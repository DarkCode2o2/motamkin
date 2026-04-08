<?php 
    $pageTitle = "قائمة المستخدمين";

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
    

    ob_start();
?>
      <?php if(!isset($_GET['user']) || empty($_GET['user'])): ?>
        
          <?php if(isset($user) && !empty($user)) {?> 
            <!-- User Info Card -->
            <div class="elite-cards-container">
              <h4 class="elite-cards-title">معلومات صاحب الرقم</h4>
              <div class="row">
                <div class="col-12 col-md-6">
                  <div class="elite-card">
                    <div class="card-details">
                      <div>
                        <p class="text-muted mb-1">الإسم</p>
                        <p class="fw-bold"><?php echo $user['name']?></p>
                      </div>
                      <div>
                        <p class="text-muted mb-1">اليوزر</p>
                        <p class="fw-bold"><?php echo $user['username']?></p>
                      </div>
                    </div>
                    <div class="card-details mt-3">
                      <div>
                        <p class="text-muted mb-1">الرقم</p>
                        <p class="fw-bold" dir="ltr">
                          <?php 
                            if($userNumber['number_two']) {
                              echo $userNumber['number'] .' - '. $userNumber['number_two'];
                            }else {
                              echo $userNumber['number'];
                            }
                          ?>
                        </p>
                      </div>
                      <div>
                        <p class="text-muted mb-1">السعر</p>
                        <p class="fw-bold"><?php echo $userNumber['price']?></p>
                      </div>
                    </div>
                    <div class="card-details mt-3">
                      <div class="category-badge">
                        <i class="fa-solid fa-tag"></i>
                        <?php echo categoryNameToNumber($userNumber['category'], true)?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <?php }else {?>
            <?php if(!empty($users)) { ?>
              <!-- Users Cards Grid -->
              <div class="elite-cards-container">
                <h4 class="elite-cards-title">جميع المستخدمين</h4>
                <div class="row">
              <?php foreach($users as $key => $user):?>
                  <div class="col-12 col-md-6 col-lg-4">
                    <div class="elite-card">
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
              
              <?php } else { ?>
                <!-- Empty State -->
                <div class="empty-state">
                  <i class="fa-solid fa-users"></i>
                  <p>لا يوجد مستخدمين لعرضهم</p>
                </div>
              <?php } 
          }
        endif;?>

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
          <!-- User Numbers Cards Grid -->
          <div class="elite-cards-container">
            <div class="d-flex align-items-center justify-content-between mb-4">
              <h4 class="elite-cards-title mb-0">أرقام: <?php echo $user['name']?></h4>
              <a href="users.php" class="btn-outline-primary">
                <i class="fa-solid fa-arrow-right"></i>
                العودة للقائمة
              </a>
            </div>
            
            <div class="row">
              <?php foreach($userNumbers as $key => $number):?>
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
                  <div class="elite-card <?php echo $categoryClass ?>">
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
        <?php 
          }else {
          ?>
            <!-- Empty State -->
            <div class="empty-state">
              <i class="fa-solid fa-inbox"></i>
              <p>لا توجد أرقام لعرضها</p>
            </div>
          <?php 
          }

      endif;
       
  $content = ob_get_clean();

  include_once '../admin/main.php';
?>