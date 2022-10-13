<?php session_start();
$userId=$_SESSION['USER_ID'];
$userAlias=$_SESSION['USER_ALIAS'];
include ('doctype.php');
include ('header.php');
include ('connection.php');
?>
<div id="wrapper" class='admin'>
    <aside>
                <h2>Mots-clés</h2>
                <?php
                /*
                 * Etape 2 : trouver tous les mots clés
                 */
                $laQuestionEnSql = "SELECT * FROM `tags` LIMIT 50";
                $lesInformations = $mysqli->query($laQuestionEnSql);
                // Vérification
                if ( ! $lesInformations)
                {
                    echo("Échec de la requete : " . $mysqli->error);
                    exit();
                }
                /*page
                 * Etape 3 : @todo : Afficher les mots clés en s'inspirant de ce qui a été fait dans news.php
                 * Attention à en pas oublier de modifier tag_id=321 avec l'id du mot dans le lien
                 */
                while ($tag = $lesInformations->fetch_assoc())
                {
                    // echo "<pre>" . print_r($tag, 1) . "</pre>";
                    ?>
                    <article>
                        <h3>#<?php echo($tag['label']) ?></h3>
                        <p>id: <?php echo ($tag['id'])?></p>
                        <nav>
                            <?php echo('<a href="tags.php?tag_id=' . $tag['id'] . '">Messages</a>'); ?>
                        </nav>
                    </article>
                <?php } ?>
    </aside>
    <main>
                <h2>Utilisatrices</h2>
                <?php
                /*
                 * Etape 4 : trouver tous les mots clés
                 * PS: on note que la connexion $mysqli à la base a été faite, pas besoin de la refaire.
                 */
                $laQuestionEnSql = "SELECT * FROM `users` LIMIT 50";
                $lesInformations = $mysqli->query($laQuestionEnSql);
                // Vérification
                if ( ! $lesInformations)
                {
                    echo("Échec de la requete : " . $mysqli->error);
                    exit();
                }

                /*
                 * Etape 5 : @todo : Afficher les utilisatrices en s'inspirant de ce qui a été fait dans news.php
                 * Attention à en pas oublier de modifier dans le lien les "user_id=123" avec l'id de l'utilisatrice
                 */
                while ($user = $lesInformations->fetch_assoc())
                {
                    // echo "<pre>" . print_r($user, 1) . "</pre>";
                    ?>
                    <article>
                        <h3><?php echo($userAlias) ?></h3>
                        <p>id: <?php echo($userId) ?></p>
                    </article>
                <?php } ?>
    </main>
</div>