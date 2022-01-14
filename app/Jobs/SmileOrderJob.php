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
use App\Logic\Curl\SmileOne;
use App\Jobs\WhatsappSender;

class SmileOrderJob implements ShouldQueue
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
        //
        DB::table('invoices')->where('invoice_number', $this->invoice_number)->update([
            'status' => 'PROGRESS'
        ]);
        $__data = DB::table('auto_order_acc')->select()->where('account', 'smile')->get()->first();
        $smile = new SmileOne($__data->cookie);
        $saldo = $smile->cekSaldo();
        if ($saldo['success']) {
            $t = "*[NOTIFIKASI [🤖] SYSTEM]*\nSALDO: " . $saldo['saldo'] . "\nNEW Order DETECTED!";
            // $this->sendWhatsapp();
            //dispatch(new WhatsappSender(str_replace("@g.us", '', setting('wagroup')), $t, "g.us"));
            $invs = DB::table('invoices')
                ->where('invoice_number', $this->invoice_number)
                ->get()
                ->first();
            $faileds = 0;
            $coin = $saldo['balance'];
            foreach ($this->data as $key => $value) {
                # code...
                $paySmile = $smile->curl_payment($value['id'], $value['server'], $value['amount']);
                // print_r($paySmile);
                // $this->sendWhatsapp(str_replace("@g.us", '', setting('wagroup')), json_encode($paySmile), "g.us");
                if ($paySmile['message'] == 'berhasil') {
                    $t = "*[NOTIFIKASI [🤖] SYSTEM]*\nSmile Order Job Success: " . $value['amount'] . " for " . $invs->product_data_name . "\nNickname: " . $paySmile['ign'];
                    dispatch(new WhatsappSender(str_replace("@g.us", '', setting('wagroup')), $t, "g.us"));
                } else {
                    # code...
                    $t = "*[NOTIFIKASI [🤖] SYSTEM]*\nSmile Order Job Failed: " . $value['amount'] . " for " . $invs->product_data_name . "\nNickname: " . $paySmile['ign'] . "\nReason: " . $paySmile['err'];
                    dispatch(new WhatsappSender(str_replace("@g.us", '', setting('wagroup')), $t, "g.us"));
                    $faileds += 1;
                }
            }
            $saldo2 = $smile->cekSaldo();
            $coin2 = $saldo2['balance'];
            $usedCoin = $coin - $coin2;
            DB::table('invoices')->where('invoice_number', $this->invoice_number)->update([
                'coin' => $usedCoin
            ]);
            $t = "*[NOTIFIKASI [🤖] SYSTEM]*\nSALDO: " . $saldo['saldo'] . "\nUSED COIN: $usedCoin\n END OF ORDER!";
            dispatch(new WhatsappSender(str_replace("@g.us", '', setting('wagroup')), $t, "g.us"));

            if ($faileds != 0) {
                DB::table('invoices')->where('invoice_number', $this->invoice_number)->update([
                    'status' => 'PROGRESS'
                ]);
                $t = "*[NOTIFIKASI [🤖] SYSTEM]*\nPlease process manual for this invoice: $this->invoice_number!\nBalance Empty";
                dispatch(new WhatsappSender(str_replace("@g.us", '', setting('wagroup')), $t, "g.us"));
                dispatch(new WhatsappSender($this->idakun, "Mohon tunggu sebentar admin akan memproses pesananmu! Biasanya memerlukan waktu beberapa menit apabila admin online"));
            } else {
                DB::table('invoices')->where('invoice_number', $this->invoice_number)->update([
                    'status' => 'DONE'
                ]);
                dispatch(new WhatsappSender($this->idakun, "Order $invs->product_data_name untuk product $invs->product_name telah berhasil ditambahkan ke akun game Anda.\n\nTerima kasih kak sudah top up di " . setting('app_name') . " ;)"));
            }
        } else {
            $t = "*[NOTIFIKASI [🤖] SYSTEM]*\nERROR: PLEASE UPDATE YOUR PHPSESSID";
            dispatch(new WhatsappSender(str_replace("@g.us", '', setting('wagroup')), $t, "g.us"));
        }
    }

    public function backup_handle()
    {
        //
        DB::table('invoices')->where('invoice_number', $this->invoice_number)->update([
            'status' => 'PROGRESS'
        ]);

        $__data = DB::table('smile_acc')
            ->select()
            ->get()->first();
        $account = [
            "type"  => $__data->type,
            "username"  => $__data->username,
            "password"  => $__data->password
        ];
        $_data = [
            'account'   => $account,
            'data'      => $this->data
        ];
        // 51.79.242.14
        $resp = Http::post(setting('autoapi') . '/smile/order', $_data)->json();
        // $resp = Http::post('http://localhost:4444/smile/order',$_data)->json();
        if ($resp['status'] == 'success') {
            DB::table('invoices')->where('invoice_number', $this->invoice_number)->update([
                'status' => 'DONE'
            ]);

            $invs = DB::table('invoices')
                ->where('invoice_number', $this->invoice_number)
                ->get()
                ->first();
            if (count($resp['data']['successfulOrders']) == count($resp['data']['orders'])) {
                $t = "Order $invs->product_data_name untuk product $invs->product_name telah berhasil ditambahkan ke akun game Anda.\n\nTerima kasih kak sudah top up di " . setting('app_name') . " ;)";
                $this->sendWhatsapp($this->idakun, $t);
            } else {
                $t = "Hai $this->idakun, Admin akan segera memproses! ditunggu yaaa";
                $this->sendWhatsapp($this->idakun, $t);
            }
            // $akun = DB::table('users')->select('*')->where('id', $this->idakun)->get()->first();
            // if ($akun) {
            //     $invs = DB::table('invoices')
            //         ->where('invoice_number', $this->invoice_number)
            //         ->get()
            //         ->first();
            //     if (count($resp['data']['successfulOrders']) == count($resp['data']['orders'])) {
            //         $t = "Hai $akun->name, " . $invs->product_data_name . " Berhasil ditambahkan ke akun Mobile Legends kamu! Cek segera! \nAyo beli lagi!";
            //         $this->sendWhatsapp($akun->number, $t);
            //     } else {
            //         $t = "Hai $akun->name, Admin akan segera memproses! ditunggu yaaa";
            //         $this->sendWhatsapp($akun->number, $t);
            //     }
            // } else {
            //     $invs = DB::table('invoices')
            //         ->where('invoice_number', $this->invoice_number)
            //         ->get()
            //         ->first();
            //     if (count($resp['data']['successfulOrders']) == count($resp['data']['orders'])) {
            //         $t = "Hai $akun->name, " . $invs->product_data_name . " Berhasil ditambahkan ke akun Mobile Legends kamu! Cek segera! \nAyo beli lagi!";
            //         $this->sendWhatsapp($akun->number, $t);
            //     } else {
            //         $t = "Hai $akun->name, Admin akan segera memproses! ditunggu yaaa";
            //         $this->sendWhatsapp($akun->number, $t);
            //     }
            // }
            foreach ($resp['data']['successfulOrders'] as $key => $value) {
                # code...
                $t = "*[NOTIFIKASI [🤖] SYSTEM]*\nSmile Order Job Success: " . $value['amount'] . " for " . $invs->product_data_name . "\nNickname: " . $value['ign'];
                $this->sendWhatsapp(str_replace("@g.us", '', setting('wagroup')), $t, "g.us");
            }
            foreach ($resp['data']['failedOrders'] as $key => $value) {
                # code...
                $t = "*[NOTIFIKASI [🤖] SYSTEM]*\nSmile Order Job Failed: " . $value['amount'] . " for " . $invs->product_data_name . "\nNickname: " . $value['ign'] . "\nReason: " . $value['err'];
                $this->sendWhatsapp(str_replace("@g.us", '', setting('wagroup')), $t, "g.us");
            }
            $t = "*[NOTIFIKASI [🤖] SYSTEM]*\nSmile order for " . $invs->product_data_name . " takes " . $resp['data']['speed'];
            $this->sendWhatsapp(str_replace("@g.us", '', setting('wagroup')), $t, "g.us");
        }
        $req = Http::get(setting('autoapi') . '/smile/check', $account)->json();
        $t = "*[NOTIFIKASI [🤖] SYSTEM]*\nYour SOC Balance is:\nID: " . $req['data']['account_id'] . "\nBalance: " . $req['data']['balance'] . " 🙂 Coin\n\nProcess Takes " . $req['data']['speed'];
        $this->sendWhatsapp(str_replace("@g.us", '', setting('wagroup')), $t, "g.us");
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
