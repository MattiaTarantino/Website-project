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
    <title>RicercaProdotti</title>
</head>
<body>
    <div class="header">
        <a href="#top" class="logo"><img src="../images/ShopWise-logo-header.png"></a>
        <div class="header-right">
            <a href="../html/login.html" class="accedi">Accedi</a>
            <a href="../html/registrazione.html" class="registrati">Registrati</a>
        </div>
        <div class="header-center">
            <form action="?" method="post" role="search" id="idform3">
                <label for="search">Cerca</label>
                <input id="search" type="search" placeholder="Cerca un prodotto..." name="search-field" autofocus required />
                <button class="vai" type="submit" form="idform3" name="submit-search">Vai</button>    
            </form>        
        </div>
    </div>
    <?php
    if (isset($_POST['submit-search'])) {
        $search = mysqli_real_escape_string($connessione, $_POST['search-field']);
    }
    
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $sql_select = "SELECT * FROM prodotti WHERE categoria = '$search' OR nome LIKE '%$search%'";
        $result = mysqli_query($connessione, $sql_select);
        $numberQueryResults = mysqli_num_rows($result);
        if ($numberQueryResults > 0) {
            echo "<br>Abbiamo trovato ".$numberQueryResults." risultati<br>";
        }
        else {
            echo "<div class='text-center'>
                    <h1>Non ci sono prodotti di questa tipologia o corrispondenti con questo nome!<br>Prova a cercare un altro prodotto</h1>
                </div>";
        }
    }
    ?>
    <div class="show-products">
        <div class="box-container">
            <?php
            while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            ?>
            <div class="box">
                <img <?= "src='data:immagine/jpeg;base64,".base64_encode($row['immagine'])."';" ?> />
                <div class="name"><?= $row['nome']; ?> </div>
                <div class="price"><?= $row['prezzo']; ?> </div>
                <div class="shop">Venditore: <?= $row['venditore']; ?> </div>
                <div class="details">Specifiche tecniche:
                    <div>Marca: <?= $row['marca']; ?> </div>
                    <div>Schermo: <?= $row['schermo']; ?> </div>
                    <div>Ram: <?= $row['ram']; ?> </div>
                    <div>Spazio: <?= $row['spazio']; ?> </div>
                    <div>CPU: <?= $row['cpu']; ?> </div>
                    <div>GPU: <?= $row['gpu']; ?> </div>
                    <div>Batteria: <?= $row['batteria']; ?> </div>
                </div>
               <!--  <div class="flex-btn"> -->
                    <button class="btn btn-success btn-lg">Prenota</button>
                <!-- </div> -->
            </div>
        <?php
            }
        ?>
        </div>
    </div>
</body>
</html>