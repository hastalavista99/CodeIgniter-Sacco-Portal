<!doctype html>
<html lang="en" data-bs-theme="auto">

<head>
    </script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.122.0">
    <title><?= $title ?></title>

    <link rel="shortcut icon" href="<?= base_url('assets/images/logo-sm.png') ?>" type="image/png">
    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/sign-in/">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">

    <style>
        html,
        body {
            height: 100%;
        }

        .form-signin {
            max-width: 330px;
            padding: 1rem;
        }

        .form-signin .form-floating:focus-within {
            z-index: 2;
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
    </style>
</head>

<body class="">


    <main>
        <div class="container">
            <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                            <div class="d-flex justify-content-center py-4">
                                <a href="index.html" class="logo d-flex align-items-center w-auto">
                                    <img src="<?= base_url('assets/images/logo-sm.png')?>" alt="logo">
                                    <span class="d-none d-lg-block">Imaniline Sacco</span>
                                </a>
                            </div><!-- End Logo -->

                            <div class="card mb-3">

                                <div class="card-body">

                                    <div class="pt-4 pb-2">
                                        <h5 class="card-title text-center pb-0 fs-4">Account Setup</h5>
                                        <p class="text-center small">Enter your personal details to create account</p>
                                    </div>

                                    <form action="<?= site_url('set/user/save?user='.$user) ?>" class="row g-3 needs-validation" method="post" novalidate>
                                        <?= csrf_field() ?>

                                        <?php if (session()->getFlashdata('fail')) : ?>
                                            <div class="alert alert-danger">
                                                <i class="bi-exclamation-triangle-fill me-2"></i>
                                                <?= session()->getFlashdata('fail') ?>
                                            </div>
                                        <?php endif; ?>
                                        <?php if (session()->getFlashdata('errors')) : ?>
                                            <div class="text-danger">
                                                <?= validation_list_errors() ?>
                                            </div>
                                        <?php endif; ?>

                                        <div class="form-floating mb-2 col-12">
                                            <input type="text" name="name" id="floatingInput" class="form-control" value="<?= set_value('name') ?>" placeholder="Name Here" required>
                                            <label for="floatingInput">Your Name</label>
                                            <div class="invalid-feedback">
                                                Please provide your name.
                                            </div>
                                        </div>

                                        <div class="form-floating mb-2 col-12">
                                            <input type="text" name="username" id="userName" class="form-control" value="<?= set_value('username') ?>" placeholder="Username Here" required minlength="4">
                                            <label for="userName">Create Username</label>
                                            <div class="invalid-feedback">
                                                Please provide a username. (at least 4 characters long)
                                            </div>
                                        </div>

                                        <div class="form-floating mb-2 col-12">
                                            <input type="text" name="membership" id="membership" class="form-control" value="<?= set_value('membership') ?>" placeholder="membership Here" required minlength="4">
                                            <label for="membership">Membership No.</label>
                                            <div class="invalid-feedback">
                                                Please provide a membership number. (at least 4 characters long)
                                            </div>
                                        </div>
                                        <div class="form-floating mb-2">
                                            <input type="password" name="password" id="newPassword" class="form-control" placeholder="Password" required minlength="5">
                                            <label for="newPassword">Password (at least 5 characters)</label>
                                            <div class="invalid-feedback">
                                                Your password must be at least 5 characters long.
                                            </div>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input type="password" name="passwordConf" id="renewPassword" class="form-control" placeholder="Confirm-Password" required>
                                            <label for="renewPassword">Confirm Password</label>
                                            <div class="invalid-feedback">
                                                Please confirm your password.
                                            </div>
                                        </div>

                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="checkbox" value="" id="checkPassword">
                                            <label class="form-check-label" for="checkPassword">
                                                Show Password
                                            </label>
                                        </div>

                                        <div class="col-12">
                                            <button class="btn btn-primary w-100" type="submit">Create Account</button>
                                        </div>
                                        <div class="col-12">
                                            <p class="small mb-0">Already have an account? <a href="<?= site_url('auth/login') ?>">Log in</a></p>
                                        </div>

                                    </form>

                                </div>
                            </div>

                            <div class="credits">
                                <!-- All the links in the footer should remain intact. -->
                                <!-- You can delete the links only if you purchased the pro version. -->
                                <!-- Licensing information: https://bootstrapmade.com/license/ -->
                                <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
                                <!-- Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a> -->
                                &copy;<?= date('Y') ?>, <a href="https://macrologicsys.com">McLogic</a>
                            </div>

                        </div>
                    </div>
                </div>

            </section>
        </div>


    </main>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="<?= base_url('assets/js/main.js')?>"></script>


</body>

</html>