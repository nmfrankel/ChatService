<?php
//show information
ini_set('display_errors',1);
error_reporting(E_ALL);
$conn = mysql_connect("localhost:3306","root","");
if(!$conn)
{
echo mysql_error();
}
$db = mysql_select_db("user",$conn);
if(!$db)
{
echo mysql_error();
}

$q = "SELECT * FROM user_info";
$r = mysql_query("$q",$conn);
if($r)
{
while($row=mysql_fetch_array($r))
{
//header("Content-type: text/html");
echo "</br>";
echo $row['name'];
echo "</br>";
echo $row['test'];
echo "</br>";

//$type = "Content-type: ".$row['aphototype'];
//header($type);
echo "<img src=".$row['img_path']." width=50 height=50/>";


}
}
else
{
echo mysql_error();
}
?>