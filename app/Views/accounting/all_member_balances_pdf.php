<!DOCTYPE html>
<html>

<head>
    <title>Value Balances</title>
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
        <p><?= esc($organization['physical_address']) ?> | <?= esc($organization['phone']) ?> |
            <?= esc($organization['email']) ?></p>

    </div>
    <hr>


    <h2>Value Balances Report</h2>

    <table class="transactions">
        <thead>
            <th>#</th>
            <th>Member No</th>
            <th>Name</th>
            <th>Savings</th>
            <th>Shares</th>
            <th>Loan Balance</th>
        </thead>
        <tbody>
            <?php foreach ($rows as $index => $row): ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= esc($row['member_number']) ?></td>
                    <td><?= esc($row['name']) ?></td>
                    <td><?= esc($row['savings']) ?></td>
                    <td><?= esc($row['shares']) ?></td>
                    <td><?= esc($row['loan_balance']) ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>



</body>

</html>