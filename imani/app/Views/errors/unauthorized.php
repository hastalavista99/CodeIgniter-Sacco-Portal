<?= $this->extend('layouts/main') ?> <!-- if you have a layout -->

<?= $this->section('content') ?>
<div class="container text-center mt-5">
    <h1 class="display-4 text-danger">Unauthorized Access</h1>
    <p class="lead">You do not have permission to access this page.</p>
    <a href="/dashboard" class="btn btn-primary mt-3">Go Back Dashboard</a>
</div>
<?= $this->endSection() ?>
