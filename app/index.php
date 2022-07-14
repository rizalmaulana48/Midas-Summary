<?php
require 'cek-sesi.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Summary Midas</title>

  <!-- Custom fonts for this template -->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

  <!-- Custom styles for this page -->
  <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">
<?php require 'koneksi.php'; ?>
<?php require 'sidebar.php'; ?>
      <!-- Main Content -->
      <div id="content">

<?php require 'navbar.php'; ?>

        <!-- Begin Page Content -->
        <div class="container-fluid">

        <!--<button type="button" class="btn btn-success" style="margin:5px " data-toggle="modal" data-target="#myModalTambah"><i class="fa fa-plus">Tambah Data</i></button><br>
          !--> 

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Daftar Proyek</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Nama Proyek</th>
                      <th>Alamat</th>
                      <th>Status</th>
                      <th>Referrall</th>
                      <th>Pimpro</th>
                      <th>Target Penjualan bulanan</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
				  <?php 
$query = mysqli_query($koneksi,"SELECT * FROM proyek");
$no = 1;
while ($data = mysqli_fetch_assoc($query)) 
{
?>
                      <tr>
                      <th scope="row"><?= $no;?></th>
                      <td><?=$data['nama_proyek']?></td>
                      <td><?=$data['alamat']?></td>
                      <td><?=$data['status']?></td>
                      <td><?=$data['referrall']?></td>
                      <td><?=$data['pimpro']?></td>
                      <td>Rp. <?=number_format($data['target_penjualan_bulanan'],2,',','.');?></td>
					  <td>
                    <!-- Button untuk modal -->
<a href="#" type="button" class=" fa fa-edit btn btn-primary btn-md" data-toggle="modal" data-target="#myModal<?php echo $data['idproyek']; ?>"></a>
</td>
</tr>
<?php 
$no++;
//mysql_close($host);
?>  
<!-- Modal Edit Mahasiswa-->
<div class="modal fade" id="myModal<?php echo $data['idproyek']; ?>" role="dialog">
<div class="modal-dialog">

<!-- Modal content-->
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title">Ubah Data Proyek</h4>
<button type="button" class="close" data-dismiss="modal">&times;</button>
</div>
<div class="modal-body">
<form role="form" action="proses-edit-proyek.php" method="POST" enctype="multipart/form-data">

<?php
$id = $data['idproyek']; 
$query_edit = mysqli_query($koneksi,"SELECT * FROM proyek WHERE idproyek ='$id'");
//$result = mysqli_query($conn, $query);
while ($row = mysqli_fetch_array($query_edit)) {  
?>


<input type="hidden" name="idproyek" value="<?php echo $row['idproyek']; ?>">

<div class="form-group">
<label>Nama Proyek</label>
<input type="text" name="nama_proyek" class="form-control" value="<?php echo $row['nama_proyek']; ?>">       
</div>

<div class="form-group">
<label>Alamat</label>
<input type="text" name="alamat" class="form-control" value="<?php echo $row['alamat']; ?>">      
</div>

<div class="form-group">
<label>Status</label>
<select class="form-control" name="status" value="<?php echo $row['status']; ?>">>
      <option value="aktif" >Aktif</option>
		 <option value="non-aktif" >Non-Aktif</option>
    </select>     
</div>

<div class="form-group">
<label>Referral</label>
<input type="text" name="referrall" class="form-control" value="<?php echo $row['referrall']; ?>">      
</div>



<div class="form-group">
<label>Pimpro</label>
<input type="text" name="pimpro" class="form-control" value="<?php echo $row['pimpro']; ?>">      
</div>

<label>Target Penjualan Bulanan</label>
<input type="number" name="target_penjualan_bulanan" class="form-control" value="<?php echo $row['target_penjualan_bulanan']; ?>">      
</div>

<div class="modal-footer">  
<button type="submit" class="btn btn-success">Ubah</button>
<a href="hapus-proyek.php?idproyek=<?=$row['idproyek'];?>" Onclick="confirm('Anda Yakin Ingin Menghapus?')" class="btn btn-danger">Hapus</a>
<button type="button" class="btn btn-default" data-dismiss="modal">Keluar</button>
</div>
<?php 
}
//mysql_close($host);
?>  
       
</form>
</div>
</div>

</div>
</div>



 <!-- Modal -->
  <div id="myModalTambah" class="modal fade" role="dialog">
    <div class="modal-dialog">

      <!-- konten modal-->
      <div class="modal-content">
        <!-- heading modal -->
        <div class="modal-header">
          <h4 class="modal-title">Tambah Proyek</h4>
		    <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- body modal -->
		<form action="tambah-proyek.php" method="POST" enctype="multipart/form-data">
    <div class="modal-body">
	  Nama Proyek: 
    <input type="text" class="form-control" name="nama_proyek">
		Alamat : 
         <input type="text" class="form-control" name="alamat">
		Status : 
    <select class="form-control" name="status">
      <option value="aktif" >Aktif</option>
		 <option value="non-aktif" >Non-Aktif</option>
    </select>
		Refferall : 
         <input type="text" class="form-control" name="referrall">
		Pimpro : 
         <input type="text" class="form-control" name="pimpro">
    Target Penjualan Bulanan : 
         <input type="number" class="form-control" name="target_penjualan_bulanan">
        </div>
        <!-- footer modal -->
        <div class="modal-footer">
		<button type="submit" class="btn btn-success" >Tambah</button>
		</form>
          <button type="button" class="btn btn-default" data-dismiss="modal">Keluar</button>
        </div>
      </div>

    </div>
  </div>


<?php               
} 
?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
		  

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

<?php require 'footer.php'?>

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
<?php require 'logout-modal.php';?>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/demo/datatables-demo.js"></script>

</body>

</html>
