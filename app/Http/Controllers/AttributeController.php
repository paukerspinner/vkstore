<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\AttributeService;

class AttributeController extends Controller
{
    /*
    ** Only varchar attributes
    **
    */
    public function index() {
        return response()->json(AttributeService::getAttributes());
    }

    public function store(Request $request) {
        $newAttribute = $request->json()->all();
        try {
            AttributeService::addProductAttributes($newAttribute);
            return response()->json([
                'message' => 'Đã thêm thuộc tính thành công'
            ], 200);
        } catch(Exception $e) {
            return response()->json($e);
        }
    }

    public function destroy($id) {
        try{
            if (AttributeService::deleteProductAttributes($id) == true) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Đã xóa thuộc tính thành công'
                ], 200);
            } else {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Không thể xóa vì thuộc tính này vẫn còn tồn tại trong danh sách sản phẩm'
                ], 200);
            }
        } catch(Exception $e) {
            return response()->json($e);
        }
    }
}