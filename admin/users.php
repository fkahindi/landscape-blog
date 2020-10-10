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

/* //Get all admin and author users */
$admins = getAdminUsers();
$roles = ['Admin', 'Author', 'User'];
?>
<!DOCTYPE html>
<html lang="en">
<title>Admin | Edit User</title>	
<?php include __DIR__ . '/components/head.php';?>
	
</head>
<body>
	<?php include __DIR__ .'/components/navbar.php'; ?>
	<div class="container-fluid">
		<div class="panel panel-default text-success text-center"><?php echo isset($_SESSION['message'])? $_SESSION['message']:''; ?></div> 
		<div class="mx-auto my-4"><h3>Admin Panel :: <?php echo $_SESSION['fullname']?></h3></div>
		
		<div class="row my-5">
			<!--Row with 3 equal columns-->
			<div class="col-md-2 panel-body border">
				<!--Column left Navigation-->
				
				<h2><span class="label label-success">Actions</span></h2>
				
				<div><a href="create_post.php">Create posts</a></div>
				<div><a href="posts.php">Manage posts</a></div>
				<div><a href="#">manage users</a></div>
				<div><a href="subscribers.php">manage subscribers</a></div>
				<div><a href="topics.php">manage topics</a></div>
			</div>
			<div class="col-md-3">
			<!-- Middle column-->
				<div class="action">
				<form method="post" action="users.php">
				<!--Validating for errors on the form -->
				<div class="text-left text-danger"><h4><?php include __DIR__ .'/includes/errors.php'; ?></h4></div>
				
				<!-- Attach a hidden id for user being edited-->
				<?php if($isEditingUser === true || $isSearchUser === true): ?>
				<input type="hidden" value="<?php echo $user_id;?>" name="user_id">
				<?php endif ?>
								
				<div class="form-group form-group-lg">
				<label for="username">Username:</label>
				<input type="text" value="<?php echo $username; ?>" name="username" placeholder="Username" id="username" class="form-control"></div>
				<div class="form-group form-group-lg">
				<label for="email">Email address:</label>
				<input type="email" value="<?php echo $email; ?>" name="email" placeholder="Email" id="email" class="form-control"></div>
				<div class="form-group form-group-lg">
				<label for="role">User role:</label>
				<select type="select" class="form-control" name="role" placeholder="Assign role">
						<option value="" selected disabled>Assign role</option>						
						<?php foreach($roles as $key=>$role):?>
						<option value="<?php echo $role; ?>"><?php echo $role; ?></option>
						<?php endforeach ?>
					</select></div>
					<!-- if editing user, display the update button instead of create button -->
				 
					<button type="submit" class="btn btn-primary btn-md" name="update_user">UPDATE</button>
					<button type="submit" class="btn btn-primary btn-md" name="search_user">SEARCH</button>
									
				</form>
				</div>
			</div>
			<div class="col-md-7 panel-body border">
			
				<!--Column right database output-->
				<div class="table-div">
				
					<table class="table table-bordered table-hover table-condensed">
						<caption class="text-center"><h4>Admins | Authors</h4></caption>
						<thead>
							<tr>
								<th>SNo.</th><th>User</th><th>Role</th><th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($admins as $key => $user):?>
							
							<tr>
								<td><?php echo $key + 1 ?></td>
								<td><?php echo $user['username'] .' , '.$user['email'] ?></td>
								<td><?php echo $user['role'] ?></td>
								<td> 
								<p>
								<a href="users.php?edit-user=<?php echo $user['user_id'] ?>" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-pencil"></span> Edit </a>
								</p>
								</td>								
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