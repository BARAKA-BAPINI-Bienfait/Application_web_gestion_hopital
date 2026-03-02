<?php
//connexion a la base de donnee
include_once "connexion.php";

//gestion des menus deroulants
//patient
$patient = $basedonnee->query('SELECT id_patients,nom_patients FROM patients ORDER BY nom_patients');
//service
$service = $basedonnee->query('SELECT id_services, nom_service FROM services ORDER BY nom_service');
//personnel
$personnel = $basedonnee->query('SELECT id_personnels, nom_personnels FROM personnels ORDER BY nom_personnels');



//suppression de la base de donnee patients
if (isset($_POST['delete']) && isset($_POST['id_a_delete'])) {
    $requette_del = $basedonnee->prepare('DELETE FROM consultation WHERE id_consultation=?');
    try{
        $requette_del->execute([$_POST['id_a_delete']]);
        // Redirection pour rafraîchir le tableau
        header('Location: consultation.php');

    }catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            header('location:consultation.php?exist=erreur');
        } else {
            echo "<p style='color:red;'>Erreur système : " . $e->getMessage() . "</p>";
        }
    }
    
}

//insertion dans la base de donnee
if (isset($_POST['ajouter'])) {
    $numConsultation = $_POST['nomConsultation'];
    $dataConsultation  = $_POST['date'];
    $diagnostique = $_POST['diagnostique'];
    $prescription = $_POST['prescription'];
    $motif = $_POST['motif'];
    $patient = $_POST['id_patient'];
    $service = $_POST['id_services'];
    $personnel = $_POST['id_personnels'];

     try{
        $sql = "INSERT INTO consultation (id_consultation, date_consultation, diagnostique, prescription, motif, id_patients,
        id_services, id_personnels) values (?,?,?,?,?,?,?,?)";
        $requette = $basedonnee->prepare($sql);
            $requette->execute([
                $numConsultation,
                $dataConsultation,
                $diagnostique,
                $prescription,
                $motif,
                $patient,
                $service,
                $personnel,
            ]);
            header('location: consultation.php?action=ok');
       }catch(Exception $e){
            header('Location:consultation.php?action=erreur');
    }
    
}
//mise en jour de la base de donnee
if (isset($_POST['modifier'])) {
    $numConsultation = $_POST['nomConsultation'] ?? '';
    $dataConsultation  = $_POST['date'] ?? '';
    $diagnostique = $_POST['diagnostique'] ?? '';
    $prescription = $_POST['prescription'] ?? '';
    $motif = $_POST['motif'] ?? '';
    $patient = $_POST['id_patient'] ?? '';
    $service = $_POST['id_services'] ?? '';
    $personnel = $_POST['id_personnels'] ?? '';

    $sql = "UPDATE consultation SET 
            date_consultation = ?, 
            diagnostique = ?,
            prescription = ?,
            motif = ?,
            id_patients = ?,
            id_services = ?,
            id_personnels = ?
            WHERE id_consultation = ?";

    $requette = $basedonnee->prepare($sql);
    $requette->execute([
        $dataConsultation,
        $diagnostique,
        $prescription,
        $motif,
        $patient,
        $service,
        $personnel,
        $numConsultation
    ]);

    header('Location: consultation.php');
    exit();
}

// recherche des element dans la base de donnee
if (isset($_POST['recherche']) && !empty($_POST['valeur_recherche'])) {
    $recher = $_POST['valeur_recherche'];
    $aff = $basedonnee->prepare('SELECT * FROM affichage_consultation_nom WHERE id_consultation=? OR date_consultation LIKE ? ORDER BY date_consultation DESC');
    // Correction de la syntaxe des %
    $aff->execute([$recher, "%$recher%"]);
} else {
    //affichage sur le tabeau
    $aff = $basedonnee->query('SELECT * FROM affichage_consultation_nom ORDER BY nom_patients DESC');
} ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="consultatio.css">
    <title>consultation</title>
</head>

