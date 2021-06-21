<?php
//si aucun identifiant fourni retourner vers la page liste
$id=filter_input(INPUT_GET,"id",FILTER_VALIDATE_INT);
if (!$id){
    header("location:liste.php");
    exit();
}
session_start();

// récupération du fichier de config
require "includes/config.inc.php";
//affichage de l'entête
require "includes/header.php";

try{

    if(!empty($_SESSION['msg'])){

        print($_SESSION['msg']);
        unset($_SESSION['msg']);

    }


    //definition de la source de données
    $db=new PDO("mysql:host=".BDD_HOST.";dbname=".BDD_DB.";charset=utf8mb4",BDD_USER,BDD_PASS);
    // on traite les erreurs en tant qu'exceptions ( optionnel )
    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    //préparation de la requête
    $requete=$db->prepare("SELECT * FROM contacts WHERE id=?");

    // Execution de la requête
    $requete->execute(array($id));

    //récupération du premier enregistrment du résultat dans $contact
    $contact=$requete->fetch(PDO::FETCH_OBJ);

    // si le résultat est vide afficher un message et finir
    if (!$contact){
        throw new Exception("Le contact demandé n'existe pas (ou plus).");
    }




?>
    <form action="maj.php" method="post" id="editForm">
        <input type="hidden" name="id" value="<?= $contact->id ?>">
        <p>
            <label for="nom">Nom :</label>
            <input type="text" id ="nom" name="nom" value="<?=$contact->nom?>">
        <p>
        <p>
            <label for="prenom">Prénom :</label>
            <input type="text" id ="prenom" name="prenom"  value="<?=$contact->prenom?>">
        <p>
        <p>
            <label for="adresse">Adresse :</label>
            <input type="text" id ="adresse" name="adresse"  value="<?=$contact->adresse?>">
        <p>
        <p>
            <label for="cp">Code postal :</label>
            <input type="text" id ="cp" name="cp"  value="<?=$contact->cp?>">
        <p>
        <p>
            <label for="ville">Ville :</label>
            <input type="text" id ="ville" name="ville"  value="<?=$contact->ville?>">
        <p>
        <p>
            <label for="tel">Téléphone :</label>
            <input type="text" id ="tel" name="tel"  value="<?=$contact->tel?>" >
        <p>
        <p>
            <label for="email">E-mail :</label>
            <input type="text" id ="email" name="email" value="<?=$contact->email?>">
        <p>
        <p>
            <button type="submit">Enregistrer</button>
        </p>
    </form>


<?php


}
catch (PDOException $e){
    echo "Une erreur est survenue lors de la récupération des informations sur le contact.";
}
catch( Exception $e){
    echo "<p class=\"error\">".$e->getMessage()."</p>";
}