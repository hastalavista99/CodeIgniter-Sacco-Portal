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
                            <div class="col-lg-9 col-md-8"><?= $loan['name'] ?></div>
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
                            <div class="col-lg-9 col-md-8"><?= $loan['member_email'] ?></div>
                        </div>

                        <div class="row">
                            <div class="col-lg-3 col-md-4 label fw-bold">ID Number:</div>
                            <div class="col-lg-9 col-md-8"><?= $loan['member_id'] ?></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-md-4 label fw-bold">Employer:</div>
                            <div class="col-lg-9 col-md-8"><?= $loan['employer'] ?></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-md-4 label fw-bold">Station:</div>
                            <div class="col-lg-9 col-md-8"><?= $loan['station'] ?></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-md-4 label fw-bold">P.O. Box:</div>
                            <div class="col-lg-9 col-md-8"><?= $loan['po_box'] . "-" . $loan['po_code'] . ", " . $loan['po_city'] ?></div>
                        </div>
                    </div>
                </section>
                <section class="my-3 py2">
                    <h5>Loan Details:</h5>
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-3 col-md-4 label fw-bold">Loan type:</div>
                            <div class="col-lg-9 col-md-8"><?= $loan['loan_type'] ?></div>
                        </div>

                        <div class="row">
                            <div class="col-lg-3 col-md-4 label fw-bold">Loan Amount:</div>
                            <div class="col-lg-9 col-md-8"><?= "Ksh " . number_format($loan['amount'], 0, 2) ?></div>
                        </div>

                        <div class="row">
                            <div class="col-lg-3 col-md-4 label fw-bold">Repayment Period:</div>
                            <div class="col-lg-9 col-md-8"><?= $loan['repay_period'] . " months" ?></div>
                        </div>

                        <div class="row">
                            <div class="col-lg-3 col-md-4 label fw-bold">Repayment Mode:</div>
                            <div class="col-lg-9 col-md-8"><?= $loan['payment_mode'] ?></div>
                        </div>
                    </div>
                </section>
                <section class="my-3 py2">
                    <h5>Disbursement Details:</h5>
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-3 col-md-4 label fw-bold">Bank Details:</div>
                            <div class="col-lg-9 col-md-8"><?= $loan['bank'] . " - " . $loan['branch'] ?></div>
                        </div>

                        <div class="row">
                            <div class="col-lg-3 col-md-4 label fw-bold">Account Details:</div>
                            <div class="col-lg-9 col-md-8"><?= $loan['account_number'] . " - " . $loan['account_name'] ?></div>
                        </div>

                        <div class="row">
                            <div class="col-lg-3 col-md-4 label fw-bold">Disbursement Type:</div>
                            <div class="col-lg-9 col-md-8"><?= $loan['payment_type'] ?></div>
                        </div>
                    </div>
                </section>
                <section class="my-3 py2">
                    <h5>Guarantors:</h5>
                    <div class="container">
                        <?php if (!empty($guarantors) && is_array($guarantors)) : ?>
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="table-info">
                                        <th>Name</th>
                                        <th>Member Number</th>
                                        <th>ID Number</th>
                                        <th>Guarantee</th>
                                        <th>Response?</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($guarantors as $guarantor) : ?>
                                        <tr>
                                            <td><?= $guarantor['member_name'] ?></td>
                                            <td><?= $guarantor['member_number'] ?></td>
                                            <td><?= $guarantor['id_number'] ?></td>
                                            <td><?= number_format($guarantor['amount']) ?></td>
                                            <td><?= $guarantor['responded'] ?></td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                    </div>
                <?php else : ?>
                    <h3>No Guarantors found</h3>
                    <p>Unable to find any guarantors for this loan.</p>
                <?php endif; ?>

                </section>

                <div class="my-3 d-flex align-content-center justify-content-around">
                    <a href="<?= site_url('loans/new') ?>" class="btn btn-success mx-2"><i class="bi-chevron-left"></i>Back</a>
                    <?php
                    if ($userInfo['role'] === 'admin') { ?>
                        <a href="<?= site_url('loans/print-pdf/' . $loan['id']) ?>" target="_blank" class="btn btn-primary mx-2">
                            View and Download PDF
                        </a>
                        <?php
                        if ($loan['loan_status'] !== 'approved' && $loan['loan_status'] !== 'rejected') {
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