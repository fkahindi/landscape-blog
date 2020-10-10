<?php
if(!isset($_SESSION)){
	session_start();
}
?>
<?php if(isset($comments)): ?>
	<div class="comments-area" id="comments-area">
	<!-- Comments display area -->
		<?php foreach($comments as $comment): ?>
		<div class="comments-section group" >
			<div class="hide-comment-id">
				<?php echo $comment['comment_id']; ?>
				<?php $num_replies = getRepliesCountByCommentId($comment['comment_id']) ; ?>
			</div>
			<div class="profile-photo"> 
				<img src="<?php echo getUserById($comment['user_id'])['profile_photo']; ?>" alt="" width=30px height=30px>
			</div>
			<div class="comments-detail">
				<div class="user-info">
					<span class="username"><?php echo getUserById($comment['user_id'])['username']; ?></span>
					<span class="created-date"><?php echo date('F j, Y  \a\t H:i', strtotime($comment['created_at'])); ?></span>
				</div>
				<div class="comment-text">
					<?php echo $comment['body']; ?>
				</div>
					<!--If user is logged in, provide a link to display reply textbox -->
					<?php if(isset($_SESSION['loggedin'])): ?> 
						<button><a href="#" data-id="<?php echo $comment['comment_id']; ?>" id="reply_btn_<?php echo $comment['comment_id']; ?>" class="reply-btn">Reply</a></button>
					<?php endif; ?>
					<?php if($num_replies>0):?>
					<a href="#" data-id="<?php echo $comment['comment_id']; ?>" id="reply_thread_<?php echo $comment['comment_id']; ?>" class="reply-thread">&#9660;</a><span><?php echo $num_replies; ?> Replies</span>
					<?php endif; ?>
					<?php if(isset($_SESSION['loggedin'])): ?>
						<!-- Reply form -->
						<div class="reply">
							<?php include __DIR__ .'/forms/reply_form.php';?>
						</div>
					<?php endif; ?>	
				<div class="group replies_container_<?php echo $comment['comment_id']; ?>" >
					<div class="replies_by_ajax">
						<!--Display reply by AJAX here -->
					</div>
					<!-- Get all replies by comment_id and display them below -->
					<?php $replies = getRepliesByCommentId($comment['comment_id']) ?>
					<?php if(isset($replies)): ?>
						<?php foreach($replies as $reply): ?>
							<!--Reply -->
							<div class="group">
								<div class="replies-profile-photo">
									<img src="<?php echo getUserById($reply['user_id'])['profile_photo']; ?>" alt="" width=30px height=30px>
								</div>
								<div class="replies-detail">
									<div class="user-info">
										<span class="username"><?php echo getUserById($reply['user_id'])['username']; ?></span>
										<span class="created-date"><?php echo date('F j, Y \a\t H:i', strtotime($reply['created_at'])); ?></span>
									</div>
									<div class="reply-text">
										<?php echo $reply['body']; ?>
									</div>
								</div>
							</div><br>
						<?php endforeach; ?>
					<?php endif; ?>
					
				</div>
			</div>
		</div>
		<?php endforeach; ?>
		<!--Display form comments using AJAX below here -->	
	</div>
	<?php endif ?>