<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $this->renderSection('title') ?></title>
  <link rel="shortcut icon" href="<?= base_url('assets/images/logo-sm.png') ?>" type="image/png">
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.bootstrap5.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.2/css/buttons.dataTables.css">
  <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/css/util.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/css/multi.css') ?>">

  <script src="https://cdn.datatables.net/2.0.7/js/dataTables.min.js"></script>
  <script src="sidebars.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>



  <style>
    .form-step {
      display: none;
    }

    .form-step.active {
      display: block;
    }

    .step-indicator {
      margin-bottom: 30px;
    }

    .step-indicator .step {
      width: 30px;
      height: 30px;
      border-radius: 50%;
      background-color: #ccc;
      display: flex;
      justify-content: center;
      align-items: center;
      color: white;
      font-weight: bold;
      margin: 0 auto;
    }

    .step-indicator .step.active {
      background-color: #0d6efd;
    }

    .step-indicator .step.completed {
      background-color: #198754;
    }

    .step-label {
      font-size: 0.8rem;
      text-align: center;
      margin-top: 5px;
    }

    .exported {

      background-color: #e0f7fa !important;
      /* Light blue background */
      color: #004d40 !important;
      /* Darker text color for contrast */

      cursor: not-allowed;
      /* pointer-events: none !important;Disable pointer events (e.g., clicking) */
    }

    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      user-select: none;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }

    .b-example-divider {
      width: 100%;
      height: 3rem;
      background-color: rgba(0, 0, 0, .1);
      border: solid rgba(0, 0, 0, .15);
      border-width: 1px 0;
      box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
    }

    .b-example-vr {
      flex-shrink: 0;
      width: 1.5rem;
      height: 100vh;
    }

    .bi {
      vertical-align: -.125em;
      fill: currentColor;
    }

    .nav-scroller {
      position: relative;
      z-index: 2;
      height: 2.75rem;
      overflow-y: hidden;
    }

    .nav-scroller .nav {
      display: flex;
      flex-wrap: nowrap;
      padding-bottom: 1rem;
      margin-top: -1px;
      overflow-x: auto;
      text-align: center;
      white-space: nowrap;
      -webkit-overflow-scrolling: touch;
    }

    .btn-bd-primary {
      --bd-violet-bg: #712cf9;
      --bd-violet-rgb: 112.520718, 44.062154, 249.437846;

      --bs-btn-font-weight: 600;
      --bs-btn-color: var(--bs-white);
      --bs-btn-bg: var(--bd-violet-bg);
      --bs-btn-border-color: var(--bd-violet-bg);
      --bs-btn-hover-color: var(--bs-white);
      --bs-btn-hover-bg: #6528e0;
      --bs-btn-hover-border-color: #6528e0;
      --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
      --bs-btn-active-color: var(--bs-btn-hover-color);
      --bs-btn-active-bg: #5a23c8;
      --bs-btn-active-border-color: #5a23c8;
    }

    .bd-mode-toggle {
      z-index: 1500;
    }

    .bd-mode-toggle .dropdown-menu .active .bi {
      display: block !important;
    }

    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      user-select: none;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }

    .b-example-divider {
      width: 100%;
      height: 3rem;
      background-color: rgba(0, 0, 0, .1);
      border: solid rgba(0, 0, 0, .15);
      border-width: 1px 0;
      box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
    }

    .b-example-vr {
      flex-shrink: 0;
      width: 1.5rem;
      height: 100vh;
    }

    .bi {
      vertical-align: -.125em;
      fill: currentColor;
    }

    .nav-scroller {
      position: relative;
      z-index: 2;
      height: 2.75rem;
      overflow-y: hidden;
    }

    .nav-scroller .nav {
      display: flex;
      flex-wrap: nowrap;
      padding-bottom: 1rem;
      margin-top: -1px;
      overflow-x: auto;
      text-align: center;
      white-space: nowrap;
      -webkit-overflow-scrolling: touch;
    }

    .btn-bd-primary {
      --bd-violet-bg: #712cf9;
      --bd-violet-rgb: 112.520718, 44.062154, 249.437846;

      --bs-btn-font-weight: 600;
      --bs-btn-color: var(--bs-white);
      --bs-btn-bg: var(--bd-violet-bg);
      --bs-btn-border-color: var(--bd-violet-bg);
      --bs-btn-hover-color: var(--bs-white);
      --bs-btn-hover-bg: #6528e0;
      --bs-btn-hover-border-color: #6528e0;
      --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
      --bs-btn-active-color: var(--bs-btn-hover-color);
      --bs-btn-active-bg: #5a23c8;
      --bs-btn-active-border-color: #5a23c8;
    }

    .bd-mode-toggle {
      z-index: 1500;
    }

    .bd-mode-toggle .dropdown-menu .active .bi {
      display: block !important;
    }

    .success-icon {
      width: 80px;
      height: 80px;
      margin: 0 auto;
      border-radius: 50%;
      border: 4px solid #4CAF50;
      padding: 0;
      position: relative;
      box-sizing: content-box;
    }

    .succ {
      color: #4CAF50;
    }

    .err {
      color: #F44336;
    }


    .error-icon {
      width: 80px;
      height: 80px;
      margin: 0 auto;
      border-radius: 50%;
      border: 4px solid #F44336;
      padding: 0;
      position: relative;
      box-sizing: content-box;
    }



    .spinner-icon {
      width: 80px;
      height: 80px;
      margin: 0 auto;
      border-radius: 50%;
      border: 4px solid #f3f3f3;
      border-top: 4px solid #3498db;
      animation: spin 1s linear infinite;
    }

    @keyframes spin {
      0% {
        transform: rotate(0deg);
      }

      100% {
        transform: rotate(360deg);
      }
    }

    #loadingOverlay {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      z-index: 9999;
      justify-content: center;
      align-items: center;
    }
  </style>
