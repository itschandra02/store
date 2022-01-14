<?php

namespace App\Http\Controllers;

use App\Jobs\WhatsappSender;
use Error;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //
    public function index(Request $request)
    {
        # code...
        if ($request->session()->has('loggedIn')) {
            return redirect()->route('index');
        }
        return view('login');
    }
    public function logout(Request $request)
    {
        # code...
        $request->session()->flush();
        $value = [
            'title' =>  'Logout',
            'text'  =>  'Success Logout',
            'type'  =>  'success'
        ];
        $request->session()->flash('flash', json_encode($value));
        return redirect()->to('/');
    }
    /**
     * Login pakai OTP START HERE
     */
    public function auth_check(Request $request)
    {
        # code...
        // if ($request->session()->has('loggedIn')) {
        //     return redirect()->route('index');
        // }
        $user = DB::table('users')
            ->select(['username', 'number'])
            ->where('username', '=', $request->username)
            ->get()
            ->first();
        if ($user) {
            $otp = rand(1000, 9999);
            session([
                'otp'       =>  true,
                'username'  =>  $user->username
            ]);
            $t = "Masukan angka OTP *$otp* untuk login";
            // $this->sendWhatsapp($user->number, $t);
            dispatch(new WhatsappSender($user->number, $t));
            DB::table('temp_otp')
                ->updateOrInsert([
                    'username'  =>  $request->username,
                    'otp_type'  =>  'login',
                ], ['otp'       =>  $otp]);
            return response()->json([
                'success'   =>  true,
                'message'   =>  'Otp sent to whatsapp!'
            ]);
        } else {
            return response()->json([
                'success'   =>  false,
                'message'   =>  'Username not found!'
            ]);
        }
    }
    public function auth_verification(Request $request)
    {
        # code...
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
            ->where('otp_type', '=', 'login')
            ->get()
            ->first();
        if ($otp) {
            $user = DB::table('users')
                ->select('id', 'username', 'avatar')
                ->where('username', '=', $request->username)
                ->get()
                ->first();
            session([
                'loggedIn'  =>  true,
                'userid'    =>  $user->id,
                'username'  =>  $user->username,
                'avatar'    =>  $user->avatar
            ]);
            $value = [
                'title' =>  'Login',
                'text'  =>  'Success Login',
                'type'  =>  'success'
            ];
            $request->session()->flash('flash', json_encode($value));
            return response()->json([
                'success'   =>  true,
                'message'   =>  'Success Login'
            ]);
        } else {
            $value = [
                'title' =>  'Login',
                'text'  =>  'Failed Login',
                'type'  =>  'error'
            ];
            $request->session()->flash('flash', json_encode($value));
            return response()->json([
                'success'   =>  false,
                'message'   =>  'Invalid OTP'
            ]);
        }
    }

    public function forgot_password(Request $request)
    {
        # code...
        $user = DB::table('users')->where('username', $request->username)->get()->first();
        if (!$user) {
            return response()->json([
                'success'   => false,
                'message'   => "User not found"
            ]);
        }
        $uid = (string)Str::uuid();
        $id = DB::table('temp_forgot')->insertGetId([
            "username" => $user->username,
            "number" => $user->number,
            "token" => $uid,
            "description" => "Forgot Password for $user->username"
        ]);
        dispatch(new WhatsappSender($user->number, "Halo $user->username! Lupa password link adalah:\n" . route('login.forget_pass', ["token" => $uid])));
        return response()->json([
            'success' => true,
            "message" => "Forgot password link has been sent to +$user->number"
        ]);
    }

    public function forget_page(Request $request)
    {
        # code...
        if (!$request->token) {
            return response('Token Not found', 404);
        }
        $tok = DB::table('temp_forgot')->where('token', $request->token)->get()->first();
        if ($tok) {
            if (date("Y-m-d") >= $tok->expired_at) {
                return response('Token is expired');
            }
            $user = DB::table('users')->where('username', $tok->username)->get()->first();
            return view('forget_page', ['user' => $user]);
        } else {
            return response('Token Not found', 404);
        }
    }

    public function forget_confirmation(Request $request)
    {
        if (!$request->token) {
            return response('Token Not found', 404);
        }
        $tok = DB::table('temp_forgot')->where('token', $request->token)->get()->first();
        if ($tok) {
            if (date("Y-m-d") >= $tok->expired_at) {
                return response('Token is expired');
            }
            DB::table('users')->where('username', $tok->username)->update([
                'password'  => Hash::make($request->password)
            ]);
            DB::table('temp_forgot')->where('token', $request->token)->delete();
            $value = [
                'title' =>  'Lupa Password',
                'text'  =>  'Password berhasil di ubah',
                'type'  =>  'success'
            ];
            $request->session()->flash('flash', json_encode($value));
            dispatch(new WhatsappSender($tok->number, "Hai $tok->username. Password anda sudah diubah! silahkan login!\n" . setting('app_name')));
            return redirect(route('login'));
        } else {
            return response('Token Not found', 404);
        }
    }

    /**
     * Login pakai OTP End Here
     */

    public function auth_password(Request $request)
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
        error_log($resp);
        if (!$captcha['success']) {
            return response()->json([
                "status"    => false,
                "message" => "Error captcha"
            ]);
        }

        $user = DB::table('users')->select()->where('username', $request->username)->orWhere('email', $request->email)
            ->get()->first();
        if (!$user) {
            $value = [
                'title' =>  'Login',
                'text'  =>  'Failed Login',
                'type'  =>  'error'
            ];
            $request->session()->flash('flash', json_encode($value));
            return response()->json([
                'success'   =>  false,
                'message'   =>  'Invalid user not found'
            ]);
        } else {
            $pwd = Hash::check($request->password, $user->password);
            if ($pwd) {
                DB::table('users')->where('username', $request->username)->update([
                    'last_login' => date('Y-m-d H:i:s')
                ]);
                $user = DB::table('users')
                    ->select('id', 'username', 'avatar')
                    ->where('username', '=', $request->username)
                    ->get()
                    ->first();
                session([
                    'loggedIn'  =>  true,
                    'userid'    =>  $user->id,
                    'username'  =>  $user->username,
                    'avatar'    =>  $user->avatar
                ]);
                $value = [
                    'title' =>  'Login',
                    'text'  =>  'Success Login',
                    'type'  =>  'success'
                ];
                $request->session()->flash('flash', json_encode($value));
                return response()->json([
                    'success'   =>  true,
                    'message'   =>  'Success Login'
                ]);
            } else {

                $value = [
                    'title' =>  'Login',
                    'text'  =>  'Failed Login',
                    'type'  =>  'error'
                ];
                $request->session()->flash('flash', json_encode($value));
                return response()->json([
                    'success'   =>  false,
                    'message'   =>  'Invalid Password'
                ]);
            }
        }
    }
}
