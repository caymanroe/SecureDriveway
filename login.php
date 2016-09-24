<?php
	session_start();

	if (session_status() != PHP_SESSION_NONE) {
	    session_destroy();
	    session_start();
	}
	
	$wrong = "";
	if (isset($_POST['username']) && isset($_POST['password']) && $_POST['password'] != "") {
		include 'db.php';

		$username = strip_tags($_POST['username']);
		$pass = strip_tags($_POST['password']);

		$username = mysqli_real_escape_string($con, $username);
		$pass = mysqli_real_escape_string($con, $pass);

		$sql = "SELECT * FROM users WHERE username = '$username' LIMIT 1";

		$query = mysqli_query($con, $sql);
		$row = mysqli_fetch_row($query);

		$dbusername = $row[1];
		$dbhash = $row[2];

		if (password_verify($pass, $dbhash)) {
			$_SESSION['uid'] = $row[0];
			$_SESSION['fname'] = $row[3];
			$_SESSION['lname'] = $row[4];
			$_SESSION['lastLogin'] = $row[5];

			header("Location: index.php");
		}

		else {
			$wrong = "Incorrect Username/Password";
		}


	}

?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Secure Drive Control Panel</title>
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<link rel="stylesheet" type="text/css" href="css/fonts.css">
		<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
	</head>

	<body>

		<div id="logo"></div>
			
		<form name="new" id="login" action="login.php" method="post" enctype="multipart/form-data">

			<h1>Control Panel</h1>
					
			<div id="username">
				<input type="text" name="username" class="text-input" placeholder="Login">
			</div>

			<div id="password">
				<input type="password" name="password" class="text-input" placeholder="Password">
			</div>

			<input type="submit" value="LOGIN" name="Submit" id="submit_btn" class="button">
					
			<p id="wrong"><?php echo $wrong; ?></p>

		</form>
			


		<script src="js/jquery-3.1.1.min.js" type="text/javascript"></script>
		<script type="text/javascript" src="js/jquery.backstretch.min.js"></script>
		<script type="text/javascript">

			var isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent) ? true : false;

			jQuery(document).ready(function($){
    			if(!isMobile) {
					$.backstretch([
					"css/images/login1.jpg",
					"css/images/login2.jpg",
					"css/images/login3.jpg"
					], {duration: 5000, fade: 2000});
    			}
			});


		</script>
	</body>

</html>