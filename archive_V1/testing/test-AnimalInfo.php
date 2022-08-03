<html>
<title>Animal Information </title>
<body>
<form enctype="multipart/form-data" action="test-StoreAnimalInfo.php" method="POST">

<table border=0 align=center bgcolor=black width=100%>
<tr><td colspan=2><h2>&nbsp</h2></td></tr>
</table>


<table border=0 align=center bgcolor=grey>
<tr><td colspan=2><h2>Animal Information</h2></td></tr>
<tr>
<td>Animal Name</td><td><input type=text name="name"></td>
</tr>
<tr>
<td>Animal Description</td><td><input type=text name="details"></td>
</tr>
<tr>
<td>Animal Photo</td><td><input type=file name="photo"></td>
</tr>
<tr>
<td></td><td><input type=submit name="submit" value="Store Information"></td>
</tr>
</table>
</form>
</body>
</html>