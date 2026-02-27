/**
 * Notification Checker
 * Memeriksa notifikasi secara berkala setiap 10 detik
 * Menampilkan notifikasi di dashboard admin
 */

class NotificationChecker {
    constructor(options = {}) {
        this.checkInterval = options.checkInterval || 10000; // 10 seconds
        this.limit = options.limit || 5;
        this.containerId = options.containerId || '#notif-list';
        this.badgeSelector = options.badgeSelector || '#notif-count';
        this.pollInterval = null;
        this.lastNotificationCount = 0;
        this.isFirstFetch = true;
        this.notificationUrl = options.notificationUrl || '/admin/notifications/latestNotifications';
        
        // Initialize
        this.init();
    }

    /**
     * Initialize notification checker
     */
    init() {
        console.log('Notification Checker initialized');
        // Check immediately on load
        this.checkNotifications();
        // Then check periodically
        this.startPolling();
    }

    /**
     * Start polling notifications
     */
    startPolling() {
        this.pollInterval = setInterval(() => {
            this.checkNotifications();
        }, this.checkInterval);
    }

    /**
     * Stop polling notifications
     */
    stopPolling() {
        if (this.pollInterval) {
            clearInterval(this.pollInterval);
            this.pollInterval = null;
        }
    }

    /**
     * Check notifications from server
     */
    checkNotifications() {
        $.ajax({
            url: this.notificationUrl,
            type: 'GET',
            data: { limit: this.limit },
            dataType: 'json',
            success: (response) => {
                this.handleNotificationResponse(response);
            },
            error: (xhr, status, error) => {
                console.error('Error fetching notifications:', error);
            }
        });
    }

    /**
     * Handle notification response from server
     */
    handleNotificationResponse(response) {
        const { count, data } = response;

        // On first fetch: initialize count but do not show alert
        if (this.isFirstFetch) {
            this.lastNotificationCount = count;
            this.isFirstFetch = false;
        } else {
            // Check if there are new notifications since last fetch
            if (count > this.lastNotificationCount) {
                const newCount = count - this.lastNotificationCount;
                this.showNotificationAlert(newCount);
            }
            // Update last notification count
            this.lastNotificationCount = count;
        }

        // Render notifications
        this.renderNotifications(data);
        // Update badge if exists
        try {
            const badge = document.querySelector(this.badgeSelector);
            if (badge) {
                if (count && parseInt(count) > 0) {
                    badge.style.display = 'inline-block';
                    badge.textContent = count;
                } else {
                    badge.style.display = 'none';
                }
            }
        } catch (e) {
            console.warn('Failed to update notif badge', e);
        }
    }

    /**
     * Show notification alert/toast
     */
    showNotificationAlert(newCount) {
        const message = newCount === 1 
            ? 'Ada 1 notifikasi baru' 
            : `Ada ${newCount} notifikasi baru`;
        // show toast
        this.showToast(message, 'info');
        // also show a simple browser alert to make sure admin notices
        try { window.alert(message); } catch (e) { console.log('alert suppressed'); }
    }

    /**
     * Show toast notification
     */
    showToast(message, type = 'info') {
        const toastId = `toast-${Date.now()}`;
        const toastHTML = `
            <div id="${toastId}" class="toast align-items-center text-white bg-${this.getBootstrapClass(type)} border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        ${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        `;

        // Append toast to body
        const toastContainer = document.getElementById('toast-container') || this.createToastContainer();
        toastContainer.insertAdjacentHTML('beforeend', toastHTML);

        // Show toast using Bootstrap toast API
        const toastElement = document.getElementById(toastId);
        const toast = new bootstrap.Toast(toastElement);
        toast.show();

        // Remove element from DOM after hide
        toastElement.addEventListener('hidden.bs.toast', function() {
            toastElement.remove();
        });
    }

    /**
     * Create toast container if not exists
     */
    createToastContainer() {
        const container = document.createElement('div');
        container.id = 'toast-container';
        container.className = 'position-fixed bottom-0 end-0 p-3';
        container.style.zIndex = '11';
        document.body.appendChild(container);
        return container;
    }

