<?php
//connexion a la base de donnee
include_once "connexion.php";

//suppression de la base de donnee patients
if (isset($_POST['delete'])) {
    $numPersonnel = $_POST['numPersonnel'] ?? '';
    $nomPersonnel  = $_POST['nomPersonnel'] ?? '';
    $role = $_POST['role'] ?? '';

    $sql = "DELETE FROM personnels
            WHERE id_personnels = ? 
            AND nom_personnels = ? 
            AND role = ?";

    $requette = $basedonnee->prepare($sql);

    $requette->execute([
        $numPersonnel,
        $nomPersonnel,
        $role,
    ]);

    // Redirection pour rafraîchir le tableau
    header('Location: personnels.php');
    exit();
}

//insertion dans la base de donnee
if (isset($_POST['ajouter'])) {
    $numPersonnel  = $_POST['numPersonnel'];
    $nomPersonnel  = $_POST['nomPersonnel'];
    $role   = $_POST['role'];
    if (
        !empty($numPersonnel) && !empty($nomPersonnel) && !empty($role)
    ) {

        $sql = "INSERT INTO personnels (id_personnels, nom_personnels, role) 
                VALUES (?, ?, ?)";

        $requette = $basedonnee->prepare($sql);
        try {
            $requette->execute([
                $numPersonnel,
                $nomPersonnel,
                $role,
            ]);
            header('location: personnels.php?action=erreur');
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                header('location: personnels.php?action3=erreur');
            } else {
                echo "<p style='color:red;'>Erreur système : " . $e->getMessage() . "</p>";
            }
        }
    }
}
//mise en jour de la base de donnee
if (isset($_POST['modifier'])) {
    $numPersonnel  = $_POST['numPersonnel'] ?? '';
    $nomPersonnel  = $_POST['nomPersonnel'] ?? '';
    $role = $_POST['role'] ?? '';
 
    $sql = "UPDATE personnels SET 
            nom_personnels = ?, 
            role = ?
            WHERE id_personnels = ?";

    $requette = $basedonnee->prepare($sql);
    $requette->execute([
        $nomPersonnel,
        $role,
        $numPersonnel
    ]);

    header('Location: personnels.php');
    exit();
}

// recherche des element dans la base de donnee
if (isset($_POST['recherche']) && !empty($_POST['valeur_recherche'])) {
    $recher = $_POST['valeur_recherche'];
    $aff = $basedonnee->prepare('SELECT * FROM personnels WHERE id_personnels = ? OR nom_personnels LIKE ? ORDER BY nom_personnels ASC');
    // Correction de la syntaxe des %
    $aff->execute([$recher, "%$recher%"]); 
} else {
    $aff = $basedonnee->query('SELECT * FROM personnels ORDER BY nom_personnels ASC');
}?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Personnels</title>
</head>
<body>
    <header class="head">
        <ul>
            <li><a href="accueil.php">accueil</a></li>
        </ul>
    </header>

    <div class="papa">
        <div class="patientbig">

            <form action="" method="post" class="patientformular">
                <h2>personnels</h2>
                <?php
                if (isset($_GET['action'])) {
                    echo "<p style='color:rgb(41, 10, 76); font-size: 15px;'>Service ajouté avec succès !</p>";
                }
                if (isset($_GET['action2'])) {
                    echo "<p style='color:red;font-size:15px'>Veuillez remplir tous les champs.</p>";
                }
                ?>
                <label for="">Numero personnel</label>
                <input type="text" name="numPersonnel" autofocus required>
                <label for="">Nom personnel</label>
                <input type="text" name="nomPersonnel" autofocus required>
                <label for="">Role</label>
                <textarea name="role" id=""></textarea>
                <div class="btn">
                    <form action="">
                        <button class="btna" name="ajouter">Ajouter</button>
                    </form>
                    <button class="btnm" name="modifier">Modifier</button>
                    <button type="submit" class="btns" name="delete" onclick="return confirm('Supprimer ce message ?')">Supprimer</button>
                    <input type="reset" value="Annuler">
                </div>
            </form>
        </div>
        <!--tableau-->
        <div class="tableau">
            <legend>Liste des personnels</legend>
            <?php
            if (isset($_GET['action3'])) {
                echo "<p style='color:red;'>Le numéro de service existe déjà.</p>";
            }
            ?>
            <div class="recherche">
                <form action="personnels.php" method="post">
                    <input type="text" name="valeur_recherche" placeholder="Reche.. par Id ou Nom" autofocus>
                    <button type="submit" name="recherche">Recherche</button>
                    <button type="reset"><a href="personnels.php">Voir plus</a></button>
                </form>
            </div>
            <table class="tab">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Numero personnels</th>
                        <th>Nom personnels</th>
                        <th>role</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    //$aff = $basedonnee->query('SELECT*FROM patients ORDER BY nom_patients ASC');
                    $i = 1;
                    while ($donnee = $aff->fetch()) {
                        echo "<tr>";
                        echo "<td>" . $i++ . "</td>";
                        echo "<td>" . $donnee['id_personnels'] . "</td>";
                        echo "<td>" . $donnee['nom_personnels'] . "</td>";
                        echo "<td>" . $donnee['role'] . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>


    
    


</body>
</html>