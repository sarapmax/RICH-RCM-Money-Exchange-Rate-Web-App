
window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.$ = window.jQuery = require('jquery');

    require('bootstrap-sass');
} catch (e) {}

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

import Echo from 'laravel-echo'

window.Pusher = require('pusher-js');

// Set pusher key for local and production.
let pusherKey = ''

if(window.location.hostname == 'richc-m.com') {
    pusherKey = 'b84b59d73bf72a926560'
} else {
    pusherKey = '3176398c2181a23ceb7f'
}

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: pusherKey,
    cluster: 'ap1',
    encrypted: true
});
