<?php  

	$filter_by['isifilter_by'] = [
        'SPP',
        'PANGKAL',
        'KEGIATAN',
        'BUKU',
        'SERAGAM',
        'REGISTRASI',
        'LAIN'
    ];

    $data_bulan = [
        'JANUARI',
        'FEBRUARI',
        'MARET',
        'APRIL',
        'MEI',
        'JUNI',
        'JULI',
        'AGUSTUS',
        'SEPTEMBER',
        'OKTOBER',
        'NOVEMBER',
        'DESEMBER'
    ];

    $ops_tx = [
        'TRANSFER',
        'CASH'
    ];

    $isifilby       = 'kosong';
    $tanggalDari    = 'kosong_tgl1';
    $tanggalSampai  = 'kosong_tgl2';

     function rupiah($angka){
    
        $hasil_rupiah = "Rp " . number_format($angka,2,',','.');
        return $hasil_rupiah;
     
    }

    function rupiahFormat($angkax){
    
        $hasil_rupiahx = "Rp " . number_format($angkax,0,'.',',');
        return $hasil_rupiahx;
     
    }

    $setSesiPageFilterBy = 0; 
    $setSesiFormEdit     = 0;

    $nominalBayarSPP        = 0;
    $nominalBayarPangkal    = 0;
    $nominalBayarKegiatan   = 0;
    $nominalBayarBuku       = 0;
    $nominalBayarSeragam    = 0;
    $nominalBayarRegistrasi = 0;
    $nominalBayarLain       = 0;

    $ketPembayaranSPP           = NULL;
    $ketPembayaranPangkal       = NULL;
    $ketPembayaranKegiatan      = NULL;
    $ketPembayaranBuku          = NULL;
    $ketPembayaranSeragam       = NULL;
    $ketPembayaranRegistrasi    = NULL;
    $ketPembayaranLain          = NULL;

    $iniScrollNextPage      = "kosong";
    $iniScrollPreviousPage  = "kosong";
    $iniScrollToPage        = "kosong";
    $iniScrollFirstPage     = "kosong";
    $iniScrollLastPage      = "kosong";
    $iniScrollBackSave      = "kosong";

    $currentPage        = 0;

    if ($_SESSION['c_accounting'] == 'accounting1') {

        // Data Modal Siswa
    	$dataSiswa = mysqli_query($con, "SELECT * FROM data_murid_sd");	

        $halamanAktif = 1;

        $jumlahData = 5;
        $totalData = mysqli_num_rows($dataSiswa);

        $jumlahPagination = ceil($totalData / $jumlahData);

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

        $halamanAktif = 1;

        // echo "TK";exit;

        $jumlahData = 5;
        $totalData = mysqli_num_rows($dataSiswa);

        $jumlahPagination = ceil($totalData / $jumlahData);

        $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;
        // echo $dataAwal . "<br>";
        $ambildata_perhalaman = mysqli_query($con, "SELECT * FROM input_data_tk ORDER BY ID DESC LIMIT $dataAwal, $jumlahData  ");
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

    }

    // Jika Ada Tombol Filter di klik
    if (isset($_POST['filter_by_edit'])) {

        $id         = $_POST['id_siswa'];
        $nis        = $_POST['nis_siswa'];
        $namaSiswa  = $_POST['nama_siswa'];
        $kelas      = $_POST['kelas_siswa'];
        $panggilan  = $_POST['panggilan_siswa'];

        if ($id != '' && $nis != '' && $namaSiswa != '' && $kelas != '' && $panggilan != '') {

            if ($_POST['isi_filter_edit'] != 'kosong') {

                $dariTanggal    = $_POST['tanggal1'] . " 00:00:00";
                $sampaiTanggal  = $_POST['tanggal2'] . " 23:59:59";

                // Data SPP
                if ($_POST['isi_filter_edit'] == 'SPP') {

                    $setSesiPageFilterBy = 1;
                    $isifilby = $_POST['isi_filter_edit'];

                } 
                // Akhir Data SPP

                // Data PANGKAL
                else if ($_POST['isi_filter_edit'] == 'PANGKAL') {

                    $setSesiPageFilterBy = 2;
                    $isifilby = $_POST['isi_filter_edit'];

                    $namaMurid = $namaSiswa;
                    $queryGetDataPANGKAL = "
                    SELECT ID, NIS, NAMA, kelas, PANGKAL, BULAN AS pembayaran_bulan, PANGKAL_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                    FROM input_data_sd
                    WHERE
                    PANGKAL != 0
                    AND NAMA LIKE '%$namaMurid%' ";
                    $execQueryDataPANGKAL    = mysqli_query($con, $queryGetDataPANGKAL);
                    $hitungDataFilterPANGKAL = mysqli_num_rows($execQueryDataPANGKAL);
                    // echo $hitungDataFilterPANGKAL;

                    $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;
                    // echo $dataAwal . "<br>";
                    $ambildata_perhalaman = mysqli_query($con, "
                        SELECT ID, NIS, NAMA, DATE, kelas, PANGKAL, TRANSAKSI, BULAN AS pembayaran_bulan, PANGKAL_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                        FROM input_data_sd
                        WHERE
                        PANGKAL != 0
                        AND NAMA LIKE '%$namaMurid%' 
                        ORDER BY ID DESC
                        LIMIT $dataAwal, $jumlahData");
                    // print_r($ambildata_perhalaman->num_rows);
                    $jumlahPagination = ceil($hitungDataFilterPANGKAL / $jumlahData);

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
                // Akhir Data Pangkal

            } else {

                $setSesiPageFilterBy = -1;
                // echo $setSesiPageFilterBy;exit;
                $_SESSION['filter'] = false;
                $id         = $_POST['id_siswa'];
                $nis        = $_POST['nis_siswa'];
                $namaSiswa  = $_POST['nama_siswa'];
                $kelas      = $_POST['kelas_siswa'];
                $panggilan  = $_POST['panggilan_siswa'];
                // echo $namaSiswa . " Woy";exit;

            }

        } else {

            $_SESSION['form_success'] = "form_empty";

        }

    } 

    // Jika Ada Tombol Edit Data di Klik
    elseif (isset($_POST['edit_data'])) {

        $id_siswa   = $_POST['id_siswa'];
        $nis        = $_POST['nis_siswa'];
        $namaSiswa  = $_POST['nama_siswa'];
        $kelas      = $_POST['kelas_siswa'];
        $panggilan  = $_POST['panggilan_siswa'];

        $typeFilter         = $_POST['isi_filter'];
        $idInvoice          = "";
        $tglPembayaran      = "";
        $pembayaranBulan    = "";
        $nominalBayar       = "";
        $ketPembayaran      = "";
        $pembayaranVIA      = "";

        $currentPage        = $_POST['currentPage'];

        if ($typeFilter == 'SPP') {

            $setSesiFormEdit    = 1;

            $idInvoice          = $_POST['id_invoice'];
            $tglPembayaran      = $_POST['tgl_bukti_pembayaran'];
            $tglPembayaran      = str_replace([" 00:00:00"], "", $tglPembayaran);

            $pembayaranBulan    = substr($_POST['pembayaran_bulan'], 0, -5);
            $tahunBayar         = substr($_POST['pembayaran_bulan'], -4);
            $nominalBayar       = $_POST['nominal_bayar'];
            $ketPembayaran      = $_POST['ket_pembayaran'];
            $pembayaranVIA      = $_POST['tipe_transaksi'];

            $isifilby = $typeFilter;

        }


        // echo "Ada edit";exit;
    }

    // Jika Ada Tombol Simpan Edit Data
    elseif (isset($_POST['simpan_edit_data'])) {

        $id   = $_POST['data_id_siswa'];
        $nis        = $_POST['data_nis_siswa'];
        $namaSiswa  = $_POST['data_nama_siswa'];
        $kelas      = $_POST['data_kelas_siswa'];
        $panggilan  = $_POST['data_panggilan_siswa'];

        $idInvoice       = $_POST['idInvoice'];
        $currentFilter   = $_POST['currentFilter'];
        $typeFilter      = htmlspecialchars($_POST['isi_filter_edit']);

        $dariTanggal    = " 00:00:00";
        $sampaiTanggal  = " 23:59:59";

        $halamanAktif   = $_POST['currentPage'];

        $iniScrollBackSave  = "ada";

        $tglPembayaranDB    = $_POST['tglPembayaran'] . " 00:00:00";
        $pembayaranBulanDB  = $_POST['bulan_pembayaran'] . " " . $_POST['tahunBayar'];

        $pembayaranBulan    = substr($pembayaranBulanDB, 0, -5);
        $tahunBayar         = substr($pembayaranBulanDB, -4);

        $tglPembayaran      = $_POST['tglPembayaran'];
        $tglPembayaran      = str_replace([" 00:00:00"], "", $tglPembayaran);

        $pembayaranVIA   = htmlspecialchars($_POST['payment_via']);
        $data_stamp      = date("Y-m-d H:i:s");

        $tanggalDari;
        $tanggalSampai;

        if ($_SESSION['c_accounting'] == 'accounting1') {

            switch ($typeFilter) {
                case "SPP" :
                    $nominalBayarSPP        = str_replace(["Rp. ", "."], "", $_POST['nominalBayar']);
                    $ketPembayaranSPP       = htmlspecialchars($_POST['ketPembayaran']);

                    $nominalBayarPangkal;
                    $ketPembayaranPangkal;

                    $nominalBayarKegiatan;
                    $ketPembayaranKegiatan;

                    $nominalBayarBuku;
                    $ketPembayaranBuku;

                    $nominalBayarSeragam;
                    $ketPembayaranSeragam;

                    $nominalBayarRegistrasi;
                    $ketPembayaranRegistrasi;

                    $nominalBayarLain;
                    $ketPembayaranLain;

                    $queryUpdate = "
                        UPDATE `u415776667_spp`.`input_data_sd` 
                        SET 
                        `DATE`='$tglPembayaranDB', 
                        `BULAN`='$pembayaranBulanDB', 
                        `SPP`='$nominalBayarSPP', 
                        `SPP_txt`='$ketPembayaranSPP', 
                        `PANGKAL`='$nominalBayarPangkal',
                        `PANGKAL_txt`=NULL,
                        `KEGIATAN`='$nominalBayarKegiatan', 
                        `KEGIATAN_txt`=NULL,
                        `BUKU`='$nominalBayarBuku',
                        `BUKU_txt`=NULL,
                        `SERAGAM`='$nominalBayarSeragam',
                        `SERAGAM_txt`=NULL,
                        `REGISTRASI`='$nominalBayarRegistrasi',
                        `REGISTRASI_txt`=NULL,
                        `LAIN`='$nominalBayarLain',
                        `LAIN_txt`=NULL,
                        `TRANSAKSI`='$pembayaranVIA',
                        `STAMP`='$data_stamp'
                        WHERE  `ID`= '$idInvoice'
                    ";

                    mysqli_query($con, $queryUpdate);
                    $_SESSION['form_success'] = "data_update";
                    $setSesiPageFilterBy = 1;
                    if ($currentFilter != $typeFilter) {
                        $isifilby = $currentFilter;
                    } else if ($currentFilter == $typeFilter) {
                        $isifilby = $typeFilter;
                    }
                    $nominalBayar       = rupiahFormat($nominalBayarSPP);
                    $ketPembayaran      = $ketPembayaranSPP;

                    break;
                case 'PANGKAL':
                    $nominalBayarSPP;
                    $ketPembayaranSPP;

                    $nominalBayarPangkal    = str_replace(["Rp. ", "."], "", $_POST['nominalBayar']);
                    $ketPembayaranPangkal   = htmlspecialchars($_POST['ketPembayaran']);

                    $nominalBayarKegiatan;
                    $ketPembayaranKegiatan;

                    $nominalBayarBuku;
                    $ketPembayaranBuku;

                    $nominalBayarSeragam;
                    $ketPembayaranSeragam;

                    $nominalBayarRegistrasi;
                    $ketPembayaranRegistrasi;

                    $nominalBayarLain;
                    $ketPembayaranLain;

                    $queryUpdate = "
                        UPDATE `u415776667_spp`.`input_data_sd` 
                        SET 
                        `DATE`='$tglPembayaranDB', 
                        `BULAN`='$pembayaranBulanDB', 
                        `SPP`='$nominalBayarSPP', 
                        `SPP_txt`=NULL, 
                        `PANGKAL`='$nominalBayarPangkal',
                        `PANGKAL_txt`='$ketPembayaranPangkal',
                        `KEGIATAN`='$nominalBayarKegiatan', 
                        `KEGIATAN_txt`=NULL,
                        `BUKU`='$nominalBayarBuku',
                        `BUKU_txt`=NULL,
                        `SERAGAM`='$nominalBayarSeragam',
                        `SERAGAM_txt`=NULL,
                        `REGISTRASI`='$nominalBayarRegistrasi',
                        `REGISTRASI_txt`=NULL,
                        `LAIN`='$nominalBayarLain',
                        `LAIN_txt`=NULL,
                        `TRANSAKSI`='$pembayaranVIA',
                        `STAMP`='$data_stamp'
                        WHERE  `ID`= '$idInvoice'
                    ";

                    mysqli_query($con, $queryUpdate);
                    $_SESSION['form_success'] = "data_update";
                    $setSesiPageFilterBy = 1;
                    if ($currentFilter != $typeFilter) {
                        $isifilby = $currentFilter;
                    } else if ($currentFilter == $typeFilter) {
                        $isifilby = $typeFilter;
                    }
                    $nominalBayar       = rupiahFormat($nominalBayarPangkal);
                    $ketPembayaran      = $ketPembayaranPangkal;
                    break;
                case 'KEGIATAN':
                    $nominalBayarSPP;
                    $ketPembayaranSPP;

                    $nominalBayarPangkal;
                    $ketPembayaranPangkal;

                    $nominalBayarKegiatan   = str_replace(["Rp. ", "."], "", $_POST['nominalBayar']);
                    $ketPembayaranKegiatan  = htmlspecialchars($_POST['ketPembayaran']);

                    $nominalBayarBuku;
                    $ketPembayaranBuku;

                    $nominalBayarSeragam;
                    $ketPembayaranSeragam;

                    $nominalBayarRegistrasi;
                    $ketPembayaranRegistrasi;

                    $nominalBayarLain;
                    $ketPembayaranLain;

                    $queryUpdate = "
                        UPDATE `u415776667_spp`.`input_data_sd` 
                        SET 
                        `DATE`='$tglPembayaranDB', 
                        `BULAN`='$pembayaranBulanDB', 
                        `SPP`='$nominalBayarSPP', 
                        `SPP_txt`=NULL, 
                        `PANGKAL`='$nominalBayarPangkal',
                        `PANGKAL_txt`=NULL,
                        `KEGIATAN`='$nominalBayarKegiatan', 
                        `KEGIATAN_txt`='$ketPembayaranKegiatan',
                        `BUKU`='$nominalBayarBuku',
                        `BUKU_txt`=NULL,
                        `SERAGAM`='$nominalBayarSeragam',
                        `SERAGAM_txt`=NULL,
                        `REGISTRASI`='$nominalBayarRegistrasi',
                        `REGISTRASI_txt`=NULL,
                        `LAIN`='$nominalBayarLain',
                        `LAIN_txt`=NULL,
                        `TRANSAKSI`='$pembayaranVIA',
                        `STAMP`='$data_stamp'
                        WHERE  `ID`= '$idInvoice'
                    ";

                    mysqli_query($con, $queryUpdate);
                    $_SESSION['form_success'] = "data_update";
                    $setSesiPageFilterBy = 1;
                    if ($currentFilter != $typeFilter) {
                        $isifilby = $currentFilter;
                    } else if ($currentFilter == $typeFilter) {
                        $isifilby = $typeFilter;
                    }
                    $nominalBayar       = rupiahFormat($nominalBayarKegiatan);
                    $ketPembayaran      = $ketPembayaranKegiatan;
                    break;
                case 'BUKU':
                    $nominalBayarSPP;
                    $ketPembayaranSPP;

                    $nominalBayarPangkal;
                    $ketPembayaranPangkal;

                    $nominalBayarKegiatan;
                    $ketPembayaranKegiatan;

                    $nominalBayarBuku   = str_replace(["Rp. ", "."], "", $_POST['nominalBayar']);
                    $ketPembayaranBuku  = htmlspecialchars($_POST['ketPembayaran']);

                    $nominalBayarSeragam;
                    $ketPembayaranSeragam;

                    $nominalBayarRegistrasi;
                    $ketPembayaranRegistrasi;

                    $nominalBayarLain;
                    $ketPembayaranLain;

                    $queryUpdate = "
                        UPDATE `u415776667_spp`.`input_data_sd` 
                        SET 
                        `DATE`='$tglPembayaranDB', 
                        `BULAN`='$pembayaranBulanDB', 
                        `SPP`='$nominalBayarSPP', 
                        `SPP_txt`=NULL, 
                        `PANGKAL`='$nominalBayarPangkal',
                        `PANGKAL_txt`=NULL,
                        `KEGIATAN`='$nominalBayarKegiatan', 
                        `KEGIATAN_txt`=NULL,
                        `BUKU`='$nominalBayarBuku',
                        `BUKU_txt`='$ketPembayaranBuku',
                        `SERAGAM`='$nominalBayarSeragam',
                        `SERAGAM_txt`=NULL,
                        `REGISTRASI`='$nominalBayarRegistrasi',
                        `REGISTRASI_txt`=NULL,
                        `LAIN`='$nominalBayarLain',
                        `LAIN_txt`=NULL,
                        `TRANSAKSI`='$pembayaranVIA',
                        `STAMP`='$data_stamp'
                        WHERE  `ID`= '$idInvoice'
                    ";

                    mysqli_query($con, $queryUpdate);
                    $_SESSION['form_success'] = "data_update";
                    $setSesiPageFilterBy = 1;
                    if ($currentFilter != $typeFilter) {
                        $isifilby = $currentFilter;
                    } else if ($currentFilter == $typeFilter) {
                        $isifilby = $typeFilter;
                    }
                    $nominalBayar       = rupiahFormat($nominalBayarBuku);
                    $ketPembayaran      = $ketPembayaranBuku;
                    break;
                case 'SERAGAM':
                    $nominalBayarSPP;
                    $ketPembayaranSPP;

                    $nominalBayarPangkal;
                    $ketPembayaranPangkal;

                    $nominalBayarKegiatan;
                    $ketPembayaranKegiatan;

                    $nominalBayarBuku;
                    $ketPembayaranBuku;

                    $nominalBayarSeragam   = str_replace(["Rp. ", "."], "", $_POST['nominalBayar']);
                    $ketPembayaranSeragam  = htmlspecialchars($_POST['ketPembayaran']);

                    $nominalBayarRegistrasi;
                    $ketPembayaranRegistrasi;

                    $nominalBayarLain;
                    $ketPembayaranLain;

                    $queryUpdate = "
                        UPDATE `u415776667_spp`.`input_data_sd` 
                        SET 
                        `DATE`='$tglPembayaranDB', 
                        `BULAN`='$pembayaranBulanDB', 
                        `SPP`='$nominalBayarSPP', 
                        `SPP_txt`=NULL, 
                        `PANGKAL`='$nominalBayarPangkal',
                        `PANGKAL_txt`=NULL,
                        `KEGIATAN`='$nominalBayarKegiatan', 
                        `KEGIATAN_txt`=NULL,
                        `BUKU`='$nominalBayarBuku',
                        `BUKU_txt`=NULL,
                        `SERAGAM`='$nominalBayarSeragam',
                        `SERAGAM_txt`='$ketPembayaranSeragam',
                        `REGISTRASI`='$nominalBayarRegistrasi',
                        `REGISTRASI_txt`=NULL,
                        `LAIN`='$nominalBayarLain',
                        `LAIN_txt`=NULL,
                        `TRANSAKSI`='$pembayaranVIA',
                        `STAMP`='$data_stamp'
                        WHERE  `ID`= '$idInvoice'
                    ";

                    mysqli_query($con, $queryUpdate);
                    $_SESSION['form_success'] = "data_update";
                    $setSesiPageFilterBy = 1;
                    if ($currentFilter != $typeFilter) {
                        $isifilby = $currentFilter;
                    } else if ($currentFilter == $typeFilter) {
                        $isifilby = $typeFilter;
                    }
                    $nominalBayar       = rupiahFormat($nominalBayarSeragam);
                    $ketPembayaran      = $ketPembayaranSeragam;
                    break;
                case 'REGISTRASI':
                    $nominalBayarSPP;
                    $ketPembayaranSPP;

                    $nominalBayarPangkal;
                    $ketPembayaranPangkal;

                    $nominalBayarKegiatan;
                    $ketPembayaranKegiatan;

                    $nominalBayarBuku;
                    $ketPembayaranBuku;

                    $nominalBayarSeragam;
                    $ketPembayaranSeragam;

                    $nominalBayarRegistrasi   = str_replace(["Rp. ", "."], "", $_POST['nominalBayar']);
                    $ketPembayaranRegistrasi  = htmlspecialchars($_POST['ketPembayaran']);

                    $nominalBayarLain;
                    $ketPembayaranLain;

                    $queryUpdate = "
                        UPDATE `u415776667_spp`.`input_data_sd` 
                        SET 
                        `DATE`='$tglPembayaranDB', 
                        `BULAN`='$pembayaranBulanDB', 
                        `SPP`='$nominalBayarSPP', 
                        `SPP_txt`=NULL, 
                        `PANGKAL`='$nominalBayarPangkal',
                        `PANGKAL_txt`=NULL,
                        `KEGIATAN`='$nominalBayarKegiatan', 
                        `KEGIATAN_txt`=NULL,
                        `BUKU`='$nominalBayarBuku',
                        `BUKU_txt`=NULL,
                        `SERAGAM`='$nominalBayarSeragam',
                        `SERAGAM_txt`=NULL,
                        `REGISTRASI`='$nominalBayarRegistrasi',
                        `REGISTRASI_txt`='$ketPembayaranRegistrasi',
                        `LAIN`='$nominalBayarLain',
                        `LAIN_txt`=NULL,
                        `TRANSAKSI`='$pembayaranVIA',
                        `STAMP`='$data_stamp'
                        WHERE  `ID`= '$idInvoice'
                    ";

                    mysqli_query($con, $queryUpdate);
                    $_SESSION['form_success'] = "data_update";
                    $setSesiPageFilterBy = 1;
                    if ($currentFilter != $typeFilter) {
                        $isifilby = $currentFilter;
                    } else if ($currentFilter == $typeFilter) {
                        $isifilby = $typeFilter;
                    }
                    $nominalBayar       = rupiahFormat($nominalBayarRegistrasi);
                    $ketPembayaran      = $ketPembayaranRegistrasi;
                    break;
                case 'LAIN':
                    $nominalBayarSPP;
                    $ketPembayaranSPP;

                    $nominalBayarPangkal;
                    $ketPembayaranPangkal;

                    $nominalBayarKegiatan;
                    $ketPembayaranKegiatan;

                    $nominalBayarBuku;
                    $ketPembayaranBuku;

                    $nominalBayarSeragam;
                    $ketPembayaranSeragam;

                    $nominalBayarRegistrasi;
                    $ketPembayaranRegistrasi;

                    $nominalBayarLain   = str_replace(["Rp. ", "."], "", $_POST['nominalBayar']);
                    $ketPembayaranLain  = htmlspecialchars($_POST['ketPembayaran']);

                    $queryUpdate = "
                        UPDATE `u415776667_spp`.`input_data_sd` 
                        SET 
                        `DATE`='$tglPembayaranDB', 
                        `BULAN`='$pembayaranBulanDB', 
                        `SPP`='$nominalBayarSPP', 
                        `SPP_txt`=NULL, 
                        `PANGKAL`='$nominalBayarPangkal',
                        `PANGKAL_txt`=NULL,
                        `KEGIATAN`='$nominalBayarKegiatan', 
                        `KEGIATAN_txt`=NULL,
                        `BUKU`='$nominalBayarBuku',
                        `BUKU_txt`=NULL,
                        `SERAGAM`='$nominalBayarSeragam',
                        `SERAGAM_txt`=NULL,
                        `REGISTRASI`='$nominalBayarRegistrasi',
                        `REGISTRASI_txt`=NULL,
                        `LAIN`='$nominalBayarLain',
                        `LAIN_txt`='$ketPembayaranLain',
                        `TRANSAKSI`='$pembayaranVIA',
                        `STAMP`='$data_stamp'
                        WHERE  `ID`= '$idInvoice'
                    ";

                    mysqli_query($con, $queryUpdate);
                    $_SESSION['form_success'] = "data_update";
                    $setSesiPageFilterBy = 1;
                    if ($currentFilter != $typeFilter) {
                        $isifilby = $currentFilter;
                    } else if ($currentFilter == $typeFilter) {
                        $isifilby = $typeFilter;
                    }
                    $nominalBayar       = rupiahFormat($nominalBayarLain);
                    $ketPembayaran      = $ketPembayaranLain;
                    break;
            }

        } else {

            switch ($typeFilter) {
                case "SPP" :
                    $nominalBayarSPP        = str_replace(["Rp. ", "."], "", $_POST['nominalBayar']);
                    $ketPembayaranSPP       = htmlspecialchars($_POST['ketPembayaran']);
                    $nominalBayarPangkal;
                    $ketPembayaranPangkal;

                    $nominalBayarKegiatan;
                    $ketPembayaranKegiatan;

                    $nominalBayarBuku;
                    $ketPembayaranBuku;

                    $nominalBayarSeragam;
                    $ketPembayaranSeragam;

                    $nominalBayarRegistrasi;
                    $ketPembayaranRegistrasi;

                    $nominalBayarLain;
                    $ketPembayaranLain;

                    $queryUpdate = "
                        UPDATE `u415776667_spp`.`input_data_tk` 
                        SET 
                        `DATE`='$tglPembayaranDB', 
                        `BULAN`='$pembayaranBulanDB', 
                        `SPP`='$nominalBayarSPP', 
                        `SPP_txt`='$ketPembayaranSPP', 
                        `PANGKAL`='$nominalBayarPangkal',
                        `PANGKAL_txt`=NULL,
                        `KEGIATAN`='$nominalBayarKegiatan', 
                        `KEGIATAN_txt`=NULL,
                        `BUKU`='$nominalBayarBuku',
                        `BUKU_txt`=NULL,
                        `SERAGAM`='$nominalBayarSeragam',
                        `SERAGAM_txt`=NULL,
                        `REGISTRASI`='$nominalBayarRegistrasi',
                        `REGISTRASI_txt`=NULL,
                        `LAIN`='$nominalBayarLain',
                        `LAIN_txt`=NULL,
                        `TRANSAKSI`='$pembayaranVIA',
                        `STAMP`='$data_stamp'
                        WHERE `ID`= '$idInvoice'
                    ";

                    mysqli_query($con, $queryUpdate);
                    $_SESSION['form_success'] = "data_update";
                    $setSesiPageFilterBy = 1;
                    if ($currentFilter != $typeFilter) {
                        $isifilby = $currentFilter;
                    } else if ($currentFilter == $typeFilter) {
                        $isifilby = $typeFilter;
                    }
                    $nominalBayar       = $nominalBayarSPP;
                    $ketPembayaran      = $ketPembayaranSPP;
                    break;
                case 'PANGKAL':
                    $nominalBayarSPP;
                    $ketPembayaranSPP;

                    $nominalBayarPangkal    = str_replace(["Rp. ", "."], "", $_POST['nominalBayar']);
                    $ketPembayaranPangkal   = htmlspecialchars($_POST['ketPembayaran']);

                    $nominalBayarKegiatan;
                    $ketPembayaranKegiatan;

                    $nominalBayarBuku;
                    $ketPembayaranBuku;

                    $nominalBayarSeragam;
                    $ketPembayaranSeragam;

                    $nominalBayarRegistrasi;
                    $ketPembayaranRegistrasi;

                    $nominalBayarLain;
                    $ketPembayaranLain;

                    $queryUpdate = "
                        UPDATE `u415776667_spp`.`input_data_tk` 
                        SET 
                        `DATE`='$tglPembayaranDB', 
                        `BULAN`='$pembayaranBulanDB', 
                        `SPP`='$nominalBayarSPP', 
                        `SPP_txt`=NULL, 
                        `PANGKAL`='$nominalBayarPangkal',
                        `PANGKAL_txt`='$ketPembayaranPangkal',
                        `KEGIATAN`='$nominalBayarKegiatan', 
                        `KEGIATAN_txt`=NULL,
                        `BUKU`='$nominalBayarBuku',
                        `BUKU_txt`=NULL,
                        `SERAGAM`='$nominalBayarSeragam',
                        `SERAGAM_txt`=NULL,
                        `REGISTRASI`='$nominalBayarRegistrasi',
                        `REGISTRASI_txt`=NULL,
                        `LAIN`='$nominalBayarLain',
                        `LAIN_txt`=NULL,
                        `TRANSAKSI`='$pembayaranVIA',
                        `STAMP`='$data_stamp'
                        WHERE  `ID`= '$idInvoice'
                    ";

                    mysqli_query($con, $queryUpdate);
                    $_SESSION['form_success'] = "data_update";
                    $setSesiPageFilterBy = 1;
                    if ($currentFilter != $typeFilter) {
                        $isifilby = $currentFilter;
                    } else if ($currentFilter == $typeFilter) {
                        $isifilby = $typeFilter;
                    }
                    $nominalBayar       = rupiahFormat($nominalBayarPangkal);
                    $ketPembayaran      = $ketPembayaranPangkal;
                    break;
                case 'KEGIATAN':
                    $nominalBayarSPP;
                    $ketPembayaranSPP;

                    $nominalBayarPangkal;
                    $ketPembayaranPangkal;

                    $nominalBayarKegiatan   = str_replace(["Rp. ", "."], "", $_POST['nominalBayar']);
                    $ketPembayaranKegiatan  = htmlspecialchars($_POST['ketPembayaran']);

                    $nominalBayarBuku;
                    $ketPembayaranBuku;

                    $nominalBayarSeragam;
                    $ketPembayaranSeragam;

                    $nominalBayarRegistrasi;
                    $ketPembayaranRegistrasi;

                    $nominalBayarLain;
                    $ketPembayaranLain;

                    $queryUpdate = "
                        UPDATE `u415776667_spp`.`input_data_tk` 
                        SET 
                        `DATE`='$tglPembayaranDB', 
                        `BULAN`='$pembayaranBulanDB', 
                        `SPP`='$nominalBayarSPP', 
                        `SPP_txt`=NULL, 
                        `PANGKAL`='$nominalBayarPangkal',
                        `PANGKAL_txt`=NULL,
                        `KEGIATAN`='$nominalBayarKegiatan', 
                        `KEGIATAN_txt`='$ketPembayaranKegiatan',
                        `BUKU`='$nominalBayarBuku',
                        `BUKU_txt`=NULL,
                        `SERAGAM`='$nominalBayarSeragam',
                        `SERAGAM_txt`=NULL,
                        `REGISTRASI`='$nominalBayarRegistrasi',
                        `REGISTRASI_txt`=NULL,
                        `LAIN`='$nominalBayarLain',
                        `LAIN_txt`=NULL,
                        `TRANSAKSI`='$pembayaranVIA',
                        `STAMP`='$data_stamp'
                        WHERE  `ID`= '$idInvoice'
                    ";

                    mysqli_query($con, $queryUpdate);
                    $_SESSION['form_success'] = "data_update";
                    $setSesiPageFilterBy = 1;
                    if ($currentFilter != $typeFilter) {
                        $isifilby = $currentFilter;
                    } else if ($currentFilter == $typeFilter) {
                        $isifilby = $typeFilter;
                    }
                    $nominalBayar       = rupiahFormat($nominalBayarKegiatan);
                    $ketPembayaran      = $ketPembayaranKegiatan;
                    break;
                case 'BUKU':
                    $nominalBayarSPP;
                    $ketPembayaranSPP;

                    $nominalBayarPangkal;
                    $ketPembayaranPangkal;

                    $nominalBayarKegiatan;
                    $ketPembayaranKegiatan;

                    $nominalBayarBuku   = str_replace(["Rp. ", "."], "", $_POST['nominalBayar']);
                    $ketPembayaranBuku  = htmlspecialchars($_POST['ketPembayaran']);

                    $nominalBayarSeragam;
                    $ketPembayaranSeragam;

                    $nominalBayarRegistrasi;
                    $ketPembayaranRegistrasi;

                    $nominalBayarLain;
                    $ketPembayaranLain;

                    $queryUpdate = "
                        UPDATE `u415776667_spp`.`input_data_tk` 
                        SET 
                        `DATE`='$tglPembayaranDB', 
                        `BULAN`='$pembayaranBulanDB', 
                        `SPP`='$nominalBayarSPP', 
                        `SPP_txt`=NULL, 
                        `PANGKAL`='$nominalBayarPangkal',
                        `PANGKAL_txt`=NULL,
                        `KEGIATAN`='$nominalBayarKegiatan', 
                        `KEGIATAN_txt`=NULL,
                        `BUKU`='$nominalBayarBuku',
                        `BUKU_txt`='$ketPembayaranBuku',
                        `SERAGAM`='$nominalBayarSeragam',
                        `SERAGAM_txt`=NULL,
                        `REGISTRASI`='$nominalBayarRegistrasi',
                        `REGISTRASI_txt`=NULL,
                        `LAIN`='$nominalBayarLain',
                        `LAIN_txt`=NULL,
                        `TRANSAKSI`='$pembayaranVIA',
                        `STAMP`='$data_stamp'
                        WHERE  `ID`= '$idInvoice'
                    ";

                    mysqli_query($con, $queryUpdate);
                    $_SESSION['form_success'] = "data_update";
                    $setSesiPageFilterBy = 1;
                    
                    if ($currentFilter != $typeFilter) {
                        $isifilby = $currentFilter;
                    } else if ($currentFilter == $typeFilter) {
                        $isifilby = $typeFilter;
                    }
                    $nominalBayar       = rupiahFormat($nominalBayarBuku);
                    $ketPembayaran      = $ketPembayaranBuku;
                    break;
                case 'SERAGAM':
                    $nominalBayarSPP;
                    $ketPembayaranSPP;

                    $nominalBayarPangkal;
                    $ketPembayaranPangkal;

                    $nominalBayarKegiatan;
                    $ketPembayaranKegiatan;

                    $nominalBayarBuku;
                    $ketPembayaranBuku;

                    $nominalBayarSeragam   = str_replace(["Rp. ", "."], "", $_POST['nominalBayar']);
                    $ketPembayaranSeragam  = htmlspecialchars($_POST['ketPembayaran']);

                    $nominalBayarRegistrasi;
                    $ketPembayaranRegistrasi;

                    $nominalBayarLain;
                    $ketPembayaranLain;

                    $queryUpdate = "
                        UPDATE `u415776667_spp`.`input_data_tk` 
                        SET 
                        `DATE`='$tglPembayaranDB', 
                        `BULAN`='$pembayaranBulanDB', 
                        `SPP`='$nominalBayarSPP', 
                        `SPP_txt`=NULL, 
                        `PANGKAL`='$nominalBayarPangkal',
                        `PANGKAL_txt`=NULL,
                        `KEGIATAN`='$nominalBayarKegiatan', 
                        `KEGIATAN_txt`=NULL,
                        `BUKU`='$nominalBayarBuku',
                        `BUKU_txt`=NULL,
                        `SERAGAM`='$nominalBayarSeragam',
                        `SERAGAM_txt`='$ketPembayaranSeragam',
                        `REGISTRASI`='$nominalBayarRegistrasi',
                        `REGISTRASI_txt`=NULL,
                        `LAIN`='$nominalBayarLain',
                        `LAIN_txt`=NULL,
                        `TRANSAKSI`='$pembayaranVIA',
                        `STAMP`='$data_stamp'
                        WHERE  `ID`= '$idInvoice'
                    ";

                    mysqli_query($con, $queryUpdate);
                    $_SESSION['form_success'] = "data_update";
                    $setSesiPageFilterBy = 1;
                    if ($currentFilter != $typeFilter) {
                        $isifilby = $currentFilter;
                    } else if ($currentFilter == $typeFilter) {
                        $isifilby = $typeFilter;
                    }
                    $nominalBayar       = rupiahFormat($nominalBayarSeragam);
                    $ketPembayaran      = $ketPembayaranSeragam;
                    break;
                case 'REGISTRASI':
                    $nominalBayarSPP;
                    $ketPembayaranSPP;

                    $nominalBayarPangkal;
                    $ketPembayaranPangkal;

                    $nominalBayarKegiatan;
                    $ketPembayaranKegiatan;

                    $nominalBayarBuku;
                    $ketPembayaranBuku;

                    $nominalBayarSeragam;
                    $ketPembayaranSeragam;

                    $nominalBayarRegistrasi   = str_replace(["Rp. ", "."], "", $_POST['nominalBayar']);
                    $ketPembayaranRegistrasi  = htmlspecialchars($_POST['ketPembayaran']);

                    $nominalBayarLain;
                    $ketPembayaranLain;

                    $queryUpdate = "
                        UPDATE `u415776667_spp`.`input_data_tk` 
                        SET 
                        `DATE`='$tglPembayaranDB', 
                        `BULAN`='$pembayaranBulanDB', 
                        `SPP`='$nominalBayarSPP', 
                        `SPP_txt`=NULL, 
                        `PANGKAL`='$nominalBayarPangkal',
                        `PANGKAL_txt`=NULL,
                        `KEGIATAN`='$nominalBayarKegiatan', 
                        `KEGIATAN_txt`=NULL,
                        `BUKU`='$nominalBayarBuku',
                        `BUKU_txt`=NULL,
                        `SERAGAM`='$nominalBayarSeragam',
                        `SERAGAM_txt`=NULL,
                        `REGISTRASI`='$nominalBayarRegistrasi',
                        `REGISTRASI_txt`='$ketPembayaranRegistrasi',
                        `LAIN`='$nominalBayarLain',
                        `LAIN_txt`=NULL,
                        `TRANSAKSI`='$pembayaranVIA',
                        `STAMP`='$data_stamp'
                        WHERE  `ID`= '$idInvoice'
                    ";

                    mysqli_query($con, $queryUpdate);
                    $_SESSION['form_success'] = "data_update";
                    $setSesiPageFilterBy = 1;
                    if ($currentFilter != $typeFilter) {
                        $isifilby = $currentFilter;
                    } else if ($currentFilter == $typeFilter) {
                        $isifilby = $typeFilter;
                    }
                    $nominalBayar       = rupiahFormat($nominalBayarRegistrasi);
                    $ketPembayaran      = $ketPembayaranRegistrasi;
                    break;
                case 'LAIN':
                    $nominalBayarSPP;
                    $ketPembayaranSPP;

                    $nominalBayarPangkal;
                    $ketPembayaranPangkal;

                    $nominalBayarKegiatan;
                    $ketPembayaranKegiatan;

                    $nominalBayarBuku;
                    $ketPembayaranBuku;

                    $nominalBayarSeragam;
                    $ketPembayaranSeragam;

                    $nominalBayarRegistrasi;
                    $ketPembayaranRegistrasi;

                    $nominalBayarLain   = str_replace(["Rp. ", "."], "", $_POST['nominalBayar']);
                    $ketPembayaranLain  = htmlspecialchars($_POST['ketPembayaran']);

                    $queryUpdate = "
                        UPDATE `u415776667_spp`.`input_data_tk` 
                        SET 
                        `DATE`='$tglPembayaranDB', 
                        `BULAN`='$pembayaranBulanDB', 
                        `SPP`='$nominalBayarSPP', 
                        `SPP_txt`=NULL, 
                        `PANGKAL`='$nominalBayarPangkal',
                        `PANGKAL_txt`=NULL,
                        `KEGIATAN`='$nominalBayarKegiatan', 
                        `KEGIATAN_txt`=NULL,
                        `BUKU`='$nominalBayarBuku',
                        `BUKU_txt`=NULL,
                        `SERAGAM`='$nominalBayarSeragam',
                        `SERAGAM_txt`=NULL,
                        `REGISTRASI`='$nominalBayarRegistrasi',
                        `REGISTRASI_txt`=NULL,
                        `LAIN`='$nominalBayarLain',
                        `LAIN_txt`='$ketPembayaranLain',
                        `TRANSAKSI`='$pembayaranVIA',
                        `STAMP`='$data_stamp'
                        WHERE  `ID`= '$idInvoice'
                    ";

                    mysqli_query($con, $queryUpdate);
                    $_SESSION['form_success'] = "data_update";
                    $setSesiPageFilterBy = 1;
                    if ($currentFilter != $typeFilter) {
                        $isifilby = $currentFilter;
                    } else if ($currentFilter == $typeFilter) {
                        $isifilby = $typeFilter;
                    }
                    $nominalBayar       = rupiahFormat($nominalBayarLain);
                    $ketPembayaran      = $ketPembayaranLain;
                    break;
            }

        }

    }

    // Bagian Pagination
    elseif (isset($_POST['nextPageFilterSPP'])) {
        // echo "next pagefilter spp";exit;

        $halamanAktif       = $_POST['halamanLanjutFilterSPP'];
        $iniScrollNextPage  = "ada";

        $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

        $namaMurid  = $_POST['namaSiswaFilterSPP'];
        $isifilby   = $_POST['iniFilterSPP'];

        $id         = $_POST['idSiswaFilterSPP'];
        $kelas      = $_POST['kelasFormFilterSPP'];
        $panggilan  = $_POST['panggilanFormFilterSPP'];
        $nis        = $_POST['nisFormFilterSPP'];
        $namaSiswa  = $_POST['namaFormFilterSPP'];

        $dariTanggal    = " 00:00:00";
        $sampaiTanggal  = " 23:59:59";

        if ($_SESSION['c_accounting'] == 'accounting1') {

            $setSesiPageFilterBy = 1;

            $queryGetDataSPP = "
                SELECT ID, NIS, NAMA, kelas, SPP, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                SPP != 0
                AND NAMA LIKE '%$namaMurid%' 
            ";
            $execQueryDataSPP    = mysqli_query($con, $queryGetDataSPP);
            $hitungDataFilterSPP = mysqli_num_rows($execQueryDataSPP);

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

        } else {

            $setSesiPageFilterBy = 1;

             $queryGetDataSPP = "
                SELECT ID, NIS, NAMA, kelas, SPP, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                SPP != 0
                AND NAMA LIKE '%$namaMurid%' 
            ";
            $execQueryDataSPP    = mysqli_query($con, $queryGetDataSPP);
            $hitungDataFilterSPP = mysqli_num_rows($execQueryDataSPP);

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, SPP, TRANSAKSI, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
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

        }

    }

    elseif (isset($_POST['previousPageFilterSPP'])) {

        $halamanAktif           = $_POST['halamanSebelumnyaFilterSPP'];
        $iniScrollPreviousPage  = "ada";

        $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

        $namaMurid = $_POST['namaSiswaFilterSPP'];
        $isifilby  = $_POST['iniFilterSPP'];

        $id        = $_POST['idSiswaFilterSPP'];
        $nis       = $_POST['nisFormFilterSPP'];
        $namaSiswa = $_POST['namaFormFilterSPP'];
        $panggilan = $_POST['panggilanFormFilterSPP'];
        $kelas     = $_POST['kelasFormFilterSPP'];

        $dariTanggal    = " 00:00:00";
        $sampaiTanggal  = " 23:59:59";

        $iniScrollPreviousPage = "ada";

        if ($_SESSION['c_accounting'] == 'accounting1') {

            $setSesiPageFilterBy = 1;

            $queryGetDataSPP = "
                SELECT ID, NIS, NAMA, kelas, SPP, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                SPP != 0
                AND NAMA LIKE '%$namaMurid%' 
            ";
            $execQueryDataSPP    = mysqli_query($con, $queryGetDataSPP);
            $hitungDataFilterSPP = mysqli_num_rows($execQueryDataSPP);

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

        } else {

            $setSesiPageFilterBy = 1;

            $queryGetDataSPP = "
                SELECT ID, NIS, NAMA, kelas, SPP, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                SPP != 0
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataSPP    = mysqli_query($con, $queryGetDataSPP);
            $hitungDataFilterSPP = mysqli_num_rows($execQueryDataSPP);

            $setSesiPageFilterBy = 1;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, SPP, TRANSAKSI, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
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

        }

    }

    elseif (isset($_POST['toPageFilterSPP'])) {

        $halamanAktif = $_POST['halamanKeFilterSPP'];
        $iniScrollNextPage = "ada";

        $namaMurid = $_POST['namaSiswaFilterSPP'];
        $isifilby  = $_POST['iniFilterSPP'];

        $namaSiswa = $namaMurid;
        $id        = $_POST['idSiswaFilterSPP'];
        $nis       = $_POST['nisFormFilterSPP'];
        $panggilan = $_POST['panggilanFormFilterSPP'];
        $kelas     = $_POST['kelasFormFilterSPP'];

        $dariTanggal    = " 00:00:00";
        $sampaiTanggal  = " 23:59:59";

        $iniScrollToPage = "ada";

        if ($_SESSION['c_accounting'] == 'accounting1') {

            $setSesiPageFilterBy = 1;

            $queryGetDataSPP = "
                SELECT ID, NIS, NAMA, kelas, SPP, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                SPP != 0
                AND NAMA LIKE '%$namaMurid%' 
            ";
            $execQueryDataSPP    = mysqli_query($con, $queryGetDataSPP);
            $hitungDataFilterSPP = mysqli_num_rows($execQueryDataSPP);

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

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

        } else {
            
            $setSesiPageFilterBy = 1;
            
            $queryGetDataSPP = "
                SELECT ID, NIS, NAMA, kelas, SPP, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                SPP != 0
                AND NAMA LIKE '%$namaMurid%' 
            ";
            $execQueryDataSPP    = mysqli_query($con, $queryGetDataSPP);
            $hitungDataFilterSPP = mysqli_num_rows($execQueryDataSPP);

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, SPP, TRANSAKSI, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
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

        }

    }

    elseif(isset($_POST['lastPageFilterSPP'])) {

        $namaMurid      = $_POST['namaSiswaFilterSPP'];
        $isifilby       = $_POST['iniFilterSPP'];

        $id             = $_POST['idSiswaFilterSPP'];
        $namaSiswa      = $namaMurid;
        $kelas          = $_POST['kelasFormFilterSPP'];
        $panggilan      = $_POST['panggilanFormFilterSPP'];
        $nis            = $_POST['nisFormFilterSPP'];

        $dariTanggal    = " 00:00:00";
        $sampaiTanggal  = " 23:59:59";

        $iniScrollLastPage  = "ada";
        $setSesiPageFilterBy = 1;

        if ($_SESSION['c_accounting'] == 'accounting1') {

            $execQueryGetAllDataHistoriFilterSPP = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, SPP, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                SPP != 0
                AND NAMA LIKE '%$namaMurid%'
            ");

            $totalData = mysqli_num_rows($execQueryGetAllDataHistoriFilterSPP);

            $jumlahPagination = ceil($totalData / $jumlahData);

            $halamanAktif   = $jumlahPagination;
            // echo $halamanAktif;exit;

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $hitungDataFilterSPP = $totalData;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, SPP, TRANSAKSI, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                SPP != 0
                AND NAMA LIKE '%$namaMurid%'
                ORDER BY STAMP DESC
                LIMIT $dataAwal, $jumlahData
            ");

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

        } else {

            $execQueryGetAllDataHistoriFilterSPP = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, SPP, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                SPP != 0
                AND NAMA LIKE '%$namaMurid%'
            ");

            $totalData = mysqli_num_rows($execQueryGetAllDataHistoriFilterSPP);

            $jumlahPagination = ceil($totalData / $jumlahData);

            $halamanAktif   = $jumlahPagination;
            // echo $halamanAktif;exit;

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $hitungDataFilterSPP = $totalData;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, SPP, TRANSAKSI, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                SPP != 0
                AND NAMA LIKE '%$namaMurid%'
                ORDER BY STAMP DESC
                LIMIT $dataAwal, $jumlahData
            ");

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

    }
    // Akhir Bagian Pagination

?>

    <div class="row">
        <div class="col-xs-12 col-md-12 col-lg-12">

            <?php if(isset($_SESSION['form_success']) && $_SESSION['form_success'] == 'form_empty'){?>
              <div style="display: none;" class="alert alert-danger alert-dismissable"> Cari Siswa Terlebih Dahulu
                 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                 <?php unset($_SESSION['form_success']); ?>
              </div>
            <?php } ?>

            <?php if(isset($_SESSION['form_success']) && $_SESSION['form_success'] == 'data_update'){?>
              <div style="display: none;" class="alert alert-warning alert-dismissable"> Data Berhasil Di Update
                 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                 <?php unset($_SESSION['form_success']); ?>
              </div>
            <?php } ?>

            <?php if(isset($_SESSION['filter']) && $_SESSION['filter'] == false){?>
              <div style="display: none;" class="alert alert-danger alert-dismissable"> Harap Pilih Filter Dahulu
                 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                 <?php unset($_SESSION['filter']); ?>
              </div>
            <?php } ?>

        </div>
    </div>

    <!-- Jika Sesi Form Edit Bukan 0 Maka Muncul Form Edit Data -->
    <?php if ($setSesiFormEdit != 0): ?>

        <div class="box box-info">

            <div class="box-body">
                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>ID Siswa</label>
                            <input type="text" class="form-control" value="<?= $id_siswa; ?>" name="id_siswa" id="form_edit_id_siswa" readonly="">
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" class="form-control" value="<?= $nis; ?>" name="nis_siswa" id="form_edit_nis_siswa" readonly="">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" name="nama_siswa" class="form-control" value="<?= $namaSiswa; ?>" id="form_edit_nama_siswa" readonly/>
                        </div>
                    </div>
                
                </div>

                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="kelas_siswa" class="form-control" value="<?= $kelas; ?>" id="form_edit_kelas_siswa" readonly/>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Panggilan</label>
                            <input type="text" class="form-control" value="<?= $panggilan; ?>" name="panggilan_siswa" id="form_edit_panggilan_siswa" readonly />
                        </div>
                    </div>
                    
                </div>

            </div>

        </div>

        <hr class="new2"></hr>

        <div class="box box-info">

            <form action="<?= $baseac; ?>editdata" method="POST">

                <div class="box-body">
                    <div class="row">

                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>NUMBER INVOICE</label>
                                <input type="text" class="form-control" value="<?= $idInvoice; ?>" name="idInvoice" readonly>
                            </div>
                        </div>
                        
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>PEMBAYARAN</label>
                                <select class="form-control" name="isi_filter_edit">  
                                    <option value="kosong"> -- PILIH -- </option>
                                    <?php foreach ($filter_by['isifilter_by'] as $filby): ?>

                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>

                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>TANGGAL PEMBAYARAN</label>
                                <input type="date" class="form-control" value="<?= $tglPembayaran; ?>" name="tglPembayaran">
                            </div>
                        </div>

                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>BULAN PEMBAYARAN</label>
                                <select class="form-control" name="bulan_pembayaran">  
                                    <option value="kosong"> -- PILIH -- </option>
                                    <?php foreach ($data_bulan as $bln): ?>

                                        <option value="<?= $bln; ?>" <?=($bln == $pembayaranBulan )?'selected="selected"':''?> > <?= $bln; ?> </option>

                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>TAHUN PEMBAYARAN</label>
                                <input type="text" class="form-control" value="<?= $tahunBayar; ?>" id="isi_tahun" name="tahunBayar">
                            </div>
                        </div>

                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>TRANSAKSI</label>
                                <select class="form-control" name="payment_via">  
                                    <option value="kosong"> -- PILIH -- </option>
                                    <?php foreach ($ops_tx as $tx): ?>

                                        <option value="<?= $tx; ?>" <?=($tx == $pembayaranVIA )?'selected="selected"':''?> > <?= $tx; ?> </option>

                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>NOMINAL BAYAR</label>
                                <input type="text" name="nominalBayar" id="nominalBayar" class="form-control" value="<?= rupiah($nominalBayar); ?>">
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>KETERANGAN</label>
                                <input type="text" class="form-control" value="<?= $ketPembayaran; ?>" name="ketPembayaran">
                            </div>
                        </div>
                        
                    </div>

                    <div class="row">

                        <div class="col-sm-2">
                            <div class="form-group">
                                <label style="color: white;"> Filter </label>

                                <input type="hidden" name="data_id_siswa" value="<?= $id_siswa; ?>">
                                <input type="hidden" name="data_nis_siswa" value="<?= $nis; ?>">
                                <input type="hidden" name="data_nama_siswa" value="<?= $namaSiswa; ?>">
                                <input type="hidden" name="data_kelas_siswa" value="<?= $kelas; ?>">
                                <input type="hidden" name="data_panggilan_siswa" value="<?= $panggilan; ?>">
                                
                                <input type="hidden" name="currentPage" value="<?= $currentPage; ?>">
                                <input type="hidden" name="currentFilter" value="<?= $typeFilter; ?>">

                                <button type="submit" name="simpan_edit_data" class="form-control btn-success"> Simpan </button>
                            </div>
                        </div>

                    </div>

                </div>
                
            </form>

        </div>

    <?php else: ?>

        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Form Edit Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
               
            </div>

            <form action="<?= $baseac; ?>editdata" method="post">
                <div class="box-body">

                    <?php if ($setSesiPageFilterBy != 0): ?>

                        <!-- Jika Data Siswa Sudah Ada Tapi tidak pilih Filter -->
                        <div class="row">

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>ID Siswa</label>
                                    <input type="text" class="form-control" value="<?= $id; ?>" name="id_siswa" id="form_edit_id_siswa" readonly="">
                                </div>
                            </div>
                            
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>NIS</label>
                                    <input type="text" class="form-control" value="<?= $nis; ?>" name="nis_siswa" id="form_edit_nis_siswa" readonly="">
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Nama Siswa</label>
                                    <input type="text" name="nama_siswa" class="form-control" value="<?= $namaSiswa; ?>" id="form_edit_nama_siswa" readonly/>
                                </div>
                            </div>
                        
                        </div>

                        <div class="row">

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Kelas</label>
                                    <input type="text" name="kelas_siswa" class="form-control" value="<?= $kelas; ?>" id="form_edit_kelas_siswa" readonly/>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Panggilan</label>
                                    <input type="text" class="form-control" id="form_edit_panggilan_siswa" value="<?= $panggilan; ?>" name="panggilan_siswa" readonly />
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

                                                <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                            <?php else: ?>

                                                <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                                
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

                    <?php else: ?>

                        <!-- Default Form -->
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

                                                <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                            <?php else: ?>

                                                <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                                
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
                        <!-- Akhir Default Form -->                
                        
                    <?php endif ?>

                </div>
            </form>

            <?php if ($setSesiPageFilterBy == 1): ?>
                <?php require 'form_edit_pembayaran_spp.php'; ?>
            <?php elseif($setSesiPageFilterBy == 2): ?>
                <?php require 'form_edit_pembayaran_pangkal.php'; ?>
            <?php endif; ?>  

        </div>

    <?php endif ?>

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

        $('#isi_tahun').keypress(function (e) {
            if (String.fromCharCode(e.keyCode).match(/[^0-9]/g)) return false;
        });

        let scrollNextPage        = `<?= $iniScrollNextPage; ?>`
        let scrollPreviousPage    = `<?= $iniScrollPreviousPage; ?>`
        let scrollToPage          = `<?= $iniScrollToPage; ?>`
        let scrollLastPage        = `<?= $iniScrollLastPage; ?>`
        let scrollBackSave        = `<?= $iniScrollBackSave; ?>`

        if (scrollNextPage == 'ada') {
            // window.scrollTo(0, document.body.scrollHeight);
            window.scroll({
              top: 550,
              behavior: 'smooth'
            });
        } 

        if (scrollPreviousPage == 'ada') {
            // window.scrollTo(0, document.body.scrollHeight);
            window.scroll({
              top: 550,
              behavior: 'smooth'
            });
        } 

        if (scrollToPage == 'ada') {
            window.scroll({
              top: 550,
              behavior: 'smooth'
            });
        }

        if (scrollBackSave == 'ada') {
            alert('Data Berhasil Di Update');
            window.scroll({
              top: 550,
              behavior: 'smooth'
            });
        }

        if (scrollLastPage == 'ada') {
            window.scroll({
              top: 550,
              behavior: 'smooth'
            });
        }

	})

    let nominalBayar  = document.getElementById('nominalBayar')

    nominalBayar.addEventListener('keyup', function(e){
        // tambahkan 'Rp.' pada saat form di ketik
        // alert("ok")
        // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
        nominalBayar.value = formatRupiah(this.value, 'Rp. ');
    });

	function OpenCarisiswaModal(){
        $('#modalEditData').modal("show");
    }

    function formatRupiah(angka, prefix){
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
        split             = number_string.split(','),
        sisa              = split[0].length % 3,
        rupiah_spp        = split[0].substr(0, sisa),
        ribuan            = split[0].substr(sisa).match(/\d{3}/gi);

        // tambahkan titik jika yang di input sudah menjadi angka ribuan
        if(ribuan){
            separator = sisa ? '.' : '';
            rupiah_spp += separator + ribuan.join('.');
        }

        rupiah_spp = split[1] != undefined ? rupiah_spp + ',' + split[1] : rupiah_spp;
        return prefix == undefined ? rupiah_spp : (rupiah_spp ? 'Rp. ' + rupiah_spp : '');
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