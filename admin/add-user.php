<?php 

  include_once '../connect.php';
  include_once "../config/helpers.php";
  if($_SERVER['REQUEST_METHOD'] == 'POST') {

    $name = htmlspecialchars($_POST['name']);
    $username = htmlspecialchars($_POST['username']);
    $password = password_hash(htmlspecialchars($_POST['password']), PASSWORD_DEFAULT);
    $role = htmlspecialchars($_POST['role']);

    if(!isExists($username)) {
        $stmt = $con->prepare("INSERT INTO users (name, username, password, role) VALUES (?, ?, ?, ?)");
        try {
            $stmt->execute([$name, $username, $password, $role]);
                header("Refresh: 2");
                $msg = "تم إضافة مستخدم جديد بنجاح!";
            } catch(PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
        }
    }else {
        $msgError = "عذرا اليوزر مستخدم بالفعل!";
        header("Refresh: 2");
    }
  }
  $pageTitle = "إضافة مستخدم جديد";

  ob_start();
?>
  
  <form action="" method="post" class="add-form my-4 text-start bg-light-subtle p-4 rounded">

    <label for="name" class="w-100 text-right fs-5">اسم المستخدم</label>
    <div class="input-group mb-3 mt-1">
        <input type="text" id="name" class="form-control" name="name" required>
    </div>
    <label for="username" class="w-100 text-right fs-5">اليوزر</label>
    <div class="input-group mb-3 mt-1">
        <input type="text" id="username" class="form-control" name="username" required>
    </div>

    <label for="password" class="w-100 text-right fs-5">كلمة المرور</label>
    <div class="input-group mb-3 mt-1">
      <input type="password" id="password" class="form-control" name="password" required>
    </div>

    <label class="w-100 text-right fs-5">أختر تصنيف المستخدم</label>
    <div class="form-floating input-group mb-3 mt-1">
        <select class="form-select p-0 ps-2" name="role" id="categorySelect" aria-label="Floating label select example">
          <option value="0">مسئوول</option>
          <option value="1" selected>مستخدم</option>
        </select>
    </div>

    <?php if(isset($msg)):?>
      <p class="mt-2 alert alert-success"><?php echo $msg ?> <i class="fa-solid fa-circle-check"></i></p>
    <?php endif?>
    <?php if(isset($msgError)):?>
      <p class="mt-2 alert alert-danger"><?php echo $msgError ?> <i class="fa-solid fa-circle-xmark"></i></p>
    <?php endif?>
    <input type="submit" value="إضافة" class="btn btn-primary">
  </form>

<?php 
  $content = ob_get_clean();
      
  include_once '../admin/main.php';
?>


