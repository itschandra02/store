<?php

namespace App\Logic\Curl;

/**
 * KiosGamer Call Of Duty Mobile unofficial API for payment Call Of Duty Mobile
 * Author by: Ari Sawali.
 */

class KiosGamerCodm
{
    public $open_id = null;
    public $ch = null;
    public $antiCaptcha = null;
    public function __construct($antiCaptcha = "")
    {
        # code...
        $this->ch = curl_init();
        $this->antiCaptcha = $antiCaptcha;
    }
    public function getHeaders($array)
    {
        $headers = array();
        foreach ($array as $key => $value) {
            $headers[] = $key . ": " . $value;
        }
        return $headers;
    }
    public function request($method, $url, $data = null, $headers = array())
    {
        // $ch = curl_init();
        if ($this->ch == null) {
            $this->ch = curl_init();
        }
        if (!is_null($data)) {
            curl_setopt($this->ch, CURLOPT_POSTFIELDS, is_array($data) ? json_encode($data) : $data);
            if (is_array($data)) $headers = array_merge(
                array(
                    "Accept" => "application/json",
                    "Content-Type" => "application/json",
                ),
                $headers
            );
        }
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
            CURLOPT_COOKIEFILE => dirname(__FILE__) . '/curl-kiosgamer-codm-cookie.txt',
            CURLOPT_COOKIEJAR => dirname(__FILE__) . '/curl-kiosgamer-codm-cookie.txt',
        ));
        $this->response = curl_exec($this->ch);
        $this->http_code = curl_getinfo($this->ch, CURLINFO_HTTP_CODE);
        if ($result = json_decode($this->response, true)) {
            if (isset($result["data"])) $this->data = $result["data"];
            return $result;
        }
        return $this->response;
    }
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
            CURLOPT_COOKIEFILE => dirname(__FILE__) . '/curl-kiosgamer-codm-cookie.txt',
            CURLOPT_COOKIEJAR => dirname(__FILE__) . '/curl-kiosgamer-codm-cookie.txt',
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
        $result = $this->request("POST", "https://kiosgamer.co.id/api/auth/player_id_login", array(
            "app_id" => 100082,
            "login_id" => strval($game_id)
        ));
        if (isset($result['error']) || empty($result['open_id'])) {
            // print("MASUK SINI");
            $recaptcha = $this->get_tokenrecaptcha("https://kiosgamer.co.id", "6LfJXvoUAAAAAMrJFTEbBeWygZCCWQWbAZk_z2H0");
            // print_r($recaptcha);
            if ($recaptcha['status'] == "error") {
                $response['status'] = "error";
                $response['message'] = "recaptcha not work";
            } else {
                $result = $this->request("POST", "https://kiosgamer.co.id/api/auth/player_id_login", array(
                    "app_id" => 100082,
                    'recaptcha_token' => $recaptcha['Token_Recaptcha'],
                    "login_id" => strval($game_id)
                ));
                $this->open_id = $result["open_id"];
                return $result;
            }
        } else {
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
            $sess = $this->request('GET', "http://178.128.215.233:4444/kiosgamer/login?username=$username&password=$password&captcha=" . setting('2captcha'));
            // $sess = $this->request('GET', "http://127.0.0.1:4444/kiosgamer/login?username=$username&password=$password&captcha=" . setting('2captcha'));
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
     * But Diamond need garenaUID that generated from LoginSSO
     * OTP needed also. it must be numeric.
     * for ItemID use parse_productID for parsing the id
     */
    public function BuyDiamond($garenaUID, $OTP, $itemID)
    {
        # code...
        $csrf = $this->request2("POST", "https://kiosgamer.co.id/api/preflight", []);
        $_csrf = explode("=", explode("; ", $csrf['info']['set-cookie'][0])[0])[1];
        $result = $this->request(
            "POST",
            "https://kiosgamer.co.id/api/shop/pay/init?language=id&region=CO.ID",
            [
                "app_id" => 100082,
                "channel_id" => 208070,
                "channel_data" => [
                    "otp_code" => $OTP,
                    "garena_uid" => $garenaUID
                ],
                "item_id" => $itemID,
                "packed_role_id" => 65536,
                "player_id"    => null,
                "service" => "pc"
            ],
            [
                "x-csrf-token" => $_csrf
            ]
        );
        return $result;
    }

    public function parse_productID($id)
    {
        # code...
        $ret = 0;
        switch ($id) {
            case '53':
                $ret = 1;
                break;
            case '112':
                $ret = 2;
                break;
            case '278':
                $ret = 3;
                break;
            case '580':
                $ret = 4;
                break;
            case '1268':
                $ret = 5;
                break;
            case '1901':
                $ret = 6;
                break;
            case '3300':
                $ret = 7;
                break;
            case '7128':
                $ret = 8;
                break;
            default:
                # code...
                break;
        }
        return $ret;
    }
}
