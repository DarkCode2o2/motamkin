<?php  include "header.php";
    $numbers = getData("numbers", 'category', 'bundle', '', true);
?>

<section class="container-lg mt-5 number-page-content text-right bundle">
    <?php if(!empty($numbers)) {?>
        <h2 class="title">قائمة أرقام الطقم</h2>
        <div class="boxes-card">
            <?php foreach($numbers as $number):
                 $buyLink =  'أريد شراء هذا الطقم: ' . str_replace(' ','', $number['number']) . '-'.  str_replace(' ','', $number['number_two']);
                ?>
                <div class="box-card">
                    <div class="info-side">
                        <h3 class="phone-number display-number" dir="ltr">
                            <p>
                                <?php echo $number['number'] ?>
                            </p>
                            <p>
                                <?php echo $number['number_two'] ?>
                            </p>
                        </h3>
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