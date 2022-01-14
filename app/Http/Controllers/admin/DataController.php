<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataController extends Controller
{
    //
    public function page_data(Request $request)
    {
        # code...
        if (!$request->session()->has('isAdminLogged')) {
            return redirect()->route('admin.login');
        }
        return view('admin.data.list_data');
    }
    public function list_data(Request $request)
    {
        # code...
        if (!$request->session()->has('isAdminLogged')) {
            return redirect()->route('admin.login');
        }
        $data = DB::table('product_data')
            ->select([
                "product_data.id",
                "products.name as product_name",
                "product_data.name",
                "product_data.type_data",
                "product_data.layanan",
                "price",
                "discount",
                "product_data.active",
                "role_prices"
            ])
            ->leftJoin("products", "products.id", "=", "product_data.product_id")
            ->orderBy("product_data.ordered")
            ->get();
        return response()->json($data);
    }
    public function page_add_data(Request $request)
    {
        # code...
        if (!$request->session()->has('isAdminLogged')) {
            return redirect()->route('admin.login');
        }
        $data = DB::table('products')
            ->select(
                "id",
                'name'
            )
            ->get();
        $smile = DB::table('auto_order_acc')->select('product_id')->where('account', 'smile')->get()->first();
        $kiosgamer = DB::table('auto_order_acc')->select('product_id')->where('account', 'kiosgamer')->get()->first();
        $kiosgamercodm = DB::table('auto_order_acc')->select('product_id')->where('account', 'kiosgamercodm')->get()->first();
        $kiosgameraov = DB::table('auto_order_acc')->select('product_id')->where('account', 'kiosgameraov')->get()->first();
        $autoorder = [
            "smile" => $smile ? $smile->product_id : 1,
            "kiosgamer" => $kiosgamer ? $kiosgamer->product_id : 2,
            "kiosgamercodm" => $kiosgamercodm ? $kiosgamercodm->product_id : 3,
            "kiosgameraov"  => $kiosgameraov ? $kiosgameraov->product_id : 4
        ];
        return view('admin.data.add', [
            'products'  => $data,
            'autoorder' => $autoorder
        ]);
    }
    public function edit_data(Request $request)
    {
        # code...
        if ($request->id) {
            $product = DB::table('products')
                ->select('*')
                ->where('name', '=', $request->product_name)
                ->get()->first();
            DB::table('product_data')
                ->where('id', '=', $request->id)
                ->update([
                    "product_id"    => $product->id,
                    "name"          => $request->name,
                    "price"         => $request->price,
                    "discount"      => $request->discount,
                    "layanan"       => $request->layanan,
                    "type_data"     => $request->type_data,
                ]);
            return response()->json([
                'success'   => true,
                'id'        => $request->id
            ]);
        }
    }
    public function delete_data(Request $request)
    {
        # code...
        if ($request->id) {
            DB::table('product_data')
                ->where('id', $request->id)
                ->delete();
            return response()->json([
                'success'   => true,
            ]);
        }
    }
    public function add_data(Request $request)
    {
        # code...
        $id = null;
        if ($request->id) {
            DB::table('product_data')
                ->updateOrInsert([
                    "id"    => $request->id
                ], [
                    "product_id"    => $request->product_id,
                    "name"          => $request->name,
                    "price"         => $request->price,
                    "discount"      => $request->discount,
                    "layanan"       => $request->layanan,
                    "type_data"     => $request->type_data,
                ]);
        } else {
            $id = DB::table('product_data')
                ->insertGetId([
                    "product_id"    => $request->product_id,
                    "name"          => $request->name,
                    "price"         => $request->price,
                    "discount"      => $request->discount,
                    "layanan"       => $request->layanan,
                    "type_data"     => $request->type_data,
                ]);
        }
        if ($request->type_data == 'voucher') {
            $v_datas = json_decode($request->voucher_items, true);
            error_log($request->voucher_items);
            if (count($v_datas) > 0) {
                $nv_data = [];
                foreach ($v_datas as $key => $value) {
                    # code...
                    $nv_data[] = [
                        "product_data_id"   => $id,
                        "data"  => $value['data'],
                        "description" => $value['description'],
                        "expired_at"    => $value['expired_at'],
                        "status"    => "ready"
                    ];
                }
                DB::table('voucher_data')->insert($nv_data);
            }
        }
        $ret = [
            "success"   => true,
        ];
        return response()->json($ret);
    }
    public function event_data(Request $request)
    {
        # code...
        if (!$request->session()->has('isAdminLogged')) {
            return redirect()->route('admin.login');
        }
        if (!$request->type) {
            return response()->json([
                'status'    => 403,
                'success'   => false,
                'message'   => 'What are you doin?'
            ], 403);
        }
        if ($request->type == "reactivate") {
            $isActive = DB::table('product_data')
                ->select('active')
                ->where('id', '=', $request->id)
                ->get()->first();
            $act = null;
            if ($isActive->active) {
                $act = false;
            } else {
                $act = true;
            }
            DB::table('product_data')
                ->where('id', '=', $request->id)
                ->update([
                    'active'    => $act
                ]);
            return response()->json([
                'status'    => 200,
                'success'   => true,
                'message'   => "Success change option active to $act"
            ]);
        } elseif ($request->type == "saveprices") {
            DB::table('product_data')->where('id', $request->id)->update([
                "role_prices" => $request->data
            ]);
            return response()->json([
                'status'    => 200,
                'success'   => true,
                'message'   => "Role prices updated"
            ]);
        } elseif ($request->type == "reorder") {
            $newOrderedList = $request->order;
            foreach ($newOrderedList as $key => $value) {
                DB::table('product_data')
                    ->where('id', '=', $value['id'])
                    ->update([
                        'ordered' => $value['position']
                    ]);
            }
            return response()->json([
                'status'    => 200,
                'success'   => true,
                'message'   => "Success reorder product data"
            ]);
        }
    }

    public function page_voucher(Request $request)
    {
        # code...
        if (!$request->session()->has('isAdminLogged')) {
            return redirect()->route('admin.login');
        }
        $product_data = DB::table('product_data')
            ->select([
                'product_data.id',
                DB::raw('products.name as product_name'),
                DB::raw('product_data.name as data_name')
            ])
            ->leftJoin('products', 'product_data.product_id', '=', 'products.id')
            ->where('product_data.type_data', 'voucher')->get();
        return view('admin.data.list_voucher', [
            'product_data' => $product_data,
        ]);
    }
    public function list_voucher(Request $request)
    {
        # code...
        if (!$request->session()->has('isAdminLogged')) {
            return redirect()->route('admin.login');
        }
        $data = DB::table('voucher_data')
            ->select([
                'voucher_data.id',
                DB::raw('products.name as product_name'),
                DB::raw('product_data.name as data_name'),
                'status',
                'used',
                'expired_at',
                'purchased'
            ])
            ->leftJoin('product_data', 'voucher_data.product_data_id', '=', 'product_data.id')
            ->leftJoin('products', 'product_data.product_id', '=', 'products.id');
        if ($request->id) {
            $data->where('product_data_id', $request->id);
        }
        return response()->json($data->get());
    }
    public function page_add_voucher(Request $request)
    {
        # code...
        if (!$request->session()->has('isAdminLogged')) {
            return redirect()->route('admin.login');
        }
        $product_data = DB::table('product_data')
            ->select([
                'product_data.id',
                DB::raw('products.name as product_name'),
                DB::raw('product_data.name as data_name')
            ])
            ->leftJoin('products', 'product_data.product_id', '=', 'products.id')
            ->where('product_data.type_data', 'voucher')->get();
        $data = null;
        if ($request->id) {
            $data = DB::table('voucher_data')->select()->where('id', $request->id)->get()->first();
        }
        return view('admin.data.add_voucher', [
            'product_data' => $product_data,
            'data'  => $data
        ]);
    }
    public function add_voucher(Request $request)
    {
        # code...
        if (!$request->session()->has('isAdminLogged')) {
            return redirect()->route('admin.login');
        }
        if ($request->id) {
            $id = $request->id;
            DB::table('voucher_data')->where('id', $request->id)->update([
                "product_data_id" => $request->product_data_id,
                "data"  => $request->data,
                "description" => $request->description,
                "expired_at" => $request->expired_at
            ]);
        } else {
            $id = DB::table('voucher_data')->insertGetId([
                "product_data_id" => $request->product_data_id,
                "data"  => $request->data,
                "description" => $request->description,
                "expired_at" => $request->expired_at,
                "status"    => "ready"
            ]);
        }
        return response()->json([
            'success' => true,
            'id'    => $id
        ]);
    }
    public function delete_voucher(Request $request)
    {
        # code...
        if (!$request->session()->has('isAdminLogged')) {
            return redirect()->route('admin.login');
        }
        DB::table('voucher_data')->where('id', $request->id)->delete();
        return response()->json(["success" => true]);
    }
}
