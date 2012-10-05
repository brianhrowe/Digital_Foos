<?php

session_name('tzLogin');
// Starting the session

//session_set_cookie_params(2*7*24*60*60);
// Making the cookie live for 2 weeks

session_start();

$_SESSION = array();
$_SESSION["id"] = -1;
$_SESSION["rememberMe"] = -1;
$_SESSION["usr"] = -1;
$_COOKIE["tzRemember"] = -1;
$arr = array();

session_destroy();



echo json_encode($arr);
	
?>