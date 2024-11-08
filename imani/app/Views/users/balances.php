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

        <div class="card shadow border-none my-2 px-2 mb-3">

            <div class="card-body px-0 pb-2 pt-3">
                <h5>Upload Excel File Below</h5>
                <form action="<?= site_url('excel/upload'); ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="row mb-3">
                        <label for="inputNumber" class="col-sm-2 col-form-label">File Upload (.xlsx)</label>
                        <div class="col-sm-8">
                            <input class="form-control" type="file" id="formFile" name="file" required>
                        </div>
                        <div class="col-sm-2">
                            <button type="submit" class="btn btn-primary">Upload</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card shadow border-none my-2 px-2 pt-3">
            <h5>Current Balances</h5>
            <div class="card-body px-0 pb-2">

                <?php if (!empty($balances) && is_array($balances)) : ?>
                    <div class="table-responsive-md">
                        <table class="table table-hover" id="paymentsTable">
                            <thead>
                                <tr>
                                    <th>Member No.</th>
                                    <th>Shares</th>
                                    <th>Deposits</th>
                                    <th>Loan Balance</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($balances as $balance) : ?>
                                    <tr>
                                        <td><?= esc($balance['member_no']) ?></td>
                                        <td><?= esc(is_numeric($balance['shares']) ? number_format($balance['shares']) : $balance['shares']) ?></td>
                                        <td><?= esc(is_numeric($balance['deposits']) ? number_format($balance['deposits']) : $balance['deposits']) ?></td>
                                        <td><?= esc(is_numeric($balance['loan']) ? number_format($balance['loan']) : $balance['loan']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>

                        </table>
                    </div>
                <?php else : ?>
                    <h3>No Balances</h3>
                    <p>Unable to find any Balances for you.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function () {
    $('form').on('submit', function (event) {
        event.preventDefault();

        let formData = new FormData(this); // Create a FormData object from the form

        $.ajax({
            url: "<?= site_url('excel/upload'); ?>",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    alert(response.message); // Success message
                    location.reload();
                } else {
                    alert(response.message); // Error message
                }
            },
            error: function(xhr, status, error) {
                alert("An error occurred while uploading. Please try again.");
            }
        });
    });
});
</script>






    <?= $this->endSection() ?>