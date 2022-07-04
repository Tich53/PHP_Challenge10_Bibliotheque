<?php
session_start();

require_once '../Identifiants/connec.php'; 
$pdo = new \PDO(DSN, USER, PASS);

//création de la requête pour afficher le formulaire de modification

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="modification_livre.css">
    <title>Modifier un auteur</title>
</head>
<body>
    <header class="hero">
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
    <section>
    <h1>Modifier ou supprimer un livre</h1>
        <form action="modification_livre.php" method="POST">
            <input type="hidden" name="action" value="search"/>
            <label for="bookId">Choisissez le numéro du livre à modifier ou à supprimer</label>
            <input type="text" id="bookId" name="bookId">
            <button type="submit" >Sélectionner</button>
        </form>
    
    <?php

     // Modification livre
    if (isset($_POST['action']) && $_POST['action'] === 'edit') {
        $modifyIsbn = trim($_POST['modify-isbn']);
        $modifyTitle = trim($_POST['modify-title']);
        $modifyBook_date = trim($_POST['modifyBook_date']);
        $modifyBook_editing = trim($_POST['modify-book_editing']);
        $modifyBook_picture = trim($_POST['modify-book_picture']);
        $modifyAuthor_id = trim($_POST['book_author']); 


        $updateQuery = "UPDATE books SET isbn = :modifyIsbn, title = :modifyTitle, book_date = :modifyBook_date, book_editing = :modifyBook_editing, book_picture = :modifyBook_picture, author_id = :modifyAuthor_id WHERE books.id = :id";

        
        $statement = $pdo->prepare($updateQuery); 
        $statement->bindValue(':modifyIsbn', $modifyIsbn, \PDO::PARAM_STR);   
        $statement->bindValue(':modifyTitle', $modifyTitle, \PDO::PARAM_STR);
        $statement->bindValue(':modifyBook_date', $modifyBook_date, \PDO::PARAM_STR);
        $statement->bindValue(':modifyBook_editing', $modifyBook_editing, \PDO::PARAM_STR);
        $statement->bindValue(':modifyBook_picture', $modifyBook_picture, \PDO::PARAM_STR);
        $statement->bindValue(':modifyAuthor_id', $modifyAuthor_id, \PDO::PARAM_INT);

        $statement->bindValue(':id', $_POST['bookId'], \PDO::PARAM_INT);
        $statement->execute(); 
        echo "Mise à jour effectuée !";
    }

    // Suppression
    if (isset($_POST['delete'])) {
        $bookId = trim($_POST['bookId']);
        $deleteQuery = "DELETE FROM books WHERE id = $bookId";
        $statement = $pdo -> prepare($deleteQuery);
        $statement -> execute();
    }


    // Requête de sélection livre
    if (isset($_POST['bookId'])) {
        $bookId = trim($_POST['bookId']);


        $query = "SELECT books.*, authors.id, authors.lastname_author, authors.firstname_author FROM books JOIN authors ON books.author_id=authors.id WHERE books.id = $bookId";

        $statement = $pdo -> prepare($query);
        $statement -> execute();
        $book = $statement->fetchAll();

        if (count($book)) {
            $id = $book[0]['id'];
            $isbn = $book[0]['isbn'];
            $title = $book[0]['title'];
            $book_date = $book[0]['book_date'];
            $book_editing = $book[0]['book_editing'];
            $book_picture = $book[0]['book_picture'];
            $author_id = $book[0]['author_id'];
            $author_lastname = $book[0]['lastname_author'];
            $author_firstname = $book[0]['firstname_author']; ?>

            <form action="modification_livre.php" method="POST">
                <input type="hidden" name="bookId" value="<?php echo $bookId; ?>"/>
                <input type="hidden" name="action" value="edit"/>
                <div>
                    <label for="modify-isbn"><strong>Modifier l'ISBN : </strong><?php echo $isbn ?></label>
                    <br>
                    <input type="text" id="modify-isbn" name="modify-isbn" value= <?php echo $isbn?> required autofocus>
                </div>
                <div>
                    <label for="modify-title"><strong>Modifier le titre : </strong><?php echo $title ?></label>
                    <br>
                    <input type="text" id="modify-title" name="modify-title" value= <?php echo $title?> required>
                </div>
                <div>
                    <label for="modify-book_date"><strong>Modifier la date : </strong><?php echo $book_date ?></label>
                    <br>
                    <input type="text" id="modify-book_date" name="modifyBook_date" value= <?php echo $book_date?> required>
                </div>
                <div>
                    <label for="modify-book_editing"><strong>Modifier l'édition : </strong><?php echo $book_editing ?></label>
                    <br>
                    <input type="text" id="modify-book_editing" name="modify-book_editing" value= <?php echo $book_editing?> required>
                </div>
                <div>
                    <label for="modify-book_picture"><strong>Modifier l'URL de l'image : </strong><?php echo $book_picture ?></label>
                    <br>
                    <input type="text" id="modify-book_picture" name="modify-book_picture" value= <?php echo $book_picture?> required>
                </div>
                <div>
                    <label for="book_author"><strong>Auteur :</strong></label>
                    <br>
                    <select name="book_author" id="book_author">
                        <?php $result = $pdo->query('SELECT id, lastname_author, firstname_author FROM authors ORDER BY lastname_author');
                    while ($data = $result->fetch()) { ?>
                        <option value="<?php echo $data['id'];?>" <?php if ($data['id'] === $author_id) {
                        echo "selected";
                        }?>>
                        <?php echo $data['lastname_author']. ' '. $data['firstname_author']; ?>
                        </option>
                    <?php } ?>
                    </select>
                    <br>
                    <a href="creation_auteur.php"><input class="button" type="button" value="Créer un auteur"> </a>
                </div> 
                <button class="modify" type="submit">Modifier</button>
        </form>
        
            <!-- Formulaire bouton suppression -->
            <form action="modification_livre.php" method="POST">
                    <input type="hidden" name="bookId" value="<?php echo $bookId; ?>"/>
                    <button class="delete" type="submit" name="delete">Supprimer</button>
            </form>

    <?php

        } else {
            echo "Livre indisponible.";
        }

    }
    //création de la requête pour récupérer les données
    $query = "SELECT books.*, authors.lastname_author, authors.firstname_author FROM books JOIN authors ON books.author_id =authors.id";
    //envoi de la requête
    $statement = $pdo->prepare($query);
    $statement->execute();
    $booksList = $statement->fetchAll();
    echo '<br>';
    ?>
    <div class="booksList">
    <?php
    foreach ($booksList as $book) {
         echo 'ID : '.$book['id'].' Titre: '.$book['title']. ' Edition: ' .$book['book_editing'].' Auteur: '.$book['lastname_author'].' '.$book['firstname_author'];
        echo '<br>';
    }
    ?>
    </div>
    
</section>
</body>
</html>