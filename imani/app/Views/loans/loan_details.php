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

            <div class="card-body px-0 pt-3 pb-2">
                <section class="my-3 py2">
                    <h5>Member Details:</h5>
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-3 col-md-4 label fw-bold">Name:</div>
                            <div class="col-lg-9 col-md-8"><?= $loan['member_first_name'] ?> <?= $loan['member_last_name'] ?></div>
                        </div>

                        <div class="row">
                            <div class="col-lg-3 col-md-4 label fw-bold">Member Number:</div>
                            <div class="col-lg-9 col-md-8"><?= $loan['member_number'] ?></div>
                        </div>

                        <div class="row">
                            <div class="col-lg-3 col-md-4 label fw-bold">Mobile:</div>
                            <div class="col-lg-9 col-md-8"><?= $loan['member_mobile'] ?></div>
                        </div>

                        <div class="row">
                            <div class="col-lg-3 col-md-4 label fw-bold">Email:</div>
                            <div class="col-lg-9 col-md-8"><?= $loan['email'] ?></div>
                        </div>

                        <div class="row">
                            <div class="col-lg-3 col-md-4 label fw-bold">Application Date:</div>
                            <div class="col-lg-9 col-md-8"><?= $loan['created_at'] ?></div>
                        </div>
                    </div>
                </section>
                <section class="my-3 py2">
                    <h5>Loan Details:</h5>
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-3 col-md-4 label fw-bold">Loan status:</div>
                            <div class="col-lg-9 col-md-8 text-capitalize"><?= $loan['loan_status'] ?></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-md-4 label fw-bold">Loan type:</div>
                            <div class="col-lg-9 col-md-8"><?= $loan['loan_name'] ?></div>
                        </div>

                        <div class="row">
                            <div class="col-lg-3 col-md-4 label fw-bold">Loan Principal:</div>
                            <div class="col-lg-9 col-md-8"><?= "Ksh " . $loan['principal'] ?></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-md-4 label fw-bold">Loan Interest:</div>
                            <div class="col-lg-9 col-md-8"><?= "Ksh " . $loan['total_interest'] ?></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-md-4 label fw-bold">Total Loan:</div>
                            <div class="col-lg-9 col-md-8"><?= "Ksh " . $loan['total_loan'] ?></div>
                        </div>

                        <div class="row">
                            <div class="col-lg-3 col-md-4 label fw-bold">Repayment Period:</div>
                            <div class="col-lg-9 col-md-8"><?= $loan['repayment_period'] . " months" ?></div>
                        </div>

                        <div class="row">
                            <div class="col-lg-3 col-md-4 label fw-bold">Monthly Repayment:</div>
                            <div class="col-lg-9 col-md-8"><?= $loan['monthly_repayment'] ?></div>
                        </div>
                    </div>
                </section>
                <section class="my-3 py2">
                    <h5>Disbursement Details:</h5>
                    <div class="container">
                    </div>
                </section>
                <section class="my-3 py2">
                    <h5>Guarantors:</h5>
                    <div class="container">

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Member No</th>
                                    <th>Name</th>
                                    <th>Mobile</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($loan['guarantors'] as $g): ?>
                                    <tr>
                                        <td><?= esc($g['guarantor_member_no']) ?></td>
                                        <td><?= esc($g['name']) ?></td>
                                        <td><?= esc($g['mobile']) ?></td>
                                        <td><?= number_format($g['amount'], 2) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                </section>

                <div class="my-3 d-flex align-content-center justify-content-around">
                    <a href="<?= site_url('loans/all') ?>" class="btn btn-success mx-2"><i class="bi-chevron-left"></i>Back</a>
                    <?php
                    if ($userInfo['role'] === 'admin') { ?>
                        <a href="<?= site_url('loans/print-pdf/' . $loan['id']) ?>" target="_blank" class="btn btn-primary mx-2">
                            View and Download PDF
                        </a>
                        <?php
                        if ($loan['loan_status'] !== 'approved') {
                        ?>
                            <a href="<?= site_url('loans/approve/' . $loan['id']) ?>" class="btn btn-success mx-2">
                                <i class="bi bi-check2 ms-auto"></i>
                                Approve
                            </a>
                            <a href="<?= site_url('loans/reject/' . $loan['id']) ?>" class="btn btn-danger mx-2">
                                <i class="bi bi-x-lg ms-auto"></i>
                                Reject
                            </a>
                        <?php
                        }
                        ?>

                    <?php } ?>
                </div>


            </div>
        </div>
    </div>



    <?= $this->endSection() ?>