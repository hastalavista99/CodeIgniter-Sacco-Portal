<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?><?= $title ?> <?= $this->endSection() ?>



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


            <div class="card-body px-0 pb-2">

                <form action="<?= site_url('employers/update/' . $employer['employer_id']) ?>" method="post" class="row g-3 mt-3">
                    <div class="col-md-6">
                        <label class="form-label">Employer Name *</label>
                        <input type="text" name="employer_name" value="<?= esc($employer['employer_name']) ?>" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Contact Person</label>
                        <input type="text" name="contact_person" value="<?= esc($employer['contact_person']) ?>" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Phone Number</label>
                        <input type="text" name="phone_number" value="<?= esc($employer['phone_number']) ?>" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" value="<?= esc($employer['email']) ?>" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Postal Address</label>
                        <input type="text" name="postal_address" value="<?= esc($employer['postal_address']) ?>" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Physical Address</label>
                        <input type="text" name="physical_address" value="<?= esc($employer['physical_address']) ?>" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Check-off Code</label>
                        <input type="text" name="checkoff_code" value="<?= esc($employer['checkoff_code']) ?>" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Deduction Frequency</label>
                        <select name="deduction_frequency" class="form-select">
                            <option value="Monthly" <?= $employer['deduction_frequency'] == 'Monthly' ? 'selected' : '' ?>>Monthly</option>
                            <option value="Bi-Weekly" <?= $employer['deduction_frequency'] == 'Bi-Weekly' ? 'selected' : '' ?>>Bi-Weekly</option>
                            <option value="Weekly" <?= $employer['deduction_frequency'] == 'Weekly' ? 'selected' : '' ?>>Weekly</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="Active" <?= $employer['status'] == 'Active' ? 'selected' : '' ?>>Active</option>
                            <option value="Inactive" <?= $employer['status'] == 'Inactive' ? 'selected' : '' ?>>Inactive</option>
                        </select>
                    </div>

                    <div class="col-12">
                        <button class="btn btn-primary" type="submit">Update Employer</button>
                        <a href="<?= site_url('employers') ?>" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>