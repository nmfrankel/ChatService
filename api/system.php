<?
// ||\\   ||\\   //||||||||
// || \\  || \\ // ||
// ||  \\ ||  \\/  |||||
// ||   \\||       ||

// 	NOSSON M FRANKEL
// 	nossonmfrankel@gmail.com
// 	ALL RIGHTS RESERVED, © 2020

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

// Prevent cross-site scripting
function escXSS($string){
	return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}
// Format phone number to (XXX) XXX-XXXX
function phoneNumber($string){
	$string = strval($string);
	preg_match_all('/\(?([2-9]\d{2})\)?[-. ]?(\d{0,3})?[-. ]?(\d{0,4})?/', $string, $group);

	$number = "(".$group[1][0].") ".$group[2][0]."-".$group[3][0];
	return $number;
}

// generate random string
function randomStr($len = 'null'){
	if(!is_int($len)) $len = random_int(9, 19);
	$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()=+?";

	$cipher = substr(str_shuffle($chars), 0, $len);
	return $cipher;
}
