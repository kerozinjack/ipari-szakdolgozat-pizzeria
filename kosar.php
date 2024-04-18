<?php
    error_reporting(E_ERROR | E_PARSE);


    require "./classes/adatbazis.class.php";
    require "./classes/muvelet.class.php";

    // foreach ($_SESSION['cart'] as $key => $value) {
    //     var_dump($value);
    //     echo "<br>";
    // }
    
    // var_dump($_SESSION['return_url']);
    // var_dump($_SERVER['HTTP_REFERER']);

    // if (!empty($_SERVER['HTTP_REFERER']) && !strpos($_SERVER['HTTP_REFERER'], '?') && $_SERVER['HTTP_REFERER'] != 'kosar.php') {
    //     $return_url = $_SERVER['HTTP_REFERER'];
    // } 
    // if (isset($_SESSION['return_url']) && !empty($_SESSION['return_url']) && !strpos($_SESSION['return_url'], '?') && $_SESSION['return_url'] != 'kosar.php') {
    //     $return_url = $_SESSION['return_url'];
    // } 
    // else {
    //     $return_url = 'index.php';
    // }
    // // unset($_SESSION['return_url']);
    
    if(isset($_SESSION['return_url'])){
        if($_SESSION['return_url']=="index.php" || $_SESSION['return_url']=="admin.php" || $_SESSION['return_url']=="felhasznalok.php" || $_SESSION['return_url']=="login.php" || $_SESSION['return_url']=="register.php" || $_SESSION['return_url']=="rendeleseim.php" || $_SESSION['return_url']=="rendelesek.php" || $_SESSION['return_url']=="adataim.php" || $_SESSION['return_url']=="jelszomodositas.php"){
            $return_url=$_SESSION['return_url'];
        }
        else{
            $return_url="categories/".$_SESSION['return_url']."";
        }
    }
    
    if(isset($_GET['action']) && $_GET['action']=="clearall"){
        unset($_SESSION['cart']);
        $_SESSION['cart_count'] = 0;
    }
    if(isset($_GET['action']) && $_GET['action']=="remove"){
        foreach ($_SESSION['cart'] as $key => $value) {
            if($value['id']==$_GET['id']){
                unset($_SESSION['cart'][$key]);
                $_SESSION['cart_count'] = count($_SESSION['cart']);
            }
        }
    }
    if (isset($_GET['action']) && $_GET['action'] === 'update') {
        if (isset($_GET['modid']) && isset($_POST['termek_db_mod'])) {
            $kosarsor_id = $_GET['modid'];
            // var_dump($kosarsor_id);
            $mod = (int)$_POST['termek_db_mod'];
            // var_dump($mod);
            // var_dump($_SESSION['cart'][$kosarsor_id]['termek_db']);
            if ($mod > 0) {
                if (!empty($_SESSION['cart'][$kosarsor_id])) {
                    $_SESSION['cart'][$kosarsor_id]['termek_db'] = $mod;
                }
                // echo 
                // "<script>
                //     alert('Sikeres módosítás')
                // </script>
                // <script>
                //     window.location.href='kosar.php';
                // </script>";

            } else {
                echo 
                "<script>
                    alert('Érvénytelen szám')
                </script>";
                
                
            }
        }
    }
    if(isset($_POST['rendelesleadas'])){
        if(!empty($_SESSION['cart'])){
            $termekek_string="";
            foreach ($_SESSION['cart'] as $key => $value) {
                $termekek_string .= $value['termek_nev'] . ":" . $value['termek_db'] . ";";
            }
            $termekek_string=rtrim($termekek_string,';');
            $_SESSION['termekek']=$termekek_string;
            if($termekek_string!=""){
                echo "
                    <script>
                        window.location.href='szallitasi_cim.php'
                    </script>";
            }
            else{
                echo $termekek_string;
            }
        }
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kosár</title>
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
                <th>Termék neve</th>
                <th>Termék ára</th>
                <th>Termék darabszáma</th>
                <th>Teljes ár</th>
                <th class="sarok"></th>
            </tr>
        <?php
            $html="";
            
            
            
            $osszesen=0;

            if(!empty($_SESSION['cart'])){
                foreach ($_SESSION['cart'] as $key => $value) {
                    // var_dump($value);
                    $html.="
                        <tr>
                            <td>".$value['termek_nev']."</td>
                            <td>".$value['termek_ar']." Ft</td>
                            <td>
                                <form method='post' action='kosar.php?action=update&modid=".(int)$key."'>
                                    <div class='input-group'>
                                        <input class='form-control' type='number' name='termek_db_mod' value='".$value['termek_db']."' min='1' max='10'>
                                        <button type='submit' class='btn btn-info btn-sm'><i class='fa-solid fa-check'></i></button>
                                    </div>
                                </form>
                            </td>
                            <td>".(int)$value['termek_ar']*(int)$value['termek_db']." Ft</td>
                            <td>
                                <a href='kosar.php?action=remove&id=".$value['id']."'>
                                    <button class='btn btn-danger btn-block'><i class='fa-solid fa-xmark'></i></button>
                                </a>
                            </td>
                        </tr>
                    ";
                    $osszesen=$osszesen+(int)$value['termek_ar']*(int)$value['termek_db'];
                }
                $_SESSION['fizetendo']=$osszesen;
                $html.="
                <tr>
                <td class='sarok2' colspan=2></td>
                <td><b>Összesen:</b></td>
                <td>".$osszesen." Ft</td>
                <td>
                <a href='kosar.php?action=clearall'>
                <button class='btn btn-warning btn-block text-white'><i class='fas fa-trash-alt'></i></button>
                </a>
                </td>
                </tr>
                ";
            }
            else{
                $html.="
                    <tr>
                        <td colspan=5 class='text-center'>Jelenleg üres a kosarad!</td>
                    </tr>
                ";
            }
            
            $html.="
            </table>
            <form action='' method='post'>
                <button type='submit' class='btn btn-success m-1' name='rendelesleadas'>
                    Tovább
                </button>
            </form>
            <a href='".$return_url."' class='btn btn-primary m-1'>Vissza az előző oldalra</a>
            ";
            // $tmp=new Felhasznalo();
            // var_dump($tmp->felhasznalo_kivalasztasa($_SESSION['id']));


            echo $html;
        ?>
        
    </div>
        
 
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>