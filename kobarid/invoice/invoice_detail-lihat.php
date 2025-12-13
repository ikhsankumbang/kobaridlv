<?php
include '../koneksi.php';

$no_invoice = $_GET['no_invoice'] ?? '';
$invoice_q = mysqli_query($conn, "SELECT * FROM invoice WHERE no_invoice = '$no_invoice'");
$invoice = mysqli_fetch_assoc($invoice_q);

if (!$invoice) {
    die("Invoice tidak ditemukan.");
}

$tanggal = date('d/m/Y', strtotime($invoice['tanggal']));
?>

<!doctype html>
<html lang="en">
<head>
    <title>Detail Invoice</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="wrapper d-flex align-items-stretch">
    <nav id="sidebar">
      <div class="p-4 pt-5">
        <a href="#" class="img logo rounded-circle mb-5" style="background-image: url(../images/bengkel.png);"></a>
        <ul class="list-unstyled components mb-5">
          <li><a href="../home.php">Home</a></li>
          <li><a href="../customer/customer-lihat.php">Customer</a></li>
          <li><a href="../barang/barang-lihat.php">Barang</a></li>
          <li><a href="../pegawai/pegawai-lihat.php">Pegawai</a></li>
          <li><a href="../purchase_order/purchase_order-lihat.php">Purchase Order</a></li>
          <li><a href="../surat_jalan/surat_jalan-lihat.php">Surat Jalan</a></li>
          <li class="active"><a href="#invoice" data-toggle="collapse" aria-expanded="false">Invoice</a></li>
          <li> <a href="../index.php?logout=true">Logout</a></li>
        </ul>
        <div class="footer">
          <p>Mbd &copy;<script>document.write(new Date().getFullYear());</script><br><i class="icon-heart" aria-hidden="true"></i></p>
        </div>
      </div>
    </nav>

     <div id="content" class="p-4 p-md-5">
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
          <button type="button" id="sidebarCollapse" class="btn btn-primary">
            <i class="fa fa-bars"></i>
            <span class="sr-only">Toggle Menu</span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="nav navbar-nav ml-auto">
              <li class="nav-item"><a class="nav-link" href="../home.php">Home</a></li>
              <li class="nav-item"><a class="nav-link" href="../customer/customer-lihat.php">Customer</a></li>
              <li class="nav-item"><a class="nav-link" href="../barang/barang-lihat.php">Barang</a></li>
              <li class="nav-item"><a class="nav-link" href="../pegawai/pegawai-lihat.php">Pegawai</a></li>
              <li class="nav-item"><a class="nav-link" href="../purchase_order/purchase_order-lihat.php">Purchase Order</a></li>
              <li class="nav-item"><a class="nav-link" href="../surat_jalan/surat_jalan-lihat.php">Surat Jalan</a></li>
              <li class="nav-item active"><a class="nav-link" href="../invoice/invoice-lihat.php">Invoice</a></li>
            </ul>
          </div>
        </div>
      </nav>

        <div class="form">
            <label class="form-label text-center" style="font-size: large;">DETAIL INVOICE: <?= htmlspecialchars($no_invoice) ?></label>
            <hr>
            <a class="btn btn-danger btn-sm" href="invoice-lihat.php">Kembali</a>

            <div class="form-element">
                <label class="form-label" style="display: inline-block; width: 120px;">No Invoice</label>
                <input class="form-control" value="<?= htmlspecialchars($no_invoice) ?>" style="display: inline-block; width: calc(100% - 130px);" readonly>
            </div>

            <div class="form-element">
                <label class="form-label" style="display: inline-block; width: 120px;">Tanggal</label>
                <input class="form-control" value="<?= $tanggal ?>" style="display: inline-block; width: calc(100% - 130px);" readonly>
            </div>

            <div class="form-element">
                <label class="form-label" style="display: inline-block; width: 120px;">List DO</label>
                <textarea class="form-control" style="display: inline-block; width: calc(100% - 130px);" readonly><?php
                    $do_result = mysqli_query($conn, "
                      SELECT sj.do_no 
                      FROM invoice_suratjalan isj
                      JOIN surat_jalan sj ON isj.do_no = sj.do_no
                      WHERE isj.no_invoice = '$no_invoice'
                    ");
                    $do_list = [];
                    while ($row = mysqli_fetch_assoc($do_result)) {
                        $do_list[] = $row['do_no'];
                    }
                    echo count($do_list) > 0 ? implode(", ", $do_list) : "Tidak ada DO";
                ?></textarea>
            </div>

            <br>
            <label class="form-label text-center" style="font-size: large;">TABEL DETAIL BARANG</label>
            <hr>

            <table width='100%' border=1 style="text-align: center;">
                <tr class="table-primary" style="color: black;">
                    <th>No Part</th>
                    <th>Nama Barang</th>
                    <th>Qty Pengiriman</th>
                    <th>Harga</th>
                    <th>Total</th>
                </tr>
                <?php
                $q = mysqli_query($conn, "
                    SELECT sjd.no_part, b.nama_barang, sjd.qty_pengiriman, b.harga,
                           (sjd.qty_pengiriman * b.harga) AS total
                    FROM invoice_suratjalan isj
                    JOIN surat_jalan_detail sjd ON isj.do_no = sjd.do_no
                    JOIN barang b ON sjd.no_part = b.no_part
                    WHERE isj.no_invoice = '$no_invoice'
                ");

                $grand_total = 0;
                while ($d = mysqli_fetch_assoc($q)) {
                $total = $d['qty_pengiriman'] * $d['harga'];
                $grand_total += $total;
                echo "<tr>";
                echo "<td>" . htmlspecialchars($d['no_part']) . "</td>";
                echo "<td>" . htmlspecialchars($d['nama_barang']) . "</td>";
                echo "<td>" . number_format($d['qty_pengiriman'], 0, ',', '.') . "</td>";
                echo "<td>Rp " . number_format($d['harga'], 0, ',', '.') . "</td>";
                echo "<td>Rp " . number_format($total, 0, ',', '.') . "</td>";
                echo "</tr>";
            }
            ?>

                <tr>
                    <td colspan="4" style="text-align: center;"><strong>GRAND TOTAL</strong></td>
                    <td>Rp <?= number_format($grand_total, 0, ',', '.') ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>

<script src="../js/jquery.min.js"></script>
<script src="../js/popper.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/main.js"></script>
</body>
</html>