<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice</title>
    <style>
        @page { size: A4; margin: 0; }
        body { margin: 12mm 15mm; font-family: Arial, sans-serif; font-size: 10.5pt; }

        .header { display: flex; align-items: center; margin-bottom: 10px; }
        .header img { width: 65px; }
        .header .info { padding-left: 15px; line-height: 1.2; font-size: 9pt; }
        .header .info strong { font-size: 11pt; }

        .judul { font-size: 26pt; font-weight: bold; margin-top: 5px; border-top: 2px solid black; padding-top: 5px; margin-bottom: 10px; }

        .barang-table { border-collapse: collapse; width: 100%; margin-top: 10px; }
        .barang-table th, .barang-table td { border: 1px solid black; padding: 6px; text-align: center; }
        .barang-table td.left { text-align: left; padding-left: 10px; }

        .barang-table .nama-barang { font-weight: bold; }
        .barang-table .no-part { font-size: 8pt; color: #555; }

        .barang-table tbody tr:first-child td {
            border-top: none;
        }

        .total-tabel-asli { width: 100%; border-collapse: collapse; margin-top: 10px; border: 1px solid black; }
        .total-tabel-asli td { padding: 6px; border-bottom: 1px solid black; vertical-align: top; }
        .total-tabel-asli td.text-right { text-align: right; }
        .total-tabel-asli tr:last-child td { font-weight: bold; border-bottom: none; }

        .two-box-table { border-collapse: collapse; width: 100%; margin-top: 10px; }
        .two-box-table td { border: 1px solid black; vertical-align: top; padding: 10px; }

        .top-info { width: 100%; margin-top: 10px; margin-bottom: 10px; }
        .top-info .left { float: left; width: 60%; border: 1px solid black; padding: 6px; height: 90px; box-sizing: border-box; }
        .top-info .right { float: right; width: 38%; padding-left: 10px; font-size: 10.5pt; position: relative; top: -45px; }
        .top-info .right div { margin-bottom: 10px; }

        .stempel { position: absolute; opacity: 0.3; top: -50px; left: 60%; transform: translateX(-50%) rotate(-15deg); }
        
        @media print {
            .no-print { display: none !important; }
        }
    </style>
</head>
<body onload="window.print()">

@php
    // Collect all unique items from all surat jalan
    $items = [];
    $subtotal = 0;
    
    // Get all related surat jalan
    $suratJalans = $invoice->suratJalans;
    $purchaseOrder = optional($suratJalans->first())->purchaseOrder;
    $customer = optional($purchaseOrder)->customer;
    
    // Collect all DO numbers
    $doList = $suratJalans->pluck('do_no')->toArray();
    $doText = implode(', ', $doList);
    
    // Aggregate items by no_part
    $aggregatedItems = [];
    foreach($suratJalans as $sj) {
        foreach($sj->details as $detail) {
            $noPart = $detail->no_part;
            $harga = optional($detail->barang)->harga ?? 0;
            $qty = $detail->qty_pengiriman;
            
            if(isset($aggregatedItems[$noPart])) {
                $aggregatedItems[$noPart]['qty'] += $qty;
                $aggregatedItems[$noPart]['jumlah'] = $aggregatedItems[$noPart]['qty'] * $harga;
            } else {
                $aggregatedItems[$noPart] = [
                    'nama_barang' => optional($detail->barang)->nama_barang ?? '-',
                    'no_part' => $noPart,
                    'qty' => $qty,
                    'harga' => $harga,
                    'jumlah' => $qty * $harga
                ];
            }
        }
    }
    
    foreach($aggregatedItems as $item) {
        $items[] = $item;
        $subtotal += $item['jumlah'];
    }
    
    $ppn = round($subtotal * 0.11);
    $total = $subtotal + $ppn;
@endphp

<!-- Header -->
<div class="header">
    <img src="{{ asset('images/bengkel.png') }}" alt="Logo">
    <div class="info">
        <strong>PT. <span style="color: #b00000;">KOBAR</span> INDONESIA</strong><br>
        Jl. Raya Penggilingan Komplek PIK Blok G No. 18-20 Kel. Penggilingan, Kec. Cakung Jakarta Timur 13940<br>
        Telp. (021) 4683137 Email : ikakobar728@gmail.com
    </div>
</div>

<!-- Judul -->
<div class="judul">INVOICE</div>

<!-- Info Atas -->
<div class="top-info">
    <div class="left">
        Kepada:<br><br>
        PT. {{ $customer->nama_customer ?? '-' }}<br>
        {!! nl2br(e($customer->alamat ?? '')) !!}
    </div>
    <div class="right">
        <div>NOMOR : {{ $invoice->no_invoice }}</div>
        <div>TANGGAL : {{ date('d/m/Y', strtotime($invoice->tanggal)) }}</div>
        <div>PO NO : {{ $purchaseOrder->po_no ?? '-' }}</div>
        <div>DO NO : {{ $doText }}</div>
        <div>NPWP : 03.290.929.3-004.000</div>
    </div>
    <div style="clear: both;"></div>
</div>

<!-- Tabel Barang -->
<table class="barang-table">
    <thead>
        <tr>
            <th style="width: 5%;">No</th>
            <th style="width: 45%;">Nama Barang</th>
            <th style="width: 10%;">Qty</th>
            <th style="width: 20%;">Harga</th>
            <th style="width: 20%;">Jumlah</th>
        </tr>
    </thead>
    <tbody>
        @foreach($items as $index => $item)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td class="left">
                <div class="nama-barang">{{ $item['nama_barang'] }}</div>
                <div class="no-part">No. Part: {{ $item['no_part'] }}</div>
            </td>
            <td>{{ $item['qty'] }}</td>
            <td style="text-align: right;">Rp. {{ number_format($item['harga'], 0, ',', '.') }}</td>
            <td style="text-align: right;">Rp. {{ number_format($item['jumlah'], 0, ',', '.') }}</td>
        </tr>
        @endforeach

        @php $sisa = 12 - count($items); @endphp
        @for($j = 0; $j < $sisa; $j++)
        <tr>
            <td></td>
            <td class="left">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        @endfor
    </tbody>
</table>


<table class="total-tabel-asli" style="width: 100%; margin-top: 10px; border-collapse: collapse;">
    <tr>
        <td rowspan="3" style="width: 60%; border: 1px solid black; padding: 8px; vertical-align: top;">
            Faktur Pajak<br>
            Nomor: {{ $invoice->nsfp }}
        </td>
        <td style="text-align: left; border: 1px solid black; padding: 8px;">Sub Total</td>
        <td style="border: 1px solid black; padding: 8px;">
            <div style="display: flex; justify-content: space-between;">
                <span>Rp.</span>
                <span>{{ number_format($subtotal, 0, ',', '.') }}</span>
            </div>
        </td>
    </tr>
    <tr>
        <td style="text-align: left; border: 1px solid black; padding: 8px;">PPN 11%</td>
        <td style="border: 1px solid black; padding: 8px;">
            <div style="display: flex; justify-content: space-between;">
                <span>Rp.</span>
                <span>{{ number_format($ppn, 0, ',', '.') }}</span>
            </div>
        </td>
    </tr>
    <tr>
        <td style="text-align: left; font-weight: bold; border: 1px solid black; padding: 8px;">TOTAL</td>
        <td style="font-weight: bold; border: 1px solid black; padding: 8px;">
            <div style="display: flex; justify-content: space-between;">
                <span>Rp.</span>
                <span>{{ number_format($total, 0, ',', '.') }}</span>
            </div>
        </td>
    </tr>
</table>


<!-- Transfer & TTD -->
<table class="two-box-table">
    <tr>
        <td style="width: 60%;">
            Mohon ditransfer ke BCA<br>
            No. Ac.<br>
            A/N : PT. KOBAR INDONESIA
        </td>
        <td style="width: 40%; text-align: center;">
            <div style="display: inline-block; margin-top: 10px;">
                <strong>PT. KOBAR INDONESIA</strong>
            </div>
        </td>
    </tr>
</table>

</body>
</html>
