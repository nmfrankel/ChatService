<!DOCTYPE html>
<?php
ini_set('session.gc_maxlifetime', 1800);
session_set_cookie_params(1800);
session_set_cookie_params(1800);
session_start();
$user = $_SESSION['user'];
if (empty($user) || !isset($user)) {
	//$user = $_GET['u'];
	if (empty($user) || !isset($user)) {
		header('location: ../login');
		//die('<script type="text/javascript">window.location.href="' . $url . '";</script>');
	}
}

if (isset($_POST['submit']) && !empty($_POST['in1']) && !empty($_POST['in2']) && $_SESSION['user'] == $_POST['conf'] && $_SESSION['id'] == $_POST['in1']){
	define('DB_NAME', 'mvusers');
	define('DB_USER', 'nm120');
	define('DB_PASSWORD', 'Nosson00');
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

	function f_clean($array) {
	    return array_map('mysql_real_escape_string', $array);
	}
	$_POST = f_clean($_POST);

	$value = $_POST['in1'];
	$value2 = $_POST['in2'];
	$value3 = $_POST['in3'];
	$x_values = time();

	function escape_xss($string){
		return htmlspecialchars($string, ENT_QUOTES, 'utf-8');
	}
	$value2 = escape_xss($value2);

	$sql = "INSERT INTO messages (ID, name, recipient, text, time) VALUES (NULL, '$value', '$value3', '$value2', '$x_values')";

	if (!mysql_query($sql)) {
		die('Error: ' . mysql_error());
	}

	mysql_close();
	}
?>
<html>
<head>
	<title>|| CHAT ||</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
	<script type="text/javascript">
		// Only do anything if jQuery isn't defined
		if (typeof jQuery == 'undefined') {
			if (typeof $ == 'function') {
				// warning, global var
				thisPageUsingOtherJSLibrary = true;
			}
			function getScript(url, success) {
				var script     = document.createElement('script');
				     script.src = url;
				var head = document.getElementsByTagName('head')[0],
				done = false;
				// Attach handlers for all browsers
				script.onload = script.onreadystatechange = function() {
					if (!done && (!this.readyState || this.readyState == 'loaded' || this.readyState == 'complete')) {
					done = true;
						// callback function provided as param
						script.onload = script.onreadystatechange = null;
						head.removeChild(script);	
					};		
				};
				head.appendChild(script);
			};
			getScript('https://code.jquery.com/jquery-3.1.1.min.js', function() {
		
				if (typeof jQuery=='undefined') {
					// Super failsafe - still somehow failed...
				} else {
					// jQuery loaded! Make sure to use .noConflict just in case
					if (thisPageUsingOtherJSLibrary) {
						// Run your jQuery Code
					} else {
						// Use .noConflict(), then run your jQuery Code
					}
				}
			});
		} else { // jQuery was already loaded
			// Run your jQuery Code
		};
	</script>
	<style>
	body{
		color: #000;
		background-color: #f1f1f1;
		padding: 0px 0px 0px 0px;
		margin: 0px 0px 0px 0px;
		font-family: 'Roboto', sans-serif;
		font-size: 11px;
		line-height: 13px;
	}
	#head{
		position: fixed;
		top: 0px;
		width: 100%;
		background-color: #f1f1f1;
		z-index: 2;
		height:40px;
		font-weight: 800;
	}
	#header{
		font-size: 15px;
		line-height: 16px;
		width: 200px;
		margin: 13px 0 13px 5%;
		position: fixed;
		top: 0px;
	}
	#liveMessages{
		z-index: -1;
	}
	.om,.omfsu{
		color: #000;
		background-color: #d9d9d9;
		border: 1px solid #111; 
		width:80%;
		margin:0 2% 10px 2%;
		padding:2px 1% 2px 1%;
		border-radius:10px;
		z-index: 1;
		min-height: 48px;
	}
	.user-picture{
		position: absolute;
		left: 2.5px;
		top: 2.75px;
		height: 45px;
		width:45px;
		border-radius: 50%;
	}
	.users-picture{
		position: relative;
		top: 1px;
		right: 2%; 
		height: 45px;
		width:45px;
		border-radius: 50%;
	}
	.picture{
		position: absolute;
	}
	.name{
		margin:4px 2px 3px 2px;
	}
	.message,.time{
		margin:2px 2px 3px 2px;
	}
	.time{
		position: relative;
		top: 2px;
		right:0px;
		font-size: 10px;
		line-height: 4px;
		color: #888;
		text-align: right;
	}
	.omfsu .time{
		color: #fff;
	}
	.content{
		position: relative;
		left:47px;
		width: calc(100% - 49px);
	}
	#inputs{
		position: fixed;
		bottom: 0px;
		width: 100%;
		padding: 7px 0 7px 0;
		background-color: #f1f1f1;
		z-index: 2;
	}
	#inputs form input[type="text"]{
		border-radius: 7px;
		height: 18px;
		padding-left:8px;
		width:calc(76% - 15px);
		margin:0 2.5% 0 2.5%;
		position: relative;
		top: -1px;
		border: 1px solid #777;
		background-color: #fff;
		color: #000;
	}
	#inputs form input[type="text"]:focus{
		outline:none;
		border: 2px solid #f4b042;
	}
	#inputs form input[type="submit"]{
		width: 14%;
		min-width: 40px;
		margin: 0 3% 0 0;
		height: 24px;
		position: relative;
		top:-1px;
		border-radius: 8px;
		background-color: #fff;
		color: #000;
	}
	#inputs form input[type="submit"]:focus,#inputs form input[type="submit"]:active{
		outline:none;
		border: 2px solid #f4b042;
	}
	.omfsu{
		position: relative;
		left: 14%;
		color: #FFF;
		background-color: #6a91d1;
		border: 0px;
	}
	#logout{
		text-align: right;
		padding-right: 5%;
		cursor:pointer;
		font-size: 15px;
	}
	</style>
