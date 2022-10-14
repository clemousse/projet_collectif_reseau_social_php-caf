<?php session_start();
$userId = $_SESSION['USER_ID'];
include('doctype.php');
include('connection.php');
?>

<body>
    <?php include('header.php'); ?>
    <div id="wrapper">
        <aside><?php include('aside.php'); ?>
        </aside>
        <main>
            <?php
            //get the posts from users's subscriptions
            $reqPostsSubs = "
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
            $posts = $mysqli->query($reqPostsSubs);
            if (!$posts) {
                echo ("Échec de la requete : " . $mysqli->error);
            }
            while ($post = $posts->fetch_assoc()) {
            ?>
                <article>
                    <h3>
                        <time datetime='<?php echo $post['created'] ?>'><?php echo $post['created']; ?></time>
                    </h3>
                    <address></address>
                    <div>
                        <p><?php echo $post['content']; ?></p>
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