<?php  

	require '../php/config.php';

	// ['pangkal'] => ['PANGKAL', 'UANG PANGKAL', 3000000], 
	// ['regis'] => ['Registrasi', 'DAFTAR ULANG KELAS 1 SD', 10000000]
	// ['spp'] => ['SPP', 'SPP MEI', 1000000]

	// "jenis_pembayaran" 	=> ["SPP", "PANGKAL", "Registrasi"], 
	// 	"keterangan" 		=> ["SPP BULAN MEI", "UANG PANGKAL 1", "DAFTAR ulang kelas 1 sd"], 
	// 	"bayar" 			=> [1000000, 3500000, 10000000],

	$nisSiswa          = $_POST['cetak_kuitansi_nis_siswa'];
    $namaSiswa         = $_POST['cetak_kuitansi_nama_siswa'];
    $kelasSiswa        = $_POST['cetak_kuitansi_kelas_siswa'];
    $idInvoice         = $_POST['cetak_kuitansi_id_invoice'];
    $tglTf             = $_POST['cetak_kuitansi_bukti_tf'];
    $bayarBulan        = $_POST['cetak_kuitansi_bulan_pembayaran'];

    $isiUangSPP        = $_POST['cetak_kuitansi_uang_spp'];
    $isiUangPangkal    = $_POST['cetak_kuitansi_uang_pangkal'];
    $isiUangKegiatan   = $_POST['cetak_kuitansi_uang_kegiatan'];
    $isiUangBuku       = $_POST['cetak_kuitansi_uang_buku'];
    $isiUangSeragam    = $_POST['cetak_kuitansi_uang_seragam'];
    $isiUangRegis      = $_POST['cetak_kuitansi_uang_registrasi'];
    $isiUangLain       = $_POST['cetak_kuitansi_uang_lain'];

	$arrIsiJenisPembayaran = [];
	$arrIsiJumlahBayar 	   = [];

	$jenisPembayaranSPP       = $_POST['jenisPembayaranSPP'];
	$jenisPembayaranPangkal   = $_POST['jenisPembayaranPangkal'];
	$jenisPembayaranKegiatan  = $_POST['jenisPembayaranKegiatan'];
	$jenisPembayaranBuku  	  = $_POST['jenisPembayaranBuku'];
	$jenisPembayaranSeragam   = $_POST['jenisPembayaranSeragam'];
	$jenisPembayaranRegis  	  = $_POST['jenisPembayaranRegistrasi'];
	$jenisPembayaranLain  	  = $_POST['jenisPembayaranLain'];

	// echo $jenisPembayaranPangkal;exit;

	if ($jenisPembayaranSPP != 0 && $jenisPembayaranPangkal == 0 && $jenisPembayaranKegiatan == 0 && $jenisPembayaranBuku == 0 && $jenisPembayaranSeragam == 0 && $jenisPembayaranRegis == 0 && $jenisPembayaranLain == 0) {
    	$jenisPembayaranSPP = "SPP";
    	$jenisPembayaranPangkal = "";
		$jenisPembayaranKegiatan = "";
		$jenisPembayaranBuku = "";
		$jenisPembayaranSeragam = "";
		$jenisPembayaranRegis = "";
		$jenisPembayaranLain = "";
    } else if ($jenisPembayaranSPP == 0 && $jenisPembayaranPangkal != 0 && $jenisPembayaranKegiatan == 0 && $jenisPembayaranBuku == 0 && $jenisPembayaranSeragam == 0 && $jenisPembayaranRegis == 0 && $jenisPembayaranLain == 0) {
    	$jenisPembayaranSPP = "";
    	$jenisPembayaranPangkal = "PANGKAL";
    	$jenisPembayaranKegiatan = "";
		$jenisPembayaranBuku = "";
		$jenisPembayaranSeragam = "";
		$jenisPembayaranRegis = "";
		$jenisPembayaranLain = "";
    } else if ($jenisPembayaranSPP == 0 && $jenisPembayaranPangkal == 0 && $jenisPembayaranKegiatan != 0 && $jenisPembayaranBuku == 0 && $jenisPembayaranSeragam == 0 && $jenisPembayaranRegis == 0 && $jenisPembayaranLain == 0) {
    	$jenisPembayaranSPP = "";
    	$jenisPembayaranPangkal = "";
		$jenisPembayaranKegiatan  = "KEGIATAN";
		$jenisPembayaranBuku = "";
		$jenisPembayaranSeragam = "";
		$jenisPembayaranRegis = "";
		$jenisPembayaranLain = "";
    } else if ($jenisPembayaranSPP == 0 && $jenisPembayaranPangkal == 0 && $jenisPembayaranKegiatan == 0 && $jenisPembayaranBuku != 0 && $jenisPembayaranSeragam == 0 && $jenisPembayaranRegis == 0 && $jenisPembayaranLain == 0) {
    	$jenisPembayaranSPP = "";
    	$jenisPembayaranPangkal = "";
		$jenisPembayaranKegiatan  = "";
		$jenisPembayaranBuku  	  = "BUKU";
		$jenisPembayaranSeragam = "";
		$jenisPembayaranRegis = "";
		$jenisPembayaranLain = "";
    } else if ($jenisPembayaranSPP == 0 && $jenisPembayaranPangkal == 0 && $jenisPembayaranKegiatan == 0 && $jenisPembayaranBuku == 0 && $jenisPembayaranSeragam != 0 && $jenisPembayaranRegis == 0 && $jenisPembayaranLain == 0) {
		$jenisPembayaranSeragam   = "SERAGAM";
    } else if ($jenisPembayaranRegis != 0) {
		$jenisPembayaranRegis  	  = "REGISTRASI";
    } else if ($jenisPembayaranLain != 0) {
    	$jenisPembayaranLain  	  = "LAIN2/INFAQ/SUMBANGAN/ANTAR JEMPUT";
    } else {

    	$jenisPembayaranSPP = "";
		$jenisPembayaranPangkal = "";
		$jenisPembayaranKegiatan = "";
		$jenisPembayaranBuku = "";
		$jenisPembayaranSeragam = "";
		$jenisPembayaranRegis = "";
		$jenisPembayaranLain = "";

    }

    if ($isiUangSPP != '') {
    	$isiUangSPP; 
    } else if ($isiUangPangkal != "") {
    	$isiUangPangkal;
    } else if ($isiUangKegiatan != "") {
    	$isiUangKegiatan;
    } else if ($isiUangBuku != "") {
    	$isiUangBuku;
    } else if ($isiUangSeragam != "") {
    	$isiUangSeragam;
    } else if ($isiUangRegis != "") {
    	$isiUangRegis;
    } else if ($isiUangLain != "") {
    	$isiUangLain;
    } else {

    	$isiUangSPP 		= "";
    	$isiUangPangkal 	= "";
    	$isiUangKegiatan 	= "";
    	$isiUangBuku 		= "";
    	$isiUangSeragam 	= "";
    	$isiUangRegis 		= "";
    	$isiUangLain 		= "";

    }

    $arrIsiJenisPembayaran[] = $jenisPembayaranSPP;
    $arrIsiJenisPembayaran[] = $jenisPembayaranPangkal;
    $arrIsiJenisPembayaran[] = $jenisPembayaranKegiatan;
    $arrIsiJenisPembayaran[] = $jenisPembayaranBuku;
    $arrIsiJenisPembayaran[] = $jenisPembayaranSeragam;
    $arrIsiJenisPembayaran[] = $jenisPembayaranRegis;
    $arrIsiJenisPembayaran[] = $jenisPembayaranLain;

	$arrIsiJumlahBayar[] = $isiUangSPP;
	$arrIsiJumlahBayar[] = $isiUangPangkal;
	$arrIsiJumlahBayar[] = $isiUangKegiatan;
	$arrIsiJumlahBayar[] = $isiUangBuku;
	$arrIsiJumlahBayar[] = $isiUangSeragam;
	$arrIsiJumlahBayar[] = $isiUangRegis;
	$arrIsiJumlahBayar[] = $isiUangLain;

	var_dump($arrIsiJenisPembayaran);exit;

	$dbJenisPembayaran = [
		'data' => [
			'jenis_pembayaran' => $arrIsiJenisPembayaran,
			'keterangan' 	   => ["spp mei", "pangkal mei", "daftar ulang"],
			'bayar' 		   => $arrIsiJumlahBayar
		],
	];

	// exit;

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

        #bulan {
        	margin-left: 5px;
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
            margin-bottom: 20px;
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
        	width: 85.6%;
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

        label {
        	font-weight: bold;
        }

        #span_pembayaran_bulan {
        	margin-left: 12px;
        }

        #total_bayar {
        	font-weight: bold;
        }

        #jns_byr {
        	width: 25%;
        }

        @media only screen and (max-width: 600px) {

        	#bulan {
        		margin-left: 0px;
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

        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img class="logo" src="logo_stempel.png" alt="Logo">
            <p id="alamat" style="color: rgba(26, 18, 136, 1);">Komplek Green View, Jl. Green View Blok E No.3-4-5,</p>
            <p id="alamats" style="color: rgba(26, 18, 136, 1);">Kel. Jaka Setia, Kec. Bekasi Selatan, Kota Bekasi, Jawa Barat 17147</p>
            <p id="alamat" style="color: rgba(26, 18, 136, 1);">Telp. 021-82772882</p>
        </div>
        <div class="company-address">
            <h1 id="title_payment" style="color: rgba(26, 18, 136, 1);"> SLIP PEMBAYARAN <span style="color: red;"> SD </span> </h1>
        </div>

        <div class="user-details">
        	<label> NUMBER INVOICE <span id="span_number_invoice"> : </span> </label>
            <input id="num_invoice" type="text" placeholder="Name" readonly="" value="23123">
            <br>
        	<label> NAMA <span id="span_nama"> : </span> </label>
            <input id="nama" type="text" placeholder="Name" readonly="" value="MUHAMMAD JANOKO ASMAYODHA CAHYONO">
        	<label> NIS <span id="span_nis"> : </span> </label>
            <input id="nis" type="text" placeholder="Address" readonly="" value="3612831">
        	<label> KELAS <span id="span_kelas"> : </span> </label>
            <input id="kelas" type="text" placeholder="Email" readonly="" value="1 SD">
            <label id="menerima_pembayaran"> TELAH MENERIMA PEMBAYARAN <span id="span_pembayaran"> : </span> </label>
            <!-- <input id="pembayaran" type="text" placeholder="Email" readonly="" value=""> -->
            <div id="terima_pembayaran"> 
            	<center>
            		<span id="isi_menerima_pembayaran"> SPP, Registrasi, Pangkal, Kegiatan, Buku, Seragam, Lain - Lain </span>
            	</center>
            </div>
            <label id="bulan">
             TANGGAL <span id="span_pembayaran_bulan"> : </span> </label>
            <input id="pembayaran_bulan" type="text" placeholder="Email" readonly="" value="31 DESEMBER 2024">
            <label id="menerima_pembayaran"> TERBILANG <span id="span_pembayaran"> : </span> </label>
            <div id="terbilang"> 
            	<center>
            		<span id="isi_terbilang"> "Delapan Ratus Tiga Puluh Tujuh Ribu Enam Ratus Delapan Puluh Satu Rupiah" </span>
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
            <!-- <tbody>


                <tr>
                    <td id="isi_jenis_pembayaran"> SPP </td>
                    <td id="isi_keterangan">SPP Bulan Mei</td>
                    <td id="isi_bayar">Rp 1.000.000</td>
                </tr>
                <tr>
                    <td id="isi_jenis_pembayaran">Registrasi/Daftar Ulang</td>
                    <td id="isi_keterangan">Daftar Ulang Kelas 2</td>
                    <td id="isi_bayar">Rp 2.000.000</td>
                </tr>
                <tr>
                    <td id="isi_jenis_pembayaran">Pangkal</td>
                    <td id="isi_keterangan">uang Pangkal jsdnaskdsa</td>
                    <td id="isi_bayar">Rp 1.000.000</td>
                </tr>
                <tr>
                    <td colspan="2" style="font-weight: bold;">Total: <span id="total_rp"> Rp. </span> </td>
                    <td id="total_bayar">14.981.379</td>
                </tr>
            </tbody> -->
            <tbody>
            	<?php  
            		for ($i=0; $i < count($dbJenisPembayaran['data']); $i++) { 
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
                    <td colspan="2" style="font-weight: bold;">Total: <span id="total_rp"> Rp. </span> </td>
                    <td id="total_bayar">14.981.379</td>
                </tr>
        		<!-- <?php foreach ($dbJenisPembayaran['jenis_pembayaran'] as $data => $Y): ?>
        		<tr>
        			<td id="isi_jenis_pembayaran"> <?= $Y; ?> </td>
        			<td id="isi_jenis_pembayaran"> <?= $Y; ?> </td>
        			<td id="isi_jenis_pembayaran"> <?= $Y; ?> </td>
        		</tr>
        		<?php endforeach ?> -->
            </tbody>
        </table>

        <div class="footer">
            <img class="logos" src="stempel.jpg" alt="Logo">
        </div>

    </div>
</body>
</html>