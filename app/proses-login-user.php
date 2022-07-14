<?php
// mengaktifkan session php
session_start();
 
// menghubungkan dengan koneksi
include 'koneksi.php';
 $email = $_POST['email'];
 $pass = md5($_POST['pass']);

 $login = mysqli_query($koneksi, "SELECT * from user where email ='$email' and pass='$pass' and group_user = '0'");
 $cek = mysqli_num_rows($login);
 if($cek > 0 ) {
 $sesi = mysqli_query($koneksi,"select * from user where email='$email' and pass='$pass'and group_user= '0'");
 $sesi = mysqli_fetch_assoc($sesi);
	$_SESSION['id'] = $sesi['id_user'];
	$_SESSION['nama'] = $sesi['nama'];
	$_SESSION['status'] = "login";
	header("location:pengeluaran-user.php");
}else{
	header("location:login.php?pesan=gagal");
}
?>