<?php 

    $getDataJuz = mysqli_query($con, "SELECT * FROM tbl_juz where parentid = 0 order by seqjuz, id ASC "); 
    
    $getDatasurah = mysqli_query($con, 
        "SELECT * FROM kumpulan_surah ORDER BY id"
    );

?>

<script language="javascript" type="text/javascript">
    var _id = 0;

    function OpenEdit(id, nm, seq, parentval, parennm) {
        _id = id;
        $('#idjuzedit').val(_id);
        $('#isijuzedit').val(nm);
        $('#seqjuzedit').val(seq);
        $('#idparentjuzedit').val(parentval)

        //alert(parennm);

        $('#editmjuz').modal("show");
    }

    function OpenEditKetSurah(id, nm, seq, parentval, parennm) {
        _id = id;
        $('#idketsurahedit').val(_id);
        $('#ketsurahedit').val(nm);
        $('#seqketsurahedit').val(seq);
        $('#idparentjuzketedit').val(parentval);

        //alert(parennm);

        $('#editmketsurah').modal("show");
    }

    function OpenEditSementara() {
        $('#editmjuz').modal("show");
    }

    function OpenAddModal(){
        $('#_nmjilidadd').val('');
        $('#_seqjilidadd').val(0);

        $('#addmjuz').modal("show");
        document.getElementById("juz").focus();
    }

    function OpenDeleteModal(id){
        _id = id;

        $('#idhapusjuz').val(id);
        $('#hapusmjuz').modal("show");
    }
    function GetId()
    {
        return _id;
    }
</script>

<style type="text/css">
    
    .formAddJuz,
    .formAddIsiSurah,
    .formKeteranganAyat,
    .formKeteranganAyatSrhAwal,
    .formKeteranganAyatSrhAkhir {
      margin:10px;
    }

    .keteranganAyatSrhAwl,
    .keteranganAyatSrhAkr {
        width: 105%;
    }

    @media only screen and (max-width: 600px) {

      .keteranganAyat {
        width: 100%
      }

    }

    .juz {
      /*padding:5px;*/
      /*width:250px;*/
      border: #cdcdcd solid 1px;
      box-shadow: inset 1px 1px 3px #f6f6f6;
      -moz-box-shadow: inset 1px 1px 3px #f6f6f6;
      -webkit-box-shadow: inset 1px 1px 3px #f6f6f6;
    }

    .juz:focus {
      outline:none;
      border-color: #3da6ff;
      box-shadow: 0 0 0 transparent;
      -moz-box-shadow: 0 0 0 transparent;
      -webkit-box-shadow: 0 0 0 transparent;
      color: #333;
    }

    #errmsg {
      background : #ff5757;
      color :#fff;
      padding :4px;
      display :none;
      width : 250px;
    }

</style>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">

    <?php if(isset($_SESSION['pesan']) && $_SESSION['pesan']=='tambah'){?>
          <div style="display: none;" class="alert alert-warning alert-dismissable">Data Juz Berhasil Disimpan
             <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
             <?php unset($_SESSION['pesan']); ?>
          </div>
        <?php } ?>

        <?php if(isset($_SESSION['pesan']) && $_SESSION['pesan']=='edit'){?>
          <div style="display: none;" class="alert alert-info alert-dismissable">Data Juz Berhasil Diedit
             <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
             <?php unset($_SESSION['pesan']); ?>
          </div>
        <?php } ?>

        <?php if(isset($_SESSION['pesan']) && $_SESSION['pesan']=='hapus'){?>
          <div style="display: none;" class="alert alert-success alert-dismissable">Data Juz Berhasil Dihapus
             <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
             <?php unset($_SESSION['pesan']); ?>
          </div>
        <?php } ?>

    </div>
</div>

<?php $_SESSION['pesan'] = '';?>

