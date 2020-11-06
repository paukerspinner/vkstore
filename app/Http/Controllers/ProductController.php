<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Product;
use App\Http\Services\ProductService;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Product::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $request->validate([
            'image' => 'required'
        ]);
        $productDetails = $request->all();
        try {
            $newProduct = ProductService::addProduct($productDetails);
            return response()->json([
                'message' => 'Đã thêm sản phẩm thành công',
                'newProduct' => $newProduct
            ], 200);
        } catch(Exception $e) {
            return response()->json($e);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json(ProductService::getProduct($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $id)
    {
        $productDetails = $request->all();
        try {
            $updatedProduct = ProductService::updateProduct($productDetails, $id);
            return response()->json([
                'message' => 'Cập nhật sản phẩm thành công',
                'updatedProduct' => $updatedProduct
            ], 200);
        } catch(Exception $e) {
            return response()->json([
                'error' => $e
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            ProductService::deleteProduct($id);
            return response()->json([
                'message' => 'Xóa sản phẩm thành công'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e
            ]);
        }
    }
}
