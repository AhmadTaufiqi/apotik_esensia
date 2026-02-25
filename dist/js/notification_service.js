// Di file JS Anda
navigator.serviceWorker.register('sw.js');
Notification.requestPermission().then(permission => {
    if (permission === 'granted') {
        navigator.serviceWorker.ready.then(swRegistration => {
            return swRegistration.pushManager.subscribe({
                userVisibleOnly: true,
                applicationServerKey: 'YOUR_PUBLIC_VAPID_KEY'
            });
        }).then(subscription => {
            // KIRIM $subscription (JSON) ke PHP Anda via AJAX/Fetch
            fetch('save_subscription.php', {
                method: 'POST',
                body: JSON.stringify(subscription)
            });
        });
    }
});
