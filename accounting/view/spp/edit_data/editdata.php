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

    $isifilby       = 'kosong';
    $tanggalDari    = 'kosong_tgl1';
    $tanggalSampai  = 'kosong_tgl2';

     function rupiah($angka){
    
        $hasil_rupiah = "Rp " . number_format($angka,2,',','.');
        return $hasil_rupiah;
     
    }

    $setSesiPageFilterBy = 0; 
    $setSesiFormEdit     = 0;

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

        if ($typeFilter == 'SPP') {

            $setSesiFormEdit    = 1;

            $idInvoice          = $_POST['id_invoice'];
            $tglPembayaran      = $_POST['tgl_bukti_pembayaran'];
            $pembayaranBulan    = $_POST['pembayaran_bulan'];
            $nominalBayar       = $_POST['nominal_bayar'];
            $ketPembayaran      = $_POST['ket_pembayaran'];
            $pembayaranVIA      = $_POST['tipe_transaksi'];

        }


        // echo "Ada edit";exit;
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
    
        <?php echo "Halaman Siap Edit"; ?>

        <div class="box box-info">
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

            </div>
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