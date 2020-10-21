<?php
	include ('../classes/adminLogin.php');

	$al = new adminLogin();
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$user = $_POST['user'];
		$password = md5($_POST['password']);

		$loginChk = $al->adminLogin($user, $password);
	}
?>

<!DOCTYPE html>
<head>
<meta charset="utf-8">
<title>Login</title>
    <link rel="stylesheet" type="text/css" href="css/stylelogin.css" media="screen" />
</head>
<body>
<div class="container">
	<section id="content">
		<form action="login.php" method="post">
			<h1>Admin Login</h1>
			<span style="color:red;font-size: 18px;">
				<?php
				if (isset($loginChk)) {
					echo "$loginChk";
				}
				?>
			</span>
			<div>
				<input type="text" placeholder="User" name="user"/>
			</div>
			<div>
				<input type="password" placeholder="Password" name="password"/>
			</div>
			<div>
				<input type="submit" value="Log in" />
			</div>
		</form><!-- form -->
		<div class="button">
			<a href="#">Full Stack Developer</a>
		</div><!-- button -->
	</section><!-- content -->
</div><!-- container -->
</body>
</html>