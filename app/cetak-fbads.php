<?php
require_once __DIR__ . '../vendor/autoload.php';
include "koneksi.php";

$from=$_POST['awal'];
$end=$_POST['akhir'];
$proyek=$_POST['proyek'];

$mpdf = new \Mpdf\Mpdf();
$mpdf->SetDefaultBodyCSS('background', "url('kopsurat1.png')");
$mpdf->SetDefaultBodyCSS('background-image-resize', 6);
$mpdf->SetFont('Arial','B','22');
$html = '<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Document</title>
                
        </head>
        <body style=" font-family: Times, serif; , font-size: 10px;">
        <img src="kopsurat2.png" style="padding-left:-80px;padding-top:-80px;padding-right:-80px;">
        <table>
                    <tr>
                        <td style="padding-left: 200px;text-align: center;"><h2 style="text-transform: capitalize;">Laporan Fb Ads <br></h2></td>
                    </tr>
                </table>
            <hr />
            <table border="1" cellpadding="10" cellspacing="0">
                <tr>
                <th scope="col">No</th>
                <th scope="col">Nama Proyek</th>
                <th scope="col">Nama Campaign</th>
                <th scope="col">Jenis Iklan</th>
                <th scope="col">Tanggal Input</th>
                <th scope="col">Tanggal Mulai</th>
                <th scope="col">Jumlah Akhir</th>
                <th scope="col">Reach</th>
                <th scope="col">Impression</th>
                <th scope="col">Database</th>
                <th scope="col">Non-Database Leads</th>
                </tr>';
                $i=1;
                if($proyek != 0 AND $from != 0 AND $end !=0){
                    $rekap = mysqli_query($koneksi, "SELECT * FROM fb_ads where tgl_input BETWEEN '$from' AND '$end' AND idproyek='$proyek'");
                    $a = mysqli_query($koneksi, "SELECT * FROM proyek where idproyek='$proyek' ");
                    foreach ($rekap as $dt){
                      foreach($a as $d)
                     
                      $html.= '<tr> 
                    <td>'. $i++ .'</td>
                    <td>'. $d["nama_proyek"] .'</td>
                    <td>'. $dt["nama_campaign"] .'</td>
                    <td>'. $dt["jenis_iklan"] .'</td>
                    <td>'. date('d F Y', strtotime($dt["tgl_input"])) .'</td>
                    <td>'. date('d F Y', strtotime($dt["tgl_mulai"])) .'</td>
                    <td>'. date('d F Y', strtotime($dt["tgl_akhir"])) .'</td>
                    <td>'. $dt["reach"] .'</td>
                    <td>'. $dt["impression"] .'</td>
                    <td>'. $dt["db"] .'</td>
                    <td>'. $dt["non_db_leads"] .'</td>
                </tr>';

                 }
                }else if($proyek != 0){
                    $rekap = mysqli_query($koneksi, "SELECT * FROM fb_ads where idproyek='$proyek'");
                    $a = mysqli_query($koneksi, "SELECT * FROM proyek where idproyek='$proyek' ");
                    foreach ($rekap as $dt){
                        foreach ($a as $d)

                        $html.= '<tr> 
                        <td>'. $i++ .'</td>
                        <td>'. $d["nama_proyek"] .'</td>
                        <td>'. $dt["nama_campaign"] .'</td>
                        <td>'. $dt["jenis_iklan"] .'</td>
                        <td>'. date('d F Y', strtotime($dt["tgl_input"])) .'</td>
                        <td>'. date('d F Y', strtotime($dt["tgl_mulai"])) .'</td>
                        <td>'. date('d F Y', strtotime($dt["tgl_akhir"])) .'</td>
                        <td>'. $dt["reach"] .'</td>
                        <td>'. $dt["impression"] .'</td>
                        <td>'. $dt["db"] .'</td>
                        <td>'. $dt["non_db_leads"] .'</td>
                    </tr>';
                        

                 }
                }else{
                    $rekap = mysqli_query($koneksi, "SELECT * FROM fb_ads LEFT JOIN proyek ON fb_ads.idproyek = proyek.idproyek");
                    foreach ($rekap as $dt){

                      $html.= '<tr> 
                    <td>'. $i++ .'</td>
                    <td>'. $dt["nama_proyek"] .'</td>
                    <td>'. $dt["nama_campaign"] .'</td>
                    <td>'. $dt["jenis_iklan"] .'</td>
                    <td>'. date('d F Y', strtotime($dt["tgl_input"])) .'</td>
                    <td>'. date('d F Y', strtotime($dt["tgl_mulai"])) .'</td>
                    <td>'. date('d F Y', strtotime($dt["tgl_akhir"])) .'</td>
                    <td>'. $dt["reach"] .'</td>
                    <td>'. $dt["impression"] .'</td>
                    <td>'. $dt["db"] .'</td>
                    <td>'. $dt["non_db_leads"] .'</td>
                </tr>';

                    }
                }

$html .=            '</table>
            
         </body>
         </html>';

$mpdf->WriteHTML($html);
$mpdf->Output('Laporan Fb Ads.pdf', \Mpdf\Output\Destination::INLINE);
?>