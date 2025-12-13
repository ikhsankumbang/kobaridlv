<!DOCTYPE html>
<html>
<head>
    <title>Cetak Surat Jalan - {{ $suratJalan->do_no }}</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header img { max-height: 80px; }
        .info { margin-bottom: 20px; }
        .info table { width: 100%; }
        .info td { padding: 5px 0; }
        .items { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .items th, .items td { border: 1px solid #333; padding: 8px; text-align: center; }
        .items th { background-color: #f0f0f0; }
        .signatures { display: flex; justify-content: space-between; margin-top: 40px; }
        .signature-box { text-align: center; width: 20%; }
        .signature-line { margin-top: 50px; border-top: 1px solid #333; }
        @media print { .no-print { display: none; } }
    </style>
</head>
<body>
    <div class="no-print" style="margin-bottom: 20px;">
        <button onclick="window.print()">Cetak</button>
        <button onclick="window.close()">Tutup</button>
    </div>

    <div class="header">
        <img src="{{ asset('images/kop.png') }}" alt="Kop Surat">
        <h2>SURAT JALAN</h2>
    </div>

    <div class="info">
        <table>
            <tr>
                <td width="120">DO No</td>
                <td>: {{ $suratJalan->do_no }}</td>
                <td width="120">PO No</td>
                <td>: {{ $suratJalan->po_no }}</td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td>: {{ date('d/m/Y', strtotime($suratJalan->tanggal)) }}</td>
                <td>Customer</td>
                <td>: {{ $suratJalan->purchaseOrder->customer->nama_customer ?? '-' }}</td>
            </tr>
            <tr>
                <td>No Kendaraan</td>
                <td>: {{ $suratJalan->no_kendaraan }}</td>
                <td></td>
                <td></td>
            </tr>
        </table>
    </div>

    <table class="items">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Qty</th>
            </tr>
        </thead>
        <tbody>
            @foreach($suratJalan->details as $index => $detail)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td style="text-align: left;">{{ $detail->barang->nama_barang ?? '-' }}</td>
                <td>{{ $detail->qty }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="signatures">
        <div class="signature-box">
            <p>Prepared By</p>
            <div class="signature-line"></div>
            <p>{{ $suratJalan->preparedBy->nama_pegawai ?? '' }}</p>
        </div>
        <div class="signature-box">
            <p>Checked By</p>
            <div class="signature-line"></div>
            <p>{{ $suratJalan->checkedBy->nama_pegawai ?? '' }}</p>
        </div>
        <div class="signature-box">
            <p>Driver</p>
            <div class="signature-line"></div>
            <p>{{ $suratJalan->driverPegawai->nama_pegawai ?? '' }}</p>
        </div>
        <div class="signature-box">
            <p>Received</p>
            <div class="signature-line"></div>
            <p>{{ $suratJalan->received ?? '' }}</p>
        </div>
    </div>
</body>
</html>
