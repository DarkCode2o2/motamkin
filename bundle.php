<?php  
// Define SEO meta as injected to prevent header.php from adding default meta
define('SEO_META_INJECTED', true);

include "header.php";

$numbers = getData("numbers", 'category', 'bundle', '', true);

$price_filter = $_GET['price'] ?? 'up';

// Prevent duplicate content from price filters - add noindex for filtered pages
if(isset($price_filter) && $price_filter !== 'up') {
    echo '<meta name="robots" content="noindex, follow">' . "\n";
}

// Prevent duplicate content from price filters
if(isset($price_filter)) {
   if($price_filter == 'down') {
        $numbers = getData("numbers", 'category', 'bundle', "ORDER BY CAST(REPLACE(price, ',', '') AS DECIMAL(10,2)) ASC", true);
    }else {  
        $numbers = getData("numbers", 'category', 'bundle', "ORDER BY CAST(REPLACE(price, ',', '') AS DECIMAL(10,2)) DESC", true);
    }
}else {
    $numbers = getData("numbers", 'category', 'bundle', "ORDER BY CAST(REPLACE(price, ',', '') AS DECIMAL(10,2)) DESC", true);
}

// Get SEO data
$seo = get_seo_data('bundle');

// Add canonical tag for price filtered pages
$canonical = $seo['canonical'];
if (isset($price_filter) && $price_filter !== 'up') {
    echo '<link rel="canonical" href="' . $canonical . '">' . "\n";
}

// Generate breadcrumb schema
$breadcrumbs = [
    ['name' => 'الرئيسية', 'url' => SITE_URL . '/'],
    ['name' => 'أرقام الطقم', 'url' => SITE_URL . '/bundle.php']
];
echo generate_breadcrumb_schema($breadcrumbs);

// Generate product schemas for first 10 numbers
$productSchemas = [];
for ($i = 0; $i < min(10, count($numbers)); $i++) {
    $productSchemas[] = generate_product_schema($numbers[$i], 'bundle');
}
echo implode("\n", $productSchemas);

// Add customer review schema
echo generate_review_schema('bundle');
?>

