<?php 

  session_start();
  include_once '../config/helpers.php';

  $numbers = getData('numbers', 'user_id', $_SESSION['user_id'], 'ORDER BY id DESC LIMIT 5', true);
  $numberCount = getCount('numbers', $_SESSION['user_id']);
  ob_start();
  $pageTitle = "حياك الله، " . $_SESSION['name'];
?>

<!-- Dashboard Welcome Section -->
<section class="container-fluid mb-5">
  <div class="welcome-section">
    <div class="row align-items-center">
      <div class="col-md-8">
        <h1 class="welcome-title"><?php echo $pageTitle ?></h1>
        <p class="welcome-subtitle">لوحة التحكم - المتمكن للأرقام المميزة</p>
      </div>
      <div class="col-md-4 text-start text-md-end mt-3 mt-md-0">
        <a href="../admin/add-number.php" class="btn-primary">
          <i class="fa-solid fa-plus me-2"></i>
          إضافة رقم جديد
        </a>
      </div>
    </div>
  </div>
</section>

<!-- Stats Section -->
<section class="container-fluid mb-5">
  <div class="boxes">
    <div class="row g-3">
      <div class="col-12 col-md-4">
        <div class="box">
          <h2><?php echo $numberCount ?></h2>
          <p>رقم متاح</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Minimalist Numbers Cards -->
<?php if(!empty($numbers)): ?>
<section class="container-fluid">
  <h4 class="elite-cards-title">آخر الأرقام المضافة</h4>
  
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
  
  <!-- View All Link -->
  <div class="mt-4">
    <a href="../admin/numbers.php" class="btn-outline-primary">
      عرض جميع الأرقام
      <i class="fa-solid fa-arrow-left me-2"></i>
    </a>
  </div>
</section>
<?php endif; ?>

<?php 
  $content = ob_get_clean();
  include_once '../admin/main.php';
?>