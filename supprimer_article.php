
<?php

//echo 'on doit supprimer l\'article ' . $_GET['id'];

session_start();
	

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

if(isset($_GET['id'])){

/* Etape 2 : on test la requete sur PHPMyAdmin et on remplace les variables par :var*/
$sql = 'DELETE FROM billets WHERE billets.id = :id '; // requete de type DELETE : //on supprime  un article du la base de données

/* Etape 3 : on envoie une requête préparée */
$q = $bdd->prepare($sql);

/* Etape 4 : on exécute la  requête : $lignes affichera le nomnre de lignes affectées ou false */
$lignes = $q->execute(array(
    //on reseigne le tableau
    //ex 'variable' => $_POST['variable'],
    'id' => $_GET['id'],
));

}
/* Etape 5 : on traite */
header('Location: index.php');
