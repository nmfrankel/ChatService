<?

class Msgs{
	// fetches all threads of a user
	public function threads(){
		$result = [
			'fetched' => true,
			'resCode' => 200,
			'fingerprint' => '123',
			'threads' => [
				[
					'id' => base64_encode(randomStr(6).'0'),
					'name' => 'Shloimy Braun',
					'lastMsg' => 'Shloimy B: Where\'s the crib at tonight?',
					'imgLoc' => 'LPlogo',
					'time' => 0
				],[
					'id' => base64_encode(randomStr(6).'1'),
					'name' => 'Nosson M Frankel',
					'lastMsg' => 'Me: I cant find you, Where are you?',
					'imgLoc' => '5de34a809a67f_1575176832',
					'time' => 0
				],[
					'id' => base64_encode(randomStr(6).'3'),
					'name' => 'Zobe Chat',
					'lastMsg' => 'Capt. Joe: Where\'s the crib at tonight?',
					'imgLoc' => 'missing',
					'time' => 0
				]
			]
		];

		return $result;
	}

	// gathers all messages between two users
    public function cluster(){

		$result = [
			'fetched' => true,
			'resCode' => 200,
			'fingerprint' => '456',
			'messages' => [
				[
					'id' => base64_encode(randomStr(6).'0'),
					'sender' => 'me',
					'content' => 'Can you come outside to help with the wire?',
					'read' => 0,
					'time' => intval(date(U))
				],[
					'id' => base64_encode(randomStr(6).'1'),
					'sender' => '',
					'content' => 'I\'ll be outside in a min',
					'read' => 0,
					'time' => date(U) - 100
				],[
					'id' => base64_encode(randomStr(6).'2'),
					'sender' => 'me',
					'content' => 'Where are you',
					'read' => 0,
					'time' => date(U) - 500
				],[
					'id' => base64_encode(randomStr(6).'3'),
					'sender' => '',
					'content' => 'Hi <span style="background:#e91e63;">Moti</span>, on my way...',
					'read' => 0,
					'time' => date(U) - 1000
				],[
					'id' => base64_encode(randomStr(6).'4'),
					'sender' => '',
					'content' => 'perfect',
					'read' => 0,
					'time' => date(U) - 1000
				]
			]
		];

		return $result;
	}
	
    public function create(){

		$_POST[id] = base64_encode(randomStr(6).random_int(0, 10));// for development
		$_POST[read] = 0;// for development
		$_POST[time] = date(U);// for development

		return $_POST;
	}
}
