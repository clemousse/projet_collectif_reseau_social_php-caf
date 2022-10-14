<?php session_start();
$userId = $_SESSION['USER_ID'];
include('doctype.php');
include('connection.php');
?>

<body>
    <?php include('header.php'); ?>
    <div id="wrapper">
        <aside>
            <?php include('aside.php'); ?>
        </aside>
        <main class='contacts'>
            <?php
            $reqSubscrs = "
            SELECT users.* 
            FROM followers 
            LEFT JOIN users ON users.id=followers.followed_user_id 
            WHERE followers.following_user_id='$userId'
            GROUP BY users.id
            ";
            $subscrs = $mysqli->query($reqSubscrs);
            while ($subscr = $subscrs->fetch_assoc()) {
            ?>
                <article>
                    <img src="images/profil.png" alt="photo du profil" />
                    <h3><?php echo $subscr['alias']; ?></h3>
                    <p><?php echo $subscr['id']; ?></p>
                </article>
            <?php
            }
            ?>
        </main>
    </div>
</body>

</html>