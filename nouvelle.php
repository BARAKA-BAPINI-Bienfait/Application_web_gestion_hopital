<?php$requette = $basedonnee->query('SELECT * FROM affichage_consultation');
        try {
            $requette->execute();
            header('location: consultation.php?action=erreur');
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                header('location: consultation.php?action3=erreur');
            } else {
                echo "<p style='color:red;'>Erreur système : " . $e->getMessage() . "</p>";
            }
        }
    }?>