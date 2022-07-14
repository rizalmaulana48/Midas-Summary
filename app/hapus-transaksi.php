<?php
//include('dbconnected.php');
include('koneksi.php');

$id = $_GET['idpenjualan'];


//query update
$query = mysqli_query($koneksi,"DELETE FROM `penjualan` WHERE idpenjualan = '$id'");



if ($query) {
 # credirect ke page index
 header("location:penjualan.php"); 
}
else{
 echo "ERROR, data gagal diupdate". mysqli_error($koneksi);
}

//mysql_close($host);
?>