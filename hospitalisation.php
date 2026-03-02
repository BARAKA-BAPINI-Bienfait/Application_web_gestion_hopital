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
                <h2>consultation</h2>
                <?php
                if (isset($_GET['action'])) {
                    echo "<p style='color:rgb(41, 10, 76); font-size: 15px;'>Hospitalisation ajouté avec succès !</p>";
                }
                if (isset($_GET['action2'])) {
                    echo "<p style='color:red;font-size:15px'>Veuillez remplir tous les champs.</p>";
                }
                ?>
                <label for="">Numero hospitalisation</label>
                <input type="text" name="hospitalisation">
                <label for="">Date d'entree</label>
                <input type="date" name="dateen" autofocus required>
                <label for="">Date sortie</label>
                <input type="text" name="dates">
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

                <label for="consultation_select">consultation</label>
                <select name="id_consultation" id="consultation_select" required class="deroulant_consultation">
                    <option value="">choisir un consultation</option>
                    <?php
                    while ($c = $consultation->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                        <option value="<?= $c['id_consultation'] ?>">
                            <?= htmlspecialchars($p['id_consultation']) ?>
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
            <legend>Liste des consultation</legend>
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
                    <input type="text" name="valeur_recherche" placeholder="Reche.. par Id ou Patient" autofocus>
                    <button type="submit" name="recherche">Recherche</button>
                    <button type="reset"><a href="consultation.php">Voir plus</a></button>
                </form>
            </div>
            <table class="tab">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Num.hospitalisation</th>
                        <th>Date d'entre</th>
                        <th>Date de sortie</th>
                        <th>Num</th>
                        <th>Motif</th>
                        <th>Num.patient</th>
                        <th>Num.service</th>
                        <th>Num.person.</th>
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
                        echo "<td>" . $donnee['id_consultation'] . "</td>";
                        echo "<td>" . $donnee['date_consultation'] . "</td>";
                        echo "<td>" . $donnee['diagnostique'] . "</td>";
                        echo "<td>" . $donnee['prescription'] . "</td>";
                        echo "<td>" . $donnee['motif'] . "</td>";
                        echo "<td>" . $donnee['id_patients'] . "</td>";
                        echo "<td>" . $donnee['id_services'] . "</td>";
                        echo "<td>" . $donnee['id_personnels'] . "</td>"; ?>
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
</html>