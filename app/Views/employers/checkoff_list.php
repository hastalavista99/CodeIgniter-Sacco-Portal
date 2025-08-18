<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?><?= $title ?> <?= $this->endSection() ?>



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

            <div class="card-body px-0 pb-2 pt-2">
                <?php if (!empty($checkoff_amounts)): ?>
                    <table class="table table-bordered table-striped" id="viewsTable">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Employer Name</th>
                                <!-- <th>Contact Person</th> -->
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Check-off Code</th>
                                <th>Frequency</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php foreach ($checkoff_amounts as $index => $amount): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td><?= esc($amount['employer_name']) ?></td>
                                    <!-- <td><?= esc($emp['contact_person']) ?></td> -->
                                    <td><?= esc($amount['phone_number']) ?></td>
                                    <td><?= esc($amount['email']) ?></td>
                                    <td><?= esc($amount['checkoff_code']) ?></td>
                                    <td><?= esc($amount['deduction_frequency']) ?></td>
                                    <td><?= esc($amount['status']) ?></td>
                                    <td>
                                        <a href="<?= site_url('employers/checkoff/' . $amount['employer_id']) ?>" class="btn btn-sm btn-info" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Checkoff List"><i class="bi bi-receipt"></i></a>
                                        <a href="<?= site_url('employers/edit/' . $amount['employer_id']) ?>" class="btn btn-sm btn-warning" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="View & Edit"><i class="bi bi-pencil-square"></i></a>
                                        <a href="<?= site_url('employers/delete/' . $amount['employer_id']) ?>"
                                            onclick="return confirm('Are you sure you want to delete this employer?');"
                                            class="btn btn-sm btn-danger"
                                            data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Delete"><i class="bi bi-trash3-fill"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                        </tbody>
                    </table>
                <?php else: ?>
                     <h3>No Available Checkoff</h3>
                    <p>Unable to find any checkoff for this employer. Create to see list</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>


<?= $this->endSection() ?>