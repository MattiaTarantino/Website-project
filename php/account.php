<?php
session_start();
if(!isset($_SESSION['loggato']) || $_SESSION['loggato'] !== true){
    header("location: login.php");
    exit;
}
?>

<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../style.css">
        <title>ShopWise - Account</title>
    </head>
    <body>
        <div class="header">
            <a href="registrato.php" class="logo"><img src="../images/ShopWise-logo-header.png"></a>
        </div>
        <div class="dati_account">
                <?php echo 'Nome : '. $_SESSION['nome'] ?>
                <?php echo 'Cognome : '. $_SESSION['cognome'] ?>
                <?php echo 'Email : '. $_SESSION['email'] ?>
                <?php echo 'Indirizzo : '. $_SESSION['indirizzo'] ?>
        </div>
        <br>
        <a href="logout.php">Logout</a>
    </body>
</html>