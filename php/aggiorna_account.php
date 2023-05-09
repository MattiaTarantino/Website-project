<?php

require_once('config.php');
session_start();
$id_utente = $_SESSION['id_utente'];

if (isset($connessione)) {
    $select = mysqli_query($connessione, "SELECT * FROM `utenti` WHERE id_utente = '$id_utente'") or die('query failed');

    if (mysqli_num_rows($select) > 0) {
        $old = mysqli_fetch_assoc($select);

        $old_name = $old['nome'];
        $old_cognome = $old['cognome'];
        $old_email = $old['email'];
        $old_indirizzo = $old['indirizzo'];
        $crypted_old_password = $old['password'];
    }

    if (isset($_POST['update_profile'])) {
        $update_name = mysqli_real_escape_string($connessione, $_POST['update_name']);
        $update_cognome = mysqli_real_escape_string($connessione, $_POST['update_cognome']);
        $update_email = mysqli_real_escape_string($connessione, $_POST['update_email']);
        $update_indirizzo = mysqli_real_escape_string($connessione, $_POST['update_indirizzo']);

        $res = mysqli_query($connessione, "SELECT * FROM utenti WHERE id_utente='$id_utente'");
        if (mysqli_num_rows($res) == 1) {
            mysqli_query($connessione, "UPDATE `utenti` SET nome = '$update_name', cognome = '$update_cognome', indirizzo ='$update_indirizzo' WHERE id_utente = '$id_utente'") or die('query failed');
            if ($update_name != $old_name) {
                $message_good[] = 'Nome aggiornato con successo!';
            }
            if ($update_cognome != $old_cognome) {
                $message_good[] = 'Cognome aggiornato con successo!';
            }
            if ($update_indirizzo != $old_indirizzo) {
                $message_good[] = 'Indirizzo aggiornato con successo!';
            }
            $check_email = mysqli_query($connessione, "SELECT * FROM utenti WHERE email='$update_email'");
            if (mysqli_num_rows($check_email) == 0) {
                mysqli_query($connessione, "UPDATE `utenti` SET email='$update_email' WHERE id_utente = '$id_utente'") or die('query failed');

                $message_good[] = 'Email aggiornato con successo!';
            } else if ($old_email != $update_email) {
                $message_bad[] = 'email già esistente!';
            }
        }


        $check_pass = mysqli_real_escape_string($connessione, $_POST['check_pass']);
        $new_pass = mysqli_real_escape_string($connessione, $_POST['new_pass']);
        $confirm_pass = mysqli_real_escape_string($connessione, $_POST['confirm_pass']);

        if (!empty($check_pass) || !empty($new_pass) || !empty($confirm_pass)) {
            if (!password_verify($check_pass, $crypted_old_password)) {
                $message_bad[] = 'Vecchia password errata!';
            } elseif ($new_pass != $confirm_pass) {
                $message_bad[] = 'Conferma della password errata!';
            } else {
                $hashed_password = password_hash($confirm_pass, PASSWORD_DEFAULT);
                mysqli_query($connessione, "UPDATE `utenti` SET password = '$hashed_password' WHERE id_utente = '$id_utente'") or die('query failed');
                $message_good[] = 'Password aggiornata con successo!';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>update profile</title>
    <link rel="stylesheet" href="../css/account.css">
</head>
<body>
<div class="header">
    <a href="logged.php" class="logo"><img src="../images/ShopWise-logo-header.png"></a>
</div>

<div class="update-profile">
    <?php
    $select = mysqli_query($connessione, "SELECT * FROM `utenti` WHERE id_utente = '$id_utente'") or die('query failed');
    if(mysqli_num_rows($select) > 0){
        $fetch = mysqli_fetch_assoc($select);
    }
    ?>
    <form action="" method="post" enctype="multipart/form-data">
        <?php
        if(isset($message_good)){
            foreach($message_good as $message){
                echo '<div class="message_good">'.$message.'</div>';
            }
        }
        if(isset($message_bad)){
            foreach($message_bad as $message){
                echo '<div class="message_bad">'.$message.'</div>';
            }
        }
        ?>
        <div class="flex">
            <div class="inputBox">
                <span>Nome :</span>
                <input type="text" name="update_name" value="<?php echo $fetch['nome']; ?>" class="box">
                <span>Email :</span>
                <input type="email" name="update_email" value="<?php echo $fetch['email']; ?>" class="box">
                <span>Indirizzo :</span>
                <input type="text" name="update_indirizzo" value="<?php echo $fetch['indirizzo']; ?>" class="box">
            </div>
            <div class="inputBox">
                <span>Cognome :</span>
                <input type="text" name="update_cognome" value="<?php echo $fetch['cognome']; ?>" class="box">
                <span>Vecchia password :</span>
                <input type="password" name="check_pass" placeholder="inserisci vecchia password" class="box">
                <span>Nuova password :</span>
                <input type="password" name="new_pass" placeholder="inserisci nuova password" class="box">
                <span>Conferma password :</span>
                <input type="password" name="confirm_pass" placeholder="conferma nuova password" class="box">
            </div>
        </div>
        <input type="submit" value="Aggiorna account" name="update_profile" class="btn">
        <a onclick="history.back();" class="btn">Torna indietro</a>
        <a href="logout.php" class="delete-btn">Logout</a>
    </form>
</div>
</body>
</html>