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
                    <table class="table table-bordered text-center" id="viewsTable">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Member Name</th>
                                <th>Member No</th>
                                <th>Employer</th>
                                <th>Check-off Code</th>
                                <th>Checkoff Shares</th>
                                <th>Checkoff Savings</th>
                                <th>Frequency</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($checkoff_amounts as $index => $amount): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td><?= esc($amount['first_name'] . ' ' . $amount['last_name']) ?></td>
                                    <td><?= esc($amount['member_number']) ?></td>
                                    <td><?= esc($amount['employer_name']) ?></td>
                                    <td><?= esc($amount['checkoff_code']) ?></td>
                                    <td><?= esc($amount['checkoff_shares']) ?></td>
                                    <td><?= esc($amount['checkoff_savings']) ?></td>
                                    <td><?= esc($amount['deduction_frequency']) ?></td>
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