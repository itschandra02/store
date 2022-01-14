<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    //
    public function index(Request $request)
    {
        # code...
        if (!$request->session()->has("isAdminLogged")) {
            return redirect()->route('admin.login');
        }
        return view('admin.index');
    }
    public function login_page(Request $request)
    {
        # code...
        if ($request->session()->has("isAdminLogged")) {
            return redirect()->route('admin');
        }
        return view('admin.login');
    }
    public function login_auth(Request $request)
    {
        # code...
        if ($request->session()->has("isAdminLogged")) {
            return redirect()->route('admin');
        }
        $inpt = $request->all();
        $adm = DB::table('admins')
            ->select(['username', 'email', 'id', 'password', 'profile_pic'])
            ->where('email', '=', $inpt['username'])
            ->orWhere('username', '=', $inpt['username'])
            ->get()->first();
        $loggin = false;
        if ($adm) {
            $loggin = true;
        }
        if (!$loggin) {
            $value = [
                "type"  => "error",
                "title" => "Login Error",
                "message" => "Username or Email doesn't exists",
            ];
            $request->session()->flash('login_flash', $value);
            return redirect()->route('admin.login');
        }
        if (!Hash::check($inpt['password'], $adm->password)) {
            $value = [
                "type"  => "error",
                "title" => "Login Error",
                "message" => "Wrong password!",
            ];
            $request->session()->flash('login_flash', $value);
            return redirect()->route('admin.login');
        } else {
            session([
                'isAdminLogged' => true,
                'admin' => [
                    'adminid' => $adm->id,
                    'username'      => $inpt['username'],
                    'email'         => $adm->email,
                    'profile_pic'    => $adm->profile_pic
                ]
            ]);
            $value = [
                "type"  => "success",
                "title" => "Login Success",
                "message" => "Welcome back, " . $adm->username . "!",
            ];
            $request->session()->flash('login_flash', $value);
            return redirect()->route('admin');
        }
    }
    public function logout(Request $request)
    {
        # code...
        $request->session()->forget('isAdminLogged');
        return redirect()->route('admin.login');
    }
}
