<?php
include 'common.php';

function lcg_rand()
{
	static $seed = 0xDEADBEEFDEADCAFE;
	//a, c, & m are taken from wikipedia to have nice mathematical properties
	//Courtesy of Donald Knuth
	define('a', 6364136223846793005);
	define('c', 1442695040888963407);
	$seed = ($seed * a + c) & (1 << 64 - 1);
	return $seed;
}

$error = null;

if ($user->loggedIn) {
	redir('/casino/');
}

if (isset($_POST['submit'])) {
	$username = $_POST['username'];
	$password = $_POST['password'];
	$submit = $_POST['submit'];

	$existing_req = $pdo->prepare('SELECT * FROM userinfo WHERE username=?;');
	$existing_req->execute([$username]);
	$existing = $existing_req->fetch();
	$existing_req->closeCursor();

	$add_cookie = $pdo->prepare('INSERT INTO cookies (cookie, userid) VALUES (?, ?);');

	if ($submit == 'register' && !$existing) {
		$s = $pdo->prepare("INSERT INTO userinfo (username, hashpass, isAdmin) VALUES (?, ?, ?);");
		$s->execute([$username, hash('sha256', $password), "FALSE"]);

		$existing_req->execute([$username]);
		$existing = $existing_req->fetch();

		$cookie = lcg_rand();
		$add_cookie->execute([$cookie, $existing['id']]);
		setcookie('authentication', $cookie);
	} else if ($submit == 'login' && $existing) {
		if ($existing->hashpass == hash('sha256', $password)) {
			$cookie = lcg_rand();
			$add_cookie->execute([$cookie, $existing['id']]);
			setcookie('authentication', $cookie);
		} else {
			$error = "This password is incorrect";
		}
	} else {
		$error = "This username is " . ($existing ? "already taken." : "not associated with any account.");
	}
	if (!$error) {
		redir('/casino/');
	}
}

?>

<html>

<body>

	<form method='post' action='<?php echo $_SERVER['PHP_SELF']; ?>'>
		Username:
		<input type='text' name='username'>
		<br /> <br />
		Password:
		<input type='password' name='password'>
		<br /> <br />
		<input type='submit' name='submit' value='login'>
		<input type='submit' name='submit' value='register'>
	</form>
</body>

</html>