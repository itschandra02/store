<?php

namespace App\Jobs;

use App\Logic\Curl\KiosGamer;
use App\Logic\Curl\KiosGamerCodm;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class KiosGamerCodmOrderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $invoice_number;
    protected $data;
    protected $idakun;
    public function __construct($invoice_number, $data, $idakun)
    {
        //
        $this->invoice_number = $invoice_number;
        $this->data = $data;
        $this->idakun = $idakun;
    }


    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        # code...
        DB::table('invoices')->where('invoice_number', $this->invoice_number)->update([
            'status' => 'PROGRESS'
        ]);
        $invs = DB::table('invoices')
            ->where('invoice_number', $this->invoice_number)
            ->get()
            ->first();
        $noGroup = str_replace("@g.us", '', setting('wagroup'));
        $__data = DB::table('auto_order_acc')->select()->where('account', 'kiosgamer')->get()->first();
        $kiosgamer = new KiosGamerCodm(setting('anticaptcha'));
        $userLogin = $kiosgamer->Login($this->data[0]['id']);
        if (!isset($userLogin['status'])) {
            $ses = $kiosgamer->LoginGarena($__data->username, $__data->password, $__data->token);
            if (!isset($ses['error'])) {
                //$this->sendWhatsapp(
                 //   $noGroup,
                 //   "*[NOTIFIKASI [🤖] SYSTEM CODM]*\n*Shell*: " . $ses['shell_balance'] . "\n*NEW ORDER DETECTED*",
                 //   "g.us"
                //);
                $faileds = 0;
                $success = 0;
                $user = $kiosgamer->getId();
                foreach ($this->data as $key => $value) {
                    # code...
                    $otp = $kiosgamer->request("GET", "https://authen.amichan.repl.co/otp?code=" . $__data->otp_key);
                    $amount = $kiosgamer->parse_productID($value['amount']);
                    $pay = $kiosgamer->BuyDiamond($ses['uid'], $otp['result'], $amount);
                    // dispatch(new WhatsappSender($noGroup, json_encode($pay), "g.us"));
                    if ($pay['result'] == 'error_balance' || isset($ses['error'])) {
                        $faileds += 1;
                        $t = "*[NOTIFIKASI [🤖] SYSTEM CODM]*\nKiosgamer Codm Order *FAILED*!\nAmount: " . $value['amount'] . " of " . $invs->product_data_name .
                            "\nInvoice number: " . $this->invoice_number . "\nStatus: " . $pay['result'];
                        //dispatch(new WhatsappSender($noGroup, $t, "g.us"));
                        $this->sendWhatsapp($noGroup, $t, "g.us");
                    } else {
                        $success += 1;
                        $t = "*[NOTIFIKASI [🤖] SYSTEM CODM]*\nKiosgamer Codm Order *Success*!\nAmount: " . $value['amount'] . " of " . $invs->product_data_name . "\nInvoice number: " . $this->invoice_number;
                        //dispatch(new WhatsappSender($noGroup, $t, "g.us"));
                        $this->sendWhatsapp($noGroup, $t, "g.us");
                    }
                }
                $ses2 = $kiosgamer->LoginGarena($__data->username, $__data->password, $__data->token);
                if (!isset($ses2['error'])) {
                    $t = "*[NOTIFIKASI [🤖] SYSTEM CODM]*\n*Shell*:" . $ses2['shell_balance'] . "\n*END OF ORDER*";
                    //dispatch(new WhatsappSender($noGroup, $t, "g.us"));
                    $this->sendWhatsapp($noGroup, $t, "g.us");
                }
                if ($success != 0) {
                    $t = "Order $invs->product_data_name untuk product $invs->product_name telah berhasil ditambahkan ke akun game Anda.\n\nTerima kasih kak sudah top up di " . setting('app_name') . " ;)";
                    //dispatch(new WhatsappSender($this->idakun, $t));
                    $this->sendWhatsapp($this->idakun, $t);
                    DB::table('invoices')->where('invoice_number', $this->invoice_number)->update([
                        'status' => 'DONE'
                    ]);
                } else {
                    $t = "Halo $this->idakun, $invs->product_data_name untuk $invs->product_name mu sedang kami proses! tunggu yaaa!! \n" . setting('app_name');
                    //dispatch(new WhatsappSender($this->idakun, $t));
                    $this->sendWhatsapp($this->idakun, $t);
                }
            } else {
                dispatch(new WhatsappSender($noGroup, "*[NOTIFIKASI [🤖] SYSTEM CODM]*\n*GARENA NEED NEW SESSIONKEY*\n\nCan't login to garena account. please generate new session_key. Then retry!", "g.us"));
                DB::table('auto_order_acc')->where('account', 'kiosgamer')->update([
                    'token' => null
                ]);
            }
        } else {
            //dispatch(new WhatsappSender($noGroup, "*[NOTIFIKASI [🤖] SYSTEM CODM]*\n*ANTI-CAPTCHA FAILED*\n\nCan't detect Username because anti-captcha is death\nPlease retry after done settings new anti-captcha apikey.", "g.us"));
            $this->sendWhatsapp($noGroup, "*[NOTIFIKASI [🤖] SYSTEM CODM]*\n*ANTI-CAPTCHA FAILED*\n\nCan't detect Username because anti-captcha is death\nPlease retry after done settings new anti-captcha apikey.", "g.us");
        }
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
    public function sendWhatsapp($jid, $text, $prepend = "s.whatsapp.net")
    {
        # code...
        sleep(1);
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
}
