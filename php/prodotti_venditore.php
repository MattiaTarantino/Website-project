<?php
require_once('config.php');
session_start();
$venditore = $_SESSION['venditore'];
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="../css/search.css">
    <title>Shopwise - I tuoi prodotti</title>
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>
<div class="header">
    <a href="pagina_venditore.php" class="logo"><img src="../images/ShopWise-logo-header.png"></a>
    <div class="header-right">
        <a href="pagina_venditore.php" class="registrati">Aggiungi</a>
        <a href="aggiorna_account_venditore.php" class="account">Account</a>
    </div>
    <div class="header-center">
        <form action="?" class="ricerca" method="post" role="search" id="idform3">
            <label class="label-search" for="search">Cerca</label>
            <input class="search-field" id="search" type="search" placeholder="Cerca un prodotto..." name="search-field" autofocus required />
            <button class="vai" type="submit" form="idform3" name="submit-search">Vai</button>
        </form>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $(".hideDetails").hide();
    });
</script>
<?php
if (isset($_POST['submit-search'])) {
    if (isset($connessione)) {
        $search = mysqli_real_escape_string($connessione, $_POST['search-field']);
    }
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $sql_select = "SELECT * FROM prodotti WHERE (categoria = '$search' OR nome LIKE '%$search%') AND venditore = '$venditore' ";
        $result = mysqli_query($connessione, $sql_select);
        $numberQueryResults = mysqli_num_rows($result);
        if ($numberQueryResults > 0) {
            echo "<div class='py-2 my-3 text-center'> <h2>Abbiamo trovato ".$numberQueryResults." risultati </h2></div>";
        }
        else {
            echo "<div class='text-center'>
                    <h1>Non ci sono prodotti di questa tipologia o corrispondenti con questo nome!<br>Prova a cercare un altro prodotto</h1>
                </div>";
        }
    }
}
else {
    $sql_select = "SELECT * FROM prodotti WHERE venditore = '$venditore' ";
    if (isset($connessione)) {
        $result = mysqli_query($connessione, $sql_select);
    }
    $numberQueryResults = mysqli_num_rows($result);
    if ($numberQueryResults > 0) {
        echo "<div class='py-2 my-3 text-center'><h2> Abbiamo trovato ".$numberQueryResults." risultati</h2> </div>";
    } else {
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
            <div class="box" id="<?php echo $row['id_prodotto']; ?>">
                <img <?= "src='data:immagine/jpeg;base64,".base64_encode($row['immagine'])."';" ?> />
                <div class="name"><?= $row['nome']; ?> </div>
                <div class="price"><?= $row['prezzo']; ?> </div>
                <div class="shop">Venditore: <?= $row['venditore']; ?> </div>
                <div class="details">
                    <h4 class="<?php echo "testo" . $row['id_prodotto']; ?>">Specifiche tecniche: <span id="<?php echo "more". $row['id_prodotto']; ?>" class="material-symbols-outlined" >expand_more</span><span id="<?php echo "less" . $row['id_prodotto']; ?>" class="material-symbols-outlined" >expand_less </span></h4>
                    <div class="hideDetails" id="<?php echo "specifiche" . $row['id_prodotto']; ?>">
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
                        $("<?php echo "#" . "specifiche". $row['id_prodotto']; ?>").slideToggle();
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
                <button onclick="cancellaprodotto(<?php echo $row['id_prodotto']; ?>)" class="btn btn-danger btn-lg">Rimuovi</button>
            </div>
            <?php
        }
        ?>
    </div>
</div>
<script type="text/javascript">

    function cancellaprodotto(id) {
        if (confirm("Sei sicuro di voler cancellare il prodotto da Shopwise?")) {
            $(document).ready(function () {
                $.ajax({
                    url: 'cancella_prodotto.php',
                    type: 'POST',
                    data: {
                        id: id,
                        action: "delete"
                    },
                    success: function (response) {
                        if (response == 1) {
                            alert("Prodotto cancellato con successo");
                            document.getElementById(id).style.display = "none";
                        } else if (response == 0) {
                            alert("Il prodotto non può essere cancellato");
                        }
                    }
                })
            })
        }
    }
</script>
</body>
</html>