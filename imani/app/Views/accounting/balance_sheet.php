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

                <?php if (!empty($balanceSheet) && is_array($balanceSheet)) : ?>
                    <div class="table-responsive">
                        <h3>Assets</h3>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Account Name</th>
                                    <th>Balance</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php foreach ($balanceSheet['asset'] as $entry): ?>
                                    <tr>
                                        <td><?= esc($entry['account_name']) ?></td>
                                        <td><?= esc(number_format($entry['balance'], 2)) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                <tr>
                                    <td>
                                        <strong>
                                            Total Assets
                                        </strong>
                                    </td>
                                    <td>
                                        <strong>
                                            <?= esc(number_format($balanceSheet['totals']['asset'], 2)) ?>
                                        </strong>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <h3>Liabilities</h3>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Account</th>
                                    <th>Balance</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($balanceSheet['liability'] as $entry): ?>
                                    <tr>
                                        <td><?= esc($entry['account_name']) ?></td>
                                        <td><?= esc(number_format($entry['balance'], 2)) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                <tr>
                                    <td>
                                        <strong>Total Liabilities</strong>
                                    </td>
                                    <td>
                                        <strong><?= esc(number_format($balanceSheet['totals']['liability'], 2)) ?></strong>
                                    </td>
                                </tr>
                            </tbody>

                        </table>

                        <h3>Equity</h3>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Account</th>
                                    <th>Balance</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($balanceSheet['equity'] as $entry): ?>
                                    <tr>
                                        <td><?= esc($entry['account_name']) ?></td>
                                        <td><?= esc(number_format($entry['balance'], 2)) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                <tr>
                                    <td>
                                        <strong>Total Equity</strong>
                                    </td>
                                    <td>
                                        <strong><?= esc(number_format($balanceSheet['totals']['equity'], 2)) ?></strong>
                                    </td>
                                </tr>
                            </tbody>

                        </table>
                        <h3>Check:</h3>
                        <p>
                            <strong>Total Assets:</strong>
                            <?= esc(number_format($balanceSheet['totals']['asset'], 2)) ?>
                        </p>
                        <p>
                            <strong>Total Liabilities + Equity:</strong>
                            <?= esc(number_format($balanceSheet['totals']['liability'] + $balanceSheet['totals']['equity'], 2)) ?>
                        </p>

                        <p>
                            <strong>
                                Status:
                            </strong>
                            <?php if ($balanceSheet['totals']['asset'] === ($balanceSheet['totals']['liability'] + $balanceSheet['totals']['equity'])): ?>
                                ✅ Balanced
                            <?php else: ?>
                                ❌ Not Balanced
                            <?php endif; ?>
                        </p>

                        <div class="d-flex justify-content-center align-items-center mt-4">
                            <a href="<?= site_url('accounting/reports/balance-sheet/pdf') ?>" target="_blank" class="btn btn-primary mb-3">
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