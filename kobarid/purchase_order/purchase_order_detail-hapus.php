<?php
include '../koneksi.php';

if (isset($_GET['po_no']) && isset($_GET['no_part'])) {
    $po_no = mysqli_real_escape_string($conn, $_GET['po_no']);
    $no_part = mysqli_real_escape_string($conn, $_GET['no_part']);

    // Hapus data detail PO
    $result = mysqli_query($conn, "DELETE FROM detail_purchase_order WHERE po_no = '$po_no' AND no_part = '$no_part' LIMIT 1");

    // Redirect kembali ke halaman detail PO
    header("Location: purchase_order_detail-lihat.php?po_no=$po_no");
    exit;
}
?>