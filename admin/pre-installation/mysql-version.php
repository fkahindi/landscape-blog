<?php

// After database connection, check mysql version before installation

// declare function
function find_SQL_Version() {
  $output = shell_exec('mysql -V');
  preg_match('@[0-9]+\.[0-9]+\.[0-9]+@', $output, $version);
  return @$version[0]?$version[0]:-1;
}
 
$mysql_version=find_SQL_Version();
if($mysql_version<5)
{
  if($mysql_version==-1){
    $mysql_error="MySQL version will be checked at the next step. <br>";
    $_SESSION['mysql-error'] = $mysql_error;
    header('Location: ../installation/db-settings-form.php');
    
  } 
  else{
    $mysql_error="MySQL version is $mysql_version. Version 5 or newer is required. <br>";
    
  } 
}else{
    $mysql_v = 'MySQL version ' .$mysql_version;
    $_SESSION['mysql-v'] = $mysql_v;
    header('Location: ../installation/db-settings-form.php');
}
