<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <title>المتمكن للأرقام المميزة</title>
    <link rel="icon" type="image/png" href="images/icon.png">
    <?php include_once "config/links.php"?>
    <?php include_once "config/helpers.php"?>

  <!-- Open Graph -->
  <meta property="og:title" content="المتمكن للأرقام المميزة" />
  <meta property="og:description" content="متجر متخصص في بيع الأرقام المميزة نضمن لك نقل ملكية سريع وآمن، وأرقام تليق بمقامك وتبيّض الوجه." />
  <meta property="og:image" content="https://motamkin.madebyomar.dev/images/icon.png" />
  <meta property="og:url" content="https://motamkin.madebyomar.dev/images/icon.jpg" />
  <meta property="og:type" content="website" />

  <!-- Twitter Card -->
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="المتمكن للأرقام المميزة">
  <meta name="twitter:description" content="متجر متخصص في بيع الأرقام المميزة نضمن لك نقل ملكية سريع وآمن، وأرقام تليق بمقامك وتبيّض الوجه.">
  <meta name="twitter:image" content="https://motamkin.madebyomar.dev/images/icon.png">
</head>
<body>

<nav class="navbar navbar-expand-md navbar-light fixed-top bg-light number-page-header">
      <div class="container-fluid">
        <a class="navbar-brand d-none"  href="/">
            <img src="images/icon.png" alt="">
        </a>
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarCollapse"
          aria-controls="navbarCollapse"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
          <ul class="navbar-nav me-auto mb-2 mb-md-0 w-100 justify-content-center">
            <li class="nav-item">
              <a class="nav-link <?php echo isCurrentUrl('/')?>" aria-current="page" href="/">الرئيسية</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php echo isCurrentUrl('economic.php')?>" aria-current="page" href="economic.php"> الإقتصادية</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php echo isCurrentUrl('special.php')?>" aria-current="page" href="special.php"> المميزة</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php echo isCurrentUrl('elite.php')?>" aria-current="page" href="elite.php"> النخبة</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php echo isCurrentUrl('vip.php')?>" aria-current="page" href="vip.php">VIP</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php echo isCurrentUrl('bundle.php')?>" aria-current="page" href="bundle.php">أرقام الطقم</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>