<?php

use CodeIgniter\HTTP\SiteURI;
?>
<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?><?= $title ?><?= $this->endSection() ?>


<div class="row">
    <?= $this->section('content') ?>

    <?= $this->include('partials/sidebar') ?>
    <div class="col-lg-12 ">
        <div class="card shadow border-none my-2 px-2">
            <div class="card-body px-0 pb-2">
                <div class="row mb-3">
                    <h2>Member Details</h2>
                    <form id="memberForm">
                        <div class="col-md-6">
                            <label for="member-number" class="form-label">Member Number</label>
                            <input type="text" name="member-number" id="member-number" class="form-control" required>
                        </div>
                        <button type="button" id="fetchMemberBtn" class="btn btn-primary mt-2">Fetch Member</button>
                    </form>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="member-name" class="form-label">Member Name</label>
                        <input type="text" name="member-name" id="member-name" class="form-control" disabled>
                    </div>
                    <div class="col-md-6">
                        <label for="member-mobile" class="form-label">Mobile Number</label>
                        <input type="text" name="member-mobile" id="member-mobile" class="form-control" disabled>
                    </div>
                </div>
                <div class="row step-indicator mb-4">
                    <div class="col-4">
                        <div class="step active" id="step-indicator-1"><i class="bi bi-pencil-square"></i></div>
                        <div class="step-label">Loan Information</div>
                    </div>
                    <div class="col-4">
                        <div class="step" id="step-indicator-2"><i class="bi bi-people"></i></div>
                        <div class="step-label">Guarantors</div>
                    </div>
                    <div class="col-4">
                        <div class="step" id="step-indicator-3"><i class="bi bi-list-check"></i></div>
                        <div class="step-label">Details Confirmation</div>
                    </div>
                </div>

                <!-- Form -->
                <form id="loanApplicationForm">
                    <!-- Step 1: Loan Information -->
                    <div class="form-step active" id="step-1">
                        <h5 class="mb-4">Step 1: Loan Information</h5>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="loan_type" class="form-label">Loan Type *</label>
                                <select class="form-select" id="loan_type" required>
                                    <option value="">Select Loan</option>
                                    <?php foreach ($loanTypes as $type): ?>
        <option value="<?= $type['id'] ?>"><?= esc($type['loan_name']) ?></option>
    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="interest_method" class="form-label">Interest Method *</label>
                                <select class="form-select" id="interest_method" required>
                                    <option value="">Select Interest Method</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>
                                    <option value="prefer-not-to-say">Prefer not to say</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="principal" class="form-label">Principal Amount *</label>
                                <input type="number" class="form-control" id="principal" required>
                            </div>
                            <div class="col-md-4">
                                <label for="principal" class="form-label">Repayment Period(Months) *</label>
                                <input type="number" class="form-control" id="principal" required>
                            </div>
                            <div class="col-md-4">
                                <label for="date" class="form-label">Request Date *</label>
                                <input type="date" class="form-control" id="date" required>
                            </div>
                        </div>
                        <h4>Repayment Details</h4>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label for="principal" class="form-label">Total Loan Amount *</label>
                                <input type="number" class="form-control" id="principal" >
                            </div>
                            <div class="col-md-3">
                                <label for="principal" class="form-label">Total Interest *</label>
                                <input type="number" class="form-control" id="principal" >
                            </div>
                            <div class="col-md-3">
                                <label for="fees" class="form-label">Fees & Charges *</label>
                                <input type="number" class="form-control" id="fees">
                            </div>
                            <div class="col-md-3">
                                <label for="disburse_amount" class="form-label">Disburse Amount *</label>
                                <input type="number" class="form-control" id="disburse_amount" >
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button type="button" class="btn btn-primary next-step" data-step="1">Next: Guarantor Details</button>
                        </div>
                    </div>

                    <!-- Step 2: Guarantor Details -->
                    <div class="form-step" id="step-2">
                        <h5 class="mb-4">Step 2: Guarantor Details</h5>

                        <div id="guarantorForm">
                            <div class="col-md-6">
                                <label for="guarantor-number" class="form-label">Member Number</label>
                                <input type="text" name="guarantor-number" id="guarantor-number" class="form-control" required>
                            </div>
                            <button type="button" id="fetchguarantorBtn" class="btn btn-primary mt-2">Fetch guarantor</button>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="guarantor-name" class="form-label">Guarantor Name</label>
                                <input type="text" name="guarantor-name" id="guarantor-name" class="form-control" disabled>
                            </div>
                            <div class="col-md-4">
                                <label for="guarantor-mobile" class="form-label">Mobile Number</label>
                                <input type="text" name="guarantor-mobile" id="guarantor-mobile" class="form-control" disabled>
                            </div>
                            <div class="col-md-4">
                                <label for="guarantor-amount" class="form-label">Guaranteed Amount</label>
                                <input type="number" name="guarantor-amount" id="guarantor-amount" class="form-control">
                            </div>
                        </div>

                        <div class="d-flex align-content-end justify-content-end m-2">
                            <button class="btn btn-primary" id="addBtn">Add to List</button>
                        </div>

                        <table class="table" id="guarantorTable">
                            <thead>
                                <tr>
                                    <th scope="col">Member No.</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Mobile</th>
                                    <th scope="col">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-between mt-4">
                            <button type="button" class="btn btn-secondary prev-step" data-step="2">Previous: Loan Information</button>
                            <button type="button" class="btn btn-primary next-step" data-step="2">Next: Details Confirmation</button>
                        </div>
                    </div>



                    <!-- Step 3: Details Confirmation -->
                    <div class="form-step" id="step-3">
                        <h5 class="mb-4">Step 3: Details Confirmation</h5>

                        <div class="mb-3">
                            <label for="howDidYouHear" class="form-label">How did you hear about us?</label>
                            <select class="form-select" id="howDidYouHear">
                                <option value="">Select an option</option>
                                <option value="search-engine">Search Engine</option>
                                <option value="social-media">Social Media</option>
                                <option value="friend">Friend/Family</option>
                                <option value="advertisement">Advertisement</option>
                                <option value="other">Other</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="interestReason" class="form-label">Why are you interested?</label>
                            <textarea class="form-control" id="interestReason" rows="2"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="preferences" class="form-label">Preferences</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="prefersEmail">
                                <label class="form-check-label" for="prefersEmail">Email updates</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="prefersSMS">
                                <label class="form-check-label" for="prefersSMS">SMS notifications</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="prefersNewsletter">
                                <label class="form-check-label" for="prefersNewsletter">Monthly newsletter</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="prefersPromo">
                                <label class="form-check-label" for="prefersPromo">Promotional offers</label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="availabilityDate" class="form-label">Available Start Date</label>
                            <input type="date" class="form-control" id="availabilityDate">
                        </div>

                        <div class="mb-3">
                            <label for="emergencyContactName" class="form-label">Emergency Contact Name</label>
                            <input type="text" class="form-control" id="emergencyContactName">
                        </div>

                        <div class="mb-3">
                            <label for="emergencyContactRelation" class="form-label">Relationship to Emergency Contact</label>
                            <input type="text" class="form-control" id="emergencyContactRelation">
                        </div>

                        <div class="mb-3">
                            <label for="emergencyContactPhone" class="form-label">Emergency Contact Phone</label>
                            <input type="tel" class="form-control" id="emergencyContactPhone">
                        </div>

                        <div class="mb-3">
                            <label for="additionalInfo" class="form-label">Additional Information</label>
                            <textarea class="form-control" id="additionalInfo" rows="3"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="dietaryRestrictions" class="form-label">Dietary Restrictions</label>
                            <input type="text" class="form-control" id="dietaryRestrictions">
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-between mt-4">
                            <button type="button" class="btn btn-secondary prev-step" data-step="3">Previous: Guarantor Info</button>
                            <button type="submit" class="btn btn-success">Submit Form</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Form steps navigation
        const form = document.getElementById('multiStepForm');
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

        let today = new Date().toISOString().split('T')[0]; // Get current date in YYYY-MM-DD format
        document.getElementById("date").value = today; // Set default value

        // Ensure fetchMemberBtn exists before adding an event listener
        let fetchMemberBtn = document.getElementById('fetchMemberBtn');
        if (fetchMemberBtn) {
            fetchMemberBtn.addEventListener('click', function() {
                console.log("Fetch Member button clicked");

                let memberNo = document.getElementById('member-number').value.trim();
                if (memberNo === '') {
                    alert("Please enter a Member Number.");
                    return;
                }

                fetch(`/accounting/remittances/get-member/${encodeURIComponent(memberNo)}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.name) {
                            document.getElementById('guarantor-name').value = data.name;
                            document.getElementById('guarantor-mobile').value = data.mobile;
                        } else {
                            alert("Member not found!");
                            document.getElementById('guarantor-name').value = "";
                            document.getElementById('guarantor-mobile').value = "";
                        }
                    })
                    .catch(error => console.error('Fetch error:', error));
            });
        }

    });
</script>



<?= $this->endSection() ?>