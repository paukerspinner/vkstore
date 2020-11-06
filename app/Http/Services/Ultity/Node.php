<?php

namespace App\Http\Services\Ultity;

class Node {
    public function __construct($data) {
        $this->data = $data;
        $this->children = [];
    }

    public function addChild($childNode) {
        $this->children[] = $childNode;
    }

    public function getDataJson() {
        $obj = (object) $this->data->only('id', 'label');
        
        foreach($this->children as $child) {
            $childrenArray[] = $child->getDataJson();
        }

        $obj->children = (object) $childrenArray;
        return $obj;
    }
}