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

                <?php if (!empty($loans) && is_array($loans)) : ?>
                    <div class="table-responsive-md my-3 text-center">
                        <table class="table table-hover" id="loansTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Member No.</th>
                                    <th>Loan Taken</th>
                                    <th>Repayment Amount</th>
                                    <th>MPESA Ref</th>
                                    <th>Date</th>
                                    <th>Disbursed?</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <?php foreach ($loans as $loan_item) : ?>
                                    <tr>
                                        <td><?= esc($loan_item['id']) ?></td>
                                        <td><?= esc($loan_item['first_name']) ?></td>
                                        <td><?= esc($loan_item['last_name']) ?></td>
                                        <td><?= esc($loan_item['member_number']) ?></td>
                                        <td><?= esc($loan_item['amount']) ?></td>
                                        <td><?= esc($loan_item['total_repayable']) ?></td>
                                        <td><?= esc($loan_item['mpesa_receipt'] ?? '-') ?></td>
                                        <td class="text-sm"><?= esc($loan_item['created_at'] ?? '-') ?></td>
                                        <?php if($loan_item['disbursement_status'] === 'approved') {?>
                                            <td class="text-capitalize fw-bold"><span class="badge rounded-pill bg-success"><?= esc($loan_item['disbursement_status']) ?></span></td>
                                        <?php } else {?>
                                            <td class="text-capitalize fw-bold"><span class="badge rounded-pill bg-warning text-dark"><?= esc($loan_item['disbursement_status']) ?></span></td>
                                        <?php } ?>
                                        <td><a class="btn btn-success btn-sm" href="<?= site_url('loans/mobile/view/' . $loan_item['id']) ?>">Details</a></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else : ?>
                    <h3>No Loans</h3>
                    <p>Unable to find any loans for you.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>



    <?= $this->endSection() ?>