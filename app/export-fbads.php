<?php
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Data_FbAds.xls");
	?>
	<h3>Data Fb Ads</h3>    
	<table border="1" cellpadding="5"> 
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
	<?php  
	 $no=0;
	// Load file koneksi.php  
	include "koneksi.php";    
	// Buat query untuk menampilkan semua data siswa 
	$query = mysqli_query($koneksi,"SELECT * FROM fb_ads INNER JOIN proyek ON fb_ads.idproyek = proyek.idproyek where is_active='1'AND nonzone='0' ORDER BY id_fbads DESC");
	
	// Untuk penomoran tabel, di awal set dengan 1 
	while($data = mysqli_fetch_array($query)){ 
   
$no++;
//mysql_close($host);

	 

	//mysql_close($host);
	
    echo "<tr>"; 
    echo "<th scope='row'>".$no."</th>";     
	echo "<td>".$data['nama_proyek']."</td>";   
	echo "<td>".$data['nama_campaign']."</td>";   
	echo "<td>".$data['jenis_iklan']."</td>";   
	echo "<td>".date('d F Y', strtotime($data['tgl_input']))."</td>";    
	echo "<td>".date('d F Y', strtotime($data['tgl_mulai']))."</td>";      
	echo "<td>".date('d F Y', strtotime($data['tgl_akhir']))."</td>";       
	echo "<td>".$data['reach']."</td>";   
	echo "<td>".$data['impression']."</td>";         
	echo "<td>".$data['db']."</td>";         
	echo "<td>".$data['non_db_leads']."</td>";     
    echo "</tr>";
    
    
    
	}  ?>
  
</table>
