
<?php

// database connection details  
$db_host = "localhost";     // hostname of your MySQL server. You most likely don't have to change this  
$db_name = "modea_foos";  // database name  
$db_user = "root";         // database user  
$db_pass = "";     // database password  
$db_table= "matches";        // table name  
  
// Lets open up a connection to the database  
$connection = mysql_connect($db_host, $db_user, $db_pass);  
mysql_select_db($db_name, $connection) or die("Error. Cannot connect to database");  
//print_r($_POST);

$table = $_POST['table'];
$team1 = $_POST['team1'];
$team2 = $_POST['team2'];
$player1_1 = $_POST['player1_1'];
$player1_2 = $_POST['player1_2'];
$player2_1 = $_POST['player2_1'];
$player2_2 = $_POST['player2_2'];

//Check for games in progress
$query = "SELECT * FROM " . $db_table. " WHERE status = 'in_progress' LIMIT 5";
$result = mysql_query($query);
$row = mysql_fetch_array($result);
if($row >= 1)
{
	echo "There is currently already a Match in progress on the $table table with the Match ID: <a href=./match.html?match_id=" . $row["match_id"] . ">" . $row["match_id"] . "</a>.";
}
else 
{
	//$query = "INSERT INTO matches (table, team1, team2, player1_1, player1_2, player2_1, player2_2) VALUES ('$table', '$team1', '$team2', '$player1_1', '$player1_2', '$player2_1', '$player2_2')";
	$query = "INSERT INTO matches (`table`, `team1`, `team2`, `player1_1`, `player1_2`, `player2_1`, `player2_2`) VALUES ('$table', '$team1', '$team2', '$player1_1', '$player1_2', '$player2_1', '$player2_2')";
	$result = mysql_query($query,$connection);
	if ($result == false)
	{
	  die('Error: ' . mysql_error());
	}
	else
	{
		echo "<h3>Starting Match...</h3>";
		header("Location: match.html?match_id=".mysql_insert_id());
		exit;
	}
	//mysql_query($query, $connection);
	
}
?>
