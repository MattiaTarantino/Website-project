<?php
session_start();
require_once('config.php');

$id_prodotto = "";
foreach ($_POST as $index => $var) {
    $id_prodotto .= $var;
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShopWise-PrenotazioneArticolo</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="../css/prenotazione.css">
</head>
<body>
    <div class="header">
        <a href="logged.php" class="logo"><img src="../images/ShopWise-logo-header.png"></a>
        <div class="header-right">
            <a href="aggiorna_account.php" class="account">Account</a>
        </div>
    </div>
    <div class="item-reservation">
        <?php 
        $query = "SELECT * FROM prodotti WHERE id_prodotto = '$id_prodotto'";
        $result = mysqli_query($connessione, $query);
        if (mysqli_num_rows($result) > 0) {
            $prodotto = $result->fetch_array(MYSQLI_ASSOC);
        }
        ?>
        <form action="conferma.php" method="post">
        <div class="text-center">
                    <h3>Rivedi le informazioni e completa l'ordine!</h3>
                </div>
            <div class="flex">
                <div class="inputBox">
                    <span>Nome e Cognome :</span>
                    <input type="text" class="box" name="reservation-name-surname" value="<?php echo $_SESSION['nome'] . " " . $_SESSION['cognome']; ?>"> 
                    <span>Email :</span>
                    <input type="text" class="box" name="reservation-mail" value="<?php echo $_SESSION['email']; ?>">
                    <span>Indirizzo :</span>
                    <input type="text" class="box" name="reservation-address" value="<?php echo $_SESSION['indirizzo']; ?>">           
                </div>
                <div class="inputBox">
                    <span>Prodotto :</span>
                    <input type="text" class="box" name="reservation-item" value="<?php echo $prodotto['nome']; ?>">
                    <input type="hidden" name="reservation-item-id" value="<?php echo $prodotto['id_prodotto']; ?>">
                    <span>Venditore :</span>
                    <input type="text" class="box" name="reservation-seller" value="<?php echo $prodotto['venditore']; ?>">
                    <span>Prezzo :</span>
                    <input type="text" class="box" name="reservation-price" value="<?php echo $prodotto['prezzo']; ?>">
                </div>
            </div>
            <input type="submit" value="Prenota" name="reservation-button" class="btn">
            <a href="page_search_logged.php" class="btn" name="go-back-button">Torna a sfoglia</a>
        </form>
    </div>
</body>
</html>