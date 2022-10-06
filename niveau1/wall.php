<?php  session_start();
//Etape 1: Le mur concerne un utilisateur en particulier
$userId=$_SESSION['USER_ID'];
include ('doctype.php');
?>
    <body>
        <?php include ('header.php');?>
        <div id="wrapper">
            <aside>
                <?php
                /**
                 * Etape 2: se connecter à la base de donnée
                 */
                include ('connection.php');
                    /**
                     * Etape 3: récupérer le nom de l'utilisateur
                     */                
                    $laQuestionEnSql = "SELECT * FROM users WHERE id= '$userId' ";
                    $lesInformations = $mysqli->query($laQuestionEnSql);
                    $user = $lesInformations->fetch_assoc();
                    ?>
                    <?php include ('photo.php');?>
                </aside>
            <main>
                <?php
                /**
                 * Etape 3: récupérer tous les messages de l'utilisatrice
                 */
                $laQuestionEnSql = "
                    SELECT posts.content, posts.created, users.alias as author_name, 
                    COUNT(likes.id) as like_number, GROUP_CONCAT(DISTINCT tags.label) AS taglist 
                    FROM posts
                    JOIN users ON  users.id=posts.user_id
                    LEFT JOIN posts_tags ON posts.id = posts_tags.post_id  
                    LEFT JOIN tags       ON posts_tags.tag_id  = tags.id 
                    LEFT JOIN likes      ON likes.post_id  = posts.id 
                    WHERE posts.user_id='$userId' 
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
                 */
                while ($post = $lesInformations->fetch_assoc())
                {
                    ?>                
                    <article>
                        <h3>
                            <time datetime='<?php echo $post['author_name']; ?>' ><?php echo $post['created']; ?></time>
                        </h3>
                        <address><?php echo $post['author_name']; ?></address>
                        <div>
                            <p><?php echo $post['content']; ?></p>
                        </div> 
                        <?php include ('footer.php'); ?>
                    </article>
                <?php } ?>
            </main>
        </div>
    </body>
</html>
