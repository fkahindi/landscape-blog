<?php 
if(!isset($_SESSION)){
	session_start();
}
include __DIR__ .'/../includes/processForm.php';
if(isset($_POST['service-btn'])){
	serviceForm();
}
?>
<!DOCTYPE html>
<html lan="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width initial-scale=1.0">
        <meta name="author" content="Francis Kahindi">
        <title>Services Form</title>
        <link rel="stylesheet" href="../styles/form.css">
    </head>
    <body>        
        <form  method="POST" action="">
        <div class="logo">
            <img src="../resources/icons/logo.png" width="150px">
        </div>    
        <h3>Ask for Services</h3> 
        <div><span class="error"><?php echo (empty($form_error)? '': $form_error); ?></span></div>
        <div id="form-error" class="error"><?php echo(!empty($form_error)? $form_error :'');?></div>
        <div class="group-form">
            <label for="name">Name<span class="red"> &#42;</span></label>
            <input  name="name" id="name" class="form-control" type="text" 
            value="<?php echo (empty($name)? '': $name); ?>" maxlength="50" autocomplete="off" placeholder="Your name"/>
            <span class="error"> <?php echo(!empty($errors['name']) ? $errors['name'] : ''); ?></span>
        </div>
        <div class="group-form">
            <label for="email"> Email<span class="red"> &#42;</span></label>
            <input name="email" id="email" class="form-control" type="email" value="<?php echo(empty($email)? '': $email); ?>" maxlength="30" autocomplete="off" placeholder="Your email" />
            <span class="error"> <?php echo(!empty($errors['email']) ? $errors['email'] : ''); ?> </span>
        </div>
        <div class="group-form">
            <label for ="tel">Telephone <span class="red"> &#42;</span></label>
            <input type="tel" name="tel" id="tel" value="<?php echo(empty($tel)? '': $tel); ?>" autocomplete="off" placeholder="Phone number" />
            <span class="error"> <?php echo(!empty($errors['tel']) ? $errors['tel'] : ''); ?> </span>
        </div>
        <div class="group-form">
            <label for="message" >Message <span class="red"> &#42;</span></label>
            <textarea name="message" id="message" col=30 rows=5 placeholder="Your message here..."></textarea>
            <span class="error"> <?php echo(!empty($errors['message']) ? $errors['message'] : ''); ?> </span>
        </div>
        <input name="service-btn" type="submit" id="service-btn" class="button" value="Submit">
        </form>
        <script src="<?php echo BASE_URL ?>resources/js/jquery-3.4.0.min.js"></script>
        <script src="<?php echo BASE_URL ?>resources/js/form_check.js"></script>
    </body>
</html>