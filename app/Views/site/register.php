<!doctype html>
<html lang="en" data-bs-theme="auto">

<head>
    </script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.122.0">
    <title><?= esc($title) ?></title>

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
            --bd-violet-bg: #712cf9 --bd-violet-rgb: 112.520718, 44.062154, 249.437846;

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

<body class="">


    <main>
        <div class="container">
            <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <?php
                            if (!empty(session()->getFlashdata('success'))) {
                            ?>
                                <div class="alert alert-success alert-dismissible fade show">
                                    <i class="bi-check-circle-fill"></i> <?= session()->getFlashdata('success') ?>
                                    <button type="button" class="container btn-close" aria-label="Close" data-bs-dismiss="alert"></button>
                                </div>
                            <?php
                            } else if (!empty(session()->getFlashdata('fail'))) {
                            ?>
                                <div class="alert alert-danger alert-dismissible fade show">
                                    <i class="bi-exclamation-triangle-fill"></i> <?= session()->getFlashdata('fail') ?>
                                    <button type="button" class="container btn-close" aria-label="Close" data-bs-dismiss="alert"></button>
                                </div>
                            <?php
                            }
                            ?>
                            <?php if (session()->getFlashdata('errors')): ?>
                                <div style="color: red;">
                                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                        <p><?= esc($error) ?></p>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>

                            <div class="d-flex justify-content-center py-4">
                                <a href="index.html" class="logo d-flex align-items-center w-auto">
                                    <img src="<?= base_url('assets/images/logo-sm.png') ?>" alt="logo">
                                </a>
                            </div>
                            <div class="card shadow border-none my-2 px-2">

                                <div class="card-body px-0 pb-2 mt-3">
                                    <!-- Step Indicators -->
                                    <div class="row step-indicator mb-4">
                                        <div class="col-3">
                                            <div class="step active" id="step-indicator-1">1</div>
                                            <div class="step-label d-none d-md-block">Personal Information</div>
                                        </div>
                                        <div class="col-2">
                                            <div class="step" id="step-indicator-2">2</div>
                                            <div class="step-label d-none d-md-block">Employment Details</div>
                                        </div>
                                        <div class="col-2">
                                            <div class="step" id="step-indicator-3">3</div>
                                            <div class="step-label d-none d-md-block">Business Details</div>
                                        </div>
                                        <div class="col-2">
                                            <div class="step" id="step-indicator-4">4</div>
                                            <div class="step-label d-none d-md-block">Terms</div>
                                        </div>
                                        <div class="col-3">
                                            <div class="step" id="step-indicator-5">5</div>
                                            <div class="step-label d-none d-md-block">Beneficiaries</div>
                                        </div>
                                    </div>

                                    <!-- Form -->
                                    <form id="memberForm" enctype="multipart/form-data">
                                        <?= csrf_field() ?>
                                        <!-- Step 1: Personal Information -->
                                        <div class="form-step active" id="step-1">
                                            <h5 class="mb-4">Step 1: Personal Information</h5>

                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label for="firstName" class="form-label">First Name *</label>
                                                    <input type="text" class="form-control" id="firstName" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="lastName" class="form-label">Last Name *</label>
                                                    <input type="text" class="form-control" id="lastName" required>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label for="passportPhoto" class="form-label">Passport Photo *</label>
                                                    <input type="file" class="form-control" id="passportPhoto" name="passport_photo" accept="image/*" required>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label for="dob" class="form-label">Date of Birth *</label>
                                                    <input type="date" class="form-control" id="dob" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="idNumber" class="form-label">ID Number *</label>
                                                    <input type="text" class="form-control" id="idNumber" required>
                                                </div>

                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label for="physicalAddress" class="form-label">Physical Address *</label>
                                                    <input type="text" class="form-control" id="physicalAddress" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="postalAddress" class="form-label">Postal Address *</label>
                                                    <input type="text" class="form-control" id="postalAddress" required>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label for="email" class="form-label">Personal Email *</label>
                                                    <input type="text" class="form-control" id="email" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="phoneNumber" class="form-label">Phone Number *</label>
                                                    <input type="text" class="form-control" id="phoneNumber" required>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label for="areaChief" class="form-label">Area Chief (HOME AREA)</label>
                                                <input type="text" class="form-control" id="areaChief">
                                            </div>

                                            <div class="row">
                                                <h4>Next of Kin</h4>
                                                <div class="col-md-6">
                                                    <label for="nextOfKinName" class="form-label">Name *</label>
                                                    <input type="text" class="form-control" id="nextOfKinName" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="nextOfKinRelationship" class="form-label">Relationship *</label>
                                                    <input type="text" class="form-control" id="nextOfKinRelationship" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="nextOfKinAddress" class="form-label">Address</label>
                                                    <input type="text" class="form-control" id="nextOfKinAddress">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="nextOfKinPhone" class="form-label">Phone Number *</label>
                                                    <input type="text" class="form-control" id="nextOfKinPhone" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="nextOfKinEmail" class="form-label">Email Address</label>
                                                    <input type="email" class="form-control" id="nextOfKinEmail">
                                                </div>
                                            </div>
                                            <div class="d-grid gap-2 d-md-flex justify-content-md-between mt-4">
                                                <a class="btn btn-secondary " href="https://glohasacco.co.ke"><i class="bi bi-arrow-left me-2"></i>Back to Website</a>
                                                <button type="button" class="btn btn-primary next-step" data-step="1">Next: Employment Details</button>
                                            </div>
                                        </div>
                                        <!-- Step 2: Employment Details -->
                                        <div class="form-step" id="step-2">
                                            <h5 class="mb-4">Step 2: Employment Details</h5>
                                            <div class="row">
                                                <div class="mb-3 col-md-6">
                                                    <label for="employer" class="form-label">Employer/Organization</label>
                                                    <input type="text" class="form-control" id="employer">
                                                </div>

                                                <div class="mb-3 col-md-6">
                                                    <label for="personalNumber" class="form-label">Personal Number</label>
                                                    <input type="tel" class="form-control" id="personalNumber">
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label for="alternatePhone" class="form-label">Date of Appointment</label>
                                                    <input type="date" class="form-control" id="alternatePhone">
                                                </div>

                                                <div class="mb-3 col-md-6">
                                                    <label for="workingStation" class="form-label">Working Station</label>
                                                    <input type="text" class="form-control" id="workingStation">
                                                </div>

                                                <div class="mb-3 col-md-6">
                                                    <label for="employerEmail" class="form-label">Employer Email Address</label>
                                                    <input type="email" class="form-control" id="employerEmail">
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <h4>Terms of Employment</h4>
                                                <div class="col-md-6">
                                                    <input type="radio" class="form-check-input" id="employmentType1" name="employmentType" value="permanent">
                                                    <label for="employmentType1" class="form-check-label">Permanent & Pensionable</label>
                                                    <br>
                                                    <input type="radio" class="form-check-input" id="employmentType2" name="employmentType" value="temporary">
                                                    <label for="employmentType2" class="form-check-label">Temporary/Contract</label>
                                                </div>

                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label for="monthlyContribution" class="form-label">Monthly Contribution</label>
                                                    <input type="number" class="form-control" id="monthlyContribution">
                                                </div>
                                                <div class="col-md-6">
                                                    <h4>Mode of remittance</h4>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="remittanceMode" id="remittanceMode1" value="payrollCheckOff">
                                                        <label class="form-check-label" for="remittanceMode1">Payroll Check Off</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="remittanceMode" id="remittanceMode2" value="bankTransfer">
                                                        <label class="form-check-label" for="remittanceMode2">Cheque/Direct Deposit</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="remittanceMode" id="remittanceMode3" value="mobileMoney">
                                                        <label class="form-check-label" for="remittanceMode3">Mobile Money</label>
                                                    </div>
                                                </div>
                                                <div class="form-check ms-3 my-2">
                                                    <input class="form-check-input" type="checkbox" id="employerAuthorization" name="employerAuthorization">
                                                    <label class="form-check-label" for="employerAuthorization">Authorize Employer to Deduct Contributions</label>
                                                </div>
                                                <p class="fw-bolder">All remittances should be deposited at any Co-op Bank, Account No.01100844777700
                                                    Account Name: GLOHA SACCO SOCIETY LTD, Haile Selassie, Nairobi Branch or Mpesa
                                                    Paybill 400200 and Account No: 40084477. (CAUTION: DO NOT PAY CASH TO ANY
                                                    INDIVIDUAL)</p>
                                            </div>

                                            <div class="d-grid gap-2 d-md-flex justify-content-md-between mt-4">
                                                <button type="button" class="btn btn-secondary prev-step" data-step="2">Previous: Personal Information</button>
                                                <button type="button" class="btn btn-primary next-step" data-step="2">Next: Business Details</button>
                                            </div>
                                        </div>

                                        <!-- Business Details -->
                                        <div class="form-step" id="step-3">
                                            <h5 class="mb-4">Step 3: Business Details (to be completed if not in employment)</h5>

                                            <div class="row mb-3">
                                                <div class="mb-3 col-md-6">
                                                    <label for="businessName" class="form-label">Business Name</label>
                                                    <input type="text" class="form-control" id="businessName">
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label for="businessPostalAddress" class="form-label">Business Postal Address</label>
                                                    <input type="text" class="form-control" id="businessPostalAddress">
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label for="businessPostalCode" class="form-label">Postal Code</label>
                                                    <input type="text" class="form-control" id="businessPostalCode">
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label for="businessNature" class="form-label">Nature of Business</label>
                                                    <input type="tel" class="form-control" id="businessNature">
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label for="businessPhysicalLocation" class="form-label">Business Physical Location</label>
                                                    <input type="text" class="form-control" id="businessPhysicalLocation">
                                                </div>
                                            </div>

                                            <div class="d-grid gap-2 d-md-flex justify-content-md-between mt-4">
                                                <button type="button" class="btn btn-secondary me-md-2 prev-step" data-step="3">Previous: Employment Details</button>
                                                <button type="button" class="btn btn-primary next-step" data-step="3">Next: Terms & Conditions</button>
                                            </div>
                                        </div>

                                        <div class="form-step" id="step-4">
                                            <h5 class="mb-4">Step 4: Terms & Conditions of Membership</h5>

                                            <div class=" mb-3">
                                                <ol>
                                                    <li class="text-uppercase">Membership fees : USD 50 - one time payment</li>
                                                    <li class="text-uppercase">Minimum Monthly savings : USD 40</li>
                                                    <li class="text-uppercase">Share Capital : USD 194</li>
                                                </ol>
                                            </div>

                                            <div class="form-check ms-3 my-2">
                                                <input class="form-check-input" type="checkbox" id="mobileBanking" name="mobileBanking">
                                                <label class="form-check-label" for="mobileBanking">Enable Mobile Banking</label>
                                            </div>

                                            <p class="mb-3 fw-bolder">NB: Monthly savings will be remitted on or before 10<sup>th</sup> of every month. No ledger fees applicable</p>

                                            <div class="d-grid gap-2 d-md-flex justify-content-md-between mt-4">
                                                <button type="button" class="btn btn-secondary me-md-2 prev-step" data-step="4">Previous: Business Details</button>
                                                <button type="button" class="btn btn-primary next-step" data-step="4">Next: Beneficiaries</button>
                                            </div>
                                        </div>

                                        <!-- Step 5: Beneficiaries Table -->
                                        <div class="form-step" id="step-5">
                                            <h5 class="mb-4">Step 5: Beneficiaries</h5>
                                            <div class="table-responsive mb-3">
                                                <table class="table table-bordered align-middle" id="beneficiariesTable">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>First Name</th>
                                                            <th>Last Name</th>
                                                            <th>Date of Birth</th>
                                                            <th>ID Number</th>
                                                            <th>Relationship</th>
                                                            <th>% Entitlement</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <!-- Beneficiary rows will be added here -->
                                                    </tbody>
                                                </table>
                                                <button type="button" class="btn btn-outline-primary" id="addBeneficiaryBtn"><i class="bi bi-plus-circle"></i> Add Beneficiary</button>
                                            </div>
                                            <div class="d-grid gap-2 d-md-flex justify-content-md-between mt-4">
                                                <button type="button" class="btn btn-secondary me-md-2 prev-step" data-step="5">Previous: Employment Details</button>
                                                <button type="submit" class="btn btn-success">Submit Application</button>
                                            </div>
                                        </div>
                                    </form>

                                </div>

                            </div>
                        </div>
                    </div>

                </div>


                <div class="d-flex justify-content-center align-items-center mt-4">
                    &copy;<?= date('Y') ?>, <a href="https://glohasacco.co.ke" class="fw-bolder text-success">Gloha Sacco</a>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        // Form steps navigation
                        const form = document.getElementById('memberForm');
                        const steps = document.querySelectorAll('.form-step');
                        const nextButtons = document.querySelectorAll('.next-step');
                        const prevButtons = document.querySelectorAll('.prev-step');
                        const stepIndicators = document.querySelectorAll('.step');

                        // Beneficiaries table logic
                        const beneficiariesTable = document.getElementById('beneficiariesTable').getElementsByTagName('tbody')[0];
                        const addBeneficiaryBtn = document.getElementById('addBeneficiaryBtn');

                        // Add initial row
                        addBeneficiaryRow();

                        addBeneficiaryBtn.addEventListener('click', function() {
                            addBeneficiaryRow();
                        });

                        function addBeneficiaryRow(data = {}) {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <td><input type="text" class="form-control" name="beneficiaries[first_name][]" value="${data.first_name || ''}" required></td>
                                <td><input type="text" class="form-control" name="beneficiaries[last_name][]" value="${data.last_name || ''}" required></td>
                                <td><input type="date" class="form-control" name="beneficiaries[dob][]" value="${data.dob || ''}"></td>
                                <td><input type="text" class="form-control" name="beneficiaries[id_number][]" value="${data.id_number || ''}"></td>
                                <td><input type="text" class="form-control" name="beneficiaries[relationship][]" value="${data.relationship || ''}"></td>
                                <td><input type="text" class="form-control" name="beneficiaries[entitlement][]" value="${data.entitlement || ''}"></td>
                                <td><button type="button" class="btn btn-danger btn-sm remove-beneficiary"><i class="bi bi-trash"></i></button></td>
                            `;
                            beneficiariesTable.appendChild(row);
                        }

                        beneficiariesTable.addEventListener('click', function(e) {
                            if (e.target.closest('.remove-beneficiary')) {
                                const row = e.target.closest('tr');
                                if (beneficiariesTable.rows.length > 1) {
                                    row.remove();
                                } else {
                                    // Always keep at least one row
                                    Array.from(row.querySelectorAll('input')).forEach(input => input.value = '');
                                }
                            }
                        });

                        // Next button click handler
                        nextButtons.forEach(button => {
                            button.addEventListener('click', function() {
                                const currentStep = parseInt(this.getAttribute('data-step'));
                                const currentStepElement = document.getElementById(`step-${currentStep}`);
                                const nextStepElement = document.getElementById(`step-${currentStep + 1}`);

                                // Basic validation for required fields
                                const requiredFields = currentStepElement.querySelectorAll('[required]');
                                let isValid = true;

                                requiredFields.forEach(field => {
                                    if (!field.value) {
                                        isValid = false;
                                        field.classList.add('is-invalid');
                                    } else {
                                        field.classList.remove('is-invalid');
                                    }
                                });

                                if (isValid) {
                                    // Move to next step
                                    currentStepElement.classList.remove('active');
                                    nextStepElement.classList.add('active');

                                    // Update step indicators
                                    document.getElementById(`step-indicator-${currentStep}`).classList.remove('active');
                                    document.getElementById(`step-indicator-${currentStep}`).classList.add('completed');
                                    document.getElementById(`step-indicator-${currentStep + 1}`).classList.add('active');

                                    // Scroll to top of form
                                    window.scrollTo({
                                        top: form.offsetTop - 50,
                                        behavior: 'smooth'
                                    });
                                }
                            });
                        });

                        // Previous button click handler
                        prevButtons.forEach(button => {
                            button.addEventListener('click', function() {
                                const currentStep = parseInt(this.getAttribute('data-step'));
                                const currentStepElement = document.getElementById(`step-${currentStep}`);
                                const prevStepElement = document.getElementById(`step-${currentStep - 1}`);

                                // Move to previous step
                                currentStepElement.classList.remove('active');
                                prevStepElement.classList.add('active');

                                // Update step indicators
                                document.getElementById(`step-indicator-${currentStep}`).classList.remove('active');
                                document.getElementById(`step-indicator-${currentStep - 1}`).classList.remove('completed');
                                document.getElementById(`step-indicator-${currentStep - 1}`).classList.add('active');

                                // Scroll to top of form
                                window.scrollTo({
                                    top: form.offsetTop - 50,
                                    behavior: 'smooth'
                                });
                            });
                        });

                        form.addEventListener('submit', function(e) {
                            e.preventDefault();
                            showLoadingState(true);

                            // Collect all form data, including beneficiaries
                            const formData = new FormData(form);

                            // Beneficiaries: collect as array of objects
                            const beneficiaries = [];
                            const rows = beneficiariesTable.querySelectorAll('tr');
                            rows.forEach(row => {
                                const firstName = row.querySelector('input[name="beneficiaries[first_name][]"]').value.trim();
                                const lastName = row.querySelector('input[name="beneficiaries[last_name][]"]').value.trim();
                                const dob = row.querySelector('input[name="beneficiaries[dob][]"]').value;
                                const idNumber = row.querySelector('input[name="beneficiaries[id_number][]"]').value.trim();
                                const relationship = row.querySelector('input[name="beneficiaries[relationship][]"]').value.trim();
                                const entitlement = row.querySelector('input[name="beneficiaries[entitlement][]"]').value.trim();
                                if (firstName || lastName || dob || idNumber || relationship || entitlement) {
                                    beneficiaries.push({
                                        first_name: firstName,
                                        last_name: lastName,
                                        dob: dob,
                                        id_number: idNumber,
                                        relationship: relationship,
                                        entitlement: entitlement
                                    });
                                }
                            });

                            // Remove any existing beneficiaries fields from FormData
                            for (let key of formData.keys()) {
                                if (key.startsWith('beneficiaries[')) {
                                    formData.delete(key);
                                }
                            }
                            // Add beneficiaries as JSON string
                            formData.append('beneficiaries', JSON.stringify(beneficiaries));

                            fetch('site/member/new', {
                                method: 'POST',
                                body: formData,
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest'
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                showLoadingState(false);
                                if (data.success) {
                                    showFeedbackModal(true, 'Success!', data.message || 'Registration successful.');
                                    setTimeout(() => {
                                        window.location.reload();
                                    }, 2000);
                                } else {
                                    showFeedbackModal(false, 'Error', data.message || 'Registration failed.');
                                }
                            })
                            .catch(error => {
                                showLoadingState(false);
                                showFeedbackModal(false, 'Submission Error', 'An error occurred while submitting the form. Please try again.');
                                console.error('Error:', error);
                            });
                        });

                        /**
                         * Shows or hides the loading overlay
                         * @param {boolean} show - True to show the loading overlay, false to hide it
                         */
                        function showLoadingState(show) {
                            const loadingOverlay = document.getElementById('loadingOverlay');
                            if (loadingOverlay) {
                                loadingOverlay.style.display = show ? 'flex' : 'none';
                            }
                        }

                        /**
                         * Shows a feedback modal with success or error styling
                         * @param {boolean} isSuccess - True for success style, false for error style
                         * @param {string} title - The title to display in the modal header
                         * @param {string} message - The message to display in the modal body (can include HTML)
                         */
                        function showFeedbackModal(isSuccess, title, message) {
                            const modal = document.getElementById('feedbackModal');
                            const modalTitle = document.getElementById('feedbackModalTitle');
                            const messageContainer = document.getElementById('feedbackMessage');
                            const iconContainer = modal.querySelector('.feedback-icon');
                            const modalContent = modal.querySelector('.modal-content');

                            // Set title and message
                            modalTitle.textContent = title;
                            messageContainer.innerHTML = message;

                            // Remove previous border classes
                            modalContent.classList.remove('success-border', 'error-border');

                            // Set icon based on success/error
                            if (isSuccess) {
                                iconContainer.innerHTML = '<div class="success-icon"><span class="succ display-4"><i class="bi bi-check-lg"><i/></span></div>';
                                modalContent.classList.add('success-border');
                            } else {
                                iconContainer.innerHTML = '<div class="error-icon"><span class="err display-4"><i class="bi bi-x"><i/></span></div>';
                                modalContent.classList.add('error-border');
                            }

                            // Show the modal
                            const bsModal = new bootstrap.Modal(modal);
                            bsModal.show();
                        }

                        // Function to show/hide loading state
                        function showLoadingState(isLoading) {
                            const overlay = document.getElementById('loadingOverlay');
                            if (isLoading) {
                                overlay.style.display = 'flex';
                            } else {
                                overlay.style.display = 'none';
                            }
                        }
                    });
                </script>
        </div>
        </div>

        </section>
        </div>


    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>


</body>

</html>