<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title"> <i class="glyphicon glyphicon-calendar"></i> Data Juz</h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenAddModal()"><i class="glyphicon glyphicon-plus"></i> Tambah Juz</a></span>
    </div>

    <div class="box-body table-responsive">
            <table id="masterJuzxs" class="table table-bordered table-hover">
            <thead>
            <tr>
                <th width="5%">NO</th>
                <th>JUZ</th>
                <th>Urutan</th>
                <th style="text-align:center;">OPSI</th>
            </tr>
            </thead>
            <tbody>

                <?php  

                    $nomer = 1;

                    while ($data = mysqli_fetch_array($getDataJuz)) {

                ?>

                <tr>
                  <td> <?= $nomer; ?> </td>
                  <td>  <?= $data['juz_atau_keterangan_ayat']; ?> </td>
                  <td> <?= $data['seqjuz']; ?> </td>
                  <td align="center">
  
                    <a class="btn btn-circle btn-primary btn-sm" onclick="OpenEdit('<?php echo $data['id'] ?>', '<?php echo $data['juz_atau_keterangan_ayat'] ?>', '<?php echo $data['seqjuz'] ?>', '<?php echo $data['parentid'] ?>', '')" data-toggle="modal"> <i class="glyphicon glyphicon-pencil"></i> Edit</a>
                    <a class="btn btn-circle btn-danger btn-sm" onclick="OpenDeleteModal('<?php echo $data['id']; ?>')" data-toggle="modal"><i class="glyphicon glyphicon-remove"></i>Delete</a>
                  </td>
                </tr>

                <?php  

                    $getDataJuz2 = mysqli_query($con, "SELECT * FROM tbl_juz where parentid = ". $data['id'] . " order by seqjuz asc ");

                    while ($data2 = mysqli_fetch_array($getDataJuz2)) {

                ?>

                <tr>
                    <td>  </td>
                    <td style="background-color:#F0F8FD">

                        <?= $data2['juz_atau_keterangan_ayat']; ?>

                    </td>
                    <td style="background-color:#F0F8FD">
                        <?= $data2['seqjuz']; ?>
                    </td>
                    <td align="center" style="background-color:#F0F8FD">
                        <?php 
                            $juzparent      = mysqli_query($con,"SELECT * FROM tbl_juz where id = ".$data2['parentid']." limit 1 ");
                            $parentvalue    = mysqli_fetch_array($juzparent); 
                        ?>
                        <a class="btn btn-circle btn-primary btn-sm" onclick="OpenEditKetSurah('<?php echo $data2['id'] ?>', '<?php echo addslashes($data2['juz_atau_keterangan_ayat']) ?>', '<?php echo $data2['seqjuz'] ?>','<?php echo $data2['parentid'] ?>','<?php echo $parentvalue['juz_atau_keterangan_ayat'] ?>')" data-toggle="modal"> <i class="glyphicon glyphicon-pencil"></i> Edit</a>
                        <a class="btn btn-circle btn-danger btn-sm" data-toggle="modal" onclick="OpenDeleteModal('<?php echo $data2['id']; ?>')" data-toggle="modal"><i class="glyphicon glyphicon-remove"></i>Delete</a>
                    </td>
                </tr>

                <?php  
                    }
                ?>
                <?php  

                    $nomer++;
                    }
                ?>

            </tbody>

        </table>
    </div>

</div>

<!-- Edit Juz -->
<div id="editmjuz" class="modal" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel"> <i class="glyphicon glyphicon-calendar"></i> Edit Data Juz </h4>
            </div>
            
            <?php $smk2=mysqli_query($con,"SELECT * FROM tbl_jilid where parentid = 0 order by seqjilid asc "); ?>

            <form action="<?php echo $basead; ?>a-control/<?php echo md5('editmjuz'); ?>/access" method="post">

                <div class="modal-body">  
                
                    <div class="row editformjuz" style="display: flex; margin-left: 10px; margin-right: 10px !important;">
                        
                        <input type="hidden" id="idjuzedit" name="idjuzedit" class="form-control">
                        <input type="hidden" id="idparentjuzedit" name="idparentjuzedit" class="form-control">

                        <div class="col-sm-2">
                            <div class="form-group">
                                <label> Juz </label>
                                <input type="number" style="width: 75px;" id="isijuzedit" name="isijuzedit" class="form-control">
                            </div>
                        </div>  

                        <div class="col-sm-2">
                            <div class="form-group">
                                <label> Urutan </label>
                                <input type="number" style="width: 75px;" id="seqjuzedit" name="seqjuzedit" class="form-control">
                            </div>
                        </div>

                    </div>
                
                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary btn-circle"><i class="glyphicon glyphicon-ok"></i> Simpan</button> 
                    <a class="btn btn-danger" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Tutup</a>
                </div>

            </form>
        </div>
    </div>
</div>

