<!DOCTYPE html>
<html>
<head>
<title>micropost</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta charset="UTF-8">
<link rel="stylesheet" href="main.css">
</head>
<body>
<?php
if ($_COOKIE["mail"]){
echo '
<nav>
<a href="index.php"><span>POSTS</span></a> 
<a href="admin.php"><span>SETTINGS</span></a>
';
$mail = $_COOKIE["mail"];
$conn = new PDO("mysql:host=localhost;dbname=micropost",array_map("trim", file("conf.txt"))[0],array_map("trim", file("conf.txt"))[1]);
$check = $conn->query("select admin from users where mail='$mail'")->fetch();
if ($check[0] == 1){
	echo '<a href="mod.php"><span>MODERATION</span></a>';
}
echo '
<a href="index.php?logout=true"><span>LOGOUT</span></a>
</nav>
<hr>
';
echo "";
}
?>
<script>
</script>
</body>
</html>
