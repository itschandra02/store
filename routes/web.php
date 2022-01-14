<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\AutoOrderController;
use App\Http\Controllers\admin\BannerController;
use App\Http\Controllers\admin\ChatController;
use App\Http\Controllers\admin\DataController;
use App\Http\Controllers\admin\InvoiceController;
use App\Http\Controllers\admin\PaymentGateController;
use App\Http\Controllers\admin\ProductsController;
use App\Http\Controllers\admin\ProfileController;
use App\Http\Controllers\admin\WhatsappController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RegistController;
use App\Http\Controllers\SocialAuthController;
use App\Http\Controllers\TopupController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get("wel", function () {
    return view('welcome');
});

Route::get('/', [IndexController::class, 'index'])->name('index');
Route::get('order/{slug}', [IndexController::class, 'order_page'])->name('order_page');
Route::get('search', [IndexController::class, 'search_page'])->name('search');
Route::get('voucherstock', [OrderController::class, 'voucher_list'])->name('order.voucher');
Route::prefix('order')->group(function () {
    Route::post('check', [OrderController::class, 'order_check'])->name('order.check');
    Route::post('add', [OrderController::class, 'order_add'])->name('order.add');
});
Route::get('status', [IndexController::class, 'status_page'])->name('status');
Route::get('contact-us', [IndexController::class, 'contact_page'])->name('contact_us');
Route::post('contact-us', [IndexController::class, 'contact_send'])->name('contact_us.send');
Route::get('harga', [IndexController::class, 'harga_page'])->name('harga');
Route::prefix('harga')->group(function () {
    Route::get('list', [IndexController::class, 'harga_list'])->name('harga.list');
});
Route::get('invoice/{id}', [IndexController::class, 'invoice_page'])->name('invoice');
Route::get('register', [RegistController::class, 'index'])->name('register');
Route::prefix('register')->group(function () {
    Route::post('check', [RegistController::class, 'reg_check'])->name('register.check');
    Route::post('verification', [RegistController::class, 'reg_verification'])->name('register.verification');
});
Route::get('login', [AuthController::class, 'index'])->name('login');
Route::prefix('login')->group(function () {
    // Route::post('check', [AuthController::class, 'auth_check'])->name('login.auth_check');
    // Route::post('verification', [AuthController::class, 'auth_verification'])->name('login.auth_verification');
    Route::post('verification', [AuthController::class, 'auth_password'])->name('login.auth.verification');
    Route::post('forgot', [AuthController::class, 'forgot_password'])->name('login.auth.forgot');
});
Route::prefix('forget-pass')->group(function () {
    Route::get('/{token}', [AuthController::class, 'forget_page'])->name('login.forget_pass');
    Route::post('/{token}', [AuthController::class, 'forget_confirmation'])->name('login.forget_pass.confirmation');
});
Route::prefix('topup')->group(function () {
    Route::get('/', [TopupController::class, 'index'])->name('topup');
    Route::post('verification', [TopupController::class, 'verification'])->name('topup.verification');
});
Route::get('logout', [AuthController::class, 'logout'])->name('logout');
// Socialite Auth
// Route::get('auth/social',)
Route::get('oauth/{driver}', [SocialAuthController::class, 'redirect_to_provider'])->name('social.oauth');
Route::get('oauth/{driver}/callback', [SocialAuthController::class, 'handle_provider_callback'])->name('social.callback');
Route::get('oauth/{driver}/deletion_callback', [SocialAuthController::class, 'data_deletion_callback'])->name('social.fb.delete');
Route::get('deletion', [SocialAuthController::class, 'deletion_page'])->name("social.fb.delete.page");
// End socialite


Route::get('user', function (Request $request) {
    if ($request->session()->has('loggedIn')) {
        $user = DB::table('users')
            ->select(['id', 'name', 'username', 'email', 'number', 'balance', 'status'])
            ->where('id', '=', session('userid'))
            ->get()
            ->first();
        return response()->json($user);
    } else {
        return response('', '403');
    }
})->name('user');

// Route::get('test',function(Request $request){
//     return Str::lower(Str::studly('Ari Sawali'));
// });

