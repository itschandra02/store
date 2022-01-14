<?php

namespace App\Logic\Curl;

/**
 * KiosGamer unofficial API for payment Freefire
 * Author by: Ari Sawali.
 */

class KiosGamer
{
    public $open_id = null;
    public $ch = null;
    public $antiCaptcha = null;
    public $app_id = null;
    public $gameid = null;
    public $gameproduct = null;
    public $packed_role_id = null;
    public $randomIP = null;
    public  $gameName = null;
    public function __construct($antiCaptcha = "", $game = "ff")
    {
        # code...
        $this->ch = curl_init();
        $this->antiCaptcha = $antiCaptcha;
        $this->gameid = [
            "ff"    => [
                "app_id" => 100067,
                "packed_role_id" => 0,
                "name" => "Freefire",
                "product_ids" => [
                    "5"                 => 8,
                    "20"                => 9,
                    "50"                => 10,
                    "70"                => 1,
                    "140"               => 2,
                    "355"               => 3,
                    "720"               => 4,
                    "2000"              => 5,
                    "membermingguan"    => 6,
                    "memberbulanan"     => 7,
                    "7290"              => 11,
                    "36500"             => 12,
                    "73100"             => 13,
                ]
            ],
            "codm"  => [
                "app_id" => 100082,
                "packed_role_id" => 65536,
                "name" => "Call of duty Mobile",
                "product_ids" => [
                    "53"        => 1,
                    "112"       => 2,
                    "278"       => 3,
                    "580"       => 4,
                    "1268"      => 5,
                    "1901"      => 6,
                    "3300"      => 7,
                    "7128"      => 8,
                ]
            ],
            "aov"   => [
                "app_id" => 100057,
                "packed_role_id" => 786432,
                "name" => "Arena of Valor",
                "product_ids" => [
                    "40"        => 1,
                    "90"        => 2,
                    "230"       => 3,
                    "470"       => 4,
                    "950"       => 5,
                    "1430"      => 6,
                    "2390"      => 7,
                    "4800"      => 8,
                    "24050"     => 9,
                    "48200"     => 10
                ]
            ],
            "fantasytown"   => [
                "app_id"    => 100095,
                "packed_role_id" => 0,
                "name"      => "Fantasy Town",
                "product_ids" => [
                    "22"    => 1,
                    "46"    => 2,
                    "117"   => 3,
                    "235"   => 4,
                    "475"   => 5,
                    "720"   => 6,
                    "1210"  => 7,
                    "2440"  => 8,
                    "12200" => 9,
                    "24400" => 10,
                ]
            ]
        ];
        $this->gameName = $this->gameid[$game]["name"];
        $this->app_id = $this->gameid[$game]["app_id"];
        $this->gameproduct = $this->gameid[$game]["product_ids"];
        $this->randomIP = $this->getRandomIP();
        $this->dataDome = $this->datadomeTest("https://kiosgamer.co.id/api/auth/player_id_login");
        $this->packed_role_id = $this->gameid[$game]["packed_role_id"];
    }
    public function getHeaders($array)
    {
        $headers = array();
        foreach ($array as $key => $value) {
            $headers[] = $key . ": " . $value;
        }
        return $headers;
    }
    public function getRandomIP()
    {
        $ip = "";
        for ($i = 0; $i < 4; $i++) {
            $ip .= mt_rand(0, 255) . ".";
        }
        $ip = substr($ip, 0, -1);
        return $ip;
    }

