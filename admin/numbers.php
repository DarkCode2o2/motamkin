<?php 
  $pageTitle = "قائمة الأرقام";
  session_start();

  include_once '../config/helpers.php';

  $cat_filter = $_GET['type'] ?? 'all';
  $num = '';
  if($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    if (isset($_POST['toggle_status'])) {

      $id = (int) $_POST['number_id'];
     
      $stmt = $con->prepare("
          UPDATE numbers
          SET status = CASE
              WHEN status = 0 THEN 1
              ELSE 0
          END
          WHERE id = ?
      ");

      $stmt->execute([$id]);

      header("Location: " . $_SERVER['PHP_SELF']);
      exit;
    }
    
    if (isset($_POST['number'])) {
      $num = str_replace(' ', '', htmlspecialchars($_POST['number']));

      $stmt = $con->prepare("SELECT * FROM numbers WHERE number LIKE ?");
      try {
        $stmt->execute(['%'. $num . '%']);

        $numbers = $stmt->fetchAll(PDO::FETCH_ASSOC);


        if(empty($numbers['user_id'])) {
          $msg = 'يرجى إدخال رقم صحيح !';
        }else {
          $numbers = getData('numbers', 'user_id', $_SESSION['user_id'], 'ORDER BY id DESC', true);
        }

      }catch(PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
      }
    }

  }else {

    if(isset($cat_filter)) {
      if($cat_filter == 'economic') {
        $numbers = user_numbers('category', 'economic', $_SESSION['user_id'], 'ORDER BY id DESC');
      }elseif($cat_filter == 'special') {
        $numbers = user_numbers('category', 'special', $_SESSION['user_id'], 'ORDER BY id DESC');
      }elseif($cat_filter == 'elite') {
        $numbers = user_numbers('category', 'elite', $_SESSION['user_id'], 'ORDER BY id DESC');
      }elseif($cat_filter == 'vip') {
        $numbers = user_numbers('category', 'vip', $_SESSION['user_id'], 'ORDER BY id DESC');
      }elseif($cat_filter == 'bundle') {
        $numbers = user_numbers('category', 'bundle', $_SESSION['user_id'], 'ORDER BY id DESC');
      }elseif($cat_filter == 'sold') {
        $numbers = user_numbers('status', '1', $_SESSION['user_id'], 'ORDER BY id DESC');
      }else { 
        $numbers = getData('numbers', 'user_id', $_SESSION['user_id'], 'ORDER BY id DESC', true);
      }
    }else {
      $numbers = getData('numbers', 'user_id', $_SESSION['user_id'], 'ORDER BY id DESC', true);
    }
  }

  ob_start();

  
?>
  
    <div class="filter">
      <h4>الأرقام المتاحة</h4>
      <ul>
        <li><a href="?type=all" class="<?php echo $cat_filter == 'all' || '' ? 'active' : ''?>" >الكل</a></li>
        <li><a href="?type=economic" class="<?php echo $cat_filter == 'economic' || '' ? 'active' : ''?>">الإقتصادية</a></li>
        <li><a href="?type=special" class="<?php echo $cat_filter == 'special' || '' ? 'active' : ''?>">المميزة</a></li>
        <li><a href="?type=elite" class="<?php echo $cat_filter == 'elite' || '' ? 'active' : ''?>">النخبة</a></li>
        <li><a href="?type=vip" class="<?php echo $cat_filter == 'vip' || '' ? 'active' : ''?>">VIP</a></li>
        <li><a href="?type=bundle" class="<?php echo $cat_filter == 'bundle' || '' ? 'active' : ''?>">الطقم</a></li>
        <li><a href="?type=sold" class="<?php echo $cat_filter == 'sold' || '' ? 'active' : ''?>">المباعة</a></li>
      </ul>
    </div>
    <?php if($num):?>
      <div class="search-query">
        <h2>الأرقام التي تحتوي على: <b>"<?php echo $num?>"</b></h2>
      </div>
    <?php endif?>
    <?php if(!empty($numbers)) { ?>
    <table class="w-100 view-numbers-table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">الرقم</th>
            <th scope="col">السعر</th>
            <th scope="col">التصنيف</th>
            <th scope="col">تحكم</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($numbers as $key => $number):?>
             <tr>
                <td><?php echo $key+1?></td>
                <td dir="ltr"> <?php 
                    if($number['number_two']) {
                      echo $number['number'] .' - '. $number['number_two'];
                    }else {
                      echo $number['number'];
                    }
                  ?></td>
                <td><?php echo $number['price']?></td>
                <td><?php echo categoryNameToNumber($number['category'], true)?></td>

                <td rowspan="2" class="d-flex justify-content-between align-items-center">
                  <a href="../admin/edit_number.php?id=<?php echo $number['id'] ?>" class="text-decoration-none">
                      <i class="fa-solid fa-pen-to-square text-primary "></i>
                  </a>
                  <form method="POST">
                      <input type="hidden" name="number_id" value="<?= $number['id'] ?>">

                      <?php if($number['status']) { ?>
                        <button type="submit" name="toggle_status" class="switch sold">
                            مباع
                        </button>
                      <?php }else {?>
                        <button type="submit" name="toggle_status" class="switch">
                          معروض
                        </button>
                      <?php } ?>

                  </form>
                  <a href="../admin/delete_number.php?id=<?php echo $number['id'] ?>"
                    onclick="return confirm('هل أنت متأكد من حذف هذا الرقم؟');">                  
                    <i class="fa-solid fa-trash text-danger"></i>
                  </a>
                </td>
              </tr>
          <?php endforeach?>
        </tbody>
    </table>
<?php 
  }else {
        echo "<p class='alert alert-info fw-bold fs-4'>لا توجد أرقام لعرضها</p>";
  }
  $content = ob_get_clean();

  include_once '../admin/main.php';


?>


