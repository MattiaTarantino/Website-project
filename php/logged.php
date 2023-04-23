<?php
session_start();
?>
<html lang="it">
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
            <a href="" class="logo"><img src="../images/ShopWise-logo-header.png"></a>
            <div class="header-right">
                <a href="aggiorna_account.php" class="account">Account</a>
            </div>
        </div>
        <img class="logo-homepage" src="../images/ShopWise logo.png">
            <form onsubmit="event.preventDefault();" role="search">
                <label for="search">Cerca</label>
                <input id="search" type="search" placeholder="Cerca un prodotto..." autofocus required />
                <button class="vai" type="submit">Vai</button>    
            </form>
        <div class="spiegazione">
                Cerca il prodotto di tuo interesse e ShopWise ti aiuterà a trovare l'offerta migliore per te!
        </div>
    </body>
</html>

