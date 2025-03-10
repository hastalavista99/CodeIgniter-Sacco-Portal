<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?>Payments<?= $this->endSection() ?>


<div class="row">
    <?= $this->section('content') ?>
    <?= $this->include('partials/sidebar') ?>
    <div class="col-lg-12">
        <div class="card shadow border-none my-4 px-2">
            <div class="d-flex justify-content-end mb-3">

                <div class="pt-1 pb-1 mb-1">
                    <h4 class="text-capitalize display-6 ps-3">Total: <?= esc($total); ?></h4>
                </div>

            </div>
            <div class="card-body px-0 pb-2">
                <?php if (!empty($payments) && is_array($payments)): ?>
                    <div class="table-responsive">
                        <table class="table table-hover" id="paymentsTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Amount</th>
                                    <th>Trans ID</th>
                                    <th>BillRefNumber</th>
                                    <th>Paybill</th>
                                    <th>Payment Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($payments as $payment_item): ?>
                                    <tr>
                                        <td><?= esc($payment_item['mp_id']) ?></td>
                                        <td><?= esc($payment_item['mp_name']) ?></td>
                                        <!-- <div class="main"> -->
                                        <td><?= esc($payment_item['TransAmount']) ?></td>
                                        <td><?= esc($payment_item['TransID']) ?></td>
                                        <td><a
                                                href="<?= site_url('payments/details/' . $payment_item['BillRefNumber']) ?>"><?= esc($payment_item['BillRefNumber']) ?></a>
                                        </td>
                                        <td><?= esc($payment_item['ShortCode']) ?></td>
                                        <td><?= esc($payment_item['mp_date']) ?></td>
                                    </tr>


                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>

                <?php else: ?>

                    <h3>No Payments</h3>

                    <p>Unable to find any payments for you.</p>

                <?php endif ?>
            </div>
        </div>
    </div>
    <?= $this->endSection() ?>