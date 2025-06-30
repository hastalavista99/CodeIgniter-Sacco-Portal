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
                    <div class="d-flex justify-content-between mt-2 mx-1">
                        <h2>Member Details</h2>
                        <a href="<?= site_url('members/import-transactions-page') ?>" class="btn btn-primary ps-2"><i
                                class="bi-upload me-2" style="font-size:1.2rem;"></i>Import Loans</a>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <form id="memberForm">
                                <div class="col-md-6">
                                    <label for="member-number" class="form-label">Member Number</label>
                                    <input type="text" name="member-number" id="member-number" class="form-control"
                                        required>
                                </div>
                                <button type="button" id="fetchMemberBtn" class="btn btn-primary mt-2">Fetch
                                    Member</button>
                            </form>
                        </div>
                        <div class="col-md-6 position-relative mb-3">
                            <label for="member-name-search" class="form-label">Search Member Name</label>
                            <input type="text" id="member-name-search" class="form-control" placeholder="Type name...">
                            <div id="name-suggestions" class="list-group position-absolute w-100"
                                style="z-index: 1000;">
                            </div>
                        </div>
                    </div>

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

                    <!--  hidden input to have member id after fetching it from the backend  -->
                    <input type="hidden" name="member-id" id="member-id">
                </div>
                <div class="row step-indicator mb-4">
                    <div class="col-6">
                        <div class="step active" id="step-indicator-1"><i class="bi bi-pencil-square"></i></div>
                        <div class="step-label">Loan Information</div>
                    </div>
                    <div class="col-6">
                        <div class="step" id="step-indicator-2"><i class="bi bi-people"></i></div>
                        <div class="step-label">Guarantors</div>
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
                                <input type="text" name="interest_method" id="interest_method" class="form-control"
                                    disabled>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label for="interest_rate" class="form-label">Interest Rate(monthly)</label>
                                <input type="number" class="form-control" id="interest_rate" name="interest_rate"
                                    disabled>
                            </div>
                            <div class="col-md-3">
                                <label for="insurance_premium" class="form-label">Insurance Premium(%)</label>
                                <input type="number" class="form-control" id="insurance_premium"
                                    name="insurance_premium" disabled>
                            </div>
                            <div class="col-md-3">
                                <label for="crb_amount" class="form-label">CRB Amount</label>
                                <input type="number" class="form-control" id="crb_amount" disabled>
                            </div>
                            <div class="col-md-3">
                                <label for="service_charge" class="form-label">Service Charge(%)</label>
                                <input type="number" class="form-control" id="service_charge" disabled>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="principal" class="form-label">Principal Amount *</label>
                                <input type="number" class="form-control" id="principal" value="" required>
                            </div>
                            <div class="col-md-4">
                                <label for="repayment_period" class="form-label">Repayment Period(Months) *</label>
                                <input type="number" class="form-control" id="repayment_period" required>
                            </div>
                            <div class="col-md-4">
                                <label for="date" class="form-label">Request Date *</label>
                                <input type="date" class="form-control" id="date" required>
                            </div>
                        </div>
                        <h4>Repayment Details</h4>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label for="total_loan" class="form-label">Total Loan Amount *</label>
                                <input type="number" class="form-control" id="total_loan" name="total_loan" disabled>
                            </div>
                            <div class="col-md-2">
                                <label for="total_interest" class="form-label">Total Interest *</label>
                                <input type="number" class="form-control" id="total_interest" name="total_interest"
                                    disabled>
                            </div>
                            <div class="col-md-2">
                                <label for="fees" class="form-label">Fees & Charges *</label>
                                <input type="number" class="form-control" id="fees" disabled>
                            </div>
                            <div class="col-md-2">
                                <label for="monthly_repayment" class="form-label">Monthly Repayment *</label>
                                <input type="number" class="form-control" id="monthly_repayment" disabled>
                            </div>
                            <div class="col-md-3">
                                <label for="disburse_amount" class="form-label">Disburse Amount *</label>
                                <input type="number" class="form-control" id="disburse_amount" disabled>
                            </div>

                            <input type="hidden" name="" id="service_calculated">
                            <input type="hidden" name="" id="insurance_calculated">

                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button type="button" class="btn btn-primary next-step" data-step="1">Next: Guarantor
                                Details</button>
                        </div>
                    </div>

                    <!-- Step 2: Guarantor Details -->
                    <div class="form-step" id="step-2">
                        <h5 class="mb-4">Step 2: Guarantor Details</h5>

                        <div id="guarantorForm">
                            <div class="col-md-6">
                                <label for="guarantor-number" class="form-label">Member Number</label>
                                <input type="text" name="guarantor-number" id="guarantor-number" class="form-control">
                            </div>
                            <button type="button" id="fetchGuarantorBtn" class="btn btn-primary mt-2">Fetch
                                guarantor</button>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="guarantor-name" class="form-label">Guarantor Name</label>
                                <input type="text" name="guarantor-name" id="guarantor-name" class="form-control"
                                    disabled>
                            </div>
                            <div class="col-md-4">
                                <label for="guarantor-mobile" class="form-label">Mobile Number</label>
                                <input type="text" name="guarantor-mobile" id="guarantor-mobile" class="form-control"
                                    disabled>
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
                            <button type="button" class="btn btn-secondary prev-step" data-step="2">Previous: Loan
                                Information</button>
                            <button type="submit" class="btn btn-success">Submit Details</button>

                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Form steps navigation
        const form = document.getElementById('multiStepForm');
        const steps = document.querySelectorAll('.form-step');
        const nextButtons = document.querySelectorAll('.next-step');
        const prevButtons = document.querySelectorAll('.prev-step');
        const stepIndicators = document.querySelectorAll('.step');

        // Next button click handler
        nextButtons.forEach(button => {
            button.addEventListener('click', function () {
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
            button.addEventListener('click', function () {
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
            fetchMemberBtn.addEventListener('click', function () {
                // console.log("Fetch Member button clicked");

                let memberNo = document.getElementById('member-number').value.trim();
                if (memberNo === '') {
                    alert("Please enter a Member Number.");
                    return;
                }

                fetch(`<?= site_url('/accounting/remittances/get-member/') ?>${encodeURIComponent(memberNo)}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.name) {
                            document.getElementById('member-id').value = data.id;
                            document.getElementById('member-name').value = data.name;
                            document.getElementById('member-mobile').value = data.mobile;
                        } else {
                            alert("Member not found!");
                            document.getElementById('member-id').value = "";
                            document.getElementById('member-name').value = "";
                            document.getElementById('member-mobile').value = "";
                        }
                    })
                    .catch(error => console.error('Fetch error:', error));
            });
        }

        // Fetch interest Method
        const loanType = document.getElementById('loan_type');

        loanType.addEventListener('change', function () {
            let loanId = loanType.value;

            fetch(`<?= site_url('/loans/get-interest/') ?>${encodeURIComponent(loanId)}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.name) {
                        document.getElementById('interest_method').value = data.name;
                        document.getElementById('interest_rate').value = data.interest;
                        document.getElementById('insurance_premium').value = data.insurance_premium;
                        document.getElementById('crb_amount').value = data.crb_amount;
                        document.getElementById('service_charge').value = data.service_charge;
                    } else {
                        alert("Interest Method not found!");
                        document.getElementById('interest_method').value = "";
                        document.getElementById('interest_rate').value = "";
                        document.getElementById('insurance_premium').value = "";
                        document.getElementById('crb_amount').value = "";
                        document.getElementById('service_charge').value = "";
                    }
                })
                .catch(error => console.error('Fetch error:', error));
        })

        // fetch guarantor details
        const fetchGuarantorBtn = document.getElementById('fetchGuarantorBtn');

        fetchGuarantorBtn.addEventListener('click', function () {
            let guarantorNumber = document.getElementById('guarantor-number').value.trim();
            if (guarantorNumber === '') {
                alert("Please enter a valid Member Number.");
                return;
            }

            fetch(`<?= site_url('/accounting/remittances/get-member/') ?>${encodeURIComponent(guarantorNumber)}`)
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
                        alert("Guarantor not found!");
                        document.getElementById('guarantor-name').value = "";
                        document.getElementById('guarantor-mobile').value = "";
                    }
                })
                .catch(error => console.error('Guarantor fetch error: ', error));
        });

        const repaymentPeriodInput = document.getElementById('repayment_period');
        const principalInput = document.getElementById('principal');
        const interestMethodInput = document.getElementById('interest_method');

        const totalLoanInput = document.getElementById('total_loan');
        const totalInterestInput = document.getElementById('total_interest');
        const repaymentInput = document.getElementById('monthly_repayment');
        const feesInput = document.getElementById('fees');
        const disburseAmountInput = document.getElementById('disburse_amount');
        const serviceChargeInput = document.getElementById('service_charge');
        const crbAmountInput = document.getElementById('crb_amount');
        const insurancePremiumInput = document.getElementById('insurance_premium');
        const calculatedInsurance = document.getElementById('insurance_calculated');
        const calculatedServiceFee = document.getElementById('service_calculated');




        function calculateLoanDetails() {
            const monthlyInterestRate = document.getElementById('interest_rate').value;
            const monthlyRate = monthlyInterestRate / 100; // interest rate per month / 100 to get the decimal
            const interestMethod = interestMethodInput.value;
            const loanPrincipal = parseFloat(principalInput.value);
            const repaymentPeriod = parseInt(repaymentPeriodInput.value);
            const insurancePremium = parseInt(loanPrincipal * parseFloat(insurancePremiumInput.value) / 100)
            const fees = parseFloat((loanPrincipal * (serviceChargeInput.value / 100)) + parseFloat(crbAmountInput.value) + insurancePremium);
            const disburse = parseFloat(loanPrincipal - fees);
            const serviceCharge = loanPrincipal * (serviceChargeInput.value / 100);

            // Validate inputs
            if (isNaN(loanPrincipal) || isNaN(repaymentPeriod) || repaymentPeriod <= 0) {
                totalLoanInput.value = '';
                totalInterestInput.value = '';
                repaymentInput.value = '';
                return;
            }

            let interest = 0;
            let totalLoan = 0;
            let repayment = 0;

            if (interestMethod === 'Flat Rate') {
                // Flat rate: interest = principal * rate * period
                interest = parseFloat(loanPrincipal) * parseFloat(monthlyRate) * parseInt(repaymentPeriod);
                totalLoan = parseFloat(loanPrincipal) + interest;
                repayment = totalLoan / parseInt(repaymentPeriod);

            } else if (interestMethod === 'Reducing Balance') {
                // Reducing balance: use the exact same formula as backend
                const r = parseFloat(monthlyRate);
                const n = parseInt(repaymentPeriod);
                const P = parseFloat(loanPrincipal);
                if (r > 0 && n > 0) {
                    repayment = (P * r * Math.pow(1 + r, n)) / (Math.pow(1 + r, n) - 1);
                } else {
                    repayment = 0;
                }
                totalLoan = repayment * n;
                interest = totalLoan - P;
            }

            totalLoanInput.value = totalLoan > 0 ? totalLoan.toFixed(2) : '';
            totalInterestInput.value = interest > 0 ? Math.round(interest) : '';
            repaymentInput.value = repayment > 0 ? repayment.toFixed(2) : '';
            feesInput.value = fees.toFixed(2);
            disburseAmountInput.value = disburse.toFixed(2);
            calculatedInsurance.value = insurancePremium.toFixed(2);
            calculatedServiceFee.value = serviceCharge.toFixed(2);
        }

        // Recalculate when any relevant input changes
        repaymentPeriodInput.addEventListener('input', calculateLoanDetails);
        principalInput.addEventListener('input', calculateLoanDetails);
        interestMethodInput.addEventListener('change', calculateLoanDetails);


        // Add guarantors to table 
        const addBtn = document.getElementById('addBtn');

        addBtn.addEventListener('click', function (e) {
            e.preventDefault(); // Prevent form submission 

            const number = document.getElementById('guarantor-number').value.trim();
            const name = document.getElementById('guarantor-name').value.trim();
            const mobile = document.getElementById('guarantor-mobile').value.trim();
            const amount = document.getElementById('guarantor-amount').value.trim();

            // Validate required fields
            if (!number || !name || !mobile || !amount) {
                alert("Please make sure all fields are filled.");
                return;
            }

            // check if amount is a valid number
            if (isNaN(amount) || parseFloat(amount) <= 0) {
                alert("Please enter a valid guaranteed amount.");
                return;
            }

            // Create new row
            const tbody = document.querySelector('#guarantorTable tbody');
            const newRow = document.createElement('tr');

            newRow.innerHTML = `
        <td>${number}</td>
        <td>${name}</td>
        <td>${mobile}</td>
        <td>${amount}</td>
    `;

            tbody.appendChild(newRow);

            // Clear inputs for next entry
            document.getElementById('guarantor-number').value = '';
            document.getElementById('guarantor-name').value = '';
            document.getElementById('guarantor-mobile').value = '';
            document.getElementById('guarantor-amount').value = '';
        });


    });
