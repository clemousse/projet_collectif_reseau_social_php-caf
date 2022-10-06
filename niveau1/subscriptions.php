<?php  session_start();
// Etape 1: récupérer l'id de l'utilisateur
$userId=$_SESSION['USER_ID'];
include ('doctype.php');
?>
    <body>
        <?php
            include ('header.php');
        ?>
        <div id="wrapper">
            <aside>
                <?php include ('photo.php');?>
            </aside>
            <main class='contacts'>
                <?php
                // Etape 2: se connecter à la base de données
                include 'connection.php';
                // Etape 3: récupérer le nom de l'utilisateur
                $laQuestionEnSql = "
                    SELECT users.* 
                    FROM followers 
                    LEFT JOIN users ON users.id=followers.followed_user_id 
                    WHERE followers.following_user_id='$userId'
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