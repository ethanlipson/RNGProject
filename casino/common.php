<?php
//boilerplate goes here.

function customError($errno, $errstr, $file, $line, $context)
{
	echo "<b>Error in $file, line $line :</b>\n[$errno] $errstr\n\n$context\n\n\n";
}
set_error_handler("customError");

function redir($url)
{
	header("Location: $url");
	exit();
}

$db = parse_url(getenv("DATABASE_URL"));
$db["path"] = ltrim($db["path"], "/");

$pdo = new PDO("pgsql:" . sprintf(
	"host=%s;port=%s;user=%s;password=%s;dbname=%s",
	$db["host"],
	$db["port"],
	$db["user"],
	$db["pass"],
	ltrim($db["path"], "/")
));
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$user = new stdClass();
$user->loggedIn = false;
$user->isAdmin = false;

if (isset($_COOKIE['authentication']) && $_COOKIE['authentication'] != "") {
	$statement = $pdo->prepare("SELECT * FROM cookies where cookie = ?;");
	$statement->execute([$_COOKIE['authentication']]);
	$row = $statement->fetch();
	if ($row) {
		$reqUser = $pdo->query("SELECT * FROM userinfo WHERE id=" . $row['userid'] . ";");
		$userRow = $reqUser->fetch();
		$user->username = $userRow['username'];
		$user->isAdmin = $userRow['isadmin'];
		$user->loggedIn = true;
	} else {
		setcookie('authentication', null, 1);
		redir($_SERVER['REQUEST_URI']);
	}
}
