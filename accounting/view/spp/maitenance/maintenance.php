<?php  

    $tahunAjaran1 = "";
    $tahunAjaran2 = "";
    $focus = 0;

    if (isset($_POST['simpan_form'])) {

        if ($_POST['tahun_ajaran'] == '' && $_POST['tahun_ajaran_2'] == '') {
            $_SESSION['form_empty'] = 'twoform_empty';
            $focus = 1;
        } else if ($_POST['tahun_ajaran'] == '') {
            $tahunAjaran2 = $_POST['tahun_ajaran_2'];
            $_SESSION['form_empty'] = 'form1_empty';
            $focus = 1;
        } else if ($_POST['tahun_ajaran_2'] == '') {
            $_SESSION['form_empty'] = 'form2_empty';
            $tahunAjaran1 = $_POST['tahun_ajaran'];
            $focus = 2;
        } else {

            // Insert to DB
            $tahunAjaran = $_POST['tahun_ajaran'] . '/' . $_POST['tahun_ajaran_2'];
            $semester    = $_POST['isi_semester'];
            $status      = "";

            $query = "
                    INSERT INTO tahun_ajaran (id_tahun_ajaran, tahun, semester, status)
                    VALUES ('', '$tahunAjaran', '$semester')
            ";

            mysqli_query($con, "INSERT INTO `u415776667_spp`.`tahun_ajaran` (`tahun`, `semester`) VALUES ('$tahunAjaran', '$semester')");

            echo $tahunAjaran;

            $_SESSION['form_success'] = 'berhasil';
        }

    }	

?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">

        <?php if(isset($_SESSION['form_success']) && $_SESSION['form_success'] == 'berhasil'){?>
          <div style="display: none;" class="alert alert-warning alert-dismissable"> Data Berhasil Di Simpan
             <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
             <?php unset($_SESSION['form_success']); ?>
          </div>
        <?php } ?>

        <?php if(isset($_SESSION['form_empty']) && $_SESSION['form_empty'] == 'twoform_empty'){?>
          <div style="display: none;" class="alert alert-danger alert-dismissable"> Form Input 1 & Input 2 Tidak Boleh Kosong
             <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
             <?php unset($_SESSION['form_empty']); ?>
          </div>
        <?php } ?>

        <?php if(isset($_SESSION['form_empty']) && $_SESSION['form_empty'] == 'form1_empty'){?>
          <div style="display: none;" class="alert alert-danger alert-dismissable"> Tahun Ajaran di Input 1 Harap Di Isi
             <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
             <?php unset($_SESSION['form_empty']); ?>
          </div>
        <?php } ?>

        <?php if(isset($_SESSION['form_empty']) && $_SESSION['form_empty'] == 'form2_empty'){?>
          <div style="display: none;" class="alert alert-danger alert-dismissable"> Tahun Ajaran di Input 2 Harap Di Isi
             <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
             <?php unset($_SESSION['form_empty']); ?>
          </div>
        <?php } ?>

    </div>
</div>

<div class="box box-info" id="container_maintenance">
    <div class="box-header with-border" id="box_header">
        <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Form Data </h3>
       
    </div>
    
    <div class="container" id="kontainer">
        <form method="post" action="<?= $baseac; ?>maintenance">
            <div class="form-group row" id="div_tahun_ajaran">
                <label for="tahun_ajaran" class="col-sm-2 col-form-label">Tahun Ajaran</label>
                <div id="input_tahun_ajaran">
                    <div class="col-sm-1" id="isi_tahun_ajaran">
                        <input type="text" name="tahun_ajaran" value="<?= $tahunAjaran1; ?>" class="form-control" placeholder="input 1" id="tahun_ajaran">
                    </div>
                    <div class="col-sm-4" id="div_slash">
                        <input type="text" style="background-color: white; width: 10%; font-size: 23px; border: 0px;" value="/" class="form-control" id="slash" readonly>
                    </div>
                    <div class="col-sm-1" id="isi_tahun_ajaran_2">
                        <input type="text" name="tahun_ajaran_2" value="<?= $tahunAjaran2; ?>" class="form-control" placeholder="input 2" id="tahun_ajaran_2">
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-4" id="div_semester">
                    <label for="semester" class="col-sm-2 col-form-label"> Semester </label>
                    <div class="col-sm-4" id="isi_semester">
                        <select class="form-control" id="semester" name="isi_semester">
                            <option value="1"> 1 </option>
                            <option value="2"> 2 </option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-10">
                    <button type="submit" name="simpan_form" class="btn btn-success btn-sm"> Save </button>
                </div>
            </div>

        </form>
    </div>
</div>

<hr class="new1">

<div class="box box-info" id="container_maintenance_2">
    <div class="box-header with-border" id="box_header_2">
        <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Status Data Aktif </h3>
       
    </div>
    
    <div class="container" id="kontainer_2">
        <form method="post" action="<?= $baseac; ?>maintenance">
            <div class="form-group row" id="div_tahun_ajaran">
                <label for="tahun_ajaran" class="col-sm-2 col-form-label">Tahun Ajaran</label>
                <div id="input_tahun_ajaran">
                    <div class="col-sm-2" id="isi_tahun_ajaran">
                        <select class="form-control" id="pilih_tahun_ajaran">
                            <option> 2023/2024 </option>
                            <option> 2024/2025 </option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-4" id="div_semester">
                    <label for="semester" class="col-sm-2 col-form-label"> Semester </label>
                    <div class="col-sm-4" id="isi_semester">
                        <select class="form-control" id="semester">
                            <option value="1"> 1 </option>
                            <option value="2"> 2 </option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-4" id="div_semester">
                    <label for="semester" class="col-sm-2 col-form-label"> Status </label>
                    <div class="col-sm-4" id="isi_status">
                        <select class="form-control" id="status_aktif">
                            <option value="aktif"> Aktif </option>
                            <option value="tidak_aktif"> Tidak Aktif </option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-10">
                    <button type="submit" name="simpan_form" class="btn btn-success btn-sm"> Save </button>
                </div>
            </div>

        </form>
    </div>
</div>

<script type="text/javascript">
        
    let dataFocus = `<?= $focus; ?>`
    if (dataFocus == 1) {
        $("#tahun_ajaran").focus();
    } else if (dataFocus == 2) {
        $("#tahun_ajaran_2").focus();
    } else {
        $("#tahun_ajaran").focus();
    }

    $('#tahun_ajaran').keypress(function (e) {
        if (String.fromCharCode(e.keyCode).match(/[^0-9]/g)) return false;
    });

</script>
