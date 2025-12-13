<!DOCTYPE html>
<html>
<head>
    <title>Cetak Invoice - {{ $invoice->no_invoice }}</title>
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
        .totals { text-align: right; margin-bottom: 30px; }
        .totals table { margin-left: auto; }
        .totals td { padding: 5px 10px; }
        .footer { margin-top: 50px; text-align: right; }
        .signature { margin-top: 60px; }
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
        <h2>INVOICE</h2>
    </div>

    <div class="info">
        <table>
            <tr>
                <td width="120">No Invoice</td>
                <td>: {{ $invoice->no_invoice }}</td>
                <td width="120">Tanggal</td>
                <td>: {{ date('d/m/Y', strtotime($invoice->tanggal)) }}</td>
            </tr>
            <tr>
                <td>NSFP</td>
                <td>: {{ $invoice->nsfp }}</td>
                <td>Customer</td>
                <td>: {{ $invoice->suratJalans->first()->purchaseOrder->customer->nama_customer ?? '-' }}</td>
            </tr>
        </table>
    </div>

    <table class="items">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Qty</th>
                <th>Harga</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach($invoice->suratJalans as $sj)
                @foreach($sj->details as $detail)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td style="text-align: left;">{{ $detail->barang->nama_barang ?? '-' }}</td>
                    <td>{{ $detail->qty }}</td>
                    <td>Rp {{ number_format($detail->barang->harga ?? 0, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format(($detail->barang->harga ?? 0) * $detail->qty, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>

    <div class="totals">
        <table>
            <tr>
                <td><strong>Subtotal:</strong></td>
                <td>Rp {{ number_format($invoice->subtotal, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td><strong>PPN (11%):</strong></td>
                <td>Rp {{ number_format($invoice->ppn, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td><strong>TOTAL:</strong></td>
                <td><strong>Rp {{ number_format($invoice->total_harga, 0, ',', '.') }}</strong></td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <p>{{ date('d F Y') }}</p>
        <div class="signature">
            <p>_______________________</p>
            <p>Tanda Tangan</p>
        </div>
    </div>
</body>
</html>
