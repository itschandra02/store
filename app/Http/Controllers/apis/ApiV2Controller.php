<?php

namespace App\Http\Controllers\apis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiV2Controller extends Controller
{
    //
    public function get_products(Request $request)
    {
        # code...
        if ($request->has('id')) {
            $id = $request->input('id');
            $products = DB::table('products')->where('id', $id)->get()->first();
            if (!$products) {
                return response()->json(["success" => false, 'error' => 'Product not found'], 404);
            }
            $product_data = DB::table('product_data')->where('product_id', $id)->get();
            $products->product_data = $product_data;
            return response()->json(["success" => true, "data" => $products]);
        }
        $limit = $request->input('limit', 10);
        $offset = $request->input('offset', 0);
        $data = DB::table('products')
            ->select("products.*", DB::raw("categories.title category_title"))
            ->leftJoin('categories', 'products.category', '=', 'categories.name')
            ->offset($offset)
            ->limit($limit)
            ->get();
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
    public function get_categories(Request $request)
    {
        # code...
        $limit = $request->input('limit', 10);
        $offset = $request->input('offset', 0);
        $data = DB::table('categories')
            ->select("categories.*")
            ->offset($offset)
            ->limit($limit)
            ->get();
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    // use middleware
    public function get_user(Request $request)
    {
        # code...
        $userApi = DB::table('users')
            ->select([
                'id', 'name', 'username', 'email',
                'number', 'balance', 'status', 'last_login',
            ])->where('apikey', $request->header('Authorization'))->get()->first();
        return response()->json([
            'success' => true,
            'data' => $userApi
        ]);
    }
}
