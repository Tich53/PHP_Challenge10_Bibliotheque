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
    <link rel="stylesheet" href="modification_auteur.css">
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
        <h1>Modifier / Supprimer un auteur</h1>
        <form action="modification_auteur.php" method="POST">
            <label for="id-number">Saisissez le numéro de l'auteur à modifier ou à supprimer</label>
            <input type="text" id="id-number" name="id-number">
            <button type="submit" >Sélectionner</button>
        </form>
        <?php

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $authorId = trim($_POST['id-number']);

            $query = "SELECT * FROM authors WHERE id = $authorId";

            $statement = $pdo -> prepare($query);
            $statement -> execute();
            $author = $statement->fetchAll();

            $lastname = $author[0]['lastname_author'];
            $firstname = $author[0]['firstname_author']; 
        ?>
            
            <form action="modification_auteur.php" method="POST">
                <input type="hidden" name="id-number" value="<?php echo $authorId; ?>"/>
                <div class="div_modify">
                    <label for="modify-lastname"><strong> Modifier le nom : </strong><?php echo $lastname ?></label>
                    <br>
                    <input type="text" id="modify-lastname" name="modify-lastname" value= <?php echo $lastname?> required autofocus>
                </div>
                <div class="div_modify">
                    <label for="modify-firstname"><strong>Nouveau prénom: </strong><?php echo $firstname?></label>
                    <br>
                    <input type="text" id="modify-firstname" name="modify-firstname" value= <?php echo $firstname ?>  required>
                </div>
                <button class="modify" type="submit">Modifier</button>
            </form>


            <form action="modification_auteur.php" method="POST">
                <input type="hidden" name="id-number" value="<?php echo $authorId; ?>"/>
                <button class="delete" type="submit" name="delete">Supprimer</button>
            </form>
      
        <?php
        }

        // Modification 
        if (isset($_POST["modify-lastname"], $_POST["modify-firstname"])) {
            $modifyLastname = trim($_POST['modify-lastname']);
            $modifyFirstname = trim($_POST['modify-firstname']);

            $updateQuery = "UPDATE authors SET lastname_author = :modifyLastname, firstname_author = :modifyFirstname WHERE id = :id";
            
            $statement = $pdo->prepare($updateQuery); 
            $statement->bindValue(':modifyLastname', $modifyLastname, \PDO::PARAM_STR);   
            $statement->bindValue(':modifyFirstname', $modifyFirstname, \PDO::PARAM_STR);
            $statement->bindValue(':id', $_POST['id-number'], \PDO::PARAM_INT);
        
            $statement->execute(); 
        ?><div class="maj"><?php echo "Mise à jour effectuée !";?></div>
        <?php
        }

        // Suppression
        if (isset($_POST['delete'])) {
            $deleteQuery = "DELETE FROM authors WHERE id = $authorId";

            $statement = $pdo -> prepare($deleteQuery);
            $statement -> execute();
            //deleteAuthor = $statement->fetchAll();
        }
        ?>

        <?php 
        
            //création de la requête pour récupérer les données
            $query = "SELECT * FROM authors";
            //envoi de la requête
            $statement = $pdo->prepare($query);
            $statement->execute();
            $authorsList = $statement->fetchAll();
            echo '<br>';

        ?>
        <div class = "authorsList">
        <?php
            foreach($authorsList as $author){
         
            echo $author['id'] . ' ' .$author['lastname_author'].' '.$author['firstname_author'];
            echo '<br>';
            }
        ?>
        </div> 

    </section>
</body>
</html>