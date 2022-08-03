<html>
<head>
	<title>| PROCESSING |</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="utf-8">
	<style type="text/css">
	p{
		font-size: 30px;
	}
		.example-6 {
			width: 100%;
			height: 100%;
			background: #78C7F9;
			display: -webkit-box;
			display: -webkit-flex;
			display: -ms-flexbox;
			display: flex;
			-webkit-box-pack: center;
			-webkit-justify-content: center;
			-ms-flex-pack: center;
			justify-content: center;
			-webkit-box-align: center;
			-webkit-align-items: center;
			-ms-flex-align: center;
			align-items: center;
		}
		.example-6 .progress-bar {
			width: 200px;
			height: 20px;
			background: white;
			border: 10px solid white;
			box-shadow: 0px 20px 25px -10px rgba(0, 0, 0, 0.3);
			border-radius: 5px;
		}
		.example-6 .progress {
			height: 100%;
			width: 0%;
			background-color: #397CA7;
			-webkit-animation: progress linear 450ms infinite;
			animation: progress linear 450ms infinite;
			border-radius: 5px;
		}
@-webkit-keyframes progress {
	0%, 30% {
	width: 0%;
	}
	30% {
	width: 20%;
	}
	40% {
	width: 70%;
	}
	70%, 90% {
	width: 80%;
	}
	90%, 100% {
	width: 100%;
	}
}
@keyframes progress {
	0%, 30% {
	width: 0%;
	}
	30% {
	width: 20%;
	}
	40% {
	width: 70%;
	}
	70%, 90% {
	width: 80%;
	}
	90%, 100% {
	width: 100%;
	}
}
	</style>
</head>
<body>
<div class="example example-6">
	<div class="progress-bar">
		<div class="progress"></div>
	</div>
</div>	
<?php
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
$x_values = time();

function escape_xss($string){
	return htmlspecialchars($string, ENT_QUOTES, 'utf-8');
}
$value2 = escape_xss($value2);

$sql = "INSERT INTO messages (ID, name, text, time) VALUES (NULL, '$value', '$value2', '$x_values')";

if (!mysql_query($sql)) {
	die('Error: ' . mysql_error());
}

mysql_close();
?>

<script>
	var x = true;
	if (x === true){
		setTimeout( function() {
			window.history.back();
		}, 425);
	};
</script>
</body>
</html>