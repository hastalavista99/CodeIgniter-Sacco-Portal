<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?>Payments<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
    <?= $this->include('partials/sidebar') ?>
    <div class="col-12 col-md-9">
        <div class="card shadow border-none my-4 px-2">
            <div class="d-flex justify-content-between mb-2">
                <div class="row col-md-7 p-0 mx-3 z-index-2 my-2" style="height: 35px;">
                    <div class="pt-1 pb-1 mb-2">
                        <h4 class="row text-capitalize display-4 ps-3">Payments</h4>
                    </div>
                </div>
                <div class="col-md-2 pt-3">
                    <div>
                        <!-- <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addUnitModal">
                            New Member
                        </button> -->
                    </div>
                </div>

            </div>
            <div class="card-body px-0 pb-2">
                <?php if (!empty($payments) && is_array($payments)) : ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Amount</th>
                                    <th>Trans ID</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($payments as $payment_item) : ?>
                                    <tr>
                                    <td><?= esc($payment_item['mp_id']) ?></td>
                                        <td><?= esc($payment_item['mp_name']) ?></td>

                                        <!-- <div class="main"> -->
                                        <td><?= esc($payment_item['TransAmount']) ?></td>
                                        <td><?= esc($payment_item['TransID']) ?></td>
                                    </tr>
                            </tbody>

                        <?php endforeach ?>
                        </table>
                    </div>

                <?php else : ?>

                    <h3>No Payments</h3>

                    <p>Unable to find any payments for you.</p>

                <?php endif ?>
            </div>
        </div>
    </div>
    <?= $this->endSection() ?>