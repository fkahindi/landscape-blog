<div class="subscribe-section">
	<h6 class="align-left" id="to-be-notified"><strong>If you would like to be notified when there is a new post via mail, subscribe below.</strong></h6>
	<form  method="POST" action="" id="subscribe" >
		<div class="subscribe_error"></div>
		<div class="group-form">
			<label for="email"> Email:<span class="red"> &#42;</span></label>
			<input name="email" id="email" class="form-control" type="text" 
			 type="email" value="<?php echo(empty($email)? '': $email); ?>" maxlength="50" autocomplete="off">
			<span class="error"> <?php echo(!empty($errors['email']) ? $errors['email'] : ''); ?> </span>
		</div>
		<div>
			<label for="privacy">
			<input type="checkbox" name="privacy" value="privacy" id="privacy-checkbox"><p> Yes, I have read and agree with the <a href="<?php echo BASE_URL ?>policies/privacy-policy.php">privacy policy</a><span class="red"> &#42;</span></p>
			</label>
			<span class="error"> <?php echo(!empty($errors['privacy']) ? $errors['privacy'] : ''); ?> </span>
		</div>
		<input name="subscribe" type="submit" id="submit_subscribe" class="button" value="Subscribe">
	</form>
	<div id="subscribe_response"><p></p></div>
</div>
<hr>
