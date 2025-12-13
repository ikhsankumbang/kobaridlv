<?php
include '../koneksi.php';

$no_invoice = $_GET['no_invoice'];
$invoice = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM invoice WHERE no_invoice = '$no_invoice'"));

$tanggal = $invoice['tanggal'];
$nsfp = $invoice['nsfp'];
$subtotal = $invoice['subtotal'];
$ppn = $invoice['ppn'];
$total_harga = $invoice['total_harga'];

// Ambil DO yang sudah dipilih sebelumnya
$selected_dos = [];
$q_dos = mysqli_query($conn, "SELECT do_no FROM invoice_suratjalan WHERE no_invoice = '$no_invoice'");
while ($row = mysqli_fetch_assoc($q_dos)) {
  $selected_dos[] = $row['do_no'];
}

// Ambil semua DO dari PO yang sama
$po_no = '';
$po_q = mysqli_query($conn, "
  SELECT sj.po_no 
  FROM surat_jalan sj 
  JOIN invoice_suratjalan isj ON sj.do_no = isj.do_no 
  WHERE isj.no_invoice = '$no_invoice' LIMIT 1
");
if ($po_row = mysqli_fetch_assoc($po_q)) {
  $po_no = $po_row['po_no'];
}

$do_data = [];
$do_q = mysqli_query($conn, "
  SELECT sj.do_no,
    (SELECT SUM(sjd.qty_pengiriman * b.harga)
     FROM surat_jalan_detail sjd
     JOIN barang b ON sjd.no_part = b.no_part
     WHERE sjd.do_no = sj.do_no) AS subtotal
  FROM surat_jalan sj
  WHERE sj.po_no = '$po_no'
");

while ($do = mysqli_fetch_assoc($do_q)) {
  $do_no = $do['do_no'];
  $subtotal_do = round($do['subtotal'] ?? 0);

  // Cek apakah DO sudah dipakai di invoice lain
  $is_used = mysqli_query($conn, "
    SELECT * FROM invoice_suratjalan 
    WHERE do_no = '$do_no' AND no_invoice != '$no_invoice'
  ");
  if (mysqli_num_rows($is_used) == 0 || in_array($do_no, $selected_dos)) {
    $do_data[$do_no] = $subtotal_do;
  }
}

if (isset($_POST['proses'])) {
  $tanggal = $_POST['tanggal'];
  $nsfp = $_POST['nsfp'];
  $subtotal = $_POST['subtotal'];
  $ppn = $_POST['ppn'];
  $total_harga = $_POST['total_harga'];
  $do_nos = $_POST['do_nos'] ?? [];

  if (empty($tanggal) || count($do_nos) == 0) {
    echo "<script>alert('TANGGAL dan minimal 1 Surat Jalan wajib diisi!');</script>";
  } else {
    mysqli_query($conn, "UPDATE invoice SET tanggal='$tanggal', nsfp='$nsfp', subtotal='$subtotal', ppn='$ppn', total_harga='$total_harga' WHERE no_invoice='$no_invoice'");
    mysqli_query($conn, "DELETE FROM invoice_suratjalan WHERE no_invoice='$no_invoice'");
    foreach ($do_nos as $do_no) {
      mysqli_query($conn, "INSERT INTO invoice_suratjalan VALUES ('$no_invoice', '$do_no')");
    }
    
    echo "<script>window.location.href = 'invoice_detail-lihat.php?no_invoice=" . $no_invoice . "';</script>";
  }
}
?>

<!doctype html>
<html lang="en">
<head>
  <title>Ubah Invoice</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="../css/style.css">
</head>

<body>
  <form action="" method="post">
    <div class="wrapper d-flex align-items-stretch">
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
              <li><a href="../surat_jalan/surat_jalan-lihat.php">Surat Jalan</a></li>
              <li class="active"><a href="../invoice/invoice-lihat.php">Invoice</a></li>
              <li> <a href="../index.php?logout=true">Logout</a></li>
            </ul>
            <div class="footer">
              <p>Mbd &copy;<script>document.write(new Date().getFullYear());</script><br><i class="icon-heart" aria-hidden="true"></i></p>
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
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="nav navbar-nav ml-auto">
              <li class="nav-item"><a class="nav-link" href="../home.php">Home</a></li>
              <li class="nav-item"><a class="nav-link" href="../customer/customer-lihat.php">Customer</a></li>
              <li class="nav-item"><a class="nav-link" href="../barang/barang-lihat.php">Barang</a></li>
              <li class="nav-item"><a class="nav-link" href="../pegawai/pegawai-lihat.php">Pegawai</a></li>
              <li class="nav-item"><a class="nav-link" href="../purchase_order/purchase_order-lihat.php">Purchase Order</a></li>
              <li class="nav-item"><a class="nav-link" href="../surat_jalan/surat_jalan-lihat.php">Surat Jalan</a></li>
              <li class="nav-item active"><a class="nav-link" href="../invoice/invoice-lihat.php">Invoice</a></li>
            </ul>
          </div>
        </div>
      </nav>
          <div class="form">
            <label class="form-label" style="display: flex; flex-direction: column; align-items: center; text-align: center; font-size: large;">UBAH INVOICE</label>
            <hr>

            <div class="form-element">
              <label class="form-label" style="display: inline-block; width: 100px;">NO INVOICE</label>
              <input type="text" class="form-control" readonly value="<?= htmlspecialchars($no_invoice) ?>" style="display: inline-block; width: calc(100% - 110px);">
            </div>

            <div class="form-element">
              <label class="form-label" style="display: inline-block; width: 100px;">TANGGAL</label>
              <input type="date" name="tanggal" value="<?= $tanggal ?>" class="form-control" required style="display: inline-block; width: calc(100% - 110px);">
            </div>

            <div class="form-element">
              <label class="form-label" style="display: inline-block; width: 100px;">NSFP</label>
              <input type="text" name="nsfp" value="<?= $nsfp ?>" class="form-control" placeholder="NSFP" style="display: inline-block; width: calc(100% - 110px);">
            </div>

            <div class="form-element">
              <label class="form-label" style="display: inline-block; width: 100px;">PO NO</label>
              <input type="text" name="po_no" value="<?= $po_no ?>" class="form-control" readonly style="display: inline-block; width: calc(100% - 110px);">
            </div>
            <div class="form-element" style="display: flex; align-items: flex-start;">
              <label class="form-label" style="display: inline-block; width: 100px; margin-top: 10px;">SURAT JALAN</label>
              <div id="do_container" style="flex: 1; padding: 4px;">
                <?php foreach ($do_data as $do => $sub) {
                  $checked = in_array($do, $selected_dos) ? "checked" : "";
                  $label = "$do - Subtotal: Rp" . number_format($sub, 0, ',', '.');
                  echo "
                    <div style='margin-bottom: 6px; max-width: 500px;'>
                      <div style='display: flex; justify-content: space-between; align-items: center; padding: 8px 12px; border: 1px solid #ccc; border-radius: 6px; background-color: #fefefe;'>
                        <span style='font-size: 14px; color: #333;'>$label</span>
                        <input type='checkbox' name='do_nos[]' value='$do' onchange='hitungTotal()' $checked style='width: 18px; height: 18px; cursor: pointer;'>
                      </div>
                    </div>
                  ";
                } ?>
              </div>
            </div>


            <div class="form-element">
            <label class="form-label" style="display: inline-block; width: 100px;">SUBTOTAL</label>
            <input type="number" name="subtotal" id="subtotal" value="<?= $subtotal ?>" class="form-control" readonly style="display: none;">
            <span id="subtotal_display" style="display: inline-block; width: calc(100% - 110px); padding: 10px; border: 1px solid #ccc; border-radius: 4px; background: #f5f5f5;">
              Rp <?= number_format($subtotal, 0, ',', '.') ?>
            </span>
          </div>

          <div class="form-element">
            <label class="form-label" style="display: inline-block; width: 100px;">PPN</label>
            <input type="number" name="ppn" id="ppn" value="<?= $ppn ?>" class="form-control" readonly style="display: none;">
            <span id="ppn_display" style="display: inline-block; width: calc(100% - 110px); padding: 10px; border: 1px solid #ccc; border-radius: 4px; background: #f5f5f5;">
              Rp <?= number_format($ppn, 0, ',', '.') ?>
            </span>
          </div>

          <div class="form-element">
            <label class="form-label" style="display: inline-block; width: 100px;">TOTAL</label>
            <input type="number" name="total_harga" id="total_harga" value="<?= $total_harga ?>" class="form-control" readonly style="display: none;">
            <span id="total_display" style="display: inline-block; width: calc(100% - 110px); padding: 10px; border: 1px solid #ccc; border-radius: 4px; background: #f5f5f5;">
              Rp <?= number_format($total_harga, 0, ',', '.') ?>
            </span>
          </div>


            <br>
            <div class="tombol" style="text-align: right;">
              <button type="submit" name="proses" class="btn btn-success">Ubah</button>
              <a href="invoice-lihat.php" class="btn btn-danger">Batal</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>

  <script>
  const doData = <?= json_encode($do_data); ?>;

  function hitungTotal() {
    let subtotal = 0;
    document.querySelectorAll('input[name="do_nos[]"]:checked').forEach(cb => {
      subtotal += doData[cb.value] || 0;
    });
    const ppn = subtotal * 0.11;
    const total = subtotal + ppn;

    // Isi nilai asli ke input hidden
    document.getElementById('subtotal').value = Math.round(subtotal);
    document.getElementById('ppn').value = Math.round(ppn);
    document.getElementById('total_harga').value = Math.round(total);

    // Tampilkan dalam format Rp
    document.getElementById('subtotal_display').innerText = 'Rp ' + Math.round(subtotal).toLocaleString('id-ID');
    document.getElementById('ppn_display').innerText = 'Rp ' + Math.round(ppn).toLocaleString('id-ID');
    document.getElementById('total_display').innerText = 'Rp ' + Math.round(total).toLocaleString('id-ID');
  }

  document.addEventListener('DOMContentLoaded', hitungTotal);
</script>

</body>
</html>
