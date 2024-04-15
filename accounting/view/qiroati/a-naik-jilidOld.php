<script language="javascript" type="text/javascript">
$(document).ready(function() {
    $('#_idsiswa').val("");
    $('#_nmsiswa').val("");
    $('#_nmsiswa2').text("");
    $('#_kelassiswa').text("");

    var _btnsetupjilid = document.getElementById("btnsetupjilid");
    _btnsetupjilid.style.display = "none";

    var _btnnaikjilid = document.getElementById("btnnaikjilid");
            _btnnaikjilid.style.display = "none";

});

function OpenCarisiswaModal(){

        $('#datamassiswa').modal("show");
    }


    function OnSiswaSelectedModal(kode, nama, kelas, c_siswa, curjilid, idcurjilid, seqjilid, 
    nextSeq, nextnmjilid, nextidjilid){

        $('#_idsiswa').val(kode);
        $('#_nmsiswa').val(nama);
        $('#_nmsiswa2').text(nama);
        $('#_kelassiswa').text(kelas);

        if(c_siswa == undefined || c_siswa == null || c_siswa == '')
        {
            var _btnnaikjilid = document.getElementById("btnnaikjilid");
            _btnnaikjilid.style.display = "none";

            var _btnsetupjilid = document.getElementById("btnsetupjilid");
            _btnsetupjilid.style.display = "block";

            $('#_jilidcur').val("Pra TK");
            $('#_jilidcur2').text("Pra TK");
            $('#_idjilid').val("1");
            $('#_seqnext').val(1);
            
        }
        else{
            var _btnnaikjilid = document.getElementById("btnnaikjilid");
            _btnnaikjilid.style.display = "block";

            var _btnsetupjilid = document.getElementById("btnsetupjilid");
            _btnsetupjilid.style.display = "none";
            $('#_jilidcur').val(nextnmjilid);
            $('#_jilidcur2').text(curjilid);
            $('#_idjilid').val(nextidjilid);
            $('#_seqnext').val(nextSeq);
        }

        $('#datamassiswa').modal("hide");
    }

</script>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">

        <?php if(isset($_SESSION['pesan']) && $_SESSION['pesan']=='tambah'){?>
          <div style="display: none;" class="alert alert-warning alert-dismissable">Setup Naik Jilid Berhasil Disimpan
             <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          </div>
        <?php } ?>

        <?php if(isset($_SESSION['pesan']) && $_SESSION['pesan']=='edit'){?>
          <div style="display: none;" class="alert alert-info alert-dismissable">Data Naik Jilid Berhasil Disimpan
             <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          </div>
        <?php } ?>

        <?php if(isset($_SESSION['pesan']) && $_SESSION['pesan']=='hapus'){?>
          <div style="display: none;" class="alert alert-info alert-dismissable">Data Naik Jilid Berhasil Dihapus
             <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          </div>
        <?php } ?>

    </div>
</div>

