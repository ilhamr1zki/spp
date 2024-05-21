<?php  

	$isifilby       = 'kosong';

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

    if ($_SESSION['c_accounting'] == 'accounting1') {

    	$dataSiswa = mysqli_query($con, "SELECT * FROM data_murid_sd");	

    }

?>

<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Form Edit Data Pembayaran </h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
       
    </div>

    <form action="editdata" method="post">
        <div class="box-body">

            <div class="row">

                <div class="col-sm-4">
                    <div class="form-group">
                        <label>ID Siswa</label>
                        <input type="text" class="form-control" value="" name="id_siswa" id="id_siswa" readonly="">
                    </div>
                </div>
                
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>NIS</label>
                        <input type="text" class="form-control" value="" name="nis_siswa" id="nis_siswa" readonly="">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Nama Siswa</label>
                        <input type="text" name="nama_siswa" class="form-control" value="" id="nama_siswa" readonly/>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Kelas</label>
                        <input type="text" name="kelas_siswa" class="form-control" value="" id="kelas_siswa" readonly/>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Panggilan</label>
                        <input type="text" class="form-control" id="panggilan_siswa" value="" name="panggilan_siswa" readonly />
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

                                <?php if ($filby == 'LAIN'): ?>

                                    <option value="<?= $filby; ?>" > LAIN - LAIN </option>

                                <?php else: ?>

                                    <option value="<?= $filby; ?>" > <?= $filby; ?> </option>
                                    
                                <?php endif; ?>

                            <?php endforeach; ?>
                        </select>
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
     
    <div style="overflow-x: auto; margin: 10px;">                         
	    <table id="example1" class="table table-bordered">
	        <thead>
	          <tr>
	            <th style="text-align: center; width: 5%;"> NUMBER INVOICE </th>
	            <th style="text-align: center; width: 1%;"> NIS </th>
	            <th style="text-align: center; width: 10%;"> NAMA </th>
	            <th style="text-align: center; width: 3%;"> KELAS </th>
	            <th style="text-align: center; width: 5%;"> SPP </th>
	            <th style="text-align: center; width: 6%;"> PEMBAYARAN BULAN </th>
	            <th style="text-align: center; width: 7%;"> KET SPP </th>
	            <th style="text-align: center; width: 2%;"> TRANSAKSI </th>
	            <th style="text-align: center; width: 4%;"> DI INPUT OLEH </th>
	            <th style="text-align: center; width: 6%;"> STAMP </th>
	            <th style="text-align: center; width: 1%;"> ACTION </th>
	          </tr>
	        </thead>
	        <tbody>

	            <tr>
	                <td style="text-align: center;"> 123 </td>
	                <td style="text-align: center;"> 3172321 </td>
	                <td style="text-align: center;"> TES23 </td>
	                <td style="text-align: center;"> 5 SD </td>
	                <td style="text-align: center;"> rP 1,000,0000 </td>
	                <td style="text-align: center;"> MEI 2024 </td>
	                <td style="text-align: center;"> SPP mei 2024 </td>
	                <td style="text-align: center;"> TRANSFER </td>
	                <td style="text-align: center;"> ILHAM </td>
	                <td style="text-align: center;"> 20 Mei 2024 16:00:10 </td>
	            	<td style="text-align: center; justify-content: center;" id="tombol-cetak">

	                    <form action="<?= $baseac; ?>Kuitansi.php" method="POST" target="_blank">
	                        <button id="cetak_kuitansi" name="cetak_kuitansi" class="btn btn-sm btn-success btn-circle"> 
	                            Edit 
	                        </button>
	                    </form>

	                </td>
	            </tr>

	        </tbody>

	    </table>
	</div>
        
</div>

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
                              <!-- <th style="text-align: center;" width="3%">NO</th> -->
                              <th style="text-align: center; width: 5%;">NIS</th>
                              <th style="text-align: center;">NAMA</th>
                              <th style="text-align: center;">KELAS</th>
                            </tr>
                        </thead>
                        <tbody>
                        	<?php foreach ($dataSiswa as $siswa): ?>
	                            <tr onclick="OnSiswaSelectedModal(
	                            	''
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

</script>