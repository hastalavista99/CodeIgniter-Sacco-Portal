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
                                        <h6>KES <?= number_format($savings['total'] ?? 0, 2) ?></h6>
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
                                <h5 class="card-title"> Generate Member Statement</h5>

<a href="<?= site_url('members/generate/'.$member['id']) ?>" class="btn btn-success">Generate</a>

                            </div>

                        </div>
                    </div>

                    <div class="col-12">
                        <div class="card recent-sales overflow-auto">

                            <div class="filter">

                            </div>

                            <div class="card-body">
                                <h5 class="card-title"><span></span></h5>


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
                    <div class="filter">

                    </div>

                    <div class="card-body pb-0">
                        <h5 class="card-title"><span></span></h5>



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