<?php
    error_reporting(E_ERROR | E_PARSE);

    require "../classes/adatbazis.class.php";
    require "../classes/muvelet.class.php";

    $felhasznalo=new Felhasznalo();

    if(!empty($_SESSION["id"])){
        $id=$_SESSION["id"];

        $bejelentkezett_felhasznalo=$felhasznalo->felhasznalo_kivalasztasa($id);
        
    }

    $url = basename($_SERVER['PHP_SELF']);
    $_SESSION['return_url'] = $url;

    $hozzaadas=new CRUD();
    if(isset($_POST['add_product'])){
        $p_image_tmp_name = $_FILES['t_kep']['tmp_name'];
        $p_image = $_FILES['t_kep']['name'];
        if($p_image==""){
            $kep="placeholder.png";
        }
        else{
            $p_image_folder = "../img/uploaded_img/".str_replace(' ', '_', $p_image);;
            $kep = $_FILES['t_kep']['name'];
        }
     
        $nev = $_POST['t_nev'];
        $ar = $_POST['t_ar'];
        // "pizza"
        // "hamburger"
        // "frissensult"
        // "salata"
        // "tal"
        // "teszta"
        // "gyrostal"
        // "koret"
        // "ontet"
        // "udito"
        // "extra"
        $kategoria="salata"; //kategoriankent modosulo konstans
        $leiras=$_POST['t_leiras'];

        $termek_hozzaadas=$hozzaadas->termek_feltoltes($nev,$ar,$kategoria,$leiras,$kep); //!
        
        if($termek_hozzaadas['valasz']=="Sikeres művelet!"){
           move_uploaded_file($p_image_tmp_name, $p_image_folder);
           echo 
                "<script>
                    alert('A termék sikeresen felvételre került!')
                </script>";
        }else{
            echo 
            "<script>
                alert('A termék felvétele nem sikerült!')
            </script>";
        }
    };

    $torles=new CRUD();
    if(isset($_GET['delete'])){
        if($bejelentkezett_felhasznalo[0]['admin']==1){
            $torles_id = $_GET['delete'];
            $termek_torles=$torles->termek_torles($torles_id);
            if($termek_torles['valasz']=="Sikeres művelet!"){
                echo 
                    "<script>
                        alert('A termék sikeresen törlődött!')
                    </script>";
                echo 
                "<script>
                    window.location.href = 'salads.php'; 
                </script>";
            }else{
                echo 
                "<script>
                    alert('A termék törlése sikertelen volt!')
                </script>";
            };
        }
        else{
            echo //!
            "<script>
                window.location.href = 'salads.php'; 
            </script>";
        }
    };

    $modositas=new CRUD();
    if(isset($_POST['edit_product'])){
        $meglevokep=$_POST['original_file'];
        // var_dump($meglevokep);
        $edit_p_image = $_FILES['edit_termek_kepurl']['name'];
        if($edit_p_image==""){
            $kepurl=$meglevokep;
        }
        else{
            $edit_p_image_tmp_name = $_FILES['edit_termek_kepurl']['tmp_name'];
            $edit_p_image_folder = '../img/uploaded_img/'.str_replace(' ', '_',$edit_p_image);
            $kepurl = $_FILES['edit_termek_kepurl']['name'];
        }


        $modosit_id = $_POST['edit_termek_id'];
        $nev = $_POST['edit_termek_nev'];
        $ar = $_POST['edit_termek_ar'];
        // "pizza"
        // "hamburger"
        // "frissensult"
        // "salata"
        // "tal"
        // "teszta"
        // "gyrostal"
        // "koret"
        // "ontet"
        // "udito"
        // "extra"
        $kategoria="salata"; //kategoriankent valtozo konstans
        $leiras=$_POST['edit_termek_leiras'];

        $termek_modositas=$modositas->termek_modositas($modosit_id,$nev,$ar,$kategoria,$leiras,$kepurl);//!
        
        if($termek_modositas['valasz']=="Sikeres művelet!"){
            move_uploaded_file($edit_p_image_tmp_name, $edit_p_image_folder);
            echo 
                "<script>
                    alert('A termék módosítása sikeres volt!')
                </script>";
            echo //!
            "<script>
                window.location.href = 'salads.php'; 
            </script>";
        }
        else{
            echo 
                "<script>
                    alert('A termék módosítása sikertelen volt!')
                </script>";
            echo //!
            "<script>
                window.location.href = 'salads.php';
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
    <title>Saláták</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap">
    <link rel="stylesheet" href="../css/main.css">
</head>
<body>
    <div id="main">
        <?php
            if(isset($_GET['edit'])){
                if($bejelentkezett_felhasznalo[0]['admin']==1){
                    $lekerdezes=new CRUD();
                    $modositando_id = $_GET['edit'];
                    $termek_modositas=$lekerdezes->modositando_termek_id($modositando_id);
                    if(is_array($termek_modositas)){
                        foreach($termek_modositas as $item){
                            echo "
                            <div id='hatter'>
                                <div id='modositPanel' class='container'>
                                    <div class=row>
                                        <div class=col-md-4 col-sm-2 col-xs-2>
                                            <p>Módosítás</p>
                                        </div>
                                        <div class=col-md-8 col-sm-10 col-xs-10>
                                            <button type='button' class='close text-dark' aria-label='Close' onclick=window.location.href='salads.php'>
                                                <span aria-hidden='false'>&times;</span>
                                            </button>
                                        </div>
                                    </div>
                                    <hr>
                                    <script>
                                        document.getElementById('modositPanel').style.display='block';
                                        document.getElementById('main').classList.add('sotetites');
                                    </script>
                                    <div class=row>
                                        <div class=col-md-4 col-sm-2 col-xs-2>
                                            <img src=../img/uploaded_img/".str_replace(' ', '_',$item['termek_kepurl'])." alt='".$item['termek_nev']."' class='img-thumbnail'>
                                        </div>
                                            <div class=col-md-8 col-sm-10 col-xs-10>
                                                <form id='modform' action='".$_SERVER['PHP_SELF']."' method='post' enctype='multipart/form-data' class='text-center'>
                                                    <input type='hidden' name='edit_termek_id' value='".$item['id']."'>
                                                    <label for='edit_termek_nev'>Termék neve:</label>
                                                    <input type='text' required name='edit_termek_nev' value='". $item['termek_nev']. "'><br>
                                                    <label for='edit_termek_leiras'>Leírás:</label>
                                                    <input type='text' name='edit_termek_leiras' value='". $item['termek_leiras']. "'><br>
                                                    <label for='edit_termek_ar'>Termék ára:</label>
                                                    <input type='number' min=0 required name='edit_termek_ar' value=".$item['termek_ar']."><br>
                                                    <input type='hidden' id='original_file' name='original_file' value='".$item['termek_kepurl']."'>
                                                    <label for='edit_termek_kepurl'>Termékkép:</label>
                                                    <input type='file' name='edit_termek_kepurl' accept='image/png, image/jpg, image/jpeg'>
                                                    <input type='submit' class='btn btn-outline-success m-1' value='Termék módosítása' name='edit_product'>
                                                    <input type='reset' class='btn btn-outline-danger m-1' value='Alaphelyzet'>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            ";
                        }
                    }
                }
                else{
                    echo //!
                    "<script>
                        window.location.href = 'salads.php'; 
                    </script>";
                }
            }
        ?>
        <nav class="navbar navbar-expand-lg navbar-light justify-content-center">
            <button class="navbar-toggler btn btn-warning" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon bg-warning rounded"></span>
            </button>
            <div class="text-center">
              <a class="navbar-brand d-lg-none" href="./index.php">
                <img src="../img/logo_final.png" class="text-center img-fluid" alt="Leveld Gasztroudvar Városlőd">
              </a>
            </div>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item mx-auto">
                      <a class="nav-link text-center" href="./pizzas.php">Pizzák<br><img src="../img/pizza.png" class="text-center justify-content-center"></a>
                      <div class="text-center">
                        
                      </div>
                    </li>
                    <li class="nav-item mx-auto">
                      <a class="nav-link text-center " href="./pastas.php">Tészták<br><img src="../img/pasta.png" class="text-center justify-content-center"></a>
                      <div class="text-center">
                        
                      </div>
                    </li>
                    <li class="nav-item mx-auto">
                      <a class="nav-link text-center active" href="./salads.php">Saláták<br><img src="../img/salad.png" class="text-center justify-content-center"></a>
                      <div class="text-center">
                       
                      </div>
                    </li>
                    <li class="nav-item mx-auto">
                      <a class="nav-link text-center" href="./hamburgers.php">Hamburgerek<br><img src="../img/burger.png" class="text-center justify-content-center"></a>
                      <div class="text-center">
                        
                      </div>
                    </li>
                    <a class="navbar-brand d-none d-lg-block" href="../index.php">
                      <img src="../img/logo_final.png" class="text-center img-fluid" alt="Leveld Gasztroudvar Városlőd">
                    </a>
                    <li class="nav-item mx-auto">
                      <a class="nav-link text-center" href="./bowls.php">Többszemélyes<br>tálak<br><img src="../img/plate.png" class="text-center justify-content-center"></a>
                      <div class="text-center">
                        
                      </div>
                    </li>
                    <li class="nav-item mx-auto">
                      <a class="nav-link text-center" href="./gyros.php">Gyros<br>tálak<br><img src="../img/gyros.png" class="text-center justify-content-center"></a>
                      <div class="text-center">
                        
                      </div>
                    </li>
                    <li class="nav-item mx-auto">
                      <a class="nav-link text-center" href="./friedstuff.php">Frissensültek<br><img src="../img/frissensult.png" class="text-center justify-content-center"></a>
                      <div class="text-center">
                        
                      </div>
                    </li>
                    <li class="nav-item dropdown">
                      <a class="nav-link text-center dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Extrák<br><img src="../img/extra.png" class="text-center justify-content-center"></a>
                      <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a href="./sidedishes.php" class="dropdown-item">Köretek</a>
                        <a href="./dressings.php" class="dropdown-item">Öntetek</a>
                        <a href="./drinks.php" class="dropdown-item">Üdítők</a>
                        <div class="dropdown-divider"></div>
                        <a href="./extras.php" class="dropdown-item">Kiegészítők</a>
                      </div>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="container-fluid">
            <div class="row">
                <div class="felhasznaloi-panel col-lg-1 col-sm-4 col-md-4 bg-dark rounded text-white my-5 p-2">
                    <div>
                        <?php 
                            if(!empty($_SESSION['id'])){
                            echo "<p>Üdvözöljük ".$bejelentkezett_felhasznalo[0]["name"]."!</p><button class='btn w-100' type='button'><a class='korvonal' href='../rendeleseim.php'>Rendeléseim</a></button><br><button class='btn w-100' type=button'><a class='korvonal' href='../logout.php'>Kijelentkezés</a></button>";
                            }
                            else{
                            echo "<p class='korvonal'>Még nincs bejelentkezve!";
                            echo "<div><button class='btn w-100' type=button><a class='korvonal' href='../login.php'>Bejelentkezés</a></button><button class='btn w-100' type=button><a class='korvonal' href='../register.php'>Regisztráció</a></button></div>";
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div> 
        <?php
            if(!empty($_SESSION['id'])){
                if ($bejelentkezett_felhasznalo[0]['admin'] == 1) {//admin //!
                    echo '<div class="container-fluid hozzaadas my-0">
                            <h3>Termék hozzáadása a(z) "Saláták" kategóriához:</h3>
                            <div class="add-product-form">
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="t_nev">Termék neve:</label>
                                    <input type="text" class="form-control" id="t_nev" name="t_nev" placeholder="Termék neve" required>
                                </div>
                                <div class="form-group">
                                    <label for="t_ar">Termék ára:</label>
                                    <input type="number" class="form-control" id="t_ar" name="t_ar" min="0" placeholder="Termék ára" required>
                                </div>
                                <div class="form-group">
                                    <label for="t_leiras">Leírás:</label>
                                    <textarea class="form-control" id="t_leiras" name="t_leiras" placeholder="Leírás" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="t_kep">Termék képe:</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="t_kep" name="t_kep" accept="image/png, image/jpg, image/jpeg">
                                        <label class="custom-file-label" for="t_kep">Válassz fájlt...</label>
                                    </div>
                                </div>
                                <button type="submit" name="add_product" class="btn btn-success mb-2">Hozzáadás</button>
                            </form>
                        </div>';
                    echo '</div>';
                }
            }
                
        ?>
        <hr>
        <div class="rendezesdiv m-3">
            <div class="m-1 rendezes korvonal">
                Rendezés szempontja
            </div>
            <form action="" method="get" id="rendezes-form">
                <select class="form-control w-30 bg-warning" name="rendezesszerint" id="legordulo">
                    <option value="termek_nev_az" selected>Név szerint (A-Z)</option>
                    <option value="termek_nev_za">Név szerint (Z-A)</option>
                    <option value="termek_ar_asc">Ár szerint (legolcsóbbtól-legdrágábbig)</option>
                    <option value="termek_ar_desc">Ár szerint (legdrágábbtól-legolcsóbbig)</option>
                    <option value="termek_id_asc">Hozzáadás dátuma szerint (legrégebbitől-legfrissebbig)</option>
                    <option value="termek_id_desc">Hozzáadás dátuma szerint (legfrissebbtől-legrégebbiig)</option>
                </select>
                <input class="rendezesgomb text-white m-1" type="submit" value="Rendezés" name='rendezo'>
                </form>
        </div>
        <div class="container-fluid termekek">
            <div class="row justify-content-center">
                <?php
                    $lekerdezes=new CRUD();
                    // "pizza"
                    // "hamburger"
                    // "frissensult"
                    // "salata"
                    // "tal"
                    // "teszta"
                    // "gyrostal"
                    // "koret"
                    // "ontet"
                    // "udito"
                    // "extra"
                    $meglevo_termekek=$lekerdezes->kategoria_lekerdezes("salata");
                    // var_dump($meglevo_termekek);k
                    // echo $meglevo_termekek['valasz'];
                    if(!isset($meglevo_termekek['valasz'])){ //1=hibauzenet array
                        foreach($meglevo_termekek as $item){//!
                            echo "
                            <div class='col-xs-12 col-sm-6 col-md-6 col-lg-4'>
                                <div class='card termekkartya m-5 hidden-card'>
                                    <img src=../img/uploaded_img/".str_replace(' ', '_',$item['termek_kepurl'])." alt='".$item['termek_nev']."' class='card-img-top'>
                                    <div class='card-body'>
                                        <h5 class='card-title'>".$item['termek_nev']."</h5>
                                        <p class='card-text'>".$item['termek_leiras']."</p>
                                        <p class='ar'>".$item['termek_ar']."Ft</p>
                                        <form method='post' action='salads.php?id=".$item['id']."'>
                                            <input type='hidden' name='kosarba_termek_nev' value='".$item['termek_nev']."'>
                                            <input type='hidden' name='kosarba_termek_ar' value=".$item['termek_ar'].">
                                            <label for='kosarba_termek_db'>Mennyiség:</label>
                                            <input type='number' name='kosarba_termek_db' value=1>
                                            <button type='submit' name='kosarba_hozzaadas' class='btn btn-success m-1'>
                                                Kosárba! <i class='fas fa-cart-shopping'></i>
                                            </button>
                                        </form>";
                                        if($bejelentkezett_felhasznalo[0]['admin']==1){
                                            $tmp = "onclick=\"return confirm('Biztosan törölni akarja ezt a terméket?')\"";//!
                                            echo "
                                                <hr><div class='justify-content-center mx-auto text-right'>
                                                    <a href='salads.php?delete=".$item['id']."' class='btn btn-danger m-1' ".$tmp. ">Törlés <i class='fa-solid fa-trash-can'></i></a>
                                                    <a href='salads.php?edit=".$item['id']."' class='btn btn-primary m-1'>Módosítás <i class='fa-solid fa-pencil'></i></a>
                                                </div>
                                            ";
                                        }
                            echo "</div></div></div>";
                            }
                            
                        }//!

                    else{
                        echo "Jelenleg egy termék sem szerepel a(z) 'Saláták' kategóriában!";
                    }
                    
                ?>
            </div>
        </div>
        <div class="fluid-container">
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
                    <a href="https://www.facebook.com/leveldgasztroudvar" target="_blank"><img class="rounded" src="../img/facebook.png" alt="Facebook oldalunk"></a>
                </div>
                </div>
            </div>
            </div>
        </div>

    </div>
    <div class="position-fixed" style="bottom: 20px; right: 20px;">
    <a href="../kosar.php" class="btn btn-success btn-lg">
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
<script src="../js/kartyak.js"></script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</html>

