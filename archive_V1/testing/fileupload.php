<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Testing...</title>
</head>


<body>


<form action="<?php echo $_SERVER['SELF_PHP']; ?>" method="post" enctype="multipart/form-data">
<input type="file" name="file_img" />
<input type="submit" name="btn_upload" value="Upload">	
</form>


<?php
//mysql_connect("localhost:3306", "root", "")or die("cannot connect to server"); 
//mysql_select_db("user")or die("cannot select DB");

if(isset($_POST['btn_upload'])){
	$val = $_POST['file_img'];
	$filetmp = $_FILES["file_img"]["tmp_name"];
	$filename = $_FILES["file_img"]["name"];
	$filetype = $_FILES["file_img"]["type"];
	$ext = pathinfo($filename, PATHINFO_EXTENSION);
	$filename = time().".".$ext;
	$filepath = "chatpic/".$filename;
	
	move_uploaded_file($filetmp,$filepath);
	
	//$sql = "INSERT INTO user_info (img_path) VALUES ('$filepath')";
	//$result = mysql_query($sql);

	echo "successfully uploaded";
}
?>


</body>
</html>


