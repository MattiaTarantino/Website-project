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
    <link rel="stylesheet" href="../jquery/jquery-ui-1.13.2/jquery-ui.css">
    <title>ShopWise-RicercaProdotti</title>
    <script type="text/javascript" src="../bootstrap/js/bootstrap.js"> </script>
    <script type="text/javascript" src="../jquery/jquery-3.6.4.js"> </script>
    <script type="text/javascript" src="../jquery/jquery-ui-1.13.2/jquery-ui.js"> </script>
</head>
<body>
    <div class="header">
        <a href="../index.html" class="logo"><img src="../images/ShopWise-logo-header.png"></a>
        <div class="header-right">
            <a href="login.php" class="accedi">Accedi</a>
            <a href="register.php" class="registrati">Registrati</a>
        </div>
        <div class="header-center">
            <form action="?" method="post" class="ricerca" role="search" id="idform3">      
                <label class="label-search" for="search">Cerca</label>
                <input class="search-field" id="search" type="search" placeholder="Cerca un prodotto..." name="search-field" autofocus required />
                <button class="vai" type="submit" form="idform3" name="submit-search">Vai</button>    
            </form>        
        </div>
    </div>
    <?php
    if (isset($_POST['submit-search'])) {
        $search = mysqli_real_escape_string($connessione, $_POST['search-field']);
    }
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $sql_select = "SELECT * FROM prodotti WHERE categoria = '$search' OR nome LIKE '$search%'";
        $result = mysqli_query($connessione, $sql_select);
        $numberQueryLabelResults = mysqli_num_rows($result);
    }
    $prezzo_minimo = 0;
    $select_prezzo_massimo = "SELECT MAX(CAST(REPLACE(prezzo, '€', '') AS DECIMAL)) FROM prodotti WHERE categoria = '$search' OR nome LIKE '$search%'";
    $result_prezzo = mysqli_query($connessione, $select_prezzo_massimo);
    $row = $result_prezzo->fetch_assoc();
    $prezzo_massimo = $row["MAX(CAST(REPLACE(prezzo, '€', '') AS DECIMAL))"];
    ?>
    <script type="text/javascript">
        $(document).ready(function () {
            $(".hideDetails").hide();

            var ordinamento = "";
            var selected_crescente = false;
            var selected_decrescente = false;
            $("#crescente").click(function() {
                if (selected_crescente == false) {
                    ordinamento = "crescente";
                    selected_crescente = true;
                    $(this).addClass('active');
                    selected_decrescente = false;
                    $('#decrescente').removeClass('active');
                }
                else {
                    ordinamento = "";
                    selected_crescente = false;
                    $(this).removeClass('active');
                }
            });

            $("#decrescente").click(function() {
                if (selected_decrescente == false) {
                    ordinamento = "decrescente";
                    selected_decrescente = true;
                    $(this).addClass('active');
                    selected_crescente = false;
                    $('#crescente').removeClass('active');
                }
                else {
                    ordinamento = "";
                    selected_decrescente = false;
                    $(this).removeClass('active');
                }
            });

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
                    dynamic_length_prezzo_minimo();
                    dynamic_length_prezzo_massimo();
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
                var ordine = ordinamento;
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
                    url: 'filtered.php',
                    method: 'POST',
                    data: {action:action, ordine:ordine, marca:marca, schermo:schermo, ram:ram, spazio:spazio, cpu:cpu, gpu:gpu, batteria:batteria, search:'<?php echo $search; ?>', prezzo_minimo:prezzo_minimo, prezzo_massimo:prezzo_massimo},
                    success:function(data) {
                        $('#ajaxResults').html(data);
                    }
                });
            };

        });
    </script>
    <?php
    if ($numberQueryLabelResults == 0) {
    ?>
        <div class="py-2 my-3 text-center">     
            <?php
            echo "<h2>Non ci sono prodotti di questa tipologia o corrispondenti con questo nome!<br>Prova a cercare un altro prodotto</h2>"; 
            ?>
        </div>
    <?php
    }
    else {
    ?>
        <div class="py-2 my-3 paddingBottoneFiltri"></div>
        <div class="container py-2 my-3 bottoneFiltri">
            <button type="button" class="btn btn-dark">Filtri</button>
        </div>
    <?php
    }
    ?>
    <div class="show-products container-fluid">
        <div class="row">
            <div class="col-xl-3" id="slideFiltri">
                <script type="text/javascript">
                    $(".bottoneFiltri").click(function() {
                        $("#slideFiltri").slideToggle();
                    });
                </script>
                <?php
                if ($numberQueryLabelResults > 0) {
                ?>
                <div class="card border-secondary rounded-3 p-3 card-filtri">
                    <h6>Ordina per prezzo</h6>
                    <div class="d-flex gap-3 filter_check">
                        <button type="button" class="btn btn-outline-secondary" id="crescente">Crescente</button>
                        <button type="button" class="btn btn-outline-secondary" id="decrescente">Decrescente</button>
                    </div>
                    <hr>
                    <h6>Scegli l'intervallo di prezzo da considerare</h6>
                    <div id="price_range"></div>
                    <div class="d-flex justify-content-between">
                        <div class="prezzo">
                            <input type="text" name="prezzoMinimo" id="prezzo_minimo" class="pointer" value="<?php echo $prezzo_minimo; ?>" readonly> 
                            <label for="prezzo_minimo">€</label>
                        </div>
                        <div class="prezzo">
                            <input type="text" name="prezzoMassimo" id="prezzo_massimo" class="pointer" value="<?php echo $prezzo_massimo; ?>" readonly>
                            <label for="prezzo_massimo">€</label>
                        </div>
                    </div>
                    <script type="text/javascript">
                        $(document).ready(dynamic_length_prezzo_minimo());
                        $(document).ready(dynamic_length_prezzo_massimo());

                        function dynamic_length_prezzo_minimo() {
                            var prezzoMinimoValue = $('#prezzo_minimo').val();
                            var minimoLength = prezzoMinimoValue.length;
                            $('#prezzo_minimo').css('width', minimoLength + 1 + 'ch');
                        }
                             
                        function dynamic_length_prezzo_massimo() {
                            var prezzoMassimoValue = $('#prezzo_massimo').val();
                            var massimoLength = prezzoMassimoValue.length;
                            $('#prezzo_massimo').css('width', massimoLength + 1 + 'ch');
                        }
                    </script>
                    <hr>
                    <h6>Scegli la marca</h6>
                    <?php
                    }
                    ?>
                    <ul class="list-group border-white">
                        <?php
                        $sql_query = "SELECT DISTINCT marca FROM prodotti WHERE (categoria = '$search' OR nome LIKE '$search%') ORDER BY marca";
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
                    $sql_query = "SELECT DISTINCT schermo FROM prodotti WHERE schermo IS NOT NULL AND schermo != '' AND (categoria = '$search' OR nome LIKE '$search%') ORDER BY schermo";
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
                    $sql_query = "SELECT DISTINCT ram FROM prodotti WHERE ram IS NOT NULL AND ram != '' AND (categoria = '$search' OR nome LIKE '$search%') ORDER BY LENGTH(ram), ram";
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
                    $sql_query = "SELECT DISTINCT spazio FROM prodotti WHERE spazio IS NOT NULL AND spazio != '' AND (categoria = '$search' OR nome LIKE '$search%') ORDER BY LENGTH(spazio), spazio";
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
                    $sql_query = "SELECT DISTINCT cpu FROM prodotti WHERE cpu IS NOT NULL AND cpu != '' AND (categoria = '$search' OR nome LIKE '$search%') ORDER BY cpu";          
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
                    $sql_query = "SELECT DISTINCT gpu FROM prodotti WHERE gpu IS NOT NULL AND gpu != '' AND (categoria = '$search' OR nome LIKE '$search%') ORDER BY gpu";          
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
                    $sql_query = "SELECT DISTINCT batteria FROM prodotti WHERE batteria IS NOT NULL AND batteria != '' AND (categoria = '$search' OR nome LIKE '$search%') ORDER BY batteria";          
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
            </div>
        </div>
    </div>
    <div class="modal fade" id="requiredAccount" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header justify-content-center">                     
                    <h3 class="modal-title">Attenzione!</h3>
                </div>
                <div class="modal-body">
                    È necessario aver effettuato l'accesso per poter proseguire!
                </div>
                <div class="modal-footer">
                    <a href="login.php" type="button" class="bottone">Login</a>
                    <a href="register.php" type="button" class="bottone">Registrati</a>
                    <button type="button" class="delete-bottone" data-bs-dismiss="modal">Chiudi</button>
                </div>
            </div>
        </div>
    </div>
    <footer class="py-3 my-4">    
</body>
</html>