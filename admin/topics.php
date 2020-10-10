<?php  
	if(!isset($_SESSION)){
		session_start();
	}
	include __DIR__ . '/includes/admin_login_status.php';
	if($_SESSION['role']!== 'Admin' && $_SESSION['role']!== 'Author'){
		header('Location: ../index.php');
	}	
	
	include __DIR__ .'/includes/admin_functions.php';
	include __DIR__ .'/includes/posts_functions.php';

?>
<!DOCTYPE html>
<html lang="en">	
<title><?php echo  $_SESSION['role'] ?> | Create Post</title>
<?php include __DIR__ . '/components/head.php';?>
		
	<!--Fetch all posts that apply to the user  -->
	<?php $topics = getAllTopics(); ?>
</head>
<body>
	<?php include __DIR__ .'/components/navbar.php'; ?>
	<div class="container border mt-3">
		
		<div class="row border">
		<?php include __DIR__ .'/includes/messages.php'?>
			<!--Row with 3 equal columns-->
			<div class="col-md-2 panel-body border">
				<!--Column left Navigation-->
				<div class="bg-success rounded">
					<h2>Actions</h2>
				</div>
				<div><a href="create_post.php">Create post</a></div>
				<div><a href="posts.php">Manage posts</a></div>
				<?php if($_SESSION['role']== 'Admin'):?>
				<div><a href="users.php">manage users</a></div>
				<div><a href="subscribers.php">manage subscribers</a></div>
				<?php endif ?>
				<div><a href="#">Manage topics</a></div>
				
			</div>
			<!--Middle column -->
			<div class="col-md-4 panel-body border">
				<h1>Creat/ Edit Topic</h1>
				<form method="post"  action="topics.php">
					<div class="form-group form-group-lg">
						<!-- Validate errors on form-->
						<?php include __DIR__ .'/includes/errors.php';?>
					
						<!--Id is required to identify the form -->
						<?php if($isEditingTopic === true):?>
						<input type="hidden" name="topic_id" value="<?php echo $_GET['edit-topic']; ?>">
						<?php endif ?> 
						<div class="form-group">
						<input type="text" name="topic_name" value="<?php echo $topic_name; ?>" class="form-control" placeholder="Topic">
						</div>								
						<!--If editing topic, display the update button instead of create button -->
						<div>
							<?php if($isEditingTopic === true): ?>
							<button type="submit" class="btn btn-md btn-primary" name="update_topic">UPDATE</button>
							<?php else: ?>
							<button type="submit" class="btn btn-md btn-primary" name="create_topic">Save post</button>
							<?php endif ?>
						</div>
					</div>
				</form>
			</div>
			<!--Right column -->
			<div class="col-md-6">
				<?php if(empty($topics)): ?>
			<div class="mx-auto my-4"><h4>There no topics in database</h4></div>
				<!--Column right database output-->
			<?php else: ?>	
					<table class="table table-bordered table-hover table-condensed">
						<thead>
							<tr>
								<th>SNo.</th>
								<th>Topic Name</th>
								<th colspan="2" class="text-center">Action</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($topics as $key => $topic):?>
							<tr>
								<td class="text-center"><?php echo $key + 1 ?></td>
								<td><?php echo $topic['topic_name'] ?></td>
										
								<td>
									<p>
									<a href="topics.php?edit-topic=<?php echo $topic['topic_id'] ?>" class="btn btn-primary btn-md"><span class="glyphicon glyphicon-pencil"></span> Edit</a>
									</p>
								</td>
								<td>
									<p>
									<a href="topics.php?delete-topic=<?php echo $topic['topic_id'] ?>" class="btn btn-danger btn-md"><span class="glyphicon glyphicon-trash"></span> Trash</a>
									</p>
								</td>
							</tr>
							<?php endforeach ?>
						</tbody>
					</table>
				<?php endif ?>
			</div>
		</div>
	</div>
</body>
<!-- For local only -->
<script src="js/jquery-3.4.0.min.js"></script> 
<script src="js/bootstrap.min.js"></script>

<script src="js/tooltip-call.js"></script>
</html>