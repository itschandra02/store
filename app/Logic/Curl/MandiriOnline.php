<?php

namespace App\Logic\Curl;

define('URL_LOGIN', 'https://ibank.klikbca.com/authentication.do');
define('URL_SALDO', 'https://ibank.klikbca.com/balanceinquiry.do');
define('URL_MUTASI_INDEX', 'https://ibank.klikbca.com/accountstmt.do?value(actions)=acct_stmt');
define('URL_MUTASI_VIEW', 'https://ibank.klikbca.com/accountstmt.do?value(actions)=acctstmtview');
define('URL_MUTASI_DOWNLOAD', 'https://ibank.klikbca.com/stmtdownload.do?value(actions)=account_statement');

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MandiriOnline
{
    public $ch = null;
    public function construct__($ip)
    {
    }
    function my_curl_open()
    {
        # code...
        $this->ch = curl_init();
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->ch, CURLOPT_AUTOREFERER, true);
        @curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($this->ch, CURLOPT_MAXREDIRS, 2);
        curl_setopt($this->ch, CURLOPT_COOKIEFILE, dirname(__FILE__) . '/curl-mandiri-cookie.txt');
        curl_setopt($this->ch, CURLOPT_COOKIEJAR, dirname(__FILE__) . '/curl-mandiri-cookie.txt');
        curl_setopt($this->ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36"); //$_SERVER['HTTP_USER_AGENT']);
    }

    function my_curl_get($url, $ref = '')
    {
        if ($this->ch == null) {
            $this->my_curl_open();
        }
        $ssl = false;
        if (preg_match('/^https/i', $url)) {
            $ssl = true;
        }

        if ($ssl) {
            curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, false);
        }

        if ($ref == '') {
            $ref = $url;
        }

        curl_setopt($this->ch, CURLOPT_URL, $url);
        curl_setopt($this->ch, CURLOPT_REFERER, $ref);
        $res = curl_exec($this->ch);
        $info = curl_getinfo($this->ch);

        return array(
            'response' => trim($res),
            'info' => $info
        );
    }

    function my_curl_post($url, $post_data, $ref = '')
    {
        if ($this->ch == null) {
            $this->my_curl_open();
        }
        $ssl = false;
        if (preg_match('/^https/i', $url)) {
            $ssl = true;
        }
        if ($ssl) {
            curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, false);
        }
        if ($ref == '') {
            $ref = $url;
        }

        curl_setopt($this->ch, CURLOPT_URL, $url);
        curl_setopt($this->ch, CURLOPT_REFERER, $ref);
        curl_setopt($this->ch, CURLOPT_POST, 1);
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, $post_data);
        $res = curl_exec($this->ch);
        $info = curl_getinfo($this->ch);

        return array(
            'response' => trim($res),
            'info' => $info
        );
    }
}