<main>
<section class="container-lg mt-5 number-page-content text-right bundle">
    <!-- Breadcrumb Navigation -->
    <nav aria-label="مسار التنقل" class="breadcrumb-nav" itemscope itemtype="https://schema.org/BreadcrumbList">
        <ol class="breadcrumb" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
            <li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                <a href="/" itemprop="item"><span itemprop="name">الرئيسية</span></a>
                <meta itemprop="position" content="1">
            </li>
            <li class="breadcrumb-item active" aria-current="page" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                <span itemprop="name">أرقام الطقم</span>
                <meta itemprop="position" content="2">
            </li>
        </ol>
    </nav>

    <?php if(!empty($numbers)) {?>
        <div class="d-flex justify-content-between align-items-center cat-title">
            <h2 class="title">قائمة أرقام الطقم</h2>
             <div class="filter-price" role="navigation" aria-label="ترتيب حسب السعر">
                <a href="?price=up" class="bundle <?php echo $price_filter != 'down' ? 'active' : ''?>" title="أعلى سعر">أعلى سعر</a>
                <a href="?price=down" class="bundle <?php echo $price_filter == 'down' ? 'active' : ''?>" title="أقل سعر">أقل سعر</a>
            </div>
        </div>
        
        <p class="category-description">
            احصل على أرقام طقم مميزة - أرقام مزدوجة متكاملة. مثالية للأسر والشركات. أرقام متناسقة ومميزة.
        </p>
    <div class="boxes-card" itemscope itemtype="https://schema.org/ItemList">

        <?php foreach ($numbers as $index => $number):

            $isSold = (string)($number['status'] ?? '0') === '1';

            $buyLink =  'أريد شراء هذا الطقم: ' . str_replace(' ','', $number['number']) . ' - '.  str_replace(' ','', $number['number_two']);

            $safeNumber = htmlspecialchars($number['number'], ENT_QUOTES, 'UTF-8');

        ?>

            <article
                class="box-card <?= $isSold ? 'is-sold' : '' ?>"
                
                itemprop="itemListElement"
                itemscope
                itemtype="https://schema.org/Product">

                <div class="info-side">

                    <div class="number-heading">

                        <h2 class="phone-number display-number" dir="ltr" itemprop="name">
                            <p><?php echo $number['number'] ?></p>
                            <p><?php echo $number['number_two'] ?></p>
                        </h2>

                        <?php if ($isSold): ?>
                            <span class="sold-badge">مباع</span>
                        <?php endif; ?>

                    </div>

                    <meta itemprop="description"
                        content="<?= htmlspecialchars(generate_product_description($number, 'economic'), ENT_QUOTES, 'UTF-8') ?>">

                </div>

                <div class="action-side">

                    <div class="price"
                        itemprop="offers"
                        itemscope
                        itemtype="https://schema.org/Offer">

                        <span itemprop="price"
                            content="<?= (int)str_replace([',', ' '], '', $number['price']) ?>">
                            <?= htmlspecialchars($number['price'], ENT_QUOTES, 'UTF-8') ?>
                        </span>

                        <meta itemprop="priceCurrency" content="SAR">

                        <link itemprop="availability"
                            href="https://schema.org/<?= $isSold ? 'OutOfStock' : 'InStock' ?>">

                    </div>

                     <?php if ($isSold) {?>
                        <div class="sold-overlay">
                            <span class="sold-ribbon">تم البيع</span>
                        </div>
                    <?php }else {?>
                        <a href="https://wa.me/+966500550950?text=<?php echo urlencode($buyLink)?>" target="_blank" rel="noopener" class="whatsapp-btn" aria-label="حجز طقم أرقام عبر واتساب">حجز عبر الواتساب <i class="fa-brands fa-whatsapp" aria-hidden="true"></i></a>

                    <?php } ?>

                </div>

                </article>

            <?php endforeach; ?>

        </div>
 <section class="premium-auction sec" aria-labelledby="auction-title">
      <div class="auction-art" aria-label="مطرقة مزاد ذهبية وأرقام مميزة" role="img">
        <div class="art-glow"></div>
        <div class="art-caption">
          <span class="caption-dot"></span>
          <span>أرقام تستحق الاقتناء</span>
        </div>
      </div>

      <div class="auction-content">
        <div class="top-pill">
          <span class="live-dot"></span>
          <span>مزادات وأرقام جديدة يومياً</span>
        </div>

        <div class="headline-wrap">
          <span class="flame" aria-hidden="true">🔥</span>
          <h2 id="auction-title">لا يفوتك المزاد!</h2>
        </div>

        <p class="intro">
          انضم لقروب مزاد المتمكن، وكن أول المطلعين على الأرقام الجديدة والمميزة.
        </p>

        <div class="features" aria-label="مميزات الخدمة">
          <div class="feature">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2 20 5v6c0 5-3.4 9-8 11-4.6-2-8-6-8-11V5l8-3Z"/><path d="m8.5 12 2.2 2.2 4.8-5"/></svg>
            <span>آمن وموثوق</span>
          </div>
          <span class="feature-separator"></span>
          <div class="feature">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="m13 2-9 12h7l-1 8 10-13h-7l0-7Z"/></svg>
            <span>مزادات يومية</span>
          </div>
          <span class="feature-separator"></span>
          <div class="feature">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="m12 2 3 6 7 1-5 5 1 8-6-3-6 3 1-8-5-5 7-1 3-6Z"/></svg>
            <span>أرقام حصرية</span>
          </div>
        </div>

        <a class="cta" href="https://chat.whatsapp.com/KfspL8lpPLcACmy4Cz0ibD" target="_blank" rel="noopener">
          <span>انضم للمزاد الآن</span>
          <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M19 12H5m0 0 6 6m-6-6 6-6"/></svg>
        </a>
        <p class="microcopy">فرصتك القادمة قد تكون هنا</p>
      </div>
    </section>
        
    <?php }else {?>
            <div class="not-found">
                <img src="images/not-found.png" alt="لا توجد أرقام طقم متوفرة حالياً">
                <h2>لا توجد أرقام لعرضها</h2>
                <p>حالياً لا تتوفر أرقام طقم، تواصل معنا للبحث عن أرقام مناسبة لك.</p>
                <a href="https://wa.link/jm23mv" class="btn btn-lg" target="_blank" rel="noopener">تواصل معنا</a>
            </div>
    <?php }?>
</section>
</main>

<?php include "footer.php";?>   
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
