<?php  session_start();
//Etape 1: Le mur concerne un utilisateur en particulier
$userId=$_SESSION['USER_ID'];
?>
<aside>
    <img src="Ecologirl3.jpg" alt="Portrait de l'utilisatrice"/>
        <section>
            <h3>Présentation</h3>
            <p>Sur cette page vous trouverez les informations de l'utilisatrice
            n° <?php echo intval($userId) ;?>
            </p>
        </section>
</aside>