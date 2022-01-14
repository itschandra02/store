<?php

namespace App\Http\Controllers;

use App\Jobs\WhatsappSender;
use App\Logic\Curl\BukuKas;
use Illuminate\Database\Eloquent\JsonEncodingException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\URL;

class TopupController extends Controller
{
    //
    public function index(Request $request)
    {
        # code..
        if (!$request->session()->has('loggedIn')) {
            return redirect()->to('login');
        }
        $priceList = array(
            300000, 500000, 800000, 1000000
        );
        $paygate = DB::table('paygate')
            ->select(['payment', 'image'])
            ->get();

        $tripay = DB::table('paygate')
            ->select(['payment', 'image', 'username', 'token'])->where('payment', 'tripay')
            ->get()->first();
        $_req = null;
        if ($tripay) {
            $_req = Http::withHeaders([
                'Authorization' => "Bearer $tripay->username"
            ])->get("https://tripay.co.id/api/merchant/payment-channel")->json();
            error_log(json_encode($_req));
        }
        return view('topup', [
            "priceList" => $priceList,
            "paygate"   => $paygate,
            'tripay'    => $_req
        ]);
    }
    public function verification(Request $request)
    {
        # code...
        $inputs = $request->all();
        $akun = DB::table('users')->select("*")->where('username', $request->session()->get('username'))->get()->first();
        $invoiceNumber = rand(100000, 999999);
        $merchantRef = $invoiceNumber;
        $amount = $inputs['price'];
        $kodeUnik = rand(100, 999);
        for ($i = 0; $i < 5; $i++) {
            # code...
            $cekkode = DB::table('invoices')
                ->select(['fee', 'price'])
                ->where(DB::raw("(price+fee)"), '=', $amount + $kodeUnik)
                ->get()->first();
            if ($cekkode) {
                $kodeUnik = rand(100, 999);
            } else {
                break;
            }
        }
        $data = [
            'method'            => $inputs['payMethod'],
            'merchant_ref'      => $merchantRef,
            'amount'            => $amount,
            'customer_name'     => $akun->name,
            'customer_email'    => $akun->email,
            'customer_phone'    => $akun->number,
            'order_items'       => [
                [
                    'sku'       => "TOPUP$amount",
                    'name'      => "Top Up $amount",
                    'price'     => $amount,
                    'quantity'  => 1
                ]
            ],
        ];

        $invoice_values = [
            'invoice_number'    => $invoiceNumber,
            'user'              => $akun->id,
            'product_data_id'   => 151,
            'product_data_name' => $data['order_items'][0]['sku'],
            'product_id'        => 152,
            'product_name'      => $data['order_items'][0]['name'],
            'price'             => $amount,
            'fee'               => $kodeUnik, //$resp['data']['fee'],
            'discount'          => 0,
            'user_input'        => '',
            'payment_method'    => $data['method'],
            'status'            => "PENDING"
        ];
        $urlReturn = route('invoice', $invoiceNumber);
        if (str_starts_with($request['payMethod'], 'tripay-')) {
            $tripay_value = $this->tripay_order($request, $invoiceNumber, $amount);
            $invoice_values['fee'] = $tripay_value['data']['fee_customer'];
            $invoice_values['payment_ref'] = $tripay_value['data']['reference'];
            if(str_starts_with($request['paymentMethod'],'tripay-OVO')){
                $urlReturn = $tripay_value['data']['pay_url'];
            }
            $price = $tripay_value['data']['amount'];
        }  elseif (str_starts_with($request['paymentMethod'], 'hitpay-')) {
            $hitpay_value = $this->hitpay_order($request, $invoiceNumber, $amount);
            $invoice_values['fee'] = 0;
            $invoice_values['payment_ref'] = $hitpay_value['id'];
            $urlReturn = $hitpay_value['url'];
        } else {
            $amount = $amount + $kodeUnik;
        }
        DB::table('invoices')->insert($invoice_values);
        // if ($request->payMethod == "qris") {
        //     $qris = DB::table('paygate')
        //         ->select("*")
        //         ->where('payment', '=', $inputs['payMethod'])
        //         ->get()->first();
        //     if ($qris) {
        //         $bukukas = new BukuKas;
        //         $newref = $bukukas->generatePaymentLink($qris->norek, $amount + $kodeUnik, $qris->token);
        //         if ($newref['data']) {
        //             DB::table('invoices')
        //                 ->where('invoice_number', '=', $invoiceNumber)
        //                 ->update([
        //                     'payment_ref'   => $newref['data']['generatePaymentLink']['id']
        //                 ]);
        //             $newurl = $newref['data']['generatePaymentLink']['slug'];
        //         }
        //     }
        // }
        $product_name = $data['order_items'][0]['name'];
        $product_data_name = $data['order_items'][0]['sku'];
        $t = "Tagihan Pembayaran Pesanan #$invoiceNumber\n
        Halo kak $akun->name,\n
        Berikut adalah rincian pesanan Anda:
        - Produk: $product_name - $product_data_name. (x1)
        - Nomor Invoice: $invoiceNumber
        - Harga: Rp $amount
        - Metode Pembayaran: " . str_replace("tripay-", "", $request['payMethod']) . "\n
        Untuk selengkapnya silakan lihat pada link yang tertera di bawah ini.
        " . route('invoice', $invoiceNumber) . "\n
        Terima kasih,
        *" . setting('app_name') . "*";
       // dispatch(new WhatsappSender($akun->number, $t));
        return response()->json([
            'success'    => true,
            'message'   => $urlReturn//route('invoice', $invoiceNumber)
        ]);
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

    public function tripay_order(Request $request, $invoiceNumber, $price)
    {
        # code...
        $pgTripay = DB::table('paygate')->select()->where('payment', 'tripay')->get()->first();
        $user = null;
        error_log($request->session()->get('username'));
        if ($request->session()->get('username') != null) {
            $_user = DB::table('users')->select()->where("username", $request->session()->get('username'))->get()->first();
            $user = [
                "name"  => $_user->username,
                "email" => $_user->email,
                "number" => $_user->number
            ];
        }
        $data = [
            'method'            => str_replace("tripay-", "", $request['payMethod']),
            'merchant_ref'      => $invoiceNumber,
            'amount'            => (int)$price,
            'customer_name'     => $user['name'],
            'customer_email'    => $user['email'],
            'customer_phone'    => $user['number'],
            'order_items'       => [
                [
                    'sku'       => "TOPUP$price",
                    'name'      => "Top Up $price",
                    'price'     => $price,
                    'quantity'  => 1
                ]
            ],
            'callback_url'      => route('api.callback.payment.tripay'),
            'return_url'        => route('invoice', $invoiceNumber),
            'expired_time'      => (time() + (24 * 60 * 60)), // 24 jam,
            'signature'         => hash_hmac('sha256', $pgTripay->norek . $invoiceNumber . (int)$price, $pgTripay->token)
        ];
        $resp = Http::withHeaders([
            'Authorization' => "Bearer " . $pgTripay->username
        ])->post("https://tripay.co.id/api/transaction/create", $data)->json();
        error_log(json_encode($resp));
        return $resp;
    }
}
