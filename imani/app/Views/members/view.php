<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?><?= esc($title) ?> <?= $this->endSection() ?>

<div class="row">
    <?= $this->section('content') ?>
    <?= $this->include('partials/sidebar') ?>
    <section class="section dashboard">
        <div class="row">

            <!-- Left side columns -->
            <div class="col-lg-8">
                <div class="row">


                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card sales-card">
                            <div class="card-body">
                                <h5 class="card-title">Total Savings</h5>
                                <div class="d-flex align-items-center">
                                    <div class="ps-3">
                                        <h6><small>KES</small> <?= number_format($savings ?? 0, 2) ?></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card revenue-card">
                            <div class="card-body">
                                <h5 class="card-title">Total Shares</h5>
                                <div class="d-flex align-items-center">
                                    <div class="ps-3">
                                        <h6><small>KES</small> <?= number_format($shares ?? 0, 2) ?></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card customers-card">
                            <div class="card-body">
                                <h5 class="card-title">Outstanding Loan</h5>
                                <div class="d-flex align-items-center">
                                    <div class="ps-3">
                                        <h6><small>KES</small> <?= number_format($loans['balance'] ?? 0, 2) ?></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="card">

                            <div class="card-body">
                                <h5 class="card-title">Recent Transactions</h5>
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered table-hover">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Date</th>
                                                <th>Service</th>
                                                <th>Amount</th>
                                                <th>Method</th>
                                                <th>Description</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($recentTransactions)): ?>
                                                <?php foreach ($recentTransactions as $tx): ?>
                                                    <tr>
                                                        <td><?= esc($tx['transaction_date']) ?></td>
                                                        <td><?= esc(ucwords(str_replace('_', ' ', $tx['service_transaction']))) ?></td>
                                                        <td><?= number_format($tx['amount'], 2) ?></td>
                                                        <td><?= esc(ucfirst($tx['payment_method'])) ?></td>
                                                        <td><?= esc($tx['description']) ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="6" class="text-center">No recent transactions found.</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-12">
                        <div class="card">

                            <div class="card-body">
                                <h5 class="card-title">Send SMS</h5>
                                <form id="smsForm">
                                    <input type="hidden" name="member-phone" id="member-phone" value="<?= $member['phone_number'] ?>">
                                    <textarea name="message" class="form-control mb-2" id="message" placeholder="Type message..."></textarea>
                                    <button type="submit" id="send-sms-btn" class="btn btn-success">Send SMS</button>
                                    <button class="btn btn-success" type="button" disabled="" id="loading-btn" style="display: none;">
                                        <span class="spinner-border spinner-border-sm" style="width: 16px !important; height: 16px;" role="status" aria-hidden="true"></span>
                                        Sending...
                                    </button>
                                </form>
                            </div>

                        </div>
                    </div>

                </div>
            </div><!-- End Left side columns -->

            <!-- Right side columns -->
            <div class="col-lg-4">

                <!-- Recent Activity -->
                <div class="card">


                    <div class="card-body">
                        <h5 class="card-title">Member Details</h5>

                        <ul class="list-group">
                            <li class="list-group-item"><strong>Member No:</strong> <?= $member['member_number'] ?></li>
                            <li class="list-group-item"><strong>Name:</strong> <?= $member['first_name'] ?> <?= $member['last_name'] ?></li>
                            <li class="list-group-item"><strong>Phone:</strong> <?= $member['phone_number'] ?></li>
                            <li class="list-group-item"><strong>Email:</strong> <?= $member['email'] ?></li>
                        </ul>
                        <a href="<?= site_url('members/all-info/'.$member['id']) ?>" class="btn btn-success mt-3">More Info</a>

                    </div>
                </div>

                <div class="card">

                    <div class="card-body pb-2">
                        <h5 class="card-title"> Generate Member Statements</h5>
                        <div class="d-flex flex-column gap-2">
                            <a href="<?= site_url('members/generate/' . $member['id']) ?>" class="btn btn-success" target="_blank">Generate Balances</a>
                            <a href="<?= site_url('members/generate/savings/' . $member['id']) ?>" class="btn btn-success" target="_blank">Savings Statement</a>
                            <a href="<?= site_url('members/generate/shares/' . $member['id']) ?>" class="btn btn-success" target="_blank">Share Capital</a>
                            <a href="<?= site_url('members/generate/loans/' . $member['id']) ?>" class="btn btn-success" target="_blank">Loan Statement</a>
                            <a href="<?= site_url('members/generate/transactions/' . $member['id']) ?>" class="btn btn-success" target="_blank">All Transactions</a>
                        </div>

                    </div>
                </div>

                <div class="card">
                    <div class="filter">
                    </div>
                    <div class="card-body pb-0">
                        <h5 class="card-title"><span></span></h5>
                    </div>
                </div>

            </div><!-- End Right side columns -->

        </div>
    </section>
</div>
</div>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        const smsForm = document.getElementById('smsForm');

        smsForm.addEventListener('submit', (e) => {
            e.preventDefault();

            const memberPhone = document.getElementById('member-phone').value;
            const message = document.getElementById('message').value;
            const sendBtn = document.getElementById('send-sms-btn');
            const loadingBtn = document.getElementById('loading-btn');

            if (message !== "") {
                sendBtn.style.display = 'none';
                loadingBtn.style.display = 'block';

                fetch('<?= site_url('/members/sms') ?>', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({
                            phone: memberPhone,
                            message: message
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        sendBtn.style.display = 'block';
                        loadingBtn.style.display = 'none';
                        if (data.success) {
                            alert('SMS sent successfully');
                        } else {
                            alert('SMS sending failed');
                        }
                    })
                    .catch(error => {
                        alert('SMS sending failed');
                        console.error(error);
                    });
            } else {
                alert("Cannot send empty message")
            }

        });
    });
</script>



<?= $this->endSection() ?>