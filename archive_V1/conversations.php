<?php
require_once 'backend.php';

if (empty($_SESSION['user']) || !isset($_SESSION['user'])) {
	header('location: ../login');
}

$conn = new mysqli($servername, $usrnme, $pswrd, $dbname);
$results = $conn->query("SELECT a.id, IF(a.name=$_SESSION[id], a.recipient, a.name) AS otherUser, a.name AS sender, a.recipient AS recipient, user_id.name AS otherName, user_id.profileimg AS otherPic, IF(a.name=$_SESSION[id], 'You: ', /*user_id.name*/'') AS lastSender, a.text, a.time FROM messages a JOIN user_id ON IF(a.name=$_SESSION[id], a.recipient, a.name)=user_id.id WHERE a.id = (SELECT MAX(b.id) FROM messages b WHERE IF(b.name=$_SESSION[id], b.recipient, b.name)=IF(a.name=$_SESSION[id], a.recipient, a.name) AND (b.name=$_SESSION[id] OR b.recipient=$_SESSION[id])) AND (a.name=$_SESSION[id] OR a.recipient=$_SESSION[id])
ORDER BY a.time DESC");
$conn->close();


// SELECT a.id, IF(a.name=$_SESSION[id], a.recipient, a.name) AS otherUser, IF(a.name=$_SESSION[id], d.profileimg, c.profileimg) AS otherPic, a.name AS sender, c.name AS sender_name, a.recipient AS recipient, d.name AS recipient_name, a.text, a.time FROM messages a JOIN user_id c ON a.name=c.id JOIN user_id d ON a.recipient=d.id WHERE a.id = (SELECT DISTINCT MAX(b.id) FROM messages b WHERE a.name = b.name OR a.recipient = b.recipient AND (b.name = $_SESSION[id] OR b.recipient = $_SESSION[id])) ORDER BY time DESC
?>
<!DOCTYPE html>
<!--
||\\   ||\\   //|| | | ||
|| \\  || \\ // ||
||  \\ ||  \\/  || | ||
||   \\||       ||

	NOSSON M FRANKEL
	nossonmfrankel@gmail.com
	ALL RIGHTS RESERVED, 2016 - 2020
-->
<html lang="en">
<head>
    <meta charset="UTF-8">
	<meta name="description" content="View your conversations">
	<meta name="theme-color" content="#4caf50">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
	<!-- <meta http-equiv="refresh" content="5"> -->
	<link rel="stylesheet" href="main.css?fileVer=<?=filesize('main.css')?>">
	<title>Conversations</title>
	<style type="text/css">
		.cta{
			position: absolute;
			right: 50px;
			bottom: 100px;
			cursor: pointer;
		}
		.cta svg{
			position: absolute;
			/* background: #333; */
			/* padding: 10px; */
			/* border-radius: 50%; */
			/* fill: #4caf50; */
			fill: #333;
			height: 30px;
			width: 30px;
		}
		main.slideOutLeft{
			animation: slideOutLeft 100ms ease-in 0s 1 forwards;
		}
		.thread{
			position: relative;
			overflow: hidden;
			padding: 5px 10px;
			margin: 15px auto;
			cursor: pointer;
			background: #fff;
			border-radius: 5px;
			box-shadow: -2px 2px 6px 3px #ccc;
			transition: all ease-in-out 250ms;
			animation: slide-threads-in 450ms ease-out 0s 1 forwards;
			perspective: 1000;
		}
		.thread:hover, .thread:focus{
			box-shadow: -2px 2px 6px 3px #bbb;
		}
		.thread .picture .userPicture{
			position: relative;
			top: 3px;
			height: 50px;
			width: 50px;
			border-radius: 50%;
			box-shadow: -1px 2px 10px 2px #ddd;
			z-index: 100;
		}
		.thread .name{
			font-weight: 700;
			font-size: 18px;
			position: absolute;
			top: 12px;
			padding-left: 20px;
		}
		.thread .lastMessage{
			display: inline-block;
			position: absolute;
			top: 38px;
			margin-left: 20px;
			padding-right: 15px;
			box-sizing: border-box;
			width: 80%;
			height: 17px;
			font-size: 16px;
			color: #777;
			overflow: hidden;
		}
		.thread .time{
			font-size: 12px;
			color: #888;
			position: absolute;
			top: 17px;
			right: 33px;
		}
		.thread svg{
			position: relative;
			left: 5px;
			float: right;
			margin-top: 15px;
		}
@keyframes slide-threads-in{
	0%{
		position: relative;
		top: -75px;
		opacity: .4;
		transform: rotateX(60deg);
	}
	100%{
		position: relative;
		top: 0px;
		opacity: 1;
		transform: rotateX(0deg);
	}
}
	</style>
</head>
<body>
<header>
	<span>Chats</span>
	<span id="headerRightIcon" onclick='ripple(event);logout();'>
		<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M0 0h24v24H0z" fill="none"/><path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/></svg>
	</span>
</header>

<main>
<?php
	if($results->num_rows>0){
		foreach($results as $result){
			// print_r($result);
			/*switch ($_SESSION[id]){
				case $result['sender']:
					break;
				case $result['recipient']:
					break;
			}*/
			$time = parseDate($result[time]);
			$pic_location = (file_exists('chatpic/'.$result[otherPic]) ? $result[otherPic]: 'missing.png');
			echo "<div class='thread' onclick='ripple(event);openThread(\"".base64_encode(encrypt($result[otherUser]))."\")'>
				<span class='picture'><img class='userPicture' src='/chatpic/$pic_location'></span>
				<span class='name'>$result[otherName]</span>
				<span class='lastMessage'>$result[lastSender]$result[text]</span>
				<span class='time'>$time</span>
				<svg fill='#999' height='24' viewBox='0 0 24 24' width='24' xmlns='http://www.w3.org/2000/svg'>
					<path d='M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z'/>
					<path d='M0 0h24v24H0z' fill='none'/>
				</svg>
			</div>";
		}
	}else{
		echo '<div align=center><br>Start a conversation by clicking<br>on the green arrow in the bottom right.</div>';
	}
?>
	<div class="cta">
		<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/><path d="M0 0h24v24H0z" fill="none"/></svg>
	</div>
	
</main>


<script type="text/javascript">

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
function logout(){
	document.getElementsByTagName('main')[0].innerHTML = 'Logging you out... please wait';
	// history.replaceState(null, 'Login', '/?type=');
	
	fetch('/login')
	.then(function(res){
		if(res.status==200){
			setTimeout(() => {
				window.location='/';
			}, 500);
		}else{
			console.log('An error occured');
			window.location='/';
		}
	})
}
function openThread(recip){
	document.getElementsByTagName('main')[0].classList.add('slideOutLeft');
	setTimeout(() => {
		window.location='/chat?recip='+recip;
		document.getElementsByTagName('main')[0].classList.remove('slideOutLeft');document.getElementsByTagName('main')[0].innerHTML = 'Loading...';
	}, 125);
}

</script>
</body>
</html>