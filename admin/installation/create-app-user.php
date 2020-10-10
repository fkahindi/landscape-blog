<?php
if(!isset($_SESSION)){
    session_start();
}
set_time_limit(0);
global $app_db_user,$app_db_pass;

$app_db_user = $_SESSION['db-name'].'_app_login';
$app_db_pass = generate_password();
try{
    $pdo = new PDO("mysql:host=" . $_SESSION['server-host'], $_SESSION['server-admin'], $_SESSION['server-password']);
        // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = "CREATE USER '" . $app_db_user . "'@'localhost' IDENTIFIED BY '" . $app_db_pass . "';
    GRANT SELECT , INSERT , UPDATE , DELETE ON " . $_SESSION['db-name'] . " . * TO '" . $app_db_user . "'@'localhost'";

    $stmt = $pdo->prepare($query);
    if ($stmt->execute()){
        $_SESSION['user-created'] = 'App user created successful';
        $_SESSION['app-db-user'] = $app_db_user;
                
        //create necessary files for DB connection. Folder will reside above web root folder, three levels up from the installation folder.
        $dir_path = '../../../includes_appDir/';
        $file_name = 'DbCredentials.php';
        $file_path = $dir_path.$file_name;
        makeDir($dir_path);
        //file in the  director
        if(!is_file($file_path)){
         $contents = "<?php \n define ('DB_SERVER','localhost');\n define('DB_NAME','".$_SESSION['db-name']."');\n define('DB_USERNAME','$app_db_user');\n define('DB_PASSWORD','$app_db_pass');
         ";
        //Save content to the file.
        file_put_contents($file_path, $contents);
        }
        //In production move following files in $dir_path
        copy('DatabaseConnection.php',$dir_path.'DatabaseConnection.php');
        copy('DbConnection.php',$dir_path.'DbConnection.php');
        copy('EmailCredential.php',$dir_path.'EmailCredential.php');
        $classes_folder ='../../classes/';
        makeDir($classes_folder);
        copy('classes/DatabaseTable.php',$classes_folder.'DatabaseTable.php');
        
        $_SESSION['app-info'] = "<ol><li>Database login credentials and other important files for the functinality of the application have been placed in <b><i>" .$dir_path. "</i></b> folder (idealy above the web root folder) for security.</li><li>If you change the db_user password in this file, you have to update it in the database, otherwise the application will fail.</li><li>Open the EmailCredential file located in " .$dir_path. " in a text editor and add the <b>email</b> and <b>password</b> of the mail exchange server you are using. </li></ol>"; 
        
        header('Location: app-info.php');
    }else{ 
     echo "App user creation failed";
    }  
}catch(PDOException $e){
    die("ERROR: Could not connect. " . $e->getMessage());
}   
//Directory function
function makeDir($path){
 $ret = @mkdir($path); // use @mkdir to suppress warnings/errors
 return $ret === true || is_dir($path);
}
function generate_password($length = 15){
  $chars =  'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'.
            '0123456789`-=~!@#$%^&*()_+,./<>?;:[]{}\|';

  $str = '';
  $max = strlen($chars) - 1;

  for ($i=0; $i < $length; $i++)
    $str .= $chars[mt_rand(0, $max)];

  return $str;
}

