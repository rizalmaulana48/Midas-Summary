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

  <title>SB Admin 2 - Tables</title>

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
        <div class="d-sm-flex align-items-center justify-content-between ">
        <button type="button" class="btn btn-success" style="margin:5px 0px 5px 0px" data-toggle="modal" data-target="#myModalTambah"><i class="fa fa-plus"> Pengeluaran </i></button><br>
        
        <button type="button" class="btn btn-primary btn-md" style= "margin:5px 1120px 5px 0px "data-toggle="modal" data-target="#myModalPrint"><i class="fa fa-print"> Pengeluaran </i></button><br>
          
        
      
          </div>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Daftar Pengeluaran</h6>
                  
            </div>
            <div class="card-body">
            <div class="d-sm-flex align-items-center left-content-between">
            <form action="" method="GET">
            <h5 class=" font-weight-bold text-primary"> Filter </h5>
                  <input type="date" name="awal"> - 
                  <input type="date" name="akhir">
                  <button type="submit" name="tampil" value="tampil">mulai</button> 
                  </form></div><br>
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Nama Proyek</th>
                      <th>Jenis Pengeluaran</th>
                      <th>Jenis Iklan</th>
                      <th>Nama Pengeluaran</th>
                      <th>Tanggal Pengeluaran</th>
                      <th>Jumlah Pengeluaran</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
				  <?php 
$query = mysqli_query($koneksi,"SELECT * FROM pengeluaran INNER JOIN proyek ON pengeluaran.idproyek = proyek.idproyek ORDER BY id_pengeluaran DESC");
$no = 1;

if(isset($_GET["tampil"])){
  $dt1 = $_GET["awal"];
  $dt2 = $_GET["akhir"];
  $sql = "SELECT * FROM pengeluaran INNER JOIN proyek ON pengeluaran.idproyek = proyek.idproyek WHERE tanggal BETWEEN '$dt1' AND '$dt2'";
			$query = mysqli_query($koneksi,$sql) or die (mysqli_error($koneksi));
}

