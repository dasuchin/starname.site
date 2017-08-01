<?php

use App\User;
use Mockery as m;
use Illuminate\Auth;
use App\Models\Order;
use App\OrderProcess;
use App\Repositories\OrderRepository;

class OrderProcessTest extends \TestCase
{
    /** @var m\MockInterface */
    protected $repository;

    /** @var m\MockInterface **/
    protected $order;

    /** @var \App\OrderProcess */
    protected $process;

    public function setUp()
    {
        parent::setUp();

        $this->repository = m::mock(OrderRepository::class)->shouldIgnoreMissing();
        $this->order = m::mock(Order::class)->shouldIgnoreMissing();
        $this->process = new OrderProcess($this->order, $this->repository);
    }

    /** @test */
    public function assign_and_save_star_works_as_expected()
    {
        $this->repository->shouldReceive('getRandomUnusedStar')->andReturn([1, 5, 5])->once();
        $this->repository->shouldReceive('attachStar')->once();
        $this->repository->shouldReceive('createUsedStarEntry')->once();

        $this->process->assignAndSaveStar(1, 'aries', 'low');
    }

    /** @test */
    public function build_and_save_order()
    {
        $user = new User(['name' => 'John', 'id' => 1]);
        $this->be($user);

        $this->order->shouldReceive('getZodiacSign')->andReturn('aries')->once();
        $this->order->shouldReceive('getMagnitude')->andReturn('low')->once();
        $this->repository->shouldReceive('saveOrder')->andReturn(9)->once();
        $this->order->shouldReceive('getPackage')->andReturn('digital')->once();
        $this->order->shouldReceive('getDedicationPrefix')->andReturn('1')->once();
        $this->order->shouldReceive('getDedicationName')->andReturn('Test')->once();
        $this->order->shouldReceive('getDedicationDate')->andReturn('12-22-16')->once();
        $this->order->shouldReceive('getVip')->andReturn('1')->once();

        $fees = [
            "package"       => 0,
            "magnitude"     => 0,
            "vip"           => 0,
            "sub_total"     => 0,
            "tax"           => 0,
            "total"         => 0
        ];

        $expected = [
            'aries', 'low', 9
        ];
        $actual = $this->process->buildAndSaveOrder(1, $fees);
        $this->assertEquals($expected, $actual);
    }
}
