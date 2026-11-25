<?php 
    $pageTitle = "قائمة المستخدمين";
    session_start();

    if(!isset($_SESSION['username']) || $_SESSION['role'] != 0) {
        header("location: ../admin/numbers.php");
        exit;
    }
    
    include_once '../connect.php';
    include_once '../config/helpers.php';

    if(!isset($_GET['user']) || empty($_GET['user'])) {

        $users = getData('users', 'role', '1', 'ORDER BY id DESC', true);
        $user = '';
        $msg = '';

        if($_SERVER['REQUEST_METHOD'] == 'POST') {

          $num = str_replace(' ', '', htmlspecialchars($_POST['number']));
          
          $stmt = $con->prepare("SELECT * FROM numbers WHERE REPLACE(number, ' ', '') = ? LIMIT 1");
          try {
            $stmt->execute([$num]);

            $userNumber = $stmt->fetch(PDO::FETCH_ASSOC);

            if(empty($userNumber['user_id'])) {
              $msg = 'يرجى إدخال رقم صحيح !';
            }else {
              $user = getData('users', 'id', $userNumber['user_id'], 'ORDER BY id DESC', false);

            }

          }catch(PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
          }

        }
    }
    
    // echo "<pre>";
    // print_r($_SESSION);
    // echo "</pre>";
    ob_start();
?>
      <?php if(!isset($_GET['user']) || empty($_GET['user'])): ?>
        
          <?php if(isset($user) && !empty($user)) {?> 
            <table class="w-100 view-numbers-table">
              <thead>
                <tr>
                  <th scope="col">صاحب الرقم</th>
                  <th scope="col">الرقم</th>
                  <th scope="col">السعر</th>
                  <th scope="col">التصنيف</th>
                  <th scope="col">تحكم</th>
                </tr>
              </thead>
              <tbody>
                  <tr>
                    <td><?php echo $user['name']?></td>
                    <td dir="ltr"> <?php 
                        if($userNumber['number_two']) {
                          echo $userNumber['number'] .' - '. $userNumber['number_two'];
                        }else {
                          echo $userNumber['number'];
                        }
                      ?></td>
                    <td><?php echo $userNumber['price']?></td>
                    <td><?php echo categoryNameToNumber($userNumber['category'], true)?></td>
                    <?php if($_SESSION['role'] == 0): ?>
                      <td rowspan="2" class="d-flex justify-content-between align-items-center">
                        <a href="../admin/edit_number.php?id=<?php echo $userNumber['id'] ?>" class="text-decoration-none">
                            <i class="fa-solid fa-pen-to-square text-primary "></i>
                        </a>
                        <a href="../admin/delete_number.php?id=<?php echo $userNumber['id'] ?>"
                          onclick="return confirm('هل أنت متأكد من حذف هذا المستخدم؟');">                  
                          <i class="fa-solid fa-trash text-danger"></i>
                        </a>
                      </td>
                    <?php endif?>
                  </tr>
              </tbody>
          </table>
          <?php }else {?>
          <?php if(!empty($users)) { ?>
            <table class="w-100 view-numbers-table">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">الإسم</th>
                    <th scope="col">اليوزر</th>
                    <th scope="col">عدد الأرقام</th>
                    <th scope="col">تحكم</th>
                  </tr>
                </thead>
                <tbody>
            <?php foreach($users as $key => $user):?>
              <a href="#">
                <tr>
                  <td><?php echo $key+1?></td>
                  <td>
                    <a href="?user=<?php echo $user['id']?>" class="text-decoration-underline text-black">
                      <?php echo $user['name']?>
                    </a>
                  </td>
                  <td><?php echo $user['username']?></td>
                  <td><?php echo getCount('numbers', $user['id'])?></td>

                  <td rowspan="2" class="d-flex justify-content-between align-items-center">
                    <a href="../admin/edit_user.php?id=<?php echo $user['id'] ?>" class="text-decoration-none">
                        <i class="fa-solid fa-pen-to-square text-primary "></i>
                    </a>
                    <a href="../admin/delete_user.php?id=<?php echo $user['id'] ?>"
                      onclick="return confirm('هل أنت متأكد من حذف هذا المستخدم؟');">                  
                      <i class="fa-solid fa-trash text-danger"></i>
                    </a>
                  </td>
                </tr>
              </a>
            <?php endforeach;

            }else {
                  echo "<p class='alert alert-info fw-bold fs-4'>لا يوجد مستخدمين لعرضهم</p>";
            }?>
            
                </tbody>
              </table>
            
          <?php } ?>

      <?php endif;?>

      <?php if(isset($_GET['user']) && is_numeric($_GET['user'])):

        $userid = htmlspecialchars($_GET['user']);
        
          $stmt = $con->prepare("SELECT * FROM numbers WHERE user_id = ?");
          try {
            $stmt->execute([$userid]);

            $userNumbers = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $user = getData('users', 'id', $userid);
            if($user) {
              $pageTitle = "قائمة أرقام: ". $user['name'];
            }else {
              header("Location: users.php");
            }
          }catch(PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
          }

        ?> 

        <?php if(!empty($userNumbers)) { ?>
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
                <?php foreach($userNumbers as $key => $number):?>
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

      endif;
       
  $content = ob_get_clean();

  include_once '../admin/main.php';
?>


