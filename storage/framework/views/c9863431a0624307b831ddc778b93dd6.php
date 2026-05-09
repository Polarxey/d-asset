<!DOCTYPE html>
<html>
<head>
    <title>RMA - <?php echo e($asset->serial_number); ?></title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 11px; color: #000; line-height: 1.2; }
        .text-center { text-align: center; }
        .fw-bold { font-weight: bold; }
        .header-title { font-size: 14px; text-decoration: underline; margin-bottom: 20px; }
        .info-table { width: 100%; margin-bottom: 15px; }
        .info-table td { padding: 2px 0; vertical-align: top; }
        .checkbox { display: inline-block; width: 12px; height: 12px; border: 1px solid #000; text-align: center; line-height: 10px; font-family: DejaVu Sans, sans-serif; margin-right: 3px; }
        .fault-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .fault-table td { border: 1px solid #000; padding: 4px; }
        .signature-table { width: 100%; margin-top: 30px; }
        .signature-table td { width: 25%; text-align: center; vertical-align: top; }
        .sig-box { height: 60px; }
    </style>
</head>
<body>
    <div class="text-center header-title fw-bold">Return Material Authorization<br>(RMA)</div>

    <table class="info-table">
        <tr>
            <td style="width: 3%;">1.</td>
            <td style="width: 35%;">No. IO/SP2K/SO/PO/ANDOP</td>
            <td style="width: 2%;">:</td>
            <td><?php echo e($asset->id_pa); ?></td> </tr>
        <tr>
            <td>2.</td>
            <td>Valuation Type</td>
            <td>:</td>
            <td>
                <span class="checkbox"><?php echo $asset->valuation_type == 'Ex-Project' ? '&#10003;' : ''; ?></span> Ex-Project &nbsp;
                <span class="checkbox"><?php echo $asset->valuation_type == 'Dismantle' ? '&#10003;' : ''; ?></span> Dismantle &nbsp;
                <span class="checkbox"><?php echo $asset->valuation_type == 'Rusak-L' ? '&#10003;' : ''; ?></span> Rusak-L &nbsp;
                <span class="checkbox"><?php echo $asset->valuation_type == 'Rusak-TL' ? '&#10003;' : ''; ?></span> Rusak-TL
            </td>
        </tr>
        <tr>
            <td>3.</td>
            <td>Tanggal</td>
            <td>:</td>
            <td><?php echo e(\Carbon\Carbon::parse($asset->tanggal_masuk)->format('d/m/Y')); ?></td>
        </tr>
        <tr>
            <td>4.</td>
            <td>Lokasi asal</td>
            <td>:</td>
            <td><?php echo e($asset->lokasi_asal); ?></td>
        </tr>
        <tr>
            <td>5.</td>
            <td>Customer Name (CPE)</td>
            <td>:</td>
            <td><?php echo e($asset->customer_name); ?></td>
        </tr>
        <tr>
            <td>6.</td>
            <td>Merk</td>
            <td>:</td>
            <td><?php echo e($asset->merk); ?></td>
        </tr>
        <tr>
            <td>7.</td>
            <td>Serial Number (SN) / Batch</td>
            <td>:</td>
            <td><?php echo e($asset->serial_number); ?></td>
        </tr>
    </table>

    <div class="fw-bold" style="margin-top: 10px;">Beri Tanda Checker Pada Kotak Jika Material Rusak</div>
    <table class="fault-table">
        <tr>
            <td style="width: 50%;">
                <span class="checkbox"></span> 9. No Power / Mati Total<br>
                <span class="checkbox"></span> 10. Port Faulty (Ethernet/Optic)<br>
                <span class="checkbox"></span> 11. Alarm Indication (Red/Orange)<br>
                <span class="checkbox"></span> 12. Physical Damage (Pecah/Penyok)
            </td>
            <td>
                <span class="checkbox"></span> 20. Rectifier/Inverter fault<br>
                <span class="checkbox"></span> 21. Charging / Static switch fault<br>
                <span class="checkbox"></span> 22. Battery faulty / Drop
            </td>
        </tr>
    </table>

    <table class="signature-table">
        <tr>
            <td><div>Pemberi Tugas,</div><div class="sig-box"></div><div>( ............................ )</div></td>
            <td><div>TS,</div><div class="sig-box"></div><div>( ............................ )</div></td>
            <td><div>Gudang,</div><div class="sig-box"></div><div>( ............................ )</div></td>
            <td><div>Logistik,</div><div class="sig-box"></div><div>( ............................ )</div></td>
        </tr>
    </table>
</body>
</html><?php /**PATH D:\WINDOWS\XAMPP\htdocs\d-asset\resources\views/pdf/rma.blade.php ENDPATH**/ ?>