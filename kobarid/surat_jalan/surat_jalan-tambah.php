<?php
if (isset($_POST['proses'])) {
  include '../koneksi.php';

  $do_no = $_POST['do_no'];
  $po_no = $_POST['po_no'];
  $tanggal = $_POST['tanggal'];
  $prepared_by = $_POST['prepared_by'];
  $checked_by = $_POST['checked_by'];
  $security = $_POST['security'];
  $driver = $_POST['driver'];
  $received = $_POST['received'];
  $no_kendaraan = $_POST['no_kendaraan'];

  // Insert data ke tabel surat_jalan
  mysqli_query($conn, "INSERT INTO surat_jalan (do_no, po_no, tanggal, prepared_by, checked_by, security, driver, received, no_kendaraan) VALUES ('$do_no', '$po_no', '$tanggal', '$prepared_by', '$checked_by', '$security', '$driver', '$received', '$no_kendaraan')");

  echo "<script>window.location.href = 'surat_jalan_detail-lihat.php?do_no=" . $do_no . "';</script>";
}
?>
<!doctype html>
<html lang="en">

<head>
  <title>surat_jalan-tambah</title>
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
          <li><a href="../pegawai/pegawai-lihat.php">Pegawai</a></li>
          <li><a href="../purchase_order/purchase_order-lihat.php">Purchase Order</a></li>
          <li class="active"><a href="#surat_jalan" data-toggle="collapse" aria-expanded="false">Surat Jalan</a></li>
          <li><a href="../invoice/invoice-lihat.php">Invoice</a></li>
          <li> <a href="../index.php?logout=true">Logout</a></li>
        </ul>
        <div class="footer">
          <p>Mbd &copy;<script>document.write(new Date().getFullYear());</script></p>
        </div>
      </div>
    </nav>

    <div id="content" class="p-4 p-md-5">

      <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
          <button type="button" id="sidebarCollapse" class="btn btn-primary">
            <i class="fa fa-bars"></i>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="nav navbar-nav ml-auto">
              <li class="nav-item"><a class="nav-link" href="../home.php">Home</a></li>
              <li class="nav-item"><a class="nav-link" href="../customer/customer-lihat.php">Customer</a></li>
              <li class="nav-item"><a class="nav-link" href="../barang/barang-lihat.php">Barang</a></li>
              <li class="nav-item"><a class="nav-link" href="../pegawai/pegawai-lihat.php">Pegawai</a></li>
              <li class="nav-item"><a class="nav-link" href="../purchase_order/purchase_order-lihat.php">Purchase Order</a></li>
              <li class="nav-item active"><a class="nav-link" href="../surat_jalan/surat_jalan-lihat.php">Surat Jalan</a></li>
              <li class="nav-item"><a class="nav-link" href="../invoice/invoice-lihat.php">Invoice</a></li>
            </ul>
          </div>
        </div>
      </nav>

      <div class="form">
        <label class="form-label" style="display: flex; flex-direction: column; align-items: center; text-align: center; font-size: large;">TAMBAH SURAT JALAN</label>
        <hr>

        <?php include '../koneksi.php'; ?>

        <div class="form-element">
          <label class="form-label" style="width: 140px;">DO NO</label>
          <input type="text" name="do_no" class="form-control" required style="width: calc(100% - 150px); display: inline-block;">
        </div>

        <div class="form-element">
          <label class="form-label" style="width: 140px;">PO NO</label>
          <select name="po_no" class="form-control" required style="width: calc(100% - 150px); display: inline-block;">
            <option value="">-- Pilih PO NO --</option>
            <?php
              $sql = mysqli_query($conn, "SELECT po_no FROM purchase_order WHERE status = 'Proses' ORDER BY po_no ASC");

              while ($row = mysqli_fetch_array($sql)) {
                echo '<option value="'.$row['po_no'].'">'.$row['po_no'].'</option>';
              }
            ?>
          </select>
        </div>

        <div class="form-element">
          <label class="form-label" style="width: 140px;">TANGGAL</label>
          <input type="date" name="tanggal" class="form-control" required style="width: calc(100% - 150px); display: inline-block;">
        </div>

        <?php
function dropdownPegawai($name, $jabatan, $conn) {
  // Query untuk mengambil pegawai berdasarkan jabatan tertentu
  $query = mysqli_query($conn, "SELECT * FROM pegawai WHERE jabatan = '$jabatan' ORDER BY nama_pegawai ASC");
  
  echo '<div class="form-element">';
  echo '<label class="form-label" style="width: 140px;">' . ucwords(str_replace('_', ' ', $name)) . '</label>';
  echo '<select name="' . $name . '" class="form-control" required style="width: calc(100% - 150px); display: inline-block;">';
  echo '<option value="">--Pilih--</option>';
  
  while ($data = mysqli_fetch_array($query)) {
    echo '<option value="' . $data['id_pegawai'] . '">' . htmlspecialchars($data['nama_pegawai']) . '</option>';
  }
  
  echo '</select>';
  echo '</div>';
}
?>

<!-- Pemanggilan fungsi dropdownPegawai dengan filter jabatan -->
<?php
dropdownPegawai('prepared_by', 'Preparation', $conn);
dropdownPegawai('checked_by', 'Checker', $conn);
dropdownPegawai('security', 'Security', $conn);
dropdownPegawai('driver', 'Driver', $conn);
?>


        <div class="form-element">
          <label class="form-label" style="width: 140px;">Received</label>
          <input type="text" name="received" class="form-control" style="width: calc(100% - 150px); display: inline-block;">
        </div>


        <div class="form-element">
          <label class="form-label" style="width: 140px;">NO KENDARAAN</label>
          <input type="text" name="no_kendaraan" class="form-control" required style="width: calc(100% - 150px); display: inline-block;">
        </div>

        <br>
        <div class="tombol" style="text-align: right;">
          <button type="submit" name="proses" class="btn btn-success">Tambah</button>
          <a href="surat_jalan-lihat.php" class="btn btn-danger">Batal</a>
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
