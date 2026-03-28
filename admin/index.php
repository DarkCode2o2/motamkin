<?php 

  session_start();
  include_once '../config/helpers.php';

  $numbers = getData('numbers', 'user_id', $_SESSION['user_id'], 'ORDER BY id DESC LIMIT 5', true);
  $numberCount = getCount('numbers', $_SESSION['user_id']);
  ob_start();
  $pageTitle = "حياك الله، " . $_SESSION['name'];
?>
  <section class="container mb-5">
    <div class="boxes row text-white gap-4 text-center">
      <div class="box col bg-info bg-gradient rounded pt-4 shadow-md">
        <h2 class="fs-1"><?php echo $numberCount?></h2>
        <p>عدد الأرقام المتاحة</p>
      </div>
    </div>
  </section>
  
  <?php if(!empty($numbers)) {?>
    <div class="table-responsive small my-5">
      <h4>آخر الأرقام المضافة</h4>
      <table class="w-100 view-numbers-table">
          <thead>
            <tr>
              <th scope="col">الرقم</th>
              <th scope="col">السعر</th>
              <th scope="col">التصنيف</th>
              <th scope="col">تحكم</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($numbers as $key => $number):?>
              <tr>
                <td dir="ltr"><?php 
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
    </div>
<?php 
  }
  $content = ob_get_clean();

  include_once '../admin/main.php';
?>


