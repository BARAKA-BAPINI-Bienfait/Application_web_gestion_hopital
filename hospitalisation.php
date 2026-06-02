<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit(); 
}
//connexion a la base de donnee
include_once "connexion.php";

//gestion des menus deroulants
//patient
$patientConsultee = $basedonnee->query('SELECT * FROM affichage_patient_consultee ORDER BY nom_patients');
//consultation
$consultation = $basedonnee->query('SELECT * from affichage_de_consultation_pour_la_quelle_pas_dhospitalisation order by date_consultation desc');
//service
$service = $basedonnee->query('SELECT id_services, nom_service FROM services ORDER BY nom_service');
//personnel
$personnel = $basedonnee->query('SELECT id_personnels, nom_personnels, role FROM personnels ORDER BY nom_personnels');

//suppression de la base de donnee patients
if (isset($_POST['delete']) && isset($_POST['id_a_delete'])) {
    $requette_del = $basedonnee->prepare('DELETE FROM hospitalisation WHERE id_hospitalisation=?');
    try {
        $requette_del->execute([$_POST['id_a_delete']]);
        // Redirection pour rafraîchir le tableau
        header('Location: hospitalisation.php');
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            header('location:hospitalisation.php?exist=erreur');
        } else {
            echo "<p style='color:red;'>Erreur système : " . $e->getMessage() . "</p>";
        }
    }
}

//insertion dans la base de donnee
if (isset($_POST['ajouter'])) {
    $numHospitalisation = $_POST['hospitalisation'];
    $dataEntre  = $_POST['dateen'];
    $dateSortie = $_POST['dates'];
    $numPatient = $_POST['id_patient'];
    $numConsultation = $_POST['id_consultation'];
    $numService = $_POST['id_services'];
    $numPersonnel = $_POST['id_personnels'];

    if (
        !empty($numHospitalisation) && !empty($dataEntre) && !empty($dateSortie) && !empty($numPatient) && !empty($numConsultation) && !empty($numService)
        && !empty($numPersonnel)
    ) {
        try {
            $sql = "INSERT INTO hospitalisation (id_hospitalisation, date_entree, date_sortie, id_patients, id_consultation,
        id_services, id_personnels) values (?,?,?,?,?,?,?)";
            $requette = $basedonnee->prepare($sql);
            $requette->execute([
                $numHospitalisation,
                $dataEntre,
                $dateSortie,
                $numPatient,
                $numConsultation,
                $numService,
                $numPersonnel,
            ]);
            header('location: hospitalisation.php');
        } catch (Exception $e) {
            header('Location:hospitalisation.php?date=erreur');
        }
    }
}

//mise en jour de la base de donnee
if (isset($_POST['modifier'])) {
    $numHospitalisation = $_POST['hospitalisation'] ?? '';
    $dataEntre  = $_POST['dateen'] ?? '';
    $dateSortie = $_POST['dates'] ?? '';
    $numPatient = $_POST['id_patients'] ?? '';
    $numConsultation = $_POST['id_consultation'] ?? '';
    $numService = $_POST['id_services'] ?? '';
    $numPersonnel = $_POST['id_personnels'] ?? '';

    $sql = "UPDATE hospitalisation SET 
            date_entree = ?, 
            date_sortie = ?,
            id_patients = ?,
            id_consultation =?,
            id_services = ?,
            id_personnels = ?
            WHERE id_hospitalisation = ?";

    $requette = $basedonnee->prepare($sql);
    $requette->execute([
        $dataEntre,
        $dateSortie,
        $numPatient,
        $numConsultation,
        $numService,
        $numPersonnel,
        $numHospitalisation
    ]);

    header('Location: hospitalisation.php');
    exit();
}

// recherche des element dans la base de donnee
if (isset($_POST['recherche']) && !empty($_POST['valeur_recherche'])) {
    $recher = $_POST['valeur_recherche'];
    $aff = $basedonnee->prepare('SELECT * FROM affichage_hospitalisation WHERE id_consultation=? OR nom_patients LIKE ? ORDER BY date_entree DESC');
    // Correction de la syntaxe des %
    $aff->execute([$recher, "%$recher%"]);
} else {
    //affichage sur le tabeau
    $aff = $basedonnee->query('SELECT * FROM affichage_hospitalisation ORDER BY date_entree DESC');
} ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="consultatio.css">
    <title>hospitalisation</title>
