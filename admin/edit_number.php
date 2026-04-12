<?php 
    ob_start();
    session_start();
    include_once '../config/helpers.php'; 
    $id = htmlspecialchars($_GET['id']);
    
    $numberData = user_numbers('id', $id, $_SESSION['user_id'])[0];
    
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
      $category = htmlspecialchars($_POST['category']);
      $number = htmlspecialchars($_POST['number']);
      $numberTwo = htmlspecialchars($_POST['number_two']);
      $price = htmlspecialchars($_POST['price']);

      if($category == 5 && empty($numberTwo)) {
        $errorMsg = 'عذرا, لا يمكنك إختيار الطقم وترك الحقل ثاني فارغا!';
      }else {
        if(!empty($numberTwo)) {
          $stmt = $con->prepare("UPDATE numbers SET category = ?, number = ?, number_two = ?, price = ? WHERE id = ?");
          try {
              $stmt->execute([$category, $number, $numberTwo, $price, $id]);
              header("Refresh: 2");
              $msg = "تم تعديل الرقم بنجاح!";
          } catch(PDOException $e) {
              echo $e->getMessage();
            }
        }else {
            $stmt = $con->prepare("UPDATE numbers SET category = ?, number = ?, number_two = ?, price = ? WHERE id = ?");
            try {
                $stmt->execute([$category, $number, null, $price, $id]);
                header("Refresh: 2");
                $msg = "تم تعديل الرقم بنجاح!";
            } catch(PDOException $e) {
                echo $e->getMessage();
            }
        }
      }
      
  }
  $pageTitle = "تعديل الرقم";


    if($numberData){
    $catNumber = categoryNameToNumber($numberData['category'])
?>      
<!-- Premium Edit Form Card -->
<div class="form-card">
  <div class="form-card-header">
    <div class="form-card-icon">
      <i class="fa-solid fa-pen-to-square"></i>
    </div>
    <h2 class="form-card-title">تعديل الرقم المميز</h2>
    <p class="form-card-subtitle">قم بتحديث بيانات الرقم في النموذج التالي</p>
  </div>
  
  <form action="" method="post" class="add-form">
    
    <!-- Category Selection -->
    <div class="form-group">
      <label for="categorySelect" class="form-label">
        <i class="fa-solid fa-layer-group"></i>
        تصنيف الرقم
      </label>
      <select class="form-select" name="category" id="categorySelect" required>
        <option value="1" <?php echo $catNumber == 1 ? 'selected' : '' ?>>الاقتصادية 0-499</option>
        <option value="2" <?php echo $catNumber == 2 ? 'selected' : '' ?>>المميزة 500-1499</option>
        <option value="3" <?php echo $catNumber == 3 ? 'selected' : '' ?>>النخبة 1500-4999</option>
        <option value="4" <?php echo $catNumber == 4 ? 'selected' : '' ?>>الفي آي بي 5000 - وما فوق</option>
        <option value="5" <?php echo $catNumber == 5 ? 'selected' : '' ?>>الطقم</option>
      </select>
    </div>

    <!-- Primary Number -->
    <div class="form-group">
      <label for="number" class="form-label">
        <i class="fa-solid fa-phone"></i>
        الرقم الأساسي
      </label>
      <input type="text" minlength="10" id="number" placeholder="0555555555" value="<?php echo $numberData['number'] ?>" class="form-control" name="number" required>
    </div>

    <!-- Secondary Number -->
    <div class="form-group d-none" id="second_bundle_number">
      <label for="number_two" class="form-label">
        <i class="fa-solid fa-phone-volume"></i>
        الرقم الثاني (للطقم فقط)
      </label>
      <input type="text" minlength="10" id="number_two" placeholder="0555555555" value="<?php echo $numberData['number_two'] ?? '' ?>" class="form-control" name="number_two">
    </div>

    <!-- Price -->
    <div class="form-group">
      <label for="price" class="form-label">
        <i class="fa-solid fa-coins"></i>
        السعر بالريال
      </label>
      <input type="text" id="price" class="form-control" required value="<?php echo $numberData['price'] ?>" name="price" placeholder="0">
    </div>

    <!-- Success Message -->
    <?php if(isset($msg)):?>
      <div class="success-message">
        <i class="fa-solid fa-circle-check"></i>
        <?php echo $msg ?>
      </div>
    <?php endif?>

    <!-- Error Message -->
    <?php if(isset($errorMsg)):?>
      <div class="error-message">
        <i class="fa-solid fa-circle-xmark"></i>
        <?php echo $errorMsg ?>
      </div>
    <?php endif?>

    <!-- Hero Submit Button -->
    <button type="submit" class="submit-btn">
      <i class="fa-solid fa-check-circle"></i>
      حفظ التعديلات
    </button>
  </form>
</div>

<?php 
    }else {
        header("location: ../admin/index.php");
        exit;
    }
  $content = ob_get_clean();

  include_once '../admin/main.php';
?>