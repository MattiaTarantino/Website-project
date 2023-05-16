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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
    <title>ShopWise-Logged</title>
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
            <form action="page_search_logged.php" method="get" role="search" id="idform2">
                <label for="search">Cerca</label>
                <input id="search" type="search" placeholder="&#xF002; Cerca un prodotto..." name="search-field-logged" style="font-family:Arial, FontAwesome"  required />
                <button class="vai" type="submit" form="idform2" name="submit-search-logged">Vai</button>    
            </form>
        <div class="spiegazione">
                Cerca il prodotto di tuo interesse e ShopWise ti aiuterà a trovare l'offerta migliore per te!
        </div>
    </body>
</html>

