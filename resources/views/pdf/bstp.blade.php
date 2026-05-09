<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>BSTP - {{ $transaction->no_bstp }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Helvetica', Arial, sans-serif; font-size: 10pt; color: #000; line-height: 1.5; }
        .page { padding: 20mm 20mm 20mm 20mm; }

        .header-table { width: 100%; border-collapse: collapse; margin-bottom: 18px; }
        .header-table td { vertical-align: middle; }
        .logo { height: 45px; }
        .doc-title { text-align: right; font-size: 13pt; font-weight: bold; color: #003366; letter-spacing: 1px; }
        .doc-subtitle { text-align: right; font-size: 8pt; color: #666; margin-top: 2px; }

        .divider { border: none; border-top: 2px solid #003366; margin: 10px 0 16px; }

        .body-text { font-size: 10pt; text-align: justify; margin-bottom: 14px; line-height: 1.7; }

        /* MAIN TABLE */
        table.main-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table.main-table th {
            background-color: #003366;
            color: #fff;
            padding: 7px 10px;
            text-align: center;
            font-size: 9.5pt;
            font-weight: bold;
            border: 1px solid #003366;
        }
        table.main-table td {
            border: 1px solid #ccc;
            padding: 7px 10px;
            font-size: 9.5pt;
            vertical-align: top;
        }
        table.main-table tr:nth-child(even) td { background: #f5f8ff; }
        .text-center { text-align: center; }

        /* SIGNATURES */
        .sig-table { width: 100%; border-collapse: collapse; margin-top: 45px; table-layout: fixed; }
        .sig-table td { width: 50%; text-align: center; vertical-align: top; padding: 0 12px; }
        .sig-title { font-size: 9.5pt; color: #333; }
        .sig-company { font-size: 10pt; font-weight: bold; color: #003366; }
        .sig-space { height: 70px; }
        .sig-line { border-top: 1px solid #333; margin: 0 10px; padding-top: 4px; font-size: 9pt; color: #333; }
        .sig-role { font-size: 8pt; color: #777; margin-top: 2px; }

        .doc-footer {
            margin-top: 25px;
            padding-top: 8px;
            border-top: 1px solid #ccc;
            font-size: 7.5pt;
            color: #999;
            text-align: center;
        }

        .no-bstp-badge {
            display: inline-block;
            background: #003366;
            color: #fff;
            padding: 3px 10px;
            border-radius: 3px;
            font-size: 9pt;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="page">

    {{-- HEADER --}}
    <table class="header-table">
        <tr>
            <td style="width:50%;">
                @if(!empty($logoBase64))
                    <img src="{{ $logoBase64 }}" class="logo">
                @else
                    <span style="font-size:13pt; font-weight:bold; color:#003366;">PLN ICON PLUS</span>
                @endif
                <div style="font-size:7.5pt; color:#555; margin-top:3px;">PT PLN Icon Plus · Regional Jawa Barat</div>
            </td>
            <td>
                <div class="doc-title">BERITA ACARA SERAH TERIMA PERANGKAT</div>
                <div class="doc-subtitle">Bukti Serah Terima Perangkat Telekomunikasi</div>
                <div style="text-align:right; margin-top:5px;">
                    <span class="no-bstp-badge">{{ $transaction->no_bstp }}</span>
                </div>
            </td>
        </tr>
    </table>
    <hr class="divider">

    {{-- BODY TEXT --}}
    <div class="body-text">
        Pada hari ini telah diserah terimakan perangkat dari <strong>PLN ICON Plus</strong>
        kepada <strong>{{ $transaction->penerima }}</strong>
        untuk keperluan <strong>{{ $transaction->lokasi_tujuan }}</strong>
        pada tanggal <strong>{{ $transaction->tanggal_serah->translatedFormat('d F Y') }}</strong>,
        dengan rincian perangkat sebagai berikut:
    </div>

    {{-- TABEL PERANGKAT --}}
    <table class="main-table">
        <thead>
            <tr>
                <th style="width:5%;">No.</th>
                <th style="width:38%;">Nama Perangkat</th>
                <th style="width:10%;">Satuan</th>
                <th style="width:8%;">Jumlah</th>
                <th style="width:39%;">Serial Number</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaction->details as $index => $detail)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $detail->nama_perangkat }}</td>
                <td class="text-center">{{ $detail->satuan }}</td>
                <td class="text-center"><strong>{{ $detail->jumlah }}</strong></td>
                <td style="font-family:monospace; font-size:8.5pt; word-break:break-all;">{{ $detail->serial_numbers }}</td>
            </tr>
            @endforeach
            {{-- Total row --}}
            <tr>
                <td colspan="3" style="text-align:right; font-weight:bold; background:#f0f0f0;">Total Perangkat</td>
                <td class="text-center" style="font-weight:bold; background:#f0f0f0;">{{ $transaction->details->sum('jumlah') }}</td>
                <td style="background:#f0f0f0;"></td>
            </tr>
        </tbody>
    </table>

    {{-- SIGNATURES --}}
    <table class="sig-table">
        <tr>
            <td>
                <div class="sig-title">Yang Menyerahkan,</div>
                <div class="sig-company">PLN ICON PLUS</div>
                <div class="sig-space"></div>
                <div class="sig-line">( ............................................. )</div>
                <div class="sig-role">Penanggung Jawab Gudang</div>
            </td>
            <td>
                <div class="sig-title">Bandung, {{ $transaction->tanggal_serah->translatedFormat('d F Y') }}</div>
                <div class="sig-title" style="margin-top:2px;">Yang Menerima,</div>
                <div class="sig-company">{{ $transaction->penerima }}</div>
                <div class="sig-space"></div>
                <div class="sig-line">( ............................................. )</div>
                <div class="sig-role">Penanggung Jawab Lapangan</div>
            </td>
        </tr>
    </table>

    <div class="doc-footer">
        Dokumen ini diterbitkan oleh Sistem D-Asset · PLN ICON Plus Bandung ·
        No. BSTP: {{ $transaction->no_bstp }} · Dicetak: {{ now()->format('d/m/Y H:i') }}
    </div>

</div>
</body>
</html>
