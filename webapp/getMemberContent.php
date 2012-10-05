<?php
// database connection details  
$db_host = "localhost";     // hostname of MySQL server. You most likely don't have to change this  
$db_name = "modea_foos";  // database name  
$db_user = "root";         // database user  
$db_pass = "";     // database password  
$db_table= "users_accounts";        // table name  
  
// Lets open up a connection to the database  
$connection = mysql_connect("localhost", "root", "");  
mysql_select_db($db_name, $connection) or die("Error. Cannot connect to database");  

echo "<h1>Members panel</h1>
<p>You can put member-only data here</p>
<a href=\"registered.php\">View a special member page</a>
<p>- or -</p>
<div>
	<a id=\"logout\" href=\"#\">Log off</a>
</div>";

?>