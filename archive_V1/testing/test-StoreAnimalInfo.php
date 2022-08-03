<?php
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
$aname = $_POST['name'];
$adetails = $_POST['details'];
$aphoto = addslashes (file_get_contents($_FILES['photo']['tmp_name']));
$image = getimagesize($_FILES['photo']['tmp_name']);//to know about image type etc

$imgtype = $image['mime'];

$q ="INSERT INTO user_info VALUES(NULL,'$aname','$aphoto','$imgtype')";

$r = mysql_query($q,$conn);
if($r)
{
echo "Information stored successfully";
}
else
{
echo mysql_error();
}


?>