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
                    <p class="text-danger"><?= esc($error) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <div class="card shadow border-none my-2 px-2">

            <div class="card-body px-0 pb-2">

                <div class="row mb-3">


                    <div class="d-flex justify-content-between mt-2 mx-1">
                        <h2>Member Details</h2>
                        <a href="<?= site_url('members/import-transactions-page') ?>" class="btn btn-primary ps-2"><i
                                class="bi-upload me-2" style="font-size:1.2rem;"></i>Import Transactions</a>
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


                <input type="hidden" name="member-id" id="member-id">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="member-name" class="form-label">Member Name</label>
                        <input type="text" name="member-name" id="member-name" class="form-control" disabled>
                    </div>
                    <div class="col-md-6">
                        <label for="member-mobile" class="form-label">Mobile</label>
                        <input type="text" name="member-mobile" id="member-mobile" class="form-control" disabled>
                    </div>
                </div>

                <!-- Transaction Form -->
                <form id="remittanceForm" class="mt-3">
                    <h2>Transaction Details</h2>
                    <?= csrf_field() ?>

                    <div class="row mb-3">
                        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>">

                        <div class="col-md-3">
                            <label for="service-transaction" class="form-label">Service Transaction</label>
                            <select class="form-select" id="service-transaction" name="service-transaction" required>
                                <option value="">-- Select Transaction Type --</option>
                                <option value="savings">Savings</option>
                                <option value="loans">Loans</option>
                                <option value="entrance_fee">Entrance Fee</option>
                                <option value="share_deposits">Share Deposits</option>
                            </select>
                        </div>
                        <input type="hidden" name="loan-id" id="loan-id">

                        <p id="details"></p>

                        <div class="col-md-3">
                            <label for="transaction-type" class="form-label">Transaction Type</label>
                            <select class="form-select" id="transaction-type" name="transaction-type">
                                <option value="cash">Cash Transaction</option>
                                <option value="coucher">Voucher Transaction</option>
                                <option value="journal">Journal Voucher</option>
                                <!-- <option value="emergency">Emergency Loan</option> -->
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="amount" class="form-label">Amount</label>
                            <input type="number" class="form-control" id="amount" name="amount" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="payment_method" class="form-label">Payment Method</label>
                            <select class="form-control" id="payment_method" name="payment_method" required>
                                <option value="">-- Select Payment Method --</option>
                                <option value="cash">Cash</option>
                                <option value="bank">Bank Transfer</option>
                                <option value="mobile">Mobile Payment</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="date" class="form-label">Date of Remittance</label>
                            <input type="date" class="form-control" id="date" name="date" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description"></textarea>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>

                </form>
                <h3>Pending Transactions</h3>
                <table class="table table-bordered" id="transactionsTable">
                    <thead>
                        <tr>
                            <th>MemberNumber</th>
                            <th>Service</th>
                            <th>Transaction Type</th>
                            <th>Amount</th>
                            <th>Payment Method</th>
                            <th>Date</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Transactions will be added here dynamically -->
                    </tbody>
                </table>
                <div class="d-flex justify-content-center">
                    <button class="btn btn-success" id="submitAllBtn">Submit All Transactions</button>
                </div>



            </div>
        </div>

    </div>
