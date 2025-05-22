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
                <div class="d-flex justify-content-center">
                    <div class="d-flex flex-column justify-content-center align-items-center mb-2">
                        <a id="downloadBtn" href="<?= site_url('members/download-template') ?>" class="btn btn-info mb-2" onclick="handleDownload(event)">
                            <i class="bi-filetype-xlsx me-2"> <span id="downloadText"></i>Download Template</span>
                        </a>
                        <p class="small">Click the button above to download the Excel template for member import.</p>
                    </div>

                    <button class="btn btn-primary" type="button" disabled="" id="download-loading-btn" style="display: none;">
                        <span class="spinner-border spinner-border-sm" style="width: 16px !important; height: 16px;" role="status" aria-hidden="true"></span>
                        <i class="bi-filetype-xlsx me-2"></i>
                        Downloading...
                    </button>
                </div>



                <form action="<?= site_url('members/import') ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label for="import_file" class="form-label">Select Excel File (.xlsx)</label>
                        <input type="file" name="import_file" id="import_file" class="form-control" required>
                    </div>
                    <div class="d-flex justify-content-between mt-2">
                        <a class="btn btn-secondary " href="<?= site_url('/members') ?>"><i class="bi bi-arrow-left me-2"></i>Back to Members</a>
                        <button type="submit" class="btn btn-primary"><i class="bi bi-download me-2"></i>Import File</button>

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