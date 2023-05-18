<?php
require_once('config.php');
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="../css/search.css">
    <title>ShopWise-ProdottiFiltrati</title>
    <script type="text/javascript" src="../jquery/jquery-3.6.4.js"> </script>
    <script type="text/javascript">
        $(document).ready(function () {
                $(".hideDetails").hide();
        });
    </script>
</head>
<body>
    <?php
    if (isset($_POST['action']) && isset($_POST['search'])) {
        $search = $_POST['search'];
        if (isset($_POST['prezzo_minimo'])) {
            $prezzo_minimo = $_POST['prezzo_minimo'];
        }
        if (isset($_POST['prezzo_massimo'])) {
            $prezzo_massimo = $_POST['prezzo_massimo'];
        }
        $sql_select = "SELECT * FROM prodotti WHERE (categoria = '$search' OR nome LIKE '$search%') AND CAST(prezzo AS DECIMAL) BETWEEN '$prezzo_minimo' AND '$prezzo_massimo'";            
        if (isset($_POST['marca'])) {
            $marca = implode("','", $_POST['marca']);
            $sql_select .= "AND marca IN ('" . $marca . "')";
        }
        if (isset($_POST['schermo'])) {
            $schermo = implode("','", $_POST['schermo']);
            $sql_select .= "AND schermo IN ('" . $schermo . "')";
        }
        if (isset($_POST['ram'])) {
            $ram = implode("','", $_POST['ram']);
            $sql_select .= "AND ram IN ('" . $ram . "')";
        }
        if (isset($_POST['spazio'])) {
            $spazio = implode("','", $_POST['spazio']);
            $sql_select .= "AND spazio IN ('" . $spazio . "')";
        }
        if (isset($_POST['cpu'])) {
            $cpu = implode("','", $_POST['cpu']);
            $sql_select .= "AND cpu IN ('" . $cpu . "')";
        }
        if (isset($_POST['gpu'])) {
            $gpu = implode("','", $_POST['gpu']);
            $sql_select .= "AND gpu IN ('" . $gpu . "')";
        }
        if (isset($_POST['batteria'])) {
            $batteria = implode("','", $_POST['batteria']);
            $sql_select .= "AND batteria IN ('" . $batteria . "')";
        }
        if (isset($_POST['ordine'])) {
            $ordine = $_POST['ordine'];
            if ($ordine == "crescente") {
                $sql_select .= "ORDER BY CAST(prezzo AS DECIMAL)";
            }
            if ($ordine == "decrescente") {
                $sql_select .= "ORDER BY CAST(prezzo AS DECIMAL) DESC";
            }
        } 
        $result = mysqli_query($connessione, $sql_select);
        $numberQueryResults = mysqli_num_rows($result);
        ?>
        <div class="py-2 my-3 text-center">
            <?php
            if ($numberQueryResults == 1) {
                echo "<h2>Abbiamo trovato ".$numberQueryResults." risultato</h2>";
            }
            else if ($numberQueryResults > 1) {
                echo "<h2>Abbiamo trovato ".$numberQueryResults." risultati</h2>";
            }
            else {
            ?>
        </div>
        <div class="py-2 my-3 text-center">     
            <?php
                echo "<h2>Non ci sono prodotti con queste caratteristiche!<br>Prova a cercare un altro prodotto</h2>";
            }  
            ?>
        </div>
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
                        <h4 class="<?php echo "testo" . $row['id_prodotto'] ?>">Specifiche tecniche: <span id="<?php echo "more". $row['id_prodotto']; ?>" class="material-symbols-outlined" >expand_more</span><span id="<?php echo "less" . $row['id_prodotto']; ?>" class="material-symbols-outlined" >expand_less </span></h4>           
                        <div class="hideDetails" id="<?php echo $row['id_prodotto']; ?>">                         
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
                        $("<?php echo "#" . "less". $row['id_prodotto']; ?>").hide();
                        $("<?php echo "." . "testo" . $row['id_prodotto']; ?>").click(function() {
                            $("<?php echo "#" . $row['id_prodotto']; ?>").slideToggle(function() {
                                if ($(this).is(':visible')) {
                                    $("<?php echo "#" . "less". $row['id_prodotto']; ?>").show();
                                    $("<?php echo "#" . "more". $row['id_prodotto']; ?>").hide();
                                }
                                else {
                                    $("<?php echo "#" . "less". $row['id_prodotto']; ?>").hide();
                                    $("<?php echo "#" . "more". $row['id_prodotto']; ?>").show();
                                }
                            });
                        });
                    </script>
                    <button type="button" class="btn btn-lg bottone-piccolo btn-success" data-bs-toggle="modal" data-bs-target="#requiredAccount">Prenota</button>
                </div>
            <?php
            }
            ?>
        </div>
        <?php
    }
    ?>
</body>
</html>
    



