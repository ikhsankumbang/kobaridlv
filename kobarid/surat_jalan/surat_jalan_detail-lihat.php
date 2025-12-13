<?php
include '../koneksi.php';

// Periksa apakah 'do_no' ada di URL
if (isset($_GET['do_no'])) {
    $do_no = $_GET['do_no'];
    
    // Query untuk mendapatkan data header surat jalan
    $query_header = mysqli_query($conn, "
        SELECT sj.*,
               p_prepared.nama_pegawai AS prepared_name,
               p_checked.nama_pegawai AS checked_name,
               p_security.nama_pegawai AS security_name,
               p_driver.nama_pegawai AS driver_name
        FROM surat_jalan sj
        LEFT JOIN pegawai p_prepared ON p_prepared.id_pegawai = sj.prepared_by AND p_prepared.jabatan = 'preparation'
        LEFT JOIN pegawai p_checked ON p_checked.id_pegawai = sj.checked_by AND p_checked.jabatan = 'checker'
        LEFT JOIN pegawai p_security ON p_security.id_pegawai = sj.security AND p_security.jabatan = 'security'
        LEFT JOIN pegawai p_driver ON p_driver.id_pegawai = sj.driver AND p_driver.jabatan = 'driver'
        WHERE sj.do_no = '" . mysqli_real_escape_string($conn, $do_no) . "'
    ");
    
    $data_header = mysqli_fetch_array($query_header);
    
    // Periksa apakah data ditemukan
    if (!$data_header) {
        die("Surat Jalan tidak ditemukan.");
    }

    // Mengubah format tanggal ke dd/mm/yyyy
    $tanggal = date('d/m/Y', strtotime($data_header['tanggal']));

} else {
    die("Nomor Surat Jalan tidak disediakan.");
}
?>

<!doctype html>
<html lang="en">

<head>
    <title>Detail Surat Jalan</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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

        <!-- Page Content -->
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
                <label class="form-label"
                    style="display: flex; flex-direction: column; align-items: center; text-align: center; font-size: large;">
                    DETAIL SURAT JALAN: <?php echo htmlspecialchars($data_header['do_no']); ?>
                </label>
                <hr>
                <a class="btn btn-danger btn-sm" href="surat_jalan-lihat.php">Kembali</a>

                <div class="form-element">
                    <label class="form-label" style="display: inline-block; width: 150px;">NO SURAT JALAN</label>
                    <input class="form-control" value="<?php echo htmlspecialchars($data_header['do_no']); ?>"
                        style="display: inline-block; width: calc(100% - 160px);" readonly>
                </div>

                <div class="form-element">
                    <label class="form-label" style="display: inline-block; width: 150px;">NO PURCHASE ORDER</label>
                    <input class="form-control" value="<?php echo htmlspecialchars($data_header['po_no']); ?>"
                        style="display: inline-block; width: calc(100% - 160px);" readonly>
                </div>

                <div class="form-element">
                    <label class="form-label" style="display: inline-block; width: 150px;">TANGGAL</label>
                    <input class="form-control" value="<?php echo $tanggal; ?>"
                        style="display: inline-block; width: calc(100% - 160px);" readonly>
                </div>

                <div class="form-element">
                    <label class="form-label" style="display: inline-block; width: 150px;">PREPARED BY</label>
                    <input class="form-control" value="<?php echo htmlspecialchars($data_header['prepared_name']); ?>"
                        style="display: inline-block; width: calc(100% - 160px);" readonly>
                </div>

                <div class="form-element">
                    <label class="form-label" style="display: inline-block; width: 150px;">CHECKED BY</label>
                    <input class="form-control" value="<?php echo htmlspecialchars($data_header['checked_name']); ?>"
                        style="display: inline-block; width: calc(100% - 160px);" readonly>
                </div>

                <div class="form-element">
                    <label class="form-label" style="display: inline-block; width: 150px;">SECURITY</label>
                    <input class="form-control" value="<?php echo htmlspecialchars($data_header['security_name']); ?>"
                        style="display: inline-block; width: calc(100% - 160px);" readonly>
                </div>

                <div class="form-element">
                    <label class="form-label" style="display: inline-block; width: 150px;">DRIVER</label>
                    <input class="form-control" value="<?php echo htmlspecialchars($data_header['driver_name']); ?>"
                        style="display: inline-block; width: calc(100% - 160px);" readonly>
                </div>

                <div class="form-element">
                    <label class="form-label" style="display: inline-block; width: 150px;">RECEIVED BY</label>
                    <input class="form-control" value="<?php echo htmlspecialchars($data_header['received']); ?>"
                        style="display: inline-block; width: calc(100% - 160px);" readonly>
                </div>

                <div class="form-element">
                    <label class="form-label" style="display: inline-block; width: 150px;">NO KENDARAAN</label>
                    <input class="form-control" value="<?php echo htmlspecialchars($data_header['no_kendaraan']); ?>"
                        style="display: inline-block; width: calc(100% - 160px);" readonly>
                </div>
            </div>

            <br>

            <label class="form-label"
                style="display: flex; flex-direction: column; align-items: center; text-align: center; font-size: large;">
                TABEL DETAIL ITEM SURAT JALAN
            </label>
            <hr>

            <div class="mb-3">
                <a type="button" class="btn btn-success"
                    href="surat_jalan_detail-tambah.php?do_no=<?php echo htmlspecialchars($data_header['do_no']); ?>">Tambah
                    Item</a>
                <a type="button" class="btn btn-primary"
                    href="surat_jalan-cetak.php?do_no=<?php echo htmlspecialchars($data_header['do_no']); ?>"
                    style="color:white;">Cetak Surat Jalan</a>
            </div>

            <table width='100%' border=1 style="text-align: center;" class="table table-striped">
                <tr class="table-primary" style="color: black; text-align: center;">
                    <th>No</th>
                    <th>No Part</th>
                    <th>Nama Barang</th>
                    <th>Quantity Kirim</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
<?php
$index = 1;

// Query untuk mendapatkan detail surat jalan beserta nama barang
$query_detail = mysqli_query($conn, "
    SELECT sdo.*, b.nama_barang, b.qty
    FROM surat_jalan_detail sdo 
    LEFT JOIN barang b ON sdo.no_part = b.no_part 
    WHERE sdo.do_no = '" . mysqli_real_escape_string($conn, $do_no) . "'
");

while ($data_detail = mysqli_fetch_array($query_detail)) {
?>
    <tr>
        <td><?php echo htmlspecialchars($index++); ?></td>
        <td><?php echo htmlspecialchars($data_detail['no_part']); ?></td>
        <td><?php echo htmlspecialchars($data_detail['nama_barang']); ?></td>
        <td><?php echo number_format($data_detail['qty_pengiriman'], 0, ',', '.'); ?></td>
        <td><?php echo htmlspecialchars($data_detail['keterangan']); ?></td>
        <td>
            <a class="btn btn-primary btn-sm" href="surat_jalan_detail-ubah.php?do_no=<?php echo urlencode($data_header['do_no']); ?>&no_part=<?php echo urlencode($data_detail['no_part']); ?>">Ubah</a> |
            <a class="btn btn-danger btn-sm" href="surat_jalan_detail-hapus.php?do_no=<?php echo urlencode($data_header['do_no']); ?>&no_part=<?php echo urlencode($data_detail['no_part']); ?>" onclick="return confirm('Yakin mau hapus item ini?')">Hapus</a>
        </td>
    </tr>
<?php } ?>

            </table>

        </div>
    </div>

    <script src="../js/jquery.min.js"></script>
    <script src="../js/popper.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/main.js"></script>

</body>

</html>
