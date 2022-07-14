<?php
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Data-Analisa.xls");
	?>
	<h3>Data Analisa Proyek</h3>    
	<table border="1" cellpadding="5"> 
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
					  <th>Reach</th> 
					  <th>Impression</th> 
					  <th>Database</th>
					  <th>Non-Database</th> 
					  <th>Total Leads</th> 
					  <th>Total Closing</th> 
					  <th>Lead PerClosing</th> 
					  <th>Cost Perlead</th> 
					  <th>Cost PerClosing</th> 
					  <th>Total HPP</th> 
	</tr>  
	<?php  
	 $no=0;
	// Load file koneksi.php  
	include "koneksi.php";    
	// Buat query untuk menampilkan semua data siswa 
	$query = mysqli_query($koneksi,"SELECT proyek.idproyek ,proyek.target_penjualan_bulanan, proyek.nama_proyek, proyek.status, SUM(penjualan.booking_fee) AS booking_fee, SUM(penjualan.harga_net) AS harga_net, jumlahp, COUNT(penjualan.idpenjualan) AS jmlh, jumlah_online, jumlah_offline, jumlah_op, jumlahdb, jumlahnondb, reach, reachp, impression
	FROM proyek 
	LEFT JOIN penjualan ON proyek.idproyek=penjualan.idproyek 
	LEFT JOIN
	(SELECT proyek.idproyek, SUM(pengeluaran.jumlah) AS jumlahp, SUM(IF(jenis='operasional', jumlah, 0)) AS jumlah_op , SUM(IF(jenis='online', jumlah, 0)) AS jumlah_online, SUM(IF(jenis='offline', jumlah, 0)) AS jumlah_offline
	FROM proyek, pengeluaran
	WHERE proyek.idproyek=pengeluaran.idproyek
	GROUP BY pengeluaran.idproyek ASC) AS pengeluaran
	ON proyek.idproyek=pengeluaran.idproyek LEFT JOIN 
	(SELECT proyek.idproyek, SUM(fb_ads.db) AS jumlahdb, SUM(fb_ads.non_db_leads) AS jumlahnondb, fb_ads.reach AS reach, SUM(fb_ads.reach) AS reachp, SUM(fb_ads.impression) AS impression FROM proyek, fb_ads where proyek.idproyek=fb_ads.idproyek group by proyek.idproyek asc) AS fb_ads ON proyek.idproyek=fb_ads.idproyek where where is_active='1' AND nonzone='0'
    GROUP BY proyek.idproyek ASC"); 
    
	while($data = mysqli_fetch_assoc($query)){ 


$no++;
echo "<tr>";    
	echo "<th scope='row'>".$no."</th>";   
	echo "<td>".$data['nama_proyek']."</td>";   
	echo "<td>Rp ".number_format($data['target_penjualan_bulanan'])."</td>";    
	echo "<td>Rp ".number_format($budgetmidas)."</td>";    
	echo "<td>Rp ".number_format($pengeluaran)."</td>";      
	echo "<td>Rp ".number_format($pendapatan) ."</td>";      
	echo "<td>".round($ratio_midas, 2)."%</td>";      
	echo "<td>".$hasil ."</td>";      
	echo "<td>Rp ".number_format($operasional)."</td>";         
	echo "<td>".round($ratio_midas)."%</td>";
	echo "<td>".$data['reachp']."</td>";      
	echo "<td>".$data['impression']."</td>";      
	echo "<td>".$data['jumlahdb']."</td>";      
	echo "<td>".$data['jumlahnondb']."</td>";      
	echo "<td>".number_format($total_leads)."</td>";
	echo "<td>".$data['jmlh']."</td>";      
	echo "<td>".number_format($leadpc) ."</td>";      
	echo "<td>Rp ".number_format($cpl1) ."</td>";      
	echo "<td>Rp ".number_format($cpc) ."</td>";      
	echo "<td>Rp ".number_format($pendapatan) ."</td>";      
	echo "</tr>";  
	      
	}  ?>
  
</table>