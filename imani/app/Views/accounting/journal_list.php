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
        <div class="card shadow border-none my-2 px-2">
            <div class="d-flex justify-content-end mb-3">

                <div class="col-md-2 pt-3">
                    <div>

                        <a href="/accounting/journals/create" class="btn btn-primary mb-3"><i class="bi-journal-plus me-1"></i>Add Journal Entry</a>
                    </div>
                </div>

            </div>
            <div class="card-body px-0 pb-2">

                <?php if (!empty($entries) && is_array($entries)) : ?>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Transaction Date</th>
                                    <th>Reference</th>
                                    <th>Description</th>
                                    <th>Created By</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($entries as $entry): ?>
                                    <tr>
                                        <td><?= $entry['id'] ?></td>
                                        <td><?= $entry['transaction_date'] ?></td>
                                        <td><?= $entry['reference'] ?></td>
                                        <td><?= $entry['description'] ?></td>
                                        <td><?= $entry['created_by'] ?></td>
                                        <td>
                                            <a href="/accounting/journal/view/<?= $entry['id'] ?>" class="btn btn-info btn-sm">View</a>
                                            <a href="/accounting/journal/delete/<?= $entry['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

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
