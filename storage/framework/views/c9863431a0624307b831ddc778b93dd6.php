<!DOCTYPE html>
<html>
<head>
    <title>RMA - <?php echo e($asset->serial_number); ?></title>
    <style>
        @page { margin: 0.8cm; }
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            color: #000;
            line-height: 1.3;
        }
        .text-center { text-align: center; }
        .fw-bold { font-weight: bold; }
        .header-title {
            font-size: 14px;
            text-decoration: underline;
            margin-bottom: 20px;
        }
        .info-table {
            width: 100%;
            margin-bottom: 10px;
            border-collapse: collapse;
        }
        .info-table td {
            padding: 3px 0;
            vertical-align: top;
        }
        .checkbox-container {
            display: inline-block;
            margin-right: 15px;
        }
        .checkbox {
            display: inline-block;
            width: 12px;
            height: 12px;
            border: 1px solid #000;
            text-align: center;
            line-height: 10px;
            font-family: DejaVu Sans, sans-serif;
            vertical-align: middle;
            margin-right: 4px;
        }
        .fault-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .fault-table td {
            border: 1px solid #000;
            padding: 6px;
            vertical-align: top;
            width: 50%;
        }
        .note-section {
            font-size: 8.5px;
            margin-top: 15px;
            line-height: 1.3;
        }
        .signature-table {
            width: 100%;
            margin-top: 30px;
            border-collapse: collapse;
        }
        .signature-table td {
            width: 50%;
            text-align: center;
            vertical-align: top;
        }
        .sig-box {
            height: 60px;
        }
    </style>
