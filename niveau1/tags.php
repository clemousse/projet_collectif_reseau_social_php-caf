<!--CREATE TABLE current_tag (name VARCHAR(255));
INSERT INTO current_tag (id, name) VALUES (1,'default');-->
<?php
include ('doctype.php');
include ('connection.php');
include ('header.php');
?>
<div id="wrapper">
    <aside>
        <?php
            /**
            * Etape 3: récupérer le nom du mot-clé
            */
            if(isset($_POST['tag'])) {
                $choosenTag = $_POST['tag'];
                //On update la valeur du tag courant par celui selectionné par l'utilisatrice => dans la table current_tag.
                $updateCurrentTag = "UPDATE current_tag SET label = '$choosenTag' WHERE id=1";
                //On sélectionne tous les tags dont l'id correspond au tag courant => dans la table tags
                $mysqli->query($updateCurrentTag);
                $laQuestionEnSql1 = "SELECT id FROM tags WHERE label='$choosenTag'";
                $lesInformations = $mysqli->query($laQuestionEnSql1);
                $tag = $lesInformations->fetch_assoc();
                $tagId=$tag['id'];
            } else if (!isset($_POST['tag'])) {
                $laQuestionEnSql1 = "
                SELECT tags.id FROM tags INNER JOIN current_tag ON tags.label = current_tag.label;
                ";
                $lesInformations = $mysqli->query($laQuestionEnSql1);
                $tag = $lesInformations->fetch_assoc();
                $tagId=$tag['id'];
            }
            include('photo.php');
            ?>
    </aside>
    <main>
        <?php
            /**
            * Etape 3: récupérer tous les messages avec un mot clé donné
            */
            $laQuestionEnSql2 = "
            SELECT posts.content,
            posts.created,
            users.alias as author_name,  
            count(likes.id) as like_number,  
            GROUP_CONCAT(DISTINCT tags.label) AS taglist 
            FROM posts_tags as filter 
            JOIN posts ON posts.id=filter.post_id
            JOIN users ON users.id=posts.user_id
            LEFT JOIN posts_tags ON posts.id = posts_tags.post_id  
            LEFT JOIN tags       ON posts_tags.tag_id  = tags.id 
            LEFT JOIN likes      ON likes.post_id  = posts.id 
            WHERE filter.tag_id = $tagId
            GROUP BY posts.id
            ORDER BY posts.created DESC  
            ";
            $lesInformations = $mysqli->query($laQuestionEnSql2);
            if (!$lesInformations)
            {
                echo("Échec de la requete : " . $mysqli->error);
            }
            while ($post = $lesInformations->fetch_assoc())
            {
                ?>                
                <article>
                    <h3>
                        <time datetime='2020-02-01 11:12:13' ><?php echo $post['created'] ?></time>
                    </h3>
                    <address><?php echo $post['author_name'] ?></address>
                    <div>
                        <p><?php echo $post['content'] ?></p>
                    </div>  
                    <?php include ('footer.php'); ?>
                </article>
            <?php 
            } 
            ?>
    </main>
</div>