<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?><?= esc($title) ?> <?= $this->endSection() ?>

<div class="row">
    <?= $this->section('content') ?>
    <?= $this->include('partials/sidebar') ?>
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
        <div class="card shadow border-none my-2 px-2">
            <div class="card-body px-0 pb-2 mt-3">
                <!-- Bordered Tabs Justified -->
                <ul class="nav nav-tabs nav-tabs-bordered d-flex" id="borderedTabJustified" role="tablist">
                    <li class="nav-item flex-fill" role="presentation">
                        <button class="nav-link w-100 active" id="home-tab" data-bs-toggle="tab" data-bs-target="#personal-details" type="button" role="tab" aria-controls="home" aria-selected="true">Personal Details</button>
                    </li>
                    <li class="nav-item flex-fill" role="presentation">
                        <button class="nav-link w-100" id="profile-tab" data-bs-toggle="tab" data-bs-target="#additional-details" type="button" role="tab" aria-controls="profile" aria-selected="false">Additional Details</button>
                    </li>
                    <li class="nav-item flex-fill" role="presentation">
                        <button class="nav-link w-100" id="contact-tab" data-bs-toggle="tab" data-bs-target="#beneficiaries" type="button" role="tab" aria-controls="contact" aria-selected="false">Beneficiaries</button>
                    </li>
                </ul>
                <div class="tab-content pt-2" id="borderedTabJustifiedContent">

                    <?= csrf_field() ?>
                    <div class="tab-pane fade  show active" id="personal-details" role="tabpanel" aria-labelledby="home-tab">
                        <form method="post" action="/newMember" class="form-floating mb-3 row">
                            <div class="mb-3 col-md-4">
                                <label for="first-name" class="col-form-label">First Name:</label>
                                <input type="text" class="form-control" id="first-name" name="first-name">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="last-name" class="col-form-label">Last Name:</label>
                                <input type="text" class="form-control" id="last-name" name="last-name">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="mobile" class="col-form-label">Mobile No.</label>
                                <input type="text" class="form-control" id="mobile" name="mobile">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="first-name" class="col-form-label">First Name:</label>
                                <input type="text" class="form-control" id="first-name" name="first-name">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="last-name" class="col-form-label">Last Name:</label>
                                <input type="text" class="form-control" id="last-name" name="last-name">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="mobile" class="col-form-label">Mobile No.</label>
                                <input type="text" class="form-control" id="mobile" name="mobile">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="first-name" class="col-form-label">First Name:</label>
                                <input type="text" class="form-control" id="first-name" name="first-name">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="last-name" class="col-form-label">Last Name:</label>
                                <input type="text" class="form-control" id="last-name" name="last-name">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="mobile" class="col-form-label">Mobile No.</label>
                                <input type="text" class="form-control" id="mobile" name="mobile">
                            </div>
                        </form>


                    </div>
                    <div class="tab-pane fade " id="additional-details" role="tabpanel" aria-labelledby="profile-tab">
                        <form method="post" action="/newMember" class="form-floating mb-3 row">
                            <div class="mb-3 col-md-4">
                                <label for="first-name" class="col-form-label">First Name:</label>
                                <input type="text" class="form-control" id="first-name" name="first-name">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="last-name" class="col-form-label">Last Name:</label>
                                <input type="text" class="form-control" id="last-name" name="last-name">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="mobile" class="col-form-label">Mobile No.</label>
                                <input type="text" class="form-control" id="mobile" name="mobile">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="first-name" class="col-form-label">First Name:</label>
                                <input type="text" class="form-control" id="first-name" name="first-name">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="last-name" class="col-form-label">Last Name:</label>
                                <input type="text" class="form-control" id="last-name" name="last-name">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="mobile" class="col-form-label">Mobile No.</label>
                                <input type="text" class="form-control" id="mobile" name="mobile">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="first-name" class="col-form-label">First Name:</label>
                                <input type="text" class="form-control" id="first-name" name="first-name">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="last-name" class="col-form-label">Last Name:</label>
                                <input type="text" class="form-control" id="last-name" name="last-name">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="mobile" class="col-form-label">Mobile No.</label>
                                <input type="text" class="form-control" id="mobile" name="mobile">
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade " id="beneficiaries" role="tabpanel" aria-labelledby="contact-tab">
                        <form method="post" action="/newMember" class="form-floating mb-3 row">
                            <div class="mb-3 col-md-4">
                                <label for="first-name" class="col-form-label">First Name:</label>
                                <input type="text" class="form-control" id="first-name" name="first-name">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="last-name" class="col-form-label">Last Name:</label>
                                <input type="text" class="form-control" id="last-name" name="last-name">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="mobile" class="col-form-label">Mobile No.</label>
                                <input type="text" class="form-control" id="mobile" name="mobile">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="first-name" class="col-form-label">First Name:</label>
                                <input type="text" class="form-control" id="first-name" name="first-name">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="last-name" class="col-form-label">Last Name:</label>
                                <input type="text" class="form-control" id="last-name" name="last-name">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="mobile" class="col-form-label">Mobile No.</label>
                                <input type="text" class="form-control" id="mobile" name="mobile">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="first-name" class="col-form-label">First Name:</label>
                                <input type="text" class="form-control" id="first-name" name="first-name">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="last-name" class="col-form-label">Last Name:</label>
                                <input type="text" class="form-control" id="last-name" name="last-name">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="mobile" class="col-form-label">Mobile No.</label>
                                <input type="text" class="form-control" id="mobile" name="mobile">
                            </div>
                        </form>
                    </div>

                </div><!-- End Bordered Tabs Justified -->
            </div>
        </div>

    </div>
</div>


<?= $this->endSection() ?>