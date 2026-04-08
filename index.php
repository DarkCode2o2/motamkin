<?php 
    include_once "config/helpers.php";
    include_once "config/seo-helpers.php";

    $numbers = getData('numbers', '', '', 'ORDER BY id DESC');

    // Get SEO data
    $seo = get_seo_data('index');
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($seo['title']); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($seo['description']); ?>">
    <meta name="keywords" content="<?php echo htmlspecialchars(generate_meta_keywords('index')); ?>">
    <link rel="canonical" href="<?php echo SITE_URL; ?>">
    
    <!-- Open Graph -->
    <meta property="og:title" content="<?php echo htmlspecialchars($seo['og_title']); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($seo['og_description']); ?>">
    <meta property="og:image" content="<?php echo SITE_URL; ?>/images/icon.png">
    <meta property="og:url" content="<?php echo SITE_URL; ?>">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="<?php echo SITE_NAME; ?>">
    <meta property="og:locale" content="ar_SA">
    
    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo htmlspecialchars($seo['title']); ?>">
    <meta name="twitter:description" content="<?php echo htmlspecialchars($seo['description']); ?>">
    <meta name="twitter:image" content="<?php echo SITE_URL; ?>/images/icon.png">
    
    <!-- Additional SEO Meta -->
    <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large">
    <meta name="author" content="<?php echo SITE_NAME; ?>">
    <meta name="language" content="Arabic">
    
    <!-- hreflang -->
    <link rel="alternate" hreflang="ar" href="<?php echo SITE_URL; ?>">
    <link rel="alternate" hreflang="x-default" href="<?php echo SITE_URL; ?>">
    
    <link rel="icon" type="image/png" href="images/icon.png">
    <?php include_once "config/links.php"; ?>
    
    <!-- Preconnect -->
    <link rel="preconnect" href="https://cdn.jsdelivr.net">
    
    <!-- Structured Data -->
    <?php echo generate_organization_schema(); ?>
    <?php echo generate_website_schema(); ?>
    <?php echo generate_faq_schema(); ?>
    <?php echo generate_localbusiness_schema(); ?>
    <?php echo generate_review_schema('index'); ?>
    <?php echo generate_howto_schema(); ?>
