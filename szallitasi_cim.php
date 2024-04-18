<?php
    require "./classes/adatbazis.class.php";
    require "./classes/muvelet.class.php";

    $felhasznalo=new Felhasznalo();

    if(!empty($_SESSION["id"])){
        $id=$_SESSION["id"];

        $bejelentkezett_felhasznalo=$felhasznalo->felhasznalo_kivalasztasa($id);
        
    }

    if(!empty($_SESSION['cart'])){
      $rendeles=new CRUD();
      if(isset($_POST['rendelesveglegesites'])){
        $nev=$_POST['nev'];
        $email=$_POST['email'];
        $tel=$_POST['telszam'];
        $szallitasicim=$_POST['szallitasicim'];
        $termekek=$_SESSION['termekek'];
        $fizetendo=$_SESSION['fizetendo'];

  

        $muvelet=$rendeles->rendeles_leadas($nev,$email,$tel,$szallitasicim,$termekek,$fizetendo);

        if($muvelet['valasz']=="Sikeres művelet!"){
          echo 
              "<script>
                alert('Rendelését rögzítettük!')
              </script>";
        }
        else{
          echo 
              "<script>
                alert('Rendelése rögzítetésekor hiba lépett fel!')
              </script>";
        }
        unset($_SESSION['cart']);
        echo 
          "<script>
            window.location.href='rendeleseim.php';
          </script>";

      }
    }
    else{
      echo 
      "<script>
      window.location.href='kosar.php';
      </script>";
    }

    

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rendelés</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="./css/main.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light justify-content-center">
            <button class="navbar-toggler btn btn-warning" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon bg-warning rounded"></span>
            </button>
            <div class="text-center">
              <a class="navbar-brand d-lg-none" href="./index.php">
                <img src="./img/logo_final.png" class="text-center img-fluid" alt="Leveld Gasztroudvar Városlőd">
              </a>
            </div>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item mx-auto">
                      <a class="nav-link text-center" href="./categories/pizzas.php">Pizzák<br><img src="./img/pizza.png" class="text-center justify-content-center"></a>
                      
                    </li>
                    <li class="nav-item mx-auto">
                      <a class="nav-link text-center" href="./categories/pastas.php">Tészták<br><img src="./img/pasta.png" class="text-center justify-content-center"></a>
                      
                    </li>
                    <li class="nav-item mx-auto">
                      <a class="nav-link text-center" href="./categories/salads.php">Saláták<br><img src="./img/salad.png" class="text-center justify-content-center"></a>
                      
                    </li>
                    <li class="nav-item mx-auto">
                      <a class="nav-link text-center" href="./categories/hamburgers.php">Hamburgerek<br><img src="./img/burger.png" class="text-center justify-content-center"></a>
                      
                    </li>
                    <a class="navbar-brand d-none d-lg-block" href="./index.php">
                      <img src="./img/logo_final.png" class="text-center img-fluid" alt="Leveld Gasztroudvar Városlőd">
                    </a>
                    <li class="nav-item mx-auto">
                      <a class="nav-link text-center" href="./categories/bowls.php">Többszemélyes<br>tálak<br><img src="./img/plate.png" class="text-center justify-content-center"></a>
                      
                    </li>
                    <li class="nav-item mx-auto">
                      <a class="nav-link text-center" href="./categories/gyros.php">Gyros<br>tálak<br><img src="./img/gyros.png" class="text-center justify-content-center"></a>
                      
                    </li>
                    <li class="nav-item mx-auto">
                      <a class="nav-link text-center" href="./categories/friedstuff.php">Frissensültek<br><img src="./img/frissensult.png" class="text-center justify-content-center"></a>
                      
                    </li>
                    <li class="nav-item dropdown">
                      <a class="nav-link text-center dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Extrák<br><img src="./img/extra.png" class="text-center justify-content-center"></a>
                      <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a href="./categories/sidedishes.php" class="dropdown-item">Köretek</a>
                        <a href="./categories/dressings.php" class="dropdown-item">Öntetek</a>
                        <a href="./categories/drinks.php" class="dropdown-item">Üdítők</a>
                        <div class="dropdown-divider"></div>
                        <a href="./categories/extras.php" class="dropdown-item">Kiegészítők</a>
                      </div>
                    </li>
                </ul>
            </div>
    </nav>
    <form action="" method="post">
        <?php
          // var_dump($_SESSION);
            if(isset($_SESSION['id'])){
                // var_dump($felhasznalo->felhasznalo_kivalasztasa($_SESSION['id']));
                $html="";
                $html.=
                "<div class='container-fluid'>
                    <div class='row justify-content-center'>
                        <div class='col-lg-8 col-md-10 col-sm-12 my-5 szcim-elerhetoseg'>
                            <h4 class='korvonal my-3'>Szállítási cím, elérhetőség</h4>
                            <hr>
                            <form class='my-5'>
                                <div class='form-group'>
                                    <label for='nev'>Név:</label>
                                    <input type='text' class='form-control' id='nev' name='nev' value='".$bejelentkezett_felhasznalo[0]['name']."' required>
                                </div>
                                <div class='form-group'>
                                    <label for='email'>Email:</label>
                                    <input type='email' class='form-control' id='email' name='email' value=".$bejelentkezett_felhasznalo[0]['email']." required>
                                </div>
                                <div class='form-group'>
                                    <label for='telszam'>Telefonszám:</label>
                                    <input type='tel' class='form-control' id='telszam' name='telszam' required>
                                </div>
                                <div class='form-group'>
                                    <label for='szallitasicim'>Szállítási cím (Ha üresen hagyja akkor az személyes átvételt jelent):</label>
                                    <input type='text' class='form-control' id='szallitasicim' name='szallitasicim'>
                                </div>
                                <input type='hidden' name='termekek' value=".$_SESSION['termekek'].">
                                <input type='hidden' name='osszesen' value=".$_SESSION['fizetendo'].">
                                <button type='submit' class='btn btn-success btn-block mt-3 mb-3' name='rendelesveglegesites'>Rendelés leadása</button>
                            </form>
                            <a href='kosar.php' class='btn btn-primary my-1'>Vissza az előző oldalra</a>
                        </div>
                    </div>
                </div>";
                echo $html;

            }
            else{
              $html="";
              $html.=
              "<div class='container-fluid'>
                  <div class='row justify-content-center'>
                    <div class='col-lg-8 col-md-10 col-sm-12 my-5 szcim-elerhetoseg'>
                      <h4 class='korvonal'>Szállítási cím, elérhetőség</h4>
                      <hr>
                      <form class='my-5'>
                        <div class='form-group'>
                          <label for='nev'>Név:</label>
                          <input type='text' class='form-control' id='nev' name='nev' required>
                        </div>
                        <div class='form-group'>
                          <label for='email'>Email:</label>
                          <input type='email' class='form-control' id='email' name='email' required>
                        </div>
                        <div class='form-group'>
                          <label for='telszam'>Telefonszám:</label>
                          <input type='tel' class='form-control' id='telszam' name='telszam' required>
                        </div>
                        <div class='form-group'>
                          <label for='szallitasicim'>Szállítási cím (Ha üresen hagyja akkor az személyes átvételt jelent):</label>
                          <input type='text' class='form-control' id='szallitasicim' name='szallitasicim'>
                        </div>
                        <input type='hidden' name='termekek' value=".$_SESSION['termekek'].">
                        <input type='hidden' name='osszesen' value=".$_SESSION['fizetendo'].">
                        <button type='submit' class='btn btn-success btn-block mt-3 mb-3' name='rendelesveglegesites'>Rendelés leadása</button>
                      </form>
                      <a href='kosar.php' class='btn btn-primary my-1'>Vissza az előző oldalra</a>
                    </div>
                  </div>
                </div>";
              echo $html;
            }

        ?>
    </form>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>