</head>
<body>

    <div class="text-center header-title fw-bold">
        Return Material Authorization<br>(RMA)
    </div>

    <table class="info-table">
        <tr>
            <td style="width: 3%;">1.</td>
            <td style="width: 38%;">No. IO/SP2K/SO/PO/ANDOP</td>
            <td style="width: 2%;">:</td>
            <td class="fw-bold"><?php echo e($asset->id_pa); ?></td>
        </tr>
        <tr>
            <td>2.</td>
            <td>Valuation Type</td>
            <td>:</td>
            <td>
                <div class="checkbox-container">
                    <span class="checkbox"><?php echo $asset->valuation_type == 'Ex-Project' ? '&#10003;' : ''; ?></span> Ex-Project
                </div>
                <div class="checkbox-container">
                    <span class="checkbox"><?php echo $asset->valuation_type == 'Dismantle' ? '&#10003;' : ''; ?></span> Dismantle
                </div>
                <div class="checkbox-container">
                    <span class="checkbox"><?php echo $asset->valuation_type == 'Rusak-L' ? '&#10003;' : ''; ?></span> Rusak-L
                </div>
                <div class="checkbox-container">
                    <span class="checkbox"><?php echo $asset->valuation_type == 'Rusak-TL' ? '&#10003;' : ''; ?></span> Rusak-TL
                </div>
            </td>
        </tr>
        <tr>
            <td>3.</td>
            <td>Tanggal</td>
            <td>:</td>
            <td><?php echo e(request('tanggal_rma') ? \Carbon\Carbon::parse(request('tanggal_rma'))->format('d/m/Y') : date('d/m/Y')); ?></td>
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
            <td>Type</td>
            <td>:</td>
            <td><?php echo e($asset->type); ?></td>
        </tr>
        <tr>
            <td>8.</td>
            <td>Serial Number (SN) / Batch</td>
            <td>:</td>
            <td class="fw-bold"><?php echo e($asset->serial_number); ?></td>
        </tr>
    </table>

    <div class="fw-bold" style="margin-top: 15px; margin-bottom: 5px;">Beri Tanda Checker Pada Kotak Jika Material Rusak</div>

    <table class="fault-table">
        <tr>
            <td>
                <span class="checkbox"></span> 7. Continue &nbsp;&nbsp; <span class="checkbox"></span> 8. Intermittent<br>
                <span class="checkbox"></span> 9. Dead on Arrival<br>
                <span class="checkbox"></span> 10. Dead on Operational<br>
                <span class="checkbox"></span> 11. BER Indication *)<br>
                <span class="checkbox"></span> 12. Software Error<br>
                <span class="checkbox"></span> 13. Tributary Error<br>
                <span class="checkbox"></span> 14. Channel Error<br>
                <span class="checkbox"></span> 15. Port Error<br>
                <span class="checkbox"></span> 16. Tx Laser Faulty<br>
                <span class="checkbox"></span> 17. Rx Laser Faulty<br>
                <span class="checkbox"></span> 18. Physical Damage<br>
                <span class="checkbox"></span> 19. Miscelaneous
            </td>
            <td>
                <span class="checkbox"></span> 20. Rectifier/Inverter fault (Input/Output Voltage/Current Fault)<br>
                <span class="checkbox"></span> 21. Charging/ static switc (Pengisian/Switch Rusak)<br>
                <span class="checkbox"></span> 22. Battery faulty (Battery Rusak/Drop)<br>
                <span class="checkbox"></span> 23. Number of Tribu : ____________<br>
                <span class="checkbox"></span> 24. Number of Chan : ____________<br>
                <span class="checkbox"></span> 25. Number of port : ____________<br>
                <div style="margin-top: 10px;">
                    Indikasi Error Lainnya:<br>
                    <div style="border-bottom: 1px dotted #000; height: 15px; width: 100%;"></div>
                </div>
            </td>
        </tr>
    </table>

    <div class="note-section">
        <strong>Note:</strong><br>
        <em>Continue</em> : Indikasi eror terjadi permanent terusmenerus &nbsp;|&nbsp; <em>Intermitent</em> : Indikasi eror terjadi kadang-kadang sangat random<br>
        <em>Dead on Arrival</em> : Perangkat mati total/rusak pada jangka waktu 24 jam setelah pemasangan<br>
        <em>Dead on Operational</em> : Perangkat mati total/rusak pd saat beroperasi normal<br>
        <em>BER indication*)</em> : Indikasi Error pada Display modul/NMS/hasil bertest (disertakan no.trib yg error) &nbsp;|&nbsp; <em>Software error</em> : Gangguan yang disebabkan Firmware/IOS/Internal Eprom<br>
        <em>Tributary error</em> : Low Order Modul Error (PDH/SDH) &nbsp;|&nbsp; <em>Channel error</em> : 64K channelize <2Mb Fault (for VFEM,V.24, Voice Ch)<br>
        <em>Port Error</em> : Port membangkitkan eror/mati total (IP Network Family, Konverter)<br>
        <em>Laser Tx Faulty</em> : Only Optical Modul TX Loss, No Signal, High Temp, Laser Bias &nbsp;|&nbsp; <em>Laser Rx Faulty</em> : Only Optical Modul No.RX, Frame Error<br>
        <em>Physical damage</em> : Rusak phisik perangkat. Benturan, Short Circuit, Liquid<br>
        <em>Miscelaneous</em> : Sebab lain yang tidak tertulis diatas, mohon indikasi dijelaskan.
    </div>

    <table class="signature-table">
        <tr>
            <td>
                <div style="font-size: 10px;">Engineer Asign</div>
                <div class="sig-box"></div>
                <div style="font-size: 10px;">Rizki Novitri</div>
            </td>
            <td>
                <div style="font-size: 10px;">Manager on Duty/Local Manager/Supervisor Sign,</div>
                <div class="sig-box"></div>
                <div style="font-size: 10px;">Name: ........................................</div>
            </td>
        </tr>
    </table>

    <div style="font-size: 9px; margin-top: 10px;">
        Master : Inventory<br>
        Copy &nbsp;&nbsp;: Technical Adm
    </div>

</body>
</html><?php /**PATH D:\WINDOWS\XAMPP\htdocs\d-asset\resources\views/pdf/rma.blade.php ENDPATH**/ ?>