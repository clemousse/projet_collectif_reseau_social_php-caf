<?php  session_start();
//Etape 1: Le mur concerne un utilisateur en particulier
$userId=$_SESSION['USER_ID'];
include ('doctype.php');
include ('connection.php');
include ('header.php');

if (isset($_POST['submitPost'])){
    if (!empty($_POST['postNew']) &&  (empty($_POST['tagNew']) && !empty($_POST['selectTagPost']))){
        $datetime = date('y-m-d h:i:s');
        $postNew = $_POST['postNew'];
        $selectTagPost = $_POST['selectTagPost'];
        //insert the new post
        $postInsert = $mysqli->prepare("INSERT INTO posts (user_id, content, created) VALUES (?, ?, ?)");
        $postInsert->bind_param('iss', $userId, $postNew, $datetime);
        $postInsert->execute() or die(print_r($mysqli->errorInfo()));
        $postInsert->close();
        //insert corresponding entry for posts_tags
        $lastPostId = $mysqli->query("SELECT id FROM posts ORDER BY id DESC LIMIT 1;");
        $lastPostIdVar = $lastPostId->fetch_assoc();
        $lastPostId->close();
        $lastTagId = $mysqli->query("SELECT id FROM tags WHERE label='$selectTagPost';");
        $lastTagIdVar = $lastTagId->fetch_assoc();
        $lastTagId->close();
        $postsTagsInsert = $mysqli->prepare("INSERT INTO posts_tags (post_id, tag_id) VALUES (?, ?)");
        $postsTagsInsert->bind_param('ii', $lastPostIdVar['id'], $lastTagIdVar['id']);
        $postsTagsInsert->execute() or die(print_r($mysqli->errorInfo()));
        $postsTagsInsert->close();
        //erase the variables
        unset($_POST['submitPost'],$_POST['postNew'],$_POST['selectTagPost'],$_POST['tagNew']);
        ?>
        <div class="alert alert-success" role="alert">Bravo, votre post a bien été ajouté !</div>
    <?php
    } else if (!empty($_POST['postNew']) &&  (!empty($_POST['tagNew']) && empty($_POST['selectTagPost']))){
        $datetime = date('y-m-d h:i:s');
        $postNew = $_POST['postNew'];
        $tagNew = $_POST['tagNew'];
        $postInsert = $mysqli->prepare("INSERT INTO posts (user_id, content, created) VALUES (?, ?, ?)");
        $postInsert->bind_param('iss', $userId, $postNew, $datetime);
        $postInsert->execute() or die(print_r($mysqli->errorInfo()));
        $postInsert->close();
        $tagInsert = $mysqli->prepare("INSERT INTO tags (label) VALUES (?)");
        $tagInsert->bind_param('s', $tagNew);
        $tagInsert->execute() or die(print_r($mysqli->errorInfo()));
        $tagInsert->close();
        //insert corresponding entry for posts_tags
        $lastPostId = $mysqli->query("SELECT id FROM posts ORDER BY id DESC LIMIT 1;");
        $lastPostIdVar = $lastPostId->fetch_assoc();
        $lastPostId->close();
        $lastTagId = $mysqli->query("SELECT id FROM tags WHERE label='$tagNew';");
        $lastTagIdVar = $lastTagId->fetch_assoc();
        $lastTagId->close();
        $postsTagsInsert = $mysqli->prepare("INSERT INTO posts_tags (post_id, tag_id) VALUES (?, ?)");
        $postsTagsInsert->bind_param('ii', $lastPostIdVar['id'], $lastTagIdVar['id']);
        $postsTagsInsert->execute() or die(print_r($mysqli->errorInfo()));
        $postsTagsInsert->close();
        unset($_POST['submitPost'],$_POST['tagNew'],$_POST['postNew'],$_POST['selectTagPost']);
        ?>
        <div class="alert alert-success" role="alert">Bravo, votre post a bien été ajouté !</div>
    <?php
    }
}  
?>
<div id="wrapper">
    <aside>
        <?php
            //selectionner les users
            $laQuestionEnSql = "SELECT * FROM users WHERE id= '$userId' ";
            $lesInformations = $mysqli->query($laQuestionEnSql);
            $user = $lesInformations->fetch_assoc();
            //selectionner les tags
            $tagsSQL = "SELECT * FROM `tags`";
            $tagsPost = $mysqli->query($tagsSQL);
            include ('photo.php');
        ?>
    </aside>
    <main>
        <article>
            <h3>Créer un post</h3>
            <br/>
            <div>
                <form action="" method="post">
                    <div>
                        <label for="postNew"></label>
                        <textarea id="postNew" name="postNew"></textarea>
                    </div>
                    <br/>
                    <div class="input-group mb-3">
                        <select class="custom-select" id="selectTagPost" name="selectTagPost">
                            <option disabled selected value>Choisissez un mot-clé</option>
                                <?php 
                                // Etape 4: créer les options de choix de tags
                                    foreach ($tagsPost as $tag) {
                                        ?>
                                        <option value='<?php echo $tag['label']; ?>'><?php echo $tag['label'];?></option>
                                    <?php
                                    }
                                    ?>
                        </select>
                    </div>
                    <div>
                        <h3>Ou créez-en un : exemple => zéro_déchet</h3>
                        <br/>
                        <label for="tagNew"></label>
                        <input type="text" id="tagNew" name="tagNew"/>
                    </div>
                    <br/>
                    <div>
                        <input type="submit" name="submitPost" value="Créer le post" class="btn btn-outline-secondary"/>
                    </div>
                </form>
            </div>
        </article>
            <?php
                // récupérer les messages de l'utilisatrice
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
                if (!$lesInformations)
                {
                    echo("Échec de la requete : " . $mysqli->error);
                }
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
                <?php 
                } ?>
    </main>
</div>
