<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kwitansi</title>
    <style>

        body {
            font-family: Arial, sans-serif;
            background-color: white;
        }

        .container {
            width: 70%;
            margin-top: 50px !important;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: white;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        #kw {
            margin-left: 385px;
            font-size: 20px;
            color: rgba(26, 18, 136, 1);
        }

        .header h1 {
            margin: 0;
        }

        .flex-container1 {
          display: flex;
          justify-content: center;
        }

        hr.new1 {
            width: 400px;
            margin-left: 10px;
            border-top: 3px solid black;
        }

        .flex-container1 > div {
/*          border: 1px solid black;*/
          margin: 10px;
          width: 50%;
/*          padding: 20px;*/
        }

        .details {
            margin-bottom: 20px;
        }

        .details p {
            margin: 5px 0;
        }

        .item-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .item-table th,
        .item-table td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        .item-table th {
            background-color: #f2f2f2;
        }

        .total {
            text-align: right;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        <div style="display: flex;">
            <div class="foto">
                <img src="<?= $base; ?>imgstatis/logo_stempel.png" style="width: 70px; height: 70px;">
            </div>
            <div class="kop-surat" style="color: rgba(26, 18, 136, 1);">
                <strong style="margin-left: 120px;">
                    <b>
                    SEKOLAH DASAR
                    </b>
                    <br>
                </strong>
                <strong style="margin-left: 15px;">
                    <b>
                    AKHYAR INTERNATIONAL ISLAMIC SCHOOL
                    </b>
                </strong>
                <p style="color: rgba(26, 18, 136, 1); font-size: 10px; margin-left: 80px;"> Komplek Green View, Jl. Green View Blok E No.3-4-5, <br></p>
                <p style="color: rgba(26, 18, 136, 1); font-size: 10px; margin-left: 43px;"> Kel. Jaka Setia, Kec. Bekasi Selatan, Kota Bekasi, Jawa Barat 17147 <br></p>
                <p style="color: rgba(26, 18, 136, 1); font-size: 10px; margin-left: 141px; margin-top: -10px;"> Telp. 021-82772882 <span id="kw"> <strong> KWITANSI PEMBAYARAN </strong> </span> <span style="color: red; font-size: 20px;"> <strong> <b> SD </b> </strong> </span> </p>
            </div>
        </div>

        <!-- <div class="details">
            <p> NIS  <span style="margin-left: 30px;"></span> : <span style="margin-left: 20px;">  </span> 202102106 </p>
            <p> NAMA  <span style="margin-left: 10px;"></span> : <span style="margin-left: 20px;">  </span> UWAIS AHZA RABBANI </p>
            <p> KELAS  <span style="margin-left: 5px;"></span> : <span style="margin-left: 20px;">  </span> 3 SD </p>
        </div> -->

        <div class="flex-container1">

            <div style="width: 80%;">
            
                <div>

                    <div class="details">
                        <p> NIS <span style="margin-left: 30px;"></span> : <span style="margin-left: 20px;">  </span> <strong> 202102106 </strong> </p>
                        <!-- <p> NAMA  <span style="margin-left: 10px;"></span> : <span style="margin-left: 20px;">  </span> AIDIL HAMIZAN IBRAHIM PUSPANEGARA </p> -->
                        <p> NAMA  <span style="margin-left: 10px;"></span> : <span style="margin-left: 20px;"> </span> <strong> UWAIS AHZA RABBANI </strong> </p>
                        <p> KELAS  <span style="margin-left: 5px;"></span> : <span style="margin-left: 20px;"> </span> <strong> 3 SD </strong> </p>
                    </div>
                    
                </div>

            </div>

            <div>

                <div>

                    <div class="details">
                        <p> <strong> TAHUN AJARAN </strong> <span style="margin-left: 30px;"></span> : <span style="margin-left: 20px;">  </span>  </p>
                    </div> 
                    
                </div>

            </div>

            <div>
            
                <div>

                    <div class="details">
                        <p> NO <span style="margin-left: 42px;"></span> : <span style="margin-left: 20px;"> </span> <strong> 4724 </strong> </p>
                        <p> Tanggal  <span style="margin-left: 10px;"></span> : <span style="margin-left: 20px;"> </span> <strong> 23-Feb-24 </strong> </p>
                        <p> Bulan  <span style="margin-left: 25px;"></span> : <span style="margin-left: 20px;"> </span> <strong> MARET 2024 </strong> </p>
                    </div>
                    
                </div>

            </div>  

        </div>

        <div class="flex-container1" style="margin-top: -35px; margin-left: 0px;">

            <div style="width: 100%;">
            
                <div>

                    <div class="details">
                        <p> <strong> Terbilang </strong> <span style="margin-left: 3px;"></span> : <input type="text" style="text-align: center; width: 90%; font-weight: bold; font-style: italic;" value='"Tiga Juta Sembilan Ratus Sembilan Puluh Sembilan Ribu Sembilan Ratus Sembilan Puluh Sembilan Rupiah"' name=""> </p>
                    </div>
                    
                </div>

            </div>

        </div>

        <div class="flex-container1">

            <div style="width: 25%;">
            
                <div>

                    <div class="details">
                        <p> <strong> Untuk Pembayaran </strong> <span style="margin-left: 30px;"></span> :  </p>
                    </div>
                    
                </div>

            </div>

            <div style="margin-top: 16px;">

                <div>

                    <div class="details">
                        <strong> 
                            1. Uang SPP
                        </strong> 
                        <span style="margin-left: 59px;"> </span> <strong> Rp. </strong> <span style="margin-left: 4px;"></span> <input type="text" value="3,999,999" style="text-align: end; font-weight: bold; width: 25%;" name="">
                    </div>

                    <div class="details">
                        <strong>
                            2. Uang Pangkal 
                        </strong>
                        <span style="margin-left: 28px;"> </span> <strong> Rp. </strong> <span style="margin-left: 5px;"></span> <input type="text" value="0" style="font-weight: bold; text-align: end; width: 25%;" name="">
                    </div>

                    <div class="details">
                        <strong>
                            3. Uang Kegiatan 
                        </strong>
                        <span style="margin-left: 22px;">  </span> <strong> Rp. </strong> <span style="margin-left: 5px;"></span> <input type="text" value="0" style="font-weight: bold; text-align: end; width: 25%;" name="">
                    </div>

                    <div class="details">
                        <strong> 
                            4. Uang Buku 
                        </strong>
                        <span style="margin-left: 49px;">  </span> <strong> Rp. </strong> <span style="margin-left: 5px;"></span> <input type="text" value="0" style="text-align: end; font-weight: bold; width: 25%;" name="">
                    </div>

                    <div class="details">
                        <strong> 
                            5. Uang Seragam 
                        </strong>
                        <span style="margin-left: 21px;">  </span> <strong> Rp. </strong> <span style="margin-left: 5px;"></span> <input type="text" value="0" style="font-weight: bold; text-align: end; width: 25%;" name="">
                    </div>

                    <div class="details">
                        <strong> 
                            6. Uang Registrasi 
                        </strong>
                        <span style="margin-left: 11px;"> </span> <strong> Rp. </strong> <span style="margin-left: 5px;"></span> <input type="text" value="0" style="font-weight: bold; text-align: end; width: 25%;" name="">
                    </div>

                    <div class="details">
                        <strong> 
                            7. Uang Lain-lain 
                        </strong>
                        <span style="margin-left: 23px;"> </span> <strong> Rp. </strong> <span style="margin-left: 5px;"></span> <input type="text" value="0" style="font-weight: bold; text-align: end; width: 25%;" name="">
                    </div> 
                    
                </div>

            </div>

            <div style="margin-top: 16px;">

                <div>

                    <div class="details">
                        <input type="text" value="SPP 3 SD - MARET 2024" name="" style="margin-left: -110px; width: 131%; font-weight: bold;">
                    </div>

                    <div class="details">
                        <input type="text" name="" style="margin-left: -110px; width: 131%; font-weight: bold;">
                    </div>

                    <div class="details">
                        <input type="text" name="" style="margin-left: -110px; width: 131%; font-weight: bold;">
                    </div>

                    <div class="details">
                        <input type="text" name="" style="margin-left: -110px; width: 131%; font-weight: bold;">
                    </div>

                    <div class="details">
                        <input type="text" name="" style="margin-left: -110px; width: 131%; font-weight: bold;">
                    </div>

                    <div class="details">
                        <input type="text" name="" style="margin-left: -110px; width: 131%; font-weight: bold;">
                    </div>

                    <div class="details">
                        <input type="text" name="" style="margin-left: -110px; width: 131%; font-weight: bold;">
                    </div> 
                    
                </div>

            </div>  

        </div>

        <!-- Jumlah -->
        <hr class="new1" />

        <div class="flex-container1" style="margin-top: -15px; margin-left: -98px;">

            <div style="width: 24%; margin-left: -50px;">
            
                <div>

                    <div class="details">
                        <p> <strong> Jumlah  <span style="margin-left: 30px;"></span> Rp. </strong> 
                    </div>
                    
                </div>

            </div>

            <div>

                <div>

                    <div class="details">
                        <input type="text" value="3,999,999,00" name="" style="margin-top: 5px; text-align: end; margin-left: -100px; font-weight: bold; width: 200px;">
                    </div> 
                    
                </div>

            </div>

        </div>        

        <hr class="new1" / style="margin-top: -20px;">

        <!-- Akhir Jumlah -->

        <div class="flex-container1" style="margin-top: -15px;">

            <div style="width: 38%;">
            
                <div>

                    <div class="details">
                    </div>
                    
                </div>

            </div>

            <div>

                <div>

                    <div class="details">
                    </div> 
                    
                </div>

            </div>

            <div style="margin-top: -4px;">
            
                <div>

                    <div class="details">
                        <fieldset>
                          <legend> Bekasi, 23-Feb-24 </legend>
                          <div class="ksg" style="display: flex;">
                            <div class="logos" style="margin-top: 5px;">
                                <img src="<?= $base; ?>imgstatis/logo_stempel.png" width="75" height="75">  
                            </div>
                            <div class="stempel">
                                <img src="<?= $base; ?>imgstatis/stempel.jpg" style="margin-left: 10px;" width="210" height="90">
                            </div>
                          </div>
                        </fieldset>
                    </div>
                    
                </div>

            </div>  

        </div>

        <div class="flex-container1" style="margin-top: -75px;margin-left: 15px;">

            <div style="width: 38%;">
            
                <div>

                    <div class="details">
                        Lembar 1: untuk Siswa
                    </div>
                    
                </div>

            </div>

            <div>

                <div>

                    <div class="details">
                    </div> 
                    
                </div>

            </div>

            <div style="margin-top: -4px;">
            
                <div>

                    <div class="details">
                    </div>
                    
                </div>

            </div>  

        </div>

    </div>
</body>

</html>