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
                                <div class="alert alert-success" role="alert">Bravo, Ton compte a bien été créé !
                                <a href="home.php">Me connecter</a>
                                </div>
                            <?php
                            } else {
                                $errorMessage = sprintf("Tes mots de passes ne correspondent pas !");
                            }
                        } else {
                            $errorMessage = sprintf("Adresse mail déjà utilisée !");
                        }
                    } else {
                        $errorMessage = sprintf("Ton adresse mail n'est pas valide !");
                    }
                } else {
                    $errorMessage = sprintf("Ton adresses mail ne correspondent pas !");
                }
            } else {
                $errorMessage = sprintf("Ton pseudo ne doit pas dépasser 255 caractères !");
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

<body class="form-v9">
    <div class="container-login100" style="background-image: url('images/bg-01.jpg');">
        <div class="page-content" >
            <div class="form-v9-content" style="background: white";>
                <form class="form-detail" action="" method="post" autocomplete="off">
                    <h2>Creér un compte</h2>
                    <div class="form-row-total">
                        <div class="form-row">
                            <input type="aliasNew" name="aliasNew" id="aliasNew" class="input-text" placeholder="Ton Pseudo" required minlength="2" required>
                        </div>
                    </div>

                    <div class="form-row-total">
                        <div class="form-row">
                            <input type="text" name="emailNew" id="emailNew" class="input-text" placeholder="Ton email">
                        </div>
                        <div class="form-row">
                            <input type="text" name="emailNew2" id="emailNew2" class="input-text" placeholder="Confirme l'email">
                        </div>
                    </div>

                    <div class="form-row-total">
                        <div class="form-row">
                            <input type="password" name="passwordNew" id="passwordNew" class="input-text" placeholder="Ton mot de passe" required minlength="5" required>
                        </div>
                        <div class="form-row">
                            <input type="password" name="passwordNew2" id="passwordNew2" class="input-text" placeholder="Confirme le mot de passe"  required minlength="5" required>
                        </div>
                    </div>
                    <div class="form-row-last">
                        <input type="submit" name="forminscription" class="register" value="Je m'incris">
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>


