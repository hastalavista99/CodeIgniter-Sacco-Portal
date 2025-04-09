<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?><?= esc($title)?><?= $this->endSection() ?>

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
            <div class="d-flex justify-content-end mb-3">

            </div>
            <div class="card-body px-0 pb-2">


                <?php if (!empty($payments) && is_array($payments)) : ?>
                    <div class="table-responsive-md">
                        <table class="table table-hover" id="paymentsTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Member Code</th>
                                    <th>Date</th>
                                    <th>Reference Code</th>
                                    <th>Amount</th>
                                    <th>View</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($payments as $payment_item) : ?>
                                    <tr>
                                        <td><?= esc($payment_item['id']) ?></td>
                                        <td><?= esc($payment_item['transactionReferenceCode']) ?></td>
                                        <td><?= esc($payment_item['paymentDate'])?></td>
                                        <td><?= esc($payment_item['paymentReferenceCode'])?></td>
                                        <td><?= esc($payment_item['paymentAmount']) ?></td>
                                        <td><button class="btn btn-sm btn-success"><i class="bi bi-eye"></i></button></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else : ?>
                    <h3>No Payments</h3>
                    <p>Unable to find any payments for you.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>


    <?= $this->endSection() ?>