<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?><?= esc($title) ?> <?= $this->endSection() ?>

<div class="row">
    <?= $this->section('content') ?>
    <?= $this->include('partials/sidebar') ?>
    <div class="col-lg-12">
        <?php
        if (!empty(session()->getFlashdata('success'))) {
        ?>
            <div class="alert alert-success alert-dismissible fade show">
                <i class="bi-check-circle-fill"></i> <?= session()->getFlashdata('success') ?>
                <button type="button" class="container btn-close" aria-label="Close" data-bs-dismiss="alert"></button>
            </div>
        <?php
        } else if (!empty(session()->getFlashdata('fail'))) {
        ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="bi-exclamation-triangle-fill"></i> <?= session()->getFlashdata('fail') ?>
                <button type="button" class="container btn-close" aria-label="Close" data-bs-dismiss="alert"></button>
            </div>
        <?php
        }
        ?>
        <?php if (session()->getFlashdata('errors')): ?>
            <div style="color: red;">
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <p><?= esc($error) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <div class="card shadow border-none my-2 px-2">

            <div class="card-body px-0 pb-2 mt-3">

                <?php if (!empty($trialBalance) && is_array($trialBalance)) : ?>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Account Name</th>
                                    <th>Debit</th>
                                    <th>Credit</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                <?php foreach ($trialBalance as $entry): ?>
                                    <tr>
                                        <td><?= esc($entry['account_name']) ?></td>
                                        <td><?= esc($entry['debit']) ?></td>
                                        <td><?= esc($entry['credit']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                <tr>
                                    <td><strong>Total</strong></td>
                                    <td><strong><?= esc(number_format($totalDebit, 2)) ?></strong></td>
                                    <td><strong><?= esc(number_format($totalCredit, 2)) ?></strong></td>
                                </tr>
                            </tbody>
                        </table>
                        <p><strong>Status:</strong>
                            <?php if (abs($totalDebit - $totalCredit) < 0.00001): ?>
                                ✅ Balanced
                            <?php else: ?>
                                ❌ Difference = <?php echo $totalDebit - $totalCredit?>
                            <?php endif; ?>
                        </p>

                        <div class="d-flex justify-content-center align-items-center mt-4">
                            <a href="<?= site_url('accounting/reports/trial-balance/pdf') ?>" target="_blank" class="btn btn-primary mb-3">
                                <i class="bi bi-filetype-pdf me-2"></i> Export to PDF
                            </a>
                        </div>

                    </div>

                <?php else : ?>

                    <h3>No Entries</h3>

                    <p>Unable to find any entries for you.</p>

                <?php endif ?>
            </div>
        </div>

    </div>
</div>


<?= $this->endSection() ?>