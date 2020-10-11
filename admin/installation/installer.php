<?php
session_start();
global $error,$email_error,$safe_mode_error,$mysql_version,$db_host,$db_username,$db_password;
//Run pre-installation checks
include __DIR__ .'/../pre-installation/php-version.php';
include __DIR__ .'/../pre-installation/php-state.php';
if($error){
    echo $error;
}else{
    $php_v = 'PHP version ' .$php_version. ', OK <br>';
    $_SESSION['php-v'] = $php_v;
}
//include __DIR__ .'/../pre-installation/php-state.php';
if(!empty($safe_mode_error)){
    echo $safe_mode_error;
}else if(!empty($mail_error)){
    echo $email_error;
}else{
    include __DIR__ .'/../pre-installation/mysql-version.php';
}