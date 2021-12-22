<?php
//boilerplate goes here...

function customError($errno, $errstr, $file, $line, $context) {
	echo "<b>Error in $file, line $line :</b>\n[$errno] $errstr\n\n$context";
}
set_error_handler("customError");

$db = parse_url(getenv("DATABASE_URL"));
$db["path"] = ltrim($db["path"], "/");
$db = parse_url(getenv("DATABASE_URL"));

$pdo = new PDO("pgsql:" . sprintf(
    "host=%s;port=%s;user=%s;password=%s;dbname=%s",
    $db["host"],
    $db["port"],
    $db["user"],
    $db["pass"],
    ltrim($db["path"], "/")
));



?>