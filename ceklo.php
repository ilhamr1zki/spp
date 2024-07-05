<?php require 'php/config.php';


if(isset($_POST['username']) and isset($_POST['password'])) {

  if($_POST['sebagai'] == 'admin'){

    $usernamenya = strtolower($_POST['username']);

     // Cek Data User Accounting
    $sqlGetUser         = "SELECT * FROM admin WHERE username = '$usernamenya' ";
    $execQueryGetUser   = mysqli_query($con, $sqlGetUser);

    $countData          = mysqli_num_rows($execQueryGetUser);
    $isiPassword        = mysqli_real_escape_string($con, htmlspecialchars($_POST['password']));

    if ($countData == 1) {

      $getData      = mysqli_fetch_array($execQueryGetUser);

      $dataPassword = $getData['password'];

      if (password_verify($isiPassword, $dataPassword)) {

          session_start();
          $_SESSION['c_admin'] = $getData['c_admin'];
          $_SESSION['start_sess']   = time();
          // Session Will Be Expired after 30 Minute
          $_SESSION['expire']       = $_SESSION['start_sess'] + (30 * 60);
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
    $isiPassword        = mysqli_real_escape_string($con, htmlspecialchars($_POST['password']));

    if ($countData == 1) {

      $getData      = mysqli_fetch_array($execQueryGetUser);

      $dataPassword = $getData['password'];

      if (password_verify($isiPassword, $dataPassword)) {

          session_start();
          $_SESSION['c_accounting'] = $getData['c_accounting'];
          $_SESSION['start_name']   = $getData['username'];
          $_SESSION['start_sess']   = time();
          // Session Will Be Expired after 30 Minute
          $_SESSION['expire']       = $_SESSION['start_sess'] + (30 * 60);
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
 
  }
  else{header('location:login');}
}
else{header('location:login');}
?>