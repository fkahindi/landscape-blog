<?php
include_once __DIR__ . '/../../config.php';
/* check if user already loged in, if not redirect to login page */
if(!isset($_SESSION['loggedin']) && $_SESSION['loggedin']!= true){
		header("Location:". "<?php echo BASE_URL ?>" ."forms/login.php");
		exit;
}elseif(!empty($_SESSION['email'])){
	$email = $_SESSION['email'];
	include __DIR__ . '/../../../includes_appDir/DatabaseConnection.php';
	include __DIR__ . '/../../classes/DatabaseTable.php';
				
	$usersTable = new DatabaseTable($pdo,'users', 'email');

	$sql = $usersTable->selectColumnRecords($email);
				
	if($sql->rowCount() == 1){
		/* //The session email is in the database */
		if($row = $sql->fetch()){
			$email = $row['email'];
			$hashed_password = $row['password'];
			
			/* //Check whether session email and password match the ones in the database */
			if($_SESSION['email']== $email && $_SESSION['password'] == $hashed_password){
				
				$_SESSION['loggedin'] = true;
				$rolesTable = new DatabaseTable($pdo, 'roles', 'role_id');
				$query = $rolesTable->selectColumnRecords($row['role_id']);
				$record = $query->fetch();
				$_SESSION['role']= $record['role'];
				
			}else{
				/* There is a problem, session values mismatch database credentials */
				include __DIR__ . '/../../includes/logout.php';
			}
		}else{
			echo 'User could not be verified.';
		}
	}else{
		echo 'Credentials could not be found.';
	}
}
