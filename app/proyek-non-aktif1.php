<?php
require 'cek-sesi1.php';
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
       <a href="analisa1.php"type="button" style="margin:5px 5px 5px 0px "class="btn btn-success btn-md">Aktif </i></a>
        
        </div>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Analisa Proyek</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Nama Proyek</th>
                      <th>Target Penjualan Bulanan</th>
                      <th>Estimasi Budget Midas</th>       
                      <th>Total Pengeluaran</th>
                      <th>Total Penjualan</th>
                      <th>Ratio Aktual Midas</th>
                      <th>Status Ratio</th>
                      <th>Operasional</th>
                      <th>Ratio Proyek</th>
                      <th>Aksi</th>
                      
                    </tr>
                  </thead>
                  <tbody>
				  <?php
          $no=1;
$query = mysqli_query($koneksi,"SELECT proyek.idproyek ,proyek.target_penjualan_bulanan, proyek.nama_proyek, proyek.status, SUM(penjualan.booking_fee) AS booking_fee, SUM(penjualan.harga_net) AS harga_net, jumlahp, jumlah_online, jumlah_offline, jumlah_op
FROM proyek 
LEFT JOIN penjualan ON proyek.idproyek=penjualan.idproyek 
LEFT JOIN
(SELECT proyek.idproyek, SUM(pengeluaran.jumlah) AS jumlahp, SUM(IF(jenis='operasional', jumlah, 0)) AS jumlah_op , SUM(IF(jenis='online', jumlah, 0)) AS jumlah_online, SUM(IF(jenis='offline', jumlah, 0)) AS jumlah_offline
FROM proyek, pengeluaran
WHERE proyek.idproyek=pengeluaran.idproyek
GROUP BY pengeluaran.idproyek ASC) AS pengeluaran
ON proyek.idproyek=pengeluaran.idproyek where is_active='0' AND nonzone='0'
GROUP BY proyek.idproyek ASC"); 

$no = 1;
while ($data = mysqli_fetch_assoc($query)) 
{
  //note
  $budgetmidas = $data['target_penjualan_bulanan'] * 0.01;
  $pengeluaran = $data['jumlahp'] ;
  $top=$data['jumlahp'] + $data['jumlah_op'];
  $jumlah_online = $data['jumlah_online'];
  $jumlah_offline = $data['jumlah_offline'];
  $operasional = $data['jumlah_op'];
  $pendapatan = ($data['booking_fee'] + $data['harga_net']) * 0.8;
  $budgetonline = $budgetmidas * 0.9 ;
  $budgetoffline = $budgetmidas * 0.1 ;
  $data['budgetmidas'] =  $budgetmidas;
  $data['budgetonline'] =  $budgetonline;
  $data['budgetoffline'] =  $budgetoffline;
  
  //ratio
  $ratio_online=round($budgetonline!=0)?($budgetonline/$budgetmidas) *100:0;
  
  $ratio_offline=round($budgetoffline!=0)?($budgetoffline/$budgetmidas)*100:0;

//ratiomidas
  if ($pendapatan== 0) {
    $ratio_midas = 0;
  } else {
    $ratio_midas = ($pengeluaran/$pendapatan)*100   ;
  }
 
//ratio proyek
//ratiomidas
if ($pendapatan== 0) {
  $ratio_proyek = 0;
} else {
  $ratio_proyek = ($top/$pendapatan)*100   ;
}


//status-ratiomidas
$nilai =round($ratio_midas, 2);

if($nilai < 0.75)
{
   $hasil = "<font color='#00ff00'><b>Safe</b></font>";
}
elseif(($nilai > 0.74) AND ($nilai < 1 ))
{
	$hasil = "<font color='#ffff00' ><b>Warning</b></font>";
}
elseif($nilai > 1)
{
	$hasil = "<font color='red'><b>Over</b></font>";
}
else
{
	$hasil ="-";
}
  
//status-ratioproyek
$nilai1 =round($ratio_proyek, 2);

if($nilai1 < 0.75)
{
   $hasil1 = "<font color='#00ff00'><b>Aman</b></font>";
}
elseif(($nilai1 > 0.74) AND ($nilai1 < 1 ))
{
	$hasil1 = "<font color='#ffff00' ><b>Warning</b></font>";
}
elseif($nilai1 > 1)
{
	$hasil1 = "<font color='red'><b>Over</b></font>";
}
else
{
	$hasil1 ="-";
}
  
 

?>
                      <tr>
                      <th scope="row"><?= $no;?></th>
                      <td><?=$data['nama_proyek']?></td>
                      <td>Rp.<?=number_format($data['target_penjualan_bulanan']);?></td>
                      <td>Rp.<?=number_format($budgetmidas);?></td>
                      
                      <td>Rp.<?=number_format($pengeluaran);?></td>
                      <td>Rp.<?=number_format($pendapatan);?></td>
                      <td><?=round($ratio_midas, 2)?>%</td>
                      <td><?=($hasil)?></td>
                      
                      <td>Rp.<?=number_format($operasional);?></td>
                      <td><?=round($ratio_proyek, 2)?>%</td>
                      <td> <a href="detail-proyek1.php?idproyek=<?=$data['idproyek']; ?>"type="button" style="margin:5px "class="btn btn-primary btn-md">Detail </i></a></td>
                     

<?php 
$no++;
//mysql_close($host);
?>  
       
</form>
</div>
</div>

</div>
</div>



 <!-- Modal -->
  


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
