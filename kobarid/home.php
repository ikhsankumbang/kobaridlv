<?php
session_start();
if (!isset($_SESSION['id_pegawai'])) {
  header("Location: index.php");
  exit;
}
?>


<!doctype html>
<html lang="en">

<head>
  <title>Home</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="css/style.css">
</head>

<body>

  <div class="wrapper d-flex align-items-stretch">
    <nav id="sidebar">
      <div class="p-4 pt-5">
        <a href="#" class="img logo rounded-circle mb-5" style="background-image: url(images/bengkel.png);"></a>
        <ul class="list-unstyled components mb-5">
          <li class="active">
            <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false">Home</a>
          </li>
          <li>
            <a href="customer/customer-lihat.php">Customer</a>
          </li>
          <li>
            <a href="barang/barang-lihat.php">Barang</a>
          </li>
          <li>
            <a href="pegawai/pegawai-lihat.php">Pegawai</a>
          </li>
          <li>
            <a href="purchase_order/purchase_order-lihat.php">Purchase Order</a>
          </li>
          <li>
            <a href="surat_jalan/surat_jalan-lihat.php">Surat Jalan</a>
          </li>
          <li>
            <a href="invoice/invoice-lihat.php">Invoice</a>
          </li>
          
          <li>
           <a href="/kobarid/index.php?logout=true">Logout</a>
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

    <!-- Page Content  -->
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
              <li class="nav-item active">
                <a class="nav-link" href="#">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="customer/customer-lihat.php">Customer</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="barang/barang-lihat.php">Barang</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="pegawai/pegawai-lihat.php">Pegawai</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="purchase_order/purchase_order-lihat.php">Purchase Order</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="surat_jalan/surat_jalan-lihat.php">Surat Jalan</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="invoice/invoice-lihat.php">Invoice</a>
              </li>
 
            </ul>
          </div>
        </div>
      </nav>

      <h2 class="mb-4">Home</h2>
      
      <div class="row">
        
        <div class="col-md-4 mb-4">
          <div class="card">
            <div class="card-body d-flex align-items-center justify-content-between">
              <div>
                <h5 class="card-title">Jumlah Customer</h5>
                <p class="card-text" style="font-size: 2rem;">
                  <?php
                  include 'koneksi.php';
                  $query = "SELECT COUNT(*) AS id_customer FROM customer";
                  $result = mysqli_query($conn, $query);
                  $row = mysqli_fetch_assoc($result);
                  echo $row['id_customer'];
                  ?>
                </p>
              </div>
              <div style="font-size: 4rem; color:#333;">
                <i class="fa-solid fa-user"></i>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-4 mb-4">
          <div class="card">
            <div class="card-body d-flex align-items-center justify-content-between">
              <div>
                <h5 class="card-title">Jumlah Barang</h5>
                <p class="card-text" style="font-size: 2rem;">
                  <?php
                  include 'koneksi.php';
                  $query = "SELECT COUNT(*) AS no_part FROM barang";
                  $result = mysqli_query($conn, $query);
                  $row = mysqli_fetch_assoc($result);
                  echo $row['no_part'];
                  ?>
                </p>
              </div>
              <div style="font-size: 4rem; color:#333;">
                <i class="fa-solid fa-box"></i>

              </div>
            </div>
          </div>
        </div>
        
        <div class="col-md-4 mb-4">
          <div class="card">
            <div class="card-body d-flex align-items-center justify-content-between">
              <div>
                <h5 class="card-title">Jumlah Pegawai</h5>
                <p class="card-text" style="font-size: 2rem;">
                  <?php
                  include 'koneksi.php';
                  $query = "SELECT COUNT(*) AS id_pegawai FROM pegawai";
                  $result = mysqli_query($conn, $query);
                  $row = mysqli_fetch_assoc($result);
                  echo $row['id_pegawai'];
                  ?>
                </p>
              </div>
              <div style="font-size: 4rem; color:#333;">
                <i class="fa-solid fa-user-tie"></i>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-4 mb-4">
          <div class="card">
            <div class="card-body d-flex align-items-center justify-content-between">
              <div>
                <h5 class="card-title">Jumlah Purchase Order</h5>
                <p class="card-text" style="font-size: 2rem;">
                  <?php
                  include 'koneksi.php';
                  $query = "SELECT COUNT(*) AS po_no FROM purchase_order";
                  $result = mysqli_query($conn, $query);
                  $row = mysqli_fetch_assoc($result);
                  echo $row['po_no'];
                  ?>
                </p>
              </div>
              <div style="font-size: 4rem; color:#333;">
                <i class="fa-solid fa-file-invoice-dollar"></i>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-4 mb-4">
          <div class="card">
            <div class="card-body d-flex align-items-center justify-content-between">
              <div>
                <h5 class="card-title">Jumlah Surat Jalan</h5>
                <p class="card-text" style="font-size: 2rem;">
                  <?php
                  include 'koneksi.php';
                  $query = "SELECT COUNT(*) AS do_no FROM surat_jalan";
                  $result = mysqli_query($conn, $query);
                  $row = mysqli_fetch_assoc($result);
                  echo $row['do_no'];
                  ?>
                </p>
              </div>
              <div style="font-size: 4rem; color:#333;">
                <i class="fa-solid fa-truck-loading"></i>
              </div>
            </div>
          </div>
        </div>
        
        <div class="col-md-4 mb-4">
          <div class="card">
            <div class="card-body d-flex align-items-center justify-content-between">
              <div>
                <h5 class="card-title">Jumlah Invoice</h5>
                <p class="card-text" style="font-size: 2rem;">
                  <?php
                  include 'koneksi.php';
                  $query = "SELECT COUNT(*) AS no_invoice FROM invoice";
                  $result = mysqli_query($conn, $query);
                  $row = mysqli_fetch_assoc($result);
                  echo $row['no_invoice'];
                  ?>
                </p>
              </div>
              <div style="font-size: 4rem; color:#333;">
                <i class="fa-solid fa-file-invoice"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>

  <script src="js/jquery.min.js"></script>
  <script src="js/popper.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/main.js"></script>
</body>

</html>
