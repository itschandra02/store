<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Jobs\KiosGamerCodmOrderJob;
use App\Jobs\KiosGamerOrderJob;
use App\Jobs\SmileOrderJob;
use App\Jobs\WhatsappSender;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    //
    public function page_list(Request $request)
    {
        # code...
        if (!$request->session()->has("isAdminLogged")) {
            return redirect()->route('admin.login');
        }
        return view('admin.invoice.list');
    }
    public function done_order(Request $request)
    {
        # code...

        $jdata = json_decode($request->getContent(), true);
        if ($jdata['type'] == 'done') {
            DB::table('invoices')->where('invoice_number', $jdata['invoice_number'])->update([
                'status' => 'DONE'
            ]);
            if ($jdata['user'] == null && $jdata['number']) {
                $t = "Order " . $jdata['product_data_name'] . " untuk product " . $jdata['product_name'] . " telah berhasil ditambahkan ke akun game Anda.\n\nTerima kasih banyak kak ;)";
                dispatch(new WhatsappSender($jdata['number'], $t));
                return response()->json([
                    'success' => true,
                    'message' => 'Status berhasil diubah'
                ]);
            }
            $akun = DB::table('users')->select('*')->where('id', $jdata['user'])->get()->first();
            if ($akun) {
                $t = "Order " . $jdata['product_data_name'] . " untuk product " . $jdata['product_name'] . " telah berhasil ditambahkan ke akun game Anda.\n\nTerima kasih banyak kak ;)";
                dispatch(new WhatsappSender($akun->number, $t));
                return response()->json([
                    'success' => true,
                    'message' => 'Status berhasil diubah'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'userid tidak ada',
                    'data'  => $jdata
                ]);
            }
        } elseif ($jdata['type'] == 'retry') {
            $inv = DB::table('invoices')->select()->where('invoice_number', $jdata['invoice_number'])->get()->first();
            $number = '';
            if ($inv->user) {
                $user = DB::table('users')->select()->where('id', $inv->user)->get()->first();
                $number = $user->number;
            } else {
                $number = $inv->number;
            }
            $resp = [
                'success' => false,
            ];
            $idSmileAuto = DB::table('auto_order_acc')->select('product_id')->where('account', 'smile')->get()->first();
            $idKiosGamerAuto = DB::table('auto_order_acc')->select('product_id')->where('account', 'kiosgamer')->get()->first();
            $idKiosGamerAutoCodm = DB::table('auto_order_acc')->select('product_id')->where('account', 'kiosgamercodm')->get()->first();
            $idKiosgamerAutoAov = DB::table('auto_order_acc')->select('product_id')->where('account', 'kiosgameraov')->get()->first();
            $idKiosgamerAutoFt = DB::table('auto_order_acc')->select('product_id')->where('account', 'kiosgamerft')->get()->first();
            if (($idSmileAuto) && ($inv->product_id == $idSmileAuto->product_id)) { // Mobile legends
                $product_data = DB::table('product_data')
                    ->select()
                    ->where('id', $inv->product_data_id)
                    ->get()->first();
                $jarr = json_decode($inv->user_input, true);
                $_id = $jarr[0]['value'];
                $_server = $jarr[1]['value'];
                $layanans = explode(",", $product_data->layanan);
                $datas = [];
                foreach ($layanans as $key => $layanan) {
                    # code...
                    $datas[] = [
                        "id" => $_id,
                        "server" => $_server,
                        "amount" => trim($layanan) // see on smile.ts
                    ];
                }
                dispatch(new SmileOrderJob($inv->invoice_number, $datas, $number));
                $resp['success'] = true;
                $resp['message'] = "$inv->product_name trying to order";
            } elseif (($idKiosGamerAuto) && ($inv->product_id == $idKiosGamerAuto->product_id)) { // Free fire
                $product_data = DB::table('product_data')
                    ->select()
                    ->where('id', $inv->product_data_id)
                    ->get()->first();
                $jarr = json_decode($inv->user_input, true);
                $_id = $jarr[0]['value'];
                $layanans = explode(",", $product_data->layanan);
                $datas = [];
                foreach ($layanans as $key => $layanan) {
                    # code...
                    $datas[] = [
                        "id" => $_id,
                        "amount" => trim($layanan), // see on kiosgamer.ts
                        "game"  => "ff"
                    ];
                }
                dispatch(new KiosGamerOrderJob($inv->invoice_number, $datas, $number));
                $resp['success'] = true;
                $resp['message'] = "$inv->product_name trying to order";
            } elseif (($idKiosGamerAutoCodm) && ($inv->product_id == $idKiosGamerAutoCodm->product_id)) { // Call Of Duty Mobile
                $product_data = DB::table('product_data')
                    ->select()
                    ->where('id', $inv->product_data_id)
                    ->get()->first();
                $jarr = json_decode($inv->user_input, true);
                $_id = $jarr[0]['value'];
                $layanans = explode(",", $product_data->layanan);
                $datas = [];
                foreach ($layanans as $key => $layanan) {
                    # code...
                    $datas[] = [
                        "id" => $_id,
                        "amount" => trim($layanan), // see on kiosgamer.ts
                        "game"  => "codm"
                    ];
                }
                dispatch(new KiosGamerOrderJob($inv->invoice_number, $datas, $number));
                $resp['success'] = true;
                $resp['message'] = "$inv->product_name trying to order";
            } elseif (($idKiosgamerAutoAov) && ($inv->product_id == $idKiosgamerAutoAov->product_id)) {
                $product_data = DB::table('product_data')
                    ->select()
                    ->where('id', $inv->product_data_id)
                    ->get()->first();
                $jarr = json_decode($inv->user_input, true);
                $_id = $jarr[0]['value'];
                $layanans = explode(",", $product_data->layanan);
                $datas = [];
                foreach ($layanans as $key => $layanan) {
                    # code...
                    $datas[] = [
                        "id" => $_id,
                        "amount" => trim($layanan), // see on kiosgamer.ts
                        "game"  => "aov"
                    ];
                }
                dispatch(new KiosGamerOrderJob($inv->invoice_number, $datas, $number));
                $resp['success'] = true;
                $resp['message'] = "$inv->product_name trying to order";
            } elseif (($idKiosgamerAutoFt) && ($inv->product_id == $idKiosgamerAutoFt->product_id)) {
                $product_data = DB::table('product_data')
                    ->select()
                    ->where('id', $inv->product_data_id)
                    ->get()->first();
                $jarr = json_decode($inv->user_input, true);
                $_id = $jarr[0]['value'];
                $layanans = explode(",", $product_data->layanan);
                $datas = [];
                foreach ($layanans as $key => $layanan) {
                    # code...
                    $datas[] = [
                        "id" => $_id,
                        "amount" => trim($layanan), // see on kiosgamer.ts
                        "game"  => "fantasytown"
                    ];
                }
                dispatch(new KiosGamerOrderJob($inv->invoice_number, $datas, $number));
                $resp['success'] = true;
                $resp['message'] = "$inv->product_name trying to order";
            } else {
                DB::table('invoices')->where('invoice_number', $jdata['invoice_number'])->update([
                    'status' => 'DONE'
                ]);
                if ($jdata['user'] == null && $jdata['number']) {
                    $t = "Order " . $jdata['product_data_name'] . " untuk product " . $jdata['product_name'] . " telah berhasil ditambahkan ke akun game Anda.\n\nTerima kasih banyak kak ;)";
                    dispatch(new WhatsappSender($jdata['number'], $t));
                    return response()->json([
                        'success' => true,
                        'message' => 'Status berhasil diubah'
                    ]);
                }
                $akun = DB::table('users')->select('*')->where('id', $jdata['user'])->get()->first();
                if ($jdata['number'] == null &&$akun) {
                    $t = "Order " . $jdata['product_data_name'] . " untuk product " . $jdata['product_name'] . " telah berhasil ditambahkan ke akun game Anda.\n\nTerima kasih banyak kak ;)";
                    dispatch(new WhatsappSender($akun->number, $t));
                    return response()->json([
                        'success' => true,
                        'message' => 'Status berhasil diubah'
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'userid tidak ada',
                        'data'  => $jdata
                    ]);
                }
                $resp['success'] = true;
                $resp['message'] = "$inv->product_name not support auto order";
            }
            return response()->json($resp);
        }
    }
}
