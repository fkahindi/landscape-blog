<?php 
if($_SESSION['role'] !== 'Admin'){
	header('Location: ../forms/login.php');
}else{
	header('Location: dashboard.php');
}
?>