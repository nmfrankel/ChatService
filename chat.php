<!-- takeover chat.php -->
<!--
||\\   ||\\   //||||||||
|| \\  || \\ // ||
||  \\ ||  \\/  |||||
||   \\||       ||

	NOSSON M FRANKEL
	nossonmfrankel@gmail.com
	ALL RIGHTS RESERVED, 2016 - <?=date('Y')?>
-->
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="content-language" content="en">
	<meta name="description" content="">
	<meta name="theme-color" content="#ffffff">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
	<link rel="stylesheet" href="./style/main.css?fileVer=<?=filesize('./style/main.css')?>">
	<link rel="stylesheet" href="./style/chat.css?fileVer=<?=filesize('./style/chat.css')?>">
	<script src="./scripts/chat.js?fileVer=<?=filesize('./scripts/chat.js')?>" defer></script>
	<script src="./scripts/main.js?fileVer=<?=filesize('./scripts/main.js')?>" defer></script>
	<title>Chat | ChatGroup</title>
</head>
<body>
	
	<section>
		<div class="container" id="msgs">
			<!-- Autofill messages here -->

		</div>
	</section>

	<form id="newMsg" action="" method='POST' onsubmit="postMsg(event)" enctype="multipart/form-data">
		<!-- <input id="options" type="button" value=""> -->
		<input type="hidden" name="authToken" value='<?=$authToken?>'>
		<input type="hidden" name="sender" value='<?=null?>'>
		<input type="hidden" name="recip">
		<div id="sending">
			<input type="text" name="content" autocomplete="off" placeholder="Chat message">
			<input id="send" type="submit" value="">
		</div>
	</form>
</body>
</html>