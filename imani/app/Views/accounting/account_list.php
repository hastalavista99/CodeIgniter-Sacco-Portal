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
            <div class="d-flex justify-content-end mb-3">

                <div class="col-md-2 pt-3">
                    <div>
                        <a href="<?= site_url('/accounting/accounts/create')?>" class="btn btn-primary mb-3"><i class="bi-journal-plus me-1"></i>Add Account</a>
                    </div>
                </div>

            </div>
            <div class="card-body px-0 pb-2">

                <?php if (!empty($accounts) && is_array($accounts)) : ?>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Account Name</th>
                                    <th>Account Code</th>
                                    <th>Account Type</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($accounts as $account): ?>
                                    <tr>
                                        <td><?= $account['id'] ?></td>
                                        <td><?= $account['account_name'] ?></td>
                                        <td><?= $account['account_code'] ?></td>
                                        <td><?= $account['category'] ?></td>
                                        <td>
                                            <a href="<?= site_url('/accounting/accounts/edit/')?><?= $account['id'] ?>" class="btn btn-info btn-sm">Edit</a>
                                            <a href="<?= site_url('/accounting/accounts/delete/')?><?= $account['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

                    </div>

                <?php else : ?>

                    <h3>No Accounts</h3>

                    <p>Unable to find any accounts for you.</p>

                <?php endif ?>
            </div>
        </div>

    </div>
</div>
<?= $this->endSection() ?>