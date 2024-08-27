<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?>My Profile<?= $this->endSection() ?>

<div class="row">
    <?= $this->section('content') ?>
    <?= $this->include('partials/sidebar') ?>
    <div class="row">
        <div class="col-xl-4">

            <div class="card">
                <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

                    <i class="bi bi-person-circle" style="font-size: 4rem;"></i>
                    <h2><?= $userInfo['name'] ?></h2>
                    <h3><?= $userInfo['role'] ?></h3>
                    <div class="social-links mt-2">
                        <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                        <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-xl-8">
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
            
            ?>
            <?php
            }else if (!empty(session()->getFlashdata('validation'))) {
            ?>
                <div class="alert alert-warning alert-dismissible fade show">
                    <i class="bi-exclamation-triangle-fill"></i> <?= session()->getFlashdata('fail') ?>
                    <button type="button" class="container btn-close" aria-label="Close" data-bs-dismiss="alert"></button>
                </div>
            <?php
            }
            ?>
            <?= validation_list_errors()?>

            <div class="card">
                <div class="card-body pt-3">
                    <!-- Bordered Tabs -->
                    <ul class="nav nav-tabs nav-tabs-bordered">

                        <li class="nav-item">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
                        </li>
                        <!-- 
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
                        </li> -->

                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change Password</button>
                        </li>

                    </ul>
                    <div class="tab-content pt-2">

                        <div class="tab-pane fade show active profile-overview" id="profile-overview">

                            <h5 class="card-title">Profile Details</h5>

                            <div class="row">
                                <div class="col-lg-3 col-md-4 label ">Name</div>
                                <div class="col-lg-9 col-md-8"><?= $userInfo['name'] ?></div>
                            </div>

                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">Company</div>
                                <div class="col-lg-9 col-md-8">Gloha Sacco Society</div>
                            </div>

                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">User Role</div>
                                <div class="col-lg-9 col-md-8"><?= $userInfo['role'] ?></div>
                            </div>

                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">Phone</div>
                                <div class="col-lg-9 col-md-8"><?= $userInfo['mobile'] ?></div>
                            </div>

                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">Email</div>
                                <div class="col-lg-9 col-md-8"><?= $userInfo['email'] ?></div>
                            </div>
                        </div>


                        <?php $id = $userInfo['id'] ?>



                        <div class="tab-pane fade pt-3" id="profile-change-password">

                            <!-- Change Password Form -->
                            <?= validation_list_errors()?>
                            <form action="<?= site_url('loginMember/changePass?id=' . $id) ?>" method="post" class="form">
                                <?= csrf_field() ?>
                                <div class="row mb-3">
                                    <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                                    <div class="col-md-8 col-lg-9 d-flex align-items-center">
                                        <input name="password" type="password" class="form-control me-1" id="currentPassword" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="newpassword" type="password" class="form-control" id="newPassword" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter New Password</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="renewpassword" type="password" class="form-control" id="renewPassword" required>
                                    </div>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="checkPassword">
                                    <label class="form-check-label" for="checkPassword">
                                        Show Password
                                    </label>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Change Password</button>
                                </div>
                            </form>
                            <script>
                                document.getElementById('checkPassword').addEventListener('change', function() {
                                    let passwordFields = document.querySelectorAll('#currentPassword, #newPassword, #renewPassword');
                                    passwordFields.forEach(field => {
                                        if (this.checked) {
                                            field.type = 'text';
                                        } else {
                                            field.type = 'password';
                                        }
                                    });
                                });
                            </script>
                        </div>


                    </div><!-- End Bordered Tabs -->

                </div>
            </div>
        </div>

    </div>
    <?= $this->endSection() ?>
</div>