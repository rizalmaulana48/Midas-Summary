<?php
//include('dbconnected.php');
include('koneksi.php');

$id = $_GET['id_fbads'];

//query update
$query = mysqli_query($koneksi,"DELETE FROM `fb_ads` WHERE id_fbads = '$id'");

if ($query) {
 # credirect ke page index
 header("location:fbads.php"); 
}
else{
 echo "ERROR, data gagal diupdate". mysqli_error($koneksi);
}

//mysql_close($host);
?>