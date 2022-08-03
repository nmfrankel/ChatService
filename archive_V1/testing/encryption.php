<!DOCTYPE HTML>
<!--
||\\   ||\\   //|| | | ||
|| \\  || \\ // ||
||  \\ ||  \\/  || | ||
||   \\||       ||

    NOSSON M FRANKEL
    ALL RIGHTS RESERVED, 2016-2020
-->
<html>
<head>
	<meta charset="utf-8">
	<meta name="description" content="Encrypt and unencrypt a string">
	<meta name="theme-color" content="#003661">
	<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<link rel="stylesheet" href="main.css" async>
	<title>ENCRYPTION</title>
	<style type="text/css">
		.results{
			padding: 20px 15px 0px;
			user-select:text;
		}
		.results:first-of-type{
			padding-top: 75px;
		}
		form{
			font-family: arial;
			width: 300px;
			padding: 15px 25px;
			box-shadow: 1px 2px 15px 2px #eee;
			position: absolute;
			top: 50%;
			left: 0px;
			right: 0px;
			margin: 0 auto;
			transform: translateY(-50%);
		}
		b{
			font-size: 22px;
			text-decoration: underline;
		}
		label{
			font-size: 24px;
			text-align: left;
			margin: 25px auto 10px;
			display: block;
		}
		input{
			transition: all ease-in-out 200ms;
			font-size: 20px;
			padding: 0px 0 5px;
			width: 300px;
			margin: 0 auto;
			border: none;
			border-bottom: 2px solid #003661;
		}
		input:focus, input:active{
			border-bottom: 2px solid #1cb102;
			outline: none;
		}
		button{
			margin: 30px 0 0;
			width: 300px;
		}
	</style>
</head>
<body>
<header>Encryption</header>
<?php
if(isset($_POST['submit'])){
	require_once '../backend.php';
	$name = $_POST["name"];
    $decrypt = $_POST["decrypt"];

	if (isset($decrypt) && $decrypt != ''){
		echo '<div class="results">Decrypted string: '.decrypt($decrypt).'</div>';
	}else{
		$echo = encrypt($name);
		echo '<div class="results">Encrypted String: '.$echo.'</div>';
		echo '<div class="results">Decrypted string: '.decrypt($echo).'</div>';
	}
}
?>
<form action="" method="post">
	<b>Encryption Testing</b>
	<label for="name">Enter string</label>
	<input id="name" name="name" autocomplete="off" type="text">
	<label for="decrypt">Decrypt string</label>
	<input id="decrypt" name="decrypt" autocomplete="off" type="text">
	<br>
	<input type="hidden" name="submit" value="true">
	<button>Submit</button>
</form>
</body>
</html>