while ($data = mysqli_fetch_assoc($query)) 
{
?>
                    <tr>
                    <td scope="row"><?= $no;?></td>
                      <td><?=$data['nama_proyek']?></td>
                      <td><?=$data['jenis']?></td>
                      <td><?=$data['jns_iklan']?></td>
                      <td><?=$data['nama_pengeluaran']?></td>
                      <td><?=date('d F Y', strtotime($data['tanggal']))?></td>
                      <td>Rp. <?=number_format($data['jumlah'],2,',','.');?></td>
                      
					  <td>
                    <!-- Button untuk modal -->
<a href="#" type="button" class=" fa fa-edit btn btn-primary btn-md" data-toggle="modal" data-target="#myModal<?php echo $data['id_pengeluaran']; ?>"></a>
<a href="detail-pengeluaran.php?id_pengeluaran=<?=$data['id_pengeluaran']; ?>"  type="button" style="margin:5px "class="btn btn-primary btn-md">  Detail </a>
                     
</td>
</tr>
<?php 
$no++;
//mysql_close($host);
?> 

<!-- Modal Edit Mahasiswa-->
<div class="modal fade" id="myModal<?php echo $data['id_pengeluaran']; ?>" role="dialog">
<div class="modal-dialog">

<!-- Modal content-->
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title">Ubah Data Pengeluaran</h4>
<button type="button" class="close" data-dismiss="modal">&times;</button>
</div>
<div class="modal-body">
<form role="form" action="proses-edit-pengeluaran.php" method="POST" enctype="multipart/form-data">

<?php
$id = $data['id_pengeluaran']; 
$query_edit = mysqli_query($koneksi,"SELECT * FROM pengeluaran WHERE id_pengeluaran ='$id'");
//$result = mysqli_query($conn, $query);
while ($row = mysqli_fetch_array($query_edit)) {  
?>


<input type="hidden" name="id_pengeluaran" value="<?php echo $row['id_pengeluaran']; ?>">

        <div class="form-group">
                    <label for="idproyek">Proyek</label>
                    <select name="idproyek" id="idproyek" class="form-control">
                        <option value=""> - Proyek yang diminati - </option>
                        <?php
                          $idproyek = mysqli_query($koneksi, "SELECT * FROM proyek where is_active='1' AND nonzone='0'");
                          while ($data_proyek = mysqli_fetch_array($idproyek)) {
                            if ($row['idproyek']==$data_proyek['idproyek']) {
                              $select="selected";
                             }else{
                              $select="";
                             }
                            echo  "<option $select>".$data_proyek['idproyek'].'. '.$data_proyek['nama_proyek']."</option>";
                          }
                        ?>
                    </select>     
                    </div>


<div class="form-group">
<label >Jenis Pengeluaran </label>
<?php $jp = $data['jenis']; ?>
<select name="jenis" class="form-control">
<option <?php echo ($jp == 'online') ? "selected": "" ?>>online</option>
<option <?php echo ($jp == 'offline') ? "selected": "" ?>>offline</option>
<option <?php echo ($jp == 'operasional') ? "selected": "" ?>>operasional</option>
</select>
</div>

<div class="form-group">
<label >Jenis Iklan </label>
<?php $jp = $data['jns_iklan']; ?>
<select name="jns_iklan" class="form-control">
<option <?php echo ($jp == 'single') ? "selected": "" ?>>Single</option>
<option <?php echo ($jp == 'canva') ? "selected": "" ?>>Canva</option>
</select>
</div>

<div class="form-group">
<label>Nama Pengeluaran</label>
<input type="text" name="nama_pengeluaran" class="form-control" value="<?php echo $row['nama_pengeluaran']; ?>">      
</div>

<div class="form-group">
<label>Tanggal Pengeluaran</label>
<input type="date" name="tanggal" class="form-control" value="<?php echo $row['tanggal']; ?>">      
</div>

<div class="form-group">
<label>Jumlah Pengeluaran</label>
<input type="number" name="jumlah" class="form-control" value="<?php echo $row['jumlah']; ?>">      
</div>

<div class="form-group">
<label>Foto/Bon/Struk/Invoice</label>
<input type="file" name="file" class="form-control" value="<?php echo $row['file'];?>">      
</div>



<div class="modal-footer">  
<button type="submit" class="btn btn-success">Ubah</button>
<a href="hapus-pengeluaran.php?id_pengeluaran=<?=$row['id_pengeluaran'];?>" onclick="return confirm('Anda Yakin Ingin Menghapus?')" class="btn btn-danger">Hapus</a>
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

<div class="modal fade" id="myModals<?php echo $data['id_pengeluaran']; ?>" role="dialog">
<div class="modal-dialog">

<!-- Modal content-->
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title">Detail Pengeluaran</h4>
<button type="button" class="close" data-dismiss="modal">&times;</button>
</div>
<div class="modal-body">
<form role="form" action="proses-edit-pengeluaran.php" method="POST" enctype="multipart/form-data">

<?php
$id = $data['id_pengeluaran']; 
$query_edit = mysqli_query($koneksi,"SELECT * FROM pengeluaran WHERE id_pengeluaran ='$id'");
//$result = mysqli_query($conn, $query);
while ($row = mysqli_fetch_array($query_edit)) {  
?>


<input type="hidden" name="id_pengeluaran" value="<?php echo $row['id_pengeluaran']; ?>">

<div class="form-group">
<label><h6>Nama Proyek         : <?= $data['nama_proyek']?> </h6></label>
</div>
<div class="form-group">
<label><h6>Jenis Pengeluaran   : <?= $data['jenis']?></h6></label>
</div>
<div class="form-group">
<label><h6>Jenis Iklan         : <?= $data['jns_iklan']?></h6></label>
</div>
<div class="form-group">
<label><h6>Nama Pengeluaran    : <?= $data['nama_pengeluaran']?></h6></label>
</div>
<div class="form-group">
<label><h6>Tanggal Pengeluaran : <?=date('d F Y', strtotime($data['tanggal']))?></h6></label>
</div>
<div class="form-group">
<label><h6>Jumlah Pengeluaran  : Rp. <?=number_format($data['jumlah'],2,',','.');?></h6></label>
</div>
<div class="form-group">
<h5>Foto/Bon/Struk/Invoice : <embed src="../assets/images/uploader/<?= $data['foto'];?>" alt="" width="460" height="300"> </h5></label>
</div>              
<div class="modal-footer">  
<button type="button" class="btn btn-success" data-dismiss="modal">Keluar</button>
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
          <h4 class="modal-title">Tambah Data Pengeluaran</h4>
		    <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- body modal -->
		<form action="tambah-pengeluaran.php" method="POST" enctype="multipart/form-data">
    <div class="modal-body">
	   
    <label for="idproyek">Nama Proyek</label>
                       <select name="idproyek" id="idproyek" class="form-control" required>
                           <option value=""> - Pilih proyek - </option>
                           <?php
                             $idproyek = mysqli_query($koneksi, "SELECT * FROM proyek where is_active='1' AND nonzone='0'");
                             while ($data_proyek = mysqli_fetch_array($idproyek)) {
                               echo '<option value="'.$data_proyek['idproyek'].'">'.$data_proyek['nama_proyek'].'</option>';
                             }
                           ?>
                       </select>
		Jenis Pengeluaran : 
    <select class="form-control" name="jenis">
      <option value="Online" >Online</option>
		 <option value="Offline" >Offline</option>
		 <option value="Operasional" >Operasional</option>
    </select>
    Jenis Iklan : 
    <select class="form-control" name="jns_iklan">
      <option value="single" >single</option>
		 <option value="canva" >canva</option>
    </select> 
		Nama Pengeluaran : 
         <input type="text" class="form-control" name="nama_pengeluaran">
		Tanggal Pengeluaran : 
         <input type="date" class="form-control" name="tanggal">
		Jumlah Pengeluaran : 
         <input type="number" class="form-control" name="jumlah">
    Foto/Bon/Struk/Invoice :
         <input type="file" name="file"><br>
  
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


<!-- konten Print-->
  <div id="myModalPrint" class="modal fade" role="dialog">
    <div class="modal-dialog">

      <!-- konten modal-->
      <div class="modal-content">
        <!-- heading modal -->
        <div class="modal-header">
          <h4 class="modal-title">Cetak Pengeluaran</h4>
		    <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- body modal -->
		
    <div class="modal-body">
        <form action="cetak-pengeluaran.php" method="POST" target="_blank">
          <div class="form-group">Dari Tanggal: </div>
              <div class="form-group">
                  <input type="date" class="form-control" name="awal">
              </div>  
            
          <div class="form-group">Sampai Tanggal : </div>
              <div class="form-group">
                  <input type="date" class="form-control" name="akhir">
              </div>  
        
        
        <div class="form-group">Proyek : 
          <select name="proyek" id="proyek" class="form-control">
          <option value=""> - Pilih Proyek - </option>
                        <?php
                          $idproyek = mysqli_query($koneksi, "SELECT * FROM proyek where is_active='1' and nonzone='0' ");
                          while ($data_proyek = mysqli_fetch_array($idproyek)) {
                            echo '<option value="'.$data_proyek['idproyek'].'">'.$data_proyek['nama_proyek'].'</option>';
                          }
                        ?>
                    </select>
                    </div>
        <!-- footer modal -->
        <div class="modal-footer">
		<button type="submit" class="btn btn-primary" >Cetak</button>
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
