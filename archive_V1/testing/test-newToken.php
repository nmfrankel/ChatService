<?php
	session_start();
	
	if (isset($_POST['submit']) && !empty($_POST['submit'])) {
		if($_POST['csrfKey'] != $_SESSION['csrfToken']) {
			die("Unauthorized source!");
		}else if($_POST['csrfKey'] = $_SESSION['csrfToken']){
			echo  "Success: $_POST[csrfKey]";
		}
	}

    $csrfToken = md5(uniqid(mt_rand(),true)); // Token generation updated

    $_SESSION['csrfToken'] = $csrfToken;
	
	echo `<br>${$_SERVER['SERVER_ADDR']}<br>${$_SERVER['REMOTE_ADDR']}`

?>
<form action="" method="post">
   <input type="text" name="csrfKey" value="<?=$csrfToken?>" />
   <input type="submit" name="submit">
</form>