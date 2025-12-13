<?php
include '../koneksi.php';

// Ambil data surat_jalan berdasarkan do_no dari URL
$do_no = $_GET['do_no'];
$query = mysqli_query($conn, "SELECT * FROM surat_jalan WHERE do_no='$do_no'");
$data = mysqli_fetch_array($query);

// Ambil data pegawai untuk dropdown
$pegawai_result = mysqli_query($conn, "SELECT id_pegawai, nama_pegawai, jabatan FROM pegawai ORDER BY nama_pegawai ASC");

// Ambil data purchase_order untuk dropdown po_no
$po_result = mysqli_query($conn, "SELECT po_no FROM purchase_order ORDER BY po_no ASC");

if (isset($_POST['proses'])) {
    // Ambil data dari form
    $tanggal = $_POST['tanggal'];
    $po_no = $_POST['po_no'];
    $prepared_by = $_POST['prepared_by'];
    $checked_by = $_POST['checked_by'];
    $security = $_POST['security'];
    $driver = $_POST['driver'];
    $received = $_POST['received'];
    $no_kendaraan = $_POST['no_kendaraan'];

    // Update data di database
    mysqli_query($conn, "UPDATE surat_jalan SET
        tanggal='$tanggal',
        po_no='$po_no',
        prepared_by='$prepared_by',
        checked_by='$checked_by',
        security='$security',
        driver='$driver',
        received='$received',
        no_kendaraan='$no_kendaraan'
        WHERE do_no='$do_no'");

    // Redirect kembali ke halaman lihat
    echo "<script>window.location.href = 'surat_jalan-lihat.php';</script>";
    exit;
}

// Fungsi untuk generate dropdown pegawai berdasarkan jabatan
function pegawai_dropdown($name, $selected_value, $jabatan, $conn) {
    $query = mysqli_query($conn, "SELECT id_pegawai, nama_pegawai FROM pegawai WHERE jabatan='$jabatan' ORDER BY nama_pegawai ASC");
    echo "<select class='form-control' name='$name' required style='width: calc(100% - 110px); display: inline-block;'>";
    echo "<option value='' disabled>-- Pilih Pegawai --</option>";
    while ($pegawai = mysqli_fetch_assoc($query)) {
        $selected = ($selected_value == $pegawai['id_pegawai']) ? 'selected' : '';
        echo "<option value='" . htmlspecialchars($pegawai['id_pegawai']) . "' $selected>" . htmlspecialchars($pegawai['nama_pegawai']) . "</option>";
    }
    echo "</select>";
}
?>

<!doctype html>
<html lang="en">

<head>
  <title>Ubah Surat Jalan</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="../css/style.css">
</head>

<body>
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
                <a class="nav-link" href="../customer/customer-lihat.php">Customer</a>
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
              <li class="nav-item active">
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
        <label class="form-label" style="display: flex; flex-direction: column; align-items: center; text-align: center; font-size: large;">UBAH SURAT JALAN (DO NO: <?= htmlspecialchars($data['do_no']); ?>)</label>
        <hr>

        <div class="form-element">
          <label class="form-label" style="display: inline-block; width: 100px;">DO NO</label>
          <input type="text" class="form-control" name="do_no" value="<?= htmlspecialchars($data['do_no']); ?>" style="display: inline-block; width: calc(100% - 110px);" readonly>
        </div>

        <div class="form-element">
          <label class="form-label" style="display: inline-block; width: 100px;">PO NO</label>
          <select class="form-control" name="po_no" required style="display: inline-block; width: calc(100% - 110px);">
            <option value="" disabled>-- Pilih PO NO --</option>
            <?php
            mysqli_data_seek($po_result, 0);
            while ($po = mysqli_fetch_assoc($po_result)) {
                $selected = ($data['po_no'] == $po['po_no']) ? 'selected' : '';
                echo "<option value='" . htmlspecialchars($po['po_no']) . "' $selected>" . htmlspecialchars($po['po_no']) . "</option>";
            }
            ?>
          </select>
        </div>

        <div class="form-element">
          <label class="form-label" style="display: inline-block; width: 100px;">Tanggal</label>
          <input type="date" class="form-control" name="tanggal" value="<?= htmlspecialchars($data['tanggal']); ?>" required style="display: inline-block; width: calc(100% - 110px);">
        </div>

        <div class="form-element">
          <label class="form-label" style="display: inline-block; width: 100px;">Prepared By</label>
          <?php pegawai_dropdown('prepared_by', $data['prepared_by'], 'Preparation', $conn); ?>
        </div>

        <div class="form-element">
          <label class="form-label" style="display: inline-block; width: 100px;">Checked By</label>
          <?php pegawai_dropdown('checked_by', $data['checked_by'], 'Checker', $conn); ?>
        </div>

        <div class="form-element">
          <label class="form-label" style="display: inline-block; width: 100px;">Security</label>
          <?php pegawai_dropdown('security', $data['security'], 'Security', $conn); ?>
        </div>

        <div class="form-element">
          <label class="form-label" style="display: inline-block; width: 100px;">Driver</label>
          <?php pegawai_dropdown('driver', $data['driver'], 'Driver', $conn); ?>
        </div>

        <div class="form-element">
          <label class="form-label" style="display: inline-block; width: 100px;">Received</label>
          <input type="text" class="form-control" name="received" value="<?= htmlspecialchars($data['received']); ?>" style="display: inline-block; width: calc(100% - 110px);">
        </div>

        <div class="form-element">
          <label class="form-label" style="display: inline-block; width: 100px;">Kendaraan</label>
          <input type="text" class="form-control" name="no_kendaraan" value="<?= htmlspecialchars($data['no_kendaraan']); ?>" style="display: inline-block; width: calc(100% - 110px);">
        </div>

        <br>
        <div class="tombol" style="text-align: right;">
          <input class="btn btn-success" type="submit" name="proses" value="Simpan Perubahan">
          <a class="btn btn-danger" href="surat_jalan-lihat.php">Kembali</a>
        </div>
      </div>
    </div>
  </div>

  <script src="../js/jquery.min.js"></script>
  <script src="../js/popper.js"></script>
  <script src="../js/bootstrap.min.js"></script>
  <script src="../js/main.js"></script>
</form>
</body>
</html>