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
                <form action="<?= site_url('members/import-transactions') ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <input type="hidden" name="tempFile" value="<?= esc($tempFile) ?>">

                    <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                            <thead>
                                <tr>
                                    <?php foreach ($headers as $letter => $header): ?>
                                        <th><?= esc($header) ?></th>
                                    <?php endforeach; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($rows as $row): ?>
                                    <tr>
                                        <?php foreach ($headers as $letter => $h): ?>
                                            <td><?= esc($row[$letter] ?? '') ?></td>
                                        <?php endforeach; ?>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <a href="<?= site_url('members/import-transactions-page') ?>" class="btn btn-secondary"><i class="bi bi-x-lg me-2"></i>Cancel</a>
                    <button type="submit" class="btn btn-success"><i class="bi bi-check-lg me-2"></i>Confirm & Import</button>

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