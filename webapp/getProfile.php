<?php
// database connection details  
$db_host = "localhost";     // hostname of your MySQL server. You most likely don't have to change this  
$db_name = "modea_foos";  // database name  
$db_user = "root";         // database user  
$db_pass = "";     // database password  
$db_table= "users_accounts";        // table name  
  
// Lets open up a connection to the database  
$connection = mysql_connect("localhost", "root", "");  
mysql_select_db($db_name, $connection) or die("Error. Cannot connect to database");  

$userid = $_GET['playerid'];
//print_r($_GET);

$query = "SELECT * FROM " . $db_table. " WHERE userid = $userid";
$get_ip = mysql_query($query);
$row = mysql_fetch_array($get_ip);
//print_r($row);
//print_r($row);
$jsonArray = array();

$jsonArray = buildPlayer($row);

echo json_encode($jsonArray);

function buildPlayer($row)
{
	$arr = array();
	$arr['id'] = $row['userid'];
	$arr['email'] = $row['email'];
	$arr['username'] = $row['username'];
	$arr['password'] = $row['password'];
	$arr['handle'] = $row['user_handle'];
	$arr['firstName'] = $row['first_name'];
	$arr['lastName'] = $row['last_name'];
	$arr['height'] = $row['height'];
	$arr['weight'] = $row['weight'];
	$arr['dob'] = $row['dob'];
	$arr['avatar'] = $row['avatar'];
	$arr['jersey'] = $row['jersey'];
	$arr['teams'] = $row['teams'];
	$arr['bio'] = $row['bio'];
	$arr['motto'] = $row['motto'];
	$arr['playStyle'] = $row['play_style'];
	$arr['shots'] = $row['shots'];
	return $arr;
}
?>