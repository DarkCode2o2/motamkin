/**
 * Premium Reviews System - Master JavaScript
 * Motamkin Special Mobile Numbers Store
 */

class ReviewsSystem {
    constructor() {
        this.apiUrl = 'api/reviews.php';
        this.currentRating = 5;
        this.reviewsCache = [];
        
        this.init();
    }
    
    init() {
        // Initialize marquee if exists
        if (document.querySelector('.reviews-marquee-section')) {
            this.loadMarqueeReviews();
        }
        
        // Initialize form if exists
        if (document.querySelector('#reviewForm')) {
            this.initForm();
        }
    }
    
    /**
     * Load approved reviews for marquee
     */
    async loadMarqueeReviews() {
        try {
            const response = await fetch(`${this.apiUrl}?status=1`);
            const result = await response.json();
            
            if (result.success && result.data.length > 0) {
                this.reviewsCache = result.data;
                this.renderMarquee(result.data);
            }
        } catch (error) {
            console.error('Failed to load reviews:', error);
        }
    }
    
    /**
     * Render marquee with reviews
     */
    renderMarquee(reviews) {
        const track = document.querySelector('.reviews-marquee-track');
        if (!track) return;
        console.log(reviews)
        // Duplicate reviews for seamless loop
        const duplicatedReviews = [...reviews, ...reviews];
        
        track.innerHTML = duplicatedReviews.map(review => this.createMarqueeCard(review)).join('');
    }
    
    /**
     * Create marquee review card HTML
     */
    createMarqueeCard(review) {
        const stars = this.generateStars(review.rating);
        const content = this.escapeHtml(review.content);
        const name = this.escapeHtml(review.name);
        
        return `
            <div class="review-card-marquee fade-in">
                <div class="review-card-header">
                    <div class="review-card-name">${name}</div>
                    <div class="review-card-stars">${stars}</div>
                </div>
                <div class="review-card-content">${content}</div>
            </div>
        `;
    }
    
    /**
     * Generate stars HTML
     */
    generateStars(rating) {
        let stars = '';
        for (let i = 1; i <= 5; i++) {
            const className = i <= rating ? 'star' : 'star empty';
            stars += `<span class="${className}">★</span>`;
        }
        return stars;
    }
    
    /**
     * Initialize review submission form
     */
    initForm() {
        const form = document.getElementById('reviewForm');
        const starBtns = document.querySelectorAll('#mainRatingSelector .star-btn');
        const messageDiv = document.querySelector('.review-form-message');
        
        // Set initial rating
        this.currentRating = 5;
        this.updateStars(5);
        
        // Star rating click handlers
        starBtns.forEach((btn, index) => {
            const rating = index + 1;
            
            btn.addEventListener('click', () => {
                this.currentRating = rating;
                this.updateStars(rating);
            });
            
            // Hover effect
            btn.addEventListener('mouseenter', () => {
                this.previewStars(rating);
            });
            
            btn.addEventListener('mouseleave', () => {
                this.updateStars(this.currentRating);
            });
        });
        
        // Form submission
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const name = document.getElementById('reviewName').value.trim();
            const content = document.getElementById('reviewContent').value.trim();
            
            if (!name || !content) {
                this.showMessage('الرجاء ملء جميع الحقول', 'error');
                return;
            }
            
            await this.submitReview({ name, content, rating: this.currentRating });
        });
        
        // Reset message on input
        form.querySelectorAll('input, textarea').forEach(input => {
            input.addEventListener('input', () => {
                messageDiv.className = 'review-form-message';
                messageDiv.textContent = '';
            });
        });
        
        // Character count for textarea
        const textarea = document.getElementById('reviewContent');
        const charCount = document.getElementById('charCount');
        
        if (textarea && charCount) {
            textarea.addEventListener('input', () => {
                const count = textarea.value.length;
                charCount.textContent = count;
                
                // Change color if near limit
                if (count > 900) {
                    charCount.style.color = '#ef4444';
                } else if (count > 700) {
                    charCount.style.color = '#fbbf24';
                } else {
                    charCount.style.color = 'var(--review-text-muted)';
                }
            });
        }
    }
    
    /**
     * Update star display
     */
    updateStars(rating) {
        const starBtns = document.querySelectorAll('.star-btn');
        starBtns.forEach((btn, index) => {
            if (index < rating) {
                btn.classList.add('active');
            } else {
                btn.classList.remove('active');
            }
        });
    }
    
    /**
     * Preview stars on hover
     */
    previewStars(rating) {
        const starBtns = document.querySelectorAll('.star-btn');
        starBtns.forEach((btn, index) => {
            if (index < rating) {
                btn.classList.add('active');
            }
        });
    }
    
    /**
     * Submit review to API
     */
    async submitReview(data) {
        const submitBtn = document.querySelector('.review-form-submit');
        const messageDiv = document.querySelector('.review-form-message');
        
        // Show loading state
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner"></span> جاري الإرسال...';
        
        try {
            const response = await fetch(this.apiUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data)
            });
            
            const result = await response.json();
            
            if (result.success) {
                this.showMessage(result.message, 'success');
                document.getElementById('reviewForm').reset();
                this.currentRating = 5;
                this.updateStars(5);
            } else {
                this.showMessage(result.message || 'حدث خطأ أثناء الإرسال', 'error');
            }
        } catch (error) {
            console.error('Submit error:', error);
            this.showMessage('فشل الاتصال بالخادم', 'error');
        } finally {
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'إرسال التقييم';
        }
    }
    
    /**
     * Show message to user
     */
    showMessage(text, type) {
        const messageDiv = document.querySelector('.review-form-message');
        messageDiv.textContent = text;
        messageDiv.className = `review-form-message ${type}`;
        
        // Auto hide after 5 seconds
        setTimeout(() => {
            messageDiv.className = 'review-form-message';
            messageDiv.textContent = '';
        }, 5000);
    }
    
    /**
     * Escape HTML to prevent XSS
     */
    escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
}

