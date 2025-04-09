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
            <div class="card-body px-0 pb-2 mt-3">
                <!-- Step Indicators -->
                <div class="row step-indicator mb-4">
                    <div class="col-4">
                        <div class="step active" id="step-indicator-1">1</div>
                        <div class="step-label">Personal Information</div>
                    </div>
                    <div class="col-4">
                        <div class="step" id="step-indicator-2">2</div>
                        <div class="step-label">Contact Details</div>
                    </div>
                    <div class="col-4">
                        <div class="step" id="step-indicator-3">3</div>
                        <div class="step-label">Beneficiaries</div>
                    </div>
                </div>

                <!-- Form -->
                <form id="memberForm">
                    <?= csrf_field() ?>
                    <!-- Step 1: Personal Information -->
                    <div class="form-step active" id="step-1">
                        <h5 class="mb-4">Step 1: Personal Information</h5>

                        <div class="row mb-3">
                            <div class="col-md-2">
                                <label for="memberNumber" class="form-label">Member No *</label>
                                <input type="text" class="form-control" id="memberNumber" value="<?= isset($member) ? esc($member['member_number']) : '' ?>" required>
                            </div>
                            <div class="col-md-5">
                                <label for="firstName" class="form-label">First Name *</label>
                                <input type="text" class="form-control" id="firstName" value="<?= isset($member) ? esc($member['first_name']) : '' ?>" required>
                            </div>
                            <div class="col-md-5">
                                <label for="lastName" class="form-label">Last Name *</label>
                                <input type="text" class="form-control" id="lastName" value="<?= isset($member) ? esc($member['last_name']) : '' ?>" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="dob" class="form-label">Date of Birth *</label>
                                <input type="date" class="form-control" id="dob" value="<?= isset($member) ? esc($member['dob']) : '' ?>" required>
                            </div>
                            <div class="col-md-4">
                                <label for="joinDate" class="form-label">Join Date *</label>
                                <input type="date" class="form-control" id="joinDate" value="<?= isset($member) ? esc($member['join_date']) : '' ?>" required>
                            </div>
                            <div class="col-md-4">
                                <label for="gender" class="form-label">Gender *</label>
                                <select class="form-select" id="gender" required>
                                    <option value="">Select Gender</option>
                                    <option value="male" <?= (isset($member) && $member['gender'] == 'male') ? 'selected' : '' ?>>Male</option>
                                    <option value="female" <?= (isset($member) && $member['gender'] == 'female') ? 'selected' : '' ?>>Female</option>
                                    <!-- <option value="other">Other</option>
                                    <option value="prefer-not-to-say">Prefer not to say</option> -->
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="nationality" class="form-label">Nationality *</label>
                                <input type="text" class="form-control" id="nationality" value="<?= isset($member) ? esc($member['nationality']) : '' ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="maritalStatus" class="form-label">Marital Status</label>
                                <select class="form-select" id="maritalStatus">
                                    <option value="">Select Marital Status</option>
                                    <option value="single" <?= (isset($member) && $member['marital_status'] == 'single') ? 'selected' : '' ?>>Single</option>
                                    <option value="married" <?= (isset($member) && $member['marital_status'] == 'married') ? 'selected' : '' ?>>Married</option>
                                    <option value="divorced" <?= (isset($member) && $member['marital_status'] == 'divorced') ? 'selected' : '' ?>>Divorced</option>
                                    <option value="widowed" <?= (isset($member) && $member['marital_status'] == 'widowed') ? 'selected' : '' ?>>Widowed</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="idNumber" class="form-label">ID Number</label>
                            <input type="text" class="form-control" id="idNumber" value="<?= isset($member) ? esc($member['id_number']) : '' ?>">
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="terms_accepted" checked>
                            <label class="form-check-label" for="terms_accepted">
                                I accept the terms and conditions *
                            </label>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-between mt-4">
                            <a class="btn btn-secondary " href="<?= site_url('/members') ?>"><i class="bi bi-arrow-left me-2"></i>Back to List</a>
                            <button type="button" class="btn btn-primary next-step" data-step="1">Next: Contact Details</button>
                        </div>
                    </div>

                    <!-- Step 2: Contact Details -->
                    <div class="form-step" id="step-2">
                        <h5 class="mb-4">Step 2: Contact Details</h5>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address *</label>
                            <input type="email" class="form-control" id="email" value="<?= isset($member) ? esc($member['email']) : '' ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="phoneNumber" class="form-label">Phone Number *</label>
                            <input type="tel" class="form-control" id="phoneNumber" value="<?= isset($member) ? esc($member['phone_number']) : '' ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="alternatePhone" class="form-label">Alternate Phone Number</label>
                            <input type="tel" class="form-control" id="alternatePhone" value="<?= isset($member) ? esc($member['alternate_phone']) : '' ?>">
                        </div>

                        <div class="mb-3">
                            <label for="streetAddress" class="form-label">Street Address *</label>
                            <input type="text" class="form-control" id="streetAddress" value="<?= isset($member) ? esc($member['street_address']) : '' ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="addressLine2" class="form-label">Address Line 2</label>
                            <input type="text" class="form-control" id="addressLine2" value="<?= isset($member) ? esc($member['address_line2']) : '' ?>">
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="city" class="form-label">Town/City *</label>
                                <input type="text" class="form-control" id="city" value="<?= isset($member) ? esc($member['city']) : '' ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="county" class="form-label">County*</label>
                                <input type="text" class="form-control" id="county" value="<?= isset($member) ? esc($member['county']) : '' ?>" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="zipCode" class="form-label">Zip/Postal Code *</label>
                                <input type="text" class="form-control" id="zipCode" value="<?= isset($member) ? esc($member['zip_code']) : '' ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="photo" class="form-label">Passport Photo</label>
                                <input type="file" class="form-control" id="photo" value="<?= isset($member) ? esc($member['photo_path']) : '' ?>">
                            </div>

                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-between mt-4">
                            <button type="button" class="btn btn-secondary prev-step" data-step="2">Previous: Personal Information</button>
                            <button type="button" class="btn btn-primary next-step" data-step="2">Next: Beneficiary Information</button>
                        </div>
                    </div>


                    <!-- Step 4: Additional Details -->
                    <div class="form-step" id="step-3">
                        <h5 class="mb-4">Step 3: Beneficiaries</h5>

                        <div class="row mb-3">
                            <div class="mb-3 col-md-6">
                                <label for="beneficiaryFirstName" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="beneficiaryFirstName" value="<?= isset($beneficiary) ? esc($beneficiary['first_name']) : '' ?>">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="beneficiaryLastName" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="beneficiaryLastName" value="<?= isset($beneficiary) ? esc($beneficiary['last_name']) : '' ?>">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="beneficiaryDOB" class="form-label">Date of Birth</label>
                                <input type="date" class="form-control" id="beneficiaryDOB" value="<?= isset($beneficiary) ? esc($beneficiary['dob']) : '' ?>">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="beneficiaryPhone" class="form-label">Phone Number</label>
                                <input type="tel" class="form-control" id="beneficiaryPhone" value="<?= isset($beneficiary) ? esc($beneficiary['phone_number']) : '' ?>">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="beneficiaryRelationship" class="form-label">Relationship to Client</label>
                                <input type="text" class="form-control" id="beneficiaryRelationship" value="<?= isset($beneficiary) ? esc($beneficiary['relationship']) : '' ?>">
                            </div>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="isBeneficiary" checked>
                            <label class="form-check-label" for="isBeneficiary">Is Beneficiary?</label>
                        </div>

                        <div class="mb-3">
                            <label for="entitlement_percentage" class="form-label">% Entitlement</label>
                            <input type="text" class="form-control" id="entitlement_percentage" value="<?= isset($beneficiary) ? esc($beneficiary['entitlement_percentage']) : '' ?>">
                        </div>
                        <?php if (isset($member)): ?>
                            <input type="hidden" name="member_id" value="<?= esc($member['id']) ?>">
                            <input type="hidden" name="is_edit" value="1">
                        <?php endif; ?>


                        <div class="d-grid gap-2 d-md-flex justify-content-md-between mt-4">
                            <button type="button" class="btn btn-secondary me-md-2 prev-step" data-step="3">Previous: Contact Details</button>
                            <button type="submit" class="btn btn-success"><?= isset($member) ? 'Update Member' : 'Submit Form' ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>



