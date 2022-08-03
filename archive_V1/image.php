<?php
ini_set('display_errors',1);
error_reporting(E_ALL);
$conn = mysql_connect("localhost","root","");
if(!$conn)
{
echo mysql_error();
}
$db = mysql_select_db("imagestore",$conn);
if(!$db)
{
echo mysql_error();
}
$ano = $_GET['ano'];
$q = "SELECT * FROM user_id" ;
$r = mysql_query("$q",$conn);
if($r)
{

$row = mysql_fetch_array($r);
$type = "Content-type: ".$row['aphototype'];
header($type);
echo $row['aphoto'];
}
else
{
echo mysql_error();
}

?>