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


    $id = $_GET['id_pengeluaran'];
    $d =mysqli_query($koneksi, "SELECT * FROM pengeluaran LEFT JOIN proyek on pengeluaran.idproyek = proyek.idproyek WHERE id_pengeluaran='$id'");
  
    
    foreach($d as $d){
       
            
    ?>
    <html>
    <head>

    </head>
    <body>
    
    <form role="form" action="" method="POST" enctype="multipart/form-data">
    <table border="0" cellpadding="4">

    <tr>
    <td>Foto/Bon Struk </td>
    </tr>
    <tr>
            <td><embed src="../assets/images/uploader/<?= $d['foto'];?>" alt=""  width="460" height="300" ></td>
        
        </tr>
        </table>
        <table border="0" cellpadding="4">
        <tr>
            <td>Nama Proyek</td>
            <td>: <?php echo $d['nama_proyek']?>
        </tr>
        <tr>
            <td>Jenis Pengeluaran </td>
            <td>: <?php echo $d['jenis']?></td>
        </tr>
        <tr>
            <td>Jenis Iklan </td>
            <td>: <?php echo $d['jns_iklan']?></td>
        </tr>
        <tr>
            <td>Nama Pengeluaran </td>
            <td>: <?php echo $d['nama_pengeluaran']?></td>
        </tr>
        <tr>
            <td>Tanggal Pengeluaran</td>
            <td>: <?= date('d F Y', strtotime($d['tanggal']))?></td>
        </tr>
        <tr>
            <td>Jumlah Pengeluaran</td>
            <td>: Rp. <?=number_format($d['jumlah'])?></td>
        </tr>
        
    </div>
        </table>
        <div class = "modal-footer">
            <a href="pengeluaran.php" class="btn btn-success"> Kembali</a>
        </div>
        </form>
    </body>
    </html>
    <?php
          
    }
    
    ?>
