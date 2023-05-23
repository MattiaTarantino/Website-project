<?php
session_start();

$message='';
if(isset($_SESSION['password_alert'])){
    $message='La password non è corretta :(';
}
if(isset($_SESSION['email_alert'])){
    $message="L'indirizzo email non è corretto";
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
    <title>ShopWise-LoginVenditore</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@600&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Lato:wght@700&display=swap');
        body{
            background-color: #e98635;
        }
    </style>
</head>
<body>
<div class="header">
    <a href="../index.html" class="logo"><img src="../images/ShopWise-logo-header.png"></a>
    <div class="header-right">
        <a href="register.php" >Registrati</a>
    </div>
</div>
<form class="form" action="check_login_venditore.php" method ="POST" role="login">
    <p class="form-title">Accedi a ShopWise!</p>
    <p class="signup-link">Se non sei un venditore <a href="login.php">clicca qui</a></p>
    <?php if($message != '')
        echo '<div class="message_bad">'.$message.'</div>';
    ?>

    <div class="input-container">
        <input type="text" name="venditore" id="venditore" placeholder="Inserisci venditore" autofocus required>
    </div>
    <div class="input-container">
        <input type="email" name="email" id="email"  placeholder="Inserisci email" autofocus required>
    </div>
    <div class="input-container">
        <input type="password" name="password" id="password" placeholder="Inserisci password" autofocus required>
    </div>
    <button type="submit" id="submit" class="submit">
        Accedi
    </button>

    <p class="signup-link">
        Non hai un account venditore?
        <a href="register_venditore.php">Registrati</a>
    </p>
</form>

<?php unset($_SESSION['email_alert']); ?>
<?php unset($_SESSION['password_alert']); ?>
</body>
</html>