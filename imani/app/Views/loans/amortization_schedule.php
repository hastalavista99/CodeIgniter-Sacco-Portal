<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?><?= esc($title) ?><?= $this->endSection() ?>

<div class="row">
    <?= $this->section('content') ?>
    <?= $this->include('partials/sidebar') ?>
    <div class="col-lg-12">

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Amortization Schedule - <?= esc($member['first_name'] . ' ' . $member['last_name']) ?></h5>
                <a href="<?= site_url('loans/amortization/pdf/loan/' . $loan['id']) ?>" class="btn btn-primary" target="_blank"><i class="bi bi-filetype-pdf me-2"></i>Export PDF</a>
            </div>
            <div class="card-body">
                <p><strong>Loan ID:</strong> <?= esc($loan['id']) ?> |
                    <strong>Principal:</strong> <?= number_format($loan['principal'], 2) ?> |
                    <strong>Monthly Repayment:</strong> <?= number_format($loan['monthly_repayment'], 2) ?> |
                    <strong>Repayment Period:</strong> <?= $loan['repayment_period'] ?> months
                </p>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Due Date</th>
                            <th>Principal</th>
                            <th>Interest</th>
                            <th>Total Repayment</th>
                            <th>Remaining Balance</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($schedule as $row): ?>
                            <tr>
                                <td><?= $row['installment'] ?></td>
                                <td><?= $row['due_date'] ?></td>
                                <td><?= number_format($row['principal'], 2) ?></td>
                                <td><?= number_format($row['interest'], 2) ?></td>
                                <td><?= number_format($row['total'], 2) ?></td>
                                <td><?= number_format($row['balance'], 2) ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<?= $this->endSection() ?>