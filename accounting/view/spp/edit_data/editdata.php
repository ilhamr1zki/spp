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

    $timeOut        = $_SESSION['expire'];
    
    $timeRunningOut = time() + 5;

    $timeIsOut = 0;

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

    function rupiahFormatInput($angkax){
    
        $hasil_rupiahx = "Rp " . number_format($angkax,0,'.','.');
        return $hasil_rupiahx;
     
    }

    $setSesiPageFilterBy = 0; 
    $setSesiFormEdit     = 0;

    $dariTanggal    = "";
    $sampaiTanggal  = "";

    $setSesiJsFormatRupiah = 0;

    $nominalBayarSPP        = 0;
    $nominalBayarPangkal    = 0;
    $nominalBayarKegiatan   = 0;
    $nominalBayarBuku       = 0;
    $nominalBayarSeragam    = 0;
    $nominalBayarRegistrasi = 0;
    $nominalBayarLain       = 0;

    $data_uang_spp        = 0;
    $data_uang_pangkal    = 0;
    $data_uang_kegiatan   = 0;
    $data_uang_buku       = 0;
    $data_uang_seragam    = 0;
    $data_uang_registrasi = 0;
    $data_uang_lain       = 0;

    $data_ket_spp         = NULL;
    $data_ket_pangkal     = NULL;
    $data_ket_kegiatan    = NULL;
    $data_ket_buku        = NULL;
    $data_ket_seragam     = NULL;
    $data_ket_registrasi  = NULL;
    $data_ket_lain        = NULL;

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
    $iniScrollBackPage      = "kosong";
    $pageActive = 0;

    $currentPage        = 0;

    $timeIsOut  = 0;

    $queryNamaInputer  = "SELECT username FROM accounting WHERE c_accounting = '$_SESSION[c_accounting]' ";
    $getNamaInputer    = mysqli_fetch_assoc(mysqli_query($con, $queryNamaInputer))['username'];
    $getNamaInputer    = ucfirst($getNamaInputer);

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

                $tanggalDari    = str_replace([" 00:00:00"], "", $dariTanggal);
                $tanggalSampai  = str_replace([" 23:59:59"], "", $sampaiTanggal);

                // Data SPP
                if ($_POST['isi_filter_edit'] == 'SPP') {

                    if ($dariTanggal != " 00:00:00" && $sampaiTanggal != " 23:59:59") {
                        $setSesiPageFilterBy = 8;
                    } elseif($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59") {
                        $setSesiPageFilterBy = 1;
                    }

                    $isifilby = $_POST['isi_filter_edit'];

                } 
                // Akhir Data SPP

                // Data PANGKAL
                else if ($_POST['isi_filter_edit'] == 'PANGKAL') {

                    if ($dariTanggal != " 00:00:00" && $sampaiTanggal != " 23:59:59") {
                        $setSesiPageFilterBy = 9;
                    } elseif($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59") {
                        $setSesiPageFilterBy = 2;
                    }

                    $isifilby = $_POST['isi_filter_edit'];

                }
                // Akhir Data Pangkal

                // Data KEGIATAN
                else if ($_POST['isi_filter_edit'] == 'KEGIATAN') {

                    if ($dariTanggal != " 00:00:00" && $sampaiTanggal != " 23:59:59") {
                        $setSesiPageFilterBy = 10;
                    } elseif($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59") {
                        $setSesiPageFilterBy = 3;
                    }

                    $isifilby = $_POST['isi_filter_edit'];

                }
                // Akhir DATA KEGIATAN

                // Data BUKU
                else if ($_POST['isi_filter_edit'] == 'BUKU') {

                    if ($dariTanggal != " 00:00:00" && $sampaiTanggal != " 23:59:59") {
                        $setSesiPageFilterBy = 11;
                    } elseif($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59") {
                        $setSesiPageFilterBy = 4;
                    }
                    $isifilby = $_POST['isi_filter_edit'];

                }
                // Akhir DATA BUKU

                // Data SERAGAM
                else if ($_POST['isi_filter_edit'] == 'SERAGAM') {

                    if ($dariTanggal != " 00:00:00" && $sampaiTanggal != " 23:59:59") {
                        $setSesiPageFilterBy = 12;
                    } elseif($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59") {
                        $setSesiPageFilterBy = 5;
                    }

                    $isifilby = $_POST['isi_filter_edit'];

                }
                // Akhir DATA SERAGAM

                // Data REGISTRASI
                else if ($_POST['isi_filter_edit'] == 'REGISTRASI') {

                    if ($dariTanggal != " 00:00:00" && $sampaiTanggal != " 23:59:59") {
                        $setSesiPageFilterBy = 13;
                    } elseif($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59") {
                        $setSesiPageFilterBy = 6;
                    }

                    $isifilby = $_POST['isi_filter_edit'];

                }
                // Akhir DATA REGISTRASI

                // Data LAIN
                else if ($_POST['isi_filter_edit'] == 'LAIN') {

                    if ($dariTanggal != " 00:00:00" && $sampaiTanggal != " 23:59:59") {
                        $setSesiPageFilterBy = 14;
                    } elseif($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59") {
                        $setSesiPageFilterBy = 7;
                    }

                    $isifilby = $_POST['isi_filter_edit'];

                }
                // Akhir DATA LAIN

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

        $dariTanggal    = $_POST['tanggal1'];
        $sampaiTanggal  = $_POST['tanggal2'];

        // $tanggalDari    = str_replace([" 00:00:00"], "", $dariTanggal);
        // $tanggalSampai  = str_replace([" 23:59:59"], "", $sampaiTanggal);

        // DATA PEMBAYARAN
        if ($typeFilter == 'SPP' || $typeFilter == 'PANGKAL' || $typeFilter == 'KEGIATAN' || $typeFilter == 'BUKU' || $typeFilter == 'SERAGAM' || $typeFilter == 'REGISTRASI' || $typeFilter == 'LAIN') {

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
        // AKhir DATA PEMBAYARAN

    }

    elseif (isset($_POST['edit_data_with_date'])) {

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

        $dariTanggal    = $_POST['tanggal1'];
        $sampaiTanggal  = $_POST['tanggal2'];

        $tanggalDari    = str_replace([" 00:00:00"], "", $dariTanggal);
        $tanggalSampai  = str_replace([" 23:59:59"], "", $sampaiTanggal);

        // DATA PEMBAYARAN
        if ($typeFilter == 'SPP' || $typeFilter == 'PANGKAL' || $typeFilter == 'KEGIATAN' || $typeFilter == 'BUKU' || $typeFilter == 'SERAGAM' || $typeFilter == 'REGISTRASI' || $typeFilter == 'LAIN') {

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
        // AKhir DATA PEMBAYARAN

    }

    // Jika Ada Tombol Tambah Data di filter edit di klik
    elseif (isset($_POST['tambah_data'])) {

        $id_siswa   = $_POST['id_siswa'];
        $nis        = $_POST['nis_siswa'];
        $namaSiswa  = $_POST['nama_siswa'];
        $kelas      = $_POST['kelas_siswa'];
        $panggilan  = $_POST['panggilan_siswa'];

        $queryUangSPP       = "";
        $ketUangSPP         = "";

        $queryUangPangkal   = "";
        $ketUangPangkal     = "";

        $queryUangKegiatan  = "";
        $ketUangKegiatan    = "";

        $queryUangBuku      = "";
        $ketUangBuku        = "";

        $queryUangSeragam   = "";
        $ketUangSeragam     = "";

        $queryUangRegis     = "";
        $ketUangRegis       = "";

        $queryUangLain      = "";
        $ketUangLain        = "";

        $typeFilter         = $_POST['isi_filter'];
        $idInvoice          = "";
        $tglPembayaran      = "";
        $pembayaranBulan    = "";
        $nominalBayar       = "";
        $ketPembayaran      = "";
        $pembayaranVIA      = "";

        $currentPage        = $_POST['currentPage'];

        $dariTanggal    = $_POST['tanggal1'];
        $sampaiTanggal  = $_POST['tanggal2'];

        $tanggalDari    = str_replace([" 00:00:00"], "", $dariTanggal);
        $tanggalSampai  = str_replace([" 23:59:59"], "", $sampaiTanggal);

        // DATA PEMBAYARAN
        if ($typeFilter == 'SPP' || $typeFilter == 'PANGKAL' || $typeFilter == 'KEGIATAN' || $typeFilter == 'BUKU' || $typeFilter == 'SERAGAM' || $typeFilter == 'REGISTRASI' || $typeFilter == 'LAIN') {

            $setSesiFormEdit    = 2;

            $idInvoice          = $_POST['id_invoice'];
            $tglPembayaran      = $_POST['tgl_bukti_pembayaran'];
            $tglPembayaran      = str_replace([" 00:00:00"], "", $tglPembayaran);

            $pembayaranBulan    = substr($_POST['pembayaran_bulan'], 0, -5);
            $tahunBayar         = substr($_POST['pembayaran_bulan'], -4);
            $nominalBayar       = $_POST['nominal_bayar'];
            $ketPembayaran      = $_POST['ket_pembayaran'];
            $pembayaranVIA      = $_POST['tipe_transaksi'];

            if ($_SESSION['c_accounting'] == 'accounting1') {

                $queryUangSPP       = mysqli_fetch_assoc(mysqli_query($con, "SELECT SPP FROM input_data_sd_lama1 WHERE ID = '$idInvoice' "))['SPP'];
                $ketUangSPP         = mysqli_fetch_assoc(mysqli_query($con, "SELECT SPP_txt FROM input_data_sd_lama1 WHERE ID = '$idInvoice' "))['SPP_txt'];

                $queryUangPangkal   = mysqli_fetch_assoc(mysqli_query($con, "SELECT PANGKAL FROM input_data_sd_lama1 WHERE ID = '$idInvoice' "))['PANGKAL'];
                $ketUangPangkal     = mysqli_fetch_assoc(mysqli_query($con, "SELECT PANGKAL_txt FROM input_data_sd_lama1 WHERE ID = '$idInvoice' "))['PANGKAL_txt'];

                $queryUangKegiatan  = mysqli_fetch_assoc(mysqli_query($con, "SELECT KEGIATAN FROM input_data_sd_lama1 WHERE ID = '$idInvoice' "))['KEGIATAN'];
                $ketUangKegiatan    = mysqli_fetch_assoc(mysqli_query($con, "SELECT KEGIATAN_txt FROM input_data_sd_lama1 WHERE ID = '$idInvoice' "))['KEGIATAN_txt'];

                $queryUangBuku      = mysqli_fetch_assoc(mysqli_query($con, "SELECT BUKU FROM input_data_sd_lama1 WHERE ID = '$idInvoice' "))['BUKU'];
                $ketUangBuku        = mysqli_fetch_assoc(mysqli_query($con, "SELECT BUKU_txt FROM input_data_sd_lama1 WHERE ID = '$idInvoice' "))['BUKU_txt'];

                $queryUangSeragam   = mysqli_fetch_assoc(mysqli_query($con, "SELECT SERAGAM FROM input_data_sd_lama1 WHERE ID = '$idInvoice' "))['SERAGAM'];
                $ketUangSeragam     = mysqli_fetch_assoc(mysqli_query($con, "SELECT SERAGAM_txt FROM input_data_sd_lama1 WHERE ID = '$idInvoice' "))['SERAGAM_txt'];

                $queryUangRegis     = mysqli_fetch_assoc(mysqli_query($con, "SELECT REGISTRASI FROM input_data_sd_lama1 WHERE ID = '$idInvoice' "))['REGISTRASI'];
                $ketUangRegis       = mysqli_fetch_assoc(mysqli_query($con, "SELECT REGISTRASI_txt FROM input_data_sd_lama1 WHERE ID = '$idInvoice' "))['REGISTRASI_txt'];

                $queryUangLain      = mysqli_fetch_assoc(mysqli_query($con, "SELECT LAIN FROM input_data_sd_lama1 WHERE ID = '$idInvoice' "))['LAIN'];
                $ketUangLain        = mysqli_fetch_assoc(mysqli_query($con, "SELECT LAIN_txt FROM input_data_sd_lama1 WHERE ID = '$idInvoice' "))['LAIN_txt'];

            } else if ($_SESSION['c_accounting'] == 'accounting2') {

                $queryUangSPP       = mysqli_fetch_assoc(mysqli_query($con, "SELECT SPP FROM input_data_tk_lama WHERE ID = '$idInvoice'"))['SPP'];
                $ketUangSPP         = mysqli_fetch_assoc(mysqli_query($con, "SELECT SPP_txt FROM input_data_tk_lama WHERE ID = '$idInvoice' "))['SPP_txt'];

                $queryUangPangkal   = mysqli_fetch_assoc(mysqli_query($con, "SELECT PANGKAL FROM input_data_tk_lama WHERE ID = '$idInvoice' "))['PANGKAL'];
                $ketUangPangkal     = mysqli_fetch_assoc(mysqli_query($con, "SELECT PANGKAL_txt FROM input_data_tk_lama WHERE ID = '$idInvoice' "))['PANGKAL_txt'];

                $queryUangKegiatan  = mysqli_fetch_assoc(mysqli_query($con, "SELECT KEGIATAN FROM input_data_tk_lama WHERE ID = '$idInvoice' "))['KEGIATAN'];
                $ketUangKegiatan    = mysqli_fetch_assoc(mysqli_query($con, "SELECT KEGIATAN_txt FROM input_data_tk_lama WHERE ID = '$idInvoice' "))['KEGIATAN_txt'];

                $queryUangBuku      = mysqli_fetch_assoc(mysqli_query($con, "SELECT BUKU FROM input_data_tk_lama WHERE ID = '$idInvoice' "))['BUKU'];
                $ketUangBuku        = mysqli_fetch_assoc(mysqli_query($con, "SELECT BUKU_txt FROM input_data_tk_lama WHERE ID = '$idInvoice' "))['BUKU_txt'];

                $queryUangSeragam   = mysqli_fetch_assoc(mysqli_query($con, "SELECT SERAGAM FROM input_data_tk_lama WHERE ID = '$idInvoice' "))['SERAGAM'];
                $ketUangSeragam     = mysqli_fetch_assoc(mysqli_query($con, "SELECT SERAGAM_txt FROM input_data_tk_lama WHERE ID = '$idInvoice' "))['SERAGAM_txt'];

                $queryUangRegis     = mysqli_fetch_assoc(mysqli_query($con, "SELECT REGISTRASI FROM input_data_tk_lama WHERE ID = '$idInvoice' "))['REGISTRASI'];
                $ketUangRegis       = mysqli_fetch_assoc(mysqli_query($con, "SELECT REGISTRASI_txt FROM input_data_tk_lama WHERE ID = '$idInvoice' "))['REGISTRASI_txt'];

                $queryUangLain      = mysqli_fetch_assoc(mysqli_query($con, "SELECT LAIN FROM input_data_tk_lama WHERE ID = '$idInvoice' "))['LAIN'];
                $ketUangLain        = mysqli_fetch_assoc(mysqli_query($con, "SELECT LAIN_txt FROM input_data_tk_lama WHERE ID = '$idInvoice' "))['LAIN_txt'];

            }

            $isifilby = $typeFilter;

        }
        // AKhir DATA PEMBAYARAN

    }

    // Jika Ada Tombol Simpan Edit Data
    elseif (isset($_POST['simpan_edit_data'])) {

        $id         = $_POST['data_id_siswa'];
        $nis        = $_POST['data_nis_siswa'];
        $namaSiswa  = $_POST['data_nama_siswa'];
        $kelas      = $_POST['data_kelas_siswa'];
        $panggilan  = $_POST['data_panggilan_siswa'];

        $idInvoice       = $_POST['idInvoice'];
        $currentFilter   = $_POST['currentFilter'];
        $typeFilter      = htmlspecialchars($_POST['isi_filter_edit']);

        $dariTanggal    = $_POST['tanggal1'];
        $sampaiTanggal  = $_POST['tanggal2'];

        $tanggalDari    = str_replace([" 00:00:00"], "", $dariTanggal);
        $tanggalSampai  = str_replace([" 23:59:59"], "", $sampaiTanggal);

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
                    $nominalBayarSPP        = str_replace(["Rp ", "Rp. ", ".", ","], "", $_POST['nominalBayar']);
                    $ketPembayaranSPP       = mysqli_real_escape_string($con, htmlspecialchars($_POST['ketPembayaran']));

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

                    if ($currentFilter == 'SPP') {

                        if ($pembayaranVIA == 'kosong') {

                            $queryUpdate = "
                                UPDATE `u415776667_spp`.`input_data_sd_lama1` 
                                SET 
                                `DATE`='$tglPembayaranDB', 
                                `BULAN`='$pembayaranBulanDB', 
                                `SPP`='$nominalBayarSPP', 
                                `SPP_txt`='$ketPembayaranSPP', 
                                `TRANSAKSI`=NULL,
                                `INPUTER`='$getNamaInputer',
                                `STAMP`='$data_stamp'
                                WHERE `ID`= '$idInvoice'
                            ";

                        } elseif ($pembayaranVIA != 'kosong') {

                            $queryUpdate = "
                                UPDATE `u415776667_spp`.`input_data_sd_lama1` 
                                SET 
                                `DATE`='$tglPembayaranDB', 
                                `BULAN`='$pembayaranBulanDB', 
                                `SPP`='$nominalBayarSPP', 
                                `SPP_txt`='$ketPembayaranSPP', 
                                `TRANSAKSI`='$pembayaranVIA',
                                `INPUTER`='$getNamaInputer',
                                `STAMP`='$data_stamp'
                                WHERE `ID`= '$idInvoice'
                            ";

                        }

                        mysqli_query($con, $queryUpdate);

                        if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {
                            
                            $setSesiPageFilterBy = 1;

                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, SPP, TRANSAKSI, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_sd_lama1
                                    WHERE
                                    SPP != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;

                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }

                        } elseif ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {

                            $setSesiPageFilterBy = 8;

                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, SPP, TRANSAKSI, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_sd_lama1
                                    WHERE
                                    SPP != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                                    order by STAMP 
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    $pageActive =  $halamanAktif - 1;
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }

                        }

                    } elseif ($currentFilter == 'PANGKAL') {

                        if ($pembayaranVIA == 'kosong') {

                            $queryUpdate = "
                                UPDATE `u415776667_spp`.`input_data_sd_lama1` 
                                SET 
                                `DATE`='$tglPembayaranDB', 
                                `BULAN`='$pembayaranBulanDB', 
                                `SPP`='$nominalBayarSPP', 
                                `SPP_txt`='$ketPembayaranSPP', 
                                `PANGKAL`='$nominalBayarPangkal',
                                `PANGKAL_txt`=NULL,
                                `TRANSAKSI`=NULL,
                                `INPUTER`='$getNamaInputer',
                                `STAMP`='$data_stamp'
                                WHERE `ID`= '$idInvoice'
                            ";

                        } elseif ($pembayaranVIA != 'kosong') {

                            $queryUpdate = "
                                UPDATE `u415776667_spp`.`input_data_sd_lama1` 
                                SET 
                                `DATE`='$tglPembayaranDB', 
                                `BULAN`='$pembayaranBulanDB', 
                                `SPP`='$nominalBayarSPP', 
                                `SPP_txt`='$ketPembayaranSPP',
                                `PANGKAL`='$nominalBayarPangkal',
                                `PANGKAL_txt`=NULL,
                                `TRANSAKSI`='$pembayaranVIA',
                                `INPUTER`='$getNamaInputer',
                                `STAMP`='$data_stamp'
                                WHERE `ID`= '$idInvoice'
                            ";

                        }

                        mysqli_query($con, $queryUpdate);

                        if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {
                            $setSesiPageFilterBy = 2;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, PANGKAL, TRANSAKSI, BULAN AS pembayaran_bulan, PANGKAL_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_sd_lama1
                                    WHERE
                                    PANGKAL != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;

                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        } elseif ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 9;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, PANGKAL, TRANSAKSI, BULAN AS pembayaran_bulan, PANGKAL_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_sd_lama1
                                    WHERE
                                    PANGKAL != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                                    order by STAMP 
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    $pageActive =  $halamanAktif - 1;
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        }

                    } elseif ($currentFilter == 'KEGIATAN') {

                        if ($pembayaranVIA == 'kosong') {

                            $queryUpdate = "
                                UPDATE `u415776667_spp`.`input_data_sd_lama1` 
                                SET 
                                `DATE`='$tglPembayaranDB', 
                                `BULAN`='$pembayaranBulanDB', 
                                `SPP`='$nominalBayarSPP', 
                                `SPP_txt`='$ketPembayaranSPP', 
                                `KEGIATAN`='$nominalBayarKegiatan',
                                `KEGIATAN_txt`=NULL,
                                `TRANSAKSI`=NULL,
                                `INPUTER`='$getNamaInputer',
                                `STAMP`='$data_stamp'
                                WHERE `ID`= '$idInvoice'
                            ";

                        } elseif ($pembayaranVIA != 'kosong') {

                            $queryUpdate = "
                                UPDATE `u415776667_spp`.`input_data_sd_lama1` 
                                SET 
                                `DATE`='$tglPembayaranDB', 
                                `BULAN`='$pembayaranBulanDB', 
                                `SPP`='$nominalBayarSPP', 
                                `SPP_txt`='$ketPembayaranSPP', 
                                `KEGIATAN`='$nominalBayarKegiatan',
                                `KEGIATAN_txt`=NULL,
                                `TRANSAKSI`='$pembayaranVIA',
                                `INPUTER`='$getNamaInputer',
                                `STAMP`='$data_stamp'
                                WHERE `ID`= '$idInvoice'
                            ";

                        }

                        mysqli_query($con, $queryUpdate);

                        if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {
                            
                            $setSesiPageFilterBy = 3;

                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, KEGIATAN, TRANSAKSI, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_sd_lama1
                                    WHERE
                                    KEGIATAN != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;

                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }

                        } elseif ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {

                            $setSesiPageFilterBy = 10;

                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, KEGIATAN, TRANSAKSI, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_sd_lama1
                                    WHERE
                                    KEGIATAN != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                                    order by STAMP 
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    $pageActive =  $halamanAktif - 1;
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                            
                        }

                    } elseif ($currentFilter == 'BUKU') {

                        if ($pembayaranVIA == 'kosong') {

                            $queryUpdate = "
                                UPDATE `u415776667_spp`.`input_data_sd_lama1` 
                                SET 
                                `DATE`='$tglPembayaranDB', 
                                `BULAN`='$pembayaranBulanDB', 
                                `SPP`='$nominalBayarSPP', 
                                `SPP_txt`='$ketPembayaranSPP', 
                                `BUKU`='$nominalBayarBuku',
                                `BUKU_txt`=NULL,
                                `TRANSAKSI`=NULL,
                                `INPUTER`='$getNamaInputer',
                                `STAMP`='$data_stamp'
                                WHERE  `ID`= '$idInvoice'
                            ";

                        } elseif ($pembayaranVIA != 'kosong') {

                            $queryUpdate = "
                                UPDATE `u415776667_spp`.`input_data_sd_lama1` 
                                SET 
                                `DATE`='$tglPembayaranDB', 
                                `BULAN`='$pembayaranBulanDB', 
                                `SPP`='$nominalBayarSPP', 
                                `SPP_txt`='$ketPembayaranSPP', 
                                `BUKU`='$nominalBayarBuku',
                                `BUKU_txt`=NULL,
                                `TRANSAKSI`='$pembayaranVIA',
                                `INPUTER`='$getNamaInputer',
                                `STAMP`='$data_stamp'
                                WHERE  `ID`= '$idInvoice'
                            ";

                        }

                        mysqli_query($con, $queryUpdate);

                        if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {
                            $setSesiPageFilterBy = 4;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, BUKU, TRANSAKSI, BULAN AS pembayaran_bulan, BUKU_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_sd_lama1
                                    WHERE
                                    BUKU != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;

                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        } elseif ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 11;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, BUKU, TRANSAKSI, BULAN AS pembayaran_bulan, BUKU_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_sd_lama1
                                    WHERE
                                    BUKU != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                                    order by STAMP 
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        }

                    } elseif ($currentFilter == 'SERAGAM') {

                        if ($pembayaranVIA == 'kosong') {

                            $queryUpdate = "
                                UPDATE `u415776667_spp`.`input_data_sd_lama1` 
                                SET 
                                `DATE`='$tglPembayaranDB', 
                                `BULAN`='$pembayaranBulanDB', 
                                `SPP`='$nominalBayarSPP', 
                                `SPP_txt`='$ketPembayaranSPP', 
                                `SERAGAM`='$nominalBayarSeragam',
                                `SERAGAM_txt`=NULL,
                                `TRANSAKSI`=NULL,
                                `INPUTER`='$getNamaInputer',
                                `STAMP`='$data_stamp'
                                WHERE  `ID`= '$idInvoice'
                            ";

                        } elseif ($pembayaranVIA != 'kosong') {

                            $queryUpdate = "
                                UPDATE `u415776667_spp`.`input_data_sd_lama1` 
                                SET 
                                `DATE`='$tglPembayaranDB', 
                                `BULAN`='$pembayaranBulanDB', 
                                `SPP`='$nominalBayarSPP', 
                                `SPP_txt`='$ketPembayaranSPP', 
                                `SERAGAM`='$nominalBayarSeragam',
                                `SERAGAM_txt`=NULL,
                                `TRANSAKSI`='$pembayaranVIA',
                                `INPUTER`='$getNamaInputer',
                                `STAMP`='$data_stamp'
                                WHERE  `ID`= '$idInvoice'
                            ";

                        }

                        mysqli_query($con, $queryUpdate);

                        if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {
                            $setSesiPageFilterBy = 5;

                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, SERAGAM, TRANSAKSI, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_sd_lama1
                                    WHERE
                                    SERAGAM != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;

                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        } elseif ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 12;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, SERAGAM, TRANSAKSI, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_sd_lama1
                                    WHERE
                                    SERAGAM != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                                    order by STAMP 
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        }

                    } elseif ($currentFilter == 'REGISTRASI') {

                        if ($pembayaranVIA == 'kosong') {

                            $queryUpdate = "
                                UPDATE `u415776667_spp`.`input_data_sd_lama1` 
                                SET 
                                `DATE`='$tglPembayaranDB', 
                                `BULAN`='$pembayaranBulanDB', 
                                `SPP`='$nominalBayarSPP', 
                                `SPP_txt`='$ketPembayaranSPP', 
                                `REGISTRASI`='$nominalBayarRegistrasi',
                                `REGISTRASI_txt`=NULL,
                                `TRANSAKSI`=NULL,
                                `INPUTER`='$getNamaInputer',
                                `STAMP`='$data_stamp'
                                WHERE  `ID`= '$idInvoice'
                            ";

                        } elseif ($pembayaranVIA != 'kosong') {

                            $queryUpdate = "
                                UPDATE `u415776667_spp`.`input_data_sd_lama1` 
                                SET 
                                `DATE`='$tglPembayaranDB', 
                                `BULAN`='$pembayaranBulanDB', 
                                `SPP`='$nominalBayarSPP', 
                                `SPP_txt`='$ketPembayaranSPP', 
                                `REGISTRASI`='$nominalBayarRegistrasi',
                                `REGISTRASI_txt`=NULL,
                                `TRANSAKSI`='$pembayaranVIA',
                                `INPUTER`='$getNamaInputer',
                                `STAMP`='$data_stamp'
                                WHERE  `ID`= '$idInvoice'
                            ";

                        }

                        mysqli_query($con, $queryUpdate);

                        if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {
                            $setSesiPageFilterBy = 6;

                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, REGISTRASI, TRANSAKSI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_sd_lama1
                                    WHERE
                                    REGISTRASI != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;

                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }

                        } elseif ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 13;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, REGISTRASI, TRANSAKSI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_sd_lama1
                                    WHERE
                                    REGISTRASI != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                                    order by STAMP 
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        }

                    } elseif ($currentFilter == 'LAIN') {

                        if ($pembayaranVIA == 'kosong') {

                            $queryUpdate = "
                                UPDATE `u415776667_spp`.`input_data_sd_lama1` 
                                SET 
                                `DATE`='$tglPembayaranDB', 
                                `BULAN`='$pembayaranBulanDB', 
                                `SPP`='$nominalBayarSPP', 
                                `SPP_txt`='$ketPembayaranSPP', 
                                `LAIN`='$nominalBayarRegistrasi',
                                `LAIN_txt`=NULL,
                                `TRANSAKSI`=NULL,
                                `INPUTER`='$getNamaInputer',
                                `STAMP`='$data_stamp'
                                WHERE  `ID`= '$idInvoice'
                            ";

                        } elseif ($pembayaranVIA != 'kosong') {

                            $queryUpdate = "
                                UPDATE `u415776667_spp`.`input_data_sd_lama1` 
                                SET 
                                `DATE`='$tglPembayaranDB', 
                                `BULAN`='$pembayaranBulanDB', 
                                `SPP`='$nominalBayarSPP', 
                                `SPP_txt`='$ketPembayaranSPP', 
                                `LAIN`='$nominalBayarRegistrasi',
                                `LAIN_txt`=NULL,
                                `TRANSAKSI`='$pembayaranVIA',
                                `INPUTER`='$getNamaInputer',
                                `STAMP`='$data_stamp'
                                WHERE  `ID`= '$idInvoice'
                            ";

                        }

                        mysqli_query($con, $queryUpdate);

                        if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {
                            $setSesiPageFilterBy = 7;

                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, LAIN, TRANSAKSI, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_sd_lama1
                                    WHERE
                                    LAIN != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;

                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }

                        } elseif ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 14;

                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, LAIN, TRANSAKSI, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_sd_lama1
                                    WHERE
                                    LAIN != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                                    order by STAMP 
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    $pageActive =  $halamanAktif - 1;
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }

                        }

                    }

                    $nominalBayar       = rupiahFormat($nominalBayarSPP);
                    $ketPembayaran      = $ketPembayaranSPP;

                    break;
                case 'PANGKAL':
                    $nominalBayarSPP;
                    $ketPembayaranSPP;

                    $nominalBayarPangkal    = str_replace(["Rp ", "Rp. ", ".", ","], "", $_POST['nominalBayar']);
                    $ketPembayaranPangkal   = mysqli_real_escape_string($con, htmlspecialchars($_POST['ketPembayaran']));

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

                    if ($currentFilter == 'SPP') {

                        if ($pembayaranVIA == 'kosong') {

                            $queryUpdate = "
                                UPDATE `u415776667_spp`.`input_data_sd_lama1` 
                                SET 
                                `DATE`='$tglPembayaranDB', 
                                `BULAN`='$pembayaranBulanDB', 
                                `SPP`='$nominalBayarSPP', 
                                `SPP_txt`=NULL, 
                                `PANGKAL`='$nominalBayarPangkal',
                                `PANGKAL_txt`='$ketPembayaranPangkal',
                                `TRANSAKSI`=NULL,
                                `INPUTER`='$getNamaInputer',
                                `STAMP`='$data_stamp'
                                WHERE `ID`= '$idInvoice'
                            ";

                        } elseif ($pembayaranVIA != 'kosong') {

                            $queryUpdate = "
                                UPDATE `u415776667_spp`.`input_data_sd_lama1` 
                                SET 
                                `DATE`='$tglPembayaranDB', 
                                `BULAN`='$pembayaranBulanDB', 
                                `SPP`='$nominalBayarSPP', 
                                `SPP_txt`=NULL,
                                `PANGKAL`='$nominalBayarPangkal',
                                `PANGKAL_txt`='$ketPembayaranPangkal',
                                `TRANSAKSI`='$pembayaranVIA',
                                `INPUTER`='$getNamaInputer',
                                `STAMP`='$data_stamp'
                                WHERE `ID`= '$idInvoice'
                            ";

                        }

                        mysqli_query($con, $queryUpdate);
                        
                        if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {
                            $setSesiPageFilterBy = 1;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, SPP, TRANSAKSI, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_sd_lama1
                                    WHERE
                                    SPP != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        } elseif ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 8;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;

                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, SPP, TRANSAKSI, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_sd_lama1
                                    WHERE
                                    SPP != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                                    order by STAMP 
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;

                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        }

                    } elseif ($currentFilter == 'PANGKAL') {

                        if ($pembayaranVIA == 'kosong') {

                            $queryUpdate = "
                                UPDATE `u415776667_spp`.`input_data_sd_lama1` 
                                SET 
                                `DATE`='$tglPembayaranDB', 
                                `BULAN`='$pembayaranBulanDB', 
                                `PANGKAL`='$nominalBayarPangkal',
                                `PANGKAL_txt`='$ketPembayaranPangkal',
                                `TRANSAKSI`=NULL,
                                `INPUTER`='$getNamaInputer',
                                `STAMP`='$data_stamp'
                                WHERE  `ID`= '$idInvoice'
                            ";

                        } else if ($pembayaranVIA != 'kosong') {

                            $queryUpdate = "
                                UPDATE `u415776667_spp`.`input_data_sd_lama1` 
                                SET 
                                `DATE`='$tglPembayaranDB', 
                                `BULAN`='$pembayaranBulanDB', 
                                `PANGKAL`='$nominalBayarPangkal',
                                `PANGKAL_txt`='$ketPembayaranPangkal',
                                `TRANSAKSI`='$pembayaranVIA',
                                `INPUTER`='$getNamaInputer',
                                `STAMP`='$data_stamp'
                                WHERE  `ID`= '$idInvoice'
                            ";

                        }

                        mysqli_query($con, $queryUpdate);

                        if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {
                            
                            $setSesiPageFilterBy = 2;

                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, PANGKAL, TRANSAKSI, BULAN AS pembayaran_bulan, PANGKAL_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_sd_lama1
                                    WHERE
                                    PANGKAL != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;

                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }

                        } elseif ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {

                            $setSesiPageFilterBy = 9;

                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, PANGKAL, TRANSAKSI, BULAN AS pembayaran_bulan, PANGKAL_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_sd_lama1
                                    WHERE
                                    PANGKAL != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                                    order by STAMP 
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    $pageActive =  $halamanAktif - 1;
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }

                        }

                    } elseif ($currentFilter == 'KEGIATAN') {
                        if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {
                            $setSesiPageFilterBy = 3;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, KEGIATAN, TRANSAKSI, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_sd
                                    WHERE
                                    KEGIATAN != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        } elseif ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 10;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;

                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, KEGIATAN, TRANSAKSI, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_sd
                                    WHERE
                                    KEGIATAN != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                                    order by STAMP 
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    $pageActive =  $halamanAktif - 1;
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;

                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        }
                    } elseif ($currentFilter == 'BUKU') {
                        if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {
                            $setSesiPageFilterBy = 4;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, BUKU, TRANSAKSI, BULAN AS pembayaran_bulan, BUKU_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_sd
                                    WHERE
                                    BUKU != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        } elseif ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 11;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;

                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, BUKU, TRANSAKSI, BULAN AS pembayaran_bulan, BUKU_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_sd
                                    WHERE
                                    BUKU != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                                    order by STAMP 
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    $pageActive =  $halamanAktif - 1;
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;

                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        }
                    } elseif ($currentFilter == 'SERAGAM') {
                        if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {
                            $setSesiPageFilterBy = 5;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, SERAGAM, TRANSAKSI, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_sd_lama1
                                    WHERE
                                    SERAGAM != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;

                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        } elseif ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 12;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, SERAGAM, TRANSAKSI, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_sd_lama1
                                    WHERE
                                    SERAGAM != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                                    order by STAMP 
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    $pageActive =  $halamanAktif - 1;
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        }
                    } elseif ($currentFilter == 'REGISTRASI') {
                        if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {
                            $setSesiPageFilterBy = 6;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, REGISTRASI, TRANSAKSI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_sd
                                    WHERE
                                    REGISTRASI != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;

                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        } elseif ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 13;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, REGISTRASI, TRANSAKSI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_sd
                                    WHERE
                                    REGISTRASI != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                                    order by STAMP 
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    $pageActive =  $halamanAktif - 1;
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        }
                    } elseif ($currentFilter == 'LAIN') {
                        if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {
                            $setSesiPageFilterBy = 7;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, LAIN, TRANSAKSI, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_sd
                                    WHERE
                                    LAIN != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;

                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        } elseif ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 14;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, LAIN, TRANSAKSI, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_sd
                                    WHERE
                                    LAIN != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                                    order by STAMP 
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    $pageActive =  $halamanAktif - 1;
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        }
                    }

                    $nominalBayar       = rupiahFormat($nominalBayarPangkal);
                    $ketPembayaran      = $ketPembayaranPangkal;
                    break;
                case 'KEGIATAN':
                    $nominalBayarSPP;
                    $ketPembayaranSPP;

                    $nominalBayarPangkal;
                    $ketPembayaranPangkal;

                    $nominalBayarKegiatan   = str_replace(["Rp ", "Rp. ", ".", ","], "", $_POST['nominalBayar']);
                    $ketPembayaranKegiatan  = mysqli_real_escape_string($con, htmlspecialchars($_POST['ketPembayaran']));
                    // echo $ketPembayaranKegiatan;exit;

                    $nominalBayarBuku;
                    $ketPembayaranBuku;

                    $nominalBayarSeragam;
                    $ketPembayaranSeragam;

                    $nominalBayarRegistrasi;
                    $ketPembayaranRegistrasi;

                    $nominalBayarLain;
                    $ketPembayaranLain;

                    // $_SESSION['form_success'] = "data_update";

                    if ($currentFilter == 'SPP') {

                        if ($pembayaranVIA == 'kosong') {

                            $queryUpdate = "
                                UPDATE `u415776667_spp`.`input_data_sd_lama1` 
                                SET 
                                `DATE`='$tglPembayaranDB', 
                                `BULAN`='$pembayaranBulanDB', 
                                `SPP`='$nominalBayarSPP', 
                                `SPP_txt`=NULL, 
                                `KEGIATAN`='$nominalBayarKegiatan',
                                `KEGIATAN_txt`='$ketPembayaranKegiatan',
                                `TRANSAKSI`=NULL,
                                `INPUTER`='$getNamaInputer',
                                `STAMP`='$data_stamp'
                                WHERE `ID`= '$idInvoice'
                            ";

                        } elseif ($pembayaranVIA != 'kosong') {

                            $queryUpdate = "
                                UPDATE `u415776667_spp`.`input_data_sd_lama1` 
                                SET 
                                `DATE`='$tglPembayaranDB', 
                                `BULAN`='$pembayaranBulanDB', 
                                `SPP`='$nominalBayarSPP', 
                                `SPP_txt`=NULL, 
                                `KEGIATAN`='$nominalBayarKegiatan',
                                `KEGIATAN_txt`='$ketPembayaranKegiatan',
                                `TRANSAKSI`='$pembayaranVIA',
                                `INPUTER`='$getNamaInputer',
                                `STAMP`='$data_stamp'
                                WHERE `ID`= '$idInvoice'
                            ";

                        }

                        mysqli_query($con, $queryUpdate);

                        if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {
                            $setSesiPageFilterBy = 1;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, SPP, TRANSAKSI, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_sd_lama1
                                    WHERE
                                    SPP != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;

                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        } elseif ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 8;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, SPP, TRANSAKSI, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_sd_lama1
                                    WHERE
                                    SPP != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                                    order by STAMP 
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    $pageActive =  $halamanAktif - 1;
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        }

                    } elseif ($currentFilter == 'PANGKAL') {
                        if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {
                            $setSesiPageFilterBy = 2;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, PANGKAL, TRANSAKSI, BULAN AS pembayaran_bulan, PANGKAL_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_sd
                                    WHERE
                                    PANGKAL != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        } elseif ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 9;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;

                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, PANGKAL, TRANSAKSI, BULAN AS pembayaran_bulan, PANGKAL_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_sd
                                    WHERE
                                    PANGKAL != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                                    order by STAMP 
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    $pageActive =  $halamanAktif - 1;
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;

                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        }
                    } elseif ($currentFilter == 'KEGIATAN') {

                        if ($pembayaranVIA == 'kosong') {

                            $queryUpdate = "
                                UPDATE `u415776667_spp`.`input_data_sd_lama1` 
                                SET 
                                `DATE`='$tglPembayaranDB', 
                                `BULAN`='$pembayaranBulanDB', 
                                `KEGIATAN`='$nominalBayarKegiatan', 
                                `KEGIATAN_txt`='$ketPembayaranKegiatan'
                                `TRANSAKSI`=NULL,
                                `INPUTER`='$getNamaInputer',
                                `STAMP`='$data_stamp'
                                WHERE  `ID`= '$idInvoice'
                            ";

                        } elseif($pembayaranVIA != 'kosong') {

                            $queryUpdate = "
                                UPDATE `u415776667_spp`.`input_data_sd_lama1` 
                                SET 
                                `DATE`='$tglPembayaranDB', 
                                `BULAN`='$pembayaranBulanDB', 
                                `KEGIATAN`='$nominalBayarKegiatan', 
                                `KEGIATAN_txt`='$ketPembayaranKegiatan',
                                `TRANSAKSI`='$pembayaranVIA',
                                `INPUTER`='$getNamaInputer',
                                `STAMP`='$data_stamp'
                                WHERE  `ID`= '$idInvoice'
                            ";

                        }

                        mysqli_query($con, $queryUpdate);

                        if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {
                            $setSesiPageFilterBy =  3;

                            // echo "Sini";exit;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, KEGIATAN, TRANSAKSI, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_sd_lama1
                                    WHERE
                                    KEGIATAN != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;

                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }

                        } elseif ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {

                            $setSesiPageFilterBy = 10;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, KEGIATAN, TRANSAKSI, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_sd_lama1
                                    WHERE
                                    KEGIATAN != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                                    order by STAMP 
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        }

                    } elseif ($currentFilter == 'BUKU') {
                        if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {
                            $setSesiPageFilterBy = 4;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, BUKU, TRANSAKSI, BULAN AS pembayaran_bulan, BUKU_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_sd
                                    WHERE
                                    BUKU != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        } elseif ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 11;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;

                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, BUKU, TRANSAKSI, BULAN AS pembayaran_bulan, BUKU_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_sd
                                    WHERE
                                    BUKU != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                                    order by STAMP 
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;

                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        }
                    } elseif ($currentFilter == 'SERAGAM') {
                        if ($pembayaranVIA == 'kosong') {

                            $queryUpdate = "
                                UPDATE `u415776667_spp`.`input_data_sd_lama1` 
                                SET 
                                `DATE`='$tglPembayaranDB', 
                                `BULAN`='$pembayaranBulanDB', 
                                `KEGIATAN`='$nominalBayarKegiatan', 
                                `KEGIATAN_txt`='$ketPembayaranKegiatan',
                                `SERAGAM`='$nominalBayarSeragam',
                                `SERAGAM_txt`=NULL,
                                `TRANSAKSI`=NULL,
                                `INPUTER`='$getNamaInputer',
                                `STAMP`='$data_stamp'
                                WHERE  `ID`= '$idInvoice'
                            ";

                        } elseif($pembayaranVIA != 'kosong') {

                            $queryUpdate = "
                                UPDATE `u415776667_spp`.`input_data_sd_lama1` 
                                SET 
                                `DATE`='$tglPembayaranDB', 
                                `BULAN`='$pembayaranBulanDB', 
                                `KEGIATAN`='$nominalBayarKegiatan', 
                                `KEGIATAN_txt`='$ketPembayaranKegiatan',
                                `SERAGAM`='$nominalBayarSeragam',
                                `SERAGAM_txt`=NULL,
                                `TRANSAKSI`='$pembayaranVIA',
                                `INPUTER`='$getNamaInputer',
                                `STAMP`='$data_stamp'
                                WHERE  `ID`= '$idInvoice'
                            ";

                        }

                        mysqli_query($con, $queryUpdate);

                        if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {
                            $setSesiPageFilterBy =  5;

                            // echo "Sini";exit;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, SERAGAM, TRANSAKSI, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_sd_lama1
                                    WHERE
                                    SERAGAM != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;

                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        } elseif ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 12;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, SERAGAM, TRANSAKSI, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_sd_lama1
                                    WHERE
                                    SERAGAM != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                                    order by STAMP 
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        }
                    } elseif ($currentFilter == 'REGISTRASI') {
                        if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {
                            $setSesiPageFilterBy =  6;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, REGISTRASI, TRANSAKSI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_sd
                                    WHERE
                                    REGISTRASI != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;

                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        } elseif ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 13;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, REGISTRASI, TRANSAKSI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_sd
                                    WHERE
                                    REGISTRASI != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                                    order by STAMP 
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        }
                    } elseif ($currentFilter == 'LAIN') {
                        if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {
                            $setSesiPageFilterBy = 7;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, LAIN, TRANSAKSI, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_sd
                                    WHERE
                                    LAIN != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;

                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        } elseif ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 14;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, LAIN, TRANSAKSI, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_sd
                                    WHERE
                                    LAIN != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                                    order by STAMP 
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        }
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

                    $nominalBayarBuku   = str_replace(["Rp ", "Rp. ", ".", ","], "", $_POST['nominalBayar']);
                    $ketPembayaranBuku  = mysqli_real_escape_string($con, htmlspecialchars($_POST['ketPembayaran']));

                    $nominalBayarSeragam;
                    $ketPembayaranSeragam;

                    $nominalBayarRegistrasi;
                    $ketPembayaranRegistrasi;

                    $nominalBayarLain;
                    $ketPembayaranLain;
                    
                    if ($currentFilter == 'SPP') {

                        if ($pembayaranVIA == 'kosong') {

                            $queryUpdate = "
                                UPDATE `u415776667_spp`.`input_data_sd_lama1` 
                                SET 
                                `DATE`='$tglPembayaranDB', 
                                `BULAN`='$pembayaranBulanDB', 
                                `SPP`='$nominalBayarSPP', 
                                `SPP_txt`=NULL, 
                                `BUKU`='$nominalBayarBuku',
                                `BUKU_txt`='$ketPembayaranBuku',
                                `TRANSAKSI`=NULL,
                                `INPUTER`='$getNamaInputer',
                                `STAMP`='$data_stamp'
                                WHERE  `ID`= '$idInvoice'
                            ";

                        } elseif ($pembayaranVIA != 'kosong') {

                            $queryUpdate = "
                                UPDATE `u415776667_spp`.`input_data_sd_lama1` 
                                SET 
                                `DATE`='$tglPembayaranDB', 
                                `BULAN`='$pembayaranBulanDB', 
                                `SPP`='$nominalBayarSPP', 
                                `SPP_txt`=NULL, 
                                `BUKU`='$nominalBayarBuku',
                                `BUKU_txt`='$ketPembayaranBuku',
                                `TRANSAKSI`='$pembayaranVIA',
                                `INPUTER`='$getNamaInputer',
                                `STAMP`='$data_stamp'
                                WHERE  `ID`= '$idInvoice'
                            ";

                        }

                        mysqli_query($con, $queryUpdate);

                        if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {
                            $setSesiPageFilterBy = 1;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, SPP, TRANSAKSI, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_sd_lama1
                                    WHERE
                                    SPP != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        } elseif ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 8;
                            // echo "Sini " . $namaSiswa;exit;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;

                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, SPP, TRANSAKSI, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_sd_lama1
                                    WHERE
                                    SPP != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                                    order by STAMP 
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);
                                // echo "Jumlah Data " . "<br>";

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;

                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        }

                    } elseif ($currentFilter == 'PANGKAL') {
                        if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {
                            $setSesiPageFilterBy = 2;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, PANGKAL, TRANSAKSI, BULAN AS pembayaran_bulan, PANGKAL_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_sd
                                    WHERE
                                    PANGKAL != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;

                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        } elseif ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 9;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, PANGKAL, TRANSAKSI, BULAN AS pembayaran_bulan, PANGKAL_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_sd
                                    WHERE
                                    PANGKAL != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                                    order by STAMP 
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        }
                    } elseif ($currentFilter == 'KEGIATAN') {
                        if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {
                            $setSesiPageFilterBy = 3;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, KEGIATAN, TRANSAKSI, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_sd
                                    WHERE
                                    KEGIATAN != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        } elseif ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 10;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;

                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, KEGIATAN, TRANSAKSI, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_sd
                                    WHERE
                                    KEGIATAN != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                                    order by STAMP 
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;

                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        }
                    } elseif ($currentFilter == 'BUKU') {

                        if ($pembayaranVIA == 'kosong') {

                            $queryUpdate = "
                                UPDATE `u415776667_spp`.`input_data_sd_lama1` 
                                SET 
                                `DATE`='$tglPembayaranDB', 
                                `BULAN`='$pembayaranBulanDB', 
                                `BUKU`='$nominalBayarBuku',
                                `BUKU_txt`='$ketPembayaranBuku',
                                `TRANSAKSI`=NULL,
                                `INPUTER`='$getNamaInputer',
                                `STAMP`='$data_stamp'
                                WHERE  `ID`= '$idInvoice'
                            ";

                        } elseif ($pembayaranVIA != 'kosong') {

                            $queryUpdate = "
                                UPDATE `u415776667_spp`.`input_data_sd_lama1` 
                                SET 
                                `DATE`='$tglPembayaranDB', 
                                `BULAN`='$pembayaranBulanDB', 
                                `BUKU`='$nominalBayarBuku',
                                `BUKU_txt`='$ketPembayaranBuku',
                                `TRANSAKSI`='$pembayaranVIA',
                                `INPUTER`='$getNamaInputer',
                                `STAMP`='$data_stamp'
                                WHERE  `ID`= '$idInvoice'
                            ";

                        }

                        mysqli_query($con, $queryUpdate);

                        if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {
                            $setSesiPageFilterBy = 4;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, BUKU, TRANSAKSI, BULAN AS pembayaran_bulan, BUKU_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_sd_lama1
                                    WHERE
                                    BUKU != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        } elseif ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 11;
                            // echo "Sini " . $namaSiswa;exit;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;

                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, BUKU, TRANSAKSI, BULAN AS pembayaran_bulan, BUKU_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_sd_lama1
                                    WHERE
                                    BUKU != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                                    order by STAMP 
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);
                                // echo "Jumlah Data " . "<br>";

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;

                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        }

                    } elseif ($currentFilter == 'SERAGAM') {
                        if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {
                            $setSesiPageFilterBy = 5;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, SERAGAM, TRANSAKSI, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_sd
                                    WHERE
                                    SERAGAM != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;

                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        } elseif ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 12;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, SERAGAM, TRANSAKSI, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_sd
                                    WHERE
                                    SERAGAM != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                                    order by STAMP 
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        }
                    } elseif ($currentFilter == 'REGISTRASI') {
                        if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {
                            $setSesiPageFilterBy = 6;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, REGISTRASI, TRANSAKSI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_sd
                                    WHERE
                                    REGISTRASI != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;

                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        } elseif ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 13;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, REGISTRASI, TRANSAKSI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_sd
                                    WHERE
                                    REGISTRASI != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                                    order by STAMP 
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        }
                    } elseif ($currentFilter == 'LAIN') {
                        if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {
                            $setSesiPageFilterBy = 7;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, LAIN, TRANSAKSI, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_sd
                                    WHERE
                                    LAIN != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;

                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        } elseif ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 14;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, LAIN, TRANSAKSI, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_sd
                                    WHERE
                                    LAIN != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                                    order by STAMP 
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        }
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

                    $nominalBayarSeragam   = str_replace(["Rp ", "Rp. ", ".", ","], "", $_POST['nominalBayar']);
                    $ketPembayaranSeragam  = mysqli_real_escape_string($con, htmlspecialchars($_POST['ketPembayaran']));

                    $nominalBayarRegistrasi;
                    $ketPembayaranRegistrasi;

                    $nominalBayarLain;
                    $ketPembayaranLain;
                    
                    if ($currentFilter == 'SPP') {

                        if ($pembayaranVIA == 'kosong') {

                            $queryUpdate = "
                                UPDATE `u415776667_spp`.`input_data_sd_lama1` 
                                SET 
                                `DATE`='$tglPembayaranDB', 
                                `BULAN`='$pembayaranBulanDB', 
                                `SPP`='$nominalBayarSPP', 
                                `SPP_txt`=NULL, 
                                `SERAGAM`='$nominalBayarSeragam',
                                `SERAGAM_txt`='$ketPembayaranSeragam',
                                `TRANSAKSI`=NULL,
                                `INPUTER`='$getNamaInputer',
                                `STAMP`='$data_stamp'
                                WHERE  `ID`= '$idInvoice'
                            ";

                        } elseif ($pembayaranVIA != 'kosong') {

                            $queryUpdate = "
                                UPDATE `u415776667_spp`.`input_data_sd_lama1` 
                                SET 
                                `DATE`='$tglPembayaranDB', 
                                `BULAN`='$pembayaranBulanDB', 
                                `SPP`='$nominalBayarSPP', 
                                `SPP_txt`=NULL, 
                                `SERAGAM`='$nominalBayarSeragam',
                                `SERAGAM_txt`='$ketPembayaranSeragam',
                                `TRANSAKSI`='$pembayaranVIA',
                                `INPUTER`='$getNamaInputer',
                                `STAMP`='$data_stamp'
                                WHERE  `ID`= '$idInvoice'
                            ";

                        }

                        mysqli_query($con, $queryUpdate);

                        if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {
                            $setSesiPageFilterBy =  1;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, SPP, TRANSAKSI, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_sd_lama1
                                    WHERE
                                    SPP != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;

                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        } elseif ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 8;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, SPP, TRANSAKSI, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_sd_lama1
                                    WHERE
                                    SPP != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                                    order by STAMP 
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        }

                    } elseif ($currentFilter == 'PANGKAL') {

                        if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {
                            $setSesiPageFilterBy = 2;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, PANGKAL, TRANSAKSI, BULAN AS pembayaran_bulan, PANGKAL_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_sd_lama1
                                    WHERE
                                    PANGKAL != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;

                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        } elseif ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 9;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, PANGKAL, TRANSAKSI, BULAN AS pembayaran_bulan, PANGKAL_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_sd_lama1
                                    WHERE
                                    PANGKAL != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                                    order by STAMP 
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    $pageActive =  $halamanAktif - 1;
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        }

                    } elseif ($currentFilter == 'KEGIATAN') {

                        if ($pembayaranVIA == 'kosong') {

                            $queryUpdate = "
                                UPDATE `u415776667_spp`.`input_data_sd_lama1` 
                                SET 
                                `DATE`='$tglPembayaranDB', 
                                `BULAN`='$pembayaranBulanDB', 
                                `KEGIATAN`='$nominalBayarKegiatan', 
                                `KEGIATAN_txt`=NULL,
                                `SERAGAM`='$nominalBayarSeragam',
                                `SERAGAM_txt`='$ketPembayaranSeragam',
                                `TRANSAKSI`=NULL,
                                `INPUTER`='$getNamaInputer',
                                `STAMP`='$data_stamp'
                                WHERE  `ID`= '$idInvoice'
                            ";

                        } else if ($pembayaranVIA != 'kosong') {

                            $queryUpdate = "
                                UPDATE `u415776667_spp`.`input_data_sd_lama1` 
                                SET 
                                `DATE`='$tglPembayaranDB', 
                                `BULAN`='$pembayaranBulanDB', 
                                `KEGIATAN`='$nominalBayarKegiatan', 
                                `KEGIATAN_txt`=NULL,
                                `SERAGAM`='$nominalBayarSeragam',
                                `SERAGAM_txt`='$ketPembayaranSeragam',
                                `TRANSAKSI`='$pembayaranVIA',
                                `INPUTER`='$getNamaInputer',
                                `STAMP`='$data_stamp'
                                WHERE  `ID`= '$idInvoice'
                            ";

                        }

                        mysqli_query($con, $queryUpdate);

                        if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {
                            $setSesiPageFilterBy =  3;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, KEGIATAN, TRANSAKSI, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_sd_lama1
                                    WHERE
                                    KEGIATAN != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;

                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        } elseif ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 10;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, KEGIATAN, TRANSAKSI, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_sd_lama1
                                    WHERE
                                    KEGIATAN != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                                    order by STAMP 
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        }
                    } elseif ($currentFilter == 'BUKU') {
                        if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {
                            $setSesiPageFilterBy = 4;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, BUKU, TRANSAKSI, BULAN AS pembayaran_bulan, BUKU_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_sd
                                    WHERE
                                    BUKU != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;

                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        } elseif ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 11;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, BUKU, TRANSAKSI, BULAN AS pembayaran_bulan, BUKU_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_sd
                                    WHERE
                                    BUKU != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                                    order by STAMP 
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        }
                    } elseif ($currentFilter == 'SERAGAM') {
                        
                        if ($pembayaranVIA == 'kosong') {

                            $queryUpdate = "
                                UPDATE `u415776667_spp`.`input_data_sd_lama1` 
                                SET 
                                `DATE`='$tglPembayaranDB', 
                                `BULAN`='$pembayaranBulanDB', 
                                `SERAGAM`='$nominalBayarSeragam',
                                `SERAGAM_txt`='$ketPembayaranSeragam',
                                `TRANSAKSI`=NULL,
                                `INPUTER`='$getNamaInputer',
                                `STAMP`='$data_stamp'
                                WHERE  `ID`= '$idInvoice'
                            ";

                        } elseif ($pembayaranVIA != 'kosong') {

                            $queryUpdate = "
                                UPDATE `u415776667_spp`.`input_data_sd_lama1` 
                                SET 
                                `DATE`='$tglPembayaranDB', 
                                `BULAN`='$pembayaranBulanDB', 
                                `SERAGAM`='$nominalBayarSeragam',
                                `SERAGAM_txt`='$ketPembayaranSeragam',
                                `TRANSAKSI`='$pembayaranVIA',
                                `INPUTER`='$getNamaInputer',
                                `STAMP`='$data_stamp'
                                WHERE  `ID`= '$idInvoice'
                            ";

                        }

                        mysqli_query($con, $queryUpdate);

                        if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {
                            $setSesiPageFilterBy = 5;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, SERAGAM, TRANSAKSI, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_sd_lama1
                                    WHERE
                                    SERAGAM != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }

                        } elseif ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 12;
                            // echo "Sini " . $namaSiswa;exit;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;

                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, SERAGAM, TRANSAKSI, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_sd_lama1
                                    WHERE
                                    SERAGAM != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                                    order by STAMP 
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);
                                // echo "Jumlah Data " . "<br>";

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;

                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }

                        }

                    } elseif ($currentFilter == 'REGISTRASI') {
                        if ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 13;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        } else if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59") {
                            $setSesiPageFilterBy = 6;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        }
                    } elseif ($currentFilter == 'LAIN') {
                        if ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 14;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        } else if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59") {
                            $setSesiPageFilterBy = 7;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        }
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

                    $nominalBayarRegistrasi   = str_replace(["Rp ", "Rp. ", ".", ","], "", $_POST['nominalBayar']);
                    $ketPembayaranRegistrasi  = mysqli_real_escape_string($con, htmlspecialchars($_POST['ketPembayaran']));

                    $nominalBayarLain;
                    $ketPembayaranLain;

                    if ($currentFilter == 'SPP') {

                        if ($pembayaranVIA == 'kosong') {

                            $queryUpdate = "
                                UPDATE `u415776667_spp`.`input_data_sd_lama1` 
                                SET 
                                `DATE`='$tglPembayaranDB', 
                                `BULAN`='$pembayaranBulanDB', 
                                `SPP`='$nominalBayarSPP', 
                                `SPP_txt`=NULL,
                                `REGISTRASI`='$nominalBayarRegistrasi',
                                `REGISTRASI_txt`='$ketPembayaranRegistrasi',
                                `TRANSAKSI`=NULL,
                                `INPUTER`='$getNamaInputer',
                                `STAMP`='$data_stamp'
                                WHERE  `ID`= '$idInvoice'
                            ";

                        } else if ($pembayaranVIA != 'kosong') {

                            $queryUpdate = "
                                UPDATE `u415776667_spp`.`input_data_sd_lama1` 
                                SET 
                                `DATE`='$tglPembayaranDB', 
                                `BULAN`='$pembayaranBulanDB', 
                                `SPP`='$nominalBayarSPP', 
                                `SPP_txt`=NULL,
                                `REGISTRASI`='$nominalBayarRegistrasi',
                                `REGISTRASI_txt`='$ketPembayaranRegistrasi',
                                `TRANSAKSI`='$pembayaranVIA',
                                `INPUTER`='$getNamaInputer',
                                `STAMP`='$data_stamp'
                                WHERE  `ID`= '$idInvoice'
                            ";

                        }

                        mysqli_query($con, $queryUpdate);

                        if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {
                            $setSesiPageFilterBy = 1;

                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, SPP, TRANSAKSI, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_sd_lama1
                                    WHERE
                                    SPP != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;

                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        } elseif ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 8;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, SPP, TRANSAKSI, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_sd_lama1
                                    WHERE
                                    SPP != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                                    order by STAMP 
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        }

                    } elseif ($currentFilter == 'PANGKAL') {
                        if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {
                            $setSesiPageFilterBy = 2;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, PANGKAL, TRANSAKSI, BULAN AS pembayaran_bulan, PANGKAL_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_sd
                                    WHERE
                                    PANGKAL != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;

                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        } elseif ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 9;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, PANGKAL, TRANSAKSI, BULAN AS pembayaran_bulan, PANGKAL_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_sd
                                    WHERE
                                    PANGKAL != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                                    order by STAMP 
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    $pageActive =  $halamanAktif - 1;
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        }
                    } elseif ($currentFilter == 'KEGIATAN') {
                        if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {
                            $setSesiPageFilterBy =  3;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, KEGIATAN, TRANSAKSI, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_sd
                                    WHERE
                                    KEGIATAN != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;

                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        } elseif ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 10;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, KEGIATAN, TRANSAKSI, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_sd
                                    WHERE
                                    KEGIATAN != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                                    order by STAMP 
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        }
                    } elseif ($currentFilter == 'BUKU') {
                        if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {
                            $setSesiPageFilterBy = 4;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, BUKU, TRANSAKSI, BULAN AS pembayaran_bulan, BUKU_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_sd
                                    WHERE
                                    BUKU != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;

                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        } elseif ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 11;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, BUKU, TRANSAKSI, BULAN AS pembayaran_bulan, BUKU_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_sd
                                    WHERE
                                    BUKU != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                                    order by STAMP 
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        }
                    } elseif ($currentFilter == 'SERAGAM') {
                        if ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 12;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        } else if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59") {
                            $setSesiPageFilterBy = 5;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        }
                    } elseif ($currentFilter == 'REGISTRASI') {

                        if ($pembayaranVIA == 'kosong') {

                            $queryUpdate = "
                                UPDATE `u415776667_spp`.`input_data_sd_lama1` 
                                SET 
                                `DATE`='$tglPembayaranDB', 
                                `BULAN`='$pembayaranBulanDB', 
                                `REGISTRASI`='$nominalBayarRegistrasi',
                                `REGISTRASI_txt`='$ketPembayaranRegistrasi',
                                `TRANSAKSI`=NULL,
                                `INPUTER`='$getNamaInputer',
                                `STAMP`='$data_stamp'
                                WHERE  `ID`= '$idInvoice'
                            ";

                        } elseif ($pembayaranVIA != 'kosong') {

                            $queryUpdate = "
                                UPDATE `u415776667_spp`.`input_data_sd_lama1` 
                                SET 
                                `DATE`='$tglPembayaranDB', 
                                `BULAN`='$pembayaranBulanDB', 
                                `REGISTRASI`='$nominalBayarRegistrasi',
                                `REGISTRASI_txt`='$ketPembayaranRegistrasi',
                                `TRANSAKSI`='$pembayaranVIA',
                                `INPUTER`='$getNamaInputer',
                                `STAMP`='$data_stamp'
                                WHERE  `ID`= '$idInvoice'
                            ";

                        }

                        mysqli_query($con, $queryUpdate);

                        if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {
                            $setSesiPageFilterBy = 6;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, REGISTRASI, TRANSAKSI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_sd_lama1
                                    WHERE
                                    REGISTRASI != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }

                        } elseif ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 13;
                            // echo "Sini " . $namaSiswa;exit;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;

                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, REGISTRASI, TRANSAKSI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_sd_lama1
                                    WHERE
                                    REGISTRASI != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                                    order by STAMP 
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);
                                // echo "Jumlah Data " . "<br>";

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;

                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }

                        }

                    } elseif ($currentFilter == 'LAIN') {
                        if ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 14;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        } else if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59") {
                            $setSesiPageFilterBy = 7;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        }
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

                    $nominalBayarLain   = str_replace(["Rp ", "Rp. ", ".", ","], "", $_POST['nominalBayar']);
                    $ketPembayaranLain  = mysqli_real_escape_string($con, htmlspecialchars($_POST['ketPembayaran']));

                    if ($currentFilter == 'SPP') {

                        if ($pembayaranVIA == 'kosong') {

                            $queryUpdate = "
                                UPDATE `u415776667_spp`.`input_data_sd_lama1` 
                                SET 
                                `DATE`='$tglPembayaranDB', 
                                `BULAN`='$pembayaranBulanDB', 
                                `SPP`='$nominalBayarSPP', 
                                `SPP_txt`=NULL,
                                `LAIN`='$nominalBayarLain',
                                `LAIN_txt`='$ketPembayaranLain',
                                `TRANSAKSI`=NULL,
                                `INPUTER`='$getNamaInputer',
                                `STAMP`='$data_stamp'
                                WHERE  `ID`= '$idInvoice'
                            ";

                        } elseif ($pembayaranVIA != 'kosong') {

                            $queryUpdate = "
                                UPDATE `u415776667_spp`.`input_data_sd_lama1` 
                                SET 
                                `DATE`='$tglPembayaranDB', 
                                `BULAN`='$pembayaranBulanDB', 
                                `SPP`='$nominalBayarSPP', 
                                `SPP_txt`=NULL,
                                `LAIN`='$nominalBayarLain',
                                `LAIN_txt`='$ketPembayaranLain',
                                `TRANSAKSI`='$pembayaranVIA',
                                `INPUTER`='$getNamaInputer',
                                `STAMP`='$data_stamp'
                                WHERE  `ID`= '$idInvoice'
                            ";

                        }

                        mysqli_query($con, $queryUpdate);
                        // $_SESSION['form_success'] = "data_update";

                        if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {
                            $setSesiPageFilterBy = 1;

                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, SPP, TRANSAKSI, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_sd_lama1
                                    WHERE
                                    SPP != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;

                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        } elseif ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 8;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, SPP, TRANSAKSI, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_sd_lama1
                                    WHERE
                                    SPP != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                                    order by STAMP 
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        }

                    } elseif ($currentFilter == 'PANGKAL') {
                        if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {
                            $setSesiPageFilterBy = 2;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, LAIN, TRANSAKSI, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_sd
                                    WHERE
                                    LAIN != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;

                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        } elseif ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 9;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, LAIN, TRANSAKSI, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_sd
                                    WHERE
                                    LAIN != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                                    order by STAMP 
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    $pageActive =  $halamanAktif - 1;
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        }
                    } elseif ($currentFilter == 'KEGIATAN') {
                        if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {
                            $setSesiPageFilterBy = 3;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, KEGIATAN, TRANSAKSI, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_sd
                                    WHERE
                                    KEGIATAN != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;

                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        } elseif ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 10;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, KEGIATAN, TRANSAKSI, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_sd
                                    WHERE
                                    KEGIATAN != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                                    order by STAMP 
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        }
                    } elseif ($currentFilter == 'BUKU') {
                        if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {
                            $setSesiPageFilterBy = 4;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, BUKU, TRANSAKSI, BULAN AS pembayaran_bulan, BUKU_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_sd
                                    WHERE
                                    BUKU != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;

                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        } elseif ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 11;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, BUKU, TRANSAKSI, BULAN AS pembayaran_bulan, BUKU_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_sd
                                    WHERE
                                    BUKU != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                                    order by STAMP 
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        }
                    } elseif ($currentFilter == 'SERAGAM') {
                        if ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 12;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        } else if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59") {
                            $setSesiPageFilterBy = 5;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        }
                    } elseif ($currentFilter == 'REGISTRASI') {
                        if ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 13;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        } else if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59") {
                            $setSesiPageFilterBy = 6;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        }
                    } elseif ($currentFilter == 'LAIN') {
                        
                        if ($pembayaranVIA == 'kosong') {

                            $queryUpdate = "
                                UPDATE `u415776667_spp`.`input_data_sd_lama1` 
                                SET 
                                `DATE`='$tglPembayaranDB', 
                                `BULAN`='$pembayaranBulanDB', 
                                `LAIN`='$nominalBayarLain',
                                `LAIN_txt`='$ketPembayaranLain',
                                `TRANSAKSI`=NULL,
                                `INPUTER`='$getNamaInputer',
                                `STAMP`='$data_stamp'
                                WHERE  `ID`= '$idInvoice'
                            ";

                        } elseif ($pembayaranVIA != 'kosong') {

                            $queryUpdate = "
                                UPDATE `u415776667_spp`.`input_data_sd_lama1` 
                                SET 
                                `DATE`='$tglPembayaranDB', 
                                `BULAN`='$pembayaranBulanDB', 
                                `LAIN`='$nominalBayarLain',
                                `LAIN_txt`='$ketPembayaranLain',
                                `TRANSAKSI`='$pembayaranVIA',
                                `INPUTER`='$getNamaInputer',
                                `STAMP`='$data_stamp'
                                WHERE  `ID`= '$idInvoice'
                            ";

                        }

                        mysqli_query($con, $queryUpdate);

                        if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {
                            $setSesiPageFilterBy = 7;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, LAIN, TRANSAKSI, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_sd_lama1
                                    WHERE
                                    LAIN != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }

                        } elseif ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 14;

                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;

                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, LAIN, TRANSAKSI, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_sd_lama1
                                    WHERE
                                    LAIN != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                                    order by STAMP 
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);
                                // echo "Jumlah Data " . "<br>";

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;

                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }

                        }

                    }

                    $nominalBayar       = rupiahFormat($nominalBayarLain);
                    $ketPembayaran      = $ketPembayaranLain;
                    break;
            }

        } else if ($_SESSION['c_accounting'] == 'accounting2') {

            switch ($typeFilter) {
                case "SPP" :
                    $nominalBayarSPP        = str_replace(["Rp ", "Rp. ", ".", ","], "", $_POST['nominalBayar']);
                    $ketPembayaranSPP       = mysqli_real_escape_string($con, htmlspecialchars($_POST['ketPembayaran']));
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

                    if ($currentFilter == 'SPP') {

                        if ($pembayaranVIA == 'kosong') {

                            $queryUpdate = "
                                UPDATE `u415776667_spp`.`input_data_tk_lama` 
                                SET 
                                `DATE`='$tglPembayaranDB', 
                                `BULAN`='$pembayaranBulanDB', 
                                `SPP`='$nominalBayarSPP', 
                                `SPP_txt`='$ketPembayaranSPP', 
                                `TRANSAKSI`=NULL,
                                `INPUTER`='$getNamaInputer',
                                `STAMP`='$data_stamp'
                                WHERE `ID`= '$idInvoice'
                            ";

                        } elseif ($pembayaranVIA != 'kosong') {

                            $queryUpdate = "
                                UPDATE `u415776667_spp`.`input_data_tk_lama` 
                                SET 
                                `DATE`='$tglPembayaranDB', 
                                `BULAN`='$pembayaranBulanDB', 
                                `SPP`='$nominalBayarSPP', 
                                `SPP_txt`='$ketPembayaranSPP', 
                                `TRANSAKSI`='$pembayaranVIA',
                                `INPUTER`='$getNamaInputer',
                                `STAMP`='$data_stamp'
                                WHERE `ID`= '$idInvoice'
                            ";

                        }

                        mysqli_query($con, $queryUpdate);

                        if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {

                            $setSesiPageFilterBy = 1;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, SPP, TRANSAKSI, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_tk_lama
                                    WHERE
                                    SPP != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;

                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        } elseif ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 8;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, SPP, TRANSAKSI, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_tk_lama
                                    WHERE
                                    SPP != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                                    order by STAMP 
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    $pageActive =  $halamanAktif - 1;
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        }

                    } elseif ($currentFilter == 'PANGKAL') {

                        if ($pembayaranVIA == 'kosong') {

                            $queryUpdate = "
                                UPDATE `u415776667_spp`.`input_data_tk_lama` 
                                SET 
                                `DATE`='$tglPembayaranDB', 
                                `BULAN`='$pembayaranBulanDB', 
                                `SPP`='$nominalBayarSPP', 
                                `SPP_txt`='$ketPembayaranSPP', 
                                `PANGKAL`='$nominalBayarPangkal',
                                `PANGKAL_txt`=NULL,
                                `TRANSAKSI`=NULL,
                                `INPUTER`='$getNamaInputer',
                                `STAMP`='$data_stamp'
                                WHERE `ID`= '$idInvoice'
                            ";

                        } elseif ($pembayaranVIA != 'kosong') {

                            $queryUpdate = "
                                UPDATE `u415776667_spp`.`input_data_tk_lama` 
                                SET 
                                `DATE`='$tglPembayaranDB', 
                                `BULAN`='$pembayaranBulanDB', 
                                `SPP`='$nominalBayarSPP', 
                                `SPP_txt`='$ketPembayaranSPP', 
                                `PANGKAL`='$nominalBayarPangkal',
                                `PANGKAL_txt`=NULL,
                                `TRANSAKSI`='$pembayaranVIA',
                                `INPUTER`='$getNamaInputer',
                                `STAMP`='$data_stamp'
                                WHERE `ID`= '$idInvoice'
                            ";

                        }

                        mysqli_query($con, $queryUpdate);

                        if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {
                            $setSesiPageFilterBy = 2;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, PANGKAL, TRANSAKSI, BULAN AS pembayaran_bulan, PANGKAL_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_tk_lama
                                    WHERE
                                    PANGKAL != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;

                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        } elseif ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 9;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, PANGKAL, TRANSAKSI, BULAN AS pembayaran_bulan, PANGKAL_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_tk_lama
                                    WHERE
                                    PANGKAL != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                                    order by STAMP 
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    $pageActive =  $halamanAktif - 1;
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        }

                    } elseif ($currentFilter == 'KEGIATAN') {

                        if ($pembayaranVIA == 'kosong') {

                            $queryUpdate = "
                                UPDATE `u415776667_spp`.`input_data_tk_lama` 
                                SET 
                                `DATE`='$tglPembayaranDB', 
                                `BULAN`='$pembayaranBulanDB', 
                                `SPP`='$nominalBayarSPP', 
                                `SPP_txt`='$ketPembayaranSPP', 
                                `KEGIATAN`='$nominalBayarKegiatan',
                                `KEGIATAN_txt`=NULL,
                                `TRANSAKSI`=NULL,
                                `INPUTER`='$getNamaInputer',
                                `STAMP`='$data_stamp'
                                WHERE `ID`= '$idInvoice'
                            ";

                        } elseif ($pembayaranVIA != 'kosong') {

                            $queryUpdate = "
                                UPDATE `u415776667_spp`.`input_data_tk_lama` 
                                SET 
                                `DATE`='$tglPembayaranDB', 
                                `BULAN`='$pembayaranBulanDB', 
                                `SPP`='$nominalBayarSPP', 
                                `SPP_txt`='$ketPembayaranSPP', 
                                `KEGIATAN`='$nominalBayarKegiatan',
                                `KEGIATAN_txt`=NULL,
                                `TRANSAKSI`='$pembayaranVIA',
                                `INPUTER`='$getNamaInputer',
                                `STAMP`='$data_stamp'
                                WHERE `ID`= '$idInvoice'
                            ";

                        }

                        mysqli_query($con, $queryUpdate);

                        if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {
                            
                            $setSesiPageFilterBy = 3;

                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, KEGIATAN, TRANSAKSI, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_tk_lama
                                    WHERE
                                    KEGIATAN != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;

                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }

                        } elseif ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {

                            $setSesiPageFilterBy = 10;

                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, KEGIATAN, TRANSAKSI, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_tk_lama
                                    WHERE
                                    KEGIATAN != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                                    order by STAMP 
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    $pageActive =  $halamanAktif - 1;
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                            
                        }

                    } elseif ($currentFilter == 'BUKU') {

                        if ($pembayaranVIA == 'kosong') {

                            $queryUpdate = "
                                UPDATE `u415776667_spp`.`input_data_tk_lama` 
                                SET 
                                `DATE`='$tglPembayaranDB', 
                                `BULAN`='$pembayaranBulanDB', 
                                `SPP`='$nominalBayarSPP', 
                                `SPP_txt`='$ketPembayaranSPP', 
                                `BUKU`='$nominalBayarBuku',
                                `BUKU_txt`=NULL,
                                `TRANSAKSI`=NULL,
                                `INPUTER`='$getNamaInputer',
                                `STAMP`='$data_stamp'
                                WHERE  `ID`= '$idInvoice'
                            ";

                        } elseif ($pembayaranVIA != 'kosong') {

                            $queryUpdate = "
                                UPDATE `u415776667_spp`.`input_data_tk_lama` 
                                SET 
                                `DATE`='$tglPembayaranDB', 
                                `BULAN`='$pembayaranBulanDB', 
                                `SPP`='$nominalBayarSPP', 
                                `SPP_txt`='$ketPembayaranSPP', 
                                `BUKU`='$nominalBayarBuku',
                                `BUKU_txt`=NULL,
                                `TRANSAKSI`='$pembayaranVIA',
                                `INPUTER`='$getNamaInputer',
                                `STAMP`='$data_stamp'
                                WHERE  `ID`= '$idInvoice'
                            ";

                        }

                        mysqli_query($con, $queryUpdate);

                        if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {
                            $setSesiPageFilterBy = 4;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, BUKU, TRANSAKSI, BULAN AS pembayaran_bulan, BUKU_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_tk_lama
                                    WHERE
                                    BUKU != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;

                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        } elseif ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 11;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, BUKU, TRANSAKSI, BULAN AS pembayaran_bulan, BUKU_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_tk_lama
                                    WHERE
                                    BUKU != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                                    order by STAMP 
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        }

                    } elseif ($currentFilter == 'SERAGAM') {

                        if ($pembayaranVIA == 'kosong') {

                            $queryUpdate = "
                                UPDATE `u415776667_spp`.`input_data_tk_lama` 
                                SET 
                                `DATE`='$tglPembayaranDB', 
                                `BULAN`='$pembayaranBulanDB', 
                                `SPP`='$nominalBayarSPP', 
                                `SPP_txt`='$ketPembayaranSPP', 
                                `SERAGAM`='$nominalBayarSeragam',
                                `SERAGAM_txt`=NULL,
                                `TRANSAKSI`=NULL,
                                `INPUTER`='$getNamaInputer',
                                `STAMP`='$data_stamp'
                                WHERE  `ID`= '$idInvoice'
                            ";

                        } elseif ($pembayaranVIA != 'kosong') {

                            $queryUpdate = "
                                UPDATE `u415776667_spp`.`input_data_tk_lama` 
                                SET 
                                `DATE`='$tglPembayaranDB', 
                                `BULAN`='$pembayaranBulanDB', 
                                `SPP`='$nominalBayarSPP', 
                                `SPP_txt`='$ketPembayaranSPP', 
                                `SERAGAM`='$nominalBayarSeragam',
                                `SERAGAM_txt`=NULL,
                                `TRANSAKSI`='$pembayaranVIA',
                                `INPUTER`='$getNamaInputer',
                                `STAMP`='$data_stamp'
                                WHERE  `ID`= '$idInvoice'
                            ";

                        }

                        mysqli_query($con, $queryUpdate);

                        if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {
                            $setSesiPageFilterBy = 5;

                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, SERAGAM, TRANSAKSI, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_tk_lama
                                    WHERE
                                    SERAGAM != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;

                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        } elseif ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 12;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, SERAGAM, TRANSAKSI, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_tk_lama
                                    WHERE
                                    SERAGAM != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                                    order by STAMP 
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        }

                    } elseif ($currentFilter == 'REGISTRASI') {

                        if ($pembayaranVIA == 'kosong') {

                            $queryUpdate = "
                                UPDATE `u415776667_spp`.`input_data_tk_lama` 
                                SET 
                                `DATE`='$tglPembayaranDB', 
                                `BULAN`='$pembayaranBulanDB', 
                                `SPP`='$nominalBayarSPP', 
                                `SPP_txt`='$ketPembayaranSPP', 
                                `REGISTRASI`='$nominalBayarRegistrasi',
                                `REGISTRASI_txt`=NULL,
                                `TRANSAKSI`=NULL,
                                `INPUTER`='$getNamaInputer',
                                `STAMP`='$data_stamp'
                                WHERE  `ID`= '$idInvoice'
                            ";

                        } elseif ($pembayaranVIA != 'kosong') {

                            $queryUpdate = "
                                UPDATE `u415776667_spp`.`input_data_tk_lama` 
                                SET 
                                `DATE`='$tglPembayaranDB', 
                                `BULAN`='$pembayaranBulanDB', 
                                `SPP`='$nominalBayarSPP', 
                                `SPP_txt`='$ketPembayaranSPP', 
                                `REGISTRASI`='$nominalBayarRegistrasi',
                                `REGISTRASI_txt`=NULL,
                                `TRANSAKSI`='$pembayaranVIA',
                                `INPUTER`='$getNamaInputer',
                                `STAMP`='$data_stamp'
                                WHERE  `ID`= '$idInvoice'
                            ";

                        }

                        mysqli_query($con, $queryUpdate);

                        if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {
                            $setSesiPageFilterBy = 6;

                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, REGISTRASI, TRANSAKSI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_tk_lama
                                    WHERE
                                    REGISTRASI != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;

                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }

                        } elseif ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 13;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, REGISTRASI, TRANSAKSI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_tk_lama
                                    WHERE
                                    REGISTRASI != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                                    order by STAMP 
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        }

                    } elseif ($currentFilter == 'LAIN') {

                        if ($pembayaranVIA == 'kosong') {

                            $queryUpdate = "
                                UPDATE `u415776667_spp`.`input_data_tk_lama` 
                                SET 
                                `DATE`='$tglPembayaranDB', 
                                `BULAN`='$pembayaranBulanDB', 
                                `SPP`='$nominalBayarSPP', 
                                `SPP_txt`='$ketPembayaranSPP', 
                                `LAIN`='$nominalBayarRegistrasi',
                                `LAIN_txt`=NULL,
                                `TRANSAKSI`=NULL,
                                `INPUTER`='$getNamaInputer',
                                `STAMP`='$data_stamp'
                                WHERE  `ID`= '$idInvoice'
                            ";

                        } elseif ($pembayaranVIA != 'kosong') {

                            $queryUpdate = "
                                UPDATE `u415776667_spp`.`input_data_tk_lama` 
                                SET 
                                `DATE`='$tglPembayaranDB', 
                                `BULAN`='$pembayaranBulanDB', 
                                `SPP`='$nominalBayarSPP', 
                                `SPP_txt`='$ketPembayaranSPP', 
                                `LAIN`='$nominalBayarRegistrasi',
                                `LAIN_txt`=NULL,
                                `TRANSAKSI`='$pembayaranVIA',
                                `INPUTER`='$getNamaInputer',
                                `STAMP`='$data_stamp'
                                WHERE  `ID`= '$idInvoice'
                            ";

                        }

                        mysqli_query($con, $queryUpdate);

                        if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {
                            $setSesiPageFilterBy = 7;

                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, LAIN, TRANSAKSI, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_tk_lama
                                    WHERE
                                    LAIN != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;

                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }

                        } elseif ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 14;

                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, LAIN, TRANSAKSI, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_tk_lama
                                    WHERE
                                    LAIN != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                                    order by STAMP 
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    $pageActive =  $halamanAktif - 1;
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }

                        }

                    }

                    $nominalBayar       = $nominalBayarSPP;
                    $ketPembayaran      = $ketPembayaranSPP;
                    break;
                case 'PANGKAL':
                    $nominalBayarSPP;
                    $ketPembayaranSPP;

                    $nominalBayarPangkal    = str_replace(["Rp ", "Rp. ", ".", ","], "", $_POST['nominalBayar']);
                    $ketPembayaranPangkal   = mysqli_real_escape_string($con, htmlspecialchars($_POST['ketPembayaran']));

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

                    if ($currentFilter == 'SPP') {

                        if ($pembayaranVIA == 'kosong') {

                            $queryUpdate = "
                                UPDATE `u415776667_spp`.`input_data_tk_lama` 
                                SET 
                                `DATE`='$tglPembayaranDB', 
                                `BULAN`='$pembayaranBulanDB', 
                                `SPP`='$nominalBayarSPP', 
                                `SPP_txt`=NULL, 
                                `PANGKAL`='$nominalBayarPangkal',
                                `PANGKAL_txt`='$ketPembayaranPangkal',
                                `TRANSAKSI`=NULL,
                                `INPUTER`='$getNamaInputer',
                                `STAMP`='$data_stamp'
                                WHERE `ID`= '$idInvoice'
                            ";

                        } elseif ($pembayaranVIA != 'kosong') {

                            $queryUpdate = "
                                UPDATE `u415776667_spp`.`input_data_tk_lama` 
                                SET 
                                `DATE`='$tglPembayaranDB', 
                                `BULAN`='$pembayaranBulanDB', 
                                `SPP`='$nominalBayarSPP', 
                                `SPP_txt`=NULL, 
                                `PANGKAL`='$nominalBayarPangkal',
                                `PANGKAL_txt`='$ketPembayaranPangkal',
                                `TRANSAKSI`='$pembayaranVIA',
                                `INPUTER`='$getNamaInputer',
                                `STAMP`='$data_stamp'
                                WHERE `ID`= '$idInvoice'
                            ";

                        }

                        mysqli_query($con, $queryUpdate);

                        if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {
                            $setSesiPageFilterBy = 1;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, SPP, TRANSAKSI, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_tk_lama
                                    WHERE
                                    SPP != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    order by STAMP 
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;

                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        } elseif ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 8;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, SPP, TRANSAKSI, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_tk_lama
                                    WHERE
                                    SPP != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                                    order by STAMP 
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        }
                    } elseif ($currentFilter == 'PANGKAL') {

                        if ($pembayaranVIA == 'kosong') {

                            $queryUpdate = "
                                UPDATE `u415776667_spp`.`input_data_tk_lama` 
                                SET 
                                `DATE`='$tglPembayaranDB', 
                                `BULAN`='$pembayaranBulanDB', 
                                `PANGKAL`='$nominalBayarPangkal',
                                `PANGKAL_txt`='$ketPembayaranPangkal',
                                `TRANSAKSI`=NULL,
                                `INPUTER`='$getNamaInputer',
                                `STAMP`='$data_stamp'
                                WHERE  `ID`= '$idInvoice'
                            ";

                        } else if ($pembayaranVIA != 'kosong') {

                            $queryUpdate = "
                                UPDATE `u415776667_spp`.`input_data_tk_lama` 
                                SET 
                                `DATE`='$tglPembayaranDB', 
                                `BULAN`='$pembayaranBulanDB', 
                                `PANGKAL`='$nominalBayarPangkal',
                                `PANGKAL_txt`='$ketPembayaranPangkal',
                                `TRANSAKSI`='$pembayaranVIA',
                                `INPUTER`='$getNamaInputer',
                                `STAMP`='$data_stamp'
                                WHERE  `ID`= '$idInvoice'
                            ";

                        }

                        mysqli_query($con, $queryUpdate);

                        if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {
                            
                            $setSesiPageFilterBy = 2;

                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, PANGKAL, TRANSAKSI, BULAN AS pembayaran_bulan, PANGKAL_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_tk_lama
                                    WHERE
                                    PANGKAL != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;

                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }

                        } elseif ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {

                            $setSesiPageFilterBy = 9;

                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, PANGKAL, TRANSAKSI, BULAN AS pembayaran_bulan, PANGKAL_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_tk_lama
                                    WHERE
                                    PANGKAL != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                                    order by STAMP 
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    $pageActive =  $halamanAktif - 1;
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }

                        }

                    } elseif ($currentFilter == 'KEGIATAN') {
                        if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {
                            $setSesiPageFilterBy = 3;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, KEGIATAN, TRANSAKSI, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_tk
                                    WHERE
                                    KEGIATAN != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        } elseif ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 10;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;

                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, KEGIATAN, TRANSAKSI, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_tk
                                    WHERE
                                    KEGIATAN != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                                    order by STAMP 
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    $pageActive =  $halamanAktif - 1;
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;

                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        }
                    } elseif ($currentFilter == 'BUKU') {
                        if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {
                            $setSesiPageFilterBy = 4;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, BUKU, TRANSAKSI, BULAN AS pembayaran_bulan, BUKU_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_tk
                                    WHERE
                                    BUKU != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        } elseif ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 11;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;

                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, BUKU, TRANSAKSI, BULAN AS pembayaran_bulan, BUKU_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_tk
                                    WHERE
                                    BUKU != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                                    order by STAMP 
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    $pageActive =  $halamanAktif - 1;
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;

                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        }
                    } elseif ($currentFilter == 'SERAGAM') {
                        if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {
                            $setSesiPageFilterBy = 5;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, SERAGAM, TRANSAKSI, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_tk_lama
                                    WHERE
                                    SERAGAM != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;

                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        } elseif ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 12;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, SERAGAM, TRANSAKSI, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_tk_lama
                                    WHERE
                                    SERAGAM != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                                    order by STAMP 
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    $pageActive =  $halamanAktif - 1;
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        }
                    } elseif ($currentFilter == 'REGISTRASI') {
                        if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {
                            $setSesiPageFilterBy = 6;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, REGISTRASI, TRANSAKSI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_tk
                                    WHERE
                                    REGISTRASI != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;

                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        } elseif ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 13;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, REGISTRASI, TRANSAKSI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_tk
                                    WHERE
                                    REGISTRASI != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                                    order by STAMP 
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    $pageActive =  $halamanAktif - 1;
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        }
                    } elseif ($currentFilter == 'LAIN') {
                        if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {
                            $setSesiPageFilterBy = 7;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, LAIN, TRANSAKSI, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_tk
                                    WHERE
                                    LAIN != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;

                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        } elseif ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 14;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, LAIN, TRANSAKSI, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_tk
                                    WHERE
                                    LAIN != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                                    order by STAMP 
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    $pageActive =  $halamanAktif - 1;
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        }
                    }

                    $nominalBayar       = rupiahFormat($nominalBayarPangkal);
                    $ketPembayaran      = $ketPembayaranPangkal;
                    break;
                case 'KEGIATAN':
                    $nominalBayarSPP;
                    $ketPembayaranSPP;

                    $nominalBayarPangkal;
                    $ketPembayaranPangkal;

                    $nominalBayarKegiatan   = str_replace(["Rp ", "Rp. ", ".", ","], "", $_POST['nominalBayar']);
                    $ketPembayaranKegiatan  = mysqli_real_escape_string($con, htmlspecialchars($_POST['ketPembayaran']));

                    $nominalBayarBuku;
                    $ketPembayaranBuku;

                    $nominalBayarSeragam;
                    $ketPembayaranSeragam;

                    $nominalBayarRegistrasi;
                    $ketPembayaranRegistrasi;

                    $nominalBayarLain;
                    $ketPembayaranLain;

                    if ($currentFilter == 'SPP') {

                        if ($pembayaranVIA == 'kosong') {

                            $queryUpdate = "
                                UPDATE `u415776667_spp`.`input_data_tk_lama` 
                                SET 
                                `DATE`='$tglPembayaranDB', 
                                `BULAN`='$pembayaranBulanDB', 
                                `SPP`='$nominalBayarSPP', 
                                `SPP_txt`=NULL, 
                                `KEGIATAN`='$nominalBayarKegiatan',
                                `KEGIATAN_txt`='$ketPembayaranKegiatan',
                                `TRANSAKSI`=NULL,
                                `INPUTER`='$getNamaInputer',
                                `STAMP`='$data_stamp'
                                WHERE `ID`= '$idInvoice'
                            ";

                        } elseif ($pembayaranVIA != 'kosong') {

                            $queryUpdate = "
                                UPDATE `u415776667_spp`.`input_data_tk_lama` 
                                SET 
                                `DATE`='$tglPembayaranDB', 
                                `BULAN`='$pembayaranBulanDB', 
                                `SPP`='$nominalBayarSPP', 
                                `SPP_txt`=NULL,
                                `KEGIATAN`='$nominalBayarKegiatan',
                                `KEGIATAN_txt`='$ketPembayaranKegiatan',
                                `TRANSAKSI`='$pembayaranVIA',
                                `INPUTER`='$getNamaInputer',
                                `STAMP`='$data_stamp'
                                WHERE `ID`= '$idInvoice'
                            ";

                        }

                        mysqli_query($con, $queryUpdate);

                        if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {
                            $setSesiPageFilterBy = 1;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, SPP, TRANSAKSI, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_tk_lama
                                    WHERE
                                    SPP != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;

                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        } elseif ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 8;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, SPP, TRANSAKSI, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_tk_lama
                                    WHERE
                                    SPP != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                                    order by STAMP 
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    $pageActive =  $halamanAktif - 1;
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        }

                    } elseif ($currentFilter == 'PANGKAL') {
                        if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {
                            $setSesiPageFilterBy = 2;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, PANGKAL, TRANSAKSI, BULAN AS pembayaran_bulan, PANGKAL_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_tk
                                    WHERE
                                    PANGKAL != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        } elseif ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 9;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;

                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, PANGKAL, TRANSAKSI, BULAN AS pembayaran_bulan, PANGKAL_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_tk
                                    WHERE
                                    PANGKAL != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                                    order by STAMP 
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    $pageActive =  $halamanAktif - 1;
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;

                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        }
                    } elseif ($currentFilter == 'KEGIATAN') {

                        if ($pembayaranVIA == 'kosong') {

                            $queryUpdate = "
                                UPDATE `u415776667_spp`.`input_data_tk_lama` 
                                SET 
                                `DATE`='$tglPembayaranDB', 
                                `BULAN`='$pembayaranBulanDB', 
                                `KEGIATAN`='$nominalBayarKegiatan', 
                                `KEGIATAN_txt`='$ketPembayaranKegiatan'
                                `TRANSAKSI`=NULL,
                                `INPUTER`='$getNamaInputer',
                                `STAMP`='$data_stamp'
                                WHERE  `ID`= '$idInvoice'
                            ";

                        } elseif($pembayaranVIA != 'kosong') {

                            $queryUpdate = "
                                UPDATE `u415776667_spp`.`input_data_tk_lama` 
                                SET 
                                `DATE`='$tglPembayaranDB', 
                                `BULAN`='$pembayaranBulanDB', 
                                `KEGIATAN`='$nominalBayarKegiatan', 
                                `KEGIATAN_txt`='$ketPembayaranKegiatan',
                                `TRANSAKSI`='$pembayaranVIA',
                                `INPUTER`='$getNamaInputer',
                                `STAMP`='$data_stamp'
                                WHERE  `ID`= '$idInvoice'
                            ";

                        }

                        mysqli_query($con, $queryUpdate);

                        if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {
                            $setSesiPageFilterBy =  3;

                            // echo "Sini";exit;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, KEGIATAN, TRANSAKSI, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_tk_lama
                                    WHERE
                                    KEGIATAN != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;

                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        } elseif ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {

                            $setSesiPageFilterBy = 10;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, KEGIATAN, TRANSAKSI, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_tk_lama
                                    WHERE
                                    KEGIATAN != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                                    order by STAMP 
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        }

                    } elseif ($currentFilter == 'BUKU') {
                        if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {
                            $setSesiPageFilterBy = 4;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, BUKU, TRANSAKSI, BULAN AS pembayaran_bulan, BUKU_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_tk
                                    WHERE
                                    BUKU != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        } elseif ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 11;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;

                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, BUKU, TRANSAKSI, BULAN AS pembayaran_bulan, BUKU_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_tk
                                    WHERE
                                    BUKU != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                                    order by STAMP 
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;

                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        }
                    } elseif ($currentFilter == 'SERAGAM') {

                        if ($pembayaranVIA == 'kosong') {

                            $queryUpdate = "
                                UPDATE `u415776667_spp`.`input_data_tk_lama` 
                                SET 
                                `DATE`='$tglPembayaranDB', 
                                `BULAN`='$pembayaranBulanDB', 
                                `KEGIATAN`='$nominalBayarKegiatan', 
                                `KEGIATAN_txt`='$ketPembayaranKegiatan',
                                `SERAGAM`='$nominalBayarSeragam',
                                `SERAGAM_txt`=NULL,
                                `TRANSAKSI`=NULL,
                                `INPUTER`='$getNamaInputer',
                                `STAMP`='$data_stamp'
                                WHERE  `ID`= '$idInvoice'
                            ";

                        } elseif($pembayaranVIA != 'kosong') {

                            $queryUpdate = "
                                UPDATE `u415776667_spp`.`input_data_tk_lama` 
                                SET 
                                `DATE`='$tglPembayaranDB', 
                                `BULAN`='$pembayaranBulanDB', 
                                `KEGIATAN`='$nominalBayarKegiatan', 
                                `KEGIATAN_txt`='$ketPembayaranKegiatan',
                                `SERAGAM`='$nominalBayarSeragam',
                                `SERAGAM_txt`=NULL,
                                `TRANSAKSI`='$pembayaranVIA',
                                `INPUTER`='$getNamaInputer',
                                `STAMP`='$data_stamp'
                                WHERE  `ID`= '$idInvoice'
                            ";

                        }

                        mysqli_query($con, $queryUpdate);

                        if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {
                            $setSesiPageFilterBy =  5;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, SERAGAM, TRANSAKSI, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_tk_lama
                                    WHERE
                                    SERAGAM != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;

                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        } elseif ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 12;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, SERAGAM, TRANSAKSI, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_tk_lama
                                    WHERE
                                    SERAGAM != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                                    order by STAMP 
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        }
                    } elseif ($currentFilter == 'REGISTRASI') {
                        if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {
                            $setSesiPageFilterBy =  6;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, REGISTRASI, TRANSAKSI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_tk
                                    WHERE
                                    REGISTRASI != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;

                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        } elseif ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 13;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, REGISTRASI, TRANSAKSI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_tk
                                    WHERE
                                    REGISTRASI != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                                    order by STAMP 
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        }
                    } elseif ($currentFilter == 'LAIN') {
                        if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {
                            $setSesiPageFilterBy = 7;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, LAIN, TRANSAKSI, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_tk
                                    WHERE
                                    LAIN != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;

                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        } elseif ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 14;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, LAIN, TRANSAKSI, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_tk
                                    WHERE
                                    LAIN != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                                    order by STAMP 
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        }
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

                    $nominalBayarBuku   = str_replace(["Rp ", "Rp. ", ".", ","], "", $_POST['nominalBayar']);
                    $ketPembayaranBuku  = mysqli_real_escape_string($con, htmlspecialchars($_POST['ketPembayaran']));

                    $nominalBayarSeragam;
                    $ketPembayaranSeragam;

                    $nominalBayarRegistrasi;
                    $ketPembayaranRegistrasi;

                    $nominalBayarLain;
                    $ketPembayaranLain;

                    if ($currentFilter == 'SPP') {

                        if ($pembayaranVIA == 'kosong') {

                            $queryUpdate = "
                                UPDATE `u415776667_spp`.`input_data_tk_lama` 
                                SET 
                                `DATE`='$tglPembayaranDB', 
                                `BULAN`='$pembayaranBulanDB', 
                                `SPP`='$nominalBayarSPP', 
                                `SPP_txt`=NULL, 
                                `BUKU`='$nominalBayarBuku',
                                `BUKU_txt`='$ketPembayaranBuku',
                                `TRANSAKSI`=NULL,
                                `INPUTER`='$getNamaInputer',
                                `STAMP`='$data_stamp'
                                WHERE  `ID`= '$idInvoice'
                            ";

                        } elseif ($pembayaranVIA != 'kosong') {

                            $queryUpdate = "
                                UPDATE `u415776667_spp`.`input_data_tk_lama` 
                                SET 
                                `DATE`='$tglPembayaranDB', 
                                `BULAN`='$pembayaranBulanDB', 
                                `SPP`='$nominalBayarSPP', 
                                `SPP_txt`=NULL, 
                                `BUKU`='$nominalBayarBuku',
                                `BUKU_txt`='$ketPembayaranBuku',
                                `TRANSAKSI`='$pembayaranVIA',
                                `INPUTER`='$getNamaInputer',
                                `STAMP`='$data_stamp'
                                WHERE  `ID`= '$idInvoice'
                            ";

                        }

                        mysqli_query($con, $queryUpdate);

                        if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {
                            $setSesiPageFilterBy = 1;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, SPP, TRANSAKSI, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_tk_lama
                                    WHERE
                                    SPP != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        } elseif ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 8;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;

                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, SPP, TRANSAKSI, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_tk_lama
                                    WHERE
                                    SPP != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                                    order by STAMP 
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;

                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        }

                    } elseif ($currentFilter == 'PANGKAL') {
                        if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {
                            $setSesiPageFilterBy = 2;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, PANGKAL, TRANSAKSI, BULAN AS pembayaran_bulan, PANGKAL_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_tk
                                    WHERE
                                    PANGKAL != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;

                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        } elseif ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 9;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, PANGKAL, TRANSAKSI, BULAN AS pembayaran_bulan, PANGKAL_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_tk
                                    WHERE
                                    PANGKAL != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                                    order by STAMP 
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        }
                    } elseif ($currentFilter == 'KEGIATAN') {
                        if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {
                            $setSesiPageFilterBy = 3;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, KEGIATAN, TRANSAKSI, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_tk
                                    WHERE
                                    KEGIATAN != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        } elseif ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 10;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;

                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, KEGIATAN, TRANSAKSI, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_tk
                                    WHERE
                                    KEGIATAN != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                                    order by STAMP 
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;

                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        }
                    } elseif ($currentFilter == 'BUKU') {

                        if ($pembayaranVIA == 'kosong') {

                            $queryUpdate = "
                                UPDATE `u415776667_spp`.`input_data_tk_lama` 
                                SET 
                                `DATE`='$tglPembayaranDB', 
                                `BULAN`='$pembayaranBulanDB', 
                                `BUKU`='$nominalBayarBuku',
                                `BUKU_txt`='$ketPembayaranBuku',
                                `TRANSAKSI`=NULL,
                                `INPUTER`='$getNamaInputer',
                                `STAMP`='$data_stamp'
                                WHERE  `ID`= '$idInvoice'
                            ";

                        } elseif ($pembayaranVIA != 'kosong') {

                            $queryUpdate = "
                                UPDATE `u415776667_spp`.`input_data_tk_lama` 
                                SET 
                                `DATE`='$tglPembayaranDB', 
                                `BULAN`='$pembayaranBulanDB', 
                                `BUKU`='$nominalBayarBuku',
                                `BUKU_txt`='$ketPembayaranBuku',
                                `TRANSAKSI`='$pembayaranVIA',
                                `INPUTER`='$getNamaInputer',
                                `STAMP`='$data_stamp'
                                WHERE  `ID`= '$idInvoice'
                            ";

                        }

                        mysqli_query($con, $queryUpdate);

                        if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {
                            $setSesiPageFilterBy = 4;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, BUKU, TRANSAKSI, BULAN AS pembayaran_bulan, BUKU_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_tk_lama
                                    WHERE
                                    BUKU != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }

                        } elseif ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 11;
                            // echo "Sini " . $namaSiswa;exit;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;

                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, BUKU, TRANSAKSI, BULAN AS pembayaran_bulan, BUKU_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_tk_lama
                                    WHERE
                                    BUKU != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                                    order by STAMP 
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);
                                // echo "Jumlah Data " . "<br>";

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;

                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }

                        }

                    } elseif ($currentFilter == 'SERAGAM') {
                        if ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 12;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        } else if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59") {
                            $setSesiPageFilterBy = 5;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        }
                    } elseif ($currentFilter == 'REGISTRASI') {
                        if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {
                            $setSesiPageFilterBy = 6;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, REGISTRASI, TRANSAKSI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_tk
                                    WHERE
                                    REGISTRASI != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;

                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        } elseif ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 13;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, REGISTRASI, TRANSAKSI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_tk
                                    WHERE
                                    REGISTRASI != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                                    order by STAMP 
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        }
                    } elseif ($currentFilter == 'LAIN') {
                        if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {
                            $setSesiPageFilterBy = 7;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, LAIN, TRANSAKSI, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_tk
                                    WHERE
                                    LAIN != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;

                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        } elseif ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 14;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, LAIN, TRANSAKSI, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_tk
                                    WHERE
                                    LAIN != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                                    order by STAMP 
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        }
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

                    $nominalBayarSeragam   = str_replace(["Rp ", "Rp. ", ".", ","], "", $_POST['nominalBayar']);
                    $ketPembayaranSeragam  = mysqli_real_escape_string($con, htmlspecialchars($_POST['ketPembayaran']));

                    $nominalBayarRegistrasi;
                    $ketPembayaranRegistrasi;

                    $nominalBayarLain;
                    $ketPembayaranLain;

                    if ($currentFilter == 'SPP') {

                        if ($pembayaranVIA == 'kosong') {

                            $queryUpdate = "
                                UPDATE `u415776667_spp`.`input_data_tk_lama` 
                                SET 
                                `DATE`='$tglPembayaranDB', 
                                `BULAN`='$pembayaranBulanDB', 
                                `SPP`='$nominalBayarSPP', 
                                `SPP_txt`=NULL, 
                                `SERAGAM`='$nominalBayarSeragam',
                                `SERAGAM_txt`='$ketPembayaranSeragam',
                                `TRANSAKSI`=NULL,
                                `INPUTER`='$getNamaInputer',
                                `STAMP`='$data_stamp'
                                WHERE  `ID`= '$idInvoice'
                            ";

                        } elseif ($pembayaranVIA != 'kosong') {

                            $queryUpdate = "
                                UPDATE `u415776667_spp`.`input_data_tk_lama` 
                                SET 
                                `DATE`='$tglPembayaranDB', 
                                `BULAN`='$pembayaranBulanDB', 
                                `SPP`='$nominalBayarSPP', 
                                `SPP_txt`=NULL, 
                                `SERAGAM`='$nominalBayarSeragam',
                                `SERAGAM_txt`='$ketPembayaranSeragam',
                                `TRANSAKSI`='$pembayaranVIA',
                                `INPUTER`='$getNamaInputer',
                                `STAMP`='$data_stamp'
                                WHERE  `ID`= '$idInvoice'
                            ";

                        }

                        mysqli_query($con, $queryUpdate);

                        if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {
                            $setSesiPageFilterBy = 1;

                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, SPP, TRANSAKSI, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_tk_lama
                                    WHERE
                                    SPP != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;

                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        } elseif ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 8;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, SPP, TRANSAKSI, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_tk_lama
                                    WHERE
                                    SPP != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                                    order by STAMP 
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        }

                    } elseif ($currentFilter == 'PANGKAL') {
                        if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {
                            $setSesiPageFilterBy = 2;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, PANGKAL, TRANSAKSI, BULAN AS pembayaran_bulan, PANGKAL_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_tk_lama
                                    WHERE
                                    PANGKAL != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;

                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        } elseif ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 9;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, PANGKAL, TRANSAKSI, BULAN AS pembayaran_bulan, PANGKAL_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_tk_lama
                                    WHERE
                                    PANGKAL != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                                    order by STAMP 
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    $pageActive =  $halamanAktif - 1;
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        }
                    } elseif ($currentFilter == 'KEGIATAN') {

                        if ($pembayaranVIA == 'kosong') {

                            $queryUpdate = "
                                UPDATE `u415776667_spp`.`input_data_tk_lama` 
                                SET 
                                `DATE`='$tglPembayaranDB', 
                                `BULAN`='$pembayaranBulanDB', 
                                `KEGIATAN`='$nominalBayarKegiatan', 
                                `KEGIATAN_txt`=NULL,
                                `SERAGAM`='$nominalBayarSeragam',
                                `SERAGAM_txt`='$ketPembayaranSeragam',
                                `TRANSAKSI`=NULL,
                                `INPUTER`='$getNamaInputer',
                                `STAMP`='$data_stamp'
                                WHERE  `ID`= '$idInvoice'
                            ";

                        } else if ($pembayaranVIA != 'kosong') {

                            $queryUpdate = "
                                UPDATE `u415776667_spp`.`input_data_tk_lama` 
                                SET 
                                `DATE`='$tglPembayaranDB', 
                                `BULAN`='$pembayaranBulanDB', 
                                `KEGIATAN`='$nominalBayarKegiatan', 
                                `KEGIATAN_txt`=NULL,
                                `SERAGAM`='$nominalBayarSeragam',
                                `SERAGAM_txt`='$ketPembayaranSeragam',
                                `TRANSAKSI`='$pembayaranVIA',
                                `INPUTER`='$getNamaInputer',
                                `STAMP`='$data_stamp'
                                WHERE  `ID`= '$idInvoice'
                            ";

                        }

                        mysqli_query($con, $queryUpdate);

                        if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {
                            $setSesiPageFilterBy =  3;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, KEGIATAN, TRANSAKSI, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_tk_lama
                                    WHERE
                                    KEGIATAN != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;

                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        } elseif ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 10;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, KEGIATAN, TRANSAKSI, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_tk_lama
                                    WHERE
                                    KEGIATAN != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                                    order by STAMP 
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        }
                    } elseif ($currentFilter == 'BUKU') {
                        if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {
                            $setSesiPageFilterBy = 4;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, BUKU, TRANSAKSI, BULAN AS pembayaran_bulan, BUKU_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_tk
                                    WHERE
                                    BUKU != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;

                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        } elseif ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 11;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, BUKU, TRANSAKSI, BULAN AS pembayaran_bulan, BUKU_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_tk
                                    WHERE
                                    BUKU != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                                    order by STAMP 
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        }
                    } elseif ($currentFilter == 'SERAGAM') {
                        
                        if ($pembayaranVIA == 'kosong') {

                            $queryUpdate = "
                                UPDATE `u415776667_spp`.`input_data_tk_lama` 
                                SET 
                                `DATE`='$tglPembayaranDB', 
                                `BULAN`='$pembayaranBulanDB', 
                                `SERAGAM`='$nominalBayarSeragam',
                                `SERAGAM_txt`='$ketPembayaranSeragam',
                                `TRANSAKSI`=NULL,
                                `INPUTER`='$getNamaInputer',
                                `STAMP`='$data_stamp'
                                WHERE  `ID`= '$idInvoice'
                            ";

                        } elseif ($pembayaranVIA != 'kosong') {

                            $queryUpdate = "
                                UPDATE `u415776667_spp`.`input_data_tk_lama` 
                                SET 
                                `DATE`='$tglPembayaranDB', 
                                `BULAN`='$pembayaranBulanDB', 
                                `SERAGAM`='$nominalBayarSeragam',
                                `SERAGAM_txt`='$ketPembayaranSeragam',
                                `TRANSAKSI`='$pembayaranVIA',
                                `INPUTER`='$getNamaInputer',
                                `STAMP`='$data_stamp'
                                WHERE  `ID`= '$idInvoice'
                            ";

                        }

                        mysqli_query($con, $queryUpdate);

                        if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {
                            $setSesiPageFilterBy = 5;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, SERAGAM, TRANSAKSI, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_tk_lama
                                    WHERE
                                    SERAGAM != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }

                        } elseif ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 12;
                            // echo "Sini " . $namaSiswa;exit;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;

                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, SERAGAM, TRANSAKSI, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_tk_lama
                                    WHERE
                                    SERAGAM != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                                    order by STAMP 
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);
                                // echo "Jumlah Data " . "<br>";

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;

                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }

                        }

                    } elseif ($currentFilter == 'REGISTRASI') {
                        if ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 13;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        } else if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59") {
                            $setSesiPageFilterBy = 6;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        }
                    } elseif ($currentFilter == 'LAIN') {
                        if ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 14;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        } else if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59") {
                            $setSesiPageFilterBy = 7;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        }
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

                    $nominalBayarRegistrasi   = str_replace(["Rp ", "Rp. ", ".", ","], "", $_POST['nominalBayar']);
                    $ketPembayaranRegistrasi  = mysqli_real_escape_string($con, htmlspecialchars($_POST['ketPembayaran']));

                    $nominalBayarLain;
                    $ketPembayaranLain;

                    if ($currentFilter == 'SPP') {

                        if ($pembayaranVIA == 'kosong') {

                            $queryUpdate = "
                                UPDATE `u415776667_spp`.`input_data_tk_lama` 
                                SET 
                                `DATE`='$tglPembayaranDB', 
                                `BULAN`='$pembayaranBulanDB', 
                                `SPP`='$nominalBayarSPP', 
                                `SPP_txt`=NULL,
                                `REGISTRASI`='$nominalBayarRegistrasi',
                                `REGISTRASI_txt`='$ketPembayaranRegistrasi',
                                `TRANSAKSI`=NULL,
                                `INPUTER`='$getNamaInputer',
                                `STAMP`='$data_stamp'
                                WHERE  `ID`= '$idInvoice'
                            ";

                        } else if ($pembayaranVIA != 'kosong') {

                            $queryUpdate = "
                                UPDATE `u415776667_spp`.`input_data_tk_lama` 
                                SET 
                                `DATE`='$tglPembayaranDB', 
                                `BULAN`='$pembayaranBulanDB', 
                                `SPP`='$nominalBayarSPP', 
                                `SPP_txt`=NULL,
                                `REGISTRASI`='$nominalBayarRegistrasi',
                                `REGISTRASI_txt`='$ketPembayaranRegistrasi',
                                `TRANSAKSI`='$pembayaranVIA',
                                `INPUTER`='$getNamaInputer',
                                `STAMP`='$data_stamp'
                                WHERE  `ID`= '$idInvoice'
                            ";

                        }

                        mysqli_query($con, $queryUpdate);

                        if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {
                            $setSesiPageFilterBy = 1;

                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, SPP, TRANSAKSI, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_tk_lama
                                    WHERE
                                    SPP != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;

                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        } elseif ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 8;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, SPP, TRANSAKSI, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_tk_lama
                                    WHERE
                                    SPP != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                                    order by STAMP 
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        }

                    } elseif ($currentFilter == 'PANGKAL') {
                        if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {
                            $setSesiPageFilterBy = 2;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, PANGKAL, TRANSAKSI, BULAN AS pembayaran_bulan, PANGKAL_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_tk
                                    WHERE
                                    PANGKAL != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;

                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        } elseif ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 9;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, PANGKAL, TRANSAKSI, BULAN AS pembayaran_bulan, PANGKAL_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_tk
                                    WHERE
                                    PANGKAL != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                                    order by STAMP 
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    $pageActive =  $halamanAktif - 1;
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        }
                    } elseif ($currentFilter == 'KEGIATAN') {
                        if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {
                            $setSesiPageFilterBy =  3;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, KEGIATAN, TRANSAKSI, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_tk
                                    WHERE
                                    KEGIATAN != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;

                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        } elseif ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 10;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, KEGIATAN, TRANSAKSI, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_tk
                                    WHERE
                                    KEGIATAN != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                                    order by STAMP 
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        }
                    } elseif ($currentFilter == 'BUKU') {
                        if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {
                            $setSesiPageFilterBy = 4;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, BUKU, TRANSAKSI, BULAN AS pembayaran_bulan, BUKU_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_tk
                                    WHERE
                                    BUKU != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;

                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        } elseif ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 11;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, BUKU, TRANSAKSI, BULAN AS pembayaran_bulan, BUKU_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_tk
                                    WHERE
                                    BUKU != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                                    order by STAMP 
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        }
                    } elseif ($currentFilter == 'SERAGAM') {
                        if ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 12;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        } else if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59") {
                            $setSesiPageFilterBy = 5;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        }
                    } elseif ($currentFilter == 'REGISTRASI') {

                        if ($pembayaranVIA == 'kosong') {

                            $queryUpdate = "
                                UPDATE `u415776667_spp`.`input_data_tk_lama` 
                                SET 
                                `DATE`='$tglPembayaranDB', 
                                `BULAN`='$pembayaranBulanDB', 
                                `REGISTRASI`='$nominalBayarRegistrasi',
                                `REGISTRASI_txt`='$ketPembayaranRegistrasi',
                                `TRANSAKSI`=NULL,
                                `INPUTER`='$getNamaInputer',
                                `STAMP`='$data_stamp'
                                WHERE  `ID`= '$idInvoice'
                            ";

                        } elseif ($pembayaranVIA != 'kosong') {

                            $queryUpdate = "
                                UPDATE `u415776667_spp`.`input_data_tk_lama` 
                                SET 
                                `DATE`='$tglPembayaranDB', 
                                `BULAN`='$pembayaranBulanDB', 
                                `REGISTRASI`='$nominalBayarRegistrasi',
                                `REGISTRASI_txt`='$ketPembayaranRegistrasi',
                                `TRANSAKSI`='$pembayaranVIA',
                                `INPUTER`='$getNamaInputer',
                                `STAMP`='$data_stamp'
                                WHERE  `ID`= '$idInvoice'
                            ";

                        }

                        mysqli_query($con, $queryUpdate);

                        if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {
                            $setSesiPageFilterBy = 6;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, REGISTRASI, TRANSAKSI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_tk_lama
                                    WHERE
                                    REGISTRASI != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }

                        } elseif ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 13;
                            // echo "Sini " . $namaSiswa;exit;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;

                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, REGISTRASI, TRANSAKSI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_tk_lama
                                    WHERE
                                    REGISTRASI != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                                    order by STAMP 
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);
                                // echo "Jumlah Data " . "<br>";

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;

                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }

                        }

                    } elseif ($currentFilter == 'LAIN') {
                        if ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 14;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        } else if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59") {
                            $setSesiPageFilterBy = 7;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        }
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

                    $nominalBayarLain   = str_replace(["Rp ", "Rp. ", ".", ","], "", $_POST['nominalBayar']);
                    $ketPembayaranLain  = mysqli_real_escape_string($con, htmlspecialchars($_POST['ketPembayaran']));

                    if ($currentFilter == 'SPP') {

                        if ($pembayaranVIA == 'kosong') {

                            $queryUpdate = "
                                UPDATE `u415776667_spp`.`input_data_tk_lama` 
                                SET 
                                `DATE`='$tglPembayaranDB', 
                                `BULAN`='$pembayaranBulanDB', 
                                `SPP`='$nominalBayarSPP', 
                                `SPP_txt`=NULL,
                                `LAIN`='$nominalBayarLain',
                                `LAIN_txt`='$ketPembayaranLain',
                                `TRANSAKSI`=NULL,
                                `INPUTER`='$getNamaInputer',
                                `STAMP`='$data_stamp'
                                WHERE  `ID`= '$idInvoice'
                            ";

                        } elseif ($pembayaranVIA != 'kosong') {

                            $queryUpdate = "
                                UPDATE `u415776667_spp`.`input_data_tk_lama` 
                                SET 
                                `DATE`='$tglPembayaranDB', 
                                `BULAN`='$pembayaranBulanDB', 
                                `SPP`='$nominalBayarSPP', 
                                `SPP_txt`=NULL,
                                `LAIN`='$nominalBayarLain',
                                `LAIN_txt`='$ketPembayaranLain',
                                `TRANSAKSI`='$pembayaranVIA',
                                `INPUTER`='$getNamaInputer',
                                `STAMP`='$data_stamp'
                                WHERE  `ID`= '$idInvoice'
                            ";

                        }

                        mysqli_query($con, $queryUpdate);
                        // $_SESSION['form_success'] = "data_update";

                        if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {
                            $setSesiPageFilterBy = 1;

                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, SPP, TRANSAKSI, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_tk_lama
                                    WHERE
                                    SPP != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;

                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        } elseif ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 8;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, SPP, TRANSAKSI, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_tk_lama
                                    WHERE
                                    SPP != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                                    order by STAMP 
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        }

                    } elseif ($currentFilter == 'PANGKAL') {
                        if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {
                            $setSesiPageFilterBy = 2;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, LAIN, TRANSAKSI, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_tk
                                    WHERE
                                    LAIN != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;

                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        } elseif ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 9;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, LAIN, TRANSAKSI, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_tk
                                    WHERE
                                    LAIN != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                                    order by STAMP 
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    $pageActive =  $halamanAktif - 1;
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        }
                    } elseif ($currentFilter == 'KEGIATAN') {
                        if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {
                            $setSesiPageFilterBy = 3;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, KEGIATAN, TRANSAKSI, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_tk
                                    WHERE
                                    KEGIATAN != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;

                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        } elseif ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 10;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, KEGIATAN, TRANSAKSI, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_tk
                                    WHERE
                                    KEGIATAN != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                                    order by STAMP 
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        }
                    } elseif ($currentFilter == 'BUKU') {
                        if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {
                            $setSesiPageFilterBy = 4;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, BUKU, TRANSAKSI, BULAN AS pembayaran_bulan, BUKU_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_tk
                                    WHERE
                                    BUKU != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;

                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        } elseif ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 11;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, BUKU, TRANSAKSI, BULAN AS pembayaran_bulan, BUKU_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_tk
                                    WHERE
                                    BUKU != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                                    order by STAMP 
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        }
                    } elseif ($currentFilter == 'SERAGAM') {
                        if ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 12;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        } else if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59") {
                            $setSesiPageFilterBy = 5;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        }
                    } elseif ($currentFilter == 'REGISTRASI') {
                        if ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 13;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        } else if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59") {
                            $setSesiPageFilterBy = 6;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }
                        }
                    } elseif ($currentFilter == 'LAIN') {

                        if ($pembayaranVIA == 'kosong') {

                            $queryUpdate = "
                                UPDATE `u415776667_spp`.`input_data_tk_lama` 
                                SET 
                                `DATE`='$tglPembayaranDB', 
                                `BULAN`='$pembayaranBulanDB', 
                                `LAIN`='$nominalBayarLain',
                                `LAIN_txt`='$ketPembayaranLain',
                                `TRANSAKSI`=NULL,
                                `INPUTER`='$getNamaInputer',
                                `STAMP`='$data_stamp'
                                WHERE  `ID`= '$idInvoice'
                            ";

                        } elseif ($pembayaranVIA != 'kosong') {

                            $queryUpdate = "
                                UPDATE `u415776667_spp`.`input_data_tk_lama` 
                                SET 
                                `DATE`='$tglPembayaranDB', 
                                `BULAN`='$pembayaranBulanDB', 
                                `LAIN`='$nominalBayarLain',
                                `LAIN_txt`='$ketPembayaranLain',
                                `TRANSAKSI`='$pembayaranVIA',
                                `INPUTER`='$getNamaInputer',
                                `STAMP`='$data_stamp'
                                WHERE  `ID`= '$idInvoice'
                            ";

                        }

                        mysqli_query($con, $queryUpdate);

                        if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {
                            $setSesiPageFilterBy = 7;
                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;
                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, LAIN, TRANSAKSI, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_tk_lama
                                    WHERE
                                    LAIN != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;
                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }

                        } elseif ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                            $setSesiPageFilterBy = 14;

                            if ($currentFilter != $typeFilter) {
                                $isifilby = $currentFilter;

                                // Cek apakah halaman tersebut ada
                                $dataAwal = ($halamanAktif * 5) - 5;

                                $ambildata_perhalaman = mysqli_query($con, "
                                    SELECT ID, NIS, NAMA, DATE, kelas, LAIN, TRANSAKSI, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                    FROM input_data_tk_lama
                                    WHERE
                                    LAIN != 0
                                    AND NAMA LIKE '%$namaSiswa%'
                                    AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                                    order by STAMP 
                                    LIMIT $dataAwal, $jumlahData
                                ");

                                $hitungJumlahDataHalaman = mysqli_num_rows($ambildata_perhalaman);
                                // echo "Jumlah Data " . "<br>";

                                if ($hitungJumlahDataHalaman == 0) {
                                    if ($halamanAktif == 1 && $hitungJumlahDataHalaman == 0) {
                                        $pageActive = 1;
                                    } else {
                                        $pageActive =  $halamanAktif - 1;
                                    }
                                } else if ($hitungJumlahDataHalaman != 0) {
                                    $pageActive =  $halamanAktif;
                                }

                                $halamanAktif = $pageActive;

                            } else if ($currentFilter == $typeFilter) {
                                $isifilby = $typeFilter;
                            }

                        }

                    }

                    $nominalBayar       = rupiahFormat($nominalBayarLain);
                    $ketPembayaran      = $ketPembayaranLain;
                    break;
            }

        }

    }

    // Tombol Kembali 
    elseif (isset($_POST['back_to_page'])) {

        $id         = $_POST['data_id_siswa'];
        $nis        = $_POST['data_nis_siswa'];
        $namaSiswa  = $_POST['data_nama_siswa'];
        $kelas      = $_POST['data_kelas_siswa'];
        $panggilan  = $_POST['data_panggilan_siswa'];

        $halamanAktif  = $_POST['currentPage'];

        $currentFilter = $_POST['currentFilter'];

        $typeFilter    = htmlspecialchars($_POST['isi_filter_edit']);

        $dariTanggal    = $_POST['tanggal1'];
        $sampaiTanggal  = $_POST['tanggal2'];

        $tanggalDari    = str_replace([" 00:00:00"], "", $dariTanggal);
        $tanggalSampai  = str_replace([" 23:59:59"], "", $sampaiTanggal);

        if ($currentFilter == 'SPP') {

            if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {
                $setSesiPageFilterBy = 1;
                if ($currentFilter != $typeFilter) {
                    $isifilby = $currentFilter;
                } else if ($currentFilter == $typeFilter) {
                    $isifilby = $typeFilter;
                }
            }else if ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                $setSesiPageFilterBy = 8;
                if ($currentFilter != $typeFilter) {
                    $isifilby = $currentFilter;
                } else if ($currentFilter == $typeFilter) {
                    $isifilby = $typeFilter;
                }
            }
            
        } elseif ($currentFilter == 'PANGKAL') {
            
            if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {

                $setSesiPageFilterBy = 2;
                if ($currentFilter != $typeFilter) {
                    $isifilby = $currentFilter;
                } else if ($currentFilter == $typeFilter) {
                    $isifilby = $typeFilter;
                }

            } else if ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                $setSesiPageFilterBy = 9;
                if ($currentFilter != $typeFilter) {
                    $isifilby = $currentFilter;
                } else if ($currentFilter == $typeFilter) {
                    $isifilby = $typeFilter;
                }
            }  

        } elseif ($currentFilter == 'KEGIATAN') {

            if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {
                $setSesiPageFilterBy = 3;
                if ($currentFilter != $typeFilter) {
                    $isifilby = $currentFilter;
                } else if ($currentFilter == $typeFilter) {
                    $isifilby = $typeFilter;
                }
            } elseif ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                $setSesiPageFilterBy = 10;
                if ($currentFilter != $typeFilter) {
                    $isifilby = $currentFilter;
                } else if ($currentFilter == $typeFilter) {
                    $isifilby = $typeFilter;
                }
            }  

        } elseif ($currentFilter == 'BUKU') {

            if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {
                $setSesiPageFilterBy = 4;
                if ($currentFilter != $typeFilter) {
                    $isifilby = $currentFilter;
                } else if ($currentFilter == $typeFilter) {
                    $isifilby = $typeFilter;
                }
            } else if ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                $setSesiPageFilterBy = 11;
                if ($currentFilter != $typeFilter) {
                    $isifilby = $currentFilter;
                } else if ($currentFilter == $typeFilter) {
                    $isifilby = $typeFilter;
                }
            }

        } elseif ($currentFilter == 'SERAGAM') {
            if($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {
                $setSesiPageFilterBy = 5;
                if ($currentFilter != $typeFilter) {
                    $isifilby = $currentFilter;
                } else if ($currentFilter == $typeFilter) {
                    $isifilby = $typeFilter;
                }
            } else if ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                $setSesiPageFilterBy = 12;
                if ($currentFilter != $typeFilter) {
                    $isifilby = $currentFilter;
                } else if ($currentFilter == $typeFilter) {
                    $isifilby = $typeFilter;
                }
            } 
        } elseif ($currentFilter == 'REGISTRASI') {
            if ($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {
                $setSesiPageFilterBy = 6;
                if ($currentFilter != $typeFilter) {
                    $isifilby = $currentFilter;
                } else if ($currentFilter == $typeFilter) {
                    $isifilby = $typeFilter;
                }
            } else if ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                $setSesiPageFilterBy = 13;
                if ($currentFilter != $typeFilter) {
                    $isifilby = $currentFilter;
                } else if ($currentFilter == $typeFilter) {
                    $isifilby = $typeFilter;
                }
            }
        } elseif ($currentFilter == 'LAIN') {
            if ($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59" || $tanggalDari == "kosong_tgl1" && $tanggalSampai == "kosong_tgl2") {
                $setSesiPageFilterBy = 7;
                if ($currentFilter != $typeFilter) {
                    $isifilby = $currentFilter;
                } else if ($currentFilter == $typeFilter) {
                    $isifilby = $typeFilter;
                }
            } else if ($dariTanggal != ' 00:00:00' && $sampaiTanggal != ' 23:59:59') {
                $setSesiPageFilterBy = 14;
                if ($currentFilter != $typeFilter) {
                    $isifilby = $currentFilter;
                } else if ($currentFilter == $typeFilter) {
                    $isifilby = $typeFilter;
                }
            } 
        }

        $iniScrollBackPage = "ada";

    }
    // Akhir Tombol Kembali

    // Jika Ada Tombol simpan_tambah_edit
    elseif (isset($_POST['simpan_tambah_edit'])) {

        $id         = $_POST['data_id_siswa'];
        $nis        = $_POST['data_nis_siswa'];
        $namaSiswa  = $_POST['data_nama_siswa'];
        $kelas      = $_POST['data_kelas_siswa'];
        $panggilan  = $_POST['data_panggilan_siswa'];

        $idInvoice       = $_POST['idInvoice'];
        $currentFilter   = $_POST['currentFilter'];
        $typeFilter      = htmlspecialchars($_POST['isi_filter_edit']);

        $dariTanggal    = $_POST['tanggal1'];
        $sampaiTanggal  = $_POST['tanggal2'];

        $tanggalDari    = str_replace([" 00:00:00"], "", $dariTanggal);
        $tanggalSampai  = str_replace([" 23:59:59"], "", $sampaiTanggal);

        $typeFilter      = htmlspecialchars($_POST['isi_filter_edit']);

        $halamanAktif    = $_POST['currentPage'];
        $currentFilter   = $_POST['currentFilter'];

        $data_uang_spp   = str_replace(["Rp. ", "Rp ", "."], "", $_POST['nominal_spp_edit']);
        $data_ket_spp    = htmlspecialchars($_POST['ket_uang_spp_edit']);
        if ($data_ket_spp == '') {
            $data_ket_spp = NULL;
        } else if ($data_ket_spp != '') {
            $data_ket_spp       = htmlspecialchars($_POST['ket_uang_spp_edit']);
            // echo $data_ket_spp . " ";
        }

        $data_uang_pangkal      = str_replace(["Rp. ", "Rp ", "."], "", $_POST['nominal_pangkal_edit']);
        $data_ket_pangkal       = htmlspecialchars($_POST['ket_uang_pangkal_edit']);
        if ($data_ket_pangkal == '') {
            $data_ket_pangkal = null;
        } else if ($data_ket_pangkal != '') {
            $data_ket_pangkal       = htmlspecialchars($_POST['ket_uang_pangkal_edit']);
            // echo $data_ket_pangkal . " ";
        }

        $data_uang_kegiatan     = str_replace(["Rp. ", "Rp ", "."], "", $_POST['nominal_kegiatan_edit']);
        $data_ket_kegiatan      = htmlspecialchars($_POST['ket_uang_kegiatan_edit']);
        if ($data_ket_kegiatan == '') {
            $data_ket_kegiatan = null;
        } else if ($data_ket_kegiatan != '') {
            $data_ket_kegiatan       = htmlspecialchars($_POST['ket_uang_kegiatan_edit']);
            // echo $data_ket_kegiatan . " ";
        }

        $data_uang_buku         = str_replace(["Rp. ", "Rp ", "."], "", $_POST['nominal_buku_edit']);
        $data_ket_buku          = htmlspecialchars($_POST['ket_uang_buku_edit']);
        if ($data_ket_buku == '') {
            $data_ket_buku = null;
        } else if ($data_ket_buku != '') {
            $data_ket_buku       = htmlspecialchars($_POST['ket_uang_buku_edit']);
            // echo $data_ket_buku . " ";
        }

        $data_uang_seragam      = str_replace(["Rp. ", "Rp ", "."], "", $_POST['nominal_seragam_edit']);
        $data_ket_seragam       = htmlspecialchars($_POST['ket_uang_seragam_edit']);
        if ($data_ket_seragam == '') {
            $data_ket_seragam = null;
        } else if ($data_ket_seragam != '') {
            $data_ket_seragam       = htmlspecialchars($_POST['ket_uang_seragam_edit']);
            // echo $data_ket_seragam . " ";
        }

        $data_uang_registrasi   = str_replace(["Rp. ", "Rp ", "."], "", $_POST['nominal_regis_edit']);
        $data_ket_registrasi    = htmlspecialchars($_POST['ket_uang_regis_edit']);
        if ($data_ket_registrasi == '') {
            $data_ket_registrasi = null;
        } else if ($data_ket_registrasi != '') {
            $data_ket_registrasi       = htmlspecialchars($_POST['ket_uang_regis_edit']);
            // echo $data_ket_registrasi . " ";
        }

        $data_uang_lain         = str_replace(["Rp. ", "Rp ", "."], "", $_POST['nominal_lain_edit']);
        $data_ket_lain          = htmlspecialchars($_POST['ket_uang_lain2_edit']);
        if ($data_ket_lain == '') {
            $data_ket_lain = null;
        } else if ($data_ket_lain != '') {
            $data_ket_lain       = mysqli_real_escape_string($con, htmlspecialchars($_POST['ket_uang_lain2_edit']));
            // echo $data_ket_lain;
        }
        // echo $data_ket_lain;exit;
        $data_stamp         = date("Y-m-d H:i:s");

        $dataIDInvoice = "";

        if ($_SESSION['c_accounting'] == 'accounting1') {

            // echo $data_uang_pangkal . " " . $data_ket_pangkal;exit;
            if ($timeRunningOut == $timeOut || $timeRunningOut > $timeOut) {

                $_SESSION['form_success'] = "session_time_out";
                $timeIsOut = 1;
                // exit;

            } else {

                if ($currentFilter == 'SPP') {

                    if ($dariTanggal != " 00:00:00" && $sampaiTanggal != " 23:59:59") {
                        $setSesiPageFilterBy = 8;
                    } else if ($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59") {
                        $setSesiPageFilterBy = 1;
                    }

                    $isifilby = $currentFilter;

                } elseif ($currentFilter == 'PANGKAL') {

                    if ($dariTanggal != " 00:00:00" && $sampaiTanggal != " 23:59:59") {
                        $setSesiPageFilterBy = 9;
                    } else if ($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59") {
                        $setSesiPageFilterBy = 2;
                    }

                    $isifilby = $currentFilter;

                } elseif ($currentFilter == 'KEGIATAN') {
                    
                    if ($dariTanggal != " 00:00:00" && $sampaiTanggal != " 23:59:59") {
                        $setSesiPageFilterBy = 10;
                    } else if ($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59") {
                        $setSesiPageFilterBy = 3;
                    }

                    $isifilby = $currentFilter;

                } elseif ($currentFilter == 'BUKU') {
                    
                    if ($dariTanggal != " 00:00:00" && $sampaiTanggal != " 23:59:59") {
                        $setSesiPageFilterBy = 11;
                    } else if ($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59") {
                        $setSesiPageFilterBy = 4;
                    }

                    $isifilby = $currentFilter;
                    // echo "Buku ";

                } elseif ($currentFilter == 'SERAGAM') {
                    
                    if ($dariTanggal != " 00:00:00" && $sampaiTanggal != " 23:59:59") {
                        $setSesiPageFilterBy = 12;
                    } else if ($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59") {
                        $setSesiPageFilterBy = 5;
                    }

                    $isifilby = $currentFilter;
                    // echo "Buku ";

                } elseif ($currentFilter == 'REGISTRASI') {
                    
                    if ($dariTanggal != " 00:00:00" && $sampaiTanggal != " 23:59:59") {
                        $setSesiPageFilterBy = 13;
                    } else if ($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59") {
                        $setSesiPageFilterBy = 6;
                    }

                    // echo "REGISTRASI";exit;

                    $isifilby = $currentFilter;
                    // echo "Buku ";

                } elseif ($currentFilter == 'LAIN') {
                    
                    if ($dariTanggal != " 00:00:00" && $sampaiTanggal != " 23:59:59") {
                        $setSesiPageFilterBy = 14;
                    } else if ($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59") {
                        $setSesiPageFilterBy = 7;
                    }

                    $isifilby = $currentFilter;
                    // echo "Buku ";

                } 

                // Update Data 
                $queryUpdate = '
                    UPDATE `u415776667_spp`.`input_data_sd_lama1` 
                    SET 
                    `SPP`="$data_uang_spp",
                    `SPP_txt`="$data_ket_spp",
                    `PANGKAL`="$data_uang_pangkal",
                    `PANGKAL_txt`="$data_ket_pangkal",
                    `KEGIATAN`="$data_uang_kegiatan", 
                    `KEGIATAN_txt`="$data_ket_kegiatan",
                    `BUKU`="$data_uang_buku",
                    `BUKU_txt`="$data_ket_buku",
                    `SERAGAM`="$data_uang_seragam",
                    `SERAGAM_txt`="$data_ket_seragam",
                    `REGISTRASI`="$data_uang_registrasi",
                    `REGISTRASI_txt`="$data_ket_registrasi",
                    `LAIN`="$data_uang_lain",
                    `LAIN_txt`="$data_ket_lain",
                    `STAMP`="$data_stamp"
                    WHERE `ID`= "$idInvoice"
                ';

                mysqli_query($con, $queryUpdate);

                $iniScrollBackSave = 'ada';

            }

        } else if ($_SESSION['c_accounting'] == 'accounting2') {

            if ($timeRunningOut == $timeOut || $timeRunningOut > $timeOut) {

                $_SESSION['form_success'] = "session_time_out";
                $timeIsOut = 1;
                // exit;

            } else {

                if ($currentFilter == 'SPP') {

                    if ($dariTanggal != " 00:00:00" && $sampaiTanggal != " 23:59:59") {
                        $setSesiPageFilterBy = 8;
                        // echo $idInvoice . " " . $data_uang_buku;exit;
                    } else if ($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59") {
                        $setSesiPageFilterBy = 1;
                    }

                    $isifilby = $currentFilter;

                } elseif ($currentFilter == 'PANGKAL') {

                    if ($dariTanggal != " 00:00:00" && $sampaiTanggal != " 23:59:59") {
                        $setSesiPageFilterBy = 9;
                    } else if ($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59") {
                        $setSesiPageFilterBy = 2;
                    }

                    $isifilby = $currentFilter;

                } elseif ($currentFilter == 'KEGIATAN') {

                    if ($dariTanggal != " 00:00:00" && $sampaiTanggal != " 23:59:59") {
                        $setSesiPageFilterBy = 10;
                    } else if ($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59") {
                        $setSesiPageFilterBy = 3;
                    }

                    $isifilby = $currentFilter;

                } elseif ($currentFilter == 'BUKU') {
                    
                    if ($dariTanggal != " 00:00:00" && $sampaiTanggal != " 23:59:59") {
                        $setSesiPageFilterBy = 11;
                    } else if ($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59") {
                        $setSesiPageFilterBy = 4;
                    }

                    $isifilby = $currentFilter;

                } elseif ($currentFilter == 'SERAGAM') {
                    
                    if ($dariTanggal != " 00:00:00" && $sampaiTanggal != " 23:59:59") {
                        $setSesiPageFilterBy = 12;
                    } else if ($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59") {
                        $setSesiPageFilterBy = 5;
                    }

                    $isifilby = $currentFilter;
                    // echo "Buku ";

                } elseif ($currentFilter == 'REGISTRASI') {
                    
                    if ($dariTanggal != " 00:00:00" && $sampaiTanggal != " 23:59:59") {
                        $setSesiPageFilterBy = 13;
                    } else if ($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59") {
                        $setSesiPageFilterBy = 6;
                    }

                    $isifilby = $currentFilter;
                    // echo "Buku ";

                } elseif ($currentFilter == 'LAIN') {
                    echo "Lain ";
                    
                    if ($dariTanggal != " 00:00:00" && $sampaiTanggal != " 23:59:59") {
                        $setSesiPageFilterBy = 14;
                    } else if ($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59") {
                        $setSesiPageFilterBy = 7;
                    }

                    $isifilby = $currentFilter;
                    // echo "Buku ";

                } 

                // Update Data 
                $queryUpdate = "
                    UPDATE `u415776667_spp`.`input_data_tk_lama` 
                    SET 
                    `SPP`='$data_uang_spp',
                    `SPP_txt`='$data_ket_spp',
                    `PANGKAL`='$data_uang_pangkal',
                    `PANGKAL_txt`='$data_ket_pangkal',
                    `KEGIATAN`='$data_uang_kegiatan', 
                    `KEGIATAN_txt`='$data_ket_kegiatan',
                    `BUKU`='$data_uang_buku',
                    `BUKU_txt`='$data_ket_buku',
                    `SERAGAM`='$data_uang_seragam',
                    `SERAGAM_txt`='$data_ket_seragam',
                    `REGISTRASI`='$data_uang_registrasi',
                    `REGISTRASI_txt`='$data_ket_registrasi',
                    `LAIN`='$data_uang_lain',
                    `LAIN_txt`='$data_ket_lain',
                    `STAMP`='$data_stamp'
                    WHERE `ID`= '$idInvoice'
                ";

                mysqli_query($con, $queryUpdate);

                $iniScrollBackSave = 'ada';

            }

        }

    }
    // Akhir Bagian Tombol simpan_tambah_edit

    // Bagian Pagination

    // SPP
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

        $dariTanggal    = $_POST['tanggal1'];
        $sampaiTanggal  = $_POST['tanggal2'];

        $tanggalDari    = str_replace([" 00:00:00"], "", $dariTanggal);
        $tanggalSampai  = str_replace([" 23:59:59"], "", $sampaiTanggal);

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

        } else if ($_SESSION['c_accounting'] == 'accounting2') {

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

        $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

        $namaMurid = $_POST['namaSiswaFilterSPP'];
        $isifilby  = $_POST['iniFilterSPP'];

        $id        = $_POST['idSiswaFilterSPP'];
        $nis       = $_POST['nisFormFilterSPP'];
        $namaSiswa = $_POST['namaFormFilterSPP'];
        $panggilan = $_POST['panggilanFormFilterSPP'];
        $kelas     = $_POST['kelasFormFilterSPP'];

        $dariTanggal    = $_POST['tanggal1'];
        $sampaiTanggal  = $_POST['tanggal2'];

        $tanggalDari    = str_replace([" 00:00:00"], "", $dariTanggal);
        $tanggalSampai  = str_replace([" 23:59:59"], "", $sampaiTanggal);

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

        $namaMurid = $_POST['namaSiswaFilterSPP'];
        $isifilby  = $_POST['iniFilterSPP'];

        $namaSiswa = $namaMurid;
        $id        = $_POST['idSiswaFilterSPP'];
        $nis       = $_POST['nisFormFilterSPP'];
        $panggilan = $_POST['panggilanFormFilterSPP'];
        $kelas     = $_POST['kelasFormFilterSPP'];

        $dariTanggal    = $_POST['tanggal1'];
        $sampaiTanggal  = $_POST['tanggal2'];

        $tanggalDari    = str_replace([" 00:00:00"], "", $dariTanggal);
        $tanggalSampai  = str_replace([" 23:59:59"], "", $sampaiTanggal);

        $iniScrollToPage = "ada";

        if ($_SESSION['c_accounting'] == 'accounting1') {

            $setSesiPageFilterBy = 1;

            $queryGetDataSPP = "
                SELECT ID, NIS, NAMA, kelas, SPP, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd_lama1
                WHERE
                SPP != 0
                AND NAMA LIKE '%$namaMurid%' 
            ";
            $execQueryDataSPP    = mysqli_query($con, $queryGetDataSPP);
            $hitungDataFilterSPP = mysqli_num_rows($execQueryDataSPP);

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, SPP, TRANSAKSI, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd_lama1
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

        } else if ($_SESSION['c_accounting'] == 'accounting2') {
            
            $setSesiPageFilterBy = 1;
            
            $queryGetDataSPP = "
                SELECT ID, NIS, NAMA, kelas, SPP, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk_lama
                WHERE
                SPP != 0
                AND NAMA LIKE '%$namaMurid%' 
            ";
            $execQueryDataSPP    = mysqli_query($con, $queryGetDataSPP);
            $hitungDataFilterSPP = mysqli_num_rows($execQueryDataSPP);

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, SPP, TRANSAKSI, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk_lama
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

    elseif (isset($_POST['firstPageFilterSPP'])) {

        $namaMurid      = $_POST['namaFormFilterSPP'];

        $id             = $_POST['idSiswaFilterSPP'];
        $nis            = $_POST['nisFormFilterSPP'];
        $kelas          = $_POST['kelasFormFilterSPP'];
        $panggilan      = $_POST['panggilanFormFilterSPP'];
        $namaSiswa      = $namaMurid;

        $isifilby       = $_POST['iniFilterSPP'];

        $iniScrollFirstPage  = "ada";
        $setSesiPageFilterBy = 1;

        $dariTanggal    = $_POST['tanggal1'];
        $sampaiTanggal  = $_POST['tanggal2'];

        $tanggalDari    = str_replace([" 00:00:00"], "", $dariTanggal);
        $tanggalSampai  = str_replace([" 23:59:59"], "", $sampaiTanggal);

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

            $halamanAktif   = 1;

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

            $halamanAktif   = 1;

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

    elseif(isset($_POST['lastPageFilterSPP'])) {

        $namaMurid      = $_POST['namaSiswaFilterSPP'];
        $isifilby       = $_POST['iniFilterSPP'];

        $id             = $_POST['idSiswaFilterSPP'];
        $namaSiswa      = $namaMurid;
        $kelas          = $_POST['kelasFormFilterSPP'];
        $panggilan      = $_POST['panggilanFormFilterSPP'];
        $nis            = $_POST['nisFormFilterSPP'];

        $iniScrollLastPage  = "ada";
        $setSesiPageFilterBy = 1;

        $dariTanggal    = $_POST['tanggal1'];
        $sampaiTanggal  = $_POST['tanggal2'];

        $tanggalDari    = str_replace([" 00:00:00"], "", $dariTanggal);
        $tanggalSampai  = str_replace([" 23:59:59"], "", $sampaiTanggal);

        echo $tanggalDari;

        if ($_SESSION['c_accounting'] == 'accounting1') {

            $execQueryGetAllDataHistoriFilterSPP = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, SPP, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd_lama1
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
                FROM input_data_sd_lama1
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

        } else if ($_SESSION['c_accounting'] == 'accounting2') {

            $execQueryGetAllDataHistoriFilterSPP = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, SPP, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk_lama
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
                FROM input_data_tk_lama
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

    elseif (isset($_POST['nextPageFilterSPPWithDate'])) {

        $halamanAktif       = $_POST['halamanLanjutFilterSPPWithDate'];
        $iniScrollNextPage  = "ada";

        $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

        $namaMurid  = $_POST['namaSiswaFilterSPPWithDate'];
        $isifilby   = $_POST['iniFilterSPPWithDate'];

        $id         = $_POST['idSiswaFilterSPPWithDate'];
        $kelas      = $_POST['kelasFormFilterSPPWithDate'];
        $panggilan  = $_POST['panggilanFormFilterSPPWithDate'];
        $nis        = $_POST['nisFormFilterSPPWithDate'];
        $namaSiswa  = $_POST['namaFormFilterSPPWithDate'];

        $setSesiPageFilterBy = 8;

        $dariTanggal    = $_POST['tanggal1'];
        $sampaiTanggal  = $_POST['tanggal2'];

        $tanggalDari    = str_replace([" 00:00:00"], "", $dariTanggal);
        $tanggalSampai  = str_replace([" 23:59:59"], "", $sampaiTanggal);

        if ($_SESSION['c_accounting'] == 'accounting1') {

            $queryGetDataSPP = "
                SELECT ID, NIS, NAMA, kelas, SPP, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                SPP != 0
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
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
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
                LIMIT $dataAwal, $jumlahData
            ");
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

        } elseif ($_SESSION['c_accounting'] == 'accounting2') {

            $queryGetDataSPP = "
                SELECT ID, NIS, NAMA, kelas, SPP, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                SPP != 0
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
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
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
                LIMIT $dataAwal, $jumlahData
            ");
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

    else if (isset($_POST['previousPageFilterSPPWithDate'])) {

        $halamanAktif           = $_POST['halamanSebelumnyaFilterSPPWithDate'];
        $iniScrollPreviousPage  = "ada";

        $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

        $namaMurid = $_POST['namaSiswaFilterSPPWithDate'];
        $isifilby  = $_POST['iniFilterSPPWithDate'];

        $id        = $_POST['idSiswaFilterSPPWithDate'];
        $nis       = $_POST['nisFormFilterSPPWithDate'];
        $namaSiswa = $_POST['namaFormFilterSPPWithDate'];
        $panggilan = $_POST['panggilanFormFilterSPPWithDate'];
        $kelas     = $_POST['kelasFormFilterSPPWithDate'];

        $setSesiPageFilterBy = 8;

        $dariTanggal    = $_POST['tanggal1'];
        $sampaiTanggal  = $_POST['tanggal2'];

        $tanggalDari    = str_replace([" 00:00:00"], "", $dariTanggal);
        $tanggalSampai  = str_replace([" 23:59:59"], "", $sampaiTanggal);

        if ($_SESSION['c_accounting'] == 'accounting1') {

            $queryGetDataSPP = "
                SELECT ID, NIS, NAMA, kelas, SPP, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                SPP != 0
                AND NAMA LIKE '%$namaMurid%'
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai' 
            ";

            $execQueryDataSPP    = mysqli_query($con, $queryGetDataSPP);
            $hitungDataFilterSPP = mysqli_num_rows($execQueryDataSPP);

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, SPP, TRANSAKSI, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                SPP != 0
                AND NAMA LIKE '%$namaMurid%'
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai' 
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

        } elseif ($_SESSION['c_accounting'] == 'accounting2') {

            $queryGetDataSPP = "
                SELECT ID, NIS, NAMA, kelas, SPP, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                SPP != 0
                AND NAMA LIKE '%$namaMurid%'
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai' 
            ";

            $execQueryDataSPP    = mysqli_query($con, $queryGetDataSPP);
            $hitungDataFilterSPP = mysqli_num_rows($execQueryDataSPP);

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, SPP, TRANSAKSI, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                SPP != 0
                AND NAMA LIKE '%$namaMurid%'
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai' 
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

    elseif (isset($_POST['toPageFilterSPPWithDate'])) {

        $halamanAktif = $_POST['halamanKeFilterSPPWithDate'];

        $namaMurid = $_POST['namaSiswaFilterSPPWithDate'];
        $isifilby  = $_POST['iniFilterSPPWithDate'];

        $namaSiswa = $namaMurid;
        $id        = $_POST['idSiswaFilterSPPWithDate'];
        $nis       = $_POST['nisFormFilterSPPWithDate'];
        $panggilan = $_POST['panggilanFormFilterSPPWithDate'];
        $kelas     = $_POST['kelasFormFilterSPPWithDate'];

        $iniScrollToPage = "ada";

        $setSesiPageFilterBy = 8;

        $dariTanggal    = $_POST['tanggal1'];
        $sampaiTanggal  = $_POST['tanggal2'];

        $tanggalDari    = str_replace([" 00:00:00"], "", $dariTanggal);
        $tanggalSampai  = str_replace([" 23:59:59"], "", $sampaiTanggal);

        if ($_SESSION['c_accounting'] == 'accounting1') {

            $queryGetDataSPP = "
                SELECT ID, NIS, NAMA, kelas, SPP, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                SPP != 0
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
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
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
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

        } elseif ($_SESSION['c_accounting'] == 'accounting2') {

            $queryGetDataSPP = "
                SELECT ID, NIS, NAMA, kelas, SPP, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                SPP != 0
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
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
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
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

    elseif (isset($_POST['firstPageFilterSPPWithDate'])) {

        $namaMurid      = $_POST['namaFormFilterSPPWithDate'];

        $id             = $_POST['idSiswaFilterSPPWithDate'];
        $nis            = $_POST['nisFormFilterSPPWithDate'];
        $kelas          = $_POST['kelasFormFilterSPPWithDate'];
        $panggilan      = $_POST['panggilanFormFilterSPPWithDate'];
        $namaSiswa      = $namaMurid;

        $isifilby       = $_POST['iniFilterSPPWithDate'];

        $iniScrollFirstPage    = "ada";
        $setSesiPageFilterBy   = 8;

        $dariTanggal    = $_POST['tanggal1'];
        $sampaiTanggal  = $_POST['tanggal2'];

        $tanggalDari    = str_replace([" 00:00:00"], "", $dariTanggal);
        $tanggalSampai  = str_replace([" 23:59:59"], "", $sampaiTanggal);

        if ($_SESSION['c_accounting'] == 'accounting1') {

            $execQueryGetAllDataHistoriFilterSPP = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, SPP, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                SPP != 0
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
                AND NAMA LIKE '%$namaMurid%'
            ");

            $totalData = mysqli_num_rows($execQueryGetAllDataHistoriFilterSPP);
            // echo $totalData;

            $jumlahPagination = ceil($totalData / $jumlahData);

            $halamanAktif   = 1;

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $hitungDataFilterSPP = $jumlahPagination;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, SPP, TRANSAKSI, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                SPP != 0
                AND NAMA LIKE '%$namaMurid%'
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
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

        } elseif ($_SESSION['c_accounting'] == 'accounting2') {

            $execQueryGetAllDataHistoriFilterSPP = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, SPP, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                SPP != 0
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
                AND NAMA LIKE '%$namaMurid%'
            ");

            $totalData = mysqli_num_rows($execQueryGetAllDataHistoriFilterSPP);
            // echo $totalData;

            $jumlahPagination = ceil($totalData / $jumlahData);

            $halamanAktif   = 1;

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $hitungDataFilterSPP = $jumlahPagination;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, SPP, TRANSAKSI, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                SPP != 0
                AND NAMA LIKE '%$namaMurid%'
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
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

    elseif (isset($_POST['lastPageFilterSPPWithDate'])) {

        $namaMurid      = $_POST['namaSiswaFilterSPPWithDate'];
        $isifilby       = $_POST['iniFilterSPPWithDate'];

        $id             = $_POST['idSiswaFilterSPPWithDate'];
        $namaSiswa      = $namaMurid;
        $kelas          = $_POST['kelasFormFilterSPPWithDate'];
        $panggilan      = $_POST['panggilanFormFilterSPPWithDate'];
        $nis            = $_POST['nisFormFilterSPPWithDate'];

        $iniScrollLastPage    = "ada";
        $setSesiPageFilterBy   = 8;

        $dariTanggal    = $_POST['tanggal1'];
        $sampaiTanggal  = $_POST['tanggal2'];

        $tanggalDari    = str_replace([" 00:00:00"], "", $dariTanggal);
        $tanggalSampai  = str_replace([" 23:59:59"], "", $sampaiTanggal);

        if ($_SESSION['c_accounting'] == 'accounting1') {

            $execQueryGetAllDataHistoriFilterSPP = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, SPP, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd_lama1
                WHERE
                SPP != 0
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                AND NAMA LIKE '%$namaMurid%'
            ");

            $totalData = mysqli_num_rows($execQueryGetAllDataHistoriFilterSPP);
            // echo $totalData;

            $jumlahPagination = ceil($totalData / $jumlahData);

            $halamanAktif   = $jumlahPagination;
            // echo $halamanAktif;exit;

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $hitungDataFilterSPP = $jumlahPagination;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, SPP, TRANSAKSI, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd_lama1
                WHERE
                SPP != 0
                AND NAMA LIKE '%$namaMurid%'
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
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

        } elseif ($_SESSION['c_accounting'] == 'accounting2') {
            // echo "Last";exit;
            $namaMurid      = $_POST['namaSiswaFilterSPPWithDate'];
            $isifilby       = $_POST['iniFilterSPPWithDate'];

            $id             = $_POST['idSiswaFilterSPPWithDate'];
            $namaSiswa      = $namaMurid;
            $kelas          = $_POST['kelasFormFilterSPPWithDate'];
            $panggilan      = $_POST['panggilanFormFilterSPPWithDate'];
            $nis            = $_POST['nisFormFilterSPPWithDate'];

            $execQueryGetAllDataHistoriFilterSPP = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, SPP, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk_lama
                WHERE
                SPP != 0
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                AND NAMA LIKE '%$namaMurid%'
            ");

            $totalData = mysqli_num_rows($execQueryGetAllDataHistoriFilterSPP);
            // echo $totalData;

            $jumlahPagination = ceil($totalData / $jumlahData);

            $halamanAktif   = $jumlahPagination;
            // echo $halamanAktif;exit;

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $hitungDataFilterSPP = $jumlahPagination;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, SPP, TRANSAKSI, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk_lama
                WHERE
                SPP != 0
                AND NAMA LIKE '%$namaMurid%'
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                order by stamp
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
    // AKHIR SPP

    // PANGKAL
    elseif (isset($_POST['nextPageFilterPANGKAL'])) {

        $halamanAktif       = $_POST['halamanLanjutFilterPANGKAL'];
        $iniScrollNextPage  = "ada";

        $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

        $namaMurid  = $_POST['namaSiswaFilterPANGKAL'];
        $isifilby   = $_POST['iniFilterPANGKAL'];

        $id         = $_POST['idSiswaFilterPANGKAL'];
        $kelas      = $_POST['kelasFormFilterPANGKAL'];
        $panggilan  = $_POST['panggilanFormFilterPANGKAL'];
        $nis        = $_POST['nisFormFilterPANGKAL'];
        $namaSiswa  = $_POST['namaFormFilterPANGKAL'];

        $dariTanggal    = $_POST['tanggal1'] . " 00:00:00";
        $sampaiTanggal  = $_POST['tanggal2'] . " 23:59:59";

        $tanggalDari    = str_replace([" 00:00:00"], "", $dariTanggal);
        $tanggalSampai  = str_replace([" 23:59:59"], "", $sampaiTanggal);

        $setSesiPageFilterBy = 2;

        if ($_SESSION['c_accounting'] == 'accounting1') {

            $queryGetDataPangkal = "
                SELECT ID, NIS, NAMA, kelas, PANGKAL, BULAN AS pembayaran_bulan, PANGKAL_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd_lama1
                WHERE
                PANGKAL != 0
                AND NAMA LIKE '%$namaMurid%' 
            ";
            $execQueryDataPangkal    = mysqli_query($con, $queryGetDataPangkal);
            $hitungDataFilterPANGKAL = mysqli_num_rows($execQueryDataPangkal);

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, PANGKAL, TRANSAKSI, BULAN AS pembayaran_bulan, PANGKAL_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd_lama1
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

        } else {

            $queryGetDataPangkal = "
                SELECT ID, NIS, NAMA, kelas, PANGKAL, BULAN AS pembayaran_bulan, PANGKAL_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk_lama
                WHERE
                PANGKAL != 0
                AND NAMA LIKE '%$namaMurid%' 
            ";
            $execQueryDataPangkal    = mysqli_query($con, $queryGetDataPangkal);
            $hitungDataFilterPANGKAL = mysqli_num_rows($execQueryDataPangkal);

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, PANGKAL, TRANSAKSI, BULAN AS pembayaran_bulan, PANGKAL_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk_lama
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

    }

    elseif (isset($_POST['previousPageFilterPANGKAL'])) {

        $halamanAktif           = $_POST['halamanSebelumnyaFilterPANGKAL'];
        $iniScrollPreviousPage  = "ada";

        $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

        $namaMurid = $_POST['namaSiswaFilterPANGKAL'];
        $isifilby  = $_POST['iniFilterPANGKAL'];

        $id        = $_POST['idSiswaFilterPANGKAL'];
        $nis       = $_POST['nisFormFilterPANGKAL'];
        $namaSiswa = $_POST['namaFormFilterPANGKAL'];
        $panggilan = $_POST['panggilanFormFilterPANGKAL'];
        $kelas     = $_POST['kelasFormFilterPANGKAL'];

        $dariTanggal    = " 00:00:00";
        $sampaiTanggal  = " 23:59:59";

        $tanggalDari    = str_replace([" 00:00:00"], "", $dariTanggal);
        $tanggalSampai  = str_replace([" 23:59:59"], "", $sampaiTanggal);

        $iniScrollPreviousPage = "ada";
        $setSesiPageFilterBy = 2;

        if ($_SESSION['c_accounting'] == 'accounting1') {

            $queryGetDataPANGKAL = "
                SELECT ID, NIS, NAMA, kelas, PANGKAL, BULAN AS pembayaran_bulan, PANGKAL_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                PANGKAL != 0
                AND NAMA LIKE '%$namaMurid%' 
            ";
            $execQueryDataPANGKAL    = mysqli_query($con, $queryGetDataPANGKAL);
            $hitungDataFilterPANGKAL = mysqli_num_rows($execQueryDataPANGKAL);

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

        } else {

            $queryGetDataPANGKAL = "
                SELECT ID, NIS, NAMA, kelas, PANGKAL, BULAN AS pembayaran_bulan, PANGKAL_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                PANGKAL != 0
                AND NAMA LIKE '%$namaMurid%' 
            ";
            $execQueryDataPANGKAL    = mysqli_query($con, $queryGetDataPANGKAL);
            $hitungDataFilterPANGKAL = mysqli_num_rows($execQueryDataPANGKAL);

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, PANGKAL, TRANSAKSI, BULAN AS pembayaran_bulan, PANGKAL_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
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

    }

    elseif (isset($_POST['toPageFilterPANGKAL'])) {

        $halamanAktif = $_POST['halamanKeFilterPANGKAL'];
        $iniScrollToPage = "ada";

        $namaMurid = $_POST['namaSiswaFilterPANGKAL'];
        $isifilby  = $_POST['iniFilterPANGKAL'];

        $namaSiswa = $namaMurid;
        $id        = $_POST['idSiswaFilterPANGKAL'];
        $nis       = $_POST['nisFormFilterPANGKAL'];
        $panggilan = $_POST['panggilanFormFilterPANGKAL'];
        $kelas     = $_POST['kelasFormFilterPANGKAL'];

        $dariTanggal    = $_POST['tanggal1'] . " 00:00:00";
        $sampaiTanggal  = $_POST['tanggal2'] . " 23:59:59";

        $tanggalDari    = str_replace([" 00:00:00"], "", $dariTanggal);
        $tanggalSampai  = str_replace([" 23:59:59"], "", $sampaiTanggal);

        $setSesiPageFilterBy = 2;

        if ($_SESSION['c_accounting'] == 'accounting1') {

            $queryGetDataPANGKAL = "
                SELECT ID, NIS, NAMA, kelas, PANGKAL, BULAN AS pembayaran_bulan, PANGKAL_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                PANGKAL != 0
                AND NAMA LIKE '%$namaMurid%' 
            ";
            $execQueryDataPANGKAL    = mysqli_query($con, $queryGetDataPANGKAL);
            $hitungDataFilterPANGKAL = mysqli_num_rows($execQueryDataPANGKAL);

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

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

        } else {

            $queryGetDataPANGKAL = "
                SELECT ID, NIS, NAMA, kelas, PANGKAL, BULAN AS pembayaran_bulan, PANGKAL_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                PANGKAL != 0
                AND NAMA LIKE '%$namaMurid%' 
            ";
            $execQueryDataPANGKAL    = mysqli_query($con, $queryGetDataPANGKAL);
            $hitungDataFilterPANGKAL = mysqli_num_rows($execQueryDataPANGKAL);

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, PANGKAL, TRANSAKSI, BULAN AS pembayaran_bulan, PANGKAL_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
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

    }

    elseif (isset($_POST['firstPageFilterPANGKAL'])) {

        $namaMurid      = $_POST['namaFormFilterPANGKAL'];

        $id             = $_POST['idSiswaFilterPANGKAL'];
        $nis            = $_POST['nisFormFilterPANGKAL'];
        $kelas          = $_POST['kelasFormFilterPANGKAL'];
        $panggilan      = $_POST['panggilanFormFilterPANGKAL'];
        $namaSiswa      = $namaMurid;

        $dariTanggal    = $_POST['tanggal1'] . " 00:00:00";
        $sampaiTanggal  = $_POST['tanggal2'] . " 23:59:59";

        $tanggalDari    = str_replace([" 00:00:00"], "", $dariTanggal);
        $tanggalSampai  = str_replace([" 23:59:59"], "", $sampaiTanggal);

        $isifilby       = $_POST['iniFilterPANGKAL'];

        $iniScrollFirstPage  = "ada";
        $setSesiPageFilterBy = 2;

        if ($_SESSION['c_accounting'] == 'accounting1') {

            $execQueryGetAllDataHistoriFilterPANGKAL = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, PANGKAL, BULAN AS pembayaran_bulan, PANGKAL_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                PANGKAL != 0
                AND NAMA LIKE '%$namaMurid%'
            ");

            $totalData = mysqli_num_rows($execQueryGetAllDataHistoriFilterPANGKAL);

            $jumlahPagination = ceil($totalData / $jumlahData);

            $halamanAktif   = 1;

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $hitungDataFilterPANGKAL = $totalData;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, PANGKAL, TRANSAKSI, BULAN AS pembayaran_bulan, PANGKAL_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                PANGKAL != 0
                AND NAMA LIKE '%$namaMurid%'
                ORDER BY ID DESC
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

        } else if ($_SESSION['c_accounting'] == 'accounting2') {

            $execQueryGetAllDataHistoriFilterPANGKAL = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, PANGKAL, BULAN AS pembayaran_bulan, PANGKAL_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                PANGKAL != 0
                AND NAMA LIKE '%$namaMurid%'
            ");

            $totalData = mysqli_num_rows($execQueryGetAllDataHistoriFilterPANGKAL);

            $jumlahPagination = ceil($totalData / $jumlahData);

            $halamanAktif   = 1;

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $hitungDataFilterPANGKAL = $totalData;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, PANGKAL, TRANSAKSI, BULAN AS pembayaran_bulan, PANGKAL_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                PANGKAL != 0
                AND NAMA LIKE '%$namaMurid%'
                ORDER BY ID DESC
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

    elseif (isset($_POST['lastPageFilterPANGKAL'])) {

        $namaMurid      = $_POST['namaSiswaFilterPANGKAL'];
        $isifilby       = $_POST['iniFilterPANGKAL'];

        $id             = $_POST['idSiswaFilterPANGKAL'];
        $namaSiswa      = $namaMurid;
        $kelas          = $_POST['kelasFormFilterPANGKAL'];
        $panggilan      = $_POST['panggilanFormFilterPANGKAL'];
        $nis            = $_POST['nisFormFilterPANGKAL'];

        $dariTanggal    = $_POST['tanggal1'] . " 00:00:00";
        $sampaiTanggal  = $_POST['tanggal2'] . " 23:59:59";

        $tanggalDari    = str_replace([" 00:00:00"], "", $dariTanggal);
        $tanggalSampai  = str_replace([" 23:59:59"], "", $sampaiTanggal);

        $iniScrollLastPage  = "ada";
        $setSesiPageFilterBy = 2;

        if ($_SESSION['c_accounting'] == 'accounting1') {

            $execQueryGetAllDataHistoriFilterPANGKAL = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, PANGKAL, BULAN AS pembayaran_bulan, PANGKAL_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd_lama1
                WHERE
                PANGKAL != 0
                AND NAMA LIKE '%$namaMurid%'
            ");

            $totalData = mysqli_num_rows($execQueryGetAllDataHistoriFilterPANGKAL);

            $jumlahPagination = ceil($totalData / $jumlahData);

            $halamanAktif   = $jumlahPagination;
            // echo $halamanAktif;exit;

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $hitungDataFilterPANGKAL = $totalData;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, PANGKAL, TRANSAKSI, BULAN AS pembayaran_bulan, PANGKAL_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd_lama1
                WHERE
                PANGKAL != 0
                AND NAMA LIKE '%$namaMurid%'
                ORDER BY ID DESC
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

            $execQueryGetAllDataHistoriFilterPANGKAL = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, PANGKAL, BULAN AS pembayaran_bulan, PANGKAL_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk_lama
                WHERE
                PANGKAL != 0
                AND NAMA LIKE '%$namaMurid%'
            ");

            $totalData = mysqli_num_rows($execQueryGetAllDataHistoriFilterPANGKAL);

            $jumlahPagination = ceil($totalData / $jumlahData);

            $halamanAktif   = $jumlahPagination;
            // echo $halamanAktif;exit;

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $hitungDataFilterPANGKAL = $totalData;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, PANGKAL, TRANSAKSI, BULAN AS pembayaran_bulan, PANGKAL_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk_lama
                WHERE
                PANGKAL != 0
                AND NAMA LIKE '%$namaMurid%'
                ORDER BY ID DESC
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

    elseif (isset($_POST['nextPageFilterPangkalWithDate'])) {

        $halamanAktif       = $_POST['halamanLanjutFilterPangkalWithDate'];
        $iniScrollNextPage  = "ada";

        $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

        $namaMurid  = $_POST['namaSiswaFilterPangkalWithDate'];
        $isifilby   = $_POST['iniFilterPangkalWithDate'];

        $id         = $_POST['idSiswaFilterPangkalWithDate'];
        $kelas      = $_POST['kelasFormFilterPangkalWithDate'];
        $panggilan  = $_POST['panggilanFormFilterPangkalWithDate'];
        $nis        = $_POST['nisFormFilterPangkalWithDate'];
        $namaSiswa  = $_POST['namaFormFilterPangkalWithDate'];

        $setSesiPageFilterBy = 9;

        $dariTanggal    = $_POST['tanggal1'] . " 00:00:00";
        $sampaiTanggal  = $_POST['tanggal2'] . " 23:59:59";

        $tanggalDari    = str_replace([" 00:00:00"], "", $dariTanggal);
        $tanggalSampai  = str_replace([" 23:59:59"], "", $sampaiTanggal);

        if ($_SESSION['c_accounting'] == 'accounting1') {

            $queryGetDataPangkalWithDate = "
                SELECT ID, NIS, NAMA, kelas, PANGKAL, BULAN AS pembayaran_bulan, PANGKAL_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                PANGKAL != 0
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataPangkalWithDate    = mysqli_query($con, $queryGetDataPangkalWithDate);
            $hitungDataFilterPangkalWithDate = mysqli_num_rows($execQueryDataPangkalWithDate);

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, PANGKAL, TRANSAKSI, BULAN AS pembayaran_bulan, PANGKAL_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                PANGKAL != 0
                AND NAMA LIKE '%$namaMurid%'
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
                LIMIT $dataAwal, $jumlahData
            ");
            // print_r($ambildata_perhalaman->num_rows);

            $jumlahPagination = ceil($hitungDataFilterPangkalWithDate / $jumlahData);
            $hitungLagi = mysqli_num_rows($ambildata_perhalaman);

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

        } elseif ($_SESSION['c_accounting'] == 'accounting2') {

            $queryGetDataPangkalWithDate = "
                SELECT ID, NIS, NAMA, kelas, PANGKAL, BULAN AS pembayaran_bulan, PANGKAL_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                PANGKAL != 0
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataPangkalWithDate    = mysqli_query($con, $queryGetDataPangkalWithDate);
            $hitungDataFilterPangkalWithDate = mysqli_num_rows($execQueryDataPangkalWithDate);

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, PANGKAL, TRANSAKSI, BULAN AS pembayaran_bulan, PANGKAL_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                PANGKAL != 0
                AND NAMA LIKE '%$namaMurid%'
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
                LIMIT $dataAwal, $jumlahData
            ");
            // print_r($ambildata_perhalaman->num_rows);

            $jumlahPagination = ceil($hitungDataFilterPangkalWithDate / $jumlahData);
            $hitungLagi = mysqli_num_rows($ambildata_perhalaman);

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

    elseif (isset($_POST['previousPageFilterPangkalWithDate'])) {

        $halamanAktif           = $_POST['halamanSebelumnyaFilterPangkalWithDate'];
        $iniScrollPreviousPage  = "ada";

        $dataAwal   = ($halamanAktif * $jumlahData) - $jumlahData;

        $namaMurid  = $_POST['namaSiswaFilterPangkalWithDate'];
        $isifilby   = $_POST['iniFilterPangkalWithDate'];

        $id         = $_POST['idSiswaFilterPangkalWithDate'];
        $nis        = $_POST['nisFormFilterPangkalWithDate'];
        $namaSiswa  = $_POST['namaFormFilterPangkalWithDate'];
        $panggilan  = $_POST['panggilanFormFilterPangkalWithDate'];
        $kelas      = $_POST['kelasFormFilterPangkalWithDate'];

        $iniScrollPreviousPage = "ada";
        $setSesiPageFilterBy = 9;

        $dariTanggal    = $_POST['tanggal1'] . " 00:00:00";
        $sampaiTanggal  = $_POST['tanggal2'] . " 23:59:59";

        $tanggalDari    = str_replace([" 00:00:00"], "", $dariTanggal);
        $tanggalSampai  = str_replace([" 23:59:59"], "", $sampaiTanggal);

        if ($_SESSION['c_accounting'] == 'accounting1') {

            $queryGetDataPangkalWithDate = "
                SELECT ID, NIS, NAMA, kelas, PANGKAL, BULAN AS pembayaran_bulan, PANGKAL_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                PANGKAL != 0
                AND STAMP >= '.' '$tanggalDari' AND STAMP <= '$tanggalSampai'
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataPangkalWithDate    = mysqli_query($con, $queryGetDataPangkalWithDate);
            $hitungDataFilterPangkalWithDate = mysqli_num_rows($execQueryDataPangkalWithDate);
            // echo $hitungDataFilterPangkalWithDate;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, PANGKAL, TRANSAKSI, BULAN AS pembayaran_bulan, PANGKAL_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                PANGKAL != 0
                AND NAMA LIKE '%$namaMurid%'
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai' 
                LIMIT $dataAwal, $jumlahData");

            $jumlahPagination = ceil($hitungDataFilterPangkalWithDate / $jumlahData);

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

        } elseif ($_SESSION['c_accounting'] == 'accounting2') {

            $queryGetDataPangkalWithDate = "
                SELECT ID, NIS, NAMA, kelas, PANGKAL, BULAN AS pembayaran_bulan, PANGKAL_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                PANGKAL != 0
                AND STAMP >= '.' '$tanggalDari' AND STAMP <= '$tanggalSampai'
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataPangkalWithDate    = mysqli_query($con, $queryGetDataPangkalWithDate);
            $hitungDataFilterPangkalWithDate = mysqli_num_rows($execQueryDataPangkalWithDate);
            // echo $hitungDataFilterPangkalWithDate;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, PANGKAL, TRANSAKSI, BULAN AS pembayaran_bulan, PANGKAL_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                PANGKAL != 0
                AND NAMA LIKE '%$namaMurid%'
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai' 
                LIMIT $dataAwal, $jumlahData");

            $jumlahPagination = ceil($hitungDataFilterPangkalWithDate / $jumlahData);

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

    elseif (isset($_POST['toPageFilterPangkalWithDate'])) {

        $halamanAktif = $_POST['halamanKeFilterPangkalWithDate'];
        $iniScrollToPage = "ada";

        $namaMurid = $_POST['namaSiswaFilterPangkalWithDate'];
        $isifilby  = $_POST['iniFilterPangkalWithDate'];

        $namaSiswa = $namaMurid;
        $id        = $_POST['idSiswaFilterPangkalWithDate'];
        $nis       = $_POST['nisFormFilterPangkalWithDate'];
        $panggilan = $_POST['panggilanFormFilterPangkalWithDate'];
        $kelas     = $_POST['kelasFormFilterPangkalWithDate'];

        $setSesiPageFilterBy = 9;

        $dariTanggal    = $_POST['tanggal1'] . " 00:00:00";
        $sampaiTanggal  = $_POST['tanggal2'] . " 23:59:59";

        $tanggalDari    = str_replace([" 00:00:00"], "", $dariTanggal);
        $tanggalSampai  = str_replace([" 23:59:59"], "", $sampaiTanggal);

        if ($_SESSION['c_accounting'] == 'accounting1') {

            $queryGetDataPangkalWithDate = "
                SELECT ID, NIS, NAMA, kelas, PANGKAL, BULAN AS pembayaran_bulan, PANGKAL_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                PANGKAL != 0
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataPangkalWithDate    = mysqli_query($con, $queryGetDataPangkalWithDate);
            $hitungDataFilterSemuaWithDate = mysqli_num_rows($execQueryDataPangkalWithDate);

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, PANGKAL, TRANSAKSI, BULAN AS pembayaran_bulan, PANGKAL_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                PANGKAL != 0
                AND NAMA LIKE '%$namaMurid%'
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
                LIMIT $dataAwal, $jumlahData");
            // print_r($ambildata_perhalaman->num_rows);

            $jumlahPagination = ceil($hitungDataFilterSemuaWithDate / $jumlahData);

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

        } elseif ($_SESSION['c_accounting'] == 'accounting2') {

            $queryGetDataPangkalWithDate = "
                SELECT ID, NIS, NAMA, kelas, PANGKAL, BULAN AS pembayaran_bulan, PANGKAL_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                PANGKAL != 0
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataPangkalWithDate    = mysqli_query($con, $queryGetDataPangkalWithDate);
            $hitungDataFilterSemuaWithDate = mysqli_num_rows($execQueryDataPangkalWithDate);

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, PANGKAL, TRANSAKSI, BULAN AS pembayaran_bulan, PANGKAL_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                PANGKAL != 0
                AND NAMA LIKE '%$namaMurid%'
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
                LIMIT $dataAwal, $jumlahData");
            // print_r($ambildata_perhalaman->num_rows);

            $jumlahPagination = ceil($hitungDataFilterSemuaWithDate / $jumlahData);

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

    elseif (isset($_POST['firstPageFilterPangkalWithDate'])) {

        $namaMurid      = $_POST['namaFormFilterPangkalWithDate'];

        $id             = $_POST['idSiswaFilterPangkalWithDate'];
        $nis            = $_POST['nisFormFilterPangkalWithDate'];
        $kelas          = $_POST['kelasFormFilterPangkalWithDate'];
        $panggilan      = $_POST['panggilanFormFilterPangkalWithDate'];
        $namaSiswa      = $namaMurid;

        $isifilby       = $_POST['iniFilterPangkalWithDate'];

        $iniScrollFirstPage  = "ada";
        $setSesiPageFilterBy = 9;

        $dariTanggal    = $_POST['tanggal1'] . " 00:00:00";
        $sampaiTanggal  = $_POST['tanggal2'] . " 23:59:59";

        $tanggalDari    = str_replace([" 00:00:00"], "", $dariTanggal);
        $tanggalSampai  = str_replace([" 23:59:59"], "", $sampaiTanggal);

        if ($_SESSION['c_accounting'] == 'accounting1') {

            $execQueryGetAllDataHistoriFilterPangkalWithDate = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, PANGKAL, BULAN AS pembayaran_bulan, PANGKAL_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                PANGKAL != 0
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
                AND NAMA LIKE '%$namaMurid%'
            ");

            $totalData = mysqli_num_rows($execQueryGetAllDataHistoriFilterPangkalWithDate);
            // echo $totalData;

            $jumlahPagination = ceil($totalData / $jumlahData);

            $halamanAktif   = 1;

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $hitungDataFilterPangkalWithDate = $jumlahPagination;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, PANGKAL, TRANSAKSI, BULAN AS pembayaran_bulan, PANGKAL_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                PANGKAL != 0
                AND NAMA LIKE '%$namaMurid%'
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
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

        } elseif ($_SESSION['c_accounting'] == 'accounting2') {

            $execQueryGetAllDataHistoriFilterPangkalWithDate = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, PANGKAL, BULAN AS pembayaran_bulan, PANGKAL_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                PANGKAL != 0
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
                AND NAMA LIKE '%$namaMurid%'
            ");

            $totalData = mysqli_num_rows($execQueryGetAllDataHistoriFilterPangkalWithDate);
            // echo $totalData;

            $jumlahPagination = ceil($totalData / $jumlahData);

            $halamanAktif   = 1;

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $hitungDataFilterPangkalWithDate = $jumlahPagination;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, PANGKAL, TRANSAKSI, BULAN AS pembayaran_bulan, PANGKAL_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                PANGKAL != 0
                AND NAMA LIKE '%$namaMurid%'
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
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

    elseif (isset($_POST['lastPageFilterPangkalWithDate'])) {

        $namaMurid      = $_POST['namaSiswaFilterPangkalWithDate'];
        $isifilby       = $_POST['iniFilterPangkalWithDate'];

        $id             = $_POST['idSiswaFilterPangkalWithDate'];
        $namaSiswa      = $namaMurid;
        $kelas          = $_POST['kelasFormFilterPangkalWithDate'];
        $panggilan      = $_POST['panggilanFormFilterPangkalWithDate'];
        $nis            = $_POST['nisFormFilterPangkalWithDate'];

        $iniScrollLastPage  = "ada";
        $setSesiPageFilterBy = 9;

        $dariTanggal    = $_POST['tanggal1'] . " 00:00:00";
        $sampaiTanggal  = $_POST['tanggal2'] . " 23:59:59";

        $tanggalDari    = str_replace([" 00:00:00"], "", $dariTanggal);
        $tanggalSampai  = str_replace([" 23:59:59"], "", $sampaiTanggal);

        if ($_SESSION['c_accounting'] == 'accounting1') {

            $execQueryGetAllDataHistoriFilterPangkalWithDate = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, PANGKAL, BULAN AS pembayaran_bulan, PANGKAL_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd_lama1
                WHERE
                PANGKAL != 0
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                AND NAMA LIKE '%$namaMurid%'
            ");

            $totalData = mysqli_num_rows($execQueryGetAllDataHistoriFilterPangkalWithDate);
            // echo $totalData;

            $jumlahPagination = ceil($totalData / $jumlahData);

            $halamanAktif   = $jumlahPagination;
            // echo $halamanAktif;exit;

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $hitungDataFilterPangkalWithDate = $jumlahPagination;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, PANGKAL, TRANSAKSI, BULAN AS pembayaran_bulan, PANGKAL_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd_lama1
                WHERE
                PANGKAL != 0
                AND NAMA LIKE '%$namaMurid%'
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
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

        } elseif ($_SESSION['c_accounting'] == 'accounting2') {

            $execQueryGetAllDataHistoriFilterPangkalWithDate = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, PANGKAL, BULAN AS pembayaran_bulan, PANGKAL_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk_lama
                WHERE
                PANGKAL != 0
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                AND NAMA LIKE '%$namaMurid%'
            ");

            $totalData = mysqli_num_rows($execQueryGetAllDataHistoriFilterPangkalWithDate);
            // echo $totalData;

            $jumlahPagination = ceil($totalData / $jumlahData);
            // echo "Jumlah Pagination : " . $jumlahPagination;

            $halamanAktif   = $jumlahPagination;
            // echo "Halaman Aktif : " . $halamanAktif;

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $hitungDataFilterPangkalWithDate = $jumlahPagination;
            // echo "Data Awal : " . $dataAwal;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, PANGKAL, TRANSAKSI, BULAN AS pembayaran_bulan, PANGKAL_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk_lama
                WHERE
                PANGKAL != 0
                AND NAMA LIKE '%$namaMurid%'
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                ORDER BY STAMP
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
    //AKHIR PANGKAL 

    // KEGIATAN
    elseif (isset($_POST['nextPageFilterKegiatan'])) {

        $halamanAktif       = $_POST['halamanLanjutFilterKegiatan'];
        $iniScrollNextPage  = "ada";

        $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

        $namaMurid  = $_POST['namaSiswaFilterKegiatan'];
        $isifilby   = $_POST['iniFilterKegiatan'];

        $id         = $_POST['idSiswaFilterKegiatan'];
        $kelas      = $_POST['kelasFormFilterKegiatan'];
        $panggilan  = $_POST['panggilanFormFilterKegiatan'];
        $nis        = $_POST['nisFormFilterKegiatan'];
        $namaSiswa  = $_POST['namaFormFilterKegiatan'];

        $dariTanggal    = $_POST['tanggal1'] . " 00:00:00";
        $sampaiTanggal  = $_POST['tanggal2'] . " 23:59:59";

        $tanggalDari    = str_replace([" 00:00:00"], "", $dariTanggal);
        $tanggalSampai  = str_replace([" 23:59:59"], "", $sampaiTanggal);

        $setSesiPageFilterBy = 3;

        if ($_SESSION['c_accounting'] == 'accounting1') {

            $queryGetDataKegiatan = "
                SELECT ID, NIS, NAMA, kelas, KEGIATAN, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                KEGIATAN != 0
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataKegiatan    = mysqli_query($con, $queryGetDataKegiatan);
            $hitungDataFilterKegiatan = mysqli_num_rows($execQueryDataKegiatan);

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, KEGIATAN, TRANSAKSI, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                KEGIATAN != 0
                AND NAMA LIKE '%$namaMurid%' 
                ORDER BY ID DESC
                LIMIT $dataAwal, $jumlahData");
            // print_r($ambildata_perhalaman->num_rows);

            $jumlahPagination = ceil($hitungDataFilterKegiatan / $jumlahData);

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

            $queryGetDataKegiatan = "
                SELECT ID, NIS, NAMA, kelas, KEGIATAN, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                KEGIATAN != 0
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataKegiatan    = mysqli_query($con, $queryGetDataKegiatan);
            $hitungDataFilterKegiatan = mysqli_num_rows($execQueryDataKegiatan);

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, KEGIATAN, TRANSAKSI, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                KEGIATAN != 0
                AND NAMA LIKE '%$namaMurid%' 
                ORDER BY ID DESC
                LIMIT $dataAwal, $jumlahData");
            // print_r($ambildata_perhalaman->num_rows);

            $jumlahPagination = ceil($hitungDataFilterKegiatan / $jumlahData);

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

    elseif (isset($_POST['previousPageFilterKegiatan'])) {

        $halamanAktif           = $_POST['halamanSebelumnyaFilterKegiatan'];
        $iniScrollPreviousPage  = "ada";

        $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

        $namaMurid = $_POST['namaSiswaFilterKegiatan'];
        $isifilby  = $_POST['iniFilterKegiatan'];

        $id        = $_POST['idSiswaFilterKegiatan'];
        $nis       = $_POST['nisFormFilterKegiatan'];
        $namaSiswa = $_POST['namaFormFilterKegiatan'];
        $panggilan = $_POST['panggilanFormFilterKegiatan'];
        $kelas     = $_POST['kelasFormFilterKegiatan'];

        $dariTanggal    = $_POST['tanggal1'] . " 00:00:00";
        $sampaiTanggal  = $_POST['tanggal2'] . " 23:59:59";

        $tanggalDari    = str_replace([" 00:00:00"], "", $dariTanggal);
        $tanggalSampai  = str_replace([" 23:59:59"], "", $sampaiTanggal);

        $setSesiPageFilterBy = 3;

        if ($_SESSION['c_accounting'] == 'accounting1') {

            $queryGetDataKegiatan = "
                SELECT ID, NIS, NAMA, kelas, KEGIATAN, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                KEGIATAN != 0
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataKegiatan     = mysqli_query($con, $queryGetDataKegiatan);
            $hitungDataFilterKegiatan  = mysqli_num_rows($execQueryDataKegiatan);

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, KEGIATAN, TRANSAKSI, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                KEGIATAN != 0
                AND NAMA LIKE '%$namaMurid%'
                ORDER BY ID DESC
                LIMIT $dataAwal, $jumlahData");
            // print_r($ambildata_perhalaman->num_rows);

            $jumlahPagination = ceil($hitungDataFilterKegiatan / $jumlahData);

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

            $queryGetDataKegiatan = "
                SELECT ID, NIS, NAMA, kelas, KEGIATAN, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                KEGIATAN != 0
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataKegiatan     = mysqli_query($con, $queryGetDataKegiatan);
            $hitungDataFilterKegiatan  = mysqli_num_rows($execQueryDataKegiatan);

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, KEGIATAN, TRANSAKSI, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                KEGIATAN != 0
                AND NAMA LIKE '%$namaMurid%'
                ORDER BY ID DESC
                LIMIT $dataAwal, $jumlahData");
            // print_r($ambildata_perhalaman->num_rows);

            $jumlahPagination = ceil($hitungDataFilterKegiatan / $jumlahData);

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

    elseif (isset($_POST['toPageFilterKegiatan'])) {

        $halamanAktif = $_POST['halamanKeFilterKegiatan'];
        $iniScrollNextPage = "ada";

        $namaMurid = $_POST['namaSiswaFilterKegiatan'];
        $isifilby  = $_POST['iniFilterKegiatan'];

        $namaSiswa = $namaMurid;
        $id        = $_POST['idSiswaFilterKegiatan'];
        $nis       = $_POST['nisFormFilterKegiatan'];
        $panggilan = $_POST['panggilanFormFilterKegiatan'];
        $kelas     = $_POST['kelasFormFilterKegiatan'];

        $dariTanggal    = $_POST['tanggal1'] . " 00:00:00";
        $sampaiTanggal  = $_POST['tanggal2'] . " 23:59:59";

        $tanggalDari    = str_replace([" 00:00:00"], "", $dariTanggal);
        $tanggalSampai  = str_replace([" 23:59:59"], "", $sampaiTanggal);

        $setSesiPageFilterBy = 3;

        if ($_SESSION['c_accounting'] == 'accounting1') { 

            $queryGetDataKegiatan = "
                SELECT ID, NIS, NAMA, kelas, KEGIATAN, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd_lama1
                WHERE
                KEGIATAN != 0
                AND NAMA LIKE '%$namaMurid%' 
            ";
            $execQueryDatakegiatan    = mysqli_query($con, $queryGetDataKegiatan);
            $hitungDataFilterKegiatan = mysqli_num_rows($execQueryDatakegiatan);

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, KEGIATAN, TRANSAKSI, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd_lama1
                WHERE
                KEGIATAN != 0
                AND NAMA LIKE '%$namaMurid%' 
                ORDER BY ID DESC
                LIMIT $dataAwal, $jumlahData");
            // print_r($ambildata_perhalaman->num_rows);

            $jumlahPagination = ceil($hitungDataFilterKegiatan / $jumlahData);

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

            $queryGetDataKegiatan = "
                SELECT ID, NIS, NAMA, kelas, KEGIATAN, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk_lama
                WHERE
                KEGIATAN != 0
                AND NAMA LIKE '%$namaMurid%' 
            ";
            $execQueryDatakegiatan    = mysqli_query($con, $queryGetDataKegiatan);
            $hitungDataFilterKegiatan = mysqli_num_rows($execQueryDatakegiatan);

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, KEGIATAN, TRANSAKSI, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk_lama
                WHERE
                KEGIATAN != 0
                AND NAMA LIKE '%$namaMurid%' 
                ORDER BY ID DESC
                LIMIT $dataAwal, $jumlahData");
            // print_r($ambildata_perhalaman->num_rows);

            $jumlahPagination = ceil($hitungDataFilterKegiatan / $jumlahData);

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

    elseif (isset($_POST['firstPageFilterKegiatan'])) {

        $namaMurid      = $_POST['namaFormFilterKegiatan'];

        $id             = $_POST['idSiswaFilterKegiatan'];
        $nis            = $_POST['nisFormFilterKegiatan'];
        $kelas          = $_POST['kelasFormFilterKegiatan'];
        $panggilan      = $_POST['panggilanFormFilterKegiatan'];
        $namaSiswa      = $namaMurid;

        $isifilby       = $_POST['iniFilterKegiatan'];

        $iniScrollFirstPage  = "ada";

        $dariTanggal    = $_POST['tanggal1'] . " 00:00:00";
        $sampaiTanggal  = $_POST['tanggal2'] . " 23:59:59";

        $tanggalDari    = str_replace([" 00:00:00"], "", $dariTanggal);
        $tanggalSampai  = str_replace([" 23:59:59"], "", $sampaiTanggal);

        $setSesiPageFilterBy = 3;

        if ($_SESSION['c_accounting'] == 'accounting1') { 

            $execQueryGetAllDataHistoriFilterKegiatan = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, KEGIATAN, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                KEGIATAN != 0
                AND NAMA LIKE '%$namaMurid%'
            ");

            $totalData = mysqli_num_rows($execQueryGetAllDataHistoriFilterKegiatan);

            $jumlahPagination = ceil($totalData / $jumlahData);

            $halamanAktif   = 1;

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $hitungDataFilterKegiatan = $totalData;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, KEGIATAN, TRANSAKSI, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                KEGIATAN != 0
                AND NAMA LIKE '%$namaMurid%'
                ORDER BY ID DESC
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

        } else if ($_SESSION['c_accounting'] == 'accounting2') {

            $execQueryGetAllDataHistoriFilterKegiatan = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, KEGIATAN, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                KEGIATAN != 0
                AND NAMA LIKE '%$namaMurid%'
            ");

            $totalData = mysqli_num_rows($execQueryGetAllDataHistoriFilterKegiatan);

            $jumlahPagination = ceil($totalData / $jumlahData);

            $halamanAktif   = 1;

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $hitungDataFilterKegiatan = $totalData;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, KEGIATAN, TRANSAKSI, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                KEGIATAN != 0
                AND NAMA LIKE '%$namaMurid%'
                ORDER BY ID DESC
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

    elseif (isset($_POST['lastPageFilterKegiatan'])) {

        $namaMurid      = $_POST['namaSiswaFilterKegiatan'];
        $isifilby       = $_POST['iniFilterKegiatan'];

        $id             = $_POST['idSiswaFilterKegiatan'];
        $namaSiswa      = $namaMurid;
        $kelas          = $_POST['kelasFormFilterKegiatan'];
        $panggilan      = $_POST['panggilanFormFilterKegiatan'];
        $nis            = $_POST['nisFormFilterKegiatan'];

        $iniScrollLastPage  = "ada";

        $dariTanggal    = $_POST['tanggal1'] . " 00:00:00";
        $sampaiTanggal  = $_POST['tanggal2'] . " 23:59:59";

        $tanggalDari    = str_replace([" 00:00:00"], "", $dariTanggal);
        $tanggalSampai  = str_replace([" 23:59:59"], "", $sampaiTanggal);

        $setSesiPageFilterBy = 3;

        if ($_SESSION['c_accounting'] == 'accounting1') { 

            $execQueryGetAllDataHistoriFilterKegiatan = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, KEGIATAN, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd_lama1
                WHERE
                KEGIATAN != 0
                AND NAMA LIKE '%$namaMurid%'
            ");

            $totalData = mysqli_num_rows($execQueryGetAllDataHistoriFilterKegiatan);

            $jumlahPagination = ceil($totalData / $jumlahData);

            $halamanAktif   = $jumlahPagination;
            // echo $halamanAktif;exit;

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $hitungDataFilterKegiatan = $totalData;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, KEGIATAN, TRANSAKSI, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd_lama1
                WHERE
                KEGIATAN != 0
                AND NAMA LIKE '%$namaMurid%'
                ORDER BY ID DESC
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

        } else if ($_SESSION['c_accounting'] == 'accounting2') {

            $execQueryGetAllDataHistoriFilterKegiatan = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, KEGIATAN, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk_lama
                WHERE
                KEGIATAN != 0
                AND NAMA LIKE '%$namaMurid%'
            ");

            $totalData = mysqli_num_rows($execQueryGetAllDataHistoriFilterKegiatan);

            $jumlahPagination = ceil($totalData / $jumlahData);

            $halamanAktif   = $jumlahPagination;
            // echo $halamanAktif;exit;

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $hitungDataFilterKegiatan = $totalData;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, KEGIATAN, TRANSAKSI, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk_lama
                WHERE
                KEGIATAN != 0
                AND NAMA LIKE '%$namaMurid%'
                ORDER BY ID DESC
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

    elseif (isset($_POST['nextPageFilterKegiatanWithDate'])) {

        $halamanAktif       = $_POST['halamanLanjutFilterKegiatanWithDate'];
        $iniScrollNextPage  = "ada";

        $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

        $namaMurid  = $_POST['namaSiswaFilterKegiatanWithDate'];
        $isifilby   = $_POST['iniFilterKegiatanWithDate'];

        $id         = $_POST['idSiswaFilterKegiatanWithDate'];
        $kelas      = $_POST['kelasFormFilterKegiatanWithDate'];
        $panggilan  = $_POST['panggilanFormFilterKegiatanWithDate'];
        $nis        = $_POST['nisFormFilterKegiatanWithDate'];
        $namaSiswa  = $_POST['namaFormFilterKegiatanWithDate'];

        $setSesiPageFilterBy = 10;

        $dariTanggal    = $_POST['tanggal1'] . " 00:00:00";
        $sampaiTanggal  = $_POST['tanggal2'] . " 23:59:59";

        $tanggalDari    = str_replace([" 00:00:00"], "", $dariTanggal);
        $tanggalSampai  = str_replace([" 23:59:59"], "", $sampaiTanggal);

        if ($_SESSION['c_accounting'] == 'accounting1') {

            $queryGetDataKegiatanWithDate = "
                SELECT ID, NIS, NAMA, kelas, KEGIATAN, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                KEGIATAN != 0
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataKegiatanWithDate    = mysqli_query($con, $queryGetDataKegiatanWithDate);
            $hitungDataFilterKegiatanWithDate = mysqli_num_rows($execQueryDataKegiatanWithDate);

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, KEGIATAN, TRANSAKSI, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                KEGIATAN != 0
                AND NAMA LIKE '%$namaMurid%'
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                ORDER BY STAMP
                LIMIT $dataAwal, $jumlahData
            ");
            // print_r($ambildata_perhalaman->num_rows);

            $jumlahPagination = ceil($hitungDataFilterKegiatanWithDate / $jumlahData);
            $hitungLagi = mysqli_num_rows($ambildata_perhalaman);

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

        } elseif ($_SESSION['c_accounting'] == 'accounting2') {

            $queryGetDataKegiatanWithDate = "
                SELECT ID, NIS, NAMA, kelas, KEGIATAN, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                KEGIATAN != 0
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataKegiatanWithDate    = mysqli_query($con, $queryGetDataKegiatanWithDate);
            $hitungDataFilterKegiatanWithDate = mysqli_num_rows($execQueryDataKegiatanWithDate);

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, KEGIATAN, TRANSAKSI, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                KEGIATAN != 0
                AND NAMA LIKE '%$namaMurid%'
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                ORDER BY STAMP
                LIMIT $dataAwal, $jumlahData
            ");
            // print_r($ambildata_perhalaman->num_rows);

            $jumlahPagination = ceil($hitungDataFilterKegiatanWithDate / $jumlahData);
            $hitungLagi = mysqli_num_rows($ambildata_perhalaman);

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

    elseif (isset($_POST['previousPageFilterKegiatanWithDate'])) {

        $halamanAktif           = $_POST['halamanSebelumnyaFilterKegiatanWithDate'];
        $iniScrollPreviousPage  = "ada";

        $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

        $namaMurid = $_POST['namaSiswaFilterKegiatanWithDate'];
        $isifilby  = $_POST['iniFilterKegiatanWithDate'];

        $id        = $_POST['idSiswaFilterKegiatanWithDate'];
        $nis       = $_POST['nisFormFilterKegiatanWithDate'];
        $namaSiswa = $_POST['namaFormFilterKegiatanWithDate'];
        $panggilan = $_POST['panggilanFormFilterKegiatanWithDate'];
        $kelas     = $_POST['kelasFormFilterKegiatanWithDate'];

        $setSesiPageFilterBy = 10;

        $dariTanggal    = $_POST['tanggal1'] . " 00:00:00";
        $sampaiTanggal  = $_POST['tanggal2'] . " 23:59:59";

        $tanggalDari    = str_replace([" 00:00:00"], "", $dariTanggal);
        $tanggalSampai  = str_replace([" 23:59:59"], "", $sampaiTanggal);

        if ($_SESSION['c_accounting'] == 'accounting1') {

            $queryGetDataKegiatanWithDate = "
                SELECT ID, NIS, NAMA, kelas, KEGIATAN, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                KEGIATAN != 0
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataKegiatanWithDate    = mysqli_query($con, $queryGetDataKegiatanWithDate);
            $hitungDataFilterKegiatanWithDate = mysqli_num_rows($execQueryDataKegiatanWithDate);

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, KEGIATAN, TRANSAKSI, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                KEGIATAN != 0
                AND NAMA LIKE '%$namaMurid%'
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal' 
                LIMIT $dataAwal, $jumlahData");

            $jumlahPagination = ceil($hitungDataFilterKegiatanWithDate / $jumlahData);

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

        } elseif ($_SESSION['c_accounting'] == 'accounting2') {

            $queryGetDataKegiatanWithDate = "
                SELECT ID, NIS, NAMA, kelas, KEGIATAN, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                KEGIATAN != 0
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataKegiatanWithDate    = mysqli_query($con, $queryGetDataKegiatanWithDate);
            $hitungDataFilterKegiatanWithDate = mysqli_num_rows($execQueryDataKegiatanWithDate);

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, KEGIATAN, TRANSAKSI, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                KEGIATAN != 0
                AND NAMA LIKE '%$namaMurid%'
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal' 
                LIMIT $dataAwal, $jumlahData");

            $jumlahPagination = ceil($hitungDataFilterKegiatanWithDate / $jumlahData);

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

    elseif (isset($_POST['toPageFilterKegiatanWithDate'])) {

        $halamanAktif = $_POST['halamanKeFilterKegiatanWithDate'];
        $iniScrollToPage = "ada";

        $namaMurid = $_POST['namaSiswaFilterKegiatanWithDate'];
        $isifilby  = $_POST['iniFilterKegiatanWithDate'];

        $namaSiswa = $namaMurid;
        $id        = $_POST['idSiswaFilterKegiatanWithDate'];
        $nis       = $_POST['nisFormFilterKegiatanWithDate'];
        $panggilan = $_POST['panggilanFormFilterKegiatanWithDate'];
        $kelas     = $_POST['kelasFormFilterKegiatanWithDate'];

        $setSesiPageFilterBy = 10;

        $dariTanggal    = $_POST['tanggal1'] . " 00:00:00";
        $sampaiTanggal  = $_POST['tanggal2'] . " 23:59:59";

        $tanggalDari    = str_replace([" 00:00:00"], "", $dariTanggal);
        $tanggalSampai  = str_replace([" 23:59:59"], "", $sampaiTanggal);

        if ($_SESSION['c_accounting'] == 'accounting1') {

            $queryGetDataKegiatanWithDate = "
                SELECT ID, NIS, NAMA, kelas, KEGIATAN, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                KEGIATAN != 0
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataKegiatanWithDate    = mysqli_query($con, $queryGetDataKegiatanWithDate);
            $hitungDataFilterKegiatanWithDate = mysqli_num_rows($execQueryDataKegiatanWithDate);

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, KEGIATAN, TRANSAKSI, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                KEGIATAN != 0
                AND NAMA LIKE '%$namaMurid%'
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                LIMIT $dataAwal, $jumlahData");
            // print_r($ambildata_perhalaman->num_rows);

            $jumlahPagination = ceil($hitungDataFilterKegiatanWithDate / $jumlahData);

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

        } elseif ($_SESSION['c_accounting'] == 'accounting2') {
            
            $queryGetDataKegiatanWithDate = "
                SELECT ID, NIS, NAMA, kelas, KEGIATAN, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                KEGIATAN != 0
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataKegiatanWithDate    = mysqli_query($con, $queryGetDataKegiatanWithDate);
            $hitungDataFilterKegiatanWithDate = mysqli_num_rows($execQueryDataKegiatanWithDate);

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, KEGIATAN, TRANSAKSI, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                KEGIATAN != 0
                AND NAMA LIKE '%$namaMurid%'
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                LIMIT $dataAwal, $jumlahData");
            // print_r($ambildata_perhalaman->num_rows);

            $jumlahPagination = ceil($hitungDataFilterKegiatanWithDate / $jumlahData);

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

    elseif (isset($_POST['firstPageFilterKegiatanWithDate'])) {

        $namaMurid      = $_POST['namaFormFilterKegiatanWithDate'];

        $id             = $_POST['idSiswaFilterKegiatanWithDate'];
        $nis            = $_POST['nisFormFilterKegiatanWithDate'];
        $kelas          = $_POST['kelasFormFilterKegiatanWithDate'];
        $panggilan      = $_POST['panggilanFormFilterKegiatanWithDate'];
        $namaSiswa      = $namaMurid;

        $isifilby       = $_POST['iniFilterKegiatanWithDate'];

        $iniScrollFirstPage  = "ada";
        $setSesiPageFilterBy = 10;

        $dariTanggal    = $_POST['tanggal1'] . " 00:00:00";
        $sampaiTanggal  = $_POST['tanggal2'] . " 23:59:59";

        $tanggalDari    = str_replace([" 00:00:00"], "", $dariTanggal);
        $tanggalSampai  = str_replace([" 23:59:59"], "", $sampaiTanggal);

        if ($_SESSION['c_accounting'] == 'accounting1') {

            $execQueryGetAllDataHistoriFilterKegitanWithDate = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, KEGIATAN, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                KEGIATAN != 0
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                AND NAMA LIKE '%$namaMurid%'
            ");

            $totalData = mysqli_num_rows($execQueryGetAllDataHistoriFilterKegitanWithDate);
            // echo $totalData;

            $jumlahPagination = ceil($totalData / $jumlahData);

            $halamanAktif   = 1;

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $hitungDataFilterPangkalWithDate = $jumlahPagination;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, KEGIATAN, TRANSAKSI, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                KEGIATAN != 0
                AND NAMA LIKE '%$namaMurid%'
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
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

        } elseif ($_SESSION['c_accounting'] == 'accounting2') {

            $execQueryGetAllDataHistoriFilterKegitanWithDate = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, KEGIATAN, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                KEGIATAN != 0
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                AND NAMA LIKE '%$namaMurid%'
            ");

            $totalData = mysqli_num_rows($execQueryGetAllDataHistoriFilterKegitanWithDate);
            // echo $totalData;

            $jumlahPagination = ceil($totalData / $jumlahData);

            $halamanAktif   = 1;

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $hitungDataFilterPangkalWithDate = $jumlahPagination;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, KEGIATAN, TRANSAKSI, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                KEGIATAN != 0
                AND NAMA LIKE '%$namaMurid%'
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
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

    elseif (isset($_POST['lastPageFilterKegiatanWithDate'])) {

        $namaMurid      = $_POST['namaSiswaFilterKegiatanWithDate'];
        $isifilby       = $_POST['iniFilterKegiatanWithDate'];

        $id             = $_POST['idSiswaFilterKegiatanWithDate'];
        $namaSiswa      = $namaMurid;
        $kelas          = $_POST['kelasFormFilterKegiatanWithDate'];
        $panggilan      = $_POST['panggilanFormFilterKegiatanWithDate'];
        $nis            = $_POST['nisFormFilterKegiatanWithDate'];

        $iniScrollLastPage  = "ada";
        $setSesiPageFilterBy = 10;

        $dariTanggal    = $_POST['tanggal1'] . " 00:00:00";
        $sampaiTanggal  = $_POST['tanggal2'] . " 23:59:59";

        $tanggalDari    = str_replace([" 00:00:00"], "", $dariTanggal);
        $tanggalSampai  = str_replace([" 23:59:59"], "", $sampaiTanggal);

        if ($_SESSION['c_accounting'] == 'accounting1') {

            $execQueryGetAllDataHistoriFilterKegiatanWithDate = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, KEGIATAN, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd_lama1
                WHERE
                KEGIATAN != 0
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                AND NAMA LIKE '%$namaMurid%'
            ");

            $totalData = mysqli_num_rows($execQueryGetAllDataHistoriFilterKegiatanWithDate);
            // echo $totalData;

            $jumlahPagination = ceil($totalData / $jumlahData);

            $halamanAktif   = $jumlahPagination;
            // echo $halamanAktif;exit;

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $hitungDataFilterKegiatanWithDate = $jumlahPagination;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, KEGIATAN, TRANSAKSI, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd_lama1
                WHERE
                KEGIATAN != 0
                AND NAMA LIKE '%$namaMurid%'
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
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

        } elseif ($_SESSION['c_accounting'] == 'accounting2') {

            $execQueryGetAllDataHistoriFilterKegiatanWithDate = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, KEGIATAN, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk_lama
                WHERE
                KEGIATAN != 0
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                AND NAMA LIKE '%$namaMurid%'
            ");

            $totalData = mysqli_num_rows($execQueryGetAllDataHistoriFilterKegiatanWithDate);
            // echo $totalData;

            $jumlahPagination = ceil($totalData / $jumlahData);

            $halamanAktif   = $jumlahPagination;
            // echo $halamanAktif;exit;

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $hitungDataFilterKegiatanWithDate = $jumlahPagination;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, KEGIATAN, TRANSAKSI, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk_lama
                WHERE
                KEGIATAN != 0
                AND NAMA LIKE '%$namaMurid%'
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
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
    // AKHIR KEGIATAN

    // BUKU
    elseif (isset($_POST['nextPageFilterBuku'])) {

        $halamanAktif       = $_POST['halamanLanjutFilterBuku'];
        $iniScrollNextPage  = "ada";

        $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

        $namaMurid  = $_POST['namaSiswaFilterBuku'];
        $isifilby   = $_POST['iniFilterBuku'];

        $id         = $_POST['idSiswaFilterBuku'];
        $kelas      = $_POST['kelasFormFilterBuku'];
        $panggilan  = $_POST['panggilanFormFilterBuku'];
        $nis        = $_POST['nisFormFilterBuku'];
        $namaSiswa  = $_POST['namaFormFilterBuku'];

        $dariTanggal    = $_POST['tanggal1'] . " 00:00:00";
        $sampaiTanggal  = $_POST['tanggal2'] . " 23:59:59";

        $tanggalDari    = str_replace([" 00:00:00"], "", $dariTanggal);
        $tanggalSampai  = str_replace([" 23:59:59"], "", $sampaiTanggal);

        $setSesiPageFilterBy = 4;

        if ($_SESSION['c_accounting'] == 'accounting1') {

            $queryGetDataBuku = "
                SELECT ID, NIS, NAMA, kelas, BUKU, BULAN AS pembayaran_bulan, BUKU_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                BUKU != 0
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataBuku    = mysqli_query($con, $queryGetDataBuku);
            $hitungDataFilterBuku = mysqli_num_rows($execQueryDataBuku);

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, DATE, BUKU, TRANSAKSI, BULAN AS pembayaran_bulan, BUKU_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                BUKU != 0
                AND NAMA LIKE '%$namaMurid%' 
                ORDER BY ID DESC
                LIMIT $dataAwal, $jumlahData");
            // print_r($ambildata_perhalaman->num_rows);

            $jumlahPagination = ceil($hitungDataFilterBuku / $jumlahData);

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

            $queryGetDataBuku = "
                SELECT ID, NIS, NAMA, kelas, BUKU, BULAN AS pembayaran_bulan, BUKU_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                BUKU != 0
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataBuku    = mysqli_query($con, $queryGetDataBuku);
            $hitungDataFilterBuku = mysqli_num_rows($execQueryDataBuku);

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, DATE, BUKU, TRANSAKSI, BULAN AS pembayaran_bulan, BUKU_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                BUKU != 0
                AND NAMA LIKE '%$namaMurid%' 
                ORDER BY ID DESC
                LIMIT $dataAwal, $jumlahData");
            // print_r($ambildata_perhalaman->num_rows);

            $jumlahPagination = ceil($hitungDataFilterBuku / $jumlahData);

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

    elseif (isset($_POST['previousPageFilterBuku'])) {

        $halamanAktif           = $_POST['halamanSebelumnyaFilterBuku'];
        $iniScrollPreviousPage  = "ada";

        $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

        $namaMurid = $_POST['namaSiswaFilterBuku'];
        $isifilby  = $_POST['iniFilterBuku'];

        $id        = $_POST['idSiswaFilterBuku'];
        $nis       = $_POST['nisFormFilterBuku'];
        $namaSiswa = $_POST['namaFormFilterBuku'];
        $panggilan = $_POST['panggilanFormFilterBuku'];
        $kelas     = $_POST['kelasFormFilterBuku'];

        $dariTanggal    = $_POST['tanggal1'] . " 00:00:00";
        $sampaiTanggal  = $_POST['tanggal2'] . " 23:59:59";

        $tanggalDari    = str_replace([" 00:00:00"], "", $dariTanggal);
        $tanggalSampai  = str_replace([" 23:59:59"], "", $sampaiTanggal);

        $setSesiPageFilterBy = 4;

        if ($_SESSION['c_accounting'] == 'accounting1') {

            $queryGetDataBuku = "
                SELECT ID, NIS, NAMA, kelas, BUKU, BULAN AS pembayaran_bulan, BUKU_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                BUKU != 0
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataBuku     = mysqli_query($con, $queryGetDataBuku);
            $hitungDataFilterBuku  = mysqli_num_rows($execQueryDataBuku);

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, BUKU, TRANSAKSI, BULAN AS pembayaran_bulan, BUKU_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                BUKU != 0
                AND NAMA LIKE '%$namaMurid%'
                ORDER BY ID DESC
                LIMIT $dataAwal, $jumlahData");
            // print_r($ambildata_perhalaman->num_rows);

            $jumlahPagination = ceil($hitungDataFilterBuku / $jumlahData);

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

            $queryGetDataBuku = "
                SELECT ID, NIS, NAMA, kelas, BUKU, BULAN AS pembayaran_bulan, BUKU_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                BUKU != 0
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataBuku     = mysqli_query($con, $queryGetDataBuku);
            $hitungDataFilterBuku  = mysqli_num_rows($execQueryDataBuku);

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, BUKU, TRANSAKSI, BULAN AS pembayaran_bulan, BUKU_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                BUKU != 0
                AND NAMA LIKE '%$namaMurid%'
                ORDER BY ID DESC
                LIMIT $dataAwal, $jumlahData");
            // print_r($ambildata_perhalaman->num_rows);

            $jumlahPagination = ceil($hitungDataFilterBuku / $jumlahData);

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

    elseif (isset($_POST['toPageFilterBuku'])) {

        $halamanAktif = $_POST['halamanKeFilterBuku'];
        $iniScrollNextPage = "ada";

        $namaMurid = $_POST['namaSiswaFilterBuku'];
        $isifilby  = $_POST['iniFilterBuku'];

        $namaSiswa = $namaMurid;
        $id        = $_POST['idSiswaFilterBuku'];
        $nis       = $_POST['nisFormFilterBuku'];
        $panggilan = $_POST['panggilanFormFilterBuku'];
        $kelas     = $_POST['kelasFormFilterBuku'];

        $setSesiPageFilterBy = 4;

        $dariTanggal    = $_POST['tanggal1'] . " 00:00:00";
        $sampaiTanggal  = $_POST['tanggal2'] . " 23:59:59";

        $tanggalDari    = str_replace([" 00:00:00"], "", $dariTanggal);
        $tanggalSampai  = str_replace([" 23:59:59"], "", $sampaiTanggal);

        if ($_SESSION['c_accounting'] == 'accounting1') {

            $queryGetDataBuku = "
                SELECT ID, NIS, NAMA, kelas, BUKU, BULAN AS pembayaran_bulan, BUKU_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                BUKU != 0
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataBuku    = mysqli_query($con, $queryGetDataBuku);
            $hitungDataFilterBuku = mysqli_num_rows($execQueryDataBuku);

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, BUKU, TRANSAKSI, BULAN AS pembayaran_bulan, BUKU_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                BUKU != 0
                AND NAMA LIKE '%$namaMurid%' 
                ORDER BY ID DESC
                LIMIT $dataAwal, $jumlahData");
            // print_r($ambildata_perhalaman->num_rows);

            $jumlahPagination = ceil($hitungDataFilterBuku / $jumlahData);

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

        } elseif ($_SESSION['c_accounting'] == 'accounting2') {

                $queryGetDataBuku = "
                SELECT ID, NIS, NAMA, kelas, BUKU, BULAN AS pembayaran_bulan, BUKU_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                BUKU != 0
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataBuku    = mysqli_query($con, $queryGetDataBuku);
            $hitungDataFilterBuku = mysqli_num_rows($execQueryDataBuku);

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, BUKU, TRANSAKSI, BULAN AS pembayaran_bulan, BUKU_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                BUKU != 0
                AND NAMA LIKE '%$namaMurid%' 
                ORDER BY ID DESC
                LIMIT $dataAwal, $jumlahData");
            // print_r($ambildata_perhalaman->num_rows);

            $jumlahPagination = ceil($hitungDataFilterBuku / $jumlahData);

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

    elseif (isset($_POST['firstPageFilterBuku'])) {

        $namaMurid      = $_POST['namaFormFilterBuku'];

        $id             = $_POST['idSiswaFilterBuku'];
        $nis            = $_POST['nisFormFilterBuku'];
        $kelas          = $_POST['kelasFormFilterBuku'];
        $panggilan      = $_POST['panggilanFormFilterBuku'];
        $namaSiswa      = $namaMurid;

        $isifilby       = $_POST['iniFilterBuku'];

        $dariTanggal    = $_POST['tanggal1'] . " 00:00:00";
        $sampaiTanggal  = $_POST['tanggal2'] . " 23:59:59";

        $tanggalDari    = str_replace([" 00:00:00"], "", $dariTanggal);
        $tanggalSampai  = str_replace([" 23:59:59"], "", $sampaiTanggal);

        $iniScrollFirstPage  = "ada";
        $setSesiPageFilterBy = 4;

        if ($_SESSION['c_accounting'] == 'accounting1') {

            $execQueryGetAllDataHistoriFilterBuku = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, BUKU, BULAN AS pembayaran_bulan, BUKU_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                BUKU != 0
                AND NAMA LIKE '%$namaMurid%'
            ");

            $totalData = mysqli_num_rows($execQueryGetAllDataHistoriFilterBuku);

            $jumlahPagination = ceil($totalData / $jumlahData);

            $halamanAktif   = 1;

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $hitungDataFilterBuku = $totalData;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, BUKU, TRANSAKSI, BULAN AS pembayaran_bulan, BUKU_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                BUKU != 0
                AND NAMA LIKE '%$namaMurid%'
                ORDER BY ID DESC
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

        } elseif ($_SESSION['c_accounting'] == 'accounting2') {

            $execQueryGetAllDataHistoriFilterBuku = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, BUKU, BULAN AS pembayaran_bulan, BUKU_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                BUKU != 0
                AND NAMA LIKE '%$namaMurid%'
            ");

            $totalData = mysqli_num_rows($execQueryGetAllDataHistoriFilterBuku);

            $jumlahPagination = ceil($totalData / $jumlahData);

            $halamanAktif   = 1;

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $hitungDataFilterBuku = $totalData;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, BUKU, TRANSAKSI, BULAN AS pembayaran_bulan, BUKU_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                BUKU != 0
                AND NAMA LIKE '%$namaMurid%'
                ORDER BY ID DESC
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

    elseif (isset($_POST['lastPageFilterBuku'])) {

        $namaMurid      = $_POST['namaSiswaFilterBuku'];
        $isifilby       = $_POST['iniFilterBuku'];

        $id             = $_POST['idSiswaFilterBuku'];
        $namaSiswa      = $namaMurid;
        $kelas          = $_POST['kelasFormFilterBuku'];
        $panggilan      = $_POST['panggilanFormFilterBuku'];
        $nis            = $_POST['nisFormFilterBuku'];

        $dariTanggal    = $_POST['tanggal1'] . " 00:00:00";
        $sampaiTanggal  = $_POST['tanggal2'] . " 23:59:59";

        $tanggalDari    = str_replace([" 00:00:00"], "", $dariTanggal);
        $tanggalSampai  = str_replace([" 23:59:59"], "", $sampaiTanggal);

        $iniScrollPreviousPage  = "ada";
        $setSesiPageFilterBy = 4;

        if ($_SESSION['c_accounting'] == 'accounting1') {

            $execQueryGetAllDataHistoriFilterBuku = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, BUKU, BULAN AS pembayaran_bulan, BUKU_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd_lama1
                WHERE
                BUKU != 0
                AND NAMA LIKE '%$namaMurid%'
            ");

            $totalData = mysqli_num_rows($execQueryGetAllDataHistoriFilterBuku);

            $jumlahPagination = ceil($totalData / $jumlahData);

            $halamanAktif   = $jumlahPagination;
            // echo $halamanAktif;exit;

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $hitungDataFilterBuku = $totalData;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, BUKU, TRANSAKSI, BULAN AS pembayaran_bulan, BUKU_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd_lama1
                WHERE
                BUKU != 0
                AND NAMA LIKE '%$namaMurid%'
                ORDER BY ID DESC
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

        } elseif ($_SESSION['c_accounting'] == 'accounting2') {

            $execQueryGetAllDataHistoriFilterBuku = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, BUKU, BULAN AS pembayaran_bulan, BUKU_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk_lama
                WHERE
                BUKU != 0
                AND NAMA LIKE '%$namaMurid%'
            ");

            $totalData = mysqli_num_rows($execQueryGetAllDataHistoriFilterBuku);

            $jumlahPagination = ceil($totalData / $jumlahData);

            $halamanAktif   = $jumlahPagination;
            // echo $halamanAktif;exit;

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $hitungDataFilterBuku = $totalData;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, BUKU, TRANSAKSI, BULAN AS pembayaran_bulan, BUKU_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk_lama
                WHERE
                BUKU != 0
                AND NAMA LIKE '%$namaMurid%'
                ORDER BY ID DESC
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

    elseif (isset($_POST['nextPageFilterBukuWithDate'])) {

        $halamanAktif       = $_POST['halamanLanjutFilterBukuWithDate'];
        $iniScrollNextPage  = "ada";

        $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

        $namaMurid  = $_POST['namaSiswaFilterBukuWithDate'];
        $isifilby   = $_POST['iniFilterBukuWithDate'];

        $id         = $_POST['idSiswaFilterBukuWithDate'];
        $kelas      = $_POST['kelasFormFilterBukuWithDate'];
        $panggilan  = $_POST['panggilanFormFilterBukuWithDate'];
        $nis        = $_POST['nisFormFilterBukuWithDate'];
        $namaSiswa  = $_POST['namaFormFilterBukuWithDate'];

        $setSesiPageFilterBy = 11;

        $dariTanggal    = $_POST['tanggal1'] . " 00:00:00";
        $sampaiTanggal  = $_POST['tanggal2'] . " 23:59:59";

        $tanggalDari    = str_replace([" 00:00:00"], "", $dariTanggal);
        $tanggalSampai  = str_replace([" 23:59:59"], "", $sampaiTanggal);

        if ($_SESSION['c_accounting'] == 'accounting1') {

            $queryGetDataBukuWithDate = "
                SELECT ID, NIS, NAMA, kelas, BUKU, BULAN AS pembayaran_bulan, BUKU_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                BUKU != 0
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataBukuWithDate    = mysqli_query($con, $queryGetDataBukuWithDate);
            $hitungDataFilterBukuWithDate = mysqli_num_rows($execQueryDataBukuWithDate);

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, BUKU, TRANSAKSI, BULAN AS pembayaran_bulan, BUKU_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                BUKU != 0
                AND NAMA LIKE '%$namaMurid%'
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                LIMIT $dataAwal, $jumlahData
            ");
            // print_r($ambildata_perhalaman->num_rows);

            $jumlahPagination = ceil($hitungDataFilterBukuWithDate / $jumlahData);
            $hitungLagi = mysqli_num_rows($ambildata_perhalaman);

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

        } elseif ($_SESSION['c_accounting'] == 'accounting2') {

            $queryGetDataBukuWithDate = "
                SELECT ID, NIS, NAMA, kelas, BUKU, BULAN AS pembayaran_bulan, BUKU_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                BUKU != 0
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataBukuWithDate    = mysqli_query($con, $queryGetDataBukuWithDate);
            $hitungDataFilterBukuWithDate = mysqli_num_rows($execQueryDataBukuWithDate);

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, BUKU, TRANSAKSI, BULAN AS pembayaran_bulan, BUKU_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                BUKU != 0
                AND NAMA LIKE '%$namaMurid%'
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                LIMIT $dataAwal, $jumlahData
            ");
            // print_r($ambildata_perhalaman->num_rows);

            $jumlahPagination = ceil($hitungDataFilterBukuWithDate / $jumlahData);
            $hitungLagi = mysqli_num_rows($ambildata_perhalaman);

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

    elseif (isset($_POST['previousPageFilterBukuWithDate'])) {

        $halamanAktif           = $_POST['halamanSebelumnyaFilterBukuWithDate'];
        $iniScrollPreviousPage  = "ada";

        $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

        $namaMurid = $_POST['namaSiswaFilterBukuWithDate'];
        $isifilby  = $_POST['iniFilterBukuWithDate'];

        $id        = $_POST['idSiswaFilterBukuWithDate'];
        $nis       = $_POST['nisFormFilterBukuWithDate'];
        $namaSiswa = $_POST['namaFormFilterBukuWithDate'];
        $panggilan = $_POST['panggilanFormFilterBukuWithDate'];
        $kelas     = $_POST['kelasFormFilterBukuWithDate'];

        $setSesiPageFilterBy = 11;

        $dariTanggal    = $_POST['tanggal1'] . " 00:00:00";
        $sampaiTanggal  = $_POST['tanggal2'] . " 23:59:59";

        $tanggalDari    = str_replace([" 00:00:00"], "", $dariTanggal);
        $tanggalSampai  = str_replace([" 23:59:59"], "", $sampaiTanggal);

        if ($_SESSION['c_accounting'] == 'accounting1') {

            $queryGetDataBukuWithDate = "
                SELECT ID, NIS, NAMA, kelas, BUKU, BULAN AS pembayaran_bulan, BUKU_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                BUKU != 0
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataBukuWithDate    = mysqli_query($con, $queryGetDataBukuWithDate);
            $hitungDataFilterBukuWithDate = mysqli_num_rows($execQueryDataBukuWithDate);

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, BUKU, TRANSAKSI, BULAN AS pembayaran_bulan, BUKU_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                BUKU != 0
                AND NAMA LIKE '%$namaMurid%'
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal' 
                LIMIT $dataAwal, $jumlahData");

            $jumlahPagination = ceil($hitungDataFilterBukuWithDate / $jumlahData);

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

        } elseif ($_SESSION['c_accounting'] == 'accounting2') {

            $queryGetDataBukuWithDate = "
                SELECT ID, NIS, NAMA, kelas, BUKU, BULAN AS pembayaran_bulan, BUKU_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                BUKU != 0
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataBukuWithDate    = mysqli_query($con, $queryGetDataBukuWithDate);
            $hitungDataFilterBukuWithDate = mysqli_num_rows($execQueryDataBukuWithDate);

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, BUKU, TRANSAKSI, BULAN AS pembayaran_bulan, BUKU_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                BUKU != 0
                AND NAMA LIKE '%$namaMurid%'
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal' 
                LIMIT $dataAwal, $jumlahData");

            $jumlahPagination = ceil($hitungDataFilterBukuWithDate / $jumlahData);

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

    elseif (isset($_POST['toPageFilterBukuWithDate'])) {

        $halamanAktif = $_POST['halamanKeFilterBukuWithDate'];
        $iniScrollToPage = "ada";

        $namaMurid = $_POST['namaSiswaFilterBukuWithDate'];
        $isifilby  = $_POST['iniFilterBukuWithDate'];

        $namaSiswa = $namaMurid;
        $id        = $_POST['idSiswaFilterBukuWithDate'];
        $nis       = $_POST['nisFormFilterBukuWithDate'];
        $panggilan = $_POST['panggilanFormFilterBukuWithDate'];
        $kelas     = $_POST['kelasFormFilterBukuWithDate'];

        $setSesiPageFilterBy = 11;

        $dariTanggal    = $_POST['tanggal1'] . " 00:00:00";
        $sampaiTanggal  = $_POST['tanggal2'] . " 23:59:59";

        $tanggalDari    = str_replace([" 00:00:00"], "", $dariTanggal);
        $tanggalSampai  = str_replace([" 23:59:59"], "", $sampaiTanggal);

        if ($_SESSION['c_accounting'] == 'accounting1') {

            $queryGetDataBukuWithDate = "
                SELECT ID, NIS, NAMA, kelas, BUKU, BULAN AS pembayaran_bulan, BUKU_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                BUKU != 0
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataBukuWithDate    = mysqli_query($con, $queryGetDataBukuWithDate);
            $hitungDataFilterBukuWithDate = mysqli_num_rows($execQueryDataBukuWithDate);

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, BUKU, TRANSAKSI, BULAN AS pembayaran_bulan, BUKU_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                BUKU != 0
                AND NAMA LIKE '%$namaMurid%'
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                LIMIT $dataAwal, $jumlahData");
            // print_r($ambildata_perhalaman->num_rows);

            $jumlahPagination = ceil($hitungDataFilterBukuWithDate / $jumlahData);

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

        } elseif ($_SESSION['c_accounting'] == 'accounting2') {

            $queryGetDataBukuWithDate = "
                SELECT ID, NIS, NAMA, kelas, BUKU, BULAN AS pembayaran_bulan, BUKU_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                BUKU != 0
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataBukuWithDate    = mysqli_query($con, $queryGetDataBukuWithDate);
            $hitungDataFilterBukuWithDate = mysqli_num_rows($execQueryDataBukuWithDate);

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, BUKU, TRANSAKSI, BULAN AS pembayaran_bulan, BUKU_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                BUKU != 0
                AND NAMA LIKE '%$namaMurid%'
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                LIMIT $dataAwal, $jumlahData");
            // print_r($ambildata_perhalaman->num_rows);

            $jumlahPagination = ceil($hitungDataFilterBukuWithDate / $jumlahData);

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

    elseif (isset($_POST['firstPageFilterBukuWithDate'])) {

        $namaMurid      = $_POST['namaFormFilterBukuWithDate'];

        $id             = $_POST['idSiswaFilterBukuWithDate'];
        $nis            = $_POST['nisFormFilterBukuWithDate'];
        $kelas          = $_POST['kelasFormFilterBukuWithDate'];
        $panggilan      = $_POST['panggilanFormFilterBukuWithDate'];
        $namaSiswa      = $namaMurid;

        $isifilby       = $_POST['iniFilterBukuWithDate'];

        $iniScrollFirstPage  = "ada";
        $setSesiPageFilterBy = 11;

        $dariTanggal    = $_POST['tanggal1'] . " 00:00:00";
        $sampaiTanggal  = $_POST['tanggal2'] . " 23:59:59";

        $tanggalDari    = str_replace([" 00:00:00"], "", $dariTanggal);
        $tanggalSampai  = str_replace([" 23:59:59"], "", $sampaiTanggal);

        if ($_SESSION['c_accounting'] == 'accounting1') {

            $execQueryGetAllDataHistoriFilterBukuWithDate = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, BUKU, BULAN AS pembayaran_bulan, BUKU_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd_lama1
                WHERE
                BUKU != 0
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                AND NAMA LIKE '%$namaMurid%'
            ");

            $totalData = mysqli_num_rows($execQueryGetAllDataHistoriFilterBukuWithDate);
            // echo $totalData;

            $jumlahPagination = ceil($totalData / $jumlahData);

            $halamanAktif   = 1;

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $hitungDataFilterBukuWithDate = $jumlahPagination;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, BUKU, TRANSAKSI, BULAN AS pembayaran_bulan, BUKU_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd_lama1
                WHERE
                BUKU != 0
                AND NAMA LIKE '%$namaMurid%'
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
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

        } elseif ($_SESSION['c_accounting'] == 'accounting2') {

            $execQueryGetAllDataHistoriFilterBukuWithDate = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, BUKU, BULAN AS pembayaran_bulan, BUKU_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk_lama
                WHERE
                BUKU != 0
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                AND NAMA LIKE '%$namaMurid%'
            ");

            $totalData = mysqli_num_rows($execQueryGetAllDataHistoriFilterBukuWithDate);
            // echo $totalData;

            $jumlahPagination = ceil($totalData / $jumlahData);

            $halamanAktif   = 1;

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $hitungDataFilterBukuWithDate = $jumlahPagination;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, BUKU, TRANSAKSI, BULAN AS pembayaran_bulan, BUKU_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk_lama
                WHERE
                BUKU != 0
                AND NAMA LIKE '%$namaMurid%'
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
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

    elseif (isset($_POST['lastPageFilterBukuWithDate'])) {

        $namaMurid      = $_POST['namaSiswaFilterBukuWithDate'];
        $isifilby       = $_POST['iniFilterBukuWithDate'];

        $id             = $_POST['idSiswaFilterBukuWithDate'];
        $namaSiswa      = $namaMurid;
        $kelas          = $_POST['kelasFormFilterBukuWithDate'];
        $panggilan      = $_POST['panggilanFormFilterBukuWithDate'];
        $nis            = $_POST['nisFormFilterBukuWithDate'];

        $iniScrollLastPage  = "ada";
        $setSesiPageFilterBy = 11;

        $dariTanggal    = $_POST['tanggal1'] . " 00:00:00";
        $sampaiTanggal  = $_POST['tanggal2'] . " 23:59:59";

        $tanggalDari    = str_replace([" 00:00:00"], "", $dariTanggal);
        $tanggalSampai  = str_replace([" 23:59:59"], "", $sampaiTanggal);

        if ($_SESSION['c_accounting'] == 'accounting1') {

            $execQueryGetAllDataHistoriFilterBukuWithDate = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, BUKU, BULAN AS pembayaran_bulan, BUKU_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd_lama1
                WHERE
                BUKU != 0
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                AND NAMA LIKE '%$namaMurid%'
            ");

            $totalData = mysqli_num_rows($execQueryGetAllDataHistoriFilterBukuWithDate);
            // echo $totalData;

            $jumlahPagination = ceil($totalData / $jumlahData);

            $halamanAktif   = $jumlahPagination;
            // echo $halamanAktif;exit;

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $hitungDataFilterBukuWithDate = $jumlahPagination;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, BUKU, TRANSAKSI, BULAN AS pembayaran_bulan, BUKU_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd_lama1
                WHERE
                BUKU != 0
                AND NAMA LIKE '%$namaMurid%'
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
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

        } elseif ($_SESSION['c_accounting'] == 'accounting2') {

            $execQueryGetAllDataHistoriFilterBukuWithDate = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, BUKU, BULAN AS pembayaran_bulan, BUKU_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk_lama
                WHERE
                BUKU != 0
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                AND NAMA LIKE '%$namaMurid%'
            ");

            $totalData = mysqli_num_rows($execQueryGetAllDataHistoriFilterBukuWithDate);
            // echo $totalData;

            $jumlahPagination = ceil($totalData / $jumlahData);

            $halamanAktif   = $jumlahPagination;
            // echo $halamanAktif;exit;

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $hitungDataFilterBukuWithDate = $jumlahPagination;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, BUKU, TRANSAKSI, BULAN AS pembayaran_bulan, BUKU_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk_lama
                WHERE
                BUKU != 0
                AND NAMA LIKE '%$namaMurid%'
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
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
    // AKHIR BUKU

    // /SERAGAM
    elseif (isset($_POST['nextPageFilterSeragam'])) {

        $halamanAktif       = $_POST['halamanLanjutFilterSeragam'];
        $iniScrollNextPage  = "ada";

        $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

        $namaMurid  = $_POST['namaSiswaFilterSeragam'];
        $isifilby   = $_POST['iniFilterSeragam'];

        $id         = $_POST['idSiswaFilterSeragam'];
        $kelas      = $_POST['kelasFormFilterSeragam'];
        $panggilan  = $_POST['panggilanFormFilterSeragam'];
        $nis        = $_POST['nisFormFilterSeragam'];
        $namaSiswa  = $_POST['namaFormFilterSeragam'];

        $dariTanggal    = $_POST['tanggal1'] . " 00:00:00";
        $sampaiTanggal  = $_POST['tanggal2'] . " 23:59:59";

        $tanggalDari    = str_replace([" 00:00:00"], "", $dariTanggal);
        $tanggalSampai  = str_replace([" 23:59:59"], "", $sampaiTanggal);

        $setSesiPageFilterBy = 5;

        if ($_SESSION['c_accounting'] == 'accounting1') {

            $queryGetDataSeragam = "
                SELECT ID, NIS, NAMA, kelas, SERAGAM, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd_lama1
                WHERE
                SERAGAM != 0
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataSeragam    = mysqli_query($con, $queryGetDataSeragam);
            $hitungDataFilterSeragam = mysqli_num_rows($execQueryDataSeragam);

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

        } elseif ($_SESSION['c_accounting'] == 'accounting2') {

            $queryGetDataSeragam = "
                SELECT ID, NIS, NAMA, kelas, SERAGAM, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk_lama
                WHERE
                SERAGAM != 0
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataSeragam    = mysqli_query($con, $queryGetDataSeragam);
            $hitungDataFilterSeragam = mysqli_num_rows($execQueryDataSeragam);

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

    }

    elseif (isset($_POST['previousPageFilterSeragam'])) {

        $halamanAktif           = $_POST['halamanSebelumnyaFilterSeragam'];
        $iniScrollPreviousPage  = "ada";

        $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

        $namaMurid = $_POST['namaSiswaFilterSeragam'];
        $isifilby  = $_POST['iniFilterSeragam'];

        $id        = $_POST['idSiswaFilterSeragam'];
        $nis       = $_POST['nisFormFilterSeragam'];
        $namaSiswa = $_POST['namaFormFilterSeragam'];
        $panggilan = $_POST['panggilanFormFilterSeragam'];
        $kelas     = $_POST['kelasFormFilterSeragam'];

        $dariTanggal    = $_POST['tanggal1'] . " 00:00:00";
        $sampaiTanggal  = $_POST['tanggal2'] . " 23:59:59";

        $tanggalDari    = str_replace([" 00:00:00"], "", $dariTanggal);
        $tanggalSampai  = str_replace([" 23:59:59"], "", $sampaiTanggal);

        $setSesiPageFilterBy = 5;

        if ($_SESSION['c_accounting'] == 'accounting1') {

            $queryGetDataSeragam = "
                SELECT ID, NIS, NAMA, kelas, SERAGAM, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd_lama1
                WHERE
                SERAGAM != 0
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataBuku     = mysqli_query($con, $queryGetDataSeragam);
            $hitungDataFilterSeragam  = mysqli_num_rows($execQueryDataBuku);

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

        } elseif ($_SESSION['c_accounting'] == 'accounting2') {

            $queryGetDataSeragam = "
                SELECT ID, NIS, NAMA, kelas, SERAGAM, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk_lama
                WHERE
                SERAGAM != 0
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataBuku     = mysqli_query($con, $queryGetDataSeragam);
            $hitungDataFilterSeragam  = mysqli_num_rows($execQueryDataBuku);

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

    }

    else if (isset($_POST['toPageFilterSeragam'])) {

        $halamanAktif = $_POST['halamanKeFilterSeragam'];
        $iniScrollNextPage = "ada";

        $namaMurid = $_POST['namaSiswaFilterSeragam'];
        $isifilby  = $_POST['iniFilterSeragam'];

        $namaSiswa = $namaMurid;
        $id        = $_POST['idSiswaFilterSeragam'];
        $nis       = $_POST['nisFormFilterSeragam'];
        $panggilan = $_POST['panggilanFormFilterSeragam'];
        $kelas     = $_POST['kelasFormFilterSeragam'];

        $dariTanggal    = $_POST['tanggal1'] . " 00:00:00";
        $sampaiTanggal  = $_POST['tanggal2'] . " 23:59:59";

        $tanggalDari    = str_replace([" 00:00:00"], "", $dariTanggal);
        $tanggalSampai  = str_replace([" 23:59:59"], "", $sampaiTanggal);

        $setSesiPageFilterBy = 5;

        if ($_SESSION['c_accounting'] == 'accounting1') {

            $queryGetDataSeragam = "
                SELECT ID, NIS, NAMA, kelas, SERAGAM, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd_lama1
                WHERE
                SERAGAM != 0
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataSeragam    = mysqli_query($con, $queryGetDataSeragam);
            $hitungDataFilterSeragam = mysqli_num_rows($execQueryDataSeragam);

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

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

        } elseif ($_SESSION['c_accounting'] == 'accounting2') {

            $queryGetDataSeragam = "
                SELECT ID, NIS, NAMA, kelas, SERAGAM, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk_lama
                WHERE
                SERAGAM != 0
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataSeragam    = mysqli_query($con, $queryGetDataSeragam);
            $hitungDataFilterSeragam = mysqli_num_rows($execQueryDataSeragam);

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

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

    }

    else if (isset($_POST['firstPageFilterSeragam'])) {

        $namaMurid      = $_POST['namaFormFilterSeragam'];

        $id             = $_POST['idSiswaFilterSeragam'];
        $nis            = $_POST['nisFormFilterSeragam'];
        $kelas          = $_POST['kelasFormFilterSeragam'];
        $panggilan      = $_POST['panggilanFormFilterSeragam'];
        $namaSiswa      = $namaMurid;

        $isifilby       = $_POST['iniFilterSeragam'];

        $dariTanggal    = $_POST['tanggal1'] . " 00:00:00";
        $sampaiTanggal  = $_POST['tanggal2'] . " 23:59:59";

        $tanggalDari    = str_replace([" 00:00:00"], "", $dariTanggal);
        $tanggalSampai  = str_replace([" 23:59:59"], "", $sampaiTanggal);

        $iniScrollFirstPage  = "ada";

        $setSesiPageFilterBy = 5;

        if ($_SESSION['c_accounting'] == 'accounting1') {

            $execQueryGetAllDataHistoriFilterSeragam = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, SERAGAM, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd_lama1
                WHERE
                SERAGAM != 0
                AND NAMA LIKE '%$namaMurid%'
            ");

            $totalData = mysqli_num_rows($execQueryGetAllDataHistoriFilterSeragam);

            $jumlahPagination = ceil($totalData / $jumlahData);

            $halamanAktif   = 1;

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $hitungDataFilterSeragam = $totalData;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, SERAGAM, TRANSAKSI, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd_lama1
                WHERE
                SERAGAM != 0
                AND NAMA LIKE '%$namaMurid%'
                ORDER BY ID DESC
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

        } elseif ($_SESSION['c_accounting'] == 'accounting2') {

            $execQueryGetAllDataHistoriFilterSeragam = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, SERAGAM, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk_lama
                WHERE
                SERAGAM != 0
                AND NAMA LIKE '%$namaMurid%'
            ");

            $totalData = mysqli_num_rows($execQueryGetAllDataHistoriFilterSeragam);

            $jumlahPagination = ceil($totalData / $jumlahData);

            $halamanAktif   = 1;

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $hitungDataFilterSeragam = $totalData;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, SERAGAM, TRANSAKSI, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk_lama
                WHERE
                SERAGAM != 0
                AND NAMA LIKE '%$namaMurid%'
                ORDER BY ID DESC
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

    else if (isset($_POST['lastPageFilterSeragam'])) {

        $namaMurid      = $_POST['namaSiswaFilterSeragam'];
        $isifilby       = $_POST['iniFilterSeragam'];

        $id             = $_POST['idSiswaFilterSeragam'];
        $namaSiswa      = $namaMurid;
        $kelas          = $_POST['kelasFormFilterSeragam'];
        $panggilan      = $_POST['panggilanFormFilterSeragam'];
        $nis            = $_POST['nisFormFilterSeragam'];

        $dariTanggal    = $_POST['tanggal1'] . " 00:00:00";
        $sampaiTanggal  = $_POST['tanggal2'] . " 23:59:59";

        $tanggalDari    = str_replace([" 00:00:00"], "", $dariTanggal);
        $tanggalSampai  = str_replace([" 23:59:59"], "", $sampaiTanggal);

        $iniScrollPreviousPage  = "ada";

        $setSesiPageFilterBy = 5;

        if ($_SESSION['c_accounting'] == 'accounting1') {

            $execQueryGetAllDataHistoriFilterSeragam = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, SERAGAM, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd_lama1
                WHERE
                SERAGAM != 0
                AND NAMA LIKE '%$namaMurid%'
            ");

            $totalData = mysqli_num_rows($execQueryGetAllDataHistoriFilterSeragam);

            $jumlahPagination = ceil($totalData / $jumlahData);

            $halamanAktif   = $jumlahPagination;
            // echo $halamanAktif;exit;

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $hitungDataFilterSeragam = $totalData;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, SERAGAM, TRANSAKSI, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd_lama1
                WHERE
                SERAGAM != 0
                AND NAMA LIKE '%$namaMurid%'
                ORDER BY ID DESC
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

        } elseif ($_SESSION['c_accounting'] == 'accounting2') {

            $execQueryGetAllDataHistoriFilterSeragam = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, SERAGAM, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk_lama
                WHERE
                SERAGAM != 0
                AND NAMA LIKE '%$namaMurid%'
            ");

            $totalData = mysqli_num_rows($execQueryGetAllDataHistoriFilterSeragam);

            $jumlahPagination = ceil($totalData / $jumlahData);

            $halamanAktif   = $jumlahPagination;
            // echo $halamanAktif;exit;

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $hitungDataFilterSeragam = $totalData;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, SERAGAM, TRANSAKSI, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk_lama
                WHERE
                SERAGAM != 0
                AND NAMA LIKE '%$namaMurid%'
                ORDER BY ID DESC
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

    elseif (isset($_POST['nextPageFilterSeragamWithDate'])) {

        $halamanAktif       = $_POST['halamanLanjutFilterSeragamWithDate'];
        $iniScrollNextPage  = "ada";

        $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

        $namaMurid  = $_POST['namaSiswaFilterSeragamWithDate'];
        $isifilby   = $_POST['iniFilterSeragamWithDate'];

        $id         = $_POST['idSiswaFilterSeragamWithDate'];
        $kelas      = $_POST['kelasFormFilterSeragamWithDate'];
        $panggilan  = $_POST['panggilanFormFilterSeragamWithDate'];
        $nis        = $_POST['nisFormFilterSeragamWithDate'];
        $namaSiswa  = $_POST['namaFormFilterSeragamWithDate'];

        $setSesiPageFilterBy = 12;

        $dariTanggal    = $_POST['tanggal1'] . " 00:00:00";
        $sampaiTanggal  = $_POST['tanggal2'] . " 23:59:59";

        $tanggalDari    = str_replace([" 00:00:00"], "", $dariTanggal);
        $tanggalSampai  = str_replace([" 23:59:59"], "", $sampaiTanggal);

        if ($_SESSION['c_accounting'] == 'accounting1') {

            $queryGetDataSeragamWithDate = "
                SELECT ID, NIS, NAMA, kelas, SERAGAM, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd_lama1
                WHERE
                SERAGAM != 0
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataSeragamWithDate    = mysqli_query($con, $queryGetDataSeragamWithDate);
            $hitungDataFilterSeragamWithDate = mysqli_num_rows($execQueryDataSeragamWithDate);

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, SERAGAM, TRANSAKSI, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd_lama1
                WHERE
                SERAGAM != 0
                AND NAMA LIKE '%$namaMurid%'
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                LIMIT $dataAwal, $jumlahData
            ");
            // print_r($ambildata_perhalaman->num_rows);

            $jumlahPagination = ceil($hitungDataFilterSeragamWithDate / $jumlahData);
            $hitungLagi = mysqli_num_rows($ambildata_perhalaman);

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

        } elseif ($_SESSION['c_accounting'] == 'accounting2') {

            $queryGetDataSeragamWithDate = "
                SELECT ID, NIS, NAMA, kelas, SERAGAM, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk_lama
                WHERE
                SERAGAM != 0
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataSeragamWithDate    = mysqli_query($con, $queryGetDataSeragamWithDate);
            $hitungDataFilterSeragamWithDate = mysqli_num_rows($execQueryDataSeragamWithDate);

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, SERAGAM, TRANSAKSI, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk_lama
                WHERE
                SERAGAM != 0
                AND NAMA LIKE '%$namaMurid%'
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                LIMIT $dataAwal, $jumlahData
            ");
            // print_r($ambildata_perhalaman->num_rows);

            $jumlahPagination = ceil($hitungDataFilterSeragamWithDate / $jumlahData);
            $hitungLagi = mysqli_num_rows($ambildata_perhalaman);

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

    elseif (isset($_POST['previousPageFilterSeragamWithDate'])) {

        $halamanAktif           = $_POST['halamanSebelumnyaFilterSeragamWithDate'];
        $iniScrollPreviousPage  = "ada";

        $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

        $namaMurid = $_POST['namaSiswaFilterSeragamWithDate'];
        $isifilby  = $_POST['iniFilterSeragamWithDate'];

        $id        = $_POST['idSiswaFilterSeragamWithDate'];
        $nis       = $_POST['nisFormFilterSeragamWithDate'];
        $namaSiswa = $_POST['namaFormFilterSeragamWithDate'];
        $panggilan = $_POST['panggilanFormFilterSeragamWithDate'];
        $kelas     = $_POST['kelasFormFilterSeragamWithDate'];

        $setSesiPageFilterBy = 12;

        $dariTanggal    = $_POST['tanggal1'] . " 00:00:00";
        $sampaiTanggal  = $_POST['tanggal2'] . " 23:59:59";

        $tanggalDari    = str_replace([" 00:00:00"], "", $dariTanggal);
        $tanggalSampai  = str_replace([" 23:59:59"], "", $sampaiTanggal);

        if ($_SESSION['c_accounting'] == 'accounting1') {

            $queryGetDataSeragamWithDate = "
                SELECT ID, NIS, NAMA, kelas, SERAGAM, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd_lama1
                WHERE
                SERAGAM != 0
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataSeragamWithDate    = mysqli_query($con, $queryGetDataSeragamWithDate);
            $hitungDataFilterSeragamWithDate = mysqli_num_rows($execQueryDataSeragamWithDate);

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, SERAGAM, TRANSAKSI, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd_lama1
                WHERE
                SERAGAM != 0
                AND NAMA LIKE '%$namaMurid%'
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal' 
                LIMIT $dataAwal, $jumlahData");

            $jumlahPagination = ceil($hitungDataFilterSeragamWithDate / $jumlahData);

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

        } elseif ($_SESSION['c_accounting'] == 'accounting2') {

            $queryGetDataSeragamWithDate = "
                SELECT ID, NIS, NAMA, kelas, SERAGAM, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk_lama
                WHERE
                SERAGAM != 0
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataSeragamWithDate    = mysqli_query($con, $queryGetDataSeragamWithDate);
            $hitungDataFilterSeragamWithDate = mysqli_num_rows($execQueryDataSeragamWithDate);

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, SERAGAM, TRANSAKSI, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk_lama
                WHERE
                SERAGAM != 0
                AND NAMA LIKE '%$namaMurid%'
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal' 
                LIMIT $dataAwal, $jumlahData");

            $jumlahPagination = ceil($hitungDataFilterSeragamWithDate / $jumlahData);

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

    elseif (isset($_POST['toPageFilterSeragamWithDate'])) {

        $halamanAktif = $_POST['halamanKeFilterSeragamWithDate'];
        $iniScrollToPage = "ada";

        $namaMurid = $_POST['namaSiswaFilterSeragamWithDate'];
        $isifilby  = $_POST['iniFilterSeragamWithDate'];

        $namaSiswa = $namaMurid;
        $id        = $_POST['idSiswaFilterSeragamWithDate'];
        $nis       = $_POST['nisFormFilterSeragamWithDate'];
        $panggilan = $_POST['panggilanFormFilterSeragamWithDate'];
        $kelas     = $_POST['kelasFormFilterSeragamWithDate'];

        $setSesiPageFilterBy = 12;

        $dariTanggal    = $_POST['tanggal1'] . " 00:00:00";
        $sampaiTanggal  = $_POST['tanggal2'] . " 23:59:59";

        $tanggalDari    = str_replace([" 00:00:00"], "", $dariTanggal);
        $tanggalSampai  = str_replace([" 23:59:59"], "", $sampaiTanggal);

        if ($_SESSION['c_accounting'] == 'accounting1') {

            $queryGetDataSeragamWithDate = "
                SELECT ID, NIS, NAMA, kelas, SERAGAM, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd_lama1
                WHERE
                SERAGAM != 0
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataSeragamWithDate    = mysqli_query($con, $queryGetDataSeragamWithDate);
            $hitungDataFilterSeragamWithDate = mysqli_num_rows($execQueryDataSeragamWithDate);

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, SERAGAM, TRANSAKSI, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd_lama1
                WHERE
                SERAGAM != 0
                AND NAMA LIKE '%$namaMurid%'
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                LIMIT $dataAwal, $jumlahData");
            // print_r($ambildata_perhalaman->num_rows);

            $jumlahPagination = ceil($hitungDataFilterSeragamWithDate / $jumlahData);

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

        } elseif ($_SESSION['c_accounting'] == 'accounting2') {

            $queryGetDataSeragamWithDate = "
                SELECT ID, NIS, NAMA, kelas, SERAGAM, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk_lama
                WHERE
                SERAGAM != 0
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataSeragamWithDate    = mysqli_query($con, $queryGetDataSeragamWithDate);
            $hitungDataFilterSeragamWithDate = mysqli_num_rows($execQueryDataSeragamWithDate);

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, SERAGAM, TRANSAKSI, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk_lama
                WHERE
                SERAGAM != 0
                AND NAMA LIKE '%$namaMurid%'
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                LIMIT $dataAwal, $jumlahData");
            // print_r($ambildata_perhalaman->num_rows);

            $jumlahPagination = ceil($hitungDataFilterSeragamWithDate / $jumlahData);

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

    elseif (isset($_POST['firstPageFilterSeragamWithDate'])) {

        $namaMurid      = $_POST['namaFormFilterSeragamWithDate'];

        $id             = $_POST['idSiswaFilterSeragamWithDate'];
        $nis            = $_POST['nisFormFilterSeragamWithDate'];
        $kelas          = $_POST['kelasFormFilterSeragamWithDate'];
        $panggilan      = $_POST['panggilanFormFilterSeragamWithDate'];
        $namaSiswa      = $namaMurid;

        $isifilby       = $_POST['iniFilterSeragamWithDate'];

        $iniScrollFirstPage  = "ada";

        $setSesiPageFilterBy = 12;

        $dariTanggal    = $_POST['tanggal1'] . " 00:00:00";
        $sampaiTanggal  = $_POST['tanggal2'] . " 23:59:59";

        $tanggalDari    = str_replace([" 00:00:00"], "", $dariTanggal);
        $tanggalSampai  = str_replace([" 23:59:59"], "", $sampaiTanggal);

        if ($_SESSION['c_accounting'] == 'accounting1') {

            $execQueryGetAllDataHistoriFilterSeragamWithDate = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, SERAGAM, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd_lama1
                WHERE
                SERAGAM != 0
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                AND NAMA LIKE '%$namaMurid%'
            ");

            $totalData = mysqli_num_rows($execQueryGetAllDataHistoriFilterSeragamWithDate);
            // echo $totalData;

            $jumlahPagination = ceil($totalData / $jumlahData);

            $halamanAktif   = 1;

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $hitungDataFilterSeragamWithDate = $jumlahPagination;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, SERAGAM, TRANSAKSI, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd_lama1
                WHERE
                SERAGAM != 0
                AND NAMA LIKE '%$namaMurid%'
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
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

        } elseif ($_SESSION['c_accounting'] == 'accounting2') {

            $execQueryGetAllDataHistoriFilterSeragamWithDate = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, SERAGAM, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk_lama
                WHERE
                SERAGAM != 0
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                AND NAMA LIKE '%$namaMurid%'
            ");

            $totalData = mysqli_num_rows($execQueryGetAllDataHistoriFilterSeragamWithDate);
            // echo $totalData;

            $jumlahPagination = ceil($totalData / $jumlahData);

            $halamanAktif   = 1;

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $hitungDataFilterSeragamWithDate = $jumlahPagination;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, SERAGAM, TRANSAKSI, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk_lama
                WHERE
                SERAGAM != 0
                AND NAMA LIKE '%$namaMurid%'
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
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

    elseif (isset($_POST['lastPageFilterSeragamWithDate'])) {

        $namaMurid      = $_POST['namaSiswaFilterSeragamWithDate'];
        $isifilby       = $_POST['iniFilterSeragamWithDate'];

        $id             = $_POST['idSiswaFilterSeragamWithDate'];
        $namaSiswa      = $namaMurid;
        $kelas          = $_POST['kelasFormFilterSeragamWithDate'];
        $panggilan      = $_POST['panggilanFormFilterSeragamWithDate'];
        $nis            = $_POST['nisFormFilterSeragamWithDate'];

        $iniScrollLastPage  = "ada";

        $setSesiPageFilterBy = 12;

        $dariTanggal    = $_POST['tanggal1'] . " 00:00:00";
        $sampaiTanggal  = $_POST['tanggal2'] . " 23:59:59";

        $tanggalDari    = str_replace([" 00:00:00"], "", $dariTanggal);
        $tanggalSampai  = str_replace([" 23:59:59"], "", $sampaiTanggal);

        if ($_SESSION['c_accounting'] == 'accounting1') {

            $execQueryGetAllDataHistoriFilterSeragamWithDate = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, SERAGAM, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd_lama1
                WHERE
                SERAGAM != 0
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                AND NAMA LIKE '%$namaMurid%'
            ");

            $totalData = mysqli_num_rows($execQueryGetAllDataHistoriFilterSeragamWithDate);
            // echo $totalData;

            $jumlahPagination = ceil($totalData / $jumlahData);

            $halamanAktif   = $jumlahPagination;
            // echo $halamanAktif;exit;

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $hitungDataFilterSeragamWithDate = $jumlahPagination;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, SERAGAM, TRANSAKSI, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd_lama1
                WHERE
                SERAGAM != 0
                AND NAMA LIKE '%$namaMurid%'
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
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

        } elseif ($_SESSION['c_accounting'] == 'accounting2') {

            $execQueryGetAllDataHistoriFilterSeragamWithDate = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, SERAGAM, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk_lama
                WHERE
                SERAGAM != 0
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                AND NAMA LIKE '%$namaMurid%'
            ");

            $totalData = mysqli_num_rows($execQueryGetAllDataHistoriFilterSeragamWithDate);
            // echo $totalData;

            $jumlahPagination = ceil($totalData / $jumlahData);

            $halamanAktif   = $jumlahPagination;
            // echo $halamanAktif;exit;

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $hitungDataFilterSeragamWithDate = $jumlahPagination;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, SERAGAM, TRANSAKSI, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk_lama
                WHERE
                SERAGAM != 0
                AND NAMA LIKE '%$namaMurid%'
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
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
    // AKHIR SERAGAM

    // REGISTRASI
    else if (isset($_POST['nextPageFilterRegistrasi'])) {

        $halamanAktif       = $_POST['halamanLanjutFilterRegistrasi'];
        $iniScrollNextPage  = "ada";

        $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

        $namaMurid  = $_POST['namaSiswaFilterRegistrasi'];
        $isifilby   = $_POST['iniFilterRegistrasi'];

        $id         = $_POST['idSiswaFilterRegistrasi'];
        $kelas      = $_POST['kelasFormFilterRegistrasi'];
        $panggilan  = $_POST['panggilanFormFilterRegistrasi'];
        $nis        = $_POST['nisFormFilterRegistrasi'];
        $namaSiswa  = $_POST['namaFormFilterRegistrasi'];

        $dariTanggal    = $_POST['tanggal1'] . " 00:00:00";
        $sampaiTanggal  = $_POST['tanggal2'] . " 23:59:59";

        $tanggalDari    = str_replace([" 00:00:00"], "", $dariTanggal);
        $tanggalSampai  = str_replace([" 23:59:59"], "", $sampaiTanggal);

        $setSesiPageFilterBy = 6;

        if ($_SESSION['c_accounting'] == 'accounting1') {

            $queryGetDataRegistrasi = "
                SELECT ID, NIS, NAMA, kelas, REGISTRASI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd_lama1
                WHERE
                REGISTRASI != 0
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataRegistrasi    = mysqli_query($con, $queryGetDataRegistrasi);
            $hitungDataFilterRegistrasi = mysqli_num_rows($execQueryDataRegistrasi);

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, REGISTRASI, TRANSAKSI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd_lama1
                WHERE
                REGISTRASI != 0
                AND NAMA LIKE '%$namaMurid%' 
                ORDER BY ID DESC
                LIMIT $dataAwal, $jumlahData");
            // print_r($ambildata_perhalaman->num_rows);

            $jumlahPagination = ceil($hitungDataFilterRegistrasi / $jumlahData);

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

        } elseif ($_SESSION['c_accounting'] == 'accounting2') {

            $queryGetDataRegistrasi = "
                SELECT ID, NIS, NAMA, kelas, REGISTRASI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk_lama
                WHERE
                REGISTRASI != 0
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataRegistrasi    = mysqli_query($con, $queryGetDataRegistrasi);
            $hitungDataFilterRegistrasi = mysqli_num_rows($execQueryDataRegistrasi);

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, REGISTRASI, TRANSAKSI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk_lama
                WHERE
                REGISTRASI != 0
                AND NAMA LIKE '%$namaMurid%' 
                ORDER BY ID DESC
                LIMIT $dataAwal, $jumlahData");
            // print_r($ambildata_perhalaman->num_rows);

            $jumlahPagination = ceil($hitungDataFilterRegistrasi / $jumlahData);

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

    else if (isset($_POST['previousPageFilterRegistrasi'])) {

        $halamanAktif           = $_POST['halamanSebelumnyaFilterRegistrasi'];
        $iniScrollPreviousPage  = "ada";

        $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

        $namaMurid = $_POST['namaSiswaFilterRegistrasi'];
        $isifilby  = $_POST['iniFilterRegistrasi'];

        $id        = $_POST['idSiswaFilterRegistrasi'];
        $nis       = $_POST['nisFormFilterRegistrasi'];
        $namaSiswa = $_POST['namaFormFilterRegistrasi'];
        $panggilan = $_POST['panggilanFormFilterRegistrasi'];
        $kelas     = $_POST['kelasFormFilterRegistrasi'];

        $dariTanggal    = $_POST['tanggal1'] . " 00:00:00";
        $sampaiTanggal  = $_POST['tanggal2'] . " 23:59:59";

        $tanggalDari    = str_replace([" 00:00:00"], "", $dariTanggal);
        $tanggalSampai  = str_replace([" 23:59:59"], "", $sampaiTanggal);

        $setSesiPageFilterBy = 6;

        if ($_SESSION['c_accounting'] == 'accounting1') {

            $queryGetDataRegistrasi = "
                SELECT ID, NIS, NAMA, kelas, REGISTRASI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd_lama1
                WHERE
                REGISTRASI != 0
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataBuku     = mysqli_query($con, $queryGetDataRegistrasi);
            $hitungDataFilterRegistrasi  = mysqli_num_rows($execQueryDataBuku);

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, REGISTRASI, TRANSAKSI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd_lama1
                WHERE
                REGISTRASI != 0
                AND NAMA LIKE '%$namaMurid%'
                ORDER BY ID DESC
                LIMIT $dataAwal, $jumlahData");
            // print_r($ambildata_perhalaman->num_rows);

            $jumlahPagination = ceil($hitungDataFilterRegistrasi / $jumlahData);

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

        } elseif ($_SESSION['c_accounting'] == 'accounting2') {

            $queryGetDataRegistrasi = "
                SELECT ID, NIS, NAMA, kelas, REGISTRASI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk_lama
                WHERE
                REGISTRASI != 0
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataBuku     = mysqli_query($con, $queryGetDataRegistrasi);
            $hitungDataFilterRegistrasi  = mysqli_num_rows($execQueryDataBuku);

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, REGISTRASI, TRANSAKSI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk_lama
                WHERE
                REGISTRASI != 0
                AND NAMA LIKE '%$namaMurid%'
                ORDER BY ID DESC
                LIMIT $dataAwal, $jumlahData");
            // print_r($ambildata_perhalaman->num_rows);

            $jumlahPagination = ceil($hitungDataFilterRegistrasi / $jumlahData);

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

    else if (isset($_POST['toPageFilterRegistrasi'])) {

        $halamanAktif = $_POST['halamanKeFilterRegistrasi'];
        $iniScrollToPage = "ada";

        $namaMurid = $_POST['namaSiswaFilterRegistrasi'];
        $isifilby  = $_POST['iniFilterRegistrasi'];

        $namaSiswa = $namaMurid;
        $id        = $_POST['idSiswaFilterRegistrasi'];
        $nis       = $_POST['nisFormFilterRegistrasi'];
        $panggilan = $_POST['panggilanFormFilterRegistrasi'];
        $kelas     = $_POST['kelasFormFilterRegistrasi'];

        $dariTanggal    = $_POST['tanggal1'] . " 00:00:00";
        $sampaiTanggal  = $_POST['tanggal2'] . " 23:59:59";

        $tanggalDari    = str_replace([" 00:00:00"], "", $dariTanggal);
        $tanggalSampai  = str_replace([" 23:59:59"], "", $sampaiTanggal);

        $setSesiPageFilterBy = 6;

        if ($_SESSION['c_accounting'] == 'accounting1') {

            $queryGetDataRegistrasi = "
                SELECT ID, NIS, NAMA, kelas, REGISTRASI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd_lama1
                WHERE
                REGISTRASI != 0
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataRegistrasi    = mysqli_query($con, $queryGetDataRegistrasi);
            $hitungDataFilterRegistrasi = mysqli_num_rows($execQueryDataRegistrasi);

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, REGISTRASI, TRANSAKSI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd_lama1
                WHERE
                REGISTRASI != 0
                AND NAMA LIKE '%$namaMurid%' 
                ORDER BY ID DESC
                LIMIT $dataAwal, $jumlahData");
            // print_r($ambildata_perhalaman->num_rows);

            $jumlahPagination = ceil($hitungDataFilterRegistrasi / $jumlahData);

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

        } elseif ($_SESSION['c_accounting'] == 'accounting2') {

            $queryGetDataRegistrasi = "
                SELECT ID, NIS, NAMA, kelas, REGISTRASI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk_lama
                WHERE
                REGISTRASI != 0
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataRegistrasi    = mysqli_query($con, $queryGetDataRegistrasi);
            $hitungDataFilterRegistrasi = mysqli_num_rows($execQueryDataRegistrasi);

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, REGISTRASI, TRANSAKSI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk_lama
                WHERE
                REGISTRASI != 0
                AND NAMA LIKE '%$namaMurid%' 
                ORDER BY ID DESC
                LIMIT $dataAwal, $jumlahData");
            // print_r($ambildata_perhalaman->num_rows);

            $jumlahPagination = ceil($hitungDataFilterRegistrasi / $jumlahData);

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

    else if (isset($_POST['firstPageFilterRegistrasi'])) {

        $namaMurid      = $_POST['namaFormFilterRegistrasi'];

        $id             = $_POST['idSiswaFilterRegistrasi'];
        $nis            = $_POST['nisFormFilterRegistrasi'];
        $kelas          = $_POST['kelasFormFilterRegistrasi'];
        $panggilan      = $_POST['panggilanFormFilterRegistrasi'];
        $namaSiswa      = $namaMurid;

        $isifilby       = $_POST['iniFilterRegistrasi'];

        $dariTanggal    = $_POST['tanggal1'] . " 00:00:00";
        $sampaiTanggal  = $_POST['tanggal2'] . " 23:59:59";

        $tanggalDari    = str_replace([" 00:00:00"], "", $dariTanggal);
        $tanggalSampai  = str_replace([" 23:59:59"], "", $sampaiTanggal);

        $iniScrollFirstPage  = "ada";
        $setSesiPageFilterBy = 6;

        if ($_SESSION['c_accounting'] == 'accounting1') {

            $execQueryGetAllDataHistoriFilterRegistrasi = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, REGISTRASI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd_lama1
                WHERE
                REGISTRASI != 0
                AND NAMA LIKE '%$namaMurid%'
            ");

            $totalData = mysqli_num_rows($execQueryGetAllDataHistoriFilterRegistrasi);

            $jumlahPagination = ceil($totalData / $jumlahData);

            $halamanAktif   = 1;

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $hitungDataFilterRegistrasi = $totalData;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, REGISTRASI, TRANSAKSI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd_lama1
                WHERE
                REGISTRASI != 0
                AND NAMA LIKE '%$namaMurid%'
                ORDER BY ID DESC
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

        } elseif ($_SESSION['c_accounting'] == 'accounting2') {

            $execQueryGetAllDataHistoriFilterRegistrasi = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, REGISTRASI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk_lama
                WHERE
                REGISTRASI != 0
                AND NAMA LIKE '%$namaMurid%'
            ");

            $totalData = mysqli_num_rows($execQueryGetAllDataHistoriFilterRegistrasi);

            $jumlahPagination = ceil($totalData / $jumlahData);

            $halamanAktif   = 1;

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $hitungDataFilterRegistrasi = $totalData;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, REGISTRASI, TRANSAKSI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk_lama
                WHERE
                REGISTRASI != 0
                AND NAMA LIKE '%$namaMurid%'
                ORDER BY ID DESC
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

    else if (isset($_POST['lastPageFilterRegistrasi'])) {

        $namaMurid      = $_POST['namaSiswaFilterRegistrasi'];
        $isifilby       = $_POST['iniFilterRegistrasi'];

        $id             = $_POST['idSiswaFilterRegistrasi'];
        $namaSiswa      = $namaMurid;
        $kelas          = $_POST['kelasFormFilterRegistrasi'];
        $panggilan      = $_POST['panggilanFormFilterRegistrasi'];
        $nis            = $_POST['nisFormFilterRegistrasi'];

        $dariTanggal    = $_POST['tanggal1'] . " 00:00:00";
        $sampaiTanggal  = $_POST['tanggal2'] . " 23:59:59";

        $tanggalDari    = str_replace([" 00:00:00"], "", $dariTanggal);
        $tanggalSampai  = str_replace([" 23:59:59"], "", $sampaiTanggal);

        $iniScrollLastPage  = "ada";
        $setSesiPageFilterBy = 6;

        if ($_SESSION['c_accounting'] == 'accounting1') {

            $execQueryGetAllDataHistoriFilterRegistrasi = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, REGISTRASI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd_lama1
                WHERE
                REGISTRASI != 0
                AND NAMA LIKE '%$namaMurid%'
            ");

            $totalData = mysqli_num_rows($execQueryGetAllDataHistoriFilterRegistrasi);

            $jumlahPagination = ceil($totalData / $jumlahData);

            $halamanAktif   = $jumlahPagination;
            // echo $halamanAktif;exit;

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $hitungDataFilterRegistrasi = $totalData;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, REGISTRASI, TRANSAKSI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd_lama1
                WHERE
                REGISTRASI != 0
                AND NAMA LIKE '%$namaMurid%'
                ORDER BY ID DESC
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

        } elseif ($_SESSION['c_accounting'] == 'accounting2') {

            $execQueryGetAllDataHistoriFilterRegistrasi = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, REGISTRASI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk_lama
                WHERE
                REGISTRASI != 0
                AND NAMA LIKE '%$namaMurid%'
            ");

            $totalData = mysqli_num_rows($execQueryGetAllDataHistoriFilterRegistrasi);

            $jumlahPagination = ceil($totalData / $jumlahData);

            $halamanAktif   = $jumlahPagination;
            // echo $halamanAktif;exit;

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $hitungDataFilterRegistrasi = $totalData;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, REGISTRASI, TRANSAKSI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk_lama
                WHERE
                REGISTRASI != 0
                AND NAMA LIKE '%$namaMurid%'
                ORDER BY ID DESC
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

    elseif (isset($_POST['nextPageFilterRegistrasiWithDate'])) {

        $halamanAktif       = $_POST['halamanLanjutFilterRegistrasiWithDate'];
        $iniScrollNextPage  = "ada";

        $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

        $namaMurid  = $_POST['namaSiswaFilterRegistrasiWithDate'];
        $isifilby   = $_POST['iniFilterRegistrasiWithDate'];

        $id         = $_POST['idSiswaFilterRegistrasiWithDate'];
        $kelas      = $_POST['kelasFormFilterRegistrasiWithDate'];
        $panggilan  = $_POST['panggilanFormFilterRegistrasiWithDate'];
        $nis        = $_POST['nisFormFilterRegistrasiWithDate'];
        $namaSiswa  = $_POST['namaFormFilterRegistrasiWithDate'];

        $setSesiPageFilterBy = 13;

        $dariTanggal    = $_POST['tanggal1'] . " 00:00:00";
        $sampaiTanggal  = $_POST['tanggal2'] . " 23:59:59";

        $tanggalDari    = str_replace([" 00:00:00"], "", $dariTanggal);
        $tanggalSampai  = str_replace([" 23:59:59"], "", $sampaiTanggal);

        if ($_SESSION['c_accounting'] == 'accounting1') {

            $queryGetDataRegistrasiWithDate = "
                SELECT ID, NIS, NAMA, kelas, REGISTRASI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                REGISTRASI != 0
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataRegistrasiWithDate    = mysqli_query($con, $queryGetDataRegistrasiWithDate);
            $hitungDataFilterRegistrasiWithDate = mysqli_num_rows($execQueryDataRegistrasiWithDate);

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, REGISTRASI, TRANSAKSI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                REGISTRASI != 0
                AND NAMA LIKE '%$namaMurid%'
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                LIMIT $dataAwal, $jumlahData
            ");
            // print_r($ambildata_perhalaman->num_rows);

            $jumlahPagination = ceil($hitungDataFilterRegistrasiWithDate / $jumlahData);
            $hitungLagi = mysqli_num_rows($ambildata_perhalaman);

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

        } elseif ($_SESSION['c_accounting'] == 'accounting2') {

            $queryGetDataRegistrasiWithDate = "
                SELECT ID, NIS, NAMA, kelas, REGISTRASI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                REGISTRASI != 0
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataRegistrasiWithDate    = mysqli_query($con, $queryGetDataRegistrasiWithDate);
            $hitungDataFilterRegistrasiWithDate = mysqli_num_rows($execQueryDataRegistrasiWithDate);

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, REGISTRASI, TRANSAKSI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                REGISTRASI != 0
                AND NAMA LIKE '%$namaMurid%'
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                LIMIT $dataAwal, $jumlahData
            ");
            // print_r($ambildata_perhalaman->num_rows);

            $jumlahPagination = ceil($hitungDataFilterRegistrasiWithDate / $jumlahData);
            $hitungLagi = mysqli_num_rows($ambildata_perhalaman);

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

    elseif (isset($_POST['previousPageFilterRegistrasiWithDate'])) {

        $halamanAktif           = $_POST['halamanSebelumnyaFilterRegistrasiWithDate'];
        $iniScrollPreviousPage  = "ada";

        $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

        $namaMurid = $_POST['namaSiswaFilterRegistrasiWithDate'];
        $isifilby  = $_POST['iniFilterRegistrasiWithDate'];

        $id        = $_POST['idSiswaFilterRegistrasiWithDate'];
        $nis       = $_POST['nisFormFilterRegistrasiWithDate'];
        $namaSiswa = $_POST['namaFormFilterRegistrasiWithDate'];
        $panggilan = $_POST['panggilanFormFilterRegistrasiWithDate'];
        $kelas     = $_POST['kelasFormFilterRegistrasiWithDate'];

        $setSesiPageFilterBy = 13;

        $dariTanggal    = $_POST['tanggal1'] . " 00:00:00";
        $sampaiTanggal  = $_POST['tanggal2'] . " 23:59:59";

        $tanggalDari    = str_replace([" 00:00:00"], "", $dariTanggal);
        $tanggalSampai  = str_replace([" 23:59:59"], "", $sampaiTanggal);

        if ($_SESSION['c_accounting'] == 'accounting1') {

            $queryGetDataRegistrasiWithDate = "
                SELECT ID, NIS, NAMA, DATE, kelas, REGISTRASI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                REGISTRASI != 0
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataRegistrasiWithDate    = mysqli_query($con, $queryGetDataRegistrasiWithDate);
            $hitungDataFilterRegistrasiWithDate = mysqli_num_rows($execQueryDataRegistrasiWithDate);

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, REGISTRASI, TRANSAKSI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                REGISTRASI != 0
                AND NAMA LIKE '%$namaMurid%'
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal' 
                LIMIT $dataAwal, $jumlahData");

            $jumlahPagination = ceil($hitungDataFilterRegistrasiWithDate / $jumlahData);

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

        } elseif ($_SESSION['c_accounting'] == 'accounting2') {

            $queryGetDataRegistrasiWithDate = "
                SELECT ID, NIS, NAMA, DATE, kelas, REGISTRASI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                REGISTRASI != 0
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataRegistrasiWithDate    = mysqli_query($con, $queryGetDataRegistrasiWithDate);
            $hitungDataFilterRegistrasiWithDate = mysqli_num_rows($execQueryDataRegistrasiWithDate);

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, REGISTRASI, TRANSAKSI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                REGISTRASI != 0
                AND NAMA LIKE '%$namaMurid%'
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal' 
                LIMIT $dataAwal, $jumlahData");

            $jumlahPagination = ceil($hitungDataFilterRegistrasiWithDate / $jumlahData);

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

    elseif (isset($_POST['toPageFilterRegistrasiWithDate'])) {

        $halamanAktif = $_POST['halamanKeFilterRegistrasiWithDate'];
        $iniScrollToPage = "ada";

        $namaMurid = $_POST['namaSiswaFilterRegistrasiWithDate'];
        $isifilby  = $_POST['iniFilterRegistrasiWithDate'];

        $namaSiswa = $namaMurid;
        $id        = $_POST['idSiswaFilterRegistrasiWithDate'];
        $nis       = $_POST['nisFormFilterRegistrasiWithDate'];
        $panggilan = $_POST['panggilanFormFilterRegistrasiWithDate'];
        $kelas     = $_POST['kelasFormFilterRegistrasiWithDate'];

        $setSesiPageFilterBy = 13;

        $dariTanggal    = $_POST['tanggal1'] . " 00:00:00";
        $sampaiTanggal  = $_POST['tanggal2'] . " 23:59:59";

        $tanggalDari    = str_replace([" 00:00:00"], "", $dariTanggal);
        $tanggalSampai  = str_replace([" 23:59:59"], "", $sampaiTanggal);

        if ($_SESSION['c_accounting'] == 'accounting1') {

            $queryGetDataRegistrasiWithDate = "
                SELECT ID, NIS, NAMA, kelas, REGISTRASI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd_lama1
                WHERE
                REGISTRASI != 0
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataRegistrasiWithDate    = mysqli_query($con, $queryGetDataRegistrasiWithDate);
            $hitungDataFilterRegistrasiWithDate = mysqli_num_rows($execQueryDataRegistrasiWithDate);

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, REGISTRASI, TRANSAKSI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd_lama1
                WHERE
                REGISTRASI != 0
                AND NAMA LIKE '%$namaMurid%'
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                LIMIT $dataAwal, $jumlahData");
            // print_r($ambildata_perhalaman->num_rows);

            $jumlahPagination = ceil($hitungDataFilterRegistrasiWithDate / $jumlahData);

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

        } elseif ($_SESSION['c_accounting'] == 'accounting2') {

            $queryGetDataRegistrasiWithDate = "
                SELECT ID, NIS, NAMA, kelas, REGISTRASI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk_lama
                WHERE
                REGISTRASI != 0
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataRegistrasiWithDate    = mysqli_query($con, $queryGetDataRegistrasiWithDate);
            $hitungDataFilterRegistrasiWithDate = mysqli_num_rows($execQueryDataRegistrasiWithDate);

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, REGISTRASI, TRANSAKSI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk_lama
                WHERE
                REGISTRASI != 0
                AND NAMA LIKE '%$namaMurid%'
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                LIMIT $dataAwal, $jumlahData");
            // print_r($ambildata_perhalaman->num_rows);

            $jumlahPagination = ceil($hitungDataFilterRegistrasiWithDate / $jumlahData);

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

    elseif (isset($_POST['firstPageFilterRegistrasiWithDate'])) {

        $namaMurid      = $_POST['namaFormFilterRegistrasiWithDate'];

        $id             = $_POST['idSiswaFilterRegistrasiWithDate'];
        $nis            = $_POST['nisFormFilterRegistrasiWithDate'];
        $kelas          = $_POST['kelasFormFilterRegistrasiWithDate'];
        $panggilan      = $_POST['panggilanFormFilterRegistrasiWithDate'];
        $namaSiswa      = $namaMurid;

        $isifilby       = $_POST['iniFilterRegistrasiWithDate'];

        $iniScrollFirstPage  = "ada";

        $setSesiPageFilterBy = 13;

        $dariTanggal    = $_POST['tanggal1'] . " 00:00:00";
        $sampaiTanggal  = $_POST['tanggal2'] . " 23:59:59";

        $tanggalDari    = str_replace([" 00:00:00"], "", $dariTanggal);
        $tanggalSampai  = str_replace([" 23:59:59"], "", $sampaiTanggal);

        if ($_SESSION['c_accounting'] == 'accounting1') {

            $execQueryGetAllDataHistoriFilterRegistrasiWithDate = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, REGISTRASI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd_lama1
                WHERE
                REGISTRASI != 0
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                AND NAMA LIKE '%$namaMurid%'
            ");

            $totalData = mysqli_num_rows($execQueryGetAllDataHistoriFilterRegistrasiWithDate);
            // echo $totalData;

            $jumlahPagination = ceil($totalData / $jumlahData);

            $halamanAktif   = 1;

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $hitungDataFilterRegistrasiWithDate = $jumlahPagination;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, REGISTRASI, TRANSAKSI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd_lama1
                WHERE
                REGISTRASI != 0
                AND NAMA LIKE '%$namaMurid%'
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
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

        } elseif ($_SESSION['c_accounting'] == 'accounting2') {

            $execQueryGetAllDataHistoriFilterRegistrasiWithDate = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, REGISTRASI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk_lama
                WHERE
                REGISTRASI != 0
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                AND NAMA LIKE '%$namaMurid%'
            ");

            $totalData = mysqli_num_rows($execQueryGetAllDataHistoriFilterRegistrasiWithDate);
            // echo $totalData;

            $jumlahPagination = ceil($totalData / $jumlahData);

            $halamanAktif   = 1;

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $hitungDataFilterRegistrasiWithDate = $jumlahPagination;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, REGISTRASI, TRANSAKSI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk_lama
                WHERE
                REGISTRASI != 0
                AND NAMA LIKE '%$namaMurid%'
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
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

    elseif (isset($_POST['lastPageFilterRegistrasiWithDate'])) {

        $namaMurid      = $_POST['namaSiswaFilterRegistrasiWithDate'];
        $isifilby       = $_POST['iniFilterRegistrasiWithDate'];

        $id             = $_POST['idSiswaFilterRegistrasiWithDate'];
        $namaSiswa      = $namaMurid;
        $kelas          = $_POST['kelasFormFilterRegistrasiWithDate'];
        $panggilan      = $_POST['panggilanFormFilterRegistrasiWithDate'];
        $nis            = $_POST['nisFormFilterRegistrasiWithDate'];

        $iniScrollLastPage  = "ada";

        $setSesiPageFilterBy = 13;

        $dariTanggal    = $_POST['tanggal1'] . " 00:00:00";
        $sampaiTanggal  = $_POST['tanggal2'] . " 23:59:59";

        $tanggalDari    = str_replace([" 00:00:00"], "", $dariTanggal);
        $tanggalSampai  = str_replace([" 23:59:59"], "", $sampaiTanggal);

        if ($_SESSION['c_accounting'] == 'accounting1') {

            $execQueryGetAllDataHistoriFilterRegistrasiWithDate = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, REGISTRASI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd_lama1
                WHERE
                REGISTRASI != 0
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                AND NAMA LIKE '%$namaMurid%'
            ");

            $totalData = mysqli_num_rows($execQueryGetAllDataHistoriFilterRegistrasiWithDate);
            // echo $totalData;

            $jumlahPagination = ceil($totalData / $jumlahData);

            $halamanAktif   = $jumlahPagination;
            // echo $halamanAktif;exit;

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $hitungDataFilterRegistrasiWithDate = $jumlahPagination;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, REGISTRASI, TRANSAKSI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd_lama1
                WHERE
                REGISTRASI != 0
                AND NAMA LIKE '%$namaMurid%'
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
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

        } elseif ($_SESSION['c_accounting'] == 'accounting2') {

            $execQueryGetAllDataHistoriFilterRegistrasiWithDate = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, REGISTRASI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk_lama
                WHERE
                REGISTRASI != 0
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                AND NAMA LIKE '%$namaMurid%'
            ");

            $totalData = mysqli_num_rows($execQueryGetAllDataHistoriFilterRegistrasiWithDate);
            // echo $totalData;

            $jumlahPagination = ceil($totalData / $jumlahData);

            $halamanAktif   = $jumlahPagination;
            // echo $halamanAktif;exit;

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $hitungDataFilterRegistrasiWithDate = $jumlahPagination;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, REGISTRASI, TRANSAKSI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk_lama
                WHERE
                REGISTRASI != 0
                AND NAMA LIKE '%$namaMurid%'
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
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
    // AKHIR REGISTRASI

    // LAIN2
    else if (isset($_POST['nextPageFilterLain'])) {

        $halamanAktif       = $_POST['halamanLanjutFilterLain'];
        $iniScrollNextPage  = "ada";

        $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

        $namaMurid  = $_POST['namaSiswaFilterLain'];
        $isifilby   = $_POST['iniFilterLain'];

        $id         = $_POST['idSiswaFilterLain'];
        $kelas      = $_POST['kelasFormFilterLain'];
        $panggilan  = $_POST['panggilanFormFilterLain'];
        $nis        = $_POST['nisFormFilterLain'];
        $namaSiswa  = $_POST['namaFormFilterLain'];

        $dariTanggal    = $_POST['tanggal1'];
        $sampaiTanggal  = $_POST['tanggal2'];

        $tanggalDari    = str_replace([" 00:00:00"], "", $dariTanggal);
        $tanggalSampai  = str_replace([" 23:59:59"], "", $sampaiTanggal);

        $setSesiPageFilterBy = 7;

        if ($_SESSION['c_accounting'] == 'accounting1') {

            $queryGetDataLain = "
                SELECT ID, NIS, NAMA, kelas, LAIN, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd_lama1
                WHERE
                LAIN != 0
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataLain    = mysqli_query($con, $queryGetDataLain);
            $hitungDataFilterLain = mysqli_num_rows($execQueryDataLain);

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, LAIN, TRANSAKSI, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd_lama1
                WHERE
                LAIN != 0
                AND NAMA LIKE '%$namaMurid%' 
                ORDER BY ID DESC
                LIMIT $dataAwal, $jumlahData");
            // print_r($ambildata_perhalaman->num_rows);

            $jumlahPagination = ceil($hitungDataFilterLain / $jumlahData);

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

        } elseif ($_SESSION['c_accounting'] == 'accounting2') {

            $queryGetDataLain = "
                SELECT ID, NIS, NAMA, kelas, LAIN, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk_lama
                WHERE
                LAIN != 0
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataLain    = mysqli_query($con, $queryGetDataLain);
            $hitungDataFilterLain = mysqli_num_rows($execQueryDataLain);

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, LAIN, TRANSAKSI, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk_lama
                WHERE
                LAIN != 0
                AND NAMA LIKE '%$namaMurid%' 
                ORDER BY ID DESC
                LIMIT $dataAwal, $jumlahData");
            // print_r($ambildata_perhalaman->num_rows);

            $jumlahPagination = ceil($hitungDataFilterLain / $jumlahData);

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

    else if (isset($_POST['previousPageFilterLain'])) {

        $halamanAktif           = $_POST['halamanSebelumnyaFilterLain'];
        $iniScrollPreviousPage  = "ada";

        $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

        $namaMurid = $_POST['namaSiswaFilterLain'];
        $isifilby  = $_POST['iniFilterLain'];

        $id        = $_POST['idSiswaFilterLain'];
        $nis       = $_POST['nisFormFilterLain'];
        $namaSiswa = $_POST['namaFormFilterLain'];
        $panggilan = $_POST['panggilanFormFilterLain'];
        $kelas     = $_POST['kelasFormFilterLain'];

        $dariTanggal    = $_POST['tanggal1'];
        $sampaiTanggal  = $_POST['tanggal2'];

        $tanggalDari    = str_replace([" 00:00:00"], "", $dariTanggal);
        $tanggalSampai  = str_replace([" 23:59:59"], "", $sampaiTanggal);

        $setSesiPageFilterBy = 7;

        if ($_SESSION['c_accounting'] == 'accounting1') {

            $queryGetDataLain = "
                SELECT ID, NIS, NAMA, kelas, LAIN, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd_lama1
                WHERE
                LAIN != 0
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataLain     = mysqli_query($con, $queryGetDataLain);
            $hitungDataFilterLain  = mysqli_num_rows($execQueryDataLain);

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, LAIN, TRANSAKSI, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd_lama1
                WHERE
                LAIN != 0
                AND NAMA LIKE '%$namaMurid%'
                ORDER BY ID DESC
                LIMIT $dataAwal, $jumlahData");
            // print_r($ambildata_perhalaman->num_rows);

            $jumlahPagination = ceil($hitungDataFilterLain / $jumlahData);

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

        } elseif ($_SESSION['c_accounting'] == 'accounting2') {

            $queryGetDataLain = "
                SELECT ID, NIS, NAMA, kelas, LAIN, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk_lama
                WHERE
                LAIN != 0
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataLain     = mysqli_query($con, $queryGetDataLain);
            $hitungDataFilterLain  = mysqli_num_rows($execQueryDataLain);

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, LAIN, TRANSAKSI, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk_lama
                WHERE
                LAIN != 0
                AND NAMA LIKE '%$namaMurid%'
                ORDER BY ID DESC
                LIMIT $dataAwal, $jumlahData");
            // print_r($ambildata_perhalaman->num_rows);

            $jumlahPagination = ceil($hitungDataFilterLain / $jumlahData);

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

    else if (isset($_POST['toPageFilterLain'])) {

        $halamanAktif = $_POST['halamanKeFilterLain'];
        $iniScrollToPage = "ada";

        $namaMurid = $_POST['namaSiswaFilterLain'];
        $isifilby  = $_POST['iniFilterLain'];

        $namaSiswa = $namaMurid;
        $id        = $_POST['idSiswaFilterLain'];
        $nis       = $_POST['nisFormFilterLain'];
        $panggilan = $_POST['panggilanFormFilterLain'];
        $kelas     = $_POST['kelasFormFilterLain'];

        $dariTanggal    = $_POST['tanggal1'];
        $sampaiTanggal  = $_POST['tanggal2'];

        $tanggalDari    = str_replace([" 00:00:00"], "", $dariTanggal);
        $tanggalSampai  = str_replace([" 23:59:59"], "", $sampaiTanggal);

        $setSesiPageFilterBy = 7;

        if ($_SESSION['c_accounting'] == 'accounting1') {

            $queryGetDataLain = "
                SELECT ID, NIS, NAMA, kelas, LAIN, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd_lama1
                WHERE
                LAIN != 0
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataLain    = mysqli_query($con, $queryGetDataLain);
            $hitungDataFilterLain = mysqli_num_rows($execQueryDataLain);

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, LAIN, TRANSAKSI, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd_lama1
                WHERE
                LAIN != 0
                AND NAMA LIKE '%$namaMurid%' 
                ORDER BY ID DESC
                LIMIT $dataAwal, $jumlahData");
            // print_r($ambildata_perhalaman->num_rows);

            $jumlahPagination = ceil($hitungDataFilterLain / $jumlahData);

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

        } elseif ($_SESSION['c_accounting'] == 'accounting2') {

            $queryGetDataLain = "
                SELECT ID, NIS, NAMA, kelas, LAIN, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk_lama
                WHERE
                LAIN != 0
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataLain    = mysqli_query($con, $queryGetDataLain);
            $hitungDataFilterLain = mysqli_num_rows($execQueryDataLain);

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, LAIN, TRANSAKSI, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk_lama
                WHERE
                LAIN != 0
                AND NAMA LIKE '%$namaMurid%' 
                ORDER BY ID DESC
                LIMIT $dataAwal, $jumlahData");
            // print_r($ambildata_perhalaman->num_rows);

            $jumlahPagination = ceil($hitungDataFilterLain / $jumlahData);

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

    else if (isset($_POST['firstPageFilterLain'])) {

        $namaMurid      = $_POST['namaFormFilterLain'];

        $id             = $_POST['idSiswaFilterLain'];
        $nis            = $_POST['nisFormFilterLain'];
        $kelas          = $_POST['kelasFormFilterLain'];
        $panggilan      = $_POST['panggilanFormFilterLain'];
        $namaSiswa      = $namaMurid;

        $isifilby       = $_POST['iniFilterLain'];

        $dariTanggal    = $_POST['tanggal1'];
        $sampaiTanggal  = $_POST['tanggal2'];

        $tanggalDari    = str_replace([" 00:00:00"], "", $dariTanggal);
        $tanggalSampai  = str_replace([" 23:59:59"], "", $sampaiTanggal);

        $iniScrollFirstPage  = "ada";
        $setSesiPageFilterBy = 7;

        if ($_SESSION['c_accounting'] == 'accounting1') {

            $execQueryGetAllDataHistoriFilterLain = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, LAIN, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd_lama1
                WHERE
                LAIN != 0
                AND NAMA LIKE '%$namaMurid%'
            ");

            $totalData = mysqli_num_rows($execQueryGetAllDataHistoriFilterLain);

            $jumlahPagination = ceil($totalData / $jumlahData);

            $halamanAktif   = 1;

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $hitungDataFilterLain = $totalData;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, LAIN, TRANSAKSI, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd_lama1
                WHERE
                LAIN != 0
                AND NAMA LIKE '%$namaMurid%'
                ORDER BY ID DESC
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

        } elseif ($_SESSION['c_accounting'] == 'accounting2') {

            $execQueryGetAllDataHistoriFilterLain = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, LAIN, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk_lama
                WHERE
                LAIN != 0
                AND NAMA LIKE '%$namaMurid%'
            ");

            $totalData = mysqli_num_rows($execQueryGetAllDataHistoriFilterLain);

            $jumlahPagination = ceil($totalData / $jumlahData);

            $halamanAktif   = 1;

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $hitungDataFilterLain = $totalData;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, LAIN, TRANSAKSI, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk_lama
                WHERE
                LAIN != 0
                AND NAMA LIKE '%$namaMurid%'
                ORDER BY ID DESC
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

    else if (isset($_POST['lastPageFilterLain'])) {

        $namaMurid      = $_POST['namaSiswaFilterLain'];
        $isifilby       = $_POST['iniFilterLain'];

        $id             = $_POST['idSiswaFilterLain'];
        $namaSiswa      = $namaMurid;
        $kelas          = $_POST['kelasFormFilterLain'];
        $panggilan      = $_POST['panggilanFormFilterLain'];
        $nis            = $_POST['nisFormFilterLain'];

        $dariTanggal    = $_POST['tanggal1'];
        $sampaiTanggal  = $_POST['tanggal2'];

        $tanggalDari    = str_replace([" 00:00:00"], "", $dariTanggal);
        $tanggalSampai  = str_replace([" 23:59:59"], "", $sampaiTanggal);

        $iniScrollLastPage  = "ada";
        $setSesiPageFilterBy = 7;

        if ($_SESSION['c_accounting'] == 'accounting1') {

            $execQueryGetAllDataHistoriFilterLain = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, LAIN, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd_lama1
                WHERE
                LAIN != 0
                AND NAMA LIKE '%$namaMurid%'
            ");

            $totalData = mysqli_num_rows($execQueryGetAllDataHistoriFilterLain);

            $jumlahPagination = ceil($totalData / $jumlahData);

            $halamanAktif   = $jumlahPagination;
            // echo $halamanAktif;exit;

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $hitungDataFilterLain = $totalData;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, LAIN, TRANSAKSI, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd_lama1
                WHERE
                LAIN != 0
                AND NAMA LIKE '%$namaMurid%'
                ORDER BY ID DESC
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

        } elseif ($_SESSION['c_accounting'] == 'accounting2') {

            $execQueryGetAllDataHistoriFilterLain = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, LAIN, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk_lama
                WHERE
                LAIN != 0
                AND NAMA LIKE '%$namaMurid%'
            ");

            $totalData = mysqli_num_rows($execQueryGetAllDataHistoriFilterLain);

            $jumlahPagination = ceil($totalData / $jumlahData);

            $halamanAktif   = $jumlahPagination;
            // echo $halamanAktif;exit;

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $hitungDataFilterLain = $totalData;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, LAIN, TRANSAKSI, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk_lama
                WHERE
                LAIN != 0
                AND NAMA LIKE '%$namaMurid%'
                ORDER BY ID DESC
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

    elseif (isset($_POST['nextPageFilterLainWithDate'])) {

        $halamanAktif       = $_POST['halamanLanjutFilterLainWithDate'];
        $iniScrollNextPage  = "ada";

        $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

        $namaMurid  = $_POST['namaSiswaFilterLainWithDate'];
        $isifilby   = $_POST['iniFilterLainWithDate'];

        $id         = $_POST['idSiswaFilterLainWithDate'];
        $kelas      = $_POST['kelasFormFilterLainWithDate'];
        $panggilan  = $_POST['panggilanFormFilterLainWithDate'];
        $nis        = $_POST['nisFormFilterLainWithDate'];
        $namaSiswa  = $_POST['namaFormFilterLainWithDate'];

        $setSesiPageFilterBy = 14;

        $dariTanggal    = $_POST['tanggal1'];
        $sampaiTanggal  = $_POST['tanggal2'];

        $tanggalDari    = str_replace([" 00:00:00"], "", $dariTanggal);
        $tanggalSampai  = str_replace([" 23:59:59"], "", $sampaiTanggal);

        if ($_SESSION['c_accounting'] == 'accounting1') {

            $queryGetDataLainWithDate = "
                SELECT ID, NIS, NAMA, kelas, LAIN, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                LAIN != 0
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataLainWithDate    = mysqli_query($con, $queryGetDataLainWithDate);
            $hitungDataFilterLainWithDate = mysqli_num_rows($execQueryDataLainWithDate);

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, LAIN, TRANSAKSI, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                LAIN != 0
                AND NAMA LIKE '%$namaMurid%'
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                LIMIT $dataAwal, $jumlahData
            ");
            // print_r($ambildata_perhalaman->num_rows);

            $jumlahPagination = ceil($hitungDataFilterLainWithDate / $jumlahData);
            $hitungLagi = mysqli_num_rows($ambildata_perhalaman);

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

        } elseif ($_SESSION['c_accounting'] == 'accounting2') {

            $queryGetDataLainWithDate = "
                SELECT ID, NIS, NAMA, kelas, LAIN, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                LAIN != 0
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataLainWithDate    = mysqli_query($con, $queryGetDataLainWithDate);
            $hitungDataFilterLainWithDate = mysqli_num_rows($execQueryDataLainWithDate);

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, LAIN, TRANSAKSI, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                LAIN != 0
                AND NAMA LIKE '%$namaMurid%'
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                LIMIT $dataAwal, $jumlahData
            ");
            // print_r($ambildata_perhalaman->num_rows);

            $jumlahPagination = ceil($hitungDataFilterLainWithDate / $jumlahData);
            $hitungLagi = mysqli_num_rows($ambildata_perhalaman);

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

    elseif (isset($_POST['previousPageFilterLainWithDate'])) {

        $halamanAktif           = $_POST['halamanSebelumnyaFilterLainWithDate'];
        $iniScrollPreviousPage  = "ada";

        $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

        $namaMurid = $_POST['namaSiswaFilterLainWithDate'];
        $isifilby  = $_POST['iniFilterLainWithDate'];

        $id        = $_POST['idSiswaFilterLainWithDate'];
        $nis       = $_POST['nisFormFilterLainWithDate'];
        $namaSiswa = $_POST['namaFormFilterLainWithDate'];
        $panggilan = $_POST['panggilanFormFilterLainWithDate'];
        $kelas     = $_POST['kelasFormFilterLainWithDate'];

        $setSesiPageFilterBy = 14;

        $dariTanggal    = $_POST['tanggal1'];
        $sampaiTanggal  = $_POST['tanggal2'];

        $tanggalDari    = str_replace([" 00:00:00"], "", $dariTanggal);
        $tanggalSampai  = str_replace([" 23:59:59"], "", $sampaiTanggal);

        if ($_SESSION['c_accounting'] == 'accounting1') {

            $queryGetDatLainWithDate = "
                SELECT ID, NIS, NAMA, kelas, LAIN, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                LAIN != 0
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataLainWithDate    = mysqli_query($con, $queryGetDatLainWithDate);
            $hitungDataFilterLainWithDate = mysqli_num_rows($execQueryDataLainWithDate);

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, LAIN, TRANSAKSI, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                LAIN != 0
                AND NAMA LIKE '%$namaMurid%'
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal' 
                LIMIT $dataAwal, $jumlahData");

            $jumlahPagination = ceil($hitungDataFilterLainWithDate / $jumlahData);

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

        } elseif ($_SESSION['c_accounting'] == 'accounting2') {

            $queryGetDatLainWithDate = "
                SELECT ID, NIS, NAMA, kelas, LAIN, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                LAIN != 0
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataLainWithDate    = mysqli_query($con, $queryGetDatLainWithDate);
            $hitungDataFilterLainWithDate = mysqli_num_rows($execQueryDataLainWithDate);

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, LAIN, TRANSAKSI, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                LAIN != 0
                AND NAMA LIKE '%$namaMurid%'
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal' 
                LIMIT $dataAwal, $jumlahData");

            $jumlahPagination = ceil($hitungDataFilterLainWithDate / $jumlahData);

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

    elseif (isset($_POST['toPageFilterLainWithDate'])) {

        $halamanAktif = $_POST['halamanKeFilterLainWithDate'];
        $iniScrollToPage = "ada";

        $namaMurid = $_POST['namaSiswaFilterLainWithDate'];
        $isifilby  = $_POST['iniFilterLainWithDate'];

        $namaSiswa = $namaMurid;
        $id        = $_POST['idSiswaFilterLainWithDate'];
        $nis       = $_POST['nisFormFilterLainWithDate'];
        $panggilan = $_POST['panggilanFormFilterLainWithDate'];
        $kelas     = $_POST['kelasFormFilterLainWithDate'];

        $setSesiPageFilterBy = 14;

        $dariTanggal    = $_POST['tanggal1'];
        $sampaiTanggal  = $_POST['tanggal2'];

        $tanggalDari    = str_replace([" 00:00:00"], "", $dariTanggal);
        $tanggalSampai  = str_replace([" 23:59:59"], "", $sampaiTanggal);

        if ($_SESSION['c_accounting'] == 'accounting1') {

            $queryGetDataLainWithDate = "
                SELECT ID, NIS, NAMA, kelas, LAIN, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                LAIN != 0
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataLainWithDate    = mysqli_query($con, $queryGetDataLainWithDate);
            $hitungDataFilterLainWithDate = mysqli_num_rows($execQueryDataLainWithDate);

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, LAIN, TRANSAKSI, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                LAIN != 0
                AND NAMA LIKE '%$namaMurid%'
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                LIMIT $dataAwal, $jumlahData");
            // print_r($ambildata_perhalaman->num_rows);

            $jumlahPagination = ceil($hitungDataFilterLainWithDate / $jumlahData);

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

        } elseif ($_SESSION['c_accounting'] == 'accounting2') {

            $queryGetDataLainWithDate = "
                SELECT ID, NIS, NAMA, kelas, LAIN, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                LAIN != 0
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataLainWithDate    = mysqli_query($con, $queryGetDataLainWithDate);
            $hitungDataFilterLainWithDate = mysqli_num_rows($execQueryDataLainWithDate);

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, LAIN, TRANSAKSI, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                LAIN != 0
                AND NAMA LIKE '%$namaMurid%'
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                LIMIT $dataAwal, $jumlahData");
            // print_r($ambildata_perhalaman->num_rows);

            $jumlahPagination = ceil($hitungDataFilterLainWithDate / $jumlahData);

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

    elseif (isset($_POST['firstPageFilterLainWithDate'])) {

        $namaMurid      = $_POST['namaFormFilterLainWithDate'];

        $id             = $_POST['idSiswaFilterLainWithDate'];
        $nis            = $_POST['nisFormFilterLainWithDate'];
        $kelas          = $_POST['kelasFormFilterLainWithDate'];
        $panggilan      = $_POST['panggilanFormFilterLainWithDate'];
        $namaSiswa      = $namaMurid;

        $isifilby       = $_POST['iniFilterLainWithDate'];

        $iniScrollFirstPage  = "ada";

        $setSesiPageFilterBy = 14;

        $dariTanggal    = $_POST['tanggal1'];
        $sampaiTanggal  = $_POST['tanggal2'];

        $tanggalDari    = str_replace([" 00:00:00"], "", $dariTanggal);
        $tanggalSampai  = str_replace([" 23:59:59"], "", $sampaiTanggal);

        if ($_SESSION['c_accounting'] == 'accounting1') {

            $execQueryGetAllDataHistoriFilterLainWithDate = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, LAIN, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                LAIN != 0
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                AND NAMA LIKE '%$namaMurid%'
            ");

            $totalData = mysqli_num_rows($execQueryGetAllDataHistoriFilterLainWithDate);
            // echo $totalData;

            $jumlahPagination = ceil($totalData / $jumlahData);

            $halamanAktif   = 1;

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $hitungDataFilterLainWithDate = $jumlahPagination;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, LAIN, TRANSAKSI, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                LAIN != 0
                AND NAMA LIKE '%$namaMurid%'
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
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

        } elseif ($_SESSION['c_accounting'] == 'accounting2') {

            $execQueryGetAllDataHistoriFilterLainWithDate = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, LAIN, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                LAIN != 0
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                AND NAMA LIKE '%$namaMurid%'
            ");

            $totalData = mysqli_num_rows($execQueryGetAllDataHistoriFilterLainWithDate);
            // echo $totalData;

            $jumlahPagination = ceil($totalData / $jumlahData);

            $halamanAktif   = 1;

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $hitungDataFilterLainWithDate = $jumlahPagination;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, LAIN, TRANSAKSI, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                LAIN != 0
                AND NAMA LIKE '%$namaMurid%'
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
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

    elseif (isset($_POST['lastPageFilterLainWithDate'])) {

        $namaMurid      = $_POST['namaSiswaFilterLainWithDate'];
        $isifilby       = $_POST['iniFilterLainWithDate'];

        $id             = $_POST['idSiswaFilterLainWithDate'];
        $namaSiswa      = $namaMurid;
        $kelas          = $_POST['kelasFormFilterLainWithDate'];
        $panggilan      = $_POST['panggilanFormFilterLainWithDate'];
        $nis            = $_POST['nisFormFilterLainWithDate'];

        $iniScrollLastPage  = "ada";

        $setSesiPageFilterBy = 14;

        $dariTanggal    = $_POST['tanggal1'];
        $sampaiTanggal  = $_POST['tanggal2'];

        $tanggalDari    = str_replace([" 00:00:00"], "", $dariTanggal);
        $tanggalSampai  = str_replace([" 23:59:59"], "", $sampaiTanggal);

        if ($_SESSION['c_accounting'] == 'accounting1') {

            $execQueryGetAllDataHistoriFilterLainWithDate = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, LAIN, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd_lama1
                WHERE
                LAIN != 0
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                AND NAMA LIKE '%$namaMurid%'
            ");

            $totalData = mysqli_num_rows($execQueryGetAllDataHistoriFilterLainWithDate);
            // echo $totalData;

            $jumlahPagination = ceil($totalData / $jumlahData);

            $halamanAktif   = $jumlahPagination;
            // echo $halamanAktif;exit;

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $hitungDataFilterLainWithDate = $jumlahPagination;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, LAIN, TRANSAKSI, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd_lama1
                WHERE
                LAIN != 0
                AND NAMA LIKE '%$namaMurid%'
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
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

        } elseif ($_SESSION['c_accounting'] == 'accounting2') {

            $execQueryGetAllDataHistoriFilterLainWithDate = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, LAIN, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk_lama
                WHERE
                LAIN != 0
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                AND NAMA LIKE '%$namaMurid%'
            ");

            $totalData = mysqli_num_rows($execQueryGetAllDataHistoriFilterLainWithDate);
            // echo $totalData;

            $jumlahPagination = ceil($totalData / $jumlahData);

            $halamanAktif   = $jumlahPagination;
            // echo $halamanAktif;exit;

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $hitungDataFilterLainWithDate = $jumlahPagination;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, LAIN, TRANSAKSI, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk_lama
                WHERE
                LAIN != 0
                AND NAMA LIKE '%$namaMurid%'
                AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
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
    // AKHIR LAIN2

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

            <?php if(isset($_SESSION['form_success']) && $_SESSION['form_success'] == 'session_time_out'){?>
              <div style="display: none;" class="alert alert-danger alert-dismissable"> Waktu Sesi Telah Habis
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
    <?php if ($setSesiFormEdit == 1): ?>

        <?php  

            $setSesiJsFormatRupiah = 1;

        ?>

        <div class="box box-info">

            <div class="box-header with-border">
                <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Edit Data Pembayaran <?= $isifilby; ?> </h3>
            </div>

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
                                <label>TANGGAL BAYAR</label>
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
                                <input type="text" name="nominalBayar" id="nominalBayar" class="form-control" value="<?= rupiahFormatInput($nominalBayar); ?>">
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
                                <label style="color: white;"> </label>

                                <input type="hidden" name="data_id_siswa" value="<?= $id_siswa; ?>">
                                <input type="hidden" name="data_nis_siswa" value="<?= $nis; ?>">
                                <input type="hidden" name="data_nama_siswa" value="<?= $namaSiswa; ?>">
                                <input type="hidden" name="data_kelas_siswa" value="<?= $kelas; ?>">
                                <input type="hidden" name="data_panggilan_siswa" value="<?= $panggilan; ?>">
                                
                                <input type="hidden" name="currentPage" value="<?= $currentPage; ?>">
                                <input type="hidden" name="currentFilter" value="<?= $typeFilter; ?>">

                                <input type="hidden" name="tanggal1" value="<?= $dariTanggal; ?>">
                                <input type="hidden" name="tanggal2" value="<?= $sampaiTanggal; ?>">

                                <button type="submit" name="simpan_edit_data" class="form-control btn-success"> <span class="glyphicon glyphicon-floppy-disk"></span> Simpan </button>
                            </div>
                        </div>

                        <div class="col-sm-2">
                            <div class="form-group">
                                <label style="color: white;"> </label>

                                <input type="hidden" name="data_id_siswa" value="<?= $id_siswa; ?>">
                                <input type="hidden" name="data_nis_siswa" value="<?= $nis; ?>">
                                <input type="hidden" name="data_nama_siswa" value="<?= $namaSiswa; ?>">
                                <input type="hidden" name="data_kelas_siswa" value="<?= $kelas; ?>">
                                <input type="hidden" name="data_panggilan_siswa" value="<?= $panggilan; ?>">
                                
                                <input type="hidden" name="currentPage" value="<?= $currentPage; ?>">
                                <input type="hidden" name="currentFilter" value="<?= $typeFilter; ?>">

                                <input type="hidden" name="tanggal1" value="<?= $dariTanggal; ?>">
                                <input type="hidden" name="tanggal2" value="<?= $sampaiTanggal; ?>">

                                <button id="kembali_ke" type="submit" name="back_to_page" class="form-control btn-primary"> <span class="glyphicon glyphicon-log-out" id="cancel"> </span> Kembali </button>
                            </div>
                        </div>

                    </div>

                </div>
                
            </form>

        </div>

    <?php elseif($setSesiFormEdit == 2): ?>

        <?php  

            $setSesiJsFormatRupiah = 2;

        ?>

        <div class="box box-info">

            <form action="<?= $baseac; ?>editdata" method="POST">

                <div class="box-header with-border">
                    <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Form Edit Data Pembayaran </h3>
                </div>

                <div class="box-body">
                    
                    <div class="row">
                        <div class="col-sm-1">
                            <div class="form-group">
                                <label>INVOICE</label>
                                <input type="text" readonly="" class="form-control" id="idInvoice" value="<?= $idInvoice; ?>" name="idInvoice" />
                            </div>
                        </div>

                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>NIS</label>
                                <input type="text" class="form-control" id="nis_siswa" name="nis_siswa" value="<?= $nis; ?>" readonly="" />
                            </div>
                        </div>

                        <div class="col-sm-5">
                            <div class="form-group">
                                <label>NAMA</label>
                                <input type="text" class="form-control" id="nama_siswa" readonly="" value="<?= $namaSiswa; ?>" name="nama_siswa" />
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>PANGGILAN</label>
                                <input type="text" class="form-control" id="panggilan_siswa" readonly="" value="<?= $panggilan; ?>" name="panggilan_siswa" />
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <div class="form-group">
                                <label>Kelas</label>
                                <input type="text" class="form-control" readonly="" id="kelas_siswa" value="<?= $kelas; ?>" name="kelas_siswa" />
                            </div>
                        </div>
                    </div> 

                    <div class="row">

                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>TANGGAL BAYAR</label>

                                <?php if ($tglPembayaran == '-'): ?>
                                    <input type="text" class="form-control" readonly="" name="tanggal_bukti_tf" value="<?= $tglPembayaran; ?>" id="tanggal_bukti_tf">
                                <?php else: ?>
                                    <input type="text" class="form-control" readonly="" name="tanggal_bukti_tf" value="<?= str_replace([' 00:00:00'], "", tglIndo($tglPembayaran)); ?>" id="tanggal_bukti_tf">
                                <?php endif ?>
                                
                            </div>
                        </div>
                        
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>BULAN PEMBAYARAN</label>
                                <input type="text" class="form-control" readonly="" name="pembayaranBulan" value="<?= $pembayaranBulan; ?>" id="pembayaranBulan">
                            </div>
                        </div>

                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>TAHUN</label>
                                <input type="text" name="isi_tahun" readonly="" id="isi_tahun" value="<?= $tahunBayar; ?>" class="form-control">
                            </div>
                        </div>

                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>TX</label>
                                <input type="text" name="tx" readonly="" id="tx" value="<?= $pembayaranVIA; ?>" class="form-control">
                            </div>
                        </div>

                    </div>

                </div>

                <div class="flex-containers">

                    <div>

                        <?php if ($typeFilter == 'SPP'): ?>
                            
                            <div class="row">
                                <div class="form-group" style="margin-left: 15px;">
                                    <label style="margin-right: 215px;"> UANG SPP </label>
                                    <input type="text" id="rupiah_spp_edit" class="uang_spp" name="nominal_spp_edit" value="<?= rupiahFormatInput($queryUangSPP); ?>" readonly>

                                    <?php if ($ketUangSPP == NULL): ?>
                                        <input type="text" class="ket_uang_spp" id="ket_uang_spp" name="ket_uang_spp_edit" placeholder="Keterangan">
                                    <?php else: ?>
                                        <input type="text" class="ket_uang_spp" id="ket_uang_spp" name="ket_uang_spp_edit" readonly value="<?= ($ketUangSPP); ?>" placeholder="Keterangan">
                                    <?php endif ?>
                                    
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group" style="margin-left: 15px;">
                                    <label style="margin-right: 175px;"> UANG PANGKAL </label>

                                    <?php if ($queryUangPangkal == 0): ?>
                                        <input type="text" id="rupiah_pangkal_edit" name="nominal_pangkal_edit" class="uang_pangkal" value="0">
                                    <?php else: ?>
                                        <input type="text" id="rupiah_pangkal_edit" name="nominal_pangkal_edit" readonly="" class="uang_pangkal" value="<?= rupiahFormatInput($queryUangPangkal); ?>">
                                    <?php endif ?>
                                    
                                    <?php if ($ketUangPangkal == NULL): ?>
                                        <input type="text" class="ket_uang_pangkal" name="ket_uang_pangkal_edit" placeholder="Keterangan">
                                    <?php else: ?>
                                        <input type="text" class="ket_uang_pangkal" name="ket_uang_pangkal_edit" readonly="" value="<?= ($ketUangPangkal); ?>">
                                    <?php endif ?>

                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group" style="margin-left: 15px;">
                                    <label style="margin-right: 173px;"> UANG KEGIATAN </label>

                                    <?php if ($queryUangKegiatan == 0): ?>
                                        <input type="text" id="rupiah_kegiatan_edit" class="uang_kegiatan" name="nominal_kegiatan_edit" value="0">
                                    <?php else: ?>
                                        <input type="text" id="rupiah_kegiatan_edit" class="uang_kegiatan" readonly="" name="nominal_kegiatan_edit" value="<?= rupiahFormatInput($queryUangKegiatan); ?>">
                                    <?php endif ?>

                                    <?php if ($ketUangKegiatan == NULL): ?>
                                        <input type="text" class="ket_uang_kegiatan" name="ket_uang_kegiatan_edit" placeholder="Keterangan">
                                    <?php else: ?>
                                        <input type="text" class="ket_uang_kegiatan" name="ket_uang_kegiatan_edit" readonly="" value="<?= ($ketUangKegiatan); ?>">
                                    <?php endif ?>

                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group" style="margin-left: 15px;">
                                    <label style="margin-right: 204px;"> UANG BUKU </label>

                                    <?php if ($queryUangBuku == 0): ?>
                                        <input type="text" id="rupiah_buku_edit" name="nominal_buku_edit" class="uang_buku" value="0">
                                    <?php else: ?>
                                        <input type="text" id="rupiah_buku_edit" readonly="" name="nominal_buku_edit" class="uang_buku" value="<?= rupiahFormatInput($queryUangBuku); ?>">
                                    <?php endif ?>

                                    <?php if ($ketUangBuku == NULL): ?>
                                        <input type="text" class="ket_uang_buku" name="ket_uang_buku_edit" placeholder="Keterangan">
                                    <?php else: ?>
                                        <input type="text" class="ket_uang_buku" readonly="" name="ket_uang_buku_edit" value="<?= ($ketUangBuku); ?>">
                                    <?php endif ?>

                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group" style="margin-left: 15px;">
                                    <label style="margin-right: 172px;"> UANG SERAGAM </label>

                                    <?php if ($queryUangSeragam == 0): ?>
                                        <input type="text" id="rupiah_seragam_edit" name="nominal_seragam_edit" class="uang_seragam" value="0">
                                    <?php else: ?>
                                        <input type="text" id="rupiah_seragam_edit" readonly="" name="nominal_seragam_edit" class="uang_seragam" value="<?= rupiahFormatInput($queryUangSeragam); ?>">
                                    <?php endif ?>

                                    <?php if ($ketUangSeragam == NULL): ?>
                                        <input type="text" class="ket_uang_seragam" name="ket_uang_seragam_edit" placeholder="Keterangan">
                                    <?php else: ?>
                                        <input type="text" class="ket_uang_seragam" readonly="" name="ket_uang_seragam_edit" value="<?= ($ketUangSeragam); ?>">
                                    <?php endif ?>

                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group" style="margin-left: 15px;">
                                    <label style="margin-right: 71px;"> UANG REGISTRASI/Daftar Ulang </label>

                                    <?php if ($queryUangRegis == 0): ?>
                                        <input type="text" id="rupiah_regis_edit" name="nominal_regis_edit" class="uang_regis" value="0">
                                    <?php else: ?>
                                        <input type="text" id="rupiah_regis_edit" readonly="" name="nominal_regis_edit" readonly="" class="uang_regis" value="<?= rupiahFormatInput($queryUangRegis); ?>">
                                    <?php endif ?>

                                    <?php if ($ketUangRegis == NULL): ?>
                                        <input type="text" class="ket_uang_regis" name="ket_uang_regis_edit" placeholder="Keterangan">
                                    <?php else: ?>
                                        <input type="text" class="ket_uang_regis" readonly="" name="ket_uang_regis_edit" readonly="" value="<?= ($ketUangRegis); ?>">
                                    <?php endif ?>

                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group" style="margin-left: 15px;">
                                    <label style="margin-right: 26px;"> LAIN<sup style="font-size: 10px;">2</sup>/INFAQ/Sumbangan/Antar Jemput </label>

                                    <?php if ($queryUangLain == 0): ?>
                                        <input type="text" id="rupiah_lain_edit" name="nominal_lain_edit" class="lain2" value="0">
                                    <?php else: ?>
                                        <input type="text" id="rupiah_lain_edit" name="nominal_lain_edit" readonly="" class="lain2" value="<?= rupiahFormatInput($queryUangLain); ?>">
                                    <?php endif ?>

                                    <?php if ($ketUangLain == NULL): ?>
                                        <input type="text" class="ket_lain2" name="ket_uang_lain2_edit" placeholder="Keterangan">
                                    <?php else: ?>
                                        <input type="text" class="ket_lain2" name="ket_uang_lain2_edit" readonly="" value="<?= ($ketUangLain); ?>">
                                    <?php endif ?>

                                </div>
                            </div>

                        <?php elseif($typeFilter == 'PANGKAL'): ?>
                            
                            <div class="row">
                                <div class="form-group" style="margin-left: 15px;">
                                    <label style="margin-right: 215px;"> UANG SPP </label>

                                    <?php if ($queryUangSPP == 0): ?>
                                        <input type="text" id="rupiah_spp_edit" class="uang_spp" name="nominal_spp_edit" value="0">
                                    <?php else: ?>
                                        <input type="text" id="rupiah_spp_edit" class="uang_spp" name="nominal_spp_edit" readonly="" value="<?= rupiahFormatInput($queryUangSPP); ?>">
                                    <?php endif ?>

                                    <?php if ($ketUangSPP == NULL): ?>
                                        <input type="text" class="ket_uang_spp" id="ket_uang_spp" name="ket_uang_spp_edit" placeholder="Keterangan">
                                    <?php else: ?>
                                        <input type="text" class="ket_uang_spp" id="ket_uang_spp" name="ket_uang_spp_edit" readonly value="<?= ($ketUangSPP); ?>" placeholder="Keterangan">
                                    <?php endif ?>

                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group" style="margin-left: 15px;">
                                    <label style="margin-right: 175px;"> UANG PANGKAL </label>

                                    <input type="text" id="rupiah_pangkal_edit" name="nominal_pangkal_edit" readonly="" class="uang_pangkal" value="<?= rupiahFormatInput($queryUangPangkal); ?>">

                                    <?php if ($ketUangPangkal == null): ?>
                                        <input type="text" class="ket_uang_pangkal" name="ket_uang_pangkal_edit" placeholder="Keterangan">
                                    <?php else: ?>
                                        <input type="text" class="ket_uang_pangkal" name="ket_uang_pangkal_edit" readonly="" value="<?= ($ketUangPangkal); ?>">
                                    <?php endif ?>
                                    

                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group" style="margin-left: 15px;">
                                    <label style="margin-right: 173px;"> UANG KEGIATAN </label>

                                    <?php if ($queryUangKegiatan == 0): ?>
                                        <input type="text" id="rupiah_kegiatan_edit" class="uang_kegiatan" name="nominal_kegiatan_edit" value="0">
                                    <?php else: ?>
                                        <input type="text" id="rupiah_kegiatan_edit" class="uang_kegiatan" readonly="" name="nominal_kegiatan_edit" value="<?= rupiahFormatInput($queryUangKegiatan); ?>">
                                    <?php endif ?>

                                    <?php if ($ketUangKegiatan == NULL): ?>
                                        <input type="text" class="ket_uang_kegiatan" name="ket_uang_kegiatan_edit" placeholder="Keterangan">
                                    <?php else: ?>
                                        <input type="text" class="ket_uang_kegiatan" name="ket_uang_kegiatan_edit" readonly="" value="<?= ($ketUangKegiatan); ?>">
                                    <?php endif ?>

                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group" style="margin-left: 15px;">
                                    <label style="margin-right: 204px;"> UANG BUKU </label>

                                    <?php if ($queryUangBuku == 0): ?>
                                        <input type="text" id="rupiah_buku_edit" name="nominal_buku_edit" class="uang_buku" value="0">
                                    <?php else: ?>
                                        <input type="text" id="rupiah_buku_edit" readonly="" name="nominal_buku_edit" class="uang_buku" value="<?= rupiahFormatInput($queryUangBuku); ?>">
                                    <?php endif ?>

                                    <?php if ($ketUangBuku == NULL): ?>
                                        <input type="text" class="ket_uang_buku" name="ket_uang_buku_edit" placeholder="Keterangan">
                                    <?php else: ?>
                                        <input type="text" class="ket_uang_buku" readonly="" name="ket_uang_buku_edit" value="<?= ($ketUangBuku); ?>">
                                    <?php endif ?>

                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group" style="margin-left: 15px;">
                                    <label style="margin-right: 172px;"> UANG SERAGAM </label>

                                    <?php if ($queryUangSeragam == 0): ?>
                                        <input type="text" id="rupiah_seragam_edit" name="nominal_seragam_edit" class="uang_seragam" value="0">
                                    <?php else: ?>
                                        <input type="text" id="rupiah_seragam_edit" readonly="" name="nominal_seragam_edit" class="uang_seragam" value="<?= rupiahFormatInput($queryUangSeragam); ?>">
                                    <?php endif ?>

                                    <?php if ($ketUangSeragam == NULL): ?>
                                        <input type="text" class="ket_uang_seragam" name="ket_uang_seragam_edit" placeholder="Keterangan">
                                    <?php else: ?>
                                        <input type="text" class="ket_uang_seragam" readonly="" name="ket_uang_seragam_edit" value="<?= ($ketUangSeragam); ?>">
                                    <?php endif ?>

                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group" style="margin-left: 15px;">
                                    <label style="margin-right: 71px;"> UANG REGISTRASI/Daftar Ulang </label>

                                    <?php if ($queryUangRegis == 0): ?>
                                        <input type="text" id="rupiah_regis_edit" name="nominal_regis_edit" class="uang_regis" value="0">
                                    <?php else: ?>
                                        <input type="text" id="rupiah_regis_edit" readonly="" name="nominal_regis_edit" readonly="" class="uang_regis" value="<?= rupiahFormatInput($queryUangRegis); ?>">
                                    <?php endif ?>

                                    <?php if ($ketUangRegis == NULL): ?>
                                        <input type="text" class="ket_uang_regis" name="ket_uang_regis_edit" placeholder="Keterangan">
                                    <?php else: ?>
                                        <input type="text" class="ket_uang_regis" readonly="" name="ket_uang_regis_edit" readonly="" value="<?= ($ketUangRegis); ?>">
                                    <?php endif ?>

                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group" style="margin-left: 15px;">
                                    <label style="margin-right: 26px;"> LAIN<sup style="font-size: 10px;">2</sup>/INFAQ/Sumbangan/Antar Jemput </label>

                                    <?php if ($queryUangLain == 0): ?>
                                        <input type="text" id="rupiah_lain_edit" name="nominal_lain_edit" class="lain2" value="0">
                                    <?php else: ?>
                                        <input type="text" id="rupiah_lain_edit" name="nominal_lain_edit" readonly="" class="lain2" value="<?= rupiahFormatInput($queryUangLain); ?>">
                                    <?php endif ?>

                                    <?php if ($ketUangLain == NULL): ?>
                                        <input type="text" class="ket_lain2" name="ket_uang_lain2_edit" placeholder="Keterangan">
                                    <?php else: ?>
                                        <input type="text" class="ket_lain2" name="ket_uang_lain2_edit" readonly="" value="<?= ($ketUangLain); ?>">
                                    <?php endif ?>

                                </div>
                            </div>

                        <?php elseif($typeFilter == 'KEGIATAN'): ?>

                            <div class="row">
                                <div class="form-group" style="margin-left: 15px;">
                                    <label style="margin-right: 215px;"> UANG SPP </label>

                                    <?php if ($queryUangSPP == 0): ?>
                                        <input type="text" id="rupiah_spp_edit" class="uang_spp" name="nominal_spp_edit" value="0">
                                    <?php else: ?>
                                        <input type="text" id="rupiah_spp_edit" class="uang_spp" name="nominal_spp_edit" readonly="" value="<?= rupiahFormatInput($queryUangSPP); ?>">
                                    <?php endif ?>

                                    <?php if ($ketUangSPP == NULL): ?>
                                        <input type="text" class="ket_uang_spp" id="ket_uang_spp" name="ket_uang_spp_edit" placeholder="Keterangan">
                                    <?php else: ?>
                                        <input type="text" class="ket_uang_spp" id="ket_uang_spp" name="ket_uang_spp_edit" readonly value="<?= ($ketUangSPP); ?>" placeholder="Keterangan">
                                    <?php endif ?>

                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group" style="margin-left: 15px;">
                                    <label style="margin-right: 175px;"> UANG PANGKAL </label>

                                    <?php if ($queryUangPangkal == 0): ?>
                                        <input type="text" id="rupiah_pangkal_edit" name="nominal_pangkal_edit" class="uang_pangkal" value="0">
                                    <?php else: ?>
                                        <input type="text" id="rupiah_pangkal_edit" name="nominal_pangkal_edit" readonly="" class="uang_pangkal" value="<?= rupiahFormatInput($queryUangPangkal); ?>">
                                    <?php endif ?>
                                    
                                    <?php if ($ketUangPangkal == NULL): ?>
                                        <input type="text" class="ket_uang_pangkal" name="ket_uang_pangkal_edit" placeholder="Keterangan">
                                    <?php else: ?>
                                        <input type="text" class="ket_uang_pangkal" name="ket_uang_pangkal_edit" readonly="" value="<?= ($ketUangPangkal); ?>">
                                    <?php endif ?>
                                    

                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group" style="margin-left: 15px;">
                                    <label style="margin-right: 173px;"> UANG KEGIATAN </label>

                                    <input type="text" id="rupiah_kegiatan_edit" class="uang_kegiatan" readonly="" name="nominal_kegiatan_edit" value="<?= rupiahFormatInput($queryUangKegiatan); ?>">

                                    <?php if ($ketUangKegiatan == NULL): ?>
                                        <input type="text" class="ket_uang_kegiatan" name="ket_uang_kegiatan_edit" placeholder="Keterangan">
                                    <?php else: ?>
                                        <input type="text" class="ket_uang_kegiatan" name="ket_uang_kegiatan_edit" readonly="" value="<?= ($ketUangKegiatan); ?>">
                                    <?php endif ?>

                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group" style="margin-left: 15px;">
                                    <label style="margin-right: 204px;"> UANG BUKU </label>

                                    <?php if ($queryUangBuku == 0): ?>
                                        <input type="text" id="rupiah_buku_edit" name="nominal_buku_edit" class="uang_buku" value="0">
                                    <?php else: ?>
                                        <input type="text" id="rupiah_buku_edit" readonly="" name="nominal_buku_edit" class="uang_buku" value="<?= rupiahFormatInput($queryUangBuku); ?>">
                                    <?php endif ?>

                                    <?php if ($ketUangBuku == NULL): ?>
                                        <input type="text" class="ket_uang_buku" name="ket_uang_buku_edit" placeholder="Keterangan">
                                    <?php else: ?>
                                        <input type="text" class="ket_uang_buku" readonly="" name="ket_uang_buku_edit" value="<?= ($ketUangBuku); ?>">
                                    <?php endif ?>

                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group" style="margin-left: 15px;">
                                    <label style="margin-right: 172px;"> UANG SERAGAM </label>

                                    <?php if ($queryUangSeragam == 0): ?>
                                        <input type="text" id="rupiah_seragam_edit" name="nominal_seragam_edit" class="uang_seragam" value="0">
                                    <?php else: ?>
                                        <input type="text" id="rupiah_seragam_edit" readonly="" name="nominal_seragam_edit" class="uang_seragam" value="<?= rupiahFormatInput($queryUangSeragam); ?>">
                                    <?php endif ?>

                                    <?php if ($ketUangSeragam == NULL): ?>
                                        <input type="text" class="ket_uang_seragam" name="ket_uang_seragam_edit" placeholder="Keterangan">
                                    <?php else: ?>
                                        <input type="text" class="ket_uang_seragam" readonly="" name="ket_uang_seragam_edit" value="<?= ($ketUangSeragam); ?>">
                                    <?php endif ?>

                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group" style="margin-left: 15px;">
                                    <label style="margin-right: 71px;"> UANG REGISTRASI/Daftar Ulang </label>

                                    <?php if ($queryUangRegis == 0): ?>
                                        <input type="text" id="rupiah_regis_edit" name="nominal_regis_edit" class="uang_regis" value="0">
                                    <?php else: ?>
                                        <input type="text" id="rupiah_regis_edit" readonly="" name="nominal_regis_edit" readonly="" class="uang_regis" value="<?= rupiahFormatInput($queryUangRegis); ?>">
                                    <?php endif ?>

                                    <?php if ($ketUangRegis == NULL): ?>
                                        <input type="text" class="ket_uang_regis" name="ket_uang_regis_edit" placeholder="Keterangan">
                                    <?php else: ?>
                                        <input type="text" class="ket_uang_regis" readonly="" name="ket_uang_regis_edit" readonly="" value="<?= ($ketUangRegis); ?>">
                                    <?php endif ?>

                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group" style="margin-left: 15px;">
                                    <label style="margin-right: 26px;"> LAIN<sup style="font-size: 10px;">2</sup>/INFAQ/Sumbangan/Antar Jemput </label>

                                    <?php if ($queryUangLain == 0): ?>
                                        <input type="text" id="rupiah_lain_edit" name="nominal_lain_edit" class="lain2" value="0">
                                    <?php else: ?>
                                        <input type="text" id="rupiah_lain_edit" name="nominal_lain_edit" readonly="" class="lain2" value="<?= rupiahFormatInput($queryUangLain); ?>">
                                    <?php endif ?>

                                    <?php if ($ketUangLain == NULL): ?>
                                        <input type="text" class="ket_lain2" name="ket_uang_lain2_edit" placeholder="Keterangan">
                                    <?php else: ?>
                                        <input type="text" class="ket_lain2" name="ket_uang_lain2_edit" readonly="" value="<?= ($ketUangLain); ?>">
                                    <?php endif ?>

                                </div>
                            </div>

                        <?php elseif($typeFilter == 'BUKU'): ?>

                            <div class="row">
                                <div class="form-group" style="margin-left: 15px;">
                                    <label style="margin-right: 215px;"> UANG SPP </label>

                                    <?php if ($queryUangSPP == 0): ?>
                                        <input type="text" id="rupiah_spp_edit" class="uang_spp" name="nominal_spp_edit" value="0">
                                    <?php else: ?>
                                        <input type="text" id="rupiah_spp_edit" class="uang_spp" name="nominal_spp_edit" readonly="" value="<?= rupiahFormatInput($queryUangSPP); ?>">
                                    <?php endif ?>

                                    <?php if ($ketUangSPP == NULL): ?>
                                        <input type="text" class="ket_uang_spp" id="ket_uang_spp" name="ket_uang_spp_edit" placeholder="Keterangan">
                                    <?php else: ?>
                                        <input type="text" class="ket_uang_spp" id="ket_uang_spp" name="ket_uang_spp_edit" readonly value="<?= ($ketUangSPP); ?>" placeholder="Keterangan">
                                    <?php endif ?>

                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group" style="margin-left: 15px;">
                                    <label style="margin-right: 175px;"> UANG PANGKAL </label>

                                    <?php if ($queryUangPangkal == 0): ?>
                                        <input type="text" id="rupiah_pangkal_edit" name="nominal_pangkal_edit" class="uang_pangkal" value="0">
                                    <?php else: ?>
                                        <input type="text" id="rupiah_pangkal_edit" name="nominal_pangkal_edit" readonly="" class="uang_pangkal" value="<?= rupiahFormatInput($queryUangPangkal); ?>">
                                    <?php endif ?>
                                    
                                    <?php if ($ketUangPangkal == NULL): ?>
                                        <input type="text" class="ket_uang_pangkal" name="ket_uang_pangkal_edit" placeholder="Keterangan">
                                    <?php else: ?>
                                        <input type="text" class="ket_uang_pangkal" name="ket_uang_pangkal_edit" readonly="" value="<?= ($ketUangPangkal); ?>">
                                    <?php endif ?>
                                    

                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group" style="margin-left: 15px;">
                                    <label style="margin-right: 173px;"> UANG KEGIATAN </label>

                                    <?php if ($queryUangKegiatan == 0): ?>
                                        <input type="text" id="rupiah_kegiatan_edit" class="uang_kegiatan" name="nominal_kegiatan_edit" value="0">
                                    <?php else: ?>
                                        <input type="text" id="rupiah_kegiatan_edit" class="uang_kegiatan" readonly="" name="nominal_kegiatan_edit" value="<?= rupiahFormatInput($queryUangKegiatan); ?>">
                                    <?php endif ?>

                                    <?php if ($ketUangKegiatan == NULL): ?>
                                        <input type="text" class="ket_uang_kegiatan" name="ket_uang_kegiatan_edit" placeholder="Keterangan">
                                    <?php else: ?>
                                        <input type="text" class="ket_uang_kegiatan" name="ket_uang_kegiatan_edit" readonly="" value="<?= ($ketUangKegiatan); ?>">
                                    <?php endif ?>

                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group" style="margin-left: 15px;">
                                    <label style="margin-right: 204px;"> UANG BUKU </label>

                                    <input type="text" id="rupiah_buku_edit" readonly="" name="nominal_buku_edit" class="uang_buku" value="<?= rupiahFormatInput($queryUangBuku); ?>">

                                    <?php if ($ketUangBuku == NULL): ?>
                                        <input type="text" class="ket_uang_buku" name="ket_uang_buku_edit" placeholder="Keterangan">
                                    <?php else: ?>
                                        <input type="text" class="ket_uang_buku" readonly="" name="ket_uang_buku_edit" value="<?= $ketUangBuku; ?>">
                                    <?php endif ?>

                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group" style="margin-left: 15px;">
                                    <label style="margin-right: 172px;"> UANG SERAGAM </label>

                                    <?php if ($queryUangSeragam == 0): ?>
                                        <input type="text" id="rupiah_seragam_edit" name="nominal_seragam_edit" class="uang_seragam" value="0">
                                    <?php else: ?>
                                        <input type="text" id="rupiah_seragam_edit" readonly="" name="nominal_seragam_edit" class="uang_seragam" value="<?= rupiahFormatInput($queryUangSeragam); ?>">
                                    <?php endif ?>

                                    <?php if ($ketUangSeragam == NULL): ?>
                                        <input type="text" class="ket_uang_seragam" name="ket_uang_seragam_edit" placeholder="Keterangan">
                                    <?php else: ?>
                                        <input type="text" class="ket_uang_seragam" readonly="" name="ket_uang_seragam_edit" value="<?= ($ketUangSeragam); ?>">
                                    <?php endif ?>

                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group" style="margin-left: 15px;">
                                    <label style="margin-right: 71px;"> UANG REGISTRASI/Daftar Ulang </label>

                                    <?php if ($queryUangRegis == 0): ?>
                                        <input type="text" id="rupiah_regis_edit" name="nominal_regis_edit" class="uang_regis" value="0">
                                    <?php else: ?>
                                        <input type="text" id="rupiah_regis_edit" readonly="" name="nominal_regis_edit" readonly="" class="uang_regis" value="<?= rupiahFormatInput($queryUangRegis); ?>">
                                    <?php endif ?>

                                    <?php if ($ketUangRegis == NULL): ?>
                                        <input type="text" class="ket_uang_regis" name="ket_uang_regis_edit" placeholder="Keterangan">
                                    <?php else: ?>
                                        <input type="text" class="ket_uang_regis" readonly="" name="ket_uang_regis_edit" readonly="" value="<?= ($ketUangRegis); ?>">
                                    <?php endif ?>

                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group" style="margin-left: 15px;">
                                    <label style="margin-right: 26px;"> LAIN<sup style="font-size: 10px;">2</sup>/INFAQ/Sumbangan/Antar Jemput </label>

                                    <?php if ($queryUangLain == 0): ?>
                                        <input type="text" id="rupiah_lain_edit" name="nominal_lain_edit" class="lain2" value="0">
                                    <?php else: ?>
                                        <input type="text" id="rupiah_lain_edit" name="nominal_lain_edit" readonly="" class="lain2" value="<?= rupiahFormatInput($queryUangLain); ?>">
                                    <?php endif ?>

                                    <?php if ($ketUangLain == NULL): ?>
                                        <input type="text" class="ket_lain2" name="ket_uang_lain2_edit" placeholder="Keterangan">
                                    <?php else: ?>
                                        <input type="text" class="ket_lain2" name="ket_uang_lain2_edit" readonly="" value="<?= ($ketUangLain); ?>">
                                    <?php endif ?>

                                </div>
                            </div>

                        <?php elseif($typeFilter == 'SERAGAM'): ?>

                            <div class="row">
                                <div class="form-group" style="margin-left: 15px;">
                                    <label style="margin-right: 215px;"> UANG SPP </label>

                                    <?php if ($queryUangSPP == 0): ?>
                                        <input type="text" id="rupiah_spp_edit" class="uang_spp" name="nominal_spp_edit" value="0">
                                    <?php else: ?>
                                        <input type="text" id="rupiah_spp_edit" class="uang_spp" name="nominal_spp_edit" readonly="" value="<?= rupiahFormatInput($queryUangSPP); ?>">
                                    <?php endif ?>

                                    <?php if ($ketUangSPP == NULL): ?>
                                        <input type="text" class="ket_uang_spp" id="ket_uang_spp" name="ket_uang_spp_edit" placeholder="Keterangan">
                                    <?php else: ?>
                                        <input type="text" class="ket_uang_spp" id="ket_uang_spp" name="ket_uang_spp_edit" readonly value="<?= ($ketUangSPP); ?>" placeholder="Keterangan">
                                    <?php endif ?>

                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group" style="margin-left: 15px;">
                                    <label style="margin-right: 175px;"> UANG PANGKAL </label>

                                    <?php if ($queryUangPangkal == 0): ?>
                                        <input type="text" id="rupiah_pangkal_edit" name="nominal_pangkal_edit" class="uang_pangkal" value="0">
                                    <?php else: ?>
                                        <input type="text" id="rupiah_pangkal_edit" name="nominal_pangkal_edit" readonly="" class="uang_pangkal" value="<?= rupiahFormatInput($queryUangPangkal); ?>">
                                    <?php endif ?>
                                    
                                    <?php if ($ketUangPangkal == NULL): ?>
                                        <input type="text" class="ket_uang_pangkal" name="ket_uang_pangkal_edit" placeholder="Keterangan">
                                    <?php else: ?>
                                        <input type="text" class="ket_uang_pangkal" name="ket_uang_pangkal_edit" readonly="" value="<?= ($ketUangPangkal); ?>">
                                    <?php endif ?>
                                    

                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group" style="margin-left: 15px;">
                                    <label style="margin-right: 173px;"> UANG KEGIATAN </label>

                                    <?php if ($queryUangKegiatan == 0): ?>
                                        <input type="text" id="rupiah_kegiatan_edit" class="uang_kegiatan" name="nominal_kegiatan_edit" value="0">
                                    <?php else: ?>
                                        <input type="text" id="rupiah_kegiatan_edit" class="uang_kegiatan" readonly="" name="nominal_kegiatan_edit" value="<?= rupiahFormatInput($queryUangKegiatan); ?>">
                                    <?php endif ?>

                                    <?php if ($ketUangKegiatan == NULL): ?>
                                        <input type="text" class="ket_uang_kegiatan" name="ket_uang_kegiatan_edit" placeholder="Keterangan">
                                    <?php else: ?>
                                        <input type="text" class="ket_uang_kegiatan" name="ket_uang_kegiatan_edit" readonly="" value="<?= ($ketUangKegiatan); ?>">
                                    <?php endif ?>

                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group" style="margin-left: 15px;">
                                    <label style="margin-right: 204px;"> UANG BUKU </label>

                                    <?php if ($queryUangBuku == 0): ?>
                                        <input type="text" id="rupiah_buku_edit" name="nominal_buku_edit" class="uang_buku" value="0">
                                    <?php else: ?>
                                        <input type="text" id="rupiah_buku_edit" readonly="" name="nominal_buku_edit" class="uang_buku" value="<?= rupiahFormatInput($queryUangBuku); ?>">
                                    <?php endif ?>

                                    <?php if ($ketUangBuku == NULL): ?>
                                        <input type="text" class="ket_uang_buku" name="ket_uang_buku_edit" placeholder="Keterangan">
                                    <?php else: ?>
                                        <input type="text" class="ket_uang_buku" readonly="" name="ket_uang_buku_edit" value="<?= ($ketUangBuku); ?>">
                                    <?php endif ?>

                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group" style="margin-left: 15px;">
                                    <label style="margin-right: 172px;"> UANG SERAGAM </label>

                                    <input type="text" id="rupiah_seragam_edit" readonly="" name="nominal_seragam_edit" class="uang_seragam" value="<?= rupiahFormatInput($queryUangSeragam); ?>">

                                    <?php if ($ketUangSeragam == NULL): ?>
                                        <input type="text" class="ket_uang_seragam" name="ket_uang_seragam_edit" placeholder="Keterangan">
                                    <?php else: ?>
                                        <input type="text" class="ket_uang_seragam" readonly="" name="ket_uang_seragam_edit" value="<?= ($ketUangSeragam); ?>">
                                    <?php endif ?>

                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group" style="margin-left: 15px;">
                                    <label style="margin-right: 71px;"> UANG REGISTRASI/Daftar Ulang </label>

                                    <?php if ($queryUangRegis == 0): ?>
                                        <input type="text" id="rupiah_regis_edit" name="nominal_regis_edit" class="uang_regis" value="0">
                                    <?php else: ?>
                                        <input type="text" id="rupiah_regis_edit" readonly="" name="nominal_regis_edit" readonly="" class="uang_regis" value="<?= rupiahFormatInput($queryUangRegis); ?>">
                                    <?php endif ?>

                                    <?php if ($ketUangRegis == NULL): ?>
                                        <input type="text" class="ket_uang_regis" name="ket_uang_regis_edit" placeholder="Keterangan">
                                    <?php else: ?>
                                        <input type="text" class="ket_uang_regis" readonly="" name="ket_uang_regis_edit" readonly="" value="<?= ($ketUangRegis); ?>">
                                    <?php endif ?>

                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group" style="margin-left: 15px;">
                                    <label style="margin-right: 26px;"> LAIN<sup style="font-size: 10px;">2</sup>/INFAQ/Sumbangan/Antar Jemput </label>

                                    <?php if ($queryUangLain == 0): ?>
                                        <input type="text" id="rupiah_lain_edit" name="nominal_lain_edit" class="lain2" value="0">
                                    <?php else: ?>
                                        <input type="text" id="rupiah_lain_edit" name="nominal_lain_edit" readonly="" class="lain2" value="<?= rupiahFormatInput($queryUangLain); ?>">
                                    <?php endif ?>

                                    <?php if ($ketUangLain == NULL): ?>
                                        <input type="text" class="ket_lain2" name="ket_uang_lain2_edit" placeholder="Keterangan">
                                    <?php else: ?>
                                        <input type="text" class="ket_lain2" name="ket_uang_lain2_edit" readonly="" value="<?= ($ketUangLain); ?>">
                                    <?php endif ?>

                                </div>
                            </div>

                        <?php elseif($typeFilter == 'REGISTRASI'): ?>

                            <div class="row">
                                <div class="form-group" style="margin-left: 15px;">
                                    <label style="margin-right: 215px;"> UANG SPP </label>

                                    <?php if ($queryUangSPP == 0): ?>
                                        <input type="text" id="rupiah_spp_edit" class="uang_spp" name="nominal_spp_edit" value="0">
                                    <?php else: ?>
                                        <input type="text" id="rupiah_spp_edit" class="uang_spp" name="nominal_spp_edit" readonly="" value="<?= rupiahFormatInput($queryUangSPP); ?>">
                                    <?php endif ?>

                                    <?php if ($ketUangSPP == NULL): ?>
                                        <input type="text" class="ket_uang_spp" id="ket_uang_spp" name="ket_uang_spp_edit" placeholder="Keterangan">
                                    <?php else: ?>
                                        <input type="text" class="ket_uang_spp" id="ket_uang_spp" name="ket_uang_spp_edit" readonly value="<?= ($ketUangSPP); ?>" placeholder="Keterangan">
                                    <?php endif ?>

                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group" style="margin-left: 15px;">
                                    <label style="margin-right: 175px;"> UANG PANGKAL </label>

                                    <?php if ($queryUangPangkal == 0): ?>
                                        <input type="text" id="rupiah_pangkal_edit" name="nominal_pangkal_edit" class="uang_pangkal" value="0">
                                    <?php else: ?>
                                        <input type="text" id="rupiah_pangkal_edit" name="nominal_pangkal_edit" readonly="" class="uang_pangkal" value="<?= rupiahFormatInput($queryUangPangkal); ?>">
                                    <?php endif ?>
                                    
                                    <?php if ($ketUangPangkal == NULL): ?>
                                        <input type="text" class="ket_uang_pangkal" name="ket_uang_pangkal_edit" placeholder="Keterangan">
                                    <?php else: ?>
                                        <input type="text" class="ket_uang_pangkal" name="ket_uang_pangkal_edit" readonly="" value="<?= ($ketUangPangkal); ?>">
                                    <?php endif ?>
                                    

                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group" style="margin-left: 15px;">
                                    <label style="margin-right: 173px;"> UANG KEGIATAN </label>

                                    <?php if ($queryUangKegiatan == 0): ?>
                                        <input type="text" id="rupiah_kegiatan_edit" class="uang_kegiatan" name="nominal_kegiatan_edit" value="0">
                                    <?php else: ?>
                                        <input type="text" id="rupiah_kegiatan_edit" class="uang_kegiatan" readonly="" name="nominal_kegiatan_edit" value="<?= rupiahFormatInput($queryUangKegiatan); ?>">
                                    <?php endif ?>

                                    <?php if ($ketUangKegiatan == NULL): ?>
                                        <input type="text" class="ket_uang_kegiatan" name="ket_uang_kegiatan_edit" placeholder="Keterangan">
                                    <?php else: ?>
                                        <input type="text" class="ket_uang_kegiatan" name="ket_uang_kegiatan_edit" readonly="" value="<?= ($ketUangKegiatan); ?>">
                                    <?php endif ?>

                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group" style="margin-left: 15px;">
                                    <label style="margin-right: 204px;"> UANG BUKU </label>

                                    <?php if ($queryUangBuku == 0): ?>
                                        <input type="text" id="rupiah_buku_edit" name="nominal_buku_edit" class="uang_buku" value="0">
                                    <?php else: ?>
                                        <input type="text" id="rupiah_buku_edit" readonly="" name="nominal_buku_edit" class="uang_buku" value="<?= rupiahFormatInput($queryUangBuku); ?>">
                                    <?php endif ?>

                                    <?php if ($ketUangBuku == NULL): ?>
                                        <input type="text" class="ket_uang_buku" name="ket_uang_buku_edit" placeholder="Keterangan">
                                    <?php else: ?>
                                        <input type="text" class="ket_uang_buku" readonly="" name="ket_uang_buku_edit" value="<?= ($ketUangBuku); ?>">
                                    <?php endif ?>

                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group" style="margin-left: 15px;">
                                    <label style="margin-right: 172px;"> UANG SERAGAM </label>

                                    <?php if ($queryUangSeragam == 0): ?>
                                        <input type="text" id="rupiah_seragam_edit" name="nominal_seragam_edit" class="uang_seragam" value="0">
                                    <?php else: ?>
                                        <input type="text" id="rupiah_seragam_edit" readonly="" name="nominal_seragam_edit" class="uang_seragam" value="<?= rupiahFormatInput($queryUangSeragam); ?>">
                                    <?php endif ?>

                                    <?php if ($ketUangSeragam == NULL): ?>
                                        <input type="text" class="ket_uang_seragam" name="ket_uang_seragam_edit" placeholder="Keterangan">
                                    <?php else: ?>
                                        <input type="text" class="ket_uang_seragam" readonly="" name="ket_uang_seragam_edit" value="<?= ($ketUangSeragam); ?>">
                                    <?php endif ?>

                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group" style="margin-left: 15px;">
                                    <label style="margin-right: 71px;"> UANG REGISTRASI/Daftar Ulang </label>

                                    <input type="text" id="rupiah_regis_edit" readonly="" name="nominal_regis_edit" readonly="" class="uang_regis" value="<?= rupiahFormatInput($queryUangRegis); ?>">

                                    <?php if ($ketUangRegis == NULL): ?>
                                        <input type="text" class="ket_uang_regis" name="ket_uang_regis_edit" placeholder="Keterangan">
                                    <?php else: ?>
                                        <input type="text" class="ket_uang_regis" readonly="" name="ket_uang_regis_edit" readonly="" value="<?= ($ketUangRegis); ?>">
                                    <?php endif ?>

                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group" style="margin-left: 15px;">
                                    <label style="margin-right: 26px;"> LAIN<sup style="font-size: 10px;">2</sup>/INFAQ/Sumbangan/Antar Jemput </label>

                                    <?php if ($queryUangLain == 0): ?>
                                        <input type="text" id="rupiah_lain_edit" name="nominal_lain_edit" class="lain2" value="0">
                                    <?php else: ?>
                                        <input type="text" id="rupiah_lain_edit" name="nominal_lain_edit" readonly="" class="lain2" value="<?= rupiahFormatInput($queryUangLain); ?>">
                                    <?php endif ?>

                                    <?php if ($ketUangLain == NULL): ?>
                                        <input type="text" class="ket_lain2" name="ket_uang_lain2_edit" placeholder="Keterangan">
                                    <?php else: ?>
                                        <input type="text" class="ket_lain2" name="ket_uang_lain2_edit" readonly="" value="<?= ($ketUangLain); ?>">
                                    <?php endif ?>

                                </div>
                            </div>

                        <?php elseif($typeFilter == 'LAIN'): ?>

                            <div class="row">
                                <div class="form-group" style="margin-left: 15px;">
                                    <label style="margin-right: 215px;"> UANG SPP </label>

                                    <?php if ($queryUangSPP == 0): ?>
                                        <input type="text" id="rupiah_spp_edit" class="uang_spp" name="nominal_spp_edit" value="0">
                                    <?php else: ?>
                                        <input type="text" id="rupiah_spp_edit" class="uang_spp" name="nominal_spp_edit" readonly="" value="<?= rupiahFormatInput($queryUangSPP); ?>">
                                    <?php endif ?>

                                    <?php if ($ketUangSPP == NULL): ?>
                                        <input type="text" class="ket_uang_spp" id="ket_uang_spp" name="ket_uang_spp_edit" placeholder="Keterangan">
                                    <?php else: ?>
                                        <input type="text" class="ket_uang_spp" id="ket_uang_spp" name="ket_uang_spp_edit" readonly value="<?= ($ketUangSPP); ?>" placeholder="Keterangan">
                                    <?php endif ?>

                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group" style="margin-left: 15px;">
                                    <label style="margin-right: 175px;"> UANG PANGKAL </label>

                                    <?php if ($queryUangPangkal == 0): ?>
                                        <input type="text" id="rupiah_pangkal_edit" name="nominal_pangkal_edit" class="uang_pangkal" value="0">
                                    <?php else: ?>
                                        <input type="text" id="rupiah_pangkal_edit" name="nominal_pangkal_edit" readonly="" class="uang_pangkal" value="<?= rupiahFormatInput($queryUangPangkal); ?>">
                                    <?php endif ?>
                                    
                                    <?php if ($ketUangPangkal == NULL): ?>
                                        <input type="text" class="ket_uang_pangkal" name="ket_uang_pangkal_edit" placeholder="Keterangan">
                                    <?php else: ?>
                                        <input type="text" class="ket_uang_pangkal" name="ket_uang_pangkal_edit" readonly="" value="<?= ($ketUangPangkal); ?>">
                                    <?php endif ?>
                                    

                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group" style="margin-left: 15px;">
                                    <label style="margin-right: 173px;"> UANG KEGIATAN </label>

                                    <?php if ($queryUangKegiatan == 0): ?>
                                        <input type="text" id="rupiah_kegiatan_edit" class="uang_kegiatan" name="nominal_kegiatan_edit" value="0">
                                    <?php else: ?>
                                        <input type="text" id="rupiah_kegiatan_edit" class="uang_kegiatan" readonly="" name="nominal_kegiatan_edit" value="<?= rupiahFormatInput($queryUangKegiatan); ?>">
                                    <?php endif ?>

                                    <?php if ($ketUangKegiatan == NULL): ?>
                                        <input type="text" class="ket_uang_kegiatan" name="ket_uang_kegiatan_edit" placeholder="Keterangan">
                                    <?php else: ?>
                                        <input type="text" class="ket_uang_kegiatan" name="ket_uang_kegiatan_edit" readonly="" value="<?= ($ketUangKegiatan); ?>">
                                    <?php endif ?>

                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group" style="margin-left: 15px;">
                                    <label style="margin-right: 204px;"> UANG BUKU </label>

                                    <?php if ($queryUangBuku == 0): ?>
                                        <input type="text" id="rupiah_buku_edit" name="nominal_buku_edit" class="uang_buku" value="0">
                                    <?php else: ?>
                                        <input type="text" id="rupiah_buku_edit" readonly="" name="nominal_buku_edit" class="uang_buku" value="<?= rupiahFormatInput($queryUangBuku); ?>">
                                    <?php endif ?>

                                    <?php if ($ketUangBuku == NULL): ?>
                                        <input type="text" class="ket_uang_buku" name="ket_uang_buku_edit" placeholder="Keterangan">
                                    <?php else: ?>
                                        <input type="text" class="ket_uang_buku" readonly="" name="ket_uang_buku_edit" value="<?= ($ketUangBuku); ?>">
                                    <?php endif ?>

                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group" style="margin-left: 15px;">
                                    <label style="margin-right: 172px;"> UANG SERAGAM </label>

                                    <?php if ($queryUangSeragam == 0): ?>
                                        <input type="text" id="rupiah_seragam_edit" name="nominal_seragam_edit" class="uang_seragam" value="0">
                                    <?php else: ?>
                                        <input type="text" id="rupiah_seragam_edit" readonly="" name="nominal_seragam_edit" class="uang_seragam" value="<?= rupiahFormatInput($queryUangSeragam); ?>">
                                    <?php endif ?>

                                    <?php if ($ketUangSeragam == NULL): ?>
                                        <input type="text" class="ket_uang_seragam" name="ket_uang_seragam_edit" placeholder="Keterangan">
                                    <?php else: ?>
                                        <input type="text" class="ket_uang_seragam" readonly="" name="ket_uang_seragam_edit" value="<?= ($ketUangSeragam); ?>">
                                    <?php endif ?>

                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group" style="margin-left: 15px;">
                                    <label style="margin-right: 71px;"> UANG REGISTRASI/Daftar Ulang </label>

                                    <?php if ($queryUangRegis == 0): ?>
                                        <input type="text" id="rupiah_regis_edit" name="nominal_regis_edit" class="uang_regis" value="0">
                                    <?php else: ?>
                                        <input type="text" id="rupiah_regis_edit" readonly="" name="nominal_regis_edit" readonly="" class="uang_regis" value="<?= rupiahFormatInput($queryUangRegis); ?>">
                                    <?php endif ?>

                                    <?php if ($ketUangRegis == NULL): ?>
                                        <input type="text" class="ket_uang_regis" name="ket_uang_regis_edit" placeholder="Keterangan">
                                    <?php else: ?>
                                        <input type="text" class="ket_uang_regis" readonly="" name="ket_uang_regis_edit" readonly="" value="<?= ($ketUangRegis); ?>">
                                    <?php endif ?>

                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group" style="margin-left: 15px;">
                                    <label style="margin-right: 26px;"> LAIN<sup style="font-size: 10px;">2</sup>/INFAQ/Sumbangan/Antar Jemput </label>

                                    <input type="text" id="rupiah_lain_edit" name="nominal_lain_edit" readonly="" class="lain2" value="<?= rupiahFormatInput($queryUangLain); ?>">

                                    <?php if ($ketUangLain == NULL): ?>
                                        <input type="text" class="ket_lain2" name="ket_uang_lain2_edit" placeholder="Keterangan">
                                    <?php else: ?>
                                        <input type="text" class="ket_lain2" name="ket_uang_lain2_edit" readonly="" value="<?= ($ketUangLain); ?>">
                                    <?php endif ?>

                                </div>
                            </div>

                        <?php endif ?>

                        <div class="tombol">

                            <div class="form-group">

                                <label style="color: white;"> </label>

                                <input type="hidden" name="data_id_siswa" value="<?= $id_siswa; ?>">
                                <input type="hidden" name="data_nis_siswa" value="<?= $nis; ?>">
                                <input type="hidden" name="data_nama_siswa" value="<?= $namaSiswa; ?>">
                                <input type="hidden" name="data_kelas_siswa" value="<?= $kelas; ?>">
                                <input type="hidden" name="data_panggilan_siswa" value="<?= $panggilan; ?>">
                                
                                <input type="hidden" name="currentPage" value="<?= $currentPage; ?>">
                                <input type="hidden" name="currentFilter" value="<?= $typeFilter; ?>">

                                <input type="hidden" name="tanggal1" value="<?= $dariTanggal; ?>">
                                <input type="hidden" name="tanggal2" value="<?= $sampaiTanggal; ?>">
                                <input type="hidden" name="isi_filter_edit" value="<?= $typeFilter; ?>">

                                <button id="save_record" type="submit" name="simpan_tambah_edit" class="form-control btn-success"> <span class="glyphicon glyphicon-floppy-disk"> </span> Simpan </button>
                            
                            </div>

                            <div class="form-group">
                                
                                <label style="color: white;"> </label>

                                <input type="hidden" name="data_id_siswa" value="<?= $id_siswa; ?>">
                                <input type="hidden" name="data_nis_siswa" value="<?= $nis; ?>">
                                <input type="hidden" name="data_nama_siswa" value="<?= $namaSiswa; ?>">
                                <input type="hidden" name="data_kelas_siswa" value="<?= $kelas; ?>">
                                <input type="hidden" name="data_panggilan_siswa" value="<?= $panggilan; ?>">
                                
                                <input type="hidden" name="currentPage" value="<?= $currentPage; ?>">
                                <input type="hidden" name="currentFilter" value="<?= $typeFilter; ?>">

                                <input type="hidden" name="tanggal1" value="<?= $dariTanggal; ?>">
                                <input type="hidden" name="tanggal2" value="<?= $sampaiTanggal; ?>">
                                <input type="hidden" name="isi_filter_edit" value="<?= $typeFilter; ?>">

                                <button id="kembali_ke" type="submit" name="back_to_page" class="form-control btn-primary"> <span class="glyphicon glyphicon-log-out" id="cancel"> </span> Kembali </button>

                            </div>

                        </div>

                    </div>

                </div>

            </form>

        </div>

    <?php else: ?>

        <div class="box box-info">
            <div class="box-header with-border">

                <?php if ($isifilby == 'kosong'): ?>
                    <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Form Edit Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
                <?php else: ?>

                    <?php if ($isifilby == 'LAIN'): ?>
                        <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Form Edit Data Pembayaran LAIN - LAIN </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
                    <?php else: ?>
                        <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Form Edit Data Pembayaran <?= $isifilby; ?> </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
                    <?php endif ?>
                    
                <?php endif ?>
               
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
            <?php elseif($setSesiPageFilterBy == 3): ?>
                <?php require 'form_edit_pembayaran_kegiatan.php'; ?>
            <?php elseif($setSesiPageFilterBy == 4): ?>
                <?php require 'form_edit_pembayaran_buku.php'; ?>
            <?php elseif($setSesiPageFilterBy == 5): ?>
                <?php require 'form_edit_pembayaran_seragam.php'; ?>
            <?php elseif($setSesiPageFilterBy == 6): ?>
                <?php require 'form_edit_pembayaran_registrasi.php'; ?>
            <?php elseif($setSesiPageFilterBy == 7): ?>
                <?php require 'form_edit_pembayaran_lain.php'; ?>

            <!-- With Filter Date -->
            <?php elseif($setSesiPageFilterBy == 8): ?>
                <?php require 'form_edit_pembayaran_spp_with_date.php'; ?>
            <?php elseif($setSesiPageFilterBy == 9): ?>
                <?php require 'form_edit_pembayaran_pangkal_with_date.php'; ?>
            <?php elseif($setSesiPageFilterBy == 10): ?>
                <?php require 'form_edit_pembayaran_kegiatan_with_date.php'; ?>
            <?php elseif($setSesiPageFilterBy == 11): ?>
                <?php require 'form_edit_pembayaran_buku_with_date.php'; ?>
            <?php elseif($setSesiPageFilterBy == 12): ?>
                <?php require 'form_edit_pembayaran_seragam_with_date.php'; ?>
            <?php elseif($setSesiPageFilterBy == 13): ?>
                <?php require 'form_edit_pembayaran_registrasi_with_date.php'; ?>
            <?php elseif($setSesiPageFilterBy == 14): ?>
                <?php require 'form_edit_pembayaran_lain_with_date.php'; ?>
            <?php endif; ?>  

        </div>

    <?php endif ?>

    <?php echo "Tanggal Dari : " . $dariTanggal . "<br>" . "Tanggal Sampai : " . $sampaiTanggal . "<br>"; ?>
    <?php echo "Ini Sesi Form Edit Nomer " . $setSesiFormEdit . "<br> Ini Sesi Sesi Page Filter By " . $setSesiPageFilterBy; ?>

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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript">
	$(document).ready(function(){

        let timeIsOut = `<?= $timeIsOut; ?>`

        if (timeIsOut == 1) {

            const myTimeout = setTimeout(clearSession, 1000);

        }

        function clearSession() {
            alert('Sessi Habis')
            document.location.href = `<?= $base; ?>`
        }

		$("#list_spp").click();
	    $("#edit_data").css({
	        "background-color" : "#ccc",
	        "color" : "black"
	    });

        function redirectPage() {
            document.location.href = `<?= $baseac; ?>editdata`
        }

        $('#isi_tahun').keypress(function (e) {
            if (String.fromCharCode(e.keyCode).match(/[^0-9]/g)) return false;
        });

        let scrollNextPage        = `<?= $iniScrollNextPage; ?>`
        let scrollPreviousPage    = `<?= $iniScrollPreviousPage; ?>`
        let scrollToPage          = `<?= $iniScrollToPage; ?>`
        let scrollFirstPage       = `<?= $iniScrollFirstPage; ?>`
        let scrollLastPage        = `<?= $iniScrollLastPage; ?>`
        let scrollBackSave        = `<?= $iniScrollBackSave; ?>`
        let scrollBackPage        = `<?= $iniScrollBackPage; ?>`

        let setSesiJsFormatRupiah = `<?= $setSesiJsFormatRupiah; ?>`

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
            Swal.fire({
              title: 'Data Berhasil Di Update',
              icon: "success"
            });
            window.scroll({
              top: 550,
              behavior: 'smooth'
            });
        }

        if (scrollFirstPage == 'ada') {
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

        if (scrollBackPage == 'ada') {
            window.scroll({
              top: 550,
              behavior: 'smooth'
            });
        }

        if (setSesiJsFormatRupiah == 1) {

            let nominalBayar  = document.getElementById('nominalBayar')

            nominalBayar.addEventListener('keyup', function(e){
                // tambahkan 'Rp.' pada saat form di ketik
                // alert("ok")
                // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
                nominalBayar.value = formatRupiah(this.value, 'Rp. ');
            });

        } else if (setSesiJsFormatRupiah == 2) {
            /* Format Rupiah SPP */
            let rupiah_spp_edit        = document.getElementById('rupiah_spp_edit');
            let rupiah_pangkal_edit    = document.getElementById('rupiah_pangkal_edit');
            let rupiah_kegiatan_edit   = document.getElementById('rupiah_kegiatan_edit');
            let rupiah_buku_edit       = document.getElementById('rupiah_buku_edit');
            let rupiah_seragam_edit    = document.getElementById('rupiah_seragam_edit');
            let rupiah_regis_edit      = document.getElementById('rupiah_regis_edit');
            let rupiah_lain_edit       = document.getElementById('rupiah_lain_edit');

            rupiah_spp_edit.addEventListener('keyup', function(e){
                // tambahkan 'Rp.' pada saat form di ketik
                // alert("ok")
                // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
                rupiah_spp_edit.value = formatRupiah(this.value, 'Rp. ');
            });

            rupiah_pangkal_edit.addEventListener('keyup', function(e){
                // tambahkan 'Rp.' pada saat form di ketik
                // alert("ok")
                // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
                rupiah_pangkal_edit.value = formatRupiah(this.value, 'Rp. ');
            });

            rupiah_kegiatan_edit.addEventListener('keyup', function(e){
                // tambahkan 'Rp.' pada saat form di ketik
                // alert("ok")
                // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
                rupiah_kegiatan_edit.value = formatRupiah(this.value, 'Rp. ');
            });

            rupiah_buku_edit.addEventListener('keyup', function(e){
                // tambahkan 'Rp.' pada saat form di ketik
                // alert("ok")
                // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
                rupiah_buku_edit.value = formatRupiah(this.value, 'Rp. ');
            });

            rupiah_seragam_edit.addEventListener('keyup', function(e){
                // tambahkan 'Rp.' pada saat form di ketik
                // alert("ok")
                // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
                rupiah_seragam_edit.value = formatRupiah(this.value, 'Rp. ');
            });

            rupiah_regis_edit.addEventListener('keyup', function(e){
                // tambahkan 'Rp.' pada saat form di ketik
                // alert("ok")
                // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
                rupiah_regis_edit.value = formatRupiah(this.value, 'Rp. ');
            });

            rupiah_lain_edit.addEventListener('keyup', function(e){
                // tambahkan 'Rp.' pada saat form di ketik
                // alert("ok")
                // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
                rupiah_lain_edit.value = formatRupiah(this.value, 'Rp. ');
            });

        }

	})

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