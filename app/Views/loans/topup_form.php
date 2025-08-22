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

            <div class="card-body px-0 pb-2">
                <div class="row mb-3 mt-2">

                    <h2>Member Details</h2>
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
                <p>Original Loan Amount: <?= number_format($oldLoan['principal'], 2) ?></p>
                <p>Repaid: <?= number_format($percentagePaid, 2) ?>%</p>
                <p>Paid Amount: <?= number_format($paidAmount, 2) ?></p>

                <form action="<?= site_url('loan-topup/process') ?>" method="post">
                    <input type="hidden" name="old_loan_id" value="<?= $oldLoan['id'] ?>">
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label">Principal Amount</label>
                            <input type="number" name="new_loan_amount" step="0.01" id="balance" class="form-control" required>
                        </div>
                        
                        <div class="col-6">
                            <label class="form-label">Disburse Amount</label>
                            <input type="number" name="disburse_amount" step="0.01" class="form-control" required>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label">Repayment Period</label>
                            <input type="number" name="repayment_period" class="form-control" required>
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
                                <input type="number" class="form-control" id="disburse_amount">
                            </div>

                            <input type="hidden" name="" id="service_calculated">
                            <input type="hidden" name="" id="insurance_calculated">

                        </div>
                        
                        <div class="d-flex align-items-center justify-content-between">
                            <a href="<?= site_url('loans/all') ?>" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Loan Applications</a>
                            <button type="submit" class="btn btn-primary mt-4">Submit Top-Up</button>
                        </div>

                        
                    </div>


                </form>

                <div id="loan-details">
                    <!-- <p id="loan-amount"></p> -->
                    <!-- <p id="balance"></p> -->
                </div>
            </div>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let fetchMemberBtn = document.getElementById('fetchMemberBtn');
            if (fetchMemberBtn) {
                fetchMemberBtn.addEventListener('click', function() {
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
        })
    </script>

    <!-- Member Name Search -->
    <script>
        const nameInput = document.getElementById('member-name-search');
        const suggestionBox = document.getElementById('name-suggestions');

        let debounceTimer;

        nameInput.addEventListener('input', function() {
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
                                setTimeout(checkLoan(member.id), 500)
                            });
                            suggestionBox.appendChild(item);

                        });
                    });
            }, 300); // debounce delay

        });

        const checkLoan = (memberId) => {
            fetch(`<?= site_url('loans/check-loan/') ?>${memberId}`)
                .then(response => response.json())
                .then(data => {
                    console.log('data before if:', data)
                    if (data.balance > 0) {
                        console.log(data)
                        // Loan exists, show details
                        document.getElementById('balance').value = data.balance;
                        document.getElementById('loan-amount').value = data.loan_amount;
                    } else {
                        document.getElementById('loan-amount').value = '';
                        document.getElementById('balance').value = '';
                    }
                })
                .catch(error => console.error('Error fetching loan details:', error));
        }


        document.addEventListener('click', function(e) {
            if (!suggestionBox.contains(e.target) && e.target !== nameInput) {
                suggestionBox.innerHTML = '';
            }
        });
    </script>
    <?= $this->endSection() ?>