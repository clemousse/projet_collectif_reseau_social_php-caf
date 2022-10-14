<?php session_start();
$userId = $_SESSION['USER_ID'];
include('doctype.php');
include('connection.php');

//delete the user account
if (isset($_POST['userId'])) {
    //because of the foreign key constraints between tables posts, posts_tags and users, we need to delete first of all the items in posts_tags, then in posts, then in users to delete entirely the account of the user.
    //1 - select posts id of the user
    $userIdInPosts = $mysqli->query("SELECT id FROM posts where user_id=$userId");
    //2 - delete the corresponding posts in posts_tags using a while loop (because there are maybe several posts)
    while ($id = $userIdInPosts->fetch_assoc()) {
        $deleteInPostsTags = $mysqli->prepare("DELETE FROM posts_tags WHERE post_id=?");
        $deleteInPostsTags->bind_param('i', $id['id']);
        $deleteInPostsTags->execute() or die(print_r($mysqli->error));
        $deleteInPostsTags->close();
    }
    //3 - delete the corresponding posts in posts
    $deleteInPosts = $mysqli->prepare("DELETE FROM posts WHERE user_id=?");
    $deleteInPosts->bind_param('i', $_POST['userId']);
    $deleteInPosts->execute() or die(print_r($mysqli->error));
    $deleteInPosts->close();
    //4 - delete the user (eventually ! )
    $deleteInUsers = $mysqli->prepare("DELETE FROM users WHERE id=?");
    $deleteInUsers->bind_param('i', $_POST['userId']);
    $deleteInUsers->execute() or die(print_r($mysqli->error));
    $deleteInUsers->close();
    //il faudra aussi d'autres requêtes pour supprimer les posts liés au user
    session_destroy();
    header("Location: home.php");
}
?>

<body>
    <?php include('header.php'); ?>
    <div id="wrapper" class='profile'>
        <aside>
            <?php include('aside.php'); ?>
        </aside>
        <main>
            <?php
            $reqUserInfos = "
                    SELECT users.*, 
                    count(DISTINCT posts.id) as totalpost, 
                    count(DISTINCT given.post_id) as totalgiven, 
                    count(DISTINCT recieved.user_id) as totalrecieved 
                    FROM users 
                    LEFT JOIN posts ON posts.user_id=users.id 
                    LEFT JOIN likes as given ON given.user_id=users.id 
                    LEFT JOIN likes as recieved ON recieved.post_id=posts.id 
                    WHERE users.id = '$userId' 
                    GROUP BY users.id
                    ";
            $userInfos = $mysqli->query($reqUserInfos);
            if (!$userInfos) {
                echo ("Échec de la requete : " . $mysqli->error);
            }
            $userInfo = $userInfos->fetch_assoc();
            ?>
            <article id="parameters" class='parameters'>
                <dl>
                    <dt>Pseudo</dt>
                    <dd><a href=<?php $userId = $userInfo['id'];
                                echo "'wall.php?user_id=$userId'"
                                ?>><?php echo ($userInfo['alias']); ?></a></dd>
                    <dt>Email</dt>
                    <dd><?php echo ($userInfo['email']); ?></dd>
                    <dt>Nombre de messages</dt>
                    <dd><?php echo ($userInfo['totalpost']); ?></dd>
                    <dt>Nombre de 💪 donnés </dt>
                    <dd><?php echo ($userInfo['totalgiven']); ?></dd>
                    <dt>Nombre de 💪 reçus</dt>
                    <dd><?php echo ($userInfo['totalrecieved']); ?></dd>
                    <dt>Modifier votre profil</dt>
                    <dd>oui / non</dd>
                    <dt>Ajouter une photo</dt>
                    <dd>Mettre à jour votre photo de profil</dd>
                    <dt>Supprimer mon compte</dt>
                    <dd><a href="#delete" data-bs-toggle="modal" data-bs-target="#delete">Supprimer toutes mes informations</a></dd>
                </dl>
                <!-- Modal to delete the user account-->
                <form action="" method="post">
                    <div class="modal fade" id="delete" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="modalLabel">Oui ! je veux supprimer mon compte !</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="visually-hidden">
                                    <label for='userId' class="form-label">User id</label>
                                    <input type="hidden" class="form-control" id="userId" name="userId" value="<?php echo ($userId); ?>">
                                </div>
                                <div class="modal-body">
                                    <button type="submit" class="btn btn-success" data-bs-dismiss="modal">GO !</button>
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Annuler</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </article>
        </main>
    </div>
</body>

</html>