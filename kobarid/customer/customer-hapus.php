<?php
// include database connection file
include '../koneksi.php';
 
// Get id from URL to delete that user
if (isset($_GET['id_customer'])) {
    $id_customer=$_GET['id_customer'];
}
 
// Delete user row from table based on given id
$result = mysqli_query($conn, "DELETE FROM customer WHERE id_customer='$id_customer'");
 
// After delete redirect to Home, so that latest user list will be displayed.
header("Location:customer-lihat.php");
?>