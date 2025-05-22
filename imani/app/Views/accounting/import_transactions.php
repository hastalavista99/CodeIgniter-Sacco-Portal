<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?><?= esc($title) ?> <?= $this->endSection() ?>

<div class="row">
    <?= $this->section('content') ?>
    <?= $this->include('partials/sidebar') ?>
    <div class="col-lg-12">
        <!-- <h4>Import Members from Excel</h4> -->

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('message')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('message') ?></div>
        <?php endif; ?>

        <div class="card shadow border-none my-2 px-2">
            <div class="card-body px-0 pb-2 mt-3">
                <div class="mb-4">
                    <h6>Download Template:</h6>
                    <div class="d-flex gap-2 flex-wrap">
                        <a href="<?= site_url('members/download-savings-template') ?>" class="btn btn-outline-info btn-sm">Savings Template</a>
                        <a href="<?= site_url('members/download-shares-template') ?>" class="btn btn-outline-primary btn-sm">Shares Template</a>
                        <a href="<?= site_url('members/download-loans-template') ?>" class="btn btn-outline-warning btn-sm">Loan Repayments</a>
                        <a href="<?= site_url('members/download-entrance-fee-template') ?>" class="btn btn-outline-success btn-sm">Entrance Fees</a>
                    </div>
                </div>

                <form action="<?= site_url('members/preview-transactions') ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label for="import_file" class="form-label">Select Excel File (.xlsx)</label>
                        <input type="file" name="import_file" id="import_file" class="form-control" required>
                    </div>

                    <div class="d-flex justify-content-between mt-2">
                        <a class="btn btn-secondary " href="<?= site_url('/accounting/remittances') ?>"><i class="bi bi-arrow-left me-2"></i>Back to Remittances</a>
                        <button type="submit" class="btn btn-primary"><i class="bi bi-download me-2"></i>Upload and Preview</button>
                    </div>
                </form>
    
            </div>
        </div>
    </div>
</div>


<script>
    function handleDownload(event) {
        const btn = document.getElementById('downloadBtn');
        const spinner = document.getElementById('download-loading-btn');

        // Change UI to loading state
        btn.style.display = 'none';
        spinner.style.display = 'block';

        // Let download continue normally, reset after short delay
        setTimeout(() => {
            spinner.style.display = 'none';
            btn.style.display = 'inline-block';
        }, 4000); // Adjust timing if needed
    }
</script>


<?= $this->endSection() ?>