<?php
//include('dbconnected.php');
include('koneksi.php');


$nama_campaign = $_POST['nama_campaign'];
$tgl_mulai = $_POST['tgl_mulai'];
$tgl_akhir = $_POST['tgl_akhir'];
$reach = $_POST['reach'];
$jenis_iklan = $_POST['jenis_iklan'];
$impression = $_POST['impression'];
$db = $_POST['db'];
$non_db_leads = $_POST['non_db_leads'];
$idproyek = $_POST['idproyek'];

$tgl_input = date("Y-m-d");

//query update
$query = mysqli_query($koneksi,"INSERT INTO `fb_ads` (`id_fbads`, `nama_campaign`, `jenis_iklan`, `tgl_input`, `reach`, `impression`,`db`,`non_db_leads`, `tgl_mulai`, `tgl_akhir`, `idproyek`) VALUES (NULL, '$nama_campaign', '$jenis_iklan', '$tgl_input', '$reach', '$impression', '$db', '$non_db_leads', '$tgl_mulai', '$tgl_akhir', '$idproyek')");




if ($query) {
 # credirect ke page index
 header("location:fbads.php"); 
}
else{
 echo "ERROR, data gagal diupdate". mysqli_error($koneksi);
}

//mysql_close($host);
?>