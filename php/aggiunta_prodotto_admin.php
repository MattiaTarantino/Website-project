<?php
session_start();
require_once('config.php');
if (isset($connessione)) {
    $categoria = $connessione->real_escape_string($_POST['categoria']);
    $nome_prodotto = $connessione->real_escape_string($_POST['nome_prodotto']);
    $marca_prodotto = $connessione->real_escape_string($_POST['marca_prodotto']);
    $venditore = $connessione->real_escape_string($_POST['venditore']);
    $prezzo_prodotto = $connessione->real_escape_string($_POST['prezzo_prodotto']);
    $fileName = basename($_FILES["foto_prodotto"]["name"]);
    $schermo_prodotto = $connessione->real_escape_string($_POST['schermo_prodotto']);
    $spazio_prodotto = $connessione->real_escape_string($_POST['spazio_prodotto']);
    $ram_prodotto = $connessione->real_escape_string($_POST['ram_prodotto']);
    $gpu_prodotto = $connessione->real_escape_string($_POST['gpu_prodotto']);
    $cpu_prodotto = $connessione->real_escape_string($_POST['cpu_prodotto']);
    $batteria_prodotto = $connessione->real_escape_string($_POST['batteria_prodotto']);

    $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
    $allowTypes = array('jpg','png','jpeg');
    if(in_array($fileType, $allowTypes)){
        $image = $_FILES['foto_prodotto']['tmp_name'];
        $imgContent = addslashes(file_get_contents($image));

        $insert = $connessione->query("INSERT into prodotti (categoria, nome, immagine, marca, venditore, prezzo, schermo, ram, spazio, cpu, gpu, batteria ) VALUES ('$categoria', '$nome_prodotto', '$imgContent' , '$marca_prodotto' ,'$venditore', '$prezzo_prodotto','$schermo_prodotto','$ram_prodotto', '$spazio_prodotto','$cpu_prodotto', '$gpu_prodotto','$batteria_prodotto' )");

        if($insert){
            $status = 'success';
            $_SESSION['caricato'] = true;
            header("location: admin.php");
        }else{
            $_SESSION['fallito'] = true;
            header("location: aggiungi_admin.php");
        }
    }else{
        $_SESSION['formato'] = true;
        header("location: aggiungi_admin.php");
    }
    $connessione->close();
}

