<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'des', 'price', 'quantity', 'image', 'category_id'];

    // protected $appends = ['attr'];

    protected $with = ['category', 'varcharEaves'];

    public function category() {
        return $this->belongsTo('App\Category', 'category_id');
    }
    
    public function varcharEaves() {
        return $this->hasMany('App\VarcharEav', 'entity_id');
    }

    public function integerEav() {
        return $this->hasMany('App\IntegerEav', 'entity_id');
    }

    public function getAttrAttribute() {
        return $this::getAllAttributeValues();
    }

    // Lay ra tat cac ca thuoc tinh co kieu varchar cua Product
    public function getVarcharAttribute() {
        $allVarAttr = [];
        $varcharEavs = $this->varcharEaves()->get();
        foreach ($varcharEavs as $varcharEav) {
            $VarAttrLabel = Attribute::find($varcharEav->attribute_id)->label;
            $elem = [
                $VarAttrLabel => $varcharEav->value
            ];
            $allVarAttr[] = $elem;
        }
        return $allVarAttr;
    }

    public function getIntegerAttribute() {
        $allIntAttr = [];
        $integerEavs = $this->integerEav()->get();
        foreach ($integerEavs as $integerEav) {
            $VarAttrLabel = Attribute::find($integerEav->attribute_id)->label;
            $elem = [
                $VarAttrLabel => $integerEav->value
            ];
            $allIntAttr[] = $elem;
        }
        return $allIntAttr;
    }

    public function getAllAttributeValues() {
        $allAttrs = (object)null;
        $attrValues = $this->varcharEav()->get();
        foreach ($attrValues as $attrValue) {
            $attrLabel = Attribute::find($attrValue->attribute_id)->label;
            $allAttrs->{$attrLabel} = $attrValue->value;
        }
        $attrValues = $this->integerEav()->get();
        foreach ($attrValues as $attrValue) {
            $attrLabel = Attribute::find($attrValue->attribute_id)->label;
            $allAttrs->{$attrLabel} = $attrValue->value;
        }
        
        return $allAttrs;
    }

}
