<?php
include('doctype.php');
include('connection.php');
?>

<body>
    <?php include('header.php'); ?>
    <div id="wrapper">
        <aside>
            <?php
            if (isset($_POST['tag'])) {
                $choosenTag = $_POST['tag'];
                //we update the value of the current tag by the one selected by the user => in the current_tag table.
                $updateCurrentTag = "UPDATE current_tag SET label = '$choosenTag' WHERE id=1";
                //we select all the tags whose id corresponds to the current tag => in the tags table
                $mysqli->query($updateCurrentTag);
                $laQuestionEnSql1 = "SELECT id FROM tags WHERE label='$choosenTag'";
                $lesInformations = $mysqli->query($laQuestionEnSql1);
                $tag = $lesInformations->fetch_assoc();
                $tagId = $tag['id'];
            } else if (!isset($_POST['tag'])) {
                $reqTags = "
                SELECT tags.id FROM tags INNER JOIN current_tag ON tags.label = current_tag.label;
                ";
                $tags = $mysqli->query($reqTags);
                $tag = $tags->fetch_assoc();
                $tagId = $tag['id'];
            }
            include('aside.php');
            ?>
        </aside>
        <main>
            <?php
            $reqPostsTags = "
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
            $postsTags = $mysqli->query($reqPostsTags);
            if (!$postsTags) {
                echo ("Échec de la requete : " . $mysqli->error);
            }
            while ($post = $postsTags->fetch_assoc()) {
            ?>
                <article>
                    <h3>
                        <time datetime='2020-02-01 11:12:13'><?php echo $post['created'] ?></time>
                    </h3>
                    <address><?php echo $post['author_name'] ?></address>
                    <div>
                        <p><?php echo $post['content'] ?></p>
                    </div>
                    <?php include('footer.php'); ?>
                </article>
            <?php
            }
            ?>
        </main>
    </div>
</body>

</html>