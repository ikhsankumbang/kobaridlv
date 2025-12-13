<?php
include '../koneksi.php';
$query = mysqli_query($conn, "SELECT * FROM pegawai WHERE id_pegawai = '$_GET[id_pegawai]'");
$data = mysqli_fetch_array($query);

?>
<?php
if (isset($_POST['proses'])) {
  include '../koneksi.php';
  $id_pegawai = $_GET['id_pegawai'];
  $nama_pegawai = $_POST['nama_pegawai'];
  $jabatan = $_POST['jabatan'];
  $kontak = $_POST['kontak'];

  mysqli_query($conn, "UPDATE pegawai SET nama_pegawai='$nama_pegawai',jabatan='$jabatan',kontak='$kontak' WHERE id_pegawai='$id_pegawai'");
  header("location:pegawai-lihat.php");
}
?>
<!doctype html>
<html lang="en">

<head>
  <title>pegawai-ubah</title>
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
          <li><a href="../barang/barang-lihat.php">Barang</a></li>
          <li class="active"><a href="#pegawai" data-toggle="collapse" aria-expanded="false">Pegawai</a></li>
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
                <a class="nav-link" href="customer/customer-lihat.php">Customer</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="../barang/barang-lihat.php">Barang</a>
              </li>
              <li class="nav-item active">
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
      <div class="form">
        <label for="tambahNota" class="form-label" style="display: flex; flex-direction: column; align-items: center; text-align: center; font-size: large;">UBAH PEGAWAI</label>
        <hr>
        <div class="form-element">
          <label class="form-label" style="display: inline-block; width: 100px;">Id Pegawai</label>
          <input type="text" name="id_pegawai" value="<?php echo $data['id_pegawai'] ?>" class="form-control" style="display: inline-block; width: calc(100% - 110px);" readonly>
        </div>

        <div class="form-element">
          <label class="form-label" style="display: inline-block; width: 100px;">Nama</label>
          <input type="text" name="nama_pegawai" value="<?php echo $data['nama_pegawai'] ?>" class="form-control" placeholder="Nama Peagawai" style="display: inline-block; width: calc(100% - 110px);">
        </div>

        <div class="form-element">
          <label class="form-label" style="display: inline-block; width: 100px;">Jabatan</label>
          <input type="text" name="jabatan" value="<?php echo $data['jabatan'] ?>" class="form-control" placeholder="Jabatan" style="display: inline-block; width: calc(100% - 110px);">
        </div>

        <div class="form-element">
          <label class="form-label" style="display: inline-block; width: 100px;">Kontak</label>
          <input type="text" name="kontak" value="<?php echo $data['kontak'] ?>" class="form-control" placeholder="Kontak" style="display: inline-block; width: calc(100% - 110px);">
        </div>

        <br>
        <div class="tombol" style="text-align: right;">
          <td><input class="btn btn-success" type="submit" name="proses" value="Ubah pegawai">
            <a class="btn btn-danger" href="pegawai-lihat.php">kembali</a>
          </td>
        </div>
      </div>

      <script src="../js/jquery.min.js"></script>
      <script src="../js/popper.js"></script>
      <script src="../js/bootstrap.min.js"></script>
      <script src="../js/main.js"></script>
</form>

</html>