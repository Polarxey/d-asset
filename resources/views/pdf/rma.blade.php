<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>RMA - {{ $noRma }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Helvetica', Arial, sans-serif;
            font-size: 10pt;
            color: #000;
            line-height: 1.5;
        }
        .page { padding: 25mm 20mm 20mm 20mm; }

        /* HEADER */
        .header-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .header-table td { vertical-align: middle; padding: 0; }
        .logo { height: 45px; }
        .doc-title {
            text-align: right;
            font-size: 13pt;
            font-weight: bold;
            color: #003366;
            letter-spacing: 1px;
        }
        .doc-subtitle { text-align: right; font-size: 8pt; color: #666; margin-top: 2px; }

        /* META BOX */
        .meta-box {
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 10px 14px;
            margin-bottom: 18px;
            background: #f9f9f9;
        }
        .meta-box table { width: 100%; border-collapse: collapse; }
        .meta-box td { padding: 3px 0; font-size: 9.5pt; vertical-align: top; }
        .meta-box .label { color: #555; width: 38%; }
        .meta-box .colon { width: 4%; color: #555; }
        .meta-box .value { color: #000; font-weight: 600; }

        /* TITLE */
        .section-title {
            font-size: 10pt;
            font-weight: bold;
            color: #003366;
            border-bottom: 2px solid #003366;
            padding-bottom: 4px;
            margin-bottom: 12px;
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        /* INFO GRID */
        .info-grid { width: 100%; border-collapse: collapse; margin-bottom: 18px; }
        .info-grid td { padding: 5px 8px; font-size: 9.5pt; vertical-align: top; border-bottom: 1px solid #eee; }
        .info-grid .label { color: #555; width: 32%; }
        .info-grid .colon { width: 3%; }
        .info-grid .value { color: #000; font-weight: 600; }

        /* VALUATION BADGE */
        .valuation-badge {
            display: inline-block;
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffc107;
            border-radius: 3px;
            padding: 1px 6px;
            font-size: 8.5pt;
            font-weight: bold;
        }

        /* FOOTER / SIGNATURES */
        .sig-table { width: 100%; border-collapse: collapse; margin-top: 50px; }
        .sig-table td { width: 50%; text-align: center; vertical-align: top; padding: 0 15px; }
        .sig-box {
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 10px;
            min-height: 100px;
        }
        .sig-title { font-size: 9pt; color: #555; margin-bottom: 4px; }
        .sig-company { font-size: 10pt; font-weight: bold; color: #003366; }
        .sig-space { height: 65px; }
        .sig-name { font-size: 9pt; border-top: 1px solid #999; padding-top: 4px; color: #333; }

        /* LEGAL FOOTER */
        .doc-footer {
            margin-top: 30px;
            padding-top: 10px;
            border-top: 1px solid #ccc;
            font-size: 7.5pt;
            color: #999;
            text-align: center;
        }

        .no-rma-box {
            display: inline-block;
            background: #003366;
            color: #fff;
            padding: 3px 10px;
            border-radius: 3px;
            font-size: 9pt;
            font-weight: bold;
            letter-spacing: .5px;
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
                <div class="doc-title">RETURN MATERIAL AUTHORIZATION</div>
                <div class="doc-subtitle">Dokumen Pengembalian Perangkat · Divisi Teknik</div>
                <div style="text-align:right; margin-top:5px;">
                    <span class="no-rma-box">{{ $noRma }}</span>
                </div>
            </td>
        </tr>
    </table>

    {{-- META BOX --}}
    <div class="meta-box">
        <table>
            <tr>
                <td class="label">Tanggal Penerbitan RMA</td>
                <td class="colon">:</td>
                <td class="value">{{ \Carbon\Carbon::parse($tanggalRma)->translatedFormat('d F Y') }}</td>
                <td class="label" style="padding-left:20px;">Valuation Type</td>
                <td class="colon">:</td>
                <td><span class="valuation-badge">{{ $asset->valuation_type ?? '-' }}</span></td>
            </tr>
            <tr>
                <td class="label">ID PA</td>
                <td class="colon">:</td>
                <td class="value" style="font-family:monospace;">{{ $asset->id_pa ?? '-' }}</td>
                <td class="label" style="padding-left:20px;">Tgl Perangkat Masuk</td>
                <td class="colon">:</td>
                <td class="value">{{ $asset->tanggal_masuk?->translatedFormat('d F Y') ?? '-' }}</td>
            </tr>
        </table>
    </div>

    {{-- DETAIL PERANGKAT --}}
    <div class="section-title">Detail Perangkat</div>
    <table class="info-grid">
        <tr>
            <td class="label">Nama Perangkat</td>
            <td class="colon">:</td>
            <td class="value">{{ $asset->nama_perangkat }}</td>
        </tr>
        <tr>
            <td class="label">Merk / Pabrikan</td>
            <td class="colon">:</td>
            <td class="value">{{ $asset->merk ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Serial Number (S/N)</td>
            <td class="colon">:</td>
            <td class="value" style="font-family:monospace; color:#003366;">{{ $asset->serial_number }}</td>
        </tr>
        <tr>
            <td class="label">Lokasi Asal (Lapangan)</td>
            <td class="colon">:</td>
            <td class="value">{{ $asset->lokasi_asal ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Customer / Site (CPE)</td>
            <td class="colon">:</td>
            <td class="value">{{ $asset->customer_name ?? '-' }}</td>
        </tr>
    </table>

    {{-- STATUS SETELAH RMA --}}
    <div style="background:#e8f5e9; border:1px solid #a5d6a7; border-radius:4px; padding:9px 14px; margin-bottom:20px; font-size:9pt;">
        <strong style="color:#1b5e20;">✓ Status Perangkat Setelah RMA Ini Diterbitkan:</strong>
        Perangkat dengan S/N di atas telah dikembalikan ke gudang dan berstatus
        <strong>Ready (Available)</strong> untuk diproses lebih lanjut.
    </div>

    {{-- TANDA TANGAN --}}
    <table class="sig-table">
        <tr>
            <td>
                <div class="sig-box">
                    <div class="sig-title">Yang Menyerahkan,</div>
                    <div class="sig-company">PLN ICON PLUS</div>
                    <div class="sig-space"></div>
                    <div class="sig-name">( ............................................. )</div>
                    <div style="font-size:8pt; color:#777; margin-top:3px;">Penanggung Jawab Gudang</div>
                </div>
            </td>
            <td>
                <div class="sig-box">
                    <div class="sig-title">Bandung, {{ \Carbon\Carbon::parse($tanggalRma)->translatedFormat('d F Y') }}</div>
                    <div class="sig-title" style="margin-top:2px;">Yang Menerima,</div>
                    <div class="sig-company">PLN ICON PLUS</div>
                    <div class="sig-space"></div>
                    <div class="sig-name">( ............................................. )</div>
                    <div style="font-size:8pt; color:#777; margin-top:3px;">Petugas Lapangan / Teknisi</div>
                </div>
            </td>
        </tr>
    </table>

    {{-- DOC FOOTER --}}
    <div class="doc-footer">
        Dokumen ini diterbitkan secara digital oleh Sistem D-Asset · PLN ICON Plus Bandung ·
        Nomor: {{ $noRma }} · Dicetak: {{ now()->format('d/m/Y H:i') }}
    </div>

</div>
</body>
</html>
