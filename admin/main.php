<?php

  include_once "includes/header.php";
  include_once "../config/helpers.php";

?> 
    
    <!-- Premium Sticky Navbar with Glass Effect -->
    <header class="navbar">
      <a class="navbar-brand" href="/admin">
        <i class="fa-solid fa-crown"></i>
        <span>المتمكن للأرقام المميزة</span>
      </a>
      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="offcanvas"
        data-bs-target="#sidebarMenu"
        aria-controls="sidebarMenu"
        aria-expanded="false"
        aria-label="تبديل التنقل"
      >
        <i class="fa-solid fa-bars"></i>
      </button>
    </header>

    <div class="wrapper">
      <!-- Premium Floating Sidebar (Right for RTL) -->
      <aside class="sidebar" id="sidebarMenu">
        
        <div class="sidebar-body">
          <!-- Main Navigation -->
          <ul class="nav flex-column">
            <li class="nav-item">
              <a class="nav-link <?php echo isCurrentUrl('admin')?>" aria-current="page" href="/admin">
                <i class="fa-solid fa-house"></i>
                <span>الرئيسية</span>
              </a>
            </li>
            
            <!-- Numbers Section -->
            <li class="nav-group">
              <button class="nav-group-toggle" data-bs-toggle="collapse" data-bs-target="#number-collapse" aria-expanded="false">
                <div class="nav-group-content">
                  <i class="fa-solid fa-mobile-screen-button"></i>
                  <span>الأرقام</span>
                </div>
                <i class="fa-solid fa-chevron-down arrow-icon"></i>
              </button> 
              
              <div class="collapse" id="number-collapse"> 
                <ul class="nav-group-items"> 
                  <li>
                    <a class="nav-link <?php echo isCurrentUrl('numbers.php')?>" href="../admin/numbers.php">
                      <i class="fa-solid fa-list-check"></i>
                      <span>قائمة الأرقام</span>
                    </a>
                  </li> 
                  <li>
                    <a class="nav-link <?php echo isCurrentUrl('add-number.php')?>" href="../admin/add-number.php">
                      <i class="fa-solid fa-circle-plus"></i>
                      <span>إضافة رقم جديد</span>
                    </a>
                  </li> 
                </ul> 
              </div> 
            </li>

            <?php if($_SESSION['role'] == 0): ?>
              <!-- Users Section (Admin Only) -->
              <li class="nav-group">
                <button class="nav-group-toggle" data-bs-toggle="collapse" data-bs-target="#users-collapse" aria-expanded="false">
                  <div class="nav-group-content">
                    <i class="fa-solid fa-users-rays"></i>
                    <span>المستخدمين</span>
                  </div>
                  <i class="fa-solid fa-chevron-down arrow-icon"></i>
                </button> 
                
                <div class="collapse" id="users-collapse"> 
                  <ul class="nav-group-items"> 
                    <li>
                      <a href="../admin/users.php" class="nav-link <?php echo isCurrentUrl('users.php')?>">
                        <i class="fa-solid fa-list-check"></i>
                        <span>قائمة المستخدمين</span>
                      </a>
                    </li>
                    <li>
                      <a href="../admin/add-user.php" class="nav-link <?php echo isCurrentUrl('add-user.php')?>">
                        <i class="fa-solid fa-user-plus"></i>
                        <span>إضافة مستخدم جديد</span>
                      </a>
                    </li>
                  </ul> 
                </div> 
              </li>
            <?php endif ?>
          </ul>

          <!-- Footer Navigation -->
          <div class="sidebar-footer">
            <hr />
            <a class="nav-link logout-link" href="../admin/logout.php">
              <i class="fa-solid fa-right-from-bracket"></i>
              <span>تسجيل الخروج</span>
            </a>
          </div>
        </div>
      </aside>

      <!-- Main Content Area -->
      <main class="main-content">
        <!-- Page Header -->
        <div class="page-header">
          <h3 class="page-title"><?php echo $pageTitle ?? '' ?></h3>

        </div>

        <!-- Dynamic Page Content -->
        <?php echo $content ?>
        
      </main>
    </div>

<?php include_once "../admin/includes/footer.php"?>