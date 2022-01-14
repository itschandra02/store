<?php

namespace App\Jobs;

use App\Logic\Curl\KiosGamer;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use OTPHP\HOTP;



class KiosGamerOrderJob implements ShouldQueue
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
        $kiosgamer = new KiosGamer(setting('anticaptcha'), $this->data[0]['game']);
        $userLogin = $kiosgamer->Login($this->data[0]['id']);
        if (!isset($userLogin['status'])) {
            $ses = $kiosgamer->LoginGarena($__data->username, $__data->password, $__data->token);
            if (!isset($ses['error'])) {
                //dispatch(new WhatsappSender(
                //    $noGroup,
                //    "*[NOTIFIKASI [🤖] SYSTEM]*\n*Shell*: " . $ses['shell_balance'] . "\n*NEW ORDER DETECTED*",
                //    "g.us"
                //));
                $faileds = 0;
                $success = 0;
                $user = $kiosgamer->getId();
                $role = $kiosgamer->getRole();
                $coin = $ses['shell_balance'];
                foreach ($this->data as $key => $value) {
                    # code...
                    // $otp = $kiosgamer->request("GET", "https://authen.amichan.repl.co/otp?code=" . $__data->otp_key);
                    $otp = HOTP::create($__data->otp_key);
                    // $amount = $kiosgamer->parse_productID($value['amount']);
                    $amount = $kiosgamer->gameproduct[$value['amount']];
                    $pay = $kiosgamer->BuyDiamond($ses['uid'], $otp->at(Carbon::now()->timestamp / 180), $amount);
                    // dispatch(new WhatsappSender($noGroup, json_encode($pay), "g.us"));
                    error_log(json_encode($pay));
                    if ($pay['result'] == 'error_balance' || isset($ses['error'])) {
                        $faileds += 1;
                        $t = "*[NOTIFIKASI [🤖] SYSTEM]*\nKiosgamer Order [" . $kiosgamer->gameName . "] *FAILED*!\n*ID Game*:" . $value['id'] . "\n*Role Name*:" . $role['role'] . "\nAmount: " . $value['amount'] . " of " . $invs->product_data_name .
                            "\nInvoice number: " . $this->invoice_number . "\nStatus: " . $pay['result'];
                        dispatch(new WhatsappSender($noGroup, $t, "g.us"));
                    } else {
                        $success += 1;
                        $t = "*[NOTIFIKASI [🤖] SYSTEM]*\nKiosgamer Order [" . $kiosgamer->gameName . "] *Success*!\n*ID Game*:" . $value['id'] . "\n*Role Name*:" . $role['role'] . "\nAmount: " . $value['amount'] . " of " . $invs->product_data_name . "\nInvoice number: " . $this->invoice_number;
                        dispatch(new WhatsappSender($noGroup, $t, "g.us"));
                    }
                }
                sleep(1);
                $ses2 = $kiosgamer->LoginGarena($__data->username, $__data->password, $__data->token);
                if (!isset($ses2['error'])) {
                    $coin2 = $ses2['shell_balance'];
                    $used_coin = $coin - $coin2;
                    DB::table('invoices')->where('invoice_number', $this->invoice_number)->update([
                        'coin' => $used_coin,
                    ]);
                    $t = "*[NOTIFIKASI [🤖] SYSTEM]*\n*Game*:" . $kiosgamer->gameName . "\n*ID Game*:" . $this->data[0]['id'] . "\n*Shell*:" . $ses2['shell_balance'] . "\n*END OF ORDER*";
                    dispatch(new WhatsappSender($noGroup, $t, "g.us"));
                }
                if ($success != 0) {
                    $t = "Order $invs->product_data_name untuk product $invs->product_name telah berhasil ditambahkan ke akun game Anda.\n\nTerima kasih kak sudah top up di " . setting('app_name') . " ;)";
                    dispatch(new WhatsappSender($this->idakun, $t));

                    DB::table('invoices')->where('invoice_number', $this->invoice_number)->update([
                        'status' => 'DONE'
                    ]);
                } else {
                    $t = "Halo $this->idakun, $invs->product_data_name untuk $invs->product_name mu sedang kami proses! tunggu yaaa!! \n" . setting('app_name');
                    dispatch(new WhatsappSender($this->idakun, $t));
                }
            } else {
                dispatch(new WhatsappSender($noGroup, "*[NOTIFIKASI [🤖] SYSTEM]*\n*GARENA NEED NEW SESSIONKEY*\n\nCan't login to garena account. please generate new session_key. Then retry!", "g.us"));
                DB::table('auto_order_acc')->where('account', 'kiosgamer')->update([
                    'token' => null
                ]);
            }
        } else {
            dispatch(new WhatsappSender($noGroup, "*[NOTIFIKASI [🤖] SYSTEM]*\n*ANTI-CAPTCHA FAILED*\n\nCan't detect Username because anti-captcha is death\nPlease retry after done settings new anti-captcha apikey.", "g.us"));
        }
    }
    public function bak_handle()
    {
        //
        DB::table('invoices')->where('invoice_number', $this->invoice_number)->update([
            'status' => 'PROGRESS'
        ]);

        foreach ($this->data as $key => $value) {
            # code...
            $__data = [
                "id"    => $value['id'],
                "amount" => $value['amount'],
                "username" => "amishopee",
                "password" => "AsdgF32!",
                "otp"   => "LFVMPKUXK5JMI44L"
            ];
            $resp = Http::post(setting('autoapi') . '/kiosgamer/order', $__data)->json();
            if ($resp['status'] == 'success') {
                DB::table('invoices')->where('invoice_number', $this->invoice_number)->update([
                    'status' => 'DONE'
                ]);
                $invs = DB::table('invoices')
                    ->where('invoice_number', $this->invoice_number)
                    ->get()
                    ->first();
                if (count($resp['data']['success']) != 0) {
                    $t = "Order $invs->product_data_name untuk product $invs->product_name telah berhasil ditambahkan ke akun game Anda.\n\nTerima kasih kak sudah top up di " . setting('app_name') . " ;)";
                    $this->sendWhatsapp($this->idakun, $t);
                    // dispatch(new WhatsappSender($this->idakun, $t));
                } else {
                    $t = "Hai $this->idakun, Admin akan segera memproses! ditunggu yaaa";
                    $this->sendWhatsapp($this->idakun, $t);
                    // dispatch(new WhatsappSender($this->idakun, $t));
                }

                foreach ($resp['data']['success'] as $key => $value) {
                    # code...
                    $t = "*[NOTIFIKASI [🤖] SYSTEM]*\nKiosgamer Order Job Success: " . $value['amount'] . " for " . $invs->product_data_name . "\nNickname: " . $value['nickname'] . "\nTakes: " . $value['speed'];
                    $this->sendWhatsapp(str_replace("@g.us", '', setting('wagroup')), $t, "g.us");
                    // dispatch(new WhatsappSender(str_replace("@g.us", '', setting('wagroup')), $t, "g.us"));
                }
                foreach ($resp['data']['failed'] as $key => $value) {
                    # code...
                    $t = "*[NOTIFIKASI [🤖] SYSTEM]*\nKiosgamer Order Job Failed: " . $value['amount'] . " for " . $invs->product_data_name . "\nNickname: " . $value['nickname'] . "\nReason: " . $value['message'] . "\nTakes: " . $value['speed'];
                    $this->sendWhatsapp(str_replace("@g.us", '', setting('wagroup')), $t, "g.us");
                    // dispatch(new WhatsappSender(str_replace("@g.us", '', setting('wagroup')), $t, "g.us"));
                }
                // $t = "*[NOTIFIKASI [🤖] SYSTEM]*\nKiosgamer order for " . $invs->product_data_name . " takes " . $resp['data']['speed'];
                // $this->sendWhatsapp(str_replace("@g.us", '', setting('wagroup')), $t, "g.us");
            }
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
