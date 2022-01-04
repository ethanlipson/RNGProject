<?php
include 'common.php';
$error='';
if (!$user->loggedIn) {
	$error="You must be logged in to access to admin page.";
} else if (!$user->isAdmin) {
	$error="You do not have admin privileges.";
}
?>
<html>

<body>
<button onclick="window.location='/'">
	Go Home
</button>
<br />
<br />

<?php

if ($user->isAdmin)
	echo "Congrats! You've escalated your privileges!<br />
	If this were a real casino, This would be pretty concerning...<br/>
	We hope you learned something about random number generators, and how knowing how to predict them can be dangerous.";
?>

</body>

<script>
<?php
	if ($error) {
		echo "alert(\"$error\"); window.location=\"/\";";
	}
?>
</script>

</html>