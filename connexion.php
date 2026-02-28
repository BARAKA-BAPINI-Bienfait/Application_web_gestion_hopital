<?php
try{
    $basedonnee = new PDO('mysql:host=localhost;dbname=gestion_de_hopital;charset=utf8', 'root', '');
    $basedonnee->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(Exception $a){
    die('Erreur :' .$a->getMessage());
}
?>