Route::get('dashboard', [IndexController::class, 'dashboard_page'])->name('dashboard');
Route::get('settings', [IndexController::class, 'settings_page'])->name('settings');
Route::post('settings', [IndexController::class, 'settings_edit'])->name('settings.edit');
Route::get('terms-and-conditions', [IndexController::class, 'tac_page'])->name('terms');
Route::get('privacy-policy', [IndexController::class, 'privacy_page'])->name('privacy_policy');

// Route::get('/settings',function(){
//     return response('',404) ;
// });


Route::middleware([AdminMiddleware::class])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin');
        Route::get('login', [AdminController::class, 'login_page'])->name('admin.login');
        Route::post('login', [AdminController::class, 'login_auth'])->name('admin.login.post');
        Route::get('logout', [AdminController::class, 'logout'])->name('admin.logout');
        Route::prefix('profile')->group(function () {
            Route::get('/', [ProfileController::class, 'index'])->name('admin.profile');
            Route::post('set', [ProfileController::class, 'profile_set'])->name('admin.profile.set');
            Route::post('save', [ProfileController::class, 'save_user'])->name('admin.profile.save-user');
            Route::post('remove', [ProfileController::class, 'remove_user'])->name('admin.profile.remove-user');
            Route::get('list-user', [ProfileController::class, 'list_user'])->name('admin.profile.list-user');
            Route::get('list', [ProfileController::class, 'userList'])->name('admin.profile.list');
            Route::get('list-admin', [ProfileController::class, 'list_admin'])->name('admin.profile.list-admin');
            Route::post('add-role', [ProfileController::class, 'add_role'])->name('admin.profile.add-role');
            Route::post('save-role', [ProfileController::class, 'save_role'])->name('admin.profile.save-role');
            Route::post('remove-role', [ProfileController::class, 'remove_role'])->name('admin.profile.remove-role');
            Route::post('add-admin', [ProfileController::class, 'add_admin'])->name('admin.profile.add-admin');
            Route::post('delete-admin', [ProfileController::class, 'delete_admin'])->name('admin.profile.delete-admin');
        });
        Route::prefix('invoice')->group(function () {
            Route::get('list-invoice', [InvoiceController::class, 'page_list'])->name('admin.invoice.page');
            Route::post('change-order', [InvoiceController::class, 'done_order'])->name('admin.invoice.done_order');
        });
        Route::prefix('banner')->group(function () {
            Route::get('list-banner', [BannerController::class, 'page_list'])->name('admin.banner.page');
            Route::get('add', [BannerController::class, 'page_add'])->name('admin.banner.page.add');
            Route::get('list', [BannerController::class, 'get_list'])->name('admin.banner.get');
            Route::post('add', [BannerController::class, 'add'])->name('admin.banner.add');
            Route::post('delete', [BannerController::class, 'delete'])->name('admin.banner.delete');
            Route::post('event', [BannerController::class, 'banner_event'])->name('admin.banner.event');
        });
        Route::prefix('products')->group(function () {
            Route::get('list-products', [ProductsController::class, 'page_products'])->name('a_product.list');
            Route::get('add-products', [ProductsController::class, 'page_add_products'])->name('prod.add');
            Route::post('add-products', [ProductsController::class, "add_product"])->name("prod.add.post");
            Route::get('list', [ProductsController::class, 'list_products'])->name('prod.list');
            Route::post('event', [ProductsController::class, 'event_prod'])->name('prod.event');
            Route::get('category-products', [ProductsController::class, 'page_category_products'])->name('prod.category');
            Route::get('list-cat', [ProductsController::class, 'list_category_products'])->name('prod.category.list');
            Route::post('add-cat', [ProductsController::class, 'add_category_products'])->name('prod.category.add');
            Route::post('delete-cat', [ProductsController::class, 'delete_category_products'])->name('prod.category.delete');
            Route::post('edit-cat', [ProductsController::class, 'edit_category_products'])->name('prod.category.edit');
            Route::post('event-cat', [ProductsController::class, 'event_category_products'])->name('prod.category.event');
        });
        Route::prefix('data')->group(function () {
            Route::get('list-data', [DataController::class, 'page_data'])->name('page.data');
            Route::get('list', [DataController::class, 'list_data'])->name('data.list');
            Route::get('add-data', [DataController::class, 'page_add_data'])->name('page.add.data');
            Route::post('add-data', [DataController::class, 'add_data'])->name('page.add.data.post');
            Route::post('edit', [DataController::class, 'edit_data'])->name('data.edit');
            Route::post('delete', [DataController::class, 'delete_data'])->name('data.delete');
            Route::post('event', [DataController::class, 'event_data'])->name('data.event');
            // Vouchers
            Route::get('list-voucher', [DataController::class, 'page_voucher'])->name('data.page.voucher');
            Route::get('list-vc', [DataController::class, 'list_voucher'])->name('data.list.voucher');
            Route::get('add-voucher', [DataController::class, 'page_add_voucher'])->name('data.page.vocher.add');
            Route::post('add-voucher', [DataController::class, 'add_voucher'])->name('data.page.voucher.add');
            Route::post('delete-voucher', [DataController::class, 'delete_voucher'])->name('data.page.voucher.delete');
        });
        Route::prefix('whatsapp')->group(function () {
            Route::get('/', [WhatsappController::class, 'index'])->name('wa');
            // Route::get('callback', [WhatsappController::class, 'callback'])->name('wa.callback');
            Route::get('check', [WhatsappController::class, 'check'])->name('wa.check');
            Route::post('event', [WhatsappController::class, 'event'])->name('wa.event');
            Route::get('logout', [WhatsappController::class, 'logout_wa'])->name('wa.logout');
            Route::get('contact', [WhatsappController::class, 'get_contact'])->name('wa.getcontact');
        });
        Route::prefix('payment')->group(function () {
            Route::get('list-payment', [PaymentGateController::class, 'index'])->name('payment');
            Route::get('list', [PaymentGateController::class, 'list_payment'])->name('payment.list');
            Route::get('add', [PaymentGateController::class, 'add_page'])->name('payment.add');
            Route::post('event', [PaymentGateController::class, 'payment_event'])->name('payment.event');
        });
        Route::prefix('chat')->group(function () {
            Route::get('/', [ChatController::class, 'index'])->name('chat');
        });
        Route::prefix('auto-order')->group(function () {
            Route::get('/', [AutoOrderController::class, 'index_page'])->name('auto-order');
            Route::get('list', [AutoOrderController::class, 'list_auto_order'])->name('auto-order.list');
            Route::get('add', [AutoOrderController::class, 'add_auto_order'])->name('auto-order.add');
            Route::post('event', [AutoOrderController::class, 'auto_order_event'])->name('auto-order.event');
            Route::prefix('smile-one')->group(function () {
                Route::get('/', [AutoOrderController::class, 'smile_page'])->name('auto.smile');
                Route::post('save', [AutoOrderController::class, 'save_acc'])->name('auto.smile.save');
                Route::get('check', [AutoOrderController::class, 'check_balance'])->name('auto.smile.check');
            });
            Route::prefix('kiosgamer')->group(function () {
                Route::get('/', [AutoOrderController::class, 'kiosgamer_page'])->name('auto.kiosgamer');
                Route::post('save', [AutoOrderController::class, 'kiosgamer_save'])->name('auto.kiosgamer.save');
                Route::get('check', [AutoOrderController::class, 'kiosgamer_check'])->name('auto.kiosgamer.check');
            });
            Route::prefix('kiosgamercodm')->group(function () {
                Route::get('/', [AutoOrderController::class, 'kiosgamercodm_page'])->name('auto.kiosgamercodm');
                Route::post('save', [AutoOrderController::class, 'kiosgamercodm_save'])->name('auto.kiosgamercodm.save');
                Route::get('check', [AutoOrderController::class, 'kiosgamercodm_check'])->name('auto.kiosgamercodm.check');
            });
            Route::prefix('kiosgameraov')->group(function () {
                Route::get('/', [AutoOrderController::class, 'kiosgameraov_page'])->name('auto.kiosgameraov');
                Route::post('save', [AutoOrderController::class, 'kiosgameraov_save'])->name('auto.kiosgameraov.save');
                Route::get('check', [AutoOrderController::class, 'kiosgameraov_check'])->name('auto.kiosgameraov.check');
            });
        });
    });
});
