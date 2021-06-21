<?php
$id=filter_input(INPUT_GET,"id",FILTER_VALIDATE_INT);
if (!$id){
    header("location:liste.php");
    exit();
}

require "includes/config.inc.php";

try{

    $db=new PDO("mysql:host=".BDD_HOST.";dbname=".BDD_DB.";charset=utf8mb4",BDD_USER,BDD_PASS);
    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    $requete=$db->prepare("SELECT nom,prenom FROM contacts WHERE id=?");
    $requete->execute(array($id));

    $contact=$requete->fetch(PDO::FETCH_OBJ);

    if ( $contact==false ){
        throw new Exception("Le contact demandé n'existe pas ou plus.");
    }

    if (isset($_GET['confirm']) && $_GET["confirm"]==1){
        
        $_SESSION["msg"]="dans le if";
        $requete_suppr=$db->prepare("DELETE FROM contacts WHERE id=?");
        $requete_suppr->execute(array($id));

        $_SESSION["msg"]= "<p class=\"success\">$contact->prenom $contact->nom a bien été supprimé.</p>";
        header("location:liste.php");
        exit();

    }

    require "includes/header.php";
    echo "
    <h2>Suppression de $contact->prenom $contact->nom</h2>
        <p>êtes vous sur de vouloir supprimer $contact->prenom $contact->nom ?</p>
        <p>
            <a href=\"supprimer.php?id=$id&confirm=1\">Oui</a> - 
            <a href=\"{$_SERVER['HTTP_REFERER']}\">Non</a> 
        </p>

    ";
    require "includes/footer.php";


}
catch( PDOException $e){
    $_SESSION["msg"]= "<p class=\"error\">Une erreur est survenue lors de la suppression du contact.</p>";
    header("location:liste.php");
    exit();
}
catch( Exception $e){
    $_SESSION["msg"]="<p class=\"error\">".$e->getMessage()."</p>";
    header("location:liste.php");
    exit();
}

