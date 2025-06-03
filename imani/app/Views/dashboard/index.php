<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?>Dashboard <?= $this->endSection() ?>

<div class="row">
    <?= $this->section('content') ?>
    <?= $this->include('partials/sidebar') ?>
    <section class="section dashboard">
        <div class="row">


            <!-- Left side columns -->
            <div class="col-lg-8">
                <div class="row">

                    <!-- Sales Card -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card sales-card">

                            <div class="card-body">
                                <h5 class="card-title">Shares <span>| To Date</span></h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-currency-dollar"></i>
                                    </div>
                                    <?php if ($userInfo['role'] === 'member') { ?>
                                        <a href="<?= site_url('members/generate/shares/' . $member['id']) ?>" target="_blank">
                                            <div class="ps-3">
                                                <span class="">KES</span>
                                                <h6>
                                                    <?= isset($shares) && is_numeric($shares) ? esc(number_format($shares)) : '-' ?>
                                                </h6>

                                            </div>
                                        </a>
                                    <?php } else { ?>
                                        <div class="ps-3">
                                            <span class="">KES</span>
                                            <h6>
                                                <?= isset($shares) && is_numeric($shares) ? esc(number_format($shares)) : '-' ?>
                                            </h6>

                                        </div>
                                    <?php } ?>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Sales Card -->

                    <!-- Revenue Card -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card revenue-card">

                            <div class="card-body">
                                <h5 class="card-title">Deposits <span>| To Date</span></h5>

                                <div class="d-flex align-items-center">

                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-currency-dollar"></i>
                                    </div>
                                    <?php if ($userInfo['role'] === 'member') { ?>
                                        <a href="<?= site_url('members/generate/savings/' . $member['id']) ?>" target="_blank">
                                            <div class="ps-3">
                                                <span class="">KES</span>
                                                <h6>
                                                    <?= isset($savings) && is_numeric($savings) ? esc(number_format($savings)) : '-' ?>
                                                </h6>

                                            </div>
                                        </a>
                                    <?php } else { ?>
                                        <div class="ps-3">
                                            <span class="">KES</span>
                                            <h6>
                                                <?= isset($savings) && is_numeric($savings) ? esc(number_format($savings)) : '-' ?>
                                            </h6>

                                        </div>
                                    <?php } ?>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Revenue Card -->

                    <!-- Customers Card -->
                    <div class="col-xxl-4 col-xl-12">

                        <div class="card info-card customers-card">

                            <div class="card-body">
                                <?php if ($userInfo['role'] === 'member') { ?>
                                    <h5 class="card-title">Loan Balance <span></span></h5>
                                <?php } else { ?>
                                    <h5 class="card-title">Loans Given <span>| To Date</span></h5>
                                <?php } ?>


                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-currency-dollar"></i>
                                    </div>
                                    <?php if ($userInfo['role'] === 'member') { ?>
                                        <a href="<?= site_url('members/generate/loans/' . $member['id']) ?>" target="_blank">
                                            <div class="ps-3">
                                                <span class="">KES</span>
                                                <h6>
                                                    <?= isset($loans) && is_numeric($loans) ? esc(number_format($loans)) : '-' ?>
                                                </h6>
                                            </div>
                                        </a>
                                    <?php } else { ?>
                                        <div class="ps-3">
                                            <span class="">KES</span>
                                            <h6>
                                                <?= isset($loans) && is_numeric($loans) ? esc(number_format($loans)) : '-' ?>
                                            </h6>
                                        </div>
                                    <?php } ?>
                                </div>

                            </div>
                        </div>

                    </div>

                    <!-- Sales Card -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card sales-card">

                            <div class="card-body">
                                <h5 class="card-title">Active Loans <span>| To Date</span></h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-currency-dollar"></i>
                                    </div>
                                    <a href="<?= site_url('loans') ?>" target="_blank">
                                        <div class="ps-3">
                                            <span class="">KES</span>
                                            <h6>
                                                <?= isset($loans) && is_numeric($loans) ? esc(number_format($loans)) : '-' ?>
                                            </h6>

                                        </div>
                                    </a>

                                </div>
                            </div>

                        </div>
                    </div><!-- End Sales Card -->

                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card sales-card">

                            <div class="card-body">
                                <h5 class="card-title">Active Staff <span>| To Date</span></h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-person-badge"></i>
                                    </div>
                                    <a href="<?= site_url('staff') ?>" target="_blank">
                                        <div class="ps-3">

                                            <h6>
                                                <?= isset($staffNumber) && is_numeric($staffNumber) ? esc($staffNumber) : '-' ?>
                                            </h6>

                                        </div>
                                    </a>

                                </div>
                            </div>

                        </div>
                    </div>


                    <!-- Sales Card -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card sales-card">

                            <div class="card-body">
                                <h5 class="card-title">Members <span>| To Date</span></h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-people"></i>
                                    </div>
                                    <a href="<?= site_url('members/') ?>" target="_blank">
                                        <div class="ps-3">

                                            <h6>
                                                <?= isset($members) && is_numeric($members) ? esc($members) : '-' ?>
                                            </h6>

                                        </div>
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Sales Card -->
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Transactions <span>| Last 6 Months</span></h5>
                                <!-- Line Chart -->
                                <canvas id="lineChart" style="max-height: 400px;"></canvas>
                                <script>
                                    const ctx = document.getElementById('lineChart').getContext('2d');
                                    const lineChart = new Chart(ctx, {
                                        type: 'line',
                                        data: {
                                            labels: <?= json_encode($months) ?>,
                                            datasets: [{
                                                    label: 'Deposits',
                                                    data: <?= json_encode($depositData) ?>,
                                                    borderColor: '#2eca6a',
                                                    tension: 0.4,
                                                    fill: false
                                                },
                                                {
                                                    label: 'Shares',
                                                    data: <?= json_encode($sharesData) ?>,
                                                    borderColor: '#4154f1',
                                                    tension: 0.4,
                                                    fill: false
                                                },
                                                {
                                                    label: 'Repayments',
                                                    data: <?= json_encode($repaymentData) ?>,
                                                    borderColor: '#ff771d',
                                                    tension: 0.4,
                                                    fill: false
                                                }
                                            ]
                                        },
                                        options: {
                                            responsive: true,
                                            plugins: {
                                                legend: {
                                                    position: 'top'
                                                },
                                                title: {
                                                    display: true,
                                                    text: 'Monthly Transaction Activity'
                                                }
                                            },
                                            scales: {
                                                y: {
                                                    beginAtZero: true
                                                }
                                            }
                                        }
                                    });
                                </script>

                            </div>

                        </div>
                    </div>

                    <!-- Recent Sales -->
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Loans vs Repayments (Monthly)</h5>
                                <canvas id="loanRepaymentChart" style="max-height: 400px;"></canvas>
                                <script>
                                    const repayChart = document.getElementById('loanRepaymentChart').getContext('2d');
                                    new Chart(repayChart, {
                                        type: 'bar',
                                        data: {
                                            labels: <?= json_encode($months) ?>,
                                            datasets: [{
                                                    label: 'Loans Disbursed',
                                                    data: <?= json_encode($loansPerMonth) ?>,
                                                    backgroundColor: '#36A2EB'
                                                },
                                                {
                                                    label: 'Repayments',
                                                    data: <?= json_encode($repaymentsPerMonth) ?>,
                                                    backgroundColor: '#4BC0C0'
                                                }
                                            ]
                                        },
                                        options: {
                                            responsive: true,
                                            scales: {
                                                y: {
                                                    beginAtZero: true,
                                                    title: {
                                                        display: true,
                                                        text: 'Amount (KES)'
                                                    }
                                                },
                                                x: {
                                                    title: {
                                                        display: true,
                                                        text: 'Month'
                                                    }
                                                }
                                            },
                                            plugins: {
                                                legend: {
                                                    position: 'bottom'
                                                }
                                            }
                                        }
                                    });
                                </script>
                            </div>

                        </div>
                    </div><!-- End Recent Sales -->




                </div>
            </div><!-- End Left side columns -->

            <!-- Right side columns -->
            <div class="col-lg-4">

                <!-- Recent Activity -->
                <div class="card">
                    <div class="filter">
                        <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <li class="dropdown-header text-start">
                                <h6>Filter</h6>
                            </li>

                            <li><a class="dropdown-item" href="#">Today</a></li>
                            <li><a class="dropdown-item" href="#">This Month</a></li>
                            <li><a class="dropdown-item" href="#">This Year</a></li>
                        </ul>
                    </div>

                    <div class="card-body">
                        <h5 class="card-title">Recent Activity <span>| Today</span></h5>

                        <div class="activity">

                            <div class="activity-item d-flex">
                                <div class="activite-label">32 min</div>
                                <i class='bi bi-circle-fill activity-badge text-success align-self-start'></i>
                                <div class="activity-content">
                                    Coming Soon!!
                                </div>
                            </div><!-- End activity item-->

                            <div class="activity-item d-flex">
                                <div class="activite-label">56 min</div>
                                <i class='bi bi-circle-fill activity-badge text-danger align-self-start'></i>
                                <div class="activity-content">
                                    Coming Soon!!
                                </div>
                            </div><!-- End activity item-->

                            <div class="activity-item d-flex">
                                <div class="activite-label">2 hrs</div>
                                <i class='bi bi-circle-fill activity-badge text-primary align-self-start'></i>
                                <div class="activity-content">
                                    Coming Soon!!
                                </div>
                            </div><!-- End activity item-->

                            <div class="activity-item d-flex">
                                <div class="activite-label">1 day</div>
                                <i class='bi bi-circle-fill activity-badge text-info align-self-start'></i>
                                <div class="activity-content">
                                    Coming Soon!!
                                </div>
                            </div><!-- End activity item-->

                            <div class="activity-item d-flex">
                                <div class="activite-label">2 days</div>
                                <i class='bi bi-circle-fill activity-badge text-warning align-self-start'></i>
                                <div class="activity-content">
                                    Coming Soon!!
                                </div>
                            </div><!-- End activity item-->

                            <div class="activity-item d-flex">
                                <div class="activite-label">4 weeks</div>
                                <i class='bi bi-circle-fill activity-badge text-muted align-self-start'></i>
                                <div class="activity-content">
                                    Coming Soon!!
                                </div>
                            </div><!-- End activity item-->

                        </div>

                    </div>
                </div><!-- End Recent Activity -->

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Shares vs Member Savings <span>| Today</span></h5>
                        <canvas id="pieChart"></canvas>
                        <script>
                            const pieChart = document.getElementById('pieChart').getContext('2d');
                            new Chart(pieChart, {
                                type: 'pie',
                                data: {
                                    labels: ['Total Savings', 'Total Shares'],
                                    datasets: [{
                                        label: 'Shares vs Savings',
                                        data: [<?= $savings ?>, <?= $shares ?>],
                                        backgroundColor: ['#4154f1', '#2eca6a'],
                                        borderColor: ['#ffffff', '#ffffff'],
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    plugins: {
                                        legend: {
                                            position: 'bottom'
                                        }
                                    }
                                }
                            });
                        </script>
                    </div>
                </div>
            </div><!-- End Right side columns -->

        </div>
    </section>
</div>
</div>


<?= $this->endSection() ?>