<?php
if(!isset($_SESSION)){
	session_start();
} 
include_once __DIR__ . '/../includes/processForm.php';
if(isset($_POST['login'])){
	login();
}
?>
<!doctype html>
<html lang="en">
<head>
	    <meta charset="utf-8">
        <meta name="viewport" content="width=device-width initial-scale=1.0">
        <meta name="author" content="Francis Kahindi">
        <title>Login In</title>
        <link rel="stylesheet" href="../styles/form.css">
</head>
<body>
    <form method="POST" action="">
        <div class="logo">
            <img src="../resources/icons/logo.png" width="150px">
        </div>
        <h3>Login</h3>
        <h4 class="success"><?php echo(!empty($_SESSION['success_msg'])? $_SESSION['success_msg']:'');?></h4>
        <h5 class="error"><?php echo(isset($form_error)? $form_error: '');?></h5>
        <div class="group-form">
        <label for="email">Email address:</label>
         <input type="text" name="email" value="<?php echo (!empty($email)? $email:'');?>" autocomplete="off"> <span class="error"><?php echo (!empty($errors['email'])? $errors['email'] :'');?></span>
        </div>
        <div class="group-form">
        <label for="password">Password: <span class="right-align"> </span></label>
         <input type="password" name="password" autocomplete="off" >
        <span class="error"><?php echo (!empty($errors['password'])? $errors['password'] :'');?></span>
        </div>		
        <input type="submit" name="login" class="button" value="Log in"> 
        <?php echo(!empty($signup_option)? $signup_option : '');?>	
        <div class="section">
        <p class="centered"><a href="<?php echo BASE_URL ?>forms/recover-password.php">Forgot password</a> | <a href="<?php echo BASE_URL ?>forms/create-account.php"> Create an account</a></p>
        </div>
    </form>
</body>
</html>