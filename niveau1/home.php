<?php  session_start();?>

<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>ReSoC - Mes abonné.e.s </title> 
        <meta name="author" content="Julien Falconnet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="style.css"/>
    </head>
    <body>
    <!-- Inclusion du formulaire de connexion -->
    <?php include ('login.php'); ?>
        <!-- Si l'utilisateur existe, on affiche ... -->
        <?php 
        if(isset($_SESSION['LOGGED_USER']))
        {
            include ('header.php');
        }
        ?>
    </body>
</html>