</div>
<script>
    let transactions = []; // Store transactions temporarily

    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById("remittanceForm").addEventListener("submit", function (event) {
            event.preventDefault(); // Prevent actual form submission

            // Get form values
            let memberNumber = document.getElementById('member-number').value.trim();
            let service = document.getElementById("service-transaction").value;
            let transactionType = document.getElementById("transaction-type").value;
            let amount = document.getElementById("amount").value;
            let paymentMethod = document.getElementById("payment_method").value;
            let date = document.getElementById("date").value;
            let description = document.getElementById("description").value;


            if (service === "" || amount === "" || paymentMethod === "") {
                alert("Please fill all required fields.");
                return;
            }

            let loanId = document.getElementById("loan-id").value;
            // Create transaction object
            let transaction = {
                memberNumber,
                service,
                transactionType,
                amount,
                paymentMethod,
                date,
                description,
                loanId
            };
            transactions.push(transaction); // Add to array

            // Update the table
            updateTransactionsTable();

            // Clear form
            this.reset();
        });

        function updateTransactionsTable() {
            let tableBody = document.querySelector("#transactionsTable tbody");
            tableBody.innerHTML = ""; // Clear existing rows

            transactions.forEach((transaction, index) => {
                let row = `<tr>
                <td>${transaction.memberNumber}</td>
                <td>${transaction.service}</td>
                <td>${transaction.transactionType}</td>
                <td>${transaction.amount}</td>
                <td>${transaction.paymentMethod}</td>
                <td>${transaction.date}</td>
                <td>${transaction.description}</td>
                <td><button class="btn btn-danger btn-sm" onclick="removeTransaction(${index})">Remove</button></td>
            </tr>`;
                tableBody.innerHTML += row;
            });
        }

        window.removeTransaction = function (index) {
            transactions.splice(index, 1); // Remove from array
            updateTransactionsTable(); // Refresh table
        };

        // Submit all transactions
        document.getElementById("submitAllBtn").addEventListener("click", function () {
            if (transactions.length === 0) {
                alert("No transactions to submit.");
                return;
            }
            showLoadingState(true);

            let csrfToken = document.querySelector('input[name="<?= csrf_token() ?>"]').value;
            fetch("<?= site_url('accounting/remittances/create') ?>", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrfToken
                },
                body: JSON.stringify({
                    transactions: transactions
                }),
            })
                .then(response => response.json())
                .then(data => {
                    showLoadingState(false);
                    if (data.success) {
                        showFeedbackModal(true, 'Success!', 'Transaction details added successfully.');
                        transactions = []; // Clear stored transactions
                        updateTransactionsTable();
                    } else {
                        alert("Error submitting transactions.");
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
                    console.error("Error:", error)
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

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const amountInput = document.getElementById("amount");
        let today = new Date().toISOString().split('T')[0]; // Get current date in YYYY-MM-DD format
        document.getElementById("date").value = today; // Set default value

        // Ensure fetchMemberBtn exists before adding an event listener
        let fetchMemberBtn = document.getElementById('fetchMemberBtn');
        if (fetchMemberBtn) {
            fetchMemberBtn.addEventListener('click', function () {
                console.log("Fetch Member button clicked");

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
                            document.getElementById('member-name').value = "";
                            document.getElementById('member-mobile').value = "";
                        }
                    })
                    .catch(error => console.error('Fetch error:', error));
            });
        }


        // search by  name
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

        // Show/hide loan type selection based on transaction type
        let transactionType = document.getElementById('service-transaction');
        let descriptionInput = document.getElementById("description");
        let balance;
        if (transactionType) {
            transactionType.addEventListener('change', function () {
                let memberID = document.getElementById('member-id').value;
                if (memberID === '') {
                    alert("Please enter a Member Number.");
                    return;
                }

                if (this.value === 'loans') {
                    descriptionInput.value = "Loans";
                } else if (this.value === 'savings') {
                    descriptionInput.value = "Savings";
                } else if (this.value === 'entrance_fee') {
                    descriptionInput.value = "Entrance Fee";
                } else if (this.value === 'share_deposits') {
                    descriptionInput.value = "Share Deposits";
                }


                if (this.value === 'loans') {
                    fetch(`<?= site_url('/loans/check-loan/') ?>${encodeURIComponent(memberID)}`)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.loan_id) {
                                balance = data.balance;
                                document.getElementById('loan-id').value = data.loan_id;
                                document.getElementById('details').innerText = `Loan ID: ${data.loan_id}, Loan Amount: ${data.loan_amount}, Balance: ${data.balance}`;
                            } else {
                                alert('Member has no loans!');
                            }
                        })
                        .catch(error => console.error('Fetch error:', error))
                } else {
                    loanTypeDiv.style.display = 'none';
                }
            });
        }

        // event listener for amount to check if it is more than balance and alert ="cannot overpay loan, balance is X"
        amountInput.addEventListener('input', function () {
            if (transactionType.value === 'loans' && balance !== undefined) {
                let amount = parseFloat(this.value);
                if (amount > balance) {
                    alert(`Cannot overpay loan, balance is ${balance}`);
                    this.value = balance; // Reset to balance
                }
            }
        });

    });
</script>

<?= $this->endSection() ?>