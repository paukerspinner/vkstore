<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\OrderService;

class OrderController extends Controller
{
    public function index() {
        return response()->json(OrderService::getAllOrders());
    }

    public function show($id) {
        return response()->json(OrderService::getOrder($id));
    }

    public function update(Request $request, $id) {
        try {
            $status = $request->json()->get('status');
            OrderService::setStatus($id, $status);
            return response()->json([
                'message' => 'Đã cập nhật trạng thái thành công'
            ], 200);
        } catch(Exception $e) {
            return response()->json([
                'error' => $e
            ]);
        }
    }

    public function destroy($id) {
        try {
            OrderService::deleteOrder($id);
            return response()->json([
                'message' => 'Đã xóa thành công'
            ], 200);
        } catch(Exception $e) {
            return response()->json([
                'error' => $e
            ]);
        }
    }
}
