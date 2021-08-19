

<?php
try{
    $options = [
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
    PDO::ATTR_ERRMODE =>  PDO::ERRMODE_EXCEPTION
    ];
    $bdd = new PDO('mysql:host=localhost;dbname=mon_blog', 'root', '', $options);
}catch(Exception $e){
    
    die('Erreur : ' . $e->getMessage());

}

function retourneMdp($bdd,$login){
    $sql = 'SELECT mdp FROM `administrateurs` WHERE login = ?';
    $q = $bdd->prepare($sql);
    $q->execute(array($login));
    $mdp = $q->fetchColumn();
    $q -> closeCursor();
    return $mdp;
}