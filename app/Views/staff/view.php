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
        <div class="card shadow border-none my-2 px-2">

            <div class="card-body px-0 pb-2">
                <div class="row p-2">
                    <div class="col-md-3">
                        <div class="d-flex justify-content-center align-items-center h-100">
                            <?php if ($staff['photo']): ?>
                                <img src="<?= base_url('uploads/staff/' . $staff['photo']) ?>" alt="Photo" class=" img-thumbnail" style="width: 200px; height: 200px; object-fit: cover; border-radius: 20px;">
                            <?php else: ?>
                                <img src="<?= base_url('assets/img/default-user.png') ?>" class="img-thumbnail" alt="No Photo">
                            <?php endif; ?>
                        </div>

                    </div>

                    <div class="col-md-9">
                        <table class="table table-bordered">
                            <tr>
                                <th>Staff Number</th>
                                <td><?= esc($staff['staff_number']) ?></td>
                            </tr>
                            <tr>
                                <th>Full Name</th>
                                <td><?= esc($staff['first_name'] . ' ' . $staff['last_name']) ?></td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td><?= esc($staff['email']) ?></td>
                            </tr>
                            <tr>
                                <th>Phone</th>
                                <td><?= esc($staff['phone']) ?></td>
                            </tr>
                            <tr>
                                <th>Gender</th>
                                <td><?= ucfirst(esc($staff['gender'])) ?></td>
                            </tr>
                            <tr>
                                <th>Position</th>
                                <td><?= esc($staff['position']) ?></td>
                            </tr>
                            <tr>
                                <th>Department</th>
                                <td><?= esc($staff['department']) ?></td>
                            </tr>
                            <tr>
                                <th>Hire Date</th>
                                <td><?= esc($staff['hire_date']) ?></td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td><?= ucfirst(esc($staff['status'])) ?></td>
                            </tr>
                        </table>

                        <div class="d-flex justify-content-around align-items-center">
                            <a href="<?= site_url('staff') ?>" class="btn btn-secondary"><i class="bi bi-arrow-left me-2"></i> Back to List</a>
                            <a href="<?= site_url('staff/badge/' . $staff['id']) ?>" class="btn btn-warning" target="_blank"><i class="bi bi-person-badge me-2"></i>Print Badge</a>
                        </div>


                    </div>
                </div>
            </div>
        </div>

    </div>
</div>


<?= $this->endSection() ?>