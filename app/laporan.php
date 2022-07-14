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
        <a href="export-detail.php" type="button" style="margin:5px "class="btn btn-success btn-md"><i class="fa fa-download"> Excel</i></a>
        <button type="button" class="btn btn-primary btn-md" style= "margin-right:1250px"data-toggle="modal" data-target="#myModalPrint"><i class="fa fa-print"> Cetak Analisa </i></button><br>
        
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
                      <th>Online Budget</th>
                      <th>Offline Budget</th>       
                      <th>Reach</th>
                      <th>Impression</th>
                      <th>Database</th>
                      <th>Non Database</th>
                      <th>Total Leads</th>
                      <th>Total Closing</th>
                      <th>Lead-PerClosing</th>
                      <th>CostPerLead</th>
                      <th>CostPerClosing</th>
                      <th>Total HPP</th>
                      
                    </tr>
                  </thead>
                  <tbody>
				  <?php
          $no=1;
$query = mysqli_query($koneksi,"SELECT proyek.idproyek ,proyek.target_penjualan_bulanan, proyek.nama_proyek, proyek.status, SUM(penjualan.booking_fee) AS booking_fee, SUM(penjualan.harga_net) AS harga_net, jumlahdb, jumlahnondb, reach, reachp, impression, COUNT(penjualan.idpenjualan) AS jmlh
FROM proyek 
LEFT JOIN penjualan ON proyek.idproyek=penjualan.idproyek 
LEFT JOIN
(SELECT proyek.idproyek, SUM(fb_ads.db) AS jumlahdb, SUM(fb_ads.non_db_leads) AS jumlahnondb, fb_ads.reach AS reach, SUM(fb_ads.reach) AS reachp, SUM(fb_ads.impression) AS impression
FROM proyek, fb_ads
WHERE proyek.idproyek=fb_ads.idproyek
GROUP BY fb_ads.idproyek ASC) AS fb_ads
ON proyek.idproyek=fb_ads.idproyek where is_active='1' AND nonzone='0'
GROUP BY proyek.idproyek ASC"); 

$no = 1;
while ($data = mysqli_fetch_assoc($query)) 
{
  $budgetmidas = $data['target_penjualan_bulanan'] * 0.01;
  $budgetonline = $budgetmidas * 0.9 ;
  $budgetoffline = $budgetmidas * 0.1 ;
  $total_budget= $budgetonline + $budgetoffline;
  $total_leads = $data['jumlahdb'] + $data['jumlahnondb'];
  $total_hpp = $data['booking_fee'] + $data['harga_net'];
  $total_closing = $data['jmlh'];
  $pendapatan = ($data['booking_fee'] + $data['harga_net']) * 0.8;
//leadperclosing
  if ($total_closing== 0) {
    $leadpc = 0;
  } else {
    $leadpc = $total_leads/$total_closing   ;
  }
//costperlead
$cpl=($total_leads!=0)?($budgetonline/$total_leads):0;
$cpc=($total_closing!=0)?($total_budget/$total_closing):0;
  
 

?>
                      <tr>
                      <th scope="row"><?= $no;?></th>
                      <td><?=$data['nama_proyek']?></td>
                      <td>Rp.<?=number_format($budgetonline);?></td>
                      <td>Rp.<?=number_format($budgetoffline);?></td>
                      <td><?=number_format($data['reachp']);?></td>
                      <td><?=number_format($data['impression']);?></td>
                      <td><?=number_format($data['jumlahdb']);?></td>
                      <td><?=number_format($data['jumlahnondb']);?></td>
                      <td><?=number_format($total_leads);?></td>
                      <td><?=number_format($data['jmlh']);?></td>
                      <td><?=number_format($leadpc);?></td>
                      <td>Rp.<?=number_format($cpl);?></td>
                      <td>Rp.<?=number_format($cpc);?></td>
                      <td>Rp.<?=number_format($pendapatan);?></td>
                      

                     
</tr>

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
