<?php
if ($_SERVER["REQUEST_METHOD"] == "POST"){
	if ($_POST["nick"]){
		$nick = trim(htmlspecialchars($_POST["nick"]));
		$mail = trim(htmlspecialchars($_POST["mail"]));
		$pass = trim(htmlspecialchars($_POST["password"]));
		$conn = new PDO("mysql:host=localhost;dbname=micropost",array_map("trim", file("conf.txt"))[0],array_map("trim", file("conf.txt"))[1]);
		$deduper = $conn->query("select count(*) from users where mail='$mail'");
		if($deduper->fetchColumn()){
			echo "<script>window.alert('this user already exists!!!')</script>";
		}else{
			$conn->exec("insert into users values (null,'$nick','$mail','$pass',0)");
			echo "<script>location.href = 'index.php'</script>";
		}
	}else{
		$conn = new PDO("mysql:host=localhost;dbname=micropost",array_map("trim", file("conf.txt"))[0],array_map("trim", file("conf.txt"))[1]);
		$mail = trim(htmlspecialchars($_POST["mail"]));
		$check = $conn->query("select password from users where mail='$mail'")->fetch();
		if ($_POST["password"] == $check[0]){
			setcookie("mail", $_POST["mail"], 2147483647,"/");
			echo "<script>location.href = 'index.php'</script>";
		}else{
			echo "<script>window.alert('bad password!!!')</script>";
		}
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>micropost</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta charset="UTF-8">
<meta name="description" content="micropost → make account">
<link rel="stylesheet" href="main.css">
</head>
<body>
<button onclick="location.href = 'index.php'">back to homescreen</button>
<div id="logger">
<form name="signup" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" >
<fieldset>
<legend>SIGN UP</legend>
<label for="snick">enter nickname:</label><input id="snick" type="text" minlength="3" maxlength="20" name="nick" required>
<label for="smail">enter your mail:</label><input id="smail" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" type="mail" name="mail" required>
<label for="spassword">enter strong password:</label><input id="spassword" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*_=+-]).{8,}$" type="password" name="password" required><br>
<input type="submit">
</fieldset>
</form>
<form name="login" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" >
<fieldset>
<legend>SIGN IN</legend>
<label for="mail">enter mail:</label><input id="mail" type="mail" name="mail" required>
<label for="password">enter password:</label><input id="password" type="password" name="password" required><br><br>
<input type="submit">
</fieldset>
</form>
</div>
<script>
</script>
</body>
</html>
