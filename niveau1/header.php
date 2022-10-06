<?php
    // Etape 2: se connecter à la base de données
    include ('connection.php');
    // Etape 3: récupérer le nom de l'utilisateur
    $laQuestionEnSql = "SELECT * FROM `tags`";
    $tags = $mysqli->query($laQuestionEnSql);
    //print_r ($tags);
?>
<header>
    <img src="Logo.jpg" alt="Logo de notre réseau social"/>
    <nav id="menu">
        <a href="news.php">Actualités</a>
        <a href="wall.php">Mur</a>
        <a href="feed.php">Flux</a>
        <a href="tags.php">Mots-clés</a>
        <a href="logout.php">Déconnexion</a>
    </nav>
    <nav id="search">
        <!--<form class="form-inline input-group">
            <input class="form-control" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-success" type="submit">Rechercher</button>
        </form>-->
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <button class="btn btn-outline-secondary" type="button">Rechercher</button>
            </div>
            <select class="custom-select" id="inputGroupSelect03">
                <option selected>Choisissez votre tag</option>
                <?php 
                // Etape 4: créer les options de choix de tags
                while ($tag = $tags->fetch_assoc())
                {
                    ?>
                    <option value='<?php $tag['label'] ?>'><?php $tag['label']?></option>
                    <?php
                }
                ?>
            </select>
        </div>
    </div>
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