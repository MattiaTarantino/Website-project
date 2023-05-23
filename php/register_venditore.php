<?php
session_start();

$message='';
if(isset($_SESSION['email_alert'])){
    $message='Indirizzo email già esistente';
}
?>

<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../css/registrazione.css">
        <link rel="stylesheet" href="../css/login.css">
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.css" />
        <title>ShopWise-RegistrazioneVenditore</title>
        <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700;900&display=swap");
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@600&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Lato:wght@700&display=swap');
        body {
            background-color: #e98635;
        }
        </style>
    </head>
    <body>
        <div class="header">
            <a href="../index.html" class="logo"><img src="../images/ShopWise-logo-header.png"></a>
            <div class="header-right">
                <a href="login_venditore.php" >Accedi</a>
            </div>
        </div>
        <form class="form" action="check_registration.php" method ="POST" role="login">
            <p class="form-title">Registrati a ShopWise!</p>
            <p class="signup-link">Se non sei un venditore <a href="register.php">clicca qui</a></p>
            <?php if($message != '')
                echo '<div class="message_bad">'.$message.'</div>';
            ?>
            <div class="input-container">
                <input type="text" name="venditore" placeholder="Venditore" autofocus required>
            </div>
            <div class="input-container">
                <input type="text" name="nome" placeholder="Nome" autofocus required>
            </div>
            <div class="input-container">
                <input type="text" name="cognome" placeholder="Cognome" required>
            </div>
            <div class="input-container">
                <input type="text" name="indirizzo" placeholder="Indirizzo" required>
            </div>
            <div class="input-container">
                <input type="email" name="email" placeholder="Indirizzo e-mail" required>
            </div>
            <div class="input-container">
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <button type="submit" id="submit" class="submit">
                Registrati
            </button>

            <p class="signup-link">
                Hai già un account venditore?
                <a href="login_venditore.php">Accedi</a>
            </p>
        </form>
    <?php unset($_SESSION['email_alert']); ?>
    </body>
</html>

