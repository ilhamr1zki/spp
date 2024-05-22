<?php  

	$isifilby       = 'kosong';

	$filter_by['isifilter_by'] = [
        'SPP',
        'PANGKAL',
        'KEGIATAN',
        'BUKU',
        'SERAGAM',
        'REGISTRASI',
        'LAIN'
    ];

    $isifilby       = 'kosong';
    $tanggalDari    = 'kosong_tgl1';
    $tanggalSampai  = 'kosong_tgl2';

     function rupiah($angka){
    
        $hasil_rupiah = "Rp " . number_format($angka,2,',','.');
        return $hasil_rupiah;
     
    }

    if ($_SESSION['c_accounting'] == 'accounting1') {

        // Data Modal Siswa
    	$dataSiswa = mysqli_query($con, "SELECT * FROM data_murid_sd");	

        $getDataInputSPP =  mysqli_query($con, "SELECT * FROM input_data_sd");

        $dataInputSPP = mysqli_num_rows($getDataInputSPP);

        // echo $dataInputSPP;

        $halamanAktif = 1;

        $jumlahData = 5;
        $totalData = mysqli_num_rows($dataSiswa);

        $jumlahPagination = ceil($totalData / $jumlahData);

        $totalHalamanTambah100 = $halamanAktif;

        $showAddPage100 = "";

        $totalHalamanTambah100 = $halamanAktif + 100;

        if ($totalHalamanTambah100 <= $jumlahPagination) {
            $showAddPage100 = "muncul";
        } else {
            $showAddPage100 = "tidak_muncul";
        }            

        $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;
        // echo $dataAwal . "<br>";
        $ambildata_perhalaman = mysqli_query($con, "SELECT * FROM input_data_sd ORDER BY ID DESC LIMIT $dataAwal, $jumlahData  ");
        // echo mysqli_num_rows($ambildata_perhalaman);
        // print_r($ambildata_perhalaman->num_rows);

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

        $dataSiswa = mysqli_query($con, "SELECT * FROM data_murid_tk"); 

    }

?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">

        <?php if(isset($_SESSION['form_success']) && $_SESSION['form_success'] == 'form_empty'){?>
          <div style="display: none;" class="alert alert-danger alert-dismissable"> Cari Siswa Terlebih Dahulu
             <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
             <?php unset($_SESSION['form_success']); ?>
          </div>
        <?php } ?>

    </div>
</div>

