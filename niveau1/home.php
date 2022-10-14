<?php session_start();
include('doctype.php');
?>

<body>
    <?php include('login.php'); ?>
    <?php
    if (isset($_SESSION['LOGGED_USER'])) {
        $userId = $_SESSION['USER_ID'];
        header("Location: news.php");
    }
    ?>
</body>

</html>