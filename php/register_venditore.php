<?php
session_start();

$message='';
if(isset($_SESSION['email_alert'])){
    $message='Indirizzo email già esistente';
}
?>

<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../css/registrazione.css">
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.css" />
        <title>ShopWise - Registrazione</title>
        <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700;900&display=swap");
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@600&display=swap');

        body {
            font-family: "Poppins", sans-serif;
            background-color: #e98635;
            overflow: hidden;
        }
        
        .form-holder {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            min-height: 100vh;
        }

        .form-holder .form-content {
            position: relative;
            text-align: center;
            display: -webkit-box;
            display: -moz-box;
            display: -ms-flexbox;
            display: -webkit-flex;
            display: flex;
            -webkit-justify-content: center;
            justify-content: center;
            -webkit-align-items: center;
            align-items: center;
            padding: 60px;
        }

        .form-content .form-items {
            border: 3px solid #fff;
            padding: 40px;
            display: inline-block;
            width: 100%;
            min-width: 540px;
            -webkit-border-radius: 10px;
            -moz-border-radius: 10px;
            border-radius: 10px;
            text-align: left;
            -webkit-transition: all 0.4s ease;
            transition: all 0.4s ease;
        }

        .form-content h3 {
            color: #fff;
            text-align: left;
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .form-content h3.form-title {
            margin-bottom: 30px;
        }

        .form-content p {
            color: #fff;
            text-align: left;
            font-size: 17px;
            font-weight: 300;
            line-height: 20px;
            margin-bottom: 30px;
        }

        .form-content input[type="text"],
        .form-content input[type="password"],
        .form-content input[type="email"],
        .form-content select {
            width: 100%;
            padding: 9px 20px;
            text-align: left;
            border: 0;
            outline: 0;
            border-radius: 6px;
            background-color: #fff;
            font-size: 15px;
            font-weight: 300;
            color: #8d8d8d;
            -webkit-transition: all 0.3s ease;
            transition: all 0.3s ease;
            margin-top: 16px;
        }

        .btn-primary {
            color: #176791;
            outline: none;
            border: 0px;
            box-shadow: none;
        }

        .btn-primary:hover,
        .btn-primary:focus,
        .btn-primary:active {
            outline: none ;
            border: none ;
            box-shadow: none;
        }

        .form-content textarea {
            position: static !important;
            width: 100%;
            padding: 8px 20px;
            border-radius: 6px;
            text-align: left;
            background-color: #fff;
            border: 0;
            font-size: 15px;
            font-weight: 300;
            color: #8d8d8d;
            outline: none;
            resize: none;
            height: 120px;
            -webkit-transition: none;
            transition: none;
            margin-bottom: 14px;
        }

        .form-content textarea:hover,
        .form-content textarea:focus {
            border: 0;
            background-color: #ebeff8;
            color: #8d8d8d;
        }
        
        </style>
    </head>
    <body>
        <div class="header">
            <a href="../index.html" class="logo"><img src="../images/ShopWise-logo-header.png"></a>
            <div class="header-right">
                <a href="login_venditore.php" >Accedi</a>
            </div>
        </div>
        <div class="form-body">
            <div class="row">
                <div class="form-holder">
                    <div class="form-content">
                        <div class="form-items">
                            <h3>Registrati a ShopWise!</h3>
                            <p>Se non sei un venditore <a href="register.php">clicca qui</a></p>
                            <p><?php echo $message; ?></p>
                            <form action="check_registration_venditore.php" method="POST" name="form_registrazione" id="idform" class="form-registrazione">
    
                                <div class="col-md-12">
                                   <input class="form-control" type="text" name="nome" placeholder="Nome" required>
                                </div>
                                
                                <div class="col-md-12">
                                    <input class="form-control" type="text" name="cognome" placeholder="Cognome" required>
                                 </div>

                                <div class="col-md-12">
                                    <input class="form-control" type="email" name="email" placeholder="Indirizzo e-mail" required>
                                </div>
                                
                                <div class="col-md-12">
                                    <input class="form-control" type="password" name="password" placeholder="Password" required>
                                </div>

                                <div class="col-md-12">
                                    <input class="form-control" type="text" name="indirizzo" placeholder="Indirizzo" required>
                                </div>
                                <div class="col-md-12">
                                    <input id="venditore" type="text" name="venditore" placeholder="Venditore" autofocus required />
                                </div>   
                                <div class="form-button mt-3">
                                    <button id="submit" type="submit" class="btn btn-primary">Registrati</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php unset($_SESSION['email_alert']); ?>
    </body>
</html>

