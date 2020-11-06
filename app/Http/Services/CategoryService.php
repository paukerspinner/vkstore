<?php

namespace App\Http\Services;

use App\Category;
use App\Http\Services\Ultity\Tree;
use App\Http\Services\Ultity\Node;

class CategoryService
{
    public static function getAllRoots() {
        return Category::all()->where('parent_id', null);
    }

    public static function getAllTree() {
        foreach((new static)::getAllRoots() as $root) {
            $roots_id[] = $root->id;
        }
        
        foreach ($roots_id as $root_id) {
            $categoryTreeData[] = (new static)::getTree($root_id);
        }

        return $categoryTreeData;
    }

    public static function createNewCategory($label, $parentId) {
        $newCategory = Category::create([
            'label' => $label,
            'parent_id' => ($parentId != -1 ? $parentId : NULL)
        ]);
        return $newCategory;
    }

    public static function updateCategory($id, $categoryData) {
        $category = Category::find($id);
        $category->update([
            'label' => $categoryData['label'],
            'parent_id' => $categoryData['parentId'] != -1 ? $categoryData['parentId'] : NULL
        ]);
        return $category;
    }

    public static function deleteCategory($id) {
        $category = Category::find($id);
        if (!(new static)::hasProducts($id)) {
            $category->delete();
            return true;
        } else {
            return false;
        }
    }

    public static function hasProducts($categoryId) {
        $category = Category::find($categoryId);
        if ($category->children->isEmpty()) {
            return $category->products->isNotEmpty();
        } else {
            foreach($category->children as $child) {
                if ((new static)::hasProducts($child->id)) {
                    return true;
                }
            }
        }
        return false;
    }

    // Xây dựng nhánh cây từ $node_id
    public static function getTree($node_id) {
        $root = new Node(Category::find($node_id));
        $tree = new Tree($root);
        $currentNode = $tree->root;
        (new static)::addToTree($currentNode);
        return $tree->root->data;
    }

    // Sử dụng đệ quy để xây dựng Cây
    public static function addToTree(Node $currentNode) {
        $children = $currentNode->data->children;
        if (empty($children)) {
            return ;
        } else {
            foreach($children as $child) {
                $childNode = new Node($child);
                $currentNode->addChild($childNode);
                (new static)::addToTree($childNode);
            }
        }
    }
}