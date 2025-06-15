// Banner Popup System
class BannerPopup {
    constructor() {
        this.apiUrl = 'controllers/BannerController.php';
        this.sessionKey = 'banner_shown_';
        this.popupContainer = null;
        this.currentBanner = null;
        this.init();
    }

    init() {
        // Load banner khi DOM ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => this.loadBanners());
        } else {
            this.loadBanners();
        }
    }

    async loadBanners() {
        try {
            const response = await fetch(this.apiUrl + '?action=getActiveBanners');
            const data = await response.json();
            
            if (data.success && data.banners.length > 0) {
                this.processBanners(data.banners);
            }
        } catch (error) {
            console.error('Error loading banners:', error);
        }
    }

    processBanners(banners) {
        // Lọc banner popup
        const popupBanners = banners.filter(banner => banner.loai_hien_thi === 'popup');
        
        if (popupBanners.length > 0) {
            // Sắp xếp theo thứ tự
            popupBanners.sort((a, b) => a.thu_tu - b.thu_tu);
            
            // Hiển thị banner đầu tiên chưa được hiển thị
            for (const banner of popupBanners) {
                if (this.shouldShowBanner(banner)) {
                    this.showPopup(banner);
                    break;
                }
            }
        }

        // Xử lý banner top/bottom/sidebar
        this.processBannerPositions(banners);
    }

    shouldShowBanner(banner) {
        // Kiểm tra thời gian hiển thị
        if (banner.ngay_bat_dau && new Date(banner.ngay_bat_dau) > new Date()) {
            return false;
        }
        
        if (banner.ngay_ket_thuc && new Date(banner.ngay_ket_thuc) < new Date()) {
            return false;
        }

        // Kiểm tra đã hiển thị chưa (nếu chỉ hiển thị 1 lần)
        if (banner.hien_thi_lan_duy_nhat) {
            const sessionKey = this.sessionKey + banner.id;
            if (sessionStorage.getItem(sessionKey)) {
                return false;
            }
        }

        return true;
    }

    showPopup(banner) {
        this.currentBanner = banner;
        
        // Tạo popup container
        this.createPopupContainer(banner);
        
        // Mark as shown
        if (banner.hien_thi_lan_duy_nhat) {
            sessionStorage.setItem(this.sessionKey + banner.id, '1');
        }

        // Track view
        this.trackView(banner.id);

        // Auto close sau thời gian quy định
        if (banner.thoi_gian_hien_thi > 0) {
            setTimeout(() => {
                this.closePopup();
            }, banner.thoi_gian_hien_thi);
        }
    }

    createPopupContainer(banner) {
        // Tạo overlay
        const overlay = document.createElement('div');
        overlay.id = 'banner-popup-overlay';
        overlay.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            z-index: 10000;
            display: flex;
            justify-content: center;
            align-items: center;
            animation: fadeIn 0.3s ease-in-out;
        `;

        // Tạo popup content
        const popup = document.createElement('div');
        popup.id = 'banner-popup';
        popup.style.cssText = `
            position: relative;
            max-width: 90%;
            max-height: 90%;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            animation: slideIn 0.3s ease-in-out;
        `;

        // Nút đóng
        const closeBtn = document.createElement('button');
        closeBtn.innerHTML = '&times;';
        closeBtn.style.cssText = `
            position: absolute;
            top: 10px;
            right: 15px;
            background: rgba(255, 255, 255, 0.9);
            border: none;
            font-size: 24px;
            font-weight: bold;
            color: #333;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            cursor: pointer;
            z-index: 10001;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        `;
        
        closeBtn.onmouseover = () => {
            closeBtn.style.background = 'rgba(255, 0, 0, 0.8)';
            closeBtn.style.color = 'white';
        };
        
        closeBtn.onmouseout = () => {
            closeBtn.style.background = 'rgba(255, 255, 255, 0.9)';
            closeBtn.style.color = '#333';
        };

        closeBtn.onclick = () => this.closePopup();

        // Hình ảnh banner
        const img = document.createElement('img');
        img.src = banner.hinh_anh;
        img.alt = banner.ten_banner;
        img.style.cssText = `
            width: 100%;
            height: auto;
            display: block;
            cursor: ${banner.link_url ? 'pointer' : 'default'};
        `;

        if (banner.link_url) {
            img.onclick = () => {
                this.trackClick(banner.id);
                if (banner.link_url.startsWith('http')) {
                    window.open(banner.link_url, '_blank');
                } else {
                    window.location.href = banner.link_url;
                }
                this.closePopup();
            };
        }

        // Ghép các elements
        popup.appendChild(closeBtn);
        popup.appendChild(img);
        overlay.appendChild(popup);

        // Thêm CSS animations
        this.addPopupStyles();

        // Thêm vào DOM
        document.body.appendChild(overlay);
        this.popupContainer = overlay;

        // Close khi click overlay
        overlay.onclick = (e) => {
            if (e.target === overlay) {
                this.closePopup();
            }
        };

        // Close với ESC key
        document.addEventListener('keydown', this.handleEscKey.bind(this));
    }

    addPopupStyles() {
        if (document.getElementById('banner-popup-styles')) return;

        const style = document.createElement('style');
        style.id = 'banner-popup-styles';
        style.textContent = `
            @keyframes fadeIn {
                from { opacity: 0; }
                to { opacity: 1; }
            }
            
            @keyframes slideIn {
                from { 
                    opacity: 0;
                    transform: scale(0.8) translateY(-20px); 
                }
                to { 
                    opacity: 1;
                    transform: scale(1) translateY(0); 
                }
            }
            
            @keyframes fadeOut {
                from { opacity: 1; }
                to { opacity: 0; }
            }
            
            @keyframes slideOut {
                from { 
                    opacity: 1;
                    transform: scale(1) translateY(0); 
                }
                to { 
                    opacity: 0;
                    transform: scale(0.8) translateY(-20px); 
                }
            }
        `;
        document.head.appendChild(style);
    }

    handleEscKey(e) {
        if (e.key === 'Escape' && this.popupContainer) {
            this.closePopup();
        }
    }

    closePopup() {
        if (!this.popupContainer) return;

        // Add closing animation
        this.popupContainer.style.animation = 'fadeOut 0.3s ease-in-out';
        const popup = this.popupContainer.querySelector('#banner-popup');
        if (popup) {
            popup.style.animation = 'slideOut 0.3s ease-in-out';
        }

        setTimeout(() => {
            if (this.popupContainer && this.popupContainer.parentNode) {
                this.popupContainer.parentNode.removeChild(this.popupContainer);
            }
            this.popupContainer = null;
            document.removeEventListener('keydown', this.handleEscKey.bind(this));
        }, 300);
    }

    processBannerPositions(banners) {
        // Xử lý banner top
        const topBanners = banners.filter(b => b.loai_hien_thi === 'banner_top' && this.shouldShowBanner(b));
        if (topBanners.length > 0) {
            this.showPositionBanner(topBanners[0], 'top');
        }

        // Xử lý banner bottom
        const bottomBanners = banners.filter(b => b.loai_hien_thi === 'banner_bottom' && this.shouldShowBanner(b));
        if (bottomBanners.length > 0) {
            this.showPositionBanner(bottomBanners[0], 'bottom');
        }

        // Xử lý sidebar banner
        const sidebarBanners = banners.filter(b => b.loai_hien_thi === 'sidebar' && this.shouldShowBanner(b));
        if (sidebarBanners.length > 0) {
            this.showPositionBanner(sidebarBanners[0], 'sidebar');
        }
    }

    showPositionBanner(banner, position) {
        const container = document.createElement('div');
        container.id = `banner-${position}`;
        container.style.cssText = this.getPositionStyles(position);

        const img = document.createElement('img');
        img.src = banner.hinh_anh;
        img.alt = banner.ten_banner;
        img.style.cssText = 'width: 100%; height: auto; display: block;';

        if (banner.link_url) {
            img.style.cursor = 'pointer';
            img.onclick = () => {
                this.trackClick(banner.id);
                if (banner.link_url.startsWith('http')) {
                    window.open(banner.link_url, '_blank');
                } else {
                    window.location.href = banner.link_url;
                }
            };
        }

        container.appendChild(img);
        document.body.appendChild(container);

        // Track view
        this.trackView(banner.id);
    }

    getPositionStyles(position) {
        const baseStyles = 'position: fixed; z-index: 1000; left: 50%; transform: translateX(-50%);';
        
        switch (position) {
            case 'top':
                return baseStyles + 'top: 0; max-width: 100%;';
            case 'bottom':
                return baseStyles + 'bottom: 0; max-width: 100%;';
            case 'sidebar':
                return 'position: fixed; top: 50%; right: 20px; transform: translateY(-50%); z-index: 1000; max-width: 300px;';
            default:
                return baseStyles;
        }
    }

    async trackView(bannerId) {
        try {
            await fetch(this.apiUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `action=trackView&banner_id=${bannerId}`
            });
        } catch (error) {
            console.error('Error tracking view:', error);
        }
    }

    async trackClick(bannerId) {
        try {
            await fetch(this.apiUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `action=trackClick&banner_id=${bannerId}`
            });
        } catch (error) {
            console.error('Error tracking click:', error);
        }
    }
}

// Khởi tạo banner system
new BannerPopup();
