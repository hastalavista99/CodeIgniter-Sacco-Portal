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
                        <a class="btn btn-success" href="<?= site_url('loan_type_settings')?>"><i class="bi-plus"></i>
                            Add Type
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
                                    <th>Loan Type</th>
                                    <th>Interest Rate(%)</th>
                                    <th>Formula</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($types as $type_item) : ?>
                                    <tr>
                                        <td><?= esc($type_item['loan_type_id']) ?></td>
                                        <td><?= esc($type_item['type']) ?></td>
                                        <td><?= esc($type_item['rate']) ?>%</td>
                                        <td><?= esc($type_item['formula_name']) ?></td>

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
    <!-- Add Member Modal -->
    <div class="modal fade" id="addTypeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">New Loan Type</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="<?= site_url('loans/type/create')?>" class="form-floating mb-3">
                        <?= csrf_field() ?>
                        <div class="mb-3">
                            <label for="first-name" class="col-form-label">Loan Name:</label>
                            <input type="text" class="form-control" id="first-name" name="loanName">
                        </div>
                        <div class="mb-3">
                            <label for="first-name" class="col-form-label">Interest Rate (%):</label>
                            <input type="number" step="0.1" class="form-control" id="first-name" name="rate">
                        </div>

                        <div class="mb-3">
                            <div class="form-floating mb-3">
                                <select class="form-select" id="calculationFormula" name="formula">
                                    <option value=""selected></option>
                                    <?php
                                    foreach ($formulas as $formula) :
                                    ?>
                                        <option value="<?= $formula['id']?>"><?= $formula['formula'] ?></option>
                                    <?php endforeach ?>
                                </select>
                                <label for="calculationFormula">Interest Calculation Formula:</label>
                            </div>
                        </div>


                        <div class="d-flex flex-row-reverse">
                            <input type="submit" value="Create" class="btn btn-info">
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>




    <?= $this->endSection() ?>