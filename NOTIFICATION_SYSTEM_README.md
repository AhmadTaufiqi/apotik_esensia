# Dokumentasi Sistem Notifikasi Dashboard Admin

## Deskripsi
Sistem notifikasi real-time yang memeriksa pesanan terbaru setiap 10 detik dan menampilkannya di dashboard admin dengan notifikasi toast dan list dinamis.

## File-file yang Terlibat

### 1. **check-notifications.js** 
- **Lokasi**: `/dist/js/check-notifications.js`
- **Fungsi**: Class utama untuk polling dan menampilkan notifikasi
- **Fitur**:
  - Polling otomatis setiap 10 detik
  - Menampilkan toast notification untuk notifikasi baru
  - Render list notifikasi di container
  - Format waktu yang user-friendly (menit lalu, jam lalu, dll)

### 2. **head.php**
- **Lokasi**: `/application/views/layouts/head.php`
- **Perubahan**: Menambahkan variabel global `window.baseURL`
- **Fungsi**: Menyediakan base URL untuk AJAX requests

### 3. **dashboard.php**
- **Lokasi**: `/application/views/dashboard.php`
- **Perubahan**: 
  - Menambahkan container notifikasi (`#notifications-container`)
  - Meload script `check-notifications.js`
  - Menambahkan CSS untuk animasi notifikasi

### 4. **Notifications Controller**
- **Lokasi**: `/application/controllers/admin/Notifications.php`
- **Method**: `latestNotifications()`
- **Endpoint**: `admin/notifications/latestNotifications`
- **Return**: JSON dengan struktur `{count, data}`
- **Parameter**: `limit` (jumlah notifikasi yang ditampilkan, default 5)

## Cara Kerja

### Flow Diagram
```
Dashboard Loaded
    ↓
check-notifications.js Initialized
    ↓
Poll Every 10 Seconds
    ↓
AJAX Request → admin/notifications/latestNotifications
    ↓
Server Returns JSON Data
    ↓
Check if count > lastCount
    ↓
Yes: Show Toast + Update List
No: Just Update List
    ↓
Render Notifications in Container
```

## Implementasi pada Page Admin Dashboard

### HTML Structure (Sudah ditambahkan di dashboard.php)
```html
<!-- Notifications Container -->
<div class="row mb-3">
  <div class="col-12">
    <div id="notifications-container">
      <!-- Notifications will be rendered here -->
    </div>
  </div>
</div>
```

### Script Loading (Sudah ditambahkan di dashboard.php)
```html
<script src="<?= base_url() ?>dist/js/check-notifications.js"></script>
```

## Fitur Notifikasi

### 1. Polling Otomatis
- Setiap 10 detik, sistem melakukan AJAX request ke server
- Mengambil data notifikasi terbaru dari database

### 2. Toast Notification
- Muncul saat ada notifikasi baru
- Tampil di sudut kanan bawah layar
- Auto-dismiss setelah beberapa detik

### 3. Notification List
- Menampilkan daftar notifikasi terbaru
- Setiap notifikasi memiliki:
  - Order ID (#)
  - Status/Message
  - Waktu notifikasi
  - Button "Lihat" untuk navigasi ke halaman orders

### 4. Responsif
- Menggunakan Bootstrap 5
- Responsive di semua ukuran layar
- Smooth animations dan transitions

## Struktur Data Notifikasi

### Request
```
GET /admin/notifications/latestNotifications?limit=5
```

### Response
```json
{
  "count": 3,
  "data": [
    {
      "order_id": "12345",
      "title": "Order Baru #12345",
      "message": "Status: unpaid",
      "created_at": "2024-01-15 10:30:00"
    },
    {
      "order_id": "12344",
      "title": "Order Baru #12344",
      "message": "Pembayaran diterima — perlu diperiksa",
      "created_at": "2024-01-15 09:45:00"
    }
  ]
}
```

## Konfigurasi

Untuk mengubah setting notifikasi, edit pada bagian initialization di `check-notifications.js`:

```javascript
window.notificationChecker = new NotificationChecker({
    checkInterval: 10000,           // Interval polling (ms), 10000 = 10 detik
    limit: 5,                       // Jumlah notifikasi yang ditampilkan
    containerId: '#notifications-container',  // ID container notifikasi
    notificationUrl: baseURL + 'admin/notifications/latestNotifications'  // URL endpoint
});
```

## Method Publik

### 1. `refresh()`
Manual refresh notifikasi:
```javascript
window.refreshNotifications();
```

### 2. `startPolling()`
Mulai polling (otomatis saat init):
```javascript
window.notificationChecker.startPolling();
```

### 3. `stopPolling()`
Hentikan polling:
```javascript
window.notificationChecker.stopPolling();
```

### 4. `destroy()`
Destroy instance:
```javascript
window.notificationChecker.destroy();
```

## Browser Requirements
- Modern browsers yang support:
  - ES6 JavaScript
  - jQuery (untuk AJAX)
  - Bootstrap 5 CSS Framework
  - Fetch API atau AJAX

## Debugging

### Console Logs
Buka browser console (F12) untuk melihat:
- Initialization status
- Request/response logs
- Error messages

### Testing di Console
```javascript
// Cek instance
console.log(window.notificationChecker);

// Manual refresh
window.refreshNotifications();

// Stop polling
window.notificationChecker.stopPolling();

// Start polling lagi
window.notificationChecker.startPolling();
```

## Troubleshooting

### Notifikasi tidak muncul
1. Cek network tab di browser console
2. Verifikasi endpoint `admin/notifications/latestNotifications` accessible
3. Cek jQuery tersedia (needed untuk AJAX)
4. Cek localStorage browser tidak blokir cookies/session

### Toast tidak muncul
- Pastikan Bootstrap 5 CSS dan JS sudah loaded
- Cek konsol untuk error messages

### Polling tidak berjalan
- Cek `window.notificationChecker` di console
- Pastikan JavaScript tidak ada error
- Cek connectivitas internet

## Performance Notes
- AJAX requests 10 detik interval meminimalkan server load
- Data disimpan di memory, no page refresh diperlukan
- Animated transitions menggunakan CSS (smooth)
- Container limit 5 notifikasi untuk UX yang baik

## Keamanan
- AJAX calls authenticated via session
- Controller Notifications.php sudah check login status
- Role-based notifications (admin vs courier)
- CSRF protection via CodeIgniter framework

## Future Improvements
- [ ] WebSocket/SSE untuk real-time notifikasi yang lebih cepat
- [ ] Persistent notifications storage
- [ ] Notification center page
- [ ] Mark as read functionality
- [ ] Notification filters by type
- [ ] Sound alerts option
- [ ] Desktop notifications API integration
