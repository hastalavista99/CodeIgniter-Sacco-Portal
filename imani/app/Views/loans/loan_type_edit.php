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
                        <input type="hidden" name="type-id" id="type-id" value="<?= esc($type['id'])?>">
                        <div class="col-md-3">
                            <label for="loan-name" class="form-label">Loan Name *</label>
                            <input type="text" name="loan-name" id="loan-name" class="form-control" value="<?= esc($type['loan_name'])?>">
                        </div>
                        <div class="col-md-3">
                            <label for="service-charge" class="form-label">Service Charge(%) *</label>
                            <input type="number" name="service-charge" id="service-charge" class="form-control" value="<?= esc($type['service_charge'])?>">
                        </div>
                        <div class="col-md-3">
                            <label for="interest-type" class="form-label">Loan Interest Type *</label>
                            <select name="interest-type" id="interest-type" class="form-select">
                                <option value="">Select Interest Type</option>
                                <?php foreach ($interestTypes as $intType): ?>
                                    <option value="<?= $intType['id'] ?>" <?php if($type['id'] === $type['id']) {
                                        ?>selected<?php
                                    } ?>><?= esc($intType['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="interest-rate" class="form-label">Interest Rate(%)</label>
                            <input type="number" name="interest-rate" id="interest-rate" class="form-control" step="0.01" value="<?= esc($type['interest_rate'])?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="insurance-premium" class="form-label">Insurance Premium(%)</label>
                            <input type="number" name="insurance-premium" id="insurance-premium" class="form-control" value="<?= esc($type['insurance_premium'])?>">
                        </div>
                        <div class="col-md-3">
                            <label for="crb" class="form-label">CRB Amount</label>
                            <input type="number" name="crb" id="crb" class="form-control" value="<?= esc($type['crb_amount'])?>">
                        </div>


                    </div>
                    <p>Main account code for loans is 110. Add additional account code in increments of 10</p>
                    <div class="col-md-3 mb-3">
                        <label for="account-code" class="form-label">Account Code(110...)</label>
                        <input type="number" name="account-code" id="account-code" class="form-control" value="<?= esc($type['account_code'])?>" disabled>
                    </div>
                    <h4>Default Limits</h4>
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="minimum-repayment-period" class="form-label">Minimum Repayment Period</label>
                            <input type="number" name="minimum-repayment-period" id="minimum-repayment-period" class="form-control" value="<?= esc($type['min_repayment_period'])?>">
                        </div>
                        <div class="col-md-3">
                            <label for="maximum-repayment-period" class="form-label">Maximum Repayment Period</label>
                            <input type="number" name="maximum-repayment-period" id="maximum-repayment-period" class="form-control" value="<?= esc($type['max_repayment_period'])?>">
                        </div>
                        <div class="col-md-3">
                            <label for="minimum-loan-limit" class="form-label">Minimum Loan Limit</label>
                            <input type="number" name="minimum-loan-limit" id="minimum-loan-limit" class="form-control" value="<?= esc($type['min_loan_limit'])?>">
                        </div>
                        <div class="col-md-3">
                            <label for="maximum-loan-limit" class="form-label">Maximum Loan Limit</label>
                            <input type="number" name="maximum-loan-limit" id="maximum-loan-limit" class="form-control" value="<?= esc($type['max_loan_limit'])?>">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" class="form-control" ><?= esc($type['description'])?></textarea>
                    </div>

                    <div class="d-flex justify-content-between mt-2">
                        <a href="<?= site_url('loans/type') ?>" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-2"></i>
                            Back to List
                        </a>
                        <button class="btn btn-info">
                            Submit
                            <i class="bi bi-arrow-right ms-2"></i>
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
                showLoadingState(true);
                const typeID = document.getElementById('type-id').value;

                const formData = new FormData(form);

                fetch(`/loans/type/update/${typeID}`, {
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
                        showLoadingState(false);
                        if (data.status === 'success') {
                            // Show success modal
                            showFeedbackModal(true, 'Success!', 'Loan details submitted successfully.');
                            // alert('Loan type created successfully!');
                            form.reset();
                        } else {
                            // Show error modal
                            let errorMessage = data.message || 'An error occurred';

                            // If we have validation errors, format them
                            if (data.errors) {
                                errorMessage += ':<br><ul>';
                                for (const field in data.errors) {
                                    errorMessage += `<li>${data.errors[field]}</li>`;
                                }
                                errorMessage += '</ul>';
                            }

                            showFeedbackModal(false, 'Error', errorMessage);
                        }
                    })
                    .catch(error => {
                        // Hide loading state
                        showLoadingState(false);

                        // Show error modal
                        showFeedbackModal(
                            false,
                            'Submission Error',
                            'An error occurred while submitting the form. Please try again.'
                        );
                        console.error('Error:', error);

                    });
                /**
                 * Shows or hides the loading overlay
                 * @param {boolean} show - True to show the loading overlay, false to hide it
                 */
                function showLoadingState(show) {
                    const loadingOverlay = document.getElementById('loadingOverlay');
                    if (loadingOverlay) {
                        loadingOverlay.style.display = show ? 'flex' : 'none';
                    }
                }

                /**
                 * Shows a feedback modal with success or error styling
                 * @param {boolean} isSuccess - True for success style, false for error style
                 * @param {string} title - The title to display in the modal header
                 * @param {string} message - The message to display in the modal body (can include HTML)
                 */
                function showFeedbackModal(isSuccess, title, message) {
                    const modal = document.getElementById('feedbackModal');
                    const modalTitle = document.getElementById('feedbackModalTitle');
                    const messageContainer = document.getElementById('feedbackMessage');
                    const iconContainer = modal.querySelector('.feedback-icon');
                    const modalContent = modal.querySelector('.modal-content');

                    // Set title and message
                    modalTitle.textContent = title;
                    messageContainer.innerHTML = message;

                    // Remove previous border classes
                    modalContent.classList.remove('success-border', 'error-border');

                    // Set icon based on success/error
                    if (isSuccess) {
                        iconContainer.innerHTML = '<div class="success-icon"><span class="succ display-4"><i class="bi bi-check-lg"><i/></span></div>';
                        modalContent.classList.add('success-border');
                    } else {
                        iconContainer.innerHTML = '<div class="error-icon"><span class="err display-4"><i class="bi bi-x"><i/></span></div>';
                        modalContent.classList.add('error-border');
                    }

                    // Show the modal
                    const bsModal = new bootstrap.Modal(modal);
                    bsModal.show();
                }

                // Function to show/hide loading state
                function showLoadingState(isLoading) {
                    const overlay = document.getElementById('loadingOverlay');
                    if (isLoading) {
                        overlay.style.display = 'flex';
                    } else {
                        overlay.style.display = 'none';
                    }
                }
            });
        });
    </script>


    <?= $this->endSection() ?>