<form method="post" >
	<textarea name="comment" id="comment" cols="50" rows="6" maxlength="350" placeholder="Type your comment here..." ></textarea>
	<input type="hidden" name="user_id" id="user_id" value="<?php echo $_SESSION['user_id'] ?>">
	<input type="hidden" name="page_id" id="page_id" value="<?php echo $page_id ?>">
	<input type="submit" id="submit_comment" class="submit_comment" name="submit" value="Post" >
</form>