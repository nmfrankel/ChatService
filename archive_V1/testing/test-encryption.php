<html>
<head>
	<title>PHP TEST</title>
	<style type="text/css">
		body{
			background-color: #eee;
		}
	</style>
</head>
<body>

<?php
if(isset($_POST['submit'])){
	$name = $_POST["name"];
	//echo "" . $name;

	$iv= mcrypt_create_iv(
	    mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC),
	    MCRYPT_DEV_URANDOM
	);

	//echo crypt($name, '$6$'.md5('nOs5@n(5/?').'^@@d55');
	$key = crypt('?.3#&6^','$6$'.md5(md5(md5('N^s%*n'))).'^@@d55');
	//echo '<br><br>'.$key;
//encrypted
	$encrypted = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, hash('sha256', $key, true), $name, MCRYPT_MODE_ECB, $iv);
	echo '<br>'.$encrypted.'<br>';
//decrypted
	$decrypted = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, hash('sha256', $key, true), $encrypted, MCRYPT_MODE_ECB, $iv);
	echo '<br>'.$decrypted;
	//echo '<br><br>'.md5('nOs5@n(5/?')."<br><br>";

//encrypt
	function encrypt($string, $key){
		$string = rtrim(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $string, MCRYPT_MODE_ECB)));
		return $string;
	}
	encrypt($name, $key);
	echo "<br><br><br>Encrypted String: ".$string;
//decrypt
	$string = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, base64_decode($string), MCRYPT_MODE_ECB));
	echo "<br><br><br>Decrypted string: ".$string;
}
?>

<form action="<?php echo $_SERVER['SELF_PHP']; ?>" /*onSubmit="returnfalse;"*/ method="post">
	<span>Enter Your Name: </span>
	<input name="name" type="text">
	<input name="submit" type="submit">
</form>

</body>
</html>