/**
 * Admin Reviews Manager Class
 */
class AdminReviewsManager {
    constructor() {
        this.apiUrl = '../api/reviews.php';
        this.currentReview = null;
        this.init();
    }
    
    init() {
        if (document.querySelector('.admin-reviews-section')) {
            this.loadAllReviews();
            this.initModal();
        }
    }
    
    /**
     * Load all reviews for admin
     */
    async loadAllReviews() {
        try {
            const response = await fetch(this.apiUrl);
            const result = await response.json();
            
            if (result.success) {
                this.renderTable(result.data);
                this.updateStats(result.data);
            }
        } catch (error) {
            console.error('Failed to load reviews:', error);
        }
    }
    
    /**
     * Render reviews table
     */
    renderTable(reviews) {
        const tbody = document.querySelector('#reviewsTableBody');
        if (!tbody) return;
        
        if (reviews.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="6">
                        <div class="empty-state">
                            <div class="empty-state-icon">📝</div>
                            <div class="empty-state-text">لا توجد تقييمات حتى الآن</div>
                        </div>
                    </td>
                </tr>
            `;
            return;
        }
        
        tbody.innerHTML = reviews.map(review => this.createTableRow(review)).join('');
        
        // Attach event listeners
        this.attachRowListeners();
    }
    
    /**
     * Create table row HTML
     */
    createTableRow(review) {
        const statusClass = review.status == 1 ? 'approved' : 'pending';
        const statusText = review.status == 1 ? 'معتمد' : 'قيد الانتظار';
        const stars = this.generateStars(review.rating);
        const date = new Date(review.created_at).toLocaleDateString('ar-SA');
        
        return `
            <tr data-id="${review.id}">
                <td>${review.id}</td>
                <td>${this.escapeHtml(review.name)}</td>
                <td style="max-width: 300px;">${this.escapeHtml(review.content)}</td>
                <td>
                    <div style="display: flex; gap: 2px; direction: ltr; justify-content: center;">
                        ${stars}
                    </div>
                </td>
                <td>
                    <span class="status-badge ${statusClass}">
                        <span class="status-icon"></span>
                        ${statusText}
                    </span>
                </td>
                <td>${date}</td>
                <td>
                    <div class="admin-actions">
                        ${review.status == 0 ? `
                            <button class="admin-btn approve" title="اعتماد" data-action="approve">
                                <i class="fas fa-check"></i>
                            </button>
                        ` : ''}
                        <button class="admin-btn edit" title="تعديل" data-action="edit">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="admin-btn delete" title="حذف" data-action="delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
        `;
    }
    
    /**
     * Generate stars HTML
     */
    generateStars(rating) {
        let stars = '';
        for (let i = 1; i <= 5; i++) {
            const className = i <= rating ? 'star' : 'star empty';
            stars += `<span class="${className}">★</span>`;
        }
        return stars;
    }
    
    /**
     * Update statistics
     */
    updateStats(reviews) {
        const total = reviews.length;
        const approved = reviews.filter(r => r.status == 1).length;
        const pending = reviews.filter(r => r.status == 0).length;
        
        const totalEl = document.querySelector('#totalReviews');
        const approvedEl = document.querySelector('#approvedReviews');
        const pendingEl = document.querySelector('#pendingReviews');
        
        if (totalEl) totalEl.textContent = total;
        if (approvedEl) approvedEl.textContent = approved;
        if (pendingEl) pendingEl.textContent = pending;
    }
    
    /**
     * Attach event listeners to table rows
     */
    attachRowListeners() {
        document.querySelectorAll('[data-action]').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                const action = btn.dataset.action;
                const row = btn.closest('tr');
                const id = parseInt(row.dataset.id);
                
                switch (action) {
                    case 'approve':
                        this.approveReview(id);
                        break;
                    case 'edit':
                        this.editReview(id);
                        break;
                    case 'delete':
                        this.deleteReview(id);
                        break;
                }
            });
        });
    }
    
    /**
     * Approve review
     */
    async approveReview(id) {
        if (!confirm('هل أنت متأكد من اعتماد هذا التقييم؟')) return;
        
        try {
            const response = await fetch(this.apiUrl, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id, status: 1 })
            });
            
            const result = await response.json();
            
            if (result.success) {
                this.loadAllReviews();
                this.showToast('تم اعتماد التقييم بنجاح', 'success');
            } else {
                this.showToast(result.message || 'حدث خطأ', 'error');
            }
        } catch (error) {
            console.error('Approve error:', error);
            this.showToast('فشل الاتصال بالخادم', 'error');
        }
    }
    
    /**
     * Edit review
     */
    async editReview(id) {
        // Find review in cache or fetch
        const row = document.querySelector(`tr[data-id="${id}"]`);
        const cells = row.querySelectorAll('td');
        
        this.currentReview = {
            id: id,
            name: cells[1].textContent.trim(),
            content: cells[2].textContent.trim(),
            rating: this.extractRating(cells[3].innerHTML),
            status: row.querySelector('.status-badge.approved') ? 1 : 0
        };
        
        // Populate modal
        document.getElementById('editName').value = this.currentReview.name;
        document.getElementById('editContent').value = this.currentReview.content;
        
        // Set rating stars
        const starBtns = document.querySelectorAll('#editRatingModal .star-btn');
        starBtns.forEach((btn, index) => {
            if (index < this.currentReview.rating) {
                btn.classList.add('active');
            } else {
                btn.classList.remove('active');
            }
        });
        
        // Set status
        document.getElementById('editStatus').checked = this.currentReview.status == 1;
        
        // Show modal
        this.openModal();
    }
    
    /**
     * Extract rating from stars HTML
     */
    extractRating(starsHtml) {
        const matches = starsHtml.match(/class="star"[^>]*>/g);
        return matches ? matches.length : 0;
    }
    
    /**
     * Save edited review
     */
    async saveReview() {
        if (!this.currentReview) return;
        
        const name = document.getElementById('editName').value.trim();
        const content = document.getElementById('editContent').value.trim();
        const status = document.getElementById('editStatus').checked ? 1 : 0;
        
        // Get rating from modal stars
        const starBtns = document.querySelectorAll('#editRatingModal .star-btn');
        let rating = 0;
        starBtns.forEach((btn, index) => {
            if (btn.classList.contains('active')) rating = index + 1;
        });
        
        if (!name || !content) {
            this.showToast('الرجاء ملء جميع الحقول', 'error');
            return;
        }
        
        try {
            const response = await fetch(this.apiUrl, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    id: this.currentReview.id,
                    name,
                    content,
                    rating,
                    status
                })
            });
            
            const result = await response.json();
            
            if (result.success) {
                this.closeModal();
                this.loadAllReviews();
                this.showToast('تم تحديث التقييم بنجاح', 'success');
            } else {
                this.showToast(result.message || 'حدث خطأ', 'error');
            }
        } catch (error) {
            console.error('Save error:', error);
            this.showToast('فشل الاتصال بالخادم', 'error');
        }
    }
    
    /**
     * Delete review
     */
    async deleteReview(id) {
        if (!confirm('هل أنت متأكد من حذف هذا التقييم؟ لا يمكن التراجع عن هذا الإجراء.')) return;
        
        try {
            const response = await fetch(this.apiUrl, {
                method: 'DELETE',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id })
            });
            
            const result = await response.json();
            
            if (result.success) {
                this.loadAllReviews();
                this.showToast('تم حذف التقييم بنجاح', 'success');
            } else {
                this.showToast(result.message || 'حدث خطأ', 'error');
            }
        } catch (error) {
            console.error('Delete error:', error);
            this.showToast('فشل الاتصال بالخادم', 'error');
        }
    }
    
    /**
     * Initialize modal
     */
    initModal() {
        const modal = document.getElementById('editModal');
        const closeBtn = document.querySelector('.modal-close');
        const cancelBtn = document.querySelector('.modal-btn.secondary');
        const saveBtn = document.querySelector('.modal-btn.primary');
        const starBtns = document.querySelectorAll('#editRatingModal .star-btn');
        
        // Close modal events
        if (closeBtn) {
            closeBtn.addEventListener('click', () => this.closeModal());
        }
        if (cancelBtn) {
            cancelBtn.addEventListener('click', () => this.closeModal());
        }
        
        // Save button
        if (saveBtn) {
            saveBtn.addEventListener('click', () => this.saveReview());
        }
        
        // Star rating in modal
        starBtns.forEach((btn, index) => {
            btn.addEventListener('click', () => {
                const rating = index + 1;
                starBtns.forEach((b, i) => {
                    if (i < rating) {
                        b.classList.add('active');
                    } else {
                        b.classList.remove('active');
                    }
                });
            });
        });
        
        // Close on overlay click
        if (modal) {
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    this.closeModal();
                }
            });
        }
        
        // Close on Escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && modal.classList.contains('active')) {
                this.closeModal();
            }
        });
    }
    
    /**
     * Open modal
     */
    openModal() {
        const modal = document.getElementById('editModal');
        if (modal) {
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
    }
    
    /**
     * Close modal
     */
    closeModal() {
        const modal = document.getElementById('editModal');
        if (modal) {
            modal.classList.remove('active');
            document.body.style.overflow = '';
        }
        this.currentReview = null;
    }
    
    /**
     * Show toast notification
     */
    showToast(message, type) {
        // Remove existing toast
        const existingToast = document.querySelector('.toast-notification');
        if (existingToast) {
            existingToast.remove();
        }
        
        // Create toast
        const toast = document.createElement('div');
        toast.className = `toast-notification toast-${type}`;
        toast.innerHTML = `
            <span>${message}</span>
            <button onclick="this.parentElement.remove()">&times;</button>
        `;
        
        // Add styles
        toast.style.cssText = `
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            padding: 16px 24px;
            background: ${type === 'success' ? 'rgba(34, 197, 94, 0.95)' : 'rgba(239, 68, 68, 0.95)'};
            color: white;
            border-radius: 8px;
            font-family: 'Tajawal', sans-serif;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 12px;
            z-index: 10000;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            animation: slideDown 0.3s ease;
        `;
        
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideDown {
                from {
                    opacity: 0;
                    transform: translateX(-50%) translateY(-20px);
                }
                to {
                    opacity: 1;
                    transform: translateX(-50%) translateY(0);
                }
            }
            .toast-notification button {
                background: none;
                border: none;
                color: white;
                font-size: 20px;
                cursor: pointer;
                padding: 0;
                line-height: 1;
            }
        `;
        document.head.appendChild(style);
        document.body.appendChild(toast);
        
        // Auto remove after 4 seconds
        setTimeout(() => {
            if (toast.parentElement) {
                toast.remove();
            }
        }, 4000);
    }
    
    /**
     * Escape HTML
     */
    escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
}

// Initialize on DOM load
document.addEventListener('DOMContentLoaded', () => {
    // Initialize reviews system
    new ReviewsSystem();
    
    // Initialize admin manager if in admin panel
    if (document.querySelector('.admin-reviews-section')) {
        new AdminReviewsManager();
    }
});
