<?php
$safeMode = 0;
if ($_SERVER["REQUEST_METHOD"] == "POST"){
	$conn = new PDO("mysql:host=localhost;dbname=micropost",array_map("trim", file("conf.txt"))[0],array_map("trim", file("conf.txt"))[1]);
	$mail = $_COOKIE['mail'];
	$nick = $conn->query("select name from users where mail='$mail'")->fetch();
	$msg = (string) $_POST["postEnter"];
	if ($safeMode == 0){
	$conn->query("insert into posts values (null,'$nick[0]','$msg',default)");
}elseif ($safeMode == 1){
	$conn->query("insert into posts values (null,'$nick[0]','".htmlspecialchars($msg)."',default)");
}
}elseif($_SERVER["REQUEST_METHOD"] == "GET" && $_GET["logout"]==true){
	setcookie("mail","",1,"/");
	echo "<script>location.href = 'index.php';</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>micropost</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta charset="UTF-8">
<meta name="description" content="micropost → main page">
<link rel="stylesheet" href="main.css">
</head>
<body>
<nav>
<a href="index.php"><span>POSTS</span></a>
<?php
if ($_COOKIE["mail"]){
echo '<a href="admin.php"><span>SETTINGS</span></a> ';
}else{
echo '<a href="login.php"><span>LOGIN</span></a>';
}
if ($_COOKIE["mail"]){
$mail = $_COOKIE["mail"];
$conn = new PDO("mysql:host=localhost;dbname=micropost",array_map("trim", file("conf.txt"))[0],array_map("trim", file("conf.txt"))[1]);
$check = $conn->query("select admin from users where mail='$mail'")->fetch();
}
if ($check[0] == true){
	echo '<a href="mod.php"><span>MODERATION</span></a>';
}
?>	
</nav>
<hr>
<?php
if($_COOKIE["mail"]){
echo '
	<div>
		<form name="post" method="post" action="index.php">
			<textarea id="postEnter" name="postEnter" cols="30" rows="10"></textarea>
			<label for="postEnter"><input type="submit" value="POOOST" accesskey=" "></label>
		</form>
	</div>
     ';
}
?>
<div class="messages">
<?php
$conn = new PDO("mysql:host=localhost;dbname=micropost",array_map("trim", file("conf.txt"))[0],array_map("trim", file("conf.txt"))[1]);
$msgs = $conn->query("select * from posts");
foreach ($msgs as $msg){
	echo '<div class="post"><div class="nick">'.$msg['author'].'</div><div class="message">'.$msg['content'].'<br><small><i>'.$msg['time'].'</i></small></div></div><hr width="75%">';
}
?>
</div>
<script>
</script>
</body>
</html>
