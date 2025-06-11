<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?>Unauthorized Access<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?= $this->include('partials/sidebar') ?>
<div class="container text-center mt-5">
    <div class="card shadow-lg border-danger p-5">
        <h1 class="text-danger display-4"><i class="bi bi-shield-lock"></i> 403</h1>
        <h2 class="text-dark mb-3">Access Denied</h2>
        <p class="lead text-muted">
            You do not have permission to access this page. Please contact your administrator if you believe this is a mistake.
        </p>
        <a href="<?= site_url('dashboard') ?>" class="btn btn-primary mt-3">
            <i class="bi bi-house-door"></i> Go to Dashboard
        </a>
    </div>
</div>

<?= $this->endSection() ?>
