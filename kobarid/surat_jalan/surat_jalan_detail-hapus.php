<?php
include '../koneksi.php';

if (isset($_GET['do_no']) && isset($_GET['no_part'])) {
    $do_no = mysqli_real_escape_string($conn, $_GET['do_no']);
    $no_part = mysqli_real_escape_string($conn, $_GET['no_part']);

    // Ambil qty_pengiriman dari surat_jalan_detail
    $query = "SELECT qty_pengiriman FROM surat_jalan_detail WHERE do_no = '$do_no' AND no_part = '$no_part'";
    $result = mysqli_query($conn, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
        $qty_pengiriman = $data['qty_pengiriman'];

        // Tambahkan qty_pengiriman ke stok barang
        $update_barang = "UPDATE barang SET qty = qty + $qty_pengiriman WHERE no_part = '$no_part'";
        if (mysqli_query($conn, $update_barang)) {
            // Hapus data dari surat_jalan_detail
            $delete = "DELETE FROM surat_jalan_detail WHERE do_no = '$do_no' AND no_part = '$no_part' LIMIT 1";
            if (mysqli_query($conn, $delete)) {

                // ✅ AMBIL po_no DARI surat_jalan
                $sj = mysqli_query($conn, "SELECT po_no FROM surat_jalan WHERE do_no = '$do_no'");
                $sj_data = mysqli_fetch_assoc($sj);
                $po_no = $sj_data['po_no'];

                // ✅ TOTAL QTY_PEMESANAN dari detail_purchase_order
                $po_total = mysqli_query($conn, "SELECT SUM(qty_pemesanan) AS total_pesan FROM detail_purchase_order WHERE po_no = '$po_no'");
                $po_total_data = mysqli_fetch_assoc($po_total);
                $total_pesan = (int)$po_total_data['total_pesan'];

                // ✅ TOTAL QTY_PENGIRIMAN dari semua surat_jalan_detail yang terkait PO ini
                $sj_total = mysqli_query($conn, "
                    SELECT SUM(sjd.qty_pengiriman) AS total_kirim
                    FROM surat_jalan_detail sjd
                    JOIN surat_jalan sj ON sjd.do_no = sj.do_no
                    WHERE sj.po_no = '$po_no'
                ");
                $sj_total_data = mysqli_fetch_assoc($sj_total);
                $total_kirim = (int)$sj_total_data['total_kirim'];

                // ✅ PERBAHARUI STATUS PO
                $status = ($total_kirim >= $total_pesan) ? 'Selesai' : 'Proses';
                mysqli_query($conn, "UPDATE purchase_order SET status = '$status' WHERE po_no = '$po_no'");

                // ✅ Redirect
                header("Location: surat_jalan_detail-lihat.php?do_no=$do_no");
                exit();
            } else {
                echo "Gagal menghapus item: " . mysqli_error($conn);
            }
        } else {
            echo "Gagal update stok barang: " . mysqli_error($conn);
        }
    } else {
        echo "Data item tidak ditemukan.";
    }
} else {
    echo "Parameter tidak lengkap.";
}
?>
