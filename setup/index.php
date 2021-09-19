<?
// load db connection info
require_once "$_SERVER[DOCUMENT_ROOT]/api/system.php";

// create connection and load db build queries
echo "Connecting to database<br>";
$conn = new mysqli(servername, username, password);
$sqlQueries = file_get_contents('chatGroup.sql');

// check for connection errors
if($conn->connect_errno){
   echo $conn->connect_error;
}
echo "Connected to database<br>";

// execute the full build with sample info
if($conn->multi_query($sqlQueries)){
	echo "Building database<br>";
	while($conn->next_result()){
		/* $result = $conn->store_result();
		$result->free(); */
	}
}

// check for any errors //

// build successful
$conn->close();
echo "Database built<br>Ready to use!!!";
?>