<?php  

	// Jika filter by SPP sedangkan filter tanggal dari dan tanggal sampai tidak di isi 
    // if ($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59") {
    	// echo "Tidak tanggal SPP";

        if ($_SESSION['c_accounting'] == 'accounting1') {

            $namaMurid = $namaSiswa;
            $queryGetDataSPP = "
            SELECT ID, NIS, NAMA, kelas, SPP, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
            FROM input_data_sd
            WHERE
            SPP != 0
            AND NAMA LIKE '%$namaMurid%' ";
            $execQueryDataSPP    = mysqli_query($con, $queryGetDataSPP);
            $hitungDataFilterSPP = mysqli_num_rows($execQueryDataSPP);
            // echo $hitungDataFilterSPP;

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;
            // echo $dataAwal . "<br>";
            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, SPP, TRANSAKSI, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                SPP != 0
                AND NAMA LIKE '%$namaMurid%' 
                ORDER BY ID DESC
                LIMIT $dataAwal, $jumlahData");
            // print_r($ambildata_perhalaman->num_rows);

            $jumlahPagination = ceil($hitungDataFilterSPP / $jumlahData);

            $jumlahLink = 2;

            if ($halamanAktif > $jumlahLink) {
                $start_number = $halamanAktif - $jumlahLink;
            } else {
                $start_number = 1;
            }

            if ($halamanAktif < ($jumlahPagination - $jumlahLink)) {
                $end_number = $halamanAktif + $jumlahLink;
            } else {
                $end_number = $jumlahPagination;
            }

        } else if ($_SESSION['c_accounting'] == 'accounting2') {

            $namaMurid = $namaSiswa;
            $queryGetDataSPP = "
            SELECT ID, NIS, NAMA, kelas, SPP, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
            FROM input_data_tk
            WHERE
            SPP != 0
            AND NAMA LIKE '%$namaMurid%' ";
            $execQueryDataSPP    = mysqli_query($con, $queryGetDataSPP);
            $hitungDataFilterSPP = mysqli_num_rows($execQueryDataSPP);
            // echo $hitungDataFilterSPP;

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;
            // echo $dataAwal . "<br>";
            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, SPP, TRANSAKSI, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                SPP != 0
                AND NAMA LIKE '%$namaMurid%' 
                ORDER BY ID DESC
                LIMIT $dataAwal, $jumlahData");
            // print_r($ambildata_perhalaman->num_rows);

            $jumlahPagination = ceil($hitungDataFilterSPP / $jumlahData);

            $jumlahLink = 2;

            if ($halamanAktif > $jumlahLink) {
                $start_number = $halamanAktif - $jumlahLink;
            } else {
                $start_number = 1;
            }

            if ($halamanAktif < ($jumlahPagination - $jumlahLink)) {
                $end_number = $halamanAktif + $jumlahLink;
            } else {
                $end_number = $jumlahPagination;
            }

        }

    // } else {
    	// echo "Ada tanggal SPP";
    // }

