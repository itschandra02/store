<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Logic\Curl\BukuKas;
use Error;
use Illuminate\Database\Eloquent\JsonEncodingException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentGateController extends Controller
{
    //
    public function index(Request $request)
    {
        # code...
        if (!$request->session()->has('isAdminLogged')) {
            return redirect()->route('login');
        }
        return view('admin.payment.list');
    }
    public function list_payment(Request $request)
    {
        # code...
        $data = DB::table('paygate')
            ->select(['payment', 'image', "name", 'status', 'updated_at'])
            ->get();
        return response()->json($data);
    }
    public function add_page(Request $request)
    {
        # code...
        if (!$request->session()->has('isAdminLogged')) {
            return redirect()->route('login');
        }
        $data = null;
        if ($request->id) {
            $data = DB::table('paygate')
                ->select("*")
                ->where('payment', '=', $request->id)
                ->get()
                ->first();
            if ($request->id == 'qris') {
                $buk = new BukuKas;
                $prof = $buk->getProfile($data->token);
                error_log(json_encode($prof));
                return view('admin.payment.add', [
                    'data'      => $data,
                    'profile'   => $prof
                ]);
            }
        }
        return view('admin.payment.add', [
            'data'      => $data
        ]);
    }
    public function payment_event(Request $request)
    {
        # code...
        $type = $request->type;
        $payment = $request->payment;
        if ($type == "reactivate") {
            $isActive = DB::table('paygate')
                ->select('status')
                ->where('payment', '=', $request->payment)
                ->get()->first();
            $act = null;
            if ($isActive->status) {
                $act = false;
            } else {
                $act = true;
            }
            DB::table('paygate')->updateOrInsert([
                "payment"   => $request->payment,
            ], [
                "status" => $act,
            ]);
            return response()->json([
                "success"   => true
            ]);
        }
        if ($payment == "qris") {
            $buk = new BukuKas;
            if (!$request->number) {
                return response()->json([
                    'success'   => false,
                    'message'   => "number is empty"
                ]);
            }
            if ($type == "getOtp") {
                $req = $buk->sendOtpMutation($request->number, $request->otpvia);
                return response()->json($req['data']['sendOtp']);
            } elseif ($type == "verifOtp") {
                if (!$request->otp) {
                    return response()->json([
                        'success'   => false,
                        'message'   => "otp is empty"
                    ]);
                }
                $req = $buk->verifyOtpMutation($request->number, $request->otp);
                error_log(json_encode($req));
                if (isset($req['errors'])) {
                    return response()->json([
                        'success'   => false,
                        'message'   => $req['errors'][0]['message']
                    ]);
                }
                $_ret = [
                    "success"   => true,
                    "token" =>  $req['data']['verifyOtp']['token'],
                ];
                $prof = $buk->getProfile($_ret['token']);
                error_log(json_encode($prof));
                if (isset($prof['errors'])) {
                    return response()->json([
                        'success'   => false,
                        'message'   => $prof['errors'][0]['message']
                    ]);
                }
                $_ret = array_merge($_ret, [
                    "data"  => $prof['data']['currentUser']['businesses']
                ]);
                error_log(json_encode($_ret));
                return response()->json($_ret);
            } elseif ($type == "submitqris") {
                error_log(json_encode($request->all()));
                $req = $buk->getMembershipBank($request->bisnisid, $request->token);
                if (isset($req['errors'])) {
                    return response()->json([
                        'success'   => false,
                        'message'   => $req['errors'][0]['message']
                    ]);
                }
                error_log(json_encode($req));
                $ret = [
                    "success"   => true,
                    "token"     => $request->token,
                    "bisnisid"  => $request->bisnisid,
                ];
                DB::table('paygate')->updateOrInsert(
                    [
                        "payment"   => $request->payment,
                    ],
                    [
                        "norek"     => $req['data']['membershipBank']['id'],
                        "name"      => $req['data']['membershipBank']['accountName'],
                        "token"     => $ret['token'],
                        "username"  => $request->number,
                        "password"  => $ret['bisnisid'],
                        'image'     => "https://seeklogo.com/images/Q/quick-response-code-indonesia-standard-qris-logo-F300D5EB32-seeklogo.com.png",
                        'status'    => 1
                    ]
                );
                return response()->json($ret);
            }
        } elseif ($payment == 'bca') {
            DB::table('paygate')->updateOrInsert(
                [
                    "payment"   => $request->payment,
                ],
                [
                    "norek"     => $request->norek,
                    "username"  => $request->username,
                    "password"  => $request->password,
                    "name"      => $request->name
                ]
            );
            return response()->json([
                "success"   => true
            ]);
        } elseif ($payment == 'tripay') {
            DB::table('paygate')->updateOrInsert([
                "payment"   => $request->payment,
            ], [
                "username"  => $request->username,
                "token"  => $request->token,
                "norek" => $request->norek,
                'image'     => "https://uploads.commoninja.com/searchengine/wordpress/tripay-payment-gateway.png",
            ]);
            return response()->json([
                "success"   => true
            ]);
        } elseif ($payment == 'hitpay') {
            DB::table('paygate')->updateOrInsert([
                "payment"   => $request->payment,
            ], [
                "token"  => $request->token,
                "password" => $request->password,
                'image'     => "https://hit-pay.com/images/logo-63b76f5f.png",
            ]);
            return response()->json([
                "success"   => true
            ]);
        }elseif($payment=='toyyibpay'){
            DB::table('paygate')->updateOrInsert([
                "payment"   => $request->payment,
            ], [
                "token"  => $request->token,
                'image'     => "https://toyyibpay.com/assets/img/icon/logop.png",
            ]);
            return response()->json([
                "success"   => true
            ]);
        }
    }
}
