<?php 
  include_once '../connect.php';
  include_once "../config/helpers.php";
  session_start();
  if($_SERVER['REQUEST_METHOD'] == 'POST') {

      $category = htmlspecialchars($_POST['category']);
      $number = htmlspecialchars($_POST['number']);
      $number_two = isset($_POST['number_two']) && $_POST['number_two'] != '' ? htmlspecialchars($_POST['number_two']) : null;
      $price = htmlspecialchars($_POST['price']);

      if(!isExists($number, 'numbers', 'number')) {
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
        $msgError = "عذرا الرقم مستخدم بالفعل!";
        header("Refresh: 2");
      }
  }
  $pageTitle = "إضافة رقم جديد";

  ob_start();
?>
  
  <form action="" method="post" class="add-form my-4 text-start bg-light-subtle p-4 rounded">
    <label class="w-100 text-right fs-5">أختر تصنيف الرقم</label>
    <div class="form-floating input-group mb-3 mt-1">
        <select class="form-select p-0 ps-2" name="category" id="categorySelect" aria-label="Floating label select example">
          <option value="1">الاقتصادية 0-499</option>
          <option value="2">المميزة 500-1499</option>
          <option value="3">النخبة 1500-4999</option>
          <option value="4">الفي آي بي 5000 - وما فوق</option>
          <option value="5">الطقم</option>
        </select>
    </div>

    <label for="number" class="w-100 text-right fs-5">الرقم</label>
    <div class="input-group mb-3 mt-1">
        <input type="text" minlength="10" inputmode="text" id="number" placeholder="050-555-5555" class="form-control" name="number" autocomplete="off" required>
    </div>
    <?php if(isset($msgError)):?>
      <p class="mt-2 alert alert-danger"><?php echo $msgError ?></p>
    <?php endif?>
    <div id="second_bundle_number">
        <label for="number" class="w-100 text-right fs-5">الرقم الثاني</label>
        <div class="input-group mb-3 mt-1">
            <input type="text" minlength="10"  id="number_two" placeholder="050-555-5555" class="form-control" name="number_two">
        </div>
    </div>

    <label for="price" class="w-100 text-right fs-5">السعر</label>
    <div class="input-group mb-3 mt-1">
      <input type="text" id="price"  inputmode="text" class="form-control" required name="price">
    </div>

    <?php if(isset($msg)):?>
      <p class="mt-2 alert alert-success"><?php echo $msg ?> <i class="fa-solid fa-circle-check"></i></p>
    <?php endif?>
    <input type="submit" value="إضافة" class="btn btn-primary">
  </form>

<?php 
  $content = ob_get_clean();
      
  include_once '../admin/main.php';
?>


