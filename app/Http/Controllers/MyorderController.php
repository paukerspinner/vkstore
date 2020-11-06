<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\OrderService;

class MyorderController extends Controller
{
    public function index() {
        $userId = auth()->user()->id;
        $orders = OrderService::getOrders($userId);
        return response()->json($orders);
    }

    public function store(Request $request) {
        $shopcartId = $request->json()->get('shopcart_id');
        $dataShip = $request->json()->get('data_ship');
        $order = OrderService::createOrder($shopcartId, $dataShip);
        return response()->json($order);
    }
}
