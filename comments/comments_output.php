<?php
if(!isset($_SESSION)){
	session_start();
}
?>
<div class="comments-section group" >
	<div class="hide-comment-id"><?php echo $comment['comment_id']; ?></div>
	<div class="profile-photo"> <img src="<?php echo getUserById($comment['user_id'])['profile_photo']; ?>" alt="" width=30px height=30px></div>
	<div class="comments-detail ">
		<div class="user-info">
			<span class="username"><?php echo getUserById($comment['user_id'])['username']; ?></span>
			<span class="created-date"><?php echo date('F j, Y ', strtotime($comment['created_at'])); ?></span>
		</div>
		<div class="comment-text"><?php echo $comment['body']; ?></div>
	</div>
</div>
