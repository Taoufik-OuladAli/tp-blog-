<?php

session_start();

if(isset($_POST['titre'], $_POST['contenu'])){
	
 //on ajoute en base de données
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


/* Etape 2 : on test la requete sur PHPMyAdmin et on remplace les variables par :var*/
$sql = 'INSERT INTO billets(titre, contenu, date_creation) VALUES ( :titre, :contenu, NOW() ) '; // requete de type INSERT INTO : on ajoute un titre et un texte
    
/* Etape 3 : on envoie une requête préparée */
$q = $bdd->prepare($sql);

/* Etape 4 : on exécute la  requête : $lignes affichera le nomnre de lignes affectées ou false */
$lignes = $q->execute(array(
    //on reseigne le tableau
    //ex 'variable' => $_POST['variable'],

    'titre' => htmlspecialchars($_POST['titre']),
    'contenu' => htmlspecialchars($_POST['contenu']),
));


/* Etape 5 : on traite */
if($lignes){
    $_SESSION['message'] = 'Yes man!';
    header('Location: index.php');
}

}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Aujouter un article - Console</title>
</head>
<body>
<?php if(isset($_SESSION['message'])) echo $_SESSION['message'] ?>
<header>
    <h1>Ajouter un article</h1>
    <a href="connexion.php?deconnecter">Se déconnecter</a>
</header>

<form method="post">
    <div class="field">
        <label for="titre" class="titre">Le titre</label> <br>
        <input type="text" name="titre" class="titre">
    </div>

    <div class="field">
    <p class="contenu">Les contenu de votre article (en HTML)</p>
    <textarea name="contenu" class="contenu" cols="30" rows="10"></textarea>
    </div>

    <div class="submit">
        <input type="submit" value="Envoyer">
    </div>
</form>
    
</body>
</html>

