<?php
session_start();
require_once('config.php');

if (isset($connessione)) {
    $nome = $connessione->real_escape_string($_POST['nome']);
    $cognome = $connessione->real_escape_string($_POST['cognome']);
    $email = $connessione->real_escape_string($_POST['email']);
    $password = $connessione->real_escape_string($_POST['password']);
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $indirizzo = $connessione->real_escape_string($_POST['indirizzo']);
    $venditore = $connessione->real_escape_string($_POST['venditore']);

    $sql = "SELECT * FROM utenti WHERE email='$email';";

    $res = mysqli_query($connessione, $sql);

    if (mysqli_num_rows($res) > 0) {

        $row = mysqli_fetch_assoc($res);

        if ($email == isset($row['email'])) {

            $_SESSION['email_alert'] = true;
            header("location: register.php");
        }
    } else {
        $sql_insert = "INSERT INTO utenti(nome, cognome, email, password, indirizzo, venditore) VALUES ('$nome','$cognome','$email','$hashed_password','$indirizzo', '$venditore')";
        $result = mysqli_query($connessione, $sql_insert);

        $for_id = "SELECT * FROM utenti where email = '$email'";
        $res = mysqli_query($connessione, $for_id);
        $row = $res->fetch_array(MYSQLI_ASSOC);

        $_SESSION['id_utente'] = $row['id_utente'];
        $_SESSION['nome'] = $nome;
        $_SESSION['cognome'] = $cognome;
        $_SESSION['email'] = $email;
        $_SESSION['indirizzo'] = $indirizzo;
        $_SESSION['venditore'] = $venditore;

        header("location: prodotti_venditore.php");
    }
}