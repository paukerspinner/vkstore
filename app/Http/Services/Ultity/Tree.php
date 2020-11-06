<?php

namespace App\Http\Services\Ultity;

use App\Http\Services\Ultity\Node;

class Tree {
    public function __construct(Node $root) {
        $this->root = $root;
    }

    public function addChildToNode(Node $parentNode, Node $childNode) {
        $parentNode->addChild($childNode);
    }
/*
    public function getDataJson() {
        $obj = $this->root->getDataJson();

        return $obj;
    }
    */
}