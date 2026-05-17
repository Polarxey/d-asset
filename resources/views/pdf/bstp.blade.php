<!DOCTYPE html>
<html>
<head>
    <title>BSTP - {{ $transaction->no_bstp }}</title>
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
        <img src="{{ public_path('img/logo-icon.png') }}" class="logo">
    </div>

    <div class="content">
        <p>Telah diserah terimakan perangkat berikut ini dari PLN ICON Plus kepada {{ $transaction->penerima }} untuk {{ $transaction->lokasi_tujuan }} dengan rincian sebagai berikut:</p>
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
            @foreach($transaction->details as $index => $detail)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td>{{ $detail->nama_perangkat }}</td>
                <td style="text-align: center;">{{ $detail->satuan }}</td>
                <td style="text-align: center;">{{ $detail->jumlah }}</td>
                <td>{{ $detail->serial_numbers }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <table class="footer-table">
        <tr>
            <td>
                <div>Yang Menyerahkan,</div>
                <div>Bandung, {{ \Carbon\Carbon::parse($transaction->tanggal_serah)->translatedFormat('d F Y') }}</div>
                <div class="signature-space"></div>
                <div>(PLN ICON PLUS)</div>
            </td>
            <td>
                <div>Yang Menerima,</div>
                <div style="margin-top: 18px;"></div>
                <div class="signature-space"></div>
                <div>({{ $transaction->penerima }})</div>
            </td>
        </tr>
    </table>

</body>
</html>