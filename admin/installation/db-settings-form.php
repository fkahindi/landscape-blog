<?php
if(!isset($_SESSION)){
    session_start();
}
global $valid,$db_host,$db_username,$db_password;
if(isset($_POST['create-db'])){
    $valid = true;
    $_SESSION['server-host'] = $_POST['server-host'];
    //$server_host = $_POST['server-host'];
     $_SESSION['server-password'] = $_POST['server-password'];
    //$server_password = $_POST['server-password'];
    $_SESSION['db-name'] = $_POST['db-name'];
    //$db_name = $_POST['db-name'];
    $_SESSION['server-admin'] = $_POST['server-admin'];
    //$server_admin = $_POST['server-admin'];
  if(empty($_POST['server-host'])){
    $valid = false;
    $host_error = 'Host is required'; 
  } 
  if(empty($_POST['server-admin'])){
      $valid = false;
    $user_error = 'Admin required';
  } 
  if(empty($_POST['server-password'])){
    $valid = false;
    $password_error = 'Password required';
  } 
  if(empty($_POST['db-name'])){
    $valid = false;
    $db_name_error = 'Database name required';
  } 
}
if($valid){
    try{
        $pdo = new PDO("mysql:host=" . $_SESSION['server-host'], $_SESSION['server-admin'], $_SESSION['server-password']);
        // Set the PDO error mode to exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = "CREATE DATABASE IF NOT EXISTS `".$_SESSION['db-name']."` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci";
        $stmt = $pdo->prepare($query);
        if ($stmt->execute()){
            //Create database tables
            $sql ="USE `".$_SESSION['db-name']."`; 
            CREATE TABLE IF NOT EXISTS `comments` (
              `comment_id` int(11) NOT NULL AUTO_INCREMENT,
              `user_id` int(11) DEFAULT NULL,
              `post_id` int(11) DEFAULT NULL,
              `body` text,
              `created_at` timestamp NOT NULL ON UPDATE CURRENT_TIMESTAMP,
              `updated_at` timestamp NULL DEFAULT NULL,
              PRIMARY KEY (`comment_id`),
              KEY `post_id` (`post_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
            CREATE TABLE IF NOT EXISTS `password_reset_temp` (
              `email` varchar(250) NOT NULL,
              `token` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
              `expDate` datetime DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
            CREATE TABLE IF NOT EXISTS `permissions` (
              `permission_id` int(11) NOT NULL AUTO_INCREMENT,
              `name` varchar(255) NOT NULL,
              `description` text NOT NULL,
              PRIMARY KEY (`permission_id`),
              UNIQUE KEY `name` (`name`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
            CREATE TABLE IF NOT EXISTS `permission_role` (
              `permission_role_id` int(11) NOT NULL AUTO_INCREMENT,
              `role_id` int(11) NOT NULL,
              `permission_id` int(11) NOT NULL,
              PRIMARY KEY (`permission_role_id`),
              KEY `role_id` (`role_id`),
              KEY `permission_id` (`permission_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
            CREATE TABLE IF NOT EXISTS `posts` (
              `post_id` int(11) NOT NULL AUTO_INCREMENT,
              `user_id` int(11) NOT NULL,
              `post_title` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
              `post_slug` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
              `post_body` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
              `meta_description` text,
              `published` tinyint(1) NOT NULL DEFAULT '0',
              `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
              `image_caption` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
              `created_at` timestamp NULL DEFAULT NULL,
              `updated_at` timestamp NULL DEFAULT NULL,
              `metaphoned` text,
              PRIMARY KEY (`post_id`),
              UNIQUE KEY `slug` (`post_slug`),
              KEY `user_post_relation` (`user_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
            CREATE TABLE IF NOT EXISTS `post_topic` (
              `post_topic_id` int(11) NOT NULL AUTO_INCREMENT,
              `topic_id` int(11) NOT NULL,
              `post_id` int(11) NOT NULL,
              PRIMARY KEY (`post_topic_id`),
              KEY `post_id` (`post_id`),
              KEY `post_topic_topics_relationship` (`topic_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
            CREATE TABLE IF NOT EXISTS `replies` (
              `reply_id` int(11) NOT NULL AUTO_INCREMENT,
              `user_id` int(11) DEFAULT NULL,
              `comment_id` int(11) DEFAULT NULL,
              `body` text,
              `created_at` timestamp NULL DEFAULT NULL,
              `updated_at` timestamp NULL DEFAULT NULL,
              PRIMARY KEY (`reply_id`),
              KEY `comment_id` (`comment_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
            CREATE TABLE IF NOT EXISTS `roles` (
              `role_id` int(11) NOT NULL AUTO_INCREMENT,
              `role` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
              `description` text NOT NULL,
              PRIMARY KEY (`role_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
            CREATE TABLE IF NOT EXISTS `subscribers` (
              `subscribe_id` int(11) NOT NULL AUTO_INCREMENT,
              `name` varchar(50) DEFAULT NULL,
              `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
              `subscribed` tinyint(2) NOT NULL DEFAULT '1',
              `created_at` datetime NOT NULL,
              PRIMARY KEY (`subscribe_id`),
              UNIQUE KEY `email` (`email`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
            CREATE TABLE IF NOT EXISTS `subscribe_temp_tbl` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
              `email` varchar(255) NOT NULL,
              `token` varchar(255) NOT NULL,
              `created_at` datetime NOT NULL,
              PRIMARY KEY (`id`),
              UNIQUE KEY `email` (`email`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
            CREATE TABLE IF NOT EXISTS `topics` (
              `topic_id` int(6) NOT NULL AUTO_INCREMENT,
              `topic_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
              `topic_slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
              PRIMARY KEY (`topic_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
            CREATE TABLE IF NOT EXISTS `users` (
              `user_id` int(11) NOT NULL AUTO_INCREMENT,
              `role_id` int(11) DEFAULT '3',
              `fullname` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
              `username` varchar(255) NOT NULL,
              `profile_photo` varchar(255) DEFAULT NULL,
              `email` varchar(255) NOT NULL,
              `password` varchar(255) NOT NULL,
              `created_at` datetime NOT NULL,
              `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
              PRIMARY KEY (`user_id`),
              UNIQUE KEY `username` (`username`),
              UNIQUE KEY `email` (`email`),
              KEY `users_ibfk_1` (`role_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
            CREATE TABLE IF NOT EXISTS `users_temp` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `fullname` varchar(30) DEFAULT NULL,
              `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
              `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
              `token` varchar(255) NOT NULL,
              `created_at` datetime NOT NULL,
              PRIMARY KEY (`id`),
              UNIQUE KEY `email` (`email`),
              UNIQUE KEY `username` (`username`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
            ALTER TABLE `comments`
                ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE ON UPDATE RESTRICT;
            ALTER TABLE `permission_role`
                ADD CONSTRAINT `permission_role_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE,
                ADD CONSTRAINT `permission_role_ibfk_2` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`permission_id`);
            ALTER TABLE `posts`
                ADD CONSTRAINT `user-post_relations` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE RESTRICT;
            ALTER TABLE `post_topic`
              ADD CONSTRAINT `post_topic_topics_relationship` FOREIGN KEY (`topic_id`) REFERENCES `topics` (`topic_id`) ON DELETE CASCADE ON UPDATE RESTRICT;
  
            ALTER TABLE `replies`
                ADD CONSTRAINT `replies_ibfk_1` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`comment_id`) ON DELETE CASCADE ON UPDATE RESTRICT;
            ALTER TABLE `users`
                ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`) ON DELETE SET NULL;
            INSERT INTO `roles` (`role`,`description`) VALUES ('Admin','Manages the whole database, users and their roles'),('Author','Can post articles and manage what they have posted'),('User','Can only read what others have been posted');
             ";
            $db_stmts = $pdo->prepare($sql);
            if ($db_stmts->execute()){
                
                $_SESSION['tbl-created'] = 'Tables created successfully';
                require_once __DIR__ .'/create-app-user.php';                 
            }else{ 
                 echo "Database created but tables failed";
            }
        }else{ 
             echo "Database creation fail";
        }
    }catch(PDOException $e){
        die("ERROR: Could not connect. " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
		<meta name="author" content="Developerspot.co.ke">
		<title>Create Site Database</title>
        <style>
            form{
                width:400px;
                margin:4em auto;
                font-family:'Helvetica',Sans-serif;
            }
            label,input[type="submit"]{
                display:block;
                margin:2em 3px;
                font-size:1em;
                font-weight:bold;
                
            }
            input{
                display:block;
                width:70%;
                margin-top:5px;
                 padding:0.2em;
                font-family:serif,Arial;
                font-size:1.15em
            }
            input[type="submit"]{
                width:auto;
                padding:0.375em auto;
                backgound-color:#ADD8E6;
                color:black;
                cursor:pointer;
            }
            .error, .red{
                color:red;
                font-size:0.75em;
            }
        </style>
    </head>
<body>
<form method="POST">

    <fieldset>
    <legend>Create database and required tables</legend>
    <div><?php echo(!empty($_SESSION['php-v'])? $_SESSION['php-v']:''); ?></div>
    <div><?php echo(!empty($_SESSION['mysql-error'])? $_SESSION['mysql-error']:''); ?></div><br>
    <div><?php echo(!empty($_SESSION['mysql-v'])? $_SESSION['mysql-v']:''); ?></div><br>
    <label for="db-host">
    Db host: <input type="text" name="server-host" value="localhost">
    <span class="error"><?php echo(empty($host_error)? '': $host_error);?></span>
    </label>
    
    <label for="server-admin">
    Db admin user: <input type="text" name="server-admin">
    <span class="error"><?php echo(empty($user_error)? '': $user_error);?></span>
    </label>
    
    <label for="server-password">
    Password: <input type="password" name="server-password" autocomplete="off">
    <span class="error"><?php echo(empty($password_error)? '': $password_error);?></span>
    </label>
    <label for="db-name">
    Database name to create: <input type="text" name="db-name" autocomplete="off">
    <span class="error"><?php echo(empty($db_name_error)? '': $db_name_error);?></span>
    </label>
    <p>Name should not have spaces. Use underscore for compound names.</p>
    </fieldset>
    <input type="submit" name="create-db" value="Create Database">
 </form>
 </body>
 </html>