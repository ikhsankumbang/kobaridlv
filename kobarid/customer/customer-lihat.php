<!doctype html>
<html lang="en">



<head>
  <title>customer-lihat</title>
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
          <li class="active"><a href="#customer" data-toggle="collapse" aria-expanded="false">Customer</a></li>
          <li><a href="../barang/barang-lihat.php">Barang</a></li>
          <li><a href="../pegawai/pegawai-lihat.php">Pegawai</a></li>
          <li><a href="../purchase_order/purchase_order-lihat.php">Purchase Order</a></li>
          <li><a href="../surat_jalan/surat_jalan-lihat.php">Surat Jalan</a></li>
          <li><a href="../invoice/invoice-lihat.php">Invoice</a></li>
          <li>
             <a href="../index.php?logout=true">Logout</a>
          </li>
        </ul>
        <div class="footer">
          <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
            Mbd &copy;<script>
              document.write(new Date().getFullYear());
            </script> <br>  <i class="icon-heart" aria-hidden="true"></i>
            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
        </div>
      </div>
    </nav>

    <!-- Page Content -->
    <div id="content" class="p-4 p-md-5">
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
          <button type="button" id="sidebarCollapse" class="btn btn-primary">
            <i class="fa fa-bars"></i>
            <span class="sr-only">Toggle Menu</span>
          </button>
          <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fa fa-bars"></i>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="nav navbar-nav ml-auto">
              <li class="nav-item">
                <a class="nav-link" href="../home.php">Home</a>
              </li>
              <li class="nav-item active">
                <a class="nav-link" href="customer/customer-lihat.php">Customer</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="../barang/barang-lihat.php">Barang</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="../pegawai/pegawai-lihat.php">Pegawai</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="../purchase_order/purchase_order-lihat.php">Purchase Order</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="../surat_jalan/surat_jalan-lihat.php">Surat Jalan</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="../invoice/invoice-lihat.php">Invoice</a>
              </li>
 
            </ul>
          </div>
        </div>
      </nav>
      <div style="text-align: end; margin-top:-25px;"><a href="customer-tambah.php" class="btn btn-warning" type="button">+ TAMBAHKAN</a></div>
      <div class="rectangle" style="width: 100%; margin-top: 5px;">
        <table id="example" class="table table-striped table-bordered" style="width:100%; text-align: center;">
          <thead class="table-primary">
            <tr>
              <th>ID CUSTOMER</th>
              <th>NAMA</th>
              <th>ALAMAT</th>
              <th>KONTAK</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            include '../koneksi.php';
            $query = mysqli_query($conn, "SELECT * FROM customer");
            while ($data = mysqli_fetch_array($query)) {
            ?>
              <tr>
                <td><?php echo $data['id_customer']; ?></td>
                <td style="text-align: start;"><?php echo $data['nama_customer']; ?></td>
                <td><?php echo $data['alamat']; ?></td>
                <td><?php echo $data['kontak']; ?></td>
                <td>
                  <a class="btn btn-success" href="customer-ubah.php?id_customer=<?php echo $data['id_customer']; ?>" role="button">Ubah</a> |
                  <a class="btn btn-danger" href="customer-hapus.php?id_customer=<?php echo $data['id_customer']; ?>" onclick="return confirm('yakin hapus?')">Hapus</a>
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