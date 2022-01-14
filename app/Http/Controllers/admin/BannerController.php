<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Intervention\Image\ImageManagerStatic as Image;


class BannerController extends Controller
{
    //
    public function page_list(Request $request)
    {
        # code...
        if (!$request->session()->has("isAdminLogged")) {
            return redirect()->route('admin.login');
        }
        return view('admin.banner.page');
    }
    public function page_add(request $request)
    {
        if (!$request->session()->has("isAdminLogged")) {
            return redirect()->route('admin.login');
        }
        if ($request->id) {
            $data = DB::table('carousels')->where('id', $request->id)->get()->first();
            return view('admin.banner.add', ['data' => $data]);
        }
        return view('admin.banner.add', ['data' => null]);
    }
    public function get_list(Request $request)
    {
        # code...
        if (!$request->session()->has("isAdminLogged")) {
            return redirect()->route('admin.login');
        }
        $data = DB::table('carousels')->get();
        return response()->json($data);
    }
    public function add(Request $request)
    {
        # code...
        if (!$request->session()->has("isAdminLogged")) {
            return redirect()->route('admin.login');
        }

        $thumbnail = $request->file("image");
        $thumbnailPath = null;
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
            if (setting('use_watermark')) {
                $this->addwatermark(public_path() . "/assets/img/$namaFile");
            }
            $thumbnailPath = URL::to("assets/img/$namaFile");
            if (setting('server_img')) {
                $thumbnailPath = $this->uploadMedia(public_path() . "/assets/img/$namaFile");
                unlink(public_path() . "/assets/img/$namaFile");
            }
            // $thumbnailPath = $this->uploadMedia(public_path() . "/assets/img/$namaFile");
        }
        if ($request->id) {
            $id = DB::table('carousels')->select()->where('id', $request->id)->get()->first();
            DB::table('carousels')->where('id', $request->id)->update([
                "title" => $request->title,
                "description" => $request->description,
                "link" => $request->link,
                "img" => $thumbnailPath ? $thumbnailPath : $id->img
            ]);
            return response()->json([
                'id' => $id->id
            ]);
        } else {
            $id = DB::table('carousels')->insertGetId([
                "title" => $request->title,
                "description" => $request->description,
                "link" => $request->link,
                "img" => $thumbnailPath
            ]);
        }
        return response()->json([
            'id' => $id
        ]);
    }
    public function delete(Request $request)
    {
        # code...

        if (!$request->session()->has("isAdminLogged")) {
            return redirect()->route('admin.login');
        }
        if ($request->id) {
            DB::table('carousels')->where('id', $request->id)->delete();
            return response()->json([
                "success" => true
            ]);
        }
    }
    public function banner_event(Request $request)
    {
        # code...
        if (!$request->session()->has("isAdminLogged")) {
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
            $isActive = DB::table('carousels')->select('active')->where('id', $request->id)->get()->first();
            $act = null;
            if ($isActive->active) {
                $act = false;
            } else {
                $act = true;
            }
            DB::table('carousels')
                ->where('id', '=', $request->id)
                ->update([
                    'active'    => $act
                ]);
            return response()->json([
                'status'    => 200,
                'success'   => true,
                'message'   => "Success change option active to $act"
            ]);
        }
    }
}
