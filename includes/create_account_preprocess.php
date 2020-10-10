<?php 
require __DIR__ .'/../../includes_appDir/DatabaseConnection.php';
require __DIR__ .'/../classes/DatabaseTable.php';
  if (isset($_POST['username_check'])) {
  	$username = $_POST['username'];
	$usersTable = new DatabaseTable($pdo, 'users','username');
	$sql = $usersTable->selectColumnRecords($username);
  	if ($sql->rowCount() > 0) {
  	  echo "taken";	
  	}else{
  	  echo 'not_taken';
  	}
  	exit();
  }
  if (isset($_POST['email_check'])) {
  	$email = $_POST['email'];
	$usersTable = new DatabaseTable($pdo, 'users','email');
	$sql = $usersTable->selectColumnRecords($email);
  	if ($sql->rowCount() > 0) {
  	  echo "taken";	
  	}else{
  	  echo 'not_taken';
  	}
  	exit();
  }
