<?php
if(!isset($_SESSION)){
	session_start();
}

/* //include necessary the files */
include __DIR__ . '/../config.php';
include __DIR__ .'/../../includes_appDir/DatabaseConnection.php';
include __DIR__ . '/../classes/DatabaseTable.php';

$errors =[];
$valid = true;
$gen_pattern ="/^[\w]{3,}$/"; /* //Matches atleast characters made of alpha-numeric and underscore */
$password_pattern = "/^[\w\-.]+$/"; /* // Matches letters, numbers, underscore, dash or dot */

/* //This section handles user account creation */
function createAccount(){
	global $pdo, $errors,$valid, $gen_pattern, $form_error, $form_success;
		
	/* //Assign variables */
	$username = $_POST['username'];
	$email = $_POST['email'];
		
	/* //Incase any field is left blank */
	if(empty($_POST['username'])){
		$valid = false;
		$errors['username'] = 'Name cannot be blank';
	}else if(strlen($_POST['username'])<3){
		$valid = false;
		$errors['username'] = 'Username must be at least three characters';
	}else{
		$username = test_input($_POST['username']);
		$username = trim($username);
				
		/* //Check if name contain only aphabet, numbers and underscore */
		if (!preg_match($gen_pattern,$username)){
			
			$valid = false;
			$errors['username'] = "Only alpha numeric and underscore allowed in username";  
		} 
	}
	
	if(empty($_POST['email'])){
		$valid = false;
		$errors['email'] ='Email cannot be blank';
	}else{
		$valid = true;
		/* //Remove spaces incase they exist */
		$email = trim($_POST['email']);
		/* //Remove illegal characters from email */
		$email = filter_var($email, FILTER_SANITIZE_EMAIL);
		
		/* //Check if email address is well formed */
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
			$valid = false;
			$errors['email'] = 'Invalid email address';
		}		
	}
	if(empty($_POST['privacy'])){
		$valid = false;
		$errors['privacy']='You need to agree with the privacy policy';
	}else{
		$valid = true;
	}
	if(empty($errors)){
		
		/* Check whether the email or username are already in use */
		$usersTable = new DatabaseTable($pdo, 'users', 'email','username');
		$sql = $usersTable->selectColumnsRecords($email,$username);
		if($sql->rowCount()>0){
			$valid = false;
			$row = $sql->fetch();
			if($row['username'] === $username){
				$errors['username'] = 'You cannot use '.$username;
			}
			if($row['email'] === $email){
				$errors['email'] = 'You cannot use '.$email;
			}
		}else{
			$curDate = date('Y-m-d H:i:s');			
			$created_at = new DateTime();	
			$created_at = $created_at->format('Y-m-d H:i:s');
			$token = bin2hex(random_bytes(20));
			
			$users_tempTable = new DatabaseTable($pdo, 'users_temp','email');
			$query = $users_tempTable->selectColumnRecords($email);
					
			if($query->rowCount()>0){
				/* If email exists check if token still valid */ 
				$temp_row = $query->fetch();
								
				$createdDateTimeStamp = strtotime($temp_row['created_at']);
				$curDateTimeStamp = strtotime($curDate);
				$span = $curDateTimeStamp - $createdDateTimeStamp;
				if($span<= 86400){
					/* If link was sent in less than 24 hrs notify user */

					$_SESSION['email_success'] = 'A link was sent to '.$temp_row['email'].' address in less than 24 hours ago. Check your email inbox.';
                    header('Location: ../templates/thank-you.html.php');
				}else{
					/* Update token, date and fullname (if set) then send email link */
					$fields = ['token' => $token, 'created_at' => $created_at];
					$update_usersToken = $users_tempTable->updateRecords($fields,$email);
					require_once __DIR__ .'/create-account-email-link.php';
                    header('Location: ../templates/thank-you.html.php');
				} 	
			}else{
				$fields = [
				'username' => $username,
				'email' => $email,
				'token' => $token,
				'created_at' => $created_at
				];				
				require_once __DIR__ .'/create-account-email-link.php';	
				if(isset($_SESSION['email_success'])){
					$insert_tempRecord = $users_tempTable ->insertRecord($fields);
                    header('Location: ../templates/thank-you.html.php');
				}else{
					$form_error = $email_error;
				}
			}
		}				
	}else{
		$form_error = 'Form has errors';		
	}
}
/* This function handles account email verification 
** and enables users to set their account password
** before account can be operational
*/
function setAccountPassword(){
	global $pdo, $password_pattern,$password, $confirm_password, $profile_photo, $valid, $errors;
	
	$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
	$token = filter_var($_POST['token'], FILTER_SANITIZE_STRING);
	$username =filter_var($_Post['username'], FILTER_SANITIZE_STRING);
	$password = $_POST['password'];
	$confirm_password = $_POST['confirm_password'];
		
	if(empty($_POST['password'])){
		$valid = false;
		$errors['password'] = 'Password cannot be blank';
	}elseif(empty($_POST['confirm_password'])){
		$valid = false;
		$errors['confirm_password'] = 'Confirm your password';
	}else{
		$valid = true;
		$password = filter_var($password, FILTER_SANITIZE_STRING);
		$confirm_password = filter_var($confirm_password, FILTER_SANITIZE_STRING);
		$password = trim($password);
		
		if(!preg_match($password_pattern, $password)){
			$valid = false;
			$errors['password'] ='Only alphanumeric, underscore, dash and dot are allowed.';
		}else if(strlen($password)<6){
			$valid = false;
			$errors['password'] ='Password must be at least 6 characters.';
		}else if($password !== $confirm_password){
			$valid = false;
			$errors['confirm_password'] ='Your passwords do not match';
		}
	}
	
	/* If everything is OK and valid is true */ 
	if($valid){

		try{
			$curDate = date('Y-m-d H:i:s');
					
			$selectEmailToken = new DatabaseTable ($pdo, 'users_temp','token', 'email');
			$sql = $selectEmailToken->selectMatchColumnsRecords($token, $email);
							
			if($sql->rowCount()==1){
				
					$row = $sql->fetch();
					$username = $row['username'];
					$expDateTimestamp = strtotime($row['created_at']);
					$curDateTimestamp = strtotime($curDate);
					$span = $curDateTimestamp - $expDateTimestamp;
					
					if($span<=86400){
						
						$created_at = new DateTime();	
						$created_at = $created_at->format('Y-m-d H:i:s');
						$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
						$profile_photo = BASE_URL . 'resources/photos/profile.png';
						$fields = [
							'username'=> $username,
							'profile_photo'=>$profile_photo,
							'email' => $email,
							'password' => $password,
							'created_at' => $created_at
						];
						$usersTable = new DatabaseTable($pdo, 'users', 'email');
						$usersTable->insertRecord($fields);
														
						$deleteToken = new DatabaseTable($pdo,'users_temp', 'email');
						$deleteToken->deleteRecords($email);
						
						/* Redirect to login page */
						$_SESSION['success_msg'] ='Congratulations! Your account is set. <br> Please, login to your account.';
										
						header('Location: ../forms/login.php');
									
					}else{
						
						echo 'The token expired';
						exit();
					}			
			}else{
				echo 'Could not find token, please try again';
				exit();
			}
			
		}catch(PDOException $e){
			if($e->errorInfo[1]==1062){
				echo 'Email or Username already exists.';
			}else{
				throw $e;
			}			
		}	
	}
}
	
