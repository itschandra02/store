<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class WhatsappSender implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $jid;
    protected $message;
    protected $prepend;
    public function __construct($jid, $message, $prepend = "s.whatsapp.net")
    {
        //
        $this->jid = $jid;
        $this->message = $message;
        $this->prepend = $prepend;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $this->sendWhatsapp($this->jid, $this->message, $this->prepend);
    }

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
        // error_log($wa->auth);
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