<!-- Edit Keterangan Surah pada juz -->
<div id="editmketsurah" class="modal" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content"> 

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel"> <i class="glyphicon glyphicon-calendar"></i> Edit Data Keterangan Surah </h4>
            </div>

            <form action="<?php echo $basead; ?>a-control/<?php echo md5('editmketsurah'); ?>/access" method="post">

                <div class="modal-body">
                    <div class="row">

                        <input type="hidden" id="idketsurahedit" name="idketsurahedit" class="form-control">
                        <input type="hidden" id="idparentjuzketedit" name="idparentjuzketedit" class="form-control">

                        <div class="col-sm-5">
                            <div class="form-group">
                                <label> Keterangan Surah </label>
                                <input type="text" id="ketsurahedit" name="ketsurahedit" class="form-control">
                            </div>
                        </div>

                        <div class="col-sm-2">
                            <div class="form-group">
                                <label> Urutan </label>
                                <input type="number" id="seqketsurahedit" name="seqketsurahedit" class="form-control">
                            </div>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary btn-circle"><i class="glyphicon glyphicon-ok"></i> Simpan</button> 
                    <a class="btn btn-danger" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Tutup</a>
                </div>

            </form>

        </div>
    </div>
</div>

<div id="addmjuz" class="modal"  data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel"> <i class="glyphicon glyphicon-calendar"></i> Tambah Data Juz </h4>
            </div>

            <?php $isiParentJuz = mysqli_query($con,"SELECT * FROM tbl_juz where parentid = 0 order by seqjuz, id asc "); ?>
            
            <form action="<?php echo $basead; ?>a-control/<?php echo md5('addmjuz'); ?>/access" method="post">

                <div class="modal-body">  
                    
                    <div class="row">

                        <div class="col-sm-2">
                          <div class="form-group formAddIsiSurah">
                            <label> Parent Juz </label>
                            <br>
                            <select class="form-control" id="parentjuz" name="parentjuz">
                                <option> -- Pilih -- </option>
                                <?php foreach($isiParentJuz as $data_juz) : ?>
                                    <option value="<?= $data_juz['id']; ?>"> <?= $data_juz['juz_atau_keterangan_ayat']; ?> </option>
                                <?php endforeach; ?>
                            </select>
                          </div>
                        </div>

                        <div class="col-sm-2">
                          <div class="form-group formAddIsiSurah">
                            <label> Urutan </label>
                            <br>
                            <input type="number" class="form-control" name="urutan">
                          </div>
                        </div>
                        
                    </div>

                    <div class="row">

                        <div class="col-sm-6">
                          <div class="form-group formAddIsiSurah">
                            <label> Surah Awal </label>
                            <br>
                            <select class="form-control js-example-basic-multiple" id="addIsiSurahAwal"  name="addIsiSurahAwal">
                                <option> -- Pilih -- </option>
                                <?php foreach($getDatasurah as $data_surah) : ?>
                                    <option value="<?= $data_surah['nomer_surah']; ?>"> QS (<?= $data_surah['nomer_surah']; ?>) <?= $data_surah['nama_surah']; ?> </option>
                                <?php endforeach; ?>
                            </select>
                          </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group formKeteranganAyatSrhAwal">
                                <label> Keterangan ayat untuk surah Awal </label>
                                <input type="text" style="width: 100%;" class="form-control keteranganAyatSrhAwl" placeholder="Optional" name="keteranganAyatSrhAwl" id="keteranganAyatSrhAwl">
                                <br>
                                <div id="errmsg"></div>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        
                        <div class="col-sm-6">
                          <div class="form-group formAddIsiSurah">
                            <label> Surah Akhir </label>
                            <br>
                            <select class="form-control js-example-basic-multiple" id="addIsiSurahAkhir"  name="addIsiSurahAkhir">

                                <option> -- Pilih -- </option>
                                <?php foreach($getDatasurah as $data_surah) : ?>
                                    <option value="<?= $data_surah['nomer_surah']; ?>"> QS (<?= $data_surah['nomer_surah']; ?>) <?= $data_surah['nama_surah']; ?> </option>
                                <?php endforeach; ?>
                            </select>
                          </div>
                        </div>    

                        <div class="col-sm-6">
                            <div class="form-group formKeteranganAyatSrhAkhir">
                                <label> Keterangan ayat untuk surah Akhir </label>
                                <input type="text" style="width: 100%;" class="form-control keteranganAyatSrhAkr" name="keteranganAyatSrhAkr" placeholder="Optional" id="keteranganAyatSrhAkr">
                                <br>
                                <div id="errmsg"></div>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary btn-circle"><i class="glyphicon glyphicon-ok"></i> Simpan</button> 
                    <a class="btn btn-danger" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Tutup</a>
                </div>

            </form>
        </div>
    </div>
