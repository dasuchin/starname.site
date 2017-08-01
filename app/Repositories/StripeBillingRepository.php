<?php

namespace App\Repositories;

use App\User;
use Stripe\Token;
use Stripe\Stripe;
use Stripe\Charge;
use Stripe\Customer;
use App\Models\Order;
use App\Models\Customer AS CustomerDB;

class StripeBillingRepository
{
    /** @var User */
    protected $user;

    /** @var Stripe */
    protected $stripe;

    /** @var Customer */
    protected $customer;

    /** @var Charge */
    protected $charge;
    
    public function __construct(User $user, Stripe $stripe, Customer $customer, Charge $charge)
    {
        $this->stripe = $stripe;
        $this->customer = $customer;
        $this->charge = $charge;
        $this->user = (\Auth::user()) ? \Auth::user() : $user;

        $this->stripe->setApiKey(\Config::get('services.stripe.secret'));
    }

    /**
     * @param $subscriptions
     * @return \Exception|\Stripe\Error\Base
     */
    public function getSubscriptionData($subscriptions)
    {
        try {
            foreach($subscriptions as $key => $subscription) {
                $customer = Customer::retrieve($subscription['stripe_customer_id']);
                $data = head($customer->subscriptions->data);
                $subscriptions[$key]['end'] = date("m-d-Y h:m:s", $data->current_period_end);
                $subscriptions[$key]['plan'] = $data->plan;
            }

            return $subscriptions;
        } catch(\Stripe\Error\Base $e) {
            return $e;
        }
    }

    /**
     * @param $customerId
     * @return \Exception|\Stripe\Error\Base
     */
    public function cancelSubscription($customerId)
    {
        try {
            $customer = Customer::retrieve($customerId);
            $data = head($customer->subscriptions->data);
            $end = date("Y-m-d h:m:s", $data->current_period_end);

            $customer->cancelSubscription(array(
                "at_period_end" => true
            ));

            CustomerDB::where('stripe_customer_id', $customerId)->update(['cancel_date' => $end]);
            $this->user->update(['cancel_date' => $end]);

            return redirect('/subscription');
        } catch(\Stripe\Error\Base $e) {
            return $e;
        }
    }

    /**
     * @param       $tokenData
     * @param Order $order
     * @return \Exception|null|StripeCustomer|\Stripe\Error\Base
     */
    public function createStripeCustomer($tokenData, Order $order)
    {
        try {
            $customerData = [
                'source'        => $tokenData['token'],
                'email'         => $this->user->email,
                'description'   => $this->user->email
            ];

            if ($order->isSubscription()) {
                $customerData['plan'] = $order->getPackage();
            }

            $customer = $this->checkForExistingStripeCustomer($tokenData, $this->user->email);
            if (!empty($customer)) {
                return $customer;
            }

            return $this->customer->create($customerData);
        } catch(\Stripe\Error\Base $e) {
            return $e;
        }
    }

    /**
     * @param       $custId
     * @param Order $order
     * @return \Exception|\Stripe\Error\Base
     */
    public function updateStripeCustomer($custId, Order $order)
    {
        try {
            $customerData = [
                "plan" => $order->getPackage(),
                "prorate" => false
            ];

            $customer = $this->customer->retrieve($custId);

            return $customer->updateSubscription($customerData);
        } catch(\Stripe\Error\Base $e) {
            return $e;
        }
    }

    /**
     * @param $tokenData
     * @param $email
     * @return null|StripeCustomer
     */
    public function checkForExistingStripeCustomer($tokenData, $email)
    {
        $customers = $this->customer->all(array("limit" => 100));
        if (!empty($customers->autoPagingIterator())) {
            foreach ($customers->autoPagingIterator() as $customer) {
                if ($this->existingCustomerFound($tokenData, $customer, $email)) {
                    return $customer;
                }
            }
        }
        return null;
    }

    /**
     * @param $fees
     * @param $custId
     * @return \Exception|Charge|\Stripe\Error\Base
     */
    public function createStripeCharge($fees, $custId)
    {
        try {
            $chargeData = [
                "amount"   => $fees['total'] * 100,
                "currency" => "usd",
                "customer" => $custId
            ];

            return $this->charge->create($chargeData);
        } catch(\Stripe\Error\Base $e) {
            return $e;
        }
    }

    /**
     * @param $tokenData
     * @param $customer
     * @param $email
     * @return bool
     */
    protected function existingCustomerFound($tokenData, $customer, $email)
    {
        $token = Token::retrieve($tokenData['token']);
        if (!empty($customer->sources->data)) {
            $cardObject = head($customer->sources->data);
            if ($customer->email == $email
                && $cardObject->name == $tokenData['name']
                && $cardObject->address_line1 == $tokenData['addressLine1']
                && $cardObject->address_city == $tokenData['addressCity']
                && $cardObject->address_state == $tokenData['addressState']
                && $cardObject->address_zip == $tokenData['addressZip']
                && $cardObject->last4 == $token->card->last4
                && $cardObject->exp_month == $token->card->exp_month
                && $cardObject->exp_year == $token->card->exp_year
            ) {
                return true;
            }
        }

        return false;
    }
}