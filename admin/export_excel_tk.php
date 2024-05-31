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

	$ambildata_perhalaman = mysqli_query($con, 'SELECT * FROM input_data_tk');


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
	header("Content-Disposition: attachment; filename=dataPembayaranSPPJenjangTK.xls");
	?>

	<div style="overflow-x: auto; margin: 10px;">
                            
        <table id="example_semua" class="table table-bordered" border="1">
            <thead>
              <tr>
                 <th style="text-align: center; width: 5%;"> NUMBER INVOICE </th>
                 <th style="text-align: center;"> NIS </th>
                 <th style="text-align: center;"> NAMA </th>
                 <th style="text-align: center;"> PANGGILAN </th>
                 <th style="text-align: center;"> KELAS </th>
                 <th style="text-align: center;"> TANGGAL BAYAR </th>
                 <th style="text-align: center;"> BULAN </th>
                 <th style="text-align: center;"> TRANSAKSI </th>
                 <th style="text-align: center;"> SPP  </th>
                 <th style="text-align: center;"> KET SPP </th>
                 <th style="text-align: center;"> PANGKAL </th>
                 <th style="text-align: center;"> KET PANGKAL </th>
                 <th style="text-align: center;"> KEGIATAN </th>
                 <th style="text-align: center;"> KET KEGIATAN </th>
                 <th style="text-align: center;"> BUKU </th>
                 <th style="text-align: center;"> KET BUKU </th>
                 <th style="text-align: center;"> SERAGAM </th>
                 <th style="text-align: center;"> KET SERAGAM </th>
                 <th style="text-align: center;"> REGISTRASI </th>
                 <th style="text-align: center;"> KET REGISTRASI </th>
                 <th style="text-align: center;"> LAIN </th>
                 <th style="text-align: center;"> KET LAIN </th>
                 <th style="text-align: center;"> DI INPUT OLEH </th>
                 <th style="text-align: center; width: 7%;"> STAMP </th>
              </tr>
            </thead>
            <tbody>

                <?php foreach ($ambildata_perhalaman as $data) : ?>
                    <tr>
                        <td style="text-align: center;"> <?= $data['ID']; ?> </td>
                        <td style="text-align: center;"> <?= $data['NIS']; ?> </td>
                        <td style="text-align: center;"> <?= $data['NAMA']; ?> </td>
                        <td style="text-align: center;"> <?= $data['PANGGILAN']; ?> </td>
                        <td style="text-align: center;"> <?= $data['KELAS']; ?> </td>

                        <?php if ($data['DATE'] == NULL || $data['DATE'] == '0000-00-00 00:00:00'): ?>

                            <td style="text-align: center;"> <strong> - </strong> </td>

                        <?php else: ?>
                            
                            <td style="text-align: center;"> <?= str_replace([' 00:00:00'], "", tglIndo($data['DATE'])); ?> </td>
                            
                        <?php endif ?>

                        <td style="text-align: center;"> <?= $data['BULAN']; ?> </td>
                        <!-- <td style="text-align: center;"> <?= $data['NAMA_KELAS']; ?> </td> -->
                        <td style="text-align: center;"> <?= $data['TRANSAKSI']; ?> </td>
                        <!-- <td style="text-align: center;"> <?= $data['SPP_SET']; ?> </td> -->
                        <!-- <td style="text-align: center;"> <?= $data['PANGKAL_SET']; ?> </td> -->
                        <td style="text-align: center;"> <?= rupiah($data['SPP']); ?> </td>
                        <?php if ($data['SPP_txt'] == NULL || $data['SPP_txt'] == ''): ?>
                            
                            <td style="text-align: center;"> <strong> - </strong> </td>

                        <?php else: ?>
                        
                            <td style="text-align: center;"> <?= $data['SPP_txt']; ?> </td>
                            
                        <?php endif ?>

                        <td style="text-align: center;"> <?= rupiah($data['PANGKAL']); ?> </td>
                        <?php if ($data['PANGKAL_txt'] == NULL || $data['PANGKAL_txt'] == ''): ?>
                            
                            <td style="text-align: center;"> <strong> - </strong> </td>

                        <?php else: ?>
                        
                            <td style="text-align: center;"> <?= $data['PANGKAL_txt']; ?> </td>
                            
                        <?php endif ?>

                        <td style="text-align: center;"> <?= rupiah($data['KEGIATAN']); ?> </td>
                        <?php if ($data['KEGIATAN_txt'] == NULL || $data['KEGIATAN_txt'] == ''): ?>
                            
                            <td style="text-align: center;"> <strong> - </strong> </td>

                        <?php else: ?>
                        
                            <td style="text-align: center;"> <?= $data['KEGIATAN_txt']; ?> </td>
                            
                        <?php endif ?>

                        <td style="text-align: center;"> <?= rupiah($data['BUKU']); ?> </td>
                        <?php if ($data['BUKU_txt'] == NULL || $data['BUKU_txt'] == ''): ?>
                            
                            <td style="text-align: center;"> <strong> - </strong> </td>

                        <?php else: ?>
                        
                            <td style="text-align: center;"> <?= $data['BUKU_txt']; ?> </td>
                            
                        <?php endif ?>

                        <td style="text-align: center;"> <?= rupiah($data['SERAGAM']); ?> </td>
                        <?php if ($data['SERAGAM_txt'] == NULL || $data['SERAGAM_txt'] == ''): ?>
                            
                            <td style="text-align: center;"> <strong> - </strong> </td>

                        <?php else: ?>
                        
                            <td style="text-align: center;"> <?= $data['SERAGAM_txt']; ?> </td>
                            
                        <?php endif ?>

                        <td style="text-align: center;"> <?= rupiah($data['REGISTRASI']); ?> </td>
                        <?php if ($data['REGISTRASI_txt'] == NULL || $data['REGISTRASI_txt'] == ''): ?>
                            
                            <td style="text-align: center;"> <strong> - </strong> </td>

                        <?php else: ?>
                        
                            <td style="text-align: center;"> <?= $data['REGISTRASI_txt']; ?> </td>
                            
                        <?php endif ?>

                        <td style="text-align: center;"> <?= rupiah($data['LAIN']); ?> </td>
                        <?php if ($data['LAIN_txt'] == NULL || $data['LAIN_txt'] == ''): ?>
                            
                            <td style="text-align: center;"> <strong> - </strong> </td>

                        <?php else: ?>
                        
                            <td style="text-align: center;"> <?= $data['LAIN_txt']; ?> </td>
                            
                        <?php endif ?>

                        <?php if ($data['INPUTER'] == NULL): ?>
                            <td style="text-align: center;"> <strong> - </strong> </td>
                        <?php else: ?>
                            <td style="text-align: center;"> <?= $data['INPUTER']; ?> </td>
                        <?php endif ?>

                        <?php if ($data['STAMP'] == NULL): ?>
                            <td style="text-align: center;"> <strong> - </strong> </td>
                        <?php elseif($data['STAMP'] == '0000-00-00 00:00:00'): ?>
                            <td style="text-align: center;"> <strong> - </strong> </td>
                        <?php else: ?>
                            <td style="text-align: center;"> <?= tglIndo($data['STAMP']); ?> </td>
                        <?php endif ?>
                    </tr>
                <?php endforeach; ?>

            </tbody>

        </table>

    </div>

</body>
</html>