</head>
<script type="text/javascript">
	function logout(){
		location.replace("../login");
	}
</script>
<body>
<div id=head>
<p id="header">Hello <?php echo ($user); ?></p>
<p id="logout" onclick="logout();">Logout</p>
</div>

<div id=liveMessages style="margin-top:45px;padding-bottom:10px;">
	<?php

	$conn = new mysqli($servername, $username, $password, $dbname);
	$results = $conn->query("SELECT user_id.name, user_id.profileimg, messages.text, messages.time FROM user_id, messages WHERE user_id.id = messages.name ORDER BY messages.ID DESC");
	$conn->close();

	// if($results > $loadedContent || empty($loadedContent) || !isset($loadedContent)){
	if($results->num_rows > 0){
		while($result = mysql_fetch_array( $results )){
			$t = $result['time'];
			$u = $result['name'];

			if ($u == $user){
				echo '<div class="omfsu" title="Posted: ' . (date("h:i:s A m/d/y",$t)) . '">';
				//if ($user == $b) {
				echo '<img class="user-picture" src="http://www.mesivtaveretzky.com/chatpic/'.$result['profileimg'].'">';
				//};
				echo '<div class="content" ><p class="name">' . $result['name'] . '</p>';
				echo '<p class="message">' . $result['text'] . '</p>';
				echo '<p class="time">Posted: ' . (date("h:i A m/d/y",$t)) . '</p>';
				echo $result['ID'];
				echo '</div></div>';
			} else{
				echo '<div class="om" title="Posted: ' . (date("h:i A m/d/y",$t)) . '">';
				echo '<div class="picture" ><img class="users-picture" src="http://www.mesivtaveretzky.com/chatpic/'.$result['profileimg'].'"></div>';
				echo '<div class="content" ><p class="name">' . $result['name'] . '</p>';
				echo '<p class="message">' . $result['text'] . '</p>';
				echo '<p class="time">Posted: ' . (date("h:i A m/d/y",$t)) . '</p>';
				echo '</div></div>';
			};
		};
		$loadedContent = $results;
	}
?>
</div>
<div id="inputs">
	<form action="" method="POST"  id="the-form" />
	<input type="hidden" id="name" name="in1" value="<?php echo $_SESSION['id']; ?>"/>
	<input type="hidden" name="conf" value="<?php echo $_SESSION['user']; ?>">
	<input type="hidden" name="in3" value="24">
	<input type="text" name="in2" value="" autocorrect="on" autocomplete="off" placeholder="Type Your Message Here" />
	<input type="submit" name="submit" value="post" />
</div>

<script>
	var x = true;
	if (x === true){
		setTimeout( function() {
			$('#liveMessages').load('');
		}, 4000);
	};
</script>
</body>
</html>