<?php
    error_reporting(E_ERROR | E_PARSE);

    require "./classes/adatbazis.class.php";
    require "./classes/muvelet.class.php";

    $felhasznalo=new Felhasznalo();


    
    if(!empty($_SESSION["id"])){
        $id=$_SESSION["id"];
        $bejelentkezett_felhasznalo=$felhasznalo->felhasznalo_kivalasztasa($id);
        // var_dump($bejelentkezett_felhasznalo);
        if($bejelentkezett_felhasznalo[0]['admin']==1){
          echo
            "<script>
                window.location.href = 'admin.php'; 
            </script>";
        }
    }

    if(isset($_POST['kosarba_hozzaadas'])){
      $return_url = basename($_SERVER['PHP_SELF']);
      $_SESSION['return_url'] = $return_url;
      if(isset($_SESSION['cart'])){
          $kosartartalom_id=array_column($_SESSION['cart'],"id");
          if(!in_array($_GET['id'],$kosartartalom_id)){
              $kosartartalom=array(
                  'id'=>$_GET['id'],
                  'termek_nev'=>$_POST['kosarba_termek_nev'],
                  'termek_ar'=>$_POST['kosarba_termek_ar'],
                  'termek_db'=>$_POST['kosarba_termek_db']
              );
              $_SESSION['cart'][]=$kosartartalom;
          }
      }
      else{
          $kosartartalom=array(
              'id'=>$_GET['id'],
              'termek_nev'=>$_POST['kosarba_termek_nev'],
              'termek_ar'=>$_POST['kosarba_termek_ar'],
              'termek_db'=>$_POST['kosarba_termek_db']
          );
          $_SESSION['cart'][]=$kosartartalom;
      }
      $_SESSION['cart_count'] = count($_SESSION['cart']);
    }

    
    $url = basename($_SERVER['PHP_SELF']);
    // var_dump($url);
    $_SESSION['return_url'] = $url;
    // var_dump($_SESSION['return_url']);

    $feliratkoz=new CRUD();
    if(isset($_POST['feliratkoz'])){
      $email=$_POST['hirlevelemail'];
      // echo $email;
      $vegrehajtas=$feliratkoz->hirlevelre_feliratkoz($email);
      switch($vegrehajtas){
        case 1:{
          echo 
              "<script>
                alert('A hírlevélre feliratkozás sikerült!')
              </script>";
            
          break;
        }
        case 0:{
          echo
            "<script>
                 alert('A hírlevélre feliratkozás nem sikerült, a megadott e-mail cím már kap hírlevelet!')
             </script>";
          break;
        }
        default:
          echo "idk";
          break;
      }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Főoldal</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap">
    <link rel="stylesheet" href="./css/main.css">
</head>
<body >
    <div>
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
      <div class="fluid-container">
        <div class="row bemutato1 justify-content-between">
          <div class="felhasznaloi-panel col-lg-1 col-sm-4 col-md-4 bg-dark rounded text-white my-5 p-2">
            <div>
              <?php 
                if(!empty($_SESSION['id'])){
                  echo "<p>Üdvözöljük ".$bejelentkezett_felhasznalo[0]["name"]."!</p><button class='btn w-100' type='button'><a class='korvonal' href='./rendeleseim.php'>Rendeléseim</a></button><br><button class='btn w-100' type=button'><a class='korvonal' href='./adataim.php'>Adataim</a></button><br><button class='btn w-100' type=button'><a class='korvonal' href='./logout.php'>Kijelentkezés</a></button>";
                }
                else{
                  echo "<p class='korvonal'>Még nincs bejelentkezve!";
                  echo "<div><button class='btn w-100' type=button><a class='korvonal' href='./login.php'>Bejelentkezés</a></button><button class='btn w-100' type=button><a class='korvonal' href='./register.php'>Regisztráció</a></button></div>";
                }
              ?>
            </div>
          </div>
          <div class="elerhetoseg-nyitvatartas col-lg-3 col-sm-4 col-md-4 my-5">
            <div class="bg-light rounded terkep">
              <h4 class="font-weight-bold">Elérhetőségünk</h4>
              <div class="elerhetoseg">
                <p class="m-0"><b>Cím: </b> 8445 Városlőd, Kossuth Lajos u. 69</p>
                <p class="m-0"><b>E-mail cím:</b> leveldgasztroudvar@gmail.com</p>
                <p class="m-0"><b>Mobil: </b>+36 20/322 6070</p>
                <p class="m-0"><b>Vezetékes: </b>06 88/418-433</p>
              </div>
              <hr>
              <h5 class="font-weight-bold">Nyitvatartás:</h5>
              <ul class="nyitvatartas">
                <li>Hétfő: Zárva</li>
                <li>Kedd: 11:00-19:30</li>
                <li>Szerda: 11:00-19:30</li>
                <li>Csütörtök: 11:00-19:30</li>
                <li>Péntek: 11:00-19:30</li>
                <li>Szombat: 11:00-19:30</li>
                <li>Vasárnap: Zárva</li>
              </ul>
              <div style="width: 100%">
                <iframe 
                  width="90%" 
                  height="300" 
                  frameborder="0" 
                  scrolling="no" 
                  marginheight="0" 
                  marginwidth="0" 
                  src="https://maps.google.com/maps?width=100%25&amp;height=600&amp;hl=en&amp;q=Hungary,%20V%C3%A1rosl%C5%91d,%20Kossuth%20Lajos%20u.%2069+(Leveld%20Gasztroudvar)&amp;t=&amp;z=15&amp;ie=UTF8&amp;iwloc=B&amp;output=embed">
                  <a href="https://www.gps.ie/">gps trackers</a>
                </iframe>
              </div>
            </div>
          </div>
        </div>
        <div class="row bemutato2 bg-dark">
          <div class="col-12">
            <h4 class="ujdonsagaink korvonal">Újdonságaink!</h4>
            <div class="row justify-content-center">
             
              <?php
                    $lekerdezes=new CRUD();
                    $muvelet=$lekerdezes->ujdonsagok();
                    // var_dump($meglevo_termekek);k
                    // echo $meglevo_termekek['valasz'];
                    if(!isset($muvelet['valasz'])){ //1=hibauzenet array
                        foreach($muvelet as $item){
                            echo "
                            <div class='col-xs-12 col-sm-6 col-md-6 col-lg-4'>
                                <div id='".$item['id']."' class='card termekkartya m-5 hidden-card'>
                                    <img src=./img/uploaded_img/".str_replace(' ', '_',$item['termek_kepurl'])." alt='".$item['termek_nev']."' class='card-img-top'>
                                    <div class='card-body'>
                                        <h5 class='card-title'>".$item['termek_nev']."</h5>
                                        <p class='card-text'>".$item['termek_leiras']."</p>
                                        <p class='ar'>".$item['termek_ar']."Ft</p>
                                        <form method='post' action='index.php?id=".$item['id']."'>
                                            <input type='hidden' name='kosarba_termek_nev' value='".$item['termek_nev']."'>
                                            <input type='hidden' name='kosarba_termek_ar' value=".$item['termek_ar'].">
                                            <label for='kosarba_termek_db'>Mennyiség:</label>
                                            <input type='number' name='kosarba_termek_db' value=1>
                                            <button type='submit' name='kosarba_hozzaadas' class='btn btn-success m-1'>
                                                Kosárba! <i class='fas fa-cart-shopping'></i>
                                            </button>
                                        </form>";
                            echo "</div></div></div>";
                            }
                            
                        }//!                   
                ?>
            </div>
          </div>
        </div>
        <div class="row bemutato3 bg-success text-light mx-auto">
          <div class="col-12 text-center">
            <p class="d-flex hazhozszallitas">HÁZHOZ SZÁLLÍTÁS</p>
            <hr>
            <table class="border-none d-flex justify-content-center text-light">
              <tr>
                <td>Városlőd, Kislőd</td>
                <td>Ingyenes</td>
              </tr>
              <tr>
                <td>Csehbánya</td>
                <td>Ingyenes</td>
              </tr>
            </table>
            <div class="kiszallitasinfo">
              <p>Herend, Bánd, Szentgál, Farkasgyepü, Bakonyjákó, és egyéb településekre kiszállítási díjat számolunk fel</p>
              <p>5000 Ft feletti rendelés esetén ingyenes!</p>
            </div>
          </div>
        </div>
        <div class="row bemutato4 justify-content-center">
          <div class="hirlevel col-12 col-lg-8 bg-light text-dark">
            <div class="row">
              <div class="col-7 hirleveltajekoztato">
                <h5>Leveld Gasztroudvar Hírlevél</h5>
                <p>A Leveld Gasztroudvar arra fogja használni az e-mail címedet, hogy kapcsolatba lépjen veled, és havi rendszerességgel hírlevelet küldjön, melyben aktuális akcióinkról és híreinkről tájékozódhatsz.</p>
                <p class="font-weight-bold">Bármikor meggondolhatod magad és leiratkozhatsz hírlevelünkről a tőlünk kapott e-mailek láblécében a leiratkozás linkre kattintva.</p>
              </div>
              <div class="col-5 feliratkozas mx-auto">
                <h5 class="text-center">Iratkozz fel!</h5>
                <form method="post" class="feliratkozasform ">
                  <input type="email" class="form-control" name="hirlevelemail" id="hirlevelemail" placeholder="Email"><br>
                  <input type="checkbox" class="" name="felhfelt" id="felhfelt" required> Elfogadom a felhasználási feltételeket és az adatvédelmi irányelveket.<br>
                  <input type="submit" value="Feliratkozás" name="feliratkoz" class="btn btn-info w-100">
                </form>
              </div>
            </div>
            <hr>
            <div class="row kozossegimedia">
              <div class="col-12">
                <a href="https://www.facebook.com/leveldgasztroudvar" target="_blank"><img class="rounded" src="./img/facebook.png" alt="Facebook oldalunk"></a>

              </div>
            </div>
          </div>
        </div>
          
    </div>
    <div class="position-fixed" style="bottom: 20px; right: 20px;">
        <a href="./kosar.php" class="btn btn-success btn-lg">
            <i class="fas fa-shopping-cart"></i> <b>Kosár</b>
            <span class="badge bg-danger rounded-circle position-absolute top-0 start-100 translate-middle">
                <?php
                    if($_SESSION['cart']==null){
                        echo "0";
                    }
                    else{
                        echo $_SESSION['cart_count'];
                    }
                ?>
            </span>
        </a>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="./js/kartyak.js"></script>
<script src="./js/nyitvatartas.js"></script>
</html>

