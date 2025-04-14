<?php

use CodeIgniter\HTTP\SiteURI;
?>
<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?><?= $title ?><?= $this->endSection() ?>


<div class="row">
    <?= $this->section('content') ?>

    <?= $this->include('partials/sidebar') ?>
    <div class="row ">
        <div class="col-12 text-center p-0 mb-2">
            <div class="card px-2 pt-3 pb-0 mb-2">
                <h3>Loan Application</h3>
                <p>Fill all fields to finalize Loan application.</p>
                <form id="msform" method="">
                    <?= csrf_field() ?>
                    <!-- progressbar -->
                    <div class="row">
                        <ul id="progressbar" class="col-sm-12">
                            <li class="active" id="account">Member Info</li>
                            <li id="employment">Employment Details</li>
                            <li id="personal">Loan Details</li>
                            <li id="payment">Guarantor Details</li>
                            <li id="confirmation">Confirm</li>
                            <li id="confirm">Finish</li>
                        </ul>
                    </div>

                    <!-- fieldsets -->
                    <fieldset>
                        <div class="">
                            <div class="row mb-2">
                                <div class="col-7 heading-text font-weight-bolder">
                                    <h5>Member Information:</h5>
                                </div>
                                <div class="col-5" style="text-align: right;">
                                    <h5>Step 1 - 5</h5>
                                </div>
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="name" placeholder="Your Name"
                                            value="<?= $userInfo['user'] ?>" required>
                                        <label for="name">Your Name</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="memberNumber"
                                            placeholder="Membership No." value="<?= $userInfo['member_no'] ?>" required>
                                        <label for="memberNumber">Membership No.</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="memberMobile"
                                            placeholder="Mobile Number" value="<?= $userInfo['mobile'] ?>" required>
                                        <label for="memberMobile">Mobile Number</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="email" class="form-control" id="memberEmail"
                                            placeholder="Your Email" value="<?= $userInfo['email'] ?>">
                                        <label for="memberEmail">Email Address</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="number" class="form-control" id="memberID" placeholder="Id No."
                                            required>
                                        <label for="memberID">ID No.</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="employer"
                                            placeholder="Your Employer">
                                        <label for="employer">Employer</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="station" placeholder="Station">
                                        <label for="station">Station</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="number" class="form-control" id="pobox" placeholder="P.O. Box">
                                        <label for="pobox">P.O. Box</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="number" class="form-control" id="poboxCode" placeholder="Code">
                                        <label for="poboxCode">Code</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="poboxCity" placeholder="Town/City">
                                        <label for="poboxCity">Town/City</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button" name="next" class="action-button next my-3 me-2" id="nextStep1"
                            disabled>Next</button>

                        <script>
                            // Function to check if all required fields are filled
                            function validateRequiredFieldsStep1() {
                                // Select all required fields in the first fieldset
                                let requiredFields = document.querySelectorAll('#name, #memberNumber, #memberMobile, #memberID');
                                let allValid = true;

                                requiredFields.forEach(function(field) {
                                    // Check if the field is empty
                                    if (!field.value) {
                                        field.classList.add('is-invalid'); // Optional: Add Bootstrap's invalid class for better visuals
                                        allValid = false;
                                    } else {
                                        field.classList.remove('is-invalid');
                                    }
                                });

                                return allValid;
                            }

                            // Function to enable/disable the Next button based on field validation
                            function toggleNextButton() {
                                const isFormValid = validateRequiredFieldsStep1();
                                const nextButton = document.getElementById('nextStep1');

                                if (isFormValid) {
                                    nextButton.disabled = false; // Enable the Next button if form is valid
                                } else {
                                    nextButton.disabled = true; // Disable the Next button if form is invalid
                                }
                            }

                            // Add event listeners to each required field to check validation on input change
                            document.querySelectorAll('#name, #memberNumber, #memberMobile, #memberID').forEach(function(field) {
                                field.addEventListener('input', toggleNextButton);
                            });
                            // Initial validation check (in case some fields are pre-filled)
                            toggleNextButton();
                        </script>

                    </fieldset>
                    <fieldset>
                        <div class="form-card">
                            <div class="row mb-2">
                                <div class="col-7 heading-text font-weight-bolder">
                                    <h5>Member Information:</h5>
                                </div>
                                <div class="col-5" style="text-align: right;">
                                    <h5>Step 1 - 5</h5>
                                </div>
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="name" placeholder="Your Name"
                                            value="<?= $userInfo['user'] ?>" required>
                                        <label for="name">Your Name</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="memberNumber"
                                            placeholder="Membership No." value="<?= $userInfo['member_no'] ?>" required>
                                        <label for="memberNumber">Membership No.</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="memberMobile"
                                            placeholder="Mobile Number" value="<?= $userInfo['mobile'] ?>" required>
                                        <label for="memberMobile">Mobile Number</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="email" class="form-control" id="memberEmail"
                                            placeholder="Your Email" value="<?= $userInfo['email'] ?>">
                                        <label for="memberEmail">Email Address</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="number" class="form-control" id="memberID" placeholder="Id No."
                                            required>
                                        <label for="memberID">ID No.</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="employer"
                                            placeholder="Your Employer">
                                        <label for="employer">Employer</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="station" placeholder="Station">
                                        <label for="station">Station</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="number" class="form-control" id="pobox" placeholder="P.O. Box">
                                        <label for="pobox">P.O. Box</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="number" class="form-control" id="poboxCode" placeholder="Code">
                                        <label for="poboxCode">Code</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="poboxCity" placeholder="Town/City">
                                        <label for="poboxCity">Town/City</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button" name="next" class="action-button next my-3 me-2" id="nextStep0"
                            disabled>Next</button> <input
                            type="button" name="previous" class="previous action-button-previous my-2" value="Previous" />

                        <script>
                            // // Function to check if all required fields are filled
                            // function validateRequiredFieldsStep1() {
                            //     // Select all required fields in the first fieldset
                            //     let requiredFields = document.querySelectorAll('#name, #memberNumber, #memberMobile, #memberID');
                            //     let allValid = true;

                            //     requiredFields.forEach(function(field) {
                            //         // Check if the field is empty
                            //         if (!field.value) {
                            //             field.classList.add('is-invalid'); // Optional: Add Bootstrap's invalid class for better visuals
                            //             allValid = false;
                            //         } else {
                            //             field.classList.remove('is-invalid');
                            //         }
                            //     });

                            //     return allValid;
                            // }

                            // // Function to enable/disable the Next button based on field validation
                            // function toggleNextButton() {
                            //     const isFormValid = validateRequiredFieldsStep1();
                            //     const nextButton = document.getElementById('nextStep0');

                            //     if (isFormValid) {
                            //         nextButton.disabled = false; // Enable the Next button if form is valid
                            //     } else {
                            //         nextButton.disabled = true; // Disable the Next button if form is invalid
                            //     }
                            // }

                            // // Add event listeners to each required field to check validation on input change
                            // document.querySelectorAll('#name, #memberNumber, #memberMobile, #memberID').forEach(function(field) {
                            //     field.addEventListener('input', toggleNextButton);
                            // });
                            // // Initial validation check (in case some fields are pre-filled)
                            // toggleNextButton();
                        </script>

                    </fieldset>
                    <fieldset>
                        <div class="form-card">
                            <div class="row">
                                <div class="col-7 heading-text">
                                    <h5>Application Details:</h5>
                                </div>
                                <div class="col-5" style="text-align: right;">
                                    <h5>Step 2 - 5</h5>
                                </div>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="form-floating mb-3">
                                        <select class="form-select" id="loanType" aria-label="State">
                                            <option selected value=""></option>
                                            <?php
                                            foreach ($types as $type) :
                                            ?>
                                                <option value="<?=$type['type']?>"><?= $type['type'] ?> - <?= $type['rate']?>%</option>
                                            <?php endforeach ?>
                                        </select>
                                        <label for="loanType">Loan Type</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="loanFormula" value="">
                                        <label for="loanFormula">Interest Formula</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="number" class="form-control" id="loanAmount"
                                            placeholder="Loan Amount" required>
                                        <label for="loanAmount">Loan Amount <small>(Kshs)</small></label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="number" class="form-control" id="repaymentPeriod"
                                            placeholder="Repayment Period" required>
                                        <label for="repaymentPeriod">Repayment Period <small>(Months)</small></label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="paymentMode"
                                            placeholder="Loan AmountRepayment Period" required>
                                        <label for="paymentMode">Mode of Payment <small>(e.g. standing
                                                order)</small></label>
                                    </div>
                                </div>

                                <div class="row mt-3 mb-2">
                                    <div class="col-7 heading-text">
                                        <h5>Disbursement Details:</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="bankName" placeholder="Bank Name">
                                        <label for="bankName">Bank Name</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="bankBranch"
                                            placeholder="Membership No.">
                                        <label for="bankBranch">Bank Branch</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="accountName" placeholder="Id No.">
                                        <label for="accountName">Account Name</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="accountNumber"
                                            placeholder="Your Employer">
                                        <label for="accountNumber">Account No.</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating mb-3">
                                        <select class="form-select" id="paymentType" aria-label="State">
                                            <option selected value="Cheque">Cheque</option>
                                            <option value="EFT">EFT</option>
                                            <option value="RTGS">RTGS</option>
                                        </select>
                                        <label for="paymentType">Disbursement By:</label>
                                    </div>
                                </div>


                            </div>
                        </div> <button type="button" name="next" class="action-button next my-2 me-2" id="nextStep2"
                            disabled>Next</button> <input
                            type="button" name="previous" class="previous action-button-previous my-2" value="Previous" />

                        <script>
                            document.getElementById('loanType').addEventListener('change', function() {
                                const loanType = this.value;

                                if (loanType) {
                                    fetch('<?= base_url('loans/getFormula') ?>', {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'X-CSRF-TOKEN': '<?= csrf_hash()?>'
                                            },
                                            body: JSON.stringify({
                                                loanType: loanType
                                            }),
                                        })
                                        .then(response => response.json())
                                        .then(data => {
                                            if (data.success) {
                                                document.getElementById('loanFormula').value = data.formula;
                                            } else {
                                                document.getElementById('loanFormula').value = 'Formula not found';
                                            }
                                        })
                                        .catch(error => console.error('Error:', error));
                                } else {
                                    document.getElementById('loanFormula').value = '';
                                }
                            });

                            function validateRequiredFieldsStep2() {
                                // Select all required fields in the first fieldset
                                let requiredFields = document.querySelectorAll('#loanAmount, #repaymentPeriod, #paymentMode, #bankName, #bankBranch, #accountName, #accountNumber');
                                let allValid = true;

                                requiredFields.forEach(function(field) {
                                    // Check if the field is empty
                                    if (!field.value) {
                                        field.classList.add('is-invalid'); // Optional: Add Bootstrap's invalid class for better visuals
                                        allValid = false;
                                    } else {
                                        field.classList.remove('is-invalid');
                                    }
                                });

                                return allValid;
                            }

                            // Function to enable/disable the Next button based on field validation
                            function toggleNextButton2() {
                                const isForm2Valid = validateRequiredFieldsStep2();
                                const nextButton2 = document.getElementById('nextStep2');

                                if (isForm2Valid) {
                                    nextButton2.disabled = false; // Enable the Next button if form is valid
                                } else {
                                    nextButton2.disabled = true; // Disable the Next button if form is invalid
                                }
                            }

                            // Add event listeners to each required field to check validation on input change
                            document.querySelectorAll('#loanAmount, #repaymentPeriod, #paymentMode, #bankName, #bankBranch, #accountName, #accountNumber').forEach(function(field) {
                                field.addEventListener('input', toggleNextButton2);
                            });
                            // Initial validation check (in case some fields are pre-filled)
                            toggleNextButton2();
                        </script>
                    </fieldset>
                    <fieldset>
                        <div class="form-card">
                            <div class="row">
                                <div class="col-7 heading-text">
                                    <h5>Guarantors:</h5>
                                </div>
                                <div class="col-5" style="text-align: right;">
                                    <h5>Step 3 - 5</h5>
                                </div>
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="guarantorName"
                                            placeholder="Name Here">
                                        <label for="guarantorName">Member Name</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="guarantorMobile"
                                            placeholder="Loan Amount">
                                        <label for="guarantorMobile">Member Mobile</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="guarantorNumber"
                                            placeholder="Repayment Period">
                                        <label for="guarantorNumber">Member Number</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="number" class="form-control" id="guarantorID"
                                            placeholder="Loan AmountRepayment Period">
                                        <label for="guarantorID">Member ID No.</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="number" class="form-control" id="guarantorAmount"
                                            placeholder="Loan AmountRepayment Period">
                                        <label for="guarantorAmount">Amount Guaranteed</label>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="d-flex align-content-end justify-content-end m-2">
                            <button class="btn btn-primary" id="addBtn">Add</button>
                        </div>

                        <table class="table" id="guarantorTable">
                            <thead>
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Member No.</th>
                                    <th scope="col">Mobile</th>
                                    <th scope="col">ID number</th>
                                    <th scope="col">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        <button type="button" name="next" class="next action-button" id="nextConfirm">Next</button>
                        <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
                        <script>
                            // Add event listener to the "Add" button
                            document.getElementById('addBtn').addEventListener('click', function(event) {
                                event.preventDefault(); // This ensures that the page does not reload.

                                // Get the input values
                                const guarantorName = document.getElementById('guarantorName').value;
                                const guarantorMobile = document.getElementById('guarantorMobile').value;
                                const guarantorNumber = document.getElementById('guarantorNumber').value;
                                const guarantorAmount = document.getElementById('guarantorAmount').value;
                                const guarantorID = document.getElementById('guarantorID').value;

                                // Ensure required fields are filled in
                                if (guarantorName === '' || guarantorMobile === '') {
                                    alert('Please fill in all required fields.');
                                    return;
                                }

                                // Create a new row and cells
                                const table = document.getElementById('guarantorTable').getElementsByTagName('tbody')[0];
                                const newRow = table.insertRow();

                                const guarantorNameCell = newRow.insertCell(0);
                                const guarantorMobileCell = newRow.insertCell(1);
                                const guarantorNumberCell = newRow.insertCell(2);
                                const guarantorAmountCell = newRow.insertCell(3);
                                const guarantorIDCell = newRow.insertCell(4);

                                // Set the text content for the new cells
                                guarantorNameCell.textContent = guarantorName;
                                guarantorMobileCell.textContent = guarantorMobile;
                                guarantorNumberCell.textContent = guarantorNumber;
                                guarantorIDCell.textContent = guarantorID;
                                guarantorAmountCell.textContent = guarantorAmount;


                                // Clear the form fields after adding the row
                                document.getElementById('guarantorName').value = '';
                                document.getElementById('guarantorMobile').value = '';
                                document.getElementById('guarantorNumber').value = '';
                                document.getElementById('guarantorID').value = '';
                                document.getElementById('guarantorAmount').value = '';
                            });
                        </script>

                    </fieldset>
                    <fieldset>
                        <div class="form-card">
                            <div class="row">
                                <div class="col-7 heading-text">
                                    <h5>Confirmation:</h5>
                                </div>
                                <div class="col-5" style="text-align: right;">
                                    <h5>Step 4 - 5</h5>
                                </div>
                            </div>
                            <div class="text-center">
                                <p>Confirm details before submitting</p>
                            </div>
                            <div class="" id="confirmDetails">

                            </div>
                        </div> <button type="button" name="next" class="next action-button"
                            id="submitForm">Submit</button> <input type="button" name="previous"
                            class="previous action-button-previous" value="Previous" />
                    </fieldset>
                    <fieldset>
                        <div class="form-card">
                            <div class="row">
                                <div class="col-7">
                                    <h5 class="heading-text">Finish:</h5>
                                </div>
                                <div class="col-5" style="text-align: right;">
                                    <h5 class="">Step 5 - 5</h5>
                                </div>
                            </div> <br>
                            <h2 class="text-success text-center" id="success"><span id="sucspan"></span></h2> <br>
                            <div class="row justify-content-center">
                                <h5>Loan Application Successfully Completed</h5>
                                <p>The SACCO will notify you on Approval/Rejection</p>
                            </div> <br><br>
                            <div class="row justify-content-center">
                                <a href="<?= site_url('loans/my_loans') ?>"
                                    class="action-button text-uppercase">Finish</a>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('nextConfirm').addEventListener('click', function(event) {
            const confirmPage = document.getElementById("confirmDetails");

            // Clear previous confirmation details
            confirmPage.innerHTML = '';

            // Get the input values for confirmation
            const name = document.getElementById('name').value;
            const memberNumber = document.getElementById('memberNumber').value;
            const memberID = document.getElementById('memberID').value;
            const employer = document.getElementById('employer').value;
            const station = document.getElementById('station').value;
            const memberMobile = document.getElementById('memberMobile').value;
            const memberEmail = document.getElementById('memberEmail').value;
            const pobox = document.getElementById('pobox').value;
            const poboxCode = document.getElementById('poboxCode').value;
            const poboxCity = document.getElementById('poboxCity').value;
            const loanType = document.getElementById('loanType').value;
            const loanFormula = document.getElementById('loanFormula').value;
            const loanAmount = document.getElementById('loanAmount').value;
            const repaymentPeriod = document.getElementById('repaymentPeriod').value;
            const paymentMode = document.getElementById('paymentMode').value;
            const bankName = document.getElementById('bankName').value;
            const bankBranch = document.getElementById('bankBranch').value;
            const accountName = document.getElementById('accountName').value;
            const accountNumber = document.getElementById('accountNumber').value;
            const paymentType = document.getElementById('paymentType').value;

            // calculate interest ** DRAFT ONLY
            const interest = loanAmount * 0.1;

            // calculate total amount
            const totalLoan = parseFloat(loanAmount) + parseFloat(interest);

            // Create a list element
            const ul = document.createElement('ul');

            // Append each input value as a list item
            const inputs = [{
                    label: 'Name',
                    value: name
                },
                {
                    label: 'Member Number',
                    value: memberNumber
                },
                {
                    label: 'Member ID',
                    value: memberID
                },
                {
                    label: 'Employer',
                    value: employer
                },
                {
                    label: 'Station',
                    value: station
                },
                {
                    label: 'Mobile',
                    value: memberMobile
                },
                {
                    label: 'Email',
                    value: memberEmail
                },
                {
                    label: 'P.O. Box',
                    value: pobox
                },
                {
                    label: 'P.O. Box Code',
                    value: poboxCode
                },
                {
                    label: 'P.O. Box City',
                    value: poboxCity
                },
                {
                    label: 'Loan Type',
                    value: loanType
                },
                {
                    label: 'Loan Formula',
                    value: loanFormula
                },
                {
                    label: 'Loan Principal(Kshs)',
                    value: loanAmount
                },
                {
                    label: 'Loan Interest(Kshs)',
                    value: interest
                },
                {
                    label: 'Loan Total(Kshs)',
                    value: totalLoan
                },
                {
                    label: 'Repayment Period',
                    value: repaymentPeriod
                },
                {
                    label: 'Payment Mode',
                    value: paymentMode
                },
                {
                    label: 'Bank Name',
                    value: bankName
                },
                {
                    label: 'Bank Branch',
                    value: bankBranch
                },
                {
                    label: 'Account Name',
                    value: accountName
                },
                {
                    label: 'Account Number',
                    value: accountNumber
                },
                {
                    label: 'Payment Type',
                    value: paymentType
                }
            ];

            inputs.forEach(input => {
                const li = document.createElement('li');
                ul.classList.add('list-group');
                li.classList.add('list-group-item');
                li.innerHTML = `<strong>${input.label}:</strong>  ${input.value}`;
                ul.appendChild(li);
            });

            // Get the table values and add them to the confirmation list
            const table = document.getElementById('guarantorTable').getElementsByTagName('tbody')[0];
            const rows = table.getElementsByTagName('tr');

            if (rows.length > 0) {
                const tableHeader = document.createElement('li');
                tableHeader.style.listStyle = "none";
                tableHeader.innerHTML = '<h3 class="pt-10">Guarantor Details:</h3>'; // Add a header for table values
                ul.appendChild(tableHeader);

                for (let row of rows) {
                    const cells = row.getElementsByTagName('td');
                    const guarantorDetails = [
                        `<strong>Name:</strong> ${cells[0].textContent}`,
                        `<strong>Mobile:</strong> ${cells[1].textContent}`,
                        `<strong>Number:</strong> ${cells[2].textContent}`,
                        `<strong>Amount:</strong> ${cells[3].textContent}`,
                        `<strong>ID:</strong> ${cells[4].textContent}`
                    ];

                    guarantorDetails.forEach(detail => {
                        const li = document.createElement('li');
                        li.classList.add('list-group-item');
                        li.innerHTML = detail; // Use textContent to set the table detail
                        ul.appendChild(li);
                    });
                }
            }

            // Append the list to the confirmation page
            confirmPage.appendChild(ul);
        });

        document.getElementById('submitForm').addEventListener('click', function() {

            const csrfName = '<?= csrf_token() ?>'; // CSRF Token Name
            const csrfHash = '<?= csrf_hash() ?>'; // CSRF Token Hash
            // Get the input values
            const formData = {
                userId: '<?= $userInfo['id'] ?>',
                name: document.getElementById('name').value,
                memberNumber: document.getElementById('memberNumber').value,
                memberID: document.getElementById('memberID').value,
                employer: document.getElementById('employer').value,
                station: document.getElementById('station').value,
                memberMobile: document.getElementById('memberMobile').value,
                memberEmail: document.getElementById('memberEmail').value,
                pobox: document.getElementById('pobox').value,
                poboxCode: document.getElementById('poboxCode').value,
                poboxCity: document.getElementById('poboxCity').value,
                loanType: document.getElementById('loanType').value,
                loanFormula: document.getElementById('loanFormula').value,
                loanAmount: document.getElementById('loanAmount').value,
                repaymentPeriod: document.getElementById('repaymentPeriod').value,
                paymentMode: document.getElementById('paymentMode').value,
                bankName: document.getElementById('bankName').value,
                bankBranch: document.getElementById('bankBranch').value,
                accountName: document.getElementById('accountName').value,
                accountNumber: document.getElementById('accountNumber').value,
                paymentType: document.getElementById('paymentType').value,
                guarantors: []
            };

            // Loop through table rows to add guarantor details
            const table = document.getElementById('guarantorTable').getElementsByTagName('tbody')[0];
            const rows = table.getElementsByTagName('tr');

            for (let i = 0; i < rows.length; i++) {
                const cells = rows[i].getElementsByTagName('td');
                let guarantor = {
                    name: cells[0].innerText,
                    mobile: cells[1].innerText,
                    number: cells[2].innerText,
                    amount: cells[3].innerText,
                    id: cells[4].innerText
                };
                formData.guarantors.push(guarantor);
            }

            // Add CSRF token to formData
            formData[csrfName] = csrfHash;


            // Send the data via AJAX to CodeIgniter controller
            fetch('<?= site_url('loans/submit') ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '<?= csrf_hash()?>'
                    },
                    body: JSON.stringify(formData)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Data submitted successfully');
                    } else {
                        alert('Error submitting data. Contact your Sacco for assisstance.');
                        window.location.reload();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });
    </script>

