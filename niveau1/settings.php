<?php  session_start();
$userId=$_SESSION['USER_ID'];
include ('doctype.php');
?>
    <body>
        <?php
            include 'header.php';
        ?>
        <div id="wrapper" class='profile'> 
            <aside>
                <?php include ('photo.php');?>
            </aside>
        <main>
                <?php
                /**
                 * Etape 1: Les paramètres concernent une utilisatrice en particulier
                 * La première étape est donc de trouver quel est l'id de l'utilisatrice
                 * Celui ci est indiqué en parametre GET de la page sous la forme user_id=...
                 * Documentation : https://www.php.net/manual/fr/reserved.variables.get.php
                 * ... mais en résumé c'est une manière de passer des informations à la page en ajoutant des choses dans l'url
                 */
                /**
                 * Etape 2: se connecter à la base de données
                 */
                include 'connection.php';
                /**
                 * Etape 3: récupérer le nom de l'utilisateur
                 */
                $laQuestionEnSql = "
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
                $lesInformations = $mysqli->query($laQuestionEnSql);
                if (! $lesInformations)
                {
                    echo("Échec de la requete : " . $mysqli->error);
                }
                $user = $lesInformations->fetch_assoc();
                /**
                 * Etape 4: à vous de jouer
                 */
                //@todo: afficher le résultat de la ligne ci dessous, remplacer les valeurs ci-après puiseffacer la ligne ci-dessous
                //echo "<pre>" . print_r($user, 1) . "</pre>";
                ?>                
                <article class='parameters'>
                    <dl>
                        <dt>Pseudo</dt>
                        <dd><a href=<?php $userId = $user['id']; echo "'wall.php?user_id=$userId'" ?>><?php echo($user['alias']) ?></a></dd>
                        <dt>Email</dt>
                        <dd><?php echo($user['email']) ?></dd>
                        <dt>Nombre de messages</dt><br />
                        <dd><?php echo($user['totalpost']) ?></dd>
                        <dt>Nombre de 💪  donnés </dt>
                        <dd><?php echo($user['totalgiven']) ?></dd>
                        <dt>Nombre de 💪 reçus</dt><br />
                        <dd><?php echo($user['totalrecieved']) ?></dd>
                        <dt>Modifier votre profil</dt><br />
                        <dd> oui non</dd>
                        <dt>Ajouter une photo</dt>
                        <dd>Mettre à jour votre photo de profil</dd>

                    </dl>
                </article>
            </main>
        </div>
    </body>
</html>
