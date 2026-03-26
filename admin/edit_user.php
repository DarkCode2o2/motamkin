<?php 
    ob_start();
    session_start();
    include_once '../config/helpers.php'; 
    $id = htmlspecialchars($_GET['id']);
    
    $userData = getData('users', 'id', $id);

    
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = htmlspecialchars($_POST['name']);
        $username = htmlspecialchars($_POST['username']);
        $password = htmlspecialchars($_POST['password']);
        $role = htmlspecialchars($_POST['role']);

        if(!empty($password)) {
            $stmt = $con->prepare("UPDATE users SET name = ?, username = ?, password = ?, role = ? WHERE id = ?");
            try {
                $stmt->execute([$name, $username, password_hash($password, PASSWORD_DEFAULT), $role, $id]);
                header("Refresh: 2");
                $msg = "تم التعديل بنجاح!";
            } catch(PDOException $e) {
                echo $e->getMessage();
            }
        }else {
            $stmt = $con->prepare("UPDATE users SET name = ?, username = ?, role = ? WHERE id = ?");
            try {
                $stmt->execute([$name, $username, $role, $id]);
                header("Refresh: 2");
                $msg = "تم التعديل بنجاح!";
            } catch(PDOException $e) {
                echo $e->getMessage();
            }
        }
    }
    $pageTitle = "تعديل المستخدم";


    if($userData){
?>      
    <form action="" method="post" class="add-form my-4 text-start bg-light-subtle p-4 rounded">
        <label for="name" class="w-fit-content text-right fs-5">اسم المستخدم</label>
        <div class="input-group mb-3 mt-1">
            <input type="text" id="name" value="<?php echo $userData['name'] ?? '' ?>" class="form-control" name="name" required>
        </div>
        <label for="username" class="w-100 text-right fs-5">اليوزر</label>
        <div class="input-group mb-3 mt-1">
            <input type="text" id="username" value="<?php echo $userData['username'] ?? '' ?>" class="form-control" name="username" required>
        </div>

        <label for="password" class="w-100 text-right fs-5">كلمة المرور</label>
        <div class="input-group mb-3 mt-1">
        <input type="password" id="password" class="form-control" name="password" placeholder="إذا كنت لا تريد تغير كلمة المرور اتركه فارغا">
        </div>

        <label class="w-100 text-right fs-5">أختر تصنيف المستخدم</label>
        <div class="form-floating input-group mb-3 mt-1">
            <select class="form-select p-0 ps-2" name="role" id="categorySelect" aria-label="Floating label select example">
                <option value="0" <?php echo $userData['role'] == 0 ? 'selected' : '' ?>>مسئوول</option>
                <option value="1" <?php echo $userData['role'] == 1 ? 'selected' : '' ?>>مستخدم</option>
            </select>
        </div>

        <?php if(isset($msg)):?>
        <p class="mt-2 alert alert-success"><?php echo $msg ?> <i class="fa-solid fa-circle-check"></i></p>
        <?php endif?>
        <?php if(isset($msgError)):?>
        <p class="mt-2 alert alert-danger"><?php echo $msgError ?> <i class="fa-solid fa-circle-xmark"></i></p>
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


