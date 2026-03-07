<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}
include_once "connexion.php";
?>
<!DOCTYPE html>
<html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="">
    <title>Document</title>
</head>

<body>
    <?php include_once "header.php"; ?>
    <style>
        body{
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            
        }
        footer {
            color: aquamarine;
            background-color: rgb(104, 50, 166);
            text-align: center;
            padding: 15px;
            color: white;
            margin-top: auto;
           
        }

        body {
            background-color: rgb(175, 146, 209);
        }
    </style>
    <footer>
        © 2026 BARAKA BAPINI bienfait. Tous droits réservés.
    </footer>

</body>

</html>