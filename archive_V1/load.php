<?php
session_start();
$user = $_SESSION['user'];
$id = $_SESSION['id'];
/*if (empty($user) || !isset($user)) {
	$user = $_GET['u'];
	if (empty($user) || !isset($user)) {
		header('location: ../login');
	}
}*/

$conn = new mysqli($servername, $username, $password, $dbname);
//$sql = "SELECT a.name, a.profileimg, messages.text, messages.time, messages.name, messages.recipient FROM user_id a, messages WHERE a.id = messages.name AND (messages.name = '$id' OR recipient = '$id') ORDER BY messages.ID ASC";
$results = $conn->query("SELECT a.id, a.name, b.name, messages.text, messages.time, a.profileimg FROM user_id b, messages JOIN user_id a ON a.id = messages.name WHERE b.id = messages.recipient AND (messages.name = '$id' OR messages.recipient = '$id') ORDER BY messages.ID ASC");
$conn->close();

if (!$results) {
	die('Invalid query: ' . mysql_error());
}

if($results > $loadedContent || empty($loadedContent) || !isset($loadedContent)){
	while($result = mysql_fetch_array( $results )){
		$t = $result['time'];
		if (!file_exists('chatpic/'.$result['profileimg'])){
			$result['profileimg'] = 'missing.jpg';
		}
		if ($result['0'] == $id){
			echo '<div class="omfsu" title="Posted: ' . (date("h:i:s A m/d/y",$t)) . '">';
			echo '<span class="picture"><img class="user-picture" src="http://www.mesivtaveretzky.com/chatpic/'.$result['profileimg'].'"></span>';
			echo '<div class="content" ><span class="name">' . $result['1'] . '</span><br>';
			echo '<span class="message">' . $result['text'] . '</span>';
			echo '<span class="time">Posted: ' . (date("h:i A m/d/y",$t)) . '</span>';
			echo '</div></div>';
		} else{
			echo '<div class="om" title="Posted: ' . (date("h:i A m/d/y",$t)) . '">';
			echo '<span class="picture"><img class="user-picture" src="http://www.mesivtaveretzky.com/chatpic/'.$result['profileimg'].'"></span>';
			echo '<div class="content" ><span class="name">' . $result['1'] . '</span><br>';
			echo '<span class="message">' . $result['text'] . '</span>';
			echo '<span class="time">Posted: ' . (date("h:i A m/d/y",$t)) . '</span>';
			echo '</div></div>';
		}
		//print_r($result);
	};
	$loadedContent = $results;
}
?>