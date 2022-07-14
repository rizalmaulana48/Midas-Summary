<?php
require_once __DIR__ . '../vendor/autoload.php';
include "koneksi.php";

$id=$_GET['idproyek'];
$query = mysqli_query($koneksi, "SELECT * FROM proyek where idproyek= '$id'");
$rekap    =mysqli_fetch_array($query);
$mpdf = new \Mpdf\Mpdf();
$html = '<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Document</title>
                
        </head>
        <body style=" font-family: Times, serif;">
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
                <th scope="col">Nama Pengeluaran</th>
                <th scope="col">Tanggal Pengeluaran</th>
                <th scope="col">Jumlah Pengeluaran</th>
                </tr>';
            $i=1;
            foreach ($rekap as $data){
                $html.= '<tr>
                    <td>'. $i++ .'</td>
                    <td>'. $data["nama_proyek"] .'</td>
                    <td>'. $data["jenis"] .'</td>
                    <td>'. $data["nama_pengeluaran"] .'</td>
                    <td>'. date('d F Y', strtotime($data["tanggal"])) .'</td>
                    <td>Rp. '. number_format($data["jumlah"]) .'</td>
                </tr>';
            }

$html .=            '</table>
            
         </body>
         </html>';

$mpdf->WriteHTML($html);
$mpdf->Output('daftar-rekapan.pdf', \Mpdf\Output\Destination::INLINE);
?>