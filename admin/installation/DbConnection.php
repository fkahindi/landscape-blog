<?php
require_once __DIR__ . '/DbCredentials.php';

//Create connection using mysqli object
$conn = new mysqli(DB_SERVER, DB_USERNAME,DB_PASSWORD,DB_NAME);
//Check connection
if($conn->connect_error){
	die('Could not connect: ' .$conn->connect_error);
}