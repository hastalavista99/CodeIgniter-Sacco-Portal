<!DOCTYPE html>
<html>

<head>
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
    </style>
</head>

<body>

    <div class="header">
        <h2><?= esc($organization['org_name']) ?></h2>
        <p><?= esc($organization['physical_address']) ?> | <?= esc($organization['phone']) ?> | <?= esc($organization['email']) ?></p>
        <img src="<?= base_url('writable/uploads/' . $organization['logo']) ?>" alt="Logo" height="80">
    </div>

    <h3>Member Statement</h3>
    <p><strong>Member:</strong> <?= esc($member['first_name'] . ' ' . $member['last_name']) ?> (<?= esc($member['member_number']) ?>)</p>

    <table class="transactions">
        <thead>
            <tr>
                <th>Date</th>
                <th>Account</th>
                <th>Description</th>
                <th>Debit</th>
                <th>Credit</th>
            </tr>
        </thead>
        <tbody>
        <?php if (!empty($transactions)): ?>
        <?php foreach ($transactions as $tx): ?>
            <tr>
                <td><?= date('Y-m-d', strtotime($tx['created_at'])) ?></td>
                <td><?= esc($tx['account_name']) ?></td>
                <td><?= esc($tx['description'] ?? '-') ?></td>
                <td><?= number_format($tx['debit'], 2) ?></td>
                <td><?= number_format($tx['credit'], 2) ?></td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="5" style="text-align: center;">No transactions found.</td>
        </tr>
    <?php endif; ?>
        </tbody>
    </table>

</body>

</html>