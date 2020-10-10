<?php 
if(!isset($_SESSION)){
	session_start();
}
include __DIR__ .'/../includes/processForm.php';
if(isset($_POST['create-account'])){
	createAccount();
}
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Francis Kahindi">
    <meta charset="utf-8">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>styles/form.css"/>
    <title>Create Account</title>
</head>
<body>			
	<form  method="POST" action="">
        <div class="logo">
        <img src="../resources/icons/logo.png" width="150px">
        </div>
        <h3>Create Account </h3>
        <p>Fields marked with <span class="red"> &#42;</span> are mandatory. </p>
        <div id="form-error" class="error"><?php echo(!empty($form_error)? $form_error :'');?></div>
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
			<label for="privacy">
			<input type="checkbox" name="privacy" value="privacy" id="privacy-checkbox"><span class="red"> &#42;</span> Yes, I have read and agree with the <a target="blank" href="<?php echo BASE_URL ?>policies/privacy-policy.php">privacy policy</a></label>
			<span class="error"> <?php echo(!empty($errors['privacy']) ? $errors['privacy'] : ''); ?> </span>
		</div>
		<input name="create-account" type="submit" id="submit_btn" class="button" value="Create Account">
        <div class="section">
		<p>Already have an account? <a href="<?php echo BASE_URL ?>forms/login.php">Login </a>.</p>
        </div>
	</form>
	
	<!-- Scripts -->
	<script src="<?php echo BASE_URL ?>resources/js/jquery-3.4.0.min.js"></script>
	<script src="<?php echo BASE_URL ?>resources/js/form_check.js"></script>
</body>
</html>