?>
	
	<div style="overflow-x: auto; margin: 10px;">
                                
        <table id="example1" class="table table-bordered">
            <thead>
             	<tr>
	                <th style="text-align: center; width: 5%;"> NUMBER INVOICE </th>
	                <th style="text-align: center; width: 1%;"> NIS </th>
	                <th style="text-align: center; width: 10%;"> NAMA </th>
	                <th style="text-align: center; width: 3%;"> KELAS </th>
	                <th style="text-align: center; width: 5%;"> SPP </th>
	                <th style="text-align: center; width: 3%;"> TANGGAL BAYAR </th>
	                <th style="text-align: center; width: 3%;"> PEMBAYARAN BULAN </th>
	                <th style="text-align: center; width: 7%;"> KET SPP </th>
	                <th style="text-align: center; width: 2%;"> TRANSAKSI </th>
	                <th style="text-align: center; width: 4%;"> DI INPUT OLEH </th>
	                <th style="text-align: center; width: 6%;"> STAMP </th>
	                <th style="text-align: center; width: 1%;"> ACTION </th>
              	</tr>
            </thead>
            <tbody>

                <?php $no = 1; ?>
                <?php foreach ($ambildata_perhalaman as $data) : ?>
                    <tr>
                        <td style="text-align: center;"> <?= $data['ID']; ?> </td>
                        <td style="text-align: center;"> <?= $data['NIS']; ?> </td>
                        <td style="text-align: center;"> <?= $data['NAMA']; ?> </td>
                        <td style="text-align: center;"> <?= $data['kelas']; ?> </td>
                        <td style="text-align: center;"> <?= rupiahFormat($data['SPP']); ?> </td>

                        <?php if ($data['DATE'] == NULL || $data['DATE'] == '0000-00-00 00:00:00'): ?>

                            <td style="text-align: center;"> <strong> - </strong> </td>

                        <?php else: ?>
                            
                            <td style="text-align: center;"> <?= str_replace([' 00:00:00'], "", tglIndo($data['DATE'])); ?> </td>
                            
                        <?php endif ?>

                        <td style="text-align: center;"> <?= $data['pembayaran_bulan']; ?> </td>

                        <?php if ($data['SPP_txt'] == NULL): ?>
                            <td style="text-align: center;"> <strong> - </strong> </td>
                        <?php else: ?>
                            <td style="text-align: center;"> <?= $data['SPP_txt']; ?> </td>
                        <?php endif ?>

                        <?php if ($data['TRANSAKSI'] == '' || $data['TRANSAKSI'] == NULL): ?>
                            <td style="text-align: center;"> <strong> - </strong> </td>
                        <?php else: ?>
                            <td style="text-align: center;"> <?= $data['TRANSAKSI']; ?> </td>
                        <?php endif ?>

                        <?php if ($data['di_input_oleh'] == NULL): ?>
                            <td style="text-align: center;"> <strong> - </strong> </td>
                        <?php else: ?>
                            <td style="text-align: center;"> <?= $data['di_input_oleh']; ?> </td>
                        <?php endif ?>

                        <?php if ($data['tanggal_diupdate'] == NULL || $data['tanggal_diupdate'] == '0000-00-00 00:00:00'): ?>
                            <td style="text-align: center;"> <strong> - </strong> </td>
                            <td style="text-align: center; justify-content: center;" id="tombol-cetak">

                                <form action="<?= $baseac; ?>editdata" method="POST" target="blank">

                                    <input type="hidden" name="id_siswa" value="<?= $id; ?>">
                                    <input type="hidden" name="nis_siswa" value="<?= $nis; ?>">
                                    <input type="hidden" name="nama_siswa" value="<?= $namaSiswa; ?>">
                                    <input type="hidden" name="kelas_siswa" value="<?= $kelas; ?>">
                                    <input type="hidden" name="panggilan_siswa" value="<?= $panggilan; ?>">

                                    <input type="hidden" name="id_invoice" value="<?= $data['ID']; ?>">
                                    <input type="hidden" name="tgl_bukti_pembayaran" value="<?= ($data['DATE'] == NULL || $data['DATE'] == '0000-00-00 00:00:00') ? ("-") : ($data['DATE']); ?>">
                                    <input type="hidden" name="pembayaran_bulan" value="<?= $data['pembayaran_bulan']; ?>">
                                    <input type="hidden" name="nominal_bayar" value="<?= $data['SPP']; ?>">
                                    <input type="hidden" name="ket_pembayaran" value="<?= $data['SPP_txt']; ?>">
                                    <input type="hidden" name="tipe_transaksi" value="<?= $data['TRANSAKSI']; ?>">
                                    <input type="hidden" name="currentPage" value="<?= $halamanAktif; ?>">

                                    <input type="hidden" name="isi_filter" value="SPP">

                                    <button id="edit_data" name="edit_data" class="btn btn-sm btn-primary btn-circle"> 
                                        EDIT 
                                        <!-- <span class="glyphicon glyphicon-pencil">  -->
                                    </button>

                                </form>

                            </td>
                        <?php else: ?>
                            <td style="text-align: center;"> <?= tglIndo($data['tanggal_diupdate']); ?> </td>
                            <td style="text-align: center; justify-content: center;" id="tombol-cetak">

                            	<form action="<?= $baseac; ?>editdata" method="POST" target="blank">

                                    <input type="hidden" name="id_siswa" value="<?= $id; ?>">
                                    <input type="hidden" name="nis_siswa" value="<?= $nis; ?>">
                                    <input type="hidden" name="nama_siswa" value="<?= $namaSiswa; ?>">
                                    <input type="hidden" name="kelas_siswa" value="<?= $kelas; ?>">
                                    <input type="hidden" name="panggilan_siswa" value="<?= $panggilan; ?>">

                                    <input type="hidden" name="id_invoice" value="<?= $data['ID']; ?>">
                                    <input type="hidden" name="tgl_bukti_pembayaran" value="<?= ($data['DATE'] == NULL || $data['DATE'] == '0000-00-00 00:00:00') ? ("-") : ($data['DATE']); ?>">
                                    <input type="hidden" name="pembayaran_bulan" value="<?= $data['pembayaran_bulan']; ?>">
                                    <input type="hidden" name="nominal_bayar" value="<?= $data['SPP']; ?>">
                                    <input type="hidden" name="ket_pembayaran" value="<?= $data['SPP_txt']; ?>">
                                    <input type="hidden" name="tipe_transaksi" value="<?= $data['TRANSAKSI']; ?>">
                                    <input type="hidden" name="currentPage" value="<?= $halamanAktif; ?>">

                                    <input type="hidden" name="isi_filter" value="SPP">
                                    
                                    <button id="edit_data" name="edit_data" class="btn btn-sm btn-primary btn-circle"> 
                                        EDIT 
                                        <!-- <span class="glyphicon glyphicon-pencil">  -->
                                    </button>

                                </form>
                               
                            </td>
                        <?php endif ?>
                    </tr>
                <?php endforeach; ?>

            </tbody>

        </table>

    </div>

	<div style="display: flex; gap: 5px; padding: 5px; justify-content: center;">

        <?php if ($halamanAktif > 1): ?>

            <form action="<?= $baseac; ?>editdata" method="post">
                <input type="hidden" name="iniFilterSPP" value="<?= $isifilby; ?>">
                <input type="hidden" name="idSiswaFilterSPP" value="<?= $id; ?>">
                <input type="hidden" name="namaSiswaFilterSPP" value="<?= $namaMurid; ?>">
                <input type="hidden" name="nisFormFilterSPP" value="<?= $nis; ?>">
                <input type="hidden" name="kelasFormFilterSPP" value="<?= $kelas; ?>">
                <input type="hidden" name="namaFormFilterSPP" value="<?= $namaMurid; ?>">
                <input type="hidden" name="panggilanFormFilterSPP" value="<?= $panggilan; ?>">
                <input type="hidden" name="halamanSebelumnyaFilterSPP" value="<?= $halamanAktif - 1; ?>">
                <button name="previousPageFilterSPP">
                    &laquo;
                    Previous
                </button>
            </form>

        <?php endif; ?>

        <?php for ($i = $start_number; $i <= $end_number; $i++): ?>

            <?php if ($jumlahPagination == 1): ?>
                
            <?php elseif ($halamanAktif == $i): ?>

                <form action="checkpembayaran" method="post">
                    <input type="hidden" name="backPage" value="<?= $halamanAktif - 1; ?>">
                    <button name="currentPage" style="color: black; font-weight: bold; background-color: lightgreen;">
                        <?= $i; ?>
                    </button>
                </form>

            <?php else: ?>

                <form action="editdata" method="post">
                    <input type="hidden" name="halamanKeFilterSPP" value="<?= $i; ?>">
                    <input type="hidden" name="iniFilterSPP" value="<?= $isifilby; ?>">
                    <input type="hidden" name="idSiswaFilterSPP" value="<?= $id; ?>">
                    <input type="hidden" name="namaSiswaFilterSPP" value="<?= $namaMurid; ?>">
                    <input type="hidden" name="nisFormFilterSPP" value="<?= $nis; ?>">
                    <input type="hidden" name="kelasFormFilterSPP" value="<?= $kelas; ?>">
                    <input type="hidden" name="namaFormFilterSPP" value="<?= $namaMurid; ?>">
                    <input type="hidden" name="panggilanFormFilterSPP" value="<?= $panggilan; ?>">
                    <button name="toPageFilterSPP">
                        <?= $i; ?>
                    </button>
                </form>
            <?php endif; ?>

        <?php endfor; ?>

        <?php if ($halamanAktif < $jumlahPagination): ?>
            
            <form action="<?= $baseac; ?>editdata" method="post">
                <input type="hidden" name="halamanLanjutFilterSPP" value="<?= $halamanAktif + 1; ?>">
                <input type="hidden" name="iniFilterSPP" value="<?= $isifilby; ?>">
                <input type="hidden" name="idSiswaFilterSPP" value="<?= $id; ?>">
                <input type="hidden" name="namaSiswaFilterSPP" value="<?= $namaMurid; ?>">
                <input type="hidden" name="nisFormFilterSPP" value="<?= $nis; ?>">
                <input type="hidden" name="kelasFormFilterSPP" value="<?= $kelas; ?>">
                <input type="hidden" name="namaFormFilterSPP" value="<?= $namaMurid; ?>">
                <input type="hidden" name="panggilanFormFilterSPP" value="<?= $panggilan; ?>">
                <button name="nextPageFilterSPP" id="nextPage" data-nextpage="<?= $halamanAktif + 1; ?>">
                    next
                    &raquo;
                </button>
            </form>

        <?php endif; ?>

    </div>

    <div style="margin-left: 3px; padding: 5px; display: flex; gap: 5px; justify-content: center;">

        <?php if ($halamanAktif > 1): ?>

            <form action="editdata" method="post">
                <input type="hidden" name="halamanPertamaFilterSPP" value="<?= $halamanAktif - 1; ?>">
                <input type="hidden" name="iniFilterSPP" value="<?= $isifilby; ?>">
                <input type="hidden" name="idSiswaFilterSPP" value="<?= $id; ?>">
                <input type="hidden" name="namaSiswaFilterSPP" value="<?= $namaMurid; ?>">
                <input type="hidden" name="nisFormFilterSPP" value="<?= $nis; ?>">
                <input type="hidden" name="kelasFormFilterSPP" value="<?= $kelas; ?>">
                <input type="hidden" name="namaFormFilterSPP" value="<?= $namaMurid; ?>">
                <input type="hidden" name="panggilanFormFilterSPP" value="<?= $panggilan; ?>">
                <button name="firstPageFilterSPP">
                    &laquo;
                    First Page
                </button>
            </form>

        <?php endif; ?>        

        <?php if ($halamanAktif == $jumlahPagination): ?>
        <?php else: ?>
            
            <form action="editdata" method="post">
                <input type="hidden" name="halamanTerakhirFilterSPP" value="<?= $halamanAktif + 1; ?>">
                <input type="hidden" name="iniFilterSPP" value="<?= $isifilby; ?>">
                <input type="hidden" name="idSiswaFilterSPP" value="<?= $id; ?>">
                <input type="hidden" name="namaSiswaFilterSPP" value="<?= $namaMurid; ?>">
                <input type="hidden" name="nisFormFilterSPP" value="<?= $nis; ?>">
                <input type="hidden" name="kelasFormFilterSPP" value="<?= $kelas; ?>">
                <input type="hidden" name="namaFormFilterSPP" value="<?= $namaMurid; ?>">
                <input type="hidden" name="panggilanFormFilterSPP" value="<?= $panggilan; ?>">
                <button name="lastPageFilterSPP">
                    Last Page
                    &raquo;
                </button>
            </form>

        <?php endif ?>

    </div>

    <br>


