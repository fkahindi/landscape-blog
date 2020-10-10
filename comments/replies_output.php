	<div class="group">
		<div class="replies-profile-photo">
			<img src="<?php echo getUserById($reply['user_id'])['profile_photo']; ?>" alt="" width=30px height=30px>
		</div>
		<div class="replies-detail">
			<div class="user-info">
				<span class="username"><?php echo getUserById($reply['user_id'])['username']; ?></span>
				<span class="created-date"><?php echo date('F j, Y ', strtotime($reply['created_at'])); ?></span>
			</div>
			<div class="reply-text">
				<?php echo $reply['body']; ?>
			</div>
		</div>
	</div><br>