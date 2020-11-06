<?php

namespace App\Http\Services;

use App\Shopcart;
use App\ProductShopcart;
use App\Order;
use Config;

class OrderService
{
    public static function createOrder($shopcartId, $dataShip) {
        $order = Order::create([
            'shopcart_id' => $shopcartId,
            'ship_name' => $dataShip["ship_name"],
            'ship_city' => $dataShip["ship_city"],
            'ship_district' => $dataShip["ship_district"],
            'ship_ward' => $dataShip["ship_ward"],
            'ship_address' => $dataShip["ship_address"],
            'ship_phone' => $dataShip["ship_phone"],
            'ship_note' => $dataShip["note"],
            'status' => Config::get('constants.ORDER_APPLY')
        ]);
        $shopcart = Shopcart::find($shopcartId)->update([
            'status' => Config::get('constants.SHOPCART_ORDERED')
        ]);
        return $order;
    }

    public static function getAllOrders() {
        return Order::all();
    }

    public static function getOrders($userId) {
        $shopcarts = Shopcart::where('user_id', $userId)->where('status', '!=', Config::get('constants.SHOPCART_SHOPPING'))->get();
        $orders = [];
        foreach($shopcarts as $shopcart) {
            $orders[] = $shopcart->order;
        }
        return $orders;
    }

    public static function getOrder($orderId) {
        return Order::with(['shopcart'])->find($orderId);
    }

    public static function setStatus($orderId, $newStatus) {
        $order = Order::find($orderId);
        $order->update([
            'status' => $newStatus
        ]);
        return $order;
    }

    public static function deleteOrder($orderId) {
        $order = Order::find($orderId);
        $order->shopcart->delete();
    }
}