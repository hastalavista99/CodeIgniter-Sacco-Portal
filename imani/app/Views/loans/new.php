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
                                            placeholder="Membership No." required>
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
                                                <option value="<?= $type['type'] ?>"><?= $type['type'] ?></option>
                                            <?php endforeach ?>
                                        </select>
                                        <label for="loanType">Loan Type</label>
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
            const loanAmount = document.getElementById('loanAmount').value;
            const repaymentPeriod = document.getElementById('repaymentPeriod').value;
            const paymentMode = document.getElementById('paymentMode').value;
            const bankName = document.getElementById('bankName').value;
            const bankBranch = document.getElementById('bankBranch').value;
            const accountName = document.getElementById('accountName').value;
            const accountNumber = document.getElementById('accountNumber').value;
            const paymentType = document.getElementById('paymentType').value;

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
                    label: 'Loan Amount',
                    value: loanAmount
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
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(formData)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Data submitted successfully');
                    } else {
                        alert('Error submitting data. Contact your Sacco for assisstance.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });
    </script>

</div>



<?= $this->endSection() ?>