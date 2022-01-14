<?php

namespace App\Http\Controllers;

use App\Jobs\WhatsappSender;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegistController extends Controller
{
    //
    public function index(Request $request)
    {
        # code...
        if ($request->session()->has('loggedIn')) {
            return redirect()->route('index');
        }
        return view('register');
    }
    public function reg_check(Request $request)
    {
        # code...
        $waNum = $this->isOnWhatsapp($request->number);
        if ($waNum['success'] == false) {
            return response()->json([
                'success'   => false,
                'message'   => "Number is not on whatsapp"
            ]);
        }
        $user = DB::table('users')
            ->select('username')
            ->where('username', '=', $request->username)
            ->get()
            ->first();
        if ($user) {
            return response()->json([
                'success'   =>  false,
                'message'   =>  "Username already taken"
            ]);
        }
        $otp = rand(1000, 9999);
        session([
            'otp'       =>  true,
            'username'  =>  $request->username
        ]);
        $t = "Masukan angka OTP *$otp* untuk register";
        $this->sendWhatsapp($request->number, $t);
        // dispatch(new WhatsappSender($request->number, $t));

        DB::table('temp_otp')
            ->updateOrInsert([
                'username'  =>  $request->username,
                'otp_type'  =>  'regist',
            ], ['otp'       =>  $otp]);
        return response()->json([
            'success'   =>  true,
            'message'   =>  'Otp sent to whatsapp!'
        ]);
    }
    public function reg_verification(Request $request)
    {
        # code...
        $gCaptchaResp = $request->captcha_response;
        if (!$gCaptchaResp) {
            return response()->json([
                "status" => false,
                "message" => "Access Forbidden"
            ]);
        }
        $urlCaptcha = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode(setting('captcha_secret')) .  '&response=' . urlencode($gCaptchaResp);
        $resp = file_get_contents($urlCaptcha);
        $captcha = json_decode($resp, true);
        if (!$captcha['success']) {
            return response()->json([
                "status"    => false,
                "message" => "Error captcha"
            ]);
        }
        if (!$request->session()->has('otp')) {
            return response()->json([
                'success'   =>  false,
                'message'   =>  'Invalid Action'
            ]);
        }
        $otp = DB::table('temp_otp')
            ->select('*')
            ->where('username', '=', $request->username)
            ->where('otp', '=', $request->otp)
            ->where('otp_type', '=', 'regist')
            ->get()
            ->first();
        if (!$otp) {
            $value = [
                'title' =>  'Register',
                'text'  =>  'Failed register',
                'type'  =>  'error'
            ];
            $request->session()->flash('flash', json_encode($value));
            return response()->json([
                'success'   =>  false,
                'message'   =>  'Invalid OTP'
            ]);
        }
        $id = DB::table('users')
            ->insertGetId([
                'name'      =>  $request->name,
                'username'  =>  $request->username,
                'email'     =>  $request->email,
                'number'    =>  $request->number,
                'password'  =>  Hash::make($request->password), //adding password,
                'apikey'    =>  Str::uuid()
            ]);
        $value = [
            'title' =>  'Register',
            'text'  =>  'Success register! please login.',
            'type'  =>  'success'
        ];
        $request->session()->flash('flash', json_encode($value));
        return response()->json([
            'success'       =>  true,
            'message'       =>  'Success register'
        ]);
    }
}
