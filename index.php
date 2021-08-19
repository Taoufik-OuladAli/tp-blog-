<?php


session_start();
unset($_SESSION['message']);

//Connexion à bdd et créeation de l'objet  PDO $bdd
try {
    $options = [
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_ERRMODE =>  PDO::ERRMODE_EXCEPTION
    ];
    $bdd = new PDO('mysql:host=localhost;dbname=mon_blog', 'root', '', $options);
} catch (Exception $e) {

    die('Erreur : ' . $e->getMessage());
}


$sql = 'SELECT billets.id, billets.titre, billets.contenu,
DATE_FORMAT(billets.date_creation, \'Le %e/%m/%Y\') AS date, COUNT(commentaires.commentaire)
AS commentaire
FROM commentaires
RIGHT JOIN billets 
ON billets.id = commentaires.id_billet 
GROUP BY billets.titre ';
$q = $bdd->query($sql);

$articles = $q->fetchAll(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Mon super blog</title>
</head>
<body>
<?php if(isset($_SESSION['message'])) echo $_SESSION['message'] ?>
    <header>
        <h1>Mon super blog</h1>
        <a href="connexion.php?deconnecter">Se déconnecter</a>
    </header>
    <main>
        <?php foreach($articles as $article): ?>
        <section class="article">
            <h2><?= htmlspecialchars($article['titre']) ?></h2>
            <p><?= $article['date'] ?></p>
            <p class="resume"><?= htmlspecialchars(substr($article['contenu'], 0, 50)) . '...' ?></p>
            <p class="readmore"><a href="article.php?id=<?= $article['id'] ?>">Lire la suite</a></p>
            <p class="commentaire">Il y a: <?= $article['commentaire']?> commentaires</p>
            <ul>    
                <li><a href="modifier_article.php?id=<?= $article['id'] ?>">Modifier cet article</a></li>
                <li><a href="supprimer_article.php?id=<?= $article['id'] ?>">Supprimer cet article</a></li>
            </ul>
        </section>
        <?php endforeach; ?>
    </main>
</body>
</html>
