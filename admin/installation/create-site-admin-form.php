<?php
if(!isset($_SESSION)){
    session_start();
}
/* Include necessary the files */
include __DIR__ . '/../../classes/DatabaseTable.php';
include __DIR__ .'/../../../includes_appDir/DatabaseConnection.php';
$errors =[];
$valid = true;
$gen_pattern ="/^[\w]{3,}$/"; /* Matches atleast characters made of alpha-numeric and underscore */
$password_pattern = "/^[\w\-.]+$/"; /* Matches letters, numbers, underscore, dash or dot */

if(isset($_POST['create-admin'])){
    
    /* Assign variables */
	$username = $_POST['username'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$confirm_password = $_POST['confirm-password'];	
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
				
		/* Check if name contain only aphabet, numbers and underscore */
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
    if(empty($_POST['password'])){
		$valid = false;
		$errors['password'] = 'Password cannot be blank';
	}elseif(empty($_POST['confirm-password'])){
		$valid = false;
		$errors['confirm-password'] = 'Confirm your password';
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
			$errors['confirm-password'] ='Your passwords do not match';
		}
	}
    if(empty($errors)){
            /* Check whether the email or username are already in use */
            $usersTable = new DatabaseTable($pdo, 'users', 'email','username');
            $sql = $usersTable->selectColumnsRecords($email,$username);
            
            if($sql->rowCount()>0){
			$valid = false;
			$row = $sql->fetch();
			if($row['username'] === $username){
				$errors['username'] = $username.' already exists';
			}
			if($row['email'] === $email){
				$errors['email'] = $email.' already exists';
			}
            }else{
                $curDate = date('Y-m-d H:i:s');			
                $created_at = new DateTime();	
                $created_at = $created_at->format('Y-m-d H:i:s');					
                $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $role_id = 1;
                $fields = [
                'role_id' => $role_id,
                'username' => $username,
                'email' => $email,
                'password' => $password,
                'created_at' => $created_at
                ];		
                $usersTable->insertRecord($fields);			
            }						
	}else{
		$form_error = 'Form has errors';		
	}
}
function test_input($data){
$data = stripslashes($data);
$data = htmlspecialchars($data, ENT_QUOTES);
return $data;
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
		<meta name="author" content="Developerspot.co.ke">
		<title>Create site Admin</title>
        <style>
            form{
                width:400px;
                margin:4em auto;
                font-family:'Helvetica',Sans-serif;
            }
            input{
                border:thin solid silver;
            }
            ul{
                margin:10px 0;
            }
           li{
                margin-left:0;
                padding-left:0;
                font-size:0.75em;
                font-weight:normal;
            }
            label{
                display:block;
                margin:1em 3px;
                font-size:1em;
                font-weight:bold;
                
            }
            input{
                display:block;
                width:80%;
                margin-top:5px;
                padding:0.2em;
                font-family:serif,Arial;
                font-size:1em
            }
            input[type="submit"]{
                display:inline;
                width:auto;
                padding:0.375em;
                margin:1em 3em;
                cursor:pointer;
                backgound-color:#ADD8E6;
                color:black;
                cursor:pointer;
            }
            .error, .red{
                color:red;
                font-size:0.75em;
            }
        </style>
    </head>
<body>
<form method="POST">
    <fieldset>
    <legend>Site Administrator</legend>
  
    <ul><li>This user will have administrative rights for the site.</li><li>Username and email are important for password recovery and must be unique on this site.</li></ul>
       
    <div class="group-form">
    <label for="username">Username:<span class="red"> &#42;</span></label>
    <input  name="username" id="username" class="form-control" type="text" 
    value="<?php echo (empty($username)? '': $username); ?>" maxlength="50" autocomplete="off" >
    <span class="error"> <?php echo(!empty($errors['username']) ? $errors['username'] : ''); ?></span>
    </div>
    <div class="group-form">
        <label for="email"> Email:<span class="red"> &#42;</span></label>
        <input name="email" id="email" class="form-control" type="email" value="<?php echo(empty($email)? '': $email); ?>" maxlength="50" autocomplete="off" >
        <span class="error"> <?php echo(!empty($errors['email']) ? $errors['email'] : ''); ?> </span>
    </div>
    <div class="group-form">
    <label for="password">Password:<span class="red"> &#42;</span></label>
    <input type="password" id ="password" name="password" value="<?php echo(empty($password)? '': $password); ?>" maxlength="50" autocomplete="off" >
    <span class="error"><?php echo (!empty($errors['password'])? $errors['password'] :'');?></span>
        <ul class="form-guidelines">
            <li>Passwords must be at least <strong>6</strong> characters.</li>
            <li>May contain letters, numbers, underscore, hyphen or dot.</li>
        </ul>
    </div>
    <div class="group-form">
    <label for="confirm-password">Confirm Password:<span class="red"> &#42;</span></label>
     <input type="password" id="confirm-password" name="confirm-password" value="<?php echo(empty($confirm_password)? '': $confirm_password); ?>" maxlength="51" autocomplete="off" >
    <span class="error"><?php echo (!empty($errors['confirm-password'])? $errors['confirm-password'] :'');?></span>
    </div>
    <input type="submit" name="create-admin" value="Create Admin">
    </fieldset>
 </form>
 </body>
 </html>