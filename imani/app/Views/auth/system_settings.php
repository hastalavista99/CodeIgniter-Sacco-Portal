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
                    <p class="text-danger"><?= esc($error) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <div class="card shadow border-none my-2 px-2">

            <div class="card-body px-0 pb-2">
                <form method="post" enctype="multipart/form-data" action="<?= site_url('admin/settings')?>">
                    <?= csrf_field() ?>
                    <h4 class="my-3">Organization Profile</h4>


                    <div class="mb-3">
                        <label>Organization Name</label>
                        <input type="text" name="org_name" class="form-control" value="<?= esc($profile['org_name'] ?? '') ?>" required>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label>Phone</label>
                            <input type="text" name="phone" class="form-control" value="<?= esc($profile['phone'] ?? '') ?>">
                        </div>

                        <div class="mb-3 col-md-6">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" value="<?= esc($profile['email'] ?? '') ?>">
                        </div>
                    </div>

                    <div class="row">
                        <div class="mb-3 col-md-4">
                            <label>Postal Address</label>
                            <input type="text" name="postal_address" class="form-control" value="<?= esc($profile['postal_address'] ?? '') ?>">
                        </div>

                        <div class="mb-3 col-md-4">
                            <label>Physical Address</label>
                            <input type="text" name="physical_address" class="form-control" value="<?= esc($profile['physical_address'] ?? '') ?>">
                        </div>

                        <div class="mb-3 col-md-4">
                            <label>Logo</label>
                            <input type="file" name="logo" class="form-control">
                            <?php if (!empty($profile['logo'])): ?>
                                <img src="<?= base_url('writable/uploads/' . $profile['logo']) ?>" alt="Logo" height="80">
                            <?php endif; ?>
                        </div>
                    </div>


                    <hr>
                    <h4 class="mb-3">System Parameters</h4>
                    <div class="row">
                        <?php foreach ($parameters as $param): ?>
                        <div class="mb-3 col-md-3">
                            <label><?= esc($param['description']) ?> (<?= esc($param['param_key']) ?>)</label>
                            <input type="text" class="form-control" name="parameters[<?= esc($param['param_key']) ?>]" value="<?= esc($param['param_value']) ?>">
                        </div>
                    <?php endforeach; ?>
                    </div>
                    

                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-primary">Save Settings</button>
                    </div>
                </form>


            </div>
        </div>

    </div>
</div>


<?= $this->endSection() ?>