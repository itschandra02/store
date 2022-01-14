<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Logic\Curl\KiosGamer;
use App\Logic\Curl\KiosGamerCodm;
use App\Logic\Curl\SmileOne;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class AutoOrderController extends Controller
{
    public function index_page(Request $request)
    {
        # code...
        if (!$request->session()->has('isAdminLogged')) {
            return redirect()->route('admin.login');
        }
        return view('admin.auto.list');
    }
    public function list_auto_order(Request $request)
    {
        # code...
        if (!$request->session()->has('isAdminLogged')) {
            return redirect()->route('admin.login');
        }
        $data = DB::table(DB::raw('auto_order_acc as a'))
            ->select("a.account", "b.name", "a.username", "a.password", "a.cookie", "a.token", 'a.last_balance', "a.is_active")
            ->leftJoin(DB::raw('products as b'), 'a.product_id', '=', 'b.id')
            ->get();

        return response()->json($data);
    }
    public function add_auto_order(Request $request)
    {
        # code...
        if (!$request->session()->has('isAdminLogged')) {
            return redirect()->route('admin.login');
        }
        $products = DB::table(DB::raw('products as a'))
            ->select(
                "a.id",
                "a.name"
            )
            ->get();
        $data = null;
        if ($request->id) {
            $data = DB::table(DB::raw('auto_order_acc as a'))
                ->select("a.account", "b.name", "a.product_id", "a.username", "a.password", "a.otp_key", "a.cookie", "a.token", "a.is_active")
                ->leftJoin(DB::raw('products as b'), 'a.product_id', '=', 'b.id')
                ->where('a.account', $request->id)
                ->first();
            return view('admin.auto.add', ['data' => $data, 'products' => $products]);
        }
        return view('admin.auto.add', ['products' => $products, 'data' => $data]);
    }

    public function auto_order_event(Request $request)
    {
        # code...
        if (!$request->session()->has('isAdminLogged')) {
            return redirect()->route('admin.login');
        }
        $req = $request->all();
        error_log(json_encode($req));
        switch ($req['type']) {
            case 'check':
                # code...
                $gameNames = [
                    'kiosgamer' => 'ff',
                    'kiosgamercodm' => 'codm',
                    'kiosgameraov' => 'aov',
                    'kiosgamerft' => 'fantasytown',
                ];
                switch ($req['auto_account']) {
                    case 'smile':
                        # code...
                        $smile = new SmileOne();
                        $smile->curl_cek_login($req['cookie']);
                        $curl_cek_saldo = $smile->cekSaldo();
                        error_log(json_encode($curl_cek_saldo));
                        return response()->json($curl_cek_saldo);
                        break;
                    case 'kiosgamer':
                    case 'kiosgamercodm':
                    case 'kiosgameraov':
                    case 'kiosgamerft':
                        # code...
                        $kiosgamer = new KiosGamer('', $gameNames[$req['auto_account']]);
                        $loginID = $kiosgamer->Login("4079848840");
                        $data = $kiosgamer->LoginGarena($req['username'], $req['password'], $req['session_key']);
                        if (isset($data['error'])) {
                            $data = $kiosgamer->LoginGarena($req['username'], $req['password'], $req['session_key']);
                        }
                        return response()->json(array_merge($data, ['success' => true]));
                        break;

                    default:
                        # code...
                        break;
                }
                break;
            case 'submit':
                # code...
                $data = DB::table('auto_order_acc')->where('account', $req['auto_account'])->first();
                if ($data) {
                    $data = DB::table('auto_order_acc')->where('account', $req['auto_account'])->update([
                        'username' => $req['username'],
                        'password' => $req['password'],
                        'cookie' => $req['cookie'],
                        'token' => $req['session_key'],
                        'is_active' => 1,
                        'product_id' => $req['product_id'],
                        'otp_key' => $req['otp'],
                        'last_balance' => $req['balance'],
                    ]);
                } else {
                    $data = DB::table('auto_order_acc')->insert([
                        'account' => $req['auto_account'],
                        'username' => $req['username'],
                        'password' => $req['password'],
                        'cookie' => $req['cookie'],
                        'token' => $req['session_key'],
                        'is_active' => 1,
                        'product_id' => $req['product_id'],
                        'otp_key' => $req['otp'],
                        'last_balance' => $req['balance'],
                    ]);
                }
                return response()->json([
                    'status' => 'success',
                    'success' => true,
                    'message' => 'Success',
                ]);
                break;
            case 'delete':
                # code...
                $data = DB::table('auto_order_acc')->where('account', $req['account'])->delete();
                return response()->json([
                    'status' => 'success',
                    'message' => 'Delete Success'
                ]);
                break;
            default:
                # code...
                break;
        }
    }

    //
    public function smile_page(Request $request)
    {
        # code...
        if (!$request->session()->has('isAdminLogged')) {
            return redirect()->route('admin.login');
        }
        $data = DB::table('auto_order_acc')
            ->select()->where('account', 'smile')
            ->get()->first();
        $products = DB::table('products')->select()->get();
        return view('admin.auto.smile', [
            'data'  => $data,
            'products' => $products
        ]);
    }
    public function save_acc(Request $request)
    {
        # code...
        $data = DB::table('auto_order_acc')->select()->where('account', 'smile')->get()->first();
        if ($data) {
            DB::table('auto_order_acc')
                ->updateOrInsert([
                    'account'    => $request->account
                ], [
                    'cookie'  => $request->cookie,
                    'product_id' => $request->product_id,
                    'is_active' => (int)$request->is_active
                ]);
        } else {
            DB::table('auto_order_acc')
                ->insert([
                    'account'    => $request->account,
                    'cookie'  => $request->cookie,
                    'product_id' => $request->product_id,
                    'is_active' => (int)$request->is_active
                ]);
        }
        return response()->json([
            'success'   => true
        ]);
    }
    public function check_balance(Request $request)
    {
        # code...
        if (!$request->session()->has('isAdminLogged')) {
            return redirect()->route('admin.login');
        }
        $data = DB::table('auto_order_acc')
            ->select()->where('account', 'smile')
            ->get()->first();
        // $account = [
        //     "type"  => $data->type,
        //     "username"  => $data->username,
        //     "password"  => $data->password
        // ];
        // $req = Http::get(setting('autoapi') . '/smile/check', $account);
        $smile = new SmileOne();
        $smile->curl_cek_login($data->cookie);
        $curl_cek_saldo = $smile->cekSaldo();
        return response()->json([
            "success" => true,
            "data" => $curl_cek_saldo
        ]);
    }

    public function kiosgamer_page(Request $request)
    {
        # code...
        if (!$request->session()->has('isAdminLogged')) {
            return redirect()->route('admin.login');
        }

        $data = DB::table('auto_order_acc')
            ->select()->where('account', 'kiosgamer')
            ->get()->first();
        $products = DB::table('products')->select()->get();
        return view('admin.auto.kiosgamer', [
            'data'  => $data,
            'products' => $products
        ]);
    }
    public function kiosgamer_save(Request $request)
    {
        if (!$request->session()->has('isAdminLogged')) {
            return redirect()->route('admin.login');
        }
        $data = DB::table('auto_order_acc')->select()->where('account', 'kiosgamer')->get()->first();
        if ($data) {
            DB::table('auto_order_acc')
                ->updateOrInsert([
                    'account'    => $request->account
                ], [
                    'username'  => $request->username,
                    'password'  => $request->password,
                    'otp_key'  => $request->otp_key,
                    'token'  => $request->session_key,
                    'is_active' => (int)$request->is_active,
                    'product_id' => $request->product_id
                ]);
        } else {
            DB::table('auto_order_acc')
                ->insert([
                    'account'    => $request->account,
                    'username'  => $request->username,
                    'password'  => $request->password,
                    'otp_key'  => $request->otp_key,
                    'token'  => $request->session_key,
                    'is_active' => (int)$request->is_active,
                    'product_id' => $request->product_id
                ]);
        }
        return response()->json([
            'success'   => true
        ]);
    }
    public function kiosgamer_check(Request $request)
    {
        # code...
        if (!$request->session()->has('isAdminLogged')) {
            return redirect()->route('admin.login');
        }
        $data = DB::table('auto_order_acc')
            ->select()->where('account', 'kiosgamer')
            ->get()->first();
        $kiosgamer = new KiosGamer("");
        $loginID = $kiosgamer->Login("4079848840");
        $data = $kiosgamer->LoginGarena($data->username, $data->password, $data->token);
        if (isset($data['error'])) {
            DB::table('auto_order_acc')->where('account', 'kiosgamer')->update([
                'token' => null
            ]);
            $data = DB::table('auto_order_acc')
                ->select()->where('account', 'kiosgamer')
                ->get()->first();
            $data = $kiosgamer->LoginGarena($data->username, $data->password, $data->token);
        }
        DB::table('auto_order_acc')->where('account', 'kiosgamer')->update([
            'token' => $data['session_key']
        ]);
        return response()->json([
            'success' => true,
            'data'  => $data,
            'loginid' => $loginID
        ]);
    }
    public function kiosgamercodm_page(Request $request)
    {
        # code...
        if (!$request->session()->has('isAdminLogged')) {
            return redirect()->route('admin.login');
        }

        $data = DB::table('auto_order_acc')
            ->select()->where('account', 'kiosgamercodm')
            ->get()->first();
        $products = DB::table('products')->select()->get();
        return view('admin.auto.kiosgamercodm', [
            'data'  => $data,
            'products' => $products
        ]);
    }
    public function kiosgamercodm_save(Request $request)
    {
        if (!$request->session()->has('isAdminLogged')) {
            return redirect()->route('admin.login');
        }
        $data = DB::table('auto_order_acc')->select()->where('account', 'kiosgamercodm')->get()->first();
        if ($data) {
            DB::table('auto_order_acc')
                ->updateOrInsert([
                    'account'    => $request->account
                ], [
                    'username'  => $request->username,
                    'password'  => $request->password,
                    'otp_key'  => $request->otp_key,
                    'token'  => $request->session_key,
                    'is_active' => (int)$request->is_active,
                    'product_id' => $request->product_id
                ]);
        } else {
            DB::table('auto_order_acc')
                ->insert([
                    'account'    => $request->account,
                    'username'  => $request->username,
                    'password'  => $request->password,
                    'otp_key'  => $request->otp_key,
                    'token'  => $request->session_key,
                    'is_active' => (int)$request->is_active,
                    'product_id' => $request->product_id
                ]);
        }
        return response()->json([
            'success'   => true
        ]);
    }
    public function kiosgamercodm_check(Request $request)
    {
        # code...
        if (!$request->session()->has('isAdminLogged')) {
            return redirect()->route('admin.login');
        }
        $data = DB::table('auto_order_acc')
            ->select()->where('account', 'kiosgamercodm')
            ->get()->first();
        $kiosgamer = new KiosGamerCodm("");
        $loginID = $kiosgamer->Login("6740385566860608233");
        $data = $kiosgamer->LoginGarena($data->username, $data->password, $data->token);
        if (isset($data['error'])) {
            DB::table('auto_order_acc')->where('account', 'kiosgamercodm')->update([
                'token' => null
            ]);
            $data = DB::table('auto_order_acc')
                ->select()->where('account', 'kiosgamercodm')
                ->get()->first();
            $data = $kiosgamer->LoginGarena($data->username, $data->password, $data->token);
        }
        DB::table('auto_order_acc')->where('account', 'kiosgamercodm')->update([
            'token' => $data['session_key']
        ]);
        return response()->json([
            'success' => true,
            'data'  => $data,
            'loginid' => $loginID
        ]);
    }

    public function kiosgameraov_page(Request $request)
    {
        # code...
        if (!$request->session()->has('isAdminLogged')) {
            return redirect()->route('admin.login');
        }

        $data = DB::table('auto_order_acc')
            ->select()->where('account', 'kiosgameraov')
            ->get()->first();
        $products = DB::table('products')->select()->get();
        return view('admin.auto.kiosgameraov', [
            'data'  => $data,
            'products' => $products
        ]);
    }
    public function kiosgameraov_save(Request $request)
    {
        if (!$request->session()->has('isAdminLogged')) {
            return redirect()->route('admin.login');
        }
        $data = DB::table('auto_order_acc')->select()->where('account', 'kiosgameraov')->get()->first();
        $dataff = DB::table('auto_order_acc')->select()->where('account', 'kiosgamer')->get()->first();
        if ($data) {
            DB::table('auto_order_acc')
                ->updateOrInsert([
                    'account'    => $request->account
                ], [
                    'username'  => $dataff->username,
                    'password'  => $dataff->password,
                    'otp_key'  => $dataff->otp_key,
                    'token'  => $dataff->token,
                    'is_active' => (int)$request->is_active,
                    'product_id' => $request->product_id
                ]);
        } else {
            DB::table('auto_order_acc')
                ->insert([
                    'account'    => $request->account,
                    'username'  => $dataff->username,
                    'password'  => $dataff->password,
                    'otp_key'  => $dataff->otp_key,
                    'token'  => $dataff->token,
                    'is_active' => (int)$request->is_active,
                    'product_id' => $request->product_id
                ]);
        }
        return response()->json([
            'success'   => true
        ]);
    }
    public function kiosgameraov_check(Request $request)
    {
        # code...
        if (!$request->session()->has('isAdminLogged')) {
            return redirect()->route('admin.login');
        }
        $data = DB::table('auto_order_acc')
            ->select()->where('account', 'kiosgameraov')
            ->get()->first();
        $kiosgamer = new KiosGamer("", "aov");
        $loginID = $kiosgamer->Login("1904997580014749");
        $data = $kiosgamer->LoginGarena($data->username, $data->password, $data->token);
        if (isset($data['error'])) {
            DB::table('auto_order_acc')->where('account', 'kiosgameraov')->update([
                'token' => null
            ]);
            $data = DB::table('auto_order_acc')
                ->select()->where('account', 'kiosgameraov')
                ->get()->first();
            $data = $kiosgamer->LoginGarena($data->username, $data->password, $data->token);
        }
        DB::table('auto_order_acc')->where('account', 'kiosgameraov')->update([
            'token' => $data['session_key']
        ]);
        return response()->json([
            'success' => true,
            'data'  => $data,
            'loginid' => $loginID
        ]);
    }
}
