<?php 
  $pageTitle = "قائمة الأرقام";
  session_start();

  include_once '../config/helpers.php';

  $cat_filter = $_GET['type'] ?? 'all';

  if(isset($cat_filter)) {
    if($cat_filter == 'economic') {
      $numbers = user_numbers('category', 'economic', $_SESSION['user_id'], 'ORDER BY id DESC');
    } elseif($cat_filter == 'special') {
      $numbers = user_numbers('category', 'special', $_SESSION['user_id'], 'ORDER BY id DESC');
    } elseif($cat_filter == 'elite') {
      $numbers = user_numbers('category', 'elite', $_SESSION['user_id'], 'ORDER BY id DESC');
    } elseif($cat_filter == 'vip') {
      $numbers = user_numbers('category', 'vip', $_SESSION['user_id'], 'ORDER BY id DESC');
    } elseif($cat_filter == 'bundle') {
      $numbers = user_numbers('category', 'bundle', $_SESSION['user_id'], 'ORDER BY id DESC');
    } else { 
      $numbers = getData('numbers', 'user_id', $_SESSION['user_id'], 'ORDER BY id DESC', true);
    }
  } else {
    $numbers = getData('numbers', 'user_id', $_SESSION['user_id'], 'ORDER BY id DESC', true);
  }

  ob_start();
?>

<!-- Minimalist Filter Section -->
<div class="filter">
  <h4>تصفية الأرقام</h4>
  <ul>
    <li>
      <a href="?type=all" class="<?php echo $cat_filter == 'all' || '' ? 'active' : ''?>">
        <i class="fa-solid fa-layer-group"></i>
        الكل
      </a>
    </li>
    <li>
      <a href="?type=economic" class="<?php echo $cat_filter == 'economic' || '' ? 'active' : ''?>" data-category="economic">
        <i class="fa-solid fa-coins"></i>
        الاقتصادية
      </a>
    </li>
    <li>
      <a href="?type=special" class="<?php echo $cat_filter == 'special' || '' ? 'active' : ''?>" data-category="special">
        <i class="fa-solid fa-star"></i>
        المميزة
      </a>
    </li>
    <li>
      <a href="?type=elite" class="<?php echo $cat_filter == 'elite' || '' ? 'active' : ''?>" data-category="elite">
        <i class="fa-solid fa-gem"></i>
        النخبة
      </a>
    </li>
    <li>
      <a href="?type=vip" class="<?php echo $cat_filter == 'vip' || '' ? 'active' : ''?>" data-category="vip">
        <i class="fa-solid fa-crown"></i>
        VIP
      </a>
    </li>
    <li>
      <a href="?type=bundle" class="<?php echo $cat_filter == 'bundle' || '' ? 'active' : ''?>" data-category="bundle">
        <i class="fa-solid fa-box"></i>
        الطقم
      </a>
    </li>
  </ul>
</div>

<!-- Minimalist Number Cards -->
<?php if(!empty($numbers)): ?>
<div class="row">
  <?php foreach($numbers as $key => $number): ?>
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
            } else {
              echo $number['number'];
            }
          ?>
        </div>
        
        <!-- Card Details -->
        <div class="card-details">
          <div class="price"><?php echo $number['price'] ?></div>
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
  <?php endforeach ?>
</div>
<?php else: ?>
  <!-- Empty State -->
  <div class="empty-state">
    <i class="fa-solid fa-inbox"></i>
    <p>لا توجد أرقام لعرضها</p>
  </div>
<?php endif; ?>

<?php 
  $content = ob_get_clean();
  include_once '../admin/main.php';
?>