/* This function handles user logins */
function login(){
	global $pdo, $valid, $errors;
	if(isset($_SESSION['page_id'])&& isset($_SESSION['post_slug'])){
		$page_id = $_SESSION['page_id'];
		$page_slug = $_SESSION['post_slug'];
	}
	$email = $_POST['email'];
	$password = $_POST['password'];
	
	if(empty($email)){
		$valid = false;
		$errors['email'] = 'You did not enter your email';
	}else{
		/* Remove illegal characters from email */
		$email = filter_var($email, FILTER_SANITIZE_EMAIL);
		
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
			$valid = false;
			$errors['email'] = 'Invalid email';
		}else{
			$valid = true;
		}
	} 
	if(empty($_POST['password'])){
		$valid = false;
		$errors['password'] = 'You did not type a password';
	}else{
		
		$password = filter_var($password, FILTER_SANITIZE_STRING);
		$password =trim($_POST['password']);
		$valid = true;
	}
	if(!$valid){
		$form_error = 'Form has errors';
	}else{
		
		/* Select from users table */			
		$usersTable = new DatabaseTable($pdo,'users', 'email');
		
		$query = $usersTable->selectColumnRecords($email);
		
		/* Check if records exists in the database */
		if($query->rowCount()==1){
			
			/* Fetch the entire record */
			$row = $query->fetch();
			
			/* Select from roles table using user's role_id */
			$rolesTable = new DatabaseTable($pdo, 'roles', 'role_id');
			
			$sql = $rolesTable->selectColumnRecords($row['role_id']);
			$record = $sql->fetch();
			
			/* Assign records values to variables */
			$user_id = $row['user_id'];
			$role = $record['role'];
			$fullname = $row['fullname'];
			$username = $row['username'];
			$profile_photo = $row['profile_photo'];
			$email = $row['email'];
			$hashed_password = $row['password'];
			
			/* Check if the password in database matches the one typed by user */
			if(password_verify($password, $hashed_password)){
				/* regenerate a new session id for security reasons */
				session_regenerate_id();
				
				/* Store data in session variables */
				$_SESSION['loggedin'] = true;
				$_SESSION['user_id'] = $user_id;
				$_SESSION['role'] = $role;
				$_SESSION['email'] = $email;
				$_SESSION['password']= $hashed_password;
				$_SESSION['fullname'] = $fullname;
				$_SESSION['username'] = $username;
				$_SESSION['profile_photo']= $profile_photo;
				$_SESSION['page_id'] = $page_id;
				$_SESSION['post_slug'] = $page_slug;
					
				/* Redirect accordingly */
				header('Location:'. BASE_URL .'admin/dashboard.php');
  									
			}else{
				$errors['password'] ='Incorrect email or password';
											
			}
			
		}else{
			$errors['email'] ='Email address does not exist';
		}	
	}
}

