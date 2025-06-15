<!DOCTYPE html>
<html>

<head>
    <title>Loan Statement - <?= esc($member['member_number'])?></title>
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
            padding: 4px;
        }

        .table-header {
            background-color: #bc0707;
            color: #fff;
        }

        .loan-section { 
            margin-bottom: 30px; 
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


<h3>Loan Statement for <?= esc($member['first_name'] . ' ' . $member['last_name']) ?> (<?= esc($member['member_number']) ?>)</h3>
    <?php if (empty($loanStatements)): ?>
        <p>No loans found for this member.</p>
    <?php else: ?>
        <?php foreach ($loanStatements as $stmt): ?>
            <div class="loan-section">
                <h5>Loan: <?= esc($stmt['loan']['loan_name']) ?> (Requested on <?= esc($stmt['loan']['request_date']) ?>)</h5>
                <p>
                    Principal: <?= number_format($stmt['loan']['principal'], 2) ?> |
                    Disbursed: <?= number_format($stmt['loan']['disburse_amount'], 2) ?> |
                    Repayment Period: <?= esc($stmt['loan']['repayment_period']) ?> months
                </p>

                <?php if (!empty($stmt['loan']['guarantors'])): ?>
                    <p>Guarantors:</p>
                    <ul>
                        <?php foreach ($stmt['loan']['guarantors'] as $g): ?>
                            <li><?= esc($g['name']) ?> (<?= esc($g['guarantor_member_no']) ?>): <?= number_format($g['amount'], 2) ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

                <table class="transactions">
                    <thead>
                        <tr class="table-header">
                            <th>Installment</th>
                            <th>Due Date</th>
                            <th>Due Principal</th>
                            <th>Due Interest</th>
                            <th>Total Due</th>
                            <th>Amount Paid</th>
                            <th>Payment Date</th>
                            <th>Method</th>
                            <th>Running Balance</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            if (empty($stmt['repayments'])): ?>
                                <tr><td colspan="8">No repayments yet.</td></tr>
                        <?php else: 
                            foreach ($stmt['repayments'] as $i => $r): ?>
                            <tr>
                                <td><?= esc($r['installment_number']) ?></td>
                                <td><small><?= esc($r['due_date']) ?></small></td>
                                <td><?= number_format($r['principal_due'], 2) ?></td>
                                <td><?= number_format($r['interest_due'], 2) ?></td>
                                <td><?= number_format($r['amount_due'], 2) ?></td>
                                <td><?= number_format($r['amount_paid'], 2) ?></td>
                                <td><?= esc($r['payment_date']) ?></td>
                                <td><?= esc($r['payment_method']) ?></td>
                                <td><?= number_format($r['running_balance'], 2) ?></td>
                            </tr>
                        <?php endforeach; endif; ?>
                    </tbody>
                </table>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
            </tbody>
        </table>


</body>

</html>