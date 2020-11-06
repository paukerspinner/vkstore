<?php

namespace App\Http\Services;

use App\Shopcart;
use App\ProductShopcart;
use App\Order;
use Config;

class ShopService
{
    public static function getShopcartOfUSer($userId) {
        return Shopcart::with('products')->where('user_id',  $userId)->where('status', Config::get('constants.SHOPCART_SHOPPING'))->first();
    }

    public static function createNewCart() {
        $shopcart = [
            'user_id' => auth()->user()->id,
            'status' => Config::get('constants.SHOPCART_SHOPPING')
        ];
        Shopcart::create($shopcart);
        return $shopcart;
    }

    public static function addProductToCart($shopcartId, $productId) {
        $productShopcart = ProductShopcart::where('product_id', $productId)->where('shopcart_id', $shopcartId)->first();
        if ($productShopcart == null) {
            $productShopcart = [
                'product_id' => $productId,
                'shopcart_id' => $shopcartId,
                'quantity' => 1
            ];
            ProductShopcart::create($productShopcart);
        } else {
            $newQuantity = $productShopcart->quantity + 1;
            $productShopcart->update([
                'quantity' => $newQuantity < 10 ? $newQuantity : 10
            ]);
        }
        
        return $productShopcart;
    }

    public static function updateQuantityProductInCart($shopcartId, $productId, $newQuantity) {
        $productShopcart = ProductShopcart::where('product_id', $productId)->where('shopcart_id', $shopcartId)->first();
        $productShopcart->update([
            'quantity' => $newQuantity
        ]);
        return $productShopcart;
    }

    public static function deleteProductShopcart($productId) {
        $userId = auth()->user()->id;
        $currentShopcart = Shopcart::where('user_id', $userId)->where('status', 0)->first();
        $shopcartId = $currentShopcart->id;
        ProductShopcart::where('product_id', $productId)->where( 'shopcart_id', $shopcartId)->delete();
    }

    public static function getProductShopcart($id) {
        return ProductShopcart::all()->where('shopcart_id', $id);
    }
}