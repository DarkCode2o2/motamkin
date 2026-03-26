<?php 
    ob_start();
    session_start();
    include_once '../config/helpers.php'; 
    $id = htmlspecialchars($_GET['id']);
    
    $numberData = user_numbers('id', $id, $_SESSION['user_id'])[0];
    
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
      $category = htmlspecialchars($_POST['category']);
      $number = htmlspecialchars($_POST['number']);
      $price = htmlspecialchars($_POST['price']);

      $stmt = $con->prepare("UPDATE numbers SET category = ?, number = ?, price = ? WHERE id = ?");
      try {
          $stmt->execute([$category, $number, $price, $id]);
          header("Refresh: 2");
          $msg = "تم تعديل الرقم بنجاح!";
      } catch(PDOException $e) {
          echo $e->getMessage();
      }
  }
  $pageTitle = "تعديل الرقم";


    if($numberData){
    $catNumber = categoryNameToNumber($numberData['category'])
?>      
    <form action="" method="post" class="add-form mt-4 text-start bg-light-subtle p-4 rounded">
         <label class="w-100 text-right fs-5">أختر تصنيف الرقم</label>
        <div class="form-floating input-group mb-3 mt-1">
            <select class="form-select p-0 ps-2" name="category" id="categorySelect" aria-label="Floating label select example">
                <option value="1" <?php echo $catNumber == 1 ? 'selected' : '' ?>>الاقتصادية 0-499</option>
                <option value="2" <?php echo $catNumber == 2 ? 'selected' : '' ?>>المميزة 500-1499</option>
                <option value="3" <?php echo $catNumber == 3 ? 'selected' : '' ?>>النخبة 1500-4999</option>
                <option value="4" <?php echo $catNumber == 4 ? 'selected' : '' ?>>الفي آي بي 5000 - وما فوق</option>
                <option value="5" <?php echo $catNumber == 5 ? 'selected' : '' ?>>الطقم</option>
            </select>
        </div>
        <label for="number" class="w-100 text-right fs-5">الرقم</label>
        <div class="input-group mb-3 mt-1">
            <input type="text" minlength="10" id="number" placeholder="050-555-5555" value="<?php echo $numberData['number'] ?>" class="form-control" name="number" required>
        </div>

        <div id="second_bundle_number">
            <label for="number" class="w-100 text-right fs-5">الرقم الثاني </label>
            <div class="input-group mb-3 mt-1">
                <input type="text" minlength="10" id="number" placeholder="050-555-5555" value="<?php echo $numberData['number_two'] ?? '' ?>" class="form-control" name="number_two">
            </div>
        </div>

        <label for="price" class="w-100 text-right fs-5">السعر</label>
        <div class="input-group mb-3 mt-1">
            <input type="tel" id="price" class="form-control" required value="<?php echo $numberData['price'] ?>" name="price">
        </div>
        <?php if(isset($msg)):?>
        <p class="mt-2 alert alert-success"><?php echo $msg ?> <i class="fa-solid fa-circle-check"></i></p>
        <?php endif?>
        <input type="submit" value="تعديل" class="btn btn-primary">
  </form>
<?php 
    }else {
        header("location: ../admin/index.php");
        exit;
    }
  $content = ob_get_clean();

  include_once '../admin/main.php';
?>


