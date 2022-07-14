<?php
//include('dbconnected.php');
include('koneksi.php');

$nama = $_GET['nama'];
$group = $_GET['group_user'];
$email = $_GET['email'];
$pass = $_GET['pass'];
$pass = md5($pass);


//query update
$query = mysqli_query($koneksi,"INSERT INTO `user` (`id_user`,`nama`, `group_user`, `email`, `pass`) VALUES (null, '$nama', '$group', '$email', '$pass')");

if ($query) {
 # credirect ke page index
 header("location:profile.php"); 
}
else{
 echo "ERROR, data gagal diupdate". mysqli_error($koneksi);
}

//mysql_close($host);
?>