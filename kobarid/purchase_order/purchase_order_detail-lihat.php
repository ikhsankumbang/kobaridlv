<?php
include '../koneksi.php';

// Periksa apakah 'nota_no' ada di URL

if (isset($_GET['po_no']) && !empty($_GET['po_no'])) {
    $po_no = $_GET['po_no'];

    // Perbaiki relasi: purchase_order.po_no = $_GET['po_no']
    // dan JOIN ke customer via id_customer
    $query = mysqli_query($conn, "SELECT n.*, p.nama_customer 
                                  FROM purchase_order n 
                                  JOIN customer p ON n.id_customer = p.id_customer 
                                  WHERE n.po_no = '$po_no'");

    $data = mysqli_fetch_array($query);

    if ($data) {
        $tanggal = date('d/m/Y', strtotime($data['tanggal']));
    } else {
        die("Purchase Order tidak ditemukan.");
    }
} else {
    die("PO NO tidak disediakan.");
}
?>

<!doctype html>
<html lang="en">

<head>
    <title>Purchase_order_detail-lihat</title>
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
          <li class="active"><a href="#purchase_order" data-toggle="collapse" aria-expanded="false">Purchase Order</a></li>
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
                   <label class="form-label">DETAIL PO: <?php echo htmlspecialchars($data['po_no']); ?></label>
                    <hr>
                    <a class="btn btn-danger btn-sm" href="purchase_order-lihat.php">Kembali</a>
                    <div class="form-element">
                        <label class="form-label" style="display: inline-block; width: 100px;">PO NO</label>
                        <input class="form-control" value="<?php echo htmlspecialchars($data['po_no']); ?>" style="display: inline-block; width: calc(100% - 110px);" readonly>
                    </div>

                    <div class="form-element">
                        <label class="form-label" style="display: inline-block; width: 100px;">NAMA</label>
                        <input class="form-control" value="<?php echo htmlspecialchars($data['nama_customer']); ?>" style="display: inline-block; width: calc(100% - 110px);" readonly>
                    </div>

                    <div class="form-element">
                        <label class="form-label" style="display: inline-block; width: 100px;">TANGGAL</label>
                        <input class="form-control" value="<?php echo $tanggal; ?>" style="display: inline-block; width: calc(100% - 110px);" readonly>
                    </div>

                    

                    <div class="form-element">
                        <label class="form-label" style="display: inline-block; width: 100px;">SCHEDULE</label>
                        <input class="form-control" value="<?php echo htmlspecialchars($data['schedule_delivery']); ?>" style="display: inline-block; width: calc(100% - 110px);" readonly>
                    </div>

                   
                </div>

                <br>

                <label class="form-label" style="display: flex; flex-direction: column; align-items: center; text-align: center; font-size: large;">TABEL DETAIL NOTA</label>
                <hr>
                <div class="mb-3">
                    <a type="button" class="btn btn-success" href="purchase_order_detail-tambah.php?po_no=<?php echo htmlspecialchars($data['po_no']); ?>">Tambah</a>
                                 </div>
                    <table width='100%' border=1 style="text-align: center;">
                        <tr class="table-primary" style="color: black; text-align: center;">
                            <th>No</th>
                            <th>No Part</th>
                            <th>QTY Pemesanan</th>
                            <th>Aksi</th>
                        </tr>

                            <?php
    include '../koneksi.php';
    $index = 1;

    // Gantilah $nota_no dengan $po_no jika kamu ambil dari parameter GET misalnya
    $po_no = $_GET['po_no'];

    $query = mysqli_query($conn, "SELECT B.no_part, B.nama_barang, D.po_no, D.qty_pemesanan
                                  FROM detail_purchase_order D
                                  JOIN barang B ON D.no_part = B.no_part
                                  WHERE D.po_no = '$po_no'");

    while ($data = mysqli_fetch_array($query)) {
    ?>
        <tr>
            <td><?php echo htmlspecialchars($index++); ?></td>
            <td><?php echo htmlspecialchars($data['nama_barang']); ?></td>
            <td><?php echo number_format($data['qty_pemesanan'], 0, ',', '.'); ?></td>
            <td>
              
                <a class="btn btn-danger btn-sm" href="purchase_order_detail-hapus.php?po_no=<?php echo htmlspecialchars($data['po_no']); ?>&no_part=<?php echo htmlspecialchars($data['no_part']); ?>" onclick="return confirm('Yakin hapus?')">Hapus</a>
            </td>
        </tr>
    <?php } ?> 
                    
                </table>
            </div>
        </div>
    </form>

    <script src="../js/jquery.min.js"></script>
    <script src="../js/popper.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/main.js"></script>
</body>

</html>
