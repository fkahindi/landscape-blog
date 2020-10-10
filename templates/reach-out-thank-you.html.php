<?php 
if(!isset($_SESSION)){
	session_start();
} 
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Email | Message Success</title>
</head>
<body>

<?php if(!empty($_SESSION['email_success'])):?>
<div class="successMsg"><?php echo $_SESSION['email_success']; ?></div>
<p> <a href="login.html.php"> Continue</a></p>
<?php unset($_SESSION['email_success']);?>
<?php else: ?>
<?php echo ''; endif; ?>

<?php if(!empty($_SESSION['message_success'])):?>
<p><?php echo($_SESSION['message_success']) ?> </p>
<p> <a href="../index.php"> Continue</a>.</p>
<?php unset($_SESSION['message_success']);?>
<?php else: ?>
<?php echo ''; endif; ?>

</body>
</html>