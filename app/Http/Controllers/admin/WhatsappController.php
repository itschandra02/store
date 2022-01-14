<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Database\Console\Migrations\StatusCommand;
use Illuminate\Database\Eloquent\JsonEncodingException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class WhatsappController extends Controller
{
    //
    public function index(Request $request)
    {
        # code...
        if (!$request->session()->has("isAdminLogged")) {
            return redirect()->route("admin.login");
        }
        $data = DB::table('wagate')
            ->select("*")
            ->get()
            ->first();
        $status = false;
        $prof = null;
        $groups = [];
        if ($data) {
            // $contacts = $this->getContact();
            // $prof = Http::get(setting('wahost') . "/api/profilepic/" . $data->id, [
            //     "jid"   => json_decode($data->user, 1)['jid']
            // ]);
            $status = true;
            // foreach ($contacts['data'] as $key => $value) {
            //     # code...
            //     if (strpos($value['jid'], 'g.us') !== false) {
            //         error_log($value['jid']);
            //         array_push($groups, $value);
            //     }
            // }
        }
        return view('admin.wa.whatsapp', [
            'data'  => $data,
            'status'    => $status,
            // 'groups'    => $groups,
        ]);
    }
    public function callback(Request $request)
    {
        # code...
        $ipt = json_decode(json_encode($request->all()));
        DB::table('wagate')
            ->insert([
                "id"    => $ipt->id,
                "auth"  => json_encode($ipt->auth),
                "user"  => json_encode($ipt->user)
            ]);
        error_log("CALLBACK::" . json_encode($request->all()));
    }
    public function check(Request $request)
    {
        # code...
        $data = DB::table('wagate')
            ->select("*")
            ->get()
            ->first();
        $status = false;
        if ($data) {
            $status = true;
        }
        $resp = [
            'success'   => $status
        ];
        return response()->json($resp);
    }
    public function event(Request $request)
    {
        # code...
        if ($request->type == "changeGroup") {
            setting()->set('wagroup', $request->jid);
            return response()->json([
                "success" => true
            ]);
        }
    }
    public function logout_wa(Request $request)
    {
        # code...
        $data = DB::table('wagate')
            ->select("*")
            ->get()
            ->first();
        DB::table('wagate')->where("id", $data->id)->delete();
        return redirect()->to(route('wa'));
    }
    public function get_contact(Request $request)
    {
        # code...
        $data = DB::table('wagate')
            ->select("*")
            ->get()
            ->first();
        if ($data) {
            try {
                $contacts = $this->getContact();
                return response()->json($contacts);
            } catch (\Throwable $th) {
                return response()->json([
                    'success' => false
                ]);
            }
        }
    }
}