</script>

<!-- script to search by name -->
<script>
    const nameInput = document.getElementById('member-name-search');
    const suggestionBox = document.getElementById('name-suggestions');

    let debounceTimer;

    nameInput.addEventListener('input', function () {
        clearTimeout(debounceTimer);

        const query = this.value.trim();
        if (query.length < 2) {
            suggestionBox.innerHTML = '';
            return;
        }

        debounceTimer = setTimeout(() => {
            fetch(`<?= site_url('/accounting/remittances/search-member-name') ?>?q=${encodeURIComponent(query)}`)
                .then(res => res.json())
                .then(data => {
                    suggestionBox.innerHTML = '';
                    if (data.length === 0) {
                        suggestionBox.innerHTML = '<div class="list-group-item">No results found</div>';
                        return;
                    }

                    data.forEach(member => {
                        const item = document.createElement('div');
                        item.classList.add('list-group-item', 'list-group-item-action');
                        item.textContent = `${member.name} (${member.member_number})`;
                        item.addEventListener('click', () => {
                            document.getElementById('member-id').value = member.id;
                            document.getElementById('member-name').value = member.name;
                            document.getElementById('member-mobile').value = member.mobile;
                            document.getElementById('member-number').value = member.member_number;
                            nameInput.value = member.name;
                            suggestionBox.innerHTML = '';
                        });
                        suggestionBox.appendChild(item);
                    });
                });
        }, 300); // debounce delay
    });

    document.addEventListener('click', function (e) {
        if (!suggestionBox.contains(e.target) && e.target !== nameInput) {
            suggestionBox.innerHTML = '';
        }
    });
