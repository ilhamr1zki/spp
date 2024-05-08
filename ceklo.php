<?php require 'php/config.php';


if(isset($_POST['username']) and isset($_POST['password'])) {

  if($_POST['sebagai'] == 'admin'){

    $usernamenya = strtolower($_POST['username']);

     // Cek Data User Accounting
    $sqlGetUser         = "SELECT * FROM admin WHERE username = '$usernamenya' ";
    $execQueryGetUser   = mysqli_query($con, $sqlGetUser);

    $countData          = mysqli_num_rows($execQueryGetUser);

    if ($countData == 1) {

      $getData      = mysqli_fetch_array($execQueryGetUser);

      $dataPassword = $getData['password'];

      if (password_verify($_POST['password'], $dataPassword)) {

          session_start();
          $_SESSION['c_admin'] = $getData['c_admin'];
          // echo $_SESSION['c_admin'];exit;
          header('location:admin/');
          exit;

      } else {

        session_start();
        $_SESSION['pesan'] = 'gagal';
        header('location:login');
        exit;
      }

    }

  } elseif ($_POST['sebagai'] == 'accounting') {

    $usernamenya = strtolower($_POST['username']);

    // Cek Data User Accounting
    $sqlGetUser         = "SELECT * FROM accounting WHERE username = '$usernamenya' ";
    $execQueryGetUser   = mysqli_query($con, $sqlGetUser);

    $countData          = mysqli_num_rows($execQueryGetUser);

    if ($countData == 1) {

      $getData      = mysqli_fetch_array($execQueryGetUser);

      $dataPassword = $getData['password'];

      if (password_verify($_POST['password'], $dataPassword)) {

          session_start();
          $_SESSION['c_accounting'] = $getData['c_accounting'];
          // echo $_SESSION['c_accounting'];exit;
          header('location:accounting/');
          exit;

      } else {
        session_start();
        $_SESSION['pesan'] = 'gagal';
        header('location:login');
        exit;
      }

    } else {
      session_start();
      $_SESSION['pesan'] = 'gagal';
      header('location:login');
      exit;
    }

    echo $countData;exit;

    if ($_POST['username'] == 'dian') {

      $sqlGetUser         = "SELECT * FROM accounting WHERE username = '$_POST[username]' ";
      $execQueryGetUser   = mysqli_query($con, $sqlGetUser);

      $getData = mysqli_fetch_array($execQueryGetUser);

      $dataPassword = $getData['password'];

      if (password_verify($_POST['password'], $dataPassword)) {
        echo "Matching";exit;
      } else {
          echo "NO Matching!";exit;
      }

    } elseif($_POST['username'] == 'dian') {

    }
 
  } 
  else if($_POST['sebagai']=='walikelas'){
    $cek3=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM walikelas where username='$_POST[username]' and password='$_POST[password]' "));
    if($cek3==NULL){
      session_start();
      $_SESSION['pesan']='gagal';
      header('location:login');
    }
    else{
      session_start();
      $_SESSION['c_walikelas']=$cek3['c_walikelas'];
      header('location:walikelas/');
    }
  }
  else if($_POST['sebagai']=='guru'){
    $cek2=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM guru where username='$_POST[username]' and password='$_POST[password]' "));
    if($cek2==NULL){
      session_start();
      $_SESSION['pesan']='gagal';
      header('location:login');
    }else{
      session_start();
      $_SESSION['c_guru']=$cek2['c_guru'];
      header('location:guru/');
    }
  }
  else if($_POST['sebagai']=='walimurid'){
    $cek4=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM walimurid where username='$_POST[username]' and password='$_POST[password]' "));
    if($cek4==NULL){
      session_start();
      $_SESSION['pesan']='gagal';
      header('location:login');
    }else{
      session_start();
      $_SESSION['c_walimurid']=$cek4['c_walimurid'];
      header('location:walimurid/');
    }
  }
  else{header('location:login');}
}
else{header('location:login');}
?>