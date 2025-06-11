<!DOCTYPE html>
<html>

<head>
    <title>Savings - <?= esc($member['member_number'])?></title>

    <link rel="shortcut icon" href="<?= base_url('assets/images/logo-sm.png') ?>" type="image/png">
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        .header,
        .footer {
            text-align: center;
        }

        .transactions {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .transactions th,
        .transactions td {
            border: 1px solid #ccc;
            padding: 5px;
        }

        .table-header {
            background-color: #bc0707;
            color: #fff;
        }
    </style>
</head>

<body>

    <div class="header">
        <?php
        $logoPath = FCPATH . 'assets/images/logo-sm.png';
        $logoBase64 = base64_encode(file_get_contents($logoPath));
        $logoSrc = 'data:image/png;base64,' . $logoBase64;
        ?>
        <img src="<?= $logoSrc ?>" alt="Logo" width="80">
        <h2><?= esc($organization['org_name']) ?></h2>
        <p><?= esc($organization['physical_address']) ?> | <?= esc($organization['phone']) ?> | <?= esc($organization['email']) ?></p>

    </div>
    <hr>

    <h3>Member Savings Statement</h3>
    <p><strong>Member:</strong> <?= esc($member['first_name'] . ' ' . $member['last_name']) ?> (<?= esc($member['member_number']) ?>)</p>

    <table class="transactions">
        <thead>
            <tr class="table-header">
                <th>Date</th>
                <th>Service Transaction</th>
                <th>Description</th>
                <th>Payment Method</th>
                <th>Amount</th>
                <th>Running Balance</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($transactions)): ?>
                <?php $runningBalance = 0; ?>
                <?php foreach ($transactions as $tx): ?>
                    <?php $runningBalance += $tx['amount']; ?>
                    <tr>
                        <td><?= esc($tx['transaction_date']) ?></td>
                        <td><?= esc($tx['service_transaction']) ?></td>
                        <td><?= esc($tx['description'] ?? '-') ?></td>
                        <td><?= esc($tx['payment_method']) ?></td>
                        <td><?= number_format($tx['amount'], 2) ?></td>
                        <td><?= number_format($runningBalance, 2) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" style="text-align: center;">No transactions found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>


</body>

</html>