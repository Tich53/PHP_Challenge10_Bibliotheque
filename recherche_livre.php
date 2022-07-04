<?php
require_once '/home/richubuntu/Info.prog/Projets/Projet-bibliotheque/Identifiants/connec.php'; 
$pdo = new \PDO(DSN, USER, PASS);

$query = "SELECT books.*, lastname_author, firstname_author FROM books JOIN authors ON books.author_id=authors.id";
$statement = $pdo->query($query);
$books = $statement->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="recherche_livre.css">
    <title>Rechercher un livre</title>
</head>
<body>

<header>
        <nav>
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="recherche_livre.php">Liste des livres</a></li>
                <li><a href="creation_auteur.php">Créer un auteur</a></li>
                <li><a href="creation_livre.php">Ajouter un livre</a></li>
                <li><a href="modification_auteur.php">Modifier / supprimer un auteur</a></li>
                <li><a href="modification_livre.php">Modifier / supprimer un livre</a></li>
                <li><a href="cart.php">Liste panier</a></li>
                <li><a href="logout.php">Se déconnecter</a></li>
            </ul>
        </nav>
</header>

<h1>Liste des livres</h1>
<form action="recherche_livre.php" method="POST">
    <div class="button">
        <button id="button" type="submit">Rechercher</button>
    </div>
</form>

<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo '<br>';
?>
    <div class="liste">
<?php
    foreach ($books as $book) {

?>

        <div class="conteneur_bibliotheque">
            <div class="picture" style ="background-image:url('<?php echo $book['book_picture']?>')"></div> 
            <div class="information1"><strong><?= "ISBN: "?></strong><?= $book['isbn'];?></div>
            <div class="information"><strong><?= "Titre: "?></strong><?= $book['title'];?></div>
            <div class="information"><strong><?= "Année : "?></strong><?=$book['book_date'];?></div>
            <div class="information"><strong><?= "Edition: "?></strong><?=$book['book_editing'];?></div>
            <div class="information"><strong><?= "Nom auteur: "?></strong><?=$book['lastname_author'];?></div>
            <div class="information"><strong><?= "Prénom auteur: "?></strong><?=$book['firstname_author'];?></div>
            <form action="cart.php" method="POST">
                <input type="hidden" name="id" value="<?php echo $book['id']?>">
                <input type="hidden" name="book_picture" value="<?php echo $book['book_picture']?>">
                <input type="hidden" name="isbn" value="<?php echo $book['isbn']?>">
                <input type="hidden" name="title" value="<?php echo $book['title']?>">
                <input type="hidden" name="book_date" value="<?php echo $book['book_date']?>">
                <input type="hidden" name="book_editing" value="<?php echo $book['book_editing']?>">
                <input type="hidden" name="lastname_author" value="<?php echo $book['lastname_author']?>">
                <input type="hidden" name="firstname_author" value="<?php echo $book['firstname_author']?>">
                <button type="submit">Ajouter au panier</button>
            </form>
        </div>
       
    <?php 
}
?>
</div>
<?php
}

?>

    
</body>
</html>