<?php
include('connection.php');
$reqTags = "SELECT * FROM `tags`";
$tags = $mysqli->query($reqTags);
?>

<header>
    <nav id="menu">
        <img id="logo" src="images/logotala.png" alt="logo " />
        <a href="news.php">Actualités🪴</a>
        <a href="wall.php">Mur🌿</a>
        <a href="feed.php">Flux🌱</a>
        <a href="tags.php">Mots-clés🍀</a>
        <a href="logout.php">Déconnexion</a>
    </nav>
    <nav id="search">
        <form action="tags.php" method="post">
            <div class="input-group mb-3">
                <select class="custom-select" id="inputGroupSelect" name="tag">
                    <option disabled selected value>Mot-clé</option>
                    <?php
                    foreach ($tags as $tag) { ?>
                        <option value='<?php echo $tag['label']; ?>'><?php echo $tag['label']; ?></option>
                    <?php
                    }
                    ?>
                </select>
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit">GO !</button>
                </div>
            </div>
        </form>
    </nav>
    <nav id="user">
        <a href="#">Profil</a>
        <ul>
            <li><a href="settings.php">Paramètres</a></li>
            <li><a href="followers.php">Mes suiveuses</a></li>
            <li><a href="subscriptions.php">Mes abonnements</a></li>
        </ul>
    </nav>
</header>

<!-- to implement with bootstrap
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="news.php" title="logo">
            <img src="logotala.png" alt="logo du site" />
        </a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul id="menu" class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="news.php">Actualités🪴</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="wall.php">Mur🌿</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="feed.php">Flux🌱</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="tags.php">Mots-clés🍀</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="wall.php">Mur🌿</a>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0" id="search">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
    </nav>
</header> -->