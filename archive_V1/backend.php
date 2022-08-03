<?php
	set_time_limit(0);
	/*ini_set('session.gc_maxlifetime', 1800);
	session_set_cookie_params(1800);*/
	session_start();
	date_default_timezone_set("America/New_York");

	// Prevent cross-site scripting
	function escape_xss($string){
		return htmlspecialchars($string, ENT_QUOTES, 'utf-8');
	}
	function f_clean($array) {
		return array_map('mysql_real_escape_string', $array);
	}
	function parseDate($timestamp, $option = 1){
		if($option == 1){
			if(date('m/d/y', $timestamp) == date('m/d/y')){
				return date("g:i A",$timestamp);
			}else if(date('m/d/y', $timestamp) == date('m/d/y', date('U')-86400)){
				return 'Yesterday';
			}else if(date('y', $timestamp) == date('y', date('U'))){
				return date('m/d', $timestamp);
			}else{
				return date('m/d/y', $timestamp);
			}
		}else{
			return date('g:i A m/d/y', $timestamp);
		}
	}
	// for encryption
	$key = crypt('?.3#&6^','$6$'.md5(md5(md5('N^s%*n'))).'^@@d55');
	// $iv = crypt('!#9+8*m','$6$@@***'.md5(md5(md5('suPR$$3c0r3'))));
	$iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC), MCRYPT_DEV_URANDOM);
	// encrypt
	function encrypt($string){
		return rtrim(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, hash('sha256', $key, true), $string, MCRYPT_MODE_ECB, $iv)));
	}
	// decrypt
	function decrypt($string){
		if ($string != '') {
			return rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, hash('sha256', $key, true), base64_decode($string), MCRYPT_MODE_ECB, $iv));
		}
	}
	// parse phone numbers
	function phoneNumber($numbers){
		$numbers = '9293339621';
		// use regex - /\(?([2-9]\d{2})\)?[-. ]?(\d{0,3})?[-. ]?(\d{0,4})?/
		$return = $numbers;
	
		return $return;
	}

	// parameters for the database : mesivtaveretzky.com database
	$testing = $_SERVER[HTTP_HOST]=='localhost'||$_SERVER[HTTP_HOST]=='127.0.0.1'? 1: 0;
	$servername = $testing===1 ? "localhost": "mysql-mvusers.mesivtaveretzky.com";
	$usrnme = $testing===1 ? "root": "nm120";
	$pswrd = $testing===1 ? "root": "Nosson00";
	$dbname = "mvusers";
	// parameteres for encryption & posted info
	$salt = md5('nOs5@n(5/?');
	$req_type = escape_xss($_POST["type"]);
	$auth = escape_xss($_POST["auth"]);
	// For testing purposes
	// echo "auth: $auth, req_type: $req_type";


    if($auth==true){
		if($req_type=='register'){

			$value1 = ucwords(strtolower(escape_xss($_POST['name'])));
			$email = strtolower(escape_xss($_POST['email']));
			$password = escape_xss($_POST['password']);
			$value4 = escape_xss($_POST['confirm_password']);

			if (empty($value1)){
				echo "<p>Your Name Is Required</p><p><a href='register.html'>Try Again</a></p>";
				die;
			}
			if (strlen($value1) <= 4){
				echo "<p>Your Name Is Too Short</p><p><a href='register.html'>Try Again</a></p>";
				die;
			}
			if (strlen($value1) >= 25){
				echo "<p>Your Name Is Too Long</p><p><a href='register.html'>Try Again</a></p>";
				die;
			}
			if (empty($value2)){
				echo "<p>A Email Is Required</p><p><a href='register.html'>Try Again</a></p>";
				die;
			}
/*
  if (empty($_POST["email"])) {
    $emailErr = "Email is required";
  } else {
    $email = test_input($_POST["email"]);
    // check if e-mail address is well-formed
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "Invalid email format"; 
    }
  }
*/
			if (strlen($email) <= 9){
				echo "<p>Your Email Is Too Short</p><p><a href='register.html'>Try Again</a></p>";
				die;
			}
			if (strlen($email) >= 40){
				echo "<p>Your Email Is Too Long</p><p><a href='register.html'>Try Again</a></p>";
				die;
			}else{
				$email = encrypt($email);
			}
			if (empty($password)){
				echo "<p>A Password Is Required</p><p><a href='register.html'>Try Again</a></p>";
				die;
			}
			if (strlen($password) <= 6){
				echo "<p>Your Password Is Too Short</p><p><a href='register.html'>Try Again</a></p>";
				die;
			}
			if (strlen($password) >= 25){
				echo "<p>Your Password Is Too Long</p><p><a href='register.html'>Try Again</a></p>";
				die;
			}else{
				$password = encrypt($password);
			}
			// Was there a reCAPTCHA response?
			if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])){
				//your site secret key
				// $secret = '6LeasQkUAAAAAKWxd768_z2hEXFnS2kbBSunVgJ3';
				// for localhost use
				$secret = '6LfDegoUAAAAAJkUGBD4ioLEEGUXQbGvE0JNxkKu';
				//get verify response data
				$verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
				$responseData = json_decode($verifyResponse);
				if($responseData->success){
					echo '<p style="display:none;">not a robot</p>';
				}else{
					echo "<p>Confirm You Are Not A Robot</p><p><a href='register.html'>Try Again</a></p>";
					die;
				}
			}else{
				echo "error";
			}
			if ($value3 !== $value4){
				echo "<p>The Passwords Entered Didn't Match</p><p><a href='register.html'>Try Again</a></p>";
				die;
			}

			//uploads the file
			$filetmp = $_FILES["file_img"]["tmp_name"];
			/* create new name file */
			$filename   = uniqid() . "_" . time(); // 5dab1961e93a7_1571494241
			$extension  = pathinfo( $_FILES["file_img"]["name"], PATHINFO_EXTENSION ); // jpg
			$basename   = $filename.'.'.$extension; // 5dab1961e93a7_1571494241.jpg

			$filepath = "chatpic/".$basename;
			if(move_uploaded_file($filetmp, $filepath)){
				$conn = new mysqli($servername, $usrnme, $pswrd, $dbname);
				$result = $conn->query("INSERT INTO user_id (ID, username, password, name, profileimg) VALUES (NULL, '$email', '$password', '$value1', '$basename')");
				$conn->close();

				echo "<p>User Account Was Created Successfully<br><a href='login'>log in</a></p>";
			}
		}else if($req_type=='login'){

			$usr = encrypt(strtolower(escape_xss($_POST["username"])));
			$pswd = encrypt(escape_xss($_POST["password"]));

			$conn = new mysqli($servername, $usrnme, $pswrd, $dbname);
			$result = $conn->query("SELECT * FROM user_id WHERE username LIKE '$usr' AND password = '$pswd'");
			$conn->close();

			if ($result->num_rows>0){

				while($row = $result->fetch_array()){
					$_SESSION['user'] = $row['name'];
					$_SESSION['id'] = $row['id'];
					$_SESSION['phone'] = $row['phone'];
					$_SESSION['img'] = $row['profileimg'];
				}

				var_dump(http_response_code(204));
			}else{
				echo'The username or password are incorrect!';
			}
		}else if($req_type=='post'){
			if (!empty($_POST['mTxt']) && !empty($_POST['in2']) && $_SESSION['user'] == $_POST['userName'] && $_SESSION['id'] == $_POST['in2'] && $_POST['csrfKey'] = $_SESSION['csrfToken']){
			
				$value1 = escape_xss($_SESSION['id']);
				$recip = decrypt(base64_decode(escape_xss($_POST['recip'])));
				$mTxt = escape_xss($_POST['mTxt']);
				$timeStamp = time();
			
				$conn = new mysqli($servername, $usrnme, $pswrd, $dbname);
				$result = $conn->query("INSERT INTO messages (ID, name, recipient, text, time) VALUES (NULL, '$value1', '$recip', '$mTxt', '$timeStamp')");
				$conn->close();
				
				var_dump(http_response_code(204));
			}
		}
	}else if((strtok($_SERVER['REQUEST_URI'], '?')=='/backend'||strtok($_SERVER['REQUEST_URI'], '?')=='/backend.php')&&($_SERVER['REDIRECT_STATUS']==200)){

		if($_SERVER[REQUEST_SCHEME]){
			$url = $_SERVER[REQUEST_SCHEME].'://'.$_SERVER[HTTP_HOST].'/missing.html';
		}else{
			$url = $_SERVER[HTTP_HOST].'/missing.html';
		}
		$ch = curl_init($url);
		curl_exec($ch);
		curl_close($ch);
	}
?>