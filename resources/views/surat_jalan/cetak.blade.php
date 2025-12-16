<!DOCTYPE html>
<html>
<head>
    <title>Surat Jalan</title>
    <style>
        @media print {
            @page {
                margin: 0;
            }
            body {
                margin: 1cm;
            }
            header, footer {
                display: none !important;
            }
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        h2 {
            text-align: center;
            font-size: 16px;
            margin-bottom: 5px;
        }
        .kop {
            width: 100%;
            display: table;
            margin-bottom: 10px;
            border-top: 2px solid black;
            border-bottom: 2px solid black;
            padding: 5px 0;
        }
        .kop .left {
            display: table-cell;
            width: 70%;
            vertical-align: top;
        }
        .kop .right {
            display: table-cell;
            text-align: right;
            width: 30%;
            vertical-align: top;
        }
        .info-table {
            width: 100%;
            margin-bottom: 10px;
            font-size: 12px;
        }
        .info-table td {
            padding: 2px 5px;
        }
        .barang {
            border-collapse: collapse;
            width: 100%;
        }
        .barang th, .barang td {
            border: 1px solid black;
            padding: 6px;
            text-align: center;
        }
        .barang th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body onload="window.print()">

<h2>SURAT JALAN</h2>

<div class="kop">
    <div class="left">
        <strong>PT. KOBAR INDONESIA</strong><br>
        Jl. Raya Penggilingan Komplek PIK, Blok G 18-20<br>
        Penggilingan Cakung. Jakarta Timur 13940<br>
        Telp. 021 46831373
    </div>
    <div class="right">
        Kepada : <strong>{{ $suratJalan->purchaseOrder->customer->nama_customer ?? '-' }}</strong>
        Di <strong>{{ $suratJalan->purchaseOrder->customer->alamat ?? '-' }}</strong>
    </div>
</div>

<table class="info-table">
    <tr>
        <td style="width: 20%;">No. Surat Jalan</td>
        <td style="width: 30%;">: {{ $suratJalan->do_no }}</td>
        <td style="width: 20%;">PO NO</td>
        <td>: {{ $suratJalan->po_no }}</td>
    </tr>
    <tr>
        <td>Tanggal</td>
        <td>: {{ date('d F Y', strtotime($suratJalan->tanggal)) }}</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>No. Kendaraan</td>
        <td>: {{ $suratJalan->no_kendaraan }}</td>
        <td></td>
        <td></td>
    </tr>
</table>

<table class="barang">
    <thead>
        <tr>
            <th style="width:5%;">NO</th>
            <th style="width:20%;">Nomor Part</th>
            <th>Nama Barang</th>
            <th style="width:10%;">Qty</th>
            <th style="width:25%;">Keterangan</th>
        </tr>
    </thead>
    <tbody>
        @php $no = 1; $max = 6; @endphp
        @foreach($suratJalan->details as $row)
        <tr>
            <td>{{ $no }}</td>
            <td>{{ $row->no_part }}</td>
            <td style="text-align: left;"> {{ $row->barang->nama_barang ?? '-' }} </td>
            <td>{{ $row->qty_pengiriman }}</td>
            <td style="text-align: left;"> {{ $row->keterangan ?? '' }} </td>
        </tr>
        @php $no++; @endphp
        @endforeach
        @for($i = $no; $i <= $max; $i++)
        <tr>
            <td>{{ $i }}</td>
            <td>&nbsp;</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        @endfor
    </tbody>
</table>

<!-- Bagian tanda tangan -->
<br><br>
<table style="width: 100%; border-collapse: collapse;">
    <tr>
        <!-- Kotak Received -->
        <td style="width: 30%; vertical-align: top;">
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <th style="border: 1px solid black; height: 25px; text-align: center;">Received</th>
                </tr>
                <tr>
                    <td style="border: 1px solid black; height: 60px;"></td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; height: 25px;"></td>
                </tr>
            </table>
        </td>
        <td style="width: 5%;"></td>
        <!-- Kolom tanda tangan lainnya -->
        <td style="width: 65%; vertical-align: top;">
            <table style="width: 100%; border-collapse: collapse;">
                <colgroup>
                    <col style="width: 25%;">
                    <col style="width: 25%;">
                    <col style="width: 25%;">
                    <col style="width: 25%;">
                </colgroup>
                <tr>
                    <th style="border: 1px solid black; height: 25px; text-align: center;">Security</th>
                    <th style="border: 1px solid black; text-align: center;">Driver</th>
                    <th style="border: 1px solid black; text-align: center;">Checked</th>
                    <th style="border: 1px solid black; text-align: center;">Prepared</th>
                </tr>
                <tr>
                    <td style="border: 1px solid black; height: 60px;"></td>
                    <td style="border: 1px solid black;"></td>
                    <td style="border: 1px solid black;"></td>
                    <td style="border: 1px solid black;"></td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; height: 25px; text-align: center;"> {{ $suratJalan->securityPegawai->nama_pegawai ?? '' }} </td>
                    <td style="border: 1px solid black; text-align: center;"> {{ $suratJalan->driverPegawai->nama_pegawai ?? '' }} </td>
                    <td style="border: 1px solid black; text-align: center;"> {{ $suratJalan->checkedBy->nama_pegawai ?? '' }} </td>
                    <td style="border: 1px solid black; text-align: center;"> {{ $suratJalan->preparedBy->nama_pegawai ?? '' }} </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

</body>
</html>
