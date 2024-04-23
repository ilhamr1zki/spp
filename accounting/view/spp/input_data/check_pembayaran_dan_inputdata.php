<?php 

    $code_accounting = $_SESSION['c_accounting'];

    $sqlJuz = mysqli_query($con,
    "select CONCAT('Juz ', tblall.juz_atau_keterangan_ayat,' Surah ', nmbagian) as nmjuzall, tblall.* from 
    (
        select tbl1.* from
        (
            select tj.id, tbl1.juz_atau_keterangan_ayat, tj.juz_atau_keterangan_ayat as nmbagian, count(sh.c_siswa) as jml, tj.seqjuz from tbl_juz tj
            left join sisjuz_h sh on tj.id = sh.idjuz 
            left join (select distinct tj2.id, tj2.juz_atau_keterangan_ayat from tbl_juz tj2 ) as tbl1 
            on tj.parentid  = tbl1.id
            where tj.parentid != 0
            
            and coalesce(sh.flag, 'N') = 'N'
            group by tj.id, tj.juz_atau_keterangan_ayat, tbl1.juz_atau_keterangan_ayat, tj.seqjuz
            order by tj.seqjuz
        ) as tbl1
    union 
        select tbl2.* from
        ( 
            select tj.id, '' juz_atau_keterangan_ayat, tj.juz_atau_keterangan_ayat as nmbagian, count(sh.c_siswa) as jml, tj.seqjuz  from tbl_juz tj
            left join sisjuz_h sh on tj.id = sh.idjuz  
            where tj.parentid = 0 and tj.seqjuz  > 14
            and coalesce(sh.flag, 'N') = 'N'
            group by tj.id, tj.juz_atau_keterangan_ayat, tj.seqjuz
            order by tj.seqjuz
        ) as tbl2
   ) as tblall
   order by seqjuz"); 

    $queryGetDataSeqJuz1 = mysqli_query($con, 
        "SELECT id, juz_atau_keterangan_ayat, seqjuz FROM tbl_juz WHERE seqjuz = '1' "
    );

    $getDataArr = mysqli_fetch_array($queryGetDataSeqJuz1);
    
    $getDataIdJuz  = $getDataArr['id'];
    $getDataSeqJuz = $getDataArr['seqjuz'];

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
                    $tanggalDari                = $_POST['tanggal1'];
                    $tanggalSampai              = $_POST['tanggal2'];
                    $checkFilterSiswa           = "adafilter";

                    $_SESSION['form_kosong']    = "form_not_empty";

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
                // header("Location:/checkpembayarandaninputdata");
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
                    $tanggalDari                = $_POST['tanggal1'];
                    $tanggalSampai              = $_POST['tanggal2'];
                    $checkFilterSiswa           = "adafilter";

                    $_SESSION['form_kosong']    = "form_not_empty";

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
                // header("Location:/checkpembayarandaninputdata");
            }
        }        

    }
    // echo $isifilby;exit;

    $cbfilter_by = [];

    $filter_by['isifilter_by'] = [
        'SPP',
        'PANGKAL',
        'KEGIATAN',
        'BUKU',
        'SERAGAM',
        'REGISTRASI',
        'LAIN'
    ];

    // foreach ($cbfilter_by['isifilter_by'] as $key) {
    //     if ($key == 'BUKU') {
    //         echo "BUKUNIH";
    //     } else {
    //         echo $key;
    //     }
    // }

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

        } else if (isset($_POST['nextLastPage'])) {

            $halamanAktif = $jumlahPagination;
            $iniScrollPreviousPage  = "ada";

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

        } else if (isset($_POST['filter_by'])) {
            
            $halamanAktif = 1;

            if ($_SESSION['form_kosong'] == 'form_not_empty') {
                $iniScrollFilterPage;
            } else if($_SESSION['form_kosong'] == 'filter_kosong') {
                $iniScrollFilterPage;
            } else if($_SESSION['form_kosong'] == 'empty_form') {
                $iniScrollFilterPage;
            } else {           
                $iniScrollFilterPage = "ada";
            }

            $hitungDataFilterSPP = "";

            // SPP
            if ($_POST['isi_filter'] != 'kosong' ) {
                $dariTanggal    = $_POST['tanggal1'] . " 00:00:00";
                $sampaiTanggal  = $_POST['tanggal2'] . " 23:59:59";
                
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
                        $getDataArr          = mysqli_fetch_array($execQueryDataSPP);

                        $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;
                        // echo $dataAwal . "<br>";
                        $ambildata_perhalaman = mysqli_query($con, "
                            SELECT ID, NIS, NAMA, kelas, SPP, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                            FROM input_data_sd
                            WHERE
                            SPP != 0
                            AND NAMA LIKE '%$namaMurid%' LIMIT $dataAwal, $jumlahData ");
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

            } else {
                // Jika tidak ada filter yang di pilih (kosong)
                $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;
                // echo $dataAwal . "<br>";
                $ambildata_perhalaman = mysqli_query($con, "SELECT * FROM input_data_sd LIMIT $dataAwal, $jumlahData  ");
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
                SELECT ID, NIS, NAMA, kelas, SPP, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                SPP != 0
                AND NAMA LIKE '%$namaMurid%' LIMIT $dataAwal, $jumlahData");
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
                SELECT ID, NIS, NAMA, kelas, SPP, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                SPP != 0
                AND NAMA LIKE '%$namaMurid%' LIMIT $dataAwal, $jumlahData");
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
                SELECT ID, NIS, NAMA, kelas, SPP, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                SPP != 0
                AND NAMA LIKE '%$namaMurid%' LIMIT $dataAwal, $jumlahData");
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

            $hitungDataFilterSPP = $jumlahPagination;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, SPP, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                SPP != 0
                AND NAMA LIKE '%$namaMurid%'
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

            $hitungDataFilterSPP = $jumlahPagination;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, SPP, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_sd
                WHERE
                SPP != 0
                AND NAMA LIKE '%$namaMurid%'
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

        } else if (isset($_POST['nextLastPage'])) {

            $halamanAktif = $jumlahPagination;
            $iniScrollPreviousPage  = "ada";

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

        } else if (isset($_POST['filter_by'])) {
            
            $halamanAktif = 1;

            if ($_SESSION['form_kosong'] == 'form_not_empty') {
                $iniScrollFilterPage;
            } else if($_SESSION['form_kosong'] == 'filter_kosong') {
                $iniScrollFilterPage;
            } else if($_SESSION['form_kosong'] == 'empty_form') {
                $iniScrollFilterPage;
            } else {           
                $iniScrollFilterPage = "ada";
            }

            $hitungDataFilterSPP = "";

            // SPP
            if ($_POST['isi_filter'] != 'kosong' ) {
                $dariTanggal    = $_POST['tanggal1'] . " 00:00:00";
                $sampaiTanggal  = $_POST['tanggal2'] . " 23:59:59";
                
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

                        if ($hitungDataFilterSPP == 0) {

                            $id                 = "";
                            $nis                = "";
                            $namaSiswa          = "";
                            $kelas              = "";
                            $panggilan          = "";
                            $checkFilterSiswa   = "";

                            $halamanAktif = 1;
                            $namaMurid;

                            $totalHalamanTambah100 = $halamanAktif;

                            $showAddPage100 = "";
                            $isifilby = "kosong";
                            $_SESSION['err_warning'] = "no_data";

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

                        } else {

                            $getDataArr          = mysqli_fetch_array($execQueryDataSPP);

                            $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;
                            // echo $dataAwal . "<br>";
                            $ambildata_perhalaman = mysqli_query($con, "
                                SELECT ID, NIS, NAMA, kelas, SPP, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                                FROM input_data_tk
                                WHERE
                                SPP != 0
                                AND NAMA LIKE '%$namaMurid%' LIMIT $dataAwal, $jumlahData ");
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
                }

            } else {
                // Jika tidak ada filter yang di pilih (kosong)
                $dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;
                // echo $dataAwal . "<br>";
                $ambildata_perhalaman = mysqli_query($con, "SELECT * FROM input_data_tk LIMIT $dataAwal, $jumlahData  ");
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
                SELECT ID, NIS, NAMA, kelas, SPP, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                SPP != 0
                AND NAMA LIKE '%$namaMurid%' LIMIT $dataAwal, $jumlahData");
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
                SELECT ID, NIS, NAMA, kelas, SPP, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                SPP != 0
                AND NAMA LIKE '%$namaMurid%' LIMIT $dataAwal, $jumlahData");
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
                SELECT ID, NIS, NAMA, kelas, SPP, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                SPP != 0
                AND NAMA LIKE '%$namaMurid%' LIMIT $dataAwal, $jumlahData");
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

            $hitungDataFilterSPP = $jumlahPagination;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, SPP, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                SPP != 0
                AND NAMA LIKE '%$namaMurid%'
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

            $hitungDataFilterSPP = $jumlahPagination;

            $ambildata_perhalaman = mysqli_query($con, "
                SELECT ID, NIS, NAMA, kelas, SPP, BULAN AS pembayaran_bulan, SPP_txt, STAMP AS tanggal_diupdate, INPUTER AS di_input_oleh 
                FROM input_data_tk
                WHERE
                SPP != 0
                AND NAMA LIKE '%$namaMurid%'
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

<?php if (isset($_POST['nextPageJustFilterSPP'])): ?>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
           
        </div>
        <form action="checkpembayarandaninputdata" method="post">
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
                            <input type="text" name="nama_siswa" class="form-control" value="<?= $namaSiswa; ?>" id="nama_siswa" />
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="kelas_siswa" value="<?= $kelas; ?>" class="form-control" id="kelas_siswa" />
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Panggilan</label>
                            <input type="text" class="form-control" id="panggilan_siswa" value="<?= $panggilan; ?>" name="panggilan_siswa" />
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

                <!-- 3 Table -->
                <!-- <div class="flex-container"> -->

                    <!-- SPP -->
                    <!-- <div style="background-color: yellow;">
                    
                        <div style="background-color: #DE7A22; color: white; padding: 5px;">

                            <label id="forLabel"> SPP </label>

                            <div id="total" style="margin-right: -65px;">
                                <label> TOTAL </label>
                                <input type="text" name="" value="0.00" readonly="" style="width: 50%; background-color: #eee; color: black;">
                            </div> 
                            
                        </div>

                        <br><br>

                        <div class="row" style="display: flex;">
                            <div class="form-group" style="margin-left: 15px;">
                                <label style="margin-right: 15px;"> JUN 21 </label>
                                <input type="text" style="width: 50%;" name="">
                            </div>
                            <div class="form-group">
                                <label style="margin-right: 11px;"> JAN 22 </label>
                                <input type="text" style="width: 50%;" name="">
                            </div>
                        </div>

                        <div class="row" style="display: flex;">
                            <div class="form-group" style="margin-left: 15px;">
                                <label style="margin-right: 16px;"> JUL 21 </label>
                                <input type="text" style="width: 50%;" name="">
                            </div>
                            <div class="form-group">
                                <label style="margin-right: 10px;"> FEB 22 </label>
                                <input type="text" style="width: 50%;" name="">
                            </div>
                        </div>

                        <div class="row" style="display: flex;">
                            <div class="form-group" style="margin-left: 15px;">
                                <label style="margin-right: 12px;"> AUG 21 </label>
                                <input type="text" style="width: 50%;" name="">
                            </div>
                            <div class="form-group">
                                <label style="margin-right: 5px;"> MAR 22 </label>
                                <input type="text" style="width: 50%;" name="">
                            </div>
                        </div>

                        <div class="row" style="display: flex;">
                            <div class="form-group" style="margin-left: 15px;">
                                <label style="margin-right: 14px;"> SEP 21 </label>
                                <input type="text" style="width: 50%;" name="">
                            </div>
                            <div class="form-group">
                                <label style="margin-right: 9px;"> APR 22 </label>
                                <input type="text" style="width: 50%;" name="">
                            </div>
                        </div>

                        <div class="row" style="display: flex;">
                            <div class="form-group" style="margin-left: 15px;">
                                <label style="margin-right: 13px;"> OCT 21 </label>
                                <input type="text" style="width: 50%;" name="">
                            </div>
                            <div class="form-group">
                                <label style="margin-right: 8px;"> MAY 22 </label>
                                <input type="text" style="width: 50%;" name="">
                            </div>
                        </div>

                        <div class="row" style="display: flex;">
                            <div class="form-group" style="margin-left: 15px;">
                                <label style="margin-right: 12px;"> NOV 21 </label>
                                <input type="text" style="width: 50%;" name="">
                            </div>
                            <div class="form-group">
                                <label style="margin-right: 10px;"> JUN 22 </label>
                                <input type="text" style="width: 50%;" name="">
                            </div>
                        </div>

                        <div class="row" style="display: flex;">
                            <div class="form-group" style="margin-left: 15px;">
                                <label style="margin-right: 13px;"> DEC 21 </label>
                                <input type="text" style="width: 39%;" name="">
                            </div>
                        </div>

                    </div> -->

                    <!-- Pangkal -->
                    <!-- <div style="background-color: #F4CC70;">

                        <div style="background-color: #DE7A22; color: white; padding: 5px;">

                            <label id="forLabel"> Pangkal 2021 </label>

                            <div id="total" style="margin-right: -65px;">
                                <label> TOTAL </label>
                                <input type="text" name="" value="0.00" readonly="" style="width: 50%; background-color: #eee; color: black;">
                            </div> 
                            
                        </div>

                        <br><br>

                        <div class="row" style="display: flex;">
                            <div class="form-group" style="margin-left: 15px;">
                                <label style="margin-right: 15px;"> JAN 21 </label>
                                <input type="text" style="width: 50%;" name="">
                            </div>
                            <div class="form-group">
                                <label style="margin-right: 11px;"> OCT 21 </label>
                                <input type="text" style="width: 50%;" name="">
                            </div>
                        </div>

                        <div class="row" style="display: flex;">
                            <div class="form-group" style="margin-left: 15px;">
                                <label style="margin-right: 15px;"> FEB 21 </label>
                                <input type="text" style="width: 50%;" name="">
                            </div>
                            <div class="form-group">
                                <label style="margin-right: 11px;"> NOV 21 </label>
                                <input type="text" style="width: 50%;" name="">
                            </div>
                        </div>

                        <div class="row" style="display: flex;">
                            <div class="form-group" style="margin-left: 15px;">
                                <label style="margin-right: 11px;"> MAR 21 </label>
                                <input type="text" style="width: 50%;" name="">
                            </div>
                            <div class="form-group">
                                <label style="margin-right: 12px;"> DES 21 </label>
                                <input type="text" style="width: 50%;" name="">
                            </div>
                        </div>

                        <div class="row" style="display: flex;">
                            <div class="form-group" style="margin-left: 15px;">
                                <label style="margin-right: 13px;"> APR 21 </label>
                                <input type="text" style="width: 50%;" name="">
                            </div>
                            <div class="form-group">
                                <label style="margin-right: 13px;"> JAN 22 </label>
                                <input type="text" style="width: 50%;" name="">
                            </div>
                        </div>

                        <div class="row" style="display: flex;">
                            <div class="form-group" style="margin-left: 15px;">
                                <label style="margin-right: 13px;"> MAY 21 </label>
                                <input type="text" style="width: 50%;" name="">
                            </div>
                            <div class="form-group">
                                <label style="margin-right: 13px;"> FEB 22 </label>
                                <input type="text" style="width: 50%;" name="">
                            </div>
                        </div>

                        <div class="row" style="display: flex;">
                            <div class="form-group" style="margin-left: 15px;">
                                <label style="margin-right: 15px;"> JUN 21 </label>
                                <input type="text" style="width: 50%;" name="">
                            </div>
                            <div class="form-group">
                                <label style="margin-right: 9px;"> MAR 22 </label>
                                <input type="text" style="width: 50%;" name="">
                            </div>
                        </div>

                        <div class="row" style="display: flex;">
                            <div class="form-group" style="margin-left: 15px;">
                                <label style="margin-right: 16px;"> JUL 21 </label>
                                <input type="text" style="width: 50%;" name="">
                            </div>
                            <div class="form-group">
                                <label style="margin-right: 11px;"> APR 22 </label>
                                <input type="text" style="width: 50%;" name="">
                            </div>
                        </div>

                        <div class="row" style="display: flex;">
                            <div class="form-group" style="margin-left: 15px;">
                                <label style="margin-right: 12px;"> AUG 21 </label>
                                <input type="text" style="width: 50%;" name="">
                            </div>
                            <div class="form-group">
                                <label style="margin-right: 11px;"> MAY 22 </label>
                                <input type="text" style="width: 50%;" name="">
                            </div>
                        </div>

                        <div class="row" style="display: flex;">
                            <div class="form-group" style="margin-left: 15px;">
                                <label style="margin-right: 14px;"> SEP 21 </label>
                                <input type="text" style="width: 50%;" name="">
                            </div>
                            <div class="form-group">
                                <label style="margin-right: 13px;"> JUN 22 </label>
                                <input type="text" style="width: 50%;" name="">
                            </div>
                        </div>

                    </div> -->

                    <!-- Registrasi -->
                    <!-- <div style="background-color: #E6DF44;">

                        <div style="background-color: #DE7A22; color: white; padding: 5px;">

                            <label id="forLabel"> Registrasi 2021 </label>

                            <div id="total" style="margin-right: -65px;">
                                <label> TOTAL </label>
                                <input type="text" name="" value="0.00" readonly="" style="width: 50%; background-color: #eee; color: black;">
                            </div> 
                            
                        </div>

                        <br><br>

                        <div class="row" style="display: flex;">
                            <div class="form-group" style="margin-left: 15px;">
                                <label style="margin-right: 14px;"> JAN 21 </label>
                                <input type="text" style="width: 50%;" name="">
                            </div>
                            <div class="form-group">
                                <label style="margin-right: 13px;"> JUL 21 </label>
                                <input type="text" style="width: 50%;" name="">
                            </div>
                        </div>

                        <div class="row" style="display: flex;">
                            <div class="form-group" style="margin-left: 15px;">
                                <label style="margin-right: 14px;"> FEB 21 </label>
                                <input type="text" style="width: 50%;" name="">
                            </div>
                            <div class="form-group">
                                <label style="margin-right: 13px;"> AUG 21 </label>
                                <input type="text" style="width: 50%;" name="">
                            </div>
                        </div>

                        <div class="row" style="display: flex;">
                            <div class="form-group" style="margin-left: 15px;">
                                <label style="margin-right: 10px;"> MAR 21 </label>
                                <input type="text" style="width: 50%;" name="">
                            </div>
                            <div class="form-group">
                                <label style="margin-right: 12px;"> SEP 21 </label>
                                <input type="text" style="width: 50%;" name="">
                            </div>
                        </div>

                        <div class="row" style="display: flex;">
                            <div class="form-group" style="margin-left: 15px;">
                                <label style="margin-right: 12px;"> APR 21 </label>
                                <input type="text" style="width: 50%;" name="">
                            </div>
                            <div class="form-group">
                                <label style="margin-right: 10px;"> OCT 21 </label>
                                <input type="text" style="width: 50%;" name="">
                            </div>
                        </div>

                        <div class="row" style="display: flex;">
                            <div class="form-group" style="margin-left: 15px;">
                                <label style="margin-right: 12px;"> MAY 21 </label>
                                <input type="text" style="width: 50%;" name="">
                            </div>
                            <div class="form-group">
                                <label style="margin-right: 13px;"> NOV 21 </label>
                                <input type="text" style="width: 50%;" name="">
                            </div>
                        </div>

                        <div class="row" style="display: flex;">
                            <div class="form-group" style="margin-left: 15px;">
                                <label style="margin-right: 14px;"> JUN 21 </label>
                                <input type="text" style="width: 50%;" name="">
                            </div>
                            <div class="form-group">
                                <label style="margin-right: 15px;"> DES 21 </label>
                                <input type="text" style="width: 50%;" name="">
                            </div>
                        </div>

                        <div class="row" id="jun22">
                            <div class="form-group">
                                <label style="margin-right: 16px;"> JUN 22 </label>
                                <input type="text" style="width: 50%;" name="">
                            </div>
                        </div>

                    </div> -->  

                <!-- </div> -->

                <!-- <table id="tabelCariSiswaCheckPembayaran" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                         <th width="5%">NO</th>
                         <th style="text-align: center;">Nama</th>
                         <th style="text-align: center;">Juz</th>
                         <th style="text-align: center;">Bagian</th>
                         <th style="text-align: center;">Tgl Naik</th>
                         <th style="text-align: center;"> Jml Hari </th>
                      </tr>
                    </thead>
                    <tbody>

                        <tr>
                            <td style="text-align: center;"> 1 </td>
                            <td style="text-align: center;"><a style="cursor:pointer;"> NISWA </a> </td>
                            <td style="text-align: center;"> lorem </td>
                            <td style="text-align: center;"> ipsum </td>
                            <td style="text-align: center;"> test </td>
                            <td style="text-align: center;"> lorem ipsum </td>
                        </tr>

                        <tr>
                            <td style="text-align: center;"> 2 </td>
                            <td style="text-align: center;"><a style="cursor:pointer;"> GATHAN </a> </td>
                            <td style="text-align: center;"> Bekasi </td>
                            <td style="text-align: center;"> 16 Desember 2002 </td>
                            <td style="text-align: center;"> Trisakti </td>
                            <td style="text-align: center;"> English </td>
                        </tr>

                    </tbody>

                </table> -->

            </div>
        </form>

        <?php require 'tabledatapagination.php'; ?>
        
    </div>

<?php elseif(isset($_POST['previousPageJustFilterSPP'])): ?>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
           
        </div>
        <form action="checkpembayarandaninputdata" method="post">
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
                            <input type="text" name="nama_siswa" class="form-control" value="<?= $namaSiswa; ?>" id="nama_siswa" />
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="kelas_siswa" value="<?= $kelas; ?>" class="form-control" value="MUHAMMAD ELVARO RAFARDHAN" id="kelas_siswa" />
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Panggilan</label>
                            <input type="text" class="form-control" id="panggilan_siswa" value="<?= $panggilan; ?>" name="panggilan_siswa" />
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

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
           
        </div>
        <form action="checkpembayarandaninputdata" method="post">
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
                            <input type="text" name="nama_siswa" class="form-control" value="<?= $namaSiswa; ?>" id="nama_siswa" />
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="kelas_siswa" value="<?= $kelas; ?>" class="form-control" id="kelas_siswa" />
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Panggilan</label>
                            <input type="text" class="form-control" id="panggilan_siswa" value="<?= $panggilan; ?>" name="panggilan_siswa" />
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

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
           
        </div>
        <form action="checkpembayarandaninputdata" method="post">
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
                            <input type="text" name="nama_siswa" class="form-control" value="<?= $namaSiswa; ?>" id="nama_siswa" />
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="kelas_siswa" value="<?= $kelas; ?>" class="form-control" id="kelas_siswa" />
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Panggilan</label>
                            <input type="text" class="form-control" id="panggilan_siswa" value="<?= $panggilan; ?>" name="panggilan_siswa" />
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

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
           
        </div>
        <form action="checkpembayarandaninputdata" method="post">
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
                            <input type="text" name="nama_siswa" class="form-control" value="<?= $namaSiswa; ?>" id="nama_siswa" />
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="kelas_siswa" value="<?= $kelas; ?>" class="form-control" id="kelas_siswa" />
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Panggilan</label>
                            <input type="text" class="form-control" id="panggilan_siswa" value="<?= $panggilan; ?>" name="panggilan_siswa" />
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

<?php else: ?>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
           
        </div>
        <form action="checkpembayarandaninputdata" method="post">
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
                            <input type="text" name="nama_siswa" class="form-control" value="<?= $namaSiswa; ?>" id="nama_siswa" />
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="kelas_siswa" class="form-control" value="<?= $kelas; ?>" id="kelas_siswa" />
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Panggilan</label>
                            <input type="text" class="form-control" id="panggilan_siswa" value="<?= $panggilan; ?>" name="panggilan_siswa" />
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

                <!-- 3 Table -->
                <!-- <div class="flex-container"> -->

                    <!-- SPP -->
                    <!-- <div style="background-color: yellow;">
                    
                        <div style="background-color: #DE7A22; color: white; padding: 5px;">

                            <label id="forLabel"> SPP </label>

                            <div id="total" style="margin-right: -65px;">
                                <label> TOTAL </label>
                                <input type="text" name="" value="0.00" readonly="" style="width: 50%; background-color: #eee; color: black;">
                            </div> 
                            
                        </div>

                        <br><br>

                        <div class="row" style="display: flex;">
                            <div class="form-group" style="margin-left: 15px;">
                                <label style="margin-right: 15px;"> JUN 21 </label>
                                <input type="text" style="width: 50%;" name="">
                            </div>
                            <div class="form-group">
                                <label style="margin-right: 11px;"> JAN 22 </label>
                                <input type="text" style="width: 50%;" name="">
                            </div>
                        </div>

                        <div class="row" style="display: flex;">
                            <div class="form-group" style="margin-left: 15px;">
                                <label style="margin-right: 16px;"> JUL 21 </label>
                                <input type="text" style="width: 50%;" name="">
                            </div>
                            <div class="form-group">
                                <label style="margin-right: 10px;"> FEB 22 </label>
                                <input type="text" style="width: 50%;" name="">
                            </div>
                        </div>

                        <div class="row" style="display: flex;">
                            <div class="form-group" style="margin-left: 15px;">
                                <label style="margin-right: 12px;"> AUG 21 </label>
                                <input type="text" style="width: 50%;" name="">
                            </div>
                            <div class="form-group">
                                <label style="margin-right: 5px;"> MAR 22 </label>
                                <input type="text" style="width: 50%;" name="">
                            </div>
                        </div>

                        <div class="row" style="display: flex;">
                            <div class="form-group" style="margin-left: 15px;">
                                <label style="margin-right: 14px;"> SEP 21 </label>
                                <input type="text" style="width: 50%;" name="">
                            </div>
                            <div class="form-group">
                                <label style="margin-right: 9px;"> APR 22 </label>
                                <input type="text" style="width: 50%;" name="">
                            </div>
                        </div>

                        <div class="row" style="display: flex;">
                            <div class="form-group" style="margin-left: 15px;">
                                <label style="margin-right: 13px;"> OCT 21 </label>
                                <input type="text" style="width: 50%;" name="">
                            </div>
                            <div class="form-group">
                                <label style="margin-right: 8px;"> MAY 22 </label>
                                <input type="text" style="width: 50%;" name="">
                            </div>
                        </div>

                        <div class="row" style="display: flex;">
                            <div class="form-group" style="margin-left: 15px;">
                                <label style="margin-right: 12px;"> NOV 21 </label>
                                <input type="text" style="width: 50%;" name="">
                            </div>
                            <div class="form-group">
                                <label style="margin-right: 10px;"> JUN 22 </label>
                                <input type="text" style="width: 50%;" name="">
                            </div>
                        </div>

                        <div class="row" style="display: flex;">
                            <div class="form-group" style="margin-left: 15px;">
                                <label style="margin-right: 13px;"> DEC 21 </label>
                                <input type="text" style="width: 39%;" name="">
                            </div>
                        </div>

                    </div> -->

                    <!-- Pangkal -->
                    <!-- <div style="background-color: #F4CC70;">

                        <div style="background-color: #DE7A22; color: white; padding: 5px;">

                            <label id="forLabel"> Pangkal 2021 </label>

                            <div id="total" style="margin-right: -65px;">
                                <label> TOTAL </label>
                                <input type="text" name="" value="0.00" readonly="" style="width: 50%; background-color: #eee; color: black;">
                            </div> 
                            
                        </div>

                        <br><br>

                        <div class="row" style="display: flex;">
                            <div class="form-group" style="margin-left: 15px;">
                                <label style="margin-right: 15px;"> JAN 21 </label>
                                <input type="text" style="width: 50%;" name="">
                            </div>
                            <div class="form-group">
                                <label style="margin-right: 11px;"> OCT 21 </label>
                                <input type="text" style="width: 50%;" name="">
                            </div>
                        </div>

                        <div class="row" style="display: flex;">
                            <div class="form-group" style="margin-left: 15px;">
                                <label style="margin-right: 15px;"> FEB 21 </label>
                                <input type="text" style="width: 50%;" name="">
                            </div>
                            <div class="form-group">
                                <label style="margin-right: 11px;"> NOV 21 </label>
                                <input type="text" style="width: 50%;" name="">
                            </div>
                        </div>

                        <div class="row" style="display: flex;">
                            <div class="form-group" style="margin-left: 15px;">
                                <label style="margin-right: 11px;"> MAR 21 </label>
                                <input type="text" style="width: 50%;" name="">
                            </div>
                            <div class="form-group">
                                <label style="margin-right: 12px;"> DES 21 </label>
                                <input type="text" style="width: 50%;" name="">
                            </div>
                        </div>

                        <div class="row" style="display: flex;">
                            <div class="form-group" style="margin-left: 15px;">
                                <label style="margin-right: 13px;"> APR 21 </label>
                                <input type="text" style="width: 50%;" name="">
                            </div>
                            <div class="form-group">
                                <label style="margin-right: 13px;"> JAN 22 </label>
                                <input type="text" style="width: 50%;" name="">
                            </div>
                        </div>

                        <div class="row" style="display: flex;">
                            <div class="form-group" style="margin-left: 15px;">
                                <label style="margin-right: 13px;"> MAY 21 </label>
                                <input type="text" style="width: 50%;" name="">
                            </div>
                            <div class="form-group">
                                <label style="margin-right: 13px;"> FEB 22 </label>
                                <input type="text" style="width: 50%;" name="">
                            </div>
                        </div>

                        <div class="row" style="display: flex;">
                            <div class="form-group" style="margin-left: 15px;">
                                <label style="margin-right: 15px;"> JUN 21 </label>
                                <input type="text" style="width: 50%;" name="">
                            </div>
                            <div class="form-group">
                                <label style="margin-right: 9px;"> MAR 22 </label>
                                <input type="text" style="width: 50%;" name="">
                            </div>
                        </div>

                        <div class="row" style="display: flex;">
                            <div class="form-group" style="margin-left: 15px;">
                                <label style="margin-right: 16px;"> JUL 21 </label>
                                <input type="text" style="width: 50%;" name="">
                            </div>
                            <div class="form-group">
                                <label style="margin-right: 11px;"> APR 22 </label>
                                <input type="text" style="width: 50%;" name="">
                            </div>
                        </div>

                        <div class="row" style="display: flex;">
                            <div class="form-group" style="margin-left: 15px;">
                                <label style="margin-right: 12px;"> AUG 21 </label>
                                <input type="text" style="width: 50%;" name="">
                            </div>
                            <div class="form-group">
                                <label style="margin-right: 11px;"> MAY 22 </label>
                                <input type="text" style="width: 50%;" name="">
                            </div>
                        </div>

                        <div class="row" style="display: flex;">
                            <div class="form-group" style="margin-left: 15px;">
                                <label style="margin-right: 14px;"> SEP 21 </label>
                                <input type="text" style="width: 50%;" name="">
                            </div>
                            <div class="form-group">
                                <label style="margin-right: 13px;"> JUN 22 </label>
                                <input type="text" style="width: 50%;" name="">
                            </div>
                        </div>

                    </div> -->

                    <!-- Registrasi -->
                    <!-- <div style="background-color: #E6DF44;">

                        <div style="background-color: #DE7A22; color: white; padding: 5px;">

                            <label id="forLabel"> Registrasi 2021 </label>

                            <div id="total" style="margin-right: -65px;">
                                <label> TOTAL </label>
                                <input type="text" name="" value="0.00" readonly="" style="width: 50%; background-color: #eee; color: black;">
                            </div> 
                            
                        </div>

                        <br><br>

                        <div class="row" style="display: flex;">
                            <div class="form-group" style="margin-left: 15px;">
                                <label style="margin-right: 14px;"> JAN 21 </label>
                                <input type="text" style="width: 50%;" name="">
                            </div>
                            <div class="form-group">
                                <label style="margin-right: 13px;"> JUL 21 </label>
                                <input type="text" style="width: 50%;" name="">
                            </div>
                        </div>

                        <div class="row" style="display: flex;">
                            <div class="form-group" style="margin-left: 15px;">
                                <label style="margin-right: 14px;"> FEB 21 </label>
                                <input type="text" style="width: 50%;" name="">
                            </div>
                            <div class="form-group">
                                <label style="margin-right: 13px;"> AUG 21 </label>
                                <input type="text" style="width: 50%;" name="">
                            </div>
                        </div>

                        <div class="row" style="display: flex;">
                            <div class="form-group" style="margin-left: 15px;">
                                <label style="margin-right: 10px;"> MAR 21 </label>
                                <input type="text" style="width: 50%;" name="">
                            </div>
                            <div class="form-group">
                                <label style="margin-right: 12px;"> SEP 21 </label>
                                <input type="text" style="width: 50%;" name="">
                            </div>
                        </div>

                        <div class="row" style="display: flex;">
                            <div class="form-group" style="margin-left: 15px;">
                                <label style="margin-right: 12px;"> APR 21 </label>
                                <input type="text" style="width: 50%;" name="">
                            </div>
                            <div class="form-group">
                                <label style="margin-right: 10px;"> OCT 21 </label>
                                <input type="text" style="width: 50%;" name="">
                            </div>
                        </div>

                        <div class="row" style="display: flex;">
                            <div class="form-group" style="margin-left: 15px;">
                                <label style="margin-right: 12px;"> MAY 21 </label>
                                <input type="text" style="width: 50%;" name="">
                            </div>
                            <div class="form-group">
                                <label style="margin-right: 13px;"> NOV 21 </label>
                                <input type="text" style="width: 50%;" name="">
                            </div>
                        </div>

                        <div class="row" style="display: flex;">
                            <div class="form-group" style="margin-left: 15px;">
                                <label style="margin-right: 14px;"> JUN 21 </label>
                                <input type="text" style="width: 50%;" name="">
                            </div>
                            <div class="form-group">
                                <label style="margin-right: 15px;"> DES 21 </label>
                                <input type="text" style="width: 50%;" name="">
                            </div>
                        </div>

                        <div class="row" id="jun22">
                            <div class="form-group">
                                <label style="margin-right: 16px;"> JUN 22 </label>
                                <input type="text" style="width: 50%;" name="">
                            </div>
                        </div>

                    </div> -->  

                <!-- </div> -->

                <!-- <table id="tabelCariSiswaCheckPembayaran" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                         <th width="5%">NO</th>
                         <th style="text-align: center;">Nama</th>
                         <th style="text-align: center;">Juz</th>
                         <th style="text-align: center;">Bagian</th>
                         <th style="text-align: center;">Tgl Naik</th>
                         <th style="text-align: center;"> Jml Hari </th>
                      </tr>
                    </thead>
                    <tbody>

                        <tr>
                            <td style="text-align: center;"> 1 </td>
                            <td style="text-align: center;"><a style="cursor:pointer;"> NISWA </a> </td>
                            <td style="text-align: center;"> lorem </td>
                            <td style="text-align: center;"> ipsum </td>
                            <td style="text-align: center;"> test </td>
                            <td style="text-align: center;"> lorem ipsum </td>
                        </tr>

                        <tr>
                            <td style="text-align: center;"> 2 </td>
                            <td style="text-align: center;"><a style="cursor:pointer;"> GATHAN </a> </td>
                            <td style="text-align: center;"> Bekasi </td>
                            <td style="text-align: center;"> 16 Desember 2002 </td>
                            <td style="text-align: center;"> Trisakti </td>
                            <td style="text-align: center;"> English </td>
                        </tr>

                    </tbody>

                </table> -->

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
        location.replace("/checkpembayarandaninputdata");
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