    public function datadomeTest($url)
    {
        $data = [
            "jsData" => '{"plg":0,"plgod":false,"plgne":"NA","plgre":"NA","plgof":"NA","plggt":"NA","pltod":false,"br_h":667,"br_w":375,"br_oh":667,"br_ow":375,"jsf":false,"cvs":null,"phe":false,"nm":false,"sln":null,"lo":true,"lb":true,"mp_cx":null,"mp_cy":null,"mp_mx":null,"mp_my":null,"mp_sx":null,"mp_sy":null,"mp_tr":null,"mm_md":null,"hc":4,"rs_h":667,"rs_w":375,"rs_cd":24,"ua":"Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1","lg":"id-ID","pr":2,"ars_h":667,"ars_w":375,"tz":-420,"tzp":null,"str_ss":true,"str_ls":true,"str_idb":true,"str_odb":true,"abk":null,"ts_mtp":1,"ts_tec":true,"ts_tsa":true,"so":"portrait-primary","wo":null,"sz":null,"wbd":false,"wbdm":true,"wdif":false,"wdifts":false,"wdifrm":false,"wdw":true,"prm":null,"lgs":true,"lgsod":false,"usb":null,"vnd":"Google Inc.","bid":"NA","mmt":"empty","plu":"empty","hdn":false,"awe":false,"geb":false,"dat":false,"eva":33,"med":"defined","ocpt":false,"aco":"probably","acmp":"probably","acw":"probably","acma":"maybe","acaa":"probably","ac3":"","acf":"probably","acmp4":"maybe","acmp3":"probably","acwm":"maybe","acots":false,"acmpts":true,"acwts":false,"acmats":false,"acaats":true,"ac3ts":false,"acfts":false,"acmp4ts":false,"acmp3ts":false,"acwmts":false,"vco":"probably","vch":"probably","vcw":"probably","vc3":"maybe","vcmp":"","vcq":"","vc1":"probably","vcots":false,"vchts":true,"vcwts":true,"vc3ts":false,"vcmpts":false,"vcqts":false,"vc1ts":false,"glrd":null,"glvd":null,"cfpp":null,"cfcpw":null,"cffpw":null,"cffrb":null,"cfpfe":null,"stcfp":null,"dvm":8,"sqt":false,"bgav":true,"rri":true,"idfr":true,"ancs":true,"inlc":true,"cgca":true,"inlf":true,"tecd":true,"sbct":true,"aflt":true,"rgp":true,"bint":true,"xr":true,"vpbq":true,"svde":false,"slat":null,"spwn":false,"emt":false,"bfr":false,"ttst":12.59999942779541,"ewsi":null,"wwsi":null,"slmk":null,"dbov":false,"ifov":false,"hcovdr":false,"plovdr":false,"ftsovdr":false,"hcovdr2":false,"plovdr2":false,"ftsovdr2":false,"cokys":"bG9hZFRpbWVzY3NpYXBwcnVudGltZQ==L=","tagpu":null,"tbce":0,"ecpc":false,"bcda":false,"idn":true,"capi":false,"nddc":2,"nclad":null,"haent":null,"dcok":".kiosgamer.co.id"}',
            "events" => '[{"source":{"x":98,"y":268},"message":"touch start","date":1638261220667,"id":3},{"source":{"x":89,"y":271},"message":"touch move","date":1638261220680,"id":5},{"source":{"x":0,"y":0},"message":"scroll","date":1638261220682,"id":2},{"source":{"x":0,"y":274},"message":"touch move","date":1638261220784,"id":5},{"source":{"x":0,"y":273},"message":"touch end","date":1638261220801,"id":4},{"source":{"x":0,"y":0},"message":"scroll","date":1638261220815,"id":2},{"source":{"x":0,"y":0},"message":"scroll","date":1638261220915,"id":2},{"source":{"x":118,"y":369},"message":"touch start","date":1638261221154,"id":3},{"source":{"x":111,"y":374},"message":"touch move","date":1638261221200,"id":5},{"source":{"x":0,"y":0},"message":"scroll","date":1638261221214,"id":2},{"source":{"x":80,"y":385},"message":"touch end","date":1638261221282,"id":4},{"source":{"x":0,"y":0},"message":"scroll","date":1638261221314,"id":2},{"source":{"x":136,"y":429},"message":"touch start","date":1638261221700,"id":3},{"source":{"x":136,"y":429},"message":"touch end","date":1638261221801,"id":4},{"source":{"x":136,"y":429},"message":"mouse move","date":1638261221801,"id":0},{"source":{"x":136,"y":429},"message":"mouse click","date":1638261221802,"id":1},{"source":{"x":0,"y":0},"message":"key down","date":1638261222177,"id":7},{"source":{"x":0,"y":0},"message":"key up","date":1638261222393,"id":8},{"source":{"x":0,"y":0},"message":"key up","date":1638261223184,"id":8},{"source":{"x":83,"y":447},"message":"touch start","date":1638261225850,"id":3},{"source":{"x":70,"y":451},"message":"touch move","date":1638261225922,"id":5},{"source":{"x":0,"y":0},"message":"scroll","date":1638261225924,"id":2},{"source":{"x":0,"y":459},"message":"touch move","date":1638261226047,"id":5},{"source":{"x":0,"y":459},"message":"touch end","date":1638261226069,"id":4},{"source":{"x":0,"y":0},"message":"scroll","date":1638261226079,"id":2},{"source":{"x":0,"y":0},"message":"scroll","date":1638261226180,"id":2},{"source":{"x":100,"y":429},"message":"touch start","date":1638261227130,"id":3},{"source":{"x":100,"y":429},"message":"touch end","date":1638261227248,"id":4},{"source":{"x":100,"y":429},"message":"mouse move","date":1638261227249,"id":0},{"source":{"x":100,"y":429},"message":"mouse click","date":1638261227249,"id":1},{"source":{"x":100,"y":429},"message":"touch start","date":1638261227549,"id":3},{"source":{"x":100,"y":429},"message":"touch end","date":1638261227641,"id":4},{"source":{"x":100,"y":429},"message":"mouse move","date":1638261227641,"id":0},{"source":{"x":100,"y":429},"message":"mouse click","date":1638261227642,"id":1},{"source":{"x":0,"y":0},"message":"key down","date":1638261227780,"id":7},{"source":{"x":0,"y":0},"message":"key down","date":1638261227937,"id":7},{"source":{"x":0,"y":0},"message":"key up","date":1638261228105,"id":8},{"source":{"x":0,"y":0},"message":"key down","date":1638261228581,"id":7},{"source":{"x":0,"y":0},"message":"key up","date":1638261228632,"id":8},{"source":{"x":0,"y":0},"message":"key down","date":1638261228785,"id":7}]',
            "eventCounters" => '{"mouse move":3,"mouse click":3,"scroll":8,"touch start":6,"touch end":6,"touch move":5,"key press":0,"key down":5,"key up":4}',
            "jsType" => "le",
            "cid" => "7wjS722f1LrDsyaQa9pBI2nWnmLK8ksSQvrb.ojDP83oOy~..jUPYAdXD7I823mKpXqXARYE8tBZzFr98tq3KQlH9JgTLC.XkWk~zt5U1X",
            "ddk" => "A513A9E66F1AD6FB8D0C1D9D9264A3",
            "Referer" => $url,
            "request" => parse_url($url, PHP_URL_PATH),
            "responsePage" => "origin",
            "ddv" => "4.1.71"
        ];
        $data = http_build_query($data);
        $req = $this->request("POST", "https://api-js.datadome.co/js/", $data, [
            "Content-Type" => "application/x-www-form-urlencoded",
            // "User-Agent" => "Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1",
        ]);
        $clientIds = explode(";", $req['cookie']);
        $clientId = null;
        foreach ($clientIds as $id) {
            if (strpos($id, "datadome") !== false) {
                $clientId = $id;
                break;
            }
        }
        $clientId = explode("=", $clientId)[1];
        return ["cookies" => $req['cookie'], "clientId" => $clientId];
    }

