<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?>Upload Success<?= $this->endSection() ?>

<div class="row">
    <?= $this->section('content') ?>

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
                <h1 class="text-success">Success</h1>
            </div>
        </div>
    </div>


    <?= $this->endSection() ?>