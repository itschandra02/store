<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use QCod\AppSettings\Setting\AppSettings;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;

class ProductsController extends Controller
{
    //
    public function page_products(Request $request)
    {
        # code...
        if (!$request->session()->has('isAdminLogged')) {
            return redirect()->route('admin.login');
        }
        return view('admin.products.list_products');
    }
    public function list_products(Request $request)
    {
        # code...
        if (!$request->session()->has('isAdminLogged')) {
            return redirect()->route('admin.login');
        }
        $data = DB::table('products')
            ->select('*')
            ->orderBy("ordered")
            ->get();
        return response()->json($data);
    }
    public function page_add_products(Request $request)
    {
        # code...
        if (!$request->session()->has('isAdminLogged')) {
            return redirect()->route('admin.login');
        }
        $data = null;
        $items = null;
        $category = DB::table('categories')->select()->get();
        if ($request->id) {
            $data = DB::table('products')
                ->select("*")
                ->where("id", "=", $request->id)
                ->get()
                ->first();
            $items = DB::table('form_inputs')
                ->select("*")
                ->where("product_id", "=", $request->id)
                ->get();
        }
        return view('admin.products.add_products', [
            "data"      => $data,
            "items"     => $items,
            "categories"    => $category
        ]);
    }
    public function event_prod(Request $request)
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
            $isActive = DB::table('products')
                ->select('active')
                ->where('id', '=', $request->id)
                ->get()->first();
            $act = null;
            if ($isActive->active) {
                $act = false;
            } else {
                $act = true;
            }
            DB::table('products')
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
        if ($request->type == "delete") {
            DB::table('products')
                ->where('id', '=', $request->id)
                ->delete();
            return response()->json([
                'status'    => 200,
                'success'   => true,
                'message'   => "Success deleted product"
            ]);
        }
        if ($request->type == "reorder") {
            $newOrderedList = $request->order;
            foreach ($newOrderedList as $key => $value) {
                DB::table('products')
                    ->where('id', '=', $value['id'])
                    ->update([
                        'ordered' => $value['position']
                    ]);
            }
            return response()->json([
                'status'    => 200,
                'success'   => true,
                'message'   => "Success reorder product"
            ]);
        }
    }
    public function add_product(Request $request)
    {
        # code...
        if (!$request->session()->has("isAdminLogged")) {
            return redirect()->route("admin.login");
        }
        $thumbnail = $request->file("thumbnail");
        if ($thumbnail) {
            $validated = $request->validate([
                'thumbnail' => 'nullable|mimes:png,jpeg,jpg,gif,svg|max:2048',
            ]);
            if (!$validated) {
                return redirect()->back()->withErrors($validated)->withInput();
            }
            $namaFile = $thumbnail->getClientOriginalName();
            $namaFile = time() . $namaFile;
            $mime = $thumbnail->getMimeType();
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
            error_log("Uploading");
            error_log($thumbnailPath);
        }
        $instruction = $request->file("instruction");
        if ($instruction) {
            $validated = $request->validate([
                'instruction' => 'nullable|mimes:png,jpeg,jpg,gif,svg|max:2048',
            ]);
            if (!$validated) {
                return redirect()->back()->withErrors($validated)->withInput();
            }
            $namaFile = $instruction->getClientOriginalName();
            $namaFile = time() . $namaFile;
            $mime = $instruction->getMimeType();
            // $instruction->move(public_path() . "/assets/img", $namaFile);
            $img = Image::make($instruction);
            $img->resize(600, null, function ($constraint) {
                $constraint->aspectRatio();
            })->encode('jpg')->save(public_path() . "/assets/img/$namaFile");
            if (setting('use_watermark')) {
                $this->addwatermark(public_path() . "/assets/img/$namaFile");
            }
            $instructionPath = URL::to("assets/img/$namaFile");
            if (setting('server_img')) {
                $instructionPath = $this->uploadMedia(public_path() . "/assets/img/$namaFile");
                unlink(public_path() . "/assets/img/$namaFile");
            }
            // $thumbnailPath = $this->uploadMedia(public_path() . "/assets/img/$namaFile");
            error_log("Uploading");
            error_log($instructionPath);
        }
        $content = $request->description;
        $dom = new \DomDocument();
        $dom->loadHtml($content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $images = $dom->getElementsByTagName('img');
        $n = 0;
        foreach ($images as $k => $img) {
            # code...
            $data = $img->getAttribute('src');
            if (str_starts_with($data, 'data:image')) {
                list($type, $data) = \explode(';', $data);
                list($type, $data) = \explode(',', $data);
                $data = \base64_decode($data);
                $filename = $img->getAttribute('data-filename');
                $image_name = "/img/articles/" . $filename;
                $path = \public_path() . $image_name;
                \file_put_contents($path, $data);
                if (setting('use_watermark')) {
                    $this->addwatermark($path);
                }
                $img->removeAttribute('src');
                $img->setAttribute('src', $image_name);
                if ($n == 0) {
                    $thumbnail = $image_name;
                }
            }
            $n++;
        }
        $content = $dom->saveHTML();
        $inputs = json_decode($request->items, true);
        $newID = $request->id;
        $_input = $request->all();
        $use_input = $request->use_input == null ? 0 : $request->use_input;
        // dump($_input);
        // if ($use_input == true) {
        //     $use_input = 1;
        // } else {
        //     $use_input = 0;
        // }
        if ($request->id == null) {
            $newID = DB::table('products')
                ->insertGetId([
                    "name"     => $request->title,
                    "subtitle"  => $request->subtitle,
                    "description" => $content,
                    "slug"      => Str::slug($request->title),//Str::slug($request->title . " " . $request->subtitle),
                    "active"    => true,
                    "use_input" => $use_input,
                    "category"  => $request->category
                ]);
            if ($thumbnail) {
                DB::table('products')
                    ->where("id", "=", $newID)
                    ->update([
                        "thumbnail" => $thumbnailPath,
                    ]);
            }
            if ($instruction) {
                DB::table('products')
                    ->where("id", "=", $newID)
                    ->update([
                        "instruction" => $instructionPath,
                    ]);
            }
            DB::table('form_inputs')->where('product_id', $newID)->delete();
            if (count($inputs) > 0) {
                for ($i = 0; $i < count($inputs); $i++) {
                    # code...
                    $inputs[$i]['product_id'] = $newID;
                }
                DB::table('form_inputs')
                    ->insert($inputs);
            }
        } else {
            DB::table('products')
                ->where("id", "=", $request->id)
                ->update([
                    "name"     => $request->title,
                    "subtitle"  => $request->subtitle,
                    "description" => $content,
                    "slug"      => Str::slug($request->title),//Str::slug($request->title . " " . $request->subtitle),
                    "active"    => true,
                    "use_input" => $use_input,
                    "category"  => $request->category
                ]);
            if ($thumbnail) {
                DB::table('products')
                    ->where("id", "=", $request->id)
                    ->update([
                        "thumbnail" => $thumbnailPath,
                    ]);
            }
            if ($instruction) {
                DB::table('products')
                    ->where("id", "=", $request->id)
                    ->update([
                        "instruction" => $instructionPath,
                    ]);
            }
            DB::table('form_inputs')->where('product_id', $request->id)->delete();
            if (count($inputs) > 0) {
                for ($i = 0; $i < count($inputs); $i++) {
                    # code...
                    $inputs[$i]['product_id'] = $request->id;
                }
                DB::table('form_inputs')
                    ->insert($inputs);
            }
        }
        $resp = [
            "status"    => true,
            "id"        => $newID,
        ];
        return response()->json($resp);
    }
    public function page_category_products(Request $request)
    {
        # code...
        if (!$request->session()->has('isAdminLogged')) {
            return redirect()->route('admin.login');
        }
        return view("admin.products.category_products");
    }
    public function list_category_products(Request $request)
    {
        # code...
        if (!$request->session()->has('isAdminLogged')) {
            return redirect()->route('admin.login');
        }
        $data = DB::table('categories')
            ->orderBy('ordered')
            ->get();
        return response()->json($data);
    }
    public function add_category_products(Request $request)
    {
        # code...
        if (!$request->session()->has('isAdminLogged')) {
            return redirect()->route('admin.login');
        }
        $data = DB::table('categories')
            ->insert([
                "name" => $request->name,
                "title" => $request->title,
            ]);
        return response()->json($data);
    }
    public function edit_category_products(Request $request)
    {
        # code...
        if (!$request->session()->has('isAdminLogged')) {
            return redirect()->route('admin.login');
        }
        $data = DB::table('categories')
            ->where("id", "=", $request->id)
            ->update([
                "name" => $request->name,
                "title" => $request->title,
            ]);
        return response()->json($data);
    }
    public function delete_category_products(Request $request)
    {
        # code...
        if (!$request->session()->has('isAdminLogged')) {
            return redirect()->route('admin.login');
        }
        $data = DB::table('categories')
            ->where("id", "=", $request->id)
            ->delete();
        return response()->json($data);
    }
    public function event_category_products(Request $request)
    {
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
            $isActive = DB::table('categories')
                ->select('active')
                ->where('id', '=', $request->id)
                ->get()->first();
            $act = null;
            if ($isActive->active) {
                $act = false;
            } else {
                $act = true;
            }
            DB::table('categories')
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
        if ($request->type == "reorder") {
            $newOrderedList = $request->order;
            foreach ($newOrderedList as $key => $value) {
                DB::table('categories')
                    ->where('id', '=', $value['id'])
                    ->update([
                        'ordered' => $value['position']
                    ]);
            }
            return response()->json([
                'status'    => 200,
                'success'   => true,
                'message'   => "Success reorder product"
            ]);
        }
    }
}
