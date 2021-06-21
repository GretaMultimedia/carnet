<?php
$id=filter_input(INPUT_GET,"id",FILTER_VALIDATE_INT);
if (!$id){
    header("location:liste.php");
    exit();
}

require "includes/config.inc.php";
require "includes/header.php";
try{

    $db=new PDO("mysql:host=".BDD_HOST.";dbname=".BDD_DB.";charset=utf8mb4",BDD_USER,BDD_PASS);
    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    $requete=$db->prepare("SELECT * FROM contacts WHERE id=?");
    $requete->execute(array($id));

    $contact=$requete->fetch(PDO::FETCH_OBJ);

    if ( $contact==false ){
        throw new Exception("Le contact demandé n'existe pas ou plus.");
    }



?>

<h2><?= $contact->prenom ?> <?= $contact->nom ?></h2>
<div id="civilite">
    <figure>
        <img src="photos/default.png" alt="">
    </figure>


    <?php if (!empty($contact->adresse) || !empty($contact->ville)) : ?>
    
    <p class="adresseBlock">
        <span class="adresse"><?= $contact->adresse ?></span><br>
        <span class="cp"><?= $contact->cp ?></span><span class="ville"><?= $contact->ville ?></span>
    </p>

    <?php endif; ?>


    <?php if (!empty($contact->tel)){ ?>
    
    <p class="telBlock">
        <span class="label">Téléphone :</span>
        <span class="numero"><?= $contact->tel ?></span>
    <p>
    
    <?php } ?>

    
    <?php if (!empty($contact->email)){ ?>

    <p class="emailBlock">
        <span class="label">E-mail :</span>
        <span class="email"><?= $contact->email ?></span>
    <p>
    
    <?php } ?>
</div>

<?php

}
catch( PDOException $e){
    echo $e->getMessage();
}
catch( Exception $e){
    echo "<p class=\"error\">".$e->getMessage()."</p>";
}


require "includes/footer.php";