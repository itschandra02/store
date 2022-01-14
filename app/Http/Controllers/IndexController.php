<?php

namespace App\Http\Controllers;

use App\Jobs\WhatsappSender;
use App\Logic\Curl\BukuKas;
use DOMXPath;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;

class IndexController extends Controller
{
    //
    public function index(Request $request)
    {
        # code...
        $products = DB::table('products')
            ->select('*')
            ->orderBy("ordered")
            ->get();
        $carousel = DB::table('carousels')
            ->select('*')
            ->where('active', true)
            ->get();
        $categories = DB::table('categories')
            ->orderBy("categories.ordered")->get();
        error_log(print_r($categories, true));
        return view('index')
            ->with([
                'products'  => $products,
                'carousels' => $carousel,
                'categories' => $categories
            ]);
    }
    public function search_page(Request $request)
    {
        # code...
        return view('search');
    }
    public function status_page(Request $request)
    {
        # code...
        return view('status');
    }
    public function order_page($slug, Request $request)
    {
        # code...
        if (is_numeric($slug)) {
            $product = DB::table('products')->select("*")->where('id', $slug)->get()->first();
        } else {
            $product = DB::table('products')->select("*")->Where('slug', $slug)->get()->first();
        }
        if ($product) {
            // if (!$product->active){
            //     return response()->redirect()
            // }
            if ($product->active == false) {
                # code...
                return abort(404);
            }
            $formData = null;
            if ($product->use_input) {
                $formData = DB::table('form_inputs')->select('*')
                    ->where('product_id', '=', $product->id)
                    ->get();
            }
            $product_data = DB::table('product_data')
                ->select("*")
                ->where('product_id', $product->id)
                ->orderBy("ordered")
                ->get();
            $user = null;
            if ($request->session()->has('loggedIn')) {
                $user = DB::table('users')->select('username', 'status')->where('username', $request->session()->get('username'))->get()->first();
            }
            $paygate = DB::table('paygate')
                ->select(['payment', 'image', 'status'])
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
                if ($_req == null || $_req['success'] == false) {
                    $_req = null;
                }
            }
            $hitpay = DB::table('paygate')
                ->select(['payment', 'image', 'username', 'token'])->where('payment', 'hitpay')
                ->get()->first();
            $hitpay_req = null;
            if ($hitpay) {
                // $_req = Http::get("https://api.hitpay.co.id/api/merchant/payment-channel")->json();
                // error_log(json_encode($_req));
                // if ($_req == null || $_req['success'] == false) {
                //     $_req = null;
                // }
                $hitpay_req = [
                    "payment_methods" => [
                        [
                            "code" => "paynow_online",
                            "name" => "Pay Now Online",
                            "images" => ["https://abs.org.sg/images/default-album/abs-logo28f7a99f299c69658b7dff00006ed795.png"]
                        ],
                        [
                            "code"  => "card",
                            "name"  => "Card (Visa, Master, American Express)",
                            "images" => [
                                "https://upload.wikimedia.org/wikipedia/commons/thumb/5/5e/Visa_Inc._logo.svg/2560px-Visa_Inc._logo.svg.png",
                                asset('assets/img/logos/master-card.png'),
                            ]
                        ],
                        [
                            "code"  => "grabpay",
                            "name"  => "GrabPay",
                            "images" => [
                                "https://www.pedagangnusantara.net/wp-content/uploads/2019/12/grabpay.png"
                            ]
                        ]
                    ],
                ];
            }
            $toyyibpay = DB::table('paygate')
                ->select(['payment', 'image', 'username', 'token'])->where('payment', 'toyyibpay')
                ->get()->first();
            $toyyibpay_req = null;
            if ($toyyibpay) {
                $toyyibpay_req = Http::get("https://toyyibpay.com/index.php/api/getBank")->json();
                error_log(json_encode($toyyibpay_req));
                if ($toyyibpay_req == null ) {
                    $toyyibpay_req = null;
                }
            }
            return view('order')->with([
                'product' => $product,
                'product_data' => $product_data,
                'formData' => $formData,
                'paygate'   => $paygate,
                'tripay'    => $_req,
                'hitpay'    => $hitpay_req,
                'toyyibpay' => $toyyibpay_req,
                'user'      => $user
            ]);
        } else {
            abort(404);
        }
    }
    public function invoice_page(Request $request)
    {
        # code...
        if (!$request->id) {
            abort(404);
        }
        $invoice = DB::table('invoices')
            ->select('*')
            ->where('invoice_number', $request->id)
            ->get()->first();
        if (!$invoice) {
            return abort(404);
        }
        $product_data = DB::table('product_data')->select()->where('id', $invoice->product_data_id)->get()->first();
        $voucher = null;
        if ($product_data) {
            if ($product_data->type_data == "voucher") {
                $voucher = DB::table('voucher_data')->select()->where('purchased', $invoice->invoice_number)->get()->first();
            }
        }
        $paygate = DB::table('paygate')
            ->select('*')
            ->where('payment', '=', $invoice->payment_method)
            ->get()->first();
        $qr = null;
        $tripay = null;
        $hitpay = null;
        if ($invoice->payment_method == 'qris') {
            $paygate = DB::table('paygate')
                ->select('*')
                ->where('payment', '=', 'qris')
                ->get()->first();
            if ($invoice->status != "EXPIRED" && $invoice->status != "DONE") {
                $bukukas = new BukuKas;
                $qrisdata = $bukukas->getPaymentList($paygate->norek, $paygate->token);
                $url = null;
                foreach ($qrisdata['data']['paymentLinksList']['paymentLinks'] as $key => $value) {
                    # code...
                    if ($value['id'] == $invoice->payment_ref) {
                        $url = 'https://api.beecash.io/' . $value['slug'];
                        break;
                    }
                }
                $r = Http::get($url);
                $dom = new \DomDocument();
                libxml_use_internal_errors(true);
                $dom->loadHTML($r, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
                $finder = new DOMXPath($dom);
                $classname = "qr-code";
                $nodes = $finder->query("//*[contains(@class, '$classname')]/svg");
                $htmlstring = $dom->saveHTML($nodes->item(0));
                $qr = $htmlstring;
            }
        } elseif (str_starts_with($invoice->payment_method, "tripay-")) {
            $pgTripay = DB::table('paygate')
                ->select('*')
                ->where('payment', '=', 'tripay')
                ->get()->first();
            $resp = Http::withHeaders([
                'Authorization' => "Bearer " . $pgTripay->username
            ])->get("https://tripay.co.id/api/transaction/detail", ["reference" => $invoice->payment_ref]);
            $tripay = $resp->json();
            error_log(json_encode($tripay));
        } elseif (str_starts_with($invoice->payment_method, "hitpay-")) {
            $pgHitpay = DB::table('paygate')->select('password as salt', 'token as apikey')->where('payment', 'hitpay')->first();
            $hitpay = Http::withHeaders([
                'X-BUSINESS-API-KEY' => $pgHitpay->apikey,
                'X-Requested-With'   => 'XMLHttpRequest'
            ])->get("https://api.sandbox.hit-pay.com/v1/payment-requests/" . $invoice->payment_ref);
            $hitpay = $hitpay->json();
            error_log(json_encode($hitpay));
        }
        return view('invoice', [
            'invoice'   => $invoice,
            'qr'        => $qr,
            'paygate'   => $paygate,
            'tripay'    => $tripay,
            'voucher'   => $voucher,
            'hitpay'    => $hitpay
        ]);
    }
    public function dashboard_page(Request $request)
    {
        # code...
        if (!$request->session()->has('loggedIn')) {
            return redirect()->to('login');
        }
        $user = DB::table('users')
            ->select('*')
            ->where('id', '=', session('userid'))
            ->get()
            ->first();
        $invoices = DB::table('invoices')
            ->select('*')
            ->where('user', '=', $user->id)
            ->limit(10)
            ->orderByDesc('created_at')
            ->get();

        $expireSeller = DB::table('users')
            ->select('expire_seller_at')
            ->where('username', $request->session()->get('username'))
            ->where('balance', '<', 500000)
            ->where('status', 'reseller')
            ->get()
            ->first();
        $totalTransactions = DB::table('invoices')
            ->select(DB::raw('SUM((price+fee))AS tot_price'), DB::raw("count(price+fee)tot_trans"))
            ->where('user', $user->id)->where('status', "DONE")->get()->first();
        return view('dashboard')->with([
            'user'  =>  $user,
            'invoices'  => $invoices,
            'expireSeller' => $expireSeller,
            'totalTransactions' => $totalTransactions
        ]);
    }

    public function settings_page(Request $request)
    {
        # code...
        if (!$request->session()->has('loggedIn')) {
            return redirect()->to('login');
        }
        $user = DB::table('users')
            ->select('*')
            ->where('id', '=', session('userid'))
            ->get()
            ->first();
        return view('settings')->with([
            'user'  => $user
        ]);
    }
    public function settings_edit(Request $request)
    {
        # code...
        if (!$request->session()->has('loggedIn')) {
            return redirect()->to('login');
        }
        $ava = $request->file('avatar');
        if ($ava) {
            $ext = $ava->getClientOriginalExtension();
            $filename = Str::random(5) . "." . $ext;
            $ava->move(public_path() . "/assets/images/profile", $filename);
            $avaPath = asset("assets/images/profile/$filename");
            if (setting('server_img')) {
                $avaPath = $this->uploadMedia(public_path() . "/assets/images/profile/$filename");
                unlink(public_path() . "/assets/img/profile/$filename");
            }
            // $avaPath = $this->uploadMedia(public_path() . "/assets/images/profile/$filename");
            DB::table('users')
                ->where('id', "=", session('userid'))
                ->update([
                    "avatar"    => $avaPath
                ]);
        }
        DB::table('users')
            ->where('id', "=", session('userid'))
            ->update([
                "name"  => $request->name,
                "username"  => $request->username,
                "email" => $request->email,
                "number"    => $request->number,
            ]);
        if ($request->password) {
            DB::table('users')->where('id', session('userid'))
                ->update([
                    "password"  => Hash::make($request->password)
                ]);
        }
        $value = [
            'title' =>  'Login',
            'text'  =>  "Success edit profile",
            'type'  =>  'success'
        ];
        session()->flash('flash', json_encode($value));
        // return redirect()->route('dashboard');
        return response()->json([
            'sucess' => true
        ]);
    }

    public function tac_page(Request $request)
    {
        # code...
        return view('tac');
    }
    public function privacy_page(Request $request)
    {
        # code...
        return view('privacy_policy');
    }
    public function harga_page(Request $request)
    {
        # code...
        $data = DB::table('products')
            ->select([
                'id', 'name',
            ])->get();
        return view('harga', [
            'products' => $data
        ]);
    }
    public function contact_page(Request $request)
    {
        # code...
        return view('contact-us');
    }
    public function contact_send(Request $request)
    {
        # code...
        $type = $request->type;
        $imageUrl = "";
        $t = [
            "*[Notification | CONTACT]*",
            "Username: *$request->username*",
            "Type: *$request->typeValue*",
            "Whatsapp: *$request->phonenum*"
        ];
        if ($type == "payment") {
            array_push(
                $t,
                "Invoice Number: *$request->invoiceNumber*"
            );
            if ($request->file('attachment')) {

                $validated = $request->validate([
                    'attachment' => 'mimes:png,jpeg,jpg,gif,svg|max:2048',
                ]);
                if (!$validated) {
                    $value = [
                        'title' =>  'Contact Us',
                        'text'  =>  "Failed to send message",
                        'type'  =>  'error'
                    ];
                    session()->flash('flash', json_encode($value));
                    return redirect()->route('contact-us');
                }
                $attachment = $request->file('attachment');
                $namaFile = $attachment->getClientOriginalName();
                $namaFile = time() . $namaFile;
                $img = Image::make($attachment);
                $img->resize(600, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->encode('jpg')->save(public_path() . "/assets/img/$namaFile");
                // $imageUrl = $this->uploadMedia(public_path("assets/img/" . $namaFile));
                $imageUrl = asset("assets/img/$namaFile"); //public_path("assets/img/" . $namaFile);
                if (setting('server_img')) {
                    $imageUrl = $this->uploadMedia(public_path() . "/assets/img/$namaFile");
                    unlink(public_path() . "/assets/img/$namaFile");
                }
                array_push(
                    $t,
                    "Screenshot: *$imageUrl*"
                );
            }
        } elseif ($type == "masalah") {
            # code...
            array_push(
                $t,
                "Invoice Number: *$request->invoiceNumber*"
            );
        }
        array_push(
            $t,
            "Description:\n```$request->description```"
        );
        $this->sendWhatsapp(str_replace("@g.us", '', setting('wagroup')), join("\r\n", $t), 'g.us');
        // dispatch(new WhatsappSender(str_replace("@g.us", '', setting('wagroup')), join("\r\n", $t), 'g.us'));
        return response()->json([
            "success" => true
        ]);
    }
    public function harga_list(Request $request)
    {
        # code...
        if (!$request->id) {
            $data = DB::table('product_data')
                ->select([
                    'product_data.name', 'price',
                    'products.name as product_name', 'product_data.updated_at'
                ])
                ->leftJoin("products", 'product_data.product_id', '=', 'products.id')
                ->get();
        } else {
            $data = DB::table('product_data')
                ->select([
                    'product_data.name', 'price',
                    'products.name as product_name', 'product_data.updated_at'
                ])
                ->leftJoin("products", 'product_data.product_id', '=', 'products.id')
                ->where('product_data.product_id', '=', $request->id)
                ->get();
        }
        return response()->json($data);
    }
}
