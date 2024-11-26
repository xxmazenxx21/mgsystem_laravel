<?php 
session_start(); 
unset($_SESSION['user']);
$_SESSION['done'] = ['loged out succsess']; 
header("location:login.php"); 
exit ; 



?>