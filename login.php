<?php 
  
  require 'php/config.php'; 
  session_start(); 
  
  if(isset($_SESSION['c_admin'])){ 
    header('location:admin/'); 
  } else if(isset($_SESSION['c_guru'])) { 
    header('location:guru/'); 
  } else if(isset($_SESSION['c_walikelas'])) { 
    header('location:walikelas/'); 
  } else if(isset($_SESSION['c_walimurid'])) { 
    header('location:walimurid/'); 
  } else if (isset($_SESSION['c_accounting']) ) {
    header('location:accounting/');
  }

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title> Login AIIS APPS SPP </title>
  <link rel="icon" href="favicon.ico">
  <link rel="shortcut icon" href="imgstatis/favicon.jpg">
  <script type="text/javascript" src="jquery.js"></script> 
  
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="theme/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="theme/dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="theme/plugins/iCheck/square/blue.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="theme/plugins/select2/select2.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="Theme/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="Theme/dist/css/skins/_all-skins.min.css">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  
</head>


<?php ?>
<body style="background:url(imgstatis/back1.jpg)
no-repeat center center fixed; background-size: cover;
 -webkit-background-size: cover; 
 -moz-background-size: cover; -o-background-size: cover;">
 <div class="row">
<div class="login-box">
  <div class="login-logo">
    <h3 style="color:#fff;"> AIIS-APPS SPP <br><p><?php echo $aplikasi['namasek']; ?></p></h3>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg" style="font-size:100%;">Masukkan Username dan Password</p>  
    <?php if(isset($_SESSION['pesan']) && $_SESSION['pesan']=='gagal'){?>
      <p><div style="display: none;" class="alert alert-danger alert-dismissable">Username atau Password Salah!
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      </div></p>
    <?php }$_SESSION['pesan'] = '';?>
    <form action="ceklo.php" method="post">
      <div class="form-group has-feedback">
        <input type="text" name="username" class="form-control" placeholder="Username" required="" autocomplete="" autofocus="">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="password" class="form-control" placeholder="Password" required="" autocomplete="off">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="form-group">
        <label>*Login Sebagai</label>
        <select name="sebagai" class="form-control form-select" id="select2">
          <option value="admin">ADMINISTRATOR</option> 
          <option value="accounting">ACCOUNTING</option>
        </select>
      </div>
        <button type="submit" name="submit" class="btn btn-primary btn-block btn-flat" style="font-size: 15px;">Login <i class="glyphicon glyphicon-log-in"></i></button>

    </form>
  </div>
  <!-- /.login-box-body -->
</div>
</div>
<!-- jQuery 2.2.3 -->
<script src="theme/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="theme/bootstrap/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="theme/plugins/iCheck/icheck.min.js"></script>
<!-- Select2 -->
<script src="theme/plugins/select2/select2.full.min.js"></script>
<script>
  $(function () {
    //Initialize Select2 Elements
    $("#select2").select2();
  });
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });

</script>
<script>
//angka 500 dibawah ini artinya pesan akan muncul dalam 0,5 detik setelah document ready
$(document).ready(function(){setTimeout(function(){$(".alert").fadeIn('fast');}, 100);});
//angka 3000 dibawah ini artinya pesan akan hilang dalam 3 detik setelah muncul
setTimeout(function(){$(".alert").fadeOut('fast');}, 5000);
</script>
</body>
</html>

