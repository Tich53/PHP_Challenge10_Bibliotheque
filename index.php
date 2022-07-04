<?php
session_start();

require_once '../Identifiants/connec.php'; 
$pdo = new \PDO(DSN, USER, PASS);

$bookList = 'SELECT books.*, lastname_author, firstname_author FROM books JOIN authors ON books.author_id=authors.id';
$statement = $pdo->query($bookList);
$books = $statement->fetchAll();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">
    <title>Bibliothèque Donkey School</title>
</head>
<body>

    <header class="hero">
        <h1>Bibliothèque Donkey</h1>
            <nav>
                <img src="/Images/shrek.png" alt="">
                <?php
                if (empty($_SESSION['login'])) 
                {
                ?>
                    <ul>
                        <li><a href="login.php">Login</a></li>
                        <li><a href="login.php">Se déconnecter</a></li>
                        <li><a href="index.php">Accueil</a></li>
                        <li><a href="login.php">Liste des livres</a></li>
                        <li><a href="login.php">Créer un auteur</a></li>
                        <li><a href="login.php">Ajouter un livre</a></li>
                        <li><a href="login.php">Modifier / supprimer un auteur</a></li>
                        <li><a href="login.php">Modifier / supprimer un livre</a></li>
                        <li><a href="login.php">Liste panier</a></li>



                <?php
                } else {
                    echo 'Bienvenue '. $_SESSION['login'];
                ?>
                    <ul>
                        <li><a href="login.php">Login</a></li>
                        <li><a href="logout.php">Se déconnecter</a></li>
                        <li><a href="index.php">Accueil</a></li>
                        <li><a href="recherche_livre.php">Liste des livres</a></li>
                        <li><a href="creation_auteur.php">Créer un auteur</a></li>
                        <li><a href="creation_livre.php">Ajouter un livre</a></li>
                        <li><a href="modification_auteur.php">Modifier / supprimer un auteur</a></li>
                        <li><a href="modification_livre.php">Modifier / supprimer un livre</a></li>
                        <li><a href="cart.php">Liste panier</a></li>
                    </ul>
                <?php
                }
                ?>
            </nav>
    </header>
   
 
</body>
</html>