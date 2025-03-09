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
        <div class="card shadow border-none my-2 px-2">

            <div class="card-body px-0 pb-2">

                <form action="<?= site_url('accounting/journal-entry') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="row mt-3 mx-3">
                        <div class="mb-3 col-4">
                            <label for="transaction_date">Transaction Date:</label>
                            <input type="date" id="transaction_date" name="transaction_date" class="form-control" required>
                        </div>
                        <div class="mb-3 col-4">
                            <label for="reference">Reference:</label>
                            <input type="text" id="reference" class="form-control" name="reference" required>
                        </div>
                        <div class="mb-3 col-4">
                            <label for="description">Description:</label>
                            <textarea id="description" class="form-control" name="description" required></textarea>
                        </div>


                        <div class="col-10">
                            <h3>Journal Entries</h3>
                            <table id="journal-entries" class="w-100 mb-2">
                                <tr>
                                    <th class="px-2">Account</th>
                                    <th class="px-2">Debit</th>
                                    <th class="px-2">Credit</th>
                                    <th class="px-2">Action</th>
                                </tr>
                                <tr class="p-3">
                                    <td class="px-2">
                                        <select name="accounts[]" class="form-control" required>
                                            <option value="">Select Account</option>
                                            <option value="Cash">Cash</option>
                                            <option value="Revenue">Revenue</option>
                                            <option value="Expense">Expense</option>
                                        </select>
                                    </td>
                                    <td class="px-2"><input type="number" class="form-control" name="debit[]" step="0.01"></td>
                                    <td class="px-2"><input type="number" class="form-control" name="credit[]" step="0.01"></td>
                                    <td ><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">Remove</button></td>
                                </tr>
                            </table>

                            <button type="button" class="btn btn-primary ms-2
                            " onclick="addRow()">Add Entry</button><br><br>
                        </div>
                    </div>

                    <div class="d-flex justify-content-evenly">
                        <a href="<?= site_url('accounting/journals/page')?>" class="btn btn-info"><i class="bi-arrow-left me-1"></i>Back to List</a>
                        <button type="submit" class="btn btn-success"><i class="bi-journal-arrow-down me-1"></i>Save Journal Entry</button>

                    </div>

                </form>

                <script>
                    function addRow() {
                        let table = document.getElementById('journal-entries');
                        let row = table.insertRow();
                        row.innerHTML = `
                <td class="px-2">
                    <select name="accounts[]" required class="form-control" >
                        <option value="">Select Account</option>
                        <option value="Cash">Cash</option>
                        <option value="Revenue">Revenue</option>
                        <option value="Expense">Expense</option>
                    </select>
                </td>
                <td class="px-2"><input type="number" class="form-control" name="debit[]" step="0.01"></td>
                <td class="px-2"><input type="number" class="form-control" name="credit[]" step="0.01"></td>
                <td><button type="button" class="btn btn-danger btn-sm"  onclick="removeRow(this)">Remove</button></td>
            `;
                    }

                    function removeRow(button) {
                        let row = button.parentNode.parentNode;
                        row.parentNode.removeChild(row);
                    }
                </script>
            </div>
        </div>

    </div>
</div>  
<?= $this->endSection() ?>