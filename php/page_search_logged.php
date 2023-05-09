<?php
session_start();
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
    <link rel="stylesheet" href="../jquery-ui-1.13.2/jquery-ui.css">
    <title>RicercaProdotti</title>
    <script type="text/javascript" src="../jquery/jquery-3.6.4.js"> </script>
    <script type="text/javascript" src="../jquery-ui-1.13.2/jquery-ui.js"> </script>
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
            <a href="aggiorna_account.php" class="account">Account</a>
        </div>
        <div class="header-center">
            <form action="?" method="get" class="ricerca" role="search" id="idform4">                   
                <label class="label-search" for="search">Cerca</label>
                <input class="search-field" id="search" type="search" placeholder="Cerca un prodotto..." name="search-field-logged" autofocus required />
                <button class="vai" type="submit" form="idform4" name="submit-search-logged">Vai</button>    
            </form>        
        </div>
    </div>
    <?php
    if (isset($_GET['submit-search-logged'])) {                                                 
        $search = mysqli_real_escape_string($connessione, $_GET['search-field-logged']);
        $_SESSION['ricerca'] = $search;
    }
    $search = $_SESSION['ricerca'];
     if($_SERVER["REQUEST_METHOD"] == "GET") { 
        $sql_select = "SELECT * FROM prodotti WHERE categoria = '$search' OR nome LIKE '$search%'";
        $result = mysqli_query($connessione, $sql_select);
        $numberQueryLabelResults = mysqli_num_rows($result);
     } 
    $prezzo_minimo = 0;
    $select_prezzo_massimo = "SELECT MAX(CAST(prezzo AS DECIMAL(10,2))) FROM prodotti WHERE categoria = '$search' OR nome LIKE '$search%'";
    $result_prezzo = mysqli_query($connessione, $select_prezzo_massimo);
    $row = $result_prezzo->fetch_assoc();
    $prezzo_massimo = $row["MAX(CAST(prezzo AS DECIMAL(10,2)))"];
    ?>
    <script type="text/javascript">
        $(document).ready(function () {
            $(".hideDetails").hide();

            var prezzo_minimo = <?php echo $prezzo_minimo; ?>;
            var prezzo_massimo = <?php echo $prezzo_massimo; ?>;
            $('#price_range').slider({
                range: true,
                min: prezzo_minimo,
                max: prezzo_massimo,
                values: [prezzo_minimo, prezzo_massimo],
                stop:function(event, ui) {
                    $('#prezzo_minimo').val(ui.values[0]);
                    $('#prezzo_massimo').val(ui.values[1]); 
                    loadAjax();
                }
            });

            function get_filter_text(text_id) {
                var filterData = [];
                $('#' + text_id + ':checked').each(function() {
                    filterData.push($(this).val());
                });
                return filterData;
            }           

            $(".filter_check").click(function() {
                loadAjax();
            });
                 
            function loadAjax() {
                var action = 'data';
                var marca = get_filter_text('marca');
                var schermo = get_filter_text('schermo');
                var ram = get_filter_text('ram');
                var spazio = get_filter_text('spazio');
                var cpu = get_filter_text('cpu');
                var gpu = get_filter_text('gpu');
                var batteria = get_filter_text('batteria');
                var prezzo_minimo = $('#prezzo_minimo').val();
                var prezzo_massimo = $('#prezzo_massimo').val();
                $.ajax({
                    url: 'filtered_logged.php',
                    method: 'POST',
                    data: {action:action, marca:marca, schermo:schermo, ram:ram, spazio:spazio, cpu:cpu, gpu:gpu, batteria:batteria, search:'<?php echo $search; ?>', prezzo_minimo:prezzo_minimo, prezzo_massimo:prezzo_massimo},
                    success:function(data) {
                        $('#ajaxResults').html(data);
                    }
                });
            };

        });
    </script>
    <div class="container py-2 my-3">
        <button type="button" class="btn btn-dark bottoneFiltri">Filtri</button>
    </div>  
    <div class="show-products container-fluid">
        <div class="row">
            <div class="col-xl-3" id="slideFiltri">
                <div class="row py-xl-4 my-xl-5"></div>
                <script type="text/javascript">
                    $(".bottoneFiltri").click(function() {
                        $("#slideFiltri").slideToggle();
                    });
                </script>
                <?php
                if ($numberQueryLabelResults > 0) {
                ?>
                <div class="card border-secondary rounded-3 p-3 card-filtri">
                    <h6>Scegli l'intervallo di prezzo da considerare</h6>
                <div id="price_range"></div>
                    <div class="d-flex justify-content-between">
                        <div class="prezzo">
                            <label for="prezzo_minimo">€: </label>
                            <input type="text" name="prezzoMinimo" id="prezzo_minimo" class="pointer" value="<?php echo $prezzo_minimo; ?>" readonly> 
                        </div>
                        <div class="prezzo">
                            <label for="prezzo_massimo">€: </label>
                            <input type="text" name="prezzoMassimo" id="prezzo_massimo" class="pointer" value="<?php echo $prezzo_massimo; ?>" readonly>
                        </div>
                    </div>
                    <hr>
                    <h6>Scegli la marca</h6>
                <?php
                    }
                ?>
                    <ul class="list-group border-white">
                    <?php
                    $sql_query = "SELECT DISTINCT marca FROM prodotti WHERE categoria = '$search' OR nome LIKE '$search%' ORDER BY marca";
                    $filter = mysqli_query($connessione, $sql_query);
                    while ($row = $filter->fetch_array(MYSQLI_ASSOC)) {
                    ?>
                    <li class="list-group-item">
                        <div class="form-check">
                            <input class="form-check-input filter_check" type="checkbox" value="<?php echo $row['marca']; ?>" id="marca">
                            <label class="form-check-label" for="marca">
                                <?php echo $row['marca']; ?>                                                                                   
                            </label>
                        </div>
                    </li>
                    <?php
                    }
                    ?>
                </ul>
                <?php
                $sql_query = "SELECT DISTINCT schermo FROM prodotti WHERE schermo IS NOT NULL AND categoria = '$search' OR nome LIKE '$search%' ORDER BY schermo";
                $filter = mysqli_query($connessione, $sql_query);
                $numberQueryResults = mysqli_num_rows($filter);
                if ($numberQueryResults > 0) {
                ?>
                    <hr>
                    <h6>Scegli la dimensione dello schermo</h6>
                        <ul class="list-group border-white">
                        <?php
                        while ($row = $filter->fetch_array(MYSQLI_ASSOC)) {
                        ?>
                        <li class="list-group-item">
                            <div class="form-check">
                                <input class="form-check-input filter_check" type="checkbox" value='<?php echo $row['schermo']; ?>' id="schermo">
                                <label class="form-check-label" for="schermo">
                                    <?php echo $row['schermo']; ?>                                                                                       
                                </label>
                            </div>
                        </li>
                        <?php
                        }
                        ?>
                    </ul>
                <?php
                }
                ?>
                <?php
                $sql_query = "SELECT DISTINCT ram FROM prodotti WHERE ram IS NOT NULL AND categoria = '$search' OR nome LIKE '$search%' ORDER BY LENGTH(ram), ram";
                $filter = mysqli_query($connessione, $sql_query);
                $numberQueryResults = mysqli_num_rows($filter);
                if ($numberQueryResults > 0) {
                ?>
                    <hr>
                    <h6>Scegli la quantità di ram</h6>
                        <ul class="list-group border-white">
                        <?php
                        while ($row = $filter->fetch_array(MYSQLI_ASSOC)) {
                        ?>
                        <li class="list-group-item">
                            <div class="form-check">
                                <input class="form-check-input filter_check" type="checkbox" value="<?php echo $row['ram']; ?>" id="ram">
                                <label class="form-check-label" for="ram">
                                    <?php echo $row['ram']; ?>                                                                                 
                                </label>
                            </div>
                        </li>
                        <?php
                        }
                        ?>
                    </ul>
                <?php
                }
                ?>
                <?php
                $sql_query = "SELECT DISTINCT spazio FROM prodotti WHERE spazio IS NOT NULL AND categoria = '$search' OR nome LIKE '$search%' ORDER BY LENGTH(spazio), spazio";         
                $filter = mysqli_query($connessione, $sql_query);
                $numberQueryResults = mysqli_num_rows($filter);
                if ($numberQueryResults > 0) {
                ?>
                    <hr>
                    <h6>Scegli la quantità di spazio</h6>
                        <ul class="list-group border-white">
                        <?php
                        while ($row = $filter->fetch_array(MYSQLI_ASSOC)) {
                        ?>
                        <li class="list-group-item">
                            <div class="form-check">
                                <input class="form-check-input filter_check" type="checkbox" value="<?php echo $row['spazio']; ?>" id="spazio">
                                <label class="form-check-label" for="spazio">
                                    <?php echo $row['spazio']; ?>                                                         
                                </label>
                            </div>
                        </li>
                        <?php
                        }
                        ?>
                    </ul>
                <?php
                }
                ?>
                <?php
                $sql_query = "SELECT DISTINCT cpu FROM prodotti WHERE cpu IS NOT NULL AND categoria = '$search' OR nome LIKE '$search%' ORDER BY cpu";          
                $filter = mysqli_query($connessione, $sql_query);
                $numberQueryResults = mysqli_num_rows($filter);
                if ($numberQueryResults > 0) {
                ?>
                    <hr>
                    <h6>Scegli la CPU</h6>
                        <ul class="list-group border-white">
                        <?php
                        while ($row = $filter->fetch_array(MYSQLI_ASSOC)) {
                        ?>
                        <li class="list-group-item">
                            <div class="form-check">
                                <input class="form-check-input filter_check" type="checkbox" value="<?php echo $row['cpu']; ?>" id="cpu">
                                <label class="form-check-label" for="cpu">
                                    <?php echo $row['cpu']; ?>                                                                                    
                                </label>
                            </div>
                        </li>
                        <?php
                        }
                        ?>
                    </ul>
                <?php
                }
                ?>
                <?php
                $sql_query = "SELECT DISTINCT gpu FROM prodotti WHERE gpu IS NOT NULL AND categoria = '$search' OR nome LIKE '$search%' ORDER BY gpu";          
                $filter = mysqli_query($connessione, $sql_query);
                $numberQueryResults = mysqli_num_rows($filter);
                if ($numberQueryResults > 0) {
                ?>
                    <hr>
                    <h6>Scegli la GPU</h6>
                        <ul class="list-group border-white">
                        <?php
                        while ($row = $filter->fetch_array(MYSQLI_ASSOC)) {
                        ?>
                        <li class="list-group-item">
                            <div class="form-check">
                                <input class="form-check-input filter_check" type="checkbox" value="<?php echo $row['gpu']; ?>" id="gpu">
                                <label class="form-check-label" for="gpu">
                                    <?php echo $row['gpu']; ?>                                                                                    
                                </label>
                            </div>
                        </li>
                        <?php
                        }
                        ?>
                    </ul>
                <?php
                }
                ?>
                <?php
                $sql_query = "SELECT DISTINCT batteria FROM prodotti WHERE batteria IS NOT NULL AND categoria = '$search' OR nome LIKE '$search%' ORDER BY batteria";          
                $filter = mysqli_query($connessione, $sql_query);
                $numberQueryResults = mysqli_num_rows($filter);
                if ($numberQueryResults > 0) {
                ?>
                    <hr>
                    <h6>Scegli la batteria</h6>
                        <ul class="list-group border-white">
                        <?php
                        while ($row = $filter->fetch_array(MYSQLI_ASSOC)) {
                        ?>
                        <li class="list-group-item">
                            <div class="form-check">
                                <input class="form-check-input filter_check" type="checkbox" value="<?php echo $row['batteria']; ?>" id="batteria">
                                <label class="form-check-label" for="batteria">
                                    <?php echo $row['batteria']; ?>                                                                                    
                                </label>
                            </div>
                        </li>
                        <?php
                        }
                        ?>
                    </ul>
                <?php
                }
                ?>
            </div>
            </div>
            <div class="col-xl-9" id="ajaxResults">
                <div class="py-2 my-3 text-center">
                    <?php
                    if ($numberQueryLabelResults > 0) {
                        echo "<h2>Abbiamo trovato ".$numberQueryLabelResults." risultati</h2>";
                    }
                    else {
                    ?>
                </div>
                <div class="py-2 my-3 text-center">
                    <?php
                        echo "<h2>Non ci sono prodotti di questa tipologia o corrispondenti con questo nome!<br>Prova a cercare un altro prodotto</h2>";
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
                                <h4 class="<?php echo "testo" . $row['id_prodotto']; ?>"><div class="specifiche">Specifiche tecniche: </div><span id="<?php echo "more". $row['id_prodotto']; ?>" class="material-symbols-outlined" >expand_more</span><span id="<?php echo "less" . $row['id_prodotto']; ?>" class="material-symbols-outlined" >expand_less </span></h4>
                                <div class="hideDetails" id="<?php echo $row['id_prodotto']; ?>">
                                    <div>Marca: <?php echo $row['marca']; ?> </div>
                                    <?php 
                                    if (!is_null($row['schermo'])) {
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
                    ?>
                </div>
            </div>
        </div>
    </div>
    <footer class="py-3 my-4">
</body>
</html>