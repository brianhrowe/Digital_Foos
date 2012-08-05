

<?php
require('Pusher.php');

$pusher = new Pusher("11486c1d5e9edacb7227", "0035b6daa40e3f4c14f3", "25294");

// config variables  
//$match_id = $_GET['goal'];    // time frame (seconds) to count active users  
  
// database connection details  
$db_host = "localhost";     // hostname of your MySQL server. You most likely don't have to change this  
$db_name = "modea_foos";  // database name  
$db_user = "root";         // database user  
$db_pass = "";     // database password  
$db_table= "matches";        // table name  
  
// Lets open up a connection to the database  
$connection = mysql_connect("localhost", "root", "");  
mysql_select_db($db_name, $connection) or die("Error. Cannot connect to database");  

$query = "SELECT * FROM " . $db_table. " WHERE status = 'in_progress' LIMIT 5";
$get_ip = mysql_query($query);
$row = mysql_fetch_array($get_ip);
$match_id = $row["match_id"];
echo "Match ID = $match_id";
if(isset($_GET['goal']) && $_GET['goal'] == "true")
{
print_r($_GET);
	if(isset($_GET['id']) && $_GET['id'] == "ksq_tornado_sport_0001")
	{
	
		$get_ip = mysql_query("SELECT * FROM " . $db_table . " WHERE match_id = " . $match_id . " LIMIT 1");  
		$row = mysql_fetch_array($get_ip);
		$current_game = $row['currentGame'];
		$gameScore = "";
		var_dump($current_game);
		switch($current_game)
		{
			case "1":
				$gameScore = $row['game1Score'];
				$gamewinner = $row['game1Winner'];
			break;
			case "2":
				$gameScore = $row['game2Score'];
				$gamewinner = $row['game2Winner'];
			break;
			case "3":
				$gameScore = $row['game3Score'];
				$gamewinner = $row['game3Winner'];
			break;
		}
		//$gameScore = $row['game1Score'];
		$split = explode('-', $gameScore);
		$status = $row['status'];

		if($gamewinner == "none" && $status != "over")
		{
			$yellowScore = (int)$split[0];
			$blackScore = (int)$split[1];
			if(isset($_GET['team']))
			{
				$team = $_GET['team'];
				changeScore($yellowScore, $blackScore, $team, $current_game);
				$get_ip = mysql_query("SELECT * FROM " . $db_table . " WHERE match_id = " . $match_id . " LIMIT 1");  
				$row = mysql_fetch_array($get_ip);
				$matchWinner = checkMatchWinner(intval($row['currentGame']), $row['game1Winner'], $row['game2Winner'], $row['game3Winner']);
				echo "Match Winner = " . $matchWinner;
				if($matchWinner != "none")
				{
					$get_ip = mysql_query("UPDATE `matches` SET `status`='over'");  
					$get_ip = mysql_query("UPDATE `matches` SET `winner`='$matchWinner'");  
				}
				sendMatchData($pusher, $db_table, $match_id);
			}
		}
	}
	else
	{
		echo "<br /><h1>Nice try! Your browser doesn't look like an Embedded Circuit to me!</h1>";
	}
}

 function changeScore($yellowScore, $blackScore, $team, $current_game)
{
	$curr = intval($current_game);
	switch($team)
	{
		case "y":
			echo "Yellow Goal<br />";
			if($curr < 3)
			{
				if($yellowScore >= 4)
				{
					$get_ip = mysql_query("UPDATE `matches` SET `game" . $current_game . "Winner`='y'");  
					//var_dump($curr);
					if($curr < 3)
						$curr++;
					$get_ip = mysql_query("UPDATE `matches` SET `currentGame`='$curr'");  
					$yellowScore++;
				}
				else
					$yellowScore++; 
			}
			else
			{
				echo "game 3 OT";
				if(($yellowScore + 1) >= ($blackScore + 2) && ($yellowScore + 1) >= 5 || ($yellowScore + 1) == 8)
				{
				echo "win + 2 game 3";
					$get_ip = mysql_query("UPDATE `matches` SET `game" . $current_game . "Winner`='y'");  
					//var_dump($curr);
					$get_ip = mysql_query("UPDATE `matches` SET `currentGame`='$curr'");  
					//$get_ip = mysql_query("UPDATE `matches` SET `status`='over'");  
					//$get_ip = mysql_query("UPDATE `matches` SET `winner`='y'"); 
					$yellowScore++;
				}
				else
					$yellowScore++; 
			}
		break;
		//team2 b y b
		case "b":
			echo "Black Goal<br />";
			if($curr < 3)
			{
				if($blackScore >= 4)
				{
					$get_ip = mysql_query("UPDATE `matches` SET `game" . $current_game . "Winner`='b'");  
					//var_dump($curr);
					if($curr < 3)
					{
						$curr++;
					}
					$get_ip = mysql_query("UPDATE `matches` SET `currentGame`='$curr'");  
					$blackScore++;
				}
				else
					$blackScore++;
			}
			else
			{
				echo "game 3 OT";
				if(($blackScore + 1) >= ($yellowScore + 2) && ($blackScore + 1) >= 5 || ($blackScore + 1) == 8)
				{
				echo "win + 2 game 3";
					$get_ip = mysql_query("UPDATE `matches` SET `game" . $current_game . "Winner`='b'");  
					//var_dump($curr);
					$get_ip = mysql_query("UPDATE `matches` SET `currentGame`='$curr'");  
					//$get_ip = mysql_query("UPDATE `matches` SET `status`='over'");  
					//$get_ip = mysql_query("UPDATE `matches` SET `winner`='b'");  
					$blackScore++;
				}
				else
					$blackScore++; 
			}
			//$get_ip = mysql_query("UPDATE `matches` SET `game1Score`='$yellowScore-$blackScore'");  
		break;
		
		default:
		break;
	}
	$get_ip = mysql_query("UPDATE `matches` SET `game" . $current_game . "Score`='$yellowScore-$blackScore'");  
} 
function checkMatchWinner($current_game, $game1Winner, $game2Winner, $game3Winner)
{
	echo "Checking Winner<br />*******<br />";
	echo "Current Game = $current_game<br />";
	echo "game1Winner = $game1Winner<br />";
	echo "game2Winner = $game2Winner<br />";
	echo "game3Winner = $game3Winner<br />";
	$matchWinner = "none";
	//team1 Y-B-Y
	//team2 B-Y-B
	if(intval($current_game) >= 2 && $game3Winner =="none")
	{
		if($game1Winner == "y" && $game2Winner == "b")
		{
			$matchWinner = "team2";
		}
		else if($game1Winner == "b" && $game2Winner == "y")
		{
			$matchWinner = "team1";
		}
	}
	else if(intval($current_game) == 3)
	{
		if($game3Winner == "y")
			$matchWinner = "team2";
		else
			$matchWinner = "team1";
	}
	return $matchWinner;
}

