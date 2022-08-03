<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<!--<meta http-equiv="refresh" content="5">-->
	<title>Alter Database</title>
	<style>
	body{
		font: arial;
	}
	table{
		width: 94%;
		text-align: center;
		border: solid 1px #000;
	x
	</style>
</head>
<body>
<?php
//define('DB_USER', 'root');
//define('DB_PASSWORD', 'root');
//define('DB_HOST', 'localhost');
define('DB_NAME', 'mvusers');
define('DB_USER', 'mv2016');
define('DB_PASSWORD', 'rcu-Akx-Gh5-9ho');
define('DB_HOST', 'mysql-mvusers.mesivtaveretzky.com');

$link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);

if (!$link) {
	die('Could not connect: ' . mysql_error());
}

$db_selected = mysql_select_db(DB_NAME, $link);

if (!$db_selected) {
	die('Can\'t use ' . DB_NAME . ': ' . mysql_error());
}

echo '<p style="display:none;">connected successfully</p>';

//add column 
/*$add = "ALTER TABLE user_id ADD phone TEXT NULL AFTER name";
$change = mysql_query($add);
if (!$change) {
	die('Invalid query: ' . mysql_error());
}
*/
//delete messages
//$delete = "DELETE FROM messages WHERE ID > 375 AND messages.name = '' OR messages.recipient = ''";
//mysql_query($delete);

// change info
//$change = 'UPDATE user_id SET password = "$5$361a562000f5816a$tluTAibDUBIbZJtew6BBZ.vSzVl9t8mYTTz1NU5hLmA" /*, text =*/ WHERE ID = 24';
//mysql_query($change);

// select all users and thier information
$sql = "SELECT * FROM user_id";

$results = mysql_query($sql);
			
if (!$results) {
	die('Invalid query: ' . mysql_error());
}

echo "<table><th>ID</th><th>Username</th><th>Password</th><th>Name</th><th>Phone Number</th><th>Profile Image Location</th>";

while($result = mysql_fetch_array( $results )){
	//print_r($result);
	echo '<tr><td>'.$result['ID'].'</td><td>'.$result['username'].'</td><td>'.$result['password'].'</td><td>'.$result['name'].'</td><td>'.$result['phone'].'</td><td>'.$result['profileimg'].'</td></tr>';
}

echo "</table><br>";
// joins specific info
//$sql = "SELECT 'user_id.id', 'user_id.name', 'messages.name', 'messages.text' FROM user_id JOIN messages ON 'user_id.id' = 'messages.name'";


//shows basic view of chat
//$sql = "SELECT a.id, a.name, b.name, messages.text, messages.time, a.profileimg FROM user_id a, messages JOIN user_id b ON b.id = messages.recipient WHERE a.id = messages.name ORDER BY messages.ID DESC";

//conversations.php sql code IN PROGRESS
//$sql = "SELECT DISTINCT messages.name, recipient, messages.id FROM user_id, messages WHERE user_id.id = messages.name AND (messages.name = 24 OR recipient = 24) ORDER BY messages.id DESC";
$sql = "SELECT DISTINCT 
	CASE 
		WHEN messages.name = 24 THEN messages.recipient
		WHEN messages.recipient = 24 THEN messages.name
		END AS 'reciever', messages.id, name, recipient
FROM messages ORDER BY messages.id DESC";
//$sql = "SELECT DISTINCT CASE WHEN messages.name = $id THEN messages.recipient WHEN messages.recipient = $id THEN messages.name END AS 'reciever' FROM messages ORDER BY messages.id DESC";
$user = 24;
//$sql = "SELECT user_id.name, user_id.profileimg, messages.text, messages.time, messages.name, messages.recipient FROM user_id, messages WHERE user_id.id = messages.name AND (messages.name = '$user' OR recipient = '$user') ORDER BY messages.ID ASC";

$results = mysql_query($sql);

if (!$results) {
		die('Invalid query: ' . mysql_error());
	}

	echo "<table><th>Id</th><th>From</th><th>To</th><th>Text</th><th>Time</th><th>Image Location</th>";

	while($result = mysql_fetch_array( $results )){
		//print_r($result);
		echo '<tr><td>'.$result['0'].'</td><td>'.$result['1'].'</td><td>'.$result['2'].'</td><td>'.$result['3'].'</td><td>'.$result['4'].'</td><td>'.$result['5'].'</td></tr>';
	}

	echo "</table>";

//end of get data
if (!mysql_query($sql)) {
	die('Error: ' . mysql_error());
}


mysql_close();
?>
</body>
</html>