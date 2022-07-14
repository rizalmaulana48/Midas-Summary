<?php
// mengaktifkan session php
session_start();
 
// menghubungkan dengan koneksi
include 'koneksi.php';
 $email = $_POST['email'];
 $pass = md5($_POST['pass']);

 $login = mysqli_query($koneksi, "SELECT * from user where email ='$email' and pass='$pass' and group_user ='1'");
 $login1 = mysqli_query($koneksi, "SELECT * from user where email ='$email' and pass='$pass' and group_user ='0'");
 $cek = mysqli_num_rows($login);
 $cek1 = mysqli_num_rows($login1);
 if($cek > 0 ) {
 $sesi = mysqli_query($koneksi,"select * from user where email ='$email' and pass='$pass' and group_user ='1'");
 $sesi = mysqli_fetch_assoc($sesi);
	$_SESSION['id'] = $sesi['id_user'];
	$_SESSION['nama'] = $sesi['nama'];
	$_SESSION['group_user'] = $sesi['group_user'];
	$_SESSION['status'] = "login";
	header("location:index.php");
}else if($cek1 > 0 ){
	$sesi = mysqli_query($koneksi,"select * from user where email ='$email' and pass='$pass' and group_user ='0'");
 	$sesi = mysqli_fetch_assoc($sesi);
	$_SESSION['id'] = $sesi['id_user'];
	$_SESSION['nama'] = $sesi['nama'];
	$_SESSION['group_user'] = $sesi['group_user'];
	$_SESSION['status'] = "login";
	header("location:pengeluaran-user.php");
}else{
	header("location:login.php?pesan=gagal");
}
?>