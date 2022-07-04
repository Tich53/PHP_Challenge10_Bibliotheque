<?php
session_start();

require_once '../Identifiants/connec.php'; 
$pdo = new \PDO(DSN, USER, PASS);

if (isset($_POST["lastname"], $_POST["firstname"])) {
    $lastname = trim($_POST['lastname']);   
    $firstname = trim($_POST['firstname']); 


    $query = "INSERT INTO authors (lastname_author, firstname_author) VALUES (:lastname, :firstname)"; 

    $statement = $pdo->prepare($query); 
    $statement->bindValue(':lastname', $lastname, \PDO::PARAM_STR);   
    $statement->bindValue(':firstname', $firstname, \PDO::PARAM_STR);

    $statement->execute(); 
    $author =$statement->fetchAll();
    
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="creation_auteur.css">
    <title>Formulaire Auteur</title>
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
            </ul>
        </nav>
        <?php echo 'Bienvenue '. $_SESSION['login']; ?>
    </header>
    
<!-- Formulaire de création livre  -->
<section class="formulaire">
    <h1>Créer un auteur</h1>
    <form action="creation_auteur.php" method="POST"> 
        <div>
            <label class="label" for="lastname"><strong>Nom</strong></label>
            <br>
            <input class="input" type="text" id="lastname" name="lastname" required autofocus>
        </div>
        <div>
            <label class="label" for="firstname"><strong>Prénom</strong></label>
            <br>
            <input class="input"  type="text" id="firstname" name="firstname" required>
        </div>
        <button type="submit">Créer</button>
    </form>
</section>

</body>
</html>