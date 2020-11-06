<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shopcart extends Model
{
    protected $fillable = ["user_id", "status"];

    protected $with = ["products"];
    
    public function products() {
        return $this->hasMany('App\ProductShopcart', 'shopcart_id');
    }

    public function order() {
        return $this->hasOne('App\Order', 'shopcart_id');
    }
}
