<!DOCTYPE html>
<html>

<head>
    <title>Cashbook Report <?= esc($startDate. 'to'.  $endDate)?></title>
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
        <img src="<?= base_url('writable/uploads/' . $organization['logo']) ?>" alt="Logo" height="80">
        <h2><?= esc($organization['org_name']) ?></h2>
        <p><?= esc($organization['physical_address']) ?> | <?= esc($organization['phone']) ?> | <?= esc($organization['email']) ?></p>

    </div>
    <hr>


    <h2>Cashbook Report</h2>
    <p>Period: <?= esc($startDate) ?> to <?= esc($endDate) ?></p>

    <table class="transactions">
        <thead>
            <tr class="table-header">
                <th>Date</th>
                <th>Reference</th>
                <th>Description</th>
                <th>Debit (KES)</th>
                <th>Credit (KES)</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($entries as $row): ?>
                <tr>
                    <td><?= esc($row['date']) ?></td>
                    <td><?= esc($row['reference']) ?></td>
                    <td><?= esc($row['description']) ?></td>
                    <td class="text-right"><?= number_format($row['debit'], 2) ?></td>
                    <td class="text-right"><?= number_format($row['credit'], 2) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>



</body>

</html>