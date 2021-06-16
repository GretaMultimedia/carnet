<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="theme/main.css">
    <title>Carnet d'adresse</title>
</head>
<body>
    <header>
        <h1>Carnet d'adresse</h1>
    </header>
    <nav>
        <ul>
            <li><a href="liste.php">Liste</a></li>
            <li><a href="ajouter.php">Ajouter</a></li>
            <li>
                <form action="liste.php" method="post" id="recherche">
                    <input type="text" name="rech" placeholder="recherche">
                    <button type="submit">Rechercher</button>
                </form>
            </li>

        </ul>
    </nav>
    <main>