<?php

namespace App\Http\Controllers;

use App\StarKit;
use App\OrderProcess;
use App\StripeBilling;
use App\Models\Customer;
use Illuminate\Support\Facades\Input;

class OrderController extends Controller
{
    /** @var OrderProcess */
    protected $orderProcess;

    /** @var \App\StripeBilling */
    protected $stripeBilling;

    /**
     * OrderController constructor.
     * @param OrderProcess  $orderProcess
     * @param StripeBilling $stripeBilling
     */
    public function __construct(OrderProcess $orderProcess, StripeBilling $stripeBilling)
    {
        $this->orderProcess = $orderProcess;
        $this->stripeBilling = $stripeBilling;

        $this->middleware('auth:user', ['only' => [
            'showOverview',
            'postOverview',
            'showOrderHistory',
            'showOrderDetail',
            'downloadZip',
            'downloadPdf'
        ]]);
    }

    /**
     * @return mixed
     */
    public function showIndex()
    {
        return \View::make('index');
    }

    /**
     * @return mixed
     */
    public function showPackages()
    {
        return \View::make('packages');
    }

    /**
     * @return mixed
     */
    public function postPackages()
    {
        $package = Input::get('package-submit');

        $packageButtons = [
            'Choose Digital Package' => 'digital',
            'Choose Premium Package' => 'premium',
            'Choose Ultimate Package' => 'ultimate',
            'Choose Digital Membership' => 'digital_membership',
            'Choose Premium Membership' => 'premium_membership',
            'Choose Ultimate Membership' => 'ultimate_membership'
        ];

        $package = array_get($packageButtons, $package, '');
        if (!empty($package)) {
            $this->orderProcess->getOrder()->setPackage($package);
            return redirect('/zodiac');
        }

        return redirect('/packages');
    }

    /**
     * @return mixed
     */
    public function showZodiacSigns()
    {
        if ($this->redirectCheck()) {
            return $this->redirectStep();
        }

        return \View::make('zodiac');
    }

    /**
     * @return mixed
     */
    public function postZodiacSigns()
    {
        $zodiac = Input::get('zodiac');
        if (!empty($zodiac)) {
            $this->orderProcess->getOrder()->setZodiacSign($zodiac);
            return redirect('/dedication');
        }

        return redirect('/zodiac');
    }

    /**
     * @return mixed
     */
    public function showDedication()
    {
        if ($this->redirectCheck()) {
            return $this->redirectStep();
        }

        return \View::make('dedication');
    }

    /**
     * @return mixed
     */
    public function postDedication()
    {
        $prefix = Input::get('prefix');
        $name = Input::get('name');
        $use_date = Input::get('use_date');
        $dedication_date = Input::get('date');

        if ($this->prefixReady($prefix, $name)) {
            $this->orderProcess->getOrder()->setDedicationPrefix($prefix);
            $this->orderProcess->getOrder()->setDedicationName($name);

            if ($this->useDedicationDate($use_date, $dedication_date)) {
                $this->orderProcess->getOrder()->setDedicationDate($dedication_date);
            }

            return redirect('magnitude');
        }

        return redirect('/dedication');
    }

    /**
     * @return mixed
     */
    public function showMagnitude()
    {
        if ($this->redirectCheck()) {
            return $this->redirectStep();
        }

        $med = $this->mediumMagnitudeIsFree();
        $high = $this->ultimateMembership();

        return \View::make('magnitude')->with('mediumFree', $med)->with('highFree', $high);
    }

    /**
     * @return mixed
     */
    public function postMagnitude()
    {
        $magnitude = Input::get('magnitude');
        if (!empty($magnitude)) {
            $this->orderProcess->getOrder()->setMagnitude($magnitude);
            return redirect('/vip');
        }

        return redirect('/magnitude');
    }

    /**
     * @return mixed
     */
    public function showVip()
    {
        if ($this->redirectCheck()) {
            return $this->redirectStep();
        }

        $free_vip = $this->ultimateMembership();

        return \View::make('vip')->with('free_vip', $free_vip);
    }

    /**
     * @return mixed
     */
    public function postVip()
    {
        $use_vip = Input::get('use_vip', false);

        $this->orderProcess->getOrder()->setVip($use_vip);
        return redirect('/order-overview');
    }

    /**
     * @param null $customerId
     * @return mixed
     */
    public function showOverview($customerId = null)
    {
        $customerId = Customer::where('uuid', $customerId)->value('id');
        if ($this->redirectCheck()) {
            return $this->redirectStep();
        }

        if ($this->paymentMethodsExistAndNotANewCustomer($customerId)) {
            return redirect('/choose-payment-method');
        }

        if ($this->paymentMethodProvided($customerId)) {
            $this->orderProcess->getOrder()->setBillingState(Customer::find($customerId)->cc_address_state);
        }

        $viewData = [
            'package' => $this->orderProcess->getOrder()->getPackage(),
            'packageTranslated' => $this->orderProcess->getOrder()->getPackageTranslated(),
            'zodiac' => $this->orderProcess->getOrder()->getZodiacSign(),
            'dedication' => $this->orderProcess->getOrder()->getDedication(),
            'dedicationDate' => $this->orderProcess->getOrder()->getDedicationDate(),
            'magnitude' => $this->orderProcess->getOrder()->getMagnitude(),
            'vip' => $this->orderProcess->getOrder()->getVip(),
            'state' => $this->orderProcess->getOrder()->getBillingState(),
            'fees' => $this->stripeBilling->calculateFees()
        ];

        if ($this->paymentMethodProvided($customerId)) {
            $this->orderProcess->getOrder()->setPaymentMethod(Customer::find($customerId));
            $viewData['billing_method'] = $this->orderProcess->getOrder()->getPaymentMethod();
        }

        return \View::make('order-overview')->with($viewData);
    }

