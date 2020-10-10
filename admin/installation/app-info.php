<?php
if(!isset($_SESSION)){
    session_start();
}

if(isset($_POST['proceed'])){
    session_destroy();
    //Go create site admin 
    header('Location: create-site-admin-form.php');
}    

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
		<meta name="author" content="Developerspot.co.ke">
		<title>Create application database</title>
        <style>
            form{
                width:400px;
                margin:4em auto;
                font-family:'Helvetica',Sans-serif;
            }
            input{
                border:thin solid silver;
            }
           p{
                font-size:1em;
                font-weight:normal;
            }
            label{
                display:block;
                margin:1em 3px;
                font-size:1em;
                font-weight:bold;
                
            }
            input{
                display:block;
                width:80%;
                margin-top:5px;
                 padding:0.2em;
                font-family:serif,Arial;
                font-size:1em
            }
            input[type="submit"]{
                display:inline;
                width:auto;
                padding:0.375em;
                margin:1em 3em;
                backgound-color:#ADD8E6;
                color:black;
                cursor:pointer;
            }
        </style>
    </head>
<body>
<form method="POST">
    <fieldset>
    <legend>App User for <b><?php $db_name ?> </b></legend>
    <p><?php echo $_SESSION['tbl-created'] ?></p>
    <p><?php echo $_SESSION['user-created'] ?></p>
    <p><?php echo 'Database name: <b>'.$_SESSION['db-name'].'</b>'; ?></p>
    <p><?php echo 'App DB Username: <b>'.$_SESSION['app-db-user'].'</b>'; ?></p>
    <p><?php echo 'APP DB password: <b><i> Not shown </i></b>' ?></p>
    <?php echo (!empty($_SESSION['app-info'])? $_SESSION['app-info']: ''); ?>
   
   <input type="submit" name="proceed" value="Continue">
    </fieldset>
 </form>
 </body>
 </html>