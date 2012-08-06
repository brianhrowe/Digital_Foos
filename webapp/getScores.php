<?php  
header('Content-Type: text/html; charset=UTF-8');  
header('Cache-Control: no-cache');  
header('Pragma: no-cache');  
  
// config variables  
//if(isss)
if(isset($_POST['match_id']))
{
	$match_id = $_POST['match_id'];    // time frame (seconds) to count active users  
}
else if(isset($_GET['match_id']))
{
	$match_id = $_GET['match_id'];    // time frame (seconds) to count active users  
} 

// database connection details  
$db_host = "localhost";     // hostname of your MySQL server. You most likely don't have to change this  
$db_name = "modea_foos";  // database name  
$db_user = "root";         // database user  
$db_pass = "";     // database password  
$db_table= "matches";        // table name  
  
// Lets open up a connection to the database  
$connection = mysql_connect($db_host, $db_user, $db_pass);  
mysql_select_db($db_name, $connection) or die("Error. Cannot connect to database");  
  
$yellowScore = 0;
$blackScore = 0;
$in_progress = "";



// update database for returning visitor  
$get_ip = mysql_query("SELECT * FROM " . $db_table . " WHERE match_id = " . $match_id . " LIMIT 1");  
$row = mysql_fetch_array($get_ip);