/* //This function handles password change by user */
function changePassword(){
	global $pdo, $password_pattern, $valid, $errors;
	
	$old_password = $_POST['old_password'];
	$new_password = $_POST['new_password'];
	$confirm_new_password = $_POST['confirm_new_password'];
		
	/* //If loggedin validate form */
	if(empty($_POST['old_password'])){
		$valid = false;
		$errors['old_password'] = 'You must enter your old password';
	}else if(empty($_POST['new_password'])){
		$valid = false;
		$errors['new_password'] = 'Enter the new password';
	}else if(empty($_POST['confirm_new_password'])){
		$valid = false;
		$errors['confirm_new_password'] = 'Confirm your new password';
	}else{
		$old_password = filter_var($old_password, FILTER_SANITIZE_STRING);
		$new_password = filter_var($new_password, FILTER_SANITIZE_STRING);
		$confirm_new_password = filter_var($confirm_new_password, FILTER_SANITIZE_STRING);
		$new_password = trim($new_password);
	}
	if(!preg_match($password_pattern, $new_password)){
		$valid = false;
		$errors['new_password'] ='Only apha-numeric, underscore, dash and dot are allowed.';
	}else if(strlen($new_password)<6){
		$valid = false;
		$errors['new_password'] ='Password must be atleast 6 characters.';
	}else if($new_password == $old_password){
		$valid = false;
		$errors['new_password'] ='New password cannot be same as old password.';
	}else if($new_password !== $confirm_new_password){
		$valid = false;
		$errors['confirm_new_password'] ='Your new password did not match';
	}else{
		$valid = true;
	}
		
	if($valid){	
		
		$usersTable = new DatabaseTable($pdo,'users', 'email','username');
		$query = $usersTable->selectMatchColumnsRecords($_SESSION['email'],$_SESSION['username']);
		
		if($query->rowCount()==1){
			
			$row=$query->fetch();
			
			$hashed_password = $row['password'];
			$old_password = $_POST['old_password'];
			
			if(password_verify($old_password, $hashed_password) && (!empty($_SESSION['email']))){
				
				$new_password = password_hash($new_password, PASSWORD_DEFAULT);
				$email = $_SESSION['email'];
				
				$fields =['password'=> $new_password];
				
				$sql=$usersTable->updateRecords($fields,$email);
											
				/* Set a variables to display on the login form */
				$_SESSION['success_msg'] = 'Update successful. <br> Please, login with your new password';
				
				/* Redirect to login page */
				header('Location: ../forms/login.php');
				
			}else{
				$valid = false;
				$errors['old_password'] = 'Password is incorrect';	
			}
		}else{
			$valid = false;
			$errors['email'] = 'Sorry, you need to login.';
		}
	}
}

