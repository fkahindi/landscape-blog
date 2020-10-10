<form method="post" class="reply-form" id="comment_reply_form_<?php echo $comment['comment_id']; ?>" data_id="<?php echo $comment['comment_id']; ?>">
	<textarea name="reply" id="reply_textarea_<?php echo $comment['comment_id']; ?>" class="reply-textarea" cols="50" rows="4" maxlength="350" placeholder="Type your reply..." ></textarea>
	<input type="hidden" name="user_id" class="reply_form_user_id" value="<?php echo $_SESSION['user_id'] ?>">
	<input type="submit" id="post_reply_<?php echo $comment['comment_id']; ?>" class="post_reply" name="submit" value="Post" >
</form>