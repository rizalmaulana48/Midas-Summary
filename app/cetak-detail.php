<?php

require_once __DIR__ . '../vendor/autoload.php';
include "koneksi.php";

$mpdf = new \Mpdf\Mpdf();
$html = '<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Document</title>
        </head>
        <body background-image : url ("surat.png") style=" font-family: Times, serif;">
            <header>
            
            </header>
            
            <br>';

            

            $id = $_GET['idproyek'];
            $surat = mysqli_query($koneksi, "SELECT * FROM proyek where idproyek= '$id'");
            $b = mysqli_query($koneksi, "SELECT SUM(penjualan.booking_fee) AS booking_fee, SUM(penjualan.harga_net) AS harga_net, COUNT(penjualan.idpenjualan) AS jmlh FROM penjualan where idproyek= '$id'");
            $c = mysqli_query($koneksi, "SELECT SUM(fb_ads.db) AS jumlahdb, SUM(fb_ads.non_db_leads) AS jumlahnondb, fb_ads.reach AS reach, SUM(fb_ads.reach) AS reachp, SUM(fb_ads.impression) AS impression FROM fb_ads where idproyek = '$id'");
            foreach ($surat as $s){
                //formula
                $budgetmidas = $s['target_penjualan_bulanan'] * 0.01;
                $budgetonline = $budgetmidas * 0.9 ;
                $budgetoffline = $budgetmidas * 0.1 ;
                $total_budget= $budgetonline + $budgetoffline;
               
               

                foreach($b as $y){
                    $total_hpp = ($y['booking_fee'] + $y['harga_net']) * 0.8;
                    $total_closing= $y['jmlh'];

                        foreach ($c as $g)
                        $total_leads = $g['jumlahdb'] + $g['jumlahnondb'];
                        //costperlead
                            $cpl=($total_leads!=0)?($budgetonline/$total_leads):0;
                            $cpc=($total_closing!=0)?($total_budget/$total_closing):0;
                            $cpl1= round($cpl);
                            $cpc1= round($cpc);
                        //leadperclosing
                            if ($total_closing== 0) {
                                $leadpc = 0;
                            } else {
                                $leadpc = $total_leads/$total_closing   ;
                            }
               
             $html .= '
            <div class="zeus" style="text-align:center; margin-bottom:15px">
            <h2> Detail Proyek</h2><hr>
            </div>
        <table>
        
            <tr>
                <td>Nama Proyek</td><td> :  </td><td>'.$s['nama_proyek'].'</td>
            </tr>
            <tr>
                <td>Budget Online </td><td> :  </td> <td>Rp. '. number_format($budgetonline) .'</td>
            </tr>
            <tr>
                <td>Budget Offline </td><td> :  </td> <td>Rp. '. number_format($budgetoffline) .'</td>
            </tr>
            <tr>
                <td>Reach</td><td> :  </td><td>'.$g['reachp'].'</td>
            </tr>
            <tr>
                <td>Impression </td><td> :  </td><td>'.$g['impression'].'</td>
            </tr>
            <tr>
                <td>Database </td><td> :  </td><td>'.$g['jumlahdb'].'</td>
            </tr>
            <tr>
                <td>Non-Database </td><td> :  </td><td>'.$g['jumlahnondb'].'</td>
            </tr>
            <tr>
                <td>Total Leads </td><td> :  </td><td>'.$total_leads.'</td>
            </tr>
            <tr>
                <td>Total Closing</td><td> :  </td><td>'.$y['jmlh'].'</td>
            </tr>
            <tr>
                <td>Lead Per Closing </td><td> :  </td><td>'.round($leadpc).'</td>
            </tr>
            <tr>
                <td>Cost Per Lead</td><td> :  </td><td>Rp. '.number_format($cpl1).'</td>
            </tr>
            <tr>
                <td>Cost Per Closing </td><td> :  </td><td>Rp. '.number_format($cpc).'</td>
            </tr>
            <tr>
                <td> Total HPP </td><td> :  </td> <td>Rp. '. number_format($total_hpp) .'</td>
            </tr>

           
             </table>';
          
            }
    }

            $html .= '
            
            

            

        
            

         </body>
         </html>'; 
        
        
$mpdf->AddPage("P","","","","","15","15","15","15","","","","","","","","","","","","A4");
$mpdf->WriteHTML($html);

$mpdf->Output();
?>



