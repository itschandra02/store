<?php

use App\Jobs\WhatsappSender;
use App\Logic\Curl\BukuKas;
use App\Logic\Curl\KiosGamer;
use App\Logic\Curl\KiosGamerCodm;
use App\Logic\Curl\Klikbca;
use App\Logic\Curl\SmileOne;
use Carbon\Carbon;
use Goutte\Client;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpClient\HttpClient;
use GuzzleHttp\Client as GuzzleHttp;
use Illuminate\Support\Facades\Hash;
use OTPHP\HOTP;
/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('hotp', function () {
    $otp = HOTP::create('TWZI7RVJX275YL72');
    $this->comment($otp->at(Carbon::now()->timestamp / 180));
})->purpose('Display an inspiring quote');

Artisan::command('smile', function () {
    $smile = new SmileOne();
    $acc = DB::table('auto_order_acc')->select()->where('account', 'smile')->get()->first();
    if (!$acc) {
        return false;
    }
    $smile->curl_cek_login($acc->cookie);
    $curl_cek_saldo = $smile->cekSaldo();
    // $angkasaldo = preg_replace("/[^0-9\.]/", "", $curl_cek_saldo);
    // $saldo = $angkasaldo;
    if ($curl_cek_saldo != NULL) {
        print_r($curl_cek_saldo);
        DB::table('auto_order_acc')->where('account', 'smile')->update(['last_balance' => str_replace(',', '', $curl_cek_saldo['saldo'])]);
    } else {
        dispatch(new WhatsappSender(str_replace("@g.us", '', setting('wagroup')), "*[ NOTIFIKASI SMILEONE ]*\nPHPSESSID revoked!", 'g.us'));
    }
});
Artisan::command('kiosgamercheck', function () {
    $data = DB::table('auto_order_acc')
        ->select()->where('account', 'kiosgamer')
        ->get()->first();
    if (!$data) {
        return false;
    }
    $kiosgamer = new KiosGamer("");
    $loginID = $kiosgamer->Login("4079848840");
    $data = $kiosgamer->LoginGarena($data->username, $data->password, $data->token);
    if (isset($data['error'])) {
        DB::table('auto_order_acc')->where('account', 'kiosgamer')->update([
            'token' => null
        ]);
        $data = DB::table('auto_order_acc')
            ->select()->where('account', 'kiosgamer')
            ->get()->first();
        $data = $kiosgamer->LoginGarena($data->username, $data->password, $data->token);
        dispatch(new WhatsappSender(str_replace("@g.us", '', setting('wagroup')), "*[ NOTIFIKASI KIOSGAMER ]*\nSession key kiosgamer revoked!", 'g.us'));
    }
    DB::table('auto_order_acc')->where('account', 'like', 'kiosgamer%')->update([
        'token' => $data['session_key'],
        'last_balance'=>$data['shell_balance']
    ]);
    $this->comment(json_encode($data));
    // dispatch(new WhatsappSender(str_replace("@g.us", '', setting('wagroup')), "*[ NOTIFIKASI KIOSGAMER ]*\nUsername: " . $data["username"] .  "\nUID: " . $data["uid"] . "\nBalance: " . $data["shell_balance"] . "\nSession Key: " . $data['session_key'] . "", 'g.us'));
});

// Artisan::command('kiosgamercodmcheck', function () {
//     $data = DB::table('auto_order_acc')
//         ->select()->where('account', 'kiosgamercodm')
//         ->get()->first();
//     if (!$data) {
//         return false;
//     }
//     $kiosgamer = new KiosGamerCodm("");
//     $loginID = $kiosgamer->Login("6740385566860608233");
//     $data = $kiosgamer->LoginGarena($data->username, $data->password, $data->token);
//     if (isset($data['error'])) {
//         DB::table('auto_order_acc')->where('account', 'kiosgamercodm')->update([
//             'token' => null
//         ]);
//         $data = DB::table('auto_order_acc')
//             ->select()->where('account', 'kiosgamercodm')
//             ->get()->first();
//         $data = $kiosgamer->LoginGarena($data->username, $data->password, $data->token);
//         dispatch(new WhatsappSender(str_replace("@g.us", '', setting('wagroup')), "*[ NOTIFIKASI KIOSGAMER CODM ]*\nSession key kiosgamer revoked!", 'g.us'));
//     }
//     DB::table('auto_order_acc')->where('account', 'kiosgamercodm')->update([
//         'token' => $data['session_key']
//     ]);
//     $this->comment(json_encode($data));
//     // dispatch(new WhatsappSender(str_replace("@g.us", '', setting('wagroup')), "*[ NOTIFIKASI KIOSGAMER CODM ]*\nUsername: " . $data["username"] .  "\nUID: " . $data["uid"] . "\nBalance: " . $data["shell_balance"] . "\nSession Key: " . $data['session_key'] . "", 'g.us'));
// });

