<?php
include '../koneksi.php';

if (isset($_POST['proses'])) {
    $do_no = $_POST['do_no'];
    $no_part = trim($_POST['no_part']);
    $qty_pengiriman = (int) $_POST['qty_pengiriman'];
    $keterangan = trim($_POST['keterangan']);

    if (empty($do_no) || empty($no_part) || empty($qty_pengiriman)) {
        die("Data tidak boleh kosong.");
    }

    // Ambil po_no dari surat_jalan
    $sj = mysqli_query($conn, "SELECT po_no FROM surat_jalan WHERE do_no = '" . mysqli_real_escape_string($conn, $do_no) . "'");
    $sj_data = mysqli_fetch_assoc($sj);
    $po_no = $sj_data['po_no'];

    // Cek apakah barang termasuk dalam PO
    $cek_po_detail = mysqli_query($conn, "SELECT qty_pemesanan FROM detail_purchase_order WHERE po_no = '" . mysqli_real_escape_string($conn, $po_no) . "' AND no_part = '" . mysqli_real_escape_string($conn, $no_part) . "'");
    if (mysqli_num_rows($cek_po_detail) == 0) {
        die("Barang tersebut tidak termasuk dalam purchase order ini.");
    }
    $data_po = mysqli_fetch_assoc($cek_po_detail);
    $qty_pemesanan = (int) $data_po['qty_pemesanan'];

    // Hitung total qty_pengiriman sebelumnya
    $cek_total_terkirim = mysqli_query($conn, "SELECT SUM(qty_pengiriman) AS total_terkirim FROM surat_jalan_detail 
        JOIN surat_jalan ON surat_jalan_detail.do_no = surat_jalan.do_no 
        WHERE surat_jalan.po_no = '" . mysqli_real_escape_string($conn, $po_no) . "' 
        AND surat_jalan_detail.no_part = '" . mysqli_real_escape_string($conn, $no_part) . "'");
    $data_terkirim = mysqli_fetch_assoc($cek_total_terkirim);
    $total_terkirim = (int) $data_terkirim['total_terkirim'];

    $sisa_pemesanan = $qty_pemesanan - $total_terkirim;
    if ($qty_pengiriman > $sisa_pemesanan) {
        die("Jumlah pengiriman melebihi sisa pemesanan. Sisa: $sisa_pemesanan");
    }

    // Ambil stok dari barang
    $stok = mysqli_query($conn, "SELECT qty FROM barang WHERE no_part = '" . mysqli_real_escape_string($conn, $no_part) . "'");
    $data_stok = mysqli_fetch_assoc($stok);
    $stok_saat_ini = (int) $data_stok['qty'];

    if ($qty_pengiriman > $stok_saat_ini) {
        die("Jumlah pengiriman melebihi stok barang. Stok tersedia: $stok_saat_ini");
    }

    mysqli_begin_transaction($conn);
    try {
        // Cek apakah sudah ada baris dengan no_part yang sama
        $cek_ada = mysqli_query($conn, "SELECT qty_pengiriman FROM surat_jalan_detail WHERE do_no = '" . mysqli_real_escape_string($conn, $do_no) . "' AND no_part = '" . mysqli_real_escape_string($conn, $no_part) . "'");

        if (mysqli_num_rows($cek_ada) > 0) {
            // Jika sudah ada, update qty_pengiriman (tambah)
            $data_lama = mysqli_fetch_assoc($cek_ada);
            $qty_lama = (int)$data_lama['qty_pengiriman'];
            $qty_baru = $qty_lama + $qty_pengiriman;

            $update_detail = "UPDATE surat_jalan_detail 
                SET qty_pengiriman = $qty_baru, 
                    keterangan = '" . mysqli_real_escape_string($conn, $keterangan) . "' 
                WHERE do_no = '" . mysqli_real_escape_string($conn, $do_no) . "' 
                AND no_part = '" . mysqli_real_escape_string($conn, $no_part) . "'";
            mysqli_query($conn, $update_detail);
        } else {
            // Insert baru jika belum ada
            $query_insert = "INSERT INTO surat_jalan_detail (do_no, no_part, qty_pengiriman, keterangan) VALUES (
                '" . mysqli_real_escape_string($conn, $do_no) . "',
                '" . mysqli_real_escape_string($conn, $no_part) . "',
                $qty_pengiriman,
                '" . mysqli_real_escape_string($conn, $keterangan) . "'
            )";
            mysqli_query($conn, $query_insert);
        }

        // Update stok barang
        $update_stok = "UPDATE barang 
            SET qty = qty - $qty_pengiriman 
            WHERE no_part = '" . mysqli_real_escape_string($conn, $no_part) . "'";
        mysqli_query($conn, $update_stok);

        // Cek apakah semua part dalam PO sudah terkirim
        $cek_detail_po = mysqli_query($conn, "SELECT no_part, qty_pemesanan FROM detail_purchase_order WHERE po_no = '" . mysqli_real_escape_string($conn, $po_no) . "'");
        $semua_terkirim = true;

        while ($detail = mysqli_fetch_assoc($cek_detail_po)) {
            $part = $detail['no_part'];
            $qty_pesan = (int)$detail['qty_pemesanan'];

            $cek_kirim = mysqli_query($conn, "
                SELECT SUM(sjd.qty_pengiriman) AS total_terkirim
                FROM surat_jalan_detail sjd
                JOIN surat_jalan sj ON sjd.do_no = sj.do_no
                WHERE sj.po_no = '" . mysqli_real_escape_string($conn, $po_no) . "'
                AND sjd.no_part = '" . mysqli_real_escape_string($conn, $part) . "'");
            $hasil_kirim = mysqli_fetch_assoc($cek_kirim);
            $total_terkirim = (int)$hasil_kirim['total_terkirim'];

            if ($total_terkirim < $qty_pesan) {
                $semua_terkirim = false;
                break;
            }
        }

        if ($semua_terkirim) {
            mysqli_query($conn, "UPDATE purchase_order SET status = 'Selesai' WHERE po_no = '" . mysqli_real_escape_string($conn, $po_no) . "'");
        }

        mysqli_commit($conn);
        header("Location: surat_jalan_detail-lihat.php?do_no=" . urlencode($do_no));
        exit;
    } catch (Exception $e) {
        mysqli_rollback($conn);
        die("Terjadi kesalahan saat menyimpan data: " . $e->getMessage());
    }
}

// Ambil data header DO
if (isset($_GET['do_no'])) {
    $do_no = $_GET['do_no'];
    $query = mysqli_query($conn, "SELECT sj.*, po.po_no, po.tanggal, 
        p1.nama_pegawai AS prepared_name,
        p2.nama_pegawai AS checked_name,
        p3.nama_pegawai AS security_name,
        p4.nama_pegawai AS driver_name
        FROM surat_jalan sj
        LEFT JOIN purchase_order po ON sj.po_no = po.po_no
        LEFT JOIN pegawai p1 ON sj.prepared_by = p1.id_pegawai
        LEFT JOIN pegawai p2 ON sj.checked_by = p2.id_pegawai
        LEFT JOIN pegawai p3 ON sj.security = p3.id_pegawai
        LEFT JOIN pegawai p4 ON sj.driver = p4.id_pegawai
        WHERE sj.do_no = '" . mysqli_real_escape_string($conn, $do_no) . "'");
    $data_header = mysqli_fetch_array($query);

    if (!$data_header) {
        die("Data Surat Jalan tidak ditemukan.");
    }
} else {
    die("Nomor DO tidak disediakan.");
}
?>

?>
<!doctype html>
<html lang="en">
<head>
    <title>Tambah Detail Surat Jalan</title>
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
                    DETAIL SURAT JALAN: <?php echo htmlspecialchars($data_header['do_no']); ?>
                </label>
                <hr>
                <a class="btn btn-danger btn-sm" href="surat_jalan-lihat.php">Kembali</a>
                <input type="hidden" name="do_no" value="<?php echo htmlspecialchars($data_header['do_no']); ?>">

                <?php
                $fields = [
                    'NO SURAT JALAN' => $data_header['do_no'],
                    'NO PURCHASE ORDER' => $data_header['po_no'],
                    'TANGGAL' => $data_header['tanggal'],
                    'PREPARED BY' => $data_header['prepared_name'],
                    'CHECKED BY' => $data_header['checked_name'],
                    'SECURITY' => $data_header['security_name'],
                    'DRIVER' => $data_header['driver_name'],
                    'RECEIVED BY' => $data_header['received'],
                    'NO KENDARAAN' => $data_header['no_kendaraan']
                ];

                foreach ($fields as $label => $value) {
                    echo "<div class='form-element'>
                            <label class='form-label' style='display:inline-block;width:150px;'>$label</label>
                            <input class='form-control' value='" . htmlspecialchars($value) . "' readonly style='display:inline-block;width:calc(100% - 160px);'>
                          </div>";
                }
                ?>

                <label class="form-label mt-4 text-center" style="font-size: large;">TAMBAH DETAIL NOTA</label>
                <hr>

                <div class="form-element">
    <label class="form-label" style="display: inline-block; width: 100px;">BARANG</label>
    <select class="form-control" name="no_part" required style="display: inline-block; width: calc(100% - 110px);">
        <option value="" selected disabled>---Pilih----</option>
        <?php
        $po_no = $data_header['po_no'];

        // Ambil semua barang dari detail_purchase_order yang terkait PO ini
        $query_barang = mysqli_query($conn, "
            SELECT 
                dp.no_part, 
                b.nama_barang, 
                b.harga, 
                b.qty AS stok, 
                dp.qty_pemesanan,
                COALESCE((
                    SELECT SUM(sjd.qty_pengiriman)
                    FROM surat_jalan_detail sjd
                    JOIN surat_jalan sj ON sjd.do_no = sj.do_no
                    WHERE sj.po_no = dp.po_no AND sjd.no_part = dp.no_part
                ), 0) AS total_terkirim
            FROM detail_purchase_order dp
            JOIN barang b ON dp.no_part = b.no_part
            WHERE dp.po_no = '" . mysqli_real_escape_string($conn, $po_no) . "'
            ORDER BY dp.no_part ASC
        ");

        while ($data_barang = mysqli_fetch_array($query_barang)) {
            $sisa = (int)$data_barang['qty_pemesanan'] - (int)$data_barang['total_terkirim'];
            if ($sisa > 0) {
                echo "<option value='" . htmlspecialchars($data_barang['no_part']) . "'>"
                    . htmlspecialchars($data_barang['no_part']) . " - "
                    . htmlspecialchars($data_barang['nama_barang']) . " - Stok: " . (int)$data_barang['stok'] . " - Sisa PO: $sisa - Rp "
                    . number_format($data_barang['harga'], 0, ',', '.') . "</option>";
            }
        }
        ?>
    </select>
</div>


                <div class="form-element">
                    <label class="form-label" style="display: inline-block; width: 100px;">Qty</label>
                    <input type="number" name="qty_pengiriman" class="form-control" placeholder="Banyaknya" min="1" required style="display: inline-block; width: calc(100% - 110px);">
                </div>

                <div class="form-element">
                    <label class="form-label" style="display: inline-block; width: 100px;">Keterangan</label>
                    <input type="text" name="keterangan" class="form-control" placeholder="Keterangan" style="display: inline-block; width: calc(100% - 110px);">
                </div>

                <br>
                <div class="tombol" style="text-align: right;">
                    <button type="submit" name="proses" class="btn btn-success">Simpan Detail</button>
                    <a href="surat_jalan_detail-lihat.php?do_no=<?php echo htmlspecialchars($data_header['do_no']); ?>" class="btn btn-danger">Kembali</a>
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