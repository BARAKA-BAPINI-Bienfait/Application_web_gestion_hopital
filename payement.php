<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit(); 
}
//connexion a la base de donnee
include_once "connexion.php";

//gestion des menus deroulants
//iconsultation
$consultation = $basedonnee->query('SELECT * FROM payement_consultation ORDER BY date_consultation DESC');

//hospitalisation
$hospitalisation = $basedonnee->query('SELECT * from payement_hospitalisation order by date_entree desc');

//suppression de la base de donnee patients
if (isset($_POST['delete']) && isset($_POST['id_a_delete'])) {
    $requette_del = $basedonnee->prepare('DELETE FROM payement WHERE id_payement=?');
    try {
        $requette_del->execute([$_POST['id_a_delete']]);
        // Redirection pour rafraîchir le tableau
        header('Location: payement.php');
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            header('location:payement.php?exist=erreur');
        } else {
            echo "<p style='color:red;'>Erreur système : " . $e->getMessage() . "</p>";
        }
    }
}

//insertion dans la base de donnee
if (isset($_POST['ajouter'])) {
    $numPayement = isset($_POST['numPayement']) ? $_POST['numPayement'] : null;
    $dataPayement  = isset($_POST['date']) ? $_POST['date'] : null;
    $montant = isset($_POST['montant']) ? $_POST['montant'] : null;
    $modePayement = isset($_POST['mode']) ? $_POST['mode'] : null;
    $statut = isset($_POST['statut']) ? $_POST['statut'] : null;
    $numConsultation = isset($_POST['id_consultaton']) ? $_POST['id_consultaton'] : null;
    $numHospitalisation = isset($_POST['id_hospitalisation']) ? $_POST['id_hospitalisation'] : null;

    try {
        $sql = "INSERT INTO payement(id_payement, date_payement, montant, mode_payement, statut,
            id_consultation, id_hospitalisation) values (?,?,?,?,?,?,?)";
        $requette = $basedonnee->prepare($sql);
        $requette->execute([
            $numPayement,
            $dataPayement,
            $montant,
            $modePayement,
            $statut,
            $numConsultation,
            $numHospitalisation
        ]);
        header('location:payement.php?action1=ok');
    } catch (Exception $e) {
        header('Location:payement.php?date=erreur');
    }
}

// recherche des element dans la base de donnee
if (isset($_POST['recherche']) && !empty($_POST['valeur_recherche'])) {
    $recher = $_POST['valeur_recherche'];
    $aff = $basedonnee->prepare('SELECT * FROM affichage_payement WHERE id_payement=? OR nom_patients LIKE ? ORDER BY date_payement DESC');
    // Correction de la syntaxe des %
    $aff->execute([$recher, "%$recher%"]);
} else {
    //affichage sur le tabeau
    $aff = $basedonnee->query('SELECT * FROM affichage_payement ORDER BY date_payement DESC');
}

?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>payement</title>
</head>

<body>
    <header class="head">
        <ul>
            <li><a href="accueil.php">accueil</a></li>
        </ul>
    </header>
    <div class="papa">
        <div class="patientbig">

            <form action="payement.php" method="post" class="patientformular">
                <h2>Payement</h2>
                <?php
                if (isset($_GET['action1'])) {?>
                    <script type="text/javascript"> alert('Payement ajouté avec succès !')</script>
                <?php
                }
                if (isset($_GET['action2'])) {
                    echo "<p style='color:red;font-size:15px'>Veuillez remplir tous les champs.</p>";
                }
                ?>
                <label for="">Numero payement</label>
                <input type="text" name="numPayement" autofocus required>
                <label for="">Date de payement</label>
                <input type="date" name="date" autofocus required placeholder="10/02/2026">
                <label for="">Montant</label>
                <input type="text" name="montant" autofocus required>
                <label for="mode">Mode de payement</label>
                <input type="text" name="mode" autofocus required value="cach">
                <label for="">Statut</label>
                <input type="text" name="statut" autofocus required value="tout payer">

                <!--menu deroulants-->
                <label for="id_consultaton">Consultation</label>
                <select name="id_consultaton" class="deroulant_patient">
                    <option value="">choisir la consultation</option>
                    <?php
                    while ($c = $consultation->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                        <option value="<?= $c['id_consultation'] ?>">
                            <?= htmlspecialchars($c['nom_patients']) ?>
                            ,<?= htmlspecialchars($c['date_consultation']) ?>
                            ,presc:<?= htmlspecialchars($c['prescription']) ?>
                            ,<?= htmlspecialchars($c['nom_service']) ?>
                        </option>
                    <?php } ?>
                </select>

                <label for="id_hospitalisation">Hospitalisation</label>
                <select name="id_hospitalisation" class="deroulant_service">
                    <option value="">choisir l'hospitalisation</option>
                    <?php
                    while ($h = $hospitalisation->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                        <option value="<?= $h['id_hospitalisation'] ?>">
                            <?= htmlspecialchars($h['nom_patients']) ?>,
                            ,entree:<?= htmlspecialchars($h['date_entree']) ?>
                            ,<?= htmlspecialchars($h['nom_service']) ?>
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
            <legend>Liste des payements</legend>
            <?php
            if (isset($_GET['date'])) {?>
                <script type="text/javascript"> alert('Le numéro existe déjà.')</script>
            <?php
            }
           
            ?>
            <div class="recherche">
                <form action="payement.php" method="post">
                    <input type="text" name="valeur_recherche" placeholder="Reche.. par Id ou Nom" autofocus>
                    <button type="submit" name="recherche">Recherche</button>
                    <button type="reset"><a href="payement.php">Voir plus</a></button>
                </form>
            </div>
            <table class="tab">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Num.hospita.</th>
                        <th>Date pay.</th>
                        <th>Montant</th>
                        <th>Mode pay.</th>
                        <th>Statut</th>
                        <th>Consult.</th>
                        <th>Hospital.</th>
                        <th>delete</th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                    //$aff = $basedonnee->query('SELECT*FROM patients ORDER BY nom_patients ASC');
                    $i = 1;
                    while ($donnee = $aff->fetch()) {
                        echo "<tr>";
                        echo "<td>" . $i++ . "</td>";
                        echo "<td>" . $donnee['id_payement'] . "</td>";
                        echo "<td>" . $donnee['date_payement'] . "</td>";
                        echo "<td>" . $donnee['montant'] . "</td>";
                        echo "<td>" . $donnee['mode_payement'] . "</td>";
                        echo "<td>" . $donnee['statut'] . "</td>";

                        // consultation
                        echo "<td>" . $donnee['nom_patients'].'<br>'
                                    . $donnee['date_consultation'].'<br/>'
                                    . $donnee['prescription'].'<br/>'
                                    . $donnee['service_consultation'].'<br/>'.
                             "</td>";

                        //hospitalisation
                        echo "<td>" . $donnee['nom_patients'].'<br>'.
                                    'Entree:'.'<br/>'
                                    . $donnee['date_entree'].'<br/>'.
                                    'Sortie:'.'<br/>'
                                    . $donnee['date_sortie'].'<br/>'
                                    . $donnee['service_hospitalisation'].'<br/>'.
                             "</td>";
                        
                        
                        
                        
                        ?>

                        
                        <!--gestion de button suppression-->
                        <td>
                            <form method="post" action="payement.php">
                                <input type='hidden' name='id_a_delete' value="<?php echo $donnee['id_payement']; ?>">
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