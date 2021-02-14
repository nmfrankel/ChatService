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
	ALL RIGHTS RESERVED, 2020
*/

class Db{
	static private $dbConn, $savedResult;

	private function connect(){
		if (!self::connected()) self::$dbConn = new mysqli(servername, username, password, dbname);
		return self::$dbConn;
	}

	public function connected(){
		return self::$dbConn;
	}

	public static function disconnect() {
		self::$dbConn = null;
	}

	public static function query($query){
		self::connect();
		self::$savedResult = self::$dbConn->query($query);
// echo $query."\n";
		return self::$savedResult;
	}

	public static function one(){
		if(self::$savedResult->field_count > 0) self::$savedResult = self::$savedResult->fetch_assoc();
		return self::$savedResult;
	}
}