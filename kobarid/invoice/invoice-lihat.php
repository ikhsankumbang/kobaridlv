<?php
include '../koneksi.php';

// Ambil semua invoice dan daftar PO-nya melalui relasi ke surat jalan
$query = mysqli_query($conn, "
    SELECT 
        i.no_invoice, 
        i.tanggal, 
        i.nsfp, 
        i.subtotal, 
        i.ppn, 
        i.total_harga,
        GROUP_CONCAT(DISTINCT po.po_no SEPARATOR ', ') AS po_list
    FROM invoice i
    LEFT JOIN invoice_suratjalan isj ON i.no_invoice = isj.no_invoice
    LEFT JOIN surat_jalan sj ON isj.do_no = sj.do_no
    LEFT JOIN purchase_order po ON sj.po_no = po.po_no
    GROUP BY i.no_invoice
");
?>

<!doctype html>
<html lang="en">

<head>
  <title>Invoice Lihat</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css">
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

      <div style="text-align: end; margin-top:-25px;">
        <a href="invoice-tambah.php" class="btn btn-warning" type="button">+ TAMBAHKAN</a>
      </div>

      <div class="rectangle" style="width: 100%; margin-top: 5px;">
        <table id="example" class="table table-striped table-bordered" style="width:100%; text-align: center;">
          <thead class="table-primary">
            <tr>
              <th>NO INVOICE</th>
              <th>TANGGAL</th>
              <th>PO NO</th>
              <th>NSFP</th>
              <th>SUB TOTAL</th>
              <th>PPN</th>
              <th>TOTAL HARGA</th>
              <th>Aksi</th>
              <th>Keterangan</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($data = mysqli_fetch_array($query)) {
              $tanggal = date('d/m/Y', strtotime($data['tanggal']));
            ?>
              <tr>
                <td><?= $data['no_invoice']; ?></td>
                <td><?= $tanggal; ?></td>
                <td><?= $data['po_list']; ?></td>
                <td><?= $data['nsfp']; ?></td>
                <td><?= 'Rp ' . number_format($data['subtotal'], 0, ',', '.'); ?></td>
                <td><?= 'Rp ' . number_format($data['ppn'], 0, ',', '.'); ?></td>
                <td><?= 'Rp ' . number_format($data['total_harga'], 0, ',', '.'); ?></td>

                <td>
                  <a class="btn btn-success" href="invoice-ubah.php?no_invoice=<?= $data['no_invoice']; ?>">Ubah</a> |
                  <a class="btn btn-danger" href="invoice-hapus.php?no_invoice=<?= $data['no_invoice']; ?>" onclick="return confirm('yakin hapus?')">Hapus</a>
                </td>
                <td>
                  <a class="btn btn-secondary" href="invoice_detail-lihat.php?no_invoice=<?= $data['no_invoice']; ?>">Detail</a> |
                  <a class="btn btn-primary" href="invoice-cetak.php?no_invoice=<?= $data['no_invoice']; ?>">Cetak</a>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>
  <script src="../js/main.js"></script>
  <script>
    $(document).ready(function() {
      $('#example').DataTable();
    });
  </script>
</body>

</html>