/* This function begins the process of recovering forgotten password */
function recoverPassword(){
	global $pdo, $valid, $errors;
	$email = $_POST['email'];
			
	if(empty($_POST['email'])){
		$valid = false;
		$errors['email'] = 'Email address is required';
		
	}else{
		filter_var($email, FILTER_SANITIZE_EMAIL);
	
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
				$valid = false;
				$errors['email'] = 'Invalid email';
		}else{
			$valid = true;
		}
	}		
	if($valid){
		
		$usersTable = new DatabaseTable($pdo, 'users', 'email');
		
		$query = $usersTable->selectColumnRecords($email);
		
		if($query->rowCount() == 0){
			$valid = false;
			$errors['email'] = 'This email address does not exist';
		}else{
			$valid = true;
			if($row=$query->fetch()){
			$email = $row['email'];
			}
		}
		if($valid){
			$expDate = new DateTime();	
			$expDate = $expDate->format('Y-m-d H:i:s');				
			$token = bin2hex(random_bytes(50));
			
			$fields =[
				'email' => $email,
				'token' => $token,
				'expDate' => $expDate
			];
			$password_resetTable =  new DatabaseTable($pdo, 'password_reset_temp');
			$password_resetTable->insertRecord($fields);
			
			include __DIR__ . '/../includes/reset-password-link.php';
		}
	}
}

/* This function allows the user to reset their password after successful recovery */
function resetPassword(){
	global $pdo, $password_pattern;
	$email = $_POST['email'];
	$token = $_POST['token'];
	
	if(empty($_POST['new_password'])){
		$valid = false;
		$errors['new_password'] = 'Password cannot be blank.';
	}else if(empty($_POST['confirm_new_password'])){
		$valid = false;
		$errors['confirm_new_password'] = 'Confirm your new password';
	}else{
		$valid = true;
		$new_password = filter_var($_POST['new_password'], FILTER_SANITIZE_STRING);
		$new_password = trim($_POST['new_password']);
		$confirm_new_password = filter_var($_POST['confirm_new_password'], FILTER_SANITIZE_STRING);
		$confirm_new_password = trim($_POST['confirm_new_password']);
	}
			
	if(!preg_match($password_pattern,$new_password)){
		$valid = false;
		$errors['new_password'] ='Only alpha-numeric, underscore, dash and dot are allowed.';
	}else if(strlen($new_password)<6){
		$valid = false;
		$errors['new_password'] ='Password must be atleast 6 characters.';
	}else if($confirm_new_password !== $new_password){
		$valid = false;
		$errors['confirm_new_password'] ='Your passwords did not match';
	}
		
	/* If everything is OK and valid is true  */
	if($valid){
				
		$curDate = date('Y-m-d H:i:s');
				
		$selectEmailToken = new DatabaseTable ($pdo, 'password_reset_temp', 'token','email');
		$sql = $selectEmailToken->selectMatchColumnsRecords($token, $email);
		
		if(!empty($sql->rowCount())){
			
			$row = $sql->fetch();
			$expDateTimestamp = strtotime($row['expDate']);
			$curDateTimestamp = strtotime($curDate);
			
			if(($curDateTimestamp - $expDateTimestamp)<=82400){
													
				$deleteToken = new DatabaseTable($pdo,'password_reset_temp', 'email');
				$deleteToken->deleteRecords($email);
				
				$new_password = password_hash($new_password, PASSWORD_DEFAULT);
				$_SESSION['email'] = $_POST['email'];
				
				$updatePassword = new DatabaseTable($pdo, 'users', 'email');
				
				$fields = ['password'=> $new_password];
				
				$updatePassword->updateRecords($fields,$_SESSION['email']);
								
				/* Redirect to login page */
				$_SESSION['success_msg'] ='You have changed your password. <br> Please, login with your new password';
								
				header('Location: ../forms/login.php');
							
			}else{
				echo 'The token expired';
				exit();
			}
		
		}else{
			echo 'Token was not found, please try recover password again.';
			exit();
		}	
	}
}

