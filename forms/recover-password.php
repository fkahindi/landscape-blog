<?php 
include __DIR__ .'/../includes/processForm.php'; 
if(isset($_POST['recover-password'])){
	recoverPassword();	
}
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width initial-scale=1.0">
    <meta name="author" content="Francis Kahindi">
    <title>Recover Password</title>
    <link rel="stylesheet" href="../styles/form.css">
</head>
<body>	
    <form method="POST" action="">
        <div class="logo">
        <img src="../resources/icons/logo.png" width="150px">
        </div>
          <h3>Recover Password</h3>
          <p class="form-p">Please fill out this form to recover your password.</p>
        <div id="form-error" class="error"><?php echo(!empty($email_error)? $email_error :'');?></div>
        <label for="email">Enter your email address:</label>
         <input type="email" name="email" maxlength="50" autocomplete="off"> <span class="error">
         <?php echo (!empty($errors['email'])? $errors['email'] :'');?></span>
         
        <input type="submit" name="recover-password" class="button" value="Submit"> 
    </form>	
</body>
</html>