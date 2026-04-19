<?php 
    $pageTitle = "إدارة التقييمات";
    session_start();
    
    include_once '../connect.php';
    include_once '../config/helpers.php';

    // Check authentication - only Super Admin (role == 0) can access
    if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 0) {
        header('Location: ../index.php');
        exit;
    }

    // Initialize variables
    $msg = '';
    $msgClass = '';

    // Handle approve action
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['approve_review'])) {
        $review_id = filter_var($_POST['review_id'], FILTER_SANITIZE_NUMBER_INT);
        
        try {
            $stmt = $con->prepare("UPDATE reviews SET status = 1 WHERE id = ?");
            $stmt->execute([$review_id]);
            $msg = 'تم اعتماد التقييم بنجاح';
            $msgClass = 'success';
        } catch(PDOException $e) {
            $msg = 'حدث خطأ أثناء اعتماد التقييم';
            $msgClass = 'danger';
        }
    }

    // Handle delete action
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_review'])) {
        $review_id = filter_var($_POST['review_id'], FILTER_SANITIZE_NUMBER_INT);
        
        try {
            $stmt = $con->prepare("DELETE FROM reviews WHERE id = ?");
            $stmt->execute([$review_id]);
            $msg = 'تم حذف التقييم بنجاح';
            $msgClass = 'success';
        } catch(PDOException $e) {
            $msg = 'حدث خطأ أثناء حذف التقييم';
            $msgClass = 'danger';
        }
    }

    // Get all reviews
    $reviews = getData('reviews', null, null, 'ORDER BY created_at DESC', true);

    // Count stats
    $totalReviews = getReviewCount();
    $approvedReviews = getReviewCount(1);
    $pendingReviews = getReviewCount(0);

    ob_start();
?>

<!-- Stats Cards -->
<div class="reviews-stats-row mb-4">
    <div class="stat-card">
        <div class="stat-value"><?php echo $totalReviews; ?></div>
        <div class="stat-label">إجمالي التقييمات</div>
    </div>
    <div class="stat-card">
        <div class="stat-value text-success"><?php echo $approvedReviews; ?></div>
        <div class="stat-label">معتمدة</div>
    </div>
    <div class="stat-card">
        <div class="stat-value text-warning"><?php echo $pendingReviews; ?></div>
        <div class="stat-label">قيد الانتظار</div>
    </div>
</div>

<!-- Message Alert -->
<?php if($msg): ?>
    <div class="alert alert-<?php echo $msgClass; ?> alert-dismissible fade show" role="alert">
        <?php echo $msg; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<!-- Reviews Table -->
<?php if(!empty($reviews)): ?>
    <div class="table-responsive">
        <table class="w-100 view-numbers-table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">الاسم</th>
                    <th scope="col">التقييم</th>
                    <th scope="col">النجوم</th>
                    <th scope="col">الحالة</th>
                    <th scope="col">التاريخ</th>
                    <th scope="col">الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($reviews as $key => $review): ?>
                    <tr>
                        <td><?php echo $key + 1; ?></td>
                        <td><?php echo htmlspecialchars($review['name']); ?></td>
                        <td class="review-content-cell" title="<?php echo $review['content']?>">
                            <?php echo nl2br(htmlspecialchars($review['content'])); ?>
                        </td>
                        <td>
                            <?php echo displayStars($review['rating']); ?>
                        </td>
                        <td>
                            <?php if($review['status'] == 1): ?>
                                <span class="badge bg-success">معتمد</span>
                            <?php else: ?>
                                <span class="badge bg-warning text-dark">قيد الانتظار</span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo date('Y-m-d', strtotime($review['created_at'])); ?></td>
                        <td class="d-flex justify-content-between align-items-center actions-cell">
                            <?php if($review['status'] != 1): ?>
                                <form method="POST" class="d-inline">
                                    <input type="hidden" name="review_id" value="<?php echo $review['id']; ?>">
                                    <button type="submit" name="approve_review" class="btn btn-sm text-success" title="اعتماد">
                                        <i class="fa-solid fa-check"></i>
                                    </button>
                                </form>
                            <?php endif; ?>
                            <form method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا التقييم؟');">
                                <input type="hidden" name="review_id" value="<?php echo $review['id']; ?>">
                                <button type="submit" name="delete_review" class="btn btn-sm text-danger" title="حذف">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <div class="empty-state">
        <i class="fa-solid fa-star empty-icon"></i>
        <p class="empty-text">لا توجد تقييمات لعرضها</p>
    </div>
<?php endif; ?>

<?php
    $content = ob_get_clean();
    include_once '../admin/main.php';
?>

