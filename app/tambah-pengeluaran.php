<?php
//include('dbconnected.php');
include('koneksi.php');


$jenis = $_POST['jenis'];
$nama_pengeluaran = $_POST['nama_pengeluaran'];
$tanggal = $_POST['tanggal'];
$jumlah = $_POST['jumlah'];
$jns_iklan = $_POST['jns_iklan'];
$idproyek = $_POST['idproyek'];
$atl = $_POST['atl'];


    // ambil data file
    $namaFile = $_FILES['file']['name'];
    $namaSementara = $_FILES['file']['tmp_name'];

    // tentukan lokasi file akan dipindahkan
    
    $dirUpload = "../assets/images/uploader/";

    // pindahkan file
    $terupload = move_uploaded_file($namaSementara, $dirUpload.$namaFile);

//query update
$query = mysqli_query($koneksi,"INSERT INTO `pengeluaran` (`id_pengeluaran`, `jenis`, `jns_iklan`, `nama_pengeluaran`, `tanggal`, `jumlah`, `foto`, `idproyek`, `atl`) VALUES (NULL, '$jenis', '$jns_iklan', '$nama_pengeluaran', '$tanggal', '$jumlah', '$namaFile', '$idproyek', '$atl')");

if ($query) {
 # credirect ke page index
 header("location:pengeluaran.php"); 
}
else{
 echo "ERROR, data gagal diupdate". mysqli_error($koneksi);
}

//mysql_close($host);
?>