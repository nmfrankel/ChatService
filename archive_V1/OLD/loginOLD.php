<?php
	session_start();
	session_destroy();
	unset($_SESSION['user']);
	unset($_SESSION['id']);
?>
<html>
<head>
	<title>Login</title>
	<link href='http://fonts.googleapis.com/css?family=Comfortaa' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="style.css">
	<meta charset="utf-8">
	<style type="text/css">
	body{
		position: relative;
		top:calc(50% - 200px);
		height: 600px;
		padding:0px;
		font-family: 'Comfortaa', cursive;
		text-align:center;
	}
	img{
		height: 75px;
		width: 75px;
		position: fixed;
		top: 3px;
		left: 5px;
		cursor: pointer;
	}
	#title{
		font-size:2.25em;
	}
	input[type="text"], input[type="password"]{
		outline:none;
		padding:10px;
		display:block;
		width:300px;
		border-radius: 5px;
		border:1px solid #CECECE;
		margin:20px auto;
	}
	input[type="submit"]{
		padding:10px;
		color:#fff;
		background:#0098cb;
		width:320px;
		margin:20px auto;
		margin-top:0px;
		border:0px;
		border-radius: 3px;
		cursor:pointer;
	}
	input:focus,input:active{
		border:1px solid #0098cb;
	}
	input[type="submit"]:hover{
		background:#00b8eb;
	}
	#small{
		text-align:right;
		position: fixed;
		bottom: 5px;
		right:20px;
		font-size:.8em;
	}
	a{
		text-decoration:none;
		color:#0098cb;
	}
	a:hover{
		color:#00b8eb;
	}
	#out{
		position: absolute;
		top: -75px;
		width: 100%;
		text-align: center;
		padding: 0px;
		margin: 0px;
		margin-left: -8px;
	}
	</style>
</head>
<body>
	<img src="favicon.ico">
	<p id="title">Login</p>
	<form action="" method="POST">
		<p>Enter Your Email: <input type="text" name="username" autocomplete="on" placeholder="Email"value="<?php if (isset($_POST['username'])){echo $_POST['username'];}?>" /></p>
		<p>Enter You Password: <input type="password" placeholder="•••••••" name="password"></p>
		<input type="submit" name="submit" onclick='signIn(event)' value="SIGN IN"/>
	</form>
	<p><a href="register.html">register here</a></p>
	<p id="small">Chat system<br>©MesivtaVeretzky.com2016-2019</p>

	<div id='printEl'>This app requires JavaScript</div>
<script>
	var printEl = document.getElementById('printEl');
	printEl.innerHTML='';

	function print(str, len = 5000){
		printEl.innerHTML = "";
		setTimeout(function(){
			printEl.innerHTML = str;
			setTimeout(function(){
				printEl.innerHTML = "";
			}, 5000);
		}, 100);
	}
	function signIn(e){
		e.preventDefault();

		var xhr = new XMLHttpRequest();
		xhr.open("POST", '/backend.php', true);

		//Send the proper header information along with the request
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

		xhr.onreadystatechange = function() { // Call a function when the state changes.
			if (this.readyState === XMLHttpRequest.DONE && this.status === 200){
				print(this.responseText);
			}else if (this.readyState === XMLHttpRequest.DONE && this.status === 204){
				print('Logging you in');
				window.location = '/conversations';
			}
		}
		xhr.send('auth=true&type=login&username='+document.forms[0].username.value+"&password="+document.forms[0].password.value);
	};
</script>
</body>
</html>