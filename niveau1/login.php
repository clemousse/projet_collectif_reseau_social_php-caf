<?php
include('connection.php');
$reqUsers = "SELECT * FROM `users`";
$users = $mysqli->query($reqUsers);
if (!$users) {
	echo ("Échec de la requete : " . $mysqli->error);
	exit();
}
$users = $users->fetch_all(MYSQLI_ASSOC);
// validate the form
if (isset($_POST['email']) &&  isset($_POST['password'])) {
	foreach ($users as $user) {
		if (
			$user['email'] === $_POST['email'] &&
			password_verify($_POST['password'], $user['password'])
		) {
			$_SESSION['LOGGED_USER'] = $user['email'];
			$_SESSION['USER_ID'] = $user['id'];
			$_SESSION['USER_ALIAS'] = $user['alias'];
		} else {
			$errorMessage = sprintf('Les informations envoyées ne permettent pas de vous identifier');
		}
	}
}
// if the user isn't logged in, we propose the form to do it
if (!isset($_SESSION['LOGGED_USER'])) : ?>
	<html>

	<body>
		<form action="home.php" method="post">
			<?php if (isset($errorMessage)) : ?>
				<div class="alert alert-danger" role="alert">
					<?php echo ($errorMessage); ?>
				</div>
			<?php endif; ?>
			<div class="mb-3">
				<label for="email" class="form-label">Email</label>
				<input type="email" class="form-control" id="email" name="email" aria-describedby="email-help" placeholder="you@exemple.com">
			</div>
			<div class="mb-3">
				<label for="password" class="form-label">Mot de passe</label>
				<input type="password" class="form-control" id="password" name="password">
			</div>
			<button type="submit" class="btn btn-light">Je me connecte</button>
		</form>
		<div>
			<br />
			<p>Pas encore inscrite ?</p>
			<a href="signup.php">S'inscrire</a>
		</div>
	<?php endif; ?>
	</body>

	</html>