<!DOCTYPE html>
<html>

<head>
    <title>Member Statement - <?= esc($member['member_number'])?></title>

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
            text-align: center;
        }

        .table-header {
            background-color: #bc0707;
            color: #fff;
        }

        h4 {
            text-align: center;
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

    <h3>Member Statement</h3>
    <p><strong>Member:</strong> <?= esc($member['first_name'] . ' ' . $member['last_name']) ?> (<?= esc($member['member_number']) ?>)</p>

    <table class="transactions">
        <thead>
            <tr class="table-header">
                <th>Balance Type</th>
                <th>Current Balance</th>

            </tr>
        </thead>
        <tbody>
            <?php if (!empty($transactions)): ?>
                <tr>
                    <td><b>Shares</b></td>
                    <td>
                        <h4><?= number_format($shares, 2) ?></h4>
                    </td>
                </tr>
                <tr>
                    <td><b>Savings</b></td>
                    <td>
                        <h4><?= number_format($savings, 2) ?></h4>
                    </td>
                </tr>
                <tr>
                    <td><b>Loans</b></td>
                    <td>
                        <h4><?= number_format($loan_balance[0]['balance'], 2) ?></h4>
                    </td>
                </tr>
            <?php else: ?>
                <tr>
                    <td colspan="5" style="text-align: center;">No transactions found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>

</html>