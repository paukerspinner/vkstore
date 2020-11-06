<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductShopcart extends Model
{
    protected $fillable = ["product_id", "shopcart_id", "quantity"];

    protected $hidden = ["shopcart_id", "created_at", "updated_at"];

    protected $appends = ["name", "price", "image"];    

    public function productDetail() {
        return Product::find($this->product_id);
    }

    public function getNameAttribute() {
        return $this->productDetail()->name;
    }

    public function getPriceAttribute() {
        return $this->productDetail()->price;
    }

    public function getImageAttribute() {
        return $this->productDetail()->image;
    }
}
