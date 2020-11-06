<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VarcharEav extends Model
{
    protected $fillable = ['entity_id', 'attribute_id', 'value'];

    protected $appends = ['label'];

    protected $hidden = ['created_at', 'updated_at', 'attribute'];

    public function attribute() {
        return $this->belongsTo('App\Attribute', 'attribute_id');
    }

    public function getLabelAttribute() {
        return $this->attribute->label;
    }
}
