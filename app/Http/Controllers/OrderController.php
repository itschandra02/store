<?php

namespace App\Http\Controllers;

use App\Jobs\KiosGamerCodmOrderJob;
use App\Jobs\KiosGamerOrderJob;
use App\Jobs\SmileOrderJob;
use App\Jobs\WhatsappSender;
use App\Logic\Curl\BukuKas;
use App\Logic\Curl\KiosGamer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use PDO;

use function PHPSTORM_META\map;

class OrderController extends Controller
{
    //
    public function order_check(Request $request)
    {
        # code...
        // $waNum = $this->isOnWhatsapp($request->number);
        // error_log(json_encode($waNum));
        // if ($waNum['success'] == false) {
        //     return response()->json([
        //         'status'    => false,
        //         'message'   => "Number not found"
        //     ]);
        // }
        # disable captcha
        if (!$request->captcha_response) {
            return response()->json([
                "status"   => false,
                "message"   => "Invalid Captcha"
            ]);
        }
        $ign = "can't load IGN";
        $status = false;
        if (str_contains(Str::lower($request['nominal']['product_name']), "mobile legends")) {
            $checkzone = "https://www.smile.one/merchant/mobilelegends/checkrole/";
            $jobj = json_encode($request->dataId);
            $jarr = json_decode($jobj, true);
            error_log($jarr[0]['value']);
            error_log($jarr[1]['value']);
            $resp = Http::post($checkzone, [
                'user_id' => $jarr[0]['value'],
                'zone_id' => $jarr[1]['value'],
                'pid' => 26,
                'checkrole' => 1
            ]);
            $respJ = $resp->json();
            if ($respJ['code'] == 200) {
                $ign = $respJ['username'];
                $status = true;
            }
            error_log(json_encode($respJ));
        } else if (str_contains(Str::lower($request['nominal']['product_name']), "sausage")) {
            $url = "https://xdg-hk.xd.com/api/v1/user/get_role";
            $jobj = json_encode($request->dataId);
            $jarr = json_decode($jobj, true);
            $resp = Http::get($url, [
                "client_id" => "zuRsHFfcY2KtVql3",
                "server_id" => "global-release",
                "character_id" => $jarr[0]['value']
            ]);
            $respJ = $resp->json();
            if ($respJ['data'] != null) {
                $nama = $respJ['data']['name'];
                $charID = $respJ['data']['character_id'];
                $ign = "$nama ($charID)";
                $status = true;
            }
        } else if (str_contains(Str::lower($request['nominal']['product_name']), "free fire")) {
            $url = "https://www.lapakgaming.com/game/ajax/user-check.php";
            $jobj = json_encode($request->dataId);
            $jarr = json_decode($jobj, true);
            $resp = Http::withHeaders([
                "X-Requested-With" => "XMLHttpRequest"
            ])->asForm()->post($url, [
                "category" => "FF",
                "target" => $jarr[0]['value']
            ]);
            error_log($resp);
            $respJ = $resp->json();
            if ($respJ['data'] != null) {
                $nama = $respJ['data']['name'];
                $ign = "$nama";
                $status = true;
            }
        } else if (str_contains(Str::lower($request['nominal']['product_name']), "codm") xor (str_contains(Str::lower($request['nominal']['product_name']), "call of duty") and str_contains(Str::lower($request['nominal']['product_name']), "mobile"))) {
            $url = "https://api.duniagames.co.id/api/transaction/v1/top-up/inquiry/store";
            $jobj = json_encode($request->dataId);
            $jarr = json_decode($jobj, true);
            $resp = Http::withHeaders([
                "X-Requested-With" => "XMLHttpRequest"
            ])->asForm()->post($url, [
                "catalogId" => 144,
                "gameId" => $jarr[0]['value'],
                "itemId" => 88,
                "paymentId" => 1527,
                "productId" => 18,
                "product_ref" => "CMS",
                "product_ref_denom" => "REG"
            ]);
            error_log($resp);
            $respJ = $resp->json();
            if ($respJ['data'] != null) {
                $nama = $respJ['data']['gameDetail']['userName'];
                $ign = "$nama";
                $status = true;
            }
        } else if (str_contains(Str::lower($request['nominal']['product_name']), "higgs domino")) {
            $url = "https://api.duniagames.co.id/api/transaction/v1/top-up/inquiry/store";
            $jobj = json_encode($request->dataId);
            $jarr = json_decode($jobj, true);
            $resp = Http::withHeaders([
                "X-Requested-With" => "XMLHttpRequest"
            ])->asForm()->post($url, [
                "catalogId" => 442,
                "gameId" => $jarr[0]['value'],
                "itemId" => 416,
                "paymentId" => 1611,
                "productId" => 61,
                "product_ref" => "REG",
                "product_ref_denom" => "AE"
            ]);
            error_log($resp);
            $respJ = $resp->json();
            if ($respJ['data'] != null) {
                $nama = $respJ['data']['gameDetail']['userName'];
                $ign = "$nama";
                $status = true;
            }
        } else if (str_contains(Str::lower($request['nominal']['product_name']), "arena of valor") or str_contains(Str::lower($request['nominal']['product_name']), "aov")) {
            $jobj = json_encode($request->dataId);
            $jarr = json_decode($jobj, true);
            $aov = new KiosGamer("", "aov");
            $loginID = $aov->login($jarr[0]['value']);
            if (!isset($loginID['error'])) {
                $role = $aov->getRole();
                if ($role) {
                    $roleServer = $role['server'];
                    $roleName = $role['role'];
                    $ign = "$roleName ($roleServer)";
                    $status = true;
                }
            }
        } else if (str_contains(Str::lower($request['nominal']['product_name']), "fantasy town")) {
            $jobj = json_encode($request->dataId);
            $jarr = json_decode($jobj, true);
            $ft = new KiosGamer("", "fantasytown");
            $loginID = $ft->login($jarr[0]['value']);
            if (!isset($loginID['error'])) {
                $role = $ft->getRole();
                $userid = $ft->getId();
                if ($role) {
                    $_userid = $userid['login_id'];
                    $roleServer = $role['event_region'];
                    $ign = "$_userid ($roleServer)";
                    $status = true;
                }
            }
        } else {
            $status = true;
        }
        return response()->json([
            'status'    => $status,
            'message'   => $ign
        ]);
    }
    public function voucher_list(Request $request)
    {
        # code...
        $data = DB::table('voucher_data')->select()
            ->where('product_data_id', $request->data_id)
            ->where('used', 0)
            ->get();
        $status = false;
        if (count($data) > 0) {
            $status = true;
        }
        return response()->json([
            'success'    => $status,
            'stock'     => count($data)
        ]);
    }

