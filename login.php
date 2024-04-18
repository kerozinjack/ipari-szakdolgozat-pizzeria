<?php
    require "./classes/adatbazis.class.php";
    require "./classes/muvelet.class.php";
    if(!empty($_SESSION["id"])){
        echo 
        "<script>
            window.location.href = 'index.php'; 
        </script>";    
    }

    $bejelentkezes=new Bejelentkezes();

    if(isset($_POST["submit"])){
        $felhasznalo_v_email=$_POST['usernameOrEmail'];
        $jelszo=$_POST['password'];

        $vegrehajtas=$bejelentkezes->bejelentkez($felhasznalo_v_email,$jelszo);

        switch ($vegrehajtas) {
            case 1:
                $_SESSION["id"]=$bejelentkezes->felhasznaloId();
                // echo $bejelentkezes->felhasznaloId();
                echo 
                    "<script>
                        alert('Sikeres bejelentkezés!')
                    </script>
                    <script>
                        window.location.href = 'index.php'
                    </script>";
                break;
            case 0:
                echo 
                    "<script>
                        alert('Helytelen jelszó!')
                    </script>";
                    break;
            case -1:
                echo
                    "<script>
                        alert('A megadott felhasználónév nincs regisztrálva!')
                    </script>"; 
                    break;
            default:
                echo "idk";
                break;
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
    <title>Bejelentkezés</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="./css/main.css">
</head>
<body class="bejelentkezo">
    <div class="container center-container">
        <div class="row mx-0 my-2">
            <div class="col-md-5 pr-0">
                <button type='button' class='close d-block d-md-none text-dark' aria-label='Close' onclick=window.location.href='index.php'>
                    <span aria-hidden='true'>&times;</span>
                </button>
                <div class="p-4 bg-light h-100 bejelentkezo-form position-relative">
                  <h4 class="korvonal align-self-center">Bejelentkezés</h4>
                    <form action="" method="post" autocomplete="off" >
                        <label class="display-5 korvonal" for="usernameOrEmail">Felhasználónév vagy Email cím:</label><br>
                        <input type="text" name="usernameOrEmail" id="usernameOrEmail" class="form-control mb-2" required><br>
                        <label for="password" class="display-5 korvonal">Jelszó:</label><br>
                        <input type="password" name="password" id="password-input" class="form-control mb-2" required><i class="korvonal fa fa-eye-slash show-passwd float-right p-2 login-show"></i><br>
                        <input type="submit" value="Bejelentkezés!" name="submit" class="btn btn-warning btn-block mb-2"><br>
                    </form>
                    <br>
                    <hr class="elvalaszto">
                    <p class="nemregisztralt"><i style="font-size:12px">Még nem regisztrált?</i></p>
                    <a class="regisztraciokorvonal text-center" href="./register.php">Regisztráció</a>
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
