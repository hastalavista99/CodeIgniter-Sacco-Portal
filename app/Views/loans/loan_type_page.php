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
            <div class="d-flex justify-content-end mb-3">

                <div class="col-md-2 pt-3">
                    <div>
                        <a class="btn btn-success" href="<?= site_url('loans/type/settings')?>"><i class="bi-plus"></i>
                            Add Loan Type
        </a>
                    </div>
                </div>

            </div>
            <div class="card-body px-0 pb-2">

                <?php if (!empty($types) && is_array($types)) : 
                    // print_r ($types);?>
                    <div class="table-responsive-md my-3">
                        <table class="table table-hover" id="paymentsTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Loan Name</th>
                                    <th>Interest Rate(%)</th>
                                    <th>Interest Method</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($types as $type_item) : ?>
                                    <tr>
                                        <td><?= esc($type_item['id']) ?></td>
                                        <td><?= esc($type_item['loan_name']) ?></td>
                                        <td><?= esc($type_item['interest_rate']) ?>%</td>
                                        <td><?= esc($type_item['interest_method']) ?></td>
                                        <td>
                                            <a href="<?= site_url('loans/type/view/'.$type_item['id'])?>" class="btn btn-sm btn-success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="View & Edit">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </td>

                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else : ?>
                    <h3>No Loan types</h3>
                    <p>Unable to find any loan types for you.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?= $this->endSection() ?>