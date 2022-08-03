<?php
require_once 'backend.php';

if (empty($_SESSION['user']) || !isset($_SESSION['user'])) {
	header('location: ../login');
}

$user = $_SESSION['user'];
$id = $_SESSION['id'];
$recip = decrypt(base64_decode(escape_xss($_GET['recip'])));
$csrfToken = md5(uniqid(mt_rand(),true)); // Token generation updated
$_SESSION['csrfToken'] = $csrfToken;

$conn = new mysqli($servername, $usrnme, $pswrd, $dbname);
$otherUser = $conn->query("SELECT name, phone, profileimg AS img FROM user_id WHERE id = $recip")->fetch_array();
?>
<html>
<head>
	<link rel="stylesheet" href="main.css?fileVer=<?=filesize('main.css')?>">
	<meta http-equiv="Cache-control" content="no-store">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<meta charset="utf-8">
	<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
	<title>Chat - <?php echo $otherUser['name']?></title>
	<style>
		i{
			position: relative;
			border-radius: 50%;
			overflow: hidden;
			cursor: pointer;
		}
		.md-38{
			position: relative;
			top: -3px;
			left: 3%;
			margin-right: 6%;
			padding: 4px;
		}
		#recipient-img{
			position: absolute;
			top: 0px;
			border-radius: 50%;
			height: 32px;
			width: 32px;
			margin: 8px 7px 0 1%;
		}
		#recipient-name{
			display: inline-block;
			position: relative;
			top: -8px;
			left: 40px;
			margin-left: 15px;
			width: 150px;
		}
		#recipient-number{
			display: inline-block;
			font-size: 14px;
			position: relative;
			top: 9px;
			left: -115px;
		}
		main{
			animation: slideIn 100ms ease-out 0s 1 forwards;
		}
		main.slideOutRight{
			animation: slideOutRight 100ms ease-in 0s 1 forwards;
		}
		#main-container{
			display: block;
			position: relative;
			padding: 9px 0 0;
			font: 1em 'Roboto', arial;
			/* background: rgba(0, 122, 193, 0.15); */
		}
		.om, .om.fsu{
			width:80%;
			margin:0 4px 10px 4px;
			padding:2px 5px 2px 3px;
			border-radius:10px;
			z-index: 1;
			min-height: 52px;
			box-shadow: 1px 2px 15px 4px #eee;
		}
		.om.fsu{
			position: relative;
			left: 15%;
			background-color: #fff;
			border: 0px;
		}
		.om{
			background-color: #03a9f4;
			position: relative;
			left: 5%;
		}
		.om:last-of-type{
			margin-bottom: 45px;
		}


		footer{
			background: white;
			position: fixed;
			bottom: 0px;
			height: 38px;
			width: 100%;
			z-index: 10;
		}
		input[type='text'], input[type='text']:focus{
			position: relative;
			top: 4px;
			left: 4%;
			height: 30px;
			width: 79%;
			border-radius: 3px;
			padding-left: 10px;
			box-shadow: -2px 3px 10px 0px #aaa;
			border: 1px solid #eee;
			outline: none;
			font-size: 18px;
			letter-spacing: .5px;
		}
		input[type='submit'], input[type='submit']:focus{
			position: relative;
			top: 4px;
			left: 4%;
			margin-left: 3px;
			height: 29px;
			width: 10%;
			background: #fff;
			border-style: none;
			border-radius: 5px;
			box-shadow: -2px 3px 10px 0px #aaa;
			border: 1px solid #eee;
			outline: none;
			font-size: 18px;
		}
@keyframes slideIn{
	0%{
		position: relative;
		transform: translateX(100%);
	}
	100%{
		position: relative;
		transform: translateX(0%);
	}
}
	</style>
</head>
<body>
<header>
	<i class='material-icons md-38' onclick='goBack(event)'>arrow_back<!--lock_outline--></i>
	
	<img id="recipient-img" src="chatpic/<?php echo (file_exists('chatpic/'.$otherUser['img']) ? $otherUser['img']: 'missing.png');?>">

	<span id="recipient-name"><?php echo $otherUser['name']; ?></span>
	<span id="recipient-number"><?php echo $otherUser['phone']; ?></span>

	
	<!-- <span id="headerRightIcon" onclick='ripple(event);'>
		<svg xmlns="http://www.w3.org/2000/svg" viewBox="2 2 20 20"><path d="M0 0h24v24H0z" fill="none"/><path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z"/></svg>
	</span> -->
