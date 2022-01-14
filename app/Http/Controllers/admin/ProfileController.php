<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\ImageManagerStatic as Image;

class ProfileController extends Controller
{
    //
    public function index(Request $request)
    {
        # code...
        if (!$request->session()->has("isAdminLogged")) {
            return redirect()->route('admin.login');
        }
        $data = DB::table('admins')->select()
            ->where('id', $request->session()->get('admin')['adminid'])
            ->get()->first();
        return view('admin.user.profile-settings', ["data" => $data]);
    }
    public function profile_set(Request $request)
    {
        # code...
        if (!$request->session()->has("isAdminLogged")) {
            return redirect()->route('admin.login');
        }
        $data = DB::table('admins')->select()->where('username', $request->username)->get()->first();
        $thumbnail = $request->file('profile_pic');
        $thumbnailUrl = null;
        if ($thumbnail) {
            $validated = $request->validate([
                'thumbnail' => 'mimes:png,jpeg,jpg,gif,svg|max:2048',
            ]);
            if (!$validated) {
                return redirect()->back()->withErrors($validated)->withInput();
            }
            $namaFile = $thumbnail->getClientOriginalName();
            $namaFile = time() . $namaFile;
            $img = Image::make($thumbnail);
            $img->resize(600, null, function ($constraint) {
                $constraint->aspectRatio();
            })->encode('jpg')->save(public_path() . "/assets/img/$namaFile");
            $thumbnailUrl = asset("assets/img/$namaFile");
            if (setting('use_watermark')) {
                $this->addwatermark(public_path() . "/assets/img/$namaFile");
            }
            if (setting('server_img')) {
                $thumbnailUrl = $this->uploadMedia(public_path() . "/assets/img/$namaFile");
                unlink(public_path() . "/assets/img/$namaFile");
            }
            // $thumbnailUrl = $this->uploadMedia(public_path() . "/assets/img/$namaFile");
            DB::table('admins')->where('username', $request->username)->update([
                'profile_pic'  => $thumbnailUrl
            ]);
        }
        $pw = $request->passwd;
        $newPass = null;
        if ($pw) {
            $newPass = Hash::make($pw);
            DB::table('admins')->where('username', $request->username)->update([
                'password'  => $newPass
            ]);
        }
        DB::table('admins')->where('username', $request->username)->update([
            "username"   => $request->username,
            "name"       => $request->name,
            "email"      => $request->email,
            "number"     => $request->phone,
        ]);
        session([
            'isAdminLogged' => true,
            "admin" => [
                "username"  => $request->username,
                "email"     => $request->email,
                "profile_pic" => $thumbnailUrl
            ]
        ]);
        return response()->json([
            "sucess" => true,
        ]);
    }

    public function save_user(Request $request)
    {
        # code...
        $user = DB::table('users')->select()->where('id', $request->id)->get()->first();
        if ($user) {
            DB::table('users')->where('id', $request->id)->update([
                'name'  => $request->name,
                'username' => $request->username,
                'number' => $request->number,
                'balance' => $request->balance,
                'status' => $request->status
            ]);
            return response()->json([
                'success' => true
            ]);
        }
    }

    public function list_user(Request $request)
    {
        # code...
        if (!$request->session()->has("isAdminLogged")) {
            return redirect()->route('admin.login');
        }
        return view('admin.user.list-users');
    }
    public function userList(Request $request)
    {
        # code...
        if (!$request->session()->has("isAdminLogged")) {
            return redirect()->route('admin.login');
        }
        $data = DB::table('users')->select()->get();
        return response()->json($data);
    }

    public function list_admin(Request $request)
    {
        if (!$request->session()->has('isAdminLogged')) {
            return redirect()->route('admin.login');
        }
        $data = DB::table('admins')->select()->get();
        return response()->json($data);
    }

    // create add_admin function here without thumbnail uploading
    public function add_admin(Request $request)
    {
        if (!$request->session()->has('isAdminLogged')) {
            return redirect()->route('admin.login');
        }
        $data = DB::table('admins')->select()->where('username', $request->username)->get()->first();
        if ($data) {
            return response()->json([
                'success' => false,
                'message' => 'Username already exist'
            ]);
        }
        $password = Hash::make($request->password);
        DB::table('admins')->insert([
            'username' => $request->username,
            'password' => $password,
            'name' => $request->name,
            'email' => $request->email,
            'number' => $request->number,
            'profile_pic' => null,
            'status'    => 'administrator'
        ]);
        //return with success status and message
        return response()->json([
            'success' => true,
            'message' => 'Admin added successfully'
        ]);
    }
    // delete_admin function here
    public function delete_admin(Request $request)
    {
        if (!$request->session()->has('isAdminLogged')) {
            return redirect()->route('admin.login');
        }
        $data = DB::table('admins')->select()->where('username', $request->username)->get()->first();
        if ($data) {
            DB::table('admins')->where('username', $request->username)->delete();
            return response()->json([
                'success' => true,
                'message' => 'Admin deleted successfully'
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'Admin not found'
        ]);
    }


    public function remove_user(Request $request)
    {
        # code...
        if (!$request->session()->has('isAdminLogged')) {
            return redirect()->route('admin.login');
        }
        if (!$request->id) {
            return response()->json(["success" => false, "message" => "What r u doin?"]);
        }
        DB::table('users')->where('id', $request->id)->delete();
        return response()->json(["success" => true, "message" => "User $request->id has been deleted"]);
    }
    // function for adding new role to usertype table with inserting type only
    // with function name add_role
    // return without message only success status
    public function add_role(Request $request)
    {
        # code...
        if (!$request->session()->has('isAdminLogged')) {
            return redirect()->route('admin.login');
        }
        if (!$request->type) {
            return response()->json(["success" => false, "message" => "What r u doin?"]);
        }
        DB::table('usertype')->insert([
            'type' => $request->type
        ]);
        return response()->json(["success" => true]);
    }

    public function remove_role(Request $request)
    {
        # code...
        if (!$request->session()->has('isAdminLogged')) {
            return redirect()->route('admin.login');
        }
        if (!$request->id) {
            return response()->json(["success" => false, "message" => "What r u doin?"]);
        }
        DB::table('usertype')->where('id', $request->id)->delete();
        return response()->json(["success" => true, "message" => "Role $request->id has been deleted"]);
    }

    // function for saving type to usertype by id
    // with function name save_role
    // return without message only success status
    public function save_role(Request $request)
    {
        # code...
        if (!$request->session()->has('isAdminLogged')) {
            return redirect()->route('admin.login');
        }
        if (!$request->id) {
            return response()->json(["success" => false, "message" => "What r u doin?"]);
        }
        if (!$request->type) {
            return response()->json(["success" => false, "message" => "What r u doin?"]);
        }
        DB::table('usertype')->where('id', $request->id)->update([
            'type' => $request->type
        ]);
        return response()->json(["success" => true]);
    }
}
