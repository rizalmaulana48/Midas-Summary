<?php
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Data_Analisa.xls");
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
	$query = mysqli_query($koneksi,"SELECT proyek.idproyek ,proyek.target_penjualan_bulanan, proyek.nama_proyek, proyek.status, SUM(penjualan.booking_fee) AS booking_fee, COUNT(penjualan.idpenjualan) AS jmlh, SUM(penjualan.harga_net) AS harga_net, jumlahp, jumlah_online, jumlah_offline, jumlah_op, jumlahdb, jumlahnondb, reach, reachp, impression
	FROM proyek 
	LEFT JOIN penjualan ON proyek.idproyek=penjualan.idproyek 
	LEFT JOIN
	(SELECT proyek.idproyek, SUM(pengeluaran.jumlah) AS jumlahp, SUM(IF(jenis='operasional', jumlah, 0)) AS jumlah_op , SUM(IF(jenis='online', jumlah, 0)) AS jumlah_online, SUM(IF(jenis='offline', jumlah, 0)) AS jumlah_offline
	FROM proyek, pengeluaran
	WHERE proyek.idproyek=pengeluaran.idproyek
	GROUP BY pengeluaran.idproyek ASC) AS pengeluaran
	ON proyek.idproyek=pengeluaran.idproyek LEFT JOIN (SELECT proyek.idproyek, SUM(fb_ads.db) AS jumlahdb, SUM(fb_ads.non_db_leads) AS jumlahnondb, fb_ads.reach AS reach, SUM(fb_ads.reach) AS reachp, SUM(fb_ads.impression) AS impression FROM proyek, fb_ads where proyek.idproyek=fb_ads.idproyek group by proyek.idproyek asc) AS fb_ads
	ON proyek.idproyek=fb_ads.idproyek where is_active = '0' AND nonzone = '0'
	GROUP BY proyek.idproyek ASC"); 
	
	// Untuk penomoran tabel, di awal set dengan 1 
	while($data = mysqli_fetch_array($query)){ 
    // Ambil semua data dari hasil eksekusi $sql 
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
	$total_leads = $data['jumlahdb'] + $data['jumlahnondb'];
	$total_closing= $data['jmlh'];
	$total_budget= $budgetonline + $budgetoffline;
	//lpc
	if ($total_closing== 0) {
		$leadpc = 0;
	} else {
		$leadpc = $total_leads/$total_closing   ;
	}
	
	//costperlead
	$cpc=($total_closing!=0)?($total_budget/$total_closing):0;

	//ratio
	$ratio_online=round($budgetonline!=0)?($budgetonline/$budgetmidas) *100:0;
	
	$ratio_offline=round($budgetoffline!=0)?($budgetoffline/$budgetmidas)*100:0;
  //costperlead
  if ($total_leads== 0){
	  $costpl = 0;
  }else{
	  $costpl= ($budgetonline/$total_leads);
  }
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
	 $hasil = "<font color='#00ff00'><b>Aman</b></font>";
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
  
$no++;
//mysql_close($host);

	 

	//mysql_close($host);
	
	echo "<tr>";    
	echo "<th scope='row'>".$no."</th>";   
	echo "<td>".$data['nama_proyek']."</td>";   
	echo "<td>Rp".number_format($data['target_penjualan_bulanan'])."</td>";    
	echo "<td>Rp".number_format($budgetmidas)."</td>";    
	echo "<td>Rp".number_format($pengeluaran)."</td>";      
	echo "<td>Rp".number_format($pendapatan) ."</td>";      
	echo "<td>".round($ratio_midas, 2)."%</td>";      
	echo "<td>".$hasil ."</td>";      
	echo "<td>Rp".number_format($operasional)."</td>";         
	echo "<td>".round($ratio_midas)."%</td>";      
	echo "<td>".$data['reachp']."</td>";      
	echo "<td>".$data['impression']."</td>";      
	echo "<td>".$data['jumlahdb']."</td>";      
	echo "<td>".$data['jumlahnondb']."</td>";      
	echo "<td>".number_format($total_leads)."</td>";
	echo "<td>".$data['jmlh']."</td>";      
	echo "<td>".number_format($leadpc) ."</td>";      
	echo "<td>Rp ".round($costpl) ."</td>";      
	echo "<td>Rp ".round($cpc) ."</td>";      
	echo "<td>Rp ".round($pendapatan) ."</td>";      
	echo "</tr>";        	       
	}  ?>
  
</table>
