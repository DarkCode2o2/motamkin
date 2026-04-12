<?php 
    $pageTitle = "قائمة المستخدمين";

    include_once '../connect.php';
    include_once '../config/helpers.php';

    $users = getData('users', 'role', '1', 'ORDER BY id DESC', true);
    $searchResult = null;
    $searchError = '';

    // Handle POST search
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['number']) && !empty($_POST['number'])) {
        $num = str_replace(' ', '', htmlspecialchars($_POST['number']));
        $stmt = $con->prepare("SELECT * FROM numbers WHERE REPLACE(number, ' ', '') = ? LIMIT 1");
        try {
            $stmt->execute([$num]);
            $userNumber = $stmt->fetch(PDO::FETCH_ASSOC);

            if(!empty($userNumber['user_id'])) {
                $searchResult = getData('users', 'id', $userNumber['user_id'], 'ORDER BY id DESC', false);
                $searchResult['number_data'] = $userNumber;
                
            } else {
                $searchError = 'لم يتم العثور على هذا الرقم';
            }
        } catch(PDOException $e) {
            $searchError = 'حدث خطأ أثناء البحث';
        }
    }

    // Handle user ID from URL
    $selectedUserId = isset($_GET['user']) && is_numeric($_GET['user']) ? $_GET['user'] : null;
    $selectedUser = null;
    $selectedUserNumbers = [];

    if ($selectedUserId) {
        $selectedUser = getData('users', 'id', $selectedUserId);
        if ($selectedUser) {
            $stmt = $con->prepare("SELECT * FROM numbers WHERE user_id = ?");
            $stmt->execute([$selectedUserId]);
            $selectedUserNumbers = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $pageTitle = "أرقام: " . $selectedUser['name'];
        } else {
            header("Location: users.php");
            exit;
        }
    }

    ob_start();
?>

<!-- Premium Search Section -->
<div class="search-section">
    <form method="POST" action="" class="search-form-inline">
        <div class="premium-search-wrapper">
            <div class="premium-search-container">
                <div class="search-icon-wrapper">
                    <i class="fa-solid fa-mobile-screen"></i>
                </div>
                <input 
                    type="text" 
                    name="number"
                    id="numberSearch" 
                    class="premium-search-input" 
                    placeholder="ابحث عن رقم لمعرفة مالكه..."
                    autocomplete="off"
                    aria-label="البحث عن رقم"
                >
                <?php if(isset($_POST['number']) && !empty($_POST['number'])): ?>
                <button type="button" class="search-clear-btn" id="clearSearch" aria-label="مسح البحث" onclick="window.location.href='users.php'">
                    <i class="fa-solid fa-times"></i>
                </button>
                <?php else: ?>
                <button type="button" class="search-clear-btn" id="clearSearch" aria-label="مسح البحث" style="display: none;">
                    <i class="fa-solid fa-times"></i>
                </button>
                <?php endif; ?>
            </div>
            <button type="submit" class="search-btn-primary" id="searchBtn">
                <i class="fa-solid fa-magnifying-glass"></i>
                <span>بحث</span>
            </button>
        </div>
    </form>
    <div class="search-results-count">
        <span class="count-number"><?php echo count($users) ?></span>
        <span class="count-label">مستخدم</span>
    </div>
</div>

<!-- User Info Card (When Search Result Found) -->
<?php if($searchResult): ?>
<div class="search-result-section fade-in">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h4 class="elite-cards-title mb-0">
            <i class="fa-solid fa-user-check text-success"></i>
            نتائج البحث
        </h4>
        <a href="users.php" class="btn-outline-primary">
            <i class="fa-solid fa-arrow-right"></i>
            مسح النتائج
        </a>
    </div>
    
    <div class="user-profile-card">
        <div class="user-profile-header">
            <div class="user-avatar-large">
                <i class="fa-solid fa-user"></i>
            </div>
            <div class="user-profile-info">
                <h3 class="user-name"><?php echo $searchResult['name'] ?></h3>
                <p class="user-username">@<?php echo $searchResult['username'] ?></p>
                <div class="user-badges">
                    <span class="badge badge-primary">
                        <i class="fa-solid fa-key"></i>
                        <?php echo getCount('numbers', $searchResult['id']) ?> أرقام
                    </span>
                </div>
            </div>
        </div>
        
        <div class="user-profile-body">
            <div class="profile-stats">
                <div class="stat-item">
                    <div class="stat-icon">
                        <i class="fa-solid fa-mobile-screen"></i>
                    </div>
                    <div class="stat-content">
                        <p class="stat-label">الرقم المطلوب</p>
                        <p class="stat-value" dir="ltr">
                            <?php 
                                if($searchResult['number_data']['number_two']) {
                                    echo $searchResult['number_data']['number'] . ' - ' . $searchResult['number_data']['number_two'];
                                } else {
                                    echo $searchResult['number_data']['number'];
                                }
                            ?>
                        </p>
                    </div>
                </div>
                
                <div class="stat-item">
                    <div class="stat-icon">
                        <i class="fa-solid fa-tag"></i>
                    </div>
                    <div class="stat-content">
                        <p class="stat-label">التصنيف</p>
                        <p class="stat-value"><?php echo categoryNameToNumber($searchResult['number_data']['category'], true) ?></p>
                    </div>
                </div>
                
                <div class="stat-item">
                    <div class="stat-icon">
                        <i class="fa-solid fa-coins"></i>
                    </div>
                    <div class="stat-content">
                        <p class="stat-label">السعر</p>
                        <p class="stat-value"><?php echo $searchResult['number_data']['price'] ?> ر.س</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="user-profile-actions">
            <a href="?user=<?php echo $searchResult['id'] ?>" class="action-btn btn-primary">
                <i class="fa-solid fa-list"></i>
                عرض جميع الأرقام
            </a>
            <a href="../admin/edit_user.php?id=<?php echo $searchResult['id'] ?>" class="action-btn btn-secondary">
                <i class="fa-solid fa-pen-to-square"></i>
                تعديل المستخدم
            </a>
            <a href="../admin/delete_user.php?id=<?php echo $searchResult['id'] ?>" class="action-btn btn-danger" onclick="return confirm('هل أنت متأكد من حذف هذا المستخدم؟');">
                <i class="fa-solid fa-trash"></i>
                حذف المستخدم
            </a>
        </div>
    </div>
