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
	html, body{
		position: relative;
		height: 100%;
		padding:0px;
		font-family: 'Comfortaa', cursive;
		text-align:center;
        background: url('');
	}
    #loginPane{
        position: absolute;
        right: 0px;
        top: 0px;
        background: rgba(20, 213, 186, .85);
        width: 45%;
        height: 100%;
        box-sizing: border-box;
    }
    form{
        position: relative;
    }





    .input-container{
        position: relative;
        display: block;
        margin: 5px auto 5px;
        width: 250px;
    }
    input.effected{
        font-family: arial, sans-serif;
        color: #333;
        width: 100%;
        box-sizing: border-box;
        letter-spacing: 1px;
        padding: 5px;
        background: transparent;
        border-bottom: 2px solid #ccc;
        font-size: 20px;
        line-height: 1.2;
        z-index: 1;
    }
    :focus{
        outline: none;
    }
    .effected{
        position: relative;
        background: transparent;
        border: 0;
        padding: 5px 15px;
        border-bottom: 1px solid #ccc;
        transition: 0.4s;
    }
    .effected ~ .focus-border{
        position: absolute;
        bottom: 0;
        left: 50%;
        width: 0;
        height: 2px;
        background-color: #4caf50;
        transition: 0.4s;
    }
    .effected:focus ~ .focus-border{
        width: 100%;
        transition: 0.4s;
        left: 0;
    }
    .effected:focus ~ .focus-border,
    .effected.has-value ~ .focus-border{
        width: 100%;
        left: 0px;
        transition: 0.4s;
    }
    .effected ~ label{
        position: absolute;
        left: 10px;
        width: 100%;
        top: 7px;
        color: #555;
        transition: 0.3s;
        z-index: 0;
        letter-spacing: 0.5px;
        font-size: 18px;
        text-align: left;
    }
    .effected:focus ~ label, .effected.has-value ~ label{
        font-size: 12px;
        color: #4caf50;
        transition: 0.3s;
        opacity: 0;
        text-shadow: 0 0 16px black;
        color: transparent;
    }
    .error{
        display: none;
    }



	a{
		text-decoration:none;
		color:#0098cb;
	}
	a:hover{
		color:#00b8eb;
	}
	</style>
</head>
<body>

    <div id="loginPane">
        <div id="title">Login</div>
        <form action="" method="POST">
            <div class="input-container">
                <input class="effected" type="text" name="username" autocomplete="off">
                <label>Email</label>
                <span class="focus-border"></span>
                <span class="error" id="cc_num">Email entered is invalid</span>
            </div>
            <div class="input-container" id="cc_exp-container">
                <input type="password" class="effected" name="password">
                <label>Password</label>
                <span class="focus-border"></span>
                <span class="error" id="cc_exp">Incorrect Password</span>
            </div>
            
            <input type="submit" name="submit" onclick='signIn(event)' value="SIGN IN"/>
        </form>
    </div>

	<div id='printEl'>This app requires JavaScript</div>
<script>
	var printEl = document.getElementById('printEl'),
    move = document.querySelectorAll('input:not([type=file])');
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
    // move labels when input ative / full
    Array.prototype.forEach.call(move, function(button){
        button.addEventListener("ready", movement);
        button.addEventListener("focusout", movement);
    });
    function movement (e){
        var target = event.target || event.srcElement;
        var text_val = target.value;
        if(text_val === ""){
            target.classList.remove('has-value');
        }else {
            target.classList.add('has-value');
        }
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