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
	<link rel="stylesheet" href="./assets/main.css?fileVer=<?=filesize('./assets/main.css')?>">
	<script src="./scripts/chat.js" defer></script>
	<title>Chat | ChatGroup</title>
	<style>
		:root{
			--background: #ebeff1;
			--lightShadow: #e0e6e8;
			--darkShadow: #c6ccce;

			/* --logo-color: rgb(6, 147, 53);
			--error: rgb(194, 0, 74);
			--disabled: rgb(124, 124, 124); */
		}
		#newMsg{
			position: fixed;
			bottom: 0px;
			height: 40px;
			width: 100%;
			padding: 15px 0;
			z-index: 10;
			background: var(--background);/* fade top 5px to transparent */
		}
		input#options{
			/* border: none;
			height: 28px;
			width: 28px;
			float: left;
			background: url("data:image/svg+xml;charset=utf-8,<svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='rgb(120, 120, 120)'><path d='M0 0h24v24H0z' fill='none'/><path d='M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm5 11h-4v4h-2v-4H7v-2h4V7h2v4h4v2z'/></svg>") no-repeat;
			background-size: cover;
			cursor: pointer; */

			display: none;
		}
		#sending{
			height: 40px;
			width: 90%;
			max-width: 700px;
			box-sizing: border-box;
			margin: 0 auto;
			padding: 5px 10px;
			background: white;
			border: 1px solid #f0f0f0;
			border-radius: 18px;
			box-shadow: -1px 2px 10px 2px var(--lightShadow);
		}
		input[type=text]{
			background: transparent;
			border: none;
			outline: none;
			height: 100%;
			padding: 0px 0px 0px 6px;
			font-size: 20px;
			width: calc(100% - 40px);
		}
		input[type=text]::placeholder{
			color: #677e89;
		}
		input#send{
			border: none;
			height: 28px;
			width: 28px;
			float: right;
			/* margin: 0 10px; */
			background: url("data:image/svg+xml;charset=utf-8,<svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='rgb(143 163 173)'><path d='M2.01 21L23 12 2.01 3 2 10l15 2-15 2z'/><path d='M0 0h24v24H0z' fill='none'/></svg>") no-repeat;
			background-size: cover;
			cursor: pointer;
		}


		section:first-of-type{
			/* background: #f0f0f0; */
			background: var(--background);
			min-height: calc(100vh - 70px);
		}
		.othersMsg:last-child, .yourMsg:last-child{
			margin-bottom: 30px;
		}
		.yourMsg{
			text-align: right;
		}
		.msgContainer{
			display: inline-block;
			width: 100%;
			margin-top: 1px;
		}
		.othersMsg .msgContainer{
			margin-top: 4px;
		}
		.msgContainer:first-child{
			margin-top: 24px;
		}
		.msg{
			width: fit-content;
			padding: 8px 16px;
			background: #fff;
			box-shadow: -1px 2px 10px 2px var(--lightShadow);
			z-index: 1;
			user-select: none;
		}
		/* changes left sides corners */
		.othersMsg .msgContainer .msg{
			background: #4284f4;
			color: #fff;
			box-shadow: -1px 2px 10px 2px var(--darkShadow);
			border-top-right-radius: 18px;
			border-bottom-right-radius: 18px;
		}
		.othersMsg .msgContainer:first-child .msg{
			border-top-left-radius: 18px;
		}
		.othersMsg .msgContainer:last-child .msg{
			border-bottom-left-radius: 18px;
		}
		/* changes rights sides corners */
		.yourMsg .msgContainer .msg{
			float: right;
			border-top-left-radius: 18px;
			border-bottom-left-radius: 18px;
		}
		.yourMsg .msgContainer:first-child .msg{
			border-top-right-radius: 18px;
		}
		.yourMsg .msgContainer:last-child .msg{
			border-bottom-right-radius: 18px;
		}
	</style>
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