<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Form Edit Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
       
    </div>

    <form action="<?= $baseac; ?>editdata" method="post">
        <div class="box-body">

            <div class="row">

                <div class="col-sm-4">
                    <div class="form-group">
                        <label>ID Siswa</label>
                        <input type="text" class="form-control" value="" name="id_siswa" id="form_edit_id_siswa" readonly="">
                    </div>
                </div>
                
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>NIS</label>
                        <input type="text" class="form-control" value="" name="nis_siswa" id="form_edit_nis_siswa" readonly="">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Nama Siswa</label>
                        <input type="text" name="nama_siswa" class="form-control" value="" id="form_edit_nama_siswa" readonly/>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Kelas</label>
                        <input type="text" name="kelas_siswa" class="form-control" value="" id="form_edit_kelas_siswa" readonly/>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Panggilan</label>
                        <input type="text" class="form-control" id="form_edit_panggilan_siswa" value="" name="panggilan_siswa" readonly />
                    </div>
                </div>
                
            </div> 

            <div class="row">

                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Filter By</label>
                        <select class="form-control" name="isi_filter_edit">  
                            <option value="kosong"> -- PILIH -- </option>
                            <?php foreach ($filter_by['isifilter_by'] as $filby): ?>

                                <?php if ($filby == 'LAIN'): ?>

                                    <option value="<?= $filby; ?>" > LAIN - LAIN </option>

                                <?php else: ?>

                                    <option value="<?= $filby; ?>" > <?= $filby; ?> </option>
                                    
                                <?php endif; ?>

                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group">
                        <label> Filter Date From </label>
                        <?php if ($tanggalDari == 'kosong_tgl1'): ?>
                            <input type="date" class="form-control" name="tanggal1">
                        <?php else: ?>
                            <input type="date" class="form-control" name="tanggal1" value="<?= $tanggalDari; ?>">
                        <?php endif; ?>
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group">
                        <label> Filter Date To </label>
                        <?php if ($tanggalSampai == 'kosong_tgl2'): ?>
                            <input type="date" class="form-control" name="tanggal2">
                        <?php else: ?>
                            <input type="date" class="form-control" name="tanggal2" value="<?= $tanggalSampai; ?>">
                        <?php endif; ?>
                    </div>
                </div>

                <div class="col-sm-2">
                    <div class="form-group">
                        <label style="color: white;"> Filter </label>
                        <button type="submit" name="filter_by_edit" class="form-control btn-primary"> Filter </button>
                    </div>
                </div>

            </div>

        </div>
    </form>
    
    <?php if (isset($_POST['filter_by_edit'])): ?>

        <?php  

            $id         = $_POST['id_siswa'];
            $nis        = $_POST['nis_siswa'];
            $namaSiswa  = $_POST['nama_siswa'];
            $kelas      = $_POST['kelas_siswa'];
            $panggilan  = $_POST['panggilan_siswa'];

        ?>

        <?php if ($id != '' && $nis != '' && $namaSiswa != '' && $kelas != '' && $panggilan != ''): ?>
            <?php echo $id;exit; ?>
            <?php if ($_POST['isi_filter_edit'] != 'kosong'): ?>

                <?php  

                    $dariTanggal    = $_POST['tanggal1'] . " 00:00:00";
                    $sampaiTanggal  = $_POST['tanggal2'] . " 23:59:59";

                ?>

                <?php if ($_POST['isi_filter_edit'] == 'SPP') : ?>

                    <?php  
                        echo $_POST['isi_filter_edit'];exit;
                        // Data SPP
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
                            ORDER BY STAMP DESC
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

                        // Akhir Data SPP

                    ?>

                    <hr class="new2" />

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
                                <th style="text-align: center; width: 1%;"> CETAK </th>
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
                                        <td style="text-align: center;"> <?= rupiah($data['SPP']); ?> </td>

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

                                                <form action="<?= $baseac; ?>Kuitansi.php" method="POST" target="_blank">
                                                    <input type="hidden" id="cetakKuitansi_uang_spp" name="cetak_kuitansi_uang_spp" value="<?= $data['SPP']; ?>">
                                                    <input type="hidden" name="cetak_kuitansi_uang_pangkal" value="0">
                                                    <input type="hidden" name="cetak_kuitansi_uang_kegiatan" value="0">
                                                    <input type="hidden" name="cetak_kuitansi_uang_buku" value="0">
                                                    <input type="hidden" name="cetak_kuitansi_uang_seragam" value="0">
                                                    <input type="hidden" name="cetak_kuitansi_uang_registrasi" value="0">
                                                    <input type="hidden" name="cetak_kuitansi_uang_lain" value="0">
                                                    <input type="hidden" id="cetakKuitansi_id_siswa" name="cetak_kuitansi_id_invoice" value="<?= $data['ID']; ?>">
                                                    <input type="hidden" id="cetakKuitansi_nis_siswa" name="cetak_kuitansi_nis_siswa" value="<?= $data['NIS']; ?>">
                                                    <input type="hidden" id="cetakKuitansi_nama_siswa" name="cetak_kuitansi_nama_siswa" value="<?= $data['NAMA']; ?>">
                                                    <input type="hidden" id="cetakKuitansi_kelas_siswa" name="cetak_kuitansi_kelas_siswa" value="<?= $data['kelas']; ?>">
                                                    <input type="hidden" id="cetakKuitansi_bukti_tf" name="cetak_kuitansi_bukti_tf" value="<?= ($data['DATE'] == NULL || $data['DATE'] == '0000-00-00 00:00:00') ? ("kosong") : ($data['DATE']); ?>">
                                                    <input type="hidden" name="cetak_kuitansi_bulan_pembayaran" value="<?= $data['pembayaran_bulan']; ?>">
                                                    <input type="hidden" id="cetakKuitansi_ket_uang_spp" name="cetak_kuitansi_ket_uang_spp" value="<?= ($data['SPP_txt'] == NULL) ? ('-') : ($data['SPP_txt']); ?>">
                                                    <input type="hidden" name="cetak_kuitansi_ket_uang_pangkal" value="">
                                                    <input type="hidden" name="cetak_kuitansi_ket_uang_kegiatan" value="">
                                                    <input type="hidden" name="cetak_kuitansi_ket_uang_buku" value="">
                                                    <input type="hidden" name="cetak_kuitansi_ket_uang_seragam" value="">
                                                    <input type="hidden" name="cetak_kuitansi_ket_uang_registrasi" value="">
                                                    <input type="hidden" name="cetak_kuitansi_ket_uang_lain" value="">
                                                    <input type="hidden" name="cetak_kuitansi_filter" value="semua">
                                                    <button id="cetak_kuitansi" name="cetak_kuitansi" class="btn btn-sm btn-success btn-circle"> 
                                                        Kuitansi 
                                                        <span class="glyphicon glyphicon-print"> 
                                                    </button>

                                                </form>

                                                <form action="<?= $baseac; ?>slipkuitansi.php" method="POST" target="_blank">
                                                    
                                                    <input type="hidden" name="cetak_kuitansi_nis_siswa" value="<?= $data['NIS']; ?>">
                                                    <input type="hidden" name="cetak_kuitansi_nama_siswa" value="<?= $data['NAMA']; ?>">
                                                    <input type="hidden" name="cetak_kuitansi_kelas_siswa" value="<?= $data['kelas']; ?>">
                                                    <input type="hidden" name="cetak_kuitansi_id_invoice" value="<?= $data['ID']; ?>">
                                                    <input type="hidden" name="cetak_kuitansi_bukti_tf" value="<?= ($data['DATE'] == NULL || $data['DATE'] == '0000-00-00 00:00:00') ? ("kosong") : ($data['DATE']); ?>">
                                                    <input type="hidden" name="cetak_kuitansi_bulan_pembayaran" value="<?= $data['pembayaran_bulan']; ?>">

                                                    <input type="hidden" name="cetak_kuitansi_uang_spp" value="<?= $data['SPP']; ?>">
                                                    <input type="hidden" name="cetak_kuitansi_uang_pangkal" value="0">
                                                    <input type="hidden" name="cetak_kuitansi_uang_kegiatan" value="0">
                                                    <input type="hidden" name="cetak_kuitansi_uang_buku" value="0">
                                                    <input type="hidden" name="cetak_kuitansi_uang_seragam" value="0">
                                                    <input type="hidden" name="cetak_kuitansi_uang_registrasi" value="0">
                                                    <input type="hidden" name="cetak_kuitansi_uang_lain" value="0">

                                                    <input type="hidden" name="cetak_kuitansi_ket_uang_spp" value="<?= ($data['SPP_txt'] == NULL) ? ('-') : ($data['SPP_txt']); ?>">
                                                    <input type="hidden" name="cetak_kuitansi_ket_uang_pangkal" value="">
                                                    <input type="hidden" name="cetak_kuitansi_ket_uang_kegiatan" value="">
                                                    <input type="hidden" name="cetak_kuitansi_ket_uang_buku" value="">
                                                    <input type="hidden" name="cetak_kuitansi_ket_uang_seragam" value="">
                                                    <input type="hidden" name="cetak_kuitansi_ket_uang_registrasi" value="">
                                                    <input type="hidden" name="cetak_kuitansi_ket_uang_lain" value="">

                                                    <input type="hidden" name="jenisPembayaranSPP" value="<?= $data['SPP']; ?>">
                                                    <input type="hidden" name="jenisPembayaranPangkal" value="0">
                                                    <input type="hidden" name="jenisPembayaranKegiatan" value="0">
                                                    <input type="hidden" name="jenisPembayaranBuku" value="0">
                                                    <input type="hidden" name="jenisPembayaranSeragam" value="0">
                                                    <input type="hidden" name="jenisPembayaranRegistrasi" value="0">
                                                    <input type="hidden" name="jenisPembayaranLain" value="0">

                                                    <button type="submit" id="slip_kuitansi" name="slip_kuitansi" class="btn btn-sm btn-success btn-circle"> 
                                                        Slip Kuitansi 
                                                        <span class="glyphicon glyphicon-print"> 
                                                    </button>

                                                </form>

                                            </td>
                                        <?php else: ?>
                                            <td style="text-align: center;"> <?= tglIndo($data['tanggal_diupdate']); ?> </td>
                                            <td style="text-align: center; justify-content: center;" id="tombol-cetak">

                                                <form action="<?= $baseac; ?>Kuitansi.php" method="POST" target="_blank">
                                                    <input type="hidden" id="cetakKuitansi_uang_spp" name="cetak_kuitansi_uang_spp" value="<?= $data['SPP']; ?>">
                                                    <input type="hidden" name="cetak_kuitansi_uang_pangkal" value="0">
                                                    <input type="hidden" name="cetak_kuitansi_uang_kegiatan" value="0">
                                                    <input type="hidden" name="cetak_kuitansi_uang_buku" value="0">
                                                    <input type="hidden" name="cetak_kuitansi_uang_seragam" value="0">
                                                    <input type="hidden" name="cetak_kuitansi_uang_registrasi" value="0">
                                                    <input type="hidden" name="cetak_kuitansi_uang_lain" value="0">
                                                    <input type="hidden" id="cetakKuitansi_id_siswa" name="cetak_kuitansi_id_invoice" value="<?= $data['ID']; ?>">
                                                    <input type="hidden" id="cetakKuitansi_nis_siswa" name="cetak_kuitansi_nis_siswa" value="<?= $data['NIS']; ?>">
                                                    <input type="hidden" id="cetakKuitansi_nama_siswa" name="cetak_kuitansi_nama_siswa" value="<?= $data['NAMA']; ?>">
                                                    <input type="hidden" id="cetakKuitansi_kelas_siswa" name="cetak_kuitansi_kelas_siswa" value="<?= $data['kelas']; ?>">
                                                    <input type="hidden" id="cetakKuitansi_bukti_tf" name="cetak_kuitansi_bukti_tf" value="<?= ($data['DATE'] == NULL || $data['DATE'] == '0000-00-00 00:00:00') ? ("kosong") : ($data['DATE']); ?>">
                                                    <input type="hidden" name="cetak_kuitansi_bulan_pembayaran" value="<?= $data['pembayaran_bulan']; ?>">
                                                    <input type="hidden" id="cetakKuitansi_ket_uang_spp" name="cetak_kuitansi_ket_uang_spp" value="<?= ($data['SPP_txt'] == NULL) ? ('-') : ($data['SPP_txt']); ?>">
                                                    <input type="hidden" name="cetak_kuitansi_ket_uang_pangkal" value="">
                                                    <input type="hidden" name="cetak_kuitansi_ket_uang_kegiatan" value="">
                                                    <input type="hidden" name="cetak_kuitansi_ket_uang_buku" value="">
                                                    <input type="hidden" name="cetak_kuitansi_ket_uang_seragam" value="">
                                                    <input type="hidden" name="cetak_kuitansi_ket_uang_registrasi" value="">
                                                    <input type="hidden" name="cetak_kuitansi_ket_uang_lain" value="">
                                                    <input type="hidden" name="cetak_kuitansi_filter" value="semua">
                                                    <button id="cetak_kuitansi" name="cetak_kuitansi" class="btn btn-sm btn-success btn-circle"> 
                                                        Kuitansi 
                                                        <span class="glyphicon glyphicon-print"> 
                                                    </button>

                                                </form>

                                                <form action="<?= $baseac; ?>slipkuitansi.php" method="POST" target="_blank">
                                                    
                                                    <input type="hidden" name="cetak_kuitansi_nis_siswa" value="<?= $data['NIS']; ?>">
                                                    <input type="hidden" name="cetak_kuitansi_nama_siswa" value="<?= $data['NAMA']; ?>">
                                                    <input type="hidden" name="cetak_kuitansi_kelas_siswa" value="<?= $data['kelas']; ?>">
                                                    <input type="hidden" name="cetak_kuitansi_id_invoice" value="<?= $data['ID']; ?>">
                                                    <input type="hidden" name="cetak_kuitansi_bukti_tf" value="<?= ($data['DATE'] == NULL || $data['DATE'] == '0000-00-00 00:00:00') ? ("kosong") : ($data['DATE']); ?>">
                                                    <input type="hidden" name="cetak_kuitansi_bulan_pembayaran" value="<?= $data['pembayaran_bulan']; ?>">

                                                    <input type="hidden" name="cetak_kuitansi_uang_spp" value="<?= $data['SPP']; ?>">
                                                    <input type="hidden" name="cetak_kuitansi_uang_pangkal" value="0">
                                                    <input type="hidden" name="cetak_kuitansi_uang_kegiatan" value="0">
                                                    <input type="hidden" name="cetak_kuitansi_uang_buku" value="0">
                                                    <input type="hidden" name="cetak_kuitansi_uang_seragam" value="0">
                                                    <input type="hidden" name="cetak_kuitansi_uang_registrasi" value="0">
                                                    <input type="hidden" name="cetak_kuitansi_uang_lain" value="0">

                                                    <input type="hidden" name="cetak_kuitansi_ket_uang_spp" value="<?= ($data['SPP_txt'] == NULL) ? ('-') : ($data['SPP_txt']); ?>">
                                                    <input type="hidden" name="cetak_kuitansi_ket_uang_pangkal" value="">
                                                    <input type="hidden" name="cetak_kuitansi_ket_uang_kegiatan" value="">
                                                    <input type="hidden" name="cetak_kuitansi_ket_uang_buku" value="">
                                                    <input type="hidden" name="cetak_kuitansi_ket_uang_seragam" value="">
                                                    <input type="hidden" name="cetak_kuitansi_ket_uang_registrasi" value="">
                                                    <input type="hidden" name="cetak_kuitansi_ket_uang_lain" value="">

                                                    <input type="hidden" name="jenisPembayaranSPP" value="<?= $data['SPP']; ?>">
                                                    <input type="hidden" name="jenisPembayaranPangkal" value="0">
                                                    <input type="hidden" name="jenisPembayaranKegiatan" value="0">
                                                    <input type="hidden" name="jenisPembayaranBuku" value="0">
                                                    <input type="hidden" name="jenisPembayaranSeragam" value="0">
                                                    <input type="hidden" name="jenisPembayaranRegistrasi" value="0">
                                                    <input type="hidden" name="jenisPembayaranLain" value="0">

                                                    <button type="submit" id="slip_kuitansi" name="slip_kuitansi" class="btn btn-sm btn-success btn-circle"> 
                                                        Slip Kuitansi 
                                                        <span class="glyphicon glyphicon-print"> 
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

                            <form action="checkpembayaran" method="post">
                                <input type="hidden" name="backPage" value="<?= $halamanAktif - 1; ?>">
                                <button name="previousPage">
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

                                <form action="checkpembayaran" method="post">
                                    <input type="hidden" name="halamanKeFilterSPP" value="<?= $i; ?>">
                                    <input type="hidden" name="iniFilterSPP" value="<?= $_POST['isi_filter']; ?>">
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
                            
                            <form action="checkpembayaran" method="post">
                                <input type="hidden" name="halamanLanjutFilterSPP" value="<?= $halamanAktif + 1; ?>">
                                <input type="hidden" name="iniFilterSPP" value="<?= $_POST['isi_filter']; ?>">
                                <input type="hidden" name="idSiswaFilterSPP" value="<?= $id; ?>">
                                <input type="hidden" name="namaSiswaFilterSPP" value="<?= $namaMurid; ?>">
                                <input type="hidden" name="nisFormFilterSPP" value="<?= $nis; ?>">
                                <input type="hidden" name="kelasFormFilterSPP" value="<?= $kelas; ?>">
                                <input type="hidden" name="namaFormFilterSPP" value="<?= $namaMurid; ?>">
                                <input type="hidden" name="panggilanFormFilterSPP" value="<?= $panggilan; ?>">
                                <button name="nextPageJustFilterSPP" id="nextPage" data-nextpage="<?= $halamanAktif + 1; ?>">
                                    next
                                    &raquo;
                                </button>
                            </form>

                        <?php endif; ?>

                    </div>

                    <div style="margin-left: 3px; padding: 5px; display: flex; gap: 5px; justify-content: center;">

                        <?php if ($halamanAktif > 1): ?>

                            <form action="checkpembayaran" method="post">
                                <input type="hidden" name="backPage" value="<?= $halamanAktif - 1; ?>">
                                <button name="previousPage">
                                    &laquo;
                                    First Page
                                </button>
                            </form>
                        <?php endif; ?>        

                        <?php if ($hitungDataFilterSPP <= 5): ?>
                        <?php else: ?>
                            
                            <form action="checkpembayaran" method="post">
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

                <?php endif; ?>

            <?php endif; ?>

        <?php else: ?>
            
            <?php  

                $_SESSION['form_success'] = "form_empty";

            ?>

        <?php endif; ?>

    <?php endif; ?>
        
