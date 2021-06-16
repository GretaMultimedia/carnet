<?php
    require "includes/config.inc.php";
    require "includes/header.php";

    echo "<h2>Contacts</h2>";

    try{

        $cnx=new PDO("mysql:host=".BDD_HOST.";dbname=".BDD_DB.";charset=utf8mb4", BDD_USER, BDD_PASS);
        $cnx->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

        $requete=$cnx->prepare("SELECT id,nom,prenom FROM contacts order by nom,prenom");
        $requete->execute();

        $resultat=$requete->fetchAll(PDO::FETCH_ASSOC);


        foreach ($resultat as $contact){
            echo "<p>{$contact['id']} {$contact['nom']} {$contact['prenom']}</p>";
        }
        
    }
    catch(PDOException $e){

        echo "Une erreur est survenue lors de la récupération de la liste des contacts.";

    }








    require "includes/footer.php";