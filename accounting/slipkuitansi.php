<?php  

	require '../php/config.php';

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
        	margin-left: 10px;
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

        #span_nama {
        	margin-left: 20px;
        }

        #span_nis {
        	margin-left: 39px;
        }

        #span_kelas {
        	margin-left: 14px;
        }

        #span_pembayaran {
        	margin-left: 1px;
        }

        #nama {
        	width: 89%;
        	margin-left: 1%;
        }

        #nis {
        	width: 89%;
        	margin-left: 1%;
        }

        #kelas {
        	width: 89%;
        	margin-left: 1%;
        }

        #pembayaran {
        	width: 16.3%;
        	margin-left: 10px;
        }

        #pembayaran_bulan {
        	width: 38.6%;
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

        #total_rp {
        	float: right;
        }

        label {
        	font-weight: bold;
        }

        #total_bayar {
        	font-weight: bold;
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

	        #isi_terbilang {
	        	font-size: 14px
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
        	<label> NUMBER INVOICE <span id="span_nama"> : </span> </label>
            <input id="nama" type="text" placeholder="Name" readonly="" value="23123">
        	<label> NAMA <span id="span_nama"> : </span> </label>
            <input id="nama" type="text" placeholder="Name" readonly="" value="MUHAMMAD JANOKO ASMAYODHA CAHYONO">
        	<label> NIS <span id="span_nis"> : </span> </label>
            <input id="nis" type="text" placeholder="Address" readonly="" value="3612831">
        	<label> KELAS <span id="span_kelas"> : </span> </label>
            <input id="kelas" type="text" placeholder="Email" readonly="" value="1 SD">
            <label id="menerima_pembayaran"> TELAH MENERIMA PEMBAYARAN <span id="span_pembayaran"> : </span> </label>
            <input id="pembayaran" type="text" placeholder="Email" readonly="" value="Registrasi">
            <label id="bulan">
             BULAN <span id="span_pembayaran_bulan"> : </span> </label>
            <input id="pembayaran_bulan" type="text" placeholder="Email" readonly="" value="DESEMBER 2024">
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
            <tbody>
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
                    <td colspan="2">Total: <span id="total_rp"> Rp. </span> </td>
                    <td id="total_bayar">14.981.379</td>
                </tr>
            </tbody>
        </table>

        <div class="footer">
            <img class="logos" src="stempel.jpg" alt="Logo">
        </div>

    </div>
</body>
</html>