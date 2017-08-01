<?php

namespace App;

use Kint;
use Webpatser\Uuid\Uuid;
use App\Models\Customer;
use Illuminate\Support\Facades\Mail;
use App\Repositories\StripeBillingRepository;

class StripeBilling
{
    /** @var OrderProcess */
    protected $process;

    /** @var User */
    protected $user;

    /** @var Customer */
    protected $customer;

    /** @var array */
    protected $costs;

    /** @var StripeBillingRepository */
    protected $repository;

    /**
     * StripeBilling constructor.
     * @param User                    $user
     * @param Customer                $customer
     * @param OrderProcess            $process
     * @param StripeBillingRepository $repository
     */
    public function __construct(User $user, Customer $customer, OrderProcess $process, StripeBillingRepository $repository)
    {
        $this->process = $process;
        $this->user = (\Auth::user()) ? \Auth::user() : $user;
        $this->customer = $customer;
        $this->repository = $repository;

        $this->costs['packages'] = [
            "digital"               => 1495,
            "premium"               => 2995,
            "ultimate"              => 6995,
            "digital_membership"    => 6000,
            "premium_membership"    => 8400,
            "ultimate_membership"   => 12000
        ];

        $this->costs['magnitudes'] = [
            "low"   => 0,
            "med"   => 1000,
            "high"  => 2000
        ];

        $this->costs['vip'] = 5.00;
    }

    /**                */
    /** Public methods */
    /**                */

    /**
     * @return mixed
     */
    public function payFromToken()
    {
        $tokenData = [
            'token'         => \Request::get('stripeToken'),
            'name'          => \Request::get('stripeBillingName'),
            'addressLine1'  => \Request::get('stripeBillingAddressLine1'),
            'addressCity'   => \Request::get('stripeBillingAddressCity'),
            'addressState'  => \Request::get('stripeBillingAddressState'),
            'addressZip'    => \Request::get('stripeBillingAddressZip')
        ];

        $customer = $this->repository->createStripeCustomer($tokenData, $this->process->getOrder());
        if ($this->stripeErrorEncountered($customer)) {
            return $this->handleStripeError($customer);
        }

        $customerData = $this->buildCustomerData($customer);
        $customerDB = $this->locateOrCreateDBCustomer($customerData);

        $fees = $this->calculateFees();

        $charge = $this->repository->createStripeCharge($fees, $customer->id);
        if ($this->stripeErrorEncountered($charge)) {
            return $this->handleStripeError($charge);
        }

        list($zodiac, $magnitude, $orderId) = $this->process->buildAndSaveOrder($customerDB->id, $fees);

        if ($orderId) {
            $this->updateUserMembership();
            $this->process->assignAndSaveStar($orderId, $zodiac, $magnitude);
        }

        return redirect('/thank-you');
    }

    /**
     * @return mixed
     */
    public function chargeExistingCustomer()
    {
        /** @var Customer $customerDB */
        $customerDB = $this->process->getOrder()->getPaymentMethod();
        $custId = $customerDB->getStripeCustomerId();
        $fees = $this->calculateFees();

        if ($this->process->getOrder()->isSubscription()) {
            $customer = $this->repository->updateStripeCustomer($custId, $this->process->getOrder());
            if ($this->stripeErrorEncountered($customer)) {
                return $this->handleStripeError($customer);
            }
        }

        $charge = $this->repository->createStripeCharge($fees, $custId);
        if ($this->stripeErrorEncountered($charge)) {
            return $this->handleStripeError($charge);
        }

        list($zodiac, $magnitude, $orderId) = $this->process->buildAndSaveOrder($customerDB->id, $fees);

        if ($orderId) {
            $this->updateUserMembership();
            $this->process->assignAndSaveStar($orderId, $zodiac, $magnitude);
        }

        return redirect('/thank-you');
    }

