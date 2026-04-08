<?php  
// Define SEO meta as injected to prevent header.php from adding default meta
define('SEO_META_INJECTED', true);

include "header.php";

$numbers = getData("numbers", 'category', 'economic', '', true);

$price_filter = $_GET['price'] ?? 'up';

// Prevent duplicate content from price filters - add noindex for filtered pages
if(isset($price_filter) && $price_filter !== 'up') {
    echo '<meta name="robots" content="noindex, follow">' . "\n";
}

// Prevent duplicate content from price filters
if(isset($price_filter)) {
    if($price_filter == 'down') {
        $numbers = getData("numbers", 'category', 'economic', "ORDER BY CAST(REPLACE(price, ',', '') AS DECIMAL(10,2)) ASC", true);
    }else {  
        $numbers = getData("numbers", 'category', 'economic', "ORDER BY CAST(REPLACE(price, ',', '') AS DECIMAL(10,2)) DESC", true);
    }
}else {
    $numbers = getData("numbers", 'category', 'economic', "ORDER BY CAST(REPLACE(price, ',', '') AS DECIMAL(10,2)) DESC", true);
}

// Get SEO data
$seo = get_seo_data('economic');

// Add canonical tag for price filtered pages
$canonical = $seo['canonical'];
if (isset($price_filter) && $price_filter !== 'up') {
    echo '<link rel="canonical" href="' . $canonical . '">' . "\n";
}

// Generate breadcrumb schema
$breadcrumbs = [
    ['name' => 'الرئيسية', 'url' => SITE_URL . '/'],
    ['name' => 'الأرقام الاقتصادية', 'url' => SITE_URL . '/economic.php']
];
echo generate_breadcrumb_schema($breadcrumbs);

// Generate product schemas for first 10 numbers
$productSchemas = [];
for ($i = 0; $i < min(10, count($numbers)); $i++) {
    $productSchemas[] = generate_product_schema($numbers[$i], 'economic');
}
echo implode("\n", $productSchemas);

// Add customer review schema
echo generate_review_schema('economic');
?>

<main>
<section class="container-lg mt-5 number-page-content text-right economic">
    <!-- Breadcrumb Navigation -->
    <nav aria-label="مسار التنقل" class="breadcrumb-nav" itemscope itemtype="https://schema.org/BreadcrumbList">
        <ol class="breadcrumb" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
            <li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                <a href="/" itemprop="item"><span itemprop="name">الرئيسية</span></a>
                <meta itemprop="position" content="1">
            </li>
            <li class="breadcrumb-item active" aria-current="page" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                <span itemprop="name">الأرقام الاقتصادية</span>
                <meta itemprop="position" content="2">
            </li>
        </ol>
    </nav>

    <?php if(!empty($numbers)) {?>
        <div class="d-flex justify-content-between align-items-center cat-title">
            <h2 class="title">قائمة الأرقام الاقتصادية</h2>
            <div class="filter-price" role="navigation" aria-label="ترتيب حسب السعر">
                <a href="?price=up" class="economic <?php echo $price_filter != 'down' ? 'active' : ''?>" title="أعلى سعر">أعلى سعر</a>
                <a href="?price=down" class="economic <?php echo $price_filter == 'down' ? 'active' : ''?>" title="أقل سعر">أقل سعر</a>
            </div>
        </div>
        
        <p class="category-description">
            اكتشف مجموعة واسعة من الأرقام الاقتصادية المميزة بأسعار مناسبة. أرقام تبدأ من 0 إلى 499 ريال، مثالية لمن يبحث عن رقم مميز بتكلفة اقتصادية.
        </p>
        
        <div class="boxes-card" itemscope itemtype="https://schema.org/ItemList">
            <?php foreach($numbers as $index => $number):
                 $buyLink =  "أريد شراء هذا الرقم: " . str_replace(' ','', $number['number'])
                ?>
                <article class="box-card" itemprop="itemListElement" itemscope itemtype="https://schema.org/Product">
                    <div class="info-side">
                        <h2 class="phone-number display-number" dir="ltr" itemprop="name"><?php echo $number['number'] ?></h2>
                        <meta itemprop="description" content="<?php echo htmlspecialchars(generate_product_description($number, 'economic')); ?>">
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
        
        <div class="category-footer">
            <h3>ما لقيت الي يناسبك؟</h3>
            <p>تواصل معنا وسنوفر لك أفضل الأرقام الاقتصادية المميزة.</p>
            <a href="https://wa.link/jm23mv" class="btn btn-lg" target="_blank" rel="noopener">تواصل معنا عبر واتساب</a>
        </div>
        
    <?php }else {?>
            <div class="not-found">
                <img src="images/not-found.png" alt="لا توجد أرقام اقتصادية متوفرة حالياً">
                <h2>لا توجد أرقام لعرضها</h2>
                <p>حالياً لا تتوفر أرقام اقتصادية، تواصل معنا للبحث عن رقم مناسب لك.</p>
                <a href="https://wa.link/jm23mv" class="btn btn-lg" target="_blank" rel="noopener">تواصل معنا</a>
            </div>
    <?php }?>
</section>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
