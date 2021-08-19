<?php

if (isset($_GET['id']) && $_GET['id'] > 0) {
    /* Etape 1: on instancie la classe PDO dans un objet $bdd (copier/coller en modifiant la ligne $bdd) */

    try {
        $options = [
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
            PDO::ATTR_ERRMODE =>  PDO::ERRMODE_EXCEPTION
        ];
        $bdd = new PDO('mysql:host=localhost;dbname=mon_blog', 'root', '', $options);
    } catch (Exception $e) {

        die('Erreur : ' . $e->getMessage());
    }


    //récupérer l'article sous forme d'un tableau
    /* Etape 2 : on test la requete sur PHPMyAdmin et on remplace les variables par :var*/

    $sql = 'SELECT billets.titre, billets.contenu, billets.date_creation FROM billets WHERE billets.id=:id';


    /* Etape 3 : on envoie une requête préparée */
    $q = $bdd->prepare($sql);

    /* Etape 4 : on exécute la  requête : $lignes affichera le nomnre de lignes affectées ou false */
    $q->execute(array('id' => $_GET['id']));

   /* Etape 5 : on traite */ 
    $article =  $q->fetch(PDO::FETCH_ASSOC);
    $q->closeCursor();



    //récupérer les commentaires de l'article sous forme d'un tableau

    /* Etape 2 : on test la requete sur PHPMyAdmin et on remplace les variables par :var*/
    $sql = 'SELECT commentaires.auteur, commentaires.commentaire, commentaires.date_commentaire FROM commentaires WHERE commentaires.id_billet = :id';

   /* Etape 3 : on envoie une requête préparée */
    $q = $bdd->prepare($sql);

    /* Etape 4 : on exécute la  requête : $lignes affichera le nomnre de lignes affectées ou false */
    $lignes = $q->execute([
        'id' => $_GET['id'],
    ]);

        /* Etape 5 : on traite */
    //je fous le tout dans un tableau qui me servira pour la vue
    $commentaires = $q->fetchAll(PDO::FETCH_ASSOC);
} else {
    header('Location: index.php');
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title><?= $article['titre'] ?> - Mon super Blog</title>
</head>

<body>
    <header>
    <h1><?= $article['titre'] ?></h1>
    <a href="connexion.php?deconnecter">Se déconnecter</a>
    </header>
    <p class="date"><?= $article['date_creation'] ?></p>

    <div class="content">
       <p class="article"><?= $article['contenu'] ?></p> 

        <section>
            <h2>Les commentaires</h2>
            <div class="commentaire">

            <?php foreach ($commentaires as $commentaire) :  ?>
            <div >
                <p>Le <?= $commentaire['date_commentaire'] ?>, <?= $commentaire['auteur'] ?> a dit :</p>
                <blockquote><?= $commentaire['commentaire'] ?></blockquote>
                </div>
            <?php endforeach; ?>
            </div>
            
        </section>
    </div>

</body>

</html>