</div>

<div id="hapusmjuz" class="modal" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
    <form action="<?php echo $basead; ?>a-control/<?php echo md5('hapusmjuz').'/access' ?>" method="post">
        <div class="modal-content">
            <input type="hidden" id="idhapusjuz" name="idhapusjuz" class="form-control">
            <div class="modal-header bg-green">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Konfirmasi Hapus Data Juz </h4>
            </div>
            <div class="modal-body">
            <p>Jika Anda Menghapus Data Ini, Akan Berpengaruh Pada</p>
            <b>1. Data Histori siswa naik juz<br>2. Data kenaikan juz</b>
            </div>
            <div class="modal-footer">
            <button class="btn btn-primary btn-circle"><i class="glyphicon glyphicon-ok"></i> Lanjutkan</button> 
            <button class="btn btn-danger" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Tutup</button>
            </div>
        </div>
        </form>
    </div>
</div>

<!-- Modal Jika Terdapat Error -->

<!-- The Modal -->
<div id="myModal" class="modal-error">

  <!-- Modal content -->
  <div class="modal-content-error" id="content-err" style="background-color: red;">
    <span class="close-popup-err" style="margin-top: -20px;margin-right: -10px;">&times;</span>
    <p style="text-align: center;" id="texterror"> </p>
  </div>

</div>
<!-- Akhir Modal -->

<script language="javascript" type="text/javascript">
    
    function SelesaiChanged(selesaival) {
        alert( $('#_jlparselect').val());
    }

    $(document).ready(function() {

        const fieldJuz  = $(".juz");

        let modal       = document.getElementById("myModal");
        let spans       = document.getElementsByClassName("close-popup-err")[0];
        let txtErr      = $("#texterror");
        let mdlErr      = $("#content-err");

        $(".juz").keypress(function (e) {

            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                $(".juz").attr('disabled','disabled');
                fieldJuz.css("background-color", "white");
                modal.style.display = "block";
                mdlErr.css("background-color", "aquamarine");
                mdlErr.css("color", "#000");
                mdlErr.css("width", "350px");
                mdlErr.css("font-family", "calibri");
                mdlErr.css("font-size", "19px");
                txtErr.html("Isi Juz Hanya Boleh Di Isi dengan Angka")
                txtErr.css("margin-top", "25px");

                spans.onclick = function() {
                    modal.style.display = "none";
                    $("#juz").removeAttr('disabled'); 
                    document.getElementById("juz").focus();
                    $("#juz").val("")
                }

                // When the user clicks anywhere outside of the modal, close it
                window.onclick = function(event) {
                  if (event.target == modal) {
                    modal.style.display = "none";
                    $("#juz").removeAttr('disabled'); 
                    document.getElementById("juz").focus();
                    $("#juz").val("")
                  }
                }

            }

            $('.juz').on("input", function() {
                let dataInputJuz = this.value;
                if (dataInputJuz > 30 ) {
                 
                    $(".juz").attr('disabled','disabled');
                    fieldJuz.css("background-color", "white");
                    modal.style.display = "block";
                    mdlErr.css("background-color", "aquamarine");
                    mdlErr.css("color", "#000");
                    mdlErr.css("width", "350px");
                    mdlErr.css("font-family", "calibri");
                    mdlErr.css("font-size", "19px");
                    txtErr.css("margin-top", "25px");
                    fieldJuz.css("background-color", "white");
                    modal.style.display = "block";
                    txtErr.html("Juz hanya ada 30")

                    // When the user clicks on <span> (x), close the modal
                    spans.onclick = function() {
                        modal.style.display = "none";
                        $("#juz").removeAttr('disabled'); 
                        document.getElementById("juz").focus();
                        $("#juz").val("")
                    }

                    // When the user clicks anywhere outside of the modal, close it
                    window.onclick = function(event) {
                      if (event.target == modal) {
                        modal.style.display = "none";
                        $("#juz").removeAttr('disabled'); 
                        document.getElementById("juz").focus();
                        $("#juz").val("")
                      }
                    }

                }
            });

        });

        $('.js-example-basic-multiple').select2();

        $("#masterJuz").DataTable();

    })

</script>