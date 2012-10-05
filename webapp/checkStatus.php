<?php

session_name('tzLogin');
// Starting the session

//session_set_cookie_params(2*7*24*60*60);
// Making the cookie live for 2 weeks

session_start();
$arr = array();
$arr["id"] = $_SESSION["id"];
$arr["rememberMe"] = $_SESSION["rememberMe"];
$arr["usr"] = $_SESSION["usr"];
$arr["tzRemember"] = $_COOKIE["tzRemember"];
echo json_encode($arr);
?>