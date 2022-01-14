<?php

namespace App\Logic\Curl;

use DOMDocument;
use DOMXPath;

class SmileOne
{
    public function __construct()
    {
        # code...

    }
    function getStr($string, $start, $end)
    {
        @$str = explode($start, $string);
        @$str = explode($end, $str[1]);
        return @$str[0];
    }
    function lokasi()
    {
        $base = rawurldecode($_SERVER["HTTP_HOST"] . $_SERVER["PHP_SELF"]);
        $base = str_replace(' ', '%20', $base);
        $pecah = explode('/', $base);
        $hitung = substr_count($base, "/");
        $folder = str_replace($pecah[$hitung], '', $base);
        $lokasi = 'http://' . $folder;
        return $lokasi; //bisa $lokasi / $base
    }
    function curl($link)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $link);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__) . "/cookie.txt");
        curl_setopt($ch, CURLOPT_COOKIEFILE, dirname(__FILE__) . "/cookie.txt");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }

    public function cekSaldo()
    {
        # code...
        $link = "https://www.smile.one/customer/account";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $link);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__) . "/cookie.txt");
        curl_setopt($ch, CURLOPT_COOKIEFILE, dirname(__FILE__) . "/cookie.txt");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $resp = curl_exec($ch);
        // echo "$resp";
        curl_close($ch);
        $dom = new DOMDocument();
        @$dom->loadHTML($resp);
        $finder = new DOMXPath($dom);
        $saldoTxt = $finder->query('//span[contains(@class,"baland-tit")]//i[2]');
        $saldo = "";
        foreach ($saldoTxt as $ctx) {
            $saldo = $ctx->textContent;
        }
        $nickTxt = $finder->query('//*[@id="Nickname"]/@value');
        if ($nickTxt[0]) {
            $nickname = $nickTxt[0]->nodeValue;
            $resp = [
                "success" => true,
                "saldo" => number_format($saldo, 0),
                "balance" => (float)$saldo,
                "nickname" => $nickname
            ];
            return json_decode(json_encode($resp), true);
        } else {
            $resp = [
                "success"  => false
            ];
            return json_decode(json_encode($resp), true);
        }
    }

    function curl_cek_saldo()
    {
        $link = "https://www.smile.one/customer/account";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $link);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__) . "/cookie.txt");
        curl_setopt($ch, CURLOPT_COOKIEFILE, dirname(__FILE__) . "/cookie.txt");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $response = curl_exec($ch);
        //echo "$response";
        curl_close($ch);
        $pecah = explode('<span class="baland-tit">', $response);
        $final_table = explode("</span>", $pecah[1]);
        $data = $final_table[0];

        $hasil = $data;
        return $hasil;
    }
    function curl_cek_login($phpsid)
    {

        $link = "https://www.smile.one/customer/account";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $link);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__) . "/cookie.txt");
        curl_setopt($ch, CURLOPT_COOKIEFILE, dirname(__FILE__) . "/cookie.txt");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $response = curl_exec($ch);
        // echo "$response";
        curl_close($ch);
        $hasil = 'error';
        // check if cookie.txt exist
        $log = file_get_contents(dirname(__FILE__) . "/cookie.txt");
        preg_match_all('/PHPSESSID.([^\s]{0,200})/', $log, $phpsids);
        $old_phpsid = $phpsids[1][0];
        if ($old_phpsid != $phpsid) {
            //ubah value
            // print_r($phpsid);
            $ubah = str_replace($old_phpsid, $phpsid, $log);
            // echo "NEW: $ubah<hr>";
            //ubah cookie
            $log = fopen(dirname(__FILE__) . "/cookie.txt", "w+");
            fwrite($log, ($ubah));
            fclose($log);
        }
        if (preg_match("/nickname/", $response)) {
            $hasil = 'ok';
        } else {
            $hasil = 'error';
        }
        return $hasil;
    }
    function curl_headers($link, $headers, $post)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $link);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__) . "/cookie.txt");
        curl_setopt($ch, CURLOPT_COOKIEFILE, dirname(__FILE__) . "/cookie.txt");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $response = curl_exec($ch);
        curl_close($ch);
    }
    function create_phpsid($phpsid)
    {
        $file_dummy = dirname(__FILE__) . '/cookie_dummy.txt';
        $file_cookie = dirname(__FILE__) . '/cookie.txt';

        if (!copy($file_dummy, $file_cookie)) {
            echo "copy gagal";
        }

        $file_cookie = "cookie.txt";
        $lokasi = $this->lokasi();
        $curl = $this->curl("$lokasi/$file_cookie");
        //echo "OLD: $curl<hr>";
        preg_match_all('/PHPSESSID.([^\s]{0,200})/', $curl, $phpsids);
        $old_phpsid = $phpsids[1][0];
        //ubah value
        $ubah = str_replace($old_phpsid, $phpsid, $curl);
        //echo "NEW: $ubah<hr>";
        //ubah cookie
        $log = fopen("./$file_cookie", "w+");
        fwrite($log, ($ubah));
        fclose($log);
        return 'ok';
    }
    //daftar harga
    function kode_paket($string)
    {
        if ($string == '1') {
            $paket = '13'; //paket rs 5,00
        } else if ($string == '2') {
            $paket = '23'; //paket rs 10,00
        } else if ($string == '3') {
            $paket = '25'; //paket rs 15,00
        } else if ($string == '4') {
            $paket = '26'; //paket rs 40,00
        } else if ($string == '5') {
            $paket = '27'; //paket rs 120,00
        } else if ($string == '6') {
            $paket = '28'; //paket rs 200,00
        } else if ($string == '7') {
            $paket = '29'; //paket rs 300,00
        } else if ($string == '8') {
            $paket = '30'; //paket rs 500,00
        } else if ($string == '9') {
            $paket = '32'; //paket rs 33,00 membro estrela
        } else if ($string == '10') {
            $paket = '33'; //paket rs 33,00 passagem do crepusculo
        } else if ($string == '11') {
            $paket = '34'; //paket rs 75
        } else if ($string == '86') {
            $paket = '13'; //paket rs 5,00
        } else if ($string == '172') {
            $paket = '23'; //paket rs 10,00
        } else if ($string == '257') {
            $paket = '25'; //paket rs 15,00
        } else if ($string == '706') {
            $paket = '26'; //paket rs 40,00
        } else if ($string == '2195') {
            $paket = '27'; //paket rs 120,00
        } else if ($string == '3688') {
            $paket = '28'; //paket rs 200,00
        } else if ($string == '5532') {
            $paket = '29'; //paket rs 300,00
        } else if ($string == '9288') {
            $paket = '30'; //paket rs 500,00
        } else if ($string == 'starlight') {
            $paket = '32'; //paket rs 33,00 membro estrela
        } else if ($string == 'twilight') {
            $paket = '33'; //paket rs 33,00 passagem do crepusculo
        } else if ($string == 'starlightplus') {
            $paket = '34'; //paket rs 75
        }
        return $paket;
    }
    //payment
    function curl_payment($id_game, $id_zone, $paket)
    {
        $curl_ambil_csrf = $this->curl("https://www.smile.one/merchant/mobilelegends?source=other");
        $token_csrf = $this->getStr($curl_ambil_csrf, '_csrf" value="', '"');
        //
        $resp = ["success" => false];
        $headers[] = "accept: application/json, text/javascript, */*; q=0.01";
        $headers[] = "accept-language: en-US,en;q=0.9";
        $headers[] = "content-type: application/x-www-form-urlencoded; charset=UTF-8";
        $headers[] = "origin: https://www.smile.one";
        $headers[] = "referer: https://www.smile.one/merchant/mobilelegends?source=other";
        $headers[] = "sec-fetch-dest: empty";
        $headers[] = "sec-fetch-mode: cors";
        $headers[] = "sec-fetch-site: same-origin";
        $headers[] = "user-agent: Mozilla/5.0 (iPad; CPU OS 11_0 like Mac OS X) AppleWebKit/604.1.34 (KHTML, like Gecko) Version/11.0 Mobile/15A5341f Safari/604.1";
        $headers[] = "x-requested-with: XMLHttpRequest";
        $kode_paket = $this->kode_paket($paket);
        $post = "user_id=$id_game&zone_id=$id_zone&pid=$kode_paket&checkrole=&pay_methond=smilecoin"; //pay smilecoin
        $link = "https://www.smile.one/merchant/mobilelegends/checkrole/";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $link);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__) . "/cookie.txt");
        curl_setopt($ch, CURLOPT_COOKIEFILE, dirname(__FILE__) . "/cookie.txt");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $response = curl_exec($ch);
        curl_close($ch);
        echo "RESPON checkrole: $response<hr>";
        //ambil flowid
        $js = json_decode($response, true);
        $resp['ign'] = $js['username'];
        $resp['amount'] = $paket;
        //print_r($js);
        $flow_id = $js['flowid'];
        //
        //unset($headers);
        $headers[] = "accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9";
        $headers[] = "accept-language: en-US,en;q=0.9";
        $headers[] = "cache-control: max-age=0";
        $headers[] = "content-type: application/x-www-form-urlencoded";
        $headers[] = "origin: https://www.smile.one";
        $headers[] = "referer: https://www.smile.one/merchant/mobilelegends?source=other";
        $headers[] = "sec-fetch-dest: document";
        $headers[] = "sec-fetch-mode: navigate";
        $headers[] = "sec-fetch-site: same-origin";
        $headers[] = "sec-fetch-user: ?1";
        $headers[] = "upgrade-insecure-requests: 1";
        $headers[] = "user-agent: Mozilla/5.0 (iPad; CPU OS 11_0 like Mac OS X) AppleWebKit/604.1.34 (KHTML, like Gecko) Version/11.0 Mobile/15A5341f Safari/604.1";

        $post = "_csrf=$token_csrf&user_id=$id_game&zone_id=$id_zone&pay_methond=smilecoin&product_id=$kode_paket&flowid=$flow_id";
        $link = "https://www.smile.one/merchant/mobilelegends/pay";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $link);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__) . "/cookie.txt");
        curl_setopt($ch, CURLOPT_COOKIEFILE, dirname(__FILE__) . "/cookie.txt");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $response = curl_exec($ch);
        $status = curl_getinfo($ch);
        $status = $status['http_code'];
        curl_close($ch);
        //cek berhasil
        if (preg_match("/success/i", $response)) {
            $hasil = 'berhasil';
            $resp['success'] = true;
            $resp['message'] = $hasil;
        } else {
            $hasil = 'gagal';
            $resp['success'] = false;
            $resp['message'] = $hasil;
            $resp['err'] = "Insufficient balance";
        }
        //echo "QUERY pay: $post<hr>";
        //echo "RESPON pay: $response<hr>";
        //echo "HASIL: $hasil<hr>";
        //return $status;
        return json_decode(json_encode($resp), true);
    }
}