</div>

<div id="modalEditData" class="modal"  data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel"> <i class="glyphicon glyphicon-calendar"></i> Data Siswa</h4>
            </div>
            <div class="modal-body"> 
                <div class="box-body table-responsive">
                    <table id="example1x" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                              <!-- <th style="text-align: center;" width="3%">NO</th> -->
                              <th style="text-align: center; width: 5%;">NIS</th>
                              <th style="text-align: center;">NAMA</th>
                              <th style="text-align: center;">KELAS</th>
                            </tr>
                        </thead>
                        <tbody>
                        	<?php foreach ($dataSiswa as $siswa): ?>
	                            <tr onclick="OnSiswaSelectedModal(
	                            	`<?= $siswa['ID']; ?>`,
                                    `<?= $siswa['NIS']; ?>`,
                                    `<?= $siswa['Nama']; ?>`,
                                    `<?= $siswa['KELAS']; ?>`,
                                    `<?= $siswa['Panggilan']; ?>`,
	                            )">
	                            <?php  

	                            	$no = 1;

	                            ?>
	                                <!-- <td style="text-align: center;"> <?= $no++; ?> </td> -->
	                                <td style="text-align: center;"> <?= $siswa['NIS']; ?> </td>
	                                <td style="text-align: center;"> <?= $siswa['Nama']; ?> </td>
	                                <td style="text-align: center;"> <?= $siswa['KELAS']; ?> </td>
                            		
                            	</tr>
                        	<?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>    
</div>

<script type="text/javascript">
	$(document).ready(function(){

		$("#list_spp").click();
	    $("#edit_data").css({
	        "background-color" : "#ccc",
	        "color" : "black"
	    });

	})

	function OpenCarisiswaModal(){
        $('#modalEditData').modal("show");
    }

    function OnSiswaSelectedModal(id, nis, nmsiswa, kelas, panggilan){

        // alert(nmsiswa)

        $('#form_edit_id_siswa').val(id);
        $('#form_edit_nis_siswa').val(nis);
        $('#form_edit_nama_siswa').val(nmsiswa);
        $('#form_edit_kelas_siswa').val(kelas);
        $('#form_edit_panggilan_siswa').val(panggilan)

        $('#modalEditData').modal("hide");
    }

</script>