if(!$row)
{
	echo "Currently No Match being played with MatchID: $match_id";
}
else
{
	$jsonArray = array();
	$time = $row['time'];
	 $jsonArray["time"] = $time;
	$game1Score = $row['game1Score'];
	 $jsonArray["game1Score"] = $game1Score;
	$in_progress = $row['status'];
	 $jsonArray["status"] = $in_progress;
	$current_game = $row['currentGame'];
	 $jsonArray["currentGame"] = $current_game;
	$team1 = $row['team1'];
	 $jsonArray["team1"] = $team1;
	$team2 = $row['team2'];
	 $jsonArray["team2"] = $team2;
	$player1_1 = $row['player1_1'];
	 $jsonArray["player1_1"] = $player1_1;
	$player1_2 = $row['player1_2'];
	 $jsonArray["player1_2"] = $player1_2;
	$player2_1 = $row['player2_1'];
	 $jsonArray["player2_1"] = $player2_1;
	$player2_2 = $row['player2_2'];
	 $jsonArray["player2_2"] = $player2_2;
	 
	$jsonArray["game1Score"] = $row['game1Score'];
	$jsonArray["game2Score"] = $row['game2Score'];
	$jsonArray["game3Score"] = $row['game3Score'];
	
	//////////Long Polling;
/* 	if( isset($_POST['poll']) && $_POST['poll'] == true ){
		if(isset($_POST['browserGame']) && $_POST['browserGame'] == true ){
			$browserGame = $_POST['browserGame'];
			if(isset($_POST['browserScore']) && $_POST['browserScore'] == true ){
				$browserScore = $_POST['browserScore'];
				//echo "Poll = true <br />Browser Game = $browserGame <br />Browser Score = $browserScore<br />";
				$gameSearch = "game" . $row['currentGame'] . "Score";
				//echo "Poll = true <br />Current Game = ". $row['currentGame'] . "<br />Current Score = " . $row[$gameSearch] . "<br />";
				while( ($row['currentGame'] == $browserGame && $row[$gameSearch] == $browserScore))
				{
					//echo "Need to Update<br />";
					$get_ip = mysql_query("SELECT * FROM " . $db_table . " WHERE match_id = " . $match_id . " LIMIT 1");  
					$row = mysql_fetch_array($get_ip);
					$browserGame = $row['currentGame'];
					$browserScore = $row[$gameSearch];
				}
				
				//echo "New <br />Poll = true <br />Browser Game = $browserGame <br />Browser Score = $browserScore<br />";
				//echo "Poll = true <br />Current Game = ". $row['currentGame'] . "<br />Current Score = " . $row[$gameSearch] . "<br />";
			}
		}
	}
	if( isset($_GET['poll']) && $_GET['poll'] == true ){
		if(isset($_GET['browserGame']) && $_GET['browserGame'] == true ){
			$browserGame = $_GET['browserGame'];
			if(isset($_GET['browserScore']) && $_GET['browserScore'] == true ){
				$browserScore = $_GET['browserScore'];
				$gameSearch = "game" . $row['currentGame'] . "Score";
				while( ($row['currentGame'] == $browserGame && $row[$gameSearch] == $browserScore) )
				{
					$get_ip = mysql_query("SELECT * FROM " . $db_table . " WHERE match_id = " . $match_id . " LIMIT 1");  
					$row = mysql_fetch_array($get_ip);
					$browserGame = $row['currentGame'];
					$browserScore = $row[$gameSearch];
				}
			}
		}
	} */
	
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
	$split = explode('-', $gameScore );
	//var_dump($split);
	$yellowScore = $split[0];
	$blackScore = $split[1];
	
	$jsonArray["yellowScore"] = $yellowScore;
	$jsonArray["blackScore"] = $blackScore;
	
	$game1Winner = "...";
	$game2Winner = "...";
	$game3Winner = "...";
	$game1Score = "";
	if($row['game1Winner'] != "none")
	{
		$game1Winner = $row['game1Winner'];
		if($game1Winner == "b")
			$game1Winner .= " - " . $team1;
		else
			$game1Winner .= " - " . $team2;
		$game1Winner .= " - " . $jsonArray["game1Score"];
	}
	if($row['game2Winner'] != "none")
	{
		$game2Winner = $row['game2Winner'];
		if($game2Winner == "b")
			$game2Winner .= " - " . $team2;
		else
			$game2Winner .= " - " . $team1;
		$game2Winner .= " - " . $jsonArray["game2Score"];
	}
	if($row['game3Winner'] != "none")
	{
		$game3Winner = $row['game3Winner'];
		if($game3Winner == "b")
			$game3Winner .= " - " . $team1;
		else
			$game3Winner .= " - " . $team2;
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
	if($current_game % 2 != 0)
	{
		$black_team = $team1;
		$yellow_team = $team2;
	}
	else
	{
		$black_team = $team2;
		$yellow_team = $team1;
	}
	if ($black_team == $team1)
	{
		$blackP1 = $player1_1;
		$blackP2 = $player1_2;
		$yellowP1 = $player2_1;
		$yellowP2 = $player2_2;
	}
	else
	{
		$blackP1 = $player2_1;
		$blackP2 = $player2_2;
		$yellowP1 = $player1_1;
		$yellowP2 = $player1_2;
	}
	
	$jsonArray["blackP1"] = $blackP1;
	$jsonArray["blackP2"] = $blackP2;
	$jsonArray["yellowP1"] = $yellowP1;
	$jsonArray["yellowP2"] = $yellowP2;
	
	$jsonArray["blackTeam"] = $black_team;
	$jsonArray["yellowTeam"] = $yellow_team;
	
	if ($in_progress == "over" && $row)
	{
		//var_dump($row);
		$winner = $row['winner'];
		switch ($winner)
		{
			case "team1":
				$winner = $team1;
			break;
			case "team2":
				$winner = $team2;
			break;
		}
		$jsonArray["status"] = "Game over! Winner: $winner";
	}
	else
	{
		$jsonArray["status"] =  ucwords(convertToPhrase($in_progress));
	}
	
	
	echo json_encode($jsonArray);
	/*
	echo "<h1>Match Info</h2>
				<h2>Game $current_game Score</h2>  
				<div id=\"black_team\" class=\"team_name\">
					<h3>$black_team</h3>
					<h4>$blackP1</h4>
					<h4>$blackP2</h4>
				</div>
				<div id=\"black\" class=\"team_score\">
					<h2>Black</h2>
					<div id=\"score2\" class=\"score_val\">  
					 $blackScore
					</div>  
				</div>
				<div id=\"yellow\" class=\"team_score\">
					<h2>Yellow</h2>
					<div id=\"score\" class=\"score_val\">  
					$yellowScore
					</div>  
				</div>
				<div id=\"yellow_team\" class=\"team_name\">
					<h3>$yellow_team</h3>
					<h4>$yellowP1</h4>
					<h4>$yellowP2</h4>
				</div>
				<div id=\"g1\" class=\"clearfix\">
				<h3>Game 1</h3>
				$game1Winner
				</div>
				<div id=\"g2\">
				<h3>Game 2</h3>
				$game2Winner
				</div>
				<div id=\"g3\">
				<h3>Game 3</h3>
				$game3Winner
				<div id=\"currentGame\">
				<h3>Current Game</h3>
				$current_game
				</div>
				<div id=\"table\">
				<h3>Table</h3>
				$table_name
				</div>
				<div id=\"status\">
				<h3>Status: ";
	if ($in_progress == "over" && $row)
	{
		//var_dump($row);
		$winner = $row['winner'];
		switch ($winner)
		{
			case "team1":
				$winner = $team1;
			break;
			case "team2":
				$winner = $team2;
			break;
		}
		echo "Game over! Winner: $winner</h3>
				</div>";
	}
	else
	{
		echo ucwords(convertToPhrase($in_progress));
	}
	*/
}
/*else if ($in_progress == "in_progress")
{
	echo "In Progress...</h3>
			</div>";
}
/*else if ($in_progress == "in_progress" && isset($_POST['view']) && $_POST['view'] == "matches")
{
	echo "In Progress...</h3>
			</div>";
}
if ((isset($_GET['view']) && $_GET['view'] == "matches") || (isset($_POST['view']) && $_POST['view'] == "matches"))
{
	echo "<div id=\"link\">
			<a href=\"index.html?match_id=$match_id\">View Match</a>
			</div>";
}
*/
 
          
// add to database for new visitor  
//if ($new_visitor === true) {  
//    mysql_query("INSERT INTO " . $db_table . " (visitor_ip, visitor_time) VALUES ('$visitor_ip','$time')") or die(mysql_error());  
//}  
  
// done processing the visit, now lets see how many total visitors are online  
//$tcheck = time() - $match_id; // (30 = 30 seconds)  
// select visitors that visited our page the last 30 seconds.  
//$query = mysql_query("SELECT * FROM " . $db_table . " WHERE visitor_time > $tcheck");  
//$onlinenow = mysql_num_rows($query);  
  
// show number of visitors on screen  
// if($onlinenow == 1) {  
    // echo 0;  
// } else {  
    // echo "0";  
// }  

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