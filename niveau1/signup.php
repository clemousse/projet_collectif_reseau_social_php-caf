<?php
    include ('doctype.php');
	include ('connection.php');

	if(isset($_POST['forminscription'])) {

	    $pseudo = htmlspecialchars($_POST['aliasNew']);
	    $mail = htmlspecialchars($_POST['emailNew']);
	    $mail2 = htmlspecialchars($_POST['emailNew2']);
    	$mdp = $_POST['passwordNew'];
	    $mdp2 = $_POST['passwordNew2'];

	    if(!empty($_POST['aliasNew']) && !empty($_POST['emailNew']) && !empty($_POST['emailNew2']) && !empty($_POST['passwordNew']) && !empty($_POST['passwordNew2'])) {

            $pseudolength = strlen($pseudo);
            if($pseudolength <= 255) {
                if($mail === $mail2) {
                    if(filter_var($mail, FILTER_VALIDATE_EMAIL)) {
                        $reqmail = $mysqli->prepare("SELECT * FROM users WHERE email=?");
                        $reqmail->bind_param('s', $mail);
                        $reqmail->execute() or die(print_r($mysqli->errorInfo()));
                        $mailexist = $reqmail->num_rows;
                        if($mailexist === 0) {
                            if($mdp === $mdp2) {
                                $reqmail->close();
                                $insertmbr=$mysqli->prepare("INSERT INTO users (alias, email, password) VALUES (?, ?, ?)");
                                $insertmbr->bind_param('sss', $pseudo, $mail, password_hash($mdp,PASSWORD_DEFAULT));
                                $insertmbr->execute() or die(print_r($mysqli->errorInfo()));
                                ?>
                                <div class="alert alert-success" role="alert">Bravo, votre compte a bien été créé !
                                <a href="home.php">Me connecter</a>
                                </div>
                            <?php
                            } else {
                                $errorMessage = sprintf("Vos mots de passes ne correspondent pas !");
                            }
                        } else {
                            $errorMessage = sprintf("Adresse mail déjà utilisée !");
                        }
                    } else {
                        $errorMessage = sprintf("Votre adresse mail n'est pas valide !");
                    }
                } else {
                    $errorMessage = sprintf("Vos adresses mail ne correspondent pas !");
                }
            } else {
                $errorMessage = sprintf("Votre pseudo ne doit pas dépasser 255 caractères !");
            }
        } else {
            $errorMessage = sprintf("Tous les champs doivent être complétés !");
        }
    }
?>

<!-- si message d'erreur on l'affiche -->
<?php if(isset($errorMessage)) : ?>
    <div class="alert alert-danger" role="alert">
        <?php echo $errorMessage; ?>
    </div>
<?php endif; ?>

<form action="" method="post">
    <div class="mb-3">
        <label for="aliasNew" class="form-label">Pseudo</label>
        <input type="aliasNew" class="form-control" id="aliasNew" name="aliasNew">
    </div>
    <div class="mb-3">
        <label for="emailNew" class="form-label">Email</label>
        <input type="emailNew" class="form-control" id="emailNew" name="emailNew" aria-describedby="email-help" placeholder="you@exemple.com">
    </div>
    <div class="mb-3">
        <label for="emailNew2" class="form-label">Confirmation de l'email</label>
        <input type="emailNew2" class="form-control" id="emailNew2" name="emailNew2" aria-describedby="email-help" placeholder="you@exemple.com">
    </div>
    <div class="mb-3">
        <label for="passwordNew" class="form-label">Mot de passe</label>
        <input type="password" class="form-control" id="passwordNew" name="passwordNew">
    </div>
    <div class="mb-3">
        <label for="passwordNew2" class="form-label">Confirmation du mot de passe</label>
        <input type="password" class="form-control" id="passwordNew2" name="passwordNew2">
    </div>
    <input type="submit" name="forminscription" value="Je m'inscris" class="btn btn-success"/>
</form>
