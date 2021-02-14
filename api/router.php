<?
/*     _         _        _ _ _ _ _ _ _
     /_/       /_//     /_/_/_/_/_/_/_/
    /_/_/     /_//_/  /_/ /_/
   /_/ /_/   /_/ /_//_/  /_/_ _ _ _
  /_/   /_/ /_/   /_/   /_/_/_/_/_/
 /_/     /_/_/         /_/
/_/       /_/         /_/

	NOSSON M FRANKEL
	nossonmfrankel@gmail.com
	ALL RIGHTS RESERVED, © 2020
*/

## api version 0.1
	require_once './system.php';

## gather request/response info
	$req = [
		'auth' => false, // look for auth header
		'method' => escXSS($_SERVER['REQUEST_METHOD']),
		'path' => preg_replace('#\?.*#', '', $_SERVER['REQUEST_URI'])  
	];
	$res = [];

## router ahead
	if ($req[path] === '/api/login' && $req[method] === 'POST'):
		# route: /login
		$res = Users::login();
	elseif ($req[path] === '/api/logout'):
		# route: /*
		$res = Users::logout();
	elseif ($req[path] === '/api/threads' && $req[method] === 'GET'):
		# route: /msgs
		$res = Msgs::threads();
	elseif (preg_match('/\/api\/cluster\/([\w\d]+)/', $req[path], $id) && $req[method] === 'GET'):
		# route: /chat
		$res = Msgs::cluster($id[1]);
	elseif ($req[path] === '/api/msg' && $req[method] === 'POST'):
		# route: /chat
		$res = Msgs::create();
	else:
		// header('HTTP/1.1 401 Unauthorized');
		// print 'Error 401 Unauthorized access';
		die('{"errMsg": "method not defined"}');
	endif;

	// send response that was set earlier to user
	header("Content-Type: application/json; charset=UTF-8\r\n");
	echo json_encode($res);




/* $input = 'test';
$moded = encrypt($input, 'qwerty', false);
$demoded = decrypt($moded, 'qwerty');
echo "$moded<br>$demoded<br>"; */