
const Notification = {
    showLoginRequired: function() {
        this.show({
            icon: 'fas fa-lock',
            iconColor: '#EF4444',
            title: 'Login Diperlukan',
            message: 'Anda harus login terlebih dahulu untuk mengakses halaman ini!',
            buttonText: 'Login Sekarang',
            buttonColor: '#3B82F6',
            onConfirm: function() {
                window.location.href = '/login';
            }
        });
    },

    /**
     * Show Success Notification
     */
    showSuccess: function(title, message, callback = null) {
        this.show({
            icon: 'fas fa-check-circle',
            iconColor: '#22C55E',
            title: title,
            message: message,
            buttonText: 'OK',
            buttonColor: '#22C55E',
            onConfirm: callback
        });
    },

    /**
     * Show Error Notification
     */
    showError: function(title, message, callback = null) {
        this.show({
            icon: 'fas fa-exclamation-circle',
            iconColor: '#EF4444',
            title: title,
            message: message,
            buttonText: 'OK',
            buttonColor: '#EF4444',
            onConfirm: callback
        });
    },

    /**
     * Show Warning Notification
     */
    showWarning: function(title, message, callback = null) {
        this.show({
            icon: 'fas fa-exclamation-triangle',
            iconColor: '#FFC107',
            title: title,
            message: message,
            buttonText: 'OK',
            buttonColor: '#FFC107',
            onConfirm: callback
        });
    },

    /**
     * Show Info Notification
     */
    showInfo: function(title, message, callback = null) {
        this.show({
            icon: 'fas fa-info-circle',
            iconColor: '#3B82F6',
            title: title,
            message: message,
            buttonText: 'OK',
            buttonColor: '#3B82F6',
            onConfirm: callback
        });
    },

    /**
     * Show Confirmation Dialog
     */
    showConfirm: function(title, message, onConfirm, onCancel = null) {
        const modalHTML = `
            <div class="notification-overlay" id="notificationOverlay">
                <div class="notification-modal notification-confirm">
                    <div class="notification-icon" style="background: rgba(59, 130, 246, 0.15);">
                        <i class="fas fa-question-circle" style="color: #3B82F6;"></i>
                    </div>
                    <h2 class="notification-title">${title}</h2>
                    <p class="notification-message">${message}</p>
                    <div class="notification-buttons">
                        <button class="notification-btn notification-btn-cancel" id="notificationCancel">
                            <i class="fas fa-times"></i> Batal
                        </button>
                        <button class="notification-btn notification-btn-confirm" id="notificationConfirm">
                            <i class="fas fa-check"></i> Ya, Lanjutkan
                        </button>
                    </div>
                </div>
            </div>
        `;

        document.body.insertAdjacentHTML('beforeend', modalHTML);
        
        const overlay = document.getElementById('notificationOverlay');
        const btnConfirm = document.getElementById('notificationConfirm');
        const btnCancel = document.getElementById('notificationCancel');

        setTimeout(() => overlay.classList.add('active'), 10);

        const closeModal = () => {
            overlay.classList.remove('active');
            setTimeout(() => overlay.remove(), 300);
        };

        btnConfirm.addEventListener('click', () => {
            closeModal();
            if (onConfirm) onConfirm();
        });

        btnCancel.addEventListener('click', () => {
            closeModal();
            if (onCancel) onCancel();
        });

        overlay.addEventListener('click', (e) => {
            if (e.target === overlay) {
                closeModal();
                if (onCancel) onCancel();
            }
        });
    },

    /**
     * Main Show Function
     */
    show: function(options) {
        const {
            icon = 'fas fa-info-circle',
            iconColor = '#3B82F6',
            title = 'Notifikasi',
            message = '',
            buttonText = 'OK',
            buttonColor = '#3B82F6',
            onConfirm = null
        } = options;

        const modalHTML = `
            <div class="notification-overlay" id="notificationOverlay">
                <div class="notification-modal">
                    <div class="notification-icon" style="background: ${this.hexToRgba(iconColor, 0.15)};">
                        <i class="${icon}" style="color: ${iconColor};"></i>
                    </div>
                    <h2 class="notification-title">${title}</h2>
                    <p class="notification-message">${message}</p>
                    <button class="notification-btn" id="notificationBtn" style="background: ${buttonColor};">
                        ${buttonText}
                    </button>
                </div>
            </div>
        `;

        document.body.insertAdjacentHTML('beforeend', modalHTML);
        
        const overlay = document.getElementById('notificationOverlay');
        const btn = document.getElementById('notificationBtn');

        setTimeout(() => overlay.classList.add('active'), 10);

        const closeModal = () => {
            overlay.classList.remove('active');
            setTimeout(() => overlay.remove(), 300);
        };

        btn.addEventListener('click', () => {
            closeModal();
            if (onConfirm) onConfirm();
        });

        overlay.addEventListener('click', (e) => {
            if (e.target === overlay) {
                closeModal();
            }
        });
    },

    /**
     * Helper: Convert HEX to RGBA
     */
    hexToRgba: function(hex, alpha) {
        const r = parseInt(hex.slice(1, 3), 16);
        const g = parseInt(hex.slice(3, 5), 16);
        const b = parseInt(hex.slice(5, 7), 16);
        return `rgba(${r}, ${g}, ${b}, ${alpha})`;
    }
};

