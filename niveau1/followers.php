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
            // get the alias of the followers
            $reqFollowers = "
                    SELECT users.*
                    FROM followers
                    LEFT JOIN users ON users.id=followers.following_user_id
                    WHERE followers.followed_user_id='$userId'
                    GROUP BY users.id
                    ";
            $followers = $mysqli->query($reqFollowers);
            while ($follower = $followers->fetch_assoc()) {
            ?>
                <article>
                    <h3><?php echo $follower['alias']; ?></h3>
                    <p><?php echo $follower['id']; ?></p>
                </article>
            <?php
            }
            ?>
        </main>
    </div>
</body>

</html>