</header>

<span id="main-container">
	<main id="reload">
	<?php
	$results = $conn->query("SELECT a.id AS user, a.name, b.name, messages.text, messages.time, a.profileimg FROM user_id b, messages JOIN user_id a ON a.id = messages.name WHERE b.id = messages.recipient AND (messages.name = $id OR messages.recipient = $id) AND (messages.name = $recip OR messages.recipient = $recip) ORDER BY messages.ID ASC");
	$conn->close();

	if($results > $loadedContent || empty($loadedContent) || !isset($loadedContent)){
	// if($results->num_rows>0){
		while($result = $results->fetch_array()){
			//print_r($result);


			$t = $result['time'];
			if (!file_exists('chatpic/'.$result['profileimg'])){
				$result['profileimg'] = 'missing.jpg';
			}

			if ($result['user'] == $id){
				echo '<div class="om fsu" title="Posted: '.(date("h:i:s A m/d/y",$t)).'">';
				echo '<span class="message">' . $result['text'] . '</span>';
				echo '</div></div>';
			} else{
				echo '<div class="om" title="Posted: '.(date("h:i A m/d/y",$t)).'">';
				echo '<span class="message">' . $result['text'] . '</span>';
				echo '</div></div>';
			}
		};
		$loadedContent = $results;
	}else{
		echo "Type to start a conversation";
	}
	?>
	</main>
</span>

<footer>
	<form action="" method="POST">
		<input type="hidden" name="csrfKey" value="<?php echo $csrfToken ?>" />
		<input type="hidden" name="userName" value="<?php echo $_SESSION['user']; ?>">
		<input type="hidden" name="in2" value="<?php echo $_SESSION['id']; ?>">
		<input type="hidden" name="recip"  value="<?php echo escape_xss($_GET['recip'])?>">
		<input type="text" name="mTxt" autocomplete="off">
		<input type="submit" name="submit" onclick='post(event)' value="Send">
	</form>
</footer>

<div id='printEl'>This app requires JavaScript</div>
<script>
var newMessages;
var printEl = document.getElementById('printEl');
printEl.innerHTML='';

function print(str, len = 5000){
	printEl.innerHTML = "";
	setTimeout(function(){
		printEl.innerHTML = str;
		setTimeout(function(){
			printEl.innerHTML = "";
		}, len);
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
function goBack(e){
	document.getElementsByTagName('main')[0].classList.add('slideOutRight');
	ripple(e);
	setTimeout(function(){
		location.replace("/conversations");
		document.getElementsByTagName('main')[0].innerHTML = 'Loading.';
	document.getElementsByTagName('main')[0].classList.remove('slideOutRight');
	},125);
}
function post(e){
	e.preventDefault();

	var xhr = new XMLHttpRequest();
	xhr.open("POST", '/backend.php', true);

	//Send the proper header information along with the request
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

	xhr.onreadystatechange = function() { // Call a function when the state changes.
		if (this.readyState === XMLHttpRequest.DONE && this.status === 200){
			print(this.responseText);
		}else if (this.readyState === XMLHttpRequest.DONE && this.status === 204){
			document.forms[0].mTxt.value = '';
			print('Message sent', 1000);
		}
	}
	xhr.send('auth=true&type=post&userName='+document.forms[0].userName.value+"&in2="+document.forms[0].in2.value+"&recip="+document.forms[0].recip.value+"&mTxt="+document.forms[0].mTxt.value);
}
function update(){
	var messages = $('main').children().length;
	$('#reload').load('load.php');
	if (messages != newMessages){
		//$('#reload').scrollTop($('#reload')[0].scrollHeight);
		newMessages = $('main').children().length;
	}
	setTimeout(function(){
		update();
	}, 8000);
};
setTimeout(function(){
	//update();
},3000);

// document.getElementById('reload').scrollTo({ left: 0, top: document.querySelector('.om:last-child').getBoundingClientRect().top, behavior: 'smooth'})
document.body.scrollTop=document.querySelector('.om:last-child').getBoundingClientRect().top;
</script>
</body>
</html>