<?php
require_once('config.php');

$nome = $connessione->real_escape_string($_POST['nome']);
$cognome = $connessione->real_escape_string($_POST['cognome']);
$email = $connessione->real_escape_string($_POST['email']);
$password = $connessione->real_escape_string($_POST['password']);
$hashed_password= password_hash($password, PASSWORD_DEFAULT);
$indirizzo = $connessione->real_escape_string($_POST['indirizzo']);

$sql = "INSERT INTO utenti(nome, cognome, email, password, indirizzo) VALUES ('$nome','$cognome','$email','$hashed_password','$indirizzo')";
?>

<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../css/style.css">
        <title>ShopWise</title>
        <style>
        .account{
            margin-right: 26px;
            }
        </style>
    </head>
    <body>
        <div class="header">
            <a href="#top" class="logo"><img src="../images/ShopWise-logo-header.png"></a>
            <div class="header-right">
                <a href="account.php" class="account">Account</a>
            </div>
        </div>
        <img class="logo-homepage" src="../images/ShopWise logo.png">
            <form action="search.php" method="post" role="search">
                <label for="search">Cerca</label>
                <input id="search" type="search" placeholder="Cerca un prodotto..." autofocus required />
                <button class="vai" type="submit">Vai</button>    
            </form>
        <div class="spiegazione">
            
                <?php if ($connessione->query($sql) === true ){ echo "Registrazione effettuata con successo " . $nome . "!"; }
                        else{ echo "Errore durante la registrazione utente $sql. " . $connessione->error;} ?>
                <br>
                Cerca il prodotto di tuo interesse e ShopWise ti aiuterà a trovare l'offerta migliore per te!
        </div>
    </body>
</html>