Artisan::command('smiletest', function () {
    // $smile = new SmileOne();
    // $smile->curl_cek_login("35r5ad18rnd4vpojgh0k63677o");
    // $curl_cek_saldo = $smile->cekSaldo();
    // $payment = $smile->curl_payment("30723382",'2043','86');
    // $angkasaldo = preg_replace("/[^0-9\.]/", "", $curl_cek_saldo);
    // $saldo = $angkasaldo;
    // print_r(setting('anticaptcha'));
    // $json = '[{"name":"Juar","Sex":"Male","ID":"1100"},{"name":"Maria","Sex":"Female","ID":"2513"},{"name":"Pedro","Sex":"Male","ID":"2211"}]';
    // $array = json_decode($json, 1);
    // $ID = "Maria";
    // $expected = array_filter($array, function ($var) use ($ID) {
    //     if (strpos($var['name'], $ID) !== false) {
    //         echo $var['name'];
    //         return true;
    //     }
    // });
    // foreach ($expected as $key => $value) {
    //     # code...
    //     print_r($value);
    // }
    $akun = DB::table('users')
        ->select("*")
        ->where("username", "=", "arisawali2014")
        ->get()->first();
    $prod = DB::table('product_data')
        ->select('*')
        ->where('id', 1)
        ->get()
        ->first();
    $price = $prod->price;
    error_log($price);
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
        // $price = $priceByType['price'];
    }
    print_r($_priceByType);
});

Artisan::command('ff', function () {
    $req = Http::withHeaders([
        // "content-type" => "application/x-www-form-urlencoded; charset=UTF-8",
        // "origin" => "https://www.lapakgaming.com",
        // "user-agent" => "Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1",
        "X-Requested-With" => "XMLHttpRequest"
    ])->asForm()->post("https://www.lapakgaming.com/game/ajax/user-check.php", [
        "category" => "FF",
        "target" => "4079848840"
    ]);
    error_log($req->status());
    $this->comment($req->body());
    $this->comment(json_encode($req->json()));
});
Artisan::command('codm', function () {
    $req = Http::withHeaders([
        // "content-type" => "application/x-www-form-urlencoded; charset=UTF-8",
        // "origin" => "https://www.lapakgaming.com",
        // "user-agent" => "Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1",
        "X-Requested-With" => "XMLHttpRequest"
    ])->asForm()->post("https://api.duniagames.co.id/api/transaction/v1/top-up/inquiry/store", [
        "catalogId" => 144,
        "gameId" => "8370310025568788107",
        "itemId" => 88,
        "paymentId" => 1527,
        "productId" => 18,
        "product_ref" => "CMS",
        "product_ref_denom" => "REG"
    ]);
    error_log($req->status());
    $this->comment($req->body());
    $this->comment(json_encode($req->json()['data']['gameDetail']));
});
Artisan::command('higgs', function () {
    $req = Http::withHeaders([
        // "content-type" => "application/x-www-form-urlencoded; charset=UTF-8",
        // "origin" => "https://www.lapakgaming.com",
        // "user-agent" => "Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1",
        "X-Requested-With" => "XMLHttpRequest"
    ])->asForm()->post("https://api.duniagames.co.id/api/transaction/v1/top-up/inquiry/store", [
        "catalogId" => 442,
        "gameId" => "63923550",
        "itemId" => 416,
        "paymentId" => 1611,
        "productId" => 61,
        "product_ref" => "REG",
        "product_ref_denom" => "AE"
    ]);
    error_log($req->status());
    $this->comment(json_encode($req->json()['data']['gameDetail']));
});

