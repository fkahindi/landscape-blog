<?php
global $form_error;
$body = $message; 
$subject = "Inquiry from ".$services_email;
 
$email_to = "fkahindi@vipingo-hills.co.ke";
$fromserver = "noreply@vipingo-hills.co.ke"; 
require __DIR__ .'/../../includes_appDir/EmailCredentials.php';
require __DIR__ .'/../PHPMailer/PHPMailerAutoload.php';
$mail = new PHPMailer();
$mail->IsSMTP();
$mail->Host = 'smtp.gmail.com'; /*  Enter your host here */
$mail->SMTPAuth = true;
$mail->Username = EMAIL; /*  Enter your email here */
$mail->Password = PASS; /* Enter your password here */
$mail->SMTPSecure = 'tls';
$mail->Port = 587;
$mail->IsHTML(true);
$mail->From = $services_email;
$mail->FromName = $name;
$mail->Sender = $fromserver; /* indicates ReturnPath header */
$mail->Subject = $subject;
$mail->Body = $body .'<br> From '.$name .'<br> '.$services_email;
$mail->AddAddress($email_to);
if(!$mail->Send()){
	$form_error = 'Oops! Sending error has occured.'. $mail->ErrorInfo;
}else{
   $_SESSION['message_success'] = "Thank you for reaching to us. We will get back to you the soonest.";
    header('Location: ../templates/thank-you.html.php');
}