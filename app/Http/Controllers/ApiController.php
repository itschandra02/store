<?php

namespace App\Http\Controllers;

use App\Jobs\KiosGamerCodmOrderJob;
use App\Jobs\KiosGamerOrderJob;
use App\Jobs\SmileOrderJob;
use App\Jobs\WhatsappSender;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ApiController extends Controller
{
    public function tripay_callback(Request $request)
    {
        # code...
        $pgTripay = DB::table('paygate')->select(["username", "token"])->where("payment", "tripay")->get()->first();
        if (!$pgTripay) {
            return response()->json([
                "success"   => false
            ]);
        }
        $callbackSignature = isset($_SERVER['HTTP_X_CALLBACK_SIGNATURE']) ? $_SERVER['HTTP_X_CALLBACK_SIGNATURE'] : '';
        // $signature = hash_hmac('sha256', $request->getContent(), env('PAYMENT_PRIVATEKEY'));
        $signature = hash_hmac('sha256', $request->getContent(), $pgTripay->token);
        // validasi signature
        if ($callbackSignature !== $signature) {
            exit("Invalid Signature"); // signature tidak valid, hentikan proses
        }
        // return $request;
        $event = $_SERVER['HTTP_X_CALLBACK_EVENT'];
        if ($event == "payment_status") {
            // $this->sendWhatsapp(str_replace("@g.us", '', setting('wagroup')), $t, "g.us");
            if ($request->status == 'PAID') {
                $inv = DB::table('invoices')->select('*')
                    ->where('invoice_number', $request->merchant_ref)
                    // ->where('status', 'PENDING')
                    ->get()
                    ->first();
                $t = "*[NOTIFIKASI [💰] PAYMENT]*
Payment Gateway: TRIPAY
Product: *$inv->product_name*
Product Data: *$inv->product_data_name*
Payment Method: $request->payment_method
Amount Received: $request->amount_received
Fee: $request->total_fee
Total Amount: $request->total_amount
STATUS: [$request->status]";
                dispatch(new WhatsappSender(str_replace("@g.us", '', setting('wagroup')), $t, "g.us"));

                if ($inv) {
                    DB::table('invoices')->where('invoice_number', $inv->invoice_number)->update([
                        'status' => 'PROGRESS'
                    ]);
                    $number = null;
                    if ($inv->number !== null) {
                        $number = $inv->number;
                    } else {
                        $user = DB::table('users')->where('id', $inv->user)->get()->first();
                        $number = $user->number;
                    }
                    $idSmileAuto = DB::table('auto_order_acc')->select('product_id')->where('account', 'smile')->get()->first();
                    $idKiosGamerAuto = DB::table('auto_order_acc')->select('product_id')->where('account', 'kiosgamer')->get()->first();
                    $idKiosGamerAutoCodm = DB::table('auto_order_acc')->select('product_id')->where('account', 'kiosgamercodm')->get()->first();
                    $idKiosgamerAutoAov = DB::table('auto_order_acc')->select('product_id')->where('account', 'kiosgameraov')->get()->first();
                    $idKiosgamerAutoFt = DB::table('auto_order_acc')->select('product_id')->where('account', 'kiosgamerft')->get()->first();
                    $product_data = DB::table('product_data')
                        ->select()
                        ->where('id', $inv->product_data_id)
                        ->get()->first();

                    // update sold product
                    if ($product_data) {
                        $products = DB::table('products')
                            ->select()
                            ->where('id', $product_data->product_id)
                            ->get()->first();
                        if ($products) {
                            $sold = $products->sold + 1;
                            DB::table('products')
                                ->where('id', $product_data->product_id)
                                ->update([
                                    'sold' => $sold
                                ]);
                        }
                    }
                    if (str_starts_with($inv->product_data_name, 'TOPUP')) {
                        $user = DB::table('users')->where('id', $inv->user)->get()->first();
                        if ($user != null) {
                            $userBalance = (int)$user->balance;
                            $amountTopup = $inv->price;
                            DB::table('users')->where('id', $inv->user)->update([
                                'balance' => $userBalance + (int)$amountTopup
                            ]);

                            DB::table('invoices')
                                ->where("invoice_number", "=", $inv->invoice_number)
                                ->update([
                                    "status"    => "DONE"
                                ]);
                            $newBalance = number_format((int)$userBalance + (int)$amountTopup, 0, '.', '.');
                            // $t = "Top up saldo dengan nominal *Rp.$amountTopup* telah berhasil di tambahkan.\nTotal saldo anda adalah $newBalance";

                            $t = "Halo kak,\n
Pembayaran Anda telah kami terima
Berikut adalah rincian pesanan Anda:
- Produk: " . setting('app_name') . " E-Wallet
- Sebesar: Rp $amountTopup
- Nomor Invoice: $inv->invoice_number
- Harga Produk: Rp $request->amount_received
- Biaya Layanan: Rp $request->total_fee
- Total: Rp $request->total_amount
- Metode Pembayaran: " . str_replace("tripay-", "", $request->payment_method) . "
" . route('invoice', $inv->invoice_number) . "\n
Top Up " . setting('app_name') . " E-Wallet Anda sebesar Rp $amountTopup telah berhasil ditambahkan.
Total " . setting('app_name') . " E-Wallet Anda sekarang sebesar Rp $newBalance.\n
Terima kasih,
*" . setting('app_name') . "*";
                            dispatch(new WhatsappSender($user->number, $t));
                        }
                    } else {
                        $idSmileAuto = DB::table('auto_order_acc')->select('product_id')->where('account', 'smile')->get()->first();
                        $idKiosGamerAuto = DB::table('auto_order_acc')->select('product_id')->where('account', 'kiosgamer')->get()->first();
                        $idKiosGamerAutoCodm = DB::table('auto_order_acc')->select('product_id')->where('account', 'kiosgamercodm')->get()->first();
                        $idKiosgamerAutoAov = DB::table('auto_order_acc')->select('product_id')->where('account', 'kiosgameraov')->get()->first();
                        $idKiosgamerAutoFt = DB::table('auto_order_acc')->select('product_id')->where('account', 'kiosgamerft')->get()->first();
                        $product_data = DB::table('product_data')
                            ->select()
                            ->where('id', $inv->product_data_id)
                            ->get()->first();

                        // update sold product
                        $products = DB::table('products')
                            ->select()
                            ->where('id', $product_data->product_id)
                            ->get()->first();
                        $sold = $products->sold + 1;
                        DB::table('products')
                            ->where('id', $product_data->product_id)
                            ->update([
                                'sold' => $sold
                            ]);

                        if (($idSmileAuto) && ($inv->product_id == $idSmileAuto->product_id)) { //MOBILE LEGENDS
                            $product_data = DB::table('product_data')
                                ->select()
                                ->where('id', $inv->product_data_id)
                                ->get()->first();
                            $jarr = json_decode($inv->user_input, true);
                            $_id = $jarr[0]['value'];
                            $_server = $jarr[1]['value'];
                            $layanans = explode(",", $product_data->layanan);
                            $datas = [];
                            foreach ($layanans as $key => $layanan) {
                                # code...
                                $datas[] = [
                                    "id" => $_id,
                                    "server" => $_server,
                                    "amount" => trim($layanan) // see on smile.ts
                                ];
                            }
                            dispatch(new SmileOrderJob($inv->invoice_number, $datas, $number));
                            DB::table('invoices')
                                ->where("invoice_number", "=", $inv->invoice_number)
                                ->update([
                                    "status"    => "DONE"
                                ]);
                        } elseif (($idKiosGamerAuto) && ($inv->product_id == $idKiosGamerAuto->product_id)) { // Free fire
                            $product_data = DB::table('product_data')
                                ->select()
                                ->where('id', $inv->product_data_id)
                                ->get()->first();
                            $jarr = json_decode($inv->user_input, true);
                            $_id = $jarr[0]['value'];
                            $layanans = explode(",", $product_data->layanan);
                            $datas = [];
                            foreach ($layanans as $key => $layanan) {
                                # code...
                                $datas[] = [
                                    "id" => $_id,
                                    "amount" => trim($layanan), // see on kiosgamer.ts
                                    "game"  => "ff"
                                ];
                            }
                            dispatch(new KiosGamerOrderJob($inv->invoice_number, $datas, $number));
                        } elseif (($idKiosGamerAutoCodm) && ($inv->product_id == $idKiosGamerAutoCodm->product_id)) { // Call Of Duty Mobile
                            $product_data = DB::table('product_data')
                                ->select()
                                ->where('id', $inv->product_data_id)
                                ->get()->first();
                            $jarr = json_decode($inv->user_input, true);
                            $_id = $jarr[0]['value'];
                            $layanans = explode(",", $product_data->layanan);
                            $datas = [];
                            foreach ($layanans as $key => $layanan) {
                                # code...
                                $datas[] = [
                                    "id" => $_id,
                                    "amount" => trim($layanan), // see on kiosgamer.ts
                                    "game"  => "codm"
                                ];
                            }
                            dispatch(new KiosGamerOrderJob($inv->invoice_number, $datas, $number));
                        } elseif (($idKiosgamerAutoAov) && ($inv->product_id == $idKiosgamerAutoAov->product_id)) {
                            $product_data = DB::table('product_data')
                                ->select()
                                ->where('id', $inv->product_data_id)
                                ->get()->first();
                            $jarr = json_decode($inv->user_input, true);
                            $_id = $jarr[0]['value'];
                            $layanans = explode(",", $product_data->layanan);
                            $datas = [];
                            foreach ($layanans as $key => $layanan) {
                                # code...
                                $datas[] = [
                                    "id" => $_id,
                                    "amount" => trim($layanan), // see on kiosgamer.ts
                                    "game"  => "aov"
                                ];
                            }
                            dispatch(new KiosGamerOrderJob($inv->invoice_number, $datas, $number));
                        } elseif (($idKiosgamerAutoFt) && ($inv->product_id == $idKiosgamerAutoFt->product_id)) {
                            $product_data = DB::table('product_data')
                                ->select()
                                ->where('id', $inv->product_data_id)
                                ->get()->first();
                            $jarr = json_decode($inv->user_input, true);
                            $_id = $jarr[0]['value'];
                            $layanans = explode(",", $product_data->layanan);
                            $datas = [];
                            foreach ($layanans as $key => $layanan) {
                                # code...
                                $datas[] = [
                                    "id" => $_id,
                                    "amount" => trim($layanan), // see on kiosgamer.ts
                                    "game"  => "fantasytown"
                                ];
                            }
                            dispatch(new KiosGamerOrderJob($inv->invoice_number, $datas, $number));
                        } elseif ($product_data->type_data == "voucher") {
                            // select the first voucher of the product_data
                            $voucher_data = DB::table('voucher_data')->select()
                                ->where('product_data_id', $product_data->id)
                                ->where('used', false)
                                ->where('expired_at', ">=", date("Y-m-d"))
                                ->get()
                                ->first();
                            if ($voucher_data) {
                                DB::table('voucher_data')->where('id', $voucher_data->id)->update([
                                    "used" => true,
                                    "purchased" => $inv->invoice_number,
                                    "purchased_at" => date("Y-m-d H:i:s"),
                                    "status" => "purchased"
                                ]);
                                $sisa = DB::table('voucher_data')->select()
                                    ->where('product_data_id', $product_data->id)
                                    ->where('used', false)
                                    ->where('expired_at', ">=", date("Y-m-d"))
                                    ->get()->count();
                                $t = "*[NOTIFIKASI | VOUCHER]*
*DATA*: $voucher_data->data
*Expired At*: $voucher_data->expired_at
*Invoice Number*: $inv->invoice_number
*Status*: PURCHASED
*Purchased by*: $number
*Voucher left*: $sisa
*Description*: $voucher_data->description";
                                dispatch(new WhatsappSender(str_replace("@g.us", '', setting('wagroup')), $t, "g.us"));
                                //                             $t = "Hai $number,
                                // Kamu berhasil membeli Voucher $product_data->name untuk product $inv->product_name.
                                // Berikut adalah vouchernya: ```$voucher_data->data```";
                                $t = "Halo kak,\n
Pembayaran Anda telah kami terima
Berikut adalah rincian pesanan Anda:
- Produk: $inv->product_name - $product_data->name
- No. Invoice: $inv->invoice_number
- Harga Produk: Rp $request->amount_received
- Biaya Layanan: Rp $request->total_fee
- Total: Rp $request->total_amount
- Metode Pembayaran: " . str_replace("tripay-", "", $request->payment_method) . "\n
Berikut adalah rincian produk $inv->product_name - $product_data->name:
- Data:
$voucher_data->data
- Syarat dan Ketentuan:
Silakan Anda lihat pada link yang tertera di bawah ini.
" . route('invoice', $inv->invoice_number) . "\n
Terima kasih,
*" . setting('app_name') . "*";
                                dispatch(new WhatsappSender($number, $t));
                                DB::table('invoices')->where('invoice_number', $inv->invoice_number)->update([
                                    'status' => 'DONE'
                                ]);
                            } else {
                                DB::table('invoices')
                                    ->where("invoice_number", "=", $inv->invoice_number)
                                    ->update([
                                        "status"    => "PAID"
                                    ]);
                                $t = "Halo kak,\n
Pembayaran Anda telah kami terima
Berikut adalah rincian pesanan Anda:
- Produk: $inv->product_name - $product_data->name
- No. Invoice: $inv->invoice_number
- Harga Produk: Rp $request->amount_received
- Biaya Layanan: Rp $request->total_fee
- Total: Rp $request->total_amount
- Metode Pembayaran: " . str_replace("tripay-", "", $request->payment_method) . "
" . route('invoice', $inv->invoice_number) . "\n
Pesanan anda akan segera diproses mohon ditunggu ya kak.
Terima kasih.\n
*" . setting('app_name') . "*";
                                //                             $t = "Hai $number,
                                // Untuk saat ini stok $product_data->name untuk product $inv->product_name sedang habis.
                                // Anda akan segera di hubungi oleh admin. Mohon ditunggu.
                                // " . setting('app_name');
                                dispatch(new WhatsappSender($number, $t));
                            }
                        } else {
                            DB::table('invoices')
                                ->where("invoice_number", "=", $inv->invoice_number)
                                ->update([
                                    "status"    => "PAID"
                                ]);
                            $t = "Halo kak,\n
Pembayaran Anda telah kami terima
Berikut adalah rincian pesanan Anda:
- Produk: $inv->product_name - $product_data->name
- No. Invoice: $inv->invoice_number
- Harga Produk: Rp $request->amount_received
- Biaya Layanan: Rp $request->total_fee
- Total: Rp $request->total_amount
- Metode Pembayaran: " . str_replace("tripay-", "", $request->payment_method) . "
" . route('invoice', $inv->invoice_number) . "\n
Pesanan anda akan segera diproses mohon ditunggu ya kak.
Terima kasih,
*" . setting('app_name') . "*";
                            dispatch(new WhatsappSender($number, $t));
                        }
                    }
                    return response()->json([
                        "success"   => true
                    ]);
                } else {
                    return response()->json($inv);
                }
            }
            return response()->json([
                "success"   => true
            ]);
        } else {
            return response()->json([
                "success"   => false
            ]);
        }
    }

    public function hitpay_callback(Request $request)
    {
        # code...
        $pgHitpay = DB::table('paygate')->select('password as salt', 'token as apikey')->where('payment', 'hitpay')->first();
        $data = $request->all();
        if ($this->generateSignatureArray($pgHitpay->salt, $data) == $data['hmac']) {
            if ($data['status'] == 'completed') {
                $inv = DB::table('invoices')->where('invoice_number', $data['reference_number'])->first();
                $hitpay = Http::withHeaders([
                    'X-BUSINESS-API-KEY' => $pgHitpay->apikey,
                    'X-Requested-With'   => 'XMLHttpRequest'
                ])->get("https://api.hit-pay.com/v1/payment-requests/" . $data['payment_request_id']);
                if ($inv) {
                    DB::table('invoices')
                        ->where("invoice_number", "=", $data['reference_number'])
                        ->update([
                            "status"    => "PAID",
                            "fee"       => $hitpay['payments'][0]['fees'],
                        ]);
                    $number = null;
                    if ($inv->number !== null) {
                        $number = $inv->number;
                    } else {
                        $user = DB::table('users')->where('id', $inv->user)->get()->first();
                        $number = $user->number;
                    }
                    $t = "[NOTIFICATION [💰] PAYMENT]";
                    $t .= "Payment Gateway : Hitpay\n";
                    $t .= "Payment Status : " . $data['status'] . "\n";
                    $t .= "Payment Request ID : " . $data['payment_request_id'] . "\n";
                    $t .= "Fee: " . $hitpay['payments'][0]['fees'] . "\n";
                    $t .= "Amount Received: " . $hitpay['payments'][0]['amount'] . "\n";
                    $t .= "Payment Method: " . $hitpay['payments'][0]['payment_type'] . "\n";
                    dispatch(new WhatsappSender(str_replace("@g.us", '', setting('wagroup')), $t, "g.us"));

                    // automation variables to check if it has the settings
                    $idSmileAuto = DB::table('auto_order_acc')->select('product_id')->where('account', 'smile')->get()->first();
                    $idKiosGamerAuto = DB::table('auto_order_acc')->select('product_id')->where('account', 'kiosgamer')->get()->first();
                    $idKiosGamerAutoCodm = DB::table('auto_order_acc')->select('product_id')->where('account', 'kiosgamercodm')->get()->first();
                    $idKiosgamerAutoAov = DB::table('auto_order_acc')->select('product_id')->where('account', 'kiosgameraov')->get()->first();
                    $idKiosgamerAutoFt = DB::table('auto_order_acc')->select('product_id')->where('account', 'kiosgamerft')->get()->first();
                    $product_data = DB::table('product_data')
                        ->where('id', $inv->product_data_id)
                        ->get()
                        ->first();
                    if ($product_data) {
                        $products = DB::table('products')
                            ->where('id', $product_data->product_id)
                            ->get()
                            ->first();
                        if ($products) {
                            $sold = $products->sold + 1;
                            DB::table('products')
                                ->where('id', $products->id)
                                ->update([
                                    "sold" => $sold
                                ]);
                        }
                    }
                    if (str_starts_with($inv->product_data_name, 'TOPUP')) {
                        $user = DB::table('users')->where('id', $inv->user)->get()->first();
                        if ($user) {
                            $userBalance = (float)$user->balance;
                            $userBalance += (float)$inv->price;
                            $amountTopup = (float)$inv->price;
                            DB::table('users')
                                ->where('id', $user->id)
                                ->update([
                                    "balance" => $userBalance
                                ]);
                            DB::table('invoices')
                                ->where("invoice_number", "=", $inv->invoice_number)
                                ->update([
                                    "status"    => "DONE"
                                ]);
                            $newBalance = number_format($userBalance, 2, ',', '.');

                            $t = "Halo kak,\n
Pembayaran Anda telah kami terima
Berikut adalah rincian pesanan Anda:
- Produk: " . setting('app_name') . " E-Wallet
- Sebesar: Rp $amountTopup
- Nomor Invoice: $inv->invoice_number
- Harga Produk: Rp $request->amount_received
- Biaya Layanan: Rp $request->total_fee
- Total: Rp $request->total_amount
- Metode Pembayaran: " . str_replace("tripay-", "", $request->payment_method) . "
" . route('invoice', $inv->invoice_number) . "\n
Top Up " . setting('app_name') . " E-Wallet Anda sebesar Rp $amountTopup telah berhasil ditambahkan.
Total " . setting('app_name') . " E-Wallet Anda sekarang sebesar Rp $newBalance.\n
Terima kasih,
*" . setting('app_name') . "*";
                            dispatch(new WhatsappSender($user->number, $t));
                        }
                    } else {
                        if (($idSmileAuto) && ($inv->product_id == $idSmileAuto->product_id)) { //MOBILE LEGENDS
                            $product_data = DB::table('product_data')
                                ->select()
                                ->where('id', $inv->product_data_id)
                                ->get()->first();
                            $jarr = json_decode($inv->user_input, true);
                            $_id = $jarr[0]['value'];
                            $_server = $jarr[1]['value'];
                            $layanans = explode(",", $product_data->layanan);
                            $datas = [];
                            foreach ($layanans as $key => $layanan) {
                                # code...
                                $datas[] = [
                                    "id" => $_id,
                                    "server" => $_server,
                                    "amount" => trim($layanan) // see on smile.ts
                                ];
                            }
                            dispatch(new SmileOrderJob($inv->invoice_number, $datas, $number));
                            DB::table('invoices')
                                ->where("invoice_number", "=", $inv->invoice_number)
                                ->update([
                                    "status"    => "DONE"
                                ]);
                        } elseif (($idKiosGamerAuto) && ($inv->product_id == $idKiosGamerAuto->product_id)) { // Free fire
                            $product_data = DB::table('product_data')
                                ->select()
                                ->where('id', $inv->product_data_id)
                                ->get()->first();
                            $jarr = json_decode($inv->user_input, true);
                            $_id = $jarr[0]['value'];
                            $layanans = explode(",", $product_data->layanan);
                            $datas = [];
                            foreach ($layanans as $key => $layanan) {
                                # code...
                                $datas[] = [
                                    "id" => $_id,
                                    "amount" => trim($layanan), // see on kiosgamer.ts
                                    "game"  => "ff"
                                ];
                            }
                            dispatch(new KiosGamerOrderJob($inv->invoice_number, $datas, $number));
                        } elseif (($idKiosGamerAutoCodm) && ($inv->product_id == $idKiosGamerAutoCodm->product_id)) { // Call Of Duty Mobile
                            $product_data = DB::table('product_data')
                                ->select()
                                ->where('id', $inv->product_data_id)
                                ->get()->first();
                            $jarr = json_decode($inv->user_input, true);
                            $_id = $jarr[0]['value'];
                            $layanans = explode(",", $product_data->layanan);
                            $datas = [];
                            foreach ($layanans as $key => $layanan) {
                                # code...
                                $datas[] = [
                                    "id" => $_id,
                                    "amount" => trim($layanan), // see on kiosgamer.ts
                                    "game"  => "codm"
                                ];
                            }
                            dispatch(new KiosGamerOrderJob($inv->invoice_number, $datas, $number));
                        } elseif (($idKiosgamerAutoAov) && ($inv->product_id == $idKiosgamerAutoAov->product_id)) {
                            $product_data = DB::table('product_data')
                                ->select()
                                ->where('id', $inv->product_data_id)
                                ->get()->first();
                            $jarr = json_decode($inv->user_input, true);
                            $_id = $jarr[0]['value'];
                            $layanans = explode(",", $product_data->layanan);
                            $datas = [];
                            foreach ($layanans as $key => $layanan) {
                                # code...
                                $datas[] = [
                                    "id" => $_id,
                                    "amount" => trim($layanan), // see on kiosgamer.ts
                                    "game"  => "aov"
                                ];
                            }
                            dispatch(new KiosGamerOrderJob($inv->invoice_number, $datas, $number));
                        } elseif (($idKiosgamerAutoFt) && ($inv->product_id == $idKiosgamerAutoFt->product_id)) {
                            $product_data = DB::table('product_data')
                                ->select()
                                ->where('id', $inv->product_data_id)
                                ->get()->first();
                            $jarr = json_decode($inv->user_input, true);
                            $_id = $jarr[0]['value'];
                            $layanans = explode(",", $product_data->layanan);
                            $datas = [];
                            foreach ($layanans as $key => $layanan) {
                                # code...
                                $datas[] = [
                                    "id" => $_id,
                                    "amount" => trim($layanan), // see on kiosgamer.ts
                                    "game"  => "fantasytown"
                                ];
                            }
                            dispatch(new KiosGamerOrderJob($inv->invoice_number, $datas, $number));
                        } elseif ($product_data->type_data == "voucher") {
                            // select the first voucher of the product_data
                            $voucher_data = DB::table('voucher_data')->select()
                                ->where('product_data_id', $product_data->id)
                                ->where('used', false)
                                ->where('expired_at', ">=", date("Y-m-d"))
                                ->get()
                                ->first();
                            if ($voucher_data) {
                                DB::table('voucher_data')->where('id', $voucher_data->id)->update([
                                    "used" => true,
                                    "purchased" => $inv->invoice_number,
                                    "purchased_at" => date("Y-m-d H:i:s"),
                                    "status" => "purchased"
                                ]);
                                $sisa = DB::table('voucher_data')->select()
                                    ->where('product_data_id', $product_data->id)
                                    ->where('used', false)
                                    ->where('expired_at', ">=", date("Y-m-d"))
                                    ->get()->count();
                                $t = "*[NOTIFIKASI | VOUCHER]*
*DATA*: $voucher_data->data
*Expired At*: $voucher_data->expired_at
*Invoice Number*: $inv->invoice_number
*Status*: PURCHASED
*Purchased by*: $number
*Voucher left*: $sisa
*Description*: $voucher_data->description";
                                dispatch(new WhatsappSender(str_replace("@g.us", '', setting('wagroup')), $t, "g.us"));
                                //                             $t = "Hai $number,
                                // Kamu berhasil membeli Voucher $product_data->name untuk product $inv->product_name.
                                // Berikut adalah vouchernya: ```$voucher_data->data```";
                                $t = "Halo kak,\n
Pembayaran Anda telah kami terima
Berikut adalah rincian pesanan Anda:
- Produk: $inv->product_name - $product_data->name
- No. Invoice: $inv->invoice_number
- Harga Produk: Rp $request->amount_received
- Biaya Layanan: Rp $request->total_fee
- Total: Rp $request->total_amount
- Metode Pembayaran: " . str_replace("tripay-", "", $request->payment_method) . "\n
Berikut adalah rincian produk $inv->product_name - $product_data->name:
- Data:
$voucher_data->data
- Syarat dan Ketentuan:
Silakan Anda lihat pada link yang tertera di bawah ini.
" . route('invoice', $inv->invoice_number) . "\n
Terima kasih,
*" . setting('app_name') . "*";
                                dispatch(new WhatsappSender($number, $t));
                                DB::table('invoices')->where('invoice_number', $inv->invoice_number)->update([
                                    'status' => 'DONE'
                                ]);
                            } else {
                                DB::table('invoices')
                                    ->where("invoice_number", "=", $inv->invoice_number)
                                    ->update([
                                        "status"    => "PAID"
                                    ]);
                                $t = "Halo kak,\n
Pembayaran Anda telah kami terima
Berikut adalah rincian pesanan Anda:
- Produk: $inv->product_name - $product_data->name
- No. Invoice: $inv->invoice_number
- Harga Produk: Rp $request->amount_received
- Biaya Layanan: Rp $request->total_fee
- Total: Rp $request->total_amount
- Metode Pembayaran: " . str_replace("tripay-", "", $request->payment_method) . "
" . route('invoice', $inv->invoice_number) . "\n
Pesanan anda akan segera diproses mohon ditunggu ya kak.
Terima kasih.\n
*" . setting('app_name') . "*";
                                dispatch(new WhatsappSender($number, $t));
                            }
                        } else {
                            DB::table('invoices')
                                ->where("invoice_number", "=", $inv->invoice_number)
                                ->update([
                                    "status"    => "PAID"
                                ]);
                            $t = "Halo kak,\n
Pembayaran Anda telah kami terima
Berikut adalah rincian pesanan Anda:
- Produk: $inv->product_name - $product_data->name
- No. Invoice: $inv->invoice_number
- Harga Produk: Rp $request->amount_received
- Biaya Layanan: Rp $request->total_fee
- Total: Rp $request->total_amount
- Metode Pembayaran: " . str_replace("tripay-", "", $request->payment_method) . "
" . route('invoice', $inv->invoice_number) . "\n
Pesanan anda akan segera diproses mohon ditunggu ya kak.
Terima kasih,
*" . setting('app_name') . "*";
                            dispatch(new WhatsappSender($number, $t));
                        }
                    }
                }
            }
        }
    }

    function generateSignatureArray($secret, array $args)
    {
        $hmacSource = [];

        foreach ($args as $key => $val) {
            $hmacSource[$key] = "{$key}{$val}";
        }
        unset($hmacSource['hmac']);
        ksort($hmacSource);

        $sig            = implode("", array_values($hmacSource));
        $calculatedHmac = hash_hmac('sha256', $sig, $secret);

        return $calculatedHmac;
    }
    //
    public function mutation_callback(Request $request)
    {
        # code...
        $data = $request->all();
        $type = $request->type;
        if (!$type) {
            return response()->json([
                'success'   => false,
                'message'   => 'type not found'
            ]);
        }
        try {
            //code...
            if ($type == "bca") {
                foreach ($data['data'] as $key => $value) {
                    # code...
                    if ($value['mutationStatus'] == "CR") {
                        $inv = DB::table('invoices')
                            ->select('*')
                            ->where(DB::raw("(price+fee)"), '=', $value['mutationAmount'])
                            ->where("status", '=', 'PENDING')
                            ->get()
                            ->first();
                        if ($inv) {
                            DB::table('invoices')
                                ->where(DB::raw("(price+fee)"), '=', $value['mutationAmount'])
                                ->where("status", '=', 'PENDING')
                                ->update([
                                    'status' => "PAID"
                                ]);
                            $number = null;
                            $user = null;
                            if ($inv->user != null) {
                                $user = DB::table('users')->select('*')->where('id', $inv->user)->get()->first();
                                $number = $user->username;
                            } else {
                                $number = $inv->number;
                            }
                            $amount_received = $value['mutationAmount'];
                            $paygate = DB::table('paygate')->select("*")->where('payment', $inv->payment_method)->get()->first();
                            $t = "*[NOTIFIKASI [💰] PAYMENT]*\nPembayaran masuk dari $number.\nNominal: *Rp.$amount_received*\nPayment: *" . strtoupper($paygate->payment) . "*\nNorek: *$paygate->norek*\nItem: $inv->product_data_name\nProduct: $inv->product_name";
                            // $this->sendWhatsapp(str_replace("@g.us", '', setting('wagroup')), $t, "g.us");
                            dispatch(new WhatsappSender(str_replace("@g.us", '', setting('wagroup')), $t, "g.us"));
                            if (str_starts_with($inv->product_data_name, 'TOPUP')) {
                                if ($user != null) {
                                    $userBalance = (int)$user->balance;
                                    $amountTopup = $inv->price;
                                    DB::table('users')->where('id', $inv->user)->update([
                                        'balance' => $userBalance + (int)$amountTopup
                                    ]);
                                    DB::table('invoices')
                                        ->where("status", '=', 'PAID')
                                        ->update([
                                            'status' => "DONE"
                                        ]);
                                    $newBalance = number_format((int)$userBalance + (int)$amountTopup, 0, '.', '.');
                                    // $t = "Top up saldo dengan nominal *Rp.$amountTopup* telah berhasil di tambahkan.\nTotal saldo anda adalah $newBalance";

                                    $t = "Halo kak,\n
Pembayaran Anda telah kami terima\n
Berikut adalah rincian pesanan Anda:
- Produk: " . setting('app_name') . " E-Wallet
- Sebesar: Rp $amountTopup
- Nomor Invoice: $inv->invoice_number
- Harga: Rp $amount_received
- Metode Pembayaran: Transfer Bank - BCA\n
" . route('invoice', $inv->invoice_number) . "\n
Top Up " . setting('app_name') . " E-Wallet Anda sebesar Rp $amountTopup telah berhasil ditambahkan.
Total " . setting('app_name') . " E-Wallet Anda sekarang sebesar Rp $newBalance.\n
Terima kasih,
*" . setting('app_name') . "*";
                                    // dispatch(new WhatsappSender($user->number, $t));
                                }
                            } else {
                                $t = "Pembayaran dengan nominal *Rp.$amount_received* telah berhasil diterima.\nMohon tunggu 5 - 15 menit maksimal 15 jam jika ada event top up.
                                Sesuai jam kerja 6 pagi - 11 malam";
                                // $this->sendWhatsapp($user->number, $t);

                                $idSmileAuto = DB::table('auto_order_acc')->select('product_id')->where('account', 'smile')->get()->first();
                                $idKiosGamerAuto = DB::table('auto_order_acc')->select('product_id')->where('account', 'kiosgamer')->get()->first();
                                $idKiosGamerAutoCodm = DB::table('auto_order_acc')->select('product_id')->where('account', 'kiosgamercodm')->get()->first();
                                $idKiosgamerAutoAov = DB::table('auto_order_acc')->select('product_id')->where('account', 'kiosgameraov')->get()->first();
                                $idKiosgamerAutoFt = DB::table('auto_order_acc')->select('product_id')->where('account', 'kiosgamerft')->get()->first();
                                $product_data = DB::table('product_data')
                                    ->select()
                                    ->where('id', $inv->product_data_id)
                                    ->get()->first();

                                // update sold product
                                if ($product_data) {
                                    $products = DB::table('products')
                                        ->select()
                                        ->where('id', $product_data->product_id)
                                        ->get()->first();
                                    if ($products) {
                                        $sold = $products->sold + 1;
                                        DB::table('products')
                                            ->where('id', $product_data->product_id)
                                            ->update([
                                                'sold' => $sold
                                            ]);
                                    }
                                }
                                if (($idSmileAuto) && ($inv->product_id == $idSmileAuto->product_id)) { // Mobile legends
                                    $product_data = DB::table('product_data')
                                        ->select()
                                        ->where('id', $inv->product_data_id)
                                        ->get()->first();
                                    $jarr = json_decode($inv->user_input, true);
                                    $_id = $jarr[0]['value'];
                                    $_server = $jarr[1]['value'];
                                    $layanans = explode(",", $product_data->layanan);
                                    $datas = [];
                                    foreach ($layanans as $key => $layanan) {
                                        # code...
                                        $datas[] = [
                                            "id" => $_id,
                                            "server" => $_server,
                                            "amount" => trim($layanan) // see on smile.ts
                                        ];
                                    }
                                    dispatch(new SmileOrderJob($inv->invoice_number, $datas, $number));
                                } elseif (($idKiosGamerAuto) && ($inv->product_id == $idKiosGamerAuto->product_id)) { // Free fire
                                    $product_data = DB::table('product_data')
                                        ->select()
                                        ->where('id', $inv->product_data_id)
                                        ->get()->first();
                                    $jarr = json_decode($inv->user_input, true);
                                    $_id = $jarr[0]['value'];
                                    $layanans = explode(",", $product_data->layanan);
                                    $datas = [];
                                    foreach ($layanans as $key => $layanan) {
                                        # code...
                                        $datas[] = [
                                            "id" => $_id,
                                            "amount" => trim($layanan), // see on kiosgamer.ts
                                            "game"  => "ff"
                                        ];
                                    }
                                    dispatch(new KiosGamerOrderJob($inv->invoice_number, $datas, $number));
                                } elseif (($idKiosGamerAutoCodm) && ($inv->product_id == $idKiosGamerAutoCodm->product_id)) { // Call Of Duty Mobile
                                    $product_data = DB::table('product_data')
                                        ->select()
                                        ->where('id', $inv->product_data_id)
                                        ->get()->first();
                                    $jarr = json_decode($inv->user_input, true);
                                    $_id = $jarr[0]['value'];
                                    $layanans = explode(",", $product_data->layanan);
                                    $datas = [];
                                    foreach ($layanans as $key => $layanan) {
                                        # code...
                                        $datas[] = [
                                            "id" => $_id,
                                            "amount" => trim($layanan), // see on kiosgamer.ts
                                            "game"  => "codm"
                                        ];
                                    }
                                    dispatch(new KiosGamerOrderJob($inv->invoice_number, $datas, $number));
                                } elseif (($idKiosgamerAutoAov) && ($inv->product_id == $idKiosgamerAutoAov->product_id)) {
                                    $product_data = DB::table('product_data')
                                        ->select()
                                        ->where('id', $inv->product_data_id)
                                        ->get()->first();
                                    $jarr = json_decode($inv->user_input, true);
                                    $_id = $jarr[0]['value'];
                                    $layanans = explode(",", $product_data->layanan);
                                    $datas = [];
                                    foreach ($layanans as $key => $layanan) {
                                        # code...
                                        $datas[] = [
                                            "id" => $_id,
                                            "amount" => trim($layanan), // see on kiosgamer.ts
                                            "game"  => "aov"
                                        ];
                                    }
                                    dispatch(new KiosGamerOrderJob($inv->invoice_number, $datas, $number));
                                } elseif (($idKiosgamerAutoFt) && ($inv->product_id == $idKiosgamerAutoFt->product_id)) {
                                    $product_data = DB::table('product_data')
                                        ->select()
                                        ->where('id', $inv->product_data_id)
                                        ->get()->first();
                                    $jarr = json_decode($inv->user_input, true);
                                    $_id = $jarr[0]['value'];
                                    $layanans = explode(",", $product_data->layanan);
                                    $datas = [];
                                    foreach ($layanans as $key => $layanan) {
                                        # code...
                                        $datas[] = [
                                            "id" => $_id,
                                            "amount" => trim($layanan), // see on kiosgamer.ts
                                            "game"  => "fantasytown"
                                        ];
                                    }
                                    dispatch(new KiosGamerOrderJob($inv->invoice_number, $datas, $number));
                                } elseif ($product_data->type_data == "voucher") {
                                    // select the first voucher of the product_data
                                    $voucher_data = DB::table('voucher_data')->select()
                                        ->where('product_data_id', $product_data->id)
                                        ->where('used', false)
                                        ->where('expired_at', ">=", date("Y-m-d"))
                                        ->get()
                                        ->first();
                                    if ($voucher_data) {
                                        DB::table('voucher_data')->where('id', $voucher_data->id)->update([
                                            "used" => true,
                                            "purchased" => $inv->invoice_number,
                                            "purchased_at" => date("Y-m-d H:i:s"),
                                            "status" => "purchased"
                                        ]);
                                        $sisa = DB::table('voucher_data')->select()
                                            ->where('product_data_id', $product_data->id)
                                            ->where('used', false)
                                            ->where('expired_at', ">=", date("Y-m-d"))
                                            ->get()->count();
                                        $t = "*[NOTIFIKASI | VOUCHER]*
                                        *DATA*: $voucher_data->data
                                        *Expired At*: $voucher_data->expired_at
                                        *Invoice Number*: $inv->invoice_number
                                        *Status*: PURCHASED
                                        *Purchased by*: $number
                                        *Voucher left*: $sisa
                                        *Description*: $voucher_data->description";
                                        dispatch(new WhatsappSender(str_replace("@g.us", '', setting('wagroup')), $t, "g.us"));
                                        $t = "Halo kak,\n
Pembayaran Anda telah kami terima
Berikut adalah rincian pesanan Anda:
- Produk: $inv->product_name - $product_data->name
- Nomor Invoice: $inv->invoice_number
- Harga: Rp $amount_received
- Metode Pembayaran: Transfer Bank - BCA\n
Berikut adalah rincian produk $inv->product_name - $product_data->name:
- Data:
$voucher_data->data
- Syarat dan Ketentuan:
Silakan Anda lihat pada link yang tertera di bawah ini.
" . route('invoice', $inv->invoice_number) . "\n
Terima kasih,
*" . setting('app_name') . "*";
                                        //                                         $t = "Hai $number,
                                        // Kamu berhasil membeli Voucher $product_data->name untuk product $inv->product_name.
                                        // Berikut adalah vouchernya: ```$voucher_data->data```
                                        // " . strip_tags($voucher_data->description);
                                        dispatch(new WhatsappSender($number, $t));
                                        DB::table('invoices')->where('invoice_number', $inv->invoice_number)->update([
                                            'status' => 'DONE'
                                        ]);
                                    } else {
                                        DB::table('invoices')->where('invoice_number', $inv->invoice_number)->update([
                                            'status' => 'PAID'
                                        ]);
                                        $t = "Halo kak,\n
Pembayaran Anda telah kami terima\n
Berikut adalah rincian pesanan Anda:
- Produk: $inv->product_name - $product_data->name
- No.Invoice: $inv->invoice_number
- Harga: Rp $amount_received
- Metode Pembayaran: Transfer Bank BCA
" . route('invoice', $inv->invoice_number) . "\n
Pesanan anda akan segera diproses mohon ditunggu ya kak.\n
Terima kasih,
*" . setting('app_name') . "*";
                                        dispatch(new WhatsappSender($number, $t));
                                    }
                                } else {
                                    DB::table('invoices')->where('invoice_number', $inv->invoice_number)->update([
                                        'status' => 'PAID'
                                    ]);
                                    $t = "Halo kak,\n
Pembayaran Anda telah kami terima\n
Berikut adalah rincian pesanan Anda:
- Produk: $inv->product_name - $product_data->name
- No.Invoice: $inv->invoice_number
- Harga: Rp $amount_received
- Metode Pembayaran: Transfer Bank BCA
" . route('invoice', $inv->invoice_number) . "\n
Pesanan anda akan segera diproses mohon ditunggu ya kak.\n
Terima kasih,
*" . setting('app_name') . "*";
                                    dispatch(new WhatsappSender($number, $t));
                                }
                            }
                        }
                    }
                }
                return response()->json(['success'  => true]);
            }
        } catch (\Throwable $th) {
            throw $th;
            return response()->json([
                'success'   => false,
                'message'   => $th
            ]);
        }
    }
    public function get_invoice(Request $request)
    {
        # code...
        if (!$request->invno) {
            return redirect()->route('index');
        }
        $inv = DB::table('invoices')
            ->select('*')
            ->where('invoice_number', $request->invno)
            ->get()
            ->first();
        return response()->json($inv);
    }

    public function list_invoice(Request $request)
    {
        # code...
        $inv = DB::table('invoices')
            ->select('invoices.*', DB::raw('users.number as user_number'), DB::raw('users.username as user_username'))
            ->leftJoin('users', 'users.id', 'invoices.user')
            ->orderByDesc('created_at')
            ->get();
        return response()->json($inv);
    }
}
