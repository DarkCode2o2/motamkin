<?php

  include_once "../admin/includes/header.php";
  include_once "../config/helpers.php";

?> 
    
    <i class="fa-solid fa-bars-staggered d-none"></i>
    <header
      class="navbar sticky-top bg-dark flex-md-nowrap p-0 shadow"
    >
      <a
        class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6 text-white"
        href="../admin"
        >المتمكن للأرقام المميزة</a
      >
      <ul class="navbar-nav flex-row d-md-none">
        <li class="nav-item text-nowrap text-white">
          <button
            class="nav-link px-3 text-white"
            type="button"
            data-bs-toggle="offcanvas"
            data-bs-target="#sidebarMenu"
            aria-controls="sidebarMenu"
            aria-expanded="false"
            aria-label="تبديل التنقل"
          >
            <i class="fa-solid fa-bars-staggered fs-3"></i>
          </button>
        </li>
      </ul>
    </header>
    <div class="container-fluid">
      <div class="row">
        <div
          class="sidebar border border-right col-md-3 col-lg-2 p-0 bg-body-tertiary"
        >
          <div
            class="offcanvas-md offcanvas-end bg-body-tertiary"
            tabindex="-1"
            id="sidebarMenu"
            aria-labelledby="sidebarMenuLabel"
          >
            <div class="offcanvas-header">
              <h5 class="offcanvas-title" id="sidebarMenuLabel">
                المتمكن للأرقام المميزة
              </h5>
              <button
                type="button"
                class="btn-close"
                data-bs-dismiss="offcanvas"
                data-bs-target="#sidebarMenu"
                aria-label="يغلق"
              ></button>
            </div>
            <div
              class="offcanvas-body d-md-flex flex-column p-0 pt-lg-3 overflow-y-auto"
            >
              <ul class="nav flex-column">
                <li class="nav-item">
                  <a
                    class="nav-link d-flex align-items-center gap-2 <?php echo isCurrentUrl('admin')?>"
                    aria-current="page"
                    href="/admin"
                  >
                    <i class="fa-solid fa-house-chimney"></i>
                    الرئيسية
                  </a>
                </li>
                 <li class="users"> 
                    <button onclick="rotateArrow(this)" class="collapsed btn" data-bs-toggle="collapse" data-bs-target="#number-collapse" aria-expanded="false">
                      <div>
                        <i class="fa-solid fa-phone"></i>
                        <p>
                          الأرقام
                        </p>  
                      </div>  
                      <i class="fa-solid fa-angle-left users-arrow"></i>
                    </button> 
                      <div class="collapse" id="number-collapse"> 
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small"> 
                          <li>
                             <a
                              class="nav-link d-flex align-items-center gap-2 <?php echo isCurrentUrl('numbers.php')?>"
                              aria-current="page"
                              href="../admin/numbers.php"
                            >
                              <i class="fa-solid fa-list"></i>
                              قائمة الأرقام
                            </a>
                          </li> 
                          <li>
                             <a
                              class="nav-link d-flex align-items-center gap-2 <?php echo isCurrentUrl('add-number.php')?>"
                              aria-current="page"
                              href="../admin/add-number.php"
                            >
                              <i class="fa-solid fa-plus"></i>
                              اضافة رقم جديد
                            </a>
                          </li> 
                      </ul> 
                    </div> 
                  </li>

                <?php if($_SESSION['role'] == 0): ?>
                  <li class="users"> 
                    <button onclick="rotateArrow(this)" class="collapsed btn" data-bs-toggle="collapse" data-bs-target="#dashboard-collapse" aria-expanded="false">
                      <div>
                        <i class="fa-solid fa-users"></i>
                        <p>
                          المستخدمين
                        </p>  
                      </div>  
                      <i class="fa-solid fa-angle-left users-arrow"></i>
                    </button> 
                      <div class="collapse" id="dashboard-collapse"> 
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small"> 
                          <li>
                            <a href="../admin/users.php" 
                            class="nav-link d-flex align-items-center gap-2 <?php echo isCurrentUrl('users.php')?>">قائمة المستخدمين</a>
                          </li> 
                          <li>
                            <a href="../admin/add-user.php" 
                            class="nav-link d-flex align-items-center gap-2 <?php echo isCurrentUrl('add-user.php')?>">أضافة مستخدم جديد</a>
                          </li> 
                      </ul> 
                    </div> 
                  </li>
                <?php endif ?>
              </ul>

              <hr class="my-3" />
              <ul class="nav flex-column mb-auto">
                <li class="nav-item">
                  <a class="nav-link d-flex align-items-center gap-2" href="../admin/logout.php">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    خروج
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
              <h3><?php echo $pageTitle  ?? '' ?></h3>
            </div>

            <?php echo $content ?>
        </main>
      </div>
    </div>
<?php include_once "../admin/includes/footer.php"?>
