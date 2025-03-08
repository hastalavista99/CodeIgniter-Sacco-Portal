<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?>Dashboard <?= $this->endSection() ?>
    
<div class="row">
    <?= $this->section('content') ?>
    <?= $this->include('partials/sidebar') ?>
    <section class="section dashboard">
        <div class="row">
            <?php if (!$hasMemberNo): ?>
                <!-- Modal  for member number input -->
                <div id="memberNoModal" class="modal fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full" style="display: none;">
                    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                        <div class="mt-3 text-center">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Enter Member Number</h3>
                            <div class="mt-2 px-7 py-2">
                                <p class="text-sm text-gray-500">
                                    Please enter your member number to continue.
                                </p>
                                <input type="text" id="member_no" class="mt-2 w-full px-3 py-2 border rounded-md text-uppercase" placeholder="Member Number">
                            </div>
                            <div class="items-center px-4">
                                <button id="submitMemberNo" class="px-4 py-2 btn btn-success">
                                    Submit
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal functionality and submission of information -->
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const modal = document.getElementById('memberNoModal');
                        modal.style.display = 'block';

                        document.getElementById('submitMemberNo').addEventListener('click', function() {
                            const memberNo = document.getElementById('member_no').value;

                            if (!memberNo) {
                                alert('Please enter a member number');
                                return;
                            }

                            // Send AJAX request
                            fetch('<?= base_url('dashboard/updateMemberNo') ?>', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/x-www-form-urlencoded',
                                        'X-Requested-With': 'XMLHttpRequest',
                                        'X-CSRF-TOKEN': '<?= csrf_hash() ?>'
                                    },
                                    body: 'member_no=' + encodeURIComponent(memberNo)
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        modal.style.display = 'none';
                                        // Reload the page to refresh the dashboard data
                                        window.location.reload();
                                    } else {
                                        alert(data.message);
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    alert('An error occurred while updating member number');
                                });
                        });
                    });
                </script>
            <?php endif; ?>

            <!-- Left side columns -->
            <div class="col-lg-8">
                <div class="row">

                    <!-- Sales Card -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card sales-card">

                            <div class="card-body">
                                <h5 class="card-title">Shares <span>| This Month</span></h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-currency-dollar"></i>
                                    </div>
                                    <div class="ps-3">
                                        <span class="">KES</span>
                                        <h6>
                                            <?= isset($balance['shares']) && is_numeric($balance['shares']) ? esc(number_format($balance['shares'])) : '-' ?>
                                        </h6>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Sales Card -->

                    <!-- Revenue Card -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card revenue-card">

                            <div class="card-body">
                                <h5 class="card-title">Deposits <span>| This Month</span></h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-currency-dollar"></i>
                                    </div>
                                    <div class="ps-3">
                                        <span class="">KES</span>
                                        <h6>
                                            <?= isset($balance['deposits']) && is_numeric($balance['deposits']) ? esc(number_format($balance['deposits'])) : '-' ?>
                                        </h6>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Revenue Card -->

                    <!-- Customers Card -->
                    <div class="col-xxl-4 col-xl-12">

                        <div class="card info-card customers-card">

                            <div class="card-body">
                                <h5 class="card-title">Loan Balance <span></span></h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-currency-dollar"></i>
                                    </div>
                                    <div class="ps-3">
                                        <span class="">KES</span>
                                        <h6>
                                            <?= isset($balance['loan']) && is_numeric($balance['loan']) ? esc(number_format($balance['loan'])) : '-' ?>
                                        </h6>

                                    </div>
                                </div>

                            </div>
                        </div>

                    </div><!-- End Customers Card -->

                    <!-- Recent Sales -->
                    <div class="col-12">
                        <div class="card recent-sales overflow-auto">

                            <div class="card-body">
                                <h5 class="card-title">Recent Transactions</h5>
                                <?php if (!empty($payments) && is_array($payments)) : ?>
                                    <table class="table table-borderless datatable">
                                        <thead>
                                            <tr>
                                                <th scope="col">Name</th>
                                                <th scope="col">TransID</th>
                                                <th scope="col">BillRefNumber</th>
                                                <th scope="col">Amount</th>
                                                <th scope="col">Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($payments as $payment_item) : ?>
                                                <tr>
                                                    <td><?= esc($payment_item['mp_name']) ?></td>
                                                    <td><?= esc($payment_item['TransID']) ?></td>
                                                    <td><?= esc($payment_item['BillRefNumber']) ?></td>
                                                    <td><?= esc(number_format($payment_item['TransAmount'], 2)) ?></td>
                                                    <td><?= esc($payment_item['mp_date']) ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                <?php else : ?>
                                    <h3>No Payments</h3>
                                    <p>Unable to find any payments for you.</p>
                                <?php endif; ?>

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
            </div><!-- End Right side columns -->

        </div>
    </section>
</div>
</div>


<?= $this->endSection() ?>