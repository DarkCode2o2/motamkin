<?php 
  include_once '../connect.php';
  include_once "../config/helpers.php";
  session_start();
  if($_SERVER['REQUEST_METHOD'] == 'POST') {

      $category = htmlspecialchars($_POST['category']);
      $number = htmlspecialchars($_POST['number']);
      $number_two = isset($_POST['number_two']) && $_POST['number_two'] != '' ? htmlspecialchars($_POST['number_two']) : null;
      $price = htmlspecialchars($_POST['price']);

      if(!isExists('numbers', 'number', $number)) {
          if($number_two) {
            $stmt = $con->prepare("INSERT INTO numbers (number, number_two, price, category, user_id) VALUES (?, ?, ?, ?, ?)");
            try {
                $stmt->execute([$number, $number_two, $price, $category, $_SESSION['user_id']]);
                header("Refresh: 2");
                $msg = "تم إضافة رقم جديد بنجاح!";
            } catch(PDOException $e) {
                echo $sql . "<br>" . $e->getMessage();
            }
          }else {
            $stmt = $con->prepare("INSERT INTO numbers (number, price, category, user_id) VALUES (?, ?, ?, ?)");
            try {
                $stmt->execute([$number, $price, $category, $_SESSION['user_id']]);
                  header("Refresh: 2");
                  $msg = "تم إضافة رقم جديد بنجاح!";
                } catch(PDOException $e) {
                echo $sql . "<br>" . $e->getMessage();
            }
          }
      }else {
        $msgError = "عذراً، هذا الرقم موجود مسبقاً في قاعدة البيانات!";
        header("Refresh: 2");
      }
  }
  $pageTitle = "إضافة رقم جديد";

  ob_start();
?>
  
  <!-- Premium Form Card -->
  <div class="form-card">
    <div class="form-card-header">
      <div class="form-card-icon">
        <i class="fa-solid fa-mobile-screen-button"></i>
      </div>
      <h2 class="form-card-title">إضافة رقم مميز جديد</h2>
      <p class="form-card-subtitle">أدخل بيانات الرقم لإضافته إلى المجموعة</p>
    </div>
    
    <form action="" method="post" class="add-form">
      
      <!-- Category Selection -->
      <div class="form-group">
        <label for="categorySelect" class="form-label">
          <i class="fa-solid fa-layer-group"></i>
          تصنيف الرقم
        </label>
        <select class="form-select" name="category" id="categorySelect" required>
          <option value="" disabled selected>اختر تصنيف الرقم</option>
          <option value="1">الاقتصادية</option>
          <option value="2">المميزة</option>
          <option value="3">النخبة</option>
          <option value="4">الفي آي بي</option>
          <option value="5">الطقم</option>
        </select>
      </div>

      <!-- Primary Number -->
      <div class="form-group">
        <label for="number" class="form-label">
          <i class="fa-solid fa-phone"></i>
          الرقم الأساسي
        </label>
        <input type="text" minlength="10" inputmode="text" id="number" placeholder="0555555555" class="form-control" name="number" autocomplete="off" required>
        <?php if(isset($msgError)):?>
          <p class="error-message">
            <i class="fa-solid fa-circle-exclamation"></i>
            <?php echo $msgError ?>
          </p>
        <?php endif?>
      </div>

      <!-- Secondary Number (for Bundle) -->
      <div class="form-group" id="second_bundle_number">
        <label for="number_two" class="form-label">
          <i class="fa-solid fa-phone-volume"></i>
          الرقم الثاني (للطقم فقط)
        </label>
        <input type="text" minlength="10" id="number_two" placeholder="0555555555" class="form-control" name="number_two">
      </div>

      <!-- Price -->
      <div class="form-group">
        <label for="price" class="form-label">
          <i class="fa-solid fa-coins"></i>
          السعر بالريال
        </label>
        <input type="text" id="price" inputmode="text" class="form-control" required name="price" placeholder="0">
      </div>

      <!-- Success Message -->
      <?php if(isset($msg)):?>
        <div class="success-message">
          <i class="fa-solid fa-circle-check"></i>
          <?php echo $msg ?>
        </div>
      <?php endif?>

      <!-- Hero Submit Button -->
      <button type="submit" class="submit-btn">
        <i class="fa-solid fa-plus-circle"></i>
        إضافة الرقم الآن
      </button>
    </form>
  </div>

<?php 
  $content = ob_get_clean();
      
  include_once '../admin/main.php';
?>