<?php
include '../koneksi.php';
$error = '';

if (isset($_POST['proses'])) {
    $no_part = $_POST['no_part'];
    $nama_barang = $_POST['nama_barang'];
    $qty = $_POST['qty'];
    $harga = $_POST['harga'];

    // Cek apakah no_part sudah ada di database
    $cek = mysqli_query($conn, "SELECT * FROM barang WHERE no_part = '$no_part'");
    if (mysqli_num_rows($cek) > 0) {
        $error = "Nomer Part <strong>$no_part</strong> sudah terdaftar. Silakan gunakan yang lain.";
    } else {
        mysqli_query($conn, "INSERT INTO barang VALUES('$no_part','$nama_barang','$qty','$harga')");
        header("Location: barang-lihat.php");
        exit;
    }
}
?>

<!doctype html>
<html lang="en">
  <head>
  	<title>barang-tambah</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
		
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="../css/style.css">
  </head>
  <form action="" method="post">
		
		<div class="wrapper d-flex align-items-stretch">
		  <nav id="sidebar">
      <div class="p-4 pt-5">
        <a href="#" class="img logo rounded-circle mb-5" style="background-image: url(../images/bengkel.png);"></a>
        <ul class="list-unstyled components mb-5">
          <li><a href="../home.php">Home</a></li>
          <li><a href="../customer/customer-lihat.php">Customer</a></li>
          <li class="active"><a href="#barang" data-toggle="collapse" aria-expanded="false">Barang</a></li>
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
              <li class="nav-item">
                <a class="nav-link" href="../home.php">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="..customer/customer-lihat.php">Customer</a>
              </li>
              <li class="nav-item active">
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
        </nav>
    
        <div class="form">
                      <?php if ($error): ?>
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= $error ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Tutup">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            <?php endif; ?>

            <label for="tambahNota" class="form-label" style="display: flex; flex-direction: column; align-items: center; text-align: center; font-size: large;">TAMBAH BARANG</label>
            <hr>

            <div class="form-element">
                <label class="form-label" style="display: inline-block; width: 100px;">NOMER PART</label>
                <input type="text" name="no_part" class="form-control" style="display: inline-block; width: calc(100% - 110px);" placeholder="Nomer Part">
            </div>
            
            <div class="form-element mt-3">
                <label class="form-label"style="display: inline-block; width: 100px;">NAMA</label>            
                <input type="text" name="nama_barang" class="form-control" style="display: inline-block; width: calc(100% - 110px);" placeholder="Nama Barang">
            </div>

            <div class="form-element mt-3">
                <label class="form-label" style="display: inline-block; width: 100px;">STOK</label>
                <input type="number" name="qty" class="form-control" style="display: inline-block; width: calc(100% - 110px);" placeholder="Qty">
            </div> 

            <div class="form-element mt-3">
                <label class="form-label" style="display: inline-block; width: 100px;">HARGA</label>
                <div style="display: inline-block; width: calc(100% - 110px);">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Rp.</span>
                        </div>
                        <input type="number" name="harga" class="form-control" placeholder="10000">
                    </div>
                </div>
            </div>       
            <br>
            <div class="tombol" style="text-align: right;">
            <td><a class="btn btn-danger" href="barang-lihat.php">Batal</a></td>
            <td><input type="submit" class="btn btn-success" name="proses" value="Simpan"> </td>
            </div>
        </div>


      </div>
		</div>

    <script src="../js/jquery.min.js"></script>
    <script src="../js/popper.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/main.js"></script>
</form>
</html>