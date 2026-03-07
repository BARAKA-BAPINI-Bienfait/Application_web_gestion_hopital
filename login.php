<?php
session_start();

if (isset($_SESSION['user'])) {
    header('location:accueil.php');
    exit();
}

include_once "connexion.php";

if (isset($_GET['action']) && $_GET['action'] == 'erreur') {
    $erreur = "Nom d'utilisateur ou mot de passe incorrect !";
}

if (isset($_POST['connect'])) {
    $champsUser = $_POST['user'];
    $champsMot = $_POST['motdepasse'];

    $user = 'bapini';
    $motdepasse = '12345';

    if ($champsUser == $user && $champsMot == $motdepasse) {
        $_SESSION['user'] = $user;
        header('location:accueil.php');
        exit();
    } else {
        header("location:login.php?action=erreur");
        exit();
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>

<body>
    
    <div class="container">
        <h3 class="host">GESTION HOPITAL</h3>
        <form action="login.php" method="post" class="formular">
            <h3>connexion</h3>
            <?php
            if (isset($_GET['action']) && $_GET['action'] == 'erreur') { ?>
                <p style='color: red; font-size: 12px;'>les donnees entree sont incorrect</p>
            <?php }
            ?>
            <label for="">Utilisateur</label>
            <input type="text" name="user" required autofocus value="bapini">
            <label for="">Mot de passe</label>
            <input type="password" name="motdepasse" id="" required autofocus value="12345">
            <input class="input1" type="submit" value="connecter" name="connect"><input class="input1" type="reset" value="annuler" name="reset">
        </form>
    </div>
    
</body>

</html>