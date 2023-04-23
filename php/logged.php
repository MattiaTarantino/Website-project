<html>
<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../css/style.css">
        <title>ShopWise</title>
        <style>
        .account{
            margin-right: 26px;
            }
        </style>
    </head>
    <body>
        <div class="header">
            <a href="#top" class="logo"><img src="../images/ShopWise-logo-header.png"></a>
            <div class="header-right">
                <a href="account.php" class="account">Account</a>
            </div>
        </div>
        <img class="logo-homepage" src="../images/ShopWise logo.png">
            <form action="page_search.php" method="post" role="search" id="idform2">
                <label for="search">Cerca</label>
                <input id="search" type="search" placeholder="Cerca un prodotto..." name="search-field" autofocus required />
                <button class="vai" type="submit" form="idform2" name="submit-search">Vai</button>    
            </form>
        <div class="spiegazione">
                Cerca il prodotto di tuo interesse e ShopWise ti aiuterà a trovare l'offerta migliore per te!
        </div>
    </body>
</html>
