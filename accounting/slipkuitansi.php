<?php  

	session_start();

	require '../php/config.php';
	require '../php/function.php'; 

    if(empty($_SESSION['c_accounting'])) {
        header('location:../login');
    }

    function bulan_indo($month) {
        $bulan = (int) $month;
        $arrBln = array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
        return $arrBln[$bulan];
    }

    function format_tanggal_indo($tgl) {
        $tanggal = substr($tgl, 8, 2);
        $bulan = bulan_indo(substr($tgl, 5, 2));
        $tahun = substr($tgl, 0, 4);
        $day = date('D', strtotime($tgl));
        $dayList = array(
            'Sun' => 'Minggu',
            'Mon' => 'Senin',
            'Tue' => 'Selasa',
            'Wed' => 'Rabu',
            'Thu' => 'Kamis',
            'Fri' => 'Jumat',
            'Sat' => 'Sabtu'
        );

        return $tanggal . ' ' . $bulan . ' '. $tahun;  
    }

	function rupiahFormat($angkax){
    
        $hasil_rupiahx = "Rp " . number_format($angkax,0,'.',',');
        return $hasil_rupiahx;
     
    }

    function rupiah($angka){
    
        $hasil_rupiah = "Rp " . number_format($angka,2,',','.');
        return $hasil_rupiah;
     
    }

    function penyebut($nilai) {
        $nilai = abs($nilai);
        $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
        $temp = "";
        if ($nilai < 12) {
            $temp = " ". $huruf[$nilai];
        } else if ($nilai <20) {
            $temp = penyebut($nilai - 10). " belas";
        } else if ($nilai < 100) {
            $temp = penyebut($nilai/10)." puluh". penyebut($nilai % 10);
        } else if ($nilai < 200) {
            $temp = " seratus" . penyebut($nilai - 100);
        } else if ($nilai < 1000) {
            $temp = penyebut($nilai/100) . " ratus" . penyebut($nilai % 100);
        } else if ($nilai < 2000) {
            $temp = " seribu" . penyebut($nilai - 1000);
        } else if ($nilai < 1000000) {
            $temp = penyebut($nilai/1000) . " ribu" . penyebut($nilai % 1000);
        } else if ($nilai < 1000000000) {
            $temp = penyebut($nilai/1000000) . " juta" . penyebut($nilai % 1000000);
        } else if ($nilai < 1000000000000) {
            $temp = penyebut($nilai/1000000000) . " milyar" . penyebut(fmod($nilai,1000000000));
        } else if ($nilai < 1000000000000000) {
            $temp = penyebut($nilai/1000000000000) . " trilyun" . penyebut(fmod($nilai,1000000000000));
        }     
        return $temp;
    }

    function terbilang($nilai) {
        if($nilai<0) {
            $hasil = "minus ". trim(penyebut($nilai));
        } else {
            $hasil = trim(penyebut($nilai));
        }           
        return ucwords($hasil) . " Rupiah";
    }

    $jenjangPendidikan = "";

    if (isset($_POST['slip_kuitansi'])) {

    	if ($_SESSION['c_accounting'] == 'accounting1') {
    		$jenjangPendidikan = 'SD';
    	} else if ($_SESSION['c_accounting'] == 'accounting2') {
    		$jenjangPendidikan = 'KB-TK';
    	}

		$nisSiswa          = $_POST['cetak_kuitansi_nis_siswa'];
	    $namaSiswa         = $_POST['cetak_kuitansi_nama_siswa'];
	    $kelasSiswa        = $_POST['cetak_kuitansi_kelas_siswa'];
	    $idInvoice         = $_POST['cetak_kuitansi_id_invoice'];
	    $tglTf             = $_POST['cetak_kuitansi_bukti_tf'];

	    if ($tglTf != 'kosong') {
	    	$tglTf;
	    } else if ($tglTf == 'kosong') {
	    	$tglTf = "-";
	    }

	    $bayarBulan        = $_POST['cetak_kuitansi_bulan_pembayaran'];

	    $isiUangSPP        = $_POST['cetak_kuitansi_uang_spp'];
	    $isiUangPangkal    = $_POST['cetak_kuitansi_uang_pangkal'];
	    $isiUangKegiatan   = $_POST['cetak_kuitansi_uang_kegiatan'];
	    $isiUangBuku       = $_POST['cetak_kuitansi_uang_buku'];
	    $isiUangSeragam    = $_POST['cetak_kuitansi_uang_seragam'];
	    $isiUangRegis      = $_POST['cetak_kuitansi_uang_registrasi'];
	    $isiUangLain       = $_POST['cetak_kuitansi_uang_lain'];

	    $ketUangSPP        = htmlspecialchars($_POST['cetak_kuitansi_ket_uang_spp']);

	    $ketUangPANGKAL    = htmlspecialchars($_POST['cetak_kuitansi_ket_uang_pangkal']);
	    $ketUangKegiatan   = htmlspecialchars($_POST['cetak_kuitansi_ket_uang_kegiatan']);
	    $ketUangBuku       = htmlspecialchars($_POST['cetak_kuitansi_ket_uang_buku']);
	    $ketUangSeragam    = htmlspecialchars($_POST['cetak_kuitansi_ket_uang_seragam']);
	    $ketUangRegistrasi = htmlspecialchars($_POST['cetak_kuitansi_ket_uang_registrasi']);
	    $ketUangLain       = htmlspecialchars($_POST['cetak_kuitansi_ket_uang_lain']);

	    $isiKetUangSpp 			= "";
	    $isiKetUangPangkal 		= "";
	    $isiKetUangKegiatan 	= "";
	    $isiKetUangBuku 		= "";
	    $isiKetUangSeragam 		= "";
	    $isiKetUangRegistrasi 	= "";
	    $isiKetUangLain 		= "";

		$arrIsiJenisPembayaran 		= [];
		$arrIsiKeteranganPembayaran = [];
		$arrIsiKetPembayaran 		= [];
		$arrIsiJumlahBayar 	   		= [];

		$arrDataBaruJenisPembayaran	= [];
		$arrDataBaruIsiKetPembyrn   = [];
		$arrDataBaruJumlahBayar		= [];

		$jenisPembayaranSPP       = $_POST['jenisPembayaranSPP'];
		$jenisPembayaranPangkal   = $_POST['jenisPembayaranPangkal'];
		$jenisPembayaranKegiatan  = $_POST['jenisPembayaranKegiatan'];
		$jenisPembayaranBuku  	  = $_POST['jenisPembayaranBuku'];
		$jenisPembayaranSeragam   = $_POST['jenisPembayaranSeragam'];
		$jenisPembayaranRegis  	  = $_POST['jenisPembayaranRegistrasi'];
		$jenisPembayaranLain  	  = $_POST['jenisPembayaranLain'];

		$dataSPP 		= "";
		$dataPangkal 	= "";
		$dataKegiatan 	= "";
		$dataBuku 		= "";
		$dataSeragam 	= "";
		$dataRegis 		= "";
		$dataLain 		= "";

		$totalNominalJumlahBayar = $isiUangSPP + $isiUangPangkal + $isiUangKegiatan + $isiUangBuku + $isiUangSeragam + $isiUangRegis + $isiUangLain;
		// $totalNominalJumlahBayar = rupiah($totalNominalJumlahBayar);
		$terbilang 				 = terbilang($totalNominalJumlahBayar);
		$totalNominalJumlahBayar = rupiahFormat($totalNominalJumlahBayar);
		$totalNominalJumlahBayar = str_replace(["Rp "], "", $totalNominalJumlahBayar);


		// Nominal Bayar
	    switch ($isiUangSPP) {
		  case 0 :
		  	$isiUangSPP = 0;
		    break;
		  default:
		  	$isiUangSPP = rupiahFormat($isiUangSPP);
		}

		switch ($isiUangPangkal) {
		  case 0 :
		  	$isiUangPangkal = 0;
		    break;
		  default:
		  	$isiUangPangkal = rupiahFormat($isiUangPangkal);
		}

		switch ($isiUangKegiatan) {
		  case 0 :
		  	$isiUangKegiatan = 0;
		    break;
		  default:
		  	$isiUangKegiatan = rupiahFormat($isiUangKegiatan);
		}

		switch ($isiUangBuku) {
		  case 0 :
		  	$isiUangBuku = 0;
		    break;
		  default:
		  	$isiUangBuku = rupiahFormat($isiUangBuku);
		}

		switch ($isiUangSeragam) {
		  case 0 :
		  	$isiUangSeragam = 0;
		    break;
		  default:
		  	$isiUangSeragam = rupiahFormat($isiUangSeragam);
		}

		switch ($isiUangRegis) {
		  case 0 :
		  	$isiUangRegis = 0;
		    break;
		  default:
		  	$isiUangRegis = rupiahFormat($isiUangRegis);
		}

		switch ($isiUangLain) {
		  case 0 :
		  	$isiUangLain = 0;
		    break;
		  default:
		  	$isiUangLain = rupiahFormat($isiUangLain);
		}
		// Akhir Nominal Bayar


		// Keterangan Pembayaran
		switch ($ketUangSPP) {
		  case "" :
		  	$ketUangSPP = "";
		    break;
		  default:
		  	$ketUangSPP;
		  	$isiKetUangSpp = $ketUangSPP . ", ";
		}

		switch ($ketUangPANGKAL) {
		  case "" :
		  	$ketUangPANGKAL = "";
		    break;
		  default:
		  	$ketUangPANGKAL;
		  	$isiKetUangPangkal = $ketUangPANGKAL . ", ";
		}

		switch ($ketUangKegiatan) {
		  case "" :
		  	$ketUangKegiatan = "";
		    break;
		  default:
		  	$ketUangKegiatan;
		  	$isiKetUangKegiatan = $ketUangKegiatan . ", ";
		}

		switch ($ketUangBuku) {
		  case "" :
		  	$ketUangBuku = "";
		    break;
		  default:
		  	$ketUangBuku;
		  	$isiKetUangBuku = $ketUangBuku . ", ";
		}

		switch ($ketUangSeragam) {
		  case "" :
		  	$ketUangSeragam = "";
		    break;
		  default:
		  	$ketUangSeragam;
		  	$isiKetUangSeragam = $ketUangSeragam . ", ";
		}

		switch ($ketUangRegistrasi) {
		  case "" :
		  	$ketUangRegistrasi = "";
		    break;
		  default:
		  	$ketUangRegistrasi;
		  	$isiKetUangRegistrasi = $ketUangRegistrasi . ", ";
		}

		switch ($ketUangLain) {
		  case "" :
		  	$ketUangLain = "";
		    break;
		  default:
		  	$ketUangLain;
		  	$isiKetUangLain = $ketUangLain . ", ";
		}
		// Akhir Keterangan Pembayaran


		// Jenis Pembayaran
	    switch ($jenisPembayaranSPP) {
		  case 0 :
		  	$dataSPP = "";
		    break;
		  default:
		  	$dataSPP = "SPP";
		}

		switch ($jenisPembayaranPangkal) {
		  case 0 :
		  	$dataPangkal = "";
		    break;
		  default:
		  	$dataPangkal = "PANGKAL";
		}

		switch ($jenisPembayaranKegiatan) {
		  case 0 :
		  	$dataKegiatan = "";
		    break;
		  default:
		  	$dataKegiatan = "KEGIATAN";
		}

	    switch ($jenisPembayaranBuku) {
		  case 0 :
		  	$dataBuku = "";
		    break;
		  default:
		  	$dataBuku = "BUKU";
		}

		switch ($jenisPembayaranSeragam) {
		  case 0 :
		  	$dataSeragam = "";
		    break;
		  default:
		  	$dataSeragam = "SERAGAM";
		}

		switch ($jenisPembayaranRegis) {
		  case 0 :
		  	$dataRegis = "";
		    break;
		  default:
		  	$dataRegis = "REGISTRASI/Daftar Ulang";
		}

		$pangkat2 = "<sup id='pangkat_2' >2</sup>";

		switch ($jenisPembayaranLain) {
		  case 0 :
		  	$dataLain = "";
		    break;
		  default:
		  	$dataLain =  "<p id = 'isi_lain'>LAIN". $pangkat2 ."/INFAQ/SUMBANGAN/ANTAR JEMPUT</p>";
		}
		// Akhir Jenis Pembayaran

	    $arrIsiJenisPembayaran[] 		= $dataSPP;
	    $arrIsiJenisPembayaran[] 		= $dataPangkal;
	    $arrIsiJenisPembayaran[] 		= $dataKegiatan;
	    $arrIsiJenisPembayaran[] 		= $dataBuku;
	    $arrIsiJenisPembayaran[] 		= $dataSeragam;
	    $arrIsiJenisPembayaran[] 		= $dataRegis;
	    $arrIsiJenisPembayaran[] 		= $dataLain;

	    $arrIsiKeteranganPembayaran[]	= $ketUangSPP;
	    $arrIsiKeteranganPembayaran[]	= $ketUangPANGKAL;
	    $arrIsiKeteranganPembayaran[]	= $ketUangKegiatan;
	    $arrIsiKeteranganPembayaran[]	= $ketUangBuku;
	    $arrIsiKeteranganPembayaran[]	= $ketUangSeragam;
	    $arrIsiKeteranganPembayaran[]	= $ketUangRegistrasi;
	    $arrIsiKeteranganPembayaran[]	= $ketUangLain;

	    // var_dump($arrIsiKeteranganPembayaran);exit;

	    $arrIsiKetPembayaran[]			= $isiKetUangSpp;
	    $arrIsiKetPembayaran[]			= $isiKetUangPangkal;
	    $arrIsiKetPembayaran[]			= $isiKetUangKegiatan;
	    $arrIsiKetPembayaran[]			= $isiKetUangBuku;
	    $arrIsiKetPembayaran[]			= $isiKetUangSeragam;
	    $arrIsiKetPembayaran[]			= $isiKetUangRegistrasi;
	    $arrIsiKetPembayaran[]			= $isiKetUangLain;

		$arrIsiJumlahBayar[] 			= $isiUangSPP;
		$arrIsiJumlahBayar[] 			= $isiUangPangkal;
		$arrIsiJumlahBayar[] 			= $isiUangKegiatan;
		$arrIsiJumlahBayar[] 			= $isiUangBuku;
		$arrIsiJumlahBayar[] 			= $isiUangSeragam;
		$arrIsiJumlahBayar[] 			= $isiUangRegis;
		$arrIsiJumlahBayar[]	 		= $isiUangLain;

		$convertString = implode($arrIsiKetPembayaran);
		// echo substr($convertString, 0, -2);exit;

	    // Mencari dan Menghapus Data Yang Mengandung Data String yang Kosong atau mengandung angka 0
		$arrIsiJenisPembayaran 		= array_diff($arrIsiJenisPembayaran, [""]);
		$arrIsiKeteranganPembayaran = array_diff($arrIsiKeteranganPembayaran, [""]);
		$arrIsiKetPembayaran 		= array_diff($arrIsiKetPembayaran, [""]);
		$arrIsiJumlahBayar			= array_diff($arrIsiJumlahBayar, [0]);

		// Membuat Data Array Baru dari hasil menghapus data array yang kosong
		$arrDataBaruJenisPembayaran = array_values($arrIsiJenisPembayaran);
		$arrDataBaruKetPembayaran   = array_values($arrIsiKeteranganPembayaran);
		$arrDataBaruIsiKetPembyrn   = array_values($arrIsiKetPembayaran);
		$arrDataBaruJumlahBayar 	= array_values($arrIsiJumlahBayar);

		// var_dump($arrDataBaruKetPembayaran);exit;

		// var_dump($arrDataBaruIsiKetPembyrn);exit;

		$dbJenisPembayaran = [
			'data' => [
				'jenis_pembayaran' => $arrDataBaruJenisPembayaran,
				'keterangan' 	   => $arrDataBaruKetPembayaran,
				'bayar' 		   => $arrDataBaruJumlahBayar,
				'isi_jenis'        => substr($convertString, 0, -2),
			],
		];

		// echo $dbJenisPembayaran['data']['isi_jenis'];

		// foreach ($dbJenisPembayaran['data']['isi_jenis'] as $key) {
		// 	echo substr($key, 0, -2) . "<br>";
		// }

		// exit;
    } else {
    	echo "<center> <h1 style='margin-top: 280px;'>Tidak Ada Data Yang Di Kirim!</h1> </center>";
    	exit;
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Slip Pembayaran </title>
    <link rel="icon" type="image/x-icon" href="<?php echo $base; ?>imgstatis/favicon.jpg">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        #pangkat_2 {
        	font-size: 9px;
        }

        #isi_lain {
        	font-size: 13px;
        }

        #jenjangSekolah1 {
        	font-size: 23px;
        }

        #jenjangSekolah2 {
        	font-size: 23px;
        }

        #bulan {
        	margin-left: 0px;
        }

        .logo {
            max-width: 150px;
            margin-bottom: 10px;
        }

        .logos {
        	max-width: 300px;
        	margin-bottom: 10px;
        	float: right;
        }

        .footer {
        	margin-bottom: 180px;
        	margin-top: 30px;
        }

        .company-address {
            margin-bottom: 40px;
            text-align: center;
        }

        .user-details {
            margin-bottom: 20px;
        }

        .user-details input {
            padding: 8px;
            margin-bottom: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        #span_number_invoice {
        	margin-left: 20px;
        }

        #span_nama {
        	margin-left: 20px;
        }

        #span_nis {
        	margin-left: 40px;
        }

        #span_kelas {
        	margin-left: 13px;
        }

        #span_pembayaran {
        	margin-left: 1px;
        }

        #num_invoice {
        	width: 15%;
        	margin-left: 1%;
        }

        #nama {
        	width: 88.5%;
        	margin-left: 1%;
        }

        #nis {
        	width: 88.5%;
        	margin-left: 1%;
        }

        #kelas {
        	width: 88.5%;
        	margin-left: 1%;
        }

        #pembayaran {
        	width: 37.4%;
        	margin-left: 5px;
        }

        #pembayaran_bulan {
        	width: 85.63%;
        	margin-left: 5px;
        }

        .receipt {
            border-collapse: collapse;
            width: 100%;
        }

        .receipt th, .receipt td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .receipt th {
            background-color: #f2f2f2;
        }

        #terbilang {
        	border: 1px solid #ccc;
        	border-radius: 4px;
        	width: 100%;
        	padding-top: 10px;
			padding-right: 10px;
			padding-bottom: 10px;
			padding-left: 10px;
			width: 97%;
			margin-top: 10px;
			font-weight: bold;
			font-style: italic;
        }

        #terima_pembayaran {
        	border: 1px solid #ccc;
        	border-radius: 4px;
        	width: 100%;
        	padding-top: 10px;
			padding-right: 10px;
			padding-bottom: 10px;
			padding-left: 10px;
			width: 97%;
			margin-top: 10px;
			margin-bottom: 10px;
			font-weight: bold;
        }

        #total_rp {
        	float: right;
        }

        input {
        	font-weight: bold;
        }

        #span_pembayaran_bulan {
        	margin-left: 17px;
        }

        #total_bayar {
        	font-weight: bold;
        }

        #jns_byr {
        	width: 25%;
        }

        #title_payment {
        	font-size: 20px;
        	margin-top: 7%;
        }

        @media only screen and (max-width: 600px) {

        	#bulan {
        		margin-left: 0px;
        	}

        	#pangkat_2 {
        		font-size: 5px;
        	}

        	#isi_lain {
        		font-size: 8px;
        	}

            .container {
                margin: 10px;
                padding: 10px;
            }

            #total_rp {
            	font-size: 13px;
            	margin-top: 2px;
	        }

            .header {
                font-size: 24px;
            }

            #nama {
	        	width: 100%;
	        	margin-top: 10px;
	        	margin-left: 0px;
	        }

	        #menerima_pembayaran {
	        	font-size: 15px;
	        }

	        #pembayaran {
	        	width: 100%;
	        	margin-top: 10px;
	        	margin-left: 0px;
	        }

	        #pembayaran_bulan {
	        	width: 100%;
	        	margin-top: 10px;
	        	margin-left: 0px;
	        }

	        /*#terbilang {
	        	margin-top: 3px;
	        	padding: 10px 10px;
	        	width: 100%;
	        	height: 50px;
	        }*/

	        #terbilang {
	        	border: 1px solid #ccc;
	        	border-radius: 4px;
	        	width: 100%;
	        	padding-top: 10px;
				padding-right: 10px;
				padding-bottom: 10px;
				padding-left: 10px;
				width: 93%;
	        }

	        #terima_pembayaran {
	        	border: 1px solid #ccc;
	        	border-radius: 4px;
	        	width: 100%;
	        	padding-top: 10px;
				padding-right: 10px;
				padding-bottom: 10px;
				padding-left: 10px;
				width: 93%;
				margin-top: 10px;
				margin-bottom: 10px;
				font-weight: bold;
	        }

	        #nis {
	        	width: 100%;
	        	margin-top: 10px;
	        	margin-left: 0px;
	        }

	        #kelas {
	        	width: 100%;
	        	margin-top: 10px;
	        	margin-left: 0px;
	        }

            .logo {
                max-width: 100px;
                margin-bottom: 5px;
            }

            .receipt th, .receipt td {
                padding: 6px;
            }

            #title_payment {
            	font-size: 20px;
            	margin-top: 10%;
            }

            #alamat {
            	font-size: 13px;
            }

            #alamats {
            	font-size: 12px;
            }

            .logos {
	        	max-width: 150px;
	        	margin-bottom: 10px;
	        	margin-top: -15px;
	        	height: 70px;
	        	float: right;
	        }

	        .footer {
	        	margin-bottom: 110px;
	        	margin-top: 30px;
	        }

	        #span_nama {
	        	margin-left: 12px;
	        }

	        #span_nis {
	        	margin-left: 35px;
	        }

	        #span_kelas {
	        	margin-left: 14px;
	        }

	        #jns_byr {
	        	width: 110px;
	        	font-size: 10px;
	        }

	        #isi_jenis_pembayaran {
	        	font-size: 12px;
	        }

	        #isi_bayar {
	        	font-size: 10px;
	        }

	        #isi_keterangan {
	        	font-size: 10px;
	        }

	        #nominal_bayar {
	        	font-size: 13px;
	        }

	        #keterangan {
	        	font-size: 13px;
	        }

	        #total_bayar {
	        	font-size: 10px;
	        }

	        #isi_menerima_pembayaran {
	        	font-size: 14px
	        }

	        #num_invoice {
	        	width: 25%;
	        }

	        #total_id {
	        	font-size: 15px;
	        }

	        #jenjangSekolah1 {
	        	font-size: 28px;
	        }

	        #jenjangSekolah2 {
	        	font-size: 28px;
	        }

	        #batas {
	        	max-width: 100%;
	        	margin-left: auto;
	        	margin-right: auto;
	        }

        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img class="logo" src="logo_stempel.png" alt="Logo">
            <?php if ($_SESSION['c_accounting'] == 'accounting1'): ?>
            	<p id="batas" style="color: rgba(26, 18, 136, 1);"><strong id="jenjangSekolah1"> SEKOLAH DASAR AKHYAR INTERNATIONAL ISLAMIC SCHOOL </strong></p>
        	<?php elseif($_SESSION['c_accounting'] == 'accounting2'): ?>
            	<p id="batas" style="color: rgba(26, 18, 136, 1);"><strong id="jenjangSekolah2"> PRA AKHYAR USIA DINI </strong></p>
            <?php endif ?>
            
            <p id="alamat" style="color: rgba(26, 18, 136, 1);">Komplek Green View, Jl. Green View Blok E No.3-4-5,</p>
            <p id="alamats" style="color: rgba(26, 18, 136, 1);">Kel. Jaka Setia, Kec. Bekasi Selatan, Kota Bekasi, Jawa Barat 17147</p>
            <p id="alamat" style="color: rgba(26, 18, 136, 1);">Telp. 021-82772882</p>
        </div>
        <div class="company-address">
            <h1 id="title_payment" style="color: rgba(26, 18, 136, 1);"> SLIP PEMBAYARAN <span style="color: red;"> <?= $jenjangPendidikan; ?> </span> </h1>
        </div>

        <div class="user-details">
        	<label> NUMBER INVOICE <span id="span_number_invoice"> : </span> </label>
            <input id="num_invoice" type="text" placeholder="Name" readonly="" value="<?= $idInvoice; ?>">
            <br>
        	<label> NIS <span id="span_nis"> : </span> </label>
            <input id="nis" type="text" placeholder="Address" readonly="" value="<?= $nisSiswa; ?>">
        	<label> NAMA <span id="span_nama"> : </span> </label>
            <input id="nama" type="text" placeholder="Name" readonly="" value="<?= $namaSiswa; ?>">
        	<label> KELAS <span id="span_kelas"> : </span> </label>
            <input id="kelas" type="text" placeholder="Email" readonly="" value="<?= $kelasSiswa; ?>">
            <label id="menerima_pembayaran"> TELAH MENERIMA PEMBAYARAN <span id="span_pembayaran"> : </span> </label>
            <!-- <input id="pembayaran" type="text" placeholder="Email" readonly="" value=""> -->
            <div id="terima_pembayaran"> 
            	<center>
            		<span id="isi_menerima_pembayaran"> 
            			<?= $dbJenisPembayaran['data']['isi_jenis']; ?>
            		</span>
            	</center>
            </div>
            <label id="bulan">
             TANGGAL <span id="span_pembayaran_bulan"> : </span> </label>
            <input id="pembayaran_bulan" type="text" placeholder="Email" readonly="" value="<?= format_tanggal_indo($tglTf); ?>">
            <label id="menerima_pembayaran"> TERBILANG <span id="span_pembayaran"> : </span> </label>
            <div id="terbilang"> 
            	<center>
            		<span id="isi_terbilang"> "<?= $terbilang; ?>" </span>
            	</center>
            </div>
        </div>

        <table class="receipt">
            <thead>
                <tr>
                    <th id="jns_byr"> JENIS PEMBAYARAN </th>
                    <th id="keterangan"> KETERANGAN </th>
                    <th id="nominal_bayar"> BAYAR </th>
                </tr>
            </thead>

            <tbody>
            	<?php  
            		for ($i=0; $i < count($dbJenisPembayaran['data']['jenis_pembayaran']); $i++) { 
            			echo "
            			<tr>
            				<td id = 'isi_jenis_pembayaran' >" . $dbJenisPembayaran['data']['jenis_pembayaran'][$i] . "</td>
            				<td id = 'isi_jenis_pembayaran' >" . $dbJenisPembayaran['data']['keterangan'][$i] . "</td>
            				<td id = 'isi_jenis_pembayaran' >" . $dbJenisPembayaran['data']['bayar'][$i] . "</td>
            			</tr>
            			";
            	?>

            	<?php  
            		}
            	?>
            	<tr>
                    <td colspan="2" style="font-weight: bold;"> <span id="total_id"> Total : <span id="total_rp"> Rp </span> </td>
                    <td id="total_bayar"> <?= $totalNominalJumlahBayar; ?> </td>
                </tr>

            </tbody>
        </table>

        <div class="footer">
            <img class="logos" src="stempel.jpg" alt="Logo">
        </div>

    </div>
</body>
</html>