// Auto-inject CSS untuk notification
const notificationCSS = `
    <style id="notification-styles">
        .notification-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(8px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            opacity: 0;
            transition: opacity 0.3s ease;
            padding: 1rem;
        }

        .notification-overlay.active {
            opacity: 1;
        }

        .notification-modal {
            background: rgba(30, 30, 30, 0.98);
            backdrop-filter: blur(20px);
            border: 2px solid rgba(59, 130, 246, 0.3);
            border-radius: 20px;
            padding: 2.5rem;
            max-width: 450px;
            width: 100%;
            text-align: center;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
            animation: modalSlideUp 0.3s ease;
            position: relative;
        }

        @keyframes modalSlideUp {
            from {
                opacity: 0;
                transform: translateY(30px) scale(0.95);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .notification-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            animation: iconPulse 2s ease infinite;
        }

        @keyframes iconPulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .notification-icon i {
            font-size: 2.5rem;
        }

        .notification-title {
            color: #fff;
            font-size: 1.6rem;
            margin-bottom: 1rem;
            font-weight: 600;
        }

        .notification-message {
            color: #D1D5DB;
            font-size: 1rem;
            line-height: 1.6;
            margin-bottom: 2rem;
        }

        .notification-btn {
            padding: 1rem 2.5rem;
            border: none;
            border-radius: 12px;
            color: #fff;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
        }

        .notification-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 32px rgba(0, 0, 0, 0.4);
        }

        .notification-btn:active {
            transform: translateY(0);
        }

        .notification-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-top: 2rem;
        }

        .notification-btn-cancel {
            background: rgba(107, 114, 128, 0.3);
            border: 2px solid rgba(107, 114, 128, 0.5);
            color: #D1D5DB;
        }

        .notification-btn-cancel:hover {
            background: rgba(107, 114, 128, 0.5);
        }

        .notification-btn-confirm {
            background: linear-gradient(135deg, #3B82F6, #2563EB);
        }

        @media (max-width: 768px) {
            .notification-modal {
                padding: 2rem 1.5rem;
            }

            .notification-title {
                font-size: 1.3rem;
            }

            .notification-icon {
                width: 70px;
                height: 70px;
            }

            .notification-icon i {
                font-size: 2rem;
            }

            .notification-buttons {
                flex-direction: column;
            }

            .notification-btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
`;

// Inject CSS jika belum ada
if (!document.getElementById('notification-styles')) {
    document.head.insertAdjacentHTML('beforeend', notificationCSS);
}

// Export untuk digunakan di file lain
if (typeof module !== 'undefined' && module.exports) {
    module.exports = Notification;
}