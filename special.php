<?php  include "header.php";
    $numbers = getData("numbers", 'category', 'special', '', true);
    $price_filter = $_GET['price'] ?? 'up';

    if(isset($price_filter)) {

        if($price_filter == 'down') {
            $numbers = getData("numbers", 'category', 'special', "ORDER BY CAST(REPLACE(price, ',', '') AS DECIMAL(10,2)) ASC", true);
        }else {  
            $numbers = getData("numbers", 'category', 'special', "ORDER BY CAST(REPLACE(price, ',', '') AS DECIMAL(10,2)) DESC", true);
        }

    }else {
        $numbers = getData("numbers", 'category', 'special', "ORDER BY CAST(REPLACE(price, ',', '') AS DECIMAL(10,2)) DESC", true);
    }
?>
<section class="container-lg mt-5 number-page-content text-right special">
     <?php if(!empty($numbers)) {?>
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="title">قائمة الأرقام المميزة</h2>
            <div class="filter-price">
                <h4>السعر:</h4>
                <a href="?price=up" class="special <?php echo $price_filter != 'down' || '' ? 'active' : ''?>">الأعلى</a>
                <a href="?price=down" class="special <?php echo $price_filter == 'down' ? 'active' : ''?>">الأقل</a>
            </div>
        </div>
        <div class="boxes-card">
            <?php foreach($numbers as $number):
                 $buyLink =  "أريد شراء هذا الرقم: " . str_replace(' ','', $number['number'])
                ?>
                <div class="box-card">
                    <div class="info-side">
                        <h3 class="phone-number display-number" dir="ltr"><?php echo $number['number'] ?></h3>
                    </div>
                    <div class="action-side">
                        <div class="price"><?php echo $number['price'] ?></div>
                        <a href="https://wa.me/+966500550950?text=<?php echo $buyLink?>" target="_blank" class="whatsapp-btn">حجز عبر الواتساب <i class="fa-brands fa-whatsapp"></i></a>
                    </div>
                </div> 
            <?php endforeach;?>
        </div>
    <?php }else {?>
            <div class="not-found">
                <img src="images/not-found.png" alt="">
                <h2>لا توجد أرقام لعرضها <i class="fa-solid fa-circle-info"></i></h2>
            </div>
    <?php }?>
</section>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>