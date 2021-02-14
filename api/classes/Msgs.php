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
					'handle' => base64_encode('0'),
					'name' => 'Shea Rubin',
					'lastMsg' => 'Shloimy B: Where\'s the crib at tonight?',
					'imgLoc' => 'LPlogo',
					'time' => 0,
					'new' => 1
				],[
					'handle' => base64_encode('1'),
					'name' => 'Nosson M Frankel',
					'lastMsg' => 'Me: I cant find you, Where are you?',
					'imgLoc' => '5de34a809a67f_1575176832',
					'time' => 0,
					'new' => 0
				],[
					'handle' => base64_encode('3'),
					'name' => 'Zobe Chat',
					'lastMsg' => 'Capt. Joe: Vote for joe for oatmeal 2020',
					'imgLoc' => 'missing',
					'time' => 0,
					'new' => 0
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
			'chatTitle' => 'Other User\'s Name',
			'messages' => [
				[
					'id' => base64_encode('0'),
					'sender' => 'notMe',
					'content' => 'Can you come outside to help with the wire?',
					'read' => 0,
					'time' => date(U)*1000
				],[
					'id' => base64_encode('1'),
					'sender' => '',
					'content' => 'I\'ll be outside in a min',
					'read' => 0,
					'time' => date(U)*1000 - 50000
				],[
					'id' => base64_encode('2'),
					'sender' => 'notMe',
					'content' => 'Where are you',
					'read' => 0,
					'time' => date(U)*1000 - 150000
				],[
					'id' => base64_encode('3'),
					'sender' => '',
					'content' => 'Hi <span style="background:#e91e63;">Moti</span>, on my way...',
					'read' => 0,
					'time' => date(U)*1000 - 225000
				],[
					'id' => base64_encode('4'),
					'sender' => '',
					'content' => 'Sorry... <span style="background:lightblue;">Shea</span>',
					'read' => 0,
					'time' => date(U)*1000 - 300000
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
