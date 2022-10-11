<?php
include ('connection.php');
$laQuestionEnSql = "SELECT * FROM `users`";
$lesInformations = $mysqli->query($laQuestionEnSql);
if (!$lesInformations)
    {
        echo("Échec de la requete : " . $mysqli->error);
        exit();
    }
$users = $lesInformations->fetch_all(MYSQLI_ASSOC);
// foreach ($users as $user) {
//     printf("%s (%s)\n", $user["alias"], $user["email"],$user["id"],$user["password"]);
// }

// Validation du formulaire
if (isset($_POST['email']) &&  isset($_POST['password'])) {
    foreach ($users as $user) {
        if (
            $user['email'] === $_POST['email'] &&
            password_verify($_POST['password'], $user['password'])
        ) {
            $_SESSION['LOGGED_USER']=$user['email'];
            $_SESSION['USER_ID']=$user['id'];
            $_SESSION['USER_ALIAS']=$user['alias'];
        } else {
            $errorMessage = sprintf('Les informations envoyées ne permettent pas de vous identifier : (%s/%s)',
                $_POST['email'],
                password_hash($user['password'], PASSWORD_DEFAULT)
            );
        }
    }
}
?>

<!-- Si utilisateur/trice est non identifié(e), on affiche le formulaire -->
<?php if(!isset($_SESSION['LOGGED_USER'])): ?>
<form action="home.php" method="post">
    <!-- si message d'erreur on l'affiche -->
    <?php if(isset($errorMessage)) : ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $errorMessage; ?>
        </div>
    <?php endif; ?>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" aria-describedby="email-help" placeholder="you@exemple.com">
        <div id="email-help" class="form-text">L'email utilisé lors de la création de compte.</div>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Mot de passe</label>
        <input type="password" class="form-control" id="password" name="password">
    </div>
    <button type="submit" class="btn btn-success">Je me connecte</button>
</form>
<div>
    <br/>
    <p>Pas encore inscrite ?</p>
    <a href="signup.php">S'inscrire</a>
</div>
<?php endif;?>