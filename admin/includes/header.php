<?php 
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if(!isset($_SESSION['username'])) {
        header("location: ../admin/login.php");
        exit;
    }

    include_once '../config/helpers.php';
    
?>

<!doctype html>
<html lang="ar" dir="rtl">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="" />
    <meta name="generator" content="Astro v5.13.2" />
    <title>Motamkin</title>
</head>
    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/dashboard-rtl/"/>
    <link href="../admin/assets/dist/css/bootstrap.rtl.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800&family=Tajawal:wght@400;500;700;800&display=swap">
    <link rel="stylesheet" href="../admin/css/admin-minimal.css?time=<?php echo filemtime('css/admin-minimal.css') ?>">
    <link rel="stylesheet" href="../css/all.min.css">
<body>