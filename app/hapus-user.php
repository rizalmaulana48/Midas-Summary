<?php
//include('dbconnected.php');
include('koneksi.php');

$id = $_GET['id_user'];

//query update
$query = mysqli_query($koneksi,"DELETE FROM `user` WHERE id_user = '$id'");

if ($query) {
 # credirect ke page index
 header("location:profile.php"); 
}
else{
 echo "ERROR, data gagal diupdate". mysqli_error($koneksi);
}

//mysql_close($host);
?>