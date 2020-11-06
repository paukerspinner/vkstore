<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use App\Http\Services\CategoryService;

class CategoryController extends Controller
{
    public function index() {
        return response()->json(Category::all());
    }

    public function create(Request $request) {

        $label = $request->json()->get('label');
        $parentId = $request->json()->get('parent_id');

        $newCategory = CategoryService::createNewCategory($label, $parentId);
        return response()->json([
            "message" => "Thêm danh mục thành công"
        ], 200);
    }

    public function show($id) {
        $category = Category::with('parent')->find($id);
        return response()->json($category);
    }

    public function update(Request $request, $id) {
        try {
            $categoryData = $request->json()->all();
            $category = CategoryService::updateCategory($id, $categoryData);
            return response()->json($category);
        } catch(Exception $e) {
            return response()->json([
                'error' => 'error accurs'
            ], 400);
        }
    }

    public function destroy($id) {
        try {
            $isAbleDeleted = CategoryService::deleteCategory($id);
            if ($isAbleDeleted) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Xóa thành công'
                ], 200);
            } else {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Bạn không thể xóa vì vẫn còn sản phẩm trong danh mục.'
                ]);
            }
        } catch(Exception $e) {
            return response()->json($e);
        }
    }

    public function getTree() {
        return response()->json(CategoryService::getAllTree());
    }

    public function getAllSubCategory($id) {
        return response()->json(CategoryService::getTree($id));
    }
}