const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */
// mix.setPublicPath('public');
// mix.setResourceRoot('../');

mix.setPublicPath('public');
mix.setResourceRoot("../../");
mix.js('resources/js/app.js', 'public/assets/js')
    .sass('resources/css/app.scss', 'public/assets/scss')
    .sass('resources/css/chatbox.scss', 'public/assets/scss')
    .postCss('resources/css/app.css', 'public/assets/css')
    .sourceMaps()
    .options({
        processCssUrls: true,
    });

mix.js('resources/admin/js/app.js', 'public/assets/admin/addons/js')
    .sass('resources/admin/css/app.scss', 'public/assets/admin/addons/scss');
// Bootstrap