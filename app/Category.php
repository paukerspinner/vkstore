<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['label', 'parent_id'];

    protected $with = ['parent'];

    public function children() {
        return $this->hasmany('App\Category', 'parent_id');
    }

    public function parent() {
        return $this->belongsTo('App\Category', 'parent_id');
    }

    public function products() {
        return $this->hasmany('App\Product', 'category_id');
    }
}
