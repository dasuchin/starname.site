<?php

use App\User;
use Mockery as m;
use Stripe\Charge;
use Illuminate\Auth;
use App\Models\Order;
use App\OrderProcess;
use App\StripeBilling;
use App\Models\Customer;
use Stripe\Customer as StripeCustomer;
use App\Repositories\StripeBillingRepository;

class StripeBillingTest extends \TestCase
{
    /** @var User */
    protected $user;

    /** @var m\MockInterface */
    protected $customer;

    /** @var m\MockInterface **/
    protected $process;

    /** @var m\MockInterface **/
    protected $repository;

    /** @var m\MockInterface **/
    protected $order;

    /** @var m\MockInterface */
    protected $stripeBilling;

    /** @var m\MockInterface */
    protected $stripeCustomer;

    /** @var m\MockInterface */
    protected $stripeCharge;

    public function setUp()
    {
        parent::setUp();

        $this->user = new User(['name' => 'John', 'id' => 1, 'email' => 'test@test.com']);
        $this->customer = m::mock(Customer::class)->shouldIgnoreMissing();
        $this->process = m::mock(OrderProcess::class)->shouldIgnoreMissing();
        $this->repository = m::mock(StripeBillingRepository::class)->shouldIgnoreMissing();
        $this->order = m::mock(Order::class)->shouldIgnoreMissing();
        $this->stripeCustomer = m::mock(StripeCustomer::class)->shouldIgnoreMissing();
        $this->stripeCharge = m::mock(Charge::class)->shouldIgnoreMissing();

        $this->stripeBilling = new StripeBilling($this->user, $this->customer, $this->process, $this->repository);
    }

    /** @test */
    public function pay_works_as_expected()
    {
        $this->repository->shouldReceive('createStripeCustomer')->andReturn($this->stripeCustomer)->once();
        $this->repository->shouldReceive('createStripeCharge')->andReturn($this->stripeCharge)->once();
        $this->process->shouldReceive('getOrder')->andReturn($this->order)->atLeast(1);
        $this->customer->shouldReceive('create')->andReturn($this->customer)->once();
        $this->order->shouldReceive('getPackage')->andReturn('digital')->atLeast(1);
        $this->order->shouldReceive('getMagnitude')->andReturn('low')->once();
        $this->process->shouldReceive('buildAndSaveOrder')->andReturn(['aries', 'low', 9])->once();
        $this->process->shouldReceive('assignAndSaveStar')->once();

        $this->stripeBilling->payFromToken();
    }

    /** @test */
    public function build_and_save_order()
    {
        $this->process->shouldReceive('getOrder')->andReturn($this->order)->atLeast(1);
        $this->order->shouldReceive('getPaymentMethod')->andReturn($this->customer)->once();
        $this->customer->shouldReceive('getStripeCustomerId')->andReturn(1)->once();
        $this->repository->shouldReceive('updateStripeCustomer')->andReturn($this->stripeCustomer);
        $this->repository->shouldReceive('createStripeCharge')->andReturn($this->stripeCharge)->once();
        $this->process->shouldReceive('buildAndSaveOrder')->andReturn(['aries', 'low', 9])->once();
        $this->process->shouldReceive('assignAndSaveStar')->once();
        $this->order->shouldReceive('getPackage')->andReturn('digital')->atLeast(1);
        $this->order->shouldReceive('getMagnitude')->andReturn('low')->once();

        $this->stripeBilling->chargeExistingCustomer();
    }
}
