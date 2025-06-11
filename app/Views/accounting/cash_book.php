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

                <div class="container mt-4">
                    <h3>Cashbook Report</h3>

                    <form method="get" class="row g-3 mb-4">
                        <div class="col-md-3">
                            <label>Start Date</label>
                            <input type="date" name="start_date" class="form-control" value="<?= esc($startDate) ?>">
                        </div>
                        <div class="col-md-3">
                            <label>End Date</label>
                            <input type="date" name="end_date" class="form-control" value="<?= esc($endDate) ?>">
                        </div>
                        <div class="col-md-3">
                            <label>Cash/Bank Account</label>
                            <select name="account_id" class="form-select">
                                <option value="">-- All Cash Accounts --</option>
                                <?php foreach ($cashAccounts as $acc): ?>
                                    <option value="<?= $acc['id'] ?>" <?= $selectedAccount == $acc['id'] ? 'selected' : '' ?>>
                                        <?= esc($acc['account_name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary">Generate</button>
                        </div>
                    </form>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Reference</th>
                                <th>Description</th>
                                <th>Cash In</th>
                                <th>Cash Out</th>
                                <th>Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $balance = 0;
                            foreach ($entries as $entry):
                                $cashIn = floatval($entry['debit']);
                                $cashOut = floatval($entry['credit']);
                                $balance += $cashIn - $cashOut;
                            ?>
                                <tr>
                                    <td><?= esc($entry['date']) ?></td>
                                    <td><?= esc($entry['reference']) ?></td>
                                    <td><?= esc($entry['description']) ?></td>
                                    <td><?= number_format($cashIn, 2) ?></td>
                                    <td><?= number_format($cashOut, 2) ?></td>
                                    <td><?= number_format($balance, 2) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center align-items-center mt-4">
                    <a href="<?= site_url('accounting/reports/cashbook/pdf?start='.$startDate.'&end='.$endDate) ?>" target="_blank" class="btn btn-primary mb-3">
                    <i class="bi bi-filetype-pdf me-2"></i> Export to PDF
                </a>
                </div>
                

            </div>
        </div>

    </div>
</div>


<?= $this->endSection() ?>