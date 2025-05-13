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
                <form action="<?= site_url('accounting/accounts/update/' . $account['id']) ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="row mt-3">
                        <div class="mb-3 col-4">
                            <label for="account_name" class="form-label">Account Name:</label>
                            <input type="text" id="account_name" class="form-control" name="account_name" value="<?= esc($account['account_name']) ?>" required>
                        </div>
                        <div class="mb-3 col-4">
                            <label for="account_type" class="form-label">Account Type:</label>
                            <select id="account_type" class="form-select" name="account_type" required>
                                <option value="asset" <?= $account['category'] == 'asset' ? 'selected' : '' ?>>Asset</option>
                                <option value="liability" <?= $account['category'] == 'liability' ? 'selected' : '' ?>>Liability</option>
                                <option value="equity" <?= $account['category'] == 'equity' ? 'selected' : '' ?>>Equity</option>
                                <option value="income" <?= $account['category'] == 'income' ? 'selected' : '' ?>>Income</option>
                                <option value="expense" <?= $account['category'] == 'expense' ? 'selected' : '' ?>>Expense</option>
                            </select>
                        </div>
                        
                    </div>

                    <div class="d-flex justify-content-evenly">
                        <a href="<?= site_url('accounting/accounts/page') ?>" class="btn btn-info"><i class="bi-arrow-left me-1"></i>Back to List</a>
                        <button type="submit" class="btn btn-success"><i class="bi-pencil-square me-1"></i>Update Account</button>

                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
<?= $this->endSection() ?>