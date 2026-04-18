<?php 
    ob_start();
    session_start();
    include_once '../config/helpers.php'; 
    $id = htmlspecialchars($_GET['id']);
    
    $numberData = user_numbers('id', $id, $_SESSION['user_id'])[0];

    $numberCol = getData('numbers', 'user_id', $_SESSION['user_id']);
    
    if($_SESSION['role'] == 0 || $number['user_id'] == $_SESSION['user_id']) {
      if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $category = htmlspecialchars($_POST['category']);
        $number = htmlspecialchars($_POST['number']);
        $numberTwo = htmlspecialchars($_POST['number_two']);
        $price = htmlspecialchars($_POST['price']);
        if(!isExists($number, 'numbers', 'number')) {


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
        }else {
          $msgError = "عذرا الرقم مستخدم بالفعل!";
          header("Refresh: 2");
        }
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
            <input type="text" dir="ltr" minlength="10" id="number" placeholder="050-555-5555" value="<?php echo $numberData['number'] ?>" class="form-control text-start" name="number" required>
        </div>
         <?php if(isset($msgError)):?>
                <p class="mt-2 alert alert-danger"><?php echo $msgError ?> <i class="fa-solid fa-circle-xmark"></i></p>
          <?php endif?>

        <div id="second_bundle_number">
            <label for="number_two" class="w-100 text-right fs-5">الرقم الثاني </label>
            <div class="input-group mb-3 mt-1">
                <input type="text" dir="ltr" id="number_two" minlength="10" id="number" placeholder="050-555-5555" value="<?php echo $numberData['number_two'] ?? '' ?>" class="form-control text-start" name="number_two">
            </div>
             <?php if(isset($errorMsg)):?>
                <p class="mt-2 alert alert-danger"><?php echo $errorMsg ?> <i class="fa-solid fa-circle-xmark"></i></p>
              <?php endif?>
        </div>

        <label for="edit_price" class="w-100 text-right fs-5">السعر</label>
        <div class="input-group mb-3 mt-1">
            <input type="tel" id="edit_price" class="form-control" required value="<?php echo $numberData['price'] ?>" name="price">
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


