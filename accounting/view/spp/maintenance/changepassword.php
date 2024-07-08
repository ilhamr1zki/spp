<?php  

    $focus = 0;

    $tahunAjaran1   = "";
    $tahunAjaran2   = "";

    $checkTypeData1 = "";
    $checkTypeData2 = "";
    $reloadPage = 0;

    $isiSemester = [1, 2];

    $timeOut        = $_SESSION['expire'];
    
    $timeRunningOut = time() + 5;

    $timeIsOut = 0;

    // echo "Waktu Habis : " . $timeOut . " Waktu Berjalan : " . $timeRunningOut;

    if ($timeRunningOut == $timeOut || $timeRunningOut > $timeOut) {

        error_reporting(1);
        $_SESSION['form_success'] = "session_time_out";
        $timeIsOut = 1;
        // exit;

    } else if (isset($_POST['simpan_ubah_pw'])) {

        $dataPasswordLama   = mysqli_query($con, "SELECT * FROM accounting WHERE c_accounting = '$_SESSION[c_accounting]' "); 

        $getPassword = mysqli_fetch_assoc($dataPasswordLama)['password'];

        $dataInputPasswordLama       = htmlspecialchars($_POST['password_lama']);
        $dataInputPasswordBaru       = htmlspecialchars($_POST['password_baru']);
        // echo strlen($dataInputPasswordBaru);exit;
        $dataInputKonfirmasiPassword = htmlspecialchars($_POST['konfirmasi_password_baru']);

        if (password_verify($dataInputPasswordLama, $getPassword)) {

            if (strlen($dataInputPasswordBaru) < 5 || strlen($dataInputKonfirmasiPassword) < 5) {

                $_SESSION['form_success'] = "change_password_too_short";

            } else {

                if ($dataInputPasswordBaru == $dataInputKonfirmasiPassword) {

                    $generatePassword = password_hash($dataInputPasswordBaru, PASSWORD_DEFAULT);

                    mysqli_query($con, "UPDATE accounting SET password = '$generatePassword' WHERE c_accounting = '$_SESSION[c_accounting]' ");

                    $_SESSION['form_success'] = "change_password_success";

                } else {
                    $_SESSION['form_success'] = "new_password_error";
                }

            }


        } else {
            $_SESSION['form_success'] = "change_password_error";
        }

    }

?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">

        <?php if(isset($_SESSION['form_success']) && $_SESSION['form_success'] == 'change_password_success'){?>
          <div style="display: none;" class="alert alert-warning alert-dismissable"> Password Berhasil Di Ubah
             <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
             <?php unset($_SESSION['form_success']); ?>
          </div>
        <?php } ?>

        <?php if(isset($_SESSION['form_success']) && $_SESSION['form_success'] == 'change_password_error'){?>
          <div style="display: none;" class="alert alert-danger alert-dismissable"> Password Sekarang Salah
             <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
             <?php unset($_SESSION['form_success']); ?>
          </div>
        <?php } ?>

        <?php if(isset($_SESSION['form_success']) && $_SESSION['form_success'] == 'new_password_error'){?>
          <div style="display: none;" class="alert alert-danger alert-dismissable"> Password Baru Dan Konfirmasi Password Tidak Sama
             <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
             <?php unset($_SESSION['form_success']); ?>
          </div>
        <?php } ?>

        <?php if(isset($_SESSION['form_success']) && $_SESSION['form_success'] == 'session_time_out'){?>
            <div style="display: none;" class="alert alert-danger alert-dismissable"> Waktu Sesi Telah Habis
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <?php 
                    unset($_SESSION['form_success']); 
                ?>
            </div>
        <?php } ?>

        <?php if(isset($_SESSION['form_success']) && $_SESSION['form_success'] == 'change_password_too_short'){?>
          <div style="display: none;" class="alert alert-danger alert-dismissable"> Panjang Password Baru Minimal 5 Karakter
             <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
             <!-- <?php unset($_SESSION['form_success']); ?> -->
          </div>
        <?php } ?>

    </div>
</div>