Artisan::command('testarr', function () {
    $arr = [
        "token" => "abacs"
    ];
    $this->comment(json_encode($arr));
    $arr["test"] = "knon";
    // $arr = array_merge($arr, [
    //     "token" => "test lagi",
    //     "data"  => "abc",
    //     "abc"   => []
    // ]);
    // // $this->comment(json_encode($newar));
    // $arr['abc']  = [
    //     "test"  => "oke"
    // ];
    $this->comment(json_encode($arr));
});

Artisan::command('testcrawl', function () {
    $r = Http::get('https://api.beecash.io/132a36');
    $dom = new \DomDocument();
    libxml_use_internal_errors(true);
    $dom->loadHTML($r, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
    $finder = new DomXPath($dom);
    $classname = "qr-code";
    $nodes = $finder->query("//*[contains(@class, '$classname')]/svg");
    $htmlstring = $dom->saveHTML($nodes->item(0));
    print_r($htmlstring);
});

Artisan::command('saldo', function () {
    $this->comment(Hash::make("ari123"));
});

Artisan::command('testmutasi', function () {
    $result[] = [
        "mutationDate" => "2021-05-17",
        "mutationNote" => "KARTU DEBIT 12- 05; IDM TNHF-PADAULUN-6019007507897487",
        "mutationStatus" => "CR",
        "mutationAmount" => 13391
    ];
    $_data = [
        "type"  => "bca",
        "data"  => $result
    ];
    $req = Http::post('http://127.0.0.1:8000/api/callback/mutation', $_data);
    // $req = Http::post('https://aristore.herokuapp.com/api/callback/mutation', $_data);
    $this->comment(route('api.callback.mutation'));
    $this->comment(json_encode($req->json()));
});
Artisan::command('cekjs', function () {
    $jss = '{"status":"success","data":{"orders":[{"id":75019011,"server":2219,"amount":172,"idx":0},{"id":75019011,"server":2219,"amount":172,"idx":1}],"successfulOrders":[{"id":75019011,"server":2219,"amount":172,"idx":0},{"id":75019011,"server":2219,"amount":172,"idx":1}],"failedOrders":[],"message":"","speed":"76.702 sec"}}';
    $jed = json_decode($jss, true);
    foreach ($jed['data']['successfulOrders'] as $key => $value) {
        # code...
        $this->comment(json_encode($value));
    }
});
Artisan::command('sosis', function () {

    $url = "https://xdg-hk.xd.com/api/v1/user/get_role";
    $resp = Http::get($url, [
        "client_id" => "zuRsHFfcY2KtVql3",
        "server_id" => "global-release",
        "character_id" => "7yisre"
    ]);
    $respJ = $resp->json();
    $this->comment(json_encode($respJ));
});
Artisan::command('cekbalance', function () {
    $account = [
        "type" => "vk",
        "username" => "6282172257901",
        "password" => "AsdgF32!"
    ];
    $data = [
        [
            "id" => 30723382,
            "server" => 2043,
            "amount" => 9288 // see on smile.ts
        ],
    ];
    $req = Http::post('https://ari-smile.herokuapp.com/smile/order', [
        "account"   => $account,
        "data"      => $data
    ])->json();
    $this->comment(json_encode($req));
});

Artisan::command('ceksaldo', function () {
    $account = [
        "type"  => "vk",
        "username"  => "6285155060559",
        "password"  => "arivk123123"
    ];
    $data = [
        [
            "id" => 30723382,
            "server" => 2043,
            "amount" => 9288 // see on smile.ts
        ],
    ];
    $req = Http::get('http://localhost:4444/smile/check', $account)->json();
    // $req = Http::get(setting('autoapi') . '/smile/check', $account)->json();
    $this->comment(json_encode($req));
});
function uploadMedia($file, $type = 'image')
{
    # code...
    error_log($file);
    $args = ['file' => curl_file_create($file, $type == 'image' ? 'image/png' : 'video/mp4')];
    error_log(json_encode($args));
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL                => 'https://telegra.ph/upload',
        CURLOPT_POST            => 1,
        CURLOPT_POSTFIELDS        => $args,
        CURLOPT_TIMEOUT            => 2,
        CURLOPT_RETURNTRANSFER    => 1
    ]);
    $res = curl_exec($curl);
    $res = json_decode(
        $res,
        true
    );
    error_log(json_encode($res));
    // $this->comment(json_encode($res));
    if (isset($res[0]['src'])) {
        // $this->comment('https://telegra.ph' . $res[0]['src']);
        return 'https://telegra.ph' . $res[0]['src'];
    }
}
Artisan::command('telegraph', function () {
    // $body = fopen('C:\\xampp\\htdocs\\ari_store\\public\\assets\\img\\screenshot.jpeg', 'r');
    // $resp = Http::withHeaders([
    //     'origin' => 'https://telegra.ph',
    //     'referer' => 'https://telegra.ph'
    // ])->attach(
    //     'file',
    //     $body,
    //     'freefire.png'
    // )->post('http://telegra.ph/upload')->json();
    // $this->comment(json_encode($resp));
    // $resp = Http::post('https://telegra.ph/upload', ['file' => $body]);
    // $args = ['file' => curl_file_create("C:\\xampp\\htdocs\\ari_store\\public\\assets\\img\\screenshot.jpeg", 'image/jpeg')];
    // $this->curl = curl_init();
    // curl_setopt_array($this->curl, [
    //     CURLOPT_URL                => 'https://telegra.ph/upload',
    //     CURLOPT_POST            => 1,
    //     CURLOPT_POSTFIELDS        => $args,
    //     CURLOPT_TIMEOUT            => 2,
    //     CURLOPT_RETURNTRANSFER    => 1
    // ]);
    // $res = curl_exec($this->curl);
    // $res = json_decode($res, true);
    // $this->comment(json_encode($res));
    // if (isset($res[0]['src'])) {
    //     $this->comment('https://telegra.ph' . $res[0]['src']);
    //     return 'https://telegra.ph' . $res[0]['src'];
    // }
    // uploadMedia(public_path() . "\\assets\\img\\freefire.png");
    $target_url = "https://telegra.ph/upload";
    $file_name_with_full_path = public_path() . "\\assets\\img\\freefire.png";
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
    $result = curl_exec($ch);
    curl_close($ch);
});

