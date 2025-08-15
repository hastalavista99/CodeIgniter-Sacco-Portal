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


            <div class="d-flex justify-content-end mb-3 pt-3">


                <div class="mb-3">
                    <a href="<?= site_url('employers/create') ?>" class="btn btn-primary">Add Employer</a>
                </div>
            </div>
            <div class="card-body px-0 pb-2">
                <?php if (!empty($employers)): ?>
                    <table class="table table-bordered table-striped" id="viewsTable">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Employer Name</th>
                                <th>Contact Person</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Check-off Code</th>
                                <th>Frequency</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php foreach ($employers as $index => $emp): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td><?= esc($emp['employer_name']) ?></td>
                                    <td><?= esc($emp['contact_person']) ?></td>
                                    <td><?= esc($emp['phone_number']) ?></td>
                                    <td><?= esc($emp['email']) ?></td>
                                    <td><?= esc($emp['checkoff_code']) ?></td>
                                    <td><?= esc($emp['deduction_frequency']) ?></td>
                                    <td><?= esc($emp['status']) ?></td>
                                    <td>
                                        <a href="<?= site_url('employers/edit/' . $emp['employer_id']) ?>" class="btn btn-sm btn-warning" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="View & Edit"><i class="bi bi-pencil-square"></i></a>
                                        <a href="<?= site_url('employers/delete/' . $emp['employer_id']) ?>"
                                            onclick="return confirm('Are you sure you want to delete this employer?');"
                                            class="btn btn-sm btn-danger"
                                            data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Delete"><i class="bi bi-trash3-fill"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                        </tbody>
                    </table>
                <?php else: ?>
                     <h3>No Employers</h3>
                    <p>Unable to find any employers for you. Create to see list</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>


<?= $this->endSection() ?>