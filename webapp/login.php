<?php

// database connection details  
$db_host = "localhost";     // hostname of your MySQL server. You most likely don't have to change this  
$db_name = "modea_foos";  // database name  
$db_user = "root";         // database user  
$db_pass = "";     // database password  
$db_table= "user_accounts";        // table name  
  
// Lets open up a connection to the database  
$connection = mysql_connect($db_host, $db_user, $db_pass);  
mysql_select_db($db_name, $connection) or die("Error. Cannot connect to database");  

if($_POST[username] !=” || $_POST[password] != ”) {
$login_status = login($_POST[username], $_POST[password]);
} else if($_GET[logout]) {
logout();
}
$userid = status();

?>

<form action="sample.php" method="POST">
<input type=text name=username>
<input type=password name=password>
<input type=submit value="Log In">
</form>

<?php ?>