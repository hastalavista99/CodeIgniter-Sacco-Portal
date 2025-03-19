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

                <?php if (!empty($incomeStatement) && is_array($incomeStatement)) : ?>
                    <div class="table-responsive">
                        <h3>Revenue</h3>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Account</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($incomeStatement['income'] as $entry): ?>
                                    <tr>
                                        <td><?= esc($entry['account_name']) ?></td>
                                        <td><?= esc(number_format($entry['balance'], 2)) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                <tr>
                                    <td><strong>Total Revenue</strong></td>
                                    <td><strong><?= esc(number_format($incomeStatement['totals']['income'], 2)) ?></strong></td>
                                </tr>
                            </tbody>

                        </table>

                        <h3>Expenses</h3>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Account</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($incomeStatement['expense'] as $entry): ?>
                                    <tr>
                                        <td><?= esc($entry['account_name']) ?></td>
                                        <td><?= esc(number_format($entry['balance'], 2)) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                <tr>
                                    <td><strong>Total Expenses</strong></td>
                                    <td><strong><?= esc(number_format($incomeStatement['totals']['expense'], 2)) ?></strong></td>
                                </tr>
                            </tbody>

                        </table>

                        <h3>Net Profit</h3>
                        <p>
                            <strong>Net Income:</strong>
                            <?= esc(number_format($incomeStatement['net_profit'], 2)) ?>
                        </p>

                        <p>
                            <strong>Status:</strong>
                            <?php if ($incomeStatement['net_profit'] >= 0): ?>
                                ✅ Profitable
                            <?php else: ?>
                                ❌ Loss
                            <?php endif; ?>
                        </p>
                        <p>
                            <strong>Status:</strong>
                            <?php if ($totalDebit === $totalCredit): ?>
                                ✅ Balanced
                            <?php else: ?>
                                ❌ Not Balanced
                            <?php endif; ?>
                        </p>

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