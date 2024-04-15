<?php 

session_start(); 
if(isset($_SESSION['c_admin'])){ header('location:control/'); }
elseif(isset($_SESSION['c_guru'])){ header('location:guru/'); }
else{header('location:login');} ?>