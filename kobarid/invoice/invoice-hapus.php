<?php
include '../koneksi.php';

if (isset($_GET['no_invoice'])) {
    $no_invoice = $_GET['no_invoice'];

    // Hapus relasi dari invoice_suratjalan terlebih dahulu
    mysqli_query($conn, "DELETE FROM invoice_suratjalan WHERE no_invoice='$no_invoice'");

    // Baru hapus invoice-nya
    mysqli_query($conn, "DELETE FROM invoice WHERE no_invoice='$no_invoice'");
}

header("Location:invoice-lihat.php");
?>