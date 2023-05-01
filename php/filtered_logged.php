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
    <title>ProdottiFiltrati</title>
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
        $sql_select = "SELECT * FROM prodotti WHERE categoria = '$search'";
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
        $result = mysqli_query($connessione, $sql_select);
        $numberQueryResults = mysqli_num_rows($result);
        if ($numberQueryResults > 0) {
            echo '<div id="filteredResultsDynamic">
                <h2>Abbiamo trovato '.$numberQueryResults.' risultati</h2>
                </div>';
        }
        else {   
            echo '<div id="filteredResultsDynamic">     
                <h2>Non abbiamo trovato nessun prodotto con queste caratteristiche!</h2>
                </div>';
        }
        if ($numberQueryResults > 0) {
            while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                ?>
                <div class="box">
                    <img <?php echo "src='data:immagine/jpeg;base64,".base64_encode($row['immagine'])."';" ?> />
                    <div class="name"> <?php echo $row['nome']; ?> </div>
                    <div class="price"> <?php echo $row['prezzo']; ?> </div>
                    <div class="shop">Venditore: <?php echo $row['venditore']; ?> </div>
                    <div class="details">
                        <h4 class="<?php echo "testo" . $row['id_prodotto'] ?>">Specifiche tecniche: <span id="<?php echo "more". $row['id_prodotto']; ?>" class="material-symbols-outlined" >expand_more</span><span id="<?php echo "less" . $row['id_prodotto']; ?>" class="material-symbols-outlined" >expand_less </span></h4>
                        <div class="hideDetails" id="<?php echo $row['id_prodotto']; ?>">
                            <div>Marca: <?php echo $row['marca']; ?> </div>
                            <?php 
                            if(!is_null($row['schermo'])) {
                                echo "Schermo: ". $row['schermo'] ."<br>";
                            }                        
                            if (!is_null($row['ram'])) {
                                echo "Ram: ". $row['ram'] ."<br>";
                            }                        
                            if (!is_null($row['spazio'])) {
                                echo "Spazio: ". $row['spazio'] ."<br>";
                            }
                            if (!is_null($row['cpu'])) {
                                echo "CPU: ". $row['cpu'] ."<br>";
                            }
                            if (!is_null($row['gpu'])) {
                                echo "GPU: ". $row['gpu'] ."<br>";
                            }
                            if (!is_null($row['batteria'])) {
                                echo "Batteria: ". $row['batteria'];
                            } 
                            ?>
                        </div>
                    </div>
                    <script type="text/javascript">
                        $("<?php echo "#" . "less". $row['id_prodotto']; ?>").hide();
                        mostra = false;
                        $("<?php echo "." . "testo" . $row['id_prodotto']; ?>").click(function() {
                            $("<?php echo "#" . $row['id_prodotto']; ?>").slideToggle();
                            if (mostra == false){
                                $("<?php echo "#" . "less". $row['id_prodotto']; ?>").show();
                                $("<?php echo "#" . "more". $row['id_prodotto']; ?>").hide();
                                mostra = true;
                            }
                            else{
                                $("<?php echo "#" . "less". $row['id_prodotto']; ?>").hide();
                                $("<?php echo "#" . "more". $row['id_prodotto']; ?>").show();
                                mostra = false;
                            }
                        });
                    </script>
                    <?php
                    $id_prodotto = $row['id_prodotto']; 
                    ?>
                    <form action="prenotazione_articolo.php" method="post" id="<?php echo "prenotazione " . $id_prodotto; ?>" >
                        <input type="hidden" name="<?php echo $id_prodotto; ?>" value="<?php echo $id_prodotto; ?>">
                        <button type="submit" class="btn btn-success" form="<?php echo "prenotazione " . $id_prodotto; ?>" name="prenota">Prenota</button>
                    </form>
                </div>
            <?php
            }
        }
    }
    ?>
</body>
</html>
    



