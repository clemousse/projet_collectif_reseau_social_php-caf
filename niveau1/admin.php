<?php session_start();
$userId = $_SESSION['USER_ID'];
$userAlias = $_SESSION['USER_ALIAS'];
include('doctype.php');
include('connection.php');
?>

<body>
    <?php include('header.php'); ?>
    <div id="wrapper" class='admin'>
        <aside>
            <h2>Mots-clés</h2>
            <?php
            $reqTags = "SELECT * FROM `tags` LIMIT 50";
            $tags = $mysqli->query($reqTags);
            // Vérification
            if (!$tags) {
                echo ("Échec de la requete : " . $mysqli->error);
                exit();
            }
            while ($tag = $tags->fetch_assoc()) {
            ?>
                <article>
                    <h3>#<?php echo ($tag['label']) ?></h3>
                    <p>id: <?php echo ($tag['id']) ?></p>
                    <nav>
                        <?php echo ('<a href="tags.php?tag_id=' . $tag['id'] . '">Messages</a>'); ?>
                    </nav>
                </article>
            <?php
            }
            ?>
        </aside>
        <main>
            <h2>Utilisatrices</h2>
            <?php
            $reqUsers = "SELECT * FROM `users` LIMIT 50";
            $users = $mysqli->query($reqUsers);
            if (!$users) {
                echo ("Échec de la requete : " . $mysqli->error);
                exit();
            }
            while ($user = $users->fetch_assoc()) {
            ?>
                <article>
                    <h3><?php echo ($users['alias']) ?></h3>
                    <p>id : <?php echo ($$users['id']) ?></p>
                </article>
            <?php
            }
            ?>
        </main>
    </div>
</body>

</html>