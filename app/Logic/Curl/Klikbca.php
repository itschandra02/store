<?php

namespace App\Logic\Curl;

define('URL_LOGIN', 'https://ibank.klikbca.com/authentication.do');
define('URL_SALDO', 'https://ibank.klikbca.com/balanceinquiry.do');
define('URL_MUTASI_INDEX', 'https://ibank.klikbca.com/accountstmt.do?value(actions)=acct_stmt');
define('URL_MUTASI_VIEW', 'https://ibank.klikbca.com/accountstmt.do?value(actions)=acctstmtview');
define('URL_MUTASI_DOWNLOAD', 'https://ibank.klikbca.com/stmtdownload.do?value(actions)=account_statement');

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Klikbca
{
    public $ch = null;
    public $ip = '';
    public $last_html = '';
    public $logged_in = false;

    public $password = ''; //use Database
    public $username = ''; //use Database
    public function construct__($ip)
    {
        $this->ip = $ip;
    }

    public function setlogin($user, $pass)
    {
        $this->password = $pass;
        $this->username = $user;
    }

    function klikbca_()
    {
        $this->ip = $_SERVER['REMOTE_ADDR'];
        $this->logged_in = false;
        // 
    }
    function read_bca()
    {
        $res = DB::table('mutation')
            ->select("*")
            ->where('bank', 'bca')
            ->get();
        return json_encode($res);
    }
    function view_mutasi()
    {
        if ($this->logged_in == false) {
        }
        $res = $this->my_curl_get(URL_MUTASI_VIEW);
        $this->last_html = $res['response'];
        preg_match_all('/color=\"\#0000bb\"\>([ ]+)?([0-9\,]+)/i', $res['response'], $match);
        //echo '<pre>';print_r($match);echo '</pre>';
        return true;
    }
    function login()
    {
        $this->logged_in = false;

        $today = Carbon::now();
        $lastm = Carbon::now()->subDays(30);
        $data = array(
            'value(actions)' => 'login',
            'value(user_id)' => $this->username,
            'value(user_ip)' => $this->ip,
            'value(pswd)' => $this->password,
            'value(Submit)' => 'LOGIN',
            'value(D1)' => '0',
            'value(r1)' => '1',
            'value(startDt)' => $lastm->day . '',
            'value(startMt)' => $lastm->month . '',
            'value(startYr)' => $lastm->year . '',
            'value(endDt)' => $today->day . '',
            'value(endMt)' => $today->month . '',
            'value(endYr)' => $lastm->year . '',
            'value(fDt)' => '',
            'value(tDt)' => '',
            'value(submit1)' => 'View+Account+Statement'
        );
        $data = http_build_query($data);
        $res = $this->my_curl_post(URL_LOGIN, $data);
        $this->last_html = $res['response'];
        if (preg_match('/value\(user_id\)/i', $res['response'])) {
            //trigger_error('CAN NOT LOGIN TO KLIKBCA (5 MIN.)', E_USER_WARNING);
            return false;
        }
        $this->logged_in = true;

        return true;
    }

    function my_curl_close()
    {
        if ($this->ch != false) {
            curl_close($this->ch);
        }
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

    function my_curl_open()
    {
        $this->ch = curl_init();
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->ch, CURLOPT_AUTOREFERER, true);
        @curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($this->ch, CURLOPT_MAXREDIRS, 2);
        curl_setopt($this->ch, CURLOPT_COOKIEFILE, dirname(__FILE__) . '/curl-cookie.txt');
        curl_setopt($this->ch, CURLOPT_COOKIEJAR, dirname(__FILE__) . '/curl-cookie.txt');
        curl_setopt($this->ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36"); //$_SERVER['HTTP_USER_AGENT']);
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
