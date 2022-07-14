<?php
//include('dbconnected.php');
include('koneksi.php');

$nama_proyek = $_POST['nama_proyek'];
$status = $_POST['status'];
$alamat = $_POST['alamat'];
$referrall = $_POST['referrall'];
$pimpro = $_POST['pimpro'];
$target_penjualan_bulanan = $_POST['target_penjualan_bulanan'];

//query update
$query = mysqli_query($koneksi,"INSERT INTO `proyek` (`idproyek`, `nama_proyek`, `status`, `alamat`, `referrall`, `pimpro`, `target_penjualan_bulanan`) VALUES (null, '$nama_proyek', '$status', '$alamat', '$referrall', '$pimpro', '$target_penjualan_bulanan')");

if ($query) {
 # credirect ke page index
 header("location:index.php"); 
}
else{
 echo "ERROR, data gagal diupdate". mysqli_error($koneksi);
}

//mysql_close($host);
?>