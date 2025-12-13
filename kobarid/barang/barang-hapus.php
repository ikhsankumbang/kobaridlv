<?php
// include database connection file
include '../koneksi.php';
 
// Get id from URL to delete that user
if (isset($_GET['no_part'])) {
    $no_part=$_GET['no_part'];
}
 
// Delete user row from table based on given id
$result = mysqli_query($conn, "DELETE FROM barang WHERE no_part='$no_part'");
 
// After delete redirect to Home, so that latest user list will be displayed.
header("Location:barang-lihat.php");
?>