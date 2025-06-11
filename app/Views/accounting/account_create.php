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
            <div class="card-body px-0 pb-2">
                <form action="<?= site_url('accounting/accounts/store') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="row mt-3">
                        <div class="col-2 mb-3">
                            <label for="account_code" class="form-label">Account Code:</label>
                            <input type="text" id="account_code" class="form-control" name="account_code" required>
                        </div>
                        <div class="col-4 mb-3">
                            <label for="account_name" class="form-label">Account Name:</label>
                            <input type="text" id="account_name" class="form-control" name="account_name" required>
                        </div>
                        <div class="col-3 mb-3">
                            <label for="account_type" class="form-label">Account Type:</label>
                            <select id="account_type" class="form-select" name="account_type" required>
                                <option value="asset">Asset</option>
                                <option value="liability">Liability</option>
                                <option value="equity">Equity</option>
                                <option value="income">Income</option>
                                <option value="expense">Expense</option>
                            </select>
                        </div>
                        <div class="col-3 mb-3">
                            <label for="account_contra" class="form-label">Default Contra Account:</label>
                            <select id="account_contra" class="form-select" name="account_contra" required>
                                <option value="">-- Select Account --</option>
                                <?php
                                if (!empty($accounts)) {
                                    foreach ($accounts as $account) {
                                ?>
                                        <option value="<?= $account['id'] ?>"><?= $account['account_name'] ?></option>
                                    <?php
                                    }
                                } else { ?>
                                    <option value="">No Accounts Available</option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="d-flex justify-content-evenly">
                        <a href="<?= site_url('accounting/accounts/page') ?>" class="btn btn-info"><i class="bi-arrow-left me-1"></i>Back to List</a>
                        <button type="submit" class="btn btn-success"><i class="bi-journal-check me-1"></i>Create Account</button>

                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
<?= $this->endSection() ?>