<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title"> <i class="glyphicon glyphicon-new-window"></i> Ubah Password </h3>
       
    </div>
    <form action="changepassword" method="post">
        <div class="box-body" style="margin: 10px;">

            <div class="row">

                <div class="col-sm-3">
                    <div class="form-group">
                        <label> Password Sekarang </label>
                        <input type="password" required class="form-control" name="password_lama" placeholder="password sekarang" value="<?= $tahunAjaran1; ?>" id="password_lama">
                    </div>
                    <div class="checkbox" id="swp1" onmouseover="mouseOver1()">
                        <i class="glyphicon glyphicon-eye-open" id="icnEye1"></i> <span id="said1"> Show </span> Password
                    </div>  
                </div>

                <div class="col-sm-3">
                    <div class="form-group">
                        <label> Password Baru </label>
                        <input type="password" required class="form-control" name="password_baru" placeholder="Minimal 5 Karakter" value="<?= $tahunAjaran1; ?>" id="password_baru">
                    </div>
                    <div class="checkbox" id="swp2" onmouseover="mouseOver2()">
                        <i class="glyphicon glyphicon-eye-open" id="icnEye2"></i> <span id="said2"> Show </span> Password
                    </div>  
                </div>

                <div class="col-sm-3">
                    <div class="form-group">
                        <label> Konfirmasi Password Baru </label>
                        <input type="password" required class="form-control" name="konfirmasi_password_baru" placeholder="Minimal 5 Karakter" value="<?= $tahunAjaran1; ?>" id="konf_password_baru">
                    </div>
                    <div class="checkbox" id="swp3" onmouseover="mouseOver3()">
                        <i class="glyphicon glyphicon-eye-open" id="icnEye3"></i> <span id="said3"> Show </span> Password
                    </div>  
                </div>

            </div>

            <div class="row">

                <div class="col-sm-3">
                    <div class="form-group">
                        <button class="btn btn-sm btn-success" name="simpan_ubah_pw"> Save </button>
                    </div>
                </div>

            </div> 

        </div>
    </form>

    
</div>

<script type="text/javascript">
        
    $(document).ready( function () {
        $("#password_lama").focus();    
        $("#list_maintenance").click();
        $("#ubah_password").css({
            "background-color" : "#ccc",
            "color" : "black"
        });

        $("#swp1").click(function(){
            let x = document.getElementById("password_lama");
            if (x.type === "password") {
                $("#icnEye1").removeClass("glyphicon-eye-open");
                $("#icnEye1").addClass("glyphicon-eye-close");
                $("#said1").text('Close')
                x.type = "text";
            } else {
                x.type = "password";
                $("#icnEye1").removeClass("glyphicon-eye-close");
                $("#icnEye1").addClass("glyphicon-eye-open");
                $("#said1").text('Show')
            }
        })

        $("#swp2").click(function(){
            let x = document.getElementById("password_baru");
            if (x.type === "password") {
                $("#icnEye2").removeClass("glyphicon-eye-open");
                $("#icnEye2").addClass("glyphicon-eye-close");
                $("#said2").text('Close')
                x.type = "text";
            } else {
                x.type = "password";
                $("#icnEye2").removeClass("glyphicon-eye-close");
                $("#icnEye2").addClass("glyphicon-eye-open");
                $("#said2").text('Show')
            }
        })

        $("#swp3").click(function(){
            let x = document.getElementById("konf_password_baru");
            if (x.type === "password") {
                $("#icnEye3").removeClass("glyphicon-eye-open");
                $("#icnEye3").addClass("glyphicon-eye-close");
                $("#said3").text('Close')
                x.type = "text";
            } else {
                x.type = "password";
                $("#icnEye3").removeClass("glyphicon-eye-close");
                $("#icnEye3").addClass("glyphicon-eye-open");
                $("#said3").text('Show')
            }
        })

    });

    function mouseOver1() {
      document.getElementById("swp1").style.cursor = "pointer";
    }

    function mouseOver2() {
      document.getElementById("swp2").style.cursor = "pointer";
    }

    function mouseOver3() {
      document.getElementById("swp3").style.cursor = "pointer";
    }

</script>
