<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?>Dashboard <?= $this->endSection() ?>


<div class="row">
    <?= $this->section('content') ?>
    <?= $this->include('partials/sidebar') ?>
    <div class="col-lg-12">
        <div class="card shadow border-none my-2 px-2">

            <div class="d-flex justify-content-between mb-3">

                <canvas class="my-4 w-100" id="myChart" width="900" height="380"></canvas>


            </div>
            
        </div>
    </div>
</div>
</div>
<?= $this->endSection() ?>