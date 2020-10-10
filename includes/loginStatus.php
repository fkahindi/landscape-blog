<?php
/* check if user already loged in, if not redirect to login page */
if(!isset($_SESSION['loggedin']) && $_SESSION['loggedin']!= true){
		header('Location: <?php echo BASE_URL ?>forms/login.html.php');
		exit;
}elseif(!empty($_SESSION['email'])){
	$email = $_SESSION['email'];
	
}else{
	/* There is a problem, some session values missing credentials */
	include __DIR__ . '/logout.php';
}