    /**
     * @return mixed
     */
    public function showTerms()
    {
        return \View::make('terms');
    }

    /**
     * @return mixed
     */
    public function showThankYou()
    {
        return \View::make('thank-you');
    }

    /**
     * @return mixed
     */
    public function showOrderHistory()
    {
        $orders = $this->orderProcess->getOrder()->where('user_id', \Auth::user()->id)->get();

        return \View::make('order-history', ['orders' => $orders]);
    }

    /**
     * @param integer $orderId
     * @return mixed
     */
    public function showOrderDetail($orderId)
    {
        $order = $this->orderProcess->getOrder()->where('uuid', $orderId)->first();
        $viewData = [
            'order_id' => $order->id,
            'uuid' => $order->uuid,
            'order_date' => $order->created_at,
            'package' => $order->package,
            'zodiac' => $order->zodiac,
            'dedication' => $order->dedication,
            'dedicationDate' => $order->dedication_date,
            'use_date' => $order->use_date,
            'magnitude' => $order->magnitude,
            'vip' => $order->use_vip,
            'state' => $order->customer->cc_address_state,
            'fees' => $this->stripeBilling->calculateFees($order),
            'payment_method' => $order->customer
        ];

        return \View::make('order-detail')->with($viewData);
    }

    /**
     * @param $orderId
     * @return mixed
     */
    public function downloadPdf($orderId)
    {
        $order = $this->orderProcess->getOrder()->where('uuid', $orderId)->first();
        $starKit = new StarKit($order);

        if (file_exists($starKit->getStoragePath())) {
            return $starKit->downloadFromDisk();
        }

        $starKit->buildKit();
        $starKit->saveToDisk();
        $starKit->downloadFromDisk();
    }

    /**
     * @param $orderId
     * @return mixed
     */
    public function viewPdf($orderId)
    {
        $order = $this->orderProcess->getOrder()->where('uuid', $orderId)->first();
        $starKit = new StarKit($order);

        if (file_exists($starKit->getStoragePath())) {
            return $starKit->outputFromDisk();
        }

        $starKit->buildKit();
        $starKit->saveToDisk();
        $starKit->output();
    }

    /**                            */
    /** Internal protected methods */
    /**                            */

    /**
     * @return bool
     */
    protected function redirectCheck()
    {
        $order = $this->orderProcess->getOrder();
        $step = head(explode('/', \Request::path()));
        switch ($step) {
            case 'zodiac':
                return empty($order->getPackage());
                break;
            case 'dedication':
                return empty($order->getPackage())
                    || empty($order->getZodiacSign());
                break;
            case 'magnitude':
                return empty($order->getPackage())
                    || empty($order->getZodiacSign())
                    || empty($order->getDedication());
                break;
            case 'vip':
                return empty($order->getPackage())
                    || empty($order->getZodiacSign())
                    || empty($order->getDedication())
                    || empty($order->getMagnitude());
                break;
            case 'order-overview':
                return empty($order->getPackage())
                    || empty($order->getZodiacSign())
                    || empty($order->getDedication())
                    || empty($order->getMagnitude());
                break;

        }
    }

    /**
     * @return mixed
     */
    protected function redirectStep()
    {
        $step = head(explode('/', \Request::path()));
        switch ($step) {
            case 'zodiac':
                return redirect('/packages');
                break;
            case 'dedication':
                return redirect('/zodiac');
                break;
            case 'magnitude':
                return redirect('/dedication');
                break;
            case 'vip':
                return redirect('/magnitude');
                break;
            case 'order-overview':
                return redirect('/vip');
                break;

        }
    }

    /**
     * @param $customerId
     * @return bool
     */
    protected function paymentMethodsExistAndNotANewCustomer($customerId)
    {
        return ($customerId != 'new') && (empty($customerId) && $this->checkPaymentMethod());
    }

    /**
     * @return bool
     */
    protected function checkPaymentMethod()
    {
        $payment_methods = Customer::where('user_id', \Auth::user()->id)->get();
        return ($payment_methods->count() > 0) ?: false;
    }

    /**
     * @return bool
     */
    protected function mediumMagnitudeIsFree()
    {
        $order = $this->orderProcess->getOrder();
        if ($order->getPackage() == 'premium_membership' || $order->getPackage() == 'ultimate_membership'
            || (!empty(\Auth::user()) && \Auth::user()->isSubscribed() && (\Auth::user()->stripe_subscription == 'premium_membership'
                    || \Auth::user()->stripe_subscription == 'ultimate_membership'))
        ) {
            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    protected function ultimateMembership()
    {
        if ($this->orderProcess->getOrder()->getPackage() == 'ultimate_membership' || (!empty(\Auth::user()) && \Auth::user()->isSubscribed() &&
                (\Auth::user()->stripe_subscription == 'ultimate_membership'))
        ) {
            return true;
        }

        return false;
    }

    /**
     * @param $prefix
     * @param $name
     * @return bool
     */
    protected function prefixReady($prefix, $name)
    {
        return (isset($prefix) && !empty($name));
    }

    /**
     * @param $use_date
     * @param $dedication_date
     * @return bool
     */
    protected function useDedicationDate($use_date, $dedication_date)
    {
        return ((int)$use_date && !empty($dedication_date));
    }

    /**
     * @param $id
     * @return bool
     */
    protected function decryptIdWhenPossible($id)
    {
        if ($id == 'new') {
            return $id;
        }
        return (!empty($id)) ? \Crypt::decrypt($id) : false;
    }

    /**
     * @param $customerId
     * @return bool
     */
    protected function paymentMethodProvided($customerId)
    {
        return !empty($customerId) && $customerId != 'new';
    }
}