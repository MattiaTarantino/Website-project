<?php
session_start();
require_once('config.php');

if(isset($_POST["action"])){
    if($_POST["action"] == "delete"){
        if (isset($connessione)) {
            $id = $connessione->real_escape_string($_POST['id']);
            mysqli_query($connessione, "DELETE FROM prodotti WHERE id_prodotto= $id ");
            echo 1;
            exit;
        }
    }
}
echo 0;