</head>
<body>
    <!-- Structured Data for Homepage -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebPage",
        "@id": "<?php echo SITE_URL; ?>#webpage",
        "url": "<?php echo SITE_URL; ?>",
        "name": "<?php echo htmlspecialchars($seo['title']); ?>",
        "description": "<?php echo htmlspecialchars($seo['description']); ?>",
        "isPartOf": {
            "@type": "WebSite",
            "@id": "<?php echo SITE_URL; ?>#website"
        }
    }
    </script>

    <div class="container-tape">
        <p class="left">يوجد تقسيط على أربع دفعات 💸</p>
        <p class="left">يوجد تقسيط على أربع دفعات 💸</p>
        <p class="left">يوجد تقسيط على أربع دفعات 💸</p>
        <p>يوجد تقسيط على أربع دفعات 💸</p>
        <p>يوجد تقسيط على أربع دفعات 💸</p>
    </div>
    
    <div class="icons" target="_blank">
        <a href="https://wa.link/jm23mv" aria-label="تواصل معنا عبر واتساب لشراء أرقام مميزة">
          <i class="fa-brands fa-whatsapp whatsapp" aria-hidden="true"></i>
        </a>
        <a href="https://www.snapchat.com/add/almotamkin" aria-label="تابعنا على سناب شات">
           <svg class="snapchat" viewBox="0 0 72 72" width="35" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-label="أيقونة سناب شات">
                    <title>Snapchat</title>
                    <desc>رابط صفحتنا على سناب شات</desc>
                    <defs></defs>
                    <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <g id="Social-Icons---Circle" transform="translate(-40.000000, -155.000000)">
                            <g id="Snapchat" transform="translate(40.000000, 155.000000)">
                                <path d="M36,72 L36,72 C55.882251,72 72,55.882251 72,36 L72,36 C72,16.117749 55.882251,-3.65231026e-15 36,0 L36,0 C16.117749,3.65231026e-15 -2.4348735e-15,16.117749 0,36 L0,36 C2.4348735e-15,55.882251 16.117749,72 36,72 Z" id="Oval" fill="#FFE400"></path>
                                <path d="M36.46152,14 L36.4594053,14 C36.4179819,14 36.3790465,14 36.341977,14.0004961 C36.0464159,14.0034729 35.5605315,14.0081862 35.516869,14.0086823 C34.4513068,14.0086823 32.3193115,14.1587621 30.029211,15.1666533 C28.7198357,15.742538 27.5420697,16.5212165 26.5287531,17.481107 C25.3206349,18.6248143 24.3364265,20.0349442 23.6039924,21.6729225 C22.5313397,24.0712224 22.785975,28.1108496 22.9904793,31.3571623 L22.9912257,31.3622477 C23.0131191,31.7099119 23.0361321,32.0729561 23.0571547,32.4266979 C22.8997958,32.498761 22.644663,32.5747932 22.2686187,32.5747932 C21.6635645,32.5747932 20.9440674,32.3819221 20.1306525,32.0018853 C19.8913177,31.8907518 19.6181477,31.8345649 19.3167401,31.8345649 C18.8324728,31.8345649 18.3219582,31.9767066 17.8791142,32.2363075 C17.3219518,32.562514 16.9619545,33.0235442 16.8641805,33.5346837 C16.7997442,33.8727974 16.8028541,34.5410866 17.5473544,35.2188023 C17.9568607,35.5918932 18.558432,35.9359604 19.3349017,36.2419496 C19.5386597,36.3219508 19.7804824,36.398355 20.0366104,36.4793485 C20.9254082,36.7610272 22.2706091,37.1865841 22.6214012,38.0097903 C22.7991608,38.427161 22.7226582,38.9763786 22.3946303,39.6402026 C22.386047,39.6583114 22.3774638,39.6760481 22.369627,39.6946531 C22.2876511,39.8855397 21.5228744,41.6128217 19.9541369,43.4344927 C19.0627268,44.4704154 18.0808819,45.336165 17.0374619,46.0084232 C15.7639122,46.8291488 14.3858713,47.3657151 12.9420257,47.602866 C12.3750361,47.6956426 11.9701324,48.1993401 12.0017286,48.7717519 C12.0114313,48.9367157 12.0502424,49.1011833 12.1175397,49.2603175 C12.1180373,49.2613097 12.1186593,49.262302 12.1191569,49.2631702 C12.3484157,49.797876 12.8799529,50.2520844 13.7441206,50.6527107 C14.8001045,51.1417723 16.3794156,51.5531894 18.4377694,51.8750548 C18.5417631,52.0722671 18.6497374,52.5679025 18.7244985,52.9072565 C18.8027425,53.2679441 18.8843452,53.6388024 19.000654,54.0327309 C19.1261679,54.4595281 19.451708,54.9695513 20.2880114,54.9695513 C20.6049683,54.9695513 20.9694438,54.8983564 21.391514,54.8167428 C22.0096296,54.6958107 22.8548895,54.530847 23.9098782,54.530847 C24.4947806,54.530847 25.1009544,54.5821966 25.7111088,54.6832834 C26.8872577,54.8785112 27.9011963,55.5926925 29.0743597,56.4197438 C30.7914997,57.6300568 32.7351619,59 35.704829,59 C35.7858097,59 35.8670392,58.9973953 35.9472736,58.9918138 C36.0454208,58.996403 36.1670785,59 36.2954535,59 C39.2659913,59 41.2091559,57.6295606 42.92443,56.42024 L42.9271667,56.4177593 C44.1005789,55.5917003 45.1133979,54.8785112 46.2891736,54.6832834 C46.8990792,54.5823206 47.5051287,54.530847 48.0902798,54.530847 C49.0981231,54.530847 49.8961131,54.658973 50.6086441,54.7975177 C51.0736303,54.8888059 51.4349959,54.9327135 51.712271,54.9327135 L51.739389,54.9332097 L51.7675021,54.9332097 C52.3791493,54.9332097 52.8285862,54.5984449 53.000126,54.0126376 C53.1140713,53.6270193 53.1954252,53.2648433 53.2756596,52.898078 C53.3455692,52.5800577 53.4572754,52.0702825 53.5612691,51.8709617 C55.6209912,51.5484762 57.1996803,51.1379273 58.2557886,50.6489897 C59.1179661,50.2502239 59.6488813,49.7965116 59.8795084,49.2640385 C59.9486717,49.1044081 59.9890999,48.9389483 59.9981807,48.7705116 C60.0306476,48.1990921 59.6251219,47.6944023 59.0577592,47.6016257 C52.6408751,46.547098 49.7500741,39.9728588 49.6305311,39.6935368 C49.6228186,39.6751799 49.614111,39.6569471 49.6050302,39.6392104 C49.2770022,38.9751383 49.201246,38.4265408 49.37913,38.008426 C49.7291758,37.1859639 51.0735059,36.760407 51.9629257,36.4788524 C52.2204221,36.3979829 52.4631155,36.3210826 52.6652564,36.2414534 C53.5408684,35.896642 54.1666965,35.5225588 54.5795615,35.0977462 C55.0726608,34.5913199 55.1686933,34.1061032 55.1627223,33.7885791 C55.1476706,33.0203193 54.5586632,32.3376423 53.6217247,32.0033737 C53.3052654,31.8728911 52.9443973,31.8040528 52.5769363,31.8040528 C52.3267792,31.8040528 51.9563328,31.8382859 51.605665,32.0015132 C50.8549449,32.3517821 50.1824689,32.5432889 49.6051546,32.5705761 C49.2981493,32.555072 49.0828226,32.4887144 48.9433765,32.4253336 C48.9609161,32.1256701 48.9803216,31.8178205 49.0003491,31.4968234 L49.0086835,31.3593949 C49.2143075,28.1109736 49.4698135,24.0682457 48.3966632,21.6682093 C47.6611192,20.0244014 46.6734278,18.6106745 45.4604582,17.4644866 C44.443161,16.5039759 43.2614144,15.7254215 41.9473121,15.1499089 C39.6604459,14.1494596 37.528575,14 36.46152,14" fill="#FFFFFF"></path>
                            </g>
                        </g>
                    </g>
                </svg>
        </a>
        <a href="https://chat.whatsapp.com/KfspL8lpPLcACmy4Cz0ibD" aria-label="انضم لمزاد المتكن للأرقام المميزة">
          <i class="fas fa-gavel gavel" aria-hidden="true"></i>
        </a>
    </div>

    <main>
    <div class="container text-center pb-0" id="hero-page">
        <header>
            <img src="images/icon.png" alt="شعار المتكن للأرقام المميزة - متجر متخصص في بيع أرقام الجوالات المميزة في السعودية" class="logo" width="120" height="120" loading="eager">
            <h1>وجهتك الصحيحة لشراء رقمك المميز</h1>
            <p class="subtitle">نخدمكم في جميع مناطق المملكة</p>
            <img src="images/hero.png" alt="صورة توضيحية - أفضل أرقام الجوالات المميزة في السعودية - أرقام VIP واقتصادية ونخبة" class="avatar" width="300" height="300" loading="eager">
         </header>
    </div>
    
    <section class="premium-block container">
        <h2 class="block-title sec_title">تصفح قائمة الأرقام المتوفرة</h2>
        
        <nav class="nav-grid" aria-label="أقسام الأرقام">
            <a href="economic.php" class="nav-item economic" title="أرقام اقتصادية بأسعار مناسبة من 0 إلى 499 ريال">
                <div class="icon-box economic"><i class="fas fa-coins" aria-hidden="true"></i></div>
                <div class="content">
                    <span class="label">الأرقام الاقتصادية</span>
                    <span class="range">من <span class="display-number">0</span> إلى <span class="display-number">499</span> ريال</span>
                </div>
                <div class="arrow"><i class="fas fa-chevron-left" aria-hidden="true"></i></div>
            </a>
            <a href="special.php" class="nav-item special" title="أرقام مميزة للبيع من 500 إلى 1499 ريال">
                <div class="icon-box special"><i class="fas fa-star" aria-hidden="true"></i></div>
                <div class="content">
                    <span class="label">الأرقام المميزة</span>
                    <span class="range">من <span class="display-number">500</span> إلى <span class="display-number">1499</span> ريال</span>
                </div>
                <div class="arrow"><i class="fas fa-chevron-left" aria-hidden="true"></i></div>
            </a>

            <a href="elite.php" class="nav-item elite" title="أرقام نخبة راقية من 1500 إلى 4999 ريال">
                <div class="icon-box elite"><i class="fa-regular fa-gem" aria-hidden="true"></i></div>
                <div class="content">
                    <span class="label">أرقام النخبة</span>
                    <span class="range">من <span class="display-number">1500</span> إلى <span class="display-number">4999</span> ريال</span>
                </div>
                <div class="arrow"><i class="fas fa-chevron-left" aria-hidden="true"></i></div>
            </a>

            <a href="vip.php" class="nav-item vip" title="أرقام VIP فاخرة من 5000 ريال فما فوق">
                <div class="icon-box vip"><i class="fas fa-crown" aria-hidden="true"></i></div>
                <div class="content">
                    <span class="label">أرقام VIP</span>
                    <span class="range">من <span class="display-number">5000</span> ريال فما فوق</span>
                </div>
                <div class="arrow"><i class="fas fa-chevron-left" aria-hidden="true"></i></div>
            </a>

            <a href="bundle.php" class="nav-item bundle" title="أرقام طقم مزدوجة متكاملة">
                <div class="icon-box bundle"><i class="fas fa-clone" aria-hidden="true"></i></div>
                <div class="content">
                    <span class="label">أرقام الطقم</span>
                </div>
                <div class="arrow"><i class="fas fa-chevron-left" aria-hidden="true"></i></div>
            </a>
        </nav>
    </section>

        <section class="avatar-sec py-4">
            <h2 class="sec_title">صدقني راح تعجبك</h2>
            <p class="fs-4 fw-700">أرقامنا المميزة، خدماتنا، أسعارنا</p>
            <img src="images/about.png" alt="صورة توضيحية للمتجر - نعرض مجموعة من أفضل أرقام الجوالات المميزة في السعودية - اتصل بنا الآن" class="avatar" width="300" height="300" loading="lazy">
        </section>
    
    <div class="container text-center">
        <section class="white-section">
            <h2 class="sec_title">ليه تختار المتمكن؟</h2>
            <ul class="feature-list" itemscope itemtype="https://schema.org/ItemList">
                <li class="fw-bold" itemprop="itemListElement"><i class="fas fa-check" aria-hidden="true"></i> نحن مؤسسة تجارية رسمية بسجل تجاري معتمد</li>
                <li class="fw-bold" itemprop="itemListElement"><i class="fas fa-check" aria-hidden="true"></i>  تقييمات عملائنا تتجاوز 500 تقييم في حراج</li>
                <li class="fw-bold" itemprop="itemListElement"><i class="fas fa-check" aria-hidden="true"></i> عبر تطبيق My STC أو الفروع مباشرة</li>
                <li class="fw-bold" itemprop="itemListElement"><i class="fas fa-check" aria-hidden="true"></i> تحويل بنكي على حساب المؤسسة الرسمي</li>
                <li class="fw-bold" itemprop="itemListElement"><i class="fas fa-check" aria-hidden="true"></i> متواجدون على واتساب وسناب شات</li>
                <li class="fw-bold" itemprop="itemListElement"><i class="fas fa-check" aria-hidden="true"></i> نخدم جميع مناطق المملكة العربية السعودية</li>
            </ul>
        
        </section>

        <section class="buy-number">
            <h2 class="sec_title">طريقة شراء الأرقام المميزة</h2>
            <p class="fw-bold fs-6">يتم <strong>نقل الملكية</strong> بسهولة عبر:</p>
            <ul class="text-right mx-auto p-0" style="max-width: 600px;">
                <li class="mb-2"><strong>الخطوة 1:</strong> اختر الرقم المناسب من أقسامنا (<a href="economic.php">اقتصادية</a>، <a href="special.php">مميزة</a>، <a href="elite.php">نخبة</a>، <a href="vip.php">VIP</a>)</li>
                <li class="mb-2"><strong>الخطوة 2:</strong> تواصل معنا عبر <a href="https://wa.link/jm23mv" target="_blank" rel="noopener">واتساب</a></li>
                <li class="mb-2"><strong>الخطوة 3:</strong> أتمم الدفع عبر تحويل بنكي</li>
                <li class="mb-2"><strong>الخطوة 4:</strong> نقوم بنقل الملكية فوراً عبر تطبيق My STC</li>
            </ul>
        </section>

        <section class="contact-us white-section">
            <h2 class="sec_title">وش تنتظر؟</h2>
            <p>تواصل معنا وشوف أرقامنا المميزة</p>
            <div class="button-grid">
                <a href="https://wa.link/jm23mv" class="btn fw-bold fs-6" title="تواصل معنا عبر واتساب"><i class="fab fa-whatsapp whatsapp" aria-hidden="true"></i> اطلب قائمة الأرقام واتساب</a>
                <a href="https://www.snapchat.com/add/almotamkin" class="btn fw-bold fs-6" title="تابعنا على سناب شات">
                <svg viewBox="0 0 72 72" width="30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-label="أيقونة سناب شات">
                    <title>Snapchat</title>
                    <desc>رابط صفحتنا على سناب شات</desc>
                    <defs></defs>
                    <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <g id="Social-Icons---Circle" transform="translate(-40.000000, -155.000000)">
                            <g id="Snapchat" transform="translate(40.000000, 155.000000)">
                                <path d="M36,72 L36,72 C55.882251,72 72,55.882251 72,36 L72,36 C72,16.117749 55.882251,-3.65231026e-15 36,0 L36,0 C16.117749,3.65231026e-15 -2.4348735e-15,16.117749 0,36 L0,36 C2.4348735e-15,55.882251 16.117749,72 36,72 Z" id="Oval" fill="#FFE400"></path>
                                <path d="M36.46152,14 L36.4594053,14 C36.4179819,14 36.3790465,14 36.341977,14.0004961 C36.0464159,14.0034729 35.5605315,14.0081862 35.516869,14.0086823 C34.4513068,14.0086823 32.3193115,14.1587621 30.029211,15.1666533 C28.7198357,15.742538 27.5420697,16.5212165 26.5287531,17.481107 C25.3206349,18.6248143 24.3364265,20.0349442 23.6039924,21.6729225 C22.5313397,24.0712224 22.785975,28.1108496 22.9904793,31.3571623 L22.9912257,31.3622477 C23.0131191,31.7099119 23.0361321,32.0729561 23.0571547,32.4266979 C22.8997958,32.498761 22.644663,32.5747932 22.2686187,32.5747932 C21.6635645,32.5747932 20.9440674,32.3819221 20.1306525,32.0018853 C19.8913177,31.8907518 19.6181477,31.8345649 19.3167401,31.8345649 C18.8324728,31.8345649 18.3219582,31.9767066 17.8791142,32.2363075 C17.3219518,32.562514 16.9619545,33.0235442 16.8641805,33.5346837 C16.7997442,33.8727974 16.8028541,34.5410866 17.5473544,35.2188023 C17.9568607,35.5918932 18.558432,35.9359604 19.3349017,36.2419496 C19.5386597,36.3219508 19.7804824,36.398355 20.0366104,36.4793485 C20.9254082,36.7610272 22.2706091,37.1865841 22.6214012,38.0097903 C22.7991608,38.427161 22.7226582,38.9763786 22.3946303,39.6402026 C22.386047,39.6583114 22.3774638,39.6760481 22.369627,39.6946531 C22.2876511,39.8855397 21.5228744,41.6128217 19.9541369,43.4344927 C19.0627268,44.4704154 18.0808819,45.336165 17.0374619,46.0084232 C15.7639122,46.8291488 14.3858713,47.3657151 12.9420257,47.602866 C12.3750361,47.6956426 11.9701324,48.1993401 12.0017286,48.7717519 C12.0114313,48.9367157 12.0502424,49.1011833 12.1175397,49.2603175 C12.1180373,49.2613097 12.1186593,49.262302 12.1191569,49.2631702 C12.3484157,49.797876 12.8799529,50.2520844 13.7441206,50.6527107 C14.8001045,51.1417723 16.3794156,51.5531894 18.4377694,51.8750548 C18.5417631,52.0722671 18.6497374,52.5679025 18.7244985,52.9072565 C18.8027425,53.2679441 18.8843452,53.6388024 19.000654,54.0327309 C19.1261679,54.4595281 19.451708,54.9695513 20.2880114,54.9695513 C20.6049683,54.9695513 20.9694438,54.8983564 21.391514,54.8167428 C22.0096296,54.6958107 22.8548895,54.530847 23.9098782,54.530847 C24.4947806,54.530847 25.1009544,54.5821966 25.7111088,54.6832834 C26.8872577,54.8785112 27.9011963,55.5926925 29.0743597,56.4197438 C30.7914997,57.6300568 32.7351619,59 35.704829,59 C35.7858097,59 35.8670392,58.9973953 35.9472736,58.9918138 C36.0454208,58.996403 36.1670785,59 36.2954535,59 C39.2659913,59 41.2091559,57.6295606 42.92443,56.42024 L42.9271667,56.4177593 C44.1005789,55.5917003 45.1133979,54.8785112 46.2891736,54.6832834 C46.8990792,54.5823206 47.5051287,54.530847 48.0902798,54.530847 C49.0981231,54.530847 49.8961131,54.658973 50.6086441,54.7975177 C51.0736303,54.8888059 51.4349959,54.9327135 51.712271,54.9327135 L51.739389,54.9332097 L51.7675021,54.9332097 C52.3791493,54.9332097 52.8285862,54.5984449 53.000126,54.0126376 C53.1140713,53.6270193 53.1954252,53.2648433 53.2756596,52.898078 C53.3455692,52.5800577 53.4572754,52.0702825 53.5612691,51.8709617 C55.6209912,51.5484762 57.1996803,51.1379273 58.2557886,50.6489897 C59.1179661,50.2502239 59.6488813,49.7965116 59.8795084,49.2640385 C59.9486717,49.1044081 59.9890999,48.9389483 59.9981807,48.7705116 C60.0306476,48.1990921 59.6251219,47.6944023 59.0577592,47.6016257 C52.6408751,46.547098 49.7500741,39.9728588 49.6305311,39.6935368 C49.6228186,39.6751799 49.614111,39.6569471 49.6050302,39.6392104 C49.2770022,38.9751383 49.201246,38.4265408 49.37913,38.008426 C49.7291758,37.1859639 51.0735059,36.760407 51.9629257,36.4788524 C52.2204221,36.3979829 52.4631155,36.3210826 52.6652564,36.2414534 C53.5408684,35.896642 54.1666965,35.5225588 54.5795615,35.0977462 C55.0726608,34.5913199 55.1686933,34.1061032 55.1627223,33.7885791 C55.1476706,33.0203193 54.5586632,32.3376423 53.6217247,32.0033737 C53.3052654,31.8728911 52.9443973,31.8040528 52.5769363,31.8040528 C52.3267792,31.8040528 51.9563328,31.8382859 51.605665,32.0015132 C50.8549449,32.3517821 50.1824689,32.5432889 49.6051546,32.5705761 C49.2981493,32.555072 49.0828226,32.4887144 48.9433765,32.4253336 C48.9609161,32.1256701 48.9803216,31.8178205 49.0003491,31.4968234 L49.0086835,31.3593949 C49.2143075,28.1109736 49.4698135,24.0682457 48.3966632,21.6682093 C47.6611192,20.0244014 46.6734278,18.6106745 45.4604582,17.4644866 C44.443161,16.5039759 43.2614144,15.7254215 41.9473121,15.1499089 C39.6604459,14.1494596 37.528575,14 36.46152,14" fill="#FFFFFF"></path>
                            </g>
                        </g>
                    </g>
                </svg>
                    لمتابعتنا عبر سناب شات</a>
                <a href="https://chat.whatsapp.com/KfspL8lpPLcACmy4Cz0ibD" class="btn fw-bold fs-6" title="انضم لمزاد المتكن"><i class="fas fa-gavel" aria-hidden="true"></i> مزاد المتكن للأرقام المميزة</a>
        </div>
        </section>
    </div>
    </main>

    <?php include 'footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

    <script>
        // Responsive tape container
        const container = document.querySelector('.container-tape');
        const allOriginalItems = Array.from(container.children);

        function updateElements() {
            const screenWidth = window.innerWidth;

            if (screenWidth <= 677) {
                const filteredItems = allOriginalItems.filter(item => item.classList.contains('left'));
                container.innerHTML = ''; 
                filteredItems.forEach(item => container.appendChild(item));
            } else {
                container.innerHTML = '';
                allOriginalItems.forEach(item => container.appendChild(item));
            }
        }

        updateElements();
        window.addEventListener('resize', updateElements);
    </script>
</body>
</html>
