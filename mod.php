<?php
if ($_COOKIE["mail"]){
	$mail = $_COOKIE["mail"];
	$conn = new PDO("mysql:host=localhost;dbname=micropost",array_map("trim", file("conf.txt"))[0],array_map("trim", file("conf.txt"))[1]);
	$check = $conn->query("select admin from users where mail='$mail'")->fetch();
		if ($check[0] == true){
			if ($_SERVER["REQUEST_METHOD"] == "GET"){
				if ($_GET["action"]=="delmsg"){
					$conn->query("delete from posts where ID=".$_GET['var']);
				}elseif ($_GET["action"]=="delusr"){
					$conn->query("delete from users where ID=".$_GET['var']);
				}elseif ($_GET["action"]=="clearmsg"){
					$conn->query("delete from posts");
				}elseif ($_GET["action"]=="clearusr"){
					$conn->query("delete from users where admin=false");
				}elseif ($_GET["action"]=="makemod"){
					$conn->query("update users set admin=1 where ID=".$_GET['var']);
				}elseif ($_GET["action"]=="unmod"){
					$conn->query("update users set admin=0 where ID=".$_GET['var']);
				}else{
	
				}
			}
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
<title>website</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta charset="UTF-8">
<link rel="stylesheet" href="main.css">
</head>
<body>
	<nav>
		<a href="index.php"><span>POSTS</span></a>
		<a href="admin.php"><span>SETTINGS</span></a>
		<?php
		if ($_COOKIE["mail"]){
			$mail = $_COOKIE["mail"];
			$conn = new PDO("mysql:host=localhost;dbname=micropost",array_map("trim", file("conf.txt"))[0],array_map("trim", file("conf.txt"))[1]);
			$check = $conn->query("select admin from users where mail='$mail'")->fetch();
			if ($check[0] == true){
				echo '<a href="mod.php"><span>MODERATION</span></a>';
			}
		}
?>
	</nav><hr>
	<?php
	if ($check[0] == true){
		echo "<div id='users'>USERS: <a href='mod.php?action=clearusr' style='float:right;' title='remove all users'>⌦</a>";
		$conn = new PDO("mysql:host=localhost;dbname=micropost",array_map("trim", file("conf.txt"))[0],array_map("trim", file("conf.txt"))[1]);
		$users = $conn->query("select * from users");
		foreach ($users as $user){
			echo '<div class="muser"><div class="id">'.$user['ID'].'<a style="float:right;" href="mod.php?action=delusr&var='.$user['ID'].'" title="remove user">⌦</a></div><hr><div class="name">'.$user['name'].'</div><div class="mail">'.$user['mail'].'</div><div class="admin">isAdmin: '.$user['admin']; if($user['admin']==true){echo "<a title='remove from moderation' href='mod.php?action=demod&var=".$user['ID']."' style='float:right;'> ⚔";}else{echo "<a title='add to moderation' href='mod.php?action=makemod&var=".$user['ID']."' style='float:right;'>⚔";} echo'</a></div></div>';
		}
		echo "</div><div id='msg'>MESSAGES: <a href='mod.php?action=clearmsg' style='float:right;' title='remove all messages'>⌦</a>";
		$msgs = $conn->query("select * from posts");
		foreach ($msgs as $msg){
			echo '<div class="mpost"><div class="id">'.$msg['ID'].'<a style="float:right;" href="mod.php?action=delmsg&var='.$msg['ID'].'" title="remove message">⌦</a></div><hr><div class="nick">'.$msg['author'].'</div><div class="message">'.htmlspecialchars($msg['content']).'<br><small><i>'.$msg['time'].'</i></small></div></div>';
		}
		echo "</div>";
	}
	?>
<script>
</script>
</body>
</html>
