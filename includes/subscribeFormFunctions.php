<?php
if(!isset($_SESSION)){
	session_start();
}

/* //include necessary the files */
include __DIR__ .'/../../includes_appDir/DatabaseConnection.php';
include __DIR__ . '/../classes/DatabaseTable.php';

$name = $email = '';

$errors =[];
$valid = true;
/* //This section handles 1st step of subscription */
if(isset($_POST['subscribe'])){
	/* //Assign variables */
	$email = $_POST['email'];
	
	/* //Incase email field is left blank */
	if(empty($_POST['email'])){
		$valid = false;
		$errors['email'] = 'Type your email address';
	}else{
		$email = filter_var($email, FILTER_SANITIZE_EMAIL);
		
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
			$valid = false;
			$errors['email']='Invalid email address';
		}else{
			$valid = true;
		}
	}
		
	if($valid){
		
		$curDate = date('Y-m-d H:i:s');			
		$created_at = new DateTime();	
		$created_at = $created_at->format('Y-m-d H:i:s');
		$token = bin2hex(random_bytes(50));
		
		$subscribeTempTbl = new DatabaseTable($pdo, 'subscribe_temp_tbl','email');
		$sql = $subscribeTempTbl->selectColumnRecords($email);
		/* Check if email already exists */
		if(!empty($sql->rowCount())){
			/* //if email exists check if token is still valid */
			$row=$sql->fetch();
			$createdDateTimeStamp = strtotime($row['created_at']);
			$curDateTimeStamp = strtotime($curDate);
			if($curDateTimeStamp - $createdDateTimeStamp<=3600){
				/* //If an hour has not elapsed since record update notify user. */                
				echo '<script>
                $("#subscribe-form").addClass("hidden");
                </script>';
				echo '<div class="success">A link was sent to your email in less than 1 hour ago. Check your email inbox.</div>';
			}else{
				/* //Update token and date then send email link */
				$fields = ['token' => $token, 'created_at' => $created_at];
				
				require_once __DIR__ .'/subscribe-email-link.php';
				if(isset($emil_success)){
				$updateToken = $subscribeTempTbl->updateRecords($fields,$email);
				echo $emil_success;
				}else{
					echo $email_error;
				}				
			}
		}else{
			$fields = [
			'email' => $email,
			'token' => $token,
			'created_at' => $created_at
			];
		
			/* Insert record into subscribers' temp table and send mail to user, otherwise display error. */
			require_once __DIR__ .'/subscribe-email-link.php';
			if(isset($emil_success)){
				$query = $subscribeTempTbl ->insertRecord($fields);
				echo $emil_success;
			}else{
				echo $email_error;
			}
		}	
	}
}
