<?php


//echo 'on doit modifier l\'article ' . $_GET['id'];
//on proposera un formulaire prérempli  

session_start();
unset($_SESSION['message']);
	
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

if(isset($_POST['titre'], $_POST['contenu'])){

/* Etape 2 : on test la requete sur PHPMyAdmin et on remplace les variables par :var*/
$sql = 'UPDATE billets SET titre = :titre, contenu = :contenu, date_creation = now() WHERE billets.id = :id '; // requete de type UPDATE SET : on modifie un texte

/* Etape 3 : on envoie une requête préparée */
$q = $bdd->prepare($sql);

/* Etape 4 : on exécute la  requête : $lignes affichera le nomnre de lignes affectées ou false */
$lignes = $q->execute(array(
    //on reseigne le tableau
    //ex 'variable' => $_POST['variable'],

    'titre' => htmlspecialchars($_POST['titre']),
    'contenu' => htmlspecialchars($_POST['contenu']),
    'id' => $_GET['id'],
));
/* Etape 5 : on traite */
if($lignes){
    $_SESSION['message'] = 'votre article a bien été modifié';
    header('Location: index.php');
}
}

// Récupérer les données
$sql = 'SELECT titre, contenu FROM billets WHERE  billets.id= :id';
$q = $bdd->prepare($sql);
$q->execute(array('id' => $_GET['id']));
$lignes = $q-> fetch(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Modifier un article - Console</title>
</head>
<body>
<?php if(isset($_SESSION['message'])) echo $_SESSION['message'] ?>
<header>
    <h1>Modifier un article</h1>
    <a href="connexion.php?deconnecter">Se déconnecter</a>
</header>

<form method="post">
    <div class="field">
        <label for="titre" class="titre">Le titre</label> <br>
        <input type="text" name="titre" class="titre" value = "<?= $lignes['titre']?>">
    </div>

    <div class="field">
    <p class="contenu">Les contenu de votre article (en HTML)</p>
    <textarea name="contenu" class="contenu" cols="30" rows="10"><?= $lignes['contenu']?></textarea>
    </div>

    <div class="submit">
        <input type="submit" value="Envoyer">
    </div>
</form>
    
</body>
</html>

