<!DOCTYPE html>
<html>

<head>
    <title>Trial Balance</title>
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

<h1>Trial Balance</h1>
    <table class="transactions">
        <thead>
            <tr class="table-header">
                <th>Account</th>
                <th>Debit (KES)</th>
                <th>Credit (KES)</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($trialBalance as $item): ?>
                <tr>
                    <td><?= esc($item['account_name']) ?></td>
                    <td><?= number_format($item['debit'], 2) ?></td>
                    <td><?= number_format($item['credit'], 2) ?></td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <th>Total</th>
                <th><?= number_format($totalDebit, 2) ?></th>
                <th><?= number_format($totalCredit, 2) ?></th>
            </tr>
        </tbody>
    </table>
</body>

</html>