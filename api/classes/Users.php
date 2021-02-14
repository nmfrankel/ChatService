<?
/*     _         _        _ _ _ _ _ _ _
     /_/       /_//     /_/_/_/_/_/_/_/
    /_/_/     /_//_/  /_//_/
   /_/ /_/   /_/ /_//_/ /_/_ _ _ _
  /_/   /_/ /_/   /_/  /_/_/_/_/_/
 /_/     /_/_/        /_/
/_/       /_/        /_/

	NOSSON M FRANKEL
	nossonmfrankel@gmail.com
	ALL RIGHTS RESERVED, © 2020
*/

class Users{
	// create a user
	public function create(){

	}
	
	// get user details
	public function fetch(){

	}

	// @desc	login User
	// @route	POST /api/login/:email :pswd
	public function login(){
		$email = strtolower(escXSS($_POST['email']));
		$pswd = trim(escXSS($_POST['pswd']));
		$res = [
			loggedIn => 0,
			redirect => null,
			errCode => 0,
			msg => ''
		];

		// is email and pswd valid
		if(preg_match("/[\w\d.]{3,}@[\w\d]{3,}[.]\w{2,}/i", $email) && strlen($pswd) > 7 /*&& $_SESSION[login_attempts] <= 4*/):
			// check db if email exists
			$email = encrypt($email);
			Db::query("SELECT * FROM users WHERE email = '$email' AND status <> 0 LIMIT 1");

			// check if rows match email and password matches with the users salt
			if(Db::connected()->affected_rows>0 && Db::one()[pswd] === encrypt($pswd, Db::one()[salt])):
					unset($_SESSION[login_attempts]);
					$_SESSION = [
						'id' => encrypt(Db::one()[id]*193),
						'user_type' => Db::one()[status],
						'first' => Db::one()[first],
						'last' => decrypt(Db::one()[last]),
						'isLoggedIn' => true
					];
					$res = [
						loggedIn => 1,
						redirect => './msgs',
						msg => 'You were authenticated and logged in successfully\nredirecting...'
					];
			else:
				$_SESSION[login_attempts]++;
				$res[errCode] = 1;
				$res[msg] = 'Username and/or password do not match';
			endif;
		else:
			$_SESSION[login_attempts]++;
			$res = [
				errCode => 2,
				msg => 'Username and/or password are invalid'
			];

			if($_SESSION[login_attempts] > 4):
				// change to temporarily -> with counting login time
				$res = [
					errCode => 3,
					msg => 'Your account was disabled due to too many failed login attempts'
				];
			endif;
		endif;

		return $res;
	}

	// @desc	logout User
	// @route	GET /api/logout/
	public function logout(){
		session_destroy();
		$res = [
			loggedIn => 0,
			redirect => '../',
			errCode => 0,
			msg => 'User successfully logged out'
		];
		return $res;
	}

}


// INSERT INTO `users` (`id`, `status`, `username`, `password`, `handle`, `salt`, `first`, `last`, `phone`, `profImg`) VALUES (NULL, '1', 'ZjQ4NDM2Zjk4NTFmOTEyNBHUEmJcRLXbG+TJDFMBID1eeq1JmPlF03ny83JIKxAz2zwLJDZm3M6Bl9VqzCN8oymjkIPs5JCXavhZ2IjsLyw=', 'ZjQ4NDM2Zjk4NTFmOTEyNGOoO8u1nB43CL+lDSls7WBKK8ARgGmgb+TyWLz0a4xL2xNjfzfj9ggJWanU04eF5Q==', 'NMFrankel', '6021d77de4e3b', 'Nosson M', 'ZjQ4NDM2Zjk4NTFmOTEyNA/pdA5rWsdxW8+4oJywmKSNhIjUDKZZPG/HMdevhJHi4OM4Vy2sqUNQcR/gDGyqaA==', 'ZjQ4NDM2Zjk4NTFmOTEyNCZwDSfZE1fgSp7m2B7fowPxQJ5aGS8cfY538uMXFBRC8G2TmVzNxj7dHGQSR/+jTQ==', NULL);

/* 
	status
	username
	password has uniqid()
	handle
	salt
	first
	last
	phone has uniqid()
*/