<?php  session_start();
//Etape 1: Le mur concerne un utilisateur en particulier
$userId=$_SESSION['USER_ID'];

include ('doctype.php');?>

    <body>
        <?php
            include ('header.php');
        ?>
        <div id="wrapper">          
            <aside>
                <img src = "Ecologirl3.jpg" alt = "Portrait de l'utilisatrice"/>
                <section>
                    <h3>Présentation</h3>
                    <p>Sur cette page vous trouverez la liste des personnes qui
                        suivent les messages de l'utilisatrice
                        n° <?php echo intval($userId)?></p>
                </section>
            </aside>
            <main class='contacts'>
                <?php
                // Etape 2: se connecter à la base de donnée
                include ('connection.php');
                // Etape 3: récupérer le nom de l'utilisateur
                $laQuestionEnSql = "
                    SELECT users.*
                    FROM followers
                    LEFT JOIN users ON users.id=followers.following_user_id
                    WHERE followers.followed_user_id='$userId'
                    GROUP BY users.id
                    ";
                $lesInformations = $mysqli->query($laQuestionEnSql);
                // Etape 4: à vous de jouer
                //@todo: faire la boucle while de parcours des abonnés et mettre les bonnes valeurs ci dessous 
                while ($post = $lesInformations->fetch_assoc())
                {
                    ?>
                    <article>
                        <img src="Ecologirl3.jpg" alt="blason"/>
                        <h3><?php echo $post['alias'] ?></h3>
                        <p> <?php echo $post['id']
                        ?></p>
                    </article>
                <?php
                    }
                ?>
            </main>
        </div>
    </body>
</html>
