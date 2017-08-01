<?php

namespace App;

use App\Models\Order;
use App\Repositories\OrderRepository;
use App\Traits\ResolvesOrderProperties;

class OrderProcess
{
    use ResolvesOrderProperties;

    /** @var OrderRepository */
    protected $repository;
    
    /** @var Order */
    protected $order;

    /**
     * OrderProcess constructor.
     * @param Order           $order
     * @param OrderRepository $repository
     */
    public function __construct(Order $order, OrderRepository $repository)
    {
        $this->repository   = $repository;
        $this->order        = $order;
    }

    /**                */
    /** Public methods */
    /**                */

    /**
     * @return Order
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param $zodiac
     * @param $magnitude
     */
    public function assignAndSaveStar($orderId, $zodiac, $magnitude)
    {
        $star = $this->assignStar($zodiac, $magnitude);
        if ($star['id']) {
            $star['order_id'] = $orderId;
            $this->repository->attachStar($star);
            $this->repository->createUsedStarEntry($star['id']);
        }
    }

    /**
     * @param $customerId
     * @param $fees
     * @return array
     */
    public function buildAndSaveOrder($customerId, $fees)
    {
        $zodiac = $this->order->getZodiacSign();
        $magnitude = $this->order->getMagnitude();

        $orderId = $this->repository->saveOrder([
            'user_id'           => \Auth::user()->id,
            'customer_id'       => $customerId,
            'sub_total'         => $fees['sub_total'] * 100,
            'tax'               => $fees['tax'] * 100,
            'total'             => $fees['total'] * 100,
            'package'           => $this->order->getPackage(),
            'zodiac'            => $zodiac,
            'prefix'            => $this->order->getDedicationPrefix(),
            'name'              => $this->order->getDedicationName(),
            'dedication_date'   => $this->order->getDedicationDate(),
            'magnitude'         => $magnitude,
            'use_vip'           => $this->order->getVip()
        ]);

        \Session::put('order', []);

        return [$zodiac, $magnitude, $orderId];
    }

    /**                            */
    /** Internal protected methods */
    /**                            */

    /**
     * @param $zodiac
     * @param $magnitude
     * @return array
     */
    protected function assignStar($zodiac, $magnitude)
    {
        $map = $this->pickMap($zodiac);
        $range = $this->generateRangeSql($magnitude);

        list($starId, $starX, $starY) = $this->repository->getRandomUnusedStar($range);

        return [
            "id"    => $starId,
            "map"   => "fc-" . $map . ".png",
            "x"     => $starX,
            "y"     => $starY
        ];
    }

    /**
     * @param $zodiac
     * @return bool|mixed
     */
    protected function pickMap($zodiac)
    {
        $map = false;
        $mapChoices = $this->resolveMapChoicesFromZodiac(strtolower($zodiac));
        if (!is_array($mapChoices)) {
            $map = rand(1, 21);
        }

        if (!$map) {
            if (count($mapChoices) > 1) {
                $rand = rand(0, count($mapChoices) - 1);
                $map = $mapChoices[$rand];
            }

            if (!$map) {
                $map = reset($mapChoices);
            }
        }

        return $map;
    }

    /**
     * @param $magnitude
     * @return string
     */
    protected function generateRangeSql($magnitude)
    {
        switch ($magnitude) {
            case "low":
                $range = "vmag >= 9 OR vmag < 0 OR vmag IS NULL";
                break;
            case "med":
                $range = "vmag >= 8 AND vmag < 9";
                break;
            case "high":
                $range = "vmag >= 0 AND vmag < 8";
                break;
        }

        return $range;
    }
}