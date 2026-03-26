<?php 
    session_start();

    include_once '../config/helpers.php';

    if(isset($_SESSION['username'])) {
        header("location:  ../admin");
        exit;
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = htmlspecialchars($_POST['username']);
        $pass = htmlspecialchars($_POST['password']);

        $user = getData('users', 'username', $username);


        if($user) {
            if(password_verify($pass, $user['password'])) {

                $_SESSION['username'] = $user['username'];
                $_SESSION['name'] = $user['name'];
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = $user['role'];
    
                header("Location: ../admin");
                exit();
            }else {
                $error = '<p class="msg text-danger fw-bold">خطأ في كلمة المرور</p>';
            }
        }else {
            $error = '<p class="msg text-danger fw-bold">خطأ في اسم المستخدم</p>';
        }
    }
?>


<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="../admin/css/custom.css">
    <link rel="stylesheet" href="../css/all.min.css">
    <link href="../admin/assets/dist/css/bootstrap.rtl.min.css" rel="stylesheet" />
</head>
<body>
    
    <div class="container login-page">
        <h3 class="login-title mb-3 fs-2 text-center">تسجيل دخول</h3>
        <form action="" method="post" class="login-form text-start shadow-sm">
            <label for="username" class="w-100 text-right fs-4">اسم المستخدم</label>
            <div class="input-group mb-3 mt-1">
                <input type="text" id="username" class="form-control" name="username" required>
            </div>

            <label for="password" class="w-100 text-right fs-4">كلمة المرور</label>
            <div class="input-group mb-3 mt-1">
                <input type="password" id="password" placeholder="*********" class="form-control" required name="password">
            </div>
            <?php echo $error ?? null?>

           <div class="w-100 d-flex justify-content-between align-items-end">
                 <input type="submit" value="تسجيل دخول" class="btn btn-primary">
                <a href="/" class="text-start btn btn-secondary btn-sm text-decoration-none">الصفحة الرئيسية <i class="fa-solid fa-house"></i></a>
           </div>
        </form>
    </div>
   
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>