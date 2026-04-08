<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <?php 
    // Include SEO helpers
    include_once "config/seo-helpers.php";
    
    // Determine current page
    $currentPage = basename($_SERVER['PHP_SELF'], '.php');
    if ($currentPage === 'index') $currentPage = 'index';
    
    // Set page-specific SEO data
    $pageSeoData = get_seo_data($currentPage);
    
    // Generate dynamic meta tags (only if not already set by page)
    if (!defined('SEO_META_INJECTED')) {
        echo generate_seo_meta($currentPage);
        // Add hreflang tags
        echo generate_hreflang_tags(SITE_URL . '/' . ($currentPage === 'index' ? '' : $currentPage . '.php'));
    }
    ?>
    <link rel="icon" type="image/png" href="images/icon.png">
    <?php include_once "config/links.php"?>
    <?php include_once "config/helpers.php"?>
    
    <!-- Preconnect to external resources -->
    <link rel="preconnect" href="https://cdn.jsdelivr.net">
    <link rel="dns-prefetch" href="https://cdn.jsdelivr.net">
    
    <!-- Structured Data -->
    <?php echo generate_all_structured_data($currentPage); ?>
</head>
<body>

<nav class="navbar navbar-expand-md navbar-light fixed-top bg-light number-page-header">
      <div class="container-fluid">
        <a class="navbar-brand d-none"  href="/">
            <img src="images/icon.png" alt="شعار المتكن للأرقام المميزة - متجر أرقام جوالات مميزة في السعودية" width="40" height="40">
        </a>
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarCollapse"
          aria-controls="navbarCollapse"
          aria-expanded="false"
          aria-label="القائمة الرئيسية"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
          <ul class="navbar-nav me-auto mb-2 mb-md-0 w-100 justify-content-center">
            <li class="nav-item">
              <a class="nav-link <?php echo isCurrentUrl('/')?>" aria-current="page" href="/">الرئيسية</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php echo isCurrentUrl('economic.php')?>" href="economic.php">الأرقام الاقتصادية</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php echo isCurrentUrl('special.php')?>" href="special.php">الأرقام المميزة</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php echo isCurrentUrl('elite.php')?>" href="elite.php">أرقام النخبة</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php echo isCurrentUrl('vip.php')?>" href="vip.php">أرقام VIP</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php echo isCurrentUrl('bundle.php')?>" href="bundle.php">أرقام الطقم</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