Artisan::command('mutasi', function () {
    $this->comment('Helloooo');
    $ip = "103.228.117.218";
    $bca = new Klikbca($ip);
    // $bca = new Klikbca($ip);
    // $bca->setlogin("wahyunis8431", "889889");
    $rekbca = DB::table('paygate')
        ->select('username', 'password')
        ->where('payment', 'bca')
        ->get()->first();
    if (!$rekbca) {
        return $this->error('bca not added');
    }
    $bca->setlogin($rekbca->username, $rekbca->password);
    $res  = $bca->login();

    if ($res == false) {
        //echo $bca->last_html;
        return $this->comment($bca->read_bca());
        // return $this->error("Error login");
    }
    $res = $bca->view_mutasi();

    if ($res != false) {
        $data_grab = $bca->last_html;
    }

    //$data_grab = $this->testdata();

    $data_grab = str_replace('\r\n', "", $data_grab);
    $data_grab = trim(preg_replace('/\s+/', ' ', $data_grab));
    //BUAT TANGGAL
    $data_grab = str_replace(' width="30" bgcolor="#e0e0e0"><div align="left"> <font face="verdana" size="1" color="#0000bb"', "", $data_grab);
    $data_grab = str_replace(' width="30" bgcolor="#f0f0f0"><div align="left"> <font face="verdana" size="1" color="#0000bb"', "", $data_grab);

    //BUAT KETERANGAN
    $data_grab = str_replace(' width="130" bgcolor="#f0f0f0"><div align="left"> <font face="verdana" size="1" color="#0000bb"', "", $data_grab);
    $data_grab = str_replace(' width="130" bgcolor="#e0e0e0"><div align="left"> <font face="verdana" size="1" color="#0000bb"', "", $data_grab);


    //BUAT CODE TENGAH
    $data_grab = str_replace(' width="30" bgcolor="#e0e0e0"><div align="center"> <font face="verdana" size="1" color="#0000bb"', "", $data_grab);
    $data_grab = str_replace(' width="30" bgcolor="#f0f0f0"><div align="center"> <font face="verdana" size="1" color="#0000bb"', "", $data_grab);


    //BUAT MUTASI GANTI SALDO
    $data_grab = str_replace(' width="" bgcolor="#f0f0f0"><div align="right"> <font face="verdana" size="1" color="#0000bb"', "", $data_grab);
    $data_grab = str_replace(' width="30" bgcolor="#f0f0f0"><div align="center"> <font face="verdana" size="1" color="#0000bb"', "", $data_grab);

    //BUAT CR / DB
    $data_grab = str_replace(' width="" bgcolor="#e0e0e0"><div align="right"> <font face="verdana" size="1" color="#0000bb"', "", $data_grab);
    $data_grab = str_replace(' width="10" bgcolor="#f0f0f0"><div align="right"> <font face="verdana" size="1" color="#0000bb"', "", $data_grab);


    //BUAT TOTAL SALDO
    $data_grab = str_replace(' width="10" bgcolor="#f0f0f0"><div align="right"> <font face="verdana" size="1" color="#0000bb"', "", $data_grab);
    $data_grab = str_replace(' width="10" bgcolor="#e0e0e0"><div align="right"> <font face="verdana" size="1" color="#0000bb"', "", $data_grab);

    //BUAT ILANGIN KURUNG TUTUP

    $data_grab = str_replace('</font></div></td>', "", $data_grab);
    $data_grab = str_replace(' </tr> ', "", $data_grab);
    $data_grab = str_replace(' <br>', "; ", $data_grab);
    $data_grab = str_replace('<br>', "; ", $data_grab);
    $data_grab = str_replace('  ', " ", $data_grab);
    $data_grab = str_replace('</table> </td></tr>', "", $data_grab);
    $data_grab = str_replace('/', "- ", $data_grab);


    $data = explode('<tr>', $data_grab);
    $result = array();
    $today = Carbon::now();
    for ($i = 0; $i < count($data); $i++) {
        if (is_numeric(substr($data[$i], -1))) {
            $input = explode(' <td> ', $data[$i]);
            array_splice($input, 0, 1);
            array_splice($input, 2, 1);
            array_splice($input, 4, 1);
            $input[2] = intval(str_replace(',', '', str_replace('.00', '', $input[2])));
            if ($input[0] != 'PEND') {
                $inputyear = $today->year;
                if ($today->month == 1) {
                    if (substr($input[0], -2) == '12' || substr($input[0], -2) == '11') {
                        $inputyear = $today->year - 1;
                    }
                }
                $input[0] = $inputyear . '-' . substr($input[0], -2) . '-' . substr($input[0], 0, 2);
            } else {
                $input[0] = $today->year . '-' . $today->month . '-' . $today->day;
            }

            // if ($input[3] != "CR");
            if (is_string(strstr($input[1], "BUNGA")));
            else {
                $result[] = [
                    "mutationDate" => date("Y-m-d", strtotime($input[0])),
                    "mutationNote" => $input[1],
                    "mutationStatus" => $input[3],
                    "mutationAmount" => $input[2]
                ];
                DB::table('mutation')
                    ->updateOrInsert([
                        "mutationAmount"    => $input[2],
                        "mutationStatus"    => $input[3],
                        "mutationStatus" => $input[3],
                        "mutationDate"      => date("Y-m-d", strtotime($input[0]))
                    ], [
                        "bank"  => 'bca',
                        "mutationDate"  => date("Y-m-d", strtotime($input[0])),
                        "mutationNote"  => $input[1],
                        "mutationStatus" => $input[3],
                        "mutationAmount" => $input[2],
                        "updated_at"    => DB::raw('now()')
                    ]);
            }
        }
    }
    $_data = [
        "type"  => "bca",
        "data"  => $result
    ];
    $req = Http::post(route('api.callback.mutation'), $_data);
    $this->comment(json_encode($result, JSON_PRETTY_PRINT));
})->purpose("Cek mutasi BCA TESTING");
