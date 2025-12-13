<?php
include '../koneksi.php';

if (!isset($_GET['no_invoice'])) {
    die('Nomor invoice tidak tersedia');
}

$no_invoice = $_GET['no_invoice'];

// Ambil data invoice + customer + PO
$q_invoice = mysqli_query($conn, "
    SELECT i.*, po.po_no, po.tanggal AS tanggal_po, po.schedule_delivery, po.id_customer,
           c.nama_customer, c.alamat, c.kontak
    FROM invoice i
    JOIN invoice_suratjalan isj ON i.no_invoice = isj.no_invoice
    JOIN surat_jalan sj ON isj.do_no = sj.do_no
    JOIN purchase_order po ON sj.po_no = po.po_no
    JOIN customer c ON po.id_customer = c.id_customer
    WHERE i.no_invoice = '$no_invoice'
    LIMIT 1
");
$data_invoice = mysqli_fetch_assoc($q_invoice);

// Ambil semua DO yang berkaitan dengan PO
$do_result = mysqli_query($conn, "SELECT do_no FROM surat_jalan WHERE po_no = '" . $data_invoice['po_no'] . "'");
$do_list = [];
while ($row = mysqli_fetch_assoc($do_result)) {
    $do_list[] = $row['do_no'];
}
$do_text = implode(', ', $do_list);

// Ambil data barang dari DO yang di-invoice-kan
$q_barang = mysqli_query($conn, "
    SELECT b.no_part, b.nama_barang, b.harga, SUM(s.qty_pengiriman) AS qty_pengiriman
    FROM invoice_suratjalan isj
    JOIN surat_jalan sj ON isj.do_no = sj.do_no
    JOIN surat_jalan_detail s ON sj.do_no = s.do_no
    JOIN barang b ON s.no_part = b.no_part
    WHERE isj.no_invoice = '$no_invoice'
    GROUP BY b.no_part, b.nama_barang, b.harga
");

$items = [];
$subtotal = 0;
while ($row = mysqli_fetch_assoc($q_barang)) {
    $jumlah = $row['qty_pengiriman'] * $row['harga'];
    $subtotal += $jumlah;
    $items[] = [
        'nama_barang' => $row['nama_barang'],
        'no_part' => $row['no_part'],
        'qty' => $row['qty_pengiriman'],
        'harga' => $row['harga'],
        'jumlah' => $jumlah
    ];
}

$ppn = round($subtotal * 0.11);
$total = $subtotal + $ppn;
?>

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

        /* ✅ Tambahan: Hapus garis atas baris pertama */
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
    </style>
</head>
<body onload="window.print()">

<!-- Header -->
<div class="header">
    <img src="../images/bengkel.png" alt="Logo">
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
        PT. <?= htmlspecialchars($data_invoice['nama_customer']) ?><br>
        <?= nl2br($data_invoice['alamat']) ?>
    </div>
    <div class="right">
        <div>NOMOR : <?= htmlspecialchars($data_invoice['no_invoice']) ?></div>
        <div>TANGGAL : <?= date('d/m/Y', strtotime($data_invoice['tanggal'])) ?></div>
        <div>PO NO : <?= htmlspecialchars($data_invoice['po_no']) ?></div>
        <div>DO NO : <?= htmlspecialchars($do_text) ?></div>
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
        <?php
        $i = 1;
        foreach ($items as $item): ?>
        <tr>
            <td><?= $i++ ?></td>
            <td class="left">
                <div class="nama-barang"><?= htmlspecialchars($item['nama_barang']) ?></div>
                <div class="no-part">No. Part: <?= htmlspecialchars($item['no_part']) ?></div>
            </td>
            <td><?= $item['qty'] ?></td>
            <td style="text-align: right;">Rp. <?= number_format($item['harga'], 0, ',', '.') ?></td>
            <td style="text-align: right;">Rp. <?= number_format($item['jumlah'], 0, ',', '.') ?></td>
        </tr>
        <?php endforeach; ?>

        <?php
        $sisa = 12 - count($items);
        for ($j = 0; $j < $sisa; $j++): ?>
        <tr>
            <td></td>
            <td class="left">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <?php endfor; ?>
    </tbody>
</table>


<table class="total-tabel-asli" style="width: 100%; margin-top: 10px; border-collapse: collapse;">
    <tr>
        <td rowspan="3" style="width: 60%; border: 1px solid black; padding: 8px; vertical-align: top;">
            Faktur Pajak<br>
            Nomor: <?= htmlspecialchars($data_invoice['nsfp']) ?>
        </td>
        <td style="text-align: left; border: 1px solid black; padding: 8px;">Sub Total</td>
        <td style="border: 1px solid black; padding: 8px;">
            <div style="display: flex; justify-content: space-between;">
                <span>Rp.</span>
                <span><?= number_format($subtotal, 0, ',', '.') ?></span>
            </div>
        </td>
    </tr>
    <tr>
        <td style="text-align: left; border: 1px solid black; padding: 8px;">PPN 11%</td>
        <td style="border: 1px solid black; padding: 8px;">
            <div style="display: flex; justify-content: space-between;">
                <span>Rp.</span>
                <span><?= number_format($ppn, 0, ',', '.') ?></span>
            </div>
        </td>
    </tr>
    <tr>
        <td style="text-align: left; font-weight: bold; border: 1px solid black; padding: 8px;">TOTAL</td>
        <td style="font-weight: bold; border: 1px solid black; padding: 8px;">
            <div style="display: flex; justify-content: space-between;">
                <span>Rp.</span>
                <span><?= number_format($total, 0, ',', '.') ?></span>
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
