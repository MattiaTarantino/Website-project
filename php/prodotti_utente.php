<?php
session_start();
require_once('config.php');
$id_utente = $_SESSION['id_utente'];
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="../css/search.css">
    <title>ProdottiUtente</title>
    <script type="text/javascript" src="../jquery/jquery-3.6.4.js"> </script>
    <script type="text/javascript">
         $(document).ready(function() {
            $('.hideDetails').hide();

            $('#prenotazioni').click(function() {
                $("body").load('prodotti_utente.php', function() {
                    $('#escludere').remove();
                });
                history.pushState({}, '', 'prodotti_utente.php');
            });

         });
    </script>
    <style>
        .account{
            margin-right: 26px;
            }
    </style>
</head>
<body>
    <div class="header">
        <a href="logged.php" class="logo"><img src="../images/ShopWise-logo-header.png"></a>
        <div class="header-right">
            <a href="#" class="btn" id="prenotazioni">Prenotazioni</a>
            <a href="aggiorna_account.php" class="account">Account</a>
        </div>
        <div class="header-center">
            <form action="?" method="get" class="ricerca" role="search" id="idform4">                   
                <label class="label-search" for="search">Cerca</label>
                <input class="search-field" id="search" type="search" placeholder="Cerca un prodotto tra le prenotazioni..." name="search-field-logged" autofocus required />
                <button class="vai" type="submit" form="idform4" name="submit-search-logged">Vai</button>    
            </form>        
        </div>
    </div>
    <div id="escludere">
        <?php
        if (isset($_GET['submit-search-logged'])) {
            if (isset($connessione)) {
                $search = mysqli_real_escape_string($connessione, $_GET['search-field-logged']);
            }
            if($_SERVER["REQUEST_METHOD"] == "GET") { 
                $sql_select = "SELECT * FROM prenotazioni, prodotti WHERE prenotazioni.id_utente = '$id_utente' AND prenotazioni.id_prodotto = prodotti.id_prodotto AND (prodotti.categoria = '$search' OR prodotti.nome LIKE '$search%')";
                $result = mysqli_query($connessione, $sql_select);
                $numberQueryResults = mysqli_num_rows($result);
                if ($numberQueryResults == 1) {
                    echo "<div class='py-2 my-3 text-center'> 
                            <h2>Abbiamo trovato ".$numberQueryResults." risultato </h2>
                        </div>";
                }
                else if ($numberQueryResults > 1) {
                    echo "<div class='py-2 my-3 text-center'> 
                            <h2>Abbiamo trovato ".$numberQueryResults." risultati </h2>
                        </div>";
                }
                else {
                    echo "<div class='py-2 my-3 text-center'>
                            <h2>Non hai effettuato la prenotazione di prodotti di questa tipologia o corrispondenti con questo nome!<br>Prova a cercare un altro prodotto</h2>
                        </div>";
                }
            }
        }
        else {
        ?>
    </div>
    <?php
        $sql_select = "SELECT * FROM prenotazioni, prodotti WHERE prenotazioni.id_utente = '$id_utente' AND prenotazioni.id_prodotto = prodotti.id_prodotto";
        if (isset($connessione)) {
            $result = mysqli_query($connessione, $sql_select);
        }
        $numberQueryResults = mysqli_num_rows($result);
        if ($numberQueryResults == 1) {
            echo "<div class='py-2 my-3 text-center'> 
                    <h2>Abbiamo trovato ".$numberQueryResults." risultato </h2>
                </div>";
        }
        else if ($numberQueryResults > 1) {
            echo "<div class='py-2 my-3 text-center'> 
                    <h2>Abbiamo trovato ".$numberQueryResults." risultati </h2>
                </div>";
        }
        else {
            echo "<div class='py-2 my-3 text-center'>
                    <h2>Non hai effettuato ancora nessuna prenotazione!</h2>
                </div>";
        }
    ?>
    <div id="escludere">
        <?php
        }
        ?>
    </div>
    <div class="show-products">
        <div class="box-container">
            <?php
            while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            ?>
                <div class="box">
                    <img <?php echo "src='data:immagine/jpeg;base64,".base64_encode($row['immagine'])."';" ?> />
                    <div class="name"> <?php echo $row['nome']; ?> </div>
                    <div class="price"><h2> <?php echo $row['prezzo']; ?> </h2></div>
                    <div class="shop">Venditore: <?php echo $row['venditore']; ?> </div>
                    <div class="details">
                        <h4 class="<?php echo "testo" . $row['id_prenotazione']; ?>"><div class="specifiche">Specifiche tecniche: </div><span id="<?php echo "more". $row['id_prenotazione']; ?>" class="material-symbols-outlined" >expand_more</span><span id="<?php echo "less" . $row['id_prenotazione']; ?>" class="material-symbols-outlined" >expand_less </span></h4>
                        <div class="hideDetails" id="<?php echo $row['id_prenotazione']; ?>">
                            <div>Marca: <?php echo $row['marca']; ?> </div>
                            <?php 
                            if (!is_null($row['schermo']) && $row['schermo'] != '') {
                                echo "Schermo: ". $row['schermo'] ."<br>";
                            }
                            if (!is_null($row['ram']) && $row['ram'] != '') {
                                echo "Ram: ". $row['ram'] ."<br>";
                            }
                            if (!is_null($row['spazio']) && $row['spazio'] != '') {
                                echo "Spazio: ". $row['spazio'] ."<br>";
                            }
                            if (!is_null($row['cpu']) && $row['cpu'] != '') {
                                echo "CPU: ". $row['cpu'] ."<br>";
                            }
                            if (!is_null($row['gpu']) && $row['gpu'] != '') {
                                echo "GPU: ". $row['gpu'] ."<br>";
                            }
                            if (!is_null($row['batteria']) && $row['batteria'] != '') {
                                echo "Batteria: ". $row['batteria'];
                            }
                            ?>
                        </div>
                    </div>
                    <script type="text/javascript">
                        $("<?php echo "#" . "less". $row['id_prenotazione']; ?>").hide();
                        mostra = false;
                        $("<?php echo "." . "testo" . $row['id_prenotazione']; ?>").click(function() {
                            $("<?php echo "#" . $row['id_prenotazione']; ?>").slideToggle();
                            if (mostra == false){
                                $("<?php echo "#" . "less". $row['id_prenotazione']; ?>").show();
                                $("<?php echo "#" . "more". $row['id_prenotazione']; ?>").hide();
                                mostra = true;
                            }
                            else{
                                $("<?php echo "#" . "less". $row['id_prenotazione']; ?>").hide();
                                $("<?php echo "#" . "more". $row['id_prenotazione']; ?>").show();
                                mostra = false;
                            }
                        });
                    </script>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
    <footer class="py-3 my-4">
</body>
</html>

