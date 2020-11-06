<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Admin;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(["prefix" => 'v1'], function() {
    Route::post('register','AuthController@register');
    Route::post('login','AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::get('profile','AuthController@getAuthenticatedUser');

    Route::get('categories', 'CategoryController@index')->name('category.index');
    Route::post('categories/create', 'CategoryController@create')->middleware('api.role:admin');
    Route::get('categories/{id}', 'CategoryController@show');
    Route::put('categories/{id}', 'CategoryController@update')->middleware('api.role:admin');
    Route::delete('categories/{id}', 'CategoryController@destroy')->middleware('api.role:admin');
    Route::get('categories-tree', 'CategoryController@getTree')->name('category.getTree');
    Route::get('subcategory/{id}', 'CategoryController@getAllSubCategory');


    Route::get('products', 'ProductController@index')->name('product.index');
    Route::post('products', 'ProductController@store')->middleware('api.role:admin');
    Route::get('products/{id}', 'ProductController@show');
    Route::post('products/{id}/update', 'ProductController@update')->middleware('api.role:admin');
    Route::delete('products/{id}', 'ProductController@destroy')->middleware('api.role:admin');


    Route::get('attributes', 'AttributeController@index');
    Route::post('attributes', 'AttributeController@store')->middleware('api.role:admin');
    Route::delete('attributes/{id}', 'AttributeController@destroy')->middleware('api.role:admin');

    Route::get('shopcarts', 'ShopcartController@index')->middleware('auth:api');
    Route::post('shopcarts/add-to-cart', 'ShopcartController@create')->middleware('auth:api');
    Route::post('shopcarts/update-quantity-product', 'ShopcartController@updateQuantity')->middleware('auth:api');
    Route::post('shopcarts/delete-product', 'ShopcartController@deleteProductShopcart')->middleware('auth:api');
    // Route::get('shopcart/{id}/product-shopcart', 'ShopcartController@getProductShopcart')->middleware('auth:api');

    // Route::get('users/{userId}/orders', 'UserOrderController@index')->middleware('owner')->name('users.orders.index');
    // Route::post('users/{userId}/orders', 'UserOrderController@store')->middleware('owner')->name('users.orders.store');

    Route::get('orders', 'OrderController@index')->middleware('api.role:admin');
    Route::get('orders/{id}', 'OrderController@show')->middleware('api.role:admin');
    Route::put('orders/{id}', 'OrderController@update')->middleware('api.role:admin');
    Route::delete('orders/{id}', 'OrderController@destroy')->middleware('api.role:admin');

    Route::get('myorders', 'MyorderController@index')->middleware('auth:api');
    Route::post('myorders', 'MyorderController@store')->middleware('auth:api');

    Route::group(["prefix" => "adminpage"], function() {
        Route::post('login', 'Admin\AdminController@login');
        Route::group(["middleware" => "api.role:admin"], function() {
            Route::get('index', function() {
                return 'success';
            });
            Route::post('logout', 'Admin\AdminController@logout');
            Route::get('profile', 'Admin\AdminController@getAuthenticatedUser');
        });
    });
});