</script>

<!-- Submission of Loan Data -->
<script>
    document.getElementById('loanApplicationForm').addEventListener('submit', function (e) {
        e.preventDefault();
        showLoadingState(true);

        // Gather loan application data
        const data = {
            member_id: document.getElementById('member-id').value,
            loan_type: document.getElementById('loan_type').value,
            interest_method: document.getElementById('interest_method').value,
            interest_rate: document.getElementById('interest_rate').value,
            insurance_premium: document.getElementById('insurance_calculated').value,
            crb_amount: document.getElementById('crb_amount').value,
            service_charge: document.getElementById('service_calculated').value,
            principal: document.getElementById('principal').value,
            repayment_period: document.getElementById('repayment_period').value,
            request_date: document.getElementById('date').value,
            total_loan: document.getElementById('total_loan').value,
            total_interest: document.getElementById('total_interest').value,
            fees: document.getElementById('fees').value,
            monthly_repayment: document.getElementById('monthly_repayment').value,
            disburse_amount: document.getElementById('disburse_amount').value,
            guarantors: []
        };

        // Gather guarantor data from the table
        const table = document.querySelector('#guarantorTable tbody');
        const rows = table.querySelectorAll('tr');
        rows.forEach(row => {
            const cols = row.querySelectorAll('td');
            data.guarantors.push({
                member_number: cols[0].innerText.trim(),
                name: cols[1].innerText.trim(),
                mobile: cols[2].innerText.trim(),
                amount: cols[3].innerText.trim()
            });
        });

        // Send data to backend using fetch
        fetch('<?= site_url('/loans/application/submit') ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest', // optional: for CI4 to detect AJAX
                'Accept': 'application/json'
            },
            body: JSON.stringify(data)
        })
            .then(response => {
                if (!response.ok) throw new Error("Network response was not ok");
                return response.json();
            })
            .then(data => {
                showLoadingState(false);

                if (data.success) {
                    // Show success modal
                    showFeedbackModal(true, 'Success!', 'Loan details submitted successfully.');

                    // Redirect after a delay
                    setTimeout(() => {
                        window.location.href = '<?= site_url('/loans/apply') ?>';
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

                // console.log(data);
            })
            .catch(error => {
                // Handle errors

                // Hide loading state
                showLoadingState(false);

                // Show error modal
                showFeedbackModal(
                    false,
                    'Submission Error',
                    'An error occurred while submitting the form. Please try again.'
                );
                console.error('Submission error:', error);
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