<?php
// include database connection file
include '../koneksi.php';
 
// Get id from URL to delete that user
if (isset($_GET['po_no'])) {
    $po_no=$_GET['po_no'];
}
 
// Delete user row from table based on given id
$result = mysqli_query($conn, "DELETE FROM purchase_order WHERE po_no='$po_no'");
 
// After delete redirect to Home, so that latest user list will be displayed.
header("Location:purchase_order-lihat.php");
?>