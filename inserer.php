<?php
if (empty($_POST)){
    header("location: ajouter.php");
    exit();
}
session_start();

require "includes/config.inc.php";
try{

$nom=filter_input(INPUT_POST,'nom',FILTER_SANITIZE_STRING);
$nom=mb_strtoupper(trim($nom),"utf-8");
$prenom=filter_input(INPUT_POST,'prenom',FILTER_SANITIZE_STRING);
$prenom=mb_convert_case(trim($prenom),MB_CASE_TITLE,"utf-8");
if ( empty($nom) && empty($prenom) ){
    throw new Exception("Vous devez fournir au moins un nom ou un prénom.");
}


$adresse=filter_input(INPUT_POST,'adresse',FILTER_SANITIZE_STRING);

$ville=filter_input(INPUT_POST,'ville',FILTER_SANITIZE_STRING);
$ville=mb_strtoupper(trim($ville),"utf-8");

$cp=filter_input(INPUT_POST,'cp',FILTER_SANITIZE_STRING);

$tel=filter_input(INPUT_POST,'tel',FILTER_SANITIZE_STRING);

$email=filter_input(INPUT_POST,'email',FILTER_VALIDATE_EMAIL);
if ($email===false && !empty($_POST['email'])){
    throw new Exception("L'email fourni n'est pas valide.");     

}




    //definition de notre connexion
    $cnx=new PDO("mysql:host=".BDD_HOST.";dbname=".BDD_DB.";charset=utf8mb4" ,BDD_USER , BDD_PASS);
    $cnx->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    /*
    $requete=$cnx->prepare("INSERT INTO contacts values (NULL,:nom,:prenom,:adresse,:cp,:ville,:tel,:email)");

    
    $newContact=array(
        ':nom'=>$nom,
        ':prenom'=>$prenom,
        ':adresse'=>$adresse,
        ':cp'=>$cp,
        ':ville'=>$ville,
        ':tel'=>$tel,
        ':email'=>$email
    );

    $requete->execute($newContact);
   */

    $requete=$cnx->prepare("INSERT INTO contacts values (NULL,?,?,?,?,?,?,?)");
    $requete->execute(array($nom,$prenom,$adresse,$cp,$ville,$tel,$email));

    $_SESSION["msg"]="<p class=\"success\">$nom $prenom a bien été ajouté à vos contacts.</p>";

}
catch(PDOException $e){

    $_SESSION["msg"]="<p class=\"error\">Une erreur est survenue lors de l'insertion.<br>Veuillez ré-essayer plus tard</p>";
    $_SESSION["postdata"]=$_POST;
}
catch(Exception $e){
    $_SESSION["msg"]="<p class=\"error\">".$e->getMessage()."</p>";
    $_SESSION["postdata"]=$_POST;
}

header("location: ajouter.php");
exit();
