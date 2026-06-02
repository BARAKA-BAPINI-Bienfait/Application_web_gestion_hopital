<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit(); 
}

//connexion a la base de donnee
include_once "connexion.php";

//nombre total de patients:
$nombrePatients = $basedonnee->query('SELECT count(*) as nombre_patients from patients');

//nombre de consultation:
$nombreConsultation = $basedonnee->query('SELECT count(*) as nombre_consultation from consultation');

//nombre d'hospitalisation:
$nombreHospitalisation = $basedonnee->query('SELECT count(*) as nombre_hospitalisation from hospitalisation');

//nombre de payement:
$nombrePayement = $basedonnee->query('SELECT count(*) as nombre_payement from payement');

//somme total
$somme = $basedonnee->query('SELECT sum(montant) as montant from payement');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="tableau_bord.CSS">
    <title>tableau de bord</title>
</head>
<body>
    <header class="head">
        <ul>
            <li><a href="accueil.php">accueil</a></li>
        </ul>
    </header>
    <h3>TABLEAU DE BORD</h3>
    <div class="bordgrand">
        
        <div class="bord">
            <div class="bor">
                <p>nombre total de patients</p>
                <p class="new">
                    <?php
                    $donnee=$nombrePatients->fetch();
                    echo $donnee['nombre_patients']; 
                    ?>
                </p>

            </div>
            <div class="bor">
                <p>nombre de consultation</p>
                <p class="new">
                    <?php 
                    $donnee=$nombreConsultation->fetch();
                    echo $donnee['nombre_consultation'];
                    ?>
                </p>

            </div>
            <div class="bor">
                <p>nombre d'hospitalisation</p>
                <p class="new">
                    <?php
                    $donnee=$nombreHospitalisation->fetch();
                    echo $donnee['nombre_hospitalisation'];
                    ?>
                </p>

            </div>
            <div class="bor">
                <p>nombre de payement</p>
                <p class="new">
                    <?php 
                    $donnee=$nombrePayement->fetch();
                    echo $donnee['nombre_payement'];
                    ?>
                </p>

            </div>


        </div>
    </div>
    <div class="montant">
        <h4>TOTAL GENERAL DES MONTANTS :</h4>
        <p><?php $donnee=$somme->fetch();
                echo $donnee['montant'];
            ?> fc
        </p>
    </div>
</body>
</html>