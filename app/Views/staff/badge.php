<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Badge</title>
    <style>

        

        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .badge {
            width: 350px;
            height: 500px;
            margin: auto;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
            display: flex;
            flex-direction: column;
        }
        
        .badge-logo {
            display: flex;
            align-items: center;
            flex-direction: column;
            margin-bottom: 10px;
        }

        .top {
            background: #2c3e50;
            color: white;
            padding: 15px;
            text-align: center;
        }

        .top .badge-photo {
            border-radius: 50%;
            width: 100px;
            height: 100px;
            object-fit: cover;
            margin-bottom: 0px;
            border: 3px solid white;
        }

        .top h3 {
            margin: 5px 0 0 0;
            font-size: 20px;
        }

        .top p {
            margin: 2px 0;
            font-size: 14px;
        }

        .bottom {
            background: #ecf0f1;
            padding: 15px;
            text-align: center;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .bottom img {
            width: 120px;
            height: 120px;
            margin: 10px auto 0;
        }

        .print-button {
            margin-top: 15px;
            padding: 10px 20px;
            background: #3498db;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 50%;
            align-self: center;
        }

        @media print {
            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
                background: white;
            }

            .print-button {
                display: none;
            }

            .badge {
                box-shadow: none;
            }
        }
    </style>
</head>

<body>
    
    <div class="badge">
    <div class="top">
        <?php
        $logoPath = FCPATH . 'assets/images/logo-sm.png';
        $logoBase64 = base64_encode(file_get_contents($logoPath));
        $logoSrc = 'data:image/png;base64,' . $logoBase64;
        ?>
        <div class="badge-logo">
            <img src="<?= $logoSrc ?>" alt="Logo" width="40px">
            <p><?= esc($organization['org_name']) ?></p>
        </div>
        <img src="<?= base_url('uploads/staff/' . $staff['photo']) ?>" alt="Profile Photo" class="badge-photo">
        <h3><?= esc($staff['first_name'] . ' ' . $staff['last_name']) ?></h3>
        <p><?= esc($staff['position']) ?></p>
    </div>
    <div class="bottom">
        <p>Staff No: <strong><?= esc($staff['staff_number']) ?></strong></p>
        <img src="<?= base_url('uploads/qrcodes/' . $staff['staff_number'] . '.png') ?>" alt="QR Code">
        <button class="print-button" onclick="window.print()">Print</button>
    </div>
</div>



</body>

</html>