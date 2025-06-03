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
                <form action="<?= site_url('staff/update/' . esc($staff['id'])) ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="row">
                        <div class="mb-3 col-6">
                            <label for="first_name">First Name</label>
                            <input type="text" name="first_name" class="form-control" value="<?= esc($staff['first_name']) ?>" required>
                        </div>

                        <div class="mb-3 col-6">
                            <label for="last_name">Last Name</label>
                            <input type="text" name="last_name" class="form-control" value="<?= esc($staff['last_name']) ?>" required>
                        </div>
                        <div class="mb-3 col-4">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control" value="<?= esc($staff['email']) ?>" required>
                        </div>

                        <div class="mb-3 col-4">
                            <label for="phone">Phone</label>
                            <input type="text" name="phone" class="form-control" value="<?= esc($staff['phone']) ?>" required>
                        </div>

                        <input type="hidden" name="staff_id" value="<?= esc($staff['id']) ?>">

                        <div class="mb-3 col-4">
                            <label for="gender">Gender</label>
                            <select name="gender" class="form-select">
                                <option value="male" <?= ($staff['gender'] == 'male') ? 'selected' : '' ?>>Male</option>
                                <option value="female" <?= ($staff['gender'] == 'female') ? 'selected' : '' ?>>Female</option>
                                <option value="other" <?= ($staff['gender'] == 'other') ? 'selected' : '' ?>>Other</option>

                            </select>
                        </div>
                        <div class="mb-3 col-4">
                            <label for="position">Position</label>
                            <input type="text" name="position" class="form-control" value="<?= esc($staff['position']) ?>" required>
                        </div>

                        <div class="mb-3 col-4">
                            <label for="department">Department</label>
                            <input type="text" name="department" class="form-control" value="<?= esc($staff['department']) ?>" required>
                        </div>

                        <div class="mb-3 col-4">
                            <label for="hire_date">Hire Date</label>
                            <input type="date" name="hire_date" class="form-control" value="<?= esc($staff['hire_date']) ?>" required>
                        </div>
                        <div class="form-group mb-3">
                            <!-- jpg only -->
                            <label for="photo">Profile Photo</label>
                            <input type="file" name="photo" class="form-control" accept=".jpg">
                        </div>

                    <div class="d-flex justify-content-between align-items-center mr-3">
                        <a href="<?= site_url('staff')?>" class="btn btn-secondary"><i class="bi bi-arrow-left me-2"></i>Back to Staff</a>
                        <button type="submit" class="btn btn-primary">Update Staff</button>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>

</div>
</div>




<?= $this->endSection() ?>