</div>

<!-- Search Error Message -->
<?php elseif($searchError): ?>
<div class="search-error-section fade-in">
    <div class="alert alert-danger">
        <i class="fa-solid fa-circle-exclamation"></i>
        <div>
            <strong>خطأ في البحث</strong>
            <p class="mb-0"><?php echo $searchError ?></p>
        </div>
    </div>
</div>
<?php endif; ?>


<!-- All Users Grid -->
<?php if(!$selectedUserId): ?>
<div class="users-section">
    <?php if(!empty($users)): ?>
        <div class="elite-cards-container">
            <h4 class="elite-cards-title">
                <i class="fa-solid fa-users"></i>
                جميع المستخدمين
            </h4>
            <div class="row">
                <?php foreach($users as $key => $user):?>
                    <div class="col-12 col-md-6 col-lg-4 user-card-wrapper">
                        <div class="elite-card fade-in">
                            <!-- User Avatar & Name -->
                            <div class="text-center mb-3">
                                <div class="user-avatar">
                                    <i class="fa-solid fa-user"></i>
                                </div>
                                <h5 class="mt-3 mb-1"><?php echo $user['name']?></h5>
                                <p class="text-muted small">@<?php echo $user['username']?></p>
                            </div>
                            
                            <!-- User Stats -->
                            <div class="card-details">
                                <div>
                                    <p class="text-muted small mb-1">عدد الأرقام</p>
                                    <p class="fw-bold"><?php echo getCount('numbers', $user['id'])?></p>
                                </div>
                                <div>
                                    <a href="?user=<?php echo $user['id']?>" class="view-link">
                                        <i class="fa-solid fa-eye"></i>
                                        عرض الأرقام
                                    </a>
                                </div>
                            </div>
                            
                            <!-- User Actions -->
                            <div class="card-actions">
                                <a href="../admin/edit_user.php?id=<?php echo $user['id'] ?>" class="edit-btn">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                    <span>تعديل</span>
                                </a>
                                <a href="../admin/delete_user.php?id=<?php echo $user['id'] ?>" class="delete-btn" onclick="return confirm('هل أنت متأكد من حذف هذا المستخدم؟');">
                                    <i class="fa-solid fa-trash"></i>
                                    <span>حذف</span>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php else: ?>
        <!-- Empty State -->
        <div class="empty-state">
            <i class="fa-solid fa-users"></i>
            <p>لا يوجد مستخدمين لعرضهم</p>
        </div>
    <?php endif; ?>
</div>
<?php endif; ?>

<!-- Selected User's Numbers -->
<?php if($selectedUserId && $selectedUser): ?>
<div class="user-numbers-section">
    <div class="elite-cards-container">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h4 class="elite-cards-title mb-0">
                <i class="fa-solid fa-mobile-screen"></i>
                أرقام: <?php echo $selectedUser['name']?>
            </h4>
            <a href="users.php" class="btn-outline-primary">
                <i class="fa-solid fa-arrow-right"></i>
                العودة للمستخدمين
            </a>
        </div>
        
        <div class="row">
            <?php foreach($selectedUserNumbers as $key => $number):?>
                <?php 
                    $categoryClass = '';
                    $categoryLabel = categoryNameToNumber($number['category'], true);
                    
                    if($number['category'] == 'elite') {
                        $categoryClass = 'elite';
                    } elseif($number['category'] == 'vip') {
                        $categoryClass = 'vip';
                    } elseif($number['category'] == 'bundle') {
                        $categoryClass = 'royal';
                    }
                ?>
                
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="elite-card <?php echo $categoryClass ?> fade-in">
                        <!-- Number Display -->
                        <div class="number-display" dir="ltr">
                            <?php 
                                if($number['number_two']) {
                                    echo $number['number'] .' <span class="separator">-</span> '. $number['number_two'];
                                }else {
                                    echo $number['number'];
                                }
                            ?>
                        </div>
                        
                        <!-- Card Details -->
                        <div class="card-details">
                            <div class="price"><?php echo $number['price'] ?> ر.س</div>
                            <div class="category-badge">
                                <i class="fa-solid fa-tag"></i>
                                <?php echo $categoryLabel ?>
                            </div>
                        </div>
                        
                        <!-- Card Actions -->
                        <div class="card-actions">
                            <a href="../admin/edit_number.php?id=<?php echo $number['id'] ?>" class="edit-btn">
                                <i class="fa-solid fa-pen-to-square"></i>
                                <span>تعديل</span>
                            </a>
                            <a href="../admin/delete_number.php?id=<?php echo $number['id'] ?>" class="delete-btn" onclick="return confirm('هل أنت متأكد من حذف هذا الرقم؟');">
                                <i class="fa-solid fa-trash"></i>
                                <span>حذف</span>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach?>
        </div>
    </div>
</div>
<?php endif; ?>

<?php 
    $content = ob_get_clean();
    include_once '../admin/main.php';
?>
