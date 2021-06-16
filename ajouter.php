<?php
require "includes/header.php";
session_start();



?>

    <h2>Ajouter un contact</h2>
<?php

    if (!empty ($_SESSION['msg'])){

        print($_SESSION['msg']);
        unset($_SESSION['msg']);
    }

    
    
    $nom=$prenom=$adresse=$cp=$ville=$email=$tel="";

    if (! empty($_SESSION['postdata'])){
        $nom=$_SESSION['postdata']['nom'];
        $prenom=$_SESSION['postdata']['prenom'];
        $adresse=$_SESSION['postdata']['adresse'];
        $cp=$_SESSION['postdata']['cp'];
        $ville=$_SESSION['postdata']['ville'];
        $email=$_SESSION['postdata']['email'];
        $tel=$_SESSION['postdata']['tel'];

        unset($_SESSION['postdata']);
    }



?>
    <form action="inserer.php" method="post" id="ajoutForm">
        <p>
            <label for="nom">Nom :</label>
            <input type="text" id ="nom" name="nom" value="<?=$nom?>">
        <p>
        <p>
            <label for="prenom">Prénom :</label>
            <input type="text" id ="prenom" name="prenom"  value="<?=$prenom?>">
        <p>
        <p>
            <label for="adresse">Adresse :</label>
            <input type="text" id ="adresse" name="adresse"  value="<?=$adresse?>">
        <p>
        <p>
            <label for="cp">Code postal :</label>
            <input type="text" id ="cp" name="cp"  value="<?=$cp?>">
        <p>
        <p>
            <label for="ville">Ville :</label>
            <input type="text" id ="ville" name="ville"  value="<?=$ville?>">
        <p>
        <p>
            <label for="tel">Téléphone :</label>
            <input type="text" id ="tel" name="tel"  value="<?=$tel?>" >
        <p>
        <p>
            <label for="email">E-mail :</label>
            <input type="text" id ="email" name="email" value="<?=$email?>">
        <p>
        <p>
            <button type="submit">Ajouter</button>
        </p>
    </form>

<?php require "includes/footer.php" ?>