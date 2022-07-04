<?php
session_start();

if($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $_SESSION['login'] = trim($_POST['username']);
    header('location: index.php');
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="login.php" method="POST">
        <label for="username">Nom d'utilisateur</label>
        <br>
        <input type="text" id="username" name="username">
        <br>
        <button type="submit">Se connecter</button>
    </form>
    
</body>
</html>