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
                    <?= csrf_field()?>
                    <!-- Step 1: Personal Information -->
                    <div class="form-step active" id="step-1">
                        <h5 class="mb-4">Step 1: Personal Information</h5>

                        <div class="row mb-3">
                            <div class="col-md-2">
                                <label for="memberNumber" class="form-label">Member No *</label>
                                <input type="text" class="form-control" id="memberNumber" required>
                            </div>
                            <div class="col-md-5">
                                <label for="firstName" class="form-label">First Name *</label>
                                <input type="text" class="form-control" id="firstName" required>
                            </div>
                            <div class="col-md-5">
                                <label for="lastName" class="form-label">Last Name *</label>
                                <input type="text" class="form-control" id="lastName" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="dob" class="form-label">Date of Birth *</label>
                                <input type="date" class="form-control" id="dob" required>
                            </div>
                            <div class="col-md-4">
                                <label for="joinDate" class="form-label">Join Date *</label>
                                <input type="date" class="form-control" id="joinDate" required>
                            </div>
                            <div class="col-md-4">
                                <label for="gender" class="form-label">Gender *</label>
                                <select class="form-select" id="gender" required>
                                    <option value="">Select Gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>
                                    <option value="prefer-not-to-say">Prefer not to say</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="nationality" class="form-label">Nationality *</label>
                                <input type="text" class="form-control" id="nationality" required>
                            </div>
                            <div class="col-md-6">
                                <label for="maritalStatus" class="form-label">Marital Status</label>
                                <select class="form-select" id="maritalStatus">
                                    <option value="">Select Marital Status</option>
                                    <option value="single">Single</option>
                                    <option value="married">Married</option>
                                    <option value="divorced">Divorced</option>
                                    <option value="widowed">Widowed</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="idNumber" class="form-label">Member Number</label>
                            <input type="text" class="form-control" id="idNumber">
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="isActive">
                            <label class="form-check-label" for="isActive">
                                Active?
                            </label>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a class="btn btn-secondary next-step" href="<?= site_url('/members') ?>">Back to List</a>
                            <button type="button" class="btn btn-primary next-step" data-step="1">Next: Contact Details</button>
                        </div>
                    </div>

                    <!-- Step 2: Contact Details -->
                    <div class="form-step" id="step-2">
                        <h5 class="mb-4">Step 2: Contact Details</h5>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address *</label>
                            <input type="email" class="form-control" id="email" required>
                        </div>

                        <div class="mb-3">
                            <label for="phoneNumber" class="form-label">Phone Number *</label>
                            <input type="tel" class="form-control" id="phoneNumber" required>
                        </div>
                        <div class="mb-3">
                            <label for="alternatePhone" class="form-label">Alternate Phone Number</label>
                            <input type="tel" class="form-control" id="alternatePhone">
                        </div>

                        <div class="mb-3">
                            <label for="streetAddress" class="form-label">Street Address *</label>
                            <input type="text" class="form-control" id="streetAddress" required>
                        </div>

                        <div class="mb-3">
                            <label for="addressLine2" class="form-label">Address Line 2</label>
                            <input type="text" class="form-control" id="addressLine2">
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="city" class="form-label">Town/City *</label>
                                <input type="text" class="form-control" id="city" required>
                            </div>
                            <div class="col-md-6">
                                <label for="county" class="form-label">County*</label>
                                <input type="text" class="form-control" id="county" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="zipCode" class="form-label">Zip/Postal Code *</label>
                                <input type="text" class="form-control" id="zipCode" required>
                            </div>
                            <div class="col-md-6">
                                <label for="photo" class="form-label">Passport Photo</label>
                                <input type="file" class="form-control" id="photo">
                            </div>

                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <button type="button" class="btn btn-secondary prev-step" data-step="2">Previous: Personal Information</button>
                            <button type="button" class="btn btn-primary next-step" data-step="2">Next: Professional Info</button>
                        </div>
                    </div>


                    <!-- Step 4: Additional Details -->
                    <div class="form-step" id="step-3">
                        <h5 class="mb-4">Step 3: Beneficiaries</h5>

                        <div class="row mb-3">
                            <div class="mb-3 col-md-6">
                                <label for="beneficiaryFirstName" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="beneficiaryFirstName">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="beneficiaryLastName" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="beneficiaryLastName">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="beneficiaryDOB" class="form-label">Date of Birth</label>
                                <input type="date" class="form-control" id="beneficiaryDOB">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="beneficiaryPhone" class="form-label">Phone Number</label>
                                <input type="tel" class="form-control" id="beneficiaryPhone">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="beneficiaryRelationship" class="form-label">Relationship to Client</label>
                                <input type="text" class="form-control" id="beneficiaryRelationship">
                            </div>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="isBeneficiary">
                            <label class="form-check-label" for="isBeneficiary">Is Beneficiary?</label>
                        </div>

                        <div class="mb-3">
                            <label for="emergencyContactName" class="form-label">% Entitlement</label>
                            <input type="text" class="form-control" id="emergencyContactName">
                        </div>


                        <div class="d-flex justify-content-between mt-4">
                            <button type="button" class="btn btn-secondary prev-step" data-step="4">Previous: Professional Info</button>
                            <button type="submit" class="btn btn-success">Submit Form</button>
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

        createFeedbackModal();
        form.addEventListener('submit', function(e) {
            console.log('form submitted')
            e.preventDefault();

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
            formData.append('isActive', document.getElementById('isActive').checked ? '1' : '0');

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
            formData.append('entitlementPercentage', document.getElementById('emergencyContactName').value); // Note: ID seems incorrectly named

            // Send the data using fetch
            fetch('<?= site_url('/members/create') ?>', {
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
                        showFeedbackModal(true, 'Success!', 'Member created successfully.');

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

        // Function to create the feedback modal elements
        function createFeedbackModal() {
            // Check if modal already exists
            if (document.getElementById('feedbackModal')) {
                return;
            }

            // Create modal container
            const modalContainer = document.createElement('div');
            modalContainer.id = 'feedbackModal';
            modalContainer.className = 'modal fade';
            modalContainer.tabIndex = '-1';
            modalContainer.setAttribute('aria-hidden', 'true');

            // Create modal HTML
            modalContainer.innerHTML = `
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="feedbackModalTitle">Notification</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <div class="feedback-icon mb-4">
                            <!-- Icon will be inserted here -->
                        </div>
                        <div id="feedbackMessage"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
                    </div>
                </div>
            </div>
        `;

            // Add modal to body
            document.body.appendChild(modalContainer);

            // Add CSS for icons
            const style = document.createElement('style');
            style.textContent = `
            .success-icon {
                width: 80px;
                height: 80px;
                margin: 0 auto;
                border-radius: 50%;
                border: 4px solid #4CAF50;
                padding: 0;
                position: relative;
                box-sizing: content-box;
            }
            .success-icon:before {
                content: '';
                position: absolute;
                width: 5px;
                height: 30px;
                background-color: #4CAF50;
                left: 28px;
                top: 12px;
                border-radius: 2px;
                transform: rotate(45deg);
            }
            .success-icon:after {
                content: '';
                position: absolute;
                width: 5px;
                height: 55px;
                background-color: #4CAF50;
                left: 46px;
                top: 3px;
                border-radius: 2px;
                transform: rotate(-45deg);
            }
            .error-icon {
                width: 80px;
                height: 80px;
                margin: 0 auto;
                border-radius: 50%;
                border: 4px solid #F44336;
                padding: 0;
                position: relative;
                box-sizing: content-box;
            }
            .error-icon:before {
                content: '';
                position: absolute;
                width: 5px;
                height: 60px;
                background-color: #F44336;
                left: 37px;
                top: 10px;
                border-radius: 2px;
                transform: rotate(45deg);
            }
            .error-icon:after {
                content: '';
                position: absolute;
                width: 5px;
                height: 60px;
                background-color: #F44336;
                left: 37px;
                top: 10px;
                border-radius: 2px;
                transform: rotate(-45deg);
            }
            .spinner-icon {
                width: 80px;
                height: 80px;
                margin: 0 auto;
                border-radius: 50%;
                border: 4px solid #f3f3f3;
                border-top: 4px solid #3498db;
                animation: spin 1s linear infinite;
            }
            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
        `;
            document.head.appendChild(style);

            // Create loading overlay
            const loadingOverlay = document.createElement('div');
            loadingOverlay.id = 'loadingOverlay';
            loadingOverlay.style.cssText = `
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 9999;
            justify-content: center;
            align-items: center;
        `;

            loadingOverlay.innerHTML = `
            <div class="spinner-icon"></div>
        `;

            document.body.appendChild(loadingOverlay);
        }

        // Function to show the feedback modal
        function showFeedbackModal(isSuccess, title, message) {
            const modal = document.getElementById('feedbackModal');
            const modalTitle = document.getElementById('feedbackModalTitle');
            const messageContainer = document.getElementById('feedbackMessage');
            const iconContainer = modal.querySelector('.feedback-icon');

            // Set title and message
            modalTitle.textContent = title;
            messageContainer.innerHTML = message;

            // Set icon based on success/error
            if (isSuccess) {
                iconContainer.innerHTML = '<div class="success-icon"></div>';
                modal.querySelector('.modal-content').style.borderTop = '5px solid #4CAF50';
            } else {
                iconContainer.innerHTML = '<div class="error-icon"></div>';
                modal.querySelector('.modal-content').style.borderTop = '5px solid #F44336';
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