<?php
//include('dbconnected.php');
include('koneksi.php');

$id = $_POST['id_pengeluaran'];
$idproyek = $_POST['idproyek'];
$jenis = $_POST['jenis'];
$jns_iklan = $_POST['jns_iklan'];
$nama_pengeluaran = $_POST['nama_pengeluaran'];
$tanggal = $_POST['tanggal'];
$jumlah = $_POST['jumlah'];
$atl = $_POST['atl'];

   // ambil data file
   $namaFile = $_FILES['file']['name'];
   $namaSementara = $_FILES['file']['tmp_name'];

   // tentukan lokasi file akan dipindahkan
   $dirUpload = "../assets/images/uploader/";

   // pindahkan file
   $terupload = move_uploaded_file($namaSementara, $dirUpload.$namaFile);

//query update
$query = mysqli_query($koneksi,"UPDATE pengeluaran SET idproyek ='$idproyek', jenis='$jenis', jns_iklan='$jns_iklan', nama_pengeluaran='$nama_pengeluaran', tanggal='$tanggal', jumlah='$jumlah', foto='$namaFile', atl='$atl' WHERE id_pengeluaran='$id' ");

if ($query) {
 # credirect ke page index
 header("location:pengeluaran.php"); 
}
else{
 echo "ERROR, data gagal diupdate". mysql_error();
}

//mysql_close($host);
?>