/* //This function helps user to upload profile image of their account */
function imageUpload(){
	global $pdo;
	if(isset($_SESSION['page_id'])&& isset($_SESSION['post_slug'])){
		$page_id = $_SESSION['page_id'];
		$page_slug = $_SESSION['post_slug'];
	}	
	$target_dir = '../resources/photos/';
	$target_file = $target_dir . basename($_FILES['fileToUpload']['name']);
	$uploadOk = 1;
	$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
	$allowed_image_types = array("png","jpg","jpeg","gif");
		
	/* //Check if an image has been selected */
	if(!empty(getimagesize($_FILES['fileToUpload']['tmp_name']))){
		
		/* Allow only jpg, jpeg, png and gif file formats */
		if(!in_array($imageFileType, $allowed_image_types)){
			$uploadOk = 0;
			$errors['fileToUpload'] = 'Sorry, only JPG, JPEG, PNG or GIF files are allowed';
							
			/* Validate image size is 2MB or less */
		}else if($_FILES['fileToUpload']['size']>2000000){
			$uploadOk = 0;
			$errors['fileToUpload'] = 'Sorry, image is too large';
		}else{
			$uploadOk = 1;
		}
		
	}else{
		$uploadOk = 0;
		$errors['fileToUpload'] =  'No image was selected.';	
	}
	
	/* //If everything is ok, try to upload the file */
	if($uploadOk == 1){
		
		/* //Get the user name id to use in the file name */
		$email = $_SESSION['email'];
		$username= $_SESSION['username'];
		
		$usersTable = new DatabaseTable($pdo, 'users', 'email');
		$query = $usersTable->selectColumnRecords($email);
		
		if($query->rowCount()>0){
			$row = $query->fetch();
			
			/* //Set the session photo path again */	
			$id = $row['user_id'];
		}
		
		/* Prepare file by renaming the image file with account session name */
		if(!empty($_SESSION['fullname'])){
			$fullname_arr = explode(' ',$_SESSION['fullname']);
			$name = implode($fullname_arr);
		}else{
			$name = $_SESSION['username'];
		}
					
		/* Split the original file name and take the extension name */
		$file_pieces = explode('.',$_FILES['fileToUpload']['name']);
		$extension = $file_pieces[1];
		
		/* To ensure filename uniqueness combine name with user id, add sufix -0 and the extension name */
		$target_file = strtolower($name .'-0'. $id .'.'.$extension);
		
		if(move_uploaded_file($_FILES['fileToUpload']['tmp_name'],'../resources/photos/'.$target_file)){
			$file_path = BASE_URL  .'resources/photos/'.$target_file;
										
			/* Update profile_photo file path in the database */
			$fields = ['profile_photo' => $file_path];
			
			$usersTable->updateRecords($fields,$email);
			
			/* Fetch the records again to place the image photo in session */
			$query = $usersTable->selectColumnRecords($email);
			if($query->rowCount()== 1){
				$row = $query->fetch();
				
				/* Set the session photo path again */	
				$_SESSION['profile_photo'] = $row['profile_photo'];
			}			
			/* Redirect accordingly */
			if(isset($_SESSION['page_id'])){
				header('Location: ../templates/post.html.php?id='.$_SESSION['page_id'].'&title='.$_SESSION['post_slug']);
			}else{
				header('Location: ../index.php');
			}				
		}else{
			echo 'Sorry, there was an error uploading your file.';
		}		
	}
}
function serviceForm(){
    global $errors, $valid;
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $tel = filter_var($_POST['tel'], FILTER_SANITIZE_NUMBER_INT);
    $message = $_POST['message'];
    
    if(empty($_POST['name'])){
        $valid = false;
        $errors['name'] = 'Please, provide your name';
    }else{
        $valid = true;
    }
    if(empty($_POST['email'])){
        $valid = false;
        $errors['email'] = 'Enter your email contact ';
    }else{
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $valid = false;
            $errors['email'] = 'Invalid email';
        }else{
            $valid = true;
        }
    }
    if(empty($_POST['tel'])){
        $valid = false;
        $errors['tel'] = 'Phone number is required';
    }else{
       $valid = true;
    }
    if(empty($message)){
        $valid = false;
        $errors['message'] = 'Type your message';
    }else{
        $message = htmlspecialchars($message, ENT_QUOTES);
    }
    if($valid){
        //Change email variable name to avoid conflict with phpMailer class
        $services_email = $email;
        include __DIR__ .'/services-email-send.php';
    }   
}
function test_input($data){
$data = stripslashes($data);
$data = htmlspecialchars($data, ENT_QUOTES);
return $data;
}