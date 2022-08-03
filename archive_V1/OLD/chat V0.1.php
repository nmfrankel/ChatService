<?php
// Get username
$user = $_GET['u'];
?>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
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
			getScript('http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js', function() {
		
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
		<title>Chat</title>
		<style>
		body{
			font-family: sans-serif;
			box-sizing: border-box;
			margin: 0px;
			padding: 0px;
			background-color: #eee;
		}
		.header{
			height: 20px;
			z-index: 1;
			padding-left: 3%;
			position:fixed;
			margin:0px;
			top:0px;
			background-color: #eee;
			width:100%;
			padding: 10px 0 10px 0;
		}
		.chatcontainer{
			border: 2px solid #ddd;
		}
		.chatcontainer .chatheader{
			width:95%;
			background: white;
			padding: 5px;
			border-bottom: 1px solid #ddd;
		}
		.chatheader h3{
			margin:0;
			padding:0;
			height: 15px;
			font-weight: 400;
			color:#333;
			padding-bottom: 7px;
		}
		#chatmessages{
			line-height: 13px;
			font-size: 11px;
			border-bottom: 1px solid #ddd;
			overflow-y: scroll;
		}
		.chatcontainer{
			margin-top:15;
		}
		.chatbottom{
			position: fixed;
			bottom: 0px;
			padding-bottom: 15px;
			z-index: 1;
			width: 100%;
			height: 5%;
			background-color: #eee;
		}
		.chatbottom form input[type="submit"]{
			width: 12%;
			min-width: 40px;
			height: 100%;
			padding-right: 3%;
			padding-left: 3%;
			background: white;
			border:1.5px solid #ddd;
			cursor: pointer;
			border-radius: 10px;
		} 
		.chatbottom form input[type="text"]{
			width: 82%;
			height:100%;
			margin-left: 7px;
			border: 1px solid #ddd;
			border-radius: 7px;
			min-height: 20px;
		}
		.cm{
			list-style: none;
			border-bottom: 1px solid #ddd;
			padding:5px;
		}
		.single-message{
			background-color:#FFF;
			border: 1px solid #e4e4e4;
			margin:0 4% 10px 4%;
			padding: 0px 1% 0px 1%;
			height: 50px;
			line-height: 12px;
			font-size: 11px;
			border-radius: 8px;
			}
		.name{
			margin-left: 2px;
		}
		.message{
			overflow-x: hidden;
		}
		</style>
	</head>
	<body>
	<!--<script type="text/javascript">
		$user = prompt('Enter Your Name');
	</script>-->
		<div class="chatcontainer">
			<div id="reload">
				<?php
				$name = 'mvusers';
				$host = 'mysql-mvusers.mesivtaveretzky.com';
				$tname = 'mvusers';
				define('DB_NAME', 'mvusers');
				
				$link = mysql_connect($host, nm120, Nosson00);
				
				$db_selected = mysql_select_db(DB_NAME, $link);

				$sql = "SELECT * FROM `messages` ORDER BY `ID` DESC";

				$results = mysql_query($sql);
						
				if (!$results) {
					die('Invalid query: ' . mysql_error());
				}

				while($result = mysql_fetch_array( $results )){
					echo '<div class="single-message">';
					echo '<p class="name">' . $result['name'] . '</p>';
					echo '<p class="message">' . $result['text'] . '</p>';
					echo '</div>';
				}
				?>
			</div>
			<script>
				var x = true;
				if (x === true){
					setTimeout( function() {
						$('#reload').load('');
					}, 2000);
				};
			</script>
			<div>
			<p class="header">Welcome <?php echo ($user); ?> </p>
			</div>
			<div class="chatbottom">
				<form action="http://www.mesivtaveretzky.com/chatposter.php" /*onsubmit="return false;"*/ method="POST"  id="chatform" />
				<input type="hidden" id="name" name="in1" value="<?php echo $user; ?>"/>
				<input type="text" name="in2" value="" placeholder="type your message..." />
				<input type="submit" name="submit" value="post" />
			</div>
		</div>
	</body>
</html>