    public function ReqOnly($method, $url, $data = null, $headers = [])
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
    public function request($method, $url, $data = null, $headers = array(), $csrf = null)
    {

        // $ch = curl_init();
        if ($this->ch == null) {
            $this->ch = curl_init();
        }
        if (!is_null($data)) {
            $this->randomIP = $this->getRandomIP();
            curl_setopt($this->ch, CURLOPT_POSTFIELDS, is_array($data) ? json_encode($data) : $data);
            if (is_array($data)) {
                $headers[] = 'Connection: keep-alive';
                $headers[] = 'Sec-Ch-Ua: \" Not A;Brand\";v=\"99\", \"Chromium\";v=\"96\", \"Google Chrome\";v=\"96\"';
                $headers[] = 'Accept: application/json';
                $headers[] = 'X-Datadome-Clientid: ' . $this->dataDome['clientId'];
                $headers[] = 'Content-Type: application/json';
                $headers[] = 'Sec-Ch-Ua-Mobile: ?1';
                $headers[] = 'User-Agent: Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Mobile Safari/537.36';
                $headers[] = 'Sec-Ch-Ua-Platform: \"Android\"';
                $headers[] = 'Origin: https://kiosgamer.co.id';
                $headers[] = 'Sec-Fetch-Site: same-origin';
                $headers[] = 'Sec-Fetch-Mode: cors';
                $headers[] = 'Sec-Fetch-Dest: empty';
                $headers[] = 'X-Csrf-Token: ' . $csrf;
                $headers[] = 'Referer: https://kiosgamer.co.id/app/100067/idlogin';
                $headers[] = 'Accept-Language: en-GB,en;q=0.9,zh-MO;q=0.8,zh;q=0.7,id-ID;q=0.6,id;q=0.5,en-US;q=0.4';
                $headers[] = 'Cookie: _ga=GA1.3.1164865825.1638283705; _gid=GA1.3.2099383426.1638371139; source=pc; b.vnpopup.1=1; session_key=rxk1sw3wgxwhtbizw509wtnifc0o3b3b; datadome=' . $this->dataDome['clientId'] . '; ' . $csrf ? "__csrf__=" . $csrf : '_gat=1;';

                $headers[] = "REMOTE-ADDR: " . $this->randomIP;
                $headers[] = "X-FORWARDED-FOR: " . $this->randomIP;
            }
            // if (is_array($data)) $headers = array_merge(array(
            // 	"Accept" => "application/json",
            // 	"Content-Type" => "application/json",
            // 	"REMOTE-ADDR" => $this->randomIP,
            // 	"X-FORWARDED-FOR" => $this->randomIP
            // ), $headers);
        }
        $headerSize = 0;
        curl_setopt_array($this->ch, array(

            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_ENCODING => 'gzip, deflate',
            CURLOPT_HTTPHEADER => $headers,
            // CURLOPT_URL => $url,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_FOLLOWLOCATION => true,
            // CURLOPT_RETURNTRANSFER => true,
            CURLOPT_PROXY => false,
            CURLOPT_SSL_VERIFYPEER => false,
            // CURLOPT_USERAGENT => "Mozilla/5.0 (Linux; Android 8.0.0; Pixel 2 XL Build/OPD1.170816.004) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/94.0.4606.81 Mobile Safari/537.36 Edg/94.0.992.50",
            // CURLOPT_HTTPHEADER => $this->getHeaders($headers),
            // CURLOPT_HEADERFUNCTION =>
            // function ($curl, $header) use (&$headers, &$headerSize) {
            // 	$lenghtCurrentLine = strlen($header);
            // 	$headerSize += $lenghtCurrentLine;
            // 	$header = explode(':', $header, 2);
            // 	if (count($header) > 1) { // store only vadid headers
            // 		$headers[strtolower(trim($header[0]))][] = trim($header[1]);
            // 	}
            // 	return $lenghtCurrentLine;
            // },
            CURLOPT_HTTPAUTH, CURLAUTH_BASIC,
            CURLOPT_COOKIEFILE => dirname(__FILE__) . '/curl-cookie.txt',
            CURLOPT_COOKIEJAR => dirname(__FILE__) . '/curl-cookie.txt',
            // CURLOPT_ENCODING=> 'gzip, deflate'
        ));
        $this->response = curl_exec($this->ch);
        $this->http_code = curl_getinfo($this->ch, CURLINFO_HTTP_CODE);
        if ($result = json_decode($this->response, true)) {
            if (isset($result["data"])) $this->data = $result["data"];
            return $result;
        }
        return $this->response;
    }
    // public function request($method, $url, $data = null, $headers = array())
    // {
    //     // $ch = curl_init();
    //     if ($this->ch == null) {
    //         $this->ch = curl_init();
    //     }
    //     if (!is_null($data)) {
    //         curl_setopt($this->ch, CURLOPT_POSTFIELDS, is_array($data) ? json_encode($data) : $data);
    //         if (is_array($data)) $headers = array_merge(
    //             array(
    //                 "Accept" => "application/json",
    //                 "Content-Type" => "application/json",
    //                 "REMOTE-ADDR" => $this->randomIP,
    //                 "X-FORWARDED-FOR" => $this->randomIP
    //             ),
    //             $headers
    //         );
    //     }
    //     curl_setopt_array($this->ch, array(
    //         CURLOPT_URL => $url,
    //         CURLOPT_CUSTOMREQUEST => $method,
    //         CURLOPT_FOLLOWLOCATION => true,
    //         CURLOPT_RETURNTRANSFER => true,
    //         CURLOPT_PROXY => false,
    //         CURLOPT_SSL_VERIFYPEER => false,
    //         CURLOPT_USERAGENT => "Mozilla/5.0 (Linux; Android 8.0.0; Pixel 2 XL Build/OPD1.170816.004) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/94.0.4606.81 Mobile Safari/537.36 Edg/94.0.992.50",
    //         CURLOPT_HTTPHEADER => $this->getHeaders($headers),
    //         CURLOPT_HTTPAUTH, CURLAUTH_BASIC,
    //         CURLOPT_COOKIEFILE => dirname(__FILE__) . '/curl-kiosgamer-cookie.txt',
    //         CURLOPT_COOKIEJAR => dirname(__FILE__) . '/curl-kiosgamer-cookie.txt',
    //     ));
    //     $this->response = curl_exec($this->ch);
    //     $this->http_code = curl_getinfo($this->ch, CURLINFO_HTTP_CODE);
    //     if ($result = json_decode($this->response, true)) {
    //         if (isset($result["data"])) $this->data = $result["data"];
    //         return $result;
    //     }
    //     return $this->response;
    // }
    public function request2($method, $url, $data = null, $headers = array())
    {
        // $ch = curl_init();
        if ($this->ch == null) {
            $this->ch = curl_init();
        }
        if (!is_null($data)) {
            curl_setopt($this->ch, CURLOPT_POSTFIELDS, is_array($data) ? json_encode($data) : $data);
            if (is_array($data)) $headers = array_merge(array(
                "Accept" => "application/json",
                "Content-Type" => "application/json",
            ), $headers);
        }
        $_headers = [];
        curl_setopt_array($this->ch, array(
            CURLOPT_URL => $url,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_PROXY => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_USERAGENT => "Mozilla/5.0 (Linux; Android 8.0.0; Pixel 2 XL Build/OPD1.170816.004) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/94.0.4606.81 Mobile Safari/537.36 Edg/94.0.992.50",
            CURLOPT_HTTPHEADER => $this->getHeaders($headers),
            CURLOPT_HTTPAUTH, CURLAUTH_BASIC,
            CURLOPT_COOKIEFILE => dirname(__FILE__) . '/curl-kiosgamer-cookie.txt',
            CURLOPT_COOKIEJAR => dirname(__FILE__) . '/curl-kiosgamer-cookie.txt',
            CURLOPT_HEADERFUNCTION => function ($curl, $header) use (&$_headers) {
                $len = strlen($header);
                $header = explode(':', $header, 2);
                if (count($header) < 2) // ignore invalid headers
                    return $len;

                $_headers[strtolower(trim($header[0]))][] = trim($header[1]);

                return $len;
            }
        ));
        $this->response = curl_exec($this->ch);
        $this->http_code = curl_getinfo($this->ch);
        if ($result = json_decode($this->response, true)) {
            if (isset($result["data"])) $this->data = $result["data"];
            return ["result" => $result, "info" => $_headers];
        }
        return ["result" => $this->response, "info" => $_headers];
    }
    // Captcha
    private function get_tokenrecaptcha($websiteUrl, $websiteKey)
    {
        $createtaskid =
            $this->request(
                "POST",
                "https://api.anti-captcha.com/createTask",
                json_encode(
                    [
                        'clientKey' => $this->antiCaptcha, // "c07cd9f7cb01c4274e40ef22f0f0fc73",
                        'task' => [
                            'websiteURL' => $websiteUrl, // 'https://kiosgamer.co.id',
                            'websiteKey' => $websiteKey, // '6LfJXvoUAAAAAMrJFTEbBeWygZCCWQWbAZk_z2H0',
                            'websiteSToken' => null,
                            'recaptchaDataSValue' => null,
                            'type' => 'NoCaptchaTaskProxyless'
                        ],
                        'softId' => 802
                    ]
                )
            );
        if (empty($createtaskid['taskId'])) {
            $response['status'] = "error";
            $response['message'] = "CAN'T CREATE TASKID";
        } else {
            $taskId = $createtaskid['taskId'];
            do {
                $result =
                    $this->request(
                        "POST",
                        "https://api.anti-captcha.com/getTaskResult",
                        json_encode([
                            'clientKey' => $this->antiCaptcha, // "c07cd9f7cb01c4274e40ef22f0f0fc73",
                            'taskId' => $taskId
                        ])
                    );
                sleep(2);
            } while ($result['status'] == "processing");
            $token_recaptcha = $result['solution']['gRecaptchaResponse'];
            $response['status'] = "success";
            $response['Token_Recaptcha'] = $token_recaptcha;
        }
        return $response;
    }
    /**
     * Login ID User
     */
    public function Login($game_id = null)
    {
        if (is_null($game_id)) return false;
        $url = "https://kiosgamer.co.id/api/auth/player_id_login";
        // $dataDome = $this->datadomeTest($url);
        $result = $this->request("POST", $url, array(
            "app_id" => $this->app_id,
            "login_id" => strval($game_id)
        ));
        // if (isset($result['error']) || empty($result['open_id'])) {
        //     // print("MASUK SINI");
        //     $recaptcha = $this->get_tokenrecaptcha("https://kiosgamer.co.id", "6LfJXvoUAAAAAMrJFTEbBeWygZCCWQWbAZk_z2H0");
        //     // print_r($recaptcha);
        //     if ($recaptcha['status'] == "error") {
        //         $response['status'] = "error";
        //         $response['message'] = "recaptcha not work";
        //     } else {
        //         $result = $this->request("POST", "https://kiosgamer.co.id/api/auth/player_id_login", array(
        //             "app_id" => 100067,
        //             'recaptcha_token' => $recaptcha['Token_Recaptcha'],
        //             "login_id" => strval($game_id)
        //         ));
        //         $this->open_id = $result["open_id"];
        //         return $result;
        //     }
        error_log(json_encode($result));
        if (isset($result['error']) && $result['error'] == "error_require_recaptcha_token") {
            error_log("[{$this->app_id}] {$game_id} - {$result['error']}");
            sleep(4);
            return $this->login($game_id);
        } elseif (isset($result['error']) && $result['error'] == "invalid_id") {
            return json_decode(json_encode(array(
                "status" => false,
                "error" => "Invalid ID"
            )), true);
        } else {
            error_log("[{$this->app_id}] {$game_id} - {$result['open_id']}");
            $this->open_id = $result["open_id"];
        }


        return json_decode(json_encode($result), true);
    }