    /**
     * @return mixed
     */
    public function getSubscriptionData()
    {
        $subscriptions = Customer::where('user_id', \Auth::user()->id)->whereNotNull('plan')->orderBy('created_at', 'desc')->get();

        if ($subscriptions) {
            $subscriptions = $this->repository->getSubscriptionData($subscriptions);
            if ($this->stripeErrorEncountered($subscriptions)) {
                return $this->handleStripeError($subscriptions);
            }
        }

        return \View::make('subscriptions')->with(['subscriptions' => $subscriptions]);
    }

    /**
     * @return \Exception|mixed|\Stripe\Error\Base
     */
    public function cancelSubscription($customerId)
    {
        $subscription = Customer::where('customer_id', $customerId)->whereNotNull('plan')->first();

        if ($subscription && !empty($subscription['stripe_customer_id'])) {
            $cancel = $this->repository->cancelSubscription($subscription['stripe_customer_id']);
            if ($this->stripeErrorEncountered($cancel)) {
                return $this->handleStripeError($cancel);
            }
            return $cancel;
        }
        
        return redirect('/subscription');
    }

    /**
     * @param null $order
     * @return array
     */
    public function calculateFees($order = null)
    {
        $order = $order ?: $this->process->getOrder();
        $tax = 0.00;
        $tax_rate = \Config::get('billing.tax.rate');
        $package = $order->getPackage();
        $magnitude = $order->getMagnitude();

        $this->adjustCostsData();

        $use_vip = $order->getVip();
        $vip = (($use_vip) ? $this->costs['vip'] : 0.00);

        $sub_total = number_format(($this->costs['packages'][$package] / 100) + ($this->costs['magnitudes'][$magnitude] / 100) + $vip, 2);
        if ($order->getBillingState() == \Config::get('billing.tax.state')) {
            $tax = number_format($sub_total * $tax_rate, 2);
        }

        $tax = $tax ?: number_format(0.00, 2);
        $total = number_format($sub_total + $tax, 2);

        return [
            "package"       => number_format($this->costs['packages'][$package] / 100, 2),
            "magnitude"     => number_format($this->costs['magnitudes'][$magnitude] / 100, 2),
            "vip"           => number_format($vip, 2),
            "sub_total"     => $sub_total,
            "tax"           => $tax,
            "total"         => $total
        ];
    }

    /**
     * @param null $email
     */
    public function sendChargeSucceededMail($event, $email = null)
    {
        $admin_user = new \stdClass();
        $admin_user->email = $email;
        $user = ($email) ? $admin_user : $this->user;

        $amount = (!empty($event['data']['object']['amount'])) ? ($event['data']['object']['amount'] / 100) : 0.0;
        $last4 = (!empty($event['data']['object']['source']['last4'])) ? $event['data']['object']['source']['last4'] : null;
        $createdDate = (!empty($event['data']['object']['created'])) ? date('Y-m-d', $event['data']['object']['created']) : null;
        $createdTime = (!empty($event['data']['object']['created'])) ? date('h:i:s', $event['data']['object']['created']) : null;

        Mail::send('mail.stripe-charge-succeeded', [
            'user' => $user,
            'amount' => $amount,
            'last4' => $last4,
            'createdDate' => $createdDate,
            'createdTime' => $createdTime
        ], function ($m) use ($user, $amount, $last4, $createdDate, $createdTime) {
            $m->from(\Config::get('app.system_email'), \Config::get('app.system_email_from'));
            $m->to($user->email, "Valued Customer")->subject('Charge Successful!');
        });
    }

    /**
     * @param $event
     */
    public function sendWebHookMail($event) {
        Kint::enabled(Kint::MODE_PLAIN);
        Mail::send('mail.stripe-webhook', ['event' => $event], function ($m) use ($event) {
            $m->from(\Config::get('app.system_email'), \Config::get('app.system_email_from'));
            $m->to(\Config::get('app.admin_email'), \Config::get('app.admin_email_from'))->subject('Stripe Web Hook');
        });
    }

    /**                            */
    /** Internal protected methods */
    /**                            */

