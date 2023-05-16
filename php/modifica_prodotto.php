<?php
require_once('config.php');
session_start();
if(isset($_GET["id"])) {
    if (isset($connessione)) {
        $id_prodotto = $connessione->real_escape_string($_GET['id']);
        $result = mysqli_query($connessione, "SELECT * FROM prodotti WHERE id_prodotto = '$id_prodotto'") or die('query failed');


        if (mysqli_num_rows($result) > 0) {
            $old = mysqli_fetch_assoc($result);

            $categoria = $old['categoria'];
            $nome = $old['nome'];
            $marca = $old['marca'];
            $venditore = $old['venditore'];
            $prezzo = $old['prezzo'];
            $immagine = $old["immagine"];
            $schermo = $old['schermo'];
            $spazio = $old['spazio'];
            $ram = $old['ram'];
            $gpu = $old['gpu'];
            $cpu = $old['cpu'];
            $batteria = $old['batteria'];
        }

        if (isset($_POST['modifica_prodotto'])) {
            $update_categoria = $connessione->real_escape_string($_POST['update_categoria']);
            $update_nome_prodotto = $connessione->real_escape_string($_POST['update_nome_prodotto']);
            $update_marca_prodotto = $connessione->real_escape_string($_POST['update_marca_prodotto']);
            $venditore = $_SESSION['venditore'];
            $update_prezzo_prodotto = $connessione->real_escape_string($_POST['update_prezzo_prodotto']);
            $update_fileName = basename($_FILES["update_foto_prodotto"]["name"]);
            $update_schermo_prodotto = $connessione->real_escape_string($_POST['update_schermo_prodotto']);
            $update_spazio_prodotto = $connessione->real_escape_string($_POST['update_spazio_prodotto']);
            $update_ram_prodotto = $connessione->real_escape_string($_POST['update_ram_prodotto']);
            $update_gpu_prodotto = $connessione->real_escape_string($_POST['update_gpu_prodotto']);
            $update_cpu_prodotto = $connessione->real_escape_string($_POST['update_cpu_prodotto']);
            $update_batteria_prodotto = $connessione->real_escape_string($_POST['update_batteria_prodotto']);
            if ($update_fileName != "") {
                $fileType = pathinfo($update_fileName, PATHINFO_EXTENSION);
                $allowTypes = array('jpg', 'png', 'jpeg');
                if (in_array($fileType, $allowTypes)) {
                    $image = $_FILES['update_foto_prodotto']['tmp_name'];
                    $imgContent = addslashes(file_get_contents($image));

                    $update = mysqli_query($connessione, "UPDATE prodotti SET categoria = '$update_categoria', nome = '$update_nome_prodotto', immagine = '$imgContent', marca = '$update_marca_prodotto', 
                    prezzo = '$update_prezzo_prodotto', schermo = '$update_schermo_prodotto', ram = '$update_ram_prodotto', spazio = '$update_spazio_prodotto', cpu = '$update_cpu_prodotto', gpu = '$update_gpu_prodotto', 
                    batteria = '$update_batteria_prodotto' WHERE id_prodotto = '$id_prodotto'");

                    if ($update) {
                        $message_good[] = "Prodotto modificato con successo";
                    } else {
                        $message_bad[] = "Modifica prodotto fallita";
                    }
                } else {
                    $message_bad[] = "Formato della foto non supportato";
                }
            }
            else {
                if ($update_categoria != $categoria || $update_nome_prodotto != $nome ||$update_marca_prodotto != $marca ||$update_prezzo_prodotto != $prezzo ||$update_schermo_prodotto != $schermo||$update_ram_prodotto != $ram ||$update_gpu_prodotto != $gpu || $update_cpu_prodotto != $cpu || $update_batteria_prodotto != $batteria){
                    $update = mysqli_query($connessione, "UPDATE prodotti SET categoria = '$update_categoria', nome = '$update_nome_prodotto', marca = '$update_marca_prodotto', prezzo = '$update_prezzo_prodotto',
                    schermo = '$update_schermo_prodotto', ram = '$update_ram_prodotto', spazio = '$update_spazio_prodotto', cpu = '$update_cpu_prodotto', gpu = '$update_gpu_prodotto', batteria = '$update_batteria_prodotto' 
                    WHERE id_prodotto = '$id_prodotto' ");
                    if ($update) {
                        $message_good[] = "Prodotto modificato con successo";
                    } else {
                        $message_bad[] = "Modifica prodotto fallita";
                    }
            }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShopWise-ModificaProdotto</title>
    <link rel="stylesheet" href="../css/account.css">
</head>
<body>
<div class="header">
    <a href="pagina_venditore.php" class="logo"><img src="../images/ShopWise-logo-header.png"></a>
</div>

<div class="update-profile">
    <form action="" method="post" enctype="multipart/form-data">
        <?php
        if(isset($message_good)){
            foreach($message_good as $message){
                echo '<div class="message_good">'.$message.'</div>';
            }
        }
        if(isset($message_bad)){
            foreach($message_bad as $message){
                echo '<div class="message_bad">'.$message.'</div>';
            }
        }
        $refresh= mysqli_query($connessione, "SELECT * FROM prodotti WHERE id_prodotto = '$id_prodotto'") or die('query failed');


        if (mysqli_num_rows($refresh) > 0) {
            $new = mysqli_fetch_assoc($refresh);

            $new_categoria = $new['categoria'];
            $new_nome = $new['nome'];
            $new_marca = $new['marca'];
            $new_venditore = $new['venditore'];
            $new_prezzo = $new['prezzo'];
            $new_immagine = $new["immagine"];
            $new_schermo = $new['schermo'];
            $new_spazio = $new['spazio'];
            $new_ram = $new['ram'];
            $new_gpu = $new['gpu'];
            $new_cpu = $new['cpu'];
            $new_batteria = $new['batteria'];
        }
        ?>
        <div class="flex">
            <div class="inputBox">
                <span>Categoria :</span>
                <select name="update_categoria" id="categoria" class="box" required>
                    <option value="" disabled>Scegli una categoria</option>
                    <option value="cuffie" <?php if ($new_categoria == "cuffie") echo "selected" ?> > Cuffie </option>
                    <option value="laptop" <?php if ($new_categoria == "laptop") echo "selected" ?> > Laptop </option>
                    <option value="smartwatch" <?php if ($new_categoria == "smartwatch") echo "selected" ?> > Smartwatch </option>
                    <option value="tablet" <?php if ($new_categoria == "tablet") echo "selected"  ?> > Tablet </option>
                    <option value="telefono" <?php if ("$new_categoria" == "telefono") echo "selected" ?> > Telefono</option>
                    <option value="televisore" <?php if ("$new_categoria" == "televisore") echo "selected" ?> > Televisore</option>
                </select>
                <span>Prezzo :</span>
                <input type="text" name="update_prezzo_prodotto" class="box" value="<?php echo $new_prezzo; ?>" required>
                <span>Immagine prodotto :</span>
                <input type="file" name="update_foto_prodotto" class="box">
                <span>Grandezza schermo :</span>
                <input type="text" name="update_schermo_prodotto" placeholder="Opzionale" value="<?php echo $new_schermo; ?>" class="box">
                <span>Spazio di archiviazione :</span>
                <input type="text" name="update_spazio_prodotto" placeholder="Opzionale" value="<?php echo $new_spazio; ?>" class="box">
                <span>Ram :</span>
                <input type="text" name="update_ram_prodotto" placeholder="Opzionale" value="<?php echo $new_ram; ?>" class="box">
            </div>
            <div class="inputBox">
                <span>Nome del prodotto :</span>
                <input type="text" name="update_nome_prodotto" class="box" value="<?php echo $new_nome; ?>" required>
                <span>Marca :</span>
                <input type="text" name="update_marca_prodotto" class="box" value="<?php echo $new_marca; ?>" required>
                <span style="color: white; user-select: none;" >.</span>
                <input style="background-color: white" type="text" name="indent" class="box" disabled>
                <span>Batteria :</span>
                <input type="text" name="update_batteria_prodotto" placeholder="Opzionale" value="<?php echo $new_batteria; ?>" class="box">
                <span>CPU :</span>
                <input type="text" name="update_cpu_prodotto" placeholder="Opzionale" value="<?php echo $new_cpu; ?>" class="box">
                <span>GPU :</span>
                <input type="text" name="update_gpu_prodotto" placeholder="Opzionale" value="<?php echo $new_gpu; ?>" class="box">
            </div>
        </div>
        <input type="submit" value="Modifica prodotto" name="modifica_prodotto" class="btn">
        <a href="prodotti_venditore.php" class="btn">Torna indietro</a>
    </form>
</div>
</body>
<?php unset($message_good);
unset($message_bad);
?>
</html>