<body>
    <header class="head">
        <ul>
            <li><a href="accueil.php">accueil</a></li>
        </ul>
    </header>
    <div class="papa">
        <div class="patientbig">

            <form action="consultation.php" method="post" class="patientformular">
                <h2>consultation</h2>
                <?php
                if (isset($_GET['action'])) {
                    echo "<p style='color:rgb(41, 10, 76); font-size: 15px;'>Consultation ajouté avec succès !</p>";
                }
                if (isset($_GET['action2'])) {
                    echo "<p style='color:red;font-size:15px'>Veuillez remplir tous les champs.</p>";
                }
                ?>
                <label for="">Numero consultation</label>
                <input type="text" name="nomConsultation">
                <label for="">Date</label>
                <input type="date" name="date" autofocus required>
                <label for="">Diagnostique</label>
                <input type="text" name="diagnostique">
                <label for="">Prescription</label>
                <input type="text" name="prescription">
                <label for="">Motif</label>
                <input type="text" name="motif">

                <!--menu deroulants-->
                <label for="patient_select">Patient</label>
                <select name="id_patient" id="patient_select" required class="deroulant_patient">
                    <option value="">choisir un patient</option>
                    <?php
                    while ($p = $patient->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                        <option value="<?= $p['id_patients'] ?>">
                            <?= htmlspecialchars($p['nom_patients']) ?>
                        </option>
                    <?php } ?>
                </select>

                <label for="id_services">Service</label>
                <select name="id_services" required class="deroulant_service">
                    <option value="">choisir un service</option>
                    <?php
                    while ($s = $service->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                        <option value="<?= $s['id_services'] ?>">
                            <?= htmlspecialchars($s['nom_service']) ?>
                        </option>
                    <?php } ?>
                </select>

                <label for="id_personnels">Personnel</label>
                <select name="id_personnels" required class="deroulant_personnel">
                    <option value="">choisir un personnel</option>
                    <?php
                    while ($p = $personnel->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                        <option value="<?= $p['id_personnels'] ?>">
                            <?= htmlspecialchars($p['nom_personnels']) ?>
                        </option>
                    <?php } ?>
                </select>
                <!--BOUTON-->
                <div class="btn">
                    <input class="" type="submit" value="Ajouter" name="ajouter">
                    <input type="submit" value="modifier">
                    <input type="reset" value="Annuler">
                </div>
            </form>
        </div>
        <!--tableau-->
        <div class="tableau">
            <legend>Liste des personnels</legend>
            <?php
            if (isset($_GET['action'])) {
                echo "<p style='color:red;'>Le numéro existe déjà.</p>";
            }
            if (isset($_GET['exist'])) {
                    echo "<p style='color:red;font-size:15px'>consultation est dans une autre table.</p>";
                }
            ?>
            <div class="recherche">
                <form action="consultation.php" method="post">
                    <input type="text" name="valeur_recherche" placeholder="Reche.. par Id ou Date" autofocus>
                    <button type="submit" name="recherche">Recherche</button>
                    <button type="reset"><a href="consultation.php">Voir plus</a></button>
                </form>
            </div>
            <table class="tab">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Num.consult.</th>
                        <th>Date</th>
                        <th>Diagnos.</th>
                        <th>Prescription</th>
                        <th>Motif</th>
                        <th>Nom patient</th>
                        <th>Nom service</th>
                        <th>Nom person.</th>
                        <th>ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    //$aff = $basedonnee->query('SELECT*FROM patients ORDER BY nom_patients ASC');
                    $i = 1;
                    while ($donnee = $aff->fetch()) {
                        echo "<tr>";
                        echo "<td>" . $i++ . "</td>";
                        echo "<td>" . $donnee['id_consultation'] . "</td>";
                        echo "<td>" . $donnee['date_consultation'] . "</td>";
                        echo "<td>" . $donnee['diagnostique'] . "</td>";
                        echo "<td>" . $donnee['prescription'] . "</td>";
                        echo "<td>" . $donnee['motif'] . "</td>";
                        echo "<td>" . $donnee['nom_patients'] . "</td>";
                        echo "<td>" . $donnee['nom_service'] . "</td>";
                        echo "<td>" . $donnee['nom_personnels'] . "</td>"; ?>
                        <!--gestion de button suppression-->
                        <td>
                            <form method="post" action="consultation.php">
                                <input type='hidden' name='id_a_delete' value="<?php echo $donnee['id_consultation'];?>">
                                <button type="submit" name="delete" style='cursor:pointer;background-color: rgb(104, 50, 166);border:none;padding:1px;border-radius:8px;color:white;'
                                    onclick="return confirm('voulez-vous supprimer')">supprimer</button>
                            </form>
                        </td>
                        <?php
                        echo "</tr>"
                        ?>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

</body>

</html> 