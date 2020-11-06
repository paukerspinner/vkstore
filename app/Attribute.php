<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    protected $fillable = ['entity_type_id', 'label', 'created_at', 'updated_at'];
}
