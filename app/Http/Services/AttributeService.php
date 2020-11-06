<?php

namespace App\Http\Services;

use App\Category;
use App\Http\Services\Ultity\Tree;
use App\Http\Services\Ultity\Node;
use App\IntegerEav;
use App\VarcharEav;
use App\Attribute;

class AttributeService
{
    public static function getAttributes() {
        return Attribute::all();
    }

    public static function addProductAttributes($newAttribute) {
        Attribute::create([
            // 'entity_type_id' => 1,
            'label' => $newAttribute['label']
        ]);
    }

    public static function deleteProductAttributes($id) {
        // Only Varchar Attributes
        $attribute = Attribute::find($id);
        $varcharValues = VarcharEav::all()->where('attribute_id', $id);
        if ($varcharValues->count() == 0) {
            $attribute->delete();
            return true;
        } else {
            return false;
        }
    }
}