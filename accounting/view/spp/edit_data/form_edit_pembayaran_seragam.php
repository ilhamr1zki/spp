<?php  

	// Jika filter by SPP sedangkan filter tanggal dari dan tanggal sampai tidak di isi 
    // if ($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59") {
    	// echo "Tidak tanggal SPP";

        if ($_SESSION['c_accounting'] == 'accounting1') {

           	$namaMurid = $namaSiswa;
            $queryGetDataSeragam = "
            SELECT ID, NIS, NAMA, kelas, SERAGAM, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
            FROM input_data_sd_lama1
            WHERE
            SERAGAM != 0
            AND NAMA LIKE '%$namaMurid%' ";

            $execQueryDataSeragam    = mysqli_query($con, $queryGetDataSeragam);
            $hitungDataFilterSeragam = mysqli_num_rows($execQueryDataSeragam);

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;
            // echo $dataAwal . "<br>";
            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, SERAGAM, TRANSAKSI, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd_lama1
                WHERE
                SERAGAM != 0
                AND NAMA LIKE '%$namaMurid%' 
                ORDER BY ID DESC
                LIMIT $dataAwal, $jumlahData");
            // print_r($ambildata_perhalaman->num_rows);
            $jumlahPagination = ceil($hitungDataFilterSeragam / $jumlahData);

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
            $queryGetDataSeragam = "
            SELECT ID, NIS, NAMA, kelas, SERAGAM, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
            FROM input_data_tk_lama
            WHERE
            SERAGAM != 0
            AND NAMA LIKE '%$namaMurid%' ";

            $execQueryDataSeragam    = mysqli_query($con, $queryGetDataSeragam);
            $hitungDataFilterSeragam = mysqli_num_rows($execQueryDataSeragam);

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;
            // echo $dataAwal . "<br>";
            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, SERAGAM, TRANSAKSI, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk_lama
                WHERE
                SERAGAM != 0
                AND NAMA LIKE '%$namaMurid%' 
                ORDER BY ID DESC
                LIMIT $dataAwal, $jumlahData");
            // print_r($ambildata_perhalaman->num_rows);
            $jumlahPagination = ceil($hitungDataFilterSeragam / $jumlahData);

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
                <th style="text-align: center; width: 7%;"> NUMBER INVOICE </th>
                <th style="text-align: center; width: 5%;"> NIS </th>
                <th style="text-align: center; width: 15%;"> NAMA </th>
                <th style="text-align: center; width: 3%;"> KELAS </th>
                <th style="text-align: center; width: 9%;"> UANG SERAGAM </th>
                <th style="text-align: center; width: 9%;"> TANGGAL BAYAR </th>
                <th style="text-align: center; width: 9%;"> PEMBAYARAN BULAN </th>
                <th style="text-align: center; width: 13%;"> KET SERAGAM </th>
                <th style="text-align: center; width: 5%;"> TRANSAKSI </th>
                <th style="text-align: center; width: 7%;"> DI INPUT OLEH </th>
                <th style="text-align: center; width: 10%;"> STAMP </th>
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
                        <td style="text-align: center;"> <?= rupiah($data['SERAGAM']); ?> </td>
                        <td style="text-align: center;"> <?= str_replace([" 00:00:00"], "", tglIndo($data['DATE'])); ?> </td>
                        <td style="text-align: center;"> <?= $data['pembayaran_bulan']; ?> </td>
                        <td style="text-align: center;"> <?= $data['SERAGAM_txt']; ?> </td>
                        <td style="text-align: center;"> <?= $data['TRANSAKSI']; ?> </td>

                        <?php if ($data['di_input_oleh'] == NULL): ?>
                            <td style="text-align: center;"> <strong> - </strong> </td>
                        <?php else: ?>
                            <td style="text-align: center;"> <?= $data['di_input_oleh']; ?> </td>
                        <?php endif ?>

                        <?php if ($data['tanggal_diupdate'] == NULL): ?>

                            <td style="text-align: center;"> - </td>

                        <?php else: ?>
                            
                            <td style="text-align: center;"> <?= tglIndo($data['tanggal_diupdate']); ?> </td>
                            
                        <?php endif ?>
                        <td style="text-align: center;" id="tombol-cetak">

                            <form action="<?= $baseac; ?>editdata" method="POST" target="blank">

                                <input type="hidden" name="id_siswa" value="<?= $id; ?>">
                                <input type="hidden" name="nis_siswa" value="<?= $nis; ?>">
                                <input type="hidden" name="nama_siswa" value="<?= $namaSiswa; ?>">
                                <input type="hidden" name="kelas_siswa" value="<?= $kelas; ?>">
                                <input type="hidden" name="panggilan_siswa" value="<?= $panggilan; ?>">

                                <input type="hidden" name="id_invoice" value="<?= $data['ID']; ?>">
                                <input type="hidden" name="tgl_bukti_pembayaran" value="<?= ($data['DATE'] == NULL || $data['DATE'] == '0000-00-00 00:00:00') ? ("-") : ($data['DATE']); ?>">
                                <input type="hidden" name="pembayaran_bulan" value="<?= $data['pembayaran_bulan']; ?>">
                                <input type="hidden" name="nominal_bayar" value="<?= $data['SERAGAM']; ?>">
                                <input type="hidden" name="ket_pembayaran" value="<?= $data['SERAGAM_txt']; ?>">
                                <input type="hidden" name="tipe_transaksi" value="<?= $data['TRANSAKSI']; ?>">
                                <input type="hidden" name="currentPage" value="<?= $halamanAktif; ?>">

                                <input type="hidden" name="isi_filter" value="<?= $isifilby; ?>">

                                <button id="edit_data" name="edit_data" class="btn btn-sm btn-primary btn-circle"> 
                                    EDIT 
                                    <!-- <span class="glyphicon glyphicon-pencil">  -->
                                </button>

                            </form>

                        </td>
                    </tr>
                <?php endforeach; ?>

            </tbody>

        </table>

    </div>

	<div style="display: flex; gap: 5px; padding: 5px; justify-content: center;">

        <?php if ($halamanAktif > 1): ?>

            <form action="<?= $baseac; ?>editdata" method="post">
                <input type="hidden" name="halamanSebelumnyaFilterSeragam" value="<?= $halamanAktif - 1; ?>">
                <input type="hidden" name="iniFilterSeragam" value="<?= $isifilby; ?>">
                <input type="hidden" name="idSiswaFilterSeragam" value="<?= $id; ?>">
                <input type="hidden" name="namaSiswaFilterSeragam" value="<?= $namaMurid; ?>">
                <input type="hidden" name="nisFormFilterSeragam" value="<?= $nis; ?>">
                <input type="hidden" name="kelasFormFilterSeragam" value="<?= $kelas; ?>">
                <input type="hidden" name="namaFormFilterSeragam" value="<?= $namaMurid; ?>">
                <input type="hidden" name="panggilanFormFilterSeragam" value="<?= $panggilan; ?>">
                <button name="previousPageFilterSeragam">
                    &laquo;
                    Previous
                </button>
            </form>

        <?php endif; ?>

        <?php for ($i = $start_number; $i <= $end_number; $i++): ?>

            <?php if ($jumlahPagination == 1): ?>
                
            <?php elseif ($halamanAktif == $i): ?>

                <form action="<?= $baseac; ?>editdata" method="post">
                    <input type="hidden" name="backPage" value="<?= $halamanAktif - 1; ?>">
                    <button name="currentPage" style="color: black; font-weight: bold; background-color: lightgreen;">
                        <?= $i; ?>
                    </button>
                </form>

            <?php else: ?>

                <form action="<?= $baseac; ?>editdata" method="post">
                    <input type="hidden" name="halamanKeFilterSeragam" value="<?= $i; ?>">
                    <input type="hidden" name="iniFilterSeragam" value="<?= $isifilby; ?>">
                    <input type="hidden" name="idSiswaFilterSeragam" value="<?= $id; ?>">
                    <input type="hidden" name="namaSiswaFilterSeragam" value="<?= $namaMurid; ?>">
                    <input type="hidden" name="nisFormFilterSeragam" value="<?= $nis; ?>">
                    <input type="hidden" name="kelasFormFilterSeragam" value="<?= $kelas; ?>">
                    <input type="hidden" name="namaFormFilterSeragam" value="<?= $namaMurid; ?>">
                    <input type="hidden" name="panggilanFormFilterSeragam" value="<?= $panggilan; ?>">
                    <button name="toPageFilterSeragam">
                        <?= $i; ?>
                    </button>
                </form>

            <?php endif; ?>

        <?php endfor; ?>

        <?php if ($halamanAktif < $jumlahPagination): ?>
            
            <form action="<?= $baseac; ?>editdata" method="post">
                <input type="hidden" name="halamanLanjutFilterSeragam" value="<?= $halamanAktif + 1; ?>">
                <input type="hidden" name="iniFilterSeragam" value="<?= $isifilby; ?>">
                <input type="hidden" name="idSiswaFilterSeragam" value="<?= $id; ?>">
                <input type="hidden" name="namaSiswaFilterSeragam" value="<?= $namaMurid; ?>">
                <input type="hidden" name="nisFormFilterSeragam" value="<?= $nis; ?>">
                <input type="hidden" name="kelasFormFilterSeragam" value="<?= $kelas; ?>">
                <input type="hidden" name="namaFormFilterSeragam" value="<?= $namaMurid; ?>">
                <input type="hidden" name="panggilanFormFilterSeragam" value="<?= $panggilan; ?>">
                <button name="nextPageFilterSeragam" id="nextPage" data-nextpage="<?= $halamanAktif + 1; ?>">
                    next
                    &raquo;
                </button>
            </form>

        <?php endif; ?>

    </div>

    <div style="margin-left: 3px; padding: 5px; display: flex; gap: 5px; justify-content: center;">

        <?php if ($halamanAktif > 1): ?>

            <form action="<?= $baseac; ?>editdata" method="post">
                <input type="hidden" name="halamanPertamaFilterSeragam" value="<?= $halamanAktif - 1; ?>">
                <input type="hidden" name="iniFilterSeragam" value="<?= $isifilby; ?>">
                <input type="hidden" name="idSiswaFilterSeragam" value="<?= $id; ?>">
                <input type="hidden" name="namaSiswaFilterSeragam" value="<?= $namaMurid; ?>">
                <input type="hidden" name="nisFormFilterSeragam" value="<?= $nis; ?>">
                <input type="hidden" name="kelasFormFilterSeragam" value="<?= $kelas; ?>">
                <input type="hidden" name="namaFormFilterSeragam" value="<?= $namaMurid; ?>">
                <input type="hidden" name="panggilanFormFilterSeragam" value="<?= $panggilan; ?>">
                <button name="firstPageFilterSeragam">
                    &laquo;
                    First Page
                </button>
            </form>

        <?php endif; ?>        

        <?php if ($hitungDataFilterSeragam != 0): ?>
        	
        	<?php if ($halamanAktif == $jumlahPagination): ?>

	        <?php else: ?>
	            
	            <form action="<?= $baseac; ?>editdata" method="post">
	                <input type="hidden" name="halamanTerakhirFilterSeragam" value="<?= $halamanAktif + 1; ?>">
	                <input type="hidden" name="iniFilterSeragam" value="<?= $isifilby; ?>">
	                <input type="hidden" name="idSiswaFilterSeragam" value="<?= $id; ?>">
	                <input type="hidden" name="namaSiswaFilterSeragam" value="<?= $namaMurid; ?>">
	                <input type="hidden" name="nisFormFilterSeragam" value="<?= $nis; ?>">
	                <input type="hidden" name="kelasFormFilterSeragam" value="<?= $kelas; ?>">
	                <input type="hidden" name="namaFormFilterSeragam" value="<?= $namaMurid; ?>">
	                <input type="hidden" name="panggilanFormFilterSeragam" value="<?= $panggilan; ?>">
	                <button name="lastPageFilterSeragam">
	                    Last Page
	                    &raquo;
	                </button>
	            </form>

	        <?php endif; ?>

        <?php endif ?>

    </div>

    <br>


