<?php
session_start();

require_once '../Identifiants/connec.php'; 
$pdo = new \PDO(DSN, USER, PASS);

    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        $book_picture = $_POST['book_picture'];
        $isbn = $_POST['isbn'];
        $title = $_POST['title'];
        $book_date = $_POST['book_date'];
        $book_editing = $_POST['book_editing'];
        $lastname_author = $_POST['lastname_author'];
        $firstname_author = $_POST['firstname_author'];

        $cartQuery = "SELECT * FROM books JOIN authors ON books.author_id=authors.id WHERE books.id=$id";
        $statement = $pdo->query($cartQuery);
        $cart = $statement->fetchAll();

        if (empty($_SESSION['cart'])) {
            $_SESSION['cart']=array();
            array_push($_SESSION['cart'], $cart[0]);
        } else {
            array_push($_SESSION['cart'], $cart[0]);
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="cart.css">
        <title>Panier</title>
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
    <?php echo 'Bienvenue '. $_SESSION['login'];?>

</header>

<section>
        <?php 
        if (empty($_SESSION['cart'])) {
            echo "Le panier est vide";
        } else {
            ?>
            <div class="liste">
            <?php
            foreach ($_SESSION['cart'] as $session) {
                ?>
            <div class="conteneur_bibliotheque">
                    <div class="picture" style ="background-image:url('<?= $session['book_picture']?>')"></div> 
                    <div class="information1"><strong><?= "ISBN: "?></strong><?= $session['isbn']; ?></div>
                    <div class="information"><strong><?= "Titre: "?></strong><?= $session['title']; ?></div>
                    <div class="information"><strong><?= "Année : "?></strong><?=$session['book_date']; ?></div>
                    <div class="information"><strong><?= "Edition: "?></strong><?=$session['book_editing']; ?></div>
                    <div class="information"><strong><?= "Nom auteur: "?></strong><?=$session['lastname_author']; ?></div>
                    <div class="information"><strong><?= "Prénom auteur: "?></strong><?=$session['firstname_author']; ?></div>
        <?php
            }
            ?>
            </div>
            <?php
        }
        ?>
</section>


<?php 

?>


        
</body>
</html>


