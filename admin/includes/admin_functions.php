<?php
require_once __DIR__ .'/../../../includes_appDir/DbConnection.php';

/* //Admin user variable */
$user_id =0;
$isEditingUser = false;
$isSearchUser = false;
$username ='';
$role = '';
$email ='';

/* //general variables */
$errors =[];

/* //Topic variables */
$topic_id =0;
$isEditingTopic = false;
$topic_name = '';

/*-----------------------
-- Admin user actions
------------------------*/ 

/* //if user clicks Edit user button */
if(isset($_GET['edit-user'])){
	$isEditingUser = true;
	$user_id = $_GET['edit-user'];
	editUser($user_id);
}
/* //if user clicks Search button */
if(isset($_POST['search_user'])){
	$isSearchUser = true;
	searchUser($_POST['search_user']);
}
/* //if user clicks Update user button */
if(isset($_POST['update_user'])){
	updateUser($_POST['update_user']);
}
/* //if user clicks Delete admin button */
if(isset($_GET['delete-User'])){
	deleteUser($user_id);
}
/*-----------------------------
--Topic actions
------------------------------*/
/* //if user clicks the Create topic button */
if(isset($_POST['create_topic'])){
	createTopic($_POST);
}
/* //if user clicks the Edit topic button */
if(isset($_GET['edit-topic'])){
	$isEditingTopic = true;
	$topic_id = $_GET['edit-topic'];
	editTopic($topic_id);
}
/* //if user clicks the Update topic button */
if(isset($_POST['update_topic'])){
	updateTopic($_POST);
}
/* //if user clicks the Delete topic button */
if(isset($_GET['delete-topic'])){
	$topic_id = $_GET['delete-topic'];
	deleteTopic($topic_id);
}

/*---------------------------------
--Admin user functions
----------------------------------
*/

/* ***************************
--Uses user_id, fetches user from database
--Sets the fields on the form
--Allows only role to be changed
**************************** */
function editUser($user_id){
	global $conn, $username, $role, $isEditingUser, $user_id, $email;
	
	$sql = "SELECT * FROM `users` WHERE user_id=$user_id";
	$result = mysqli_query($conn, $sql);
	$user = mysqli_fetch_assoc($result);
	
	/* //Set fields on the form: One field "User role" will be editable */
	$username = $user['username'];
	$email = $user['email'];
	$user_id = $user['user_id'];
}

/**********************************
*--Takes user id from the form 
*--Updates user role on the database
**********************************/
function updateUser($request_values){
	global $conn, $user_id, $role, $isEditingUser, $errors;
	
	/* //get id of the user to be updated */
	$user_id = $_POST['user_id'];
	/* //set editing state to false */
	$isEditingUser = false;
	/* //set search user state to false */
	$isSearchUser = false;
	
	if(isset($_POST['role'])){
		$role = $_POST['role'];
	}
	
	/* //update user role if no errors on the form */
	if(!$errors){
		if($role =='Admin'){
			$query = "UPDATE `users` SET role_id=1, updated_at=now() WHERE user_id=$user_id";
		}elseif($role == 'Author'){
			$query = "UPDATE `users` SET role_id=2, updated_at=now() WHERE user_id=$user_id";
		}elseif($role == 'User'){
			$query = "UPDATE `users` SET role_id=3, updated_at=now() WHERE user_id=$user_id";
		}		
		if(mysqli_query($conn, $query)){
			$_SESSION['message'] = 'User role update successful';
			header('Location: users.php');
			exit(0);
		}		
	}
}
function searchUser($request_values){
	global $conn, $user_id, $username, $email, $isSearchUser, $errors;
		
	if(isset($_POST['username']) || isset($_POST['email'])){
		
		$username = $_POST['username'];
		$email = $_POST['email'];
		
		$query = "SELECT * FROM `users` WHERE username='$username' OR email='$email'";
		
		$result = mysqli_query($conn, $query);
		if($result){
			$user_record = mysqli_fetch_assoc($result);
			
			$user_id =$user_record['user_id'];
			$username = $user_record['username'];
			$email = $user_record['email'];
			if(empty($user_record)){
				array_push($errors, 'User not found');
			}		
		}else{
			echo 'Error has occured!';
		}
	}
}

/*******************************************
*--Returns all admin users with their roles
********************************************/
function getAdminUsers(){
	global $conn, $role;
	
	$sql = "SELECT * FROM `users` WHERE role_id=1 || role_id=2";
	$result = mysqli_query($conn, $sql);
	$users = mysqli_fetch_all($result, MYSQLI_ASSOC);
	
	$final_users = array();
	foreach($users as $user){
		$user['role'] = getUserRole($user['role_id']);
		array_push($final_users, $user);
	}
	return $final_users;
}

