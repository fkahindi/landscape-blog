<?php 
if(!isset($_SESSION)){
	session_start();
}

include __DIR__ . '/includes/admin_login_status.php';
	
if($_SESSION['role'] !== 'Admin'){
	header('Location: ../index.php');
}
?>
<!DOCTYPE html>
<html lang="en">	
<?php include __DIR__ . '/components/head.php';?>
<title>Admin | Dashboard</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
	<?php include __DIR__ .'/components/navbar.php'; ?>
	<div class="container bg-info">
	
	</div>
	<div class="container-fluid">
		<div class="mx-auto my-4"><h1><?php echo $_SESSION['role']; ?></h1></div>
		
		<div class="row ">
			<!--Row with 3 equal columns-->
			<div class="col-md-4 panel-body border">
				<!--Column left -->
				<a href="#">Registered Users | Posts</a>
			</div>
			<div class="col-md-4 panel-body border">
				<!--Column middle -->
				<a href="#">Published posts</a>
			</div>
			<div class="col-md-4 panel-body border">
				<!--Column right -->
				<a href="#">Posted comments</a>
			</div>
		</div>
		<div>
			<a href="users.php" class="btn btn-info">Users</a>
			<a href="posts.php " class="btn btn-info ">Posts</a>
		</div>
	</div>
	
</body>
<!-- For local only -->
<script src="js/jquery-3.4.0.min.js"></script>
<script src="js/bootstrap.min.js"></script>

<script src="js/tooltip-call.js"></script>
</html>