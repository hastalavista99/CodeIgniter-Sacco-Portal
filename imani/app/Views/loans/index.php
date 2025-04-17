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

                <?php if (!empty($loans) && is_array($loans)) : ?>
                    <div class="table-responsive-md my-3">
                        <table class="table table-hover" id="loansTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Member No.</th>
                                    <th>Loan Taken</th>
                                    <th>Loan Type</th>
                                    <th>Interest Method</th>
                                    <th>Loan Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($loans as $loan_item) : ?>
                                    <tr>
                                        <td><?= esc($loan_item['id']) ?></td>
                                        <td><?= esc($loan_item['member_first_name']) ?></td>
                                        <td><?= esc($loan_item['member_last_name']) ?></td>
                                        <td><?= esc($loan_item['member_number']) ?></td>
                                        <td><?= esc($loan_item['principal']) ?></td>
                                        <td><?= esc($loan_item['loan_name']) ?></td>
                                        <td><?= esc($loan_item['created_at']) ?></td>
                                        <td class="text-capitalize fw-bold"></td>
                                        <td><a class="btn btn-success btn-sm" href="<?= site_url('loans/view/' . $loan_item['id']) ?>">Details</a></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else : ?>
                    <h3>No Loans</h3>
                    <p>Unable to find any loans for you.</p>
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