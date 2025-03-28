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
                            <div class="col-md-6">
                                <label for="firstName" class="form-label">First Name *</label>
                                <input type="text" class="form-control" id="firstName" required>
                            </div>
                            <div class="col-md-6">
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
                            <label for="idNumber" class="form-label">ID Number</label>
                            <input type="text" class="form-control" id="idNumber">
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="termsAccepted">
                            <label class="form-check-label" for="termsAccepted">
                                I accept the terms and conditions *
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

<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="successModalLabel">Success!</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center py-4">
                <div class="modal-icon success">
                    <i class="bi bi-check-circle-fill"></i>
                </div>
                <h4>Registration Successful!</h4>
                <p class="mb-4">Your information has been submitted successfully. We will contact you shortly.</p>
                <div class="d-flex justify-content-center">
                    <div class="bg-light rounded p-3 mb-3">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <i class="bi bi-envelope-check fs-3 text-success"></i>
                            </div>
                            <div class="text-start">
                                <p class="mb-0">Confirmation email sent to:</p>
                                <strong id="confirmationEmail">user@example.com</strong>
                            </div>
                        </div>
                    </div>
                </div>
                <p>Your reference number: <strong id="referenceNumber">REF-123456</strong></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-bs-dismiss="modal">Continue</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
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

        // Form submission
        form.addEventListener('submit', function(e) {
            console.log('form submitted')
            e.preventDefault();

           fetch('<?= site_url('') ?>', {
                method: 'POST',
                body: new FormData(form)
            })
            .then(response => response.json())
            .then(data => console.log(data))
            .catch(err => console.log(err));
            // const formData = new FormData(form);


        });
    });
</script>


<?= $this->endSection() ?>