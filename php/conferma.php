<?php
session_start();
require_once('config.php');

if (isset($_POST['reservation-button'])) {
    $id_prodotto = mysqli_real_escape_string($connessione, $_POST['reservation-item-id']);
}

$id_utente = $_SESSION['id_utente'];

$sql_insert = "INSERT INTO prenotazioni(id_utente, id_prodotto) VALUES ('$id_utente', '$id_prodotto')";
$result = mysqli_query($connessione, $sql_insert);
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="../css/conferma.css" >
    <title>Conferma</title>
</head>
<body>
    <div class="header">
        <a href="logged.php" class="logo"><img src="../images/ShopWise-logo-header.png"></a>
    </div>
    <div class="d-flex">
        <div class="container">
            <div class="mb-4 text-center">
                <img src="../images/confirmation.png">
            </div>
            <div class="text-center">
                <h3>Prenotazione Effettuata!</h3>
                <p>Grazie per aver effettuato la tua prenotazione su ShopwWise!</p>
                <a href="prodotti_utente.php" class="btn">Le tue prenotazioni</a>
            </div>
        </div>
    </div>
</body>
</html>