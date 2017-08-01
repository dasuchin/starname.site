<?php

namespace App\Repositories;

use App\Models\Order;
use App\Models\Star;
use App\Models\UsedStar;
use Webpatser\Uuid\Uuid;

class OrderRepository
{
    /**
     * @param $data
     * @return mixed
     */
    public function saveOrder($data)
    {
        $order = new Order();
        foreach($data as $key => $value) {
            $order->$key = $value;
        }
        $order->uuid = Uuid::generate(4);
        $order->save();
        return $order->id;
    }

    /**
     * @param $data
     */
    public function attachStar($data)
    {
        $order = Order::find($data['order_id']);

        $order->star_map    = $data['map'];
        $order->star_id     = $data['id'];
        $order->star_x      = $data['x'];
        $order->star_y      = $data['y'];
        $order->save();
    }

    /**
     * @param $range
     * @return array
     */
    public function getRandomUnusedStar($range)
    {
        $starId = Star::whereRaw($range)
            ->whereRaw('((SELECT COUNT(*) FROM used_stars WHERE star_id = stars.id) < 1)')
            ->orderByRaw('RAND()')
            ->select('id')->take(1)->value('id');

        $starX = rand(50, 225);
        $starY = rand(25, 163);

        return [$starId, $starX, $starY];
    }

    /**
     * @param $starId
     */
    public function createUsedStarEntry($starId)
    {
        UsedStar::create(['star_id' => $starId]);
    }
}