<style>
/* Premium White Theme for Reviews Admin */
:root {
    --review-bg-white: #ffffff;
    --review-bg-cream: #f5ebe0;
    --review-text-dark: #5e503f;
    --review-gold: #d4a373;
    --review-gold-light: #e8c9a8;
    --review-success: #22c55e;
    --review-warning: #fbbf24;
    --review-danger: #ef4444;
}

/* Stats Row */
.reviews-stats-row {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
}

.stat-card {
    flex: 1;
    min-width: 150px;
    background: var(--review-bg-white);
    border: 2px solid var(--review-gold-light);
    border-radius: 12px;
    padding: 20px;
    text-align: center;
    transition: all 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(212, 163, 115, 0.2);
}

.stat-value {
    font-size: 2rem;
    font-weight: 700;
    color: var(--review-gold);
    font-family: 'Tajawal', sans-serif;
}

.stat-value.text-success {
    color: var(--review-success);
}

.stat-value.text-warning {
    color: var(--review-warning);
}

.stat-label {
    font-size: 0.9rem;
    color: var(--review-text-dark);
    margin-top: 5px;
    font-family: 'Tajawal', sans-serif;
}

/* Table Styling */
.view-numbers-table {
    background-color: var(--review-bg-white);
    padding: 15px;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.view-numbers-table thead th {
    background-color: var(--review-gold);
    color: var(--review-bg-white);
    padding: 12px 15px;
    font-weight: 600;
    border: none;
}

.view-numbers-table tbody td {
    padding: 15px;
    border: 1px solid #eee;
    font-size: 16px;
    color: var(--review-text-dark);
    vertical-align: middle;
}

/* Review Content Cell */
.review-content-cell {
    max-width: 300px;
    white-space: normal;
    line-height: 1.6;
}

/* Stars in Table */
.review-content-cell + td .star,
td .star {
    color: var(--review-gold);
    font-size: 1.1rem;
}

td .star.empty {
    color: #ccc;
}

/* Badge Styling */
.badge {
    padding: 6px 12px;
    font-size: 0.85rem;
    font-weight: 600;
    border-radius: 20px;
}

.badge.bg-success {
    background-color: rgba(34, 197, 94, 0.15) !important;
    color: var(--review-success) !important;
    border: 1px solid rgba(34, 197, 94, 0.3);
}

.badge.bg-warning {
    background-color: rgba(251, 191, 36, 0.15) !important;
    color: #b45309 !important;
    border: 1px solid rgba(251, 191, 36, 0.3);
}

/* Action Buttons */
.actions-cell {
    min-width: 100px;
}

.actions-cell .btn {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
    background: rgba(212, 163, 115, 0.1);
    border: 1px solid var(--review-gold-light);
}

.actions-cell .btn:hover {
    transform: scale(1.1);
    box-shadow: 0 2px 8px rgba(212, 163, 115, 0.3);
}

.actions-cell .btn.text-success {
    color: var(--review-success) !important;
}

.actions-cell .btn.text-danger {
    color: var(--review-danger) !important;
}

.actions-cell .btn.text-danger:hover {
    background: rgba(239, 68, 68, 0.15);
    border-color: rgba(239, 68, 68, 0.3);
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 60px 20px;
    background: var(--review-bg-white);
    border-radius: 12px;
    border: 2px dashed var(--review-gold-light);
}

.empty-icon {
    font-size: 4rem;
    color: var(--review-gold-light);
    margin-bottom: 20px;
    opacity: 0.5;
}

.empty-text {
    font-size: 1.2rem;
    color: var(--review-text-dark);
    font-weight: 600;
}

/* Alert Styling */
.alert {
    border-radius: 10px;
    font-weight: 500;
    padding: 15px 20px;
    margin-bottom: 20px;
    border: 1px solid;
}

.alert-success {
    background-color: rgba(34, 197, 94, 0.1);
    border-color: rgba(34, 197, 94, 0.3);
    color: #15803d;
}

.alert-danger {
    background-color: rgba(239, 68, 68, 0.1);
    border-color: rgba(239, 68, 68, 0.3);
    color: #b91c1c;
}

/* Responsive */
@media (max-width: 768px) {
    .reviews-stats-row {
        flex-direction: column;
    }
    
    .stat-card {
        min-width: 100%;
    }
    
    .view-numbers-table {
        font-size: 14px;
    }
    
    .view-numbers-table thead th,
    .view-numbers-table tbody td {
        padding: 10px 8px;
    }
    
    .review-content-cell {
        max-width: 200px;
        font-size: 14px;
    }
    
    .actions-cell .btn {
        width: 32px;
        height: 32px;
    }
}

@media (max-width: 480px) {
    .view-numbers-table {
        display: block;
        overflow-x: auto;
    }
    
    .review-content-cell {
        max-width: 150px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
}
</style>