    /**
     * Get Bootstrap color class based on notification type
     */
    getBootstrapClass(type) {
        const classMap = {
            'success': 'success',
            'error': 'danger',
            'warning': 'warning',
            'info': 'info',
            'primary': 'primary'
        };
        return classMap[type] || 'primary';
    }

    /**
     * Render notifications list
     */
    renderNotifications(notifications) {
        const container = document.querySelector(this.containerId);
        if (!container) {
            console.warn(`Container ${this.containerId} not found`);
            return;
        }

        // Clear existing notifications
        container.innerHTML = '';

        // If no notifications
        if (!notifications || notifications.length === 0) {
            const li = document.createElement('li');
            li.className = 'text-center small text-muted py-2';
            li.textContent = 'Belum ada notifikasi';
            container.appendChild(li);
            return;
        }

        // Render each notification as dropdown items
        notifications.forEach((n) => {
            const li = document.createElement('li');
            li.className = 'dropdown-item d-flex align-items-start';

            const a = document.createElement('a');
            a.className = 'd-flex align-items-start w-100 text-decoration-none text-reset';
            const href = (n.link) ? n.link : (window.baseURL ? window.baseURL + 'admin_orders' : '/admin_orders');
            a.href = href;
            a.innerHTML = '<div class="me-2 mt-1"><i class="fa fa-shopping-cart text-primary"></i></div>' +
                '<div><div class="small fw-bold">' + (n.title || '') + '</div>' +
                '<div class="small text-muted">' + (n.message || '') + '</div></div>';

            li.appendChild(a);
            container.appendChild(li);
        });
    }

    /**
     * Create individual notification element
     */
    createNotificationElement(notification, index) {
        const { order_id, title, message, created_at } = notification;
        const cleanTitle = title.replace('Order Baru #', '#');
        
        return `
            <div class="notification-item card mb-2 border-start border-4 border-primary" style="animation: slideIn 0.3s ease-out;">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-start">
                        <div style="flex: 1;">
                            <h6 class="card-title mb-1">
                                <i class="fas fa-circle-info text-primary me-2"></i>${cleanTitle}
                            </h6>
                            <p class="card-text text-muted small mb-2">${message}</p>
                            ${created_at ? `<small class="text-muted">${this.formatTime(created_at)}</small>` : ''}
                        </div>
                        <button class="btn btn-sm btn-outline-primary" onclick="window.location.href='/admin_orders'">
                            Lihat
                        </button>
                    </div>
                </div>
            </div>
        `;
    }

    /**
     * Format notification time
     */
    formatTime(timestamp) {
        try {
            const date = new Date(timestamp);
            const now = new Date();
            const diffMs = now - date;
            const diffMins = Math.floor(diffMs / 60000);
            const diffHours = Math.floor(diffMs / 3600000);
            const diffDays = Math.floor(diffMs / 86400000);

            if (diffMins < 1) return 'Sekarang';
            if (diffMins < 60) return `${diffMins} menit lalu`;
            if (diffHours < 24) return `${diffHours} jam lalu`;
            if (diffDays < 7) return `${diffDays} hari lalu`;
            
            return date.toLocaleDateString('id-ID');
        } catch (e) {
            return timestamp;
        }
    }

    /**
     * Manual refresh notifications
     */
    refresh() {
        this.checkNotifications();
    }

    /**
     * Destroy checker instance
     */
    destroy() {
        this.stopPolling();
    }
}

// Auto-initialize when document is ready
document.addEventListener('DOMContentLoaded', function() {
    // Initialize notification checker if jQuery is available
    if (typeof $ !== 'undefined') {
        window.notificationChecker = new NotificationChecker({
            checkInterval: 10000, // 10 seconds
            limit: 5,
            containerId: '#notif-list',
            badgeSelector: '#notif-count',
            notificationUrl: (window.baseURL || '') + 'admin/notifications/latestNotifications'
        });

        // Expose refresh function to window for manual refresh if needed
        window.refreshNotifications = function() {
            window.notificationChecker.refresh();
        };
    } else {
        console.warn('jQuery is required for NotificationChecker');
    }
});
