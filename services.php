<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit(); 
}
//connexion a la base de donnee
include_once "connexion.php";

//suppression de la base de donnee patients
if (isset($_POST['delete']) && isset($_POST['id_a_delete'])) {
    $requette_del = $basedonnee->prepare('DELETE FROM services WHERE id_services=?');
    try {
        $requette_del->execute([$_POST['id_a_delete']]);
        // Redirection pour rafraîchir le tableau
        header('Location: services.php');
        exit();
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            header('location:services.php?exist=erreur');
        } else {
            echo "<p style='color:red;'>Erreur système : " . $e->getMessage() . "</p>";
        }
    }
}

//insertion dans la base de donnee
if (isset($_POST['ajouter'])) {
    $numService  = $_POST['numService'];
    $nomService  = $_POST['nomService'];
    $description   = $_POST['description'];
    if (
        !empty($numService) && !empty($nomService) && !empty($description)
    ) {

        $sql = "INSERT INTO services (id_services, nom_service, description) 
                VALUES (?, ?, ?)";

        $requette = $basedonnee->prepare($sql);
        try {
            $requette->execute([
                $numService,
                $nomService,
                $description,
            ]);
            header('location: services.php');
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                header('location: services.php?action3=erreur');
            } else {
                echo "<p style='color:red;'>Erreur système : " . $e->getMessage() . "</p>";
            }
        }
    }
}
//mise en jour de la base de donnee
if (isset($_POST['modifier'])) {
    $numService  = $_POST['numService'] ?? '';
    $nomService  = $_POST['nomService'] ?? '';
    $description = $_POST['description'] ?? '';

    $sql = "UPDATE services SET 
            nom_service = ?, 
            description = ?
            WHERE id_services = ?";

    $requette = $basedonnee->prepare($sql);
    $requette->execute([
        $nomService,
        $description,
        $numService
    ]);

    header('Location: services.php');
    exit();
}

// recherche des element dans la base de donnee
if (isset($_POST['recherche']) && !empty($_POST['valeur_recherche'])) {
    $recher = $_POST['valeur_recherche'];
    $aff = $basedonnee->prepare('SELECT * FROM services WHERE id_services = ? OR nom_service LIKE ? ORDER BY nom_service ASC');
    // Correction de la syntaxe des %
    $aff->execute([$recher, "%$recher%"]);
} else {
    $aff = $basedonnee->query('SELECT * FROM services ORDER BY nom_service ASC');
} ?>










<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>service</title>
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
                <h2>services</h2>
                <?php
                if (isset($_GET['action2'])) {
                    echo "<p style='color:red;font-size:15px'>Veuillez remplir tous les champs.</p>";
                }
                ?>
                <label for="">Numero service</label>
                <input type="text" name="numService" autofocus required>
                <label for="">Nom service</label>
                <input type="text" name="nomService" autofocus required>
                <label for="">Description</label>
                <textarea name="description" id=""></textarea>
                <div class="btn">
                    <form action="">
                        <button class="btna" name="ajouter">Ajouter</button>
                    </form>
                    <button class="btnm" name="modifier">Modifier</button>
                    <input type="reset" value="Annuler">
                </div>
            </form>
        </div>
        <!--tableau-->
        <div class="tableau">
            <legend>Liste des services</legend>
            <?php
            if (isset($_GET['exist'])) { ?>
                <script type="text/javascript">
                    alert('le service est utilisee dans une autre table')
                </script>
            <?php
            }
            if (isset($_GET['action3'])) {?>
            <script type="text/javascript">
                    alert('Le numéro de service existe déjà.')
                </script>
                <?php
            }
            ?>
            <div class="recherche">
                <form action="services.php" method="post">
                    <input type="text" name="valeur_recherche" placeholder="Reche.. par Id ou Nom" autofocus>
                    <button type="submit" name="recherche">Recherche</button>
                    <button type="reset"><a href="services.php">Voir plus</a></button>
                </form>
            </div>
            <table class="tab">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Numero service</th>
                        <th>Nom service</th>
                        <th>Description</th>
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
                        echo "<td>" . $donnee['id_services'] . "</td>";
                        echo "<td>" . $donnee['nom_service'] . "</td>";
                        echo "<td>" . $donnee['description'] . "</td>"; ?>
                        <!--gestion de button suppression-->
                        <td>
                            <form method="post" action="services.php">
                                <input type='hidden' name='id_a_delete' value="<?php echo $donnee['id_services']; ?>">
                                <button type="submit" name="delete" style='cursor:pointer;background-color: rgb(104, 50, 166);border:none;padding:1px;border-radius:8px;color:white;'
                                    onclick="return confirm('voulez-vous supprimer ce service')">supprimer</button>
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