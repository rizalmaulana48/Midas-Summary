<?php
require_once __DIR__ . '../vendor/autoload.php';
include "koneksi.php";

$from=$_POST['awal'];
$end=$_POST['akhir'];
$proyek=$_POST['proyek'];

$mpdf = new \Mpdf\Mpdf();
$mpdf->AddPage("P","","","","","15","15","15","15","","","","","","","","","","","","A4");
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
                        <td style="padding-left: 200px;text-align: center;"><h2 style="text-transform: capitalize;">Laporan Pengeluaran <br></h2></td>
                    </tr>
                </table>
            <hr />
            <table border="1" cellpadding="10" cellspacing="0">
                <tr>
                <th scope="col">No</th>
                <th scope="col">Nama Proyek</th>
                <th scope="col">Jenis Pengeluaran</th>
                <th scope="col">Jenis Iklan</th>
                <th scope="col">Nama Pengeluaran</th>
                <th scope="col">Tanggal Pengeluaran</th>
                <th scope="col">Jumlah Pengeluaran</th>
                </tr>';
                $i=1;
                if($proyek != 0 AND $from != 0 AND $end !=0){
                    $rekap = mysqli_query($koneksi, "SELECT * FROM pengeluaran where tanggal BETWEEN '$from' AND '$end' AND idproyek='$proyek'");
                    $a = mysqli_query($koneksi, "SELECT * FROM proyek where idproyek='$proyek' ");
                    foreach ($rekap as $dt){
                      foreach($a as $d)
                     
                      $html.= '<tr> 
                    <td>'. $i++ .'</td>
                    <td>'. $d["nama_proyek"] .'</td>
                    <td>'. $dt["jenis"] .'</td>
                    <td>'. $dt["jns_iklan"] .'</td>
                    <td>'. $dt["nama_pengeluaran"] .'</td>
                    <td>'. date('d F Y', strtotime($dt["tanggal"])) .'</td>
                    <td>Rp. '. number_format($dt["jumlah"]) .'</td>
                </tr>';

                 }
                }else if($proyek != 0){
                    $rekap = mysqli_query($koneksi, "SELECT * FROM pengeluaran where idproyek='$proyek'");
                    $a = mysqli_query($koneksi, "SELECT * FROM proyek where idproyek='$proyek' ");
                    foreach ($rekap as $dt){
                        foreach ($a as $d)
                        $html.= '<tr>
                        <td>'. $i++ .'</td>
                        <td>'. $d["nama_proyek"] .'</td>
                        <td>'. $dt["jenis"] .'</td>
                        <td>'. $dt["jns_iklan"] .'</td>
                        <td>'. $dt["nama_pengeluaran"] .'</td>
                        <td>'. date('d F Y', strtotime($dt["tanggal"])) .'</td>
                        <td>Rp. '. number_format($dt["jumlah"]) .'</td>
                    </tr>';
                        

                 }
                }else{
                    $rekap = mysqli_query($koneksi, "SELECT * FROM pengeluaran LEFT JOIN proyek ON pengeluaran.idproyek = proyek.idproyek");
                    foreach ($rekap as $dt){

                        $html.= '<tr>
                    <td>'. $i++ .'</td>
                    <td>'. $dt["nama_proyek"] .'</td>
                    <td>'. $dt["jenis"] .'</td>
                    <td>'. $dt["jns_iklan"] .'</td>
                    <td>'. $dt["nama_pengeluaran"] .'</td>
                    <td>'. date('d F Y', strtotime($dt["tanggal"])) .'</td>
                    <td>Rp. '. number_format($dt["jumlah"]) .'</td>
                </tr>';

                    }
                }

$html .=            '</table>
            
         </body>
         </html>';

$mpdf->WriteHTML($html);
$mpdf->Output('Laporan Pengeluaran.pdf', \Mpdf\Output\Destination::INLINE);
?>