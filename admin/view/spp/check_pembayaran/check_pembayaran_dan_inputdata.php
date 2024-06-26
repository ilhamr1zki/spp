<?php 

    $code_accounting = $_SESSION['c_accounting'];
    
    $dataBulan = [
        'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    ];

    $pwBuatBuDian = password_hash('dian', PASSWORD_DEFAULT);
    $pwBuatBuRani = password_hash('rani', PASSWORD_DEFAULT);

    // echo "Bu Dian : " . $pwBuatBuDian . "<br>" . "Bu Rani : " . $pwBuatBuRani;exit;

    $sqlGetUser         = "SELECT * FROM accounting WHERE username = 'rani' ";
    $execQueryGetUser   = mysqli_query($con, $sqlGetUser);

    $getData = mysqli_fetch_array($execQueryGetUser);

    $dataPassword = $getData['password'];

    function rupiah($angka){
    
        $hasil_rupiah = "Rp " . number_format($angka,2,',','.');
        return $hasil_rupiah;
     
    }

    $isifilby       = 'kosong';
    $tanggalDari    = 'kosong_tgl1';
    $tanggalSampai  = 'kosong_tgl2';

    // isi form default
    $id                 = "";
    $nis                = "";
    $namaSiswa          = "";
    $kelas              = "";
    $panggilan          = "";
    $checkFilterSiswa   = "";
    $hitungDataFilterSPPDate = 0;

    if ($code_accounting == 'accounting1') {

        if (isset($_POST['filter_by'])) {

            $id         = $_POST['id_siswa'];
            $nis        = $_POST['nis_siswa'];
            $namaSiswa  = $_POST['nama_siswa'];
            $kelas      = $_POST['kelas_siswa'];
            $panggilan  = $_POST['panggilan_siswa'];

            if ($id !== "" && $nis !== "") {
                // Jika ID & NIS pada form tidak kosong maka lanjut
                if ($_POST['isi_filter'] != 'kosong') {

                    $isifilby                   = $_POST['isi_filter'];
                    $tanggalDari                = $_POST['tanggal1'] . " dari";
                    $tanggalSampai              = $_POST['tanggal2'] . " sampai";
                    $checkFilterSiswa           = "adafilter";

                    if ($tanggalDari != ' dari' && $tanggalSampai == " sampai") {
                        $_SESSION['form_kosong']    = "hanya_tanggal_dari";
                    } else if ($tanggalDari == ' dari' && $tanggalSampai != " sampai") {
                        $_SESSION['form_kosong']    = "hanya_tanggal_sampai";
                    } else if ($_POST['tanggal1'] > $_POST['tanggal2']) {
                        $_SESSION['form_kosong']    = "tanggal_awal_lebih_besar";
                    } else {
                        $_SESSION['form_kosong']    = "form_not_empty";
                    }

                } else {
                    $isifilby;
                    $id                 = "";
                    $nis                = "";
                    $namaSiswa          = "";
                    $kelas              = "";
                    $panggilan          = "";
                    $checkFilterSiswa   = "tidakadafilter";
                    $iniScrollFilterPage    = "kosong";

                    $halamanAktif = 1;

                    $jumlahData = 5;
                    $queryGetAllDataHistori     = "SELECT * FROM input_data_sd";
                    $execQueryGetAllDataHistori = mysqli_query($con, $queryGetAllDataHistori);
                    $totalData = mysqli_num_rows($execQueryGetAllDataHistori);

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
                    $ambildata_perhalaman = mysqli_query($con, "SELECT * FROM input_data_sd LIMIT $dataAwal, $jumlahData  ");
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

                    $_SESSION['form_kosong'] = "filter_kosong";
                }

            } else {
                // Jika ID & NIS pada form kosong maka kembalikan pada halaman awal
                $_SESSION['form_kosong'] = "empty_form";
                // header("Location:/checkpembayaran");
            }
        }

    } else {

         if (isset($_POST['filter_by'])) {

            $id         = $_POST['id_siswa'];
            $nis        = $_POST['nis_siswa'];
            $namaSiswa  = $_POST['nama_siswa'];
            $kelas      = $_POST['kelas_siswa'];
            $panggilan  = $_POST['panggilan_siswa'];

            if ($id !== "" && $nis !== "") {
                // Jika ID & NIS pada form tidak kosong maka lanjut
                if ($_POST['isi_filter'] != 'kosong') {

                    $isifilby                   = $_POST['isi_filter'];
                    $tanggalDari                = $_POST['tanggal1'] . " dari";
                    $tanggalSampai              = $_POST['tanggal2'] . " sampai";
                    $checkFilterSiswa           = "adafilter";

                    if ($tanggalDari != ' dari' && $tanggalSampai == " sampai") {
                        $_SESSION['form_kosong']    = "hanya_tanggal_dari";
                    } else if ($tanggalDari == ' dari' && $tanggalSampai != " sampai") {
                        $_SESSION['form_kosong']    = "hanya_tanggal_sampai";
                    } else if ($_POST['tanggal1'] > $_POST['tanggal2']) {
                        $_SESSION['form_kosong']    = "tanggal_awal_lebih_besar";
                    } else {
                        $_SESSION['form_kosong']    = "form_not_empty";
                    }

                } else {
                    $isifilby;
                    $id                 = "";
                    $nis                = "";
                    $namaSiswa          = "";
                    $kelas              = "";
                    $panggilan          = "";
                    $checkFilterSiswa   = "tidakadafilter";
                    $iniScrollFilterPage    = "kosong";

                    $halamanAktif = 1;

                    $jumlahData = 5;
                    $queryGetAllDataHistori     = "SELECT * FROM input_data_tk";
                    $execQueryGetAllDataHistori = mysqli_query($con, $queryGetAllDataHistori);
                    $totalData = mysqli_num_rows($execQueryGetAllDataHistori);

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
                    $ambildata_perhalaman = mysqli_query($con, "SELECT * FROM input_data_tk LIMIT $dataAwal, $jumlahData  ");
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

                    $_SESSION['form_kosong'] = "filter_kosong";
                }

            } else {
                // Jika ID & NIS pada form kosong maka kembalikan pada halaman awal
                $_SESSION['form_kosong'] = "empty_form";
                // header("Location:/checkpembayaran");
            }
        }        

    }
    // echo $isifilby;exit;

    $cbfilter_by = [];

    $filter_by['isifilter_by'] = [
        'SEMUA',
        'SPP',
        'PANGKAL',
        'KEGIATAN',
        'BUKU',
        'SERAGAM',
        'REGISTRASI',
        'LAIN'
    ];

    $no = 1;
    $iniScrollNextPage      = "kosong";
    $iniScrollPreviousPage  = "kosong";
    $iniScrollFilterPage    = "kosong";


    if ($code_accounting == 'accounting1') {
        
        // histori input data sd
        $queryGetAllDataHistori     = "SELECT * FROM input_data_sd";
        $execQueryGetAllDataHistori = mysqli_query($con, $queryGetAllDataHistori);

        $halamanAktif = "";
        
        $jumlahData = 5;
        $totalData = mysqli_num_rows($execQueryGetAllDataHistori);

        $jumlahPagination = ceil($totalData / $jumlahData);
        // echo $jumlahPagination;

        if (isset($_POST['toPage'])) {
            // echo $_POST['teslg'];exit;
            $halamanAktif = $_POST['halamanKe'];
            $iniScrollNextPage = "ada";

            $totalHalamanTambah100 = $halamanAktif + 100;

            if ($totalHalamanTambah100 <= $jumlahPagination) {
                $showAddPage100 = "muncul";
            } else {
                $showAddPage100 = "tidak_muncul";
            }

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;
            // echo $dataAwal . "<br>";
            $ambildata_perhalaman = mysqli_query($con, "SELECT * FROM input_data_sd ORDER BY ID DESC LIMIT $dataAwal, $jumlahData  ");
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

        } else if (isset($_POST['nextPage'])) {

            $halamanAktif = $_POST['halamanLanjut'];
            $iniScrollNextPage = "ada";

            $totalHalamanTambah100 = $halamanAktif + 100;

            if ($totalHalamanTambah100 <= $jumlahPagination) {
                $showAddPage100 = "muncul";
            } else {
                $showAddPage100 = "tidak_muncul";
            }

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;
            // echo $dataAwal . "<br>";
            $ambildata_perhalaman = mysqli_query($con, "SELECT * FROM input_data_sd ORDER BY ID DESC LIMIT $dataAwal, $jumlahData  ");
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

        } else if (isset($_POST['previousPage'])) {

            $halamanAktif = $_POST['backPage'];
            $iniScrollPreviousPage  = "ada";

            $totalHalamanTambah100 = $halamanAktif + 100;

            if ($totalHalamanTambah100 <= $jumlahPagination) {
                $showAddPage100 = "muncul";
            } else {
                $showAddPage100 = "tidak_muncul";
            }

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;
            // echo $dataAwal . "<br>";
            $ambildata_perhalaman = mysqli_query($con, "SELECT * FROM input_data_sd ORDER BY ID DESC LIMIT $dataAwal, $jumlahData  ");
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

        } else if (isset($_POST['firstPage'])) {

            $halamanAktif = 1;
            $iniScrollPreviousPage  = "ada";

            $totalHalamanTambah100 = $halamanAktif + 100;

            if ($totalHalamanTambah100 <= $jumlahPagination) {
                $showAddPage100 = "muncul";
            } else {
                $showAddPage100 = "tidak_muncul";
            }

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;
            // echo $dataAwal . "<br>";
            $ambildata_perhalaman = mysqli_query($con, "SELECT * FROM input_data_sd ORDER BY ID DESC LIMIT $dataAwal, $jumlahData  ");
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

        } else if (isset($_POST['addPage100'])) {

            $halamanAktif = $_POST['paginationSekarangTambah100'] + 100;
            $iniScrollPreviousPage  = "ada";

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

        } else if (isset($_POST['reductionPage100'])) {

            $halamanAktif = $_POST['paginationSekarangKurang100'] - 100;

            $iniScrollPreviousPage = "ada";

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

        } else if (isset($_POST['nextLastPage'])) {

            $halamanAktif = $jumlahPagination;
            $iniScrollPreviousPage  = "ada";

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;
            // echo $dataAwal . "<br>";
            $ambildata_perhalaman = mysqli_query($con, "SELECT * FROM input_data_sd ORDER BY ID DESC LIMIT $dataAwal, $jumlahData  ");
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

        } else if (isset($_POST['filter_by'])) {
            
            $halamanAktif = 1;

            if ($_SESSION['form_kosong'] == 'form_not_empty') {
                $iniScrollFilterPage;
            } else if($_SESSION['form_kosong'] == 'filter_kosong') {
                $iniScrollFilterPage;
            } else if($_SESSION['form_kosong'] == 'empty_form') {
                $iniScrollFilterPage;
            } else if ($_SESSION['form_kosong'] == 'hanya_tanggal_dari') {         
                $iniScrollFilterPage;
            } else if ($_SESSION['form_kosong'] == 'hanya_tanggal_sampai') {         
                $iniScrollFilterPage;
            } else if($_SESSION['form_kosong'] == 'tanggal_awal_lebih_besar') {
                $iniScrollFilterPage;
            } else {
                $iniScrollFilterPage = "ada";
            }

            $hitungDataFilterSPP = "";

            if ($_POST['isi_filter'] != 'kosong' ) {
                $dariTanggal    = $_POST['tanggal1'] . " 00:00:00";
                $sampaiTanggal  = $_POST['tanggal2'] . " 23:59:59";
                
                // SPP
                if ($_POST['isi_filter'] == 'SPP') {

                    // Jika filter by SPP sedangkan filter tanggal dari dan tanggal sampai tidak di isi 
                    if ($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59") {

                        // Data SPP
                        // echo "Masuk filter SPP tanpa filter tanggal dari dan tanggal sampai";exit;
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

                    } else if ($dariTanggal != " 00:00:00" && $sampaiTanggal == " 23:59:59") {

                        $id                 = "";
                        $nis                = "";
                        $namaSiswa          = "";
                        $kelas              = "";
                        $panggilan          = "";

                        $isifilby           = "kosong";

                        $halamanAktif = 1;

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

                    } else if ($dariTanggal > $sampaiTanggal) {

                        $id                 = "";
                        $nis                = "";
                        $namaSiswa          = "";
                        $kelas              = "";
                        $panggilan          = "";

                        $isifilby           = "kosong";

                        $halamanAktif = 1;

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

                    } else if ($dariTanggal != " 00:00:00" && $sampaiTanggal != " 23:59:59") {

                        // echo "Masuk ke filter tanggal lengkap";

                        // Data Filter SPP dan tanggal Filter
                        // echo "Masuk ke filter tanggal " . $dariTanggal . " & " . $sampaiTanggal;
                        $namaMurid = $namaSiswa;

                        $tanggalDari    = $_POST['tanggal1'];
                        $tanggalSampai  = $_POST['tanggal2'];

                        $queryGetDataSPP = "
                            SELECT ID, NIS, NAMA, kelas, SPP, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                            FROM input_data_sd
                            WHERE
                            SPP != 0
                            AND NAMA LIKE '%$namaMurid%'
                            AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                        ";

                        $execQueryDataSPP    = mysqli_query($con, $queryGetDataSPP);
                        // $hitungDataFilterSPP = mysqli_num_rows($execQueryDataSPP);
                        $hitungDataFilterSPPDate = mysqli_num_rows($execQueryDataSPP);

                        $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

                        $ambildata_perhalaman = mysqli_query($con, "
                            SELECT ID, NIS, NAMA, DATE, kelas, SPP, TRANSAKSI, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                            FROM input_data_sd
                            WHERE
                            SPP != 0
                            AND NAMA LIKE '%$namaMurid%'
                            AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                            LIMIT $dataAwal, $jumlahData
                        ");

                        $jumlahPagination = ceil($hitungDataFilterSPPDate / $jumlahData);

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

                    } else if ($dariTanggal == " 00:00:00" && $sampaiTanggal != " 23:59:59") {

                        $id                 = "";
                        $nis                = "";
                        $namaSiswa          = "";
                        $kelas              = "";
                        $panggilan          = "";

                        $isifilby           = "kosong";

                        $halamanAktif = 1;

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
                }

                // PANGKAL
                else if ($_POST['isi_filter'] == 'PANGKAL') {

                    // echo "Pangkal";exit;
                    // Jika filter by SPP sedangkan filter tanggal dari dan tanggal sampai tidak di isi

                    if ($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59") {

                        // Data PANGKAL
                        // echo "Masuk filter PANGKAL tanpa filter tanggal dari dan tanggal sampai";exit;
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

                    } else if ($dariTanggal != " 00:00:00" && $sampaiTanggal == " 23:59:59") {

                        $id                 = "";
                        $nis                = "";
                        $namaSiswa          = "";
                        $kelas              = "";
                        $panggilan          = "";

                        $isifilby           = "kosong";

                        $halamanAktif = 1;

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
                        $ambildata_perhalaman = mysqli_query($con, "SELECT * FROM input_data_sd LIMIT $dataAwal, $jumlahData  ");
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

                    } else if ($dariTanggal > $sampaiTanggal) {

                        $id                 = "";
                        $nis                = "";
                        $namaSiswa          = "";
                        $kelas              = "";
                        $panggilan          = "";

                        $isifilby           = "kosong";

                        $halamanAktif = 1;

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
                        $ambildata_perhalaman = mysqli_query($con, "SELECT * FROM input_data_sd LIMIT $dataAwal, $jumlahData  ");
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

                    } else if ($dariTanggal != " 00:00:00" && $sampaiTanggal != " 23:59:59") {

                        // echo "Masuk ke filter tanggal lengkap";

                        // Data Filter PANGKAL dan tanggal Filter
                        // echo "Masuk ke filter tanggal " . $dariTanggal . " & " . $sampaiTanggal;exit;
                        $namaMurid = $namaSiswa;

                        $tanggalDari    = $_POST['tanggal1'];
                        $tanggalSampai  = $_POST['tanggal2']; 

                        $queryGetDataPangkal = "
                            SELECT ID, NIS, NAMA, kelas, PANGKAL, BULAN AS pembayaran_bulan, PANGKAL_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                            FROM input_data_sd
                            WHERE
                            PANGKAL != 0
                            AND NAMA LIKE '%$namaMurid%'
                            AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                        ";

                        $execQueryDataPangkal    = mysqli_query($con, $queryGetDataPangkal);
                        // $hitungDataFilterPANGKAL = mysqli_num_rows($execQueryDataPangkal);
                        $hitungDataFilterPangkalDate = mysqli_num_rows($execQueryDataPangkal);
                        // echo "Jumlah Data : ". $hitungDataFilterPangkalDate;exit;
                        // echo $hitungDataFilterPANGKAL;exit;

                        $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

                        $ambildata_perhalaman = mysqli_query($con, "
                            SELECT ID, NIS, NAMA, DATE, kelas, PANGKAL, TRANSAKSI, BULAN AS pembayaran_bulan, PANGKAL_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                            FROM input_data_sd
                            WHERE
                            PANGKAL != 0
                            AND NAMA LIKE '%$namaMurid%'
                            AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                            LIMIT $dataAwal, $jumlahData
                        ");

                        $jumlahPagination = ceil($hitungDataFilterPangkalDate / $jumlahData);

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

                // SEMUA
                else if ($_POST['isi_filter'] == 'SEMUA') {

                    // echo "SEMUA";exit;
                    if ($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59") {

                        $namaMurid = $namaSiswa;
                        $queryGetDataFilterSemua = "
                        SELECT * FROM input_data_sd WHERE NAMA LIKE '%$namaMurid%' ";
                        $execQueryDataFilterSemua    = mysqli_query($con, $queryGetDataFilterSemua);
                        $hitungDataFilterSemua = mysqli_num_rows($execQueryDataFilterSemua);
                        // echo $hitungDataFilterSemua;

                        $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;
                        // echo $dataAwal . "<br>";
                        $ambildata_perhalaman = mysqli_query($con, "SELECT * FROM input_data_sd WHERE NAMA LIKE '%$namaMurid%' ORDER BY ID DESC LIMIT $dataAwal, $jumlahData");

                        $jumlahPagination = ceil($hitungDataFilterSemua / $jumlahData);
                        // echo $jumlahPagination;

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

                    } else if ($dariTanggal != " 00:00:00" && $sampaiTanggal != " 23:59:59") {

                        // echo $dariTanggal . " & " . $sampaiTanggal;exit;

                        $namaMurid = $namaSiswa;

                        $tanggalDari    = $_POST['tanggal1'];
                        $tanggalSampai  = $_POST['tanggal2']; 

                        $queryGetDataFilterSemuaWithDate = "
                            SELECT * FROM input_data_sd 
                            WHERE
                            NAMA LIKE '%$namaMurid%'
                            AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                        ";

                        $execQueryDataFilterSemuaWithDate    = mysqli_query($con, $queryGetDataFilterSemuaWithDate);
                        // $hitungDataFilterSPP = mysqli_num_rows($execQueryDataFilterSemuaWithDate);
                        $hitungDataFilterSemuaWithDate = mysqli_num_rows($execQueryDataFilterSemuaWithDate);

                        $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

                        $ambildata_perhalaman = mysqli_query($con, "
                            SELECT * FROM input_data_sd
                            WHERE
                            NAMA LIKE '%$namaMurid%'
                            AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                            ORDER BY STAMP ASC
                            LIMIT $dataAwal, $jumlahData
                        ");

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

                // KEGIATAN
                else if ($_POST['isi_filter'] == 'KEGIATAN') {

                    if ($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59") {

                        // echo $_POST['isi_filter'];exit;

                        $namaMurid = $namaSiswa;
                        $queryGetDataKegiatan = "
                        SELECT ID, NIS, NAMA, kelas, KEGIATAN, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                        FROM input_data_sd
                        WHERE
                        KEGIATAN != 0
                        AND NAMA LIKE '%$namaMurid%' ";

                        $execQueryDataKegiatan    = mysqli_query($con, $queryGetDataKegiatan);
                        $hitungDataFilterKegiatan = mysqli_num_rows($execQueryDataKegiatan);

                        $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;
                        // echo $dataAwal . "<br>";
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

                    } else if ($dariTanggal != " 00:00:00" && $sampaiTanggal != " 23:59:59") {

                        // echo $dariTanggal . " & " . $sampaiTanggal;exit;

                        $namaMurid = $namaSiswa;

                        $tanggalDari    = $_POST['tanggal1'];
                        $tanggalSampai  = $_POST['tanggal2']; 

                        $queryGetDataFilterKegiatanWithDate = "
                            SELECT ID, NIS, NAMA, kelas, KEGIATAN, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                            FROM input_data_sd
                            WHERE
                            KEGIATAN != 0
                            AND NAMA LIKE '%$namaMurid%'
                            AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                        ";

                        $execQueryDataFilterKegiatanWithDate    = mysqli_query($con, $queryGetDataFilterKegiatanWithDate);
                        // $hitungDataFilterPANGKAL = mysqli_num_rows($execQueryDataFilterKegiatanWithDate);
                        $hitungDataFilterKegiatanWithDate = mysqli_num_rows($execQueryDataFilterKegiatanWithDate);

                        // echo "Dari tanggal : " . $dariTanggal . "<br> ". "Sampai Tanggal : " . $sampaiTanggal . "<br> Jumlah Data : ". $hitungDataFilterKegiatanWithDate;
                        // echo $hitungDataFilterPANGKAL;exit;

                        $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

                        $ambildata_perhalaman = mysqli_query($con, "
                            SELECT ID, NIS, NAMA, DATE, kelas, KEGIATAN, TRANSAKSI, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                            FROM input_data_sd
                            WHERE
                            KEGIATAN != 0
                            AND NAMA LIKE '%$namaMurid%'
                            AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                            LIMIT $dataAwal, $jumlahData
                        ");

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

                // BUKU
                else if ($_POST['isi_filter'] == 'BUKU') {

                    if ($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59") {

                        $namaMurid = $namaSiswa;
                        $queryGetDataBuku = "
                        SELECT ID, NIS, NAMA, kelas, BUKU, BULAN AS pembayaran_bulan, BUKU_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                        FROM input_data_sd
                        WHERE
                        BUKU != 0
                        AND NAMA LIKE '%$namaMurid%' ";

                        $execQueryDataBuku    = mysqli_query($con, $queryGetDataBuku);
                        $hitungDataFilterBuku = mysqli_num_rows($execQueryDataBuku);

                        $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;
                        // echo $dataAwal . "<br>";
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

                    } else if ($dariTanggal != " 00:00:00" && $sampaiTanggal != " 23:59:59") {

                        $namaMurid = $namaSiswa;

                        $tanggalDari    = $_POST['tanggal1'];
                        $tanggalSampai  = $_POST['tanggal2']; 

                        $queryGetDataFilterBukuWithDate = "
                            SELECT ID, NIS, NAMA, kelas, BUKU, BULAN AS pembayaran_bulan, BUKU_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                            FROM input_data_sd
                            WHERE
                            BUKU != 0
                            AND NAMA LIKE '%$namaMurid%'
                            AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                        ";

                        $execQueryDataFilterBukuWithDate    = mysqli_query($con, $queryGetDataFilterBukuWithDate);
                        // $hitungDataFilterPANGKAL = mysqli_num_rows($execQueryDataFilterBukuWithDate);
                        $hitungDataFilterBukuWithDate = mysqli_num_rows($execQueryDataFilterBukuWithDate);
                        // echo $hitungDataFilterBukuWithDate . "<br>";

                        // echo "Dari tanggal : " . $dariTanggal . "<br> ". "Sampai Tanggal : " . $sampaiTanggal . "<br> Jumlah Data : ". $hitungDataFilterBukuWithDate;
                        // echo $hitungDataFilterPANGKAL;exit;

                        $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

                        $ambildata_perhalaman = mysqli_query($con, "
                            SELECT ID, NIS, NAMA, DATE, kelas, BUKU, TRANSAKSI, BULAN AS pembayaran_bulan, BUKU_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                            FROM input_data_sd
                            WHERE
                            BUKU != 0
                            AND NAMA LIKE '%$namaMurid%'
                            AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                            LIMIT $dataAwal, $jumlahData
                        ");

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

                // SERAGAM
                else if ($_POST['isi_filter'] == 'SERAGAM') {

                    if ($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59") {

                        $namaMurid = $namaSiswa;
                        $queryGetDataSeragam = "
                        SELECT ID, NIS, NAMA, kelas, SERAGAM, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                        FROM input_data_sd
                        WHERE
                        SERAGAM != 0
                        AND NAMA LIKE '%$namaMurid%' ";

                        $execQueryDataSeragam    = mysqli_query($con, $queryGetDataSeragam);
                        $hitungDataFilterSeragam = mysqli_num_rows($execQueryDataSeragam);

                        $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;
                        // echo $dataAwal . "<br>";
                        $ambildata_perhalaman = mysqli_query($con, "
                            SELECT ID, NIS, NAMA, DATE, kelas, SERAGAM, TRANSAKSI, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                            FROM input_data_sd
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

                    } else if ($dariTanggal != " 00:00:00" && $sampaiTanggal != " 23:59:59") {

                        $namaMurid = $namaSiswa;

                        $tanggalDari    = $_POST['tanggal1'];
                        $tanggalSampai  = $_POST['tanggal2']; 

                        $queryGetDataFilterSeragamWithDate = "
                            SELECT ID, NIS, NAMA, kelas, SERAGAM, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                            FROM input_data_sd
                            WHERE
                            SERAGAM != 0
                            AND NAMA LIKE '%$namaMurid%'
                            AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                        ";

                        $execQueryDataFilterSeragamWithDate    = mysqli_query($con, $queryGetDataFilterSeragamWithDate);
                        // $hitungDataFilterPANGKAL = mysqli_num_rows($execQueryDataFilterSeragamWithDate);
                        $hitungDataFilterSeragamWithDate = mysqli_num_rows($execQueryDataFilterSeragamWithDate);
                        // echo $hitungDataFilterSeragamWithDate . "<br>";

                        // echo "Dari tanggal : " . $dariTanggal . "<br> ". "Sampai Tanggal : " . $sampaiTanggal . "<br> Jumlah Data : ". $hitungDataFilterSeragamWithDate;
                        // echo $hitungDataFilterPANGKAL;exit;

                        $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

                        $ambildata_perhalaman = mysqli_query($con, "
                            SELECT ID, NIS, NAMA, DATE, kelas, SERAGAM, TRANSAKSI, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                            FROM input_data_sd
                            WHERE
                            SERAGAM != 0
                            AND NAMA LIKE '%$namaMurid%'
                            AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                            LIMIT $dataAwal, $jumlahData
                        ");

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

                // REGISTRASI
                else if ($_POST['isi_filter'] == 'REGISTRASI') {

                    if ($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59") { 

                        $namaMurid = $namaSiswa;
                        $queryGetDataRegistrasi = "
                        SELECT ID, NIS, NAMA, kelas, REGISTRASI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                        FROM input_data_sd
                        WHERE
                        REGISTRASI != 0
                        AND NAMA LIKE '%$namaMurid%' ";

                        $execQueryDataRegistrasi    = mysqli_query($con, $queryGetDataRegistrasi);
                        $hitungDataFilterRegistrasi = mysqli_num_rows($execQueryDataRegistrasi);

                        $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;
                        // echo $dataAwal . "<br>";
                        $ambildata_perhalaman = mysqli_query($con, "
                            SELECT ID, NIS, NAMA, DATE, kelas, REGISTRASI, TRANSAKSI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                            FROM input_data_sd
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

                    } else if ($dariTanggal != " 00:00:00" && $sampaiTanggal != " 23:59:59") {

                        $namaMurid = $namaSiswa;

                        $tanggalDari    = $_POST['tanggal1'];
                        $tanggalSampai  = $_POST['tanggal2']; 

                        $queryGetDataFilterRegistrasiWithDate = "
                            SELECT ID, NIS, NAMA, kelas, REGISTRASI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                            FROM input_data_sd
                            WHERE
                            REGISTRASI != 0
                            AND NAMA LIKE '%$namaMurid%'
                            AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                        ";

                        $execQueryDataFilterRegistrasiWithDate    = mysqli_query($con, $queryGetDataFilterRegistrasiWithDate);
                        // $hitungDataFilterPANGKAL = mysqli_num_rows($execQueryDataFilterRegistrasiWithDate);
                        $hitungDataFilterRegistrasiWithDate = mysqli_num_rows($execQueryDataFilterRegistrasiWithDate);
                        // echo $hitungDataFilterRegistrasiWithDate . "<br>";

                        // echo "Dari tanggal : " . $dariTanggal . "<br> ". "Sampai Tanggal : " . $sampaiTanggal . "<br> Jumlah Data : ". $hitungDataFilterRegistrasiWithDate;
                        // echo $hitungDataFilterPANGKAL;exit;

                        $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

                        $ambildata_perhalaman = mysqli_query($con, "
                            SELECT ID, NIS, NAMA, DATE, kelas, REGISTRASI, TRANSAKSI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                            FROM input_data_sd
                            WHERE
                            REGISTRASI != 0
                            AND NAMA LIKE '%$namaMurid%'
                            AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                            LIMIT $dataAwal, $jumlahData
                        ");

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

                // LAIN
                else if($_POST['isi_filter'] == 'LAIN') {

                    if ($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59") { 

                        $namaMurid = $namaSiswa;
                        $queryGetDataLain = "
                        SELECT ID, NIS, NAMA, kelas, LAIN, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                        FROM input_data_sd
                        WHERE
                        LAIN != 0
                        AND NAMA LIKE '%$namaMurid%' ";

                        $execQueryDataLain    = mysqli_query($con, $queryGetDataLain);
                        $hitungDataFilterLain = mysqli_num_rows($execQueryDataLain);
                        // echo $hitungDataFilterLain;exit;

                        $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;
                        // echo $dataAwal . "<br>";
                        $ambildata_perhalaman = mysqli_query($con, "
                            SELECT ID, NIS, NAMA, DATE, kelas, LAIN, TRANSAKSI, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                            FROM input_data_sd
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

                    } else if ($dariTanggal != " 00:00:00" && $sampaiTanggal != " 23:59:59") {

                        $namaMurid = $namaSiswa;

                        $tanggalDari    = $_POST['tanggal1'];
                        $tanggalSampai  = $_POST['tanggal2']; 

                        $queryGetDataFilterLainWithDate = "
                            SELECT ID, NIS, NAMA, kelas, LAIN, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                            FROM input_data_sd
                            WHERE
                            LAIN != 0
                            AND NAMA LIKE '%$namaMurid%'
                            AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                        ";

                        $execQueryDataFilterRegistrasiWithDate    = mysqli_query($con, $queryGetDataFilterLainWithDate);
                        // $hitungDataFilterPANGKAL = mysqli_num_rows($execQueryDataFilterRegistrasiWithDate);
                        $hitungDataFilterLainWithDate = mysqli_num_rows($execQueryDataFilterRegistrasiWithDate);

                        // echo "Dari tanggal : " . $dariTanggal . "<br> ". "Sampai Tanggal : " . $sampaiTanggal . "<br> Jumlah Data : ". $hitungDataFilterLainWithDate;
                        // echo $hitungDataFilterPANGKAL;exit;

                        $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

                        $ambildata_perhalaman = mysqli_query($con, "
                            SELECT ID, NIS, NAMA, DATE, kelas, LAIN, TRANSAKSI, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                            FROM input_data_sd
                            WHERE
                            LAIN != 0
                            AND NAMA LIKE '%$namaMurid%'
                            AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                            LIMIT $dataAwal, $jumlahData
                        ");

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

            } else {
                // Jika tidak ada filter yang di pilih (kosong)
                $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;
                // echo $dataAwal . "<br>";
                $ambildata_perhalaman = mysqli_query($con, "SELECT * FROM input_data_sd ORDER BY ID DESC LIMIT $dataAwal, $jumlahData  ");
                // print_r($ambildata_perhalaman->num_rows);

                $jumlahLink = 2;

                $showAddPage100 = "";

                $totalHalamanTambah100 = $halamanAktif + 100;

                if ($totalHalamanTambah100 <= $jumlahPagination) {
                    $showAddPage100 = "muncul";
                } else {
                    $showAddPage100 = "tidak_muncul";
                }

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

        } else if (isset($_POST['nextPageFilterSemua'])) {

            $halamanAktif       = $_POST['halamanLanjutFilterSemua'];
            $iniScrollNextPage  = "ada";

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $namaMurid  = $_POST['namaSiswaFilterSemua'];
            $isifilby   = $_POST['iniFilterSemua'];

            $id         = $_POST['idSiswaFilterSemua'];
            $kelas      = $_POST['kelasFormFilterSemua'];
            $panggilan  = $_POST['panggilanFormFilterSemua'];
            $nis        = $_POST['nisFormFilterSemua'];
            $namaSiswa  = $_POST['namaFormFilterSemua'];

            $queryGetDataFilterSemua = "
                SELECT * FROM input_data_sd WHERE NAMA LIKE '%$namaMurid%'
            ";

            $execQueryDataFilterSemua    = mysqli_query($con, $queryGetDataFilterSemua);

            $hitungDataFilterSemua = mysqli_num_rows($execQueryDataFilterSemua);

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT * FROM input_data_sd WHERE NAMA LIKE '%$namaMurid%' ORDER BY ID DESC LIMIT $dataAwal, $jumlahData
            ");

            $check = mysqli_fetch_assoc($ambildata_perhalaman);

            $jumlahPagination = ceil($hitungDataFilterSemua / $jumlahData);

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

        } else if (isset($_POST['previousPageFilterSemua'])) {

            $halamanAktif           = $_POST['halamanSebelumnyaFilterSemua'];
            $iniScrollPreviousPage  = "ada";

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $namaMurid = $_POST['namaSiswaFilterSemua'];
            $isifilby  = $_POST['iniFilterSemua'];

            $id        = $_POST['idSiswaFilterSemua'];
            $nis       = $_POST['nisFormFilterSemua'];
            $namaSiswa = $_POST['namaFormFilterSemua'];
            $panggilan = $_POST['panggilanFormFilterSemua'];
            $kelas     = $_POST['kelasFormFilterSemua'];

            $queryGetDataFilterSemua = "
                SELECT * FROM input_data_sd WHERE NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataFilterSemua    = mysqli_query($con, $queryGetDataFilterSemua);
            $hitungDataFilterSemua = mysqli_num_rows($execQueryDataFilterSemua);

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT * FROM input_data_sd WHERE NAMA LIKE '%$namaMurid%' ORDER BY ID DESC LIMIT $dataAwal, $jumlahData");
            // print_r($ambildata_perhalaman->num_rows);

            $jumlahPagination = ceil($hitungDataFilterSemua / $jumlahData);

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

        } else if (isset($_POST['toPageFilterSemua'])) {

            $halamanAktif = $_POST['halamanKeFilterSemua'];
            $iniScrollNextPage = "ada";

            $namaMurid = $_POST['namaSiswaFilterSemua'];
            $isifilby  = $_POST['iniFilterSemua'];

            $namaSiswa = $namaMurid;
            $id        = $_POST['idSiswaFilterSemua'];
            $nis       = $_POST['nisFormFilterSemua'];
            $panggilan = $_POST['panggilanFormFilterSemua'];
            $kelas     = $_POST['kelasFormFilterSemua'];

            $queryGetDataFilterSemua = "
                SELECT * FROM input_data_sd WHERE NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataFilterSemua   = mysqli_query($con, $queryGetDataFilterSemua);
            $hitungDataFilterSemua        = mysqli_num_rows($execQueryDataFilterSemua);

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT * FROM input_data_sd WHERE NAMA LIKE '%$namaMurid%' 
                ORDER BY ID DESC
                LIMIT $dataAwal, $jumlahData");
            // print_r($ambildata_perhalaman->num_rows);

            $jumlahPagination = ceil($hitungDataFilterSemua / $jumlahData);

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

        } else if (isset($_POST['firstPageFilterSemua'])) {

            $namaMurid      = $_POST['namaFormFilterSemua'];

            $id             = $_POST['idSiswaFilterSemua'];
            $nis            = $_POST['nisFormFilterSemua'];
            $kelas          = $_POST['kelasFormFilterSemua'];
            $panggilan      = $_POST['panggilanFormFilterSemua'];
            $namaSiswa      = $namaMurid;

            $isifilby       = $_POST['iniFilterSemua'];

            $iniScrollPreviousPage  = "ada";

            $execQueryGetAllDataHistoriFilterSemua = mysqli_query($con, "
                SELECT * FROM input_data_sd WHERE NAMA LIKE '%$namaMurid%'
            ");

            $totalData = mysqli_num_rows($execQueryGetAllDataHistoriFilterSemua);

            $jumlahPagination = ceil($totalData / $jumlahData);

            $halamanAktif   = 1;

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $hitungDataFilterSemua = $totalData;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT * FROM input_data_sd WHERE NAMA LIKE '%$namaMurid%'
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

        } else if (isset($_POST['lastPageFilterSemua'])) {

            $namaMurid      = $_POST['namaSiswaFilterSemua'];
            $isifilby       = $_POST['iniFilterSemua'];

            $id             = $_POST['idSiswaFilterSemua'];
            $namaSiswa      = $namaMurid;
            $kelas          = $_POST['kelasFormFilterSemua'];
            $panggilan      = $_POST['panggilanFormFilterSemua'];
            $nis            = $_POST['nisFormFilterSemua'];

            $iniScrollPreviousPage  = "ada";

            $execQueryGetAllDataHistoriFilterSemua = mysqli_query($con, "
                SELECT * FROM input_data_sd WHERE NAMA LIKE '%$namaMurid%'
            ");

            $totalData = mysqli_num_rows($execQueryGetAllDataHistoriFilterSemua);

            $jumlahPagination = ceil($totalData / $jumlahData);

            $halamanAktif   = $jumlahPagination;

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $hitungDataFilterSemua = $totalData;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT * FROM input_data_sd WHERE NAMA LIKE '%$namaMurid%'
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

        } else if (isset($_POST['nextPageFilterSemuaWithDate'])) {

            $halamanAktif       = $_POST['halamanLanjutFilterSemuaWithDate'];
            $iniScrollNextPage  = "ada";

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $namaMurid  = $_POST['namaSiswaFilterSemuaWithDate'];
            $isifilby   = $_POST['iniFilterSemuaWithDate'];

            $id         = $_POST['idSiswaFilterSemuaWithDate'];
            $kelas      = $_POST['kelasFormFilterSemuaWithDate'];
            $panggilan  = $_POST['panggilanFormFilterSemuaWithDate'];
            $nis        = $_POST['nisFormFilterSemuaWithDate'];
            $namaSiswa  = $_POST['namaFormFilterSemuaWithDate'];

            $tanggalDari    = $_POST['tanggalDariFormFilterSemuaWithDate'] . " 00:00:00";
            $tanggalSampai  = $_POST['tanggalSampaiFormFilterSemuaWithDate'] . " 23:59:59";

            $queryGetDataFilterSemuaWithDate = "
                SELECT * FROM input_data_sd 
                WHERE NAMA LIKE '%$namaMurid%' AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
            ";

            $execQueryDataFilterSemuaWithDate    = mysqli_query($con, $queryGetDataFilterSemuaWithDate);
            $hitungDataFilterSemuaWithDate = mysqli_num_rows($execQueryDataFilterSemuaWithDate);

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT * 
                FROM input_data_sd
                WHERE
                NAMA LIKE '%$namaMurid%'
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
                ORDER BY STAMP ASC
                LIMIT $dataAwal, $jumlahData
            ");
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

        } else if (isset($_POST['previousPageFilterSemuaWithDate'])) {

            $halamanAktif           = $_POST['halamanSebelumnyaFilterSemuaWithDate'];
            $iniScrollPreviousPage  = "ada";

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $namaMurid = $_POST['namaSiswaFilterSemuaWithDate'];
            $isifilby  = $_POST['iniFilterSemuaWithDate'];

            $id        = $_POST['idSiswaFilterSemuaWithDate'];
            $nis       = $_POST['nisFormFilterSemuaWithDate'];
            $namaSiswa = $_POST['namaFormFilterSemuaWithDate'];
            $panggilan = $_POST['panggilanFormFilterSemuaWithDate'];
            $kelas     = $_POST['kelasFormFilterSemuaWithDate'];

            $tanggalDari    = $_POST['tanggalDariFormFilterSemuaWithDate'] . " 00:00:00";
            $tanggalSampai  = $_POST['tanggalSampaiFormFilterSemuaWithDate'] . " 23:59:59";

            $queryGetDataFilterSemuaWithDate = "
                SELECT * FROM input_data_sd
                WHERE
                STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
                AND NAMA LIKE '%$namaMurid%' 
            ";
            $execQueryDataFilterSemua    = mysqli_query($con, $queryGetDataFilterSemuaWithDate);
            $hitungDataFilterSemuaWithDate = mysqli_num_rows($execQueryDataFilterSemua);

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT * FROM input_data_sd
                WHERE
                NAMA LIKE '%$namaMurid%'
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai' 
                ORDER By STAMP ASC
                LIMIT $dataAwal, $jumlahData");

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

        } else if (isset($_POST['toPageFilterSemuaWithDate'])) {

            $halamanAktif = $_POST['halamanKeFilterSemuaWithDate'];
            $iniScrollNextPage = "ada";

            $namaMurid = $_POST['namaSiswaFilterSemuaWithDate'];
            $isifilby  = $_POST['iniFilterSemuaWithDate'];

            $namaSiswa = $namaMurid;
            $id        = $_POST['idSiswaFilterSemuaWithDate'];
            $nis       = $_POST['nisFormFilterSemuaWithDate'];
            $panggilan = $_POST['panggilanFormFilterSemuaWithDate'];
            $kelas     = $_POST['kelasFormFilterSemuaWithDate'];

            $tanggalDari    = $_POST['tanggalDariFormFilterSemuaWithDate'] . " 00:00:00";
            $tanggalSampai  = $_POST['tanggalSampaiFormFilterSemuaWithDate'] . " 23:59:59";

            $queryGetDataFilterSemuaWithDate = "
                SELECT * FROM input_data_sd
                WHERE
                STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
                AND NAMA LIKE '%$namaMurid%' 
            ";
            $execQueryDataFilterSemua    = mysqli_query($con, $queryGetDataFilterSemuaWithDate);
            $hitungDataFilterSemua = mysqli_num_rows($execQueryDataFilterSemua);
            // echo $hitungDataFilterSemua;

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT * FROM input_data_sd
                WHERE
                NAMA LIKE '%$namaMurid%'
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
                ORDER by STAMP ASC
                LIMIT $dataAwal, $jumlahData");

            $jumlahPagination = ceil($hitungDataFilterSemua / $jumlahData);

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

        } else if (isset($_POST['firstPageFilterSemuaWithDate'])) {

            $namaMurid      = $_POST['namaFormFilterSemuaWithDate'];

            $id             = $_POST['idSiswaFilterSemuaWithDate'];
            $nis            = $_POST['nisFormFilterSemuaWithDate'];
            $kelas          = $_POST['kelasFormFilterSemuaWithDate'];
            $panggilan      = $_POST['panggilanFormFilterSemuaWithDate'];
            $namaSiswa      = $namaMurid;

            $isifilby       = $_POST['iniFilterSemuaWithDate'];

            $iniScrollPreviousPage  = "ada";

            $tanggalDari    = $_POST['tanggalDariFormFilterSemuaWithDate'] . " 00:00:00";
            $tanggalSampai  = $_POST['tanggalSampaiFormFilterSemuaWithDate'] . " 23:59:59";

            $execQueryGetAllDataHistoriFilterSemua = mysqli_query($con, "
                SELECT * FROM input_data_sd
                WHERE
                STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
                AND NAMA LIKE '%$namaMurid%'
            ");

            $totalData = mysqli_num_rows($execQueryGetAllDataHistoriFilterSemua);
            // echo $totalData;

            $jumlahPagination = ceil($totalData / $jumlahData);

            $halamanAktif   = 1;

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $hitungDataFilterSemuaWithDate = $jumlahPagination;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT * FROM input_data_sd
                WHERE
                NAMA LIKE '%$namaMurid%'
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
                ORDER BY STAMP ASC
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

        } else if (isset($_POST['lastPageFilterSemuaWithDate'])) {

            $namaMurid      = $_POST['namaSiswaFilterSemuaWithDate'];
            $isifilby       = $_POST['iniFilterSemuaWithDate'];

            $id             = $_POST['idSiswaFilterSemuaWithDate'];
            $namaSiswa      = $namaMurid;
            $kelas          = $_POST['kelasFormFilterSemuaWithDate'];
            $panggilan      = $_POST['panggilanFormFilterSemuaWithDate'];
            $nis            = $_POST['nisFormFilterSemuaWithDate'];

            $iniScrollPreviousPage  = "ada";

            $tanggalDari    = $_POST['tanggalDariFormFilterSemuaWithDate'] . " 00:00:00";
            $tanggalSampai  = $_POST['tanggalSampaiFormFilterSemuaWithDate'] . " 23:59:59";

            $execQueryGetAllDataHistoriFilterSemua = mysqli_query($con, "
                SELECT * FROM input_data_sd
                WHERE
                STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
                AND NAMA LIKE '%$namaMurid%'
            ");

            $totalData = mysqli_num_rows($execQueryGetAllDataHistoriFilterSemua);
            // echo $totalData;

            $jumlahPagination = ceil($totalData / $jumlahData);

            $halamanAktif   = $jumlahPagination;
            // echo $halamanAktif;exit;

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $hitungDataFilterSemuaWithDate = $jumlahPagination;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT * FROM input_data_sd
                WHERE
                NAMA LIKE '%$namaMurid%'
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
                ORDER BY STAMP ASC
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

        } else if (isset($_POST['nextPageJustFilterSPP'])) {
            
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

        } else if (isset($_POST['previousPageJustFilterSPP'])) {

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

        } else if (isset($_POST['toPageFilterSPP'])) {

            $halamanAktif = $_POST['halamanKeFilterSPP'];
            $iniScrollNextPage = "ada";

            $namaMurid = $_POST['namaSiswaFilterSPP'];
            $isifilby  = $_POST['iniFilterSPP'];

            $namaSiswa = $namaMurid;
            $id        = $_POST['idSiswaFilterSPP'];
            $nis       = $_POST['nisFormFilterSPP'];
            $panggilan = $_POST['panggilanFormFilterSPP'];
            $kelas     = $_POST['kelasFormFilterSPP'];

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

        } else if (isset($_POST['firstPageFilterSPP'])) {

            $namaMurid      = $_POST['namaFormFilterSPP'];

            $id             = $_POST['idSiswaFilterSPP'];
            $nis            = $_POST['nisFormFilterSPP'];
            $kelas          = $_POST['kelasFormFilterSPP'];
            $panggilan      = $_POST['panggilanFormFilterSPP'];
            $namaSiswa      = $namaMurid;

            $isifilby       = $_POST['iniFilterSPP'];

            $iniScrollPreviousPage  = "ada";

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

        } else if (isset($_POST['lastPageFilterSPP'])) {

            $namaMurid      = $_POST['namaSiswaFilterSPP'];
            $isifilby       = $_POST['iniFilterSPP'];

            $id             = $_POST['idSiswaFilterSPP'];
            $namaSiswa      = $namaMurid;
            $kelas          = $_POST['kelasFormFilterSPP'];
            $panggilan      = $_POST['panggilanFormFilterSPP'];
            $nis            = $_POST['nisFormFilterSPP'];

            $iniScrollPreviousPage  = "ada";

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

        } else if (isset($_POST['findPageData'])) {

            $halamanAktif = $_POST['cari_halaman'];
            $iniScrollPreviousPage  = "ada";
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

        } else if (isset($_POST['nextPageFilterSPPWithDate']) ) {

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

            $tanggalDari    = $_POST['tanggalDariFormFilterSPPWithDate'] . " 00:00:00";
            $tanggalSampai  = $_POST['tanggalSampaiFormFilterSPPWithDate'] . " 23:59:59";

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

        } else if (isset($_POST['previousPageFilterSPPWithDate'])) {

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

            $tanggalDari    = $_POST['tanggalDariFormFilterSPPWithDate'] . " 00:00:00";
            $tanggalSampai  = $_POST['tanggalSampaiFormFilterSPPWithDate'] . " 23:59:59";

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

        } else if (isset($_POST['firstPageFilterSPPWithDate'])) {

            $namaMurid      = $_POST['namaFormFilterSPPWithDate'];

            $id             = $_POST['idSiswaFilterSPPWithDate'];
            $nis            = $_POST['nisFormFilterSPPWithDate'];
            $kelas          = $_POST['kelasFormFilterSPPWithDate'];
            $panggilan      = $_POST['panggilanFormFilterSPPWithDate'];
            $namaSiswa      = $namaMurid;

            $isifilby       = $_POST['iniFilterSPPWithDate'];

            $iniScrollPreviousPage  = "ada";

            $tanggalDari    = $_POST['tanggalDariFormFilterSPPWithDate'] . " 00:00:00";
            $tanggalSampai  = $_POST['tanggalSampaiFormFilterSPPWithDate'] . " 23:59:59";

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

        } else if (isset($_POST['lastPageFilterSPPWithDate'])) {

            $namaMurid      = $_POST['namaSiswaFilterSPPWithDate'];
            $isifilby       = $_POST['iniFilterSPPWithDate'];

            $id             = $_POST['idSiswaFilterSPPWithDate'];
            $namaSiswa      = $namaMurid;
            $kelas          = $_POST['kelasFormFilterSPPWithDate'];
            $panggilan      = $_POST['panggilanFormFilterSPPWithDate'];
            $nis            = $_POST['nisFormFilterSPPWithDate'];

            $iniScrollPreviousPage  = "ada";

            $tanggalDari    = $_POST['tanggalDariFormFilterSPPWithDate'] . " 00:00:00";
            $tanggalSampai  = $_POST['tanggalSampaiFormFilterSPPWithDate'] . " 23:59:59";

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

            $halamanAktif   = $jumlahPagination;
            // echo $halamanAktif;exit;

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

        } else if (isset($_POST['toPageFilterSPPWithDate'])) {

            $halamanAktif = $_POST['halamanKeFilterSPPWithDate'];
            $iniScrollNextPage = "ada";

            $namaMurid = $_POST['namaSiswaFilterSPPWithDate'];
            $isifilby  = $_POST['iniFilterSPPWithDate'];

            $namaSiswa = $namaMurid;
            $id        = $_POST['idSiswaFilterSPPWithDate'];
            $nis       = $_POST['nisFormFilterSPPWithDate'];
            $panggilan = $_POST['panggilanFormFilterSPPWithDate'];
            $kelas     = $_POST['kelasFormFilterSPPWithDate'];

            $tanggalDari    = $_POST['tanggalDariFormFilterSPPWithDate'] . " 00:00:00";
            $tanggalSampai  = $_POST['tanggalSampaiFormFilterSPPWithDate'] . " 23:59:59";

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

        } else if (isset($_POST['nextPageJustFilterPANGKAL'])) {

            // echo "Next page filter pangkal";exit;
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

            $queryGetDataPangkal = "
                SELECT ID, NIS, NAMA, kelas, PANGKAL, BULAN AS pembayaran_bulan, PANGKAL_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                PANGKAL != 0
                AND NAMA LIKE '%$namaMurid%' 
            ";
            $execQueryDataPangkal    = mysqli_query($con, $queryGetDataPangkal);
            $hitungDataFilterPANGKAL = mysqli_num_rows($execQueryDataPangkal);

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

        } else if (isset($_POST['previousPageJustFilterPANGKAL'])) {

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

        } else if (isset($_POST['toPageFilterPANGKAL'])) {

            $halamanAktif = $_POST['halamanKeFilterPANGKAL'];
            $iniScrollNextPage = "ada";

            $namaMurid = $_POST['namaSiswaFilterPANGKAL'];
            $isifilby  = $_POST['iniFilterPANGKAL'];

            $namaSiswa = $namaMurid;
            $id        = $_POST['idSiswaFilterPANGKAL'];
            $nis       = $_POST['nisFormFilterPANGKAL'];
            $panggilan = $_POST['panggilanFormFilterPANGKAL'];
            $kelas     = $_POST['kelasFormFilterPANGKAL'];

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

        } else if (isset($_POST['firstPageFilterPANGKAL'])) {

            $namaMurid      = $_POST['namaFormFilterPANGKAL'];

            $id             = $_POST['idSiswaFilterPANGKAL'];
            $nis            = $_POST['nisFormFilterPANGKAL'];
            $kelas          = $_POST['kelasFormFilterPANGKAL'];
            $panggilan      = $_POST['panggilanFormFilterPANGKAL'];
            $namaSiswa      = $namaMurid;

            $isifilby       = $_POST['iniFilterPANGKAL'];

            $iniScrollPreviousPage  = "ada";

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

        } else if (isset($_POST['lastPageFilterPANGKAL'])) {

            $namaMurid      = $_POST['namaSiswaFilterPANGKAL'];
            $isifilby       = $_POST['iniFilterPANGKAL'];

            $id             = $_POST['idSiswaFilterPANGKAL'];
            $namaSiswa      = $namaMurid;
            $kelas          = $_POST['kelasFormFilterPANGKAL'];
            $panggilan      = $_POST['panggilanFormFilterPANGKAL'];
            $nis            = $_POST['nisFormFilterPANGKAL'];

            $iniScrollPreviousPage  = "ada";

            $execQueryGetAllDataHistoriFilterPANGKAL = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, PANGKAL, BULAN AS pembayaran_bulan, PANGKAL_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
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

        } else if (isset($_POST['nextPageFilterPangkalWithDate'])) {

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

            $tanggalDari    = $_POST['tanggalDariFormFilterPangkalWithDate'] . " 00:00:00";
            $tanggalSampai  = $_POST['tanggalSampaiFormFilterPangkalWithDate'] . " 23:59:59";

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

        } else if (isset($_POST['previousPageFilterPangkalWithDate'])) {

            $halamanAktif           = $_POST['halamanSebelumnyaFilterPangkalWithDate'];
            $iniScrollPreviousPage  = "ada";

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $namaMurid = $_POST['namaSiswaFilterPangkalWithDate'];
            $isifilby  = $_POST['iniFilterPangkalWithDate'];

            $id        = $_POST['idSiswaFilterPangkalWithDate'];
            $nis       = $_POST['nisFormFilterPangkalWithDate'];
            $namaSiswa = $_POST['namaFormFilterPangkalWithDate'];
            $panggilan = $_POST['panggilanFormFilterPangkalWithDate'];
            $kelas     = $_POST['kelasFormFilterPangkalWithDate'];

            $tanggalDari    = $_POST['tanggalDariFormFilterPangkalWithDate'] . " 00:00:00";
            $tanggalSampai  = $_POST['tanggalSampaiFormFilterPangkalWithDate'] . " 23:59:59";

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

        } else if (isset($_POST['toPageFilterPangkalWithDate'])) {

            $halamanAktif = $_POST['halamanKeFilterPangkalWithDate'];
            $iniScrollNextPage = "ada";

            $namaMurid = $_POST['namaSiswaFilterPangkalWithDate'];
            $isifilby  = $_POST['iniFilterPangkalWithDate'];

            $namaSiswa = $namaMurid;
            $id        = $_POST['idSiswaFilterPangkalWithDate'];
            $nis       = $_POST['nisFormFilterPangkalWithDate'];
            $panggilan = $_POST['panggilanFormFilterPangkalWithDate'];
            $kelas     = $_POST['kelasFormFilterPangkalWithDate'];

            $tanggalDari    = $_POST['tanggalDariFormFilterPangkalWithDate'] . " 00:00:00";
            $tanggalSampai  = $_POST['tanggalSampaiFormFilterPangkalWithDate'] . " 23:59:59";

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

        } else if (isset($_POST['firstPageFilterPangkalWithDate'])) {

            $namaMurid      = $_POST['namaFormFilterPangkalWithDate'];

            $id             = $_POST['idSiswaFilterPangkalWithDate'];
            $nis            = $_POST['nisFormFilterPangkalWithDate'];
            $kelas          = $_POST['kelasFormFilterPangkalWithDate'];
            $panggilan      = $_POST['panggilanFormFilterPangkalWithDate'];
            $namaSiswa      = $namaMurid;

            $isifilby       = $_POST['iniFilterPangkalWithDate'];

            $iniScrollPreviousPage  = "ada";

            $tanggalDari    = $_POST['tanggalDariFormFilterPangkalWithDate'] . " 00:00:00";
            $tanggalSampai  = $_POST['tanggalSampaiFormFilterPangkalWithDate'] . " 23:59:59";

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

        } else if (isset($_POST['lastPageFilterPangkalWithDate'])) {

            $namaMurid      = $_POST['namaSiswaFilterPangkalWithDate'];
            $isifilby       = $_POST['iniFilterPangkalWithDate'];

            $id             = $_POST['idSiswaFilterPangkalWithDate'];
            $namaSiswa      = $namaMurid;
            $kelas          = $_POST['kelasFormFilterPangkalWithDate'];
            $panggilan      = $_POST['panggilanFormFilterPangkalWithDate'];
            $nis            = $_POST['nisFormFilterPangkalWithDate'];

            $iniScrollPreviousPage  = "ada";

            $tanggalDari    = $_POST['tanggalDariFormFilterPangkalWithDate'] . " 00:00:00";
            $tanggalSampai  = $_POST['tanggalSampaiFormFilterPangkalWithDate'] . " 23:59:59";

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

            $halamanAktif   = $jumlahPagination;
            // echo $halamanAktif;exit;

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

        } else if (isset($_POST['nextPageFilterKegiatan'])) {

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

        } else if (isset($_POST['previousPageFilterKegiatan'])) {

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

        } else if (isset($_POST['toPageFilterKegiatan'])) {

            $halamanAktif = $_POST['halamanKeFilterKegiatan'];
            $iniScrollNextPage = "ada";

            $namaMurid = $_POST['namaSiswaFilterKegiatan'];
            $isifilby  = $_POST['iniFilterKegiatan'];

            $namaSiswa = $namaMurid;
            $id        = $_POST['idSiswaFilterKegiatan'];
            $nis       = $_POST['nisFormFilterKegiatan'];
            $panggilan = $_POST['panggilanFormFilterKegiatan'];
            $kelas     = $_POST['kelasFormFilterKegiatan'];

            $queryGetDataKegiatan = "
                SELECT ID, NIS, NAMA, kelas, KEGIATAN, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                KEGIATAN != 0
                AND NAMA LIKE '%$namaMurid%' 
            ";
            $execQueryDatakegiatan    = mysqli_query($con, $queryGetDataKegiatan);
            $hitungDataFilterKegiatan = mysqli_num_rows($execQueryDatakegiatan);

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

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

        } else if (isset($_POST['firstPageFilterKegiatan'])) {

            $namaMurid      = $_POST['namaFormFilterKegiatan'];

            $id             = $_POST['idSiswaFilterKegiatan'];
            $nis            = $_POST['nisFormFilterKegiatan'];
            $kelas          = $_POST['kelasFormFilterKegiatan'];
            $panggilan      = $_POST['panggilanFormFilterKegiatan'];
            $namaSiswa      = $namaMurid;

            $isifilby       = $_POST['iniFilterKegiatan'];

            $iniScrollPreviousPage  = "ada";

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

        } else if (isset($_POST['lastPageFilterKegiatan'])) {

            $namaMurid      = $_POST['namaSiswaFilterKegiatan'];
            $isifilby       = $_POST['iniFilterKegiatan'];

            $id             = $_POST['idSiswaFilterKegiatan'];
            $namaSiswa      = $namaMurid;
            $kelas          = $_POST['kelasFormFilterKegiatan'];
            $panggilan      = $_POST['panggilanFormFilterKegiatan'];
            $nis            = $_POST['nisFormFilterKegiatan'];

            $iniScrollPreviousPage  = "ada";

            $execQueryGetAllDataHistoriFilterKegiatan = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, KEGIATAN, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
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

        } else if (isset($_POST['nextPageFilterKegiatanWithDate'])) {

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

            $tanggalDari    = $_POST['tanggalDariFormFilterKegiatanWithDate'] . " 00:00:00";
            $tanggalSampai  = $_POST['tanggalSampaiFormFilterKegiatanWithDate'] . " 23:59:59";

            $queryGetDataKegiatanWithDate = "
                SELECT ID, NIS, NAMA, kelas, KEGIATAN, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                KEGIATAN != 0
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
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
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
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

        } else if (isset($_POST['previousPageFilterKegiatanWithDate'])) {

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

            $tanggalDari    = $_POST['tanggalDariFormFilterKegiatanWithDate'] . " 00:00:00";
            $tanggalSampai  = $_POST['tanggalSampaiFormFilterKegiatanWithDate'] . " 23:59:59";

            $queryGetDataKegiatanWithDate = "
                SELECT ID, NIS, NAMA, kelas, KEGIATAN, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                KEGIATAN != 0
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
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
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai' 
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

        } else if (isset($_POST['toPageFilterKegiatanWithDate'])) {

            $halamanAktif = $_POST['halamanKeFilterKegiatanWithDate'];
            $iniScrollNextPage = "ada";

            $namaMurid = $_POST['namaSiswaFilterKegiatanWithDate'];
            $isifilby  = $_POST['iniFilterKegiatanWithDate'];

            $namaSiswa = $namaMurid;
            $id        = $_POST['idSiswaFilterKegiatanWithDate'];
            $nis       = $_POST['nisFormFilterKegiatanWithDate'];
            $panggilan = $_POST['panggilanFormFilterKegiatanWithDate'];
            $kelas     = $_POST['kelasFormFilterKegiatanWithDate'];

            $tanggalDari    = $_POST['tanggalDariFormFilterKegiatanWithDate'] . " 00:00:00";
            $tanggalSampai  = $_POST['tanggalSampaiFormFilterKegiatanWithDate'] . " 23:59:59";

            $queryGetDataKegiatanWithDate = "
                SELECT ID, NIS, NAMA, kelas, KEGIATAN, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                KEGIATAN != 0
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
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
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
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

        } elseif (isset($_POST['firstPageFilterKegiatanWithDate'])) {

            $namaMurid      = $_POST['namaFormFilterKegiatanWithDate'];

            $id             = $_POST['idSiswaFilterKegiatanWithDate'];
            $nis            = $_POST['nisFormFilterKegiatanWithDate'];
            $kelas          = $_POST['kelasFormFilterKegiatanWithDate'];
            $panggilan      = $_POST['panggilanFormFilterKegiatanWithDate'];
            $namaSiswa      = $namaMurid;

            $isifilby       = $_POST['iniFilterKegiatanWithDate'];

            $iniScrollPreviousPage  = "ada";

            $tanggalDari    = $_POST['tanggalDariFormFilterKegiatanWithDate'] . " 00:00:00";
            $tanggalSampai  = $_POST['tanggalSampaiFormFilterKegiatanWithDate'] . " 23:59:59";

            $execQueryGetAllDataHistoriFilterKegitanWithDate = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, KEGIATAN, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                KEGIATAN != 0
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
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

        } else if (isset($_POST['lastPageFilterKegiatanWithDate'])) {

            $namaMurid      = $_POST['namaSiswaFilterKegiatanWithDate'];
            $isifilby       = $_POST['iniFilterKegiatanWithDate'];

            $id             = $_POST['idSiswaFilterKegiatanWithDate'];
            $namaSiswa      = $namaMurid;
            $kelas          = $_POST['kelasFormFilterKegiatanWithDate'];
            $panggilan      = $_POST['panggilanFormFilterKegiatanWithDate'];
            $nis            = $_POST['nisFormFilterKegiatanWithDate'];

            $iniScrollPreviousPage  = "ada";

            $tanggalDari    = $_POST['tanggalDariFormFilterKegiatanWithDate'] . " 00:00:00";
            $tanggalSampai  = $_POST['tanggalSampaiFormFilterKegiatanWithDate'] . " 23:59:59";

            $execQueryGetAllDataHistoriFilterKegiatanWithDate = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, KEGIATAN, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                KEGIATAN != 0
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
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
                FROM input_data_sd
                WHERE
                KEGIATAN != 0
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

        } else if (isset($_POST['nextPageFilterBuku'])) {

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

        } else if (isset($_POST['previousPageFilterBuku'])) {

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

        } else if (isset($_POST['toPageFilterBuku'])) {

            $halamanAktif = $_POST['halamanKeFilterBuku'];
            $iniScrollNextPage = "ada";

            $namaMurid = $_POST['namaSiswaFilterBuku'];
            $isifilby  = $_POST['iniFilterBuku'];

            $namaSiswa = $namaMurid;
            $id        = $_POST['idSiswaFilterBuku'];
            $nis       = $_POST['nisFormFilterBuku'];
            $panggilan = $_POST['panggilanFormFilterBuku'];
            $kelas     = $_POST['kelasFormFilterBuku'];

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

        } else if (isset($_POST['firstPageFilterBuku'])) {

            $namaMurid      = $_POST['namaFormFilterBuku'];

            $id             = $_POST['idSiswaFilterBuku'];
            $nis            = $_POST['nisFormFilterBuku'];
            $kelas          = $_POST['kelasFormFilterBuku'];
            $panggilan      = $_POST['panggilanFormFilterBuku'];
            $namaSiswa      = $namaMurid;

            $isifilby       = $_POST['iniFilterBuku'];

            $iniScrollPreviousPage  = "ada";

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

        } else if (isset($_POST['lastPageFilterBuku'])) {

            $namaMurid      = $_POST['namaSiswaFilterBuku'];
            $isifilby       = $_POST['iniFilterBuku'];

            $id             = $_POST['idSiswaFilterBuku'];
            $namaSiswa      = $namaMurid;
            $kelas          = $_POST['kelasFormFilterBuku'];
            $panggilan      = $_POST['panggilanFormFilterBuku'];
            $nis            = $_POST['nisFormFilterBuku'];

            $iniScrollPreviousPage  = "ada";

            $execQueryGetAllDataHistoriFilterBuku = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, BUKU, BULAN AS pembayaran_bulan, BUKU_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
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

        } else if (isset($_POST['nextPageFilterBukuWithDate'])) {

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

            $tanggalDari    = $_POST['tanggalDariFormFilterBukuWithDate'] . " 00:00:00";
            $tanggalSampai  = $_POST['tanggalSampaiFormFilterBukuWithDate'] . " 23:59:59";

            $queryGetDataBukuWithDate = "
                SELECT ID, NIS, NAMA, kelas, BUKU, BULAN AS pembayaran_bulan, BUKU_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                BUKU != 0
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
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
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
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

        } else if (isset($_POST['previousPageFilterBukuWithDate'])) {

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

            $tanggalDari    = $_POST['tanggalDariFormFilterBukuWithDate'] . " 00:00:00";
            $tanggalSampai  = $_POST['tanggalSampaiFormFilterBukuWithDate'] . " 23:59:59";

            $queryGetDataBukuWithDate = "
                SELECT ID, NIS, NAMA, kelas, BUKU, BULAN AS pembayaran_bulan, BUKU_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                BUKU != 0
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
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
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai' 
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

        } else if (isset($_POST['toPageFilterBukuWithDate'])) {

            $halamanAktif = $_POST['halamanKeFilterBukuWithDate'];
            $iniScrollNextPage = "ada";

            $namaMurid = $_POST['namaSiswaFilterBukuWithDate'];
            $isifilby  = $_POST['iniFilterBukuWithDate'];

            $namaSiswa = $namaMurid;
            $id        = $_POST['idSiswaFilterBukuWithDate'];
            $nis       = $_POST['nisFormFilterBukuWithDate'];
            $panggilan = $_POST['panggilanFormFilterBukuWithDate'];
            $kelas     = $_POST['kelasFormFilterBukuWithDate'];

            $tanggalDari    = $_POST['tanggalDariFormFilterBukuWithDate'] . " 00:00:00";
            $tanggalSampai  = $_POST['tanggalSampaiFormFilterBukuWithDate'] . " 23:59:59";

            $queryGetDataBukuWithDate = "
                SELECT ID, NIS, NAMA, kelas, BUKU, BULAN AS pembayaran_bulan, BUKU_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                BUKU != 0
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
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
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
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

        } else if (isset($_POST['firstPageFilterBukuWithDate'])) {

            $namaMurid      = $_POST['namaFormFilterBukuWithDate'];

            $id             = $_POST['idSiswaFilterBukuWithDate'];
            $nis            = $_POST['nisFormFilterBukuWithDate'];
            $kelas          = $_POST['kelasFormFilterBukuWithDate'];
            $panggilan      = $_POST['panggilanFormFilterBukuWithDate'];
            $namaSiswa      = $namaMurid;

            $isifilby       = $_POST['iniFilterBukuWithDate'];

            $iniScrollPreviousPage  = "ada";

            $tanggalDari    = $_POST['tanggalDariFormFilterBukuWithDate'] . " 00:00:00";
            $tanggalSampai  = $_POST['tanggalSampaiFormFilterBukuWithDate'] . " 23:59:59";

            $execQueryGetAllDataHistoriFilterBukuWithDate = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, BUKU, BULAN AS pembayaran_bulan, BUKU_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                BUKU != 0
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
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
                FROM input_data_sd
                WHERE
                BUKU != 0
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

        } else if (isset($_POST['lastPageFilterBukuWithDate'])) {

            $namaMurid      = $_POST['namaSiswaFilterBukuWithDate'];
            $isifilby       = $_POST['iniFilterBukuWithDate'];

            $id             = $_POST['idSiswaFilterBukuWithDate'];
            $namaSiswa      = $namaMurid;
            $kelas          = $_POST['kelasFormFilterBukuWithDate'];
            $panggilan      = $_POST['panggilanFormFilterBukuWithDate'];
            $nis            = $_POST['nisFormFilterBukuWithDate'];

            $iniScrollPreviousPage  = "ada";

            $tanggalDari    = $_POST['tanggalDariFormFilterBukuWithDate'] . " 00:00:00";
            $tanggalSampai  = $_POST['tanggalSampaiFormFilterBukuWithDate'] . " 23:59:59";

            $execQueryGetAllDataHistoriFilterBukuWithDate = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, BUKU, BULAN AS pembayaran_bulan, BUKU_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                BUKU != 0
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
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
                FROM input_data_sd
                WHERE
                BUKU != 0
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

        } else if (isset($_POST['nextPageFilterSeragam'])) {

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

            $queryGetDataSeragam = "
                SELECT ID, NIS, NAMA, kelas, SERAGAM, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                SERAGAM != 0
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataSeragam    = mysqli_query($con, $queryGetDataSeragam);
            $hitungDataFilterSeragam = mysqli_num_rows($execQueryDataSeragam);

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, SERAGAM, TRANSAKSI, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
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

        } else if (isset($_POST['previousPageFilterSeragam'])) {

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

            $queryGetDataSeragam = "
                SELECT ID, NIS, NAMA, kelas, SERAGAM, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                SERAGAM != 0
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataBuku     = mysqli_query($con, $queryGetDataSeragam);
            $hitungDataFilterSeragam  = mysqli_num_rows($execQueryDataBuku);

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, SERAGAM, TRANSAKSI, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
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

        } else if (isset($_POST['toPageFilterSeragam'])) {

            $halamanAktif = $_POST['halamanKeFilterSeragam'];
            $iniScrollNextPage = "ada";

            $namaMurid = $_POST['namaSiswaFilterSeragam'];
            $isifilby  = $_POST['iniFilterSeragam'];

            $namaSiswa = $namaMurid;
            $id        = $_POST['idSiswaFilterSeragam'];
            $nis       = $_POST['nisFormFilterSeragam'];
            $panggilan = $_POST['panggilanFormFilterSeragam'];
            $kelas     = $_POST['kelasFormFilterSeragam'];

            $queryGetDataSeragam = "
                SELECT ID, NIS, NAMA, kelas, SERAGAM, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                SERAGAM != 0
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataSeragam    = mysqli_query($con, $queryGetDataSeragam);
            $hitungDataFilterSeragam = mysqli_num_rows($execQueryDataSeragam);

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, SERAGAM, TRANSAKSI, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
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

        } else if (isset($_POST['firstPageFilterSeragam'])) {

            $namaMurid      = $_POST['namaFormFilterSeragam'];

            $id             = $_POST['idSiswaFilterSeragam'];
            $nis            = $_POST['nisFormFilterSeragam'];
            $kelas          = $_POST['kelasFormFilterSeragam'];
            $panggilan      = $_POST['panggilanFormFilterSeragam'];
            $namaSiswa      = $namaMurid;

            $isifilby       = $_POST['iniFilterSeragam'];

            $iniScrollPreviousPage  = "ada";

            $execQueryGetAllDataHistoriFilterSeragam = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, SERAGAM, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
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
                FROM input_data_sd
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

        } else if (isset($_POST['lastPageFilterSeragam'])) {

            $namaMurid      = $_POST['namaSiswaFilterSeragam'];
            $isifilby       = $_POST['iniFilterSeragam'];

            $id             = $_POST['idSiswaFilterSeragam'];
            $namaSiswa      = $namaMurid;
            $kelas          = $_POST['kelasFormFilterSeragam'];
            $panggilan      = $_POST['panggilanFormFilterSeragam'];
            $nis            = $_POST['nisFormFilterSeragam'];

            $iniScrollPreviousPage  = "ada";

            $execQueryGetAllDataHistoriFilterSeragam = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, SERAGAM, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
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
                FROM input_data_sd
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

        } else if (isset($_POST['nextPageFilterSeragamWithDate'])) {

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

            $tanggalDari    = $_POST['tanggalDariFormFilterSeragamWithDate'] . " 00:00:00";
            $tanggalSampai  = $_POST['tanggalSampaiFormFilterSeragamWithDate'] . " 23:59:59";

            $queryGetDataSeragamWithDate = "
                SELECT ID, NIS, NAMA, kelas, SERAGAM, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                SERAGAM != 0
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataSeragamWithDate    = mysqli_query($con, $queryGetDataSeragamWithDate);
            $hitungDataFilterSeragamWithDate = mysqli_num_rows($execQueryDataSeragamWithDate);

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, SERAGAM, TRANSAKSI, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                SERAGAM != 0
                AND NAMA LIKE '%$namaMurid%'
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
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

        } else if (isset($_POST['previousPageFilterSeragamWithDate'])) {

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

            $tanggalDari    = $_POST['tanggalDariFormFilterSeragamWithDate'] . " 00:00:00";
            $tanggalSampai  = $_POST['tanggalSampaiFormFilterSeragamWithDate'] . " 23:59:59";

            $queryGetDataSeragamWithDate = "
                SELECT ID, NIS, NAMA, kelas, SERAGAM, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                SERAGAM != 0
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataSeragamWithDate    = mysqli_query($con, $queryGetDataSeragamWithDate);
            $hitungDataFilterSeragamWithDate = mysqli_num_rows($execQueryDataSeragamWithDate);

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, SERAGAM, TRANSAKSI, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                SERAGAM != 0
                AND NAMA LIKE '%$namaMurid%'
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai' 
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

        } else if (isset($_POST['toPageFilterSeragamWithDate'])) {

            $halamanAktif = $_POST['halamanKeFilterSeragamWithDate'];
            $iniScrollNextPage = "ada";

            $namaMurid = $_POST['namaSiswaFilterSeragamWithDate'];
            $isifilby  = $_POST['iniFilterSeragamWithDate'];

            $namaSiswa = $namaMurid;
            $id        = $_POST['idSiswaFilterSeragamWithDate'];
            $nis       = $_POST['nisFormFilterSeragamWithDate'];
            $panggilan = $_POST['panggilanFormFilterSeragamWithDate'];
            $kelas     = $_POST['kelasFormFilterSeragamWithDate'];

            $tanggalDari    = $_POST['tanggalDariFormFilterSeragamWithDate'] . " 00:00:00";
            $tanggalSampai  = $_POST['tanggalSampaiFormFilterSeragamWithDate'] . " 23:59:59";

            $queryGetDataSeragamWithDate = "
                SELECT ID, NIS, NAMA, kelas, SERAGAM, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                SERAGAM != 0
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataSeragamWithDate    = mysqli_query($con, $queryGetDataSeragamWithDate);
            $hitungDataFilterSeragamWithDate = mysqli_num_rows($execQueryDataSeragamWithDate);

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, SERAGAM, TRANSAKSI, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                SERAGAM != 0
                AND NAMA LIKE '%$namaMurid%'
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
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

        } else if (isset($_POST['firstPageFilterSeragamWithDate'])) {

            $namaMurid      = $_POST['namaFormFilterSeragamWithDate'];

            $id             = $_POST['idSiswaFilterSeragamWithDate'];
            $nis            = $_POST['nisFormFilterSeragamWithDate'];
            $kelas          = $_POST['kelasFormFilterSeragamWithDate'];
            $panggilan      = $_POST['panggilanFormFilterSeragamWithDate'];
            $namaSiswa      = $namaMurid;

            $isifilby       = $_POST['iniFilterSeragamWithDate'];

            $iniScrollPreviousPage  = "ada";

            $tanggalDari    = $_POST['tanggalDariFormFilterSeragamWithDate'] . ' 00:00:00';
            $tanggalSampai  = $_POST['tanggalSampaiFormFilterSeragamWithDate'] . ' 23:59:59';

            $execQueryGetAllDataHistoriFilterSeragamWithDate = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, SERAGAM, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                SERAGAM != 0
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
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
                FROM input_data_sd
                WHERE
                SERAGAM != 0
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

        } else if (isset($_POST['lastPageFilterSeragamWithDate'])) {

            $namaMurid      = $_POST['namaSiswaFilterSeragamWithDate'];
            $isifilby       = $_POST['iniFilterSeragamWithDate'];

            $id             = $_POST['idSiswaFilterSeragamWithDate'];
            $namaSiswa      = $namaMurid;
            $kelas          = $_POST['kelasFormFilterSeragamWithDate'];
            $panggilan      = $_POST['panggilanFormFilterSeragamWithDate'];
            $nis            = $_POST['nisFormFilterSeragamWithDate'];

            $iniScrollPreviousPage  = "ada";

            $tanggalDari    = $_POST['tanggalDariFormFilterSeragamWithDate'] . " 00:00:00";
            $tanggalSampai  = $_POST['tanggalSampaiFormFilterSeragamWithDate'] . " 23:59:59";

            $execQueryGetAllDataHistoriFilterSeragamWithDate = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, SERAGAM, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                SERAGAM != 0
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
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
                FROM input_data_sd
                WHERE
                SERAGAM != 0
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

        } else if (isset($_POST['nextPageFilterRegistrasi'])) {

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

            $queryGetDataRegistrasi = "
                SELECT ID, NIS, NAMA, kelas, REGISTRASI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                REGISTRASI != 0
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataRegistrasi    = mysqli_query($con, $queryGetDataRegistrasi);
            $hitungDataFilterRegistrasi = mysqli_num_rows($execQueryDataRegistrasi);

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, REGISTRASI, TRANSAKSI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
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

        } else if (isset($_POST['previousPageFilterRegistrasi'])) {

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

            $queryGetDataRegistrasi = "
                SELECT ID, NIS, NAMA, kelas, REGISTRASI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                REGISTRASI != 0
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataBuku     = mysqli_query($con, $queryGetDataRegistrasi);
            $hitungDataFilterRegistrasi  = mysqli_num_rows($execQueryDataBuku);

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, REGISTRASI, TRANSAKSI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
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

        } else if (isset($_POST['toPageFilterRegistrasi'])) {

            $halamanAktif = $_POST['halamanKeFilterRegistrasi'];
            $iniScrollNextPage = "ada";

            $namaMurid = $_POST['namaSiswaFilterRegistrasi'];
            $isifilby  = $_POST['iniFilterRegistrasi'];

            $namaSiswa = $namaMurid;
            $id        = $_POST['idSiswaFilterRegistrasi'];
            $nis       = $_POST['nisFormFilterRegistrasi'];
            $panggilan = $_POST['panggilanFormFilterRegistrasi'];
            $kelas     = $_POST['kelasFormFilterRegistrasi'];

            $queryGetDataRegistrasi = "
                SELECT ID, NIS, NAMA, kelas, REGISTRASI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                REGISTRASI != 0
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataRegistrasi    = mysqli_query($con, $queryGetDataRegistrasi);
            $hitungDataFilterRegistrasi = mysqli_num_rows($execQueryDataRegistrasi);

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, REGISTRASI, TRANSAKSI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
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

        } else if (isset($_POST['firstPageFilterRegistrasi'])) {

            $namaMurid      = $_POST['namaFormFilterRegistrasi'];

            $id             = $_POST['idSiswaFilterRegistrasi'];
            $nis            = $_POST['nisFormFilterRegistrasi'];
            $kelas          = $_POST['kelasFormFilterRegistrasi'];
            $panggilan      = $_POST['panggilanFormFilterRegistrasi'];
            $namaSiswa      = $namaMurid;

            $isifilby       = $_POST['iniFilterRegistrasi'];

            $iniScrollPreviousPage  = "ada";

            $execQueryGetAllDataHistoriFilterRegistrasi = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, REGISTRASI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
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
                FROM input_data_sd
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

        } else if (isset($_POST['lastPageFilterRegistrasi'])) {

            $namaMurid      = $_POST['namaSiswaFilterRegistrasi'];
            $isifilby       = $_POST['iniFilterRegistrasi'];

            $id             = $_POST['idSiswaFilterRegistrasi'];
            $namaSiswa      = $namaMurid;
            $kelas          = $_POST['kelasFormFilterRegistrasi'];
            $panggilan      = $_POST['panggilanFormFilterRegistrasi'];
            $nis            = $_POST['nisFormFilterRegistrasi'];

            $iniScrollPreviousPage  = "ada";

            $execQueryGetAllDataHistoriFilterRegistrasi = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, REGISTRASI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
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
                FROM input_data_sd
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

        } else if (isset($_POST['nextPageFilterRegistrasiWithDate'])) {

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

            $tanggalDari    = $_POST['tanggalDariFormFilterRegistrasiWithDate'] . " 00:00:00";
            $tanggalSampai  = $_POST['tanggalSampaiFormFilterRegistrasiWithDate'] . " 23:59:59";

            $queryGetDataRegistrasiWithDate = "
                SELECT ID, NIS, NAMA, kelas, REGISTRASI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                REGISTRASI != 0
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
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
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
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

        } else if (isset($_POST['previousPageFilterRegistrasiWithDate'])) {

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

            $tanggalDari    = $_POST['tanggalDariFormFilterRegistrasiWithDate'] . " 00:00:00";
            $tanggalSampai  = $_POST['tanggalSampaiFormFilterRegistrasiWithDate'] . " 23:59:59";

            $queryGetDataRegistrasiWithDate = "
                SELECT ID, NIS, NAMA, DATE, kelas, REGISTRASI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                REGISTRASI != 0
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
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
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai' 
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

        } else if (isset($_POST['toPageFilterRegistrasiWithDate'])) {

            $halamanAktif = $_POST['halamanKeFilterRegistrasiWithDate'];
            $iniScrollNextPage = "ada";

            $namaMurid = $_POST['namaSiswaFilterRegistrasiWithDate'];
            $isifilby  = $_POST['iniFilterRegistrasiWithDate'];

            $namaSiswa = $namaMurid;
            $id        = $_POST['idSiswaFilterRegistrasiWithDate'];
            $nis       = $_POST['nisFormFilterRegistrasiWithDate'];
            $panggilan = $_POST['panggilanFormFilterRegistrasiWithDate'];
            $kelas     = $_POST['kelasFormFilterRegistrasiWithDate'];

            $tanggalDari    = $_POST['tanggalDariFormFilterRegistrasiWithDate'] . " 00:00:00";
            $tanggalSampai  = $_POST['tanggalSampaiFormFilterRegistrasiWithDate'] . " 23:59:59";

            $queryGetDataRegistrasiWithDate = "
                SELECT ID, NIS, NAMA, kelas, REGISTRASI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                REGISTRASI != 0
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataRegistrasiWithDate    = mysqli_query($con, $queryGetDataRegistrasiWithDate);
            $hitungDataFilterRegistrasiWithDate = mysqli_num_rows($execQueryDataRegistrasiWithDate);

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, REGISTRASI, TRANSAKSI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                REGISTRASI != 0
                AND NAMA LIKE '%$namaMurid%'
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
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

        } else if (isset($_POST['firstPageFilterRegistrasiWithDate'])) {

            $namaMurid      = $_POST['namaFormFilterRegistrasiWithDate'];

            $id             = $_POST['idSiswaFilterRegistrasiWithDate'];
            $nis            = $_POST['nisFormFilterRegistrasiWithDate'];
            $kelas          = $_POST['kelasFormFilterRegistrasiWithDate'];
            $panggilan      = $_POST['panggilanFormFilterRegistrasiWithDate'];
            $namaSiswa      = $namaMurid;

            $isifilby       = $_POST['iniFilterRegistrasiWithDate'];

            $iniScrollPreviousPage  = "ada";

            $tanggalDari    = $_POST['tanggalDariFormFilterRegistrasiWithDate'] . ' 00:00:00';
            $tanggalSampai  = $_POST['tanggalSampaiFormFilterRegistrasiWithDate'] . ' 23:59:59';

            $execQueryGetAllDataHistoriFilterRegistrasiWithDate = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, REGISTRASI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                REGISTRASI != 0
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
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
                FROM input_data_sd
                WHERE
                REGISTRASI != 0
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

        } else if (isset($_POST['lastPageFilterRegistrasiWithDate'])) {

            $namaMurid      = $_POST['namaSiswaFilterRegistrasiWithDate'];
            $isifilby       = $_POST['iniFilterRegistrasiWithDate'];

            $id             = $_POST['idSiswaFilterRegistrasiWithDate'];
            $namaSiswa      = $namaMurid;
            $kelas          = $_POST['kelasFormFilterRegistrasiWithDate'];
            $panggilan      = $_POST['panggilanFormFilterRegistrasiWithDate'];
            $nis            = $_POST['nisFormFilterRegistrasiWithDate'];

            $iniScrollPreviousPage  = "ada";

            $tanggalDari    = $_POST['tanggalDariFormFilterRegistrasiWithDate'] . " 00:00:00";
            $tanggalSampai  = $_POST['tanggalSampaiFormFilterRegistrasiWithDate'] . " 23:59:59";

            $execQueryGetAllDataHistoriFilterRegistrasiWithDate = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, REGISTRASI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                REGISTRASI != 0
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
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
                FROM input_data_sd
                WHERE
                REGISTRASI != 0
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

        } else if (isset($_POST['nextPageFilterLain'])) {

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

            $queryGetDataLain = "
                SELECT ID, NIS, NAMA, kelas, LAIN, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                LAIN != 0
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataLain    = mysqli_query($con, $queryGetDataLain);
            $hitungDataFilterLain = mysqli_num_rows($execQueryDataLain);

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, LAIN, TRANSAKSI, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
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

        } else if (isset($_POST['previousPageFilterLain'])) {

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

            $queryGetDataLain = "
                SELECT ID, NIS, NAMA, kelas, LAIN, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                LAIN != 0
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataLain     = mysqli_query($con, $queryGetDataLain);
            $hitungDataFilterLain  = mysqli_num_rows($execQueryDataLain);

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, LAIN, TRANSAKSI, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
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

        } else if (isset($_POST['toPageFilterLain'])) {

            $halamanAktif = $_POST['halamanKeFilterLain'];
            $iniScrollNextPage = "ada";

            $namaMurid = $_POST['namaSiswaFilterLain'];
            $isifilby  = $_POST['iniFilterLain'];

            $namaSiswa = $namaMurid;
            $id        = $_POST['idSiswaFilterLain'];
            $nis       = $_POST['nisFormFilterLain'];
            $panggilan = $_POST['panggilanFormFilterLain'];
            $kelas     = $_POST['kelasFormFilterLain'];

            $queryGetDataLain = "
                SELECT ID, NIS, NAMA, kelas, LAIN, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                LAIN != 0
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataLain    = mysqli_query($con, $queryGetDataLain);
            $hitungDataFilterLain = mysqli_num_rows($execQueryDataLain);

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, LAIN, TRANSAKSI, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
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

        } else if (isset($_POST['firstPageFilterLain'])) {

            $namaMurid      = $_POST['namaFormFilterLain'];

            $id             = $_POST['idSiswaFilterLain'];
            $nis            = $_POST['nisFormFilterLain'];
            $kelas          = $_POST['kelasFormFilterLain'];
            $panggilan      = $_POST['panggilanFormFilterLain'];
            $namaSiswa      = $namaMurid;

            $isifilby       = $_POST['iniFilterLain'];

            $iniScrollPreviousPage  = "ada";

            $execQueryGetAllDataHistoriFilterLain = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, LAIN, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
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
                FROM input_data_sd
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

        } else if (isset($_POST['lastPageFilterLain'])) {

            $namaMurid      = $_POST['namaSiswaFilterLain'];
            $isifilby       = $_POST['iniFilterLain'];

            $id             = $_POST['idSiswaFilterLain'];
            $namaSiswa      = $namaMurid;
            $kelas          = $_POST['kelasFormFilterLain'];
            $panggilan      = $_POST['panggilanFormFilterLain'];
            $nis            = $_POST['nisFormFilterLain'];

            $iniScrollPreviousPage  = "ada";

            $execQueryGetAllDataHistoriFilterLain = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, LAIN, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
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
                FROM input_data_sd
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

        } else if (isset($_POST['nextPageFilterLainWithDate'])) {

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

            $tanggalDari    = $_POST['tanggalDariFormFilterLainWithDate'] . " 00:00:00";
            $tanggalSampai  = $_POST['tanggalSampaiFormFilterLainWithDate'] . " 23:59:59";

            $queryGetDataLainWithDate = "
                SELECT ID, NIS, NAMA, kelas, LAIN, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                LAIN != 0
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
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
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
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

        } else if (isset($_POST['previousPageFilterLainWithDate'])) {

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

            $tanggalDari    = $_POST['tanggalDariFormFilterLainWithDate'] . " 00:00:00";
            $tanggalSampai  = $_POST['tanggalSampaiFormFilterLainWithDate'] . " 23:59:59";

            $queryGetDatLainWithDate = "
                SELECT ID, NIS, NAMA, kelas, LAIN, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                LAIN != 0
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
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
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai' 
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

        } else if (isset($_POST['toPageFilterLainWithDate'])) {

            $halamanAktif = $_POST['halamanKeFilterLainWithDate'];
            $iniScrollNextPage = "ada";

            $namaMurid = $_POST['namaSiswaFilterLainWithDate'];
            $isifilby  = $_POST['iniFilterLainWithDate'];

            $namaSiswa = $namaMurid;
            $id        = $_POST['idSiswaFilterLainWithDate'];
            $nis       = $_POST['nisFormFilterLainWithDate'];
            $panggilan = $_POST['panggilanFormFilterLainWithDate'];
            $kelas     = $_POST['kelasFormFilterLainWithDate'];

            $tanggalDari    = $_POST['tanggalDariFormFilterLainWithDate'] . " 00:00:00";
            $tanggalSampai  = $_POST['tanggalSampaiFormFilterLainWithDate'] . " 23:59:59";

            $queryGetDataLainWithDate = "
                SELECT ID, NIS, NAMA, kelas, LAIN, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                LAIN != 0
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
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
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
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

        } else if (isset($_POST['firstPageFilterLainWithDate'])) {

            $namaMurid      = $_POST['namaFormFilterLainWithDate'];

            $id             = $_POST['idSiswaFilterLainWithDate'];
            $nis            = $_POST['nisFormFilterLainWithDate'];
            $kelas          = $_POST['kelasFormFilterLainWithDate'];
            $panggilan      = $_POST['panggilanFormFilterLainWithDate'];
            $namaSiswa      = $namaMurid;

            $isifilby       = $_POST['iniFilterLainWithDate'];

            $iniScrollPreviousPage  = "ada";

            $tanggalDari    = $_POST['tanggalDariFormFilterLainWithDate'] . " 00:00:00";
            $tanggalSampai  = $_POST['tanggalSampaiFormFilterLainWithDate'] . " 23:59:59";

            $execQueryGetAllDataHistoriFilterLainWithDate = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, LAIN, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                LAIN != 0
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
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

        } else if (isset($_POST['lastPageFilterLainWithDate'])) {

            $namaMurid      = $_POST['namaSiswaFilterLainWithDate'];
            $isifilby       = $_POST['iniFilterLainWithDate'];

            $id             = $_POST['idSiswaFilterLainWithDate'];
            $namaSiswa      = $namaMurid;
            $kelas          = $_POST['kelasFormFilterLainWithDate'];
            $panggilan      = $_POST['panggilanFormFilterLainWithDate'];
            $nis            = $_POST['nisFormFilterLainWithDate'];

            $iniScrollPreviousPage  = "ada";

            $tanggalDari    = $_POST['tanggalDariFormFilterLainWithDate'] . " 00:00:00";
            $tanggalSampai  = $_POST['tanggalSampaiFormFilterLainWithDate'] . " 23:59:59";

            $execQueryGetAllDataHistoriFilterLainWithDate = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, LAIN, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                LAIN != 0
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
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
                FROM input_data_sd
                WHERE
                LAIN != 0
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

        } else {

            $halamanAktif = 1;

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

    } else {

        // histori input data tk
        $queryGetAllDataHistori     = "SELECT * FROM input_data_tk";
        $execQueryGetAllDataHistori = mysqli_query($con, $queryGetAllDataHistori);

        $halamanAktif = "";
        
        $jumlahData = 5;
        $totalData = mysqli_num_rows($execQueryGetAllDataHistori);

        $jumlahPagination = ceil($totalData / $jumlahData);
        // echo $jumlahPagination;

        if (isset($_POST['toPage'])) {
            // echo $_POST['teslg'];exit;
            $halamanAktif = $_POST['halamanKe'];
            $iniScrollNextPage = "ada";

            $totalHalamanTambah100 = $halamanAktif + 100;

            if ($totalHalamanTambah100 <= $jumlahPagination) {
                $showAddPage100 = "muncul";
            } else {
                $showAddPage100 = "tidak_muncul";
            }

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;
            // echo $dataAwal . "<br>";
            $ambildata_perhalaman = mysqli_query($con, "SELECT * FROM input_data_tk ORDER BY ID DESC LIMIT $dataAwal, $jumlahData  ");
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

        } else if (isset($_POST['nextPage'])) {

            $halamanAktif = $_POST['halamanLanjut'];
            $iniScrollNextPage = "ada";

            $totalHalamanTambah100 = $halamanAktif + 100;

            if ($totalHalamanTambah100 <= $jumlahPagination) {
                $showAddPage100 = "muncul";
            } else {
                $showAddPage100 = "tidak_muncul";
            }

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;
            // echo $dataAwal . "<br>";
            $ambildata_perhalaman = mysqli_query($con, "SELECT * FROM input_data_tk ORDER BY ID DESC LIMIT $dataAwal, $jumlahData  ");
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

        } else if (isset($_POST['previousPage'])) {

            $halamanAktif = $_POST['backPage'];
            $iniScrollPreviousPage  = "ada";

            $totalHalamanTambah100 = $halamanAktif + 100;

            if ($totalHalamanTambah100 <= $jumlahPagination) {
                $showAddPage100 = "muncul";
            } else {
                $showAddPage100 = "tidak_muncul";
            }

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;
            // echo $dataAwal . "<br>";
            $ambildata_perhalaman = mysqli_query($con, "SELECT * FROM input_data_tk ORDER BY ID DESC LIMIT $dataAwal, $jumlahData  ");
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

        } else if (isset($_POST['firstPage'])) {

            $halamanAktif = 1;
            $iniScrollPreviousPage  = "ada";

            $totalHalamanTambah100 = $halamanAktif + 100;

            if ($totalHalamanTambah100 <= $jumlahPagination) {
                $showAddPage100 = "muncul";
            } else {
                $showAddPage100 = "tidak_muncul";
            }

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;
            // echo $dataAwal . "<br>";
            $ambildata_perhalaman = mysqli_query($con, "SELECT * FROM input_data_tk ORDER BY ID DESC LIMIT $dataAwal, $jumlahData  ");
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

        } else if (isset($_POST['addPage100'])) {

            $halamanAktif = $_POST['paginationSekarangTambah100'] + 100;
            $iniScrollPreviousPage  = "ada";

            $showAddPage100 = "";

            $totalHalamanTambah100 = $halamanAktif + 100;

            if ($totalHalamanTambah100 <= $jumlahPagination) {
                $showAddPage100 = "muncul";
            } else {
                $showAddPage100 = "tidak_muncul";
            }            

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;
            // echo $dataAwal . "<br>";
            $ambildata_perhalaman = mysqli_query($con, "SELECT * FROM input_data_tk ORDER BY ID DESC LIMIT $dataAwal, $jumlahData  ");
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

        } else if (isset($_POST['reductionPage100'])) {

            $halamanAktif = $_POST['paginationSekarangKurang100'] - 100;

            $iniScrollPreviousPage = "ada";

            $showAddPage100 = "";

            $totalHalamanTambah100 = $halamanAktif + 100;

            if ($totalHalamanTambah100 <= $jumlahPagination) {
                $showAddPage100 = "muncul";
            } else {
                $showAddPage100 = "tidak_muncul";
            }

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;
            // echo $dataAwal . "<br>";
            $ambildata_perhalaman = mysqli_query($con, "SELECT * FROM input_data_tk ORDER BY ID DESC LIMIT $dataAwal, $jumlahData  ");
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

        } else if (isset($_POST['nextLastPage'])) {

            $halamanAktif = $jumlahPagination;
            $iniScrollPreviousPage  = "ada";

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;
            // echo $dataAwal . "<br>";
            $ambildata_perhalaman = mysqli_query($con, "SELECT * FROM input_data_tk ORDER BY ID DESC LIMIT $dataAwal, $jumlahData  ");
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

        } else if (isset($_POST['filter_by'])) {
            
            $halamanAktif = 1;

            if ($_SESSION['form_kosong'] == 'form_not_empty') {
                $iniScrollFilterPage;
            } else if($_SESSION['form_kosong'] == 'filter_kosong') {
                $iniScrollFilterPage;
            } else if($_SESSION['form_kosong'] == 'empty_form') {
                $iniScrollFilterPage;
            } else if ($_SESSION['form_kosong'] == 'hanya_tanggal_dari') {         
                $iniScrollFilterPage;
            } else if ($_SESSION['form_kosong'] == 'hanya_tanggal_sampai') {         
                $iniScrollFilterPage;
            } else if($_SESSION['form_kosong'] == 'tanggal_awal_lebih_besar') {
                $iniScrollFilterPage;
            } else {
                $iniScrollFilterPage = "ada";
            }

            $hitungDataFilterSPP = "";

            if ($_POST['isi_filter'] != 'kosong' ) {
                $dariTanggal    = $_POST['tanggal1'] . " 00:00:00";
                $sampaiTanggal  = $_POST['tanggal2'] . " 23:59:59";
                
                // SPP
                if ($_POST['isi_filter'] == 'SPP') {

                    // Jika filter by SPP sedangkan filter tanggal dari dan tanggal sampai tidak di isi 
                    if ($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59") {

                        // Data SPP
                        // echo "Masuk filter SPP tanpa filter tanggal dari dan tanggal sampai";exit;
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

                    } else if ($dariTanggal != " 00:00:00" && $sampaiTanggal == " 23:59:59") {

                        $id                 = "";
                        $nis                = "";
                        $namaSiswa          = "";
                        $kelas              = "";
                        $panggilan          = "";

                        $isifilby           = "kosong";

                        $halamanAktif = 1;

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
                        $ambildata_perhalaman = mysqli_query($con, "SELECT * FROM input_data_tk ORDER BY ID DESC LIMIT $dataAwal, $jumlahData  ");
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

                    } else if ($dariTanggal > $sampaiTanggal) {

                        $id                 = "";
                        $nis                = "";
                        $namaSiswa          = "";
                        $kelas              = "";
                        $panggilan          = "";

                        $isifilby           = "kosong";

                        $halamanAktif = 1;

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
                        $ambildata_perhalaman = mysqli_query($con, "SELECT * FROM input_data_tk ORDER BY ID DESC LIMIT $dataAwal, $jumlahData  ");
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

                    } else if ($dariTanggal != " 00:00:00" && $sampaiTanggal != " 23:59:59") {

                        // echo "Masuk ke filter tanggal lengkap";

                        // Data Filter SPP dan tanggal Filter
                        // echo "Masuk ke filter tanggal " . $dariTanggal . " & " . $sampaiTanggal;
                        $namaMurid = $namaSiswa;

                        $tanggalDari    = $_POST['tanggal1'];
                        $tanggalSampai  = $_POST['tanggal2'];

                        $queryGetDataSPP = "
                            SELECT ID, NIS, NAMA, kelas, SPP, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                            FROM input_data_tk
                            WHERE
                            SPP != 0
                            AND NAMA LIKE '%$namaMurid%'
                            AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                        ";

                        $execQueryDataSPP    = mysqli_query($con, $queryGetDataSPP);
                        // $hitungDataFilterSPP = mysqli_num_rows($execQueryDataSPP);
                        $hitungDataFilterSPPDate = mysqli_num_rows($execQueryDataSPP);

                        $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

                        $ambildata_perhalaman = mysqli_query($con, "
                            SELECT ID, NIS, NAMA, DATE, kelas, SPP, TRANSAKSI, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                            FROM input_data_tk
                            WHERE
                            SPP != 0
                            AND NAMA LIKE '%$namaMurid%'
                            AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                            LIMIT $dataAwal, $jumlahData
                        ");

                        $jumlahPagination = ceil($hitungDataFilterSPPDate / $jumlahData);

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

                    } else if ($dariTanggal == " 00:00:00" && $sampaiTanggal != " 23:59:59") {
                        $id                 = "";
                        $nis                = "";
                        $namaSiswa          = "";
                        $kelas              = "";
                        $panggilan          = "";

                        $isifilby           = "kosong";

                        $halamanAktif = 1;

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
                        $ambildata_perhalaman = mysqli_query($con, "SELECT * FROM input_data_tk ORDER BY ID DESC LIMIT $dataAwal, $jumlahData  ");
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
                }

                // PANGKAL
                else if ($_POST['isi_filter'] == 'PANGKAL') {

                    // echo "Pangkal";exit;
                    // Jika filter by SPP sedangkan filter tanggal dari dan tanggal sampai tidak di isi

                    if ($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59") {

                        // Data PANGKAL
                        // echo "Masuk filter PANGKAL tanpa filter tanggal dari dan tanggal sampai";exit;
                        $namaMurid = $namaSiswa;
                        $queryGetDataPANGKAL = "
                        SELECT ID, NIS, NAMA, kelas, PANGKAL, BULAN AS pembayaran_bulan, PANGKAL_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                        FROM input_data_tk
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

                    } else if ($dariTanggal != " 00:00:00" && $sampaiTanggal == " 23:59:59") {

                        $id                 = "";
                        $nis                = "";
                        $namaSiswa          = "";
                        $kelas              = "";
                        $panggilan          = "";

                        $isifilby           = "kosong";

                        $halamanAktif = 1;

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
                        $ambildata_perhalaman = mysqli_query($con, "SELECT * FROM input_data_tk LIMIT $dataAwal, $jumlahData  ");
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

                    } else if ($dariTanggal > $sampaiTanggal) {

                        $id                 = "";
                        $nis                = "";
                        $namaSiswa          = "";
                        $kelas              = "";
                        $panggilan          = "";

                        $isifilby           = "kosong";

                        $halamanAktif = 1;

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
                        $ambildata_perhalaman = mysqli_query($con, "SELECT * FROM input_data_tk LIMIT $dataAwal, $jumlahData  ");
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

                    } else if ($dariTanggal != " 00:00:00" && $sampaiTanggal != " 23:59:59") {

                        // echo "Masuk ke filter tanggal lengkap";

                        // Data Filter PANGKAL dan tanggal Filter
                        // echo "Masuk ke filter tanggal " . $dariTanggal . " & " . $sampaiTanggal;
                        $namaMurid = $namaSiswa;

                        $tanggalDari    = $_POST['tanggal1'];
                        $tanggalSampai  = $_POST['tanggal2']; 

                        $queryGetDataPangkal = "
                            SELECT ID, NIS, NAMA, kelas, PANGKAL, BULAN AS pembayaran_bulan, PANGKAL_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                            FROM input_data_tk
                            WHERE
                            PANGKAL != 0
                            AND NAMA LIKE '%$namaMurid%'
                            AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                        ";

                        $execQueryDataPangkal    = mysqli_query($con, $queryGetDataPangkal);
                        // $hitungDataFilterPANGKAL = mysqli_num_rows($execQueryDataPangkal);
                        $hitungDataFilterPangkalDate = mysqli_num_rows($execQueryDataPangkal);
                        // echo "Jumlah Data : ". $hitungDataFilterPangkalDate;
                        // echo $hitungDataFilterPANGKAL;exit;

                        $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

                        $ambildata_perhalaman = mysqli_query($con, "
                            SELECT ID, NIS, NAMA, DATE, kelas, PANGKAL, TRANSAKSI, BULAN AS pembayaran_bulan, PANGKAL_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                            FROM input_data_tk
                            WHERE
                            PANGKAL != 0
                            AND NAMA LIKE '%$namaMurid%'
                            AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                            LIMIT $dataAwal, $jumlahData
                        ");

                        $jumlahPagination = ceil($hitungDataFilterPangkalDate / $jumlahData);

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

                // SEMUA
                else if ($_POST['isi_filter'] == 'SEMUA') {

                    // echo "SEMUA";exit;
                    if ($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59") {

                        $namaMurid = $namaSiswa;
                        $queryGetDataFilterSemua = "
                        SELECT * FROM input_data_tk WHERE NAMA LIKE '%$namaMurid%' ";
                        $execQueryDataFilterSemua    = mysqli_query($con, $queryGetDataFilterSemua);
                        $hitungDataFilterSemua = mysqli_num_rows($execQueryDataFilterSemua);
                        // echo $hitungDataFilterSemua;

                        $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;
                        // echo $dataAwal . "<br>";
                        $ambildata_perhalaman = mysqli_query($con, "SELECT * FROM input_data_tk WHERE NAMA LIKE '%$namaMurid%' ORDER BY ID DESC LIMIT $dataAwal, $jumlahData");

                        $jumlahPagination = ceil($hitungDataFilterSemua / $jumlahData);
                        // echo $jumlahPagination;

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

                    } else if ($dariTanggal != " 00:00:00" && $sampaiTanggal != " 23:59:59") {

                        // echo $dariTanggal . " & " . $sampaiTanggal;exit;

                        $namaMurid = $namaSiswa;

                        $tanggalDari    = $_POST['tanggal1'];
                        $tanggalSampai  = $_POST['tanggal2']; 

                        $queryGetDataFilterSemuaWithDate = "
                            SELECT * FROM input_data_tk 
                            WHERE
                            NAMA LIKE '%$namaMurid%'
                            AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                        ";

                        $execQueryDataFilterSemuaWithDate    = mysqli_query($con, $queryGetDataFilterSemuaWithDate);
                        // $hitungDataFilterSPP = mysqli_num_rows($execQueryDataFilterSemuaWithDate);
                        $hitungDataFilterSemuaWithDate = mysqli_num_rows($execQueryDataFilterSemuaWithDate);

                        $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

                        $ambildata_perhalaman = mysqli_query($con, "
                            SELECT * FROM input_data_tk
                            WHERE
                            NAMA LIKE '%$namaMurid%'
                            AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                            ORDER BY STAMP ASC
                            LIMIT $dataAwal, $jumlahData
                        ");

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

                // KEGIATAN
                else if ($_POST['isi_filter'] == 'KEGIATAN') {

                    if ($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59") {

                        // echo $_POST['isi_filter'];exit;

                        $namaMurid = $namaSiswa;
                        $queryGetDataKegiatan = "
                        SELECT ID, NIS, NAMA, kelas, KEGIATAN, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                        FROM input_data_tk
                        WHERE
                        KEGIATAN != 0
                        AND NAMA LIKE '%$namaMurid%' ";

                        $execQueryDataKegiatan    = mysqli_query($con, $queryGetDataKegiatan);
                        $hitungDataFilterKegiatan = mysqli_num_rows($execQueryDataKegiatan);

                        $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;
                        // echo $dataAwal . "<br>";
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

                    } else if ($dariTanggal != " 00:00:00" && $sampaiTanggal != " 23:59:59") {

                        // echo $dariTanggal . " & " . $sampaiTanggal;exit;

                        $namaMurid = $namaSiswa;

                        $tanggalDari    = $_POST['tanggal1'];
                        $tanggalSampai  = $_POST['tanggal2']; 

                        $queryGetDataFilterKegiatanWithDate = "
                            SELECT ID, NIS, NAMA, kelas, KEGIATAN, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                            FROM input_data_tk
                            WHERE
                            KEGIATAN != 0
                            AND NAMA LIKE '%$namaMurid%'
                            AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                        ";

                        $execQueryDataFilterKegiatanWithDate    = mysqli_query($con, $queryGetDataFilterKegiatanWithDate);
                        // $hitungDataFilterPANGKAL = mysqli_num_rows($execQueryDataFilterKegiatanWithDate);
                        $hitungDataFilterKegiatanWithDate = mysqli_num_rows($execQueryDataFilterKegiatanWithDate);

                        // echo "Dari tanggal : " . $dariTanggal . "<br> ". "Sampai Tanggal : " . $sampaiTanggal . "<br> Jumlah Data : ". $hitungDataFilterKegiatanWithDate;
                        // echo $hitungDataFilterPANGKAL;exit;

                        $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

                        $ambildata_perhalaman = mysqli_query($con, "
                            SELECT ID, NIS, NAMA, DATE, kelas, KEGIATAN, TRANSAKSI, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                            FROM input_data_tk
                            WHERE
                            KEGIATAN != 0
                            AND NAMA LIKE '%$namaMurid%'
                            AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                            LIMIT $dataAwal, $jumlahData
                        ");

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

                // BUKU
                else if ($_POST['isi_filter'] == 'BUKU') {

                    if ($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59") {

                        $namaMurid = $namaSiswa;
                        $queryGetDataBuku = "
                        SELECT ID, NIS, NAMA, kelas, BUKU, BULAN AS pembayaran_bulan, BUKU_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                        FROM input_data_tk
                        WHERE
                        BUKU != 0
                        AND NAMA LIKE '%$namaMurid%' ";

                        $execQueryDataBuku    = mysqli_query($con, $queryGetDataBuku);
                        $hitungDataFilterBuku = mysqli_num_rows($execQueryDataBuku);

                        $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;
                        // echo $dataAwal . "<br>";
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

                    } else if ($dariTanggal != " 00:00:00" && $sampaiTanggal != " 23:59:59") {

                        $namaMurid = $namaSiswa;

                        $tanggalDari    = $_POST['tanggal1'];
                        $tanggalSampai  = $_POST['tanggal2']; 

                        $queryGetDataFilterBukuWithDate = "
                            SELECT ID, NIS, NAMA, kelas, BUKU, BULAN AS pembayaran_bulan, BUKU_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                            FROM input_data_tk
                            WHERE
                            BUKU != 0
                            AND NAMA LIKE '%$namaMurid%'
                            AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                        ";

                        $execQueryDataFilterBukuWithDate    = mysqli_query($con, $queryGetDataFilterBukuWithDate);
                        // $hitungDataFilterPANGKAL = mysqli_num_rows($execQueryDataFilterBukuWithDate);
                        $hitungDataFilterBukuWithDate = mysqli_num_rows($execQueryDataFilterBukuWithDate);
                        // echo $hitungDataFilterBukuWithDate . "<br>";

                        // echo "Dari tanggal : " . $dariTanggal . "<br> ". "Sampai Tanggal : " . $sampaiTanggal . "<br> Jumlah Data : ". $hitungDataFilterBukuWithDate;
                        // echo $hitungDataFilterPANGKAL;exit;

                        $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

                        $ambildata_perhalaman = mysqli_query($con, "
                            SELECT ID, NIS, NAMA, DATE, kelas, BUKU, TRANSAKSI, BULAN AS pembayaran_bulan, BUKU_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                            FROM input_data_tk
                            WHERE
                            BUKU != 0
                            AND NAMA LIKE '%$namaMurid%'
                            AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                            LIMIT $dataAwal, $jumlahData
                        ");

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

                // SERAGAM
                else if ($_POST['isi_filter'] == 'SERAGAM') {

                    if ($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59") {

                        $namaMurid = $namaSiswa;
                        $queryGetDataSeragam = "
                        SELECT ID, NIS, NAMA, kelas, SERAGAM, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                        FROM input_data_tk
                        WHERE
                        SERAGAM != 0
                        AND NAMA LIKE '%$namaMurid%' ";

                        $execQueryDataSeragam    = mysqli_query($con, $queryGetDataSeragam);
                        $hitungDataFilterSeragam = mysqli_num_rows($execQueryDataSeragam);

                        $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;
                        // echo $dataAwal . "<br>";
                        $ambildata_perhalaman = mysqli_query($con, "
                            SELECT ID, NIS, NAMA, DATE, kelas, SERAGAM, TRANSAKSI, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                            FROM input_data_tk
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

                    } else if ($dariTanggal != " 00:00:00" && $sampaiTanggal != " 23:59:59") {

                        $namaMurid = $namaSiswa;

                        $tanggalDari    = $_POST['tanggal1'];
                        $tanggalSampai  = $_POST['tanggal2']; 

                        $queryGetDataFilterSeragamWithDate = "
                            SELECT ID, NIS, NAMA, kelas, SERAGAM, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                            FROM input_data_tk
                            WHERE
                            SERAGAM != 0
                            AND NAMA LIKE '%$namaMurid%'
                            AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                        ";

                        $execQueryDataFilterSeragamWithDate    = mysqli_query($con, $queryGetDataFilterSeragamWithDate);
                        // $hitungDataFilterPANGKAL = mysqli_num_rows($execQueryDataFilterSeragamWithDate);
                        $hitungDataFilterSeragamWithDate = mysqli_num_rows($execQueryDataFilterSeragamWithDate);
                        // echo $hitungDataFilterSeragamWithDate . "<br>";

                        // echo "Dari tanggal : " . $dariTanggal . "<br> ". "Sampai Tanggal : " . $sampaiTanggal . "<br> Jumlah Data : ". $hitungDataFilterSeragamWithDate;
                        // echo $hitungDataFilterPANGKAL;exit;

                        $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

                        $ambildata_perhalaman = mysqli_query($con, "
                            SELECT ID, NIS, NAMA, DATE, kelas, SERAGAM, TRANSAKSI, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                            FROM input_data_tk
                            WHERE
                            SERAGAM != 0
                            AND NAMA LIKE '%$namaMurid%'
                            AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                            LIMIT $dataAwal, $jumlahData
                        ");

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

                // REGISTRASI
                else if ($_POST['isi_filter'] == 'REGISTRASI') {

                    if ($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59") { 

                        $namaMurid = $namaSiswa;
                        $queryGetDataRegistrasi = "
                        SELECT ID, NIS, NAMA, kelas, REGISTRASI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                        FROM input_data_tk
                        WHERE
                        REGISTRASI != 0
                        AND NAMA LIKE '%$namaMurid%' ";

                        $execQueryDataRegistrasi    = mysqli_query($con, $queryGetDataRegistrasi);
                        $hitungDataFilterRegistrasi = mysqli_num_rows($execQueryDataRegistrasi);

                        $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;
                        // echo $dataAwal . "<br>";
                        $ambildata_perhalaman = mysqli_query($con, "
                            SELECT ID, NIS, NAMA, DATE, kelas, REGISTRASI, TRANSAKSI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                            FROM input_data_tk
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

                    } else if ($dariTanggal != " 00:00:00" && $sampaiTanggal != " 23:59:59") {

                        $namaMurid = $namaSiswa;

                        $tanggalDari    = $_POST['tanggal1'];
                        $tanggalSampai  = $_POST['tanggal2']; 

                        $queryGetDataFilterRegistrasiWithDate = "
                            SELECT ID, NIS, NAMA, kelas, REGISTRASI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                            FROM input_data_tk
                            WHERE
                            REGISTRASI != 0
                            AND NAMA LIKE '%$namaMurid%'
                            AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                        ";

                        $execQueryDataFilterRegistrasiWithDate    = mysqli_query($con, $queryGetDataFilterRegistrasiWithDate);
                        // $hitungDataFilterPANGKAL = mysqli_num_rows($execQueryDataFilterRegistrasiWithDate);
                        $hitungDataFilterRegistrasiWithDate = mysqli_num_rows($execQueryDataFilterRegistrasiWithDate);
                        // echo $hitungDataFilterRegistrasiWithDate . "<br>";

                        // echo "Dari tanggal : " . $dariTanggal . "<br> ". "Sampai Tanggal : " . $sampaiTanggal . "<br> Jumlah Data : ". $hitungDataFilterRegistrasiWithDate;
                        // echo $hitungDataFilterPANGKAL;exit;

                        $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

                        $ambildata_perhalaman = mysqli_query($con, "
                            SELECT ID, NIS, NAMA, DATE, kelas, REGISTRASI, TRANSAKSI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                            FROM input_data_tk
                            WHERE
                            REGISTRASI != 0
                            AND NAMA LIKE '%$namaMurid%'
                            AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                            LIMIT $dataAwal, $jumlahData
                        ");

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

                // LAIN
                else if($_POST['isi_filter'] == 'LAIN') {

                    if ($dariTanggal == " 00:00:00" && $sampaiTanggal == " 23:59:59") { 

                        $namaMurid = $namaSiswa;
                        $queryGetDataLain = "
                        SELECT ID, NIS, NAMA, kelas, LAIN, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                        FROM input_data_tk
                        WHERE
                        LAIN != 0
                        AND NAMA LIKE '%$namaMurid%' ";

                        $execQueryDataLain    = mysqli_query($con, $queryGetDataLain);
                        $hitungDataFilterLain = mysqli_num_rows($execQueryDataLain);
                        // echo $hitungDataFilterLain;

                        $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;
                        // echo $dataAwal . "<br>";
                        $ambildata_perhalaman = mysqli_query($con, "
                            SELECT ID, NIS, NAMA, DATE, kelas, LAIN, TRANSAKSI, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                            FROM input_data_tk
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

                    } else if ($dariTanggal != " 00:00:00" && $sampaiTanggal != " 23:59:59") {

                        $namaMurid = $namaSiswa;

                        $tanggalDari    = $_POST['tanggal1'];
                        $tanggalSampai  = $_POST['tanggal2']; 

                        $queryGetDataFilterLainWithDate = "
                            SELECT ID, NIS, NAMA, kelas, LAIN, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                            FROM input_data_tk
                            WHERE
                            LAIN != 0
                            AND NAMA LIKE '%$namaMurid%'
                            AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                        ";

                        $execQueryDataFilterRegistrasiWithDate    = mysqli_query($con, $queryGetDataFilterLainWithDate);
                        // $hitungDataFilterPANGKAL = mysqli_num_rows($execQueryDataFilterRegistrasiWithDate);
                        $hitungDataFilterLainWithDate = mysqli_num_rows($execQueryDataFilterRegistrasiWithDate);

                        // echo "Dari tanggal : " . $dariTanggal . "<br> ". "Sampai Tanggal : " . $sampaiTanggal . "<br> Jumlah Data : ". $hitungDataFilterLainWithDate;
                        // echo $hitungDataFilterPANGKAL;exit;

                        $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

                        $ambildata_perhalaman = mysqli_query($con, "
                            SELECT ID, NIS, NAMA, DATE, kelas, LAIN, TRANSAKSI, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                            FROM input_data_tk
                            WHERE
                            LAIN != 0
                            AND NAMA LIKE '%$namaMurid%'
                            AND STAMP >= '$dariTanggal' AND STAMP <= '$sampaiTanggal'
                            LIMIT $dataAwal, $jumlahData
                        ");

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

            } else {
                // Jika tidak ada filter yang di pilih (kosong)
                $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;
                // echo $dataAwal . "<br>";
                $ambildata_perhalaman = mysqli_query($con, "SELECT * FROM input_data_tk ORDER BY STAMP DESC LIMIT $dataAwal, $jumlahData  ");
                // print_r($ambildata_perhalaman->num_rows);

                $jumlahLink = 2;

                $showAddPage100 = "";

                $totalHalamanTambah100 = $halamanAktif + 100;

                if ($totalHalamanTambah100 <= $jumlahPagination) {
                    $showAddPage100 = "muncul";
                } else {
                    $showAddPage100 = "tidak_muncul";
                }

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

        } else if (isset($_POST['nextPageFilterSemua'])) {

            $halamanAktif       = $_POST['halamanLanjutFilterSemua'];
            $iniScrollNextPage  = "ada";

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $namaMurid  = $_POST['namaSiswaFilterSemua'];
            $isifilby   = $_POST['iniFilterSemua'];

            $id         = $_POST['idSiswaFilterSemua'];
            $kelas      = $_POST['kelasFormFilterSemua'];
            $panggilan  = $_POST['panggilanFormFilterSemua'];
            $nis        = $_POST['nisFormFilterSemua'];
            $namaSiswa  = $_POST['namaFormFilterSemua'];

            $queryGetDataFilterSemua = "
                SELECT * FROM input_data_tk WHERE NAMA LIKE '%$namaMurid%'
            ";

            $execQueryDataFilterSemua    = mysqli_query($con, $queryGetDataFilterSemua);

            $hitungDataFilterSemua = mysqli_num_rows($execQueryDataFilterSemua);

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT * FROM input_data_tk WHERE NAMA LIKE '%$namaMurid%' ORDER BY ID DESC LIMIT $dataAwal, $jumlahData
            ");

            $check = mysqli_fetch_assoc($ambildata_perhalaman);

            $jumlahPagination = ceil($hitungDataFilterSemua / $jumlahData);

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

        } else if (isset($_POST['previousPageFilterSemua'])) {

            $halamanAktif           = $_POST['halamanSebelumnyaFilterSemua'];
            $iniScrollPreviousPage  = "ada";

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $namaMurid = $_POST['namaSiswaFilterSemua'];
            $isifilby  = $_POST['iniFilterSemua'];

            $id        = $_POST['idSiswaFilterSemua'];
            $nis       = $_POST['nisFormFilterSemua'];
            $namaSiswa = $_POST['namaFormFilterSemua'];
            $panggilan = $_POST['panggilanFormFilterSemua'];
            $kelas     = $_POST['kelasFormFilterSemua'];

            $queryGetDataFilterSemua = "
                SELECT * FROM input_data_tk WHERE NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataFilterSemua    = mysqli_query($con, $queryGetDataFilterSemua);
            $hitungDataFilterSemua = mysqli_num_rows($execQueryDataFilterSemua);

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT * FROM input_data_tk WHERE NAMA LIKE '%$namaMurid%' ORDER BY ID DESC LIMIT $dataAwal, $jumlahData");
            // print_r($ambildata_perhalaman->num_rows);

            $jumlahPagination = ceil($hitungDataFilterSemua / $jumlahData);

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

        } else if (isset($_POST['toPageFilterSemua'])) {

            $halamanAktif = $_POST['halamanKeFilterSemua'];
            $iniScrollNextPage = "ada";

            $namaMurid = $_POST['namaSiswaFilterSemua'];
            $isifilby  = $_POST['iniFilterSemua'];

            $namaSiswa = $namaMurid;
            $id        = $_POST['idSiswaFilterSemua'];
            $nis       = $_POST['nisFormFilterSemua'];
            $panggilan = $_POST['panggilanFormFilterSemua'];
            $kelas     = $_POST['kelasFormFilterSemua'];

            $queryGetDataFilterSemua = "
                SELECT * FROM input_data_tk WHERE NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataFilterSemua   = mysqli_query($con, $queryGetDataFilterSemua);
            $hitungDataFilterSemua        = mysqli_num_rows($execQueryDataFilterSemua);

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT * FROM input_data_tk WHERE NAMA LIKE '%$namaMurid%' 
                ORDER BY ID DESC
                LIMIT $dataAwal, $jumlahData");
            // print_r($ambildata_perhalaman->num_rows);

            $jumlahPagination = ceil($hitungDataFilterSemua / $jumlahData);

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

        } else if (isset($_POST['firstPageFilterSemua'])) {

            $namaMurid      = $_POST['namaFormFilterSemua'];

            $id             = $_POST['idSiswaFilterSemua'];
            $nis            = $_POST['nisFormFilterSemua'];
            $kelas          = $_POST['kelasFormFilterSemua'];
            $panggilan      = $_POST['panggilanFormFilterSemua'];
            $namaSiswa      = $namaMurid;

            $isifilby       = $_POST['iniFilterSemua'];

            $iniScrollPreviousPage  = "ada";

            $execQueryGetAllDataHistoriFilterSemua = mysqli_query($con, "
                SELECT * FROM input_data_tk WHERE NAMA LIKE '%$namaMurid%'
            ");

            $totalData = mysqli_num_rows($execQueryGetAllDataHistoriFilterSemua);

            $jumlahPagination = ceil($totalData / $jumlahData);

            $halamanAktif   = 1;

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $hitungDataFilterSemua = $totalData;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT * FROM input_data_tk WHERE NAMA LIKE '%$namaMurid%'
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

        } else if (isset($_POST['lastPageFilterSemua'])) {

            $namaMurid      = $_POST['namaSiswaFilterSemua'];
            $isifilby       = $_POST['iniFilterSemua'];

            $id             = $_POST['idSiswaFilterSemua'];
            $namaSiswa      = $namaMurid;
            $kelas          = $_POST['kelasFormFilterSemua'];
            $panggilan      = $_POST['panggilanFormFilterSemua'];
            $nis            = $_POST['nisFormFilterSemua'];

            $iniScrollPreviousPage  = "ada";

            $execQueryGetAllDataHistoriFilterSemua = mysqli_query($con, "
                SELECT * FROM input_data_tk WHERE NAMA LIKE '%$namaMurid%'
            ");

            $totalData = mysqli_num_rows($execQueryGetAllDataHistoriFilterSemua);

            $jumlahPagination = ceil($totalData / $jumlahData);

            $halamanAktif   = $jumlahPagination;

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $hitungDataFilterSemua = $totalData;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT * FROM input_data_tk WHERE NAMA LIKE '%$namaMurid%'
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

        } else if (isset($_POST['nextPageFilterSemuaWithDate'])) {

            $halamanAktif       = $_POST['halamanLanjutFilterSemuaWithDate'];
            $iniScrollNextPage  = "ada";

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $namaMurid  = $_POST['namaSiswaFilterSemuaWithDate'];
            $isifilby   = $_POST['iniFilterSemuaWithDate'];

            $id         = $_POST['idSiswaFilterSemuaWithDate'];
            $kelas      = $_POST['kelasFormFilterSemuaWithDate'];
            $panggilan  = $_POST['panggilanFormFilterSemuaWithDate'];
            $nis        = $_POST['nisFormFilterSemuaWithDate'];
            $namaSiswa  = $_POST['namaFormFilterSemuaWithDate'];

            $tanggalDari    = $_POST['tanggalDariFormFilterSemuaWithDate'] . " 00:00:00";
            $tanggalSampai  = $_POST['tanggalSampaiFormFilterSemuaWithDate'] . " 23:59:59";

            $queryGetDataFilterSemuaWithDate = "
                SELECT * FROM input_data_tk 
                WHERE NAMA LIKE '%$namaMurid%' AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
            ";

            $execQueryDataFilterSemuaWithDate    = mysqli_query($con, $queryGetDataFilterSemuaWithDate);
            $hitungDataFilterSemuaWithDate = mysqli_num_rows($execQueryDataFilterSemuaWithDate);

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT * 
                FROM input_data_tk
                WHERE
                NAMA LIKE '%$namaMurid%'
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
                ORDER BY STAMP ASC
                LIMIT $dataAwal, $jumlahData
            ");
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

        } else if (isset($_POST['previousPageFilterSemuaWithDate'])) {

            $halamanAktif           = $_POST['halamanSebelumnyaFilterSemuaWithDate'];
            $iniScrollPreviousPage  = "ada";

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $namaMurid = $_POST['namaSiswaFilterSemuaWithDate'];
            $isifilby  = $_POST['iniFilterSemuaWithDate'];

            $id        = $_POST['idSiswaFilterSemuaWithDate'];
            $nis       = $_POST['nisFormFilterSemuaWithDate'];
            $namaSiswa = $_POST['namaFormFilterSemuaWithDate'];
            $panggilan = $_POST['panggilanFormFilterSemuaWithDate'];
            $kelas     = $_POST['kelasFormFilterSemuaWithDate'];

            $tanggalDari    = $_POST['tanggalDariFormFilterSemuaWithDate'] . " 00:00:00";
            $tanggalSampai  = $_POST['tanggalSampaiFormFilterSemuaWithDate'] . " 23:59:59";

            $queryGetDataFilterSemuaWithDate = "
                SELECT * FROM input_data_tk
                WHERE
                STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
                AND NAMA LIKE '%$namaMurid%' 
            ";
            $execQueryDataFilterSemua    = mysqli_query($con, $queryGetDataFilterSemuaWithDate);
            $hitungDataFilterSemuaWithDate = mysqli_num_rows($execQueryDataFilterSemua);

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT * FROM input_data_tk
                WHERE
                NAMA LIKE '%$namaMurid%'
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai' 
                ORDER By STAMP ASC
                LIMIT $dataAwal, $jumlahData");

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

        } else if (isset($_POST['toPageFilterSemuaWithDate'])) {

            $halamanAktif = $_POST['halamanKeFilterSemuaWithDate'];
            $iniScrollNextPage = "ada";

            $namaMurid = $_POST['namaSiswaFilterSemuaWithDate'];
            $isifilby  = $_POST['iniFilterSemuaWithDate'];

            $namaSiswa = $namaMurid;
            $id        = $_POST['idSiswaFilterSemuaWithDate'];
            $nis       = $_POST['nisFormFilterSemuaWithDate'];
            $panggilan = $_POST['panggilanFormFilterSemuaWithDate'];
            $kelas     = $_POST['kelasFormFilterSemuaWithDate'];

            $tanggalDari    = $_POST['tanggalDariFormFilterSemuaWithDate'] . " 00:00:00";
            $tanggalSampai  = $_POST['tanggalSampaiFormFilterSemuaWithDate'] . " 23:59:59";

            $queryGetDataFilterSemuaWithDate = "
                SELECT * FROM input_data_tk
                WHERE
                STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
                AND NAMA LIKE '%$namaMurid%' 
            ";
            $execQueryDataFilterSemua    = mysqli_query($con, $queryGetDataFilterSemuaWithDate);
            $hitungDataFilterSemua = mysqli_num_rows($execQueryDataFilterSemua);
            // echo $hitungDataFilterSemua;

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT * FROM input_data_tk
                WHERE
                NAMA LIKE '%$namaMurid%'
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
                ORDER by STAMP ASC
                LIMIT $dataAwal, $jumlahData");

            $jumlahPagination = ceil($hitungDataFilterSemua / $jumlahData);

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

        } else if (isset($_POST['firstPageFilterSemuaWithDate'])) {

            $namaMurid      = $_POST['namaFormFilterSemuaWithDate'];

            $id             = $_POST['idSiswaFilterSemuaWithDate'];
            $nis            = $_POST['nisFormFilterSemuaWithDate'];
            $kelas          = $_POST['kelasFormFilterSemuaWithDate'];
            $panggilan      = $_POST['panggilanFormFilterSemuaWithDate'];
            $namaSiswa      = $namaMurid;

            $isifilby       = $_POST['iniFilterSemuaWithDate'];

            $iniScrollPreviousPage  = "ada";

            $tanggalDari    = $_POST['tanggalDariFormFilterSemuaWithDate'] . " 00:00:00";
            $tanggalSampai  = $_POST['tanggalSampaiFormFilterSemuaWithDate'] . " 23:59:59";

            $execQueryGetAllDataHistoriFilterSemua = mysqli_query($con, "
                SELECT * FROM input_data_tk
                WHERE
                STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
                AND NAMA LIKE '%$namaMurid%'
            ");

            $totalData = mysqli_num_rows($execQueryGetAllDataHistoriFilterSemua);
            // echo $totalData;

            $jumlahPagination = ceil($totalData / $jumlahData);

            $halamanAktif   = 1;

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $hitungDataFilterSemuaWithDate = $jumlahPagination;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT * FROM input_data_tk
                WHERE
                NAMA LIKE '%$namaMurid%'
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
                ORDER BY STAMP ASC
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

        } else if (isset($_POST['lastPageFilterSemuaWithDate'])) {

            $namaMurid      = $_POST['namaSiswaFilterSemuaWithDate'];
            $isifilby       = $_POST['iniFilterSemuaWithDate'];

            $id             = $_POST['idSiswaFilterSemuaWithDate'];
            $namaSiswa      = $namaMurid;
            $kelas          = $_POST['kelasFormFilterSemuaWithDate'];
            $panggilan      = $_POST['panggilanFormFilterSemuaWithDate'];
            $nis            = $_POST['nisFormFilterSemuaWithDate'];

            $iniScrollPreviousPage  = "ada";

            $tanggalDari    = $_POST['tanggalDariFormFilterSemuaWithDate'] . " 00:00:00";
            $tanggalSampai  = $_POST['tanggalSampaiFormFilterSemuaWithDate'] . " 23:59:59";

            $execQueryGetAllDataHistoriFilterSemua = mysqli_query($con, "
                SELECT * FROM input_data_tk
                WHERE
                STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
                AND NAMA LIKE '%$namaMurid%'
            ");

            $totalData = mysqli_num_rows($execQueryGetAllDataHistoriFilterSemua);
            // echo $totalData;

            $jumlahPagination = ceil($totalData / $jumlahData);

            $halamanAktif   = $jumlahPagination;
            // echo $halamanAktif;exit;

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $hitungDataFilterSemuaWithDate = $jumlahPagination;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT * FROM input_data_tk
                WHERE
                NAMA LIKE '%$namaMurid%'
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
                ORDER BY STAMP ASC
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

        } else if (isset($_POST['nextPageJustFilterSPP'])) {
            
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

        } else if (isset($_POST['previousPageJustFilterSPP'])) {

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

        } else if (isset($_POST['toPageFilterSPP'])) {

            $halamanAktif = $_POST['halamanKeFilterSPP'];
            $iniScrollNextPage = "ada";

            $namaMurid = $_POST['namaSiswaFilterSPP'];
            $isifilby  = $_POST['iniFilterSPP'];

            $namaSiswa = $namaMurid;
            $id        = $_POST['idSiswaFilterSPP'];
            $nis       = $_POST['nisFormFilterSPP'];
            $panggilan = $_POST['panggilanFormFilterSPP'];
            $kelas     = $_POST['kelasFormFilterSPP'];

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

        } else if (isset($_POST['firstPageFilterSPP'])) {

            $namaMurid      = $_POST['namaFormFilterSPP'];

            $id             = $_POST['idSiswaFilterSPP'];
            $nis            = $_POST['nisFormFilterSPP'];
            $kelas          = $_POST['kelasFormFilterSPP'];
            $panggilan      = $_POST['panggilanFormFilterSPP'];
            $namaSiswa      = $namaMurid;

            $isifilby       = $_POST['iniFilterSPP'];

            $iniScrollPreviousPage  = "ada";

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

        } else if (isset($_POST['lastPageFilterSPP'])) {

            $namaMurid      = $_POST['namaSiswaFilterSPP'];
            $isifilby       = $_POST['iniFilterSPP'];

            $id             = $_POST['idSiswaFilterSPP'];
            $namaSiswa      = $namaMurid;
            $kelas          = $_POST['kelasFormFilterSPP'];
            $panggilan      = $_POST['panggilanFormFilterSPP'];
            $nis            = $_POST['nisFormFilterSPP'];

            $iniScrollPreviousPage  = "ada";

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

        } else if (isset($_POST['findPageData'])) {

            $halamanAktif = $_POST['cari_halaman'];
            $iniScrollPreviousPage  = "ada";
            $showAddPage100 = "";

            $totalHalamanTambah100 = $halamanAktif + 100;

            if ($totalHalamanTambah100 <= $jumlahPagination) {
                $showAddPage100 = "muncul";
            } else {
                $showAddPage100 = "tidak_muncul";
            }

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;
            // echo $dataAwal . "<br>";
            $ambildata_perhalaman = mysqli_query($con, "SELECT * FROM input_data_tk ORDER BY ID DESC LIMIT $dataAwal, $jumlahData  ");
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

        } else if (isset($_POST['nextPageFilterSPPWithDate']) ) {

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

            $tanggalDari    = $_POST['tanggalDariFormFilterSPPWithDate'] . " 00:00:00";
            $tanggalSampai  = $_POST['tanggalSampaiFormFilterSPPWithDate'] . " 23:59:59";

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

        } else if (isset($_POST['previousPageFilterSPPWithDate'])) {

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

            $tanggalDari    = $_POST['tanggalDariFormFilterSPPWithDate'] . " 00:00:00";
            $tanggalSampai  = $_POST['tanggalSampaiFormFilterSPPWithDate'] . " 23:59:59";

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

        } else if (isset($_POST['firstPageFilterSPPWithDate'])) {

            $namaMurid      = $_POST['namaFormFilterSPPWithDate'];

            $id             = $_POST['idSiswaFilterSPPWithDate'];
            $nis            = $_POST['nisFormFilterSPPWithDate'];
            $kelas          = $_POST['kelasFormFilterSPPWithDate'];
            $panggilan      = $_POST['panggilanFormFilterSPPWithDate'];
            $namaSiswa      = $namaMurid;

            $isifilby       = $_POST['iniFilterSPPWithDate'];

            $iniScrollPreviousPage  = "ada";

            $tanggalDari    = $_POST['tanggalDariFormFilterSPPWithDate'] . " 00:00:00";
            $tanggalSampai  = $_POST['tanggalSampaiFormFilterSPPWithDate'] . " 23:59:59";

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

        } else if (isset($_POST['lastPageFilterSPPWithDate'])) {

            $namaMurid      = $_POST['namaSiswaFilterSPPWithDate'];
            $isifilby       = $_POST['iniFilterSPPWithDate'];

            $id             = $_POST['idSiswaFilterSPPWithDate'];
            $namaSiswa      = $namaMurid;
            $kelas          = $_POST['kelasFormFilterSPPWithDate'];
            $panggilan      = $_POST['panggilanFormFilterSPPWithDate'];
            $nis            = $_POST['nisFormFilterSPPWithDate'];

            $iniScrollPreviousPage  = "ada";

            $tanggalDari    = $_POST['tanggalDariFormFilterSPPWithDate'] . " 00:00:00";
            $tanggalSampai  = $_POST['tanggalSampaiFormFilterSPPWithDate'] . " 23:59:59";

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

            $halamanAktif   = $jumlahPagination;
            // echo $halamanAktif;exit;

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

        } else if (isset($_POST['toPageFilterSPPWithDate'])) {

            $halamanAktif = $_POST['halamanKeFilterSPPWithDate'];
            $iniScrollNextPage = "ada";

            $namaMurid = $_POST['namaSiswaFilterSPPWithDate'];
            $isifilby  = $_POST['iniFilterSPPWithDate'];

            $namaSiswa = $namaMurid;
            $id        = $_POST['idSiswaFilterSPPWithDate'];
            $nis       = $_POST['nisFormFilterSPPWithDate'];
            $panggilan = $_POST['panggilanFormFilterSPPWithDate'];
            $kelas     = $_POST['kelasFormFilterSPPWithDate'];

            $tanggalDari    = $_POST['tanggalDariFormFilterSPPWithDate'] . " 00:00:00";
            $tanggalSampai  = $_POST['tanggalSampaiFormFilterSPPWithDate'] . " 23:59:59";

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
                SELECT ID, NIS, NAMA, kelas, SPP, TRANSAKSI, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
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

        } else if (isset($_POST['nextPageJustFilterPANGKAL'])) {

            // echo "Next page filter pangkal";exit;
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

            $queryGetDataPangkal = "
                SELECT ID, NIS, NAMA, kelas, PANGKAL, BULAN AS pembayaran_bulan, PANGKAL_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                PANGKAL != 0
                AND NAMA LIKE '%$namaMurid%' 
            ";
            $execQueryDataPangkal    = mysqli_query($con, $queryGetDataPangkal);
            $hitungDataFilterPANGKAL = mysqli_num_rows($execQueryDataPangkal);

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

        } else if (isset($_POST['previousPageJustFilterPANGKAL'])) {

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

        } else if (isset($_POST['toPageFilterPANGKAL'])) {

            $halamanAktif = $_POST['halamanKeFilterPANGKAL'];
            $iniScrollNextPage = "ada";

            $namaMurid = $_POST['namaSiswaFilterPANGKAL'];
            $isifilby  = $_POST['iniFilterPANGKAL'];

            $namaSiswa = $namaMurid;
            $id        = $_POST['idSiswaFilterPANGKAL'];
            $nis       = $_POST['nisFormFilterPANGKAL'];
            $panggilan = $_POST['panggilanFormFilterPANGKAL'];
            $kelas     = $_POST['kelasFormFilterPANGKAL'];

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

        } else if (isset($_POST['firstPageFilterPANGKAL'])) {

            $namaMurid      = $_POST['namaFormFilterPANGKAL'];

            $id             = $_POST['idSiswaFilterPANGKAL'];
            $nis            = $_POST['nisFormFilterPANGKAL'];
            $kelas          = $_POST['kelasFormFilterPANGKAL'];
            $panggilan      = $_POST['panggilanFormFilterPANGKAL'];
            $namaSiswa      = $namaMurid;

            $isifilby       = $_POST['iniFilterPANGKAL'];

            $iniScrollPreviousPage  = "ada";

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

        } else if (isset($_POST['lastPageFilterPANGKAL'])) {

            $namaMurid      = $_POST['namaSiswaFilterPANGKAL'];
            $isifilby       = $_POST['iniFilterPANGKAL'];

            $id             = $_POST['idSiswaFilterPANGKAL'];
            $namaSiswa      = $namaMurid;
            $kelas          = $_POST['kelasFormFilterPANGKAL'];
            $panggilan      = $_POST['panggilanFormFilterPANGKAL'];
            $nis            = $_POST['nisFormFilterPANGKAL'];

            $iniScrollPreviousPage  = "ada";

            $execQueryGetAllDataHistoriFilterPANGKAL = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, PANGKAL, BULAN AS pembayaran_bulan, PANGKAL_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
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

        } else if (isset($_POST['nextPageFilterPangkalWithDate'])) {

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

            $tanggalDari    = $_POST['tanggalDariFormFilterPangkalWithDate'] . " 00:00:00";
            $tanggalSampai  = $_POST['tanggalSampaiFormFilterPangkalWithDate'] . " 23:59:59";

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

        } else if (isset($_POST['previousPageFilterPangkalWithDate'])) {

            $halamanAktif           = $_POST['halamanSebelumnyaFilterPangkalWithDate'];
            $iniScrollPreviousPage  = "ada";

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $namaMurid = $_POST['namaSiswaFilterPangkalWithDate'];
            $isifilby  = $_POST['iniFilterPangkalWithDate'];

            $id        = $_POST['idSiswaFilterPangkalWithDate'];
            $nis       = $_POST['nisFormFilterPangkalWithDate'];
            $namaSiswa = $_POST['namaFormFilterPangkalWithDate'];
            $panggilan = $_POST['panggilanFormFilterPangkalWithDate'];
            $kelas     = $_POST['kelasFormFilterPangkalWithDate'];

            $tanggalDari    = $_POST['tanggalDariFormFilterPangkalWithDate'] . " 00:00:00";
            $tanggalSampai  = $_POST['tanggalSampaiFormFilterPangkalWithDate'] . " 23:59:59";

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

        } else if (isset($_POST['toPageFilterPangkalWithDate'])) {

            $halamanAktif = $_POST['halamanKeFilterPangkalWithDate'];
            $iniScrollNextPage = "ada";

            $namaMurid = $_POST['namaSiswaFilterPangkalWithDate'];
            $isifilby  = $_POST['iniFilterPangkalWithDate'];

            $namaSiswa = $namaMurid;
            $id        = $_POST['idSiswaFilterPangkalWithDate'];
            $nis       = $_POST['nisFormFilterPangkalWithDate'];
            $panggilan = $_POST['panggilanFormFilterPangkalWithDate'];
            $kelas     = $_POST['kelasFormFilterPangkalWithDate'];

            $tanggalDari    = $_POST['tanggalDariFormFilterPangkalWithDate'] . " 00:00:00";
            $tanggalSampai  = $_POST['tanggalSampaiFormFilterPangkalWithDate'] . " 23:59:59";

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

        } else if (isset($_POST['firstPageFilterPangkalWithDate'])) {

            $namaMurid      = $_POST['namaFormFilterPangkalWithDate'];

            $id             = $_POST['idSiswaFilterPangkalWithDate'];
            $nis            = $_POST['nisFormFilterPangkalWithDate'];
            $kelas          = $_POST['kelasFormFilterPangkalWithDate'];
            $panggilan      = $_POST['panggilanFormFilterPangkalWithDate'];
            $namaSiswa      = $namaMurid;

            $isifilby       = $_POST['iniFilterPangkalWithDate'];

            $iniScrollPreviousPage  = "ada";

            $tanggalDari    = $_POST['tanggalDariFormFilterPangkalWithDate'] . " 00:00:00";
            $tanggalSampai  = $_POST['tanggalSampaiFormFilterPangkalWithDate'] . " 23:59:59";

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

        } else if (isset($_POST['lastPageFilterPangkalWithDate'])) {

            $namaMurid      = $_POST['namaSiswaFilterPangkalWithDate'];
            $isifilby       = $_POST['iniFilterPangkalWithDate'];

            $id             = $_POST['idSiswaFilterPangkalWithDate'];
            $namaSiswa      = $namaMurid;
            $kelas          = $_POST['kelasFormFilterPangkalWithDate'];
            $panggilan      = $_POST['panggilanFormFilterPangkalWithDate'];
            $nis            = $_POST['nisFormFilterPangkalWithDate'];

            $iniScrollPreviousPage  = "ada";

            $tanggalDari    = $_POST['tanggalDariFormFilterPangkalWithDate'] . " 00:00:00";
            $tanggalSampai  = $_POST['tanggalSampaiFormFilterPangkalWithDate'] . " 23:59:59";

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

            $halamanAktif   = $jumlahPagination;
            // echo $halamanAktif;exit;

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

        } else if (isset($_POST['nextPageFilterKegiatan'])) {

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

        } else if (isset($_POST['previousPageFilterKegiatan'])) {

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

        } else if (isset($_POST['toPageFilterKegiatan'])) {

            $halamanAktif = $_POST['halamanKeFilterKegiatan'];
            $iniScrollNextPage = "ada";

            $namaMurid = $_POST['namaSiswaFilterKegiatan'];
            $isifilby  = $_POST['iniFilterKegiatan'];

            $namaSiswa = $namaMurid;
            $id        = $_POST['idSiswaFilterKegiatan'];
            $nis       = $_POST['nisFormFilterKegiatan'];
            $panggilan = $_POST['panggilanFormFilterKegiatan'];
            $kelas     = $_POST['kelasFormFilterKegiatan'];

            $queryGetDataKegiatan = "
                SELECT ID, NIS, NAMA, kelas, KEGIATAN, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                KEGIATAN != 0
                AND NAMA LIKE '%$namaMurid%' 
            ";
            $execQueryDatakegiatan    = mysqli_query($con, $queryGetDataKegiatan);
            $hitungDataFilterKegiatan = mysqli_num_rows($execQueryDatakegiatan);

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

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

        } else if (isset($_POST['firstPageFilterKegiatan'])) {

            $namaMurid      = $_POST['namaFormFilterKegiatan'];

            $id             = $_POST['idSiswaFilterKegiatan'];
            $nis            = $_POST['nisFormFilterKegiatan'];
            $kelas          = $_POST['kelasFormFilterKegiatan'];
            $panggilan      = $_POST['panggilanFormFilterKegiatan'];
            $namaSiswa      = $namaMurid;

            $isifilby       = $_POST['iniFilterKegiatan'];

            $iniScrollPreviousPage  = "ada";

            $execQueryGetAllDataHistoriFilterKegiatan = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, KEGIATAN, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
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
                FROM input_data_tk
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

        } else if (isset($_POST['lastPageFilterKegiatan'])) {

            $namaMurid      = $_POST['namaSiswaFilterKegiatan'];
            $isifilby       = $_POST['iniFilterKegiatan'];

            $id             = $_POST['idSiswaFilterKegiatan'];
            $namaSiswa      = $namaMurid;
            $kelas          = $_POST['kelasFormFilterKegiatan'];
            $panggilan      = $_POST['panggilanFormFilterKegiatan'];
            $nis            = $_POST['nisFormFilterKegiatan'];

            $iniScrollPreviousPage  = "ada";

            $execQueryGetAllDataHistoriFilterKegiatan = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, KEGIATAN, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
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
                FROM input_data_tk
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

        } else if (isset($_POST['nextPageFilterKegiatanWithDate'])) {

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

            $tanggalDari    = $_POST['tanggalDariFormFilterKegiatanWithDate'] . " 00:00:00";
            $tanggalSampai  = $_POST['tanggalSampaiFormFilterKegiatanWithDate'] . " 23:59:59";

            $queryGetDataKegiatanWithDate = "
                SELECT ID, NIS, NAMA, kelas, KEGIATAN, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                KEGIATAN != 0
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
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
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
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

        } else if (isset($_POST['previousPageFilterKegiatanWithDate'])) {

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

            $tanggalDari    = $_POST['tanggalDariFormFilterKegiatanWithDate'] . " 00:00:00";
            $tanggalSampai  = $_POST['tanggalSampaiFormFilterKegiatanWithDate'] . " 23:59:59";

            $queryGetDataKegiatanWithDate = "
                SELECT ID, NIS, NAMA, kelas, KEGIATAN, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                KEGIATAN != 0
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
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
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai' 
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

        } else if (isset($_POST['toPageFilterKegiatanWithDate'])) {

            $halamanAktif = $_POST['halamanKeFilterKegiatanWithDate'];
            $iniScrollNextPage = "ada";

            $namaMurid = $_POST['namaSiswaFilterKegiatanWithDate'];
            $isifilby  = $_POST['iniFilterKegiatanWithDate'];

            $namaSiswa = $namaMurid;
            $id        = $_POST['idSiswaFilterKegiatanWithDate'];
            $nis       = $_POST['nisFormFilterKegiatanWithDate'];
            $panggilan = $_POST['panggilanFormFilterKegiatanWithDate'];
            $kelas     = $_POST['kelasFormFilterKegiatanWithDate'];

            $tanggalDari    = $_POST['tanggalDariFormFilterKegiatanWithDate'] . " 00:00:00";
            $tanggalSampai  = $_POST['tanggalSampaiFormFilterKegiatanWithDate'] . " 23:59:59";

            $queryGetDataKegiatanWithDate = "
                SELECT ID, NIS, NAMA, kelas, KEGIATAN, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                KEGIATAN != 0
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
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
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
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

        } elseif (isset($_POST['firstPageFilterKegiatanWithDate'])) {

            $namaMurid      = $_POST['namaFormFilterKegiatanWithDate'];

            $id             = $_POST['idSiswaFilterKegiatanWithDate'];
            $nis            = $_POST['nisFormFilterKegiatanWithDate'];
            $kelas          = $_POST['kelasFormFilterKegiatanWithDate'];
            $panggilan      = $_POST['panggilanFormFilterKegiatanWithDate'];
            $namaSiswa      = $namaMurid;

            $isifilby       = $_POST['iniFilterKegiatanWithDate'];

            $iniScrollPreviousPage  = "ada";

            $tanggalDari    = $_POST['tanggalDariFormFilterKegiatanWithDate'] . " 00:00:00";
            $tanggalSampai  = $_POST['tanggalSampaiFormFilterKegiatanWithDate'] . " 23:59:59";

            $execQueryGetAllDataHistoriFilterKegitanWithDate = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, KEGIATAN, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                KEGIATAN != 0
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
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

        } else if (isset($_POST['lastPageFilterKegiatanWithDate'])) {

            $namaMurid      = $_POST['namaSiswaFilterKegiatanWithDate'];
            $isifilby       = $_POST['iniFilterKegiatanWithDate'];

            $id             = $_POST['idSiswaFilterKegiatanWithDate'];
            $namaSiswa      = $namaMurid;
            $kelas          = $_POST['kelasFormFilterKegiatanWithDate'];
            $panggilan      = $_POST['panggilanFormFilterKegiatanWithDate'];
            $nis            = $_POST['nisFormFilterKegiatanWithDate'];

            $iniScrollPreviousPage  = "ada";

            $tanggalDari    = $_POST['tanggalDariFormFilterKegiatanWithDate'] . " 00:00:00";
            $tanggalSampai  = $_POST['tanggalSampaiFormFilterKegiatanWithDate'] . " 23:59:59";

            $execQueryGetAllDataHistoriFilterKegiatanWithDate = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, KEGIATAN, BULAN AS pembayaran_bulan, KEGIATAN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                KEGIATAN != 0
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
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
                FROM input_data_tk
                WHERE
                KEGIATAN != 0
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

        } else if (isset($_POST['nextPageFilterBuku'])) {

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

        } else if (isset($_POST['previousPageFilterBuku'])) {

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

        } else if (isset($_POST['toPageFilterBuku'])) {

            $halamanAktif = $_POST['halamanKeFilterBuku'];
            $iniScrollNextPage = "ada";

            $namaMurid = $_POST['namaSiswaFilterBuku'];
            $isifilby  = $_POST['iniFilterBuku'];

            $namaSiswa = $namaMurid;
            $id        = $_POST['idSiswaFilterBuku'];
            $nis       = $_POST['nisFormFilterBuku'];
            $panggilan = $_POST['panggilanFormFilterBuku'];
            $kelas     = $_POST['kelasFormFilterBuku'];

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

        } else if (isset($_POST['firstPageFilterBuku'])) {

            $namaMurid      = $_POST['namaFormFilterBuku'];

            $id             = $_POST['idSiswaFilterBuku'];
            $nis            = $_POST['nisFormFilterBuku'];
            $kelas          = $_POST['kelasFormFilterBuku'];
            $panggilan      = $_POST['panggilanFormFilterBuku'];
            $namaSiswa      = $namaMurid;

            $isifilby       = $_POST['iniFilterBuku'];

            $iniScrollPreviousPage  = "ada";

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

        } else if (isset($_POST['lastPageFilterBuku'])) {

            $namaMurid      = $_POST['namaSiswaFilterBuku'];
            $isifilby       = $_POST['iniFilterBuku'];

            $id             = $_POST['idSiswaFilterBuku'];
            $namaSiswa      = $namaMurid;
            $kelas          = $_POST['kelasFormFilterBuku'];
            $panggilan      = $_POST['panggilanFormFilterBuku'];
            $nis            = $_POST['nisFormFilterBuku'];

            $iniScrollPreviousPage  = "ada";

            $execQueryGetAllDataHistoriFilterBuku = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, BUKU, BULAN AS pembayaran_bulan, BUKU_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
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

        } else if (isset($_POST['nextPageFilterBukuWithDate'])) {

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

            $tanggalDari    = $_POST['tanggalDariFormFilterBukuWithDate'] . " 00:00:00";
            $tanggalSampai  = $_POST['tanggalSampaiFormFilterBukuWithDate'] . " 23:59:59";

            $queryGetDataBukuWithDate = "
                SELECT ID, NIS, NAMA, kelas, BUKU, BULAN AS pembayaran_bulan, BUKU_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                BUKU != 0
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
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
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
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

        } else if (isset($_POST['previousPageFilterBukuWithDate'])) {

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

            $tanggalDari    = $_POST['tanggalDariFormFilterBukuWithDate'] . " 00:00:00";
            $tanggalSampai  = $_POST['tanggalSampaiFormFilterBukuWithDate'] . " 23:59:59";

            $queryGetDataBukuWithDate = "
                SELECT ID, NIS, NAMA, kelas, BUKU, BULAN AS pembayaran_bulan, BUKU_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                BUKU != 0
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
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
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai' 
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

        } else if (isset($_POST['toPageFilterBukuWithDate'])) {

            $halamanAktif = $_POST['halamanKeFilterBukuWithDate'];
            $iniScrollNextPage = "ada";

            $namaMurid = $_POST['namaSiswaFilterBukuWithDate'];
            $isifilby  = $_POST['iniFilterBukuWithDate'];

            $namaSiswa = $namaMurid;
            $id        = $_POST['idSiswaFilterBukuWithDate'];
            $nis       = $_POST['nisFormFilterBukuWithDate'];
            $panggilan = $_POST['panggilanFormFilterBukuWithDate'];
            $kelas     = $_POST['kelasFormFilterBukuWithDate'];

            $tanggalDari    = $_POST['tanggalDariFormFilterBukuWithDate'] . " 00:00:00";
            $tanggalSampai  = $_POST['tanggalSampaiFormFilterBukuWithDate'] . " 23:59:59";

            $queryGetDataBukuWithDate = "
                SELECT ID, NIS, NAMA, kelas, BUKU, BULAN AS pembayaran_bulan, BUKU_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                BUKU != 0
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
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
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
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

        } else if (isset($_POST['firstPageFilterBukuWithDate'])) {

            $namaMurid      = $_POST['namaFormFilterBukuWithDate'];

            $id             = $_POST['idSiswaFilterBukuWithDate'];
            $nis            = $_POST['nisFormFilterBukuWithDate'];
            $kelas          = $_POST['kelasFormFilterBukuWithDate'];
            $panggilan      = $_POST['panggilanFormFilterBukuWithDate'];
            $namaSiswa      = $namaMurid;

            $isifilby       = $_POST['iniFilterBukuWithDate'];

            $iniScrollPreviousPage  = "ada";

            $tanggalDari    = $_POST['tanggalDariFormFilterBukuWithDate'] . " 00:00:00";
            $tanggalSampai  = $_POST['tanggalSampaiFormFilterBukuWithDate'] . " 23:59:59";

            $execQueryGetAllDataHistoriFilterBukuWithDate = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, BUKU, BULAN AS pembayaran_bulan, BUKU_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                BUKU != 0
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
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
                FROM input_data_tk
                WHERE
                BUKU != 0
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

        } else if (isset($_POST['lastPageFilterBukuWithDate'])) {

            $namaMurid      = $_POST['namaSiswaFilterBukuWithDate'];
            $isifilby       = $_POST['iniFilterBukuWithDate'];

            $id             = $_POST['idSiswaFilterBukuWithDate'];
            $namaSiswa      = $namaMurid;
            $kelas          = $_POST['kelasFormFilterBukuWithDate'];
            $panggilan      = $_POST['panggilanFormFilterBukuWithDate'];
            $nis            = $_POST['nisFormFilterBukuWithDate'];

            $iniScrollPreviousPage  = "ada";

            $tanggalDari    = $_POST['tanggalDariFormFilterBukuWithDate'] . " 00:00:00";
            $tanggalSampai  = $_POST['tanggalSampaiFormFilterBukuWithDate'] . " 23:59:59";

            $execQueryGetAllDataHistoriFilterBukuWithDate = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, BUKU, BULAN AS pembayaran_bulan, BUKU_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                BUKU != 0
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
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
                FROM input_data_tk
                WHERE
                BUKU != 0
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

        } else if (isset($_POST['nextPageFilterSeragam'])) {

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

            $queryGetDataSeragam = "
                SELECT ID, NIS, NAMA, kelas, SERAGAM, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                SERAGAM != 0
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataSeragam    = mysqli_query($con, $queryGetDataSeragam);
            $hitungDataFilterSeragam = mysqli_num_rows($execQueryDataSeragam);

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, SERAGAM, TRANSAKSI, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
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

        } else if (isset($_POST['previousPageFilterSeragam'])) {

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

            $queryGetDataSeragam = "
                SELECT ID, NIS, NAMA, kelas, SERAGAM, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                SERAGAM != 0
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataBuku     = mysqli_query($con, $queryGetDataSeragam);
            $hitungDataFilterSeragam  = mysqli_num_rows($execQueryDataBuku);

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, SERAGAM, TRANSAKSI, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
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

        } else if (isset($_POST['toPageFilterSeragam'])) {

            $halamanAktif = $_POST['halamanKeFilterSeragam'];
            $iniScrollNextPage = "ada";

            $namaMurid = $_POST['namaSiswaFilterSeragam'];
            $isifilby  = $_POST['iniFilterSeragam'];

            $namaSiswa = $namaMurid;
            $id        = $_POST['idSiswaFilterSeragam'];
            $nis       = $_POST['nisFormFilterSeragam'];
            $panggilan = $_POST['panggilanFormFilterSeragam'];
            $kelas     = $_POST['kelasFormFilterSeragam'];

            $queryGetDataSeragam = "
                SELECT ID, NIS, NAMA, kelas, SERAGAM, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                SERAGAM != 0
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataSeragam    = mysqli_query($con, $queryGetDataSeragam);
            $hitungDataFilterSeragam = mysqli_num_rows($execQueryDataSeragam);

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, SERAGAM, TRANSAKSI, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
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

        } else if (isset($_POST['firstPageFilterSeragam'])) {

            $namaMurid      = $_POST['namaFormFilterSeragam'];

            $id             = $_POST['idSiswaFilterSeragam'];
            $nis            = $_POST['nisFormFilterSeragam'];
            $kelas          = $_POST['kelasFormFilterSeragam'];
            $panggilan      = $_POST['panggilanFormFilterSeragam'];
            $namaSiswa      = $namaMurid;

            $isifilby       = $_POST['iniFilterSeragam'];

            $iniScrollPreviousPage  = "ada";

            $execQueryGetAllDataHistoriFilterSeragam = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, SERAGAM, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
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
                FROM input_data_tk
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

        } else if (isset($_POST['lastPageFilterSeragam'])) {

            $namaMurid      = $_POST['namaSiswaFilterSeragam'];
            $isifilby       = $_POST['iniFilterSeragam'];

            $id             = $_POST['idSiswaFilterSeragam'];
            $namaSiswa      = $namaMurid;
            $kelas          = $_POST['kelasFormFilterSeragam'];
            $panggilan      = $_POST['panggilanFormFilterSeragam'];
            $nis            = $_POST['nisFormFilterSeragam'];

            $iniScrollPreviousPage  = "ada";

            $execQueryGetAllDataHistoriFilterSeragam = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, SERAGAM, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
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
                FROM input_data_tk
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

        } else if (isset($_POST['nextPageFilterSeragamWithDate'])) {

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

            $tanggalDari    = $_POST['tanggalDariFormFilterSeragamWithDate'] . " 00:00:00";
            $tanggalSampai  = $_POST['tanggalSampaiFormFilterSeragamWithDate'] . " 23:59:59";

            $queryGetDataSeragamWithDate = "
                SELECT ID, NIS, NAMA, kelas, SERAGAM, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                SERAGAM != 0
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataSeragamWithDate    = mysqli_query($con, $queryGetDataSeragamWithDate);
            $hitungDataFilterSeragamWithDate = mysqli_num_rows($execQueryDataSeragamWithDate);

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, SERAGAM, TRANSAKSI, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                SERAGAM != 0
                AND NAMA LIKE '%$namaMurid%'
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
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

        } else if (isset($_POST['previousPageFilterSeragamWithDate'])) {

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

            $tanggalDari    = $_POST['tanggalDariFormFilterSeragamWithDate'] . " 00:00:00";
            $tanggalSampai  = $_POST['tanggalSampaiFormFilterSeragamWithDate'] . " 23:59:59";

            $queryGetDataSeragamWithDate = "
                SELECT ID, NIS, NAMA, kelas, SERAGAM, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                SERAGAM != 0
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataSeragamWithDate    = mysqli_query($con, $queryGetDataSeragamWithDate);
            $hitungDataFilterSeragamWithDate = mysqli_num_rows($execQueryDataSeragamWithDate);

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, SERAGAM, TRANSAKSI, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                SERAGAM != 0
                AND NAMA LIKE '%$namaMurid%'
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai' 
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

        } else if (isset($_POST['toPageFilterSeragamWithDate'])) {

            $halamanAktif = $_POST['halamanKeFilterSeragamWithDate'];
            $iniScrollNextPage = "ada";

            $namaMurid = $_POST['namaSiswaFilterSeragamWithDate'];
            $isifilby  = $_POST['iniFilterSeragamWithDate'];

            $namaSiswa = $namaMurid;
            $id        = $_POST['idSiswaFilterSeragamWithDate'];
            $nis       = $_POST['nisFormFilterSeragamWithDate'];
            $panggilan = $_POST['panggilanFormFilterSeragamWithDate'];
            $kelas     = $_POST['kelasFormFilterSeragamWithDate'];

            $tanggalDari    = $_POST['tanggalDariFormFilterSeragamWithDate'] . " 00:00:00";
            $tanggalSampai  = $_POST['tanggalSampaiFormFilterSeragamWithDate'] . " 23:59:59";

            $queryGetDataSeragamWithDate = "
                SELECT ID, NIS, NAMA, kelas, SERAGAM, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                SERAGAM != 0
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataSeragamWithDate    = mysqli_query($con, $queryGetDataSeragamWithDate);
            $hitungDataFilterSeragamWithDate = mysqli_num_rows($execQueryDataSeragamWithDate);

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, SERAGAM, TRANSAKSI, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                SERAGAM != 0
                AND NAMA LIKE '%$namaMurid%'
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
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

        } else if (isset($_POST['firstPageFilterSeragamWithDate'])) {

            $namaMurid      = $_POST['namaFormFilterSeragamWithDate'];

            $id             = $_POST['idSiswaFilterSeragamWithDate'];
            $nis            = $_POST['nisFormFilterSeragamWithDate'];
            $kelas          = $_POST['kelasFormFilterSeragamWithDate'];
            $panggilan      = $_POST['panggilanFormFilterSeragamWithDate'];
            $namaSiswa      = $namaMurid;

            $isifilby       = $_POST['iniFilterSeragamWithDate'];

            $iniScrollPreviousPage  = "ada";

            $tanggalDari    = $_POST['tanggalDariFormFilterSeragamWithDate'] . ' 00:00:00';
            $tanggalSampai  = $_POST['tanggalSampaiFormFilterSeragamWithDate'] . ' 23:59:59';

            $execQueryGetAllDataHistoriFilterSeragamWithDate = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, SERAGAM, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                SERAGAM != 0
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
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
                FROM input_data_tk
                WHERE
                SERAGAM != 0
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

        } else if (isset($_POST['lastPageFilterSeragamWithDate'])) {

            $namaMurid      = $_POST['namaSiswaFilterSeragamWithDate'];
            $isifilby       = $_POST['iniFilterSeragamWithDate'];

            $id             = $_POST['idSiswaFilterSeragamWithDate'];
            $namaSiswa      = $namaMurid;
            $kelas          = $_POST['kelasFormFilterSeragamWithDate'];
            $panggilan      = $_POST['panggilanFormFilterSeragamWithDate'];
            $nis            = $_POST['nisFormFilterSeragamWithDate'];

            $iniScrollPreviousPage  = "ada";

            $tanggalDari    = $_POST['tanggalDariFormFilterSeragamWithDate'] . " 00:00:00";
            $tanggalSampai  = $_POST['tanggalSampaiFormFilterSeragamWithDate'] . " 23:59:59";

            $execQueryGetAllDataHistoriFilterSeragamWithDate = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, SERAGAM, BULAN AS pembayaran_bulan, SERAGAM_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                SERAGAM != 0
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
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
                FROM input_data_tk
                WHERE
                SERAGAM != 0
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

        } else if (isset($_POST['nextPageFilterRegistrasi'])) {

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

            $queryGetDataRegistrasi = "
                SELECT ID, NIS, NAMA, kelas, REGISTRASI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                REGISTRASI != 0
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataRegistrasi    = mysqli_query($con, $queryGetDataRegistrasi);
            $hitungDataFilterRegistrasi = mysqli_num_rows($execQueryDataRegistrasi);

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, REGISTRASI, TRANSAKSI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
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

        } else if (isset($_POST['previousPageFilterRegistrasi'])) {

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

            $queryGetDataRegistrasi = "
                SELECT ID, NIS, NAMA, kelas, REGISTRASI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                REGISTRASI != 0
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataBuku     = mysqli_query($con, $queryGetDataRegistrasi);
            $hitungDataFilterRegistrasi  = mysqli_num_rows($execQueryDataBuku);

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, REGISTRASI, TRANSAKSI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
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

        } else if (isset($_POST['toPageFilterRegistrasi'])) {

            $halamanAktif = $_POST['halamanKeFilterRegistrasi'];
            $iniScrollNextPage = "ada";

            $namaMurid = $_POST['namaSiswaFilterRegistrasi'];
            $isifilby  = $_POST['iniFilterRegistrasi'];

            $namaSiswa = $namaMurid;
            $id        = $_POST['idSiswaFilterRegistrasi'];
            $nis       = $_POST['nisFormFilterRegistrasi'];
            $panggilan = $_POST['panggilanFormFilterRegistrasi'];
            $kelas     = $_POST['kelasFormFilterRegistrasi'];

            $queryGetDataRegistrasi = "
                SELECT ID, NIS, NAMA, kelas, REGISTRASI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                REGISTRASI != 0
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataRegistrasi    = mysqli_query($con, $queryGetDataRegistrasi);
            $hitungDataFilterRegistrasi = mysqli_num_rows($execQueryDataRegistrasi);

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, REGISTRASI, TRANSAKSI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
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

        } else if (isset($_POST['firstPageFilterRegistrasi'])) {

            $namaMurid      = $_POST['namaFormFilterRegistrasi'];

            $id             = $_POST['idSiswaFilterRegistrasi'];
            $nis            = $_POST['nisFormFilterRegistrasi'];
            $kelas          = $_POST['kelasFormFilterRegistrasi'];
            $panggilan      = $_POST['panggilanFormFilterRegistrasi'];
            $namaSiswa      = $namaMurid;

            $isifilby       = $_POST['iniFilterRegistrasi'];

            $iniScrollPreviousPage  = "ada";

            $execQueryGetAllDataHistoriFilterRegistrasi = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, REGISTRASI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
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
                FROM input_data_tk
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

        } else if (isset($_POST['lastPageFilterRegistrasi'])) {

            $namaMurid      = $_POST['namaSiswaFilterRegistrasi'];
            $isifilby       = $_POST['iniFilterRegistrasi'];

            $id             = $_POST['idSiswaFilterRegistrasi'];
            $namaSiswa      = $namaMurid;
            $kelas          = $_POST['kelasFormFilterRegistrasi'];
            $panggilan      = $_POST['panggilanFormFilterRegistrasi'];
            $nis            = $_POST['nisFormFilterRegistrasi'];

            $iniScrollPreviousPage  = "ada";

            $execQueryGetAllDataHistoriFilterRegistrasi = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, REGISTRASI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
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
                FROM input_data_tk
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

        } else if (isset($_POST['nextPageFilterRegistrasiWithDate'])) {

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

            $tanggalDari    = $_POST['tanggalDariFormFilterRegistrasiWithDate'] . " 00:00:00";
            $tanggalSampai  = $_POST['tanggalSampaiFormFilterRegistrasiWithDate'] . " 23:59:59";

            $queryGetDataRegistrasiWithDate = "
                SELECT ID, NIS, NAMA, kelas, REGISTRASI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                REGISTRASI != 0
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
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
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
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

        } else if (isset($_POST['previousPageFilterRegistrasiWithDate'])) {

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

            $tanggalDari    = $_POST['tanggalDariFormFilterRegistrasiWithDate'] . " 00:00:00";
            $tanggalSampai  = $_POST['tanggalSampaiFormFilterRegistrasiWithDate'] . " 23:59:59";

            $queryGetDataRegistrasiWithDate = "
                SELECT ID, NIS, NAMA, kelas, REGISTRASI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                REGISTRASI != 0
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
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
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai' 
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

        } else if (isset($_POST['toPageFilterRegistrasiWithDate'])) {

            $halamanAktif = $_POST['halamanKeFilterRegistrasiWithDate'];
            $iniScrollNextPage = "ada";

            $namaMurid = $_POST['namaSiswaFilterRegistrasiWithDate'];
            $isifilby  = $_POST['iniFilterRegistrasiWithDate'];

            $namaSiswa = $namaMurid;
            $id        = $_POST['idSiswaFilterRegistrasiWithDate'];
            $nis       = $_POST['nisFormFilterRegistrasiWithDate'];
            $panggilan = $_POST['panggilanFormFilterRegistrasiWithDate'];
            $kelas     = $_POST['kelasFormFilterRegistrasiWithDate'];

            $tanggalDari    = $_POST['tanggalDariFormFilterRegistrasiWithDate'] . " 00:00:00";
            $tanggalSampai  = $_POST['tanggalSampaiFormFilterRegistrasiWithDate'] . " 23:59:59";

            $queryGetDataRegistrasiWithDate = "
                SELECT ID, NIS, NAMA, kelas, REGISTRASI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                REGISTRASI != 0
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataRegistrasiWithDate    = mysqli_query($con, $queryGetDataRegistrasiWithDate);
            $hitungDataFilterRegistrasiWithDate = mysqli_num_rows($execQueryDataRegistrasiWithDate);

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, DATE, REGISTRASI, TRANSAKSI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                REGISTRASI != 0
                AND NAMA LIKE '%$namaMurid%'
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
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

        } else if (isset($_POST['firstPageFilterRegistrasiWithDate'])) {

            $namaMurid      = $_POST['namaFormFilterRegistrasiWithDate'];

            $id             = $_POST['idSiswaFilterRegistrasiWithDate'];
            $nis            = $_POST['nisFormFilterRegistrasiWithDate'];
            $kelas          = $_POST['kelasFormFilterRegistrasiWithDate'];
            $panggilan      = $_POST['panggilanFormFilterRegistrasiWithDate'];
            $namaSiswa      = $namaMurid;

            $isifilby       = $_POST['iniFilterRegistrasiWithDate'];

            $iniScrollPreviousPage  = "ada";

            $tanggalDari    = $_POST['tanggalDariFormFilterRegistrasiWithDate'] . ' 00:00:00';
            $tanggalSampai  = $_POST['tanggalSampaiFormFilterRegistrasiWithDate'] . ' 23:59:59';

            $execQueryGetAllDataHistoriFilterRegistrasiWithDate = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, REGISTRASI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                REGISTRASI != 0
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
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
                FROM input_data_tk
                WHERE
                REGISTRASI != 0
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

        } else if (isset($_POST['lastPageFilterRegistrasiWithDate'])) {

            $namaMurid      = $_POST['namaSiswaFilterRegistrasiWithDate'];
            $isifilby       = $_POST['iniFilterRegistrasiWithDate'];

            $id             = $_POST['idSiswaFilterRegistrasiWithDate'];
            $namaSiswa      = $namaMurid;
            $kelas          = $_POST['kelasFormFilterRegistrasiWithDate'];
            $panggilan      = $_POST['panggilanFormFilterRegistrasiWithDate'];
            $nis            = $_POST['nisFormFilterRegistrasiWithDate'];

            $iniScrollPreviousPage  = "ada";

            $tanggalDari    = $_POST['tanggalDariFormFilterRegistrasiWithDate'] . " 00:00:00";
            $tanggalSampai  = $_POST['tanggalSampaiFormFilterRegistrasiWithDate'] . " 23:59:59";

            $execQueryGetAllDataHistoriFilterRegistrasiWithDate = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, REGISTRASI, BULAN AS pembayaran_bulan, REGISTRASI_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                REGISTRASI != 0
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
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
                FROM input_data_tk
                WHERE
                REGISTRASI != 0
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

        } else if (isset($_POST['nextPageFilterLain'])) {

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

            $queryGetDataLain = "
                SELECT ID, NIS, NAMA, kelas, LAIN, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                LAIN != 0
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataLain    = mysqli_query($con, $queryGetDataLain);
            $hitungDataFilterLain = mysqli_num_rows($execQueryDataLain);

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, LAIN, TRANSAKSI, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
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

        } else if (isset($_POST['previousPageFilterLain'])) {

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

            $queryGetDataLain = "
                SELECT ID, NIS, NAMA, kelas, LAIN, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                LAIN != 0
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataLain     = mysqli_query($con, $queryGetDataLain);
            $hitungDataFilterLain  = mysqli_num_rows($execQueryDataLain);

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, LAIN, TRANSAKSI, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
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

        } else if (isset($_POST['toPageFilterLain'])) {

            $halamanAktif = $_POST['halamanKeFilterLain'];
            $iniScrollNextPage = "ada";

            $namaMurid = $_POST['namaSiswaFilterLain'];
            $isifilby  = $_POST['iniFilterLain'];

            $namaSiswa = $namaMurid;
            $id        = $_POST['idSiswaFilterLain'];
            $nis       = $_POST['nisFormFilterLain'];
            $panggilan = $_POST['panggilanFormFilterLain'];
            $kelas     = $_POST['kelasFormFilterLain'];

            $queryGetDataLain = "
                SELECT ID, NIS, NAMA, kelas, LAIN, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                LAIN != 0
                AND NAMA LIKE '%$namaMurid%' 
            ";

            $execQueryDataLain    = mysqli_query($con, $queryGetDataLain);
            $hitungDataFilterLain = mysqli_num_rows($execQueryDataLain);

            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, LAIN, TRANSAKSI, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
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

        } else if (isset($_POST['firstPageFilterLain'])) {

            $namaMurid      = $_POST['namaFormFilterLain'];

            $id             = $_POST['idSiswaFilterLain'];
            $nis            = $_POST['nisFormFilterLain'];
            $kelas          = $_POST['kelasFormFilterLain'];
            $panggilan      = $_POST['panggilanFormFilterLain'];
            $namaSiswa      = $namaMurid;

            $isifilby       = $_POST['iniFilterLain'];

            $iniScrollPreviousPage  = "ada";

            $execQueryGetAllDataHistoriFilterLain = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, LAIN, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
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
                FROM input_data_tk
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

        } else if (isset($_POST['lastPageFilterLain'])) {

            $namaMurid      = $_POST['namaSiswaFilterLain'];
            $isifilby       = $_POST['iniFilterLain'];

            $id             = $_POST['idSiswaFilterLain'];
            $namaSiswa      = $namaMurid;
            $kelas          = $_POST['kelasFormFilterLain'];
            $panggilan      = $_POST['panggilanFormFilterLain'];
            $nis            = $_POST['nisFormFilterLain'];

            $iniScrollPreviousPage  = "ada";

            $execQueryGetAllDataHistoriFilterLain = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, LAIN, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
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
                FROM input_data_tk
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

        } else if (isset($_POST['nextPageFilterLainWithDate'])) {

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

            $tanggalDari    = $_POST['tanggalDariFormFilterLainWithDate'] . " 00:00:00";
            $tanggalSampai  = $_POST['tanggalSampaiFormFilterLainWithDate'] . " 23:59:59";

            $queryGetDataLainWithDate = "
                SELECT ID, NIS, NAMA, kelas, LAIN, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                LAIN != 0
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
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
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
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

        } else if (isset($_POST['previousPageFilterLainWithDate'])) {

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

            $tanggalDari    = $_POST['tanggalDariFormFilterLainWithDate'] . " 00:00:00";
            $tanggalSampai  = $_POST['tanggalSampaiFormFilterLainWithDate'] . " 23:59:59";

            $queryGetDatLainWithDate = "
                SELECT ID, NIS, NAMA, kelas, LAIN, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                LAIN != 0
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
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
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai' 
                ORDER BY STAMP ASC
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

        } else if (isset($_POST['toPageFilterLainWithDate'])) {

            $halamanAktif = $_POST['halamanKeFilterLainWithDate'];
            $iniScrollNextPage = "ada";

            $namaMurid = $_POST['namaSiswaFilterLainWithDate'];
            $isifilby  = $_POST['iniFilterLainWithDate'];

            $namaSiswa = $namaMurid;
            $id        = $_POST['idSiswaFilterLainWithDate'];
            $nis       = $_POST['nisFormFilterLainWithDate'];
            $panggilan = $_POST['panggilanFormFilterLainWithDate'];
            $kelas     = $_POST['kelasFormFilterLainWithDate'];

            $tanggalDari    = $_POST['tanggalDariFormFilterLainWithDate'] . " 00:00:00";
            $tanggalSampai  = $_POST['tanggalSampaiFormFilterLainWithDate'] . " 23:59:59";

            $queryGetDataLainWithDate = "
                SELECT ID, NIS, NAMA, kelas, LAIN, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                LAIN != 0
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
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
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
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

        } else if (isset($_POST['firstPageFilterLainWithDate'])) {

            $namaMurid      = $_POST['namaFormFilterLainWithDate'];

            $id             = $_POST['idSiswaFilterLainWithDate'];
            $nis            = $_POST['nisFormFilterLainWithDate'];
            $kelas          = $_POST['kelasFormFilterLainWithDate'];
            $panggilan      = $_POST['panggilanFormFilterLainWithDate'];
            $namaSiswa      = $namaMurid;

            $isifilby       = $_POST['iniFilterLainWithDate'];

            $iniScrollPreviousPage  = "ada";

            $tanggalDari    = $_POST['tanggalDariFormFilterLainWithDate'] . " 00:00:00";
            $tanggalSampai  = $_POST['tanggalSampaiFormFilterLainWithDate'] . " 23:59:59";

            $execQueryGetAllDataHistoriFilterLainWithDate = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, LAIN, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                LAIN != 0
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
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

        } else if (isset($_POST['lastPageFilterLainWithDate'])) {

            $namaMurid      = $_POST['namaSiswaFilterLainWithDate'];
            $isifilby       = $_POST['iniFilterLainWithDate'];

            $id             = $_POST['idSiswaFilterLainWithDate'];
            $namaSiswa      = $namaMurid;
            $kelas          = $_POST['kelasFormFilterLainWithDate'];
            $panggilan      = $_POST['panggilanFormFilterLainWithDate'];
            $nis            = $_POST['nisFormFilterLainWithDate'];

            $iniScrollPreviousPage  = "ada";

            $tanggalDari    = $_POST['tanggalDariFormFilterLainWithDate'] . " 00:00:00";
            $tanggalSampai  = $_POST['tanggalSampaiFormFilterLainWithDate'] . " 23:59:59";

            $execQueryGetAllDataHistoriFilterLainWithDate = mysqli_query($con, "
                SELECT ID, NIS, NAMA, DATE, kelas, LAIN, BULAN AS pembayaran_bulan, LAIN_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                LAIN != 0
                AND STAMP >= '$tanggalDari' AND STAMP <= '$tanggalSampai'
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
                FROM input_data_tk
                WHERE
                LAIN != 0
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

        } else {

            $halamanAktif = 1;

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
            $ambildata_perhalaman = mysqli_query($con, "SELECT * FROM input_data_tk ORDER BY ID DESC LIMIT $dataAwal, $jumlahData  ");
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

    }

?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">

        <?php if(isset($_SESSION['form_kosong']) && $_SESSION['form_kosong'] == 'filter_kosong'){?>
          <div style="display: none;" class="alert alert-danger alert-dismissable"> Tidak Ada Filter yang di pilih
             <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
             <?php unset($_SESSION['form_kosong']); ?>
          </div>
        <?php } ?>

        <?php if(isset($_SESSION['form_kosong']) && $_SESSION['form_kosong'] == 'tanggal_awal_lebih_besar'){?>
          <div style="display: none;" class="alert alert-danger alert-dismissable"> Tanggal Awal harus lebih dulu dari pada tanggal Akhir
             <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
             <?php unset($_SESSION['form_kosong']); ?>
          </div>
        <?php } ?>

        <?php if(isset($_SESSION['form_kosong']) && $_SESSION['form_kosong'] == 'hanya_tanggal_dari'){?>
          <div style="display: none;" class="alert alert-danger alert-dismissable"> Filter Date to juga harus di isi
             <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
             <?php unset($_SESSION['form_kosong']); ?>
          </div>
        <?php } ?>

        <?php if(isset($_SESSION['form_kosong']) && $_SESSION['form_kosong'] == 'hanya_tanggal_sampai'){?>
          <div style="display: none;" class="alert alert-danger alert-dismissable"> Filter Date From juga harus di isi
             <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
             <?php unset($_SESSION['form_kosong']); ?>
          </div>
        <?php } ?>

        <?php if(isset($_SESSION['form_kosong']) && $_SESSION['form_kosong'] == 'empty_form'){?>
          <div style="display: none;" class="alert alert-danger alert-dismissable"> Harap Pilih Siswa Terlebih Dahulu
             <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
             <?php unset($_SESSION['form_kosong']); ?>
          </div>
        <?php } ?>

        <?php if(isset($_SESSION['pesan']) && $_SESSION['pesan'] == 'tambah'){?>
          <div style="display: none;" class="alert alert-warning alert-dismissable">Setup Naik Juz Berhasil Disimpan
             <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
             <?php unset($_SESSION['pesan']); ?>
          </div>
        <?php } ?>

        <?php if(isset($_SESSION['pesan']) && $_SESSION['pesan'] == 'edit'){?>
          <div style="display: none;" class="alert alert-info alert-dismissable">Data Naik Juz Berhasil Disimpan
             <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
             <?php unset($_SESSION['pesan']); ?>
          </div>
        <?php } ?>

        <?php if(isset($_SESSION['pesan']) && $_SESSION['pesan'] == 'edit_catatan') { ?>
          <div style="display: none;" class="alert alert-success alert-dismissable"> Histori Catatan Berhasil Disimpan
             <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
             <?php unset($_SESSION['pesan']); ?>
          </div>
        <?php } ?>

        <?php if(isset($_SESSION['pesan']) && $_SESSION['pesan'] == 'hapus') {?>
          <div style="display: none;" class="alert alert-info alert-dismissable">Data Naik Juz Berhasil Dihapus
             <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
             <?php unset($_SESSION['pesan']); ?>
          </div>
        <?php } ?>

        <?php if(isset($_SESSION['err_warning']) && $_SESSION['err_warning'] == 'err_validation'){?>
          <div style="display: none;" class="alert alert-danger alert-dismissable"> Mohon Cari Siswa Terlebih Dahulu
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <?php unset($_SESSION['err_warning']); ?>
          </div>
        <?php } ?>

        <?php if(isset($_SESSION['err_warning']) && $_SESSION['err_warning'] == 'no_data'){?>
          <div style="display: none;" class="alert alert-danger alert-dismissable"> Tidak Ada Data SPP atas Nama <?= $namaMurid; ?>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <?php unset($_SESSION['err_warning']); ?>
          </div>
        <?php } ?>

    </div>
</div>

<!-- Filter SPP -->
<?php if (isset($_POST['nextPageJustFilterSPP'])): ?>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
           
        </div>
        <form action="checkpembayaran" method="post">
            <div class="box-body">

                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>ID Siswa</label>
                            <input type="text" class="form-control" value="<?= $id; ?>" name="id_siswa" id="id_siswa" readonly="">
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" class="form-control" value="<?= $nis; ?>" name="nis_siswa" id="nis_siswa" readonly="">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" name="nama_siswa" class="form-control" value="<?= $namaSiswa; ?>" id="nama_siswa" readonly/>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="kelas_siswa" value="<?= $kelas; ?>" class="form-control" id="kelas_siswa" readonly/>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Panggilan</label>
                            <input type="text" class="form-control" id="panggilan_siswa" value="<?= $panggilan; ?>" name="panggilan_siswa" readonly/>
                        </div>
                    </div>
                    
                </div> 

                <div class="row">

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Filter By</label>
                            <select class="form-control" name="isi_filter">  
                                <option value="kosong"> -- PILIH -- </option>
                                <?php foreach ($filter_by['isifilter_by'] as $filby): ?>
                                    <?php if ($filby == $isifilby): ?>

                                        <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                    
                                    
                                    <?php else: ?>

                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php endif ?>
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
                            <button type="submit" name="filter_by" class="form-control btn-primary"> Filter </button>
                        </div>
                    </div>
                </div>

                <hr class="new1" />

            </div>
        </form>

        <?php require 'tabledatapagination.php'; ?>
        
    </div>

<?php elseif(isset($_POST['previousPageJustFilterSPP'])): ?>
    <!-- <?php echo "elseif previousPageJustFilterSPP"; ?> -->
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
           
        </div>
        <form action="checkpembayaran" method="post">
            <div class="box-body">

                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>ID Siswa</label>
                            <input type="text" class="form-control" value="<?= $id; ?>" name="id_siswa" id="id_siswa" readonly="">
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" class="form-control" value="<?= $nis; ?>" name="nis_siswa" id="nis_siswa" readonly="">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" name="nama_siswa" class="form-control" value="<?= $namaSiswa; ?>" id="nama_siswa" readonly/>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="kelas_siswa" value="<?= $kelas; ?>" class="form-control" value="MUHAMMAD ELVARO RAFARDHAN" id="kelas_siswa" readonly/>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Panggilan</label>
                            <input type="text" class="form-control" id="panggilan_siswa" value="<?= $panggilan; ?>" name="panggilan_siswa" readonly/>
                        </div>
                    </div>
                    
                </div> 

                <div class="row">

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Filter By</label>
                            <select class="form-control" name="isi_filter">  
                                <option value="kosong"> -- PILIH -- </option>
                                <?php foreach ($filter_by['isifilter_by'] as $filby): ?>
                                    <?php if ($filby == $isifilby): ?>

                                        <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                    
                                    
                                    <?php else: ?>

                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php endif ?>
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
                            <button type="submit" name="filter_by" class="form-control btn-primary"> Filter </button>
                        </div>
                    </div>
                </div>

                <hr class="new1" />

            </div>
        </form>

        <?php require 'tabledatapagination.php'; ?>
        
    </div>

<?php elseif(isset($_POST['toPageFilterSPP'])): ?>
    <!-- <?php echo "elseif toPageFilterSPP"; ?> -->
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
           
        </div>
        <form action="checkpembayaran" method="post">
            <div class="box-body">

                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>ID Siswa</label>
                            <input type="text" class="form-control" value="<?= $id; ?>" name="id_siswa" id="id_siswa" readonly="">
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" class="form-control" value="<?= $nis; ?>" name="nis_siswa" id="nis_siswa" readonly="">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" name="nama_siswa" class="form-control" value="<?= $namaSiswa; ?>" id="nama_siswa" readonly/>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="kelas_siswa" value="<?= $kelas; ?>" class="form-control" id="kelas_siswa" readonly/>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Panggilan</label>
                            <input type="text" class="form-control" id="panggilan_siswa" value="<?= $panggilan; ?>" name="panggilan_siswa" readonly/>
                        </div>
                    </div>
                    
                </div> 

                <div class="row">

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Filter By</label>
                            <select class="form-control" name="isi_filter">  
                                <option value="kosong"> -- PILIH -- </option>
                                <?php foreach ($filter_by['isifilter_by'] as $filby): ?>
                                    <?php if ($filby == $isifilby): ?>

                                        <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                    
                                    
                                    <?php else: ?>

                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php endif ?>
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
                            <button type="submit" name="filter_by" class="form-control btn-primary"> Filter </button>
                        </div>
                    </div>
                </div>

                <hr class="new1" />

            </div>
        </form>

        <?php require 'tabledatapagination.php'; ?>
        
    </div>

<?php elseif(isset($_POST['firstPageFilterSPP'])): ?>
    <!-- <?php echo "elseif firstPageFilterSPP"; ?> -->
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
           
        </div>
        <form action="checkpembayaran" method="post">
            <div class="box-body">

                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>ID Siswa</label>
                            <input type="text" class="form-control" value="<?= $id; ?>" name="id_siswa" id="id_siswa" readonly="">
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" class="form-control" value="<?= $nis; ?>" name="nis_siswa" id="nis_siswa" readonly="">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" name="nama_siswa" class="form-control" value="<?= $namaSiswa; ?>" id="nama_siswa" readonly/>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="kelas_siswa" value="<?= $kelas; ?>" class="form-control" id="kelas_siswa" readonly/>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Panggilan</label>
                            <input type="text" class="form-control" id="panggilan_siswa" value="<?= $panggilan; ?>" name="panggilan_siswa" readonly/>
                        </div>
                    </div>
                    
                </div> 

                <div class="row">

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Filter By</label>
                            <select class="form-control" name="isi_filter">  
                                <option value="kosong"> -- PILIH -- </option>
                                <?php foreach ($filter_by['isifilter_by'] as $filby): ?>
                                    <?php if ($filby == $isifilby): ?>

                                        <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                    
                                    
                                    <?php else: ?>

                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php endif ?>
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
                            <button type="submit" name="filter_by" class="form-control btn-primary"> Filter </button>
                        </div>
                    </div>
                </div>

                <hr class="new1" />

            </div>
        </form>

        <?php require 'tabledatapagination.php'; ?>
        
    </div>

<?php elseif(isset($_POST['lastPageFilterSPP'])): ?>
    <!-- <?php echo "elseif lastPageFilterSPP"; ?> -->

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
           
        </div>
        <form action="checkpembayaran" method="post">
            <div class="box-body">

                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>ID Siswa</label>
                            <input type="text" class="form-control" value="<?= $id; ?>" name="id_siswa" id="id_siswa" readonly="">
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" class="form-control" value="<?= $nis; ?>" name="nis_siswa" id="nis_siswa" readonly="">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" name="nama_siswa" class="form-control" value="<?= $namaSiswa; ?>" id="nama_siswa" readonly/>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="kelas_siswa" value="<?= $kelas; ?>" class="form-control" id="kelas_siswa" readonly/>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Panggilan</label>
                            <input type="text" class="form-control" id="panggilan_siswa" value="<?= $panggilan; ?>" name="panggilan_siswa" readonly/>
                        </div>
                    </div>
                    
                </div> 

                <div class="row">

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Filter By</label>
                            <select class="form-control" name="isi_filter">  
                                <option value="kosong"> -- PILIH -- </option>
                                <?php foreach ($filter_by['isifilter_by'] as $filby): ?>
                                    <?php if ($filby == $isifilby): ?>

                                        <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                    
                                    
                                    <?php else: ?>

                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php endif ?>
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
                            <button type="submit" name="filter_by" class="form-control btn-primary"> Filter </button>
                        </div>
                    </div>
                </div>

                <hr class="new1" />

            </div>
        </form>

        <?php require 'tabledatapagination.php'; ?>
        
    </div>
<!-- End Filter SPP -->

<!-- Filter SPP with Date -->
<?php elseif(isset($_POST['nextPageFilterSPPWithDate'])): ?>

    <?php 

        $tanggalDari   = str_replace([' 00:00:00'], "", $tanggalDari);
        $tanggalSampai = str_replace([' 23:59:59'], "", $tanggalSampai);

    ?>

    <div class="box box-info">

        <div class="box-header with-border">
            <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
           
        </div>

        <form action="checkpembayaran" method="post">
            <div class="box-body">

                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>ID Siswa</label>
                            <input type="text" class="form-control" value="<?= $id; ?>" name="id_siswa" id="id_siswa" readonly="">
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" class="form-control" value="<?= $nis; ?>" name="nis_siswa" id="nis_siswa" readonly="">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" name="nama_siswa" class="form-control" value="<?= $namaSiswa; ?>" readonly id="nama_siswa" />
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="kelas_siswa" value="<?= $kelas; ?>" readonly class="form-control" id="kelas_siswa" />
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Panggilan</label>
                            <input type="text" class="form-control" id="panggilan_siswa" value="<?= $panggilan; ?>" readonly name="panggilan_siswa" />
                        </div>
                    </div>
                    
                </div> 

                <div class="row">

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Filter By</label>
                            <select class="form-control" name="isi_filter">  
                                <option value="kosong"> -- PILIH -- </option>
                                <?php foreach ($filter_by['isifilter_by'] as $filby): ?>
                                    <?php if ($filby == $isifilby): ?>

                                        <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                    
                                    
                                    <?php else: ?>

                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php endif ?>
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
                            <button type="submit" name="filter_by" class="form-control btn-primary"> Filter </button>
                        </div>
                    </div>
                </div>

                <hr class="new1" />

            </div>
        </form>

        <?php require 'tabledatapagination.php'; ?>
        
    </div>

<?php elseif(isset($_POST['previousPageFilterSPPWithDate'])): ?>

    <?php 

        $tanggalDari   = str_replace([' 00:00:00'], "", $tanggalDari);
        $tanggalSampai = str_replace([' 23:59:59'], "", $tanggalSampai);

    ?>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
           
        </div>
        <form action="checkpembayaran" method="post">
            <div class="box-body">

                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>ID Siswa</label>
                            <input type="text" class="form-control" value="<?= $id; ?>" name="id_siswa" id="id_siswa" readonly="">
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" class="form-control" value="<?= $nis; ?>" name="nis_siswa" id="nis_siswa" readonly="">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" readonly name="nama_siswa" class="form-control" value="<?= $namaSiswa; ?>" id="nama_siswa" />
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" readonly name="kelas_siswa" value="<?= $kelas; ?>" class="form-control" value="MUHAMMAD ELVARO RAFARDHAN" id="kelas_siswa" />
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Panggilan</label>
                            <input type="text" readonly class="form-control" id="panggilan_siswa" value="<?= $panggilan; ?>" name="panggilan_siswa" />
                        </div>
                    </div>
                    
                </div> 

                <div class="row">

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Filter By</label>
                            <select class="form-control" name="isi_filter">  
                                <option value="kosong"> -- PILIH -- </option>
                                <?php foreach ($filter_by['isifilter_by'] as $filby): ?>
                                    <?php if ($filby == $isifilby): ?>

                                        <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                    
                                    
                                    <?php else: ?>

                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php endif ?>
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
                            <button type="submit" name="filter_by" class="form-control btn-primary"> Filter </button>
                        </div>
                    </div>
                </div>

                <hr class="new1" />

            </div>
        </form>

        <?php require 'tabledatapagination.php'; ?>
        
    </div>

<?php elseif(isset($_POST['firstPageFilterSPPWithDate'])): ?>

    <?php 

        $tanggalDari   = str_replace([' 00:00:00'], "", $tanggalDari);
        $tanggalSampai = str_replace([' 23:59:59'], "", $tanggalSampai);

    ?>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
           
        </div>
        <form action="checkpembayaran" method="post">
            <div class="box-body">

                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>ID Siswa</label>
                            <input type="text" class="form-control" value="<?= $id; ?>" name="id_siswa" id="id_siswa" readonly="">
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" class="form-control" value="<?= $nis; ?>" name="nis_siswa" id="nis_siswa" readonly="">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" name="nama_siswa" class="form-control" readonly value="<?= $namaSiswa; ?>" id="nama_siswa" />
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="kelas_siswa" value="<?= $kelas; ?>" class="form-control" readonly id="kelas_siswa" />
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Panggilan</label>
                            <input type="text" class="form-control" readonly id="panggilan_siswa" value="<?= $panggilan; ?>" name="panggilan_siswa" />
                        </div>
                    </div>
                    
                </div> 

                <div class="row">

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Filter By</label>
                            <select class="form-control" name="isi_filter">  
                                <option value="kosong"> -- PILIH -- </option>
                                <?php foreach ($filter_by['isifilter_by'] as $filby): ?>
                                    <?php if ($filby == $isifilby): ?>

                                        <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                    
                                    
                                    <?php else: ?>

                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php endif ?>
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
                            <button type="submit" name="filter_by" class="form-control btn-primary"> Filter </button>
                        </div>
                    </div>
                </div>

                <hr class="new1" />

            </div>
        </form>

        <?php require 'tabledatapagination.php'; ?>
        
    </div>

<?php elseif(isset($_POST['lastPageFilterSPPWithDate'])): ?>

    <?php 

        $tanggalDari   = str_replace([' 00:00:00'], "", $tanggalDari);
        $tanggalSampai = str_replace([' 23:59:59'], "", $tanggalSampai);

    ?>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
           
        </div>
        <form action="checkpembayaran" method="post">
            <div class="box-body">

                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>ID Siswa</label>
                            <input type="text" class="form-control" value="<?= $id; ?>" name="id_siswa" id="id_siswa" readonly="">
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" class="form-control" value="<?= $nis; ?>" name="nis_siswa" id="nis_siswa" readonly="">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" name="nama_siswa" class="form-control" readonly="" value="<?= $namaSiswa; ?>" id="nama_siswa" />
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="kelas_siswa" value="<?= $kelas; ?>" readonly class="form-control" id="kelas_siswa" />
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Panggilan</label>
                            <input type="text" class="form-control" id="panggilan_siswa" readonly value="<?= $panggilan; ?>" name="panggilan_siswa" />
                        </div>
                    </div>
                    
                </div> 

                <div class="row">

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Filter By</label>
                            <select class="form-control" name="isi_filter">  
                                <option value="kosong"> -- PILIH -- </option>
                                <?php foreach ($filter_by['isifilter_by'] as $filby): ?>
                                    <?php if ($filby == $isifilby): ?>

                                        <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                    
                                    
                                    <?php else: ?>

                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php endif ?>
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
                            <button type="submit" name="filter_by" class="form-control btn-primary"> Filter </button>
                        </div>
                    </div>
                </div>

                <hr class="new1" />

            </div>
        </form>

        <?php require 'tabledatapagination.php'; ?>
        
    </div>

<?php elseif(isset($_POST['toPageFilterSPPWithDate'])): ?>

    <?php 

        $tanggalDari   = str_replace([' 00:00:00'], "", $tanggalDari);
        $tanggalSampai = str_replace([' 23:59:59'], "", $tanggalSampai);

    ?>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
           
        </div>
        <form action="checkpembayaran" method="post">
            <div class="box-body">

                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>ID Siswa</label>
                            <input type="text" class="form-control" value="<?= $id; ?>" name="id_siswa" id="id_siswa" readonly="">
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" class="form-control" value="<?= $nis; ?>" name="nis_siswa" id="nis_siswa" readonly="">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" readonly name="nama_siswa" class="form-control" value="<?= $namaSiswa; ?>" id="nama_siswa" />
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" readonly name="kelas_siswa" value="<?= $kelas; ?>" class="form-control" id="kelas_siswa" />
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Panggilan</label>
                            <input type="text" readonly class="form-control" id="panggilan_siswa" value="<?= $panggilan; ?>" name="panggilan_siswa" />
                        </div>
                    </div>
                    
                </div> 

                <div class="row">

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Filter By</label>
                            <select class="form-control" name="isi_filter">  
                                <option value="kosong"> -- PILIH -- </option>
                                <?php foreach ($filter_by['isifilter_by'] as $filby): ?>
                                    <?php if ($filby == $isifilby): ?>

                                        <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                    
                                    
                                    <?php else: ?>

                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php endif ?>
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
                            <button type="submit" name="filter_by" class="form-control btn-primary"> Filter </button>
                        </div>
                    </div>
                </div>

                <hr class="new1" />

            </div>
        </form>

        <?php require 'tabledatapagination.php'; ?>
        
    </div>    
<!-- End Filter SPP with Date -->

<!-- Filter Semua -->
<?php elseif(isset($_POST['nextPageFilterSemua'])): ?>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
           
        </div>
        <form action="checkpembayaran" method="post">
            <div class="box-body">

                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>ID Siswa</label>
                            <input type="text" class="form-control" value="<?= $id; ?>" name="id_siswa" id="id_siswa" readonly="">
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" class="form-control" value="<?= $nis; ?>" name="nis_siswa" id="nis_siswa" readonly="">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" name="nama_siswa" class="form-control" value="<?= $namaSiswa; ?>" id="nama_siswa" readonly/>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="kelas_siswa" value="<?= $kelas; ?>" class="form-control" id="kelas_siswa" readonly/>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Panggilan</label>
                            <input type="text" class="form-control" id="panggilan_siswa" value="<?= $panggilan; ?>" name="panggilan_siswa" readonly/>
                        </div>
                    </div>
                    
                </div> 

                <div class="row">

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Filter By</label>
                            <select class="form-control" name="isi_filter">  
                                <option value="kosong"> -- PILIH -- </option>
                                <?php foreach ($filter_by['isifilter_by'] as $filby): ?>
                                    <?php if ($filby == $isifilby): ?>

                                        <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                    
                                    
                                    <?php else: ?>

                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php endif ?>
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
                            <button type="submit" name="filter_by" class="form-control btn-primary"> Filter </button>
                        </div>
                    </div>
                </div>

                <hr class="new1" />

            </div>
        </form>

        <?php require 'tabledatapagination.php'; ?>
        
    </div>

<?php elseif(isset($_POST['previousPageFilterSemua'])): ?>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
           
        </div>
        <form action="checkpembayaran" method="post">
            <div class="box-body">

                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>ID Siswa</label>
                            <input type="text" class="form-control" value="<?= $id; ?>" name="id_siswa" id="id_siswa" readonly="">
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" class="form-control" value="<?= $nis; ?>" name="nis_siswa" id="nis_siswa" readonly="">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" name="nama_siswa" class="form-control" value="<?= $namaSiswa; ?>" id="nama_siswa" readonly/>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="kelas_siswa" value="<?= $kelas; ?>" class="form-control" id="kelas_siswa" readonly/>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Panggilan</label>
                            <input type="text" class="form-control" id="panggilan_siswa" value="<?= $panggilan; ?>" name="panggilan_siswa" readonly/>
                        </div>
                    </div>
                    
                </div> 

                <div class="row">

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Filter By</label>
                            <select class="form-control" name="isi_filter">  
                                <option value="kosong"> -- PILIH -- </option>
                                <?php foreach ($filter_by['isifilter_by'] as $filby): ?>
                                    <?php if ($filby == $isifilby): ?>

                                        <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                    
                                    
                                    <?php else: ?>

                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php endif ?>
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
                            <button type="submit" name="filter_by" class="form-control btn-primary"> Filter </button>
                        </div>
                    </div>
                </div>

                <hr class="new1" />

            </div>
        </form>

        <?php require 'tabledatapagination.php'; ?>
        
    </div>

<?php elseif(isset($_POST['toPageFilterSemua'])): ?>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
           
        </div>
        <form action="checkpembayaran" method="post">
            <div class="box-body">

                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>ID Siswa</label>
                            <input type="text" class="form-control" value="<?= $id; ?>" name="id_siswa" id="id_siswa" readonly="">
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" class="form-control" value="<?= $nis; ?>" name="nis_siswa" id="nis_siswa" readonly="">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" name="nama_siswa" class="form-control" value="<?= $namaSiswa; ?>" id="nama_siswa" readonly/>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="kelas_siswa" value="<?= $kelas; ?>" class="form-control" id="kelas_siswa" readonly/>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Panggilan</label>
                            <input type="text" class="form-control" id="panggilan_siswa" value="<?= $panggilan; ?>" name="panggilan_siswa" readonly/>
                        </div>
                    </div>
                    
                </div> 

                <div class="row">

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Filter By</label>
                            <select class="form-control" name="isi_filter">  
                                <option value="kosong"> -- PILIH -- </option>
                                <?php foreach ($filter_by['isifilter_by'] as $filby): ?>
                                    <?php if ($filby == $isifilby): ?>

                                        <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                    
                                    
                                    <?php else: ?>

                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php endif ?>
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
                            <button type="submit" name="filter_by" class="form-control btn-primary"> Filter </button>
                        </div>
                    </div>
                </div>

                <hr class="new1" />

            </div>
        </form>

        <?php require 'tabledatapagination.php'; ?>
        
    </div>

<?php elseif(isset($_POST['firstPageFilterSemua'])): ?>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
           
        </div>
        <form action="checkpembayaran" method="post">
            <div class="box-body">

                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>ID Siswa</label>
                            <input type="text" class="form-control" value="<?= $id; ?>" name="id_siswa" id="id_siswa" readonly="">
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" class="form-control" value="<?= $nis; ?>" name="nis_siswa" id="nis_siswa" readonly="">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" name="nama_siswa" class="form-control" value="<?= $namaSiswa; ?>" id="nama_siswa" readonly/>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="kelas_siswa" value="<?= $kelas; ?>" class="form-control" id="kelas_siswa" readonly/>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Panggilan</label>
                            <input type="text" class="form-control" id="panggilan_siswa" value="<?= $panggilan; ?>" name="panggilan_siswa" readonly/>
                        </div>
                    </div>
                    
                </div> 

                <div class="row">

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Filter By</label>
                            <select class="form-control" name="isi_filter">  
                                <option value="kosong"> -- PILIH -- </option>
                                <?php foreach ($filter_by['isifilter_by'] as $filby): ?>
                                    <?php if ($filby == $isifilby): ?>

                                        <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                    
                                    
                                    <?php else: ?>

                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php endif ?>
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
                            <button type="submit" name="filter_by" class="form-control btn-primary"> Filter </button>
                        </div>
                    </div>
                </div>

                <hr class="new1" />

            </div>
        </form>

        <?php require 'tabledatapagination.php'; ?>
        
    </div>    

<?php elseif(isset($_POST['lastPageFilterSemua'])): ?>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
           
        </div>
        <form action="checkpembayaran" method="post">
            <div class="box-body">

                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>ID Siswa</label>
                            <input type="text" class="form-control" value="<?= $id; ?>" name="id_siswa" id="id_siswa" readonly="">
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" class="form-control" value="<?= $nis; ?>" name="nis_siswa" id="nis_siswa" readonly="">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" name="nama_siswa" class="form-control" value="<?= $namaSiswa; ?>" id="nama_siswa" readonly/>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="kelas_siswa" value="<?= $kelas; ?>" class="form-control" id="kelas_siswa" readonly/>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Panggilan</label>
                            <input type="text" class="form-control" id="panggilan_siswa" value="<?= $panggilan; ?>" name="panggilan_siswa" readonly/>
                        </div>
                    </div>
                    
                </div> 

                <div class="row">

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Filter By</label>
                            <select class="form-control" name="isi_filter">  
                                <option value="kosong"> -- PILIH -- </option>
                                <?php foreach ($filter_by['isifilter_by'] as $filby): ?>
                                    <?php if ($filby == $isifilby): ?>

                                        <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                    
                                    
                                    <?php else: ?>

                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php endif ?>
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
                            <button type="submit" name="filter_by" class="form-control btn-primary"> Filter </button>
                        </div>
                    </div>
                </div>

                <hr class="new1" />

            </div>
        </form>

        <?php require 'tabledatapagination.php'; ?>
        
    </div>
<!-- End Filter Semua -->

<!-- Filter Semua With Date -->
<?php elseif(isset($_POST['nextPageFilterSemuaWithDate'])): ?>

    <?php 

        $tanggalDari   = str_replace([' 00:00:00'], "", $tanggalDari);
        $tanggalSampai = str_replace([' 23:59:59'], "", $tanggalSampai);

    ?>

    <div class="box box-info">

        <div class="box-header with-border">
            <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
           
        </div>

        <form action="checkpembayaran" method="post">
            <div class="box-body">

                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>ID Siswa</label>
                            <input type="text" class="form-control" value="<?= $id; ?>" name="id_siswa" id="id_siswa" readonly="">
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" class="form-control" value="<?= $nis; ?>" name="nis_siswa" id="nis_siswa" readonly="">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" readonly name="nama_siswa" class="form-control" value="<?= $namaSiswa; ?>" id="nama_siswa" />
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" readonly name="kelas_siswa" value="<?= $kelas; ?>" class="form-control" id="kelas_siswa" />
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Panggilan</label>
                            <input type="text" readonly class="form-control" id="panggilan_siswa" value="<?= $panggilan; ?>" name="panggilan_siswa" />
                        </div>
                    </div>
                    
                </div> 

                <div class="row">

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Filter By</label>
                            <select class="form-control" name="isi_filter">  
                                <option value="kosong"> -- PILIH -- </option>
                                <?php foreach ($filter_by['isifilter_by'] as $filby): ?>
                                    <?php if ($filby == $isifilby): ?>

                                        <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                    
                                    
                                    <?php else: ?>

                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php endif ?>
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
                            <button type="submit" name="filter_by" class="form-control btn-primary"> Filter </button>
                        </div>
                    </div>
                </div>

                <hr class="new1" />

            </div>
        </form>

        <?php require 'tabledatapagination.php'; ?>
        
    </div>

<?php elseif(isset($_POST['previousPageFilterSemuaWithDate'])): ?>

    <?php 

        $tanggalDari   = str_replace([' 00:00:00'], "", $tanggalDari);
        $tanggalSampai = str_replace([' 23:59:59'], "", $tanggalSampai);

    ?>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
           
        </div>
        <form action="checkpembayaran" method="post">
            <div class="box-body">

                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>ID Siswa</label>
                            <input type="text" class="form-control" value="<?= $id; ?>" name="id_siswa" id="id_siswa" readonly="">
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" class="form-control" value="<?= $nis; ?>" name="nis_siswa" id="nis_siswa" readonly="">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" readonly name="nama_siswa" class="form-control" value="<?= $namaSiswa; ?>" id="nama_siswa" />
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" readonly name="kelas_siswa" value="<?= $kelas; ?>" class="form-control" value="MUHAMMAD ELVARO RAFARDHAN" id="kelas_siswa" />
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Panggilan</label>
                            <input type="text" readonly class="form-control" id="panggilan_siswa" value="<?= $panggilan; ?>" name="panggilan_siswa" />
                        </div>
                    </div>
                    
                </div> 

                <div class="row">

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Filter By</label>
                            <select class="form-control" name="isi_filter">  
                                <option value="kosong"> -- PILIH -- </option>
                                <?php foreach ($filter_by['isifilter_by'] as $filby): ?>
                                    <?php if ($filby == $isifilby): ?>

                                        <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                    
                                    
                                    <?php else: ?>

                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php endif ?>
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
                            <button type="submit" name="filter_by" class="form-control btn-primary"> Filter </button>
                        </div>
                    </div>
                </div>

                <hr class="new1" />

            </div>
        </form>

        <?php require 'tabledatapagination.php'; ?>
        
    </div>

<?php elseif(isset($_POST['toPageFilterSemuaWithDate'])): ?>

    <?php 

        $tanggalDari   = str_replace([' 00:00:00'], "", $tanggalDari);
        $tanggalSampai = str_replace([' 23:59:59'], "", $tanggalSampai);

    ?>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
           
        </div>
        <form action="checkpembayaran" method="post">
            <div class="box-body">

                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>ID Siswa</label>
                            <input type="text" class="form-control" value="<?= $id; ?>" name="id_siswa" id="id_siswa" readonly="">
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" class="form-control" value="<?= $nis; ?>" name="nis_siswa" id="nis_siswa" readonly="">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" readonly name="nama_siswa" class="form-control" value="<?= $namaSiswa; ?>" id="nama_siswa" />
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" readonly name="kelas_siswa" value="<?= $kelas; ?>" class="form-control" value="MUHAMMAD ELVARO RAFARDHAN" id="kelas_siswa" />
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Panggilan</label>
                            <input type="text" readonly class="form-control" id="panggilan_siswa" value="<?= $panggilan; ?>" name="panggilan_siswa" />
                        </div>
                    </div>
                    
                </div> 

                <div class="row">

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Filter By</label>
                            <select class="form-control" name="isi_filter">  
                                <option value="kosong"> -- PILIH -- </option>
                                <?php foreach ($filter_by['isifilter_by'] as $filby): ?>
                                    <?php if ($filby == $isifilby): ?>

                                        <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                    
                                    
                                    <?php else: ?>

                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php endif ?>
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
                            <button type="submit" name="filter_by" class="form-control btn-primary"> Filter </button>
                        </div>
                    </div>
                </div>

                <hr class="new1" />

            </div>
        </form>

        <?php require 'tabledatapagination.php'; ?>
        
    </div>

<?php elseif(isset($_POST['firstPageFilterSemuaWithDate'])): ?>

    <?php 

        $tanggalDari   = str_replace([' 00:00:00'], "", $tanggalDari);
        $tanggalSampai = str_replace([' 23:59:59'], "", $tanggalSampai);

    ?>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
           
        </div>
        <form action="checkpembayaran" method="post">
            <div class="box-body">

                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>ID Siswa</label>
                            <input type="text" class="form-control" value="<?= $id; ?>" name="id_siswa" id="id_siswa" readonly="">
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" class="form-control" value="<?= $nis; ?>" name="nis_siswa" id="nis_siswa" readonly="">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" readonly name="nama_siswa" class="form-control" value="<?= $namaSiswa; ?>" id="nama_siswa" />
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" readonly name="kelas_siswa" value="<?= $kelas; ?>" class="form-control" value="MUHAMMAD ELVARO RAFARDHAN" id="kelas_siswa" />
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Panggilan</label>
                            <input type="text" readonly class="form-control" id="panggilan_siswa" value="<?= $panggilan; ?>" name="panggilan_siswa" />
                        </div>
                    </div>
                    
                </div> 

                <div class="row">

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Filter By</label>
                            <select class="form-control" name="isi_filter">  
                                <option value="kosong"> -- PILIH -- </option>
                                <?php foreach ($filter_by['isifilter_by'] as $filby): ?>
                                    <?php if ($filby == $isifilby): ?>

                                        <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                    
                                    
                                    <?php else: ?>

                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php endif ?>
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
                            <button type="submit" name="filter_by" class="form-control btn-primary"> Filter </button>
                        </div>
                    </div>
                </div>

                <hr class="new1" />

            </div>
        </form>

        <?php require 'tabledatapagination.php'; ?>
        
    </div>

<?php elseif(isset($_POST['lastPageFilterSemuaWithDate'])): ?>

    <?php 

        $tanggalDari   = str_replace([' 00:00:00'], "", $tanggalDari);
        $tanggalSampai = str_replace([' 23:59:59'], "", $tanggalSampai);

    ?>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
           
        </div>
        <form action="checkpembayaran" method="post">
            <div class="box-body">

                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>ID Siswa</label>
                            <input type="text" class="form-control" value="<?= $id; ?>" name="id_siswa" id="id_siswa" readonly="">
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" class="form-control" value="<?= $nis; ?>" name="nis_siswa" id="nis_siswa" readonly="">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" readonly name="nama_siswa" class="form-control" value="<?= $namaSiswa; ?>" id="nama_siswa" />
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" readonly name="kelas_siswa" value="<?= $kelas; ?>" class="form-control" value="MUHAMMAD ELVARO RAFARDHAN" id="kelas_siswa" />
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Panggilan</label>
                            <input type="text" readonly class="form-control" id="panggilan_siswa" value="<?= $panggilan; ?>" name="panggilan_siswa" />
                        </div>
                    </div>
                    
                </div> 

                <div class="row">

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Filter By</label>
                            <select class="form-control" name="isi_filter">  
                                <option value="kosong"> -- PILIH -- </option>
                                <?php foreach ($filter_by['isifilter_by'] as $filby): ?>
                                    <?php if ($filby == $isifilby): ?>

                                        <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                    
                                    
                                    <?php else: ?>

                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php endif ?>
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
                            <button type="submit" name="filter_by" class="form-control btn-primary"> Filter </button>
                        </div>
                    </div>
                </div>

                <hr class="new1" />

            </div>
        </form>

        <?php require 'tabledatapagination.php'; ?>
        
    </div>
<!-- End Filter Semua With Date -->

<!-- Filter PANGKAL  -->
<?php elseif(isset($_POST['nextPageJustFilterPANGKAL'])): ?>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
           
        </div>
        <form action="checkpembayaran" method="post">
            <div class="box-body">

                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>ID Siswa</label>
                            <input type="text" class="form-control" value="<?= $id; ?>" name="id_siswa" id="id_siswa" readonly="">
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" class="form-control" value="<?= $nis; ?>" name="nis_siswa" id="nis_siswa" readonly="">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" name="nama_siswa" class="form-control" value="<?= $namaSiswa; ?>" id="nama_siswa" readonly/>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="kelas_siswa" value="<?= $kelas; ?>" class="form-control" id="kelas_siswa" readonly/>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Panggilan</label>
                            <input type="text" class="form-control" id="panggilan_siswa" value="<?= $panggilan; ?>" name="panggilan_siswa" readonly/>
                        </div>
                    </div>
                    
                </div> 

                <div class="row">

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Filter By</label>
                            <select class="form-control" name="isi_filter">  
                                <option value="kosong"> -- PILIH -- </option>
                                <?php foreach ($filter_by['isifilter_by'] as $filby): ?>
                                    <?php if ($filby == $isifilby): ?>

                                        <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                    
                                    
                                    <?php else: ?>

                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php endif ?>
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
                            <button type="submit" name="filter_by" class="form-control btn-primary"> Filter </button>
                        </div>
                    </div>
                </div>

                <hr class="new1" />

            </div>
        </form>

        <?php require 'tabledatapagination.php'; ?>
        
    </div>

<?php elseif(isset($_POST['previousPageJustFilterPANGKAL'])): ?>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
           
        </div>
        <form action="checkpembayaran" method="post">
            <div class="box-body">

                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>ID Siswa</label>
                            <input type="text" class="form-control" value="<?= $id; ?>" name="id_siswa" id="id_siswa" readonly="">
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" class="form-control" value="<?= $nis; ?>" name="nis_siswa" id="nis_siswa" readonly="">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" name="nama_siswa" class="form-control" value="<?= $namaSiswa; ?>" id="nama_siswa" readonly/>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="kelas_siswa" value="<?= $kelas; ?>" class="form-control" value="MUHAMMAD ELVARO RAFARDHAN" id="kelas_siswa" readonly/>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Panggilan</label>
                            <input type="text" class="form-control" id="panggilan_siswa" value="<?= $panggilan; ?>" name="panggilan_siswa" readonly/>
                        </div>
                    </div>
                    
                </div> 

                <div class="row">

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Filter By</label>
                            <select class="form-control" name="isi_filter">  
                                <option value="kosong"> -- PILIH -- </option>
                                <?php foreach ($filter_by['isifilter_by'] as $filby): ?>
                                    <?php if ($filby == $isifilby): ?>

                                        <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                    
                                    
                                    <?php else: ?>

                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php endif ?>
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
                            <button type="submit" name="filter_by" class="form-control btn-primary"> Filter </button>
                        </div>
                    </div>
                </div>

                <hr class="new1" />

            </div>
        </form>

        <?php require 'tabledatapagination.php'; ?>
        
    </div>

<?php elseif(isset($_POST['toPageFilterPANGKAL'])): ?>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
           
        </div>
        <form action="checkpembayaran" method="post">
            <div class="box-body">

                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>ID Siswa</label>
                            <input type="text" class="form-control" value="<?= $id; ?>" name="id_siswa" id="id_siswa" readonly="">
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" class="form-control" value="<?= $nis; ?>" name="nis_siswa" id="nis_siswa" readonly="">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" name="nama_siswa" class="form-control" value="<?= $namaSiswa; ?>" id="nama_siswa" readonly/>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="kelas_siswa" value="<?= $kelas; ?>" class="form-control" id="kelas_siswa" readonly/>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Panggilan</label>
                            <input type="text" class="form-control" id="panggilan_siswa" value="<?= $panggilan; ?>" name="panggilan_siswa" readonly/>
                        </div>
                    </div>
                    
                </div> 

                <div class="row">

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Filter By</label>
                            <select class="form-control" name="isi_filter">  
                                <option value="kosong"> -- PILIH -- </option>
                                <?php foreach ($filter_by['isifilter_by'] as $filby): ?>
                                    <?php if ($filby == $isifilby): ?>

                                        <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                    
                                    
                                    <?php else: ?>

                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php endif ?>
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
                            <button type="submit" name="filter_by" class="form-control btn-primary"> Filter </button>
                        </div>
                    </div>
                </div>

                <hr class="new1" />

            </div>
        </form>

        <?php require 'tabledatapagination.php'; ?>
        
    </div>

<?php elseif(isset($_POST['firstPageFilterPANGKAL'])): ?>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
           
        </div>
        <form action="checkpembayaran" method="post">
            <div class="box-body">

                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>ID Siswa</label>
                            <input type="text" class="form-control" value="<?= $id; ?>" name="id_siswa" id="id_siswa" readonly="">
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" class="form-control" value="<?= $nis; ?>" name="nis_siswa" id="nis_siswa" readonly="">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" name="nama_siswa" class="form-control" value="<?= $namaSiswa; ?>" id="nama_siswa" readonly/>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="kelas_siswa" value="<?= $kelas; ?>" class="form-control" id="kelas_siswa" readonly/>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Panggilan</label>
                            <input type="text" class="form-control" id="panggilan_siswa" value="<?= $panggilan; ?>" name="panggilan_siswa" readonly/>
                        </div>
                    </div>
                    
                </div> 

                <div class="row">

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Filter By</label>
                            <select class="form-control" name="isi_filter">  
                                <option value="kosong"> -- PILIH -- </option>
                                <?php foreach ($filter_by['isifilter_by'] as $filby): ?>
                                    <?php if ($filby == $isifilby): ?>

                                        <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                    
                                    
                                    <?php else: ?>

                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php endif ?>
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
                            <button type="submit" name="filter_by" class="form-control btn-primary"> Filter </button>
                        </div>
                    </div>
                </div>

                <hr class="new1" />

            </div>
        </form>

        <?php require 'tabledatapagination.php'; ?>
        
    </div>

<?php elseif(isset($_POST['lastPageFilterPANGKAL'])): ?>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
           
        </div>
        <form action="checkpembayaran" method="post">
            <div class="box-body">

                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>ID Siswa</label>
                            <input type="text" class="form-control" value="<?= $id; ?>" name="id_siswa" id="id_siswa" readonly="">
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" class="form-control" value="<?= $nis; ?>" name="nis_siswa" id="nis_siswa" readonly="">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" name="nama_siswa" class="form-control" value="<?= $namaSiswa; ?>" id="nama_siswa" readonly/>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="kelas_siswa" value="<?= $kelas; ?>" class="form-control" id="kelas_siswa" readonly/>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Panggilan</label>
                            <input type="text" class="form-control" id="panggilan_siswa" value="<?= $panggilan; ?>" name="panggilan_siswa" readonly/>
                        </div>
                    </div>
                    
                </div> 

                <div class="row">

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Filter By</label>
                            <select class="form-control" name="isi_filter">  
                                <option value="kosong"> -- PILIH -- </option>
                                <?php foreach ($filter_by['isifilter_by'] as $filby): ?>
                                    <?php if ($filby == $isifilby): ?>

                                        <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                    
                                    
                                    <?php else: ?>

                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php endif ?>
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
                            <button type="submit" name="filter_by" class="form-control btn-primary"> Filter </button>
                        </div>
                    </div>
                </div>

                <hr class="new1" />

            </div>
        </form>

        <?php require 'tabledatapagination.php'; ?>
        
    </div>

<!-- End Filter PANGKAL -->

<!-- Filter Pangkal With Date -->
<?php elseif(isset($_POST['nextPageFilterPangkalWithDate'])): ?>

    <?php 

        $tanggalDari   = str_replace([' 00:00:00'], "", $tanggalDari);
        $tanggalSampai = str_replace([' 23:59:59'], "", $tanggalSampai);

    ?>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
           
        </div>
        <form action="checkpembayaran" method="post">
            <div class="box-body">

                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>ID Siswa</label>
                            <input type="text" class="form-control" value="<?= $id; ?>" name="id_siswa" id="id_siswa" readonly="">
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" class="form-control" value="<?= $nis; ?>" name="nis_siswa" id="nis_siswa" readonly="">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" name="nama_siswa" class="form-control" value="<?= $namaSiswa; ?>" id="nama_siswa" readonly/>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="kelas_siswa" value="<?= $kelas; ?>" class="form-control" id="kelas_siswa" readonly/>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Panggilan</label>
                            <input type="text" class="form-control" id="panggilan_siswa" value="<?= $panggilan; ?>" name="panggilan_siswa" readonly/>
                        </div>
                    </div>
                    
                </div> 

                <div class="row">

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Filter By</label>
                            <select class="form-control" name="isi_filter">  
                                <option value="kosong"> -- PILIH -- </option>
                                <?php foreach ($filter_by['isifilter_by'] as $filby): ?>
                                    <?php if ($filby == $isifilby): ?>

                                        <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                    
                                    
                                    <?php else: ?>

                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php endif ?>
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
                            <button type="submit" name="filter_by" class="form-control btn-primary"> Filter </button>
                        </div>
                    </div>
                </div>

                <hr class="new1" />

            </div>
        </form>

        <?php require 'tabledatapagination.php'; ?>
        
    </div>

<?php elseif(isset($_POST['previousPageFilterPangkalWithDate'])): ?>

    <?php 

        $tanggalDari   = str_replace([' 00:00:00'], "", $tanggalDari);
        $tanggalSampai = str_replace([' 23:59:59'], "", $tanggalSampai);

    ?>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
           
        </div>
        <form action="checkpembayaran" method="post">
            <div class="box-body">

                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>ID Siswa</label>
                            <input type="text" class="form-control" value="<?= $id; ?>" name="id_siswa" id="id_siswa" readonly="">
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" class="form-control" value="<?= $nis; ?>" name="nis_siswa" id="nis_siswa" readonly="">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" name="nama_siswa" class="form-control" value="<?= $namaSiswa; ?>" id="nama_siswa" readonly/>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="kelas_siswa" value="<?= $kelas; ?>" class="form-control" id="kelas_siswa" readonly/>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Panggilan</label>
                            <input type="text" class="form-control" id="panggilan_siswa" value="<?= $panggilan; ?>" name="panggilan_siswa" readonly/>
                        </div>
                    </div>
                    
                </div> 

                <div class="row">

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Filter By</label>
                            <select class="form-control" name="isi_filter">  
                                <option value="kosong"> -- PILIH -- </option>
                                <?php foreach ($filter_by['isifilter_by'] as $filby): ?>
                                    <?php if ($filby == $isifilby): ?>

                                        <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                    
                                    
                                    <?php else: ?>

                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php endif ?>
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
                            <button type="submit" name="filter_by" class="form-control btn-primary"> Filter </button>
                        </div>
                    </div>
                </div>

                <hr class="new1" />

            </div>
        </form>

        <?php require 'tabledatapagination.php'; ?>
        
    </div>

<?php elseif(isset($_POST['toPageFilterPangkalWithDate'])): ?>

    <?php 

        $tanggalDari   = str_replace([' 00:00:00'], "", $tanggalDari);
        $tanggalSampai = str_replace([' 23:59:59'], "", $tanggalSampai);

    ?>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
           
        </div>
        <form action="checkpembayaran" method="post">
            <div class="box-body">

                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>ID Siswa</label>
                            <input type="text" class="form-control" value="<?= $id; ?>" name="id_siswa" id="id_siswa" readonly="">
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" class="form-control" value="<?= $nis; ?>" name="nis_siswa" id="nis_siswa" readonly="">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" name="nama_siswa" class="form-control" value="<?= $namaSiswa; ?>" id="nama_siswa" readonly/>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="kelas_siswa" value="<?= $kelas; ?>" class="form-control" id="kelas_siswa" readonly/>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Panggilan</label>
                            <input type="text" class="form-control" id="panggilan_siswa" value="<?= $panggilan; ?>" name="panggilan_siswa" readonly/>
                        </div>
                    </div>
                    
                </div> 

                <div class="row">

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Filter By</label>
                            <select class="form-control" name="isi_filter">  
                                <option value="kosong"> -- PILIH -- </option>
                                <?php foreach ($filter_by['isifilter_by'] as $filby): ?>
                                    <?php if ($filby == $isifilby): ?>

                                        <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                    
                                    
                                    <?php else: ?>

                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php endif ?>
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
                            <button type="submit" name="filter_by" class="form-control btn-primary"> Filter </button>
                        </div>
                    </div>
                </div>

                <hr class="new1" />

            </div>
        </form>

        <?php require 'tabledatapagination.php'; ?>
        
    </div>

<?php elseif(isset($_POST['firstPageFilterPangkalWithDate'])): ?>

    <?php 

        $tanggalDari   = str_replace([' 00:00:00'], "", $tanggalDari);
        $tanggalSampai = str_replace([' 23:59:59'], "", $tanggalSampai);

    ?>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
           
        </div>
        <form action="checkpembayaran" method="post">
            <div class="box-body">

                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>ID Siswa</label>
                            <input type="text" class="form-control" value="<?= $id; ?>" name="id_siswa" id="id_siswa" readonly="">
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" class="form-control" value="<?= $nis; ?>" name="nis_siswa" id="nis_siswa" readonly="">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" name="nama_siswa" class="form-control" value="<?= $namaSiswa; ?>" id="nama_siswa" readonly/>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="kelas_siswa" value="<?= $kelas; ?>" class="form-control" id="kelas_siswa" readonly/>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Panggilan</label>
                            <input type="text" class="form-control" id="panggilan_siswa" value="<?= $panggilan; ?>" name="panggilan_siswa" readonly/>
                        </div>
                    </div>
                    
                </div> 

                <div class="row">

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Filter By</label>
                            <select class="form-control" name="isi_filter">  
                                <option value="kosong"> -- PILIH -- </option>
                                <?php foreach ($filter_by['isifilter_by'] as $filby): ?>
                                    <?php if ($filby == $isifilby): ?>

                                        <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                    
                                    
                                    <?php else: ?>

                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php endif ?>
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
                            <button type="submit" name="filter_by" class="form-control btn-primary"> Filter </button>
                        </div>
                    </div>
                </div>

                <hr class="new1" />

            </div>
        </form>

        <?php require 'tabledatapagination.php'; ?>
        
    </div>

<?php elseif(isset($_POST['lastPageFilterPangkalWithDate'])): ?>

    <?php 

        $tanggalDari   = str_replace([' 00:00:00'], "", $tanggalDari);
        $tanggalSampai = str_replace([' 23:59:59'], "", $tanggalSampai);

    ?>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
           
        </div>
        <form action="checkpembayaran" method="post">
            <div class="box-body">

                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>ID Siswa</label>
                            <input type="text" class="form-control" value="<?= $id; ?>" name="id_siswa" id="id_siswa" readonly="">
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" class="form-control" value="<?= $nis; ?>" name="nis_siswa" id="nis_siswa" readonly="">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" name="nama_siswa" class="form-control" value="<?= $namaSiswa; ?>" id="nama_siswa" readonly/>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="kelas_siswa" value="<?= $kelas; ?>" class="form-control" id="kelas_siswa" readonly/>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Panggilan</label>
                            <input type="text" class="form-control" id="panggilan_siswa" value="<?= $panggilan; ?>" name="panggilan_siswa" readonly/>
                        </div>
                    </div>
                    
                </div> 

                <div class="row">

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Filter By</label>
                            <select class="form-control" name="isi_filter">  
                                <option value="kosong"> -- PILIH -- </option>
                                <?php foreach ($filter_by['isifilter_by'] as $filby): ?>
                                    <?php if ($filby == $isifilby): ?>

                                        <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                    
                                    
                                    <?php else: ?>

                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php endif ?>
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
                            <button type="submit" name="filter_by" class="form-control btn-primary"> Filter </button>
                        </div>
                    </div>
                </div>

                <hr class="new1" />

            </div>
        </form>

        <?php require 'tabledatapagination.php'; ?>
        
    </div>
<!-- End Filter Pangkal With Date -->

<!-- Filter Kegiatan -->
<?php elseif(isset($_POST['nextPageFilterKegiatan'])): ?>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
           
        </div>
        <form action="checkpembayaran" method="post">
            <div class="box-body">

                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>ID Siswa</label>
                            <input type="text" class="form-control" value="<?= $id; ?>" name="id_siswa" id="id_siswa" readonly="">
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" class="form-control" value="<?= $nis; ?>" name="nis_siswa" id="nis_siswa" readonly="">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" name="nama_siswa" class="form-control" value="<?= $namaSiswa; ?>" id="nama_siswa" readonly/>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="kelas_siswa" value="<?= $kelas; ?>" class="form-control" id="kelas_siswa" readonly/>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Panggilan</label>
                            <input type="text" class="form-control" id="panggilan_siswa" value="<?= $panggilan; ?>" name="panggilan_siswa" readonly/>
                        </div>
                    </div>
                    
                </div> 

                <div class="row">

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Filter By</label>
                            <select class="form-control" name="isi_filter">  
                                <option value="kosong"> -- PILIH -- </option>
                                <?php foreach ($filter_by['isifilter_by'] as $filby): ?>
                                    <?php if ($filby == $isifilby): ?>

                                        <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                    
                                    
                                    <?php else: ?>

                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php endif ?>
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
                            <button type="submit" name="filter_by" class="form-control btn-primary"> Filter </button>
                        </div>
                    </div>
                </div>

                <hr class="new1" />

            </div>
        </form>

        <?php require 'tabledatapagination.php'; ?>
        
    </div>

<?php elseif(isset($_POST['previousPageFilterKegiatan'])): ?>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
           
        </div>
        <form action="checkpembayaran" method="post">
            <div class="box-body">

                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>ID Siswa</label>
                            <input type="text" class="form-control" value="<?= $id; ?>" name="id_siswa" id="id_siswa" readonly="">
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" class="form-control" value="<?= $nis; ?>" name="nis_siswa" id="nis_siswa" readonly="">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" name="nama_siswa" class="form-control" value="<?= $namaSiswa; ?>" id="nama_siswa" readonly/>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="kelas_siswa" value="<?= $kelas; ?>" class="form-control" id="kelas_siswa" readonly/>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Panggilan</label>
                            <input type="text" class="form-control" id="panggilan_siswa" value="<?= $panggilan; ?>" name="panggilan_siswa" readonly/>
                        </div>
                    </div>
                    
                </div> 

                <div class="row">

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Filter By</label>
                            <select class="form-control" name="isi_filter">  
                                <option value="kosong"> -- PILIH -- </option>
                                <?php foreach ($filter_by['isifilter_by'] as $filby): ?>
                                    <?php if ($filby == $isifilby): ?>

                                        <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                    
                                    
                                    <?php else: ?>

                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php endif ?>
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
                            <button type="submit" name="filter_by" class="form-control btn-primary"> Filter </button>
                        </div>
                    </div>
                </div>

                <hr class="new1" />

            </div>
        </form>

        <?php require 'tabledatapagination.php'; ?>
        
    </div>

<?php elseif(isset($_POST['toPageFilterKegiatan'])): ?>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
           
        </div>
        <form action="checkpembayaran" method="post">
            <div class="box-body">

                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>ID Siswa</label>
                            <input type="text" class="form-control" value="<?= $id; ?>" name="id_siswa" id="id_siswa" readonly="">
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" class="form-control" value="<?= $nis; ?>" name="nis_siswa" id="nis_siswa" readonly="">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" name="nama_siswa" class="form-control" value="<?= $namaSiswa; ?>" id="nama_siswa" readonly/>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="kelas_siswa" value="<?= $kelas; ?>" class="form-control" id="kelas_siswa" readonly/>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Panggilan</label>
                            <input type="text" class="form-control" id="panggilan_siswa" value="<?= $panggilan; ?>" name="panggilan_siswa" readonly/>
                        </div>
                    </div>
                    
                </div> 

                <div class="row">

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Filter By</label>
                            <select class="form-control" name="isi_filter">  
                                <option value="kosong"> -- PILIH -- </option>
                                <?php foreach ($filter_by['isifilter_by'] as $filby): ?>
                                    <?php if ($filby == $isifilby): ?>

                                        <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                    
                                    
                                    <?php else: ?>

                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php endif ?>
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
                            <button type="submit" name="filter_by" class="form-control btn-primary"> Filter </button>
                        </div>
                    </div>
                </div>

                <hr class="new1" />

            </div>
        </form>

        <?php require 'tabledatapagination.php'; ?>
        
    </div>

<?php elseif(isset($_POST['firstPageFilterKegiatan'])): ?>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
           
        </div>
        <form action="checkpembayaran" method="post">
            <div class="box-body">

                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>ID Siswa</label>
                            <input type="text" class="form-control" value="<?= $id; ?>" name="id_siswa" id="id_siswa" readonly="">
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" class="form-control" value="<?= $nis; ?>" name="nis_siswa" id="nis_siswa" readonly="">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" name="nama_siswa" class="form-control" value="<?= $namaSiswa; ?>" id="nama_siswa" readonly/>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="kelas_siswa" value="<?= $kelas; ?>" class="form-control" id="kelas_siswa" readonly/>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Panggilan</label>
                            <input type="text" class="form-control" id="panggilan_siswa" value="<?= $panggilan; ?>" name="panggilan_siswa" readonly/>
                        </div>
                    </div>
                    
                </div> 

                <div class="row">

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Filter By</label>
                            <select class="form-control" name="isi_filter">  
                                <option value="kosong"> -- PILIH -- </option>
                                <?php foreach ($filter_by['isifilter_by'] as $filby): ?>
                                    <?php if ($filby == $isifilby): ?>

                                        <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                    
                                    
                                    <?php else: ?>

                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php endif ?>
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
                            <button type="submit" name="filter_by" class="form-control btn-primary"> Filter </button>
                        </div>
                    </div>
                </div>

                <hr class="new1" />

            </div>
        </form>

        <?php require 'tabledatapagination.php'; ?>
        
    </div>

<?php elseif(isset($_POST['lastPageFilterKegiatan'])): ?>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
           
        </div>
        <form action="checkpembayaran" method="post">
            <div class="box-body">

                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>ID Siswa</label>
                            <input type="text" class="form-control" value="<?= $id; ?>" name="id_siswa" id="id_siswa" readonly="">
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" class="form-control" value="<?= $nis; ?>" name="nis_siswa" id="nis_siswa" readonly="">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" name="nama_siswa" class="form-control" value="<?= $namaSiswa; ?>" id="nama_siswa" readonly/>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="kelas_siswa" value="<?= $kelas; ?>" class="form-control" id="kelas_siswa" readonly/>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Panggilan</label>
                            <input type="text" class="form-control" id="panggilan_siswa" value="<?= $panggilan; ?>" name="panggilan_siswa" readonly/>
                        </div>
                    </div>
                    
                </div> 

                <div class="row">

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Filter By</label>
                            <select class="form-control" name="isi_filter">  
                                <option value="kosong"> -- PILIH -- </option>
                                <?php foreach ($filter_by['isifilter_by'] as $filby): ?>
                                    <?php if ($filby == $isifilby): ?>

                                        <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                    
                                    
                                    <?php else: ?>

                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php endif ?>
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
                            <button type="submit" name="filter_by" class="form-control btn-primary"> Filter </button>
                        </div>
                    </div>
                </div>

                <hr class="new1" />

            </div>
        </form>

        <?php require 'tabledatapagination.php'; ?>
        
    </div>
<!-- End Filter Kegiatan -->

<!-- Filter Kegiatan With Date -->
<?php elseif(isset($_POST['nextPageFilterKegiatanWithDate'])): ?>

    <?php 

        $tanggalDari   = str_replace([' 00:00:00'], "", $tanggalDari);
        $tanggalSampai = str_replace([' 23:59:59'], "", $tanggalSampai);

    ?>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
           
        </div>
        <form action="checkpembayaran" method="post">
            <div class="box-body">

                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>ID Siswa</label>
                            <input type="text" class="form-control" value="<?= $id; ?>" name="id_siswa" id="id_siswa" readonly="">
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" class="form-control" value="<?= $nis; ?>" name="nis_siswa" id="nis_siswa" readonly="">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" name="nama_siswa" class="form-control" value="<?= $namaSiswa; ?>" id="nama_siswa" readonly/>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="kelas_siswa" value="<?= $kelas; ?>" class="form-control" id="kelas_siswa" readonly/>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Panggilan</label>
                            <input type="text" class="form-control" id="panggilan_siswa" value="<?= $panggilan; ?>" name="panggilan_siswa" readonly/>
                        </div>
                    </div>
                    
                </div> 

                <div class="row">

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Filter By</label>
                            <select class="form-control" name="isi_filter">  
                                <option value="kosong"> -- PILIH -- </option>
                                <?php foreach ($filter_by['isifilter_by'] as $filby): ?>
                                    <?php if ($filby == $isifilby): ?>

                                        <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                    
                                    
                                    <?php else: ?>

                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php endif ?>
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
                            <button type="submit" name="filter_by" class="form-control btn-primary"> Filter </button>
                        </div>
                    </div>
                </div>

                <hr class="new1" />

            </div>
        </form>

        <?php require 'tabledatapagination.php'; ?>
        
    </div>

<?php elseif(isset($_POST['previousPageFilterKegiatanWithDate'])): ?>

    <?php 

        $tanggalDari   = str_replace([' 00:00:00'], "", $tanggalDari);
        $tanggalSampai = str_replace([' 23:59:59'], "", $tanggalSampai);

    ?>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
           
        </div>
        <form action="checkpembayaran" method="post">
            <div class="box-body">

                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>ID Siswa</label>
                            <input type="text" class="form-control" value="<?= $id; ?>" name="id_siswa" id="id_siswa" readonly="">
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" class="form-control" value="<?= $nis; ?>" name="nis_siswa" id="nis_siswa" readonly="">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" name="nama_siswa" class="form-control" value="<?= $namaSiswa; ?>" id="nama_siswa" readonly/>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="kelas_siswa" value="<?= $kelas; ?>" class="form-control" id="kelas_siswa" readonly/>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Panggilan</label>
                            <input type="text" class="form-control" id="panggilan_siswa" value="<?= $panggilan; ?>" name="panggilan_siswa" readonly/>
                        </div>
                    </div>
                    
                </div> 

                <div class="row">

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Filter By</label>
                            <select class="form-control" name="isi_filter">  
                                <option value="kosong"> -- PILIH -- </option>
                                <?php foreach ($filter_by['isifilter_by'] as $filby): ?>
                                    <?php if ($filby == $isifilby): ?>

                                        <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                    
                                    
                                    <?php else: ?>

                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php endif ?>
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
                            <button type="submit" name="filter_by" class="form-control btn-primary"> Filter </button>
                        </div>
                    </div>
                </div>

                <hr class="new1" />

            </div>
        </form>

        <?php require 'tabledatapagination.php'; ?>
        
    </div>

<?php elseif(isset($_POST['toPageFilterKegiatanWithDate'])): ?>

    <?php 

        $tanggalDari   = str_replace([' 00:00:00'], "", $tanggalDari);
        $tanggalSampai = str_replace([' 23:59:59'], "", $tanggalSampai);

    ?>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
           
        </div>
        <form action="checkpembayaran" method="post">
            <div class="box-body">

                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>ID Siswa</label>
                            <input type="text" class="form-control" value="<?= $id; ?>" name="id_siswa" id="id_siswa" readonly="">
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" class="form-control" value="<?= $nis; ?>" name="nis_siswa" id="nis_siswa" readonly="">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" name="nama_siswa" class="form-control" value="<?= $namaSiswa; ?>" id="nama_siswa" readonly/>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="kelas_siswa" value="<?= $kelas; ?>" class="form-control" id="kelas_siswa" readonly/>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Panggilan</label>
                            <input type="text" class="form-control" id="panggilan_siswa" value="<?= $panggilan; ?>" name="panggilan_siswa" readonly/>
                        </div>
                    </div>
                    
                </div> 

                <div class="row">

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Filter By</label>
                            <select class="form-control" name="isi_filter">  
                                <option value="kosong"> -- PILIH -- </option>
                                <?php foreach ($filter_by['isifilter_by'] as $filby): ?>
                                    <?php if ($filby == $isifilby): ?>

                                        <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                    
                                    
                                    <?php else: ?>

                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php endif ?>
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
                            <button type="submit" name="filter_by" class="form-control btn-primary"> Filter </button>
                        </div>
                    </div>
                </div>

                <hr class="new1" />

            </div>
        </form>

        <?php require 'tabledatapagination.php'; ?>
        
    </div>

<?php elseif(isset($_POST['firstPageFilterKegiatanWithDate'])): ?>

    <?php 

        $tanggalDari   = str_replace([' 00:00:00'], "", $tanggalDari);
        $tanggalSampai = str_replace([' 23:59:59'], "", $tanggalSampai);

    ?>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
           
        </div>
        <form action="checkpembayaran" method="post">
            <div class="box-body">

                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>ID Siswa</label>
                            <input type="text" class="form-control" value="<?= $id; ?>" name="id_siswa" id="id_siswa" readonly="">
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" class="form-control" value="<?= $nis; ?>" name="nis_siswa" id="nis_siswa" readonly="">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" name="nama_siswa" class="form-control" value="<?= $namaSiswa; ?>" id="nama_siswa" readonly/>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="kelas_siswa" value="<?= $kelas; ?>" class="form-control" id="kelas_siswa" readonly/>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Panggilan</label>
                            <input type="text" class="form-control" id="panggilan_siswa" value="<?= $panggilan; ?>" name="panggilan_siswa" readonly/>
                        </div>
                    </div>
                    
                </div> 

                <div class="row">

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Filter By</label>
                            <select class="form-control" name="isi_filter">  
                                <option value="kosong"> -- PILIH -- </option>
                                <?php foreach ($filter_by['isifilter_by'] as $filby): ?>
                                    <?php if ($filby == $isifilby): ?>

                                        <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                    
                                    
                                    <?php else: ?>

                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php endif ?>
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
                            <button type="submit" name="filter_by" class="form-control btn-primary"> Filter </button>
                        </div>
                    </div>
                </div>

                <hr class="new1" />

            </div>
        </form>

        <?php require 'tabledatapagination.php'; ?>
        
    </div>

<?php elseif(isset($_POST['lastPageFilterKegiatanWithDate'])): ?>
    
    <?php 

        $tanggalDari   = str_replace([' 00:00:00'], "", $tanggalDari);
        $tanggalSampai = str_replace([' 23:59:59'], "", $tanggalSampai);

    ?>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
           
        </div>
        <form action="checkpembayaran" method="post">
            <div class="box-body">

                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>ID Siswa</label>
                            <input type="text" class="form-control" value="<?= $id; ?>" name="id_siswa" id="id_siswa" readonly="">
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" class="form-control" value="<?= $nis; ?>" name="nis_siswa" id="nis_siswa" readonly="">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" name="nama_siswa" class="form-control" value="<?= $namaSiswa; ?>" id="nama_siswa" readonly/>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="kelas_siswa" value="<?= $kelas; ?>" class="form-control" id="kelas_siswa" readonly/>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Panggilan</label>
                            <input type="text" class="form-control" id="panggilan_siswa" value="<?= $panggilan; ?>" name="panggilan_siswa" readonly/>
                        </div>
                    </div>
                    
                </div> 

                <div class="row">

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Filter By</label>
                            <select class="form-control" name="isi_filter">  
                                <option value="kosong"> -- PILIH -- </option>
                                <?php foreach ($filter_by['isifilter_by'] as $filby): ?>
                                    <?php if ($filby == $isifilby): ?>

                                        <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                    
                                    
                                    <?php else: ?>

                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php endif ?>
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
                            <button type="submit" name="filter_by" class="form-control btn-primary"> Filter </button>
                        </div>
                    </div>
                </div>

                <hr class="new1" />

            </div>
        </form>

        <?php require 'tabledatapagination.php'; ?>
        
    </div>
<!-- End Filter Kegiatan With Date -->

<!-- Filter Buku -->
<?php elseif(isset($_POST['nextPageFilterBuku'])): ?>

    <?php 

        $tanggalDari   = str_replace([' 00:00:00'], "", $tanggalDari);
        $tanggalSampai = str_replace([' 23:59:59'], "", $tanggalSampai);

    ?>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
           
        </div>
        <form action="checkpembayaran" method="post">
            <div class="box-body">

                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>ID Siswa</label>
                            <input type="text" class="form-control" value="<?= $id; ?>" name="id_siswa" id="id_siswa" readonly="">
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" class="form-control" value="<?= $nis; ?>" name="nis_siswa" id="nis_siswa" readonly="">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" name="nama_siswa" class="form-control" value="<?= $namaSiswa; ?>" id="nama_siswa" readonly/>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="kelas_siswa" value="<?= $kelas; ?>" class="form-control" id="kelas_siswa" readonly/>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Panggilan</label>
                            <input type="text" class="form-control" id="panggilan_siswa" value="<?= $panggilan; ?>" name="panggilan_siswa" readonly/>
                        </div>
                    </div>
                    
                </div> 

                <div class="row">

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Filter By</label>
                            <select class="form-control" name="isi_filter">  
                                <option value="kosong"> -- PILIH -- </option>
                                <?php foreach ($filter_by['isifilter_by'] as $filby): ?>
                                    <?php if ($filby == $isifilby): ?>

                                        <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                    
                                    
                                    <?php else: ?>

                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php endif ?>
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
                            <button type="submit" name="filter_by" class="form-control btn-primary"> Filter </button>
                        </div>
                    </div>
                </div>

                <hr class="new1" />

            </div>
        </form>

        <?php require 'tabledatapagination.php'; ?>
        
    </div>

<?php elseif(isset($_POST['previousPageFilterBuku'])): ?>

    <?php 

        $tanggalDari   = str_replace([' 00:00:00'], "", $tanggalDari);
        $tanggalSampai = str_replace([' 23:59:59'], "", $tanggalSampai);

    ?>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
           
        </div>
        <form action="checkpembayaran" method="post">
            <div class="box-body">

                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>ID Siswa</label>
                            <input type="text" class="form-control" value="<?= $id; ?>" name="id_siswa" id="id_siswa" readonly="">
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" class="form-control" value="<?= $nis; ?>" name="nis_siswa" id="nis_siswa" readonly="">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" name="nama_siswa" class="form-control" value="<?= $namaSiswa; ?>" id="nama_siswa" readonly/>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="kelas_siswa" value="<?= $kelas; ?>" class="form-control" id="kelas_siswa" readonly/>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Panggilan</label>
                            <input type="text" class="form-control" id="panggilan_siswa" value="<?= $panggilan; ?>" name="panggilan_siswa" readonly/>
                        </div>
                    </div>
                    
                </div> 

                <div class="row">

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Filter By</label>
                            <select class="form-control" name="isi_filter">  
                                <option value="kosong"> -- PILIH -- </option>
                                <?php foreach ($filter_by['isifilter_by'] as $filby): ?>
                                    <?php if ($filby == $isifilby): ?>

                                        <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                    
                                    
                                    <?php else: ?>

                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php endif ?>
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
                            <button type="submit" name="filter_by" class="form-control btn-primary"> Filter </button>
                        </div>
                    </div>
                </div>

                <hr class="new1" />

            </div>
        </form>

        <?php require 'tabledatapagination.php'; ?>
        
    </div>

<?php elseif(isset($_POST['toPageFilterBuku'])): ?>

    <?php 

        $tanggalDari   = str_replace([' 00:00:00'], "", $tanggalDari);
        $tanggalSampai = str_replace([' 23:59:59'], "", $tanggalSampai);

    ?>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
           
        </div>
        <form action="checkpembayaran" method="post">
            <div class="box-body">

                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>ID Siswa</label>
                            <input type="text" class="form-control" value="<?= $id; ?>" name="id_siswa" id="id_siswa" readonly="">
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" class="form-control" value="<?= $nis; ?>" name="nis_siswa" id="nis_siswa" readonly="">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" name="nama_siswa" class="form-control" value="<?= $namaSiswa; ?>" id="nama_siswa" readonly/>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="kelas_siswa" value="<?= $kelas; ?>" class="form-control" id="kelas_siswa" readonly/>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Panggilan</label>
                            <input type="text" class="form-control" id="panggilan_siswa" value="<?= $panggilan; ?>" name="panggilan_siswa" readonly/>
                        </div>
                    </div>
                    
                </div> 

                <div class="row">

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Filter By</label>
                            <select class="form-control" name="isi_filter">  
                                <option value="kosong"> -- PILIH -- </option>
                                <?php foreach ($filter_by['isifilter_by'] as $filby): ?>
                                    <?php if ($filby == $isifilby): ?>

                                        <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                    
                                    
                                    <?php else: ?>

                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php endif ?>
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
                            <button type="submit" name="filter_by" class="form-control btn-primary"> Filter </button>
                        </div>
                    </div>
                </div>

                <hr class="new1" />

            </div>
        </form>

        <?php require 'tabledatapagination.php'; ?>
        
    </div>

<?php elseif(isset($_POST['firstPageFilterBuku'])): ?>

    <?php 

        $tanggalDari   = str_replace([' 00:00:00'], "", $tanggalDari);
        $tanggalSampai = str_replace([' 23:59:59'], "", $tanggalSampai);

    ?>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
           
        </div>
        <form action="checkpembayaran" method="post">
            <div class="box-body">

                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>ID Siswa</label>
                            <input type="text" class="form-control" value="<?= $id; ?>" name="id_siswa" id="id_siswa" readonly="">
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" class="form-control" value="<?= $nis; ?>" name="nis_siswa" id="nis_siswa" readonly="">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" name="nama_siswa" class="form-control" value="<?= $namaSiswa; ?>" id="nama_siswa" readonly/>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="kelas_siswa" value="<?= $kelas; ?>" class="form-control" id="kelas_siswa" readonly/>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Panggilan</label>
                            <input type="text" class="form-control" id="panggilan_siswa" value="<?= $panggilan; ?>" name="panggilan_siswa" readonly/>
                        </div>
                    </div>
                    
                </div> 

                <div class="row">

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Filter By</label>
                            <select class="form-control" name="isi_filter">  
                                <option value="kosong"> -- PILIH -- </option>
                                <?php foreach ($filter_by['isifilter_by'] as $filby): ?>
                                    <?php if ($filby == $isifilby): ?>

                                        <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                    
                                    
                                    <?php else: ?>

                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php endif ?>
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
                            <button type="submit" name="filter_by" class="form-control btn-primary"> Filter </button>
                        </div>
                    </div>
                </div>

                <hr class="new1" />

            </div>
        </form>

        <?php require 'tabledatapagination.php'; ?>
        
    </div>

<?php elseif(isset($_POST['lastPageFilterBuku'])): ?>

    <?php 

        $tanggalDari   = str_replace([' 00:00:00'], "", $tanggalDari);
        $tanggalSampai = str_replace([' 23:59:59'], "", $tanggalSampai);

    ?>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
           
        </div>
        <form action="checkpembayaran" method="post">
            <div class="box-body">

                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>ID Siswa</label>
                            <input type="text" class="form-control" value="<?= $id; ?>" name="id_siswa" id="id_siswa" readonly="">
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" class="form-control" value="<?= $nis; ?>" name="nis_siswa" id="nis_siswa" readonly="">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" name="nama_siswa" class="form-control" value="<?= $namaSiswa; ?>" id="nama_siswa" readonly/>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="kelas_siswa" value="<?= $kelas; ?>" class="form-control" id="kelas_siswa" readonly/>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Panggilan</label>
                            <input type="text" class="form-control" id="panggilan_siswa" value="<?= $panggilan; ?>" name="panggilan_siswa" readonly/>
                        </div>
                    </div>
                    
                </div> 

                <div class="row">

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Filter By</label>
                            <select class="form-control" name="isi_filter">  
                                <option value="kosong"> -- PILIH -- </option>
                                <?php foreach ($filter_by['isifilter_by'] as $filby): ?>
                                    <?php if ($filby == $isifilby): ?>

                                        <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                    
                                    
                                    <?php else: ?>

                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php endif ?>
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
                            <button type="submit" name="filter_by" class="form-control btn-primary"> Filter </button>
                        </div>
                    </div>
                </div>

                <hr class="new1" />

            </div>
        </form>

        <?php require 'tabledatapagination.php'; ?>
        
    </div>
<!-- End Filter Buku -->

<!-- Filter Buku With Date -->
<?php elseif(isset($_POST['nextPageFilterBukuWithDate'])): ?>

    <?php 

        $tanggalDari   = str_replace([' 00:00:00'], "", $tanggalDari);
        $tanggalSampai = str_replace([' 23:59:59'], "", $tanggalSampai);

    ?>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
           
        </div>
        <form action="checkpembayaran" method="post">
            <div class="box-body">

                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>ID Siswa</label>
                            <input type="text" class="form-control" value="<?= $id; ?>" name="id_siswa" id="id_siswa" readonly="">
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" class="form-control" value="<?= $nis; ?>" name="nis_siswa" id="nis_siswa" readonly="">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" name="nama_siswa" class="form-control" value="<?= $namaSiswa; ?>" id="nama_siswa" readonly/>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="kelas_siswa" value="<?= $kelas; ?>" class="form-control" id="kelas_siswa" readonly/>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Panggilan</label>
                            <input type="text" class="form-control" id="panggilan_siswa" value="<?= $panggilan; ?>" name="panggilan_siswa" readonly/>
                        </div>
                    </div>
                    
                </div> 

                <div class="row">

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Filter By</label>
                            <select class="form-control" name="isi_filter">  
                                <option value="kosong"> -- PILIH -- </option>
                                <?php foreach ($filter_by['isifilter_by'] as $filby): ?>
                                    <?php if ($filby == $isifilby): ?>

                                        <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                    
                                    
                                    <?php else: ?>

                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php endif ?>
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
                            <button type="submit" name="filter_by" class="form-control btn-primary"> Filter </button>
                        </div>
                    </div>
                </div>

                <hr class="new1" />

            </div>
        </form>

        <?php require 'tabledatapagination.php'; ?>
        
    </div>

<?php elseif(isset($_POST['previousPageFilterBukuWithDate'])): ?>

    <?php 

        $tanggalDari   = str_replace([' 00:00:00'], "", $tanggalDari);
        $tanggalSampai = str_replace([' 23:59:59'], "", $tanggalSampai);

    ?>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
           
        </div>
        <form action="checkpembayaran" method="post">
            <div class="box-body">

                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>ID Siswa</label>
                            <input type="text" class="form-control" value="<?= $id; ?>" name="id_siswa" id="id_siswa" readonly="">
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" class="form-control" value="<?= $nis; ?>" name="nis_siswa" id="nis_siswa" readonly="">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" name="nama_siswa" class="form-control" value="<?= $namaSiswa; ?>" id="nama_siswa" readonly/>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="kelas_siswa" value="<?= $kelas; ?>" class="form-control" id="kelas_siswa" readonly/>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Panggilan</label>
                            <input type="text" class="form-control" id="panggilan_siswa" value="<?= $panggilan; ?>" name="panggilan_siswa" readonly/>
                        </div>
                    </div>
                    
                </div> 

                <div class="row">

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Filter By</label>
                            <select class="form-control" name="isi_filter">  
                                <option value="kosong"> -- PILIH -- </option>
                                <?php foreach ($filter_by['isifilter_by'] as $filby): ?>
                                    <?php if ($filby == $isifilby): ?>

                                        <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                    
                                    
                                    <?php else: ?>

                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php endif ?>
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
                            <button type="submit" name="filter_by" class="form-control btn-primary"> Filter </button>
                        </div>
                    </div>
                </div>

                <hr class="new1" />

            </div>
        </form>

        <?php require 'tabledatapagination.php'; ?>
        
    </div>

<?php elseif(isset($_POST['toPageFilterBukuWithDate'])): ?>

    <?php 

        $tanggalDari   = str_replace([' 00:00:00'], "", $tanggalDari);
        $tanggalSampai = str_replace([' 23:59:59'], "", $tanggalSampai);

    ?>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
           
        </div>
        <form action="checkpembayaran" method="post">
            <div class="box-body">

                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>ID Siswa</label>
                            <input type="text" class="form-control" value="<?= $id; ?>" name="id_siswa" id="id_siswa" readonly="">
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" class="form-control" value="<?= $nis; ?>" name="nis_siswa" id="nis_siswa" readonly="">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" name="nama_siswa" class="form-control" value="<?= $namaSiswa; ?>" id="nama_siswa" readonly/>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="kelas_siswa" value="<?= $kelas; ?>" class="form-control" id="kelas_siswa" readonly/>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Panggilan</label>
                            <input type="text" class="form-control" id="panggilan_siswa" value="<?= $panggilan; ?>" name="panggilan_siswa" readonly/>
                        </div>
                    </div>
                    
                </div> 

                <div class="row">

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Filter By</label>
                            <select class="form-control" name="isi_filter">  
                                <option value="kosong"> -- PILIH -- </option>
                                <?php foreach ($filter_by['isifilter_by'] as $filby): ?>
                                    <?php if ($filby == $isifilby): ?>

                                        <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                    
                                    
                                    <?php else: ?>

                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php endif ?>
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
                            <button type="submit" name="filter_by" class="form-control btn-primary"> Filter </button>
                        </div>
                    </div>
                </div>

                <hr class="new1" />

            </div>
        </form>

        <?php require 'tabledatapagination.php'; ?>
        
    </div>

<?php elseif(isset($_POST['firstPageFilterBukuWithDate'])): ?>

    <?php 

        $tanggalDari   = str_replace([' 00:00:00'], "", $tanggalDari);
        $tanggalSampai = str_replace([' 23:59:59'], "", $tanggalSampai);

    ?>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
           
        </div>
        <form action="checkpembayaran" method="post">
            <div class="box-body">

                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>ID Siswa</label>
                            <input type="text" class="form-control" value="<?= $id; ?>" name="id_siswa" id="id_siswa" readonly="">
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" class="form-control" value="<?= $nis; ?>" name="nis_siswa" id="nis_siswa" readonly="">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" name="nama_siswa" class="form-control" value="<?= $namaSiswa; ?>" id="nama_siswa" readonly/>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="kelas_siswa" value="<?= $kelas; ?>" class="form-control" id="kelas_siswa" readonly/>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Panggilan</label>
                            <input type="text" class="form-control" id="panggilan_siswa" value="<?= $panggilan; ?>" name="panggilan_siswa" readonly/>
                        </div>
                    </div>
                    
                </div> 

                <div class="row">

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Filter By</label>
                            <select class="form-control" name="isi_filter">  
                                <option value="kosong"> -- PILIH -- </option>
                                <?php foreach ($filter_by['isifilter_by'] as $filby): ?>
                                    <?php if ($filby == $isifilby): ?>

                                        <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                    
                                    
                                    <?php else: ?>

                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php endif ?>
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
                            <button type="submit" name="filter_by" class="form-control btn-primary"> Filter </button>
                        </div>
                    </div>
                </div>

                <hr class="new1" />

            </div>
        </form>

        <?php require 'tabledatapagination.php'; ?>
        
    </div>

<?php elseif(isset($_POST['lastPageFilterBukuWithDate'])): ?>

    <?php 

        $tanggalDari   = str_replace([' 00:00:00'], "", $tanggalDari);
        $tanggalSampai = str_replace([' 23:59:59'], "", $tanggalSampai);

    ?>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
           
        </div>
        <form action="checkpembayaran" method="post">
            <div class="box-body">

                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>ID Siswa</label>
                            <input type="text" class="form-control" value="<?= $id; ?>" name="id_siswa" id="id_siswa" readonly="">
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" class="form-control" value="<?= $nis; ?>" name="nis_siswa" id="nis_siswa" readonly="">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" name="nama_siswa" class="form-control" value="<?= $namaSiswa; ?>" id="nama_siswa" readonly/>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="kelas_siswa" value="<?= $kelas; ?>" class="form-control" id="kelas_siswa" readonly/>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Panggilan</label>
                            <input type="text" class="form-control" id="panggilan_siswa" value="<?= $panggilan; ?>" name="panggilan_siswa" readonly/>
                        </div>
                    </div>
                    
                </div> 

                <div class="row">

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Filter By</label>
                            <select class="form-control" name="isi_filter">  
                                <option value="kosong"> -- PILIH -- </option>
                                <?php foreach ($filter_by['isifilter_by'] as $filby): ?>
                                    <?php if ($filby == $isifilby): ?>

                                        <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                    
                                    
                                    <?php else: ?>

                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php endif ?>
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
                            <button type="submit" name="filter_by" class="form-control btn-primary"> Filter </button>
                        </div>
                    </div>
                </div>

                <hr class="new1" />

            </div>
        </form>

        <?php require 'tabledatapagination.php'; ?>
        
    </div>
<!-- End filter Buku With Date -->

<!-- Filter Seragam -->
<?php elseif(isset($_POST['nextPageFilterSeragam'])): ?>

    <?php 

        $tanggalDari   = str_replace([' 00:00:00'], "", $tanggalDari);
        $tanggalSampai = str_replace([' 23:59:59'], "", $tanggalSampai);

    ?>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
           
        </div>
        <form action="checkpembayaran" method="post">
            <div class="box-body">

                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>ID Siswa</label>
                            <input type="text" class="form-control" value="<?= $id; ?>" name="id_siswa" id="id_siswa" readonly="">
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" class="form-control" value="<?= $nis; ?>" name="nis_siswa" id="nis_siswa" readonly="">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" name="nama_siswa" class="form-control" value="<?= $namaSiswa; ?>" id="nama_siswa" readonly/>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="kelas_siswa" value="<?= $kelas; ?>" class="form-control" id="kelas_siswa" readonly/>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Panggilan</label>
                            <input type="text" class="form-control" id="panggilan_siswa" value="<?= $panggilan; ?>" name="panggilan_siswa" readonly/>
                        </div>
                    </div>
                    
                </div> 

                <div class="row">

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Filter By</label>
                            <select class="form-control" name="isi_filter">  
                                <option value="kosong"> -- PILIH -- </option>
                                <?php foreach ($filter_by['isifilter_by'] as $filby): ?>
                                    <?php if ($filby == $isifilby): ?>

                                        <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                    
                                    
                                    <?php else: ?>

                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php endif ?>
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
                            <button type="submit" name="filter_by" class="form-control btn-primary"> Filter </button>
                        </div>
                    </div>
                </div>

                <hr class="new1" />

            </div>
        </form>

        <?php require 'tabledatapagination.php'; ?>
        
    </div>

<?php elseif(isset($_POST['previousPageFilterSeragam'])): ?>

    <?php 

        $tanggalDari   = str_replace([' 00:00:00'], "", $tanggalDari);
        $tanggalSampai = str_replace([' 23:59:59'], "", $tanggalSampai);

    ?>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
           
        </div>
        <form action="checkpembayaran" method="post">
            <div class="box-body">

                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>ID Siswa</label>
                            <input type="text" class="form-control" value="<?= $id; ?>" name="id_siswa" id="id_siswa" readonly="">
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" class="form-control" value="<?= $nis; ?>" name="nis_siswa" id="nis_siswa" readonly="">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" name="nama_siswa" class="form-control" value="<?= $namaSiswa; ?>" id="nama_siswa" readonly/>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="kelas_siswa" value="<?= $kelas; ?>" class="form-control" id="kelas_siswa" readonly/>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Panggilan</label>
                            <input type="text" class="form-control" id="panggilan_siswa" value="<?= $panggilan; ?>" name="panggilan_siswa" readonly/>
                        </div>
                    </div>
                    
                </div> 

                <div class="row">

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Filter By</label>
                            <select class="form-control" name="isi_filter">  
                                <option value="kosong"> -- PILIH -- </option>
                                <?php foreach ($filter_by['isifilter_by'] as $filby): ?>
                                    <?php if ($filby == $isifilby): ?>

                                        <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                    
                                    
                                    <?php else: ?>

                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php endif ?>
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
                            <button type="submit" name="filter_by" class="form-control btn-primary"> Filter </button>
                        </div>
                    </div>
                </div>

                <hr class="new1" />

            </div>
        </form>

        <?php require 'tabledatapagination.php'; ?>
        
    </div>

<?php elseif(isset($_POST['toPageFilterSeragam'])): ?>

    <?php 

        $tanggalDari   = str_replace([' 00:00:00'], "", $tanggalDari);
        $tanggalSampai = str_replace([' 23:59:59'], "", $tanggalSampai);

    ?>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
           
        </div>
        <form action="checkpembayaran" method="post">
            <div class="box-body">

                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>ID Siswa</label>
                            <input type="text" class="form-control" value="<?= $id; ?>" name="id_siswa" id="id_siswa" readonly="">
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" class="form-control" value="<?= $nis; ?>" name="nis_siswa" id="nis_siswa" readonly="">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" name="nama_siswa" class="form-control" value="<?= $namaSiswa; ?>" id="nama_siswa" readonly/>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="kelas_siswa" value="<?= $kelas; ?>" class="form-control" id="kelas_siswa" readonly/>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Panggilan</label>
                            <input type="text" class="form-control" id="panggilan_siswa" value="<?= $panggilan; ?>" name="panggilan_siswa" readonly/>
                        </div>
                    </div>
                    
                </div> 

                <div class="row">

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Filter By</label>
                            <select class="form-control" name="isi_filter">  
                                <option value="kosong"> -- PILIH -- </option>
                                <?php foreach ($filter_by['isifilter_by'] as $filby): ?>
                                    <?php if ($filby == $isifilby): ?>

                                        <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                    
                                    
                                    <?php else: ?>

                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php endif ?>
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
                            <button type="submit" name="filter_by" class="form-control btn-primary"> Filter </button>
                        </div>
                    </div>
                </div>

                <hr class="new1" />

            </div>
        </form>

        <?php require 'tabledatapagination.php'; ?>
        
    </div>

<?php elseif(isset($_POST['firstPageFilterSeragam'])): ?>

    <?php 

        $tanggalDari   = str_replace([' 00:00:00'], "", $tanggalDari);
        $tanggalSampai = str_replace([' 23:59:59'], "", $tanggalSampai);

    ?>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
           
        </div>
        <form action="checkpembayaran" method="post">
            <div class="box-body">

                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>ID Siswa</label>
                            <input type="text" class="form-control" value="<?= $id; ?>" name="id_siswa" id="id_siswa" readonly="">
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" class="form-control" value="<?= $nis; ?>" name="nis_siswa" id="nis_siswa" readonly="">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" name="nama_siswa" class="form-control" value="<?= $namaSiswa; ?>" id="nama_siswa" readonly/>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="kelas_siswa" value="<?= $kelas; ?>" class="form-control" id="kelas_siswa" readonly/>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Panggilan</label>
                            <input type="text" class="form-control" id="panggilan_siswa" value="<?= $panggilan; ?>" name="panggilan_siswa" readonly/>
                        </div>
                    </div>
                    
                </div> 

                <div class="row">

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Filter By</label>
                            <select class="form-control" name="isi_filter">  
                                <option value="kosong"> -- PILIH -- </option>
                                <?php foreach ($filter_by['isifilter_by'] as $filby): ?>
                                    <?php if ($filby == $isifilby): ?>

                                        <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                    
                                    
                                    <?php else: ?>

                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php endif ?>
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
                            <button type="submit" name="filter_by" class="form-control btn-primary"> Filter </button>
                        </div>
                    </div>
                </div>

                <hr class="new1" />

            </div>
        </form>

        <?php require 'tabledatapagination.php'; ?>
        
    </div>

<?php elseif(isset($_POST['lastPageFilterSeragam'])): ?>

    <?php 

        $tanggalDari   = str_replace([' 00:00:00'], "", $tanggalDari);
        $tanggalSampai = str_replace([' 23:59:59'], "", $tanggalSampai);

    ?>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
           
        </div>
        <form action="checkpembayaran" method="post">
            <div class="box-body">

                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>ID Siswa</label>
                            <input type="text" class="form-control" value="<?= $id; ?>" name="id_siswa" id="id_siswa" readonly="">
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" class="form-control" value="<?= $nis; ?>" name="nis_siswa" id="nis_siswa" readonly="">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" name="nama_siswa" class="form-control" value="<?= $namaSiswa; ?>" id="nama_siswa" readonly/>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="kelas_siswa" value="<?= $kelas; ?>" class="form-control" id="kelas_siswa" readonly/>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Panggilan</label>
                            <input type="text" class="form-control" id="panggilan_siswa" value="<?= $panggilan; ?>" name="panggilan_siswa" readonly/>
                        </div>
                    </div>
                    
                </div> 

                <div class="row">

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Filter By</label>
                            <select class="form-control" name="isi_filter">  
                                <option value="kosong"> -- PILIH -- </option>
                                <?php foreach ($filter_by['isifilter_by'] as $filby): ?>
                                    <?php if ($filby == $isifilby): ?>

                                        <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                    
                                    
                                    <?php else: ?>

                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php endif ?>
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
                            <button type="submit" name="filter_by" class="form-control btn-primary"> Filter </button>
                        </div>
                    </div>
                </div>

                <hr class="new1" />

            </div>
        </form>

        <?php require 'tabledatapagination.php'; ?>
        
    </div>
<!-- End Filter Seragam -->

<!-- Filter Seragam With Date -->
<?php elseif(isset($_POST['nextPageFilterSeragamWithDate'])): ?>

    <?php 

        $tanggalDari   = str_replace([' 00:00:00'], "", $tanggalDari);
        $tanggalSampai = str_replace([' 23:59:59'], "", $tanggalSampai);

    ?>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
           
        </div>
        <form action="checkpembayaran" method="post">
            <div class="box-body">

                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>ID Siswa</label>
                            <input type="text" class="form-control" value="<?= $id; ?>" name="id_siswa" id="id_siswa" readonly="">
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" class="form-control" value="<?= $nis; ?>" name="nis_siswa" id="nis_siswa" readonly="">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" name="nama_siswa" class="form-control" value="<?= $namaSiswa; ?>" id="nama_siswa" readonly/>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="kelas_siswa" value="<?= $kelas; ?>" class="form-control" id="kelas_siswa" readonly/>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Panggilan</label>
                            <input type="text" class="form-control" id="panggilan_siswa" value="<?= $panggilan; ?>" name="panggilan_siswa" readonly/>
                        </div>
                    </div>
                    
                </div> 

                <div class="row">

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Filter By</label>
                            <select class="form-control" name="isi_filter">  
                                <option value="kosong"> -- PILIH -- </option>
                                <?php foreach ($filter_by['isifilter_by'] as $filby): ?>
                                    <?php if ($filby == $isifilby): ?>

                                        <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                    
                                    
                                    <?php else: ?>

                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php endif ?>
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
                            <button type="submit" name="filter_by" class="form-control btn-primary"> Filter </button>
                        </div>
                    </div>
                </div>

                <hr class="new1" />

            </div>
        </form>

        <?php require 'tabledatapagination.php'; ?>
        
    </div>

<?php elseif(isset($_POST['previousPageFilterSeragamWithDate'])): ?>

    <?php 

        $tanggalDari   = str_replace([' 00:00:00'], "", $tanggalDari);
        $tanggalSampai = str_replace([' 23:59:59'], "", $tanggalSampai);

    ?>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
           
        </div>
        <form action="checkpembayaran" method="post">
            <div class="box-body">

                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>ID Siswa</label>
                            <input type="text" class="form-control" value="<?= $id; ?>" name="id_siswa" id="id_siswa" readonly="">
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" class="form-control" value="<?= $nis; ?>" name="nis_siswa" id="nis_siswa" readonly="">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" name="nama_siswa" class="form-control" value="<?= $namaSiswa; ?>" id="nama_siswa" readonly/>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="kelas_siswa" value="<?= $kelas; ?>" class="form-control" id="kelas_siswa" readonly/>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Panggilan</label>
                            <input type="text" class="form-control" id="panggilan_siswa" value="<?= $panggilan; ?>" name="panggilan_siswa" readonly/>
                        </div>
                    </div>
                    
                </div> 

                <div class="row">

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Filter By</label>
                            <select class="form-control" name="isi_filter">  
                                <option value="kosong"> -- PILIH -- </option>
                                <?php foreach ($filter_by['isifilter_by'] as $filby): ?>
                                    <?php if ($filby == $isifilby): ?>

                                        <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                    
                                    
                                    <?php else: ?>

                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php endif ?>
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
                            <button type="submit" name="filter_by" class="form-control btn-primary"> Filter </button>
                        </div>
                    </div>
                </div>

                <hr class="new1" />

            </div>
        </form>

        <?php require 'tabledatapagination.php'; ?>
        
    </div>

<?php elseif(isset($_POST['toPageFilterSeragamWithDate'])): ?>

    <?php 

        $tanggalDari   = str_replace([' 00:00:00'], "", $tanggalDari);
        $tanggalSampai = str_replace([' 23:59:59'], "", $tanggalSampai);

    ?>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
           
        </div>
        <form action="checkpembayaran" method="post">
            <div class="box-body">

                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>ID Siswa</label>
                            <input type="text" class="form-control" value="<?= $id; ?>" name="id_siswa" id="id_siswa" readonly="">
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" class="form-control" value="<?= $nis; ?>" name="nis_siswa" id="nis_siswa" readonly="">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" name="nama_siswa" class="form-control" value="<?= $namaSiswa; ?>" id="nama_siswa" readonly/>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="kelas_siswa" value="<?= $kelas; ?>" class="form-control" id="kelas_siswa" readonly/>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Panggilan</label>
                            <input type="text" class="form-control" id="panggilan_siswa" value="<?= $panggilan; ?>" name="panggilan_siswa" readonly/>
                        </div>
                    </div>
                    
                </div> 

                <div class="row">

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Filter By</label>
                            <select class="form-control" name="isi_filter">  
                                <option value="kosong"> -- PILIH -- </option>
                                <?php foreach ($filter_by['isifilter_by'] as $filby): ?>
                                    <?php if ($filby == $isifilby): ?>

                                        <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                    
                                    
                                    <?php else: ?>

                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php endif ?>
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
                            <button type="submit" name="filter_by" class="form-control btn-primary"> Filter </button>
                        </div>
                    </div>
                </div>

                <hr class="new1" />

            </div>
        </form>

        <?php require 'tabledatapagination.php'; ?>
        
    </div>

<?php elseif(isset($_POST['firstPageFilterSeragamWithDate'])): ?>

    <?php 

        $tanggalDari   = str_replace([' 00:00:00'], "", $tanggalDari);
        $tanggalSampai = str_replace([' 23:59:59'], "", $tanggalSampai);

    ?>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
           
        </div>
        <form action="checkpembayaran" method="post">
            <div class="box-body">

                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>ID Siswa</label>
                            <input type="text" class="form-control" value="<?= $id; ?>" name="id_siswa" id="id_siswa" readonly="">
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" class="form-control" value="<?= $nis; ?>" name="nis_siswa" id="nis_siswa" readonly="">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" name="nama_siswa" class="form-control" value="<?= $namaSiswa; ?>" id="nama_siswa" readonly/>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="kelas_siswa" value="<?= $kelas; ?>" class="form-control" id="kelas_siswa" readonly/>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Panggilan</label>
                            <input type="text" class="form-control" id="panggilan_siswa" value="<?= $panggilan; ?>" name="panggilan_siswa" readonly/>
                        </div>
                    </div>
                    
                </div> 

                <div class="row">

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Filter By</label>
                            <select class="form-control" name="isi_filter">  
                                <option value="kosong"> -- PILIH -- </option>
                                <?php foreach ($filter_by['isifilter_by'] as $filby): ?>
                                    <?php if ($filby == $isifilby): ?>

                                        <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                    
                                    
                                    <?php else: ?>

                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php endif ?>
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
                            <button type="submit" name="filter_by" class="form-control btn-primary"> Filter </button>
                        </div>
                    </div>
                </div>

                <hr class="new1" />

            </div>
        </form>

        <?php require 'tabledatapagination.php'; ?>
        
    </div>

<?php elseif(isset($_POST['lastPageFilterSeragamWithDate'])): ?>

    <?php 

        $tanggalDari   = str_replace([' 00:00:00'], "", $tanggalDari);
        $tanggalSampai = str_replace([' 23:59:59'], "", $tanggalSampai);

    ?>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
           
        </div>
        <form action="checkpembayaran" method="post">
            <div class="box-body">

                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>ID Siswa</label>
                            <input type="text" class="form-control" value="<?= $id; ?>" name="id_siswa" id="id_siswa" readonly="">
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" class="form-control" value="<?= $nis; ?>" name="nis_siswa" id="nis_siswa" readonly="">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" name="nama_siswa" class="form-control" value="<?= $namaSiswa; ?>" id="nama_siswa" readonly/>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="kelas_siswa" value="<?= $kelas; ?>" class="form-control" id="kelas_siswa" readonly/>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Panggilan</label>
                            <input type="text" class="form-control" id="panggilan_siswa" value="<?= $panggilan; ?>" name="panggilan_siswa" readonly/>
                        </div>
                    </div>
                    
                </div> 

                <div class="row">

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Filter By</label>
                            <select class="form-control" name="isi_filter">  
                                <option value="kosong"> -- PILIH -- </option>
                                <?php foreach ($filter_by['isifilter_by'] as $filby): ?>
                                    <?php if ($filby == $isifilby): ?>

                                        <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                    
                                    
                                    <?php else: ?>

                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php endif ?>
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
                            <button type="submit" name="filter_by" class="form-control btn-primary"> Filter </button>
                        </div>
                    </div>
                </div>

                <hr class="new1" />

            </div>
        </form>

        <?php require 'tabledatapagination.php'; ?>
        
    </div>
<!-- End Filter Seragam With Date -->

<!-- Filter Registrasi -->
<?php elseif(isset($_POST['nextPageFilterRegistrasi'])): ?>

    <?php 

        $tanggalDari   = str_replace([' 00:00:00'], "", $tanggalDari);
        $tanggalSampai = str_replace([' 23:59:59'], "", $tanggalSampai);

    ?>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
           
        </div>
        <form action="checkpembayaran" method="post">
            <div class="box-body">

                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>ID Siswa</label>
                            <input type="text" class="form-control" value="<?= $id; ?>" name="id_siswa" id="id_siswa" readonly="">
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" class="form-control" value="<?= $nis; ?>" name="nis_siswa" id="nis_siswa" readonly="">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" name="nama_siswa" class="form-control" value="<?= $namaSiswa; ?>" id="nama_siswa" readonly/>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="kelas_siswa" value="<?= $kelas; ?>" class="form-control" id="kelas_siswa" readonly/>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Panggilan</label>
                            <input type="text" class="form-control" id="panggilan_siswa" value="<?= $panggilan; ?>" name="panggilan_siswa" readonly/>
                        </div>
                    </div>
                    
                </div> 

                <div class="row">

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Filter By</label>
                            <select class="form-control" name="isi_filter">  
                                <option value="kosong"> -- PILIH -- </option>
                                <?php foreach ($filter_by['isifilter_by'] as $filby): ?>
                                    <?php if ($filby == $isifilby): ?>

                                        <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                    
                                    
                                    <?php else: ?>

                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php endif ?>
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
                            <button type="submit" name="filter_by" class="form-control btn-primary"> Filter </button>
                        </div>
                    </div>
                </div>

                <hr class="new1" />

            </div>
        </form>

        <?php require 'tabledatapagination.php'; ?>
        
    </div>

<?php elseif(isset($_POST['previousPageFilterRegistrasi'])): ?>

    <?php 

        $tanggalDari   = str_replace([' 00:00:00'], "", $tanggalDari);
        $tanggalSampai = str_replace([' 23:59:59'], "", $tanggalSampai);

    ?>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
           
        </div>
        <form action="checkpembayaran" method="post">
            <div class="box-body">

                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>ID Siswa</label>
                            <input type="text" class="form-control" value="<?= $id; ?>" name="id_siswa" id="id_siswa" readonly="">
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" class="form-control" value="<?= $nis; ?>" name="nis_siswa" id="nis_siswa" readonly="">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" name="nama_siswa" class="form-control" value="<?= $namaSiswa; ?>" id="nama_siswa" readonly/>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="kelas_siswa" value="<?= $kelas; ?>" class="form-control" id="kelas_siswa" readonly/>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Panggilan</label>
                            <input type="text" class="form-control" id="panggilan_siswa" value="<?= $panggilan; ?>" name="panggilan_siswa" readonly/>
                        </div>
                    </div>
                    
                </div> 

                <div class="row">

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Filter By</label>
                            <select class="form-control" name="isi_filter">  
                                <option value="kosong"> -- PILIH -- </option>
                                <?php foreach ($filter_by['isifilter_by'] as $filby): ?>
                                    <?php if ($filby == $isifilby): ?>

                                        <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                    
                                    
                                    <?php else: ?>

                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php endif ?>
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
                            <button type="submit" name="filter_by" class="form-control btn-primary"> Filter </button>
                        </div>
                    </div>
                </div>

                <hr class="new1" />

            </div>
        </form>

        <?php require 'tabledatapagination.php'; ?>
        
    </div>

<?php elseif(isset($_POST['toPageFilterRegistrasi'])): ?>

    <?php 

        $tanggalDari   = str_replace([' 00:00:00'], "", $tanggalDari);
        $tanggalSampai = str_replace([' 23:59:59'], "", $tanggalSampai);

    ?>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
           
        </div>
        <form action="checkpembayaran" method="post">
            <div class="box-body">

                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>ID Siswa</label>
                            <input type="text" class="form-control" value="<?= $id; ?>" name="id_siswa" id="id_siswa" readonly="">
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" class="form-control" value="<?= $nis; ?>" name="nis_siswa" id="nis_siswa" readonly="">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" name="nama_siswa" class="form-control" value="<?= $namaSiswa; ?>" id="nama_siswa" readonly/>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="kelas_siswa" value="<?= $kelas; ?>" class="form-control" id="kelas_siswa" readonly/>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Panggilan</label>
                            <input type="text" class="form-control" id="panggilan_siswa" value="<?= $panggilan; ?>" name="panggilan_siswa" readonly/>
                        </div>
                    </div>
                    
                </div> 

                <div class="row">

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Filter By</label>
                            <select class="form-control" name="isi_filter">  
                                <option value="kosong"> -- PILIH -- </option>
                                <?php foreach ($filter_by['isifilter_by'] as $filby): ?>
                                    <?php if ($filby == $isifilby): ?>

                                        <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                    
                                    
                                    <?php else: ?>

                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php endif ?>
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
                            <button type="submit" name="filter_by" class="form-control btn-primary"> Filter </button>
                        </div>
                    </div>
                </div>

                <hr class="new1" />

            </div>
        </form>

        <?php require 'tabledatapagination.php'; ?>
        
    </div>

<?php elseif(isset($_POST['firstPageFilterRegistrasi'])): ?>

    <?php 

        $tanggalDari   = str_replace([' 00:00:00'], "", $tanggalDari);
        $tanggalSampai = str_replace([' 23:59:59'], "", $tanggalSampai);

    ?>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
           
        </div>
        <form action="checkpembayaran" method="post">
            <div class="box-body">

                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>ID Siswa</label>
                            <input type="text" class="form-control" value="<?= $id; ?>" name="id_siswa" id="id_siswa" readonly="">
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" class="form-control" value="<?= $nis; ?>" name="nis_siswa" id="nis_siswa" readonly="">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" name="nama_siswa" class="form-control" value="<?= $namaSiswa; ?>" id="nama_siswa" readonly/>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="kelas_siswa" value="<?= $kelas; ?>" class="form-control" id="kelas_siswa" readonly/>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Panggilan</label>
                            <input type="text" class="form-control" id="panggilan_siswa" value="<?= $panggilan; ?>" name="panggilan_siswa" readonly/>
                        </div>
                    </div>
                    
                </div> 

                <div class="row">

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Filter By</label>
                            <select class="form-control" name="isi_filter">  
                                <option value="kosong"> -- PILIH -- </option>
                                <?php foreach ($filter_by['isifilter_by'] as $filby): ?>
                                    <?php if ($filby == $isifilby): ?>

                                        <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                    
                                    
                                    <?php else: ?>

                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php endif ?>
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
                            <button type="submit" name="filter_by" class="form-control btn-primary"> Filter </button>
                        </div>
                    </div>
                </div>

                <hr class="new1" />

            </div>
        </form>

        <?php require 'tabledatapagination.php'; ?>
        
    </div>

<?php elseif(isset($_POST['lastPageFilterRegistrasi'])): ?>

    <?php 

        $tanggalDari   = str_replace([' 00:00:00'], "", $tanggalDari);
        $tanggalSampai = str_replace([' 23:59:59'], "", $tanggalSampai);

    ?>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
           
        </div>
        <form action="checkpembayaran" method="post">
            <div class="box-body">

                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>ID Siswa</label>
                            <input type="text" class="form-control" value="<?= $id; ?>" name="id_siswa" id="id_siswa" readonly="">
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" class="form-control" value="<?= $nis; ?>" name="nis_siswa" id="nis_siswa" readonly="">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" name="nama_siswa" class="form-control" value="<?= $namaSiswa; ?>" id="nama_siswa" readonly/>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="kelas_siswa" value="<?= $kelas; ?>" class="form-control" id="kelas_siswa" readonly/>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Panggilan</label>
                            <input type="text" class="form-control" id="panggilan_siswa" value="<?= $panggilan; ?>" name="panggilan_siswa" readonly/>
                        </div>
                    </div>
                    
                </div> 

                <div class="row">

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Filter By</label>
                            <select class="form-control" name="isi_filter">  
                                <option value="kosong"> -- PILIH -- </option>
                                <?php foreach ($filter_by['isifilter_by'] as $filby): ?>
                                    <?php if ($filby == $isifilby): ?>

                                        <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                    
                                    
                                    <?php else: ?>

                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php endif ?>
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
                            <button type="submit" name="filter_by" class="form-control btn-primary"> Filter </button>
                        </div>
                    </div>
                </div>

                <hr class="new1" />

            </div>
        </form>

        <?php require 'tabledatapagination.php'; ?>
        
    </div>
<!-- End Filter Registrasi -->

<!-- Filter Registrasi With Date -->
<?php elseif(isset($_POST['nextPageFilterRegistrasiWithDate'])): ?>

    <?php 

        $tanggalDari   = str_replace([' 00:00:00'], "", $tanggalDari);
        $tanggalSampai = str_replace([' 23:59:59'], "", $tanggalSampai);

    ?>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
           
        </div>
        <form action="checkpembayaran" method="post">
            <div class="box-body">

                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>ID Siswa</label>
                            <input type="text" class="form-control" value="<?= $id; ?>" name="id_siswa" id="id_siswa" readonly="">
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" class="form-control" value="<?= $nis; ?>" name="nis_siswa" id="nis_siswa" readonly="">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" name="nama_siswa" class="form-control" value="<?= $namaSiswa; ?>" id="nama_siswa" readonly/>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="kelas_siswa" value="<?= $kelas; ?>" class="form-control" id="kelas_siswa" readonly/>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Panggilan</label>
                            <input type="text" class="form-control" id="panggilan_siswa" value="<?= $panggilan; ?>" name="panggilan_siswa" readonly/>
                        </div>
                    </div>
                    
                </div> 

                <div class="row">

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Filter By</label>
                            <select class="form-control" name="isi_filter">  
                                <option value="kosong"> -- PILIH -- </option>
                                <?php foreach ($filter_by['isifilter_by'] as $filby): ?>
                                    <?php if ($filby == $isifilby): ?>

                                        <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                    
                                    
                                    <?php else: ?>

                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php endif ?>
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
                            <button type="submit" name="filter_by" class="form-control btn-primary"> Filter </button>
                        </div>
                    </div>
                </div>

                <hr class="new1" />

            </div>
        </form>

        <?php require 'tabledatapagination.php'; ?>
        
    </div>

<?php elseif(isset($_POST['previousPageFilterRegistrasiWithDate'])): ?>

    <?php 

        $tanggalDari   = str_replace([' 00:00:00'], "", $tanggalDari);
        $tanggalSampai = str_replace([' 23:59:59'], "", $tanggalSampai);

    ?>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
           
        </div>
        <form action="checkpembayaran" method="post">
            <div class="box-body">

                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>ID Siswa</label>
                            <input type="text" class="form-control" value="<?= $id; ?>" name="id_siswa" id="id_siswa" readonly="">
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" class="form-control" value="<?= $nis; ?>" name="nis_siswa" id="nis_siswa" readonly="">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" name="nama_siswa" class="form-control" value="<?= $namaSiswa; ?>" id="nama_siswa" readonly/>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="kelas_siswa" value="<?= $kelas; ?>" class="form-control" id="kelas_siswa" readonly/>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Panggilan</label>
                            <input type="text" class="form-control" id="panggilan_siswa" value="<?= $panggilan; ?>" name="panggilan_siswa" readonly/>
                        </div>
                    </div>
                    
                </div> 

                <div class="row">

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Filter By</label>
                            <select class="form-control" name="isi_filter">  
                                <option value="kosong"> -- PILIH -- </option>
                                <?php foreach ($filter_by['isifilter_by'] as $filby): ?>
                                    <?php if ($filby == $isifilby): ?>

                                        <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                    
                                    
                                    <?php else: ?>

                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php endif ?>
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
                            <button type="submit" name="filter_by" class="form-control btn-primary"> Filter </button>
                        </div>
                    </div>
                </div>

                <hr class="new1" />

            </div>
        </form>

        <?php require 'tabledatapagination.php'; ?>
        
    </div>

<?php elseif(isset($_POST['toPageFilterRegistrasiWithDate'])): ?>

    <?php 

        $tanggalDari   = str_replace([' 00:00:00'], "", $tanggalDari);
        $tanggalSampai = str_replace([' 23:59:59'], "", $tanggalSampai);

    ?>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
           
        </div>
        <form action="checkpembayaran" method="post">
            <div class="box-body">

                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>ID Siswa</label>
                            <input type="text" class="form-control" value="<?= $id; ?>" name="id_siswa" id="id_siswa" readonly="">
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" class="form-control" value="<?= $nis; ?>" name="nis_siswa" id="nis_siswa" readonly="">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" name="nama_siswa" class="form-control" value="<?= $namaSiswa; ?>" id="nama_siswa" readonly/>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="kelas_siswa" value="<?= $kelas; ?>" class="form-control" id="kelas_siswa" readonly/>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Panggilan</label>
                            <input type="text" class="form-control" id="panggilan_siswa" value="<?= $panggilan; ?>" name="panggilan_siswa" readonly/>
                        </div>
                    </div>
                    
                </div> 

                <div class="row">

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Filter By</label>
                            <select class="form-control" name="isi_filter">  
                                <option value="kosong"> -- PILIH -- </option>
                                <?php foreach ($filter_by['isifilter_by'] as $filby): ?>
                                    <?php if ($filby == $isifilby): ?>

                                        <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                    
                                    
                                    <?php else: ?>

                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php endif ?>
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
                            <button type="submit" name="filter_by" class="form-control btn-primary"> Filter </button>
                        </div>
                    </div>
                </div>

                <hr class="new1" />

            </div>
        </form>

        <?php require 'tabledatapagination.php'; ?>
        
    </div>

<?php elseif(isset($_POST['firstPageFilterRegistrasiWithDate'])): ?>

    <?php 

        $tanggalDari   = str_replace([' 00:00:00'], "", $tanggalDari);
        $tanggalSampai = str_replace([' 23:59:59'], "", $tanggalSampai);

    ?>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
           
        </div>
        <form action="checkpembayaran" method="post">
            <div class="box-body">

                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>ID Siswa</label>
                            <input type="text" class="form-control" value="<?= $id; ?>" name="id_siswa" id="id_siswa" readonly="">
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" class="form-control" value="<?= $nis; ?>" name="nis_siswa" id="nis_siswa" readonly="">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" name="nama_siswa" class="form-control" value="<?= $namaSiswa; ?>" id="nama_siswa" readonly/>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="kelas_siswa" value="<?= $kelas; ?>" class="form-control" id="kelas_siswa" readonly/>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Panggilan</label>
                            <input type="text" class="form-control" id="panggilan_siswa" value="<?= $panggilan; ?>" name="panggilan_siswa" readonly/>
                        </div>
                    </div>
                    
                </div> 

                <div class="row">

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Filter By</label>
                            <select class="form-control" name="isi_filter">  
                                <option value="kosong"> -- PILIH -- </option>
                                <?php foreach ($filter_by['isifilter_by'] as $filby): ?>
                                    <?php if ($filby == $isifilby): ?>

                                        <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                    
                                    
                                    <?php else: ?>

                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php endif ?>
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
                            <button type="submit" name="filter_by" class="form-control btn-primary"> Filter </button>
                        </div>
                    </div>
                </div>

                <hr class="new1" />

            </div>
        </form>

        <?php require 'tabledatapagination.php'; ?>
        
    </div>

<?php elseif(isset($_POST['lastPageFilterRegistrasiWithDate'])): ?>

    <?php 

        $tanggalDari   = str_replace([' 00:00:00'], "", $tanggalDari);
        $tanggalSampai = str_replace([' 23:59:59'], "", $tanggalSampai);

    ?>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
           
        </div>
        <form action="checkpembayaran" method="post">
            <div class="box-body">

                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>ID Siswa</label>
                            <input type="text" class="form-control" value="<?= $id; ?>" name="id_siswa" id="id_siswa" readonly="">
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" class="form-control" value="<?= $nis; ?>" name="nis_siswa" id="nis_siswa" readonly="">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" name="nama_siswa" class="form-control" value="<?= $namaSiswa; ?>" id="nama_siswa" readonly/>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="kelas_siswa" value="<?= $kelas; ?>" class="form-control" id="kelas_siswa" readonly/>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Panggilan</label>
                            <input type="text" class="form-control" id="panggilan_siswa" value="<?= $panggilan; ?>" name="panggilan_siswa" readonly/>
                        </div>
                    </div>
                    
                </div> 

                <div class="row">

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Filter By</label>
                            <select class="form-control" name="isi_filter">  
                                <option value="kosong"> -- PILIH -- </option>
                                <?php foreach ($filter_by['isifilter_by'] as $filby): ?>
                                    <?php if ($filby == $isifilby): ?>

                                        <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                    
                                    
                                    <?php else: ?>

                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php endif ?>
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
                            <button type="submit" name="filter_by" class="form-control btn-primary"> Filter </button>
                        </div>
                    </div>
                </div>

                <hr class="new1" />

            </div>
        </form>

        <?php require 'tabledatapagination.php'; ?>
        
    </div>
<!-- End Filter Registrasi With Date  -->

<!-- Filter Lain -->
<?php elseif(isset($_POST['nextPageFilterLain'])): ?>

    <?php 

        $tanggalDari   = str_replace([' 00:00:00'], "", $tanggalDari);
        $tanggalSampai = str_replace([' 23:59:59'], "", $tanggalSampai);

    ?>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
           
        </div>
        <form action="checkpembayaran" method="post">
            <div class="box-body">

                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>ID Siswa</label>
                            <input type="text" class="form-control" value="<?= $id; ?>" name="id_siswa" id="id_siswa" readonly="">
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" class="form-control" value="<?= $nis; ?>" name="nis_siswa" id="nis_siswa" readonly="">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" name="nama_siswa" class="form-control" value="<?= $namaSiswa; ?>" id="nama_siswa" readonly/>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="kelas_siswa" value="<?= $kelas; ?>" class="form-control" id="kelas_siswa" readonly/>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Panggilan</label>
                            <input type="text" class="form-control" id="panggilan_siswa" value="<?= $panggilan; ?>" name="panggilan_siswa" readonly/>
                        </div>
                    </div>
                    
                </div> 

                <div class="row">

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Filter By</label>
                            <select class="form-control" name="isi_filter">  
                                <option value="kosong"> -- PILIH -- </option>
                                <?php foreach ($filter_by['isifilter_by'] as $filby): ?>
                                    <?php if ($filby == $isifilby): ?>
                                    
                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php else: ?>

                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php endif ?>
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
                            <button type="submit" name="filter_by" class="form-control btn-primary"> Filter </button>
                        </div>
                    </div>
                </div>

                <hr class="new1" />

            </div>
        </form>

        <?php require 'tabledatapagination.php'; ?>
        
    </div>

<?php elseif(isset($_POST['previousPageFilterLain'])): ?>

    <?php 

        $tanggalDari   = str_replace([' 00:00:00'], "", $tanggalDari);
        $tanggalSampai = str_replace([' 23:59:59'], "", $tanggalSampai);

    ?>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
           
        </div>
        <form action="checkpembayaran" method="post">
            <div class="box-body">

                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>ID Siswa</label>
                            <input type="text" class="form-control" value="<?= $id; ?>" name="id_siswa" id="id_siswa" readonly="">
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" class="form-control" value="<?= $nis; ?>" name="nis_siswa" id="nis_siswa" readonly="">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" name="nama_siswa" class="form-control" value="<?= $namaSiswa; ?>" id="nama_siswa" readonly/>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="kelas_siswa" value="<?= $kelas; ?>" class="form-control" id="kelas_siswa" readonly/>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Panggilan</label>
                            <input type="text" class="form-control" id="panggilan_siswa" value="<?= $panggilan; ?>" name="panggilan_siswa" readonly/>
                        </div>
                    </div>
                    
                </div> 

                <div class="row">

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Filter By</label>
                            <select class="form-control" name="isi_filter">  
                                <option value="kosong"> -- PILIH -- </option>
                                <?php foreach ($filter_by['isifilter_by'] as $filby): ?>
                                    <?php if ($filby == $isifilby): ?>
                                        
                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php else: ?>

                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php endif ?>
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
                            <button type="submit" name="filter_by" class="form-control btn-primary"> Filter </button>
                        </div>
                    </div>
                </div>

                <hr class="new1" />

            </div>
        </form>

        <?php require 'tabledatapagination.php'; ?>
        
    </div>

<?php elseif(isset($_POST['toPageFilterLain'])): ?>

    <?php 

        $tanggalDari   = str_replace([' 00:00:00'], "", $tanggalDari);
        $tanggalSampai = str_replace([' 23:59:59'], "", $tanggalSampai);

    ?>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
           
        </div>
        <form action="checkpembayaran" method="post">
            <div class="box-body">

                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>ID Siswa</label>
                            <input type="text" class="form-control" value="<?= $id; ?>" name="id_siswa" id="id_siswa" readonly="">
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" class="form-control" value="<?= $nis; ?>" name="nis_siswa" id="nis_siswa" readonly="">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" name="nama_siswa" class="form-control" value="<?= $namaSiswa; ?>" id="nama_siswa" readonly/>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="kelas_siswa" value="<?= $kelas; ?>" class="form-control" id="kelas_siswa" readonly/>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Panggilan</label>
                            <input type="text" class="form-control" id="panggilan_siswa" value="<?= $panggilan; ?>" name="panggilan_siswa" readonly/>
                        </div>
                    </div>
                    
                </div> 

                <div class="row">

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Filter By</label>
                            <select class="form-control" name="isi_filter">  
                                <option value="kosong"> -- PILIH -- </option>
                                <?php foreach ($filter_by['isifilter_by'] as $filby): ?>
                                    <?php if ($filby == $isifilby): ?>
                                        
                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php else: ?>

                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php endif ?>
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
                            <button type="submit" name="filter_by" class="form-control btn-primary"> Filter </button>
                        </div>
                    </div>
                </div>

                <hr class="new1" />

            </div>
        </form>

        <?php require 'tabledatapagination.php'; ?>
        
    </div>

<?php elseif(isset($_POST['firstPageFilterLain'])): ?>

    <?php 

        $tanggalDari   = str_replace([' 00:00:00'], "", $tanggalDari);
        $tanggalSampai = str_replace([' 23:59:59'], "", $tanggalSampai);

    ?>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
           
        </div>
        <form action="checkpembayaran" method="post">
            <div class="box-body">

                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>ID Siswa</label>
                            <input type="text" class="form-control" value="<?= $id; ?>" name="id_siswa" id="id_siswa" readonly="">
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" class="form-control" value="<?= $nis; ?>" name="nis_siswa" id="nis_siswa" readonly="">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" name="nama_siswa" class="form-control" value="<?= $namaSiswa; ?>" id="nama_siswa" readonly/>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="kelas_siswa" value="<?= $kelas; ?>" class="form-control" id="kelas_siswa" readonly/>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Panggilan</label>
                            <input type="text" class="form-control" id="panggilan_siswa" value="<?= $panggilan; ?>" name="panggilan_siswa" readonly/>
                        </div>
                    </div>
                    
                </div> 

                <div class="row">

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Filter By</label>
                            <select class="form-control" name="isi_filter">  
                                <option value="kosong"> -- PILIH -- </option>
                                <?php foreach ($filter_by['isifilter_by'] as $filby): ?>
                                    <?php if ($filby == $isifilby): ?>
                                        
                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php else: ?>

                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php endif ?>
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
                            <button type="submit" name="filter_by" class="form-control btn-primary"> Filter </button>
                        </div>
                    </div>
                </div>

                <hr class="new1" />

            </div>
        </form>

        <?php require 'tabledatapagination.php'; ?>
        
    </div>

<?php elseif(isset($_POST['lastPageFilterLain'])): ?>

    <?php 

        $tanggalDari   = str_replace([' 00:00:00'], "", $tanggalDari);
        $tanggalSampai = str_replace([' 23:59:59'], "", $tanggalSampai);

    ?>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
           
        </div>
        <form action="checkpembayaran" method="post">
            <div class="box-body">

                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>ID Siswa</label>
                            <input type="text" class="form-control" value="<?= $id; ?>" name="id_siswa" id="id_siswa" readonly="">
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" class="form-control" value="<?= $nis; ?>" name="nis_siswa" id="nis_siswa" readonly="">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" name="nama_siswa" class="form-control" value="<?= $namaSiswa; ?>" id="nama_siswa" readonly/>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="kelas_siswa" value="<?= $kelas; ?>" class="form-control" id="kelas_siswa" readonly/>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Panggilan</label>
                            <input type="text" class="form-control" id="panggilan_siswa" value="<?= $panggilan; ?>" name="panggilan_siswa" readonly/>
                        </div>
                    </div>
                    
                </div> 

                <div class="row">

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Filter By</label>
                            <select class="form-control" name="isi_filter">  
                                <option value="kosong"> -- PILIH -- </option>
                                <?php foreach ($filter_by['isifilter_by'] as $filby): ?>
                                    <?php if ($filby == $isifilby): ?>
                                        
                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php else: ?>

                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php endif ?>
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
                            <button type="submit" name="filter_by" class="form-control btn-primary"> Filter </button>
                        </div>
                    </div>
                </div>

                <hr class="new1" />

            </div>
        </form>

        <?php require 'tabledatapagination.php'; ?>
        
    </div>
<!-- End Filter Lain -->

<!-- Filter Lain With Date -->
<?php elseif(isset($_POST['nextPageFilterLainWithDate'])): ?>

    <?php 

        $tanggalDari   = str_replace([' 00:00:00'], "", $tanggalDari);
        $tanggalSampai = str_replace([' 23:59:59'], "", $tanggalSampai);

    ?>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
           
        </div>
        <form action="checkpembayaran" method="post">
            <div class="box-body">

                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>ID Siswa</label>
                            <input type="text" class="form-control" value="<?= $id; ?>" name="id_siswa" id="id_siswa" readonly="">
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" class="form-control" value="<?= $nis; ?>" name="nis_siswa" id="nis_siswa" readonly="">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" name="nama_siswa" class="form-control" value="<?= $namaSiswa; ?>" id="nama_siswa" readonly/>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="kelas_siswa" value="<?= $kelas; ?>" class="form-control" id="kelas_siswa" readonly/>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Panggilan</label>
                            <input type="text" class="form-control" id="panggilan_siswa" value="<?= $panggilan; ?>" name="panggilan_siswa" readonly/>
                        </div>
                    </div>
                    
                </div> 

                <div class="row">

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Filter By</label>
                            <select class="form-control" name="isi_filter">  
                                <option value="kosong"> -- PILIH -- </option>
                                <?php foreach ($filter_by['isifilter_by'] as $filby): ?>
                                    <?php if ($filby == $isifilby): ?>
                                        
                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php else: ?>

                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php endif ?>
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
                            <button type="submit" name="filter_by" class="form-control btn-primary"> Filter </button>
                        </div>
                    </div>
                </div>

                <hr class="new1" />

            </div>
        </form>

        <?php require 'tabledatapagination.php'; ?>
        
    </div>

<?php elseif(isset($_POST['previousPageFilterLainWithDate'])): ?>

    <?php 

        $tanggalDari   = str_replace([' 00:00:00'], "", $tanggalDari);
        $tanggalSampai = str_replace([' 23:59:59'], "", $tanggalSampai);

    ?>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
           
        </div>
        <form action="checkpembayaran" method="post">
            <div class="box-body">

                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>ID Siswa</label>
                            <input type="text" class="form-control" value="<?= $id; ?>" name="id_siswa" id="id_siswa" readonly="">
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" class="form-control" value="<?= $nis; ?>" name="nis_siswa" id="nis_siswa" readonly="">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" name="nama_siswa" class="form-control" value="<?= $namaSiswa; ?>" id="nama_siswa" readonly/>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="kelas_siswa" value="<?= $kelas; ?>" class="form-control" id="kelas_siswa" readonly/>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Panggilan</label>
                            <input type="text" class="form-control" id="panggilan_siswa" value="<?= $panggilan; ?>" name="panggilan_siswa" readonly/>
                        </div>
                    </div>
                    
                </div> 

                <div class="row">

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Filter By</label>
                            <select class="form-control" name="isi_filter">  
                                <option value="kosong"> -- PILIH -- </option>
                                <?php foreach ($filter_by['isifilter_by'] as $filby): ?>
                                    <?php if ($filby == $isifilby): ?>
                                        
                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php else: ?>

                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php endif ?>
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
                            <button type="submit" name="filter_by" class="form-control btn-primary"> Filter </button>
                        </div>
                    </div>
                </div>

                <hr class="new1" />

            </div>
        </form>

        <?php require 'tabledatapagination.php'; ?>
        
    </div>

<?php elseif(isset($_POST['toPageFilterLainWithDate'])): ?>

    <?php 

        $tanggalDari   = str_replace([' 00:00:00'], "", $tanggalDari);
        $tanggalSampai = str_replace([' 23:59:59'], "", $tanggalSampai);

    ?>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
           
        </div>
        <form action="checkpembayaran" method="post">
            <div class="box-body">

                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>ID Siswa</label>
                            <input type="text" class="form-control" value="<?= $id; ?>" name="id_siswa" id="id_siswa" readonly="">
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" class="form-control" value="<?= $nis; ?>" name="nis_siswa" id="nis_siswa" readonly="">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" name="nama_siswa" class="form-control" value="<?= $namaSiswa; ?>" id="nama_siswa" readonly/>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="kelas_siswa" value="<?= $kelas; ?>" class="form-control" id="kelas_siswa" readonly/>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Panggilan</label>
                            <input type="text" class="form-control" id="panggilan_siswa" value="<?= $panggilan; ?>" name="panggilan_siswa" readonly/>
                        </div>
                    </div>
                    
                </div> 

                <div class="row">

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Filter By</label>
                            <select class="form-control" name="isi_filter">  
                                <option value="kosong"> -- PILIH -- </option>
                                <?php foreach ($filter_by['isifilter_by'] as $filby): ?>
                                    <?php if ($filby == $isifilby): ?>
                                        
                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php else: ?>

                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php endif ?>
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
                            <button type="submit" name="filter_by" class="form-control btn-primary"> Filter </button>
                        </div>
                    </div>
                </div>

                <hr class="new1" />

            </div>
        </form>

        <?php require 'tabledatapagination.php'; ?>
        
    </div>

<?php elseif(isset($_POST['firstPageFilterLainWithDate'])): ?>

    <?php 

        $tanggalDari   = str_replace([' 00:00:00'], "", $tanggalDari);
        $tanggalSampai = str_replace([' 23:59:59'], "", $tanggalSampai);

    ?>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
           
        </div>
        <form action="checkpembayaran" method="post">
            <div class="box-body">

                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>ID Siswa</label>
                            <input type="text" class="form-control" value="<?= $id; ?>" name="id_siswa" id="id_siswa" readonly="">
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" class="form-control" value="<?= $nis; ?>" name="nis_siswa" id="nis_siswa" readonly="">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" name="nama_siswa" class="form-control" value="<?= $namaSiswa; ?>" id="nama_siswa" readonly/>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="kelas_siswa" value="<?= $kelas; ?>" class="form-control" id="kelas_siswa" readonly/>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Panggilan</label>
                            <input type="text" class="form-control" id="panggilan_siswa" value="<?= $panggilan; ?>" name="panggilan_siswa" readonly/>
                        </div>
                    </div>
                    
                </div> 

                <div class="row">

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Filter By</label>
                            <select class="form-control" name="isi_filter">  
                                <option value="kosong"> -- PILIH -- </option>
                                <?php foreach ($filter_by['isifilter_by'] as $filby): ?>
                                    <?php if ($filby == $isifilby): ?>
                                        
                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php else: ?>

                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php endif ?>
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
                            <button type="submit" name="filter_by" class="form-control btn-primary"> Filter </button>
                        </div>
                    </div>
                </div>

                <hr class="new1" />

            </div>
        </form>

        <?php require 'tabledatapagination.php'; ?>
        
    </div>

<?php elseif(isset($_POST['lastPageFilterLainWithDate'])): ?>

    <?php 

        $tanggalDari   = str_replace([' 00:00:00'], "", $tanggalDari);
        $tanggalSampai = str_replace([' 23:59:59'], "", $tanggalSampai);

    ?>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
           
        </div>
        <form action="checkpembayaran" method="post">
            <div class="box-body">

                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>ID Siswa</label>
                            <input type="text" class="form-control" value="<?= $id; ?>" name="id_siswa" id="id_siswa" readonly="">
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" class="form-control" value="<?= $nis; ?>" name="nis_siswa" id="nis_siswa" readonly="">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" name="nama_siswa" class="form-control" value="<?= $namaSiswa; ?>" id="nama_siswa" readonly/>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="kelas_siswa" value="<?= $kelas; ?>" class="form-control" id="kelas_siswa" readonly/>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Panggilan</label>
                            <input type="text" class="form-control" id="panggilan_siswa" value="<?= $panggilan; ?>" name="panggilan_siswa" readonly/>
                        </div>
                    </div>
                    
                </div> 

                <div class="row">

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Filter By</label>
                            <select class="form-control" name="isi_filter">  
                                <option value="kosong"> -- PILIH -- </option>
                                <?php foreach ($filter_by['isifilter_by'] as $filby): ?>
                                    <?php if ($filby == $isifilby): ?>
                                        
                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php else: ?>

                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php endif ?>
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
                            <button type="submit" name="filter_by" class="form-control btn-primary"> Filter </button>
                        </div>
                    </div>
                </div>

                <hr class="new1" />

            </div>
        </form>

        <?php require 'tabledatapagination.php'; ?>
        
    </div>
<!-- End Filter Lain With Date -->

<?php else: ?>

    <!-- <?php echo "Else"; ?> -->

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
           
        </div>
        <form action="checkpembayaran" method="post">
            <div class="box-body">

                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>ID Siswa</label>
                            <input type="text" class="form-control" value="<?= $id; ?>" name="id_siswa" id="id_siswa" readonly="">
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" class="form-control" value="<?= $nis; ?>" name="nis_siswa" id="nis_siswa" readonly="">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" name="nama_siswa" class="form-control" value="<?= $namaSiswa; ?>" id="nama_siswa" readonly/>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="kelas_siswa" class="form-control" value="<?= $kelas; ?>" id="kelas_siswa" readonly/>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Panggilan</label>
                            <input type="text" class="form-control" id="panggilan_siswa" value="<?= $panggilan; ?>" name="panggilan_siswa" readonly />
                        </div>
                    </div>
                    
                </div> 

                <div class="row">

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Filter By</label>
                            <select class="form-control" name="isi_filter">  
                                <option value="kosong"> -- PILIH -- </option>
                                <?php foreach ($filter_by['isifilter_by'] as $filby): ?>
                                    <?php if ($filby == $isifilby): ?>

                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php else: ?>

                                        <?php if ($filby == 'LAIN'): ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > LAIN - LAIN </option>

                                        <?php else: ?>

                                            <option value="<?= $filby; ?>" <?=($filby == $isifilby )?'selected="selected"':''?> > <?= $filby; ?> </option>
                                            
                                        <?php endif; ?>
                                    
                                    <?php endif ?>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-group">
                            <label> Filter Date From </label>
                            <?php if ($tanggalDari == 'kosong_tgl1'): ?>
                                <input type="date" class="form-control" name="tanggal1" min="1997-01-01" max="2030-12-31">
                            <?php else: ?>
                                <input type="date" class="form-control" name="tanggal1" min="1997-01-01" max="2030-12-31" value="<?= $tanggalDari; ?>">
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-group">
                            <label> Filter Date To </label>
                            <?php if ($tanggalSampai == 'kosong_tgl2'): ?>
                                <input type="date" class="form-control" name="tanggal2" min="1997-01-01" max="2030-12-31">
                            <?php else: ?>
                                <input type="date" class="form-control" name="tanggal2" min="1997-01-01" max="2030-12-31" value="<?= $tanggalSampai; ?>">
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label style="color: white;"> Filter </label>
                            <button type="submit" name="filter_by" class="form-control btn-primary"> Filter </button>
                        </div>
                    </div>
                </div>

                <hr class="new1" />

            </div>
        </form>

        <?php require 'tabledatapagination.php'; ?>
        
    </div>

<?php endif ?>

<!-- Modal Cari Siswa -->
<div id="datamassiswa" class="modal"  data-bs-backdrop="static" data-bs-keyboard="false">
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
                              <th style="text-align: center;" width="5%">NO</th>
                            <?php 
                                if(empty($_GET['q'])) {
                                    echo '<th style="text-align: center;" width="12%">KELAS</th>';
                                } 
                            ?>
                              <th style="text-align: center;">NIS</th>
                              <th style="text-align: center;">NAMA</th>
                              <th style="text-align: center;">GENDER</th>
                            </tr>
                        </thead>
                        <?php

                            $no = 1;
                            
                            if(isset($_GET['q'])) {
                              $smk=mysqli_query($con,"SELECT * FROM siswa where c_kelas='$_GET[q]' order by nama asc ");
                            } else {

                                if ($code_accounting == 'accounting1') {
                                    $queryGetAllDataSiswa      = "SELECT * FROM data_murid_sd ORDER BY KELAS asc ";
                                    $execqueryGetAllDataSiswa  = mysqli_query($con, $queryGetAllDataSiswa);
                                } else {
                                    $queryGetAllDataSiswa      = "SELECT * FROM data_murid_tk";
                                    $execqueryGetAllDataSiswa  = mysqli_query($con, $queryGetAllDataSiswa);
                                }

                            } 

                        ?>
                        <tbody>
                            <?php foreach ($execqueryGetAllDataSiswa as $data): ?>
                            <tr onclick="
                                OnSiswaSelectedModal(
                                    '<?= $data['ID']; ?>', 
                                    '<?= $data['NIS']; ?>', 
                                    '<?= $data['Nama']; ?>', 
                                    '<?= $data['KELAS']; ?>', 
                                    '<?= $data['Panggilan']; ?>'
                                    )
                                ">
                                    <td style="text-align: center;"> <?= $no++; ?> </td>
                                    <td style="text-align: center;"> <?= $data['KELAS']; ?> </td>
                                    <td style="text-align: center;"> <?= $data['NIS']; ?> </td>
                                    <td style="text-align: center;"> <?= $data['Nama']; ?> </td>
                                    <?php if ($data['jk'] == 'L'): ?>
                                        <td style="text-align: center;"> Laki - Laki </td>
                                    <?php else: ?>
                                        <td style="text-align: center;"> Perempuan </td>
                                    <?php endif; ?>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>    
</div>
<!-- Akhir Modal Cari Siswa -->

<!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script> -->

<script language="javascript" type="text/javascript">

$(document).ready(function() {

    $("#list_spp").click();
    $("#check_pembayaran").css({
        "background-color" : "#ccc",
        "color" : "black"
    });

    let scrollNextPage        = `<?= $iniScrollNextPage; ?>`
    let scrollPreviousPage    = `<?= $iniScrollPreviousPage; ?>`
    let scrollFilterPage      = `<?= $iniScrollFilterPage; ?>`

    if (scrollNextPage == 'ada') {
        // window.scrollTo(0, document.body.scrollHeight);
        window.scroll({
          top: 550,
          behavior: 'smooth'
        });
    } else if ( scrollPreviousPage == 'ada' ) {
        window.scroll({
          top: 550,
          behavior: 'smooth'
        });
    } else if ( scrollFilterPage == 'ada' ) {
        window.scroll({
          top: 350,
          behavior: 'smooth'
        });
    }

    $('#_idsiswa').val("");
    $('#_nmsiswa').val("");
    $('#_nmsiswa2').text("");
    $('#_kelassiswa').text("");

    $("#next").click(function() {
        let dataNya = $(this).data('next')
        // alert(dataNya);
        fetch("view/spp/input_data/datacheckpembayaran.php?nextPage=" + dataNya)
        .then((response) => {
            if(!response.ok){ // Before parsing (i.e. decoding) the JSON data,// check for any errors.// In case of an error, throw.
                throw new Error("Terjadi kesalahan!");
            }

            return response.json(); // Parse the JSON data.
        })
        .then((data) => {
            console.log(JSON.parse(data));

        })
        .catch((error) => {
            // This is where you handle errors.
        });
        $("html, body").animate({ scrollTop: 0 }, "slow");
        location.replace("/checkpembayaran");
        return false;
    })

    $('#editorcatatan').summernote({
        placeholder: 'Isi Catatan',
        tabsize: 2,
        height: 150
      });

    var _btnsetupjuz = document.getElementById("btnsetupjuz");
    _btnsetupjuz.style.display = "none";

    // $("#btnSimpanCatatan").click(function() {
    //     alert("Hello")
    //     $.ajax({
    //         url     : "../../a-guru/control.php",
    //         type    : "POST",
    //         data    : {
    //             datanama : document.getElementById("_nmsiswa2").value
    //         },
    //         success:function(data) {
    //             console.log(data);
    //         }
    //     });
    // })

});

    function findOpenPage() {
        $('#findPage').modal("show");
        $('#cari_halaman').focus();

        $(function () {
            $("input[name='cari_halaman']").on('input', function (e) {
                $(this).val($(this).val().replace(/[^0-9]/g, ''));
            });
        });
        function onlynum() {
            let ip = document.getElementById("num");
            let tag = document.getElementById("value");
            let res = ip.value;
 
            if (res != '') {
                if (isNaN(res)) {
 
                    // Set input value empty
                    ip.value = "";
 
                    // Reset the form
                    return false;
                } else {
                    return true
                }
            }
        }
    }

    function OpenCarisiswaModal(){

        $('#datamassiswa').modal("show");
    }

    function OnSiswaSelectedModal(id, nis, nmsiswa, kelas, panggilan){

        // alert(nmsiswa)

        $('#id_siswa').val(id);
        $('#nis_siswa').val(nis);
        $('#nama_siswa').val(nmsiswa);
        $('#kelas_siswa').val(kelas);
        $('#panggilan_siswa').val(panggilan)

        $('#datamassiswa').modal("hide");
    }

    function SelectilidChanged(juzval) {

        if($('#_idsiswa').val() == null || $('#_idsiswa').val() == "")
        {
            alert("Silahkan pilih siswa");
            return $('#_setmanualjuzselect').val("");
        }

        fetch("view/tahfidz/apiservicemasterjuz.php?idjuz=" + $('#_setmanualjuzselect').val())
            .then((response) => {
                if(!response.ok){ // Before parsing (i.e. decoding) the JSON data,// check for any errors.// In case of an error, throw.
                    throw new Error("Terjadi kesalahan!");
                }

                return response.json(); // Parse the JSON data.
            })
            .then((data) => {
                var valjuz = JSON.stringify(data.nmjuz2);
                var valnmbagian = JSON.stringify(data.nmbagian);
                var valseq = JSON.stringify(data.seqjuz);

                $('#_idjuzmanual').val($('#_setmanualjuzselect').val());
                $('#_seqnextmanual').val(valseq.slice(1, -1).trim());
                $('#_nmjuzmanual').val(valjuz.slice(1, -1).trim());
                $('#_nmbagianmanual').val(valnmbagian.slice(1, -1).trim());


                //alert("id: " + $('#_setmanualjuzselect').val() + "- jilid: " + valjuz + "- bagian: " + valnmbagian);
            })
            .catch((error) => {
                // This is where you handle errors.
            });

    } 

</script>

<!-- jQuery 2.2.3 -->

<script type="text/javascript" src="<?php echo $base; ?>theme/datetime/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="<?php echo $base; ?>theme/datetime/js/locales/bootstrap-datetimepicker.fr.js" charset="UTF-8"></script>
<script type="text/javascript">
    $('.form_datetime').datetimepicker({
        //language:  'fr',
        weekStart: 1,
        todayBtn:  1,
    autoclose: 1,
    todayHighlight: 1,
    startView: 2,
    forceParse: 0,
        showMeridian: 1
    });
  $('.form_date').datetimepicker({
        weekStart: 1,
        todayBtn:  1,
    autoclose: 1,
    todayHighlight: 1,
    startView: 2,
    minView: 2,
    forceParse: 0
    });
  $('.form_time').datetimepicker({
        language:  'fr',
        weekStart: 1,
        todayBtn:  1,
    autoclose: 1,
    todayHighlight: 1,
    startView: 1,
    minView: 0,
    maxView: 1,
    forceParse: 0
    });
</script>




