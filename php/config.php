<?php
$dbhost ='localhost';
$dbuser ='u415776667_apps';
$dbpass ='apps123';
// $dbpass ='Admin@2023';
$dbname ='u415776667_apps';
$db_dsn = "mysql:dbname=$dbname;host=$dbhost";
try {
  $db = new PDO($db_dsn, $dbuser, $dbpass);
} catch (PDOException $e) {
  echo 'Connection failed: '.$e->getMessage();
}
$con=mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);
($GLOBALS["___mysqli_ston"] = mysqli_connect($dbhost, $dbuser, $dbpass));mysqli_select_db($GLOBALS["___mysqli_ston"], $dbname);
/* css.plugin.hancon <?php echo $base; ?> */
/* $base='https://apps.aiis.sch.id/'; */
// $base='http://localhost/spp/';
$base='http://192.168.0.169/apps/';
/* control(link.redirect) <?php echo $basecon; ?> */
$basead='http://localhost/spp/admin/';
$baseac='http://192.168.0.169/spp/accounting/';
/* $basead='https://apps.aiis.sch.id/admin/'; */
/*kelas(link.redirect) <?php echo $basekel; ?>*/
/* $basegu='https://apps.aiis.sch.id/guru/'; */
$basegu='http://localhost/apps/guru/';
// $basegu='http://192.168.0.163/apps/guru/';
$basewa='http://localhost/apps/walikelas/';
/* $basewa='https://apps.aiis.sch.id/walikelas/'; */
$basewam='http://localhost/apps/walimurid/';
/* $basewam='https://apps.aiis.sch.id/walimurid/'; */

$aplikasi=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM aplikasi limit 1"));
$ata=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM tahunakademik where status='aktif' ")); 
$c_ta=$ata['c_ta'];
?>
