<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Shopcart;
use App\Http\Services\ShopService;

class ShopcartController extends Controller
{
    public function index() {
        $userId = auth()->user()->id;
        return response()->json(ShopService::getShopcartOfUSer($userId));
    }

    public function create(Request $request) {
        $userId = auth()->user()->id;
        $currentShopcart = Shopcart::where('user_id', $userId)->where('status', 0)->first();
        if ($currentShopcart == null) {
            $shopcart = ShopService::createNewCart();
            $currentShopcart = Shopcart::where('user_id', $userId)->where('status', 0)->first();
        };

        $productShopcart = ShopService::addProductToCart($currentShopcart->id,$request->json()->get('product_id'));

        return response()->json($productShopcart);
    }

    public function updateQuantity(Request $request) {
        $userId = auth()->user()->id;
        $currentShopcart = Shopcart::where('user_id', $userId)->where('status', 0)->first();
        $productId = $request->json()->get('product_id');
        $newQuantity = $request->json()->get('quantity');
        $productShopcart = ShopService::updateQuantityProductInCart($currentShopcart->id, $productId, $newQuantity);
        return response()->json($productShopcart, 200);
    }

    public function deleteProductShopcart(Request $request) {
        $productId = $request->json()->get('product_id');
        ShopService::deleteProductShopcart($productId);
        return response()->json(["message" => "Successfully delete"], 200);
    }

    public function getProductShopcart($id) {
        return response()->json(ShopService::getProductShopcart($id));
    }
}
