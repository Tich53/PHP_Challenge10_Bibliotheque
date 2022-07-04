<?php
session_start();

require_once '../Identifiants/connec.php'; 
$pdo = new \PDO(DSN, USER, PASS);

if (isset($_POST["isbn"], $_POST["title"], $_POST["book_date"], $_POST["book_editing"], $_POST["book_author"])) { 
    $isbn = trim($_POST['isbn']);   
    $title = trim($_POST['title']); 
    $book_date = trim($_POST['book_date']);   
    $book_editing = trim($_POST['book_editing']); 
    $book_author = trim($_POST['book_author']);   
    $book_picture = trim($_POST['book_picture']);

    $errors = "";
    if (mb_strlen($book_date) !=4){
        echo $errors = "Année de sortie: vous devez saisir 4 chiffres";
    } else {
        $query = "INSERT INTO books (isbn, title, book_date, book_editing, book_picture, author_id) 
        VALUES (:isbn, :title, :book_date, :book_editing, :book_picture, :book_author)";
    

        $statement = $pdo->prepare($query);
        $statement->bindValue(':isbn', $isbn, \PDO::PARAM_INT);
        $statement->bindValue(':title', $title, \PDO::PARAM_STR);
        $statement->bindValue(':book_date', $book_date, \PDO::PARAM_STR);
        $statement->bindValue(':book_editing', $book_editing, \PDO::PARAM_STR);
        $statement->bindValue(':book_author', $book_author, \PDO::PARAM_STR);
        $statement->bindValue(':book_picture', $book_picture, \PDO::PARAM_STR);

        $statement->execute();
        $books = $statement->fetchAll();
    }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="creation_livre.css">
    <title>Formulaire livre</title>
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
    <?php echo 'Bienvenue '. $_SESSION['login']; ?>
</header>

<!-- Formulaire de création livre  -->
<section class="formulaire">
    <h1>Ajouter un livre</h1>
    <form action="creation_livre.php" method="POST"> 
        <div>
            <label for="isbn"><strong>ISBN</strong></label>
            <br>
            <input class="input" type="text" id="isbn" name="isbn" required autofocus>
        </div>
        <div>
            <label for="title"><strong>Titre</strong></label>
            <br>
            <input class="input" type="text" id="title" name="title" required>
        </div>
        <div>
            <label for="book_date"><strong>Année de sortie</strong></label>
            <br>
            <input class="input" type="text" id="book_date" name="book_date" required>
        </div>
        <div>
            <label for="book_editing"><strong>Edition</strong></label>
            <br>
            <input class="input" type="text" id="book_editing" name="book_editing" required>
        </div>
        <div>
            <label for="book_author"><strong>Auteur</strong></label>
            <br>
            <select name="book_author" id="book_author">
                <?php $result = $pdo->query('SELECT id, lastname_author, firstname_author FROM authors ORDER BY lastname_author');
                    while ($data = $result->fetch()) { ?>
                        <option value="<?php echo $data['id']; ?>">
                            <?php echo $data['lastname_author']. ' '. $data['firstname_author']; ?>
                        </option>
                        <?php } ?>
            </select>
        </div> 
            <br>
            <a href="creation_auteur.php"><input class="button" type="button" value="Créer un auteur"></a>
            <br>
            <label for="book_picture"><strong>URL image</strong></label>
            <br>
            <input class="input" type="text" id="book_picture" name="book_picture">
            <br>
        <button type="submit">Ajouter</button>
    </form>
</section>

</body>
</html>