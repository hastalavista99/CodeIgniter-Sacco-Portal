<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?><?= esc($title) ?><?= $this->endSection() ?>

<div class="row">
    <?= $this->section('content') ?>
    <?= $this->include('partials/sidebar') ?>
    <div class="col-lg-12">
        <?php if (!empty(session()->getFlashdata('success'))) : ?>
            <div class="alert alert-success alert-dismissible fade show">
                <i class="bi-check-circle-fill"></i> <?= session()->getFlashdata('success') ?>
                <button type="button" class="container btn-close" aria-label="Close" data-bs-dismiss="alert"></button>
            </div>
        <?php elseif (!empty(session()->getFlashdata('fail'))) : ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="bi-exclamation-triangle-fill"></i> <?= session()->getFlashdata('fail') ?>
                <button type="button" class="container btn-close" aria-label="Close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="card shadow border-none my-2 px-2">

            <div class="card-body px-0 pb-2">
                <h2>Top-Up Loan Request</h2>

                <p>Original Loan Amount: <?= number_format($oldLoan['principal'], 2) ?></p>
                <p>Repaid: <?= number_format($percentagePaid, 2) ?>%</p>

                <form action="<?= site_url('loan-topup/process') ?>" method="post">
                    <input type="hidden" name="old_loan_id" value="<?= $oldLoan['id'] ?>">
                    <div class="form-control">
                        <label class="form-label">New Loan Amount</label>
                        <input type="number" name="new_loan_amount" step="0.01" class="form-control" required>
                        <button type="submit" class="btn btn-primary mt-4">Submit Top-Up</button>
                    </div>
                    
                    
                </form>

            </div>
        </div>
    </div>



    <?= $this->endSection() ?>