<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Naik Jilid</h3><span style="float:right;"><a class="btn btn-primary" onclick="OpenCarisiswaModal()"><i class="glyphicon glyphicon-plus"></i> Cari Siswa</a></span>
    </div>
    <form action="<?php echo $basead; ?>a-control/<?php echo md5('addnaikjilid'); ?>/access" method="post">
    <div class="box-body table-responsive">
        <input type="hidden" id="_entryby" name="_entryby" class="form-control" value="<?php echo $na['nama'] ?>">
        <input type="hidden" id="_idsiswa" name="_idsiswa" class="form-control">
        <input type="hidden" id="_idjilid" name="_idjilid" class="form-control">
        <input type="hidden" id="_idjilidnext" name="_idjilidnext" class="form-control">
        <input type="hidden" id="_nmjilidnext" name="_nmjilidnext" class="form-control">
        <input type="hidden" id="_seqnext" name="_seqnext" class="form-control">

        <input type="hidden" class="form-control" id="_nmsiswa" name="_nmsiswa">
        <input type="hidden" class="form-control" id="_jilidcur" name="_jilidcur"/>

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Nama Siswa</label>
                    <label class="form-control" id="_nmsiswa2" name="_nmsiswa2"> </label>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label>Kelas</label>
                    <label class="form-control" id="_kelassiswa" name="_kelassiswa"></label>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label>Jilid</label>
                    <label class="form-control" id="_jilidcur2" name="_jilidcur2"> </label>
                </div>
            </div>
        </div>
        <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                      <label>Tgl Naik Jilid</label>
                      <div class="controls input-append date form_date" data-date="1998-10-14" data-date-format="dd-m-yyyy" data-link-field="dtp_input1">
                          <input id="_tglnaikjilid" name="_tglnaikjilid" class="form-control form-select" type="text" value="<?php echo date('d-m-Y'); ?>"  required="">
                          <span class="add-on"><i class="icon-th"></i></span>
                      </div>
                    </div>
                </div>
        </div>
        <div class="row">
            <div class="col-sm-3">
            <button id="btnsetupjilid" name="btnsetupjilid" style="display:none;" class="btn btn-primary btn-circle"><i class="glyphicon glyphicon-ok"></i> Setup Jilid</button> 
            <button id="btnnaikjilid" name="btnnaikjilid" style="display:none;" class="btn btn-primary btn-circle"><i class="glyphicon glyphicon-ok"></i> Naik Jilid</button> 
            </div>
        </div>
    </div>
    </form>
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
                <table id="example1" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th width="5%">NO</th>
                <?php if(empty($_GET['q'])){
                  echo '<th width="12%">KELAS</th>';
                } ?>
                  <th>NISN</th>
                  <th>NAMA</th>
                  <th>GENDER</th>
                </tr>
                </thead>
                <tbody>
<?php
if(isset($_GET['q'])){
  $smk=mysqli_query($con,"SELECT * FROM siswa where c_kelas='$_GET[q]' order by nama asc ");
}else{
  $smk=mysqli_query($con,"SELECT * FROM siswa order by nama asc ");
}             $vr=1;
while($akh=mysqli_fetch_array($smk))
{ 
    $kk=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM kelas where c_kelas='$akh[c_kelas]' ")); 
    $sjh=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM sisjilid_h where c_siswa='$akh[c_siswa]' limit 1 "));
    
if($sjh != null){
    $nextSeq = $sjh['seqjilid'] + 1;
    $nextmjilid =mysqli_fetch_array(mysqli_query($con,"SELECT * FROM tbl_jilid where seqjilid='$nextSeq' limit 1 ")); 
}

?>                
                <tr onclick="OnSiswaSelectedModal('<?php echo $akh['c_siswa']; ?>', 
                '<?php echo $akh['nama']; ?>', 
                '<?php echo $kk['kelas']; ?>', 
                '<?php echo $sjh['c_siswa'] ?? ''; ?>',
                '<?php echo $sjh['nmjilid'] ?? ''; ?>', 
                '<?php echo $sjh['idjilid'] ?? 0; ?>',
                '<?php echo $sjh['seqjilid'] ?? 0; ?>',
                '<?php echo $nextSeq ?? 0; ?>', 
                '<?php echo $nextmjilid['nmjilid'] ?? ''; ?>',
                '<?php echo $nextmjilid['id'] ?? 0; ?>')">
                  <td><?php echo $vr; ?></td>
                <?php if(empty($_GET['q'])){
                  echo '<td>'.$kk['kelas'].'</td>';
                }?>
                  <td><?php echo $akh['nisn']; ?></td>
                  <td><?php echo $akh['nama']; ?></td>
                  <td><?php if($akh['jk']=='L'){echo 'Laki - Laki';}elseif($akh['jk']=='P'){echo 'Perempuan';} ?></td>
                </tr>

<?php $vr++; 
} ?>
</tbody>
</table>
                </div>
            </div>
        </div>
    </div>    
</div>



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