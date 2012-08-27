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

if(isset($_POST['submit']) && $_POST['submit']=='Register')
{
	// If the Register form has been submitted
	
	$err = array();
	//for errors
	
	//Check for errors
	if(strlen($_POST['username'])<4 || strlen($_POST['username'])>32)
	{	//if username isn't between 3 and 32 characters
		$err[]='Your username must be between 3 and 32 characters!';
	}
	
	if(preg_match('/[^a-z0-9\-\_\.]+/i',$_POST['username']))
	{	//if username contains invalid characters
		$err[]='Your username contains invalid characters!';
	}
	
	if(!checkEmail($_POST['email']))
	{	//if email is not valid
		$err[]='Your email is not valid!';
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
		
		if(mysql_affected_rows($link)==1)
		{
		//	send_mail(	'demo-test@tutorialzine.com',
			//			$_POST['email'],
				//		'Registration System Demo - Your New Password',
					//	'Your password is: '.$pass);

			$_SESSION['msg']['reg-success']='Your profile has been created!';
		}
		else $err[]='This username is already taken!';
	}

	if(count($err))
	{
		$_SESSION['msg']['reg-err'] = implode('<br />',$err);
	}	
	
	header("Location: register.php");
	exit;
}

?>

<form action="" method="post">
	<h1>Not a member yet? Sign Up!</h1>		
	
	<?php
		
		if(isset($_SESSION['msg']['reg-err']))
		{
			echo '<div class="err">'.$_SESSION['msg']['reg-err'].'</div>';
			unset($_SESSION['msg']['reg-err']);
		}
		
		if(isset($_SESSION['msg']['reg-success']))
		{
			echo '<div class="success">'.$_SESSION['msg']['reg-success'].'</div>';
			unset($_SESSION['msg']['reg-success']);
		}
	?>
			
	<label class="grey" for="username">Username:</label>
	<input class="field" type="text" name="username" id="username" value="" size="23" />
	<label class="grey" for="email">Email:</label>
	<input class="field" type="text" name="email" id="email" size="23" />
	<label class="grey" for="password">Password:</label>
	<input class="field" type="text" name="password" id="password" size="23" />
	<input type="submit" name="submit" value="Register" class="bt_register" />
</form>
</div>