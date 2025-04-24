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
                                        <h6>KES <?= number_format($savings ?? 0, 2) ?></h6>
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
                                        <h6><?= $shares['shares_owned'] ?? 0 ?> Shares</h6>
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
                                        <h6>KES <?= number_format($loans['balance'] ?? 0, 2) ?></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="card">

                            <div class="card-body">
                                <h5 class="card-title">Recent Transactions</h5>
                                
                            </div>

                        </div>
                    </div>

                    <div class="col-12">
                        <div class="card">

                            <div class="card-body">
                                <h5 class="card-title">Send SMS</h5>
                                <div>
                                    <textarea name="" class="form-control mb-2" id="sms-member" placeholder="Type message..."></textarea>
                                    <button id="send-sms-btn" class="btn btn-success">Send SMS</button>
                                </div>
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

                    </div>
                </div>

                <div class="card">

                    <div class="card-body pb-0">
                        <h5 class="card-title"> Generate Member Statements</h5>
                        <div class="d-flex flex-column gap-2">
                            <a href="<?= site_url('members/generate/' . $member['id']) ?>" class="btn btn-success">Generate Balances</a>
                            <a href="<?= site_url('members/generate/savings' . $member['id']) ?>" class="btn btn-success">Savings Statement</a>
                            <a href="<?= site_url('members/generate/shares' . $member['id']) ?>" class="btn btn-success">Share Capital</a>
                            <a href="<?= site_url('members/generate/loans' . $member['id']) ?>" class="btn btn-success">Loan Statement</a>
                            <a href="<?= site_url('members/generate/transactions' . $member['id']) ?>" class="btn btn-success">All Transactions</a>
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


<?= $this->endSection() ?>