</div>

<!-- Step Indicators -->

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
                            <!--
                            <div class="col-3">
                                <div class="step" id="step-indicator-4">4</div>
                                <div class="step-label">Additional Details</div>
                            </div> -->
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
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                            <option value="other">Other</option>
                                            <option value="prefer-not-to-say">Prefer not to say</option>
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
                                    <div class="col-md-4">
                                        <label for="principal" class="form-label">Total Loan Amount *</label>
                                        <input type="number" class="form-control" id="principal" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="principal" class="form-label">Total Interest *</label>
                                        <input type="number" class="form-control" id="principal" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="monthly_repayment" class="form-label"> *</label>
                                        <input type="monthly_repayment" class="form-control" id="monthly_repayment" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="idType" class="form-label">ID Type</label>
                                        <select class="form-select" id="idType">
                                            <option value="">Select ID Type</option>
                                            <option value="passport">Passport</option>
                                            <option value="national-id">National ID</option>
                                            <option value="drivers-license">Driver's License</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="idExpiryDate" class="form-label">ID Expiry Date</label>
                                        <input type="date" class="form-control" id="idExpiryDate">
                                    </div>
                                </div>
                                
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="termsAccepted">
                                    <label class="form-check-label" for="termsAccepted">
                                        I accept the terms and conditions *
                                    </label>
                                </div>
                                
                                <div class="d-flex justify-content-end mt-4">
                                    <button type="button" class="btn btn-primary next-step" data-step="1">Next: Guarantor Details</button>
                                </div>
                            </div>
                            
                            <!-- Step 2: Guarantor Details -->
                            <div class="form-step" id="step-2">
                                <h5 class="mb-4">Step 2: Guarantor Details</h5>
                                
                                
                    <form id="guarantorForm">
                        <div class="col-md-6">
                            <label for="guarantor-number" class="form-label">Member Number</label>
                            <input type="text" name="guarantor-number" id="guarantor-number" class="form-control" required>
                        </div>
                        <button type="button" id="fetchguarantorBtn" class="btn btn-primary mt-2">Fetch guarantor</button>
                    </form>
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
                        <input type="number" name="guarantor-amount" id="guarantor-amount" class="form-control" disabled>
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
                                    <button type="button" class="btn btn-secondary prev-step" data-step="1">Previous: Loan Information</button>
                                    <button type="button" class="btn btn-primary next-step" data-step="3">Next: Details Confirmation</button>
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
                                    <button type="button" class="btn btn-secondary prev-step" data-step="2">Previous: Professional Info</button>
                                    <button type="submit" class="btn btn-success">Submit Form</button>
                                </div>
                            </div>
                        </form>

                        <script>
    document.addEventListener("DOMContentLoaded", function() {
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
                            document.getElementById('member-name').value = data.name;
                            document.getElementById('member-mobile').value = data.mobile;
                        } else {
                            alert("Member not found!");
                            document.getElementById('member-name').value = "";
                            document.getElementById('member-mobile').value = "";
                        }
                    })
                    .catch(error => console.error('Fetch error:', error));
            });
        }

    });
</script>



<?= $this->endSection() ?>