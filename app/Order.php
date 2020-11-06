<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Shopcart;
use App\ProductShopcart;
use App\User;

class Order extends Model
{
    protected $fillable = ["shopcart_id", 'ship_name', 'ship_city', 'ship_district', 'ship_ward', 'ship_address', 'ship_phone', 'ship_note', 'status'];

    protected $appends = ["phoneuser"];

    public function shopcart() {
        return $this->belongsTo('App\Shopcart', 'shopcart_id');
    }

    public function getPhoneuserAttribute() {
        $userId = $this->shopcart->user_id;
        return User::find($userId)->phone;
    }
}
