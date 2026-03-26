<?php 
    $pageTitle = "قائمة المستخدمين";

    include_once '../config/helpers.php';
    $users = getData('users', 'role', '1', 'ORDER BY id DESC', true);
    ob_start();
?>
  
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
            <tr>
              <td><?php echo $key+1?></td>
              <td><?php echo $user['name']?></td>
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
          <?php endforeach?>
        </tbody>
    </table>
<?php 
  }else {
        echo "<p class='alert alert-info fw-bold fs-4'>لا يوجد مستخدمين لعرضهم</p>";
  }
  $content = ob_get_clean();

  include_once '../admin/main.php';
?>