    /**
     * @param $e
     */
    protected function sendExceptionMail($e)
    {
        Kint::enabled(Kint::MODE_PLAIN);
        $session = \Session::all();
        $exception = $e->getJsonBody();

        Mail::send('mail.stripe-exception', ['session' => $session, 'exception' => $exception], function ($m) use ($session, $exception) {
            $m->from(\Config::get('app.system_email'), \Config::get('app.system_email_from'));
            $m->to(\Config::get('app.admin_email'), \Config::get('app.admin_email_from'))->subject('Stripe Exception');
        });
    }

    /**
     * @param $customer
     * @return bool
     */
    protected function stripeErrorEncountered($customer)
    {
        return strpos(strtolower(get_class((object)$customer)), 'error') !== false;
    }

    /**
     * @param $e
     * @return mixed
     */
    protected function handleStripeError($e)
    {
        $this->sendExceptionMail($e);
        $body = $e->getJsonBody();

        return \View::make('errors.stripe-exception')->with(['error' => $body['error']['message']]);
    }

    /**
     * @param $customer
     * @return array
     */
    protected function buildCustomerData($customer)
    {
        $customerData = [];

        if (!empty($customer->sources->data)) {
            $cardObject = head($customer->sources->data);
            $customerData = [
                'user_id' => $this->user->id,
                'stripe_customer_id' => $customer->id,
                'email' => $customer->email,
                'cc_last4' => $cardObject->last4,
                'cc_type' => $cardObject->brand,
                'cc_exp_month' => $cardObject->exp_month,
                'cc_exp_year' => $cardObject->exp_year,
                'cc_fingerprint' => $cardObject->fingerprint,
                'cc_country' => $cardObject->country,
                'cc_name' => $cardObject->name,
                'cc_address_line1' => $cardObject->address_line1,
                'cc_address_line2' => $cardObject->address_line2,
                'cc_address_city' => $cardObject->address_city,
                'cc_address_state' => $cardObject->address_state,
                'cc_address_zip' => $cardObject->address_zip,
                'cc_address_country' => $cardObject->address_country,
                'uuid' => Uuid::generate(4)
            ];

            if ($this->process->getOrder()->isSubscription()) {
                $customerData['plan'] = $this->process->getOrder()->getPackage();
            }
        }

        return $customerData;
    }

    protected function updateUserMembership()
    {
        if ($this->process->getOrder()->isSubscription()) {
            $this->user->membership = $this->process->getOrder()->getPackage();
            \Session::put('user.membership', $this->user->membership);
        }
    }

    protected function adjustCostsData()
    {
        $package = $this->process->getOrder()->getPackage();
        $membershipActive = $this->user->isSubscribed();
        if ($membershipActive) {
            switch ($this->user->stripe_subscription) {
                case "digital_membership":
                    $this->costs['packages']['digital'] = 0;
                    break;
                case "premium_membership":
                    $this->costs['packages']['digital'] = 0;
                    $this->costs['magnitudes']['med'] = 0;
                    break;
                case "ultimate_membership":
                    $this->costs['packages']['digital'] = 0;
                    $this->costs['magnitudes']['med'] = 0;
                    $this->costs['magnitudes']['high'] = 0;
                    $this->costs['vip'] = 0.00;
                    break;
            }
        }

        if ($package == "premium_membership") {
            $this->costs['magnitudes']['med'] = 0;
        }

        if ($package == "ultimate_membership") {
            $this->costs['magnitudes']['med'] = 0;
            $this->costs['magnitudes']['high'] = 0;
            $this->costs['vip'] = 0.00;
        }
    }

    /**
     * @param $customerData
     * @return static
     */
    protected function locateOrCreateDBCustomer($customerData)
    {
        $customerDB = $this->customer->where('stripe_customer_id', array_get($customerData, 'stripe_customer_id', ''));
        if ($customerDB) {
            $customerDB = $customerDB->first();
        }
        if (empty($customerDB)) {
            $customerDB = $this->customer->create($customerData);
        }
        return $customerDB;
    }
}

?>