<?php
include '../koneksi.php';

if (!isset($_GET['do_no']) || !isset($_GET['no_part'])) {
    die("Parameter tidak lengkap.");
}

$do_no = $_GET['do_no'];
$no_part = $_GET['no_part'];
// Ambil nama_barang dari tabel barang
$query_barang = mysqli_query($conn, "SELECT nama_barang FROM barang WHERE no_part = '" . mysqli_real_escape_string($conn, $no_part) . "'");
$data_barang = mysqli_fetch_assoc($query_barang);
$nama_barang = $data_barang['nama_barang'] ?? 'Barang tidak ditemukan';
// Ambil data surat_jalan_detail
$q = mysqli_query($conn, "SELECT * FROM surat_jalan_detail WHERE do_no='$do_no' AND no_part='$no_part'");
$data = mysqli_fetch_assoc($q);
if (!$data) die("Data detail tidak ditemukan.");
$qty_lama = (int)$data['qty_pengiriman'];
$keterangan = $data['keterangan'] ?? '';

// Ambil header DO & info pegawai
$query_header = mysqli_query($conn, "
    SELECT sj.*, po.po_no, p1.nama_pegawai AS prepared_name,
        p2.nama_pegawai AS checked_name,
        p3.nama_pegawai AS security_name,
        p4.nama_pegawai AS driver_name
    FROM surat_jalan sj
    LEFT JOIN purchase_order po ON sj.po_no = po.po_no
    LEFT JOIN pegawai p1 ON sj.prepared_by = p1.id_pegawai
    LEFT JOIN pegawai p2 ON sj.checked_by = p2.id_pegawai
    LEFT JOIN pegawai p3 ON sj.security = p3.id_pegawai
    LEFT JOIN pegawai p4 ON sj.driver = p4.id_pegawai
    WHERE sj.do_no = '$do_no'
");
$data_header = mysqli_fetch_assoc($query_header);
if (!$data_header) die("Data header tidak ditemukan.");

$po_no = $data_header['po_no'];

if (isset($_POST['proses'])) {
    $qty_baru = (int) $_POST['qty_pengiriman'];
    $keterangan = trim($_POST['keterangan']);

    // Ambil qty_pemesanan dari detail_purchase_order
    $q_po = mysqli_query($conn, "SELECT qty_pemesanan FROM detail_purchase_order WHERE po_no='$po_no' AND no_part='$no_part'");
    $data_po = mysqli_fetch_assoc($q_po);
    if (!$data_po) die("Barang tidak termasuk dalam PO.");
    $qty_pemesanan = (int) $data_po['qty_pemesanan'];

    // Hitung total qty terkirim selain dari record ini
    $q_terkirim = mysqli_query($conn, "
        SELECT SUM(qty_pengiriman) AS total FROM surat_jalan_detail 
        JOIN surat_jalan ON surat_jalan_detail.do_no = surat_jalan.do_no
        WHERE surat_jalan.po_no = '$po_no' AND no_part='$no_part' AND NOT (surat_jalan_detail.do_no='$do_no')
    ");
    $d_terkirim = mysqli_fetch_assoc($q_terkirim);
    $terkirim_lain = (int) $d_terkirim['total'];
    $sisa_pemesanan = $qty_pemesanan - $terkirim_lain;

    if ($qty_baru > $sisa_pemesanan) {
        die("Jumlah pengiriman melebihi sisa pemesanan ($sisa_pemesanan)");
    }

    // Cek stok
    $q_stok = mysqli_query($conn, "SELECT qty FROM barang WHERE no_part='$no_part'");
    $data_stok = mysqli_fetch_assoc($q_stok);
    $stok = (int)$data_stok['qty'];

    $selisih = $qty_baru - $qty_lama;
    if ($selisih > 0 && $selisih > $stok) {
        die("Stok tidak cukup. Sisa stok: $stok");
    }

    // Proses update
    mysqli_begin_transaction($conn);
    try {
        mysqli_query($conn, "UPDATE surat_jalan_detail SET qty_pengiriman='$qty_baru', keterangan='$keterangan' 
            WHERE do_no='$do_no' AND no_part='$no_part'");
        
        mysqli_query($conn, "UPDATE barang SET qty = qty - $selisih WHERE no_part='$no_part'");
        
        mysqli_commit($conn);
mysqli_commit($conn);

// Cek ulang total pengiriman dan update status PO
$po_total = mysqli_query($conn, "SELECT SUM(qty_pemesanan) AS total_pesan FROM detail_purchase_order WHERE po_no = '$po_no'");
$po_total_data = mysqli_fetch_assoc($po_total);
$total_pesan = (int)$po_total_data['total_pesan'];

$sj_total = mysqli_query($conn, "
    SELECT SUM(sjd.qty_pengiriman) AS total_kirim
    FROM surat_jalan_detail sjd
    JOIN surat_jalan sj ON sjd.do_no = sj.do_no
    WHERE sj.po_no = '$po_no'
");
$sj_total_data = mysqli_fetch_assoc($sj_total);
$total_kirim = (int)$sj_total_data['total_kirim'];

$status = ($total_kirim >= $total_pesan) ? 'Selesai' : 'Proses';
mysqli_query($conn, "UPDATE purchase_order SET status = '$status' WHERE po_no = '$po_no'");

// Redirect
header("Location: surat_jalan_detail-lihat.php?do_no=$do_no");
exit;


        header("Location: surat_jalan_detail-lihat.php?do_no=$do_no");
        exit;
    } catch (Exception $e) {
        mysqli_rollback($conn);
        die("Gagal update: " . $e->getMessage());
    }
}
?>

<!-- FORM TAMPILAN -->
<!doctype html>
<html lang="en">
<head>
    <title>Ubah Detail Surat Jalan</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="../css/style.css" />
</head>
<body>
<form method="post">
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
                    <li class="active"><a href="../surat_jalan/surat_jalan-lihat.php">Surat Jalan</a></li>
                    <li><a href="../invoice/invoice-lihat.php">Invoice</a></li>
                    <li>
                         <a href="../index.php?logout=true">Logout</a>
                    </li>
                </ul>
                <div class="footer">
                    <p>Mbd &copy;<script>document.write(new Date().getFullYear());</script> <br><i class="icon-heart" aria-hidden="true"></i></p>
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
                <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                        aria-label="Toggle navigation">
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
            <label class="form-label text-center" style="font-size: large;">
                UBAH DETAIL SURAT JALAN: <?php echo htmlspecialchars($do_no); ?>
            </label>
            <hr>
            <a class="btn btn-danger btn-sm" href="surat_jalan_detail-lihat.php?do_no=<?php echo urlencode($do_no); ?>">Kembali</a>

            <?php
            foreach ([
                'NO SURAT JALAN' => $data_header['do_no'],
                'NO PURCHASE ORDER' => $data_header['po_no'],
                'TANGGAL' => $data_header['tanggal'],
                'PREPARED BY' => $data_header['prepared_name'],
                'CHECKED BY' => $data_header['checked_name'],
                'SECURITY' => $data_header['security_name'],
                'DRIVER' => $data_header['driver_name'],
                'RECEIVED BY' => $data_header['received'],
                'NO KENDARAAN' => $data_header['no_kendaraan']
            ] as $label => $val) {
                echo "<div class='form-element'>
                        <label class='form-label' style='display:inline-block;width:150px;'>$label</label>
                        <input class='form-control' value='" . htmlspecialchars($val) . "' readonly style='display:inline-block;width:calc(100% - 160px);'>
                    </div>";
            }
            ?>

            <label class="form-label mt-4 text-center" style="font-size: large;">UBAH DETAIL BARANG</label>
            <hr>

            <div class="form-element">
                <label class="form-label" style="display:inline-block;width:100px;">Barang</label>
                <input class="form-control" value="<?php echo htmlspecialchars($nama_barang); ?>" readonly style="display:inline-block;width:calc(100% - 110px);">
            </div>

            <div class="form-element">
                <label class="form-label" style="display:inline-block;width:100px;">Qty</label>
                <input type="number" name="qty_pengiriman" value="<?php echo htmlspecialchars($qty_lama); ?>" class="form-control" min="1" required style="display:inline-block;width:calc(100% - 110px);">
            </div>

            <div class="form-element">
                <label class="form-label" style="display:inline-block;width:100px;">Keterangan</label>
                <input type="text" name="keterangan" value="<?php echo htmlspecialchars($keterangan); ?>" class="form-control" style="display:inline-block;width:calc(100% - 110px);">
            </div>

            <br>
            <div class="tombol" style="text-align:right;">
                <button type="submit" name="proses" class="btn btn-success">Simpan Perubahan</button>
                <a href="surat_jalan_detail-lihat.php?do_no=<?php echo urlencode($do_no); ?>" class="btn btn-danger">Batal</a>
            </div>
        </div>
    </div>
</div>
</form>

<script src="../js/jquery.min.js"></script>
<script src="../js/popper.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/main.js"></script>
</body>
</html>
