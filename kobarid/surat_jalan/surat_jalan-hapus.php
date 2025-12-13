<?php
// include database connection file
include '../koneksi.php';
 
// Get id from URL to delete that user
if (isset($_GET['do_no'])) {
    $do_no=$_GET['do_no'];
}
 
// Delete user row from table based on given id
$result = mysqli_query($conn, "DELETE FROM surat_jalan WHERE do_no='$do_no'");
 
// After delete redirect to Home, so that latest user list will be displayed.
header("Location:surat_jalan-lihat.php");
?>