</head>

<body>
  <div class="spinner-wrapper">
    <div class="spinner-border text-info" role="status">
      <span class="visually-hidden">Loading...</span>
    </div>
  </div>
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="<?= site_url('dashboard') ?>" class="logo d-flex align-items-center">
        <img src="<?= base_url('assets/images/logo-sm.png') ?>" alt="logo">
        <span class="d-none d-lg-block" style="color:#000000;">Sacco</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <div class="search-bar">
      <form class="search-form d-flex align-items-center" method="POST" action="#">
        <input type="text" name="query" placeholder="Search" title="Enter search keyword">
        <button type="submit" title="Search"><i class="bi bi-search"></i></button>
      </form>
    </div><!-- End Search Bar -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
            <i class="bi bi-search"></i>
          </a>
        </li><!-- End Search Icon-->


        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <i class="bi-person-circle" style="font-size:2rem;"></i>
            <span class="d-none d-md-block dropdown-toggle ps-2"><?= $userInfo['name'] ?></span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6><?= $userInfo['name'] ?></h6>
              <span><?= $userInfo['role'] ?></span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="<?= site_url('/profile')?>">
                <i class="bi bi-person"></i>
                <span>My Profile</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="#">
                <i class="bi bi-question-circle"></i>
                <span>Need Help?</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="<?= site_url('/logout')?>">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header>
  <main id="main" class="main">
    <div class="pagetitle">
      <h1><?= $title ?></h1>

    </div>
    <section class="section">
      <?= $this->renderSection('content') ?>
    </section>

  </main>

<!-- Feedback Modal -->
<div id="feedbackModal" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="feedbackModalTitle">Notification</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <div class="feedback-icon mb-4">
                    <!-- Icon will be inserted here -->
                </div>
                <div id="feedbackMessage"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

<!-- Loading Overlay -->
<div id="loadingOverlay">
    <div class="spinner-icon"></div>
</div>



  <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span><a href="https://macrologicsys.com">McLogic</a></span><span class="d-none">NiceAdmin</span></strong>. All Rights Reserved
    </div>
    <div class="credits d-none">
      <!-- All the links in the footer should remain intact. -->
      <!-- You can delete the links only if you purchased the pro version. -->
      <!-- Licensing information: https://bootstrapmade.com/license/ -->
      <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
      Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"> </script>
  <script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
  <script src="https://cdn.datatables.net/2.0.7/js/dataTables.bootstrap5.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.0.2/js/dataTables.buttons.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.dataTables.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.print.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.colVis.min.js"></script>
 
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const navLinks = document.querySelectorAll('.nav-link');


      navLinks.forEach(function(link) {
        link.addEventListener('click', function(event) {
          // Remove active class from all links
          navLinks.forEach(function(navLink) {
            navLink.classList.remove('active');
          });
          // Add active class to the clicked link
          link.classList.add('active');
          // Store the clicked link's text content in localStorage
          localStorage.setItem('activeNavLink', link.textContent);
        });
      });

      // Check if there's a stored active link and apply the active class
      const storedActiveLink = localStorage.getItem('activeNavLink');
      if (storedActiveLink) {
        navLinks.forEach(function(navLink) {
          if (navLink.textContent === storedActiveLink) {
            navLink.classList.add('active');
          }
        });
      }
    });
  </script>
  <script>
    new DataTable('#viewsTable', {
      layout: {
        topStart: {
          buttons: ['excelHtml5', 'pdfHtml5', 'print', 'colvis']
        }
      },
      pagingType: 'simple',
      pageLength: 60
    });

    new DataTable('#paymentsTable', {
      layout: {
        topStart: {
          buttons: ['excelHtml5', 'pdfHtml5', 'print', 'colvis']
        }
      },
      order: [
        [1, 'desc']
      ],
      pagingType: 'simple',
      pageLength: 60
    });
    new DataTable('#loansTable', {
      layout: {
        topStart: {
          buttons: ['excelHtml5', 'pdfHtml5', 'print', 'colvis']
        }
      },
      order: [
        [0, 'desc']
      ],
      pagingType: 'simple',
      pageLength: 60
    });

    new DataTable('#journalsTable', {
      layout: {
        topStart: {
          buttons: ['colvis']
        }
      },
      order: [
        [0, 'desc']
      ],
      pagingType: 'simple',
      pageLength: 40
    });
  </script>

  <script src="<?= base_url('assets/js/main.js') ?>"></script>
  <script src="<?= base_url('assets/js/dashboard.js') ?>"></script>
  <script src="<?= base_url('assets/js/util.js') ?>"></script>
  <script src="<?= base_url('assets/js/script.js') ?>"></script>


</body>

</html>