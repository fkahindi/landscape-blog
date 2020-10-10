<?php
require_once __DIR__ . '/DbCredentials.php';

//Create connection using PDO object	
$pdo = new PDO('mysql:host='.DB_SERVER . ';dbname='.DB_NAME .'; charset=utf8', DB_USERNAME,DB_PASSWORD);
	
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);