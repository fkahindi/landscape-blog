<?php
$output='<p>Dear user,</p>';
$output.='<p>Please use the following link to confirm your subscription for new posts notification from Vipingo Hills.</p>';
$output.='<p>------------------------------------------------</p>';
/* ** FOR ONLINE SERVER **

	$output.='<p><a href="https://www.vipingo-hills.co.ke/forms/confirm-subscription.html.php?
key='.$token.'&email='.$email.'&action=subscribe" target="_blank">

** */

/* For Local Server */
$output.='<p><a href="localhost/landscape/forms/confirm-subscription.html.php?
key='.$token.'&email='.$email.'&action=subscribe" target="_blank">
Confirm email subscription</a></p>';		
$output.='<p>------------------------------------------------</p>';
$output.='<p>The link will expire after 1 day for security reasons. Please, if the link does not work, copy and paste it on a new tab on your browser.
</p>';
$output.='<p>If you did not request this subscription, no action is needed, you will not be subscribed.</p>';   	
$output.='<p>Thanks,</p>';
$output.='<p>Vipingo Hills Team</p>';
$body = $output; 
$subject = "Email Subscription";
 
$email_to = $email;
$fromserver = "noreply@vipingo-hills.co.ke"; 
require __DIR__ .'/../../includes_appDir/EmailCredentials.php';
require __DIR__ .'/../PHPMailer/PHPMailerAutoload.php';
$mail = new PHPMailer();
$mail->IsSMTP();
$mail->Host = 'smtp.gmail.com'; /* // Enter your host here */
$mail->SMTPAuth = true;
$mail->Username = EMAIL; /* // Enter your email here */
$mail->Password = PASS; /* //Enter your password here */
$mail->SMTPSecure = 'tls';
$mail->Port = 587;
$mail->IsHTML(true);
$mail->From = EMAIL;
$mail->FromName = "Developerspot";
$mail->Sender = $fromserver; /* // indicates ReturnPath header */
$mail->Subject = $subject;
$mail->Body = $body;
$mail->AddAddress($email_to);
if(!$mail->Send()){
	$email_error = '<div class="errorMsg"> Message could not be sent. Mailer Error: '. $mail->ErrorInfo .'</div>';
}else{
	echo '<script>$("#subscribe").addClass("hidden");$("#to-be-notified").addClass("hidden");</script>';
	$emil_success = '<div class="successMsg">An email has been sent to your email box with instructions to confirm your subscription.</div>';
	}