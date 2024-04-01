import Pusher from 'pusher-js';
import Echo from 'laravel-echo';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

window.Pusher = Pusher;


window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'mt1',
    wsHost: import.meta.env.VITE_PUSHER_HOST ? import.meta.env.VITE_PUSHER_HOST : `ws-${import.meta.env.VITE_PUSHER_APP_CLUSTER}.pusher.com`,
    wsPort: import.meta.env.VITE_PUSHER_PORT ?? 80,
    wssPort: import.meta.env.VITE_PUSHER_PORT ?? 443,
    forceTLS: (import.meta.env.VITE_PUSHER_SCHEME ?? 'https') === 'https',
    enabledTransports: [ 'ws', 'wss' ],
});


window.Echo.channel("chats.83")
    .listen('MessageSent', (e) => {
        console.log(e, 'yaa raaab');
    });
// window.pusher = new Pusher('125939c2ea49d8c1c7f1', {
//     cluster: 'eu'
// });

// let channel = window.pusher.subscribe('my-channel');
// channel.bind('my-event', function (data) {
//     alert(JSON.stringify(data));
// });
