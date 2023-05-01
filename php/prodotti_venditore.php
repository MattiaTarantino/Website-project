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
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js">
    </script>
</head>
<body>
<div class="header">
    <a href="pagina_venditore.php" class="logo"><img src="../images/ShopWise-logo-header.png"></a>
    <div class="header-right">
        <a href="pagina_venditore.php" class="registrati">Aggiungi</a>
        <a href="aggiorna_account_venditore.php" class="account">Account</a>
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
    if (isset($connessione)) {
        $search = mysqli_real_escape_string($connessione, $_POST['search-field']);
    }
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $sql_select = "SELECT * FROM prodotti WHERE (categoria = '$search' OR nome LIKE '%$search%') AND venditore = '$venditore' ";
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
}
else {
    $sql_select = "SELECT * FROM prodotti WHERE venditore = '$venditore' ";
    if (isset($connessione)) {
        $result = mysqli_query($connessione, $sql_select);
    }
    $numberQueryResults = mysqli_num_rows($result);
    if ($numberQueryResults > 0) {
        echo "<br>Abbiamo trovato " . $numberQueryResults . " risultati<br>";
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
                <div class="details">Specifiche tecniche:
                    <div>Marca: <?= $row['marca']; ?> </div>
                    <div>Schermo: <?= $row['schermo']; ?> </div>
                    <div>Ram: <?= $row['ram']; ?> </div>
                    <div>Spazio: <?= $row['spazio']; ?> </div>
                    <div>CPU: <?= $row['cpu']; ?> </div>
                    <div>GPU: <?= $row['gpu']; ?> </div>
                    <div>Batteria: <?= $row['batteria']; ?> </div>
                </div>
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