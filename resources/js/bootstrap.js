window._ = require('lodash');

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
try {
    window.Popper = require('popper.js').default;
    window.$ = global.$ = global.jQuery = global.JQuery = require('jquery');
    require('bootstrap');
} catch (error) {

}
require('@fortawesome/fontawesome-free');
window.Swal = require('sweetalert2');
window.toastr = require('toastr');
require('bootstrap-notify');
toastr.options.progressBar = true;
require('bootstrap-table');
/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });
