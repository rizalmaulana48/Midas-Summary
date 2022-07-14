<?php
//include('dbconnected.php');
include('koneksi.php');

$group = $_GET['group_user'];
$id = $_GET['id_user'];
$nama = $_GET['nama'];
$email = $_GET['email'];
$pass = $_GET['pass'];
$pass = md5($pass);

//query update
$query = mysqli_query($koneksi,"UPDATE user SET nama='$nama' , group_user='$group', email='$email', pass='$pass' WHERE id_user='$id' ");

if ($query) {
 # credirect ke page index
 header("location:profile.php"); 
}
else{
 echo "ERROR, data gagal diupdate". mysqli_error($Koneksi);
}

//mysql_close($host);
?>