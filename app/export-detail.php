<?php
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Data_Detail.xls");
	?>
	<h3>Data Detail Proyek</h3>    
	<table border="1" cellpadding="5"> 
	<tr>    
				      <th>No</th>
					  <th>Nama Proyek</th>
                      <th>Online Budget</th>
                      <th>Offline Budget</th>       
                      <th>Reach</th>
                      <th>impression</th>
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

	// Load file koneksi.php  
	include "koneksi.php";    
	// Buat query untuk menampilkan semua data siswa 
	$no=0;
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
	
	// Untuk penomoran tabel, di awal set dengan 1 
	while($data = mysqli_fetch_array($query)){ 
    // Ambil semua data dari hasil eksekusi $sql 
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
$no++;
  

//mysql_close($host);

	 

	//mysql_close($host);
	
	echo "<tr>";    
	echo "<th scope='row'>".$no."</th>";   
	echo "<td>".$data['nama_proyek']."</td>";   
	echo "<td>Rp".number_format($budgetonline)."</td>";    
	echo "<td>Rp".number_format($budgetoffline)."</td>";    
	echo "<td>".number_format($data['reachp'])."</td>";   
	echo "<td>".number_format($data['impression'])."</td>";   
	echo "<td>".number_format($data['jumlahdb'])."</td>";   
	echo "<td>".number_format($data['jumlahnondb'])."</td>";  
	echo "<td>".number_format($total_leads)."</td>";      
	echo "<td>".number_format($data['jmlh'])."</td>";  
	echo "<td>".number_format($leadpc)."</td>";      
	echo "<td>Rp".number_format($cpl)."</td>";      
	echo "<td>Rp".number_format($cpc)."</td>";      
	echo "<td>Rp".number_format($total_hpp)."</td>";         
	echo "</tr>";        
	}  ?>
 
</table>
