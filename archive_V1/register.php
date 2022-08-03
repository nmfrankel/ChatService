<!DOCTYPE html>
<html lang="en">
<!--
||\\   ||\\   //|| | | ||
|| \\  || \\ // ||
||  \\ ||  \\/  || | ||
||   \\||       ||

	NOSSON M FRANKEL
	nossonmfrankel@gmail.com
	ALL RIGHTS RESERVED, 2016 - 2020
-->
<head>
    <meta charset="UTF-8"><link rel="stylesheet" href="main.css?fileVer=<?=filesize('main.css')?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="main.css?fileVer=<?=filesize('main.css')?>">
    <title>Register | Create an account</title>
    <style>
		#title{
			text-align: center;
			position: relative;
			font-size: 2.25em;
            font-weight: 500;
			/* margin: 22.5% auto 75px; */
		}
        form{
            text-align: center;
            position: relative;
            /* top: 25%;
            transform: translateX(50% - 225px); */
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
    <header>Register</header>

    <main>
        <h1 id="title">REGISTER</h1>

        <form action="" method='POST'>
            <div>COMING SOON<br><br></div>

            <input type="submit" name="submit" onclick='register(event)' value="REGISTER"/>
        </form>

        <a href="/">&nbsp;LOGIN&nbsp;</a>
    </main>

    
	<p id="small"><br>©ChatGroup 2016-2020</p>
	<!-- <div id='printEl'>This app requires JavaScript</div> -->
    <script>
        function register(e){
            e.preventDefault();
            console.log('Write in function');
        }
    </script>
</body>
</html>