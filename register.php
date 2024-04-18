<?php
    // error_reporting(E_ERROR | E_PARSE);
    

    require "./classes/adatbazis.class.php";
    require "./classes/muvelet.class.php";
    
    if(!empty($_SESSION["id"])){
        echo 
            "<script>
                window.location.href = 'index.php'; 
            </script>";
        exit();
    }

    $regisztracio = new Regisztracio();

    if(isset($_POST['submit'])){
        $nev = filter_var($_POST['name'], FILTER_SANITIZE_STRIPPED);
        $felhasznalo = filter_var($_POST['username'], FILTER_SANITIZE_STRIPPED);
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $jelszo = filter_var($_POST['password'], FILTER_SANITIZE_STRIPPED);
        $mjelszo = filter_var($_POST['password_confirm'], FILTER_SANITIZE_STRIPPED);

        if(empty($nev) || empty($felhasznalo) || empty($email) || empty($jelszo) || empty($mjelszo)){
            echo "<script>alert('Minden mezőt ki kell tölteni!')</script>";
        } else {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo "<script>alert('Érvénytelen email cím!')</script>";
            } else {
                $vegrehajtas = $regisztracio->regisztral($nev, $felhasznalo, $email, $jelszo, $mjelszo);
                
                switch ($vegrehajtas) {
                    case 1:
                        header("Location: index.php");
                        exit();
                    case 0:
                        echo "<script>alert('A megadott felhasználónév vagy email cím már használatban van!')</script>";
                        break;
                    case -1:
                        echo "<script>alert('A két jelszó nem egyezik!')</script>";
                        break;
                    case -2:
                        echo "<script>alert('Hiba történt a regisztráció közben!')</script>";
                        break;
                    default:
                        echo "<script>alert('Ismeretlen hiba történt!')</script>";
                        break;
                }
            }
        }
    }


    $url = basename($_SERVER['PHP_SELF']);
    $_SESSION['return_url'] = $url;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regisztráció</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="./css/main.css">
</head>
<body class="regisztralo">
    <div class="container">
            <div class="row mx-0 my-2">
                <div class="col-md-5 pr-0">
                    <div class="p-4 bg-light h-100 bejelentkezo-form position-relative">
                        <h3 class="korvonal align-self-center">Regisztráció</h3>
                        <form id="regisztralo" action="" method="post" autocomplete="off">
                            <label  class="display-5 korvonal" for="name">Név: </label>
                            <input type="text" name="name" id="name" required class="form-control mb-2">
                            <label  class="display-5 korvonal" for="username">Felhasználónév: </label>
                            <input type="text" name="username" id="username" required class="form-control mb-2">
                            <label  class="display-5 korvonal" for="email">Email: </label>
                            <input type="email" name="email" id="email" required class="form-control mb-2">
                            <label  class="display-5 korvonal" for="">Jelszó: </label>
                            <input type="password" name="password" id="password-input" required class="form-control mb-2 password-input"><i class="korvonal fa fa-eye-slash show-passwd float-right p-2"></i><br>
                            <div class="jelszoerosseg">
                                <h6><b>A jelszó:</b></h6>
                                <ul class="lista">
                                    <li class="list-item">legalább 8 karakter hosszú</li>
                                    <li class="list-item">tartalmaz legalább 1 numerikus karaktert</li>
                                    <li class="list-item">tartalmaz legalább 1 kisbetűs karaktert</li>
                                    <li class="list-item">tartalmaz legalább 1 nagybetűs karaktert</li>
                                    <li class="list-item">tartalmaz legalább 1 speciális karaktert</li>
                                </ul>
                            </div>
                            <label  class="display-5 korvonal" for="password_confirm">Jelszó megerősítése: </label>
                            <input type="password" name="password_confirm" id="password-confirm" required class="form-control mb-2 password-c-input"><i class="korvonal fa fa-eye-slash show-passwd-c float-right p-2"></i>
                            <input type="submit" value="Regisztrálás!" name="submit" required class="btn btn-warning btn-block mb-2">
                        </form>
                        <br>
                        <hr class="elvalaszto">
                        <p class="marregisztralt"><i style="font-size:12px">Már regisztrált?</i></p>
                        <a class="loginkorvonal text-center" href="./login.php">Bejelentkezés</a>
                    </div>
                </div>
                <div class="col-md-7 d-none d-md-block pl-0">
                    <button type='button' class=close aria-label='Close' onclick=window.location.href='index.php'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                    <img src="./img/pizzabg.jpg" class="loginkep img-fluid h-100">
                </div>
            </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script defer src="./js/jelszo.js"></script>
    

</body>
</html>