    /**
     * Order add with OTP
     * Backup!!!!!!
     */
    public function bak_order_add(Request $request)
    {
        # code...
        if ($request->type == "otp") {
            $otp = rand(1000, 9999);
            DB::table('temp_otp')->insert([
                'username' => $request->user,
                'otp' => $otp,
                'otp_type' => "order_add"
            ]);
            $akun = DB::table('users')->select('*')->where('username', $request->user)->get()->first();
            $t = "Halo *$request->user*,\nSilahkan input kode OTP berikut: *$otp*";
            $this->sendWhatsapp($akun->number, $t);
            return response()->json([
                "success"   => true,
                "message"   => "OTP has been sent"
            ]);
        } else if ($request->type == 'verification') {
            $temp_otp = DB::table('temp_otp')
                ->select("*")
                ->where("username", "=", $request->user)
                ->where("otp", "=", $request->otp)
                ->where('otp_type', "=", "order_add")
                ->get()->first();
            if ($temp_otp) {
                DB::table('temp_otp')
                    ->where("username", "=", $request->user)
                    ->where("otp", "=", $request->otp)
                    ->where('otp_type', "=", "order_add")
                    ->delete();
                $akun = DB::table('users')
                    ->select("*")
                    ->where("username", "=", $request->user)
                    ->get()->first();
                $price = $request->price;
                $type = DB::table('usertype')
                    ->select("*")
                    ->where("type", "=", $akun->status)
                    ->get()->first();
                $disc = 0;
                if ($akun->status == $type->type) {
                    $disc = $type->discount;
                    $price = $price - ($price * ($disc / 100));
                }
                if ($request->paymentMethod == "saldo") {
                    if ($akun->balance <= $price) {
                        return response()->json([
                            "success"   => false,
                            "message"   => "Saldo Anda tidak cukup: " . $akun->balance
                        ]);
                    }
                }
                $invoiceNumber = rand(100000, 999999);
                $prod = DB::table('product_data')
                    ->select('*')
                    ->where('id', $request['nominal']['id'])
                    ->get()
                    ->first();
                $kodeunik = rand(100, 999);
                for ($i = 0; $i < 5; $i++) {
                    # code...
                    $cekkode = DB::table('invoices')
                        ->select(['fee', 'price'])
                        ->where(DB::raw("(price+fee)"), '=', $price + $kodeunik)
                        ->get()->first();
                    if ($cekkode) {
                        $kodeunik = rand(100, 999);
                    } else {
                        break;
                    }
                }
                if ($request->paymentMethod == "saldo") {
                    $kodeunik = 0;
                }
                DB::table('invoices')->insert([
                    'invoice_number'    => $invoiceNumber,
                    'user'              => $akun->id,
                    'product_data_id'   => $request['nominal']['id'],
                    'product_data_name' => $request['nominal']['name'],
                    'product_id'        => $request['nominal']['product_id'],
                    'product_name'      => $request['nominal']['product_name'],
                    'price'             => $price,
                    'fee'               => $kodeunik,
                    'discount'          => $disc,
                    'user_input'        => json_encode($request->dataId),
                    'payment_method'    => $request['paymentMethod'],
                    'status'            => 'PENDING'
                ]);
                $newurl = null;
                $balance = $akun->balance;
                if ($request->paymentMethod == "qris") {
                    $qris = DB::table('paygate')
                        ->select("*")
                        ->where('payment', '=', $request->paymentMethod)
                        ->get()->first();
                    if ($qris) {
                        $bukukas = new BukuKas;
                        $newref = $bukukas->generatePaymentLink($qris->norek, $price + $kodeunik, $qris->token);
                        if ($newref['data']) {
                            DB::table('invoices')
                                ->where('invoice_number', '=', $invoiceNumber)
                                ->update([
                                    'payment_ref'   => $newref['data']['generatePaymentLink']['id']
                                ]);
                            $newurl = $newref['data']['generatePaymentLink']['slug'];
                        }
                    }
                } else if ($request->paymentMethod == "saldo") {
                    $inv = DB::table('invoices')
                        ->select()
                        ->where("invoice_number", '=', $invoiceNumber)
                        ->get()->first();
                    $exactBalance = $akun->balance - $price;
                    DB::table('users')->where('id', $akun->id)->update([
                        'balance' => $exactBalance
                    ]);
                    $balance = $exactBalance;
                    if ($request['nominal']['product_id'] == 1) {
                        $product_data = DB::table('product_data')
                            ->select()
                            ->where('id', $request['nominal']['id'])
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
                        dispatch(new SmileOrderJob($inv->invoice_number, $datas, $akun->number));
                        DB::table('invoices')
                            ->where("invoice_number", "=", $invoiceNumber)
                            ->update([
                                "status"    => "DONE"
                            ]);
                    }
                }
                $formatted_balance = number_format($balance, 0, ".", ".");
                $product_name = $request['nominal']['product_name'];
                $product_data_name = $request['nominal']['name'];
                $price = $price + $kodeunik;
                $t = "Halo kak *$akun->name*, ini orderannya ya :

                *Nama product*: $product_name
                *Layanan*: $product_data_name
                *Harga*: Rp.$price
                *Nomor Pesanan*: $invoiceNumber\n
                Terima kasih sudah top up di " . setting('app_name') . " ;-)";
                // $this->sendWhatsapp($akun->number, $t);
                //dispatch(new WhatsappSender($akun->number, $t));
                $t = "*[NOTIFIKASI | Pesanan]*
                *Username:* $akun->username
                *Invoice:* $invoiceNumber
                *Product Name:* $product_name
                *Product Data Name:* $product_data_name
                *Price:* Rp.$price
                *Payment Method:* $request->paymentMethod
                *Balance sisa:* Rp.$akun->balance
                *Balance sekarang:* Rp.$formatted_balance
                *User Input:*\n";
                $jobj = json_encode($request->dataId);
                $jarr = json_decode($jobj, true);
                for ($i = 0; $i < count($jarr); $i++) {
                    # code...
                    $t .= " - *" . $jarr[$i]['name'] . "*: " . $jarr[$i]['value'] . "\n";
                }
                // $this->sendWhatsapp(str_replace("@g.us", '', setting('wagroup')), $t, "g.us");
                // dispatch(new WhatsappSender(str_replace("@g.us", '', setting('wagroup')), $t, "g.us"));
                return response()->json([
                    'success'    => true,
                    'message'   => route('invoice', $invoiceNumber)
                ]);
            } else {
                return response()->json([
                    'success'    => false,
                    'message'   => "Otp salah!"
                ]);
            }
        }
    }

    /**
     * Order without otp. and with Guest mode
     */
    public function guest_order(Request $request)
    {
        # code...
        $gCaptchaResp = $request->captcha_response;
        if (!$gCaptchaResp) {
            return response()->json([
                "status" => false,
                "message" => "Access Forbidden"
            ]);
        }
        $urlCaptcha = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode(setting('captcha_secret')) .  '&response=' . urlencode($gCaptchaResp);
        $resp = file_get_contents($urlCaptcha);
        $captcha = json_decode($resp, true);
        if (!$captcha['success']) {
            return response()->json([
                "status"    => false,
                "message" => "Error captcha"
            ]);
        }
        $price = $request->price;
        $invoiceNumber = rand(100000, 999999);
        $prod = DB::table('product_data')
            ->select('*')
            ->where('id', $request['nominal']['id'])
            ->get()
            ->first();
        $kodeunik = rand(100, 999);
        for ($i = 0; $i < 5; $i++) {
            # code...
            $cekkode = DB::table('invoices')
                ->select(['fee', 'price'])
                ->where(DB::raw("(price+fee)"), '=', $price + $kodeunik)
                ->get()->first();
            if ($cekkode) {
                $kodeunik = rand(100, 999);
            } else {
                break;
            }
        }
        $invoice_values = [
            'invoice_number'    => $invoiceNumber,
            'user'              => null,
            'number'            => $request->number,
            'product_data_id'   => $request['nominal']['id'],
            'product_data_name' => $request['nominal']['name'],
            'product_id'        => $request['nominal']['product_id'],
            'product_name'      => $request['nominal']['product_name'],
            'price'             => $price,
            'fee'               => $kodeunik,
            'discount'          => 0,
            'user_input'        => $request->dataId ? json_encode($request->dataId) : "",
            'payment_method'    => $request['paymentMethod'],
            'status'            => 'PENDING',
            "expiry_date"     => (time() + (3 * 60 * 60)), // 3 hour,,
        ];
        $urlReturn = route('invoice', $invoiceNumber);
        if (str_starts_with($request['paymentMethod'], 'tripay-')) {
            $tripay_value = $this->tripay_order($request, $invoiceNumber, $price);
            $invoice_values['fee'] = $tripay_value['data']['fee_customer'];
            $invoice_values['payment_ref'] = $tripay_value['data']['reference'];
            if (str_starts_with($request['paymentMethod'], 'tripay-OVO')) {
                $urlReturn = $tripay_value['data']['pay_url'];
            }
        } elseif (str_starts_with($request['paymentMethod'], 'hitpay-')) {
            $hitpay_value = $this->hitpay_order($request, $invoiceNumber, $price);
            $invoice_values['fee'] = 0;
            $invoice_values['payment_ref'] = $hitpay_value['id'];
            $urlReturn = $hitpay_value['url'];
        } else {
            $price = $price + $kodeunik;
        }
        DB::table('invoices')->insert($invoice_values);
        // $formatted_balance = number_format($balance, 0, ".", ".");
        $product_name = $request['nominal']['product_name'];
        $product_data_name = $request['nominal']['name'];
        $urlPesanan = route('invoice', $invoiceNumber);
        $t = "Halo kak, ini orderannya ya :

        *Product* : $product_name
        *Layanan* : $product_data_name
        *Harga* : Rp.$price
        *No.Invoice* : $invoiceNumber
        $urlPesanan

        Segera lakukan pembayaran ya kak agar pesanannya segera diproses.\n
        Terima kasih ;)";
        // $this->sendWhatsapp($request->number, $t);

        $t = "Halo kak,\n
