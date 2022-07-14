<?php
//include('dbconnected.php');
include('koneksi.php');

$id = $_POST['id_fbads'];
$idproyek = $_POST['idproyek'];
$tgl_mulai = $_POST['tgl_mulai'];
$tgl_akhir = $_POST['tgl_akhir'];
$nama_campaign = $_POST['nama_campaign'];
$reach = $_POST['reach'];
$impression = $_POST['impression'];
$db = $_POST['db'];
$non_db_leads = $_POST['non_db_leads'];

//query update
$query = mysqli_query($koneksi,"UPDATE fb_ads SET idproyek ='$idproyek', nama_campaign='$nama_campaign', tgl_input='$tgl_input', tgl_mulai='$tgl_mulai', tgl_akhir='$tgl_akhir', reach='$reach', impression='$impression', db='$db', non_db_leads='$non_db_leads' WHERE id_fbads='$id' ");

if ($query) {
 # credirect ke page index
 header("location:fbads.php"); 
}
else{
 echo "ERROR, data gagal diupdate". mysql_error();
}

//mysql_close($host);
?>