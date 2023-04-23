<?php

include 'config.php';
session_start();
$id_utente = $_SESSION['id_utente'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>update profile</title>
    <link rel="stylesheet" href="../css/account.css">
    <style>
        .update-profile{
            margin-top: 40px;
        }
    </style>
</head>
<body>
<div class="header">
    <a href="" class="logo"><img src="../images/ShopWise-logo-header.png"></a>
    <div class="header-right">
        <a href="aggiorna_account_venditore.php" class="account">Account</a>
    </div>
</div>

<div class="update-profile">
    <form action="" method="post" enctype="multipart/form-data">
        <h1>Inserisci un prodotto su ShopWise!</h1>
        <div class="flex">
            <div class="inputBox">
                <span>Categoria :</span>
                <select name="categoria" id="categoria" class="box" required>
                    <option></option>
                    <option value="cuffie"> Cuffie </option>
                    <option value="laptop"> Laptop </option>
                    <option value="smartwatch"> Smartwatch </option>
                    <option value="tablet"> Tablet </option>
                    <option value="telefono"> Telefono</option>
                </select>
                <span>Codice :</span>
                <input type="text" name="codice_prodotto" class="box" required>
                <span>Prezzo :</span>
                <input type="text" name="prezzo_prodotto" class="box" required>
                <span>Grandezza schermo :</span>
                <input type="text" name="schermo_prodotto" placeholder="Opzionale" class="box">
                <span>Ram :</span>
                <input type="text" name="ram_prodotto" placeholder="Opzionale" class="box">
                <span>CPU :</span>
                <input type="text" name="cpu_prodotto" placeholder="Opzionale" class="box">
            </div>
            <div class="inputBox">
                <span>Nome del prodotto :</span>
                <input type="text" name="nome_prodotto"  class="box" required>
                <span>Marca :</span>
                <input type="text" name="marca_prodotto" class="box" required>
                <span>Immagine prodotto :</span>
                <input type="file" name="foto_prodotto"  class="box" required>
                <span>Spazio di archiviazione :</span>
                <input type="text" name="spazio_prodotto" placeholder="Opzionale" class="box">
                <span>GPU :</span>
                <input type="text" name="gpu_prodotto" placeholder="Opzionale" class="box">
                <span>Batteria :</span>
                <input type="text" name="batteria_prodotto" placeholder="Opzionale" class="box">
            </div>
        </div>
        <input type="submit" value="Inserisci prodotto" name="update_profile" class="btn">
    </form>
</div>
</body>
</html>