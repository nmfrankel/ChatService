<?
//  ||\\   ||\\   //||||||||
//  || \\  || \\ // ||
//  ||  \\ ||  \\/  |||||
//  ||   \\||       ||
//
//    NOSSON M FRANKEL
//    nossonmfrankel@gmail.com
//    ALL RIGHTS RESERVED, © 2020

## system main version 0.1

/* hide to the public */
if (basename($_SERVER[PHP_SELF])===basename(__FILE__)):
	// look into hiding page through comparing [SERVER_ADDR] and [REMOTE_ADDR]
	http_response_code(404);
	header('HTTP/1.1 404 Not Found');
	die(file_get_contents("$_SERVER[DOCUMENT_ROOT]/missing.php"));
endif;


/* parameters used system wide */

// runs autoLoad() when a class is called
spl_autoload_register('autoLoad');

// common parameters
set_time_limit(0);
session_start();
date_default_timezone_set("America/New_York");
$version = 0.01;
$websiteUrl = "----.com";
$unix = date(U);
$dst = date(I) ? 3600: 0;
$today = date("U", (($unix - ($unix-18000-7200)%86400))-$dst);

// database details
$isTesting = $_SERVER[HTTP_HOST]=='localhost' || $_SERVER[HTTP_HOST]=='127.0.0.1'? 1: 0;
define(servername, $isTesting===1? "localhost": "");
define(username, $isTesting===1? "root": "");
define(password, $isTesting===1? "root": "");
define(dbname, $isTesting===1? "chatGroup": "");


/* functions used system wide */

// loads classes as used from the '/api/classes/' folder
function autoLoad($className){
    $path = "$_SERVER[DOCUMENT_ROOT]/api/classes/";// folder where classes are in
    $fullPath = "$path$className.php";

	if (!file_exists($fullPath)) return false;

    include_once $fullPath;
}
// following 2 functions cover encryption and decryption
function encrypt($string, $salt = 'Open-Source_Software', $static = true){
	$string = rtrim($string);
	$key = crypt('?.3#&6^','$6$'.md5(md5(md5($salt))).'^@@d55');
	$ivlen = openssl_cipher_iv_length($cipher="AES-256-CBC");
	if($static):
		$iv = crypt('!#9+8*m','$6$@@***'.md5(md5(md5('yAY$8f29r'))));
	else:
		$iv = openssl_random_pseudo_bytes($ivlen);// random string every time encrypted
	endif;
	$iv = substr(hash('sha256', $iv), 0, 16);
	$ciphertext_raw = openssl_encrypt($string, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
	$hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
	return base64_encode($iv.$hmac.$ciphertext_raw);
}
function decrypt($string, $salt = 'Open-Source_Software'){
	$string = rtrim($string);
	$c = base64_decode($string);
	$key = crypt('?.3#&6^','$6$'.md5(md5(md5($salt))).'^@@d55');
	$ivlen = openssl_cipher_iv_length($cipher="AES-256-CBC");
	$iv = substr($c, 0, $ivlen);
	$hmac = substr($c, $ivlen, $sha2len=32);
	$ciphertext_raw = substr($c, $ivlen+$sha2len);
	$original_plaintext = openssl_decrypt($ciphertext_raw, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
	$calcmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
	if (hash_equals($hmac, $calcmac)) return $original_plaintext;//PHP 5.6+ timing attack safe comparison
}
// Prevent cross-site scripting
function escXSS($string){
	return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}
// generate random string
function randomStr($len = 'null'){
	if(!is_int($len)) $len = random_int(9, 19);
	$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()=+?";

	$cipher = substr(str_shuffle($chars), 0, $len);
	return $cipher;
}
// generate a random id
function UUIDv4() {
    return sprintf('%04x%04x_%04x_%04x_%04x_%04x%04x%04x',
      // 32 bits for "time_low"
      mt_rand(0, 0xffff), mt_rand(0, 0xffff),

      // 16 bits for "time_mid"
      mt_rand(0, 0xffff),

      // 16 bits for "time_hi_and_version",
      // four most significant bits holds version number 4
      mt_rand(0, 0x0fff) | 0x4000,

      // 16 bits, 8 bits for "clk_seq_hi_res",
      // 8 bits for "clk_seq_low",
      // two most significant bits holds zero and one for variant DCE1.1
      mt_rand(0, 0x3fff) | 0x8000,

      // 48 bits for "node"
      mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
    );
}
// Format phone number to (XXX) XXX-XXXX
function phoneNumber($string){
	$string = strval($string);
	preg_match_all('/\(?([2-9]\d{2})\)?[-. ]?(\d{0,3})?[-. ]?(\d{0,4})?/', $string, $group);

	$number = "(".$group[1][0].") ".$group[2][0]."-".$group[3][0];
	return $number;
}