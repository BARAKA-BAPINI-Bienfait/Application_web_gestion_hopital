<?php
include_once "connexion.php";
if (isset($_POST['connect'])) {
    $champsUser = $_POST['user'];
    $champsMot = $_POST['motdepasse'];

    $user = 'bapini';
    $motdepasse = '12345';

    if ($champsUser == $user && $champsMot == $motdepasse) {
        header('location:accueil.php');
    } else {
        header("location:login.php?action=erreur");
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
        <form action="login.php" method="post" class="formular">
            <h3>connexion</h3>
            <?php
            if (isset($_GET['action']) && $_GET['action'] == 'erreur') { ?>
                <p style='color: red; font-size: 12px;'>les donnees entree sont incorrect</p>
            <?php }
            ?>
            <label for="">Utilisateur</label>
            <input type="text" name="user" required autofocus>
            <label for="">Mot de passe</label>
            <input type="password" name="motdepasse" id="" required autofocus>
            <input class="input1" type="submit" value="connecter" name="connect"><input class="input1" type="reset" value="annuler" name="reset">
        </form>
    </div>
</body>

</html>