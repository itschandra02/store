<?php

use App\Http\Controllers\admin\WhatsappController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\apis\ApiV2Controller;
use App\Http\Middleware\ApiAuthMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('callback')->group(function () {
    Route::post("mutation", [ApiController::class, 'mutation_callback'])->name('api.callback.mutation');
    // Route::post("payment",[ApiController::class,'tripay_callback'])
    Route::prefix('payment')->group(function () {
        Route::post("tripay", [ApiController::class, 'tripay_callback'])->name('api.callback.payment.tripay');
        Route::post("hitpay", [ApiController::class, 'hitpay_callback'])->name('api.callback.payment.hitpay');
    });
    Route::post('whatsapp', [WhatsappController::class, 'callback'])->name('wa.callback');
});
Route::prefix('invoice')->group(function () {
    Route::get('get', [ApiController::class, 'get_invoice'])->name('api.invoice.get');
    Route::get('list', [ApiController::class, 'list_invoice'])->name('api.invoice.list');
});

Route::post('search', function (Request $request) {
    $query = $request->q;
    $limit = $request->limit ?? 10;
    if (!$query) {
        return response()->json([]);
    }
    $result = DB::table('products')
        ->select("products.*", DB::raw("categories.title category_title"))
        ->where('products.name', 'like', "%{$query}%")
        ->orWhere('products.subtitle', 'like', "%{$query}%")
        ->orWhere('products.category', 'like', "%{$query}%")
        ->leftJoin('categories', 'products.category', '=', 'categories.name')
        ->limit($limit)->get();
    return response()->json($result);
})->name('api.search');

Route::get('users', function (Request $request) {
    if ($request->id) {
        $id = $request->id;
        $data = DB::table('users')
            ->select([
                'id', 'name', 'username', 'email',
                'number', 'balance', 'status', 'last_login',
            ])->where('id', $id)->get()->first();
    } else {

        $data = DB::table('users')
            ->select([
                'id', 'name', 'username', 'email',
                'number', 'balance', 'status', 'last_login',
            ])->get();
    }
    return response()->json(['success' => true, 'data' => $data]);
})->name('api.user');

// get role type from table usertype select all columns with id and type
// search by id if id none return all
// return all data
Route::get('usertype', function (Request $request) {
    if ($request->id) {
        $id = $request->id;
        $data = DB::table('usertype')
            ->select([
                'id', 'type',
            ])->where('id', $id)->get()->first();
    } else {

        $data = DB::table('usertype')
            ->select([
                'id', 'type',
            ])->get();
    }
    return response()->json($data);
})->name('api.usertype');

//check IP user
Route::get('checkip', function (Request $request) {
    $ip = $request->ip();

    $whitelistIP = explode(';', env('WHITELIST_IP'));
    $whitelistIPS = preg_match("/^" . implode("|", $whitelistIP) . "/", $_SERVER["REMOTE_ADDR"]);
    return response()->json([
        "ip" => $ip,
        "remote_addr" => $_SERVER["REMOTE_ADDR"],
        "whitelist" => $whitelistIP,
        "CanIPass" => $whitelistIPS
    ]);
})->name('api.checkip');

// Using ApiAuthMiddleware
Route::middleware([ApiAuthMiddleware::class])->group(function () {
    Route::prefix('v2')->group(function () {
        Route::get('user', [ApiV2Controller::class, 'get_user']);
    });
});

// Without ApiAuthMiddleware
Route::prefix('v2')->group(function () {
    Route::get('products', [ApiV2Controller::class, 'get_products'])->name('api.products');
    Route::get('categories', [ApiV2Controller::class, 'get_categories'])->name('api.categories');
});
