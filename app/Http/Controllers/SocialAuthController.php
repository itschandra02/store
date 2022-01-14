<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class SocialAuthController extends Controller
{
    //
    public function __construct()
    {
        # code...
        $this->middleware('guest');
    }
    protected $providers = [
        'github',
        'facebook',
        'google',
        'twitter'
    ];
    public function data_deletion_callback($driver, Request $request)
    {
        # code...
        if ($driver == "facebook") {
            $signed_request = $request->get('signed_request');
            $data = $this->parse_signed_request($signed_request);
            $user_id = $data['user_id'];
            $user = DB::table('users')
                ->select('*')
                ->where('provider_id', '=', $user_id)
                ->get()
                ->first();
            DB::table('users')
                ->where('provider_id', '=', $user_id)
                ->delete();
            $code = Str::random(5);
            DB::table('data_deletion')
                ->insert([
                    "provider"  => $driver,
                    "email"     => $user->email,
                    "balance"   => $user->balance,
                    "code"      => $code
                ]);
            if (session('userid') == $user->id) {
                session()->flush();
            }
            return response()->json([
                'url' => route('social.fb.delete.page') . "?id=" . $code, // <------ i dont know what to put on this or what should it do
                'code' => $code, // <------ i dont know what is the logic of this code
            ]);
        }
    }
    public function deletion_page(Request $request)
    {
        # code...
        $data = DB::table('data_deletion')
            ->select(['provider', 'created_at'])
            ->where('code', '=', $request->id)
            ->get()
            ->first();
        $success = false;
        if ($data) {
            $success = true;
        }
        return view('deletion', [
            'data'  => $data,
            'success'   => $success
        ]);
    }
    private function parse_signed_request($signed_request)
    {
        // encoded,payload
        $splited = explode('.', $signed_request, 2);

        $secret = config('service.facebook.client_secret'); // Use your app secret here

        // decode the data
        $sig = $this->base64_url_decode($splited[0]);
        $data = json_decode($this->base64_url_decode($splited[1]), true);

        // confirm the signature
        $expected_sig = hash_hmac('sha256', $splited[1], $secret, $raw = true);
        if ($sig !== $expected_sig) {
            error_log('Bad Signed JSON signature!');
            return null;
        }

        return $data;
    }

    private function base64_url_decode($input)
    {
        return base64_decode(strtr($input, '-_', '+/'));
    }
    public function redirect_to_provider($driver)
    {
        # code...
        if (!$this->isProviderAllowed($driver)) {

            return $this->sendFailedResponse("{$driver} is not currently supported");
        }
        try {
            return Socialite::driver($driver)->redirect();
        } catch (Exception $e) {
            return $this->sendFailedResponse($e->getMessage());
        }
    }
    public function handle_provider_callback($driver)
    {
        # code...
        try {
            $user = Socialite::driver($driver)->user();
            // $user->getName()
        } catch (Exception $e) {
            return $this->sendFailedResponse($e->getMessage());
        }
        return empty($user->email)
            ? $this->sendFailedResponse("No Email id returned from {$driver} provider")
            : $this->loginOrCreateAccount($user, $driver);
    }
    protected function sendSuccessResponse()
    {
        return redirect()->intended('settings');
    }
    protected function sendFailedResponse($msg = null)
    {
        $value = [
            'title' =>  'Login',
            'text'  =>  $msg, //'Failed Login',
            'type'  =>  'error'
        ];
        session()->flash('flash', $value);
        return redirect()->route('login');
    }
    protected function loginOrCreateAccount($provUser, $driver)
    {
        $user = DB::table('users')
            ->select('*')
            ->where('email', "=", $provUser->getEmail())
            ->get()
            ->first();
        $newUser = false;
        if ($user) {
            DB::table('users')
                ->where('email', '=', $provUser->getEmail())
                ->update([
                    'avatar'    => $provUser->avatar,
                    'provider'  => $driver,
                    'provider_id' => $provUser->id,
                    'access_token' => $provUser->token
                ]);
            session([
                'loggedIn'  =>  true,
                'userid'    =>  $user->id,
                'username'  =>  $user->username,
                'avatar'    =>  $provUser->avatar
            ]);
        } else {
            $id = DB::table('users')
                ->insertGetId([
                    "name"  => $provUser->getName(),
                    "email" => $provUser->getEmail(),
                    "username" => Str::lower(Str::studly($provUser->getName())),
                    "number"    => "",
                    "password"  =>  "",
                    // Socialite
                    "avatar"    => $provUser->getAvatar(),
                    "provider"  => $driver,
                    "provider_id" => $provUser->getId(),
                    "access_token" => $provUser->token,
                    'apikey'    =>  Str::uuid()
                ]);
            session([
                'loggedIn'  =>  true,
                'userid'    =>  $id,
                'username'  =>  Str::lower(Str::studly($provUser->getName())),
                'avatar'    =>  $provUser->avatar
            ]);
            $newUser = true;
        }
        if ($newUser) {
            $value = [
                'title' =>  'Login',
                'text'  =>  "Success Login with {$driver}, Tolong input nomor whatsapp",
                'type'  =>  'success'
            ];
            session()->flash('flash', json_encode($value));
            return redirect()->route('settings');
        } else {
            $value = [
                'title' =>  'Login',
                'text'  =>  "Selamat datang kembali " . $user->name,
                'type'  =>  'success'
            ];
            session()->flash('flash', json_encode($value));
            if ($user->number == "") {
                return redirect()->route('settings');
            } else {
                return redirect()->route('dashboard');
            }
        }
    }
    private function isProviderAllowed($driver)
    {
        # code...
        return in_array($driver, $this->providers) && config()->has("services.{$driver}");
    }
}