function getUserRole($role_id){
	global $conn;
	
	$query = "SELECT role FROM `roles` WHERE role_id=$role_id";
	$result = mysqli_query($conn, $query);
	
	if($result){
		$role = mysqli_fetch_assoc($result);
		return $role['role'];
	}else{
		return null;
	}	
}
/*******************************************
*--Returns first 20 subscribers
********************************************/
function getSubscribers(){
	global $conn;
	$sql ="SELECT * FROM `subscribers` WHERE subscribed=1 LIMIT 20";
	$result = mysqli_query($conn, $sql);
	if($result){
		$subscribers = mysqli_fetch_all($result, MYSQLI_ASSOC);
		return $subscribers;
	}else{
		return null;
	}
}
/**************************************
*-Escapes from submitted values
*-to prevent mysql injection
*************************************/
function esc(string $value){
	global $conn;
	
	$val = trim($value);
	$val = mysqli_real_escape_string($conn, $val);
	return $val;
}

/******************************************
*-Recieve a string like "sunny sand beaches" and
*-returns "sunny-sand-beaches"
******************************************/
function makeSlug(string $string){
	$string = strtolower($string);
	$slug = preg_replace('/[^A-za-z,0-9-]+/', '-',$string);
	return $slug;
}

/*----------------------------------
--Topic functions
-----------------------------------*/

/* //Get all topics from database */

function getAllTopics(){
	global $conn;
	
	$sql = "SELECT * FROM `topics`";
	$result = mysqli_query($conn, $sql);
	$topics = mysqli_fetch_all($result, MYSQLI_ASSOC);
	
	return $topics;
}

function createTopic($request_values){
	global $conn, $errors, $topic_name;
	
	$topic_name = esc($request_values['topic_name']);
	/* //create slug */
	$topic_slug = makeSlug($topic_name);
	/* //Validate form  */
	if(empty($topic_name)){
		array_push($errors, 'Topic name required.');
	}
	/* //To ensure that no topic is saved twice */
	$topic_check_query = "SELECT  * FROM `topics` WHERE topic_slug='$topic_slug' LIMIT 1";
	$result = mysqli_query($conn, $topic_check_query);
	if(mysqli_num_rows($result)>0){
		array_push($errors, 'Topic already exist');
	}
	/* //Register topic if no errors */
	if(count($errors) === 0){
		$query = "INSERT INTO `topics`(topic_name, topic_slug) VALUES ('$topic_name', '$topic_slug')";
		mysqli_query($conn, $query);
		
		$_SESSION['message'] = 'Topic created successfully.';
		header('Location: topics.php');
		exit(0);		
	}
}

/***********************************
*-Fetches a topic from database
*-Sets it on the form for editing
***********************************/
function editTopic($topic_id){
	global $conn, $topic_name, $isEditicTopic, $topic_id;
	
	$sql = "SELECT * FROM `topics` WHERE topic_id=$topic_id LIMIT 1";
	$result = mysqli_query($conn, $sql);
	$topic = mysqli_fetch_assoc($result);
	
	/* //Set topic_name to be updated on the form */
	$topic_name = $topic['topic_name'];
}

function updateTopic($request_values){
	global $conn, $topic_name, $errors, $topic_id;
	
	$topic_name = esc($request_values['topic_name']);
	$topic_id = esc($request_values['topic_id']);
	
	/* //Create slug */
	$topic_slug = makeSlug($topic_name);
	
	/* //Validate form */
	if(empty($topic_name)){
		array_push($errors, 'Topic name is required.');
	}
	
	/* //Register topic if there are no errors */
	if(count($errors) == 0){
		$query = "UPDATE `topics` SET topic_name='$topic_name', topic_slug='$topic_slug' WHERE topic_id=$topic_id";
		mysqli_query($conn, $query);
		
		$_SESSION['message'] = 'Topic updated successfully.';
		header('Location:topics.php');
		exit(0);
	}
}

/* //Delete topic */
function deleteTopic($topic_id){
	global $conn;
	
	$sql = "DELETE FROM `topics` WHERE topic_id=$topic_id";
	if(mysqli_query($conn, $sql)){
		$_SESSION['message'] = 'Topic deleted successfull.';
		header('Location: topics.php');
		exit(0);
	}
}