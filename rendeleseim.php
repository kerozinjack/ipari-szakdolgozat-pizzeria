<?php
  error_reporting(E_ERROR | E_PARSE);


  require "./classes/adatbazis.class.php";
  require "./classes/muvelet.class.php";

  if(!isset($_SESSION['id'])){
    echo //!
    "<script>
        window.location.href = 'index.php'; 
    </script>";
  }

  $url = basename($_SERVER['PHP_SELF']);
  $_SESSION['return_url'] = $url;


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rendeléseim</title>
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
    <div class="container mx-auto m-5 kosartabla table-responsive">
        <table class='table-bordered table-striped m-3 mx-auto'>
            <tr>
                <th>Rendelés dátuma</th>
                <th>Szállítási cím</th>
                <th>Rendelés tartalma</th>
                <th>Végösszeg</th>
                <th>Fizetve</th>
            </tr>
        <?php
          
          $rendeleseim=new CRUD();
          $rendelesek=$rendeleseim->user_rendelesei($_SESSION['id']);

          $html="";
          if(!isset($rendelesek['valasz']))
          {
            foreach($rendelesek as $item){
              $rendelestartalom=explode(';',$item['termekek']);
              $rendelestd="<ul>";
              foreach($rendelestartalom as $rendeles_item){
                  $tmp=explode(':',$rendeles_item);
                  $termeknev=$tmp[0];
                  $termekdb=$tmp[1];
                  $rendelestd.="<li>".$termeknev."-".$termekdb."x";
              }

              $html.="
                <tr>
                  <td>".$item['rendeles_datuma']."</td>";
                  if($item['sz_cim']==""){
                    $html.="<td><i>Személyes átvétel</i></td>";
                  }
                  else{
                    $html.="<td>".$item['sz_cim']."</td>";
                  }
                  $html.="<td>".$rendelestd."</td>
                  <td>".$item['vegosszeg']." Ft</td>";
                if($item['fizetve']==0){
                  $html.="<td>Nem</td></tr>";
                }
                else{
                  $html.="<td>Igen</td></tr>";
                }
              }
          }
          else{
            $html.="<tr><td colspan=5 class='text-center''>Még nem rendeltél tőlünk semmit!</td></tr>";
          }
          $html.="</table>";
          $html.="<a href='index.php' class='btn btn-primary my-1'>Főoldal</a>";
          echo $html;
        ?>
        
    </div>
        
 
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>