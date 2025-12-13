<!DOCTYPE html>
<html>
<head>
    <title>Cetak Purchase Order - {{ $purchaseOrder->po_no }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header img {
            max-height: 80px;
        }
        .info {
            margin-bottom: 20px;
        }
        .info table {
            width: 100%;
        }
        .info td {
            padding: 5px 0;
        }
        .items {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .items th, .items td {
            border: 1px solid #333;
            padding: 8px;
            text-align: center;
        }
        .items th {
            background-color: #f0f0f0;
        }
        .total {
            text-align: right;
            font-weight: bold;
        }
        .footer {
            margin-top: 50px;
            text-align: right;
        }
        .signature {
            margin-top: 60px;
        }
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="no-print" style="margin-bottom: 20px;">
        <button onclick="window.print()">Cetak</button>
        <button onclick="window.close()">Tutup</button>
    </div>

    <div class="header">
        <img src="{{ asset('images/kop.png') }}" alt="Kop Surat">
        <h2>PURCHASE ORDER</h2>
    </div>

    <div class="info">
        <table>
            <tr>
                <td width="100">PO No</td>
                <td>: {{ $purchaseOrder->po_no }}</td>
                <td width="150">Tanggal</td>
                <td>: {{ date('d/m/Y', strtotime($purchaseOrder->tanggal)) }}</td>
            </tr>
            <tr>
                <td>Customer</td>
                <td>: {{ $purchaseOrder->customer->nama_customer ?? '-' }}</td>
                <td>Schedule Delivery</td>
                <td>: {{ date('d/m/Y', strtotime($purchaseOrder->schedule_delivery)) }}</td>
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
            @php $total = 0; @endphp
            @foreach($purchaseOrder->details as $index => $detail)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td style="text-align: left;">{{ $detail->barang->nama_barang ?? '-' }}</td>
                <td>{{ $detail->qty }}</td>
                <td>Rp. {{ number_format($detail->harga, 0, ',', '.') }}</td>
                <td>Rp. {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
            </tr>
            @php $total += $detail->subtotal; @endphp
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4" class="total">TOTAL</th>
                <th>Rp. {{ number_format($total, 0, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <p>{{ date('d F Y') }}</p>
        <div class="signature">
            <p>_______________________</p>
            <p>Tanda Tangan</p>
        </div>
    </div>
</body>
</html>