Berikut adalah rincian pesanan Anda:
- Produk : $product_name - $product_data_name
- No.Invoice : $invoiceNumber
- Harga : Rp $price
- Metode Pembayaran : " . str_replace("tripay-", "", $request->paymentMethod) . "\n
Untuk selengkapnya silahkan lihat pada link yang tertera di bawah ini.
" . route('invoice', $invoiceNumber) . "\n
Terima kasih.
*" . setting('app_name') . "*";
        //dispatch(new WhatsappSender($request->number, $t));
        $t = "*[NOTIFIKASI | Pesanan]*
*User:* http://wa.me/$request->number
*Invoice:* $invoiceNumber
*Product Name:* $product_name
*Product Data Name:* $product_data_name
*Price:* Rp.$price
*Payment Method:* $request->paymentMethod
*Mode:* Guest
*User Input:*\n";
        $jobj = json_encode($request->dataId);
        $jarr = json_decode($jobj, true);
        if ($jarr) {
            for ($i = 0; $i < count($jarr); $i++) {
                # code...
                $t .= " - *" . $jarr[$i]['name'] . "*: " . $jarr[$i]['value'] . "\n";
            }
        }
        // $this->sendWhatsapp(str_replace("@g.us", '', setting('wagroup')), $t, "g.us");
        //dispatch(new WhatsappSender(str_replace("@g.us", '', setting('wagroup')), $t, "g.us"));
        return response()->json([
            'success'    => true,
            'message'   => $urlReturn, //route('invoice', $invoiceNumber)
        ]);
    }

    public function tripay_order(Request $request, $invoiceNumber, $price)
    {
        # code...
        $pgTripay = DB::table('paygate')->select()->where('payment', 'tripay')->get()->first();
        $user = null;
        error_log($request->user);
        if ($request->user != null) {
            $_user = DB::table('users')->select()->where("username", $request->user)->get()->first();
            $user = [
                "name"  => $_user->username,
                "email" => $_user->email,
                "number" => $_user->number
            ];
        } else {
            $user = [
                "name"  => "guest",
                "email" => "guest@gmail.com",
                "number"    => $request->number
            ];
        }
        $count_rep = 1;

        $data = [
            'method'            => str_replace("tripay-", "", $request['paymentMethod']),
            'merchant_ref'      => $invoiceNumber,
            'amount'            => (int)$price,
            'customer_name'     => $user['name'],
            'customer_email'    => $user['email'],
            'customer_phone'    => str_starts_with($user['number'], '62') ? str_replace("62", "0", $user['number'], $count_rep) : $user['number'],
            'order_items'       => [
                [
                    'sku'       => "PRD" . $request['nominal']['id'] . "X" . $request['nominal']['product_id'],
                    'name'      => $request['nominal']['product_name'] . " - " . $request['nominal']['name'],
                    'price'     => $price,
                    'quantity'  => 1
                ]
            ],
            'callback_url'      => route('api.callback.payment.tripay'),
            'return_url'        => route('invoice', $invoiceNumber),
            'expired_time'      => (time() + (3 * 60 * 60)), // 24 jam,
            'signature'         => hash_hmac('sha256', $pgTripay->norek . $invoiceNumber . (int)$price, $pgTripay->token)
        ];
        error_log(json_encode($data));
        $resp = Http::withHeaders([
            'Authorization' => "Bearer " . $pgTripay->username
        ])->post("https://tripay.co.id/api/transaction/create", $data)->json();
        error_log(json_encode($resp));
        return $resp;
    }

    public function hitpay_order(Request $request, $invoiceNumber, $price)
    {
        # code...
        $pgTripay = DB::table('paygate')->select()->where('payment', 'hitpay')->get()->first();
        $user = null;
        error_log($request->user);
        if ($request->user != null) {
            $_user = DB::table('users')->select()->where("username", $request->user)->get()->first();
            $user = [
                "name"  => $_user->username,
                "email" => $_user->email,
                "number" => $_user->number
            ];
        } else {
            $user = [
                "name"  => "guest",
                "email" => "guest@gmail.com",
                "number"    => $request->number
            ];
        }

        $data = [
            "reference_number" => $invoiceNumber,
            "email"           => $user['email'],
            "redirect_url"    => route('invoice', $invoiceNumber),
            "webhook"         => route('api.callback.payment.hitpay'),
            "currency"        => "SGD",
            "amount"          => (string)$price,
            "name"            => $user['name'],
            "expiry_date"     => (time() + (3 * 60 * 60)), // 3 hour,,
            "send_email"      => 'true',
        ];
        error_log(json_encode($data));
        error_log($pgTripay->token);
        $resp = Http::withHeaders([
            'X-BUSINESS-API-KEY' => $pgTripay->token,
            'Content-Type' => 'application/x-www-form-urlencoded',
            'X-Requested-With' => 'XMLHttpRequest'
        ])->asForm()->post("https://api.hit-pay.com/v1/payment-requests", $data)->json();
        error_log(json_encode($resp));
        return $resp;
    }

    public function order_add(Request $request)
    {
        # code...
        if (!$request->session()->has('loggedIn') && $request->paymentMethod == "saldo") {
            return response()->json([
                'success'    => false,
                'message'   => "Silahkan login terlebih dahulu untuk melakukan pembayaran"
            ]);
        }
        if ($request->user == null && $request->number) {
            error_log("Guest Mode");
            return $this->guest_order($request);
        }
        $akun = DB::table('users')
            ->select("*")
            ->where("username", "=", $request->user)
            ->get()->first();
        $price = $request->price;
        $type = DB::table('usertype')
            ->select("*")
            ->where("type", "=", $akun->status)
            ->get()->first();
        $disc = 0;

        $prod = DB::table('product_data')
            ->select('*')
            ->where('id', $request['nominal']['id'])
            ->get()
            ->first();
        if ($prod->role_prices != null) {
            $priceByType = json_decode($prod->role_prices, true);
            $priceByType = array_filter($priceByType, function ($k) use ($akun) {
                return $k['name'] == $akun->status;
            });
            $_priceByType = null;
            foreach ($priceByType as $key => $value) {
                # code...
                $_priceByType = $value;
            }
            $price = $_priceByType ? $_priceByType['price'] : $price;
        }
        // if ($akun->status == $type->type) {
        //     $disc = $type->discount;
        //     $price = $price - ($price * ($disc / 100));
        // }
        if ($request->paymentMethod == "saldo") {
            if ($akun->balance <= $price) {
                return response()->json([
                    "success"   => false,
                    "message"   => "Saldo Anda tidak cukup: " . $akun->balance
                ]);
            }
        }
        $invoiceNumber = rand(100000, 999999);
        $kodeunik = rand(100, 999);
        for ($i = 0; $i < 5; $i++) {
            # code...
            $cekkode = DB::table('invoices')
                ->select(['fee', 'price'])
                ->where(DB::raw("(price+fee)"), '=', $price + $kodeunik)
                ->get()->first();
            if ($cekkode) {
                $kodeunik = rand(100, 999);
            } else {
                break;
            }
        }
        if ($request->paymentMethod == "saldo") {
            $kodeunik = 0;
        }
        // DB::table('invoices')->insert([
        //     'invoice_number'    => $invoiceNumber,
        //     'user'              => $akun->id,
        //     'product_data_id'   => $request['nominal']['id'],
        //     'product_data_name' => $request['nominal']['name'],
        //     'product_id'        => $request['nominal']['product_id'],
        //     'product_name'      => $request['nominal']['product_name'],
        //     'price'             => $price,
        //     'fee'               => $kodeunik,
        //     'discount'          => $disc,
        //     'user_input'        => json_encode($request->dataId),
        //     'payment_method'    => $request['paymentMethod'],
        //     'status'            => 'PENDING'
        // ]);

        $invoice_values = [
            'invoice_number'    => $invoiceNumber,
            'user'              => $akun->id,
            'product_data_id'   => $request['nominal']['id'],
            'product_data_name' => $request['nominal']['name'],
            'product_id'        => $request['nominal']['product_id'],
            'product_name'      => $request['nominal']['product_name'],
            'price'             => $price,
            'fee'               => $kodeunik,
            'discount'          => $disc,
            'user_input'        => $request->dataId ? json_encode($request->dataId) : "",
            'payment_method'    => $request['paymentMethod'],
            'status'            => 'PENDING',
            'expired_time'      => (time() + (3 * 60 * 60)), // 24 jam,
        ];
        $urlReturn = route('invoice', $invoiceNumber);
        if (str_starts_with($request['paymentMethod'], 'tripay-')) {
            $tripay_value = $this->tripay_order($request, $invoiceNumber, $price);
            $invoice_values['fee'] = $tripay_value['data']['fee_customer'];
            $invoice_values['payment_ref'] = $tripay_value['data']['reference'];
            if (str_starts_with($request['paymentMethod'], 'tripay-OVO')) {
                $urlReturn = $tripay_value['data']['pay_url'];
            }
        } elseif (str_starts_with($request['paymentMethod'], 'hitpay-')) {
            $hitpay_value = $this->hitpay_order($request, $invoiceNumber, $price);
            $invoice_values['fee'] = 0;
            $invoice_values['payment_ref'] = $hitpay_value['id'];
            $urlReturn = $hitpay_value['url'];
        } else {
            $price = $price + $kodeunik;
        }
        DB::table('invoices')->insert($invoice_values);

        $newurl = null;
        $balance = $akun->balance;
        if ($request->paymentMethod == "qris") {
            $qris = DB::table('paygate')
                ->select("*")
                ->where('payment', '=', $request->paymentMethod)
                ->get()->first();
            if ($qris) {
                $bukukas = new BukuKas;
                $newref = $bukukas->generatePaymentLink($qris->norek, $price + $kodeunik, $qris->token);
                if ($newref['data']) {
                    DB::table('invoices')
                        ->where('invoice_number', '=', $invoiceNumber)
                        ->update([
                            'payment_ref'   => $newref['data']['generatePaymentLink']['id']
                        ]);
                    $newurl = $newref['data']['generatePaymentLink']['slug'];
                }
            }
        }
        if ($request->paymentMethod == 'saldo') {
            $exactBalance = $akun->balance - $price;
            $balance = $exactBalance;
        }
        $formatted_balance = number_format($balance, 0, ".", ".");
        $product_name = $request['nominal']['product_name'];
        $product_data_name = $request['nominal']['name'];
        // $price = (int)($price + $kodeunik);
        $t = "Halo kak *$akun->name*,\n
Berikut adalah rincian pesanan Anda:
- Produk : $product_name - $product_data_name
- No.Invoice : $invoiceNumber
- Harga : Rp $price
- Metode Pembayaran : " . str_replace("tripay-", "", $request->paymentMethod) . "\n
Untuk selengkapnya silakan lihat pada link yang tertera di bawah ini.
" . route('invoice', $invoiceNumber) . "\n
Terima kasih.
*" . setting('app_name') . "*";
        //         $t = "Hai *$akun->name*,
        // Kamu berhasil melakukan pesanan, Berikut adalah detail pesanan\n
        // *Nama product*: $product_name
        // *Layanan*: $product_data_name
        // *Harga*: Rp.$price
        // *Nomor Pesanan*: $invoiceNumber\n
        // " . route('invoice', $invoiceNumber) . "

        // Simpan baik baik ya. Silahkan tunggu proses top upnya\nTunggu informasi promo menarik " . setting('app_name') . "!";
        error_log("KIRIM KE USER");
        dispatch(new WhatsappSender($akun->number, $t));
        $t = "*[NOTIFIKASI | Pesanan]*
        *Username :* $akun->username
        *Invoice :* $invoiceNumber
        *Product Name :* $product_name
        *Product Data Name :* $product_data_name
        *Price :* Rp.$price
        *Payment Method :* $request->paymentMethod
        *Balance Sisa :* Rp.$akun->balance
        *Balance Sekarang :* Rp.$formatted_balance
        *User Input:*\n";
        $jobj = json_encode($request->dataId);
        $jarr = json_decode($jobj, true);
        if ($jarr) {
            for ($i = 0; $i < count($jarr); $i++) {
                # code...
                $t .= " - *" . $jarr[$i]['name'] . "*: " . $jarr[$i]['value'] . "\n";
            }
        }
        //$this->sendWhatsapp(str_replace("@g.us", '', setting('wagroup')), $t, "g.us");
        dispatch(new WhatsappSender(str_replace("@g.us", '', setting('wagroup')), $t, "g.us"));
        if ($request->paymentMethod == "saldo") {
            $inv = DB::table('invoices')
                ->select()
                ->where("invoice_number", '=', $invoiceNumber)
                ->get()->first();
            DB::table('users')->where('id', $akun->id)->update([
                'balance' => $exactBalance
            ]);
            $idSmileAuto = DB::table('auto_order_acc')->select('product_id')->where('account', 'smile')->get()->first();
            $idKiosGamerAuto = DB::table('auto_order_acc')->select('product_id')->where('account', 'kiosgamer')->get()->first();
            $idKiosGamerAutoCodm = DB::table('auto_order_acc')->select('product_id')->where('account', 'kiosgamercodm')->get()->first();
            $idKiosgamerAutoAov = DB::table('auto_order_acc')->select('product_id')->where('account', 'kiosgameraov')->get()->first();
            $idKiosgamerAutoFt = DB::table('auto_order_acc')->select('product_id')->where('account', 'kiosgamerft')->get()->first();
            $product_data = DB::table('product_data')
                ->select()
                ->where('id', $request['nominal']['id'])
                ->get()->first();
            // update sold product
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
            if (($idSmileAuto) && ($request['nominal']['product_id'] == $idSmileAuto->product_id)) {
                $product_data = DB::table('product_data')
                    ->select()
                    ->where('id', $request['nominal']['id'])
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
                dispatch(new SmileOrderJob($inv->invoice_number, $datas, $akun->number));
                DB::table('invoices')
                    ->where("invoice_number", "=", $invoiceNumber)
                    ->update([
                        "status"    => "DONE"
                    ]);
            } elseif (($idKiosGamerAuto) && ($request['nominal']['product_id'] == $idKiosGamerAuto->product_id)) { // Free fire
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
                dispatch(new KiosGamerOrderJob($inv->invoice_number, $datas,  $akun->number));
            } elseif (($idKiosGamerAutoCodm) && ($request['nominal']['product_id'] == $idKiosGamerAutoCodm->product_id)) { // Call Of Duty Mobile
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
                dispatch(new KiosGamerOrderJob($inv->invoice_number, $datas, $akun->number));
            } elseif (($idKiosgamerAutoAov) && ($request['nominal']['product_id'] == $idKiosgamerAutoAov->product_id)) {
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
                dispatch(new KiosGamerOrderJob($inv->invoice_number, $datas, $akun->number));
            } elseif (($idKiosgamerAutoFt) && ($request['nominal']['product_id'] == $idKiosgamerAutoFt->product_id)) {
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
                dispatch(new KiosGamerOrderJob($inv->invoice_number, $datas, $akun->number));
            } elseif ($product_data->type_data == "voucher") {
                $voucher_data = DB::table('voucher_data')->select()
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
                    *Purchased by*: $akun->number
                    *Voucher left*: $sisa
                    *Description*: $voucher_data->description";
                    dispatch(new WhatsappSender(str_replace("@g.us", '', setting('wagroup')), $t, "g.us"));
                    $t = "Halo kak,\n
Berikut adalah rincian pesanan Anda:
- Produk: $product_name - $product_data_name
- Nomor Invoice: $invoiceNumber
- Harga: Rp $price
- Metode Pembayaran: " . setting('app_name') . " E-Wallet\n
Berikut adalah rincian produk  $product_name - $product_data_name:
- Data:
$voucher_data->data
- Syarat dan Ketentuan:
Silakan Anda lihat pada link yang tertera di bawah ini.
" . route('invoice', $inv->invoice_number) . "\n
Terima kasih.
*" . setting('app_name') . "*";
                    //                     $t = "Hai $akun->number,
                    // Kamu berhasil membeli Voucher $product_data->name untuk product $product_name.
                    // Berikut adalah vouchernya: ```$voucher_data->data```
                    // " . strip_tags($voucher_data->description);
                    dispatch(new WhatsappSender($akun->number, $t));
                    DB::table('invoices')
                        ->where("invoice_number", "=", $invoiceNumber)
                        ->update([
                            "status"    => "DONE"
                        ]);
                } else {
                    $t = "Halo kak,\n
Berikut adalah rincian pesanan Anda:
- Produk: $product_name - $product_data_name
- Nomor Invoice: $invoiceNumber
- Harga: Rp $price
- Metode Pembayaran: " . setting('app_name') . " E-Wallet\n
" . route('invoice', $invoiceNumber) . "\n
Untuk saat ini ketersediaan $product_name - $product_data_name baru saja kosong.
Pesanan anda akan segera diproses segera mungkin. Maksimal 1x24 jam.
Anda juga dapat melihat detail pesanan anda di menu *Cek Invoice* pada website.
Dan Anda akan segera dihubungi oleh pihak kami jika proses sudah berhasil/terdapat kendala.
Mohon ditunggu. Terima kasih.\n
*" . setting('app_name') . "*";
                    //                     $t = "Hai $akun->number,
                    // Untuk saat ini stok $product_data->name untuk product $inv->product_name sedang habis.
                    // Anda akan segera di hubungi oleh admin. Mohon ditunggu.
                    // " . setting('app_name');
                    dispatch(new WhatsappSender($akun->number, $t));
                }
            } else {

                DB::table('invoices')
                    ->where("invoice_number", "=", $invoiceNumber)
                    ->update([
                        "status"    => "PAID"
                    ]);
                $t = "Halo kak,\n
Berikut adalah rincian pesanan Anda:
- Produk: $product_name - $product_data_name
- Nomor Invoice: $invoiceNumber
- Harga: Rp $price
- Metode Pembayaran: " . setting('app_name') . " E-Wallet\n
" . route('invoice', $invoiceNumber) . "\n
Pesanan anda akan segera diproses mohon ditunggu ya kak.\n
Terima kasih,
*" . setting('app_name') . "*";
                dispatch(new WhatsappSender($akun->number, $t));
            }
        }
        return response()->json([
            'success'    => true,
            'message'   => $urlReturn //route('invoice', $invoiceNumber)
        ]);
    }
}
