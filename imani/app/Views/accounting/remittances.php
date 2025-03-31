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

                <form id="remittanceForm" class="mt-3">
                <?= csrf_field()?>
                    <div class="mb-3">
                        <label for="member" class="form-label">Select Member</label>
                        <select class="form-control" id="member" name="member" required>
                            <option value="">-- Select Member --</option>
                            <option value="1">Member 1</option>
                            <option value="2">Member 2</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="account" class="form-label">Select Account</label>
                        <select class="form-control" id="account" name="account" required>
                            <option value="">-- Select Account --</option>
                            <option value="savings">Savings Account</option>
                            <option value="loans">Loans Account</option>
                            <option value="entrance_fee">Entrance Fee</option>
                            <option value="share_deposits">Share Deposits</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="transaction_type" class="form-label">Transaction Type</label>
                        <select class="form-control" id="transaction_type" name="transaction_type" required>
                            <option value="">-- Select Transaction Type --</option>
                            <option value="savings">Savings</option>
                            <option value="loans">Loans</option>
                            <option value="entrance_fee">Entrance Fee</option>
                            <option value="share_deposits">Share Deposits</option>
                        </select>
                    </div>
                    <div class="mb-3" id="loanTypeDiv" style="display: none;">
                        <label for="loan_type" class="form-label">Select Loan Type</label>
                        <select class="form-control" id="loan_type" name="loan_type">
                            <option value="">-- Select Loan Type --</option>
                            <option value="personal">Personal Loan</option>
                            <option value="business">Business Loan</option>
                            <option value="emergency">Emergency Loan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="amount" class="form-label">Amount</label>
                        <input type="number" class="form-control" id="amount" name="amount" required>
                    </div>
                    <div class="mb-3">
                        <label for="payment_method" class="form-label">Payment Method</label>
                        <select class="form-control" id="payment_method" name="payment_method" required>
                            <option value="">-- Select Payment Method --</option>
                            <option value="cash">Cash</option>
                            <option value="bank">Bank Transfer</option>
                            <option value="mobile">Mobile Payment</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="date" class="form-label">Date of Remittance</label>
                        <input type="date" class="form-control" id="date" name="date" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>


                
            </div>
        </div>

    </div>
</div>
<script>
    document.getElementById('transaction_type').addEventListener('change', function() {
        let loanTypeDiv = document.getElementById('loanTypeDiv');
        if (this.value === 'loans') {
            loanTypeDiv.style.display = 'block';
        } else {
            loanTypeDiv.style.display = 'none';
        }
    });
    document.addEventListener("DOMContentLoaded", function() {
        let today = new Date().toISOString().split('T')[0]; // Get current date in YYYY-MM-DD format
        document.getElementById("date").value = today; // Set default value
    });

</script>
<?= $this->endSection() ?>


