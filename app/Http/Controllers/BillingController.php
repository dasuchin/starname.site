<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\StripeBilling;
use App\Models\Customer;
use Illuminate\Support\Facades\Input;

class BillingController extends Controller
{
    /** @var Order */
    protected $order;

    /** @var StripeBilling */
    protected $stripeBilling;

    public function __construct(Order $order, StripeBilling $stripeBilling)
    {
        $this->order = $order;
        $this->stripeBilling = $stripeBilling;

        $this->middleware('auth:user', ['except' => [
            'stripeWebHook'
        ]]);
    }

    /**
     * @return mixed
     */
    public function payFromToken()
    {
        if ($this->redirectCheck()) {
            return $this->redirectStep();
        }

        return $this->stripeBilling->payFromToken();
    }

    /**
     * @return mixed
     */
    public function chargeExistingCustomer()
    {
        if ($this->redirectCheck()) {
            return $this->redirectStep();
        }

        return $this->stripeBilling->chargeExistingCustomer();
    }

    /**
     * @return mixed
     */
    public function showChoosePaymentMethod()
    {
        $payment_methods = Customer::where('user_id', \Auth::user()->id)->get();
        return \View::make('choose-payment-method')->with(['payment_methods' => $payment_methods]);
    }

    /**
     * @return mixed
     */
    public function showSubscriptions()
    {
        return $subscriptions = $this->stripeBilling->getSubscriptionData();
    }

    /**
     * @param $customerId
     * @return \Exception|mixed|\Stripe\Error\Base
     */
    public function cancelSubscription($customerId)
    {
        $customerId = \Crypt::decrypt($customerId);
        return $this->stripeBilling->cancelSubscription($customerId);
    }

    /**
     * Any action that takes place on our Stripe account will fire off an event to this endpoint
     * We will perform the necessary actions for each type of event
     *
     * @return mixed
     */
    public function stripeWebHook()
    {
        $event = Input::all();

        $this->stripeBilling->sendWebHookMail($event);
        if (!empty($event['livemode']) && $event['livemode']) {
            $return = ['Production / Live'];
            switch ($event['type']) {
                case 'charge.succeeded':
                    $this->stripeBilling->sendChargeSucceededMail($event);
                    break;
            }
        } else {
            $return = ['Development / Test'];
            switch ($event['type']) {
                case 'charge.succeeded':
                    $this->stripeBilling->sendChargeSucceededMail($event, \Config::get('app.admin_email'));
                    break;
            }
        }

        return json_encode($return);
    }

    /**
     * @return bool
     */
    protected function redirectCheck()
    {
        $step = head(explode('/', \Request::path()));
        switch ($step) {
            case 'pay':
            case 'charge':
                return empty($this->order->getPackage())
                || empty($this->order->getZodiacSign())
                || empty($this->order->getDedication())
                || empty($this->order->getMagnitude());
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
            case 'pay':
            case 'charge':
                return redirect('/vip');
                break;
        }
    }
}