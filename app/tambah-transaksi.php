<?php
//include('dbconnected.php');
include('koneksi.php');


$nama_konsumen = $_POST['nama_konsumen'];
$tgl_transaksi = $_POST['tgl_transaksi'];
$harga_net = $_POST['harga_net'];
$booking_fee = $_POST['booking_fee'];
$idproyek = $_POST['idproyek'];
$idpegawai = $_POST['idpegawai'];

//query update
$query = mysqli_query($koneksi,"INSERT INTO `penjualan` (`idpenjualan`, `nama_konsumen`, `tgl_transaksi`,`harga_net`,`booking_fee`,`idproyek`, `idpegawai`) VALUES (NULL, '$nama_konsumen', '$tgl_transaksi', '$harga_net', '$booking_fee', '$idproyek', '$idpegawai')");




if ($query) {
 # credirect ke page index
 header("location:penjualan.php"); 
}
else{
 echo "ERROR, data gagal diupdate". mysqli_error($koneksi);
}

//mysql_close($host);
?>