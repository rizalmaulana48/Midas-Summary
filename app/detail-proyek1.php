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
<div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between ">
     </div>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h2 class="m-0 font-weight-bold text-primary">Detail Proyek</h2>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="">
<?php

if(isset($_GET['idproyek'])){
    $id=$_GET['idproyek'];
}
else {
    die ("Error. No ID Selected!");    
}

$surat =mysqli_query($koneksi, "SELECT * FROM proyek  WHERE idproyek='$id'");
$b = mysqli_query($koneksi, "SELECT SUM(penjualan.booking_fee) AS booking_fee, SUM(penjualan.harga_net) AS harga_net, COUNT(penjualan.idpenjualan) AS jmlh FROM penjualan where idproyek= '$id'");
$c = mysqli_query($koneksi, "SELECT SUM(fb_ads.db) AS jumlahdb, SUM(fb_ads.non_db_leads) AS jumlahnondb, fb_ads.reach AS reach, SUM(fb_ads.reach) AS reachp, SUM(fb_ads.impression) AS impression FROM fb_ads where idproyek = '$id'");
$d= mysqli_query($koneksi, "SELECT SUM(pengeluaran.jumlah) AS jumlahp, SUM(IF(jenis='operasional', jumlah, 0)) AS jumlah_op , SUM(IF(jenis='online', jumlah, 0)) AS jumlah_online, SUM(IF(jenis='offline', jumlah, 0)) AS jumlah_offline FROM pengeluaran where idproyek = '$id'");
foreach ($surat as $s){
    //formula
    $budgetmidas = $s['target_penjualan_bulanan'] * 0.01;
    $budgetonline = $budgetmidas * 0.9 ;
    $budgetoffline = $budgetmidas * 0.1 ;
    $total_budget= $budgetonline + $budgetoffline;


   

    foreach($b as $y){
        $total_hpp = ($y['booking_fee'] + $y['harga_net']) * 0.8;
        $total_closing= $y['jmlh'];
        $total_penjualan= ($y['booking_fee'] + $y['harga_net']) ;

         foreach($d as $f){
            $top=$f['jumlahp'] + $f['jumlah_op'];
            $jumlah_online = $f['jumlah_online'];
            $jumlah_offline = $f['jumlah_offline'];
            $operasional = $f['jumlah_op'];
            $pengeluaran= $f['jumlahp'] ;

                    foreach ($c as $g)
                    $total_leads = $g['jumlahdb'] + $g['jumlahnondb'];

                    //costperlead
                        $cpl=($total_leads!=0)?($budgetonline/$total_leads):0;
                        $cpc=($total_closing!=0)?($total_budget/$total_closing):0;
                        $cpl1= round($cpl);
                        $cpc1= round($cpc);
                    //leadperclosing
                        if ($total_closing== 0) {
                            $leadpc = 0;
                        } else {
                            $leadpc = $total_leads/$total_closing   ;
                        }
                        //ratiomidas
                        if ($total_hpp== 0) {
                            $ratio_midas = 0;
                          } else {
                            $ratio_midas = ($pengeluaran/$total_hpp)*100   ;
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
                            //ratio proyek
                            if ($total_hpp== 0) {
                                $ratio_proyek = 0;
                            } else {
                                $ratio_proyek = ($top/$total_hpp)*100   ;
                            }
  
?>
<html>
<head>

</head>
<body>
<h2> <?php echo $s['nama_proyek']?> </h2>

<table border="0" cellpadding="4">

    <tr>
        <td>Estimasi Budget Midas</td>
        <td >: Rp. <?=number_format($budgetmidas)?></td>
        
        <td>Target Penjualan Bulanan</td>
        <td >: Rp. <?=number_format($s['target_penjualan_bulanan'])?></td>  
    </tr>
    <tr>
        <td>Budget Online</td>
        <td>: <?=number_format($budgetonline)?></td>

        <td>Total Pengeluaran</td>
        <td >: Rp. <?=number_format($f['jumlahp'])?></td>
    </tr>
    <tr>
        <td>Budget Offline</td>
        <td>: <?=number_format($budgetoffline)?></td>

        <td>Total Penjualan</td>
        <td >: Rp. <?=number_format($total_penjualan)?></td>
    </tr>
    <tr>
        <td>Reach </td>
        <td>: <?php echo $g['reachp']?></td>

        <td>Ratio Aktual Midas</td>
        <td>: <?= round($ratio_midas, 2)?>%</td>
    </tr>
    <tr>
        <td>Impression </td>
        <td>: <?php echo $g['impression']?></td>

        <td>Status Ratio </td>
        <td>: <?php echo $hasil?></td>
    </tr>
    <tr>
        <td>Database</td>
        <td>: <?php echo $g['jumlahdb']?></td>

        <td>Operasional</td>
        <td>: Rp. <?php echo number_format($f['jumlah_op']);?></td>                    
    </tr>
    <tr>
        <td>Non-Database </td>
        <td>: <?php echo $g['jumlahnondb']?></td>

        <td>Ratio Proyek</td>
        <td>: <?= round($ratio_proyek, 2)?>%</td>
    </tr>
    <tr>
        <td>Total Leads </td>
        <td>: <?php echo $total_leads?></td>
    </tr>
    <tr>
        <td>Total Closing</td>
        <td>: <?php echo $y['jmlh']?></td>
    </tr>
    <tr>
        <td>Lead Perclosing</td>
        <td>: <?=round($leadpc)?></td>
    </tr>
    <tr>
        <td>Cost PerLead</td>
        <td>: Rp. <?=number_format($cpl1)?></td>
    </tr>
    <tr>
        <td>Cost Perclosing </td>
        <td>: Rp. <?=number_format($cpc)?></td>
    </tr>
    <tr>
        <td>Total HPP</td>
        <td>: Rp. <?=number_format($total_hpp)?></td>
    </tr>
</div>
    </table>
    <div class = "modal-footer">
        <a href="analisa.php" class="btn btn-success"> Kembali</a>
    </div>
</body>
</html>
<?php
    }
  }
}
?>
