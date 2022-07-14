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

      <title>BOSPRO Midas</title>

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

            <!--tempatbutton-->
            <div class="d-sm-flex align-items-center justify-content-between ">
            <button type="button" class="btn btn-success" style="margin:5px" data-toggle="modal" data-target="#myModalTambah"><i class="fa fa-plus">Penjualan </i></button><br>
            <button type="button" class="btn btn-primary btn-md" style= "margin-right:1130px"data-toggle="modal" data-target="#myModalPrintF"><i class="fa fa-print"> Penjualan </i></button><br>
             
             </div>
              <!-- DataTales Example -->
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Daftar Penjualan</h6>
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
                          <th>Nama Konsumen</th>
                          <th>Tanggal Transaksi</th>         
                          <th>Nama Marketing</th>                
                          <th>Harga Net</th>
                          <th>Booking Fee</th>
                          <th>Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
              <?php 
    $query = mysqli_query($koneksi,"SELECT * FROM penjualan LEFT JOIN proyek ON penjualan.idproyek = proyek.idproyek 
                                                         LEFT JOIN pegawai ON penjualan.idpegawai= pegawai.idpegawai 
                                                        ORDER BY  idpenjualan DESC");
                                                       
    $no = 1;      

    if(isset($_GET["tampil"])){
      $dt1 = $_GET["awal"];
      $dt2 = $_GET["akhir"];
      $sql = "SELECT * FROM penjualan INNER JOIN proyek ON penjualan.idproyek = proyek.idproyek WHERE tgl_transaksi BETWEEN '$dt1' AND '$dt2'";
          $query = mysqli_query($koneksi,$sql) or die (mysqli_error($koneksi));
    }

    while ($data = mysqli_fetch_assoc($query)) 
    {
        $a= $data['harga_net'];
        $b= $data['booking_fee'];
        $c= ($a + $b )* 0.8;
        
    ?>
                          <tr>
                          <th scope="row"><?= $no;?></th>
                          <td><?=$data['nama_proyek']?></td>
                          <td><?=$data['nama_konsumen']?></td>
                          <td><?=date('d F Y', strtotime($data['tgl_transaksi']))?></td>
                          <td><?=$data['nama_lengkap']?></td>
                                  
                          <td>Rp. <?=number_format($data['harga_net'],2,',','.');?></td>
                          <td>Rp. <?=number_format($data['booking_fee'],2,',','.');?></td>
                          
                <td>
                        <!-- Button untuk modal -->
    <a href="#" type="button" class=" fa fa-edit btn btn-primary btn-md" data-toggle="modal" data-target="#myModal<?php echo $data['idpenjualan']; ?>"></a>
    
    </td>
    </tr><?php 
$no++;
//mysql_close($host);
?>  
    <!-- Modal Edit Mahasiswa-->
    <div class="modal fade" id="myModal<?php echo $data['idpenjualan']; ?>" role="dialog">
    <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
    <div class="modal-header">  
    <h4 class="modal-title">Ubah Data Penjualan </h4>
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div>
    <div class="modal-body">
    <form role="form" action="proses-edit-transaksi.php" method="POST" enctype="multipart/form-data">

    <?php
    $id = $data['idpenjualan']; 
    $query_edit = mysqli_query($koneksi,"SELECT * FROM penjualan WHERE idpenjualan ='$id'");
    //$result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_array($query_edit)) {  
    ?>


    <input type="hidden" name="idpenjualan" value="<?php echo $row['idpenjualan']; ?>">

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
    <label>Nama Konsumen</label>
    <input type="text" name="nama_konsumen" class="form-control" value="<?php echo $row['nama_konsumen']; ?>">      
    </div>

    <label for="idpegawai">Nama Marketing</label>
                       <select name="idpegawai" id="idpegawai" class="form-control" required>
                           <option value=""> - Pilih Marketing - </option>
                           <?php
                             $idproyek = mysqli_query($koneksi, "SELECT * FROM pegawai");
                             while ($data_proyek = mysqli_fetch_array($idproyek)) {
                               echo '<option value="'.$data_proyek['idpegawai'].'">'.$data_proyek['nama_lengkap'].'</option>';
                             }
                           ?>
                       </select>

    <div class="form-group">
    <label>Tanggal Transaksi</label>
    <input type="date" name="tgl_transaksi" class="form-control" value="<?php echo $row['tgl_transaksi']; ?>">   
    </div>

    <div class="form-group">
    <label>Harga Net</label>
    <input type="number" name="harga_net" class="form-control" value="<?php echo $row['harga_net']; ?>">      
    </div>

    <label>Booking Fee</label>
    <input type="number" name="booking_fee" class="form-control" value="<?php echo $row['booking_fee']; ?>">      
    </div>

    <div class="modal-footer">  
    <button type="submit" class="btn btn-success">Ubah</button>
    
    <a href="hapus-transaksi.php?idpenjualan=<?=$row['idpenjualan'];?>" onclick="return confirm('Anda Yakin Ingin Menghapus?')" class="btn btn-danger">Hapus</a>
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
              <h4 class="modal-title">Tambah Data Penjualan</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- body modal -->
        <form action="tambah-transaksi.php" method="POST" enctype="multipart/form-data">
        <div class="modal-body">
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
       
        Nama Konsumen : 
      <input type="text" class="form-control" name="nama_konsumen">

    <label for="idpegawai">Nama Marketing</label>
                       <select name="idpegawai" id="idpegawai" class="form-control" required>
                           <option value=""> - Pilih Marketing - </option>
                           <?php
                             $idpegawai = mysqli_query($koneksi, "SELECT * FROM pegawai");
                             while ($data_pegawai = mysqli_fetch_array($idpegawai)) {
                               echo '<option value="'.$data_pegawai['idpegawai'].'">'.$data_pegawai['nama_lengkap'].'</option>';
                             }
                           ?>
                       </select>

        Tanggal Transaksi : 
         <input type="date" class="form-control" name="tgl_transaksi">
        Harga Net : 
            <input type="harga_net" class="form-control" name="harga_net">
        Booking fee : 
            <input type="booking_fee" class="form-control" name="booking_fee">
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
<div id="myModalPrintF" class="modal fade" role="dialog">
    <div class="modal-dialog">

      <!-- konten modal-->
      <div class="modal-content">
        <!-- heading modal -->
        <div class="modal-header">
          <h4 class="modal-title">Cetak Penjualan</h4>
		    <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- body modal -->
        <div class="modal-body">
        <form action="cetak-penjualan.php" method="POST" target="_blank">
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
		<button type="submit" name="cetak-penjualan.php?idpenjualan<?=$data['idpenjualan']?>" class="btn btn-primary" >Cetak</button>
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