    /**
     * Auto get session_key for loginSSO. but need to get to the API using puppeteer
     * the cookie generated via javascript. and they use x-datadome-clientId (21-10-2021)
     * as bot protection. So use API with stealth puppeteer to bypass it.
     */
    public function LoginGarena($username, $password, $session_key = null)
    {
        # code...
        if ($session_key == null) {
            // Use Puppeteer API for getting sessionKey.
            // maybe in future i will make it curlly
            ini_set('max_execution_time', 180);
            error_log(setting('2captcha'));
            $sess = $this->request('GET', "http://178.128.215.233:4444/kiosgamer/login?username=$username&password=$password&captcha=" . setting('2captcha'));
            // $sess = $this->request('GET', "http://127.0.0.1:4444/kiosgamer/login?username=$username&password=$password&captcha=" . setting('2captcha'));
            // error_log(json_encode($sess));
            error_log(json_encode($sess));
            $result = $this->loginSSO($sess['data']['sessionKey']);
            $result['session_key'] = $sess['data']['sessionKey'];
        } else {
            $result = $this->loginSSO($session_key);
            $result['session_key'] = $session_key;
        }
        return $result;
    }

    /**
     * Important for payment. need Session key from function LoginGarena
     */
    public function loginSSO($session_key)
    {
        # code...
        $result = $this->request("POST", "https://kiosgamer.co.id/api/auth/sso", [
            "session_key" => $session_key
        ]);
        return $result;
    }
    /**
     * Get User info after login with ID.
     */
    public function getId()
    {
        $result = $this->request("GET", "https://kiosgamer.co.id/api/auth/get_user_info");
        return $result;
    }

