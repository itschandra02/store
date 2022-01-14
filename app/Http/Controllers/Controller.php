<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Intervention\Image\ImageManagerStatic as Image;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function checkConnWhatsapp()
    {
        # code...
        $wa = DB::table('wagate')
            ->select("*")
            ->orderByDesc("created_at")
            ->get()
            ->first();
        if (!$wa) {
            return false;
        }
        error_log($wa->auth);
        $resp = Http::post(setting('wahost') . "/api/create", [
            "id"  =>    $wa->id,
            "auth" =>    json_decode($wa->auth)
        ]);
        $respJ = $resp->json();
        if (!$respJ['success']) {
            DB::table('wagate')
                ->where('id', '=', $wa->id)
                ->delete();
            return false;
        }
        return $wa;
    }
    public static function addwatermark($name)
    {
        $thumbnail = Image::make($name);
        $imageWidth = $thumbnail->width();
        $watermarkSource =  Image::make(setting('watermark'));

        $watermarkSize = round(20 * $imageWidth / 50);
        $watermarkSource->resize($watermarkSize, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        $watermarkSource->opacity(setting('watermark_opacity'));
        $thumbnail->insert($watermarkSource, setting('watermark_position'), setting('watermark_x'), setting('watermark_y'));
        // $thumbnail->insert($watermarkSource, 'bottom-left', 10, 10);
        $thumbnail->save($name)->destroy();
    }
    public function isOnWhatsapp($jid)
    {
        # code...
        $check = $this->checkConnWhatsapp();
        if ($check) {
            $resp = Http::get(setting('wahost') . "/api/check/$check->id", [
                'jid' => "$jid@s.whatsapp.net"
            ])->json();
            return $resp;
        } else {
            return $check;
        }
    }
    public function sendWhatsapp($jid, $text, $prepend = "s.whatsapp.net")
    {
        # code...
        $check = $this->checkConnWhatsapp();
        if ($check) {
            $resp = Http::post(setting('wahost') . "/api/sendtext/" . $check->id, [
                'jid' => "$jid@$prepend",
                'text' => $text
            ]);
            return $resp;
        } else {
            return $check;
        }
    }
    public function getContact()
    {
        # code...
        $check = $this->checkConnWhatsapp();
        if ($check) {
            $resp = Http::get(setting('wahost') . "/api/contacts/" . $check->id);
            return $resp->json();
        } else {
            return $check;
        }
    }
    public function uploadMedia($file)
    {
        $target_url = "https://telegra.ph/upload";
        $file_name_with_full_path = $file;
        if (function_exists('curl_file_create')) { // php 5.5+
            $cFile = curl_file_create($file_name_with_full_path);
        } else { // 
            $cFile = '@' . realpath($file_name_with_full_path);
        }
        $post = array('extra_info' => '123456', 'file_contents' => $cFile);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $target_url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $res = curl_exec($ch);
        curl_close($ch);
        error_log($res);
        $res = json_decode(
            $res,
            true
        );
        if (isset($res[0]['src'])) {
            return 'https://telegra.ph' . $res[0]['src'];
        }
    }
}
