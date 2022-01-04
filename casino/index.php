<?php
include 'common.php';
?>

<html>

<body>
	<h1>
		<?php
		if ($user->loggedIn) {
			echo "Welcome " . $user->username . "!";
		} else {
			echo "Welcome to the casino loco!";
		}
		?>
	</h1>



	<?php
		if ($user->loggedIn) {
			echo "
				<button onclick=\"window.location='admin.php'\">
					Admin Page
				</button>
				<button onclick=\"window.location='logout.php'\">
					Logout
				</button>
			";
		}
		else {
			echo "
				<button onclick=\"window.location='admin.php'\">
					Admin Page
				</button>
				<button onclick=\"window.location='login.php'\">
					Login / Register
				</button>
			";
		}
	?>
</body>

</html>