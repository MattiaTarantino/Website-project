<?php
session_start();
require_once('config.php');

$email = $connessione->real_escape_string($_POST['email']);
$password = $connessione->real_escape_string($_POST['password']);

if($_SERVER["REQUEST_METHOD"] === "POST"){
    $sql_select = "SELECT * FROM utenti where email = '$email'";
    if ($result = $connessione->query($sql_select)){
        if($result->num_rows == 1){
            $row = $result->fetch_array(MYSQLI_ASSOC);
            if(password_verify($password, $row['password'])){
                session_start();
                
                $_SESSION['loggato'] = true;
                $_SESSION['id_utente'] = $row['id_utente'];
                $_SESSION['nome'] = $row['nome'];
                $_SESSION['cognome'] = $row['cognome'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['indirizzo'] = $row['indirizzo'];

                header("location: logged.php");
            }
            else{
                $_SESSION['password_alert'] = true;
                header("location: login.php");
            }
        }
        else{
            $_SESSION['email_alert'] = true;
            header("location: login.php");
        }
    }
    else{
        echo "Errore in fase di login";
    }
}
$connessione->close();
?>
