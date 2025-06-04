<!DOCTYPE html>
<html>

<head>
    <title>General Ledger</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        .header,
        .footer {
            text-align: center;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th,
        .table td {
            border: 1px solid #ccc;
            padding: 6px;
        }

        .table-header {
            background-color: #bc0707;
            color: white;
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
        <img src="<?= $logoSrc ?>" width="80">
        <h2><?= esc($organization['org_name']) ?></h2>
        <p><?= esc($organization['physical_address']) ?> | <?= esc($organization['phone']) ?> | <?= esc($organization['email']) ?></p>
        <h3>General Ledger Report</h3>
        <p><?= esc($startDate) ?> to <?= esc($endDate) ?></p>
    </div>

    <table class="table">

    Controller methods for exporting to PDF and Excel.

    PDF template matching your current style.

    Excel export using PhpSpreadsheet.

        <thead>
            <tr class="table-header">
                <th>Date</th>
                <th>Account</th>
                <th>Description</th>
                <th>Debit</th>
                <th>Credit</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($entries as $entry): ?>
                <tr>
                    <td><?= esc($entry['date']) ?></td>
                    <td><?= esc($entry['account_name']) ?></td>
                    <td><?= esc($entry['description']) ?></td>
                    <td><?= number_format($entry['debit'], 2) ?></td>
                    <td><?= number_format($entry['credit'], 2) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>