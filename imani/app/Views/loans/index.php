<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?><?= esc($title)?><?= $this->endSection() ?>

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
            <div class="d-flex justify-content-end mb-3">
                <div class="pt-1 pb-1 mb-1">
                    <h4 class="text-capitalize display-6 ps-3">Total: <?= esc($total); ?></h4>
                </div>

            </div>
            <div class="card-body px-0 pb-2">
                <div class="col-md-2 ms-3">
                    <!-- Export Button -->
                    <button id="exportButton" class="btn btn-success mb-2">Export selected</button>
                </div>
                
                <form method="GET" action="<?= site_url('filterPay') ?>" class="form-inline mb-3 row ms-1">
                    <div class="form-group col-md-3">
                        <label for="startDate">Start Date:</label>
                        <input type="date" name="startDate" id="startDate" class="form-control" value="<?= esc($startDate ?? '') ?>">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="endDate">End Date:</label>
                        <input type="date" name="endDate" id="endDate" class="form-control" value="<?= esc($endDate ?? '') ?>">
                    </div>

                    <div class="form-group col-md-2 mt-3">
                        <button type="submit" class="btn btn-primary ms-2 mt-2">Filter</button>
                    </div>
                </form>


                <?php if (!empty($payments) && is_array($payments)) : ?>
                    <div class="table-responsive-md">
                        <table class="table table-hover" id="paymentsTable">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" class="form-check-input" id="checkAll"></th>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Member No.</th>
                                    <th>Amount</th>
                                    <th>Trans ID</th>
                                    <th>BillRefNumber</th>
                                    <th>Paybill</th>
                                    <th>Time</th>
                                    <th>Edit name</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($payments as $payment_item) : ?>
                                    <tr id="paymentRow-<?= esc($payment_item['mp_id']) ?>" class="<?= $payment_item['exported'] ? 'table-info exported' : '' ?>">
                                        <td><input type="checkbox" class=" checkPayment" data-id="<?= esc($payment_item['mp_id']) ?>" <?= $payment_item['exported'] ? 'disabled' : '' ?>></td>
                                        <td><?= esc($payment_item['mp_id']) ?></td>
                                        <td><?= esc($payment_item['mp_name']) ?></td>
                                        <td><?= esc($payment_item['member_no'])?></td>
                                        <td><?= esc(number_format($payment_item['TransAmount'], 2)) ?></td>
                                        <td><?= esc($payment_item['TransID']) ?></td>
                                        <td><?= esc($payment_item['BillRefNumber']) ?></td>
                                        <td><?= esc($payment_item['ShortCode']) ?></td>
                                        <td><?= esc($payment_item['mp_date']) ?></td>
                                        <td><a href="<?= site_url('editPay?id=' . $payment_item['mp_id']) ?>"><i class="bi bi-pencil-square text-success"></i></a></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else : ?>
                    <h3>No Payments</h3>
                    <p>Unable to find any payments for you.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <script defer>
        // console.log('JavaScript loaded');
        document.getElementById('checkAll').addEventListener('click', function(e) {
            let checkboxes = document.querySelectorAll('.checkPayment');
            checkboxes.forEach(checkbox => checkbox.checked = e.target.checked);
        });

        document.getElementById('exportButton').addEventListener('click', function() {
            let selectedPayments = [];
            document.querySelectorAll('.checkPayment:checked').forEach(function(checkbox) {
                selectedPayments.push(checkbox.getAttribute('data-id'));
            });

            if (selectedPayments.length > 0) {
                fetch('<?= site_url('payments/export') ?>', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': '<?= csrf_hash() ?>' // Ensure CSRF token is included
                        },
                        body: JSON.stringify({
                            payment_ids: selectedPayments,
                            title: '<?= $title ?>'
                        })
                    })
                    .then(response => {
                        if (response.ok) {
                            // If the response is okay, return the blob
                            return response.blob();
                        } else {
                            // If there is an error, throw an error
                            return response.json().then(data => {
                                throw new Error(data.message || 'Failed to export payments.');
                            });
                        }
                    })
                    .then(blob => {
                        // Handle the blob response (Excel file)
                        const url = window.URL.createObjectURL(blob);
                        const a = document.createElement('a');
                        a.href = url;
                        a.download = "payments_export_" + new Date().toISOString().slice(0, 19).replace(/:/g, "-") + ".xlsx";
                        document.body.appendChild(a);
                        a.click();
                        a.remove();
                        window.URL.revokeObjectURL(url);

                        // Grey out exported rows
                        selectedPayments.forEach(id => {
                            let row = document.querySelector(`#paymentRow-${id}`);
                            if (row) {
                                row.classList.add('table-info');
                            }
                        });
                        setTimeout(function() {
                            location.reload();
                        }, 1000); // Reloads the page after 1 second

                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert(error.message);
                    });
            } else {
                alert('Please select at least one payment to export.');
            }
        });
    </script>


    <?= $this->endSection() ?>