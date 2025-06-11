<!DOCTYPE html>
<html>

<head>
    <title>Amortization Schedule</title>
    <link rel="shortcut icon" href="<?= base_url('assets/images/logo-sm.png') ?>" type="image/png">
    <style>
          body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 30px;
        }
        .header {
            text-align: center;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .loan-summary {
            margin-bottom: 20px;
        }

        .loan-summary table {
            width: 100%;
            border-collapse: collapse;
        }

        .loan-summary th,
        .loan-summary td {
            text-align: left;
            padding: 5px 10px;
        }

        .amortization-table {
            width: 100%;
            border-collapse: collapse;
        }

        .amortization-table th,
        .amortization-table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: right;
        }

        .amortization-table th {
            background-color: #bc0707;
            color: white;
        }

        .amortization-table td:first-child,
        .amortization-table th:first-child {
            text-align: center;
        }

        .footer {
            text-align: center;
            margin-top: 40px;
            font-size: 10px;
        }
        /* body {
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
        } */
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


    <h2>Amortization Schedule</h2>


    <div class="loan-summary">
        <table>
            <tr>
                <th>Loan ID:</th>
                <td><?= $loan['id'] ?></td>
                <th>Member :</th>
                <td><?= $member['first_name']. ' ' .$member['last_name'] ?></td>
            </tr>
            <tr>
                <th>Principal:</th>
                <td>KES <?= number_format($loan['principal'], 2) ?></td>
                <th>Interest Rate:</th>
                <td><?= $loan['interest_rate'] ?>%</td>
            </tr>
            <tr>
                <th>Repayment Period:</th>
                <td><?= $loan['repayment_period'] ?> months</td>
                <th>Start Date:</th>
                <td><?= $loan['request_date'] ?></td>
            </tr>
        </table>
    </div>

    <table class="amortization-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Due Date</th>
                <th>Principal (KES)</th>
                <th>Interest (KES)</th>
                <th>Total Repayment (KES)</th>
                <th>Remaining Balance (KES)</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($schedule as $row): ?>
                <tr>
                    <td><?= $row['installment'] ?></td>
                    <td><?= $row['due_date'] ?></td>
                    <td><?= number_format($row['principal'], 2) ?></td>
                    <td><?= number_format($row['interest'], 2) ?></td>
                    <td><?= number_format($row['total'], 2) ?></td>
                    <td><?= number_format($row['balance'], 2) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="footer">
        Generated on <?= date('Y-m-d H:i') ?> by SACCO System
    </div>


</body>

</html>