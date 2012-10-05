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

// Checking whether the Login form has been submitted

$err = array();
// Will hold our errors


if( !isset($_POST['username']) || !isset($_POST['password']) )
{
	$err["success"] = 0;
	$err[] = 'All the fields must be filled in!';
}

if(!count($err))
{
	$_POST['username'] = mysql_real_escape_string($_POST['username']);
	$_POST['password'] = mysql_real_escape_string($_POST['password']);
	$_POST['rememberMe'] = (int)$_POST['rememberMe'];
	
	// Escaping all input data

	//$row = mysql_fetch_assoc(mysql_query("SELECT id,usr FROM tz_members WHERE usr='{$_POST['username']}' AND pass='".md5($_POST['password'])."'"));
	$row = mysql_fetch_assoc(mysql_query("SELECT id,usr FROM tz_members WHERE usr='{$_POST['username']}' AND pass='".$_POST['password']."'"));

	if($row['usr'])
	{
		// If everything is OK login
		
		$_SESSION['usr']=$row['usr'];
		$_SESSION['id'] = $row['id'];
		$_SESSION['rememberMe'] = $_POST['rememberMe'];
		
		// Store some data in the session
		$msg = array();
		$msg["success"] = 1;
		$msg["login_success"] = "You have successfully be logged in!";
		$msg["username"] = $row["usr"];
		echo json_encode($msg);
		setcookie('tzRemember',$_POST['rememberMe']);
	}
	else {
		$err["success"] = 0;
		$err["user_pass"]='Wrong username and/or password!';
	}
}

if(count($err))
{
	echo json_encode($err);
//$_SESSION['msg']['login-err'] = implode('<br />',$err);
}
// Save the error messages in the session

//header("Location: demo.php");
exit;


?>