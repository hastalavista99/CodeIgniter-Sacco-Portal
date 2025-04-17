<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?><?= esc($title) ?><?= $this->endSection() ?>

<div class="row">
    <?= $this->section('content') ?>
    <?= $this->include('partials/sidebar') ?>
    <div class="col-lg-12">
        <?php if (!empty(session()->getFlashdata('success'))) : ?>
            <div class="alert alert-success alert-dismissible fade show">
                <i class="bi-check-circle-fill"></i> <?= session()->getFlashdata('success') ?>
                <button type="button" class="container btn-close" aria-label="Close" data-bs-dismiss="alert"></button>
            </div>
        <?php elseif (!empty(session()->getFlashdata('fail'))) : ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="bi-exclamation-triangle-fill"></i> <?= session()->getFlashdata('fail') ?>
                <button type="button" class="container btn-close" aria-label="Close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="card shadow border-none my-2 px-2">

            <div class="card-body px-0 py-2">
                <form id="loanTypeForm" class="mt-3">
                    <h4>Default Settings</h4>
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="loan-name" class="form-label">Loan Name *</label>
                            <input type="text" name="loan-name" id="loan-name" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label for="service-charge" class="form-label">Service Charge(%) *</label>
                            <input type="number" name="service-charge" id="service-charge" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label for="interest-type" class="form-label">Loan Interest Type *</label>
                            <select name="interest-type" id="interest-type" class="form-select">
                                <option value="">Select Interest Type</option>
                                <?php foreach ($interestTypes as $type): ?>
                                    <option value="<?= $type['id'] ?>"><?= esc($type['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="interest-rate" class="form-label">Interest Rate(%)</label>
                            <input type="number" name="interest-rate" id="interest-rate" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="insurance-premium" class="form-label">Insurance Premium(%)</label>
                            <input type="number" name="insurance-premium" id="insurance-premium" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label for="crb" class="form-label">CRB Amount</label>
                            <input type="number" name="crb" id="crb" class="form-control">
                        </div>
                        

                    </div>
                    <p>Main account code for loans is 110. Add additional account code in increments of 10</p>
                    <div class="col-md-3 mb-3">
                            <label for="account-code" class="form-label">Account Code(110...)</label>
                            <input type="number" name="account-code" id="account-code" class="form-control">
                        </div>
                    <h4>Default Limits</h4>
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="minimum-repayment-period" class="form-label">Minimum Repayment Period</label>
                            <input type="number" name="minimum-repayment-period" id="minimum-repayment-period" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label for="maximum-repayment-period" class="form-label">Maximum Repayment Period</label>
                            <input type="number" name="maximum-repayment-period" id="maximum-repayment-period" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label for="minimum-loan-limit" class="form-label">Minimum Loan Limit</label>
                            <input type="number" name="minimum-loan-limit" id="minimum-loan-limit" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label for="maximum-loan-limit" class="form-label">Maximum Loan Limit</label>
                            <input type="number" name="maximum-loan-limit" id="maximum-loan-limit" class="form-control">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" class="form-control"></textarea>
                    </div>

                    <div class="d-flex justify-content-end mt-2">
                        <button class="btn btn-info">
                            Submit
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('loanTypeForm');

            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(form);

                fetch('/loans/type/create', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            // 'Content-Type' is NOT needed for FormData
                            // If using CSRF protection, add it here
                            // 'X-CSRF-TOKEN': 'your-csrf-token'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            alert('Loan type created successfully!');
                            form.reset();
                        } else {
                            alert('Something went wrong: ' + (data.message || 'Unknown error'));
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Something went wrong. Check console for details.');
                    });
            });
        });
    </script>


    <?= $this->endSection() ?>