<?php  
// Define SEO meta as injected to prevent header.php from adding default meta
define('SEO_META_INJECTED', true);

include "header.php";

$numbers = getData("numbers", 'category', 'vip', '', true);
$price_filter = $_GET['price'] ?? 'up';

// Prevent duplicate content from price filters - add noindex for filtered pages
if(isset($price_filter) && $price_filter !== 'up') {
    echo '<meta name="robots" content="noindex, follow">' . "\n";
}

// Prevent duplicate content from price filters
if(isset($price_filter)) {
    if($price_filter == 'down') {
        $numbers = getData("numbers", 'category', 'vip', "ORDER BY CAST(REPLACE(price, ',', '') AS DECIMAL(10,2)) ASC", true);
    }else {  
        $numbers = getData("numbers", 'category', 'vip', "ORDER BY CAST(REPLACE(price, ',', '') AS DECIMAL(10,2)) DESC", true);
    }
}else {
    $numbers = getData("numbers", 'category', 'vip', "ORDER BY CAST(REPLACE(price, ',', '') AS DECIMAL(10,2)) DESC", true);
}

// Get SEO data
$seo = get_seo_data('vip');

// Add canonical tag for price filtered pages
$canonical = $seo['canonical'];
if (isset($price_filter) && $price_filter !== 'up') {
    echo '<link rel="canonical" href="' . $canonical . '">' . "\n";
}

// Generate breadcrumb schema
$breadcrumbs = [
    ['name' => 'الرئيسية', 'url' => SITE_URL . '/'],
    ['name' => 'أرقام VIP', 'url' => SITE_URL . '/vip.php']
];
echo generate_breadcrumb_schema($breadcrumbs);

// Generate product schemas for first 10 numbers
$productSchemas = [];
for ($i = 0; $i < min(10, count($numbers)); $i++) {
    $productSchemas[] = generate_product_schema($numbers[$i], 'vip');
}
echo implode("\n", $productSchemas);

// Add customer review schema
echo generate_review_schema('vip');
?>

<main>
<section class="container-lg mt-5 number-page-content text-right vip">
    <!-- Breadcrumb Navigation -->
    <nav aria-label="مسار التنقل" class="breadcrumb-nav" itemscope itemtype="https://schema.org/BreadcrumbList">
        <ol class="breadcrumb" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
            <li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                <a href="/" itemprop="item"><span itemprop="name">الرئيسية</span></a>
                <meta itemprop="position" content="1">
            </li>
            <li class="breadcrumb-item active" aria-current="page" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                <span itemprop="name">أرقام VIP</span>
                <meta itemprop="position" content="2">
            </li>
        </ol>
    </nav>

     <?php if(!empty($numbers)) {?>
        <div class="d-flex justify-content-between align-items-center cat-title">
            <h2 class="title">قائمة الأرقام VIP</h2>
            <div class="filter-price" role="navigation" aria-label="ترتيب حسب السعر">
                <a href="?price=up" class="vip <?php echo $price_filter != 'down' ? 'active' : ''?>" title="أعلى سعر">أعلى سعر</a>
                <a href="?price=down" class="vip <?php echo $price_filter == 'down' ? 'active' : ''?>" title="أقل سعر">أقل سعر</a>
            </div>
        </div>
        
        <p class="category-description">
            تسوق أرقام VIP الفاخرة والراقية من 5000 ريال فما فوق. أرقام تليق بمقامك وتعكس شخصيتك المميزة.
        </p>
        
        <div class="boxes-card" itemscope itemtype="https://schema.org/ItemList">
            <?php foreach($numbers as $index => $number):
                 $buyLink =  "أريد شراء هذا الرقم: " . str_replace(' ','', $number['number'])
                ?>
                <article class="box-card" itemprop="itemListElement" itemscope itemtype="https://schema.org/Product">
                    <div class="info-side">
                        <h2 class="phone-number display-number" dir="ltr" itemprop="name"><?php echo $number['number'] ?></h2>
                        <meta itemprop="description" content="<?php echo htmlspecialchars(generate_product_description($number, 'vip')); ?>">
                    </div>
                    <div class="action-side">
                        <div class="price" itemprop="offers" itemscope itemtype="https://schema.org/Offer">
                            <span itemprop="price" content="<?php echo (int)str_replace([',', ' '], '', $number['price']); ?>">
                                <?php echo $number['price'] ?>
                            </span>
                            <meta itemprop="priceCurrency" content="SAR">
                            <link itemprop="availability" href="https://schema.org/InStock">
                        </div>
                        <a href="https://wa.me/+966500550950?text=<?php echo urlencode($buyLink)?>" target="_blank" rel="noopener" class="whatsapp-btn" aria-label="حجز رقم <?php echo $number['number']; ?> عبر واتساب">حجز عبر الواتساب <i class="fa-brands fa-whatsapp" aria-hidden="true"></i></a>
                    </div>
                </article> 
            <?php endforeach;?>
        </div>
        
            <div class="auction-card" style="width: 100%;" dir="rtl">
            <div class="auction-content">
                <div>
                    <h2>لا يفوتك المزاد!</h2>
                    <span class="auction-icon">🔥</span>
                </div>
                <h3>أرقام مميزة.. ومزايدات يومية</h3>

                <p>
                    انضم لقروب مزاد المتمكن وكن أول المطلعين
                    على الأرقام الجديدة
                </p>

                <a href="https://chat.whatsapp.com/KfspL8lpPLcACmy4Cz0ibD?s=cl&p=i&iam=2" target="_blank" class="auction-btn">
                    انضم للمزاد الآن
                    <span>
                        <i class="fa-solid fa-arrow-left-long"></i>
                    </span>
                </a>
            </div>
        </div>
        
    <?php }else {?>
            <div class="not-found">
                <img src="images/not-found.png" alt="لا توجد أرقام VIP متوفرة حالياً">
                <h2>لا توجد أرقام لعرضها</h2>
                <p>حالياً لا تتوفر أرقام VIP، تواصل معنا للبحث عن رقم مناسب لك.</p>
                <a href="https://wa.link/jm23mv" class="btn btn-lg" target="_blank" rel="noopener">تواصل معنا</a>
            </div>
    <?php }?>
</section>
</main>
<?php include "footer.php";?>   
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
