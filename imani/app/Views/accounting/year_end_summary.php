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
                    <p><?= esc($error) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <div class="card shadow border-none my-2 px-2">

            <div class="card-body px-0 pb-2 mt-3">

                <h2>Year-End Financial Summary for <?= esc($year) ?></h2>

                <h3>Income Accounts</h3>
                <table border="1">
                    <tr>
                        <th>Account</th>
                        <th>Amount</th>
                    </tr>
                    <?php foreach ($incomeAccounts as $account): ?>
                        <tr>
                            <td><?= esc($account['name']) ?></td>
                            <td><?= esc(number_format($account['balance'], 2)) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
                <p><strong>Total Income: </strong> <?= esc(number_format($totalIncome, 2)) ?></p>

                <h3>Expense Accounts</h3>
                <table border="1">
                    <tr>
                        <th>Account</th>
                        <th>Amount</th>
                    </tr>
                    <?php foreach ($expenseAccounts as $account): ?>
                        <tr>
                            <td><?= esc($account['name']) ?></td>
                            <td><?= esc(number_format($account['balance'], 2)) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
                <p><strong>Total Expenses: </strong> <?= esc(number_format($totalExpenses, 2)) ?></p>

                <h3>Net Profit</h3>
                <p><strong>Net Profit/Loss: </strong> <?= esc(number_format($netProfit, 2)) ?></p>

                <?php if ($netProfit >= 0): ?>
                    <p>Status: ✅ Profitable</p>
                <?php else: ?>
                    <p>Status: ❌ Loss</p>
                <?php endif; ?>

                <form action="<?= base_url('year-end/close') ?>" method="post">
                    <button type="submit">Close Year</button>
                </form>
            </div>
        </div>

    </div>
</div>


<?= $this->endSection() ?>