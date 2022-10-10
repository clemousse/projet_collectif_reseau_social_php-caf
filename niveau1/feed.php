<?php  session_start();
//Etape 1: Le mur concerne un utilisateur en particulier
$userId=$_SESSION['USER_ID'];
include ('doctype.php');
?>
    <body>
        <?php include ('header.php');?>
        <div id="wrapper">
            <?php
            /**
             * Cette page est TRES similaire à wall.php. 
             * Vous avez sensiblement à y faire la meme chose.
             * Il y a un seul point qui change c'est la requete sql.
             * Etape 2: se connecter à la base de données
             */
            include ('connection.php');
            ?>
            <aside>
                <?php
                /**
                 * Etape 3: récupérer le nom de l'utilisateur
                 */
                $laQuestionEnSql = "SELECT * FROM `users` WHERE id= '$userId' ";
                $lesInformations = $mysqli->query($laQuestionEnSql);
                $user = $lesInformations->fetch_assoc();
                include ('photo.php');
                ?>
            </aside>
            <main>
                <?php
                /**
                 * Etape 3: récupérer tous les messages des abonnements
                 */
                $laQuestionEnSql = "
                    SELECT posts.content,
                    posts.created,
                    users.alias as author_name,  
                    count(likes.id) as like_number,  
                    GROUP_CONCAT(DISTINCT tags.label) AS taglist 
                    FROM followers 
                    JOIN users ON users.id=followers.followed_user_id
                    JOIN posts ON posts.user_id=users.id
                    LEFT JOIN posts_tags ON posts.id = posts_tags.post_id  
                    LEFT JOIN tags       ON posts_tags.tag_id  = tags.id 
                    LEFT JOIN likes      ON likes.post_id  = posts.id 
                    WHERE followers.following_user_id='$userId' 
                    GROUP BY posts.id
                    ORDER BY posts.created DESC  
                    ";
                $lesInformations = $mysqli->query($laQuestionEnSql);
                if ( ! $lesInformations)
                {
                    echo("Échec de la requete : " . $mysqli->error);
                }

                /**
                 * Etape 4: @todo Parcourir les messages et remplir correctement le HTML avec les bonnes valeurs php
                 * A vous de retrouver comment faire la boucle while de parcours...
                 */
                
                while ($post = $lesInformations->fetch_assoc())
                {
                ?>               
                <article>
                    <h3>
                        <time datetime='<?php echo $post['created'] ?>' ><?php echo $post['created']; ?></time>
                    </h3>
                    <address></address>
                    <div>
                        <p><?php echo $post['content']; ?></p>
                    </div>                                            
                    <?php include ('footer.php'); ?>
                </article>
                <?php
                }
                // et de pas oublier de fermer ici vote while
                ?>
            </main>
        </div>
    </body>
</html>