function sendMatchData($pusher, $db_table, $match_id)
{
	$jsonArray = array();

	$get_ip = mysql_query("SELECT * FROM " . $db_table . " WHERE match_id = " . $match_id . " LIMIT 1");  
	$row = mysql_fetch_array($get_ip);

	$jsonArray["time"] = $row['time'];
	$jsonArray["game1Score"] = $row['game1Score'];
	$jsonArray["game2Score"] = $row['game2Score'];
	$jsonArray["game3Score"] = $row['game3Score'];
	$jsonArray["currentGame"] = $row['currentGame'];
	$jsonArray["team1"] = $row['team1'];
	$jsonArray["team2"] = $row['team2'];
	$jsonArray["player1_1"] = $row['player1_1'];
	$jsonArray["player1_2"] = $row['player1_2'];
	$jsonArray["player2_1"] = $row['player2_1'];
	$jsonArray["player2_2"] = $row['player2_2'];
	$jsonArray["player2_2"] = $row['player2_2'];
	
	$gameScore = "game" . $row['currentGame'] . "Score";
	$gameScore = $row[$gameScore];
	$split = explode('-', $gameScore );
	//var_dump($split);
	$yellowScore = $split[0];
	$blackScore = $split[1];
	
	$jsonArray["yellowScore"] = $yellowScore;
	$jsonArray["blackScore"] = $blackScore;
	
	$game1Winner = "...";
	$game2Winner = "...";
	$game3Winner = "...";
	if($row['game1Winner'] != "none")
	{
		$game1Winner = $row['game1Winner'];
		if($game1Winner == "b")
			$game1Winner .= " - " .  $row['team1'];
		else
			$game1Winner .= " - " .  $row['team2'];
		$game1Winner .= " - " . $jsonArray["game1Score"];
	}
	if($row['game2Winner'] != "none")
	{
		$game2Winner = $row['game2Winner'];
		if($game2Winner == "b")
			$game2Winner .= " - " . $row['team2'];
		else
			$game2Winner .= " - " .  $row['team1'];
		$game2Winner .= " - " . $jsonArray["game2Score"];
	}
	if($row['game3Winner'] != "none")
	{
		$game3Winner = $row['game3Winner'];
		if($game3Winner == "b")
			$game3Winner .= " - " .  $row['team1'];
		else
			$game3Winner .= " - " .  $row['team2'];
		$game3Winner .= " - " . $jsonArray["game3Score"];
	}
	
	$jsonArray["game1Winner"] = $game1Winner;
	$jsonArray["game2Winner"] = $game2Winner;
	$jsonArray["game3Winner"] = $game3Winner;
	
	$table_name = $row['table'];
	$table_arr = explode('_', $table_name);
	//print_r($table_arr);
	$table_name = $table_arr[0] . " " . $table_arr[1] . " " . $table_arr[2];
	$table_name = ucwords($table_name);
	$jsonArray["table"] = $table_name;
	
	if ($row['status'] == "over" && $row)
	{
		//var_dump($row);
		$winner = $row['winner'];
		switch ($winner)
		{
			case "team1":
				$winner = $row['team1'];
			break;
			case "team2":
				$winner = $row['team2'];
			break;
		}
		$jsonArray["status"] = "Game over! Winner: $winner";
	}
	else
	{
		$jsonArray["status"] =  ucwords(convertToPhrase($row['status'] ));
	}
	$pusher->trigger('my-channel', 'my-event', $jsonArray );
}

function convertToPhrase($input) 
{
	$phrase_arr = explode('_', $input);
	$output = "";
	$i;
	for($i = 0; $i < count($phrase_arr); $i++)
	{
		$output = $output.$phrase_arr[$i];
		if(count($phrase_arr) + 1 != $i)
			$output = $output." ";
	}
	return $output;
}
?>