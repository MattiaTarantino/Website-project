<?php
require_once('config.php');
session_start();

if ($_SESSION['email'] != "admin@admin.com")
    header("location: ../index.html" )

?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="../css/search.css">
    <title>Shopwise - ITuoiProdotti</title>
    <script type="text/javascript" src="../bootstrap/js/bootstrap.js"> </script>
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>
<div class="header">
    <a href="logout.php" class="logo"><img src="../images/ShopWise-logo-header.png"></a>
    <div class="header-right">
        <a href="aggiungi_admin.php" class="registrati">Aggiungi</a>
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
        $sql_select = "SELECT * FROM prodotti WHERE (categoria = '$search' OR nome LIKE '%$search%')";
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
    $sql_select = "SELECT * FROM prodotti";
    if (isset($connessione)) {
        $result = mysqli_query($connessione, $sql_select);
    }
    $numberQueryResults = mysqli_num_rows($result);
    if ($numberQueryResults > 0) {
        echo "<div class='py-2 my-3 text-center'><h2> Abbiamo trovato ".$numberQueryResults." risultati</h2> </div>";
    } else {
        echo "<div style='margin-top: 50px' class='text-center'>
                   <h1>Non ci sono prodotti di questa tipologia o corrispondenti con questo nome!</h1>
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
                <div class="price"><h2><?= $row['prezzo']; ?> </h2></div>
                <div class="shop">Venditore: <?= $row['venditore']; ?> </div>
                <div class="details">
                    <h4 class="<?php echo "testo" . $row['id_prodotto']; ?>">Specifiche tecniche: <span id="<?php echo "more". $row['id_prodotto']; ?>" class="material-symbols-outlined" >expand_more</span><span id="<?php echo "less" . $row['id_prodotto']; ?>" class="material-symbols-outlined" >expand_less </span></h4>
                    <div class="hideDetails" id="<?php echo "specifiche" . $row['id_prodotto']; ?>">
                        <div>Marca: <?php echo $row['marca']; ?> </div>
                        <?php
                        if (!is_null($row['schermo']) && $row['schermo'] != '' ) {
                            echo "Schermo: ". $row['schermo'] ."<br>";
                        }
                        if (!is_null($row['ram']) && $row['ram'] != '' ) {
                            echo "Ram: ". $row['ram'] ."<br>";
                        }
                        if (!is_null($row['spazio']) && $row['spazio'] != '' ) {
                            echo "Spazio: ". $row['spazio'] ."<br>";
                        }
                        if (!is_null($row['cpu']) && $row['cpu'] != '' ) {
                            echo "CPU: ". $row['cpu'] ."<br>";
                        }
                        if (!is_null($row['gpu']) && $row['gpu'] != '' ) {
                            echo "GPU: ". $row['gpu'] ."<br>";
                        }
                        if (!is_null($row['batteria']) && $row['batteria'] != '' ) {
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
                <a href="modifica_prodotto_admin.php?id=<?php echo $row['id_prodotto']?>" class="btn btn-primary btn-lg">Modifica</a>
                <button data-nome="<?php echo $row['nome']; ?>" data-id="<?php echo $row['id_prodotto']; ?>" class="rimuovi btn btn-danger btn-lg" data-bs-toggle="modal" data-bs-target="#confirmDelete">Rimuovi</button>
            </div>
            <?php
        }
        ?>
        <div class="modal modal-lg fade" id="confirmDelete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header justify-content-center">
                    </div>
                    <div class="modal-body">
                        Una volta rimosso non sarà più visualizzato su Shopwise e non potrà essere recuperato.
                    </div>
                    <div class="modal-footer">
                        <button class="cancella delete-bottone" data-bs-dismiss="modal">Cancella</button>
                        <button type="button" class="bottone" data-bs-dismiss="modal">Annulla</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    $(document).ready(function (){
        $('.rimuovi').click(function (){
            var id = $(this).data('id') ;
            var nome = 'Sei sicuro di voler rimuovere ' + $(this).data('nome') + '?';
            var h3 = '<h3>' + nome + '</h3>';
            $('.modal-header').html(h3);


            $('.cancella').click(function () {
                $.ajax({
                    url: 'cancella_prodotto.php',
                    type: 'POST',
                    data: {
                        id: id,
                        action: "delete"
                    },
                    success: function (response) {
                        if (response == 1) {
                            document.getElementById(id).style.display = "none";
                        } else if (response == 0) {
                            alert("Il prodotto non può essere cancellato");
                        }
                    }
                });
            });
        });
    });
</script>
</body>
</html>