    /**
     * Get User Role info after login with ID.
     */
    public function getRole()
    {
        $result = $this->request("GET", "https://kiosgamer.co.id/api/shop/apps/roles?app_id=" . $this->app_id);
        return $result[$this->app_id][0];
    }


    /**
     * But Diamond need garenaUID that generated from LoginSSO
     * OTP needed also. it must be numeric.
     * for ItemID use parse_productID for parsing the id
     */
    public function BuyDiamond($garenaUID, $OTP, $itemID)
    {
        # code...
        $csrf = $this->request2("POST", "https://kiosgamer.co.id/api/preflight", []);
        $_csrf = explode("=", explode("; ", $csrf['info']['set-cookie'][0])[0])[1];
        $data = [
            "app_id" => $this->app_id,
            "channel_id" => 208070,
            "channel_data" => [
                "otp_code" => $OTP,
                "garena_uid" => $garenaUID
            ],
            "item_id" => $itemID,
            "packed_role_id" => $this->packed_role_id,
            "player_id"    => null,
            "service" => "pc"
        ];
        error_log(json_encode($data));
        $result = $this->request(
            "POST",
            "https://kiosgamer.co.id/api/shop/pay/init?language=id&region=CO.ID",
            $data,
            [
                "X-Csrf-Token" => $_csrf
            ],
            $_csrf
        );
        return $result;
    }

    public function parse_productID($id)
    {
        # code...
        $ret = 0;
        switch ($id) {
            case '5':
                $ret = 8;
                break;
            case '20':
                $ret = 9;
                break;
            case '50':
                $ret = 10;
                break;
            case '70':
                $ret = 1;
                break;
            case '140':
                $ret = 2;
                break;
            case '355':
                $ret = 3;
                break;
            case '720':
                $ret = 4;
                break;
            case '2000':
                $ret = 5;
                break;
            case 'membermingguan':
                $ret = 6;
                break;
            case 'memberbulanan':
                $ret = 7;
                break;
            case '7290':
                $ret = 11;
                break;
            case '36500':
                $ret = 12;
                break;
            case '73100':
                $ret = 13;
            default:
                # code...
                break;
        }
        return $ret;
    }
}
