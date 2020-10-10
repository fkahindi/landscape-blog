<?php 
if(!isset($_SESSION)){
	session_start();
}

include __DIR__ . '/includes/admin_login_status.php';
	
if($_SESSION['role'] !== 'Admin'){
	header('Location: ../index.php');
}
?>
<?php  
include __DIR__ .'/includes/admin_functions.php';
include __DIR__ .'/includes/posts_functions.php';

/* //Get all subscribers in chanks of 20 */
$subscription = getSubscribers();
?>
<!DOCTYPE html>
<html lang="en">
<title>Admin | Subscriptions</title>	
<?php include __DIR__ . '/components/head.php';?>
	
</head>
<body>
	<?php include __DIR__ .'/components/navbar.php'; ?>
	<div class="container-fluid">
		<div class="panel panel-default text-success text-center"><?php echo isset($_SESSION['message'])? $_SESSION['message']:''; ?></div> 
		<div class="mx-auto my-4"><h3>Admin Panel :: <?php echo $_SESSION['fullname']?></h3></div>
		
		<div class="row my-5">
			<!--Row with 3 equal columns-->
			<div class="col-md-4 panel-body border">
				<!--Column left Navigation-->
				
				<h2><span class="label label-success">Actions</span></h2>
				
				<div><a href="create_post.php">Create posts</a></div>
				<div><a href="posts.php">Manage posts</a></div>
				<div><a href="users.php">manage users</a></div>
				<div><a href="#">manage subscribers</a></div>
				<div><a href="topics.php">manage topics</a></div>
			</div>
			<div class="col-md-8 panel-body border">
			
				<!--Column right database output-->
				<div class="table-div">
				
					<table class="table table-bordered table-hover table-condensed">
						<caption class="text-center"><h4>Admin | Subscribers</h4></caption>
						<thead>
							<tr>
								<th>SNo.</th><th>Name</th><th>Email</th><th>Date Created</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($subscription as $key => $subscriber):?>
							
							<tr>
								<td><?php echo $key + 1 ?></td>
								<td><?php echo $subscriber['name'] ?></td>
								<td><?php echo $subscriber['email']  ?></td>
								<td><?php echo $subscriber['created_at']  ?></td>		
							</tr>
							<?php endforeach ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</body>
<!-- For local only -->
<script src="js/jquery-3.4.0.min.js"></script> 
<script src="js/bootstrap.min.js"></script>

<script src="js/tooltip-call.js"></script>
</html>