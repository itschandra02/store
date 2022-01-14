<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        if (env('APP_ENV') !== 'local') {
            // $url->forceSchema('https');
            $whitelist = array(
                '127.0.0.1',
                // '::1',
                'localhost',
                '192.168'
            );
            if (preg_match("/^" . implode("|", $whitelist) . "/", $_SERVER["REMOTE_ADDR"] ?? '127.0.0.1')) {
                $this->app['request']->server->set('HTTPS', true);
            }
        }
    }
}
