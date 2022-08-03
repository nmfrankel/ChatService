<!--
||\\   ||\\   //|| | | ||
|| \\  || \\ // ||
||  \\ ||  \\/  || | ||
||   \\||       ||

	NOSSON M FRANKEL
	nossonmfrankel@gmail.com
	ALL RIGHTS RESERVED, 2016 - 2020
-->
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
	<link rel="stylesheet" href="main.css?fileVer=<?=filesize('main.css')?>">
	<meta charset="utf-8">
	<style type="text/css">
		#title{
			text-align: center;
			position: relative;
			font-size: 2.25em;
            font-weight: 500;
			margin: 150px auto 75px;
		}
		form{
			text-align: center;
			position: relative;
			/* top: 25%;
			transform: translateX(50% - 225px); */
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
            transition: all ease-in-out 250ms;
        }
        input:focus,input:active{
            /* border:1px solid #0098cb; */
        }
        input[type="submit"]:hover, input[type="submit"]:active{
            background:#00b8eb;
            outline: none;
        }
		a{
			display: block;
			padding: 10px 5px;
			text-align: center;
			font-size: 18px;
			color: #000;
			text-decoration: underline;
			font-weight: 700;
		}
		#small{
			text-align:right;
			position: fixed;
			bottom: 3px;
			right:20px;
			font-size:.8em;
			color: #777;
		}
	</style>
</head>
<body>
	<header>Chat Group</header>

	<h1 id="title">LOGIN</h1>
	<form action="" method="POST">
		<p>Enter Your Email: <input type="text" name="username" autocomplete="on" placeholder="Email"value="<?php if (isset($_POST['username'])){echo $_POST['username'];}?>" /></p>
		<p>Enter You Password: <input type="password" placeholder="•••••••" name="password"></p>
		<input type="submit" name="submit" onclick='signIn(event)' value="LOGIN" onclick='ripple(event);'/>
	</form>

	<a href="/register">&nbsp;REGISTER&nbsp;</a>

	<p id="small"><br>©ChatGroup 2016-2020</p>
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
	function ripple(event) {
		el = event.currentTarget;

		rippleEl = document.querySelector('span.ripple');
		if(!rippleEl) {
			rippleEl = document.createElement('span');
		}
		el.appendChild(rippleEl);

		max = Math.max(el.offsetWidth, el.offsetHeight);
		rippleEl.style.width = rippleEl.style.height = max + 'px';

		rect = el.getBoundingClientRect();
		rippleEl.style.left = event.clientX - rect.left - (max/2) + 'px';
		rippleEl.style.top = event.clientY - rect.top - (max/2) + 'px';

		rippleEl.classList.add('ripple');
	}
	function signIn(e){
		e.preventDefault();
		// fetch('backend.php?auth=true&type=login&username='+document.forms[0].username.value+'&password='+document.forms[0].password.value, {method: "POST"})

		var xhr = new XMLHttpRequest();
		xhr.open("POST", '/backend.php', true);
		//Send the proper header information along with the request
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.send('auth=true&type=login&username='+document.forms[0].username.value+"&password="+document.forms[0].password.value);

		xhr.onreadystatechange = function() { // Call a function when the state changes.
			if (this.readyState === XMLHttpRequest.DONE && this.status === 200){
				print(this.responseText);
			}else if (this.readyState === XMLHttpRequest.DONE && this.status === 204){
				print('Logging you in');
				window.location = '/conversations';
			}
		}
	};
</script>
</body>
</html>