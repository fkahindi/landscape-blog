<?php
if(!isset($_SESSION)){
	session_start();
}
if(isset($_GET['email']) && isset($_GET['key'])){
	
	$email=$_GET['email'];
	$token=$_GET['key'];

	require __DIR__ . '/../includes/confirm_subscription.php';
}else{
	echo 'Token was not found';
}
