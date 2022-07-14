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
<?php require 'sidebar1.php'; ?>
      <!-- Main Content -->
      <div id="content">

<?php require 'navbar.php'; ?>

        <!-- Begin Page Content -->
        <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between ">
        <button type="button" class="btn btn-success" style="margin:5px 0px 5px 0px" data-toggle="modal" data-target="#myModalTambah"><i class="fa fa-plus"> Fb Ads </i></button><br>
        
        
      
          </div>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Daftar Fb Ads</h6>
                  
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
                      <th>Nama Campaign</th>
                      <th>Jenis Iklan</th>
                      <th>Tanggal Input</th>
                      <th>Tanggal Mulai</th>
                      <th>Tanggal Akhir</th>
                      <th>Reach</th>
                      <th>Impression</th>
                      <th>Database</th>
                      <th>Non-Database leads</th>
                      
                    </tr>
                  </thead>
                  <tbody>
				  <?php 
$query = mysqli_query($koneksi,"SELECT * FROM fb_ads INNER JOIN proyek ON fb_ads.idproyek = proyek.idproyek where is_active='1'AND nonzone='0' ORDER BY id_fbads DESC");
$no = 1;

if(isset($_GET["tampil"])){
  $dt1 = $_GET["awal"];
  $dt2 = $_GET["akhir"];
  $sql = "SELECT * FROM fb_ads INNER JOIN proyek ON fb_ads.idproyek = proyek.idproyek WHERE tgl_input BETWEEN '$dt1' AND '$dt2'";
			$query = mysqli_query($koneksi,$sql) or die (mysqli_error($koneksi));
}

while ($data = mysqli_fetch_assoc($query)) 
{
?>
                    <tr>
                    <td scope="row"><?= $no;?></td>
                      <td><?=$data['nama_proyek']?></td>
                      <td><?=$data['nama_campaign']?></td>
                      <td><?=$data['jenis_iklan']?></td>
                      <td><?=date('d F Y', strtotime($data['tgl_input']))?></td>
                      <td><?=date('d F Y', strtotime($data['tgl_mulai']))?></td>
                      <td><?=date('d F Y', strtotime($data['tgl_akhir']))?></td>
                      <td><?=$data['reach']?></td>
                      <td><?=$data['impression']?></td>
                      <td><?=$data['db']?></td>
                      <td><?=$data['non_db_leads']?></td>
                      
	
</tr>
<?php 
$no++;
//mysql_close($host);
?> 

<!-- Modal Edit Mahasiswa-->
<div class="modal fade" id="myModal<?php echo $data['id_fbads']; ?>" role="dialog">
    <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
    <div class="modal-header">  
    <h4 class="modal-title">Ubah Data </h4>
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div>
    <div class="modal-body">
    <form role="form" action="proses-edit-fbads.php" method="POST" enctype="multipart/form-data">

    <?php
    $id = $data['id_fbads']; 
    $query_edit = mysqli_query($koneksi,"SELECT * FROM fb_ads WHERE id_fbads ='$id'");
    //$result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_array($query_edit)) {  
    ?>


    <input type="hidden" name="id_fbads" value="<?php echo $row['id_fbads']; ?>">

    <div class="form-group">
    <label for="idproyek">Nama Proyek</label>
                       <select name="idproyek" id="idproyek" class="form-control" required>
                           <option value=""> - Pilih proyek - </option>
                           <?php
                             $idproyek = mysqli_query($koneksi, "SELECT * FROM proyek where is_active='1'AND nonzone='0'");
                             while ($data_proyek = mysqli_fetch_array($idproyek)) {
                               echo '<option value="'.$data_proyek['idproyek'].'">'.$data_proyek['nama_proyek'].'</option>';
                             }
                           ?>
                       </select>
    </div>

    <div class="form-group">
<label >Jenis Iklan </label>
<?php $jp = $data['jenis_iklan']; ?>
<select name="jenis_iklan" class="form-control">
<option <?php echo ($jp == 'single') ? "selected": "" ?>>Single</option>
<option <?php echo ($jp == 'canva') ? "selected": "" ?>>Canva</option>
</select>
</div>


    <div class="form-group">
    <label>Nama Campaign</label>
    <input type="text" name="nama_campaign" class="form-control" value="<?php echo $row['nama_campaign']; ?>">      
    </div>

    <div class="form-group">
    <label>Tanggal Mulai</label>
    <input type="date" name="tgl_mulai" class="form-control" value="<?php echo $row['tgl_mulai']; ?>">   
    </div>

    <div class="form-group">
    <label>Tanggal Akhir</label>
    <input type="date" name="tgl_akhir" class="form-control" value="<?php echo $row['tgl_akhir']; ?>">   
    </div>

    <div class="form-group">
    <label>Reach</label>
    <input type="text" name="reach" class="form-control" value="<?php echo $row['reach']; ?>">      
    </div>

    <div class="form-group">
    <label>Impression</label>
    <input type="text" name="impression" class="form-control" value="<?php echo $row['impression']; ?>">      
    </div>

    <div class="form-group">                        
    <label>Database</label>
    <input type="number" name="db" class="form-control" value="<?php echo $row['db']; ?>">      
    </div>

     <div class="form-group">                         
    <label>Non-Database</label>
    <input type="number" name="non_db_leads" class="form-control" value="<?php echo $row['non_db_leads']; ?>">      
    </div>

    <div class="modal-footer">  
    <button type="submit" class="btn btn-success">Ubah</button>
    
    <a href="hapus-fbads.php?id_fbads=<?=$row['id_fbads'];?>" onclick="return confirm('Anda Yakin Ingin Menghapus?')" class="btn btn-danger">Hapus</a>
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
          <h4 class="modal-title">Tambah Data</h4>
		    <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- body modal -->
		<form action="tambah-fbads.php" method="POST" enctype="multipart/form-data">
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
		Nama Campaign : 
         <input type="text" class="form-control" name="nama_campaign">
    Jenis Iklan : 
    <select class="form-control" name="jenis_iklan">
      <option value="single" >Single</option>
		 <option value="canva" >Canva</option>
    </select>
		Tanggal Mulai: 
         <input type="date" class="form-control" name="tgl_mulai">
		Tanggal Akhir: 
         <input type="date" class="form-control" name="tgl_akhir">
         Reach : 
         <input type="text" class="form-control" name="reach">
         Impression : 
         <input type="text" class="form-control" name="impression">

		Database : 
         <input type="number" class="form-control" name="db">
		Non-Database Leads: 
         <input type="number" class="form-control" name="non_db_leads">
   
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
//mysql_close($host);
?> 



       
</form>
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
          <h4 class="modal-title">Cetak Fb Ads</h4>
		    <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- body modal -->
        <div class="modal-body">
        <form action="cetak-fbads.php" method="POST" target="_blank">
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
        
        <div class="form-group"> 
          Jenis Iklan : 
        <select class="form-control" id="jenis_iklan" name="jenis_iklan">
        <option value=""> - Pilih Jenis Iklan - </option>
           <option value="single" >Single</option>
		       <option value="canva" >Canva</option>
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
