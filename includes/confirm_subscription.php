<?php
/* include necessary files */
require_once __DIR__ .'/../config.php';
include __DIR__ .'/../../includes_appDir/DatabaseConnection.php';
include __DIR__ . '/../classes/DatabaseTable.php';
try{
	$subscribeTempTbl = new DatabaseTable($pdo, 'subscribe_temp_tbl','token','email');
	$sql = $subscribeTempTbl->selectMatchColumnsRecords($token,$email);
	
	/* //There should be only 1 matching record in database */
	if($sql->rowCount()==1){
		
		$curDate = date('Y-m-d H:i:s');
		$row=$sql->fetch();
		
		$createdDateTimeStamp = strtotime($row['created_at']);
		$curDateTimeStamp = strtotime($curDate);
		
		/* //Token expires after 1 day */
		if($curDateTimeStamp-$createdDateTimeStamp<=86400){
			$created_at = new DateTime();	
			$created_at = $created_at->format('Y-m-d H:i:s');
			$fields =[
				'email' => $row['email'],
				'created_at' => $created_at
			];
			$subscribeUser = new DatabaseTable($pdo, 'subscribers', 'email');
			$query = $subscribeUser->insertRecord($fields);
			
			$sql = $subscribeTempTbl->deleteRecords($email);
			echo '<h2>Subscription confirmed! </h2><br>';
			echo '<h4>You will be notified when a new post is available.</h3><br>';
			echo '<p><a href="'.BASE_URL .'index.php">Continue</a></p>';
		}else{
			echo 'Token expired';
		}
		
	}else{
		echo 'Token matching email was not found';
	}
}catch(PDOException $e){
	/* 1062 - Duplicate entry */
	if($e->errorInfo[1]==1062){
		echo 'Subscriber already exists.';
	}else{
		throw $e;
	}		
}	
	