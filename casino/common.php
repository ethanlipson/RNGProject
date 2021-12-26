<?php
//boilerplate goes here.

function customError($errno, $errstr, $file, $line, $context) {
	echo "<b>Error in $file, line $line :</b>\n[$errno] $errstr\n\n$context\n\n\n";
}
set_error_handler("customError");

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

$user = new stdClass();

if(isset($_COOKIE['authentication'])) {
	$statement = $pdo->prepare("SELECT * FROM cookies where cookie = :cookie;", $_COOKIE['authentication']);
	$row = $statement->fetch();
	$user->username = $row->username;
}

?>