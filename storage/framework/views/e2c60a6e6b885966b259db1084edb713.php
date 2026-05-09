<!DOCTYPE html>
<html>
<head>
    <title>BSTP - <?php echo e($transaction->no_bstp); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #000;
            line-height: 1.5;
        }
        .header {
            margin-bottom: 25px;
        }
        .logo {
            width: 140px;
        }
        .content {
            margin-bottom: 20px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 40px;
        }
        .table th, .table td {
            border: 1px solid #000;
            padding: 6px 8px;
            text-align: left;
        }
        .table th {
            text-align: center;
        }
        .footer-table {
            width: 100%;
        }
        .footer-table td {
            width: 50%;
            vertical-align: top;
            text-align: center;
        }
        .signature-space {
            height: 90px;
        }
    </style>
</head>
<body>

    <div class="header">
        <img src="<?php echo e(public_path('img/logo-icon.png')); ?>" class="logo">
    </div>

    <div class="content">
        <p>Telah diserah terimakan Aksesoris FO berikut ini dari PLN ICON Plus kepada <?php echo e($transaction->penerima); ?> untuk <?php echo e($transaction->lokasi_tujuan); ?> dengan rincian sebagai berikut:</p>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th style="width: 5%;">No.</th>
                <th style="width: 30%;">Nama Perangkat</th>
                <th style="width: 10%;">Satuan</th>
                <th style="width: 10%;">Jumlah</th>
                <th style="width: 45%;">Keterangan (SerialNumber)</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $transaction->details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td style="text-align: center;"><?php echo e($index + 1); ?></td>
                <td><?php echo e($detail->nama_perangkat); ?></td>
                <td style="text-align: center;"><?php echo e($detail->satuan); ?></td>
                <td style="text-align: center;"><?php echo e($detail->jumlah); ?></td>
                <td><?php echo e($detail->serial_numbers); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>

    <table class="footer-table">
        <tr>
            <td>
                <div>Yang Menyerahkan,</div>
                <div>Bandung, <?php echo e(\Carbon\Carbon::parse($transaction->tanggal_serah)->translatedFormat('d F Y')); ?></div>
                <div class="signature-space"></div>
                <div>(PLN ICON PLUS)</div>
            </td>
            <td>
                <div>Yang Menerima,</div>
                <div style="margin-top: 18px;"></div>
                <div class="signature-space"></div>
                <div>(<?php echo e($transaction->penerima); ?>)</div>
            </td>
        </tr>
    </table>

</body>
</html><?php /**PATH D:\WINDOWS\XAMPP\htdocs\d-asset\resources\views/pdf/bstp.blade.php ENDPATH**/ ?>