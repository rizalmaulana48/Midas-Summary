<?php
//include('dbconnected.php');
include('koneksi.php');

$id = $_POST['idproyek'];
$nama_proyek = $_POST['nama_proyek'];
$status = $_POST['status'];
$alamat = $_POST['alamat'];
$refferall = $_POST['referrall'];
$pimpro = $_POST['pimpro'];
$target_penjualan_bulanan = $_POST['target_penjualan_bulanan'];

 
//query update
$query = mysqli_query($koneksi,"UPDATE proyek SET nama_proyek='$nama_proyek' , status='$status', alamat='$alamat', referrall='$referrall', pimpro='$pimpro', target_penjualan_bulanan='$target_penjualan_bulanan' WHERE idproyek='$id' ");

if ($query) {
 # credirect ke page index
 header("location:index.php"); 
}
else{
 echo "ERROR, data gagal diupdate". mysql_error();
}

//mysql_close($host);
?>