</head>

<body>
    <header class="head">
        <ul>
            <li><a href="accueil.php">accueil</a></li>
        </ul>
    </header>
    <div class="papa">
        <div class="patientbig">

            <form action="hospitalisation.php" method="post" class="patientformular">
                <h2>Hospitalisation</h2>
                <?php
                if (isset($_GET['date'])) {?>
                <script type="text/javascript"> alert('erreur')</script>
                    <?php 
                }
                ?>
                <label for="">Numero hospitalisation</label>
                <input type="text" name="hospitalisation">
                <label for="">Date d'entree</label>
                <input type="date" name="dateen" autofocus required value=".../.../...">
                <label for="">Date sortie</label>
                <input type="date" name="dates" value=".../.../..." autofocus required>
                <!--menu deroulants-->
                <label for="patient_select">Patient</label>
                <select name="id_patient" id="patient_select" required class="deroulant_patient">
                    <option value="">choisir un patient</option>
                    <?php
                    while ($pa= $patientConsultee->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                        <option value="<?= $pa['id_patients'] ?>">
                            <?= htmlspecialchars($pa['nom_patients']) ?>
                        </option>
                    <?php } ?>
                </select>

                <label for="consultation_select">consultation</label>
                <select name="id_consultation" id="consultation_select" required class="deroulant_consultation">
                    <option value="">choisir un consultation</option>
                    <?php
                    while ($c = $consultation->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                        <option value="<?= $c['id_consultation'] ?>">
                            consult. du: <?= htmlspecialchars($c['date_consultation']) ?>
                            ,Patient:<?= htmlspecialchars($c['nom_patients']) ?>
                            ,Diagno.:<?= htmlspecialchars($c['diagnostique']) ?>
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
                            <?= htmlspecialchars($p['nom_personnels']) ?>:
                            <?= htmlspecialchars_decode($p['role']) ?>
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
            <legend>Liste d'hospitalisation</legend>
            <?php
            if (isset($_GET['action'])) {?>
                <script type="text/javascript"> alert('Le numéro existe déjà.')</script>
                <?php
            }
            if (isset($_GET['exist'])) {?>

                
                <script type="text/javascript"> alert('hospitalisation est dans une autre table.')</script>
                <?php
            }
            ?>
            <div class="recherche">
                <form action="hospitalisation.php" method="post">
                    <input type="text" name="valeur_recherche" placeholder="Reche.. par Id ou Patient" autofocus>
                    <button type="submit" name="recherche">Recherche</button>
                    <button type="reset"><a href="hospitalisation.php">Voir plus</a></button>
                </form>
            </div>
            <table class="tab">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Num.hospitalisation</th>
                        <th>Date d'entre</th>
                        <th>Date de sortie</th>
                        <th>Nom patient</th>
                        <th>Num consulta.</th>
                        <th>Nom service</th>
                        <th>Nom personnel</th>
                        <th>DEL</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    //$aff = $basedonnee->query('SELECT*FROM patients ORDER BY nom_patients ASC');
                    $i = 1;
                    while ($donnee = $aff->fetch()) {
                        echo "<tr>";
                        echo "<td>" . $i++ . "</td>";
                        echo "<td>" . $donnee['id_hospitalisation'] . "</td>";
                        echo "<td>" . $donnee['date_entree'] . "</td>";
                        echo "<td>" . $donnee['date_sortie'] . "</td>";
                        echo "<td>" . $donnee['nom_patients'] . "</td>";
                        echo "<td>" . $donnee['id_consultation'] . "</td>";
                        echo "<td>" . $donnee['nom_service'] . "</td>";
                        echo "<td>" . $donnee['nom_personnels'] . "</td>"; 
                    ?>
                    <!--gestion de button suppression-->
                        <td>
                            <form method="post" action="hospitalisation.php">
                                <input type='hidden' name='id_a_delete' value="<?php echo $donnee['id_hospitalisation']; ?>">
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

</html>