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


<div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between">
            <h1 class="h3 mb-3 ml-1 text-gray-800">Fb Ads</h1>
            <ol class="breadcrumb">
              
              <li class="breadcrumb-item active" aria-current="page">Form Isian</li>
            </ol>
          </div>

        <!-- Data table -->

          <!-- DataTales Example -->

            <!-- Forms -->
            <div class="card mb-4">
             <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h4 class="m-0 font-weight-bold text-primary">Form Fb Ads</h6>
                </div>
                <div class="card-body">
                  <form action="tambah-tamu2.php" method="get">
                      
                    <div class="form-group">
                    <input type="hidden" name="id_user" value="<?=$_SESSION['id']?>">   
                    </div>
                    
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
                    <label>Nama Campaign</label>
                    <input type="text" name="nama_campaign" class="form-control">      
                    </div>

                    <div class="form-group">
                    <label>Tanggal Input</label>
                    <input type="date" name="no_wa" class="form-control">      
                    </div>

                    <div class="form-group">
                    <label>Reach</label>
                    <input type="text" name="email" class="form-control">      
                    </div>

                    <div class="form-group">
                    <label>Impression</label>
                    <input type="text" name="instansi" class="form-control">      
                    </div>

                    <div class="form-group">
                    <label>Database</label>
                    <input type="number" name="alamat" class="form-control">      
                    </div>

                    <div class="form-group">
                    <label>Non-Database Leads</label>
                    <input type="number" name="alamat" class="form-control">      
                    </div>

                       
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                  </form>
                </div>
            </div> 

    
        <!-- Data table -->

        <!-- Modal Logout -->
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabelLogout">Logout</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <p>Are you sure you want to logout?</p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cancel</button>
                  <a href="keluarf.php" class="btn btn-primary">Logout</a>
                </div>
              </div>
            </div>
          </div>

        
        </div>
        <!---Container Fluid-->
      </div>







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
