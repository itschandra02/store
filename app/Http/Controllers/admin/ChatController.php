<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    //
    public function index(Request $request)
    {
        # code...
        if (!$request->session()->has('isAdminLogged')) {
            return redirect()->route('admin.login');
        }
        return view('admin.chats.chat');
    }
}
