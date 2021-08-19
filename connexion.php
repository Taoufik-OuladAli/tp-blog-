<?php

    session_start();
    if(isset($_GET['deconnecter'])) unset($_SESSION['login']);
    if(isset($_POST['login'], $_POST['mdp'])){
        if(empty($_POST['login']) OR empty($_POST['mdp'])){
            $_SESSION['message'] = 'veulliez remplir tous les champs';
        }
        else{
            $mdp = retourneMdp($bdd, $_POST['login']);
             if(password_verify($_POST['mdp'], $mdp)){
                 $_SESSION['login'] = $_POST['login'];
                 header('Location: index.php');
             }else{
                 $_SESSION['message'] = 'identifiant ou mot de passe incorrects';
             }
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
    <title>Document</title>
</head>
<body>
    <header>
        <h1>Se connecter</h1>
    </header>
    <?php if(isset($_SESSION['message'])) afficheMessage(); ?>
<form action="" method="post">
<div class="field">
   <label for="login">login</label> <br>
   <input type="text" name="login" id="login">
</div>
<div class="field">
    <label for="password">mot de passe</label> <br>
    <input type="mdp" name="mdp" id="mdp">
</div>

<div class="submit">
        <input type="submit" value="Connexion">
</div>
</form>
</body>
</html>