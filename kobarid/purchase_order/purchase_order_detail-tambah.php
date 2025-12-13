<?php
include '../koneksi.php';

// Proses form sebelum ada output HTML
if (isset($_POST['proses'])) {
    $po_no = $_POST['po_no'];
    $no_part = trim($_POST['no_part']); // Hilangkan spasi depan-belakang
    $qty_pemesanan = $_POST['qty_pemesanan'];

    // Validasi input minimal
    if (empty($po_no) || empty($no_part) || empty($qty_pemesanan)) {
        die("Data tidak boleh kosong.");
    }

    // Periksa apakah no_part ada di tabel barang
    $check_barang = mysqli_query($conn, "SELECT * FROM barang WHERE no_part = '" . mysqli_real_escape_string($conn, $no_part) . "'");
    if (mysqli_num_rows($check_barang) == 0) {
        die("Barang dengan no_part <strong>" . htmlspecialchars($no_part) . "</strong> tidak ditemukan.");
    }

    // Insert data ke detail_purchase_order, kolom disesuaikan jika urutan tidak sama
    $query_insert = "INSERT INTO detail_purchase_order (po_no, no_part, qty_pemesanan) VALUES ('" 
        . mysqli_real_escape_string($conn, $po_no) . "', '" 
        . mysqli_real_escape_string($conn, $no_part) . "', '" 
        . (int)$qty_pemesanan . "')";
    $result = mysqli_query($conn, $query_insert);
    if (!$result) {
        die("Gagal menyimpan detail purchase order: " . mysqli_error($conn));
    }

    // Redirect setelah berhasil
    header("Location: purchase_order_detail-lihat.php?po_no=" . urlencode($po_no));
    exit;
}

// Ambil data untuk tampilan form
if (isset($_GET['po_no'])) {
    $po_no = $_GET['po_no'];
    $query = mysqli_query($conn, "SELECT po.*, c.nama_customer FROM purchase_order po 
    LEFT JOIN customer c ON po.id_customer = c.id_customer
    WHERE po.po_no = '" . mysqli_real_escape_string($conn, $po_no) . "'");
$data = mysqli_fetch_array($query);

    if (!$data) {
        die("Data PO tidak ditemukan.");
    }
} else {
    die("Nomor PO tidak disediakan.");
}
?>

<!doctype html>
<html lang="en">
<head>
    <title>Tambah Detail Purchase Order</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="../css/style.css" />
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
          <li class="active"><a href="#purchase_order" data-toggle="collapse" aria-expanded="false">Purchase Order</a></li>
          <li><a href="../surat_jalan/surat_jalan-lihat.php">Surat Jalan</a></li>
          <li><a href="../invoice/invoice-lihat.php">Invoice</a></li>
          <li>
             <a href="../index.php?logout=true">Logout</a>
          </li>
        </ul>
                <div class="footer">
                    <p>
                        Mbd &copy;<script>document.write(new Date().getFullYear());</script><br><i class="icon-heart" aria-hidden="true"></i>
                    </p>
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
                    <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
                        <i class="fa fa-bars"></i>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="nav navbar-nav ml-auto">
              <li class="nav-item">
                <a class="nav-link" href="../home.php">Home</a>
              </li>
              <li class="nav-item ">
                <a class="nav-link" href="..customer/customer-lihat.php">Customer</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="../barang/barang-lihat.php">Barang</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="../pegawai/pegawai-lihat.php">Pegawai</a>
              </li>
              <li class="nav-item active">
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
                <label class="form-label" style="display: flex; flex-direction: column; align-items: center; text-align: center; font-size: large;">
                    FORM DETAIL NOTA : <?php echo htmlspecialchars($data['po_no'] ?? ''); ?>
                </label>
                <hr>
                <div class="form-element">
                    <label class="form-label" style="display: inline-block; width: 100px;">Po No</label>
                    <input name="po_no" class="form-control" value="<?php echo htmlspecialchars($data['po_no'] ?? ''); ?>" style="display: inline-block; width: calc(100% - 110px);" readonly>
                </div>
                <div class="form-element">
                    <label class="form-label" style="display: inline-block; width: 100px;">Customer</label>
                    <input type="text" name="nama_customer" class="form-control" value="<?php echo htmlspecialchars($data['nama_customer'] ?? ''); ?>" style="display: inline-block; width: calc(100% - 110px);" readonly>
                </div>
                <div class="form-element">
                    <label class="form-label" style="display: inline-block; width: 100px;">Tanggal</label>
                    <input type="date" name="tanggal" class="form-control" value="<?php echo htmlspecialchars($data['tanggal'] ?? ''); ?>" style="display: inline-block; width: calc(100% - 110px);" readonly>
                </div>
                <div class="form-element">
                    <label class="form-label" style="display: inline-block; width: 100px;">Schedule</label>
                    <input type="date" name="schedule_delivery" class="form-control" value="<?php echo htmlspecialchars($data['schedule_delivery'] ?? ''); ?>" style="display: inline-block; width: calc(100% - 110px);" readonly>
                </div>

                <label class="form-label mt-4" style="display: flex; flex-direction: column; align-items: center; text-align: center; font-size: large;">TAMBAH DETAIL NOTA</label>
                <hr>
                <div class="form-element">
                    <label class="form-label" style="display: inline-block; width: 100px;">BARANG</label>
                    <select class="form-control" name="no_part" aria-label="Default select example" style="display: inline-block; width: calc(100% - 110px);" required>
                        <option value="" selected disabled>---Pilih----</option>
                        <?php
                        $query = mysqli_query($conn, "SELECT * FROM barang ORDER BY no_part ASC");
                        while ($data_barang = mysqli_fetch_array($query)) {
                            echo "<option value='" . trim(htmlspecialchars($data_barang['no_part'])) . "' data-harga='" . htmlspecialchars($data_barang['harga']) . "'>"
                                . htmlspecialchars($data_barang['no_part']) . " - "
                                . htmlspecialchars($data_barang['nama_barang']) . " - "
                                . number_format($data_barang['harga'], 0, ',', '.') . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-element">
                    <label class="form-label" style="display: inline-block; width: 100px;">qty_pemesanan</label>
                    <input type="number" name="qty_pemesanan" class="form-control" placeholder="Banyaknya" style="display: inline-block; width: calc(100% - 110px);" min="1" required>
                </div>
                <br>
                <div class="tombol" style="text-align: right;">
                    <button type="submit" name="proses" class="btn btn-success">Simpan Detail</button>
                    <a href="purchase_order_detail-lihat.php?po_no=<?php echo htmlspecialchars($data['po_no'] ?? ''); ?>" class="btn btn-danger">Kembali</a>
                </div>
            </div>
        </div>
    </div>

    <script src="../js/jquery.min.js"></script>
    <script src="../js/popper.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/main.js"></script>
</form>

<script>
    var selectBarang = document.querySelector("select[name='no_part']");
    var inputBanyaknya = document.querySelector("input[name='qty_pemesanan']");

    function hitungTotal() {
        var hargaSatuan = selectBarang.options[selectBarang.selectedIndex].getAttribute("data-harga");
        var banyaknya = inputBanyaknya.value;
        var total = hargaSatuan * banyaknya;
        console.log("Total: " + total); // debugging
    }

    selectBarang.addEventListener("change", hitungTotal);
    inputBanyaknya.addEventListener("input", hitungTotal);
</script>
</body>
</html>
