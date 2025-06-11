<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?></title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            line-height: 1.2;
            margin: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        .no-border {
            border: none;
        }

        .center-align {
            text-align: center;
        }

        .bold {
            font-weight: bold;
        }

        .heading-table td {
            border: none;
            padding: 0;
            margin-bottom: 0px !important;
        }

        .details-table {
            margin-bottom: 20px;
            max-width: 200px;
        }

        .details-table td {
            padding: 5px;
            border: none;
        }

        .guarantor-table th,
        .guarantor-table td {
            border: 1px solid black;
        }
    </style>
</head>

<body>

    <!-- Header Table (Logo + Contact Info) -->
    <table class="heading-table">
        <tr>
            <td style="width: 100%;">
                <img src="<?= $base64 ?>" alt="Logo" height="80px">
            </td>
        </tr>
        <tr>
            <td style="text-align:center;">
                <p><strong>P.O. BOX:</strong> 8074-00200, NAIROBI&nbsp;&nbsp;&nbsp;
                    <strong>TEL:</strong> 0726 228 004 / 0788 872 544
                </p>
            </td>
        </tr>
        <tr>
            <td style="text-align:center; padding-bottom: 0px;">
                <p><strong>EMAIL:</strong> info@gloha-sacco.co.ke&nbsp;&nbsp;&nbsp;
                    <strong>WEBSITE:</strong> gloha-sacco.co.ke
                </p>
            </td>

        </tr>
    </table>

    <hr>

    <!-- Loan Details Title -->
    <h1 class="center-align"><?= esc($title) ?></h1>

    <!-- Member Details Section (Table) -->
    <table class="details-table">
        <tr>
            <td><strong>Name:</strong></td>
            <td><?= esc($loan['name']) ?></td>
        </tr>
        <tr>
            <td><strong>Member Number:</strong></td>
            <td><?= esc($loan['member_number']) ?></td>
        </tr>
        <tr>
            <td><strong>Mobile:</strong></td>
            <td><?= esc($loan['member_mobile']) ?></td>
        </tr>
        <tr>
            <td><strong>Email:</strong></td>
            <td><?= esc($loan['member_email']) ?></td>
        </tr>
        <tr>
            <td><strong>ID Number:</strong></td>
            <td><?= esc($loan['member_id']) ?></td>
        </tr>
        <tr>
            <td><strong>Employer:</strong></td>
            <td><?= esc($loan['employer']) ?></td>
        </tr>
        <tr>
            <td><strong>Station:</strong></td>
            <td><?= esc($loan['station']) ?></td>
        </tr>
        <tr>
            <td><strong>P.O. Box:</strong></td>
            <td><?= esc($loan['po_box'] . '-' . $loan['po_code'] . ', ' . $loan['po_city']) ?></td>
        </tr>
        <tr>
            <td><strong>Application Date:</strong></td>
            <td><?= esc($loan['apply_date'])?></td>
        </tr>
    </table>

    <!-- Loan and Disbursement Details Section (Table) -->
    <table>
        <tr>
            <td>
                <h3>Loan Details:</h3>
                <p><strong>Loan Type:</strong> <?= esc($loan['loan_type']) ?></p>
                <p><strong>Loan Amount:</strong> Ksh <?= number_format($loan['amount'], 2) ?></p>
                <p><strong>Loan Interest:</strong> Ksh <?= number_format($loan['interest'], 2) ?></p>
                <p><strong>Total Loan:</strong> Ksh <?= number_format($loan['total'], 2) ?></p>
                <p><strong>Repayment Period:</strong> <?= esc($loan['repay_period']) ?> months</p>
                <p><strong>Repayment Mode:</strong> <?= esc($loan['payment_mode']) ?></p>
            </td>
            <td>
                <h3>Disbursement Details:</h3>
                <p><strong>Bank Details:</strong> <?= esc($loan['bank'] . " - " . $loan['branch']) ?></p>
                <p><strong>Account Details:</strong> <?= esc($loan['account_number'] . " - " . $loan['account_name']) ?></p>
                <p><strong>Disbursement Type:</strong> <?= esc($loan['payment_type']) ?></p>
            </td>
        </tr>
    </table>

    <!-- Guarantors Table Section -->
    <div class="section">
        <h3>Guarantors:</h3>
        <?php if (!empty($guarantors) && is_array($guarantors)) : ?>
            <table class="guarantor-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Member Number</th>
                        <th>ID Number</th>
                        <th>Guarantee Amount</th>
                        <th>Response</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($guarantors as $guarantor) : ?>
                        <tr>
                            <td><?= esc($guarantor['member_name']) ?></td>
                            <td><?= esc($guarantor['member_number']) ?></td>
                            <td><?= esc($guarantor['id_number']) ?></td>
                            <td>Ksh <?= number_format($guarantor['amount'], 2) ?></td>
                            <td><?= esc($guarantor['responded']) ?></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        <?php else : ?>
            <p>No guarantors found.</p>
        <?php endif; ?>
    </div>

</body>

</html>