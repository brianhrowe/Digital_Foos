<?php


define('INCLUDE_CHECK',true);

require 'connect.php';
require './login-demo/functions.php';
// Those two files can be included only if INCLUDE_CHECK is defined


session_name('tzLogin');
// Starting the session

session_set_cookie_params(2*7*24*60*60);
// Making the cookie live for 2 weeks

session_start();
	
$err = array();
//for errors

//Check for errors
if(strlen($_POST['username']) < 4 || strlen($_POST['username'])>32)
{	//if username isn't between 4 and 32 characters
	$err["success"] = 0;
	$err["user_num"]='Your username must be between 4 and 32 characters!';
}

if(preg_match('/[^a-z0-9\-\_\.]+/i',$_POST['username']))
{	//if username contains invalid characters
		$err["success"] = 0;
	$err["user_char"]='Your username contains invalid characters!';
}

if(strlen($_POST['password'])<4 || strlen($_POST['password'])>32)
{	//if password isn't between 4 and 32 characters
	$err["success"] = 0;
	$err["password"]='Your password must be between 4 and 32 characters!';
}

if(!checkEmail($_POST['email']))
{	//if email is not valid
		$err["success"] = 0;
	$err["email"]='Your email is not valid!';
}

// If there are no errors
if(!count($err))
{	
	//$pass = substr(md5($_SERVER['REMOTE_ADDR'].microtime().rand(1,100000)),0,6);
	// Generate a random password
	
	$_POST['email'] = mysql_real_escape_string($_POST['email']);
	$_POST['username'] = mysql_real_escape_string($_POST['username']);
	$_POST['password'] = mysql_real_escape_string($_POST['password']);
	// Escape the input data
	
	$pass = $_POST['password'];
	
	mysql_query("	INSERT INTO users_accounts(username,password,email,regIP,dt)
					VALUES(
					
						'".$_POST['username']."',
						'".$pass."',
						'".$_POST['email']."',
						'".$_SERVER['REMOTE_ADDR']."',
						NOW()
						
					)");
	
	$res = mysql_insert_id();
	
	if(mysql_affected_rows($link)==1)
	{
	//	send_mail(	'demo-test@tutorialzine.com',
		//			$_POST['email'],
			//		'Registration System Demo - Your New Password',
				//	'Your password is: '.$pass);

		//$_SESSION['msg']['reg-success']='Your profile has been created!';
		$msg = array();
		$msg['success'] = 1;
		$msg['reg_success'] = "Your Profile has been created!";
		echo json_encode($msg);
	}
	else {
		$err["success"] = 0;
		$err["user_exists"]='This username is already taken!' . strval($res);
	}
}

if(count($err))
{
	//$_SESSION['msg']['reg-err'] = implode('<br />',$err);
	echo json_encode($err);
}	

//header("Location: register.php");
exit;

?>