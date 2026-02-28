<?php
//connexion a la base de donnee
include_once "connexion.php";

//suppression de la base de donnee patients
if (isset($_POST['delete'])) {
    $numpatient  = $_POST['numPatient'] ?? '';
    $nomPatient  = $_POST['nomPatient'] ?? '';
    $datenaiss   = $_POST['date'] ?? '';
    $sexe        = $_POST['sexe'] ?? '';
    $adresse     = $_POST['adresse'] ?? '';
    $telephone   = $_POST['telepho'] ?? '';
    $groupes     = $_POST['sanguin'] ?? '';

    $sql = "DELETE FROM patients 
            WHERE id_patients = ? 
            AND nom_patients = ? 
            AND date_de_naissance = ? 
            AND sexe = ? 
            AND adresse = ? 
            AND telephone = ? 
            AND groupe_sanguin = ?";

    $requette = $basedonnee->prepare($sql);

    $requette->execute([
        $numpatient,
        $nomPatient,
        $datenaiss,
        $sexe,
        $adresse,
        $telephone,
        $groupes
    ]);

    // Redirection pour rafraîchir le tableau
    header('Location: patients.php');
    exit();
}

//insertion dans la base de donnee
if (isset($_POST['ajouter'])) {
    $numpatient  = $_POST['numPatient'];
    $nomPatient  = $_POST['nomPatient'];
    $datenaiss   = $_POST['date'];
    $sexe        = $_POST['sexe'];
    $adresse     = $_POST['adresse'];
    $telephone   = $_POST['telepho'];
    $groupes     = $_POST['sanguin'];

    if (
        !empty($numpatient) && !empty($nomPatient) && !empty($datenaiss) &&
        !empty($sexe) && !empty($adresse) && !empty($telephone) && !empty($groupes)
    ) {

        $sql = "INSERT INTO patients (id_patients, nom_patients, date_de_naissance, sexe, adresse, telephone, groupe_sanguin) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";

        $requette = $basedonnee->prepare($sql);
        try {
            $requette->execute([
                $numpatient,
                $nomPatient,
                $datenaiss,
                $sexe,
                $adresse,
                $telephone,
                $groupes
            ]);
            header('location: patients.php?action=erreur');
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                header('location:patients.php?action3=erreur');
            } else {
                echo "<p style='color:red;'>Erreur système : " . $e->getMessage() . "</p>";
            }
        }
    }
}
//mise en jour de la base de donnee
if (isset($_POST['modifier'])) {
    $numpatient  = $_POST['numPatient'] ?? '';
    $nomPatient  = $_POST['nomPatient'] ?? '';
    $datenaiss   = $_POST['date'] ?? '';
    $sexe        = $_POST['sexe'] ?? '';
    $adresse     = $_POST['adresse'] ?? '';
    $telephone   = $_POST['telepho'] ?? '';
    $groupes     = $_POST['sanguin'] ?? '';

    $sql = "UPDATE patients SET 
            nom_patients = ?, 
            date_de_naissance = ?, 
            sexe = ?, 
            adresse = ?, 
            telephone = ?, 
            groupe_sanguin = ?
            WHERE id_patients = ?";

    $requette = $basedonnee->prepare($sql);
    $requette->execute([
        $nomPatient,
        $datenaiss,
        $sexe,
        $adresse,
        $telephone,
        $groupes,
        $numpatient
    ]);

    header('Location: patients.php');
    exit();
}

// recherche des element dans la base de donnee
if (isset($_POST['recherche']) && !empty($_POST['valeur_recherche'])) {
    $recher = $_POST['valeur_recherche'];
    $aff = $basedonnee->prepare('SELECT * FROM patients WHERE id_patients = ? OR nom_patients LIKE ? ORDER BY nom_patients ASC');
    // Correction de la syntaxe des %
    $aff->execute([$recher, "%$recher%"]); 
} else {
    $aff = $basedonnee->query('SELECT * FROM patients ORDER BY nom_patients ASC');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>patients</title>
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
                <h2>Patient</h2>
                <?php
                if (isset($_GET['action'])) {
                    echo "<p style='color:rgb(41, 10, 76); font-size: 15px;'>Patient ajouté avec succès !</p>";
                }
                if (isset($_GET['action2'])) {
                    echo "<p style='color:red;font-size:15px'>Veuillez remplir tous les champs.</p>";
                }
                ?>
                <label for="">Numero patient</label>
                <input type="text" name="numPatient" autofocus required>
                <label for="">Nom patient</label>
                <input type="text" name="nomPatient" autofocus required>
                <label for="">Date de naissance</label>
                <input type="date" name="date" required>
                <label for="">Sexe</label>
                <input type="text" name="sexe" required autofocus>
                <label for="">Adresse</label>
                <input type="text" name="adresse" autofocus required>
                <label for="">Telephone</label>
                <input type="text" name="telepho" autofocus required>
                <label for="">Groupe sanguin</label>
                <input type="text" name="sanguin" autofocus required>
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

        <div class="tableau">
            <legend>Liste des patients</legend>
            <?php
            if (isset($_GET['action3'])) {
                echo "<p style='color:red;'>Le numéro de patient existe déjà.</p>";
            }
            ?>
            <div class="recherche">
                <form action="patients.php" method="post">
                    <input type="text" name="valeur_recherche" placeholder="Reche.. par Id ou Nom" autofocus>
                    <button type="submit" name="recherche">Recherche</button>
                    <button type="reset"><a href="patients.php">Avoir plus</a></button>
                </form>
            </div>
            <table class="tab">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Numero patients</th>
                        <th>Nom patients</th>
                        <th>Date de naissance</th>
                        <th>Sexe</th>
                        <th>Adresse</th>
                        <th>Telephone</th>
                        <th>groupe sanguin</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    //$aff = $basedonnee->query('SELECT*FROM patients ORDER BY nom_patients ASC');
                    $i = 1;
                    while ($donnee = $aff->fetch()) {
                        echo "<tr>";
                        echo "<td>" . $i++ . "</td>";
                        echo "<td>" . $donnee['id_patients'] . "</td>";
                        echo "<td>" . $donnee['nom_patients'] . "</td>";
                        echo "<td>" . $donnee['date_de_naissance'] . "</td>";
                        echo "<td>" . $donnee['sexe'] . "</td>";
                        echo "<td>" . $donnee['adresse'] . "</td>";
                        echo "<td>" . $donnee['telephone'] . "</td>";
                        echo "<td>" . $donnee['groupe_sanguin'] . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>