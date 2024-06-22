<?php  
    
    require '../php/config.php';
    require '../php/function.php';

    function rupiah($angka){
    
        $hasil_rupiah = "Rp " . number_format($angka,2,',','.');
        return $hasil_rupiah;
     
    }

    function rupiahFormat($angkax){
    
        $hasil_rupiahx = "Rp " . number_format($angkax,0,'.',',');
        return $hasil_rupiahx;
     
    }

    $ambildata_perhalaman = mysqli_query($con, 'SELECT * FROM data_murid_tk');


?>


<!DOCTYPE html>
<html>
<head>
    <title>EXPORT EXCEL</title>
</head>
<body>
    <style type="text/css">
        body{
            font-family: sans-serif;
        }
        table{
            margin: 20px auto;
            border-collapse: collapse;
        }
        table th,
        table td{
            border: 1px solid #3c3c3c;
            padding: 3px 8px;

        }
        a{
            background: blue;
            color: #fff;
            padding: 8px 10px;
            text-decoration: none;
            border-radius: 2px;
        }
    </style>

    <?php
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=data_murid_tk.xls");
    ?>

    <div style="overflow-x: auto; margin: 10px;">
                            
        <table id="example_semua" class="table table-bordered" border="1">
            <thead>
              <tr>
                 <th style="text-align: center; width: 5%;"> ID </th>
                 <th style="text-align: center;"> thn_join </th>
                 <th style="text-align: center;"> NIS </th>
                 <th style="text-align: center;"> KELAS </th>
                 <th style="text-align: center;"> Nama </th>
                 <th style="text-align: center;"> Panggilan </th>
                 <th style="text-align: center;"> KLP </th>
                 <th style="text-align: center;"> jk </th>
                 <th style="text-align: center;"> temlahir </th>
                 <th style="text-align: center;"> tanglahir </th>
                 <th style="text-align: center;"> berat_badan </th>
                 <th style="text-align: center;"> tinggi_badan </th>
                 <th style="text-align: center;"> ukuran_baju  </th>
                 <th style="text-align: center;"> Alamat </th>
                 <th style="text-align: center;"> telp_rumah </th>
                 <th style="text-align: center;"> HP </th>
                 <th style="text-align: center;"> email </th>
                 <th style="text-align: center;"> nama_ayah </th>
                 <th style="text-align: center;"> pendidikan_a </th>
                 <th style="text-align: center;"> pekerjaan_a </th>
                 <th style="text-align: center;"> ttl_a </th>
                 <th style="text-align: center;"> nama_ibu </th>
                 <th style="text-align: center;"> pendidikan_i </th>
                 <th style="text-align: center;"> pekerjaan_i </th>
                 <th style="text-align: center;"> ttl_i </th>
              </tr>
            </thead>
            <tbody>

                <?php foreach ($ambildata_perhalaman as $data) : ?>
                    <tr>
                        <td style="text-align: center;"> <?= $data['ID']; ?> </td>
                        <td style="text-align: center;"> <?= $data['thn_join']; ?> </td>
                        <td style="text-align: center;"> <?= $data['NIS']; ?> </td>
                        <td style="text-align: center;"> <?= $data['KELAS']; ?> </td>
                        <td style="text-align: center;"> <?= $data['Nama']; ?> </td>
                        <td style="text-align: center;"> <?= $data['Panggilan']; ?> </td>

                        <?php if ($data['KLP'] == NULL || $data['KLP'] == ''): ?>
                            
                            <td style="text-align: center;">  </td>

                        <?php else: ?>
                        
                            <td style="text-align: center;"> <?= $data['KLP']; ?> </td>
                            
                        <?php endif ?>

                        <td style="text-align: center;"> <?= $data['jk']; ?> </td>

                        <?php if ($data['temlahir'] == NULL || $data['temlahir'] == ''): ?>

                            <td style="text-align: center;">  </td>

                        <?php else: ?>
                            
                            <td style="text-align: center;"> <?= $data['temlahir']; ?> </td>
                            
                        <?php endif ?>

                        <?php if ($data['tanglahir'] == NULL || $data['tanglahir'] == '0000-00-00 00:00:00'): ?>

                            <td style="text-align: center;">  </td>

                        <?php else: ?>
                            
                            <td style="text-align: center;"> <?= $data['tanglahir']; ?> </td>
                            
                        <?php endif ?>

                        <?php if ($data['berat_badan'] == NULL || $data['berat_badan'] == ''): ?>
                            
                            <td style="text-align: center;">  </td>

                        <?php else: ?>
                        
                            <td style="text-align: center;"> <?= $data['berat_badan']; ?> </td>
                            
                        <?php endif ?>

                        <?php if ($data['tinggi_badan'] == NULL || $data['tinggi_badan'] == ''): ?>
                            
                            <td style="text-align: center;">  </td>

                        <?php else: ?>
                        
                            <td style="text-align: center;"> <?= $data['tinggi_badan']; ?> </td>
                            
                        <?php endif ?>

                        <?php if ($data['ukuran_baju'] == NULL || $data['ukuran_baju'] == ''): ?>
                            
                            <td style="text-align: center;">  </td>

                        <?php else: ?>
                        
                            <td style="text-align: center;"> <?= $data['ukuran_baju']; ?> </td>
                            
                        <?php endif ?>

                        <?php if ($data['Alamat'] == NULL || $data['Alamat'] == ''): ?>
                            
                            <td style="text-align: center;">  </td>

                        <?php else: ?>
                        
                            <td style="text-align: center;"> <?= $data['Alamat']; ?> </td>
                            
                        <?php endif ?>

                        <?php if ($data['telp_rumah'] == NULL || $data['telp_rumah'] == ''): ?>
                            
                            <td style="text-align: center;">  </td>

                        <?php else: ?>
                        
                            <td style="text-align: center;"> <?= $data['telp_rumah']; ?> </td>
                            
                        <?php endif ?>

                        <?php if ($data['HP'] == NULL || $data['HP'] == ''): ?>
                            
                            <td style="text-align: center;">  </td>

                        <?php else: ?>
                        
                            <td style="text-align: center;"> <?= $data['HP']; ?> </td>
                            
                        <?php endif ?>

                        <?php if ($data['email'] == NULL || $data['email'] == ''): ?>
                            
                            <td style="text-align: center;">  </td>

                        <?php else: ?>
                        
                            <td style="text-align: center;"> <?= $data['email']; ?> </td>
                            
                        <?php endif ?>

                        <?php if ($data['nama_ayah'] == NULL || $data['nama_ayah'] == ''): ?>
                            
                            <td style="text-align: center;">  </td>

                        <?php else: ?>
                        
                            <td style="text-align: center;"> <?= $data['nama_ayah']; ?> </td>
                            
                        <?php endif ?>

                        <?php if ($data['pendidikan_a'] == NULL || $data['pendidikan_a'] == ''): ?>
                            
                            <td style="text-align: center;">  </td>

                        <?php else: ?>
                        
                            <td style="text-align: center;"> <?= $data['pendidikan_a']; ?> </td>
                            
                        <?php endif ?>

                        <?php if ($data['pekerjaan_a'] == NULL || $data['pekerjaan_a'] == ''): ?>
                            
                            <td style="text-align: center;">  </td>

                        <?php else: ?>
                        
                            <td style="text-align: center;"> <?= $data['pekerjaan_a']; ?> </td>
                            
                        <?php endif ?>

                        <?php if ($data['ttl_a'] == NULL || $data['ttl_a'] == ''): ?>
                            
                            <td style="text-align: center;">  </td>

                        <?php else: ?>
                        
                            <td style="text-align: center;"> <?= $data['ttl_a']; ?> </td>
                            
                        <?php endif ?>

                        <?php if ($data['nama_ibu'] == NULL || $data['nama_ibu'] == ''): ?>
                            
                            <td style="text-align: center;">  </td>

                        <?php else: ?>
                        
                            <td style="text-align: center;"> <?= $data['nama_ibu']; ?> </td>
                            
                        <?php endif ?>

                        <?php if ($data['pendidikan_i'] == NULL || $data['pendidikan_i'] == ''): ?>
                            
                            <td style="text-align: center;">  </td>

                        <?php else: ?>
                        
                            <td style="text-align: center;"> <?= $data['pendidikan_i']; ?> </td>
                            
                        <?php endif ?>

                        <?php if ($data['pekerjaan_i'] == NULL || $data['pekerjaan_i'] == ''): ?>
                            
                            <td style="text-align: center;">  </td>

                        <?php else: ?>
                        
                            <td style="text-align: center;"> <?= $data['pekerjaan_i']; ?> </td>
                            
                        <?php endif ?>

                        <?php if ($data['ttl_i'] == NULL || $data['ttl_i'] == ''): ?>
                            
                            <td style="text-align: center;">  </td>

                        <?php else: ?>
                        
                            <td style="text-align: center;"> <?= $data['ttl_i']; ?> </td>
                            
                        <?php endif ?>

                    </tr>
                <?php endforeach; ?>

            </tbody>

        </table>

    </div>

</body>
</html>