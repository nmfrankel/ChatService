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
					'handle' => UUIDv4(),
					'name' => 'Shea Rubin',
					// 'lastMsg' => 'You: I can\'t find you, where you at?',
					'lastMsg' => 'You: I can\'t find you, where you at?',
					'img' => 'avatar_anonymous',
					'time' => date(U)-30,
					'new' => 2
				],[
					'handle' => UUIDv4(),
					'name' => 'Moti Taub',
					'lastMsg' => 'Did you get a response yet?',
					'img' => null,
					'time' => date(U)-150,
					'new' => 0
				],[
					'handle' => UUIDv4(),
					'name' => 'Another Person',
					'lastMsg' => 'I think Tuesday will work out better 😊',
					'img' => null,
					'time' => date(U)-4680,
					'new' => 13
				],[
					'handle' => UUIDv4(),
					'name' => 'Nosson M Frankel',
					'lastMsg' => 'Reminder: Set the tracker on.',
					'img' => '5de34a809a67f_1575176832',
					'time' => date(U)-129600,
					'new' => 0
				],[
					'handle' => UUIDv4(),
					'name' => 'Zobe Chat',
					'lastMsg' => 'KlatzCo: I think the fireworks display started.',
					'img' => null,
					'time' => date(U)-626400,
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
			'msgs' => [
				[
					'id' => UUIDv4(),
					'sender' => 'notMe',
					'content' => 'Can you come outside to help with the wire?',
					'read' => 0,
					'time' => date(U)*1000
				],[
					'id' => UUIDv4(),
					'sender' => '',
					'content' => 'I\'ll be outside in a min',
					'read' => 0,
					'time' => date(U)*1000 - 50000
				],[
					'id' => UUIDv4(),
					'sender' => 'notMe',
					'content' => 'Where are you',
					'read' => 0,
					'time' => date(U)*1000 - 150000
				],[
					'id' => UUIDv4(),
					'sender' => 'notMe',
					'content' => 'Random fact if you\'d keep a piece of silver foil in between your wireless cards you should be able to continue skating then down when you pay.
					Ps I know you said you USED to have a thin wallet, so in theory. ',
					'read' => 0,
					'time' => date(U)*1000 - 150000
				],[
					'id' => UUIDv4(),
					'sender' => '',
					'content' => 'Hi <span style="background:#e91e63;">Moti</span>, on my way...',
					'read' => 0,
					'time' => date(U)*1000 - 225000
				],[
					'id' => UUIDv4(),
					'sender' => '',
					'content' => 'Sorry... <span style="background:lightblue;">Shea</span>',
					'read' => 0,
					'time' => date(U)*1000 - 300000
				],[
					'id' => UUIDv4(),
					'sender' => '',
					'content' => 'Random long message about nothing important.',
					'read' => 0,
					'time' => date(U)*1000 - 350000
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