<script>
    document.addEventListener('DOMContentLoaded', function() {
        // handle dates
        let today = new Date().toISOString().split('T')[0]; // Get current date in YYYY-MM-DD format
        document.getElementById("dob").value = today;
        document.getElementById("joinDate").value = today; // Set default value
        // Form steps navigation
        const form = document.getElementById('memberForm');
        const steps = document.querySelectorAll('.form-step');
        const nextButtons = document.querySelectorAll('.next-step');
        const prevButtons = document.querySelectorAll('.prev-step');
        const stepIndicators = document.querySelectorAll('.step');

        // Next button click handler
        nextButtons.forEach(button => {
            button.addEventListener('click', function() {
                const currentStep = parseInt(this.getAttribute('data-step'));
                const currentStepElement = document.getElementById(`step-${currentStep}`);
                const nextStepElement = document.getElementById(`step-${currentStep + 1}`);

                // Basic validation for required fields
                const requiredFields = currentStepElement.querySelectorAll('[required]');
                let isValid = true;

                requiredFields.forEach(field => {
                    if (!field.value) {
                        isValid = false;
                        field.classList.add('is-invalid');
                    } else {
                        field.classList.remove('is-invalid');
                    }
                });

                if (isValid) {
                    // Move to next step
                    currentStepElement.classList.remove('active');
                    nextStepElement.classList.add('active');

                    // Update step indicators
                    document.getElementById(`step-indicator-${currentStep}`).classList.remove('active');
                    document.getElementById(`step-indicator-${currentStep}`).classList.add('completed');
                    document.getElementById(`step-indicator-${currentStep + 1}`).classList.add('active');

                    // Scroll to top of form
                    window.scrollTo({
                        top: form.offsetTop - 50,
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Previous button click handler
        prevButtons.forEach(button => {
            button.addEventListener('click', function() {
                const currentStep = parseInt(this.getAttribute('data-step'));
                const currentStepElement = document.getElementById(`step-${currentStep}`);
                const prevStepElement = document.getElementById(`step-${currentStep - 1}`);

                // Move to previous step
                currentStepElement.classList.remove('active');
                prevStepElement.classList.add('active');

                // Update step indicators
                document.getElementById(`step-indicator-${currentStep}`).classList.remove('active');
                document.getElementById(`step-indicator-${currentStep - 1}`).classList.remove('completed');
                document.getElementById(`step-indicator-${currentStep - 1}`).classList.add('active');

                // Scroll to top of form
                window.scrollTo({
                    top: form.offsetTop - 50,
                    behavior: 'smooth'
                });
            });
        });

        
        form.addEventListener('submit', function(e) {
            console.log('form submitted')
            e.preventDefault();
            showLoadingState(true);

            // Create FormData object
            const formData = new FormData();

            formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');

            // Personal Information (Step 1)
            formData.append('memberNumber', document.getElementById('memberNumber').value);
            formData.append('firstName', document.getElementById('firstName').value);
            formData.append('lastName', document.getElementById('lastName').value);
            formData.append('dob', document.getElementById('dob').value);
            formData.append('joinDate', document.getElementById('joinDate').value);
            formData.append('gender', document.getElementById('gender').value);
            formData.append('nationality', document.getElementById('nationality').value);
            formData.append('maritalStatus', document.getElementById('maritalStatus').value);
            formData.append('idNumber', document.getElementById('idNumber').value);
            formData.append('termsAccepted', document.getElementById('terms_accepted').checked ? '1' : '0');

            // Contact Details (Step 2)
            formData.append('email', document.getElementById('email').value);
            formData.append('phoneNumber', document.getElementById('phoneNumber').value);
            formData.append('alternatePhone', document.getElementById('alternatePhone').value);
            formData.append('streetAddress', document.getElementById('streetAddress').value);
            formData.append('addressLine2', document.getElementById('addressLine2').value);
            formData.append('city', document.getElementById('city').value);
            formData.append('county', document.getElementById('county').value);
            formData.append('zipCode', document.getElementById('zipCode').value);

            // Handle file upload
            const photoInput = document.getElementById('photo');
            if (photoInput.files.length > 0) {
                formData.append('photo', photoInput.files[0]);
            }

            // Beneficiary Details (Step 3)
            formData.append('beneficiaryFirstName', document.getElementById('beneficiaryFirstName').value);
            formData.append('beneficiaryLastName', document.getElementById('beneficiaryLastName').value);
            formData.append('beneficiaryDOB', document.getElementById('beneficiaryDOB').value);
            formData.append('beneficiaryPhone', document.getElementById('beneficiaryPhone').value);
            formData.append('beneficiaryRelationship', document.getElementById('beneficiaryRelationship').value);
            formData.append('isBeneficiary', document.getElementById('isBeneficiary').checked ? '1' : '0');
            formData.append('entitlementPercentage', document.getElementById('entitlement_percentage').value); // Note: ID seems incorrectly named

            // Check if this is an edit operation
            const memberIdInput = document.querySelector('input[name="member_id"]');
            const isEditInput = document.querySelector('input[name="is_edit"]');

            let url = '<?= site_url('/members/create') ?>';

            // If this is an edit operation, change the URL and add the member ID
            if (memberIdInput && isEditInput) {
                url = `/members/update/${memberIdInput.value}`;
                formData.append('member_id', memberIdInput.value);
                formData.append('is_edit', isEditInput.value);
            }


            // Send the data using fetch
            fetch(url, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    return response.json().then(data => {
                        // Add status to the data object
                        return {
                            ...data,
                            status: response.status
                        };
                    });
                })
                .then(data => {
                    // Hide loading state
                    showLoadingState(false);

                    if (data.success) {
                        // Show success modal
                        showFeedbackModal(true, 'Success!', 'Member details added successfully.');

                        // Redirect after a delay
                        setTimeout(() => {
                            window.location.href = '<?= site_url('/members') ?>';
                        }, 2000);
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
</script>


<?= $this->endSection() ?>