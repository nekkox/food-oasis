import Echo from 'laravel-echo';

import Pusher from 'pusher-js';
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: pusherKey,
    cluster: pusherCluster ?? 'mt1',
    wsHost: import.meta.env.VITE_PUSHER_HOST ? import.meta.env.VITE_PUSHER_HOST : `ws-${pusherCluster}.pusher.com`,
    wsPort: import.meta.env.VITE_PUSHER_PORT ?? 80,
    wssPort: import.meta.env.VITE_PUSHER_PORT ?? 443,
    forceTLS: (import.meta.env.VITE_PUSHER_SCHEME ?? 'https') === 'https',
    enabledTransports: ['ws', 'wss'],
});


window.Echo.channel('order-placed')
    .listen('.RTOrderPlacedNotificationEvent', (e) => { // Note the dot before the event name
        console.log('Event received:', e);

        let html = `
            <a href="/admin/orders/${e.orderId}"
               class="dropdown-item dropdown-item-unread">
                <div class="dropdown-item-icon bg-primary text-white">
                    <i class="fas fa-code"></i>
                </div>
                <div class="dropdown-item-desc">
                    ${e.message}
                    <div class="time text-primary">2 Min Ago</div>
                </div>
            </a>
        `;
        $('.rt_notification').prepend(html);
    });
console.log('Echo listener set up complete');


