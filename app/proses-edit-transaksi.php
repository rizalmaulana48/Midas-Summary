<?php
//include('dbconnected.php');
include('koneksi.php');

$id = $_POST['idpenjualan'];
$idproyek = $_POST['idproyek'];
$idpegawai = $_POST['idpegawai'];
$nama_konsumen = $_POST['nama_konsumen'];
$tgl_transaksi = $_POST['tgl_transaksi'];
$harga_net = $_POST['harga_net'];
$booking_fee = $_POST['booking_fee'];

//query update
$query = mysqli_query($koneksi,"UPDATE penjualan SET idproyek ='$idproyek', idpegawai ='$idpegawai', nama_konsumen='$nama_konsumen', tgl_transaksi='$tgl_transaksi', harga_net='$harga_net', booking_fee='$booking_fee' WHERE idpenjualan='$id' ");

if ($query) {
 # credirect ke page index
 header("location:penjualan.php"); 
}
else{
 echo "ERROR, data gagal diupdate". mysql_error();
}

//mysql_close($host);
?>