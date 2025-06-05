<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?><?= $title ?><?= $this->endSection() ?>


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
        <div class="card shadow border-none my-4 px-2">
            <div class="card-body px-0 pb-2">

                <?= form_open('accounting/reports/general-ledger') ?>
                <div class="row mt-3 mb-3 d-flex justify-content-between align-items-center">
                    <div class="col-md-3">
                        <label class="form-label">Start Date:</label>
                        <input type="date" name="start_date" class="form-control" required value="<?= $startDate ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">End Date:</label>
                        <input type="date" name="end_date" class="form-control" required value="<?= $endDate ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Account:</label>
                        <select name="account_id" class="form-select">
                            <option value="">-- All Accounts --</option>
                            <?php foreach ($accounts as $acc): ?>
                                <option value="<?= $acc['id'] ?>"><?= esc($acc['account_name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3 pt-4">
                        <button type="submit" class="btn btn-secondary ">Filter</button>
                    </div>
                </div>

                <?= form_close() ?>

                <hr>

                <h3>General Ledger</h3>

                <table border="1" width="100%" class="table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Reference</th>
                            <th>Description</th>
                            <th>Debit</th>
                            <th>Credit</th>
                            <th>Running Balance</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $balance = 0; ?>
                        <?php foreach ($entries as $entry): ?>
                            <?php
                            $balance += $entry['debit'] - $entry['credit'];
                            ?>
                            <tr>
                                <td><?= $entry['date'] ?></td>
                                <td><?= $entry['reference'] ?></td>
                                <td><?= $entry['description'] ?></td>
                                <td><?= number_format($entry['debit'], 2) ?></td>
                                <td><?= number_format($entry['credit'], 2) ?></td>
                                <td><?= number_format($balance, 2) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <div style="margin-top: 20px;">
                    <div class="d-flex gap-2 justify-content-center align-items-center mb-2">
                        <a href="<?= site_url('accounting/reports/general-ledger/pdf?start_date=' . $startDate . '&end_date=' . $endDate . '&account_id=' . $accountId) ?>" class="btn btn-danger"><i class="bi bi-filetype-pdf me-2"></i>Export PDF</a>
                        <a href="<?= site_url('accounting/reports/general-ledger/excel') ?>" class="btn btn-success" id="exportBtn" onclick="handleDownload(event)"><i class="bi bi-filetype-xlsx me-2"></i>Export Excel</a>
                        <button class="btn btn-success" type="button" disabled="" id="loading-btn" style="display: none;">
                            <span class="spinner-border spinner-border-sm" style="width: 16px !important; height: 16px;" role="status" aria-hidden="true"></span>
                            <i class="bi bi-filetype-xlsx me-2"></i>
                            Exporting
                        </button>
                    </div>
                </div>

                <script>
                    function handleDownload(event) {
                        const btn = document.getElementById('exportBtn');
                        const spinner = document.getElementById('loading-btn');

                        // Change UI to loading state
                        btn.style.display = 'none';
                        spinner.style.display = 'block';

                        // Let download continue normally, reset after short delay
                        setTimeout(() => {
                            spinner.style.display = 'none';
                            btn.style.display = 'inline-block';
                        }, 3000); // Adjust timing if needed
                    }
                </script>

            </div>
        </div>
    </div>

</div>


<?= $this->endSection() ?>