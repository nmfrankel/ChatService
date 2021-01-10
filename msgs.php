<!-- takeover conversations.php -->
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
	<script src="./scripts/msgs.js" defer></script>
    <title>Messages | ChatGroup</title>
    <style>
		/* section:first-of-type .container{
			box-shadow: -2px 2px 6px 2px #f3f3f3;
			/* background: tomato; *
		} */
		
		#threads.slideOutLeft{
			animation: slideOutLeft 150ms ease-in 0s 1 forwards;
		}
		#threads.slideOutRight{
			animation: slideOutRight 150ms ease-in 0s 1 forwards;
		}
		.thread{
			position: relative;
			overflow: hidden;
			margin: 2px auto;
			padding: 8px 10px;
			border-bottom: 2px solid #f3f3f3;
			background: #fff;
			cursor: pointer;
			animation: slide-threads-in 150ms ease-out 0s 1 forwards;						
		}
		.thread:last-of-type{
			border-bottom: none;
		}
		.thread:hover, .thread:focus{
			border-radius: 5px;
			box-shadow: -2px 2px 6px 2px #eeeeee;
		}
		.picContainer{
			display: inline-block;
			height: 50px;
			width: 50px;
			margin: 3px 0 0 15px;
			border-radius: 50%;
			box-shadow: -1px 2px 10px 2px #e6e6e6;
			z-index: 5;
			overflow: hidden;
		}
		.picContainer .userPicture{
			height: 100%;
			width: 100%;
		}
		.name{
			font-weight: 700;
			font-size: 18px;
			position: absolute;
			top: 15px;
			padding-left: 20px;
		}
		.lastMessage{
			display: inline-block;
			position: absolute;
			top: 40px;
			margin-left: 20px;
			padding-right: 15px;
			box-sizing: border-box;
			width: 80%;
			font-size: 16px;
			line-height: 1.25;
			color: #777;
			overflow: hidden;
		}
		.time{
			font-size: 12px;
			color: #888;
			position: absolute;
			top: 25px;
			right: 50px;
		}
		.chevron{
			float: right;
			height: 24px;
			width: 24px;
			margin: 15px 5px 0 0;
			content: url("data:image/svg+xml;charset=utf-8,<svg viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg' fill='rgb(153,153,153)'><path d='M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z'/><path d='M0 0h24v24H0z' fill='none'/></svg>");
			/* data:image/svg+xml;charset=utf-8,<svg viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg' fill='rgb(153,153,153)'><path d='M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z'/><path d='M0 0h24v24H0z' fill='none'/></svg> */
		}
@keyframes slide-threads-in{
	0%{
		position: relative;
		top: -50px;
		opacity: .4;
		transform: rotateX(60deg);
	}
	90%{
		position: relative;
		top: 0px;
		opacity: 1;
		transform: rotateX(0deg);
	}
}
    </style>
</head>
<body>

	<section>
		<div class="container" id="threads">
				<!--  id="threads" -->
				<!-- autofill message threads here -->

			<!-- <div class="cta">
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/><path d="M0 0h24v24H0z" fill="none"/></svg>
			</div> -->
		</div>
	</section>

</body>
</html>