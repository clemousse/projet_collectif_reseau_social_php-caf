<?php  session_start();
include ('doctype.php');
?>
    <body>
    <!-- Inclusion du formulaire de connexion -->
    <?php include ('login.php'); ?>
        <!-- Si l'utilisateur existe, on affiche ... -->
        <?php 
        if(isset($_SESSION['LOGGED_USER']))
        {
            $userId=$_SESSION['USER_ID'];
            header("Location: news.php");
        }
        ?>
    </body>
</html>