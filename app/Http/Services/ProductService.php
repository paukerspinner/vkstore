<?php

namespace App\Http\Services;

use App\Product;
use App\Http\Services\CategoryService;
use App\VarcharEav;
use Illuminate\Support\Facades\File;

class ProductService
{
    public static function getProduct($productId) {
        return Product::find($productId);
    }

    public static function addProduct($productDetails) {
        $newProduct = Product::create([
            'name' => $productDetails['name'],
            'des' => $productDetails['description'],
            'price' => $productDetails['price'],
            'quantity' => $productDetails['quantity'],
            'image' => 'null',
            'category_id' => $productDetails['category_id']
        ]);
        $newProduct->update([
            'image' => 'img/product/product-'.$newProduct->id.'.jpg'
        ]);
        $productDetails['image']->move('img/product/', 'product-'.$newProduct->id.'.jpg');
        $attrValues = json_decode($productDetails['attributes']);
        foreach($attrValues as $productAttributes) {
            $productAttribute = VarcharEav::create([
                'entity_id' => $newProduct->id,
                'attribute_id' => $productAttributes->id,
                'value' => $productAttributes->value
            ]);
        }
        return Product::find($newProduct->id);
    }

    public static function updateProduct($productDetails, $id) {
        $product = Product::find($id);
        $product->update([
            'name' => $productDetails['name'],
            'des' => $productDetails['description'],
            'price' => $productDetails['price'],
            'quantity' => $productDetails['quantity'],
            'category_id' => $productDetails['category_id'],
            'image' => 'img/product/product-'.$id.'.jpg'
        ]);
        if ($productDetails['image'] != null) {
            $productDetails['image']->move('img/product/', 'product-'.$id.'.jpg');
        }
        $oldProductAttributes = VarcharEav::where('entity_id', $id)->delete();
        $attrValues = json_decode($productDetails['attributes']);
        foreach($attrValues as $productAttributes) {
            $productAttribute = VarcharEav::create([
                'entity_id' => $id,
                'attribute_id' => $productAttributes->id,
                'value' => $productAttributes->value
            ]);
        }
        return Product::find($id);
    }
    
    public static function deleteProduct($id) {
        $product = Product::find($id);
        $imagePath = public_path().'/'.$product->image;
        if (File::exists($imagePath)) {
            File::delete($imagePath);
        }
        $product->delete();
    }
}