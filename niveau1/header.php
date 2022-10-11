<?php
    // Etape 2: se connecter à la base de données
    include ('connection.php');
    // Etape 3: récupérer le nom de l'utilisateur
    $laQuestionEnSql = "SELECT * FROM `tags`";
    $tags = $mysqli->query($laQuestionEnSql);
    // echo ('<pre>'.print_r ($tags).'</pre>');
    // foreach ($tags as $tag) {
    //     printf("%s (%s)\n", $tag["id"], $tag["label"]);
    // }
?>
<header>
    <img src="logotala.png" alt="Logo de notre réseau social"/>
    <nav id="menu">
        <a href="news.php">Actualités🪴</a>
        <a href="wall.php">Mur🌿</a>
        <a href="feed.php">Flux🌱</a>
        <a href="tags.php">Mots-clés🍀</a>
        <a href="logout.php">Déconnexion</a>
    </nav>
    <nav id="search">
        <!--<form class="form-inline input-group">
            <input class="form-control" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-success" type="submit">Rechercher</button>
        </form>-->
        <form action="tags.php" method="post">
            <div class="input-group mb-3">
                <select class="custom-select" id="inputGroupSelect" name="tag">
                    <option disabled selected value>Choisissez un mot-clé</option>
                    <?php 
                    // Etape 4: créer les options de choix de tags
                    foreach ($tags as $tag) {?>
                        <option value='<?php echo $tag['label']; ?>'><?php echo $tag['label'];?></option>
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
            <li><a href="followers.php">Mes suiveurs</a></li>
            <li><a href="subscriptions.php">Mes abonnements</a></li>
        </ul>
    </nav>
</header>