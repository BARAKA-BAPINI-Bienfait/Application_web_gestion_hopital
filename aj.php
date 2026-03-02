<?php
include_once 'connexion.php';
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
            header('location:consultation.php?action=ok');
        }catch(Exception $e){
            header('Location:consultation.php?action=erreur');
    }
    
}