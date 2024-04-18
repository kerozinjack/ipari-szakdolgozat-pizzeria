<?php
    require "./classes/adatbazis.class.php";
    require "./classes/muvelet.class.php";
 
    $felhasznalo=new Felhasznalo();
 
    $url = basename($_SERVER['PHP_SELF']);
    $_SESSION['return_url'] = $url;
 
    if(!empty($_SESSION['id'])){
      $id= $_SESSION["id"];
      $bejelentkezett_felhasznalo=$felhasznalo->felhasznalo_kivalasztasa($id);
      // var_dump($bejelentkezett_felhasznalo);
      if($bejelentkezett_felhasznalo[0]['admin']!=1){
        echo
             "<script>
                 window.location.href = 'index.php'; 
             </script>";
        }
    }
    else{
      echo
        "<script>
           window.location.href = 'index.php'; 
         </script>";
    }

    
    $hozzaadas=new CRUD();
    if(isset($_POST['add_product'])){
        $p_image_tmp_name = $_FILES['t_kep']['tmp_name'];
        $p_image = $_FILES['t_kep']['name'];
        if($p_image==""){
            $kep="placeholder.png";
        }
        else{
            $p_image_folder = "./img/uploaded_img/".str_replace(' ', '_', $p_image);;
            $kep = $_FILES['t_kep']['name'];
        }
     
        $nev = $_POST['t_nev'];
        $ar = $_POST['t_ar'];
        $kategoria=$_POST['t_kategoria'];
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

    $ftorles=new CRUD();
    if(isset($_GET['u_delete'])){
          $torles_id = $_GET['u_delete'];
          if($torles_id!=1){
           $felhasznalo_torles=$ftorles->felhasznalo_torles($torles_id);
           if($felhasznalo_torles['valasz']=="Sikeres művelet!"){
               echo 
                 "<script>
                     alert('A felhasználó sikeresen törlődött!')
                 </script>";
               echo 
                 "<script>
                     window.location.href = 'admin.php'; 
                 </script>";
           }else{
               echo 
               "<script>
                   alert('A felhasználó törlése sikertelen volt!')
               </script>";
           };
          }
          else{
           echo 
             "<script>
                 window.location.href = 'admin.php'; 
             </script>";
          }
    };

    $fmodositas=new CRUD();
    if(isset($_POST['edit_user'])){
       // $edit_id=$_GET['edit'];
       //var_dump($edit_id);
       
       $modosit_id=$_POST['edit_u_id'];
       $mnev=$_POST['edit_u_name'];
       $mfelhasznalonev=$_POST['edit_u_uname'];
       $memail=$_POST['edit_u_email'];
       $madmin=$_POST['edit_u_admin'];
 
       $user_modositas=$fmodositas->felhasznalo_modositas($mnev,$mfelhasznalonev,$memail,$madmin,$modosit_id);
       
       // var_dump($user_modositas);
       if($user_modositas['valasz']=="Sikeres művelet!"){
         echo 
           "<script>
             alert('A felhasználó módosítása sikeres volt!')        
           </script>";
         echo //!
           "<script>
             window.location.href = 'admin.php'; 
           </script>";
        }
        else{
          echo 
            "<script>
              alert('A felhasználó módosítása sikertelen volt!')
            </script>";
            echo //!
            "<script>
              window.location.href = 'admin.php'; 
            </script>";
        }
    }

    $rtorles=new CRUD();
    if(isset($_GET['o_delete'])){
        $torles_id = $_GET['o_delete'];
        $rendeles_torles=$rtorles->rendeles_torles($torles_id);
        if($rendeles_torles['valasz']=="Sikeres művelet!"){
            echo 
              "<script>
                  alert('A rendelés sikeresen törlődött!')
              </script>";
            echo 
              "<script>
                  window.location.href = 'admin.php'; 
              </script>";
        }else{
            echo 
            "<script>
                alert('A rendelés törlése sikertelen volt!')
            </script>";
        };
    };

    $rmodositas=new CRUD();
    if(isset($_POST['edit_order'])){
        // $edit_id=$_GET['edit'];
        //var_dump($edit_id);
  
        $modosit_id=$_POST['edit_o_id'];
        $mnev=$_POST['edit_o_megrendelo'];
        $memail=$_POST['edit_u_email'];
        $mtel=$_POST['edit_o_telefonszam'];
        $mszcim=$_POST['edit_o_szcim'];
        $mtermekek=$_POST['edit_o_termekek'];
        $mvegosszeg=$_POST['edit_o_vegosszeg'];
        $mfizetve=$_POST['edit_o_fizetve'];

        $rendeles_modositas=$rmodositas->rendeles_modositas($mnev,$memail,$mtel,$mszcim,$mtermekek,$mvegosszeg,$mfizetve,$modosit_id);
        
        // var_dump($user_modositas);
        if($rendeles_modositas['valasz']=="Sikeres művelet!"){
          echo 
            "<script>
              alert('A rendelés módosítása sikeres volt!')        
            </script>";
          echo //!
            "<script>
              window.location.href = 'admin.php'; 
            </script>";
          }
          else{
            echo 
              "<script>
                alert('A rendelés módosítása sikertelen volt!')
              </script>";
            echo //!
              "<script>
                window.location.href = 'admin.php'; 
              </script>";
          }
    }

    $ttorles=new CRUD();
    if(isset($_GET['p_delete'])){
        if($bejelentkezett_felhasznalo[0]['admin']==1){
          $torles_id = $_GET['p_delete'];
          $termek_torles=$ttorles->termek_torles($torles_id);
            if($termek_torles['valasz']=="Sikeres művelet!"){
              echo 
                "<script>
                  alert('A termék sikeresen törlődött!')
                </script>";
              echo 
                "<script>
                  window.location.href = 'admin.php'; 
                </script>";
            }
            else{
              echo 
                "<script>
                  alert('A termék törlése sikertelen volt!')
                </script>";
            };
        }
        else{
          echo //!
            "<script>
              window.location.href = 'admin.php'; 
            </script>";
        }
    }

    $tmodositas=new CRUD();
    if(isset($_POST['edit_product'])){
        $meglevokep=$_POST['original_file'];
        // var_dump($meglevokep);
        $edit_p_image = $_FILES['edit_termek_kepurl']['name'];
        if($edit_p_image==""){
            $kepurl=$meglevokep;
        }
        else{
            $edit_p_image_tmp_name = $_FILES['edit_termek_kepurl']['tmp_name'];
            $edit_p_image_folder = './img/uploaded_img/'.str_replace(' ', '_',$edit_p_image);
            $kepurl = $_FILES['edit_termek_kepurl']['name'];
        }


        $modosit_id = $_POST['edit_termek_id'];
        $nev = $_POST['edit_termek_nev'];
        $ar = $_POST['edit_termek_ar'];
        $kategoria=$_POST['edit_termek_kategoria'];
        $leiras=$_POST['edit_termek_leiras'];

        $termek_modositas=$tmodositas->termek_modositas($modosit_id,$nev,$ar,$kategoria,$leiras,$kepurl);//!
        
        if($termek_modositas['valasz']=="Sikeres művelet!"){
            move_uploaded_file($edit_p_image_tmp_name, $edit_p_image_folder);
            echo 
                "<script>
                    alert('A termék módosítása sikeres volt!')
                </script>";
            echo //!
            "<script>
                window.location.href = 'admin.php'; 
            </script>";
        }
        else{
            echo 
                "<script>
                    alert('A termék módosítása sikertelen volt!')
                </script>";
            echo //!
            "<script>
                window.location.href = 'admin.php'; 
            </script>";
        }


    }

    if(isset($_GET['action'])){
      if($_GET['action']==='order_paid'){
        if(isset($_GET['modid']) && isset($_POST['fizetve'])){
          $modid=$_GET['modid'];
          $fiz=$_POST['fizetve'];
          $fizetve=new CRUD();
          $muvelet=$fizetve->rendeles_fizetve_mod($modid,$fiz);
          if($muvelet['valasz']=="Sikeres művelet!"){
            echo 
            "<script>
                   window.location.href = 'admin.php'; 
               </script>";
           }
           else{
               echo 
               "<script>
                   alert('A módosítás sikertelen volt! Rendelés azonosító:".$modid."');
               </script>";
           }      
        }
      }
      if($_GET['action']==='grant_admin'){
        if(isset($_GET['modid']) && isset($_POST['adminjog'])){
          $modid=$_GET['modid'];
          $admin=$_POST['adminjog'];
          $adminjogok=new CRUD();
          $muvelet=$adminjogok->admin_jogok_mod($modid,$admin);
          if($muvelet['valasz']=="Sikeres művelet!"){
            echo 
            "<script>
                   window.location.href = 'admin.php'; 
            </script>";
           }
           else{
               echo 
               "<script>
                   alert('A módosítás sikertelen volt! Felhasználó azonosító:".$modid."');
               </script>";
           }  
        }
      }
      if($_GET['action']==='update_category'){
        if(isset($_GET['modid']) && isset($_POST['kategoria'])){
          $modid=$_GET['modid'];
          $kategoria=$_POST['kategoria'];
          $kategoriavaltoztat=new CRUD();
          $muvelet=$kategoriavaltoztat->termek_kategoria_mod($modid,$kategoria);
          if($muvelet['valasz']=="Sikeres művelet!"){
            echo 
            "<script>
                   window.location.href = 'admin.php'; 
            </script>";
           }
           else{
               echo 
               "<script>
                   alert('A módosítás sikertelen volt! Felhasználó azonosító:".$modid."');
               </script>";
           } 
        }
      }
    }

    if (isset($_GET['fmegjelenit'])) {
      $fmennyit = (int)$_GET['fmegjelenit'];
    } else {
      $fmennyit = 10; 
    }
    if (isset($_GET['adminokat'])) {
      $adminokat = 1;
    } else {
      $adminokat=0; 
    }
    
    if (isset($_GET['rmegjelenit'])) {
      $rmennyit = (int)$_GET['rmegjelenit'];
    } else {
      $rmennyit = 10; 
    }
    if (isset($_GET['fizetetteket'])) {
      $fizetetteket = 1;
    } else {
      $fizetetteket=0; 
    }


    $url = basename($_SERVER['PHP_SELF']);
    // var_dump($url);
    $_SESSION['return_url'] = $url;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="./css/main.css">
</head>
<body>
    <div id="main">
    <?php
      if(isset($_GET['u_edit'])){
        $lekerdezes=new CRUD();
        $modositando_id = $_GET['u_edit'];
        if($modositando_id==1){
          echo
            "<script>
              window.location.href = 'index.php'; 
            </script>";
        }
        else{
          $felhasznalo_modositas=$lekerdezes->modositando_felhasznalo_id($modositando_id);
            if(is_array($felhasznalo_modositas)){
              foreach($felhasznalo_modositas as $item){
                echo "
                  <div id='hatter'>
                    <div id='modositPanel' class='container'>
                      <div class=row>
                        <div class=col-md-4 col-sm-2 col-xs-2>
                          <p>Felhasználó módosítás</p>
                        </div>
                        <div class=col-md-8 col-sm-10 col-xs-10>
                          <button type='button' class='close text-dark' aria-label='Close' onclick=window.location.href='admin.php'>
                            <span aria-hidden='true'>&times;</span>
                          </button>
                        </div>
                      </div>
                      <hr>
                      <script>
                        document.getElementById('modositPanel').style.display='block';
                        document.getElementById('main').classList.add('sotetites');
                      </script>
                      <div class=row>
                        <div class='col-12 justify-content-center'>
                          <form id='modform' action='".$_SERVER['PHP_SELF']."' method='post' enctype='multipart/form-data' class='text-center'>
                            <input type='hidden' name='edit_u_id' value='".$item['id']."'>
                            <label for='edit_u_name'>Felhasználó neve:</label>
                            <input type='text' required name='edit_u_name' value='". $item['name']. "'><br>
                            <label for='edit_u_uname'>Felhasználónév:</label>
                            <input type='text' required name='edit_u_uname' value='". $item['username']. "'><br>
                            <label for='edit_u_email'>E-mail cím:</label>
                            <input type='text' required name='edit_u_email' value=".$item['email']."><br>
                            <label for='edit_u_admin'>Admin jogosultság:</label><br>
                            <input type='number' min=0 max=1 required name='edit_u_admin' value=".$item['admin']."><br>
                            <input type='submit' class='btn btn-outline-success m-1' value='Felhasználó módosítása' name='edit_user' id='edit_user'>
                            <input type='reset' class='btn btn-outline-danger m-1' value='Alaphelyzet' id='close_edit'>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                ";
              }
            }
        }
      }
    ?>
    <?php
      if(isset($_GET['o_edit'])){
        $lekerdezes=new CRUD();
        $modositando_id = $_GET['o_edit'];
        $rendeles_modositas=$lekerdezes->modositando_rendeles_id($modositando_id);
          if(is_array($rendeles_modositas)){
            foreach($rendeles_modositas as $item){
              echo "
                <div id='hatter'>
                  <div id='modositPanel' class='container'>
                    <div class=row>
                      <div class=col-md-4 col-sm-2 col-xs-2>
                        <p>Rendelés módosítás</p>
                      </div>
                      <div class=col-md-8 col-sm-10 col-xs-10>
                        <button type='button' class='close text-dark' aria-label='Close' onclick=window.location.href='admin.php'>
                          <span aria-hidden='true'>&times;</span>
                        </button>
                      </div>
                    </div>
                    <hr>
                    <script>
                      document.getElementById('modositPanel').style.display='block';
                      document.getElementById('main').classList.add('sotetites');
                    </script>
                    <div class=row>
                      <div class='col-12 justify-content-center'>
                        <form id='modform' action='".$_SERVER['PHP_SELF']."' method='post' enctype='multipart/form-data' class='text-center'>
                          <input type='hidden' name='edit_o_id' value='".$item['id']."'>
                          <label for='edit_o_megrendelo'>Megrendelő neve:</label>
                          <input type='text' required name='edit_o_megrendelo' value='". $item['nev']. "'><br>
                          <label for='edit_o_email'>E-mail cím:</label>
                          <input type='text' required name='edit_u_email' value='". $item['email']. "'><br>
                          <label for='edit_o_telefonszam'>Telefonszám:</label>
                          <input type='text' required name='edit_o_telefonszam' value=".$item['telefonszam']."><br>
                          <label for='edit_o_szcim'>Szállítási cím:</label>
                          <input type='text' required name='edit_o_szcim' value='".$item['sz_cim']."'><br>
                          <label for='edit_o_termekek'>Rendelés</label>
                          <input type='text' required name='edit_o_termekek' value='".$item['termekek']."'><br>
                          <label for='edit_o_vegosszeg'>Végösszeg <span class='figyelmeztetes'>(FIGYELEM! Manuális rekalkulációt igényel)</span>:</label>
                          <input type='number' required name='edit_o_vegosszeg' value=".$item['vegosszeg']."><br>
                          <label for='edit_o_fizetve'>Fizetve:</label><br>
                          <input type='number' min=0 max=1 required name='edit_o_fizetve' value=".$item['fizetve']."><br>
                          <input type='submit' class='btn btn-outline-success m-1' value='Rendelés módosítása' name='edit_order' id='edit_order'>
                          <input type='reset' class='btn btn-outline-danger m-1' value='Alaphelyzet' id='close_edit'>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              ";
            }
          }
      }
    ?>
    <?php
    if(isset($_GET['p_edit'])){
                if($bejelentkezett_felhasznalo[0]['admin']==1){
                    $lekerdezes=new CRUD();
                    $modositando_id = $_GET['p_edit'];
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
                                            <button type='button' class='close text-dark' aria-label='Close' onclick=window.location.href='admin.php'>
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
                                            <img src=./img/uploaded_img/".str_replace(' ', '_',$item['termek_kepurl'])." alt='".$item['termek_nev']."' class='img-thumbnail'>
                                        </div>
                                            <div class=col-md-8 col-sm-10 col-xs-10>
                                                <form id='modform' action='".$_SERVER['PHP_SELF']."' method='post' enctype='multipart/form-data' class='text-center'>
                                                    <input type='hidden' name='edit_termek_id' value='".$item['id']."'>
                                                    <label for='edit_termek_nev'>Termék neve:</label>
                                                    <input type='text' required name='edit_termek_nev' value='". $item['termek_nev']. "'><br>
                                                    <input type='hidden' name='edit_termek_kategoria' value='".$item['termek_kategoria']."'>
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
                        window.location.href = 'admin.php'; 
                    </script>";
                }
    }
    ?>
      <div id="imageModal" class="modal">
        <span class="close">&times;</span>
        <img class="modal-content" id="modalImg">
      </div>
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
                      <div class="text-center">
                        
                      </div>
                    </li>
                    <li class="nav-item mx-auto">
                      <a class="nav-link text-center" href="./categories/pastas.php">Tészták<br><img src="./img/pasta.png" class="text-center justify-content-center"></a>
                      <div class="text-center">
                        
                      </div>
                    </li>
                    <li class="nav-item mx-auto">
                      <a class="nav-link text-center" href="./categories/salads.php">Saláták<br><img src="./img/salad.png" class="text-center justify-content-center"></a>
                      <div class="text-center">
                       
                      </div>
                    </li>
                    <li class="nav-item mx-auto">
                      <a class="nav-link text-center" href="./categories/hamburgers.php">Hamburgerek<br><img src="./img/burger.png" class="text-center justify-content-center"></a>
                      <div class="text-center">
                        
                      </div>
                    </li>
                    <a class="navbar-brand d-none d-lg-block" href="./index.php">
                      <img src="./img/logo_final.png" class="text-center img-fluid" alt="Leveld Gasztroudvar Városlőd">
                    </a>
                    <li class="nav-item mx-auto">
                      <a class="nav-link text-center" href="./categories/bowls.php">Többszemélyes<br>tálak<br><img src="./img/plate.png" class="text-center justify-content-center"></a>
                      <div class="text-center">
                        
                      </div>
                    </li>
                    <li class="nav-item mx-auto">
                      <a class="nav-link text-center" href="./categories/gyros.php">Gyros<br>tálak<br><img src="./img/gyros.png" class="text-center justify-content-center"></a>
                      <div class="text-center">
                        
                      </div>
                    </li>
                    <li class="nav-item mx-auto">
                      <a class="nav-link text-center" href="./categories/friedstuff.php">Frissensültek<br><img src="./img/frissensult.png" class="text-center justify-content-center"></a>
                      <div class="text-center">
                        
                      </div>
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
      <div class="container-fluid">
        <div class="row">
          <div class="felhasznaloi-panel col-lg-1 col-sm-4 col-md-4 bg-dark rounded text-white my-5 p-2">
            <div>
              <?php echo "<p>Üdvözöljük ".$bejelentkezett_felhasznalo[0]["name"]."!</p><button class='btn w-100' type='button'><a class='korvonal' href='./rendeleseim.php'>Rendeléseim</a></button><br><button class='btn w-100' type=button'><a class='korvonal' href='./adataim.php'>Adataim</a></button><br><button class='btn w-100' type=button'><a class='korvonal' href='./logout.php'>Kijelentkezés</a></button></p>"?>
            </div>
          </div>
        </div>
        <hr>
        <div id="adminPanel">
          <h4 class='korvonal'>Felhasználókezelés <button type="button" class="btn-sm btn-warning collapse-btn text-white"><i class="fas fa-angle-down"></i></button></h4>
          <div class="row justify-content-center">
            <div class="col-auto adminMenu">
            <div class="row">
                <div class="col-xs-12 col-lg-3 mt-4 mx-2">
                  <div class="form-group">
                    <label for="mennyit" class="korvonal">Felhasználók megjelenítése:</label>
                    <form action="admin.php" method="get">
                      <select class="form-control my-0" name="fmegjelenit" id="mennyit">
                          <option value="10" <?php if ($fmennyit == 10) echo "selected"; ?>>10</option>
                          <option value="25" <?php if ($fmennyit == 25) echo "selected"; ?>>25</option>
                          <option value="50" <?php if ($fmennyit == 50) echo "selected"; ?>>50</option>
                          <option value="100" <?php if ($fmennyit == 100) echo "selected"; ?>>100</option>
                          <option value="250" <?php if ($fmennyit == 250) echo "selected"; ?>>250</option>
                      </select>
                      <br>
                      <label for="adminokat" class="form-check-label korvonal">Csak admin-jogú felhasználók megjelenítése:</label>
                      <input class="" type="checkbox" name="adminokat"<?php if ($adminokat) echo "checked"; ?>>
                      <br>
                      <button type="submit" class="btn btn-sm btn-danger my-1 form-control ">Megjelenít</button>
                    </form>
                  </div>
                </div>
              </div>
              <hr>
              <table class="table-responsive my-3 mx-auto" id="adminmenutablazat">
                <tr class='bg-warning fejlec'>
                  <td>Név</td>
                  <td>Felhasználónév</td>
                  <td>E-mail cím</td>
                  <td>Admin<br>jogosultság</td>
                  <td>Egyéb művelet</td>
                </tr>
                <?php
                  $lekerdezes=new CRUD();
                  // var_dump($mennyit);
                  // var_dump($adminokat);
                  $felhasznalok=$lekerdezes->felhasznalok_lekerdezes($fmennyit, $adminokat);
                  // var_dump($felhasznalok);
                  // echo count($felhasznalok);
                  
                  if(count($felhasznalok)>1 && !isset($felhasznalok['valasz'])){
                    foreach($felhasznalok as $item){
                      if($item['id']!=1){//főadmin
                        $confirm_uzenet = "onclick=\"return confirm('Biztosan törölni akarja ezt a felhasználót?')\"";//!
                        echo 
                          "<tr class='table-warning'>
                            <td>".$item['name']."</td>
                            <td>".$item['username']."</td>
                            <td>".$item['email']."</td>";
                        if($item['admin']==1){
                          if($bejelentkezett_felhasznalo[0]['id']==1)//főadmin
                          {
                            echo "
                            <td>
                              <form method='post' action='admin.php?action=grant_admin&modid=".(int)$item['id']."'>
                                <div class='input-group'>
                                  <select class='mx-1 form-control' name='adminjog' id='admin'>";
                                  if ($item['admin'] == 0) {
                                    echo "
                                    <option value='0' selected>Nem</option>
                                    <option value='1'>Igen</option>
                                    ";
                                  } else { 
                                    echo "
                                      <option value='0'>Nem</option>
                                      <option value='1' selected>Igen</option>
                                      ";
                                  }
                                  echo "</select>
                                  <button type='submit' class='btn btn-info btn-sm mx-1'><i class='fa-solid fa-check'></i></button>
                                </div>
                              </form>
                            </td>";
                            echo"
                            <td>
                              <div class='input-group'>
                                <button type='button' class='btn btn-info btn-sm text-white mx-1 form-control'>
                                  <a href='admin.php?u_edit=".$item['id']."'><i class='fas fa-pencil modosit'></i></a>
                                </button>
                                <button type='button' class='btn btn-danger btn-sm text-white mx-1 form-control'>
                                  <a href='admin.php?u_delete=".$item['id']."'".$confirm_uzenet. "><i class='fas fa-trash-alt torol'></i></a>
                                </button>
                              </div>
                            </td>
                          </tr>";
                          }
                          else{
                            echo "<td>Van</td><td></td>";
                          }
                        }
                        else{
                          echo "
                          <td>
                            <form method='post' action='admin.php?action=grant_admin&modid=".(int)$item['id']."'>
                              <div class='input-group'>
                                <select class='mx-1 form-control' name='adminjog' id='admin'>";
                                echo "
                                  <option value='0' selected>Nem</option>
                                  <option value='1'>Igen</option>
                                  ";
                                echo "</select>
                                <button type='submit' class='btn btn-info btn-sm mx-1'><i class='fa-solid fa-check'></i></button>
                              </div>
                            </form>
                          </td>";
                          echo"
                          <td>
                            <div class='input-group'>
                              <button type='button' class='btn btn-info btn-sm text-white mx-1 form-control'>
                                <a href='admin.php?u_edit=".$item['id']."'><i class='fas fa-pencil modosit'></i></a>
                              </button>
                              <button type='button' class='btn btn-danger btn-sm text-white mx-1 form-control'>
                                <a href='admin.php?u_delete=".$item['id']."'".$confirm_uzenet. "><i class='fas fa-trash-alt torol'></i></a>
                              </button>
                            </div>
                          </td>
                        </tr>";
                        }
                        
                      } 
                    }
                  }
                  else{
                    if(count($felhasznalok)==1 && (int)$felhasznalok[0]['id']===1){
                      echo "<tr class=table-warning><td colspan=5><h6 class='text-center py-2'>Nincsen még regisztrált felhasználó!</h6></td></tr>";
                    }
                  }  
                  ?>
              </table>
            </div>
          </div>
          <hr>
          <h4 class='korvonal'>Rendelések <button type="button" class="btn-sm btn-warning collapse-btn text-white"><i class="fas fa-angle-down"></i></button></h4>
          <div class="row justify-content-center">
            <div class="col-auto adminMenu">
              <div class="row">
                <div class="col-xs-12 col-lg-3 mt-4 mx-2">
                  <div class="form-group">
                    <label for="mennyit" class="korvonal">Rendelések megjelenítése:</label>
                    <form action="admin.php" method="get">
                      <select class="form-control my-0" name="rmegjelenit" id="mennyit">
                          <option value="10" <?php if ($rmennyit == 10) echo "selected"; ?>>10</option>
                          <option value="25" <?php if ($rmennyit == 25) echo "selected"; ?>>25</option>
                          <option value="50" <?php if ($rmennyit == 50) echo "selected"; ?>>50</option>
                          <option value="100" <?php if ($rmennyit == 100) echo "selected"; ?>>100</option>
                          <option value="250" <?php if ($rmennyit == 250) echo "selected"; ?>>250</option>
                          <option value="500" <?php if ($rmennyit == 500) echo "selected"; ?>>500</option>
                      </select>
                      <br>
                      <label for="fizetetteket" class="form-check-label korvonal">Csak fizetettek megjelenítése:</label>
                      <input class="" type="checkbox" name="fizetetteket"<?php if ($fizetetteket) echo "checked"; ?>>
                      <br>
                      <button type="submit" class="btn btn-sm btn-danger my-1 form-control ">Megjelenít</button>
                    </form>
                  </div>
                </div>
              </div>
              <hr>
              <table class="table-responsive my-3 mx-auto" id="adminmenutablazat">
                <tr class="bg-warning fejlec">
                    <td>Megrendelő adatai</td>
                    <td>Rendelés</td>
                    <td>Rendelés végösszeg</td>
                    <td>Rendelés dátuma</td>
                    <td>Fizetve</td>
                    <td>Egyéb műveletek</td>
                </tr>
                <?php

                    $lekerdezes=new CRUD();
                    $rendelesek=$lekerdezes->rendelesek_lekerdezes($rmennyit, $fizetetteket);
                    // var_dump($rendelesek);
                    if(count($rendelesek)>0 && !isset($rendelesek['valasz'])){
                      foreach($rendelesek as $item){
                            $confirm_uzenet = "onclick=\"return confirm('Biztosan törölni akarja ezt a rendelést?')\"";//!
                            $rendeles=explode(';',$item['termekek']);
                            $rendelestd="<ul>";
                            foreach($rendeles as $rendeles_item){
                                $tmp=explode(':',$rendeles_item);
                                $termeknev=$tmp[0];
                                $termekdb=$tmp[1];
                                $rendelestd.="<li>".$termeknev."-".$termekdb."x";
                            }
                            echo "<tr style='";
                            if($item['fizetve']==1){
                                echo "filter:grayscale(100%); background-color:#ffeeba;";
                            }
                            else{
                                echo "background-color:#ffeeba;";
                            }
                            echo "'>
                                    <td>
                                        <ul>
                                            <li>".$item['nev']."</li>
                                            <li>".$item['email']."</li>
                                            <li>".$item['telefonszam']."</li>";
                                            if($item['sz_cim']==""){
                                              echo "<li><i><b>Személyes átvétel</b></i></li>";
                                            }
                                            else{
                                              echo "<li>".$item['sz_cim']."</li>";
                                            }
                                            echo"
                                        </ul>
                                    </td>
                                    <td>".$rendelestd."</td>
                                    <td>".$item['vegosszeg']." Ft</td>
                                    <td>".$item['rendeles_datuma']."</td>
                                    <td>
                                        <form method='post' action='admin.php?action=order_paid&modid=".(int)$item['id']."'>
                                            <div class='input-group'>
                                                <select class='mx-1 form-control' name='fizetve' id='fizetve'>";
                                                    if ($item['fizetve'] == 0) {
                                                        echo "
                                                            <option value='0' selected>Nem</option>
                                                            <option value='1'>Igen</option>
                                                            ";
                                                    } else { 
                                                        echo "
                                                            <option value='0'>Nem</option>
                                                            <option value='1' selected>Igen</option>
                                                            ";
                                                    }
                                                echo "</select>
                                                <button type='submit' class='btn btn-info btn-sm mx-1'><i class='fa-solid fa-check'></i></button>
                                            </div>
                                        </form>
                                    </td>
                                    <td>
                                      <div class='input-group'>
                                        <button type='button' class='btn btn-info btn-sm text-white mx-1 form-control'>
                                          <a href='admin.php?o_edit=".$item['id']."'><i class='fas fa-pencil modosit'></i></a>
                                        </button>
                                        <button type='button' class='btn btn-danger btn-sm text-white mx-1 form-control'>
                                            <a href='admin.php?o_delete=".$item['id']."'".$confirm_uzenet. "><i class='fas fa-trash-alt torol'></i></a>
                                        </button>
                                      </div>
                                    </td>
                                </tr>
                            ";
                        }
                    }
                    else{
                      echo "<tr class='table-warning'><td colspan=6><h6 class='text-center py-2'>Nincsen még leadott rendelés!</h6></td></tr>";
                    }
                    
                  

                  
                ?>
              </table>
            </div>
          </div>
          <hr>
          <h4 class='korvonal'>Termékek <button type="button" class="btn-sm btn-warning collapse-btn text-white"><i class="fas fa-angle-down"></i></button></h4>
          <div class="row justify-content-center">
            <div class="col-auto adminMenu">
            <div class="mt-2">
              <h5 class="korvonal">Termék hozzáadása:</h5>
              <div>
                <div class="col-12 col-md-4">
                  <form action="" method="post" enctype="multipart/form-data" class="my-2">
                    <div class="form-group">
                      <input type="text" class="form-control" name="t_nev" placeholder="Termék neve" required>
                    </div>
                    <div class="form-group">
                      <select class="form-control" name='t_kategoria' required>
                        <option value="" selected>Válassz kategóriát</option>
                        <option value='pizza'>Pizza</option>
                        <option value='hamburger'>Hamburger</option>
                        <option value='frissensult'>Frissensült</option>
                        <option value='salata'>Saláta</option>
                        <option value='tal'>Tál</option>
                        <option value='teszta'>Tészta</option>
                        <option value='gyrostal'>Gyrostál</option>
                        <option value='koret'>Körét</option>
                        <option value='ontet'>Öntet</option>
                        <option value='udito'>Üdítő</option>
                        <option value='extra'>Extra</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <input type="number" class="form-control" name="t_ar" min="0" placeholder="Termék ára" required>
                    </div>
                    <div class="form-group">
                      <textarea class="form-control" name="t_leiras" placeholder="Leírás"></textarea>
                    </div>
                    <div class="form-group">
                      <label for="t_kep">Termék képe:</label>
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="t_kep" name="t_kep" accept="image/png, image/jpg, image/jpeg">
                        <label class="custom-file-label" for="t_kep">Válassz fájlt...</label>
                      </div>
                    </div>
                    <div class="form-group text-center">
                      <input type="submit" class="btn btn-danger w-100" value="Hozzáadás" name="add_product">
                    </div>
                  </form>
                </div>
              </div>
            </div>

              <table class="table-responsive my-3 mx-auto" id="adminmenutablazat">
                <tr class="bg-warning fejlec">
                    <td>Termék neve</td>
                    <td>Termék ára</td>
                    <td>Termék kategória</td>
                    <td>Termék leírása</td>
                    <td>Termék képe</td>
                    <td>Műveletek</td>
                </tr>
                <?php

                    $lekerdezes=new CRUD();
                    $termekek=$lekerdezes->kategoria_lekerdezes("all");
                    
                    if(count($termekek)>0 && !isset($termekek['valasz'])){
                        foreach($termekek as $item){
                          $confirm_uzenet = "onclick=\"return confirm('Biztosan törölni akarja ezt a terméket?')\"";//!
                          echo 
                          "<tr class='table-warning'>
                            <td>".$item['termek_nev']."</td>
                            <td>".$item['termek_ar']." Ft</td>
                            <td>
                              <form method='post' action='admin.php?action=update_category&modid=".(int)$item['id']."'>
                                <div class='input-group'>
                                  <select class='mx-1 form-control' name='kategoria' id='kategoria'>";
                                    switch($item['termek_kategoria']){
                                      case 'pizza':{
                                        echo "
                                          <option value='pizza' selected>Pizza</option>
                                          <option value='hamburger'>Hamburger</option>
                                          <option value='frissensult'>Frissensült</option>
                                          <option value='salata'>Saláta</option>
                                          <option value='tal'>Tál</option>
                                          <option value='teszta'>Tészta</option>
                                          <option value='gyrostal'>Gyrostál</option>
                                          <option value='koret'>Körét</option>
                                          <option value='ontet'>Öntet</option>
                                          <option value='udito'>Üdítő</option>
                                          <option value='extra'>Extra</option>
                                          ";
                                        break;
                                      }
                                      case 'hamburger':{
                                        echo "
                                          <option value='pizza'>Pizza</option>
                                          <option value='hamburger' selected>Hamburger</option>
                                          <option value='frissensult'>Frissensült</option>
                                          <option value='salata'>Saláta</option>
                                          <option value='tal'>Tál</option>
                                          <option value='teszta'>Tészta</option>
                                          <option value='gyrostal'>Gyrostál</option>
                                          <option value='koret'>Körét</option>
                                          <option value='ontet'>Öntet</option>
                                          <option value='udito'>Üdítő</option>
                                          <option value='extra'>Extra</option>
                                          ";
                                        break;
                                      }
                                      case 'frissensult':{
                                        echo "
                                          <option value='pizza'>Pizza</option>
                                          <option value='hamburger'>Hamburger</option>
                                          <option value='frissensult' selected>Frissensült</option>
                                          <option value='salata'>Saláta</option>
                                          <option value='tal'>Tál</option>
                                          <option value='teszta'>Tészta</option>
                                          <option value='gyrostal'>Gyrostál</option>
                                          <option value='koret'>Körét</option>
                                          <option value='ontet'>Öntet</option>
                                          <option value='udito'>Üdítő</option>
                                          <option value='extra'>Extra</option>
                                          ";
                                        break;
                                      }
                                      case 'salata':{
                                        echo "
                                        <option value='pizza'>Pizza</option>
                                        <option value='hamburger'>Hamburger</option>
                                        <option value='frissensult'>Frissensült</option>
                                        <option value='salata' selected>Saláta</option>
                                        <option value='tal'>Tál</option>
                                        <option value='teszta'>Tészta</option>
                                        <option value='gyrostal'>Gyrostál</option>
                                        <option value='koret'>Körét</option>
                                        <option value='ontet'>Öntet</option>
                                        <option value='udito'>Üdítő</option>
                                        <option value='extra'>Extra</option>
                                        ";
                                        break;
                                      }
                                      case 'tal':{
                                        echo "
                                          <option value='pizza'>Pizza</option>
                                          <option value='hamburger'>Hamburger</option>
                                          <option value='frissensult'>Frissensült</option>
                                          <option value='salata'>Saláta</option>
                                          <option value='tal' selected>Tál</option>
                                          <option value='teszta'>Tészta</option>
                                          <option value='gyrostal'>Gyrostál</option>
                                          <option value='koret'>Körét</option>
                                          <option value='ontet'>Öntet</option>
                                          <option value='udito'>Üdítő</option>
                                          <option value='extra'>Extra</option>
                                          ";
                                        break;
                                      }
                                      case 'teszta':{
                                        echo "
                                          <option value='pizza'>Pizza</option>
                                          <option value='hamburger'>Hamburger</option>
                                          <option value='frissensult'>Frissensült</option>
                                          <option value='salata'>Saláta</option>
                                          <option value='tal'>Tál</option>
                                          <option value='teszta' selected>Tészta</option>
                                          <option value='gyrostal'>Gyrostál</option>
                                          <option value='koret'>Körét</option>
                                          <option value='ontet'>Öntet</option>
                                          <option value='udito'>Üdítő</option>
                                          <option value='extra'>Extra</option>
                                          ";
                                        break;
                                      }
                                      case 'gyrostal':{
                                        echo "
                                        <option value='pizza'>Pizza</option>
                                        <option value='hamburger'>Hamburger</option>
                                        <option value='frissensult'>Frissensült</option>
                                        <option value='salata'>Saláta</option>
                                        <option value='tal'>Tál</option>
                                        <option value='teszta'>Tészta</option>
                                        <option value='gyrostal' selected>Gyrostál</option>
                                        <option value='koret'>Körét</option>
                                        <option value='ontet'>Öntet</option>
                                        <option value='udito'>Üdítő</option>
                                        <option value='extra'>Extra</option>
                                        ";
                                        break;
                                      }
                                      case 'koret':{
                                        echo "
                                        <option value='pizza'>Pizza</option>
                                        <option value='hamburger'>Hamburger</option>
                                        <option value='frissensult'>Frissensült</option>
                                        <option value='salata'>Saláta</option>
                                        <option value='tal'>Tál</option>
                                        <option value='teszta'>Tészta</option>
                                        <option value='gyrostal'>Gyrostál</option>
                                        <option value='koret' selected>Körét</option>
                                        <option value='ontet'>Öntet</option>
                                        <option value='udito'>Üdítő</option>
                                        <option value='extra'>Extra</option>
                                        ";
                                        break;
                                      }
                                      case 'ontet':{
                                        echo "
                                        <option value='pizza'>Pizza</option>
                                        <option value='hamburger'>Hamburger</option>
                                        <option value='frissensult'>Frissensült</option>
                                        <option value='salata'>Saláta</option>
                                        <option value='tal'>Tál</option>
                                        <option value='teszta'>Tészta</option>
                                        <option value='gyrostal'>Gyrostál</option>
                                        <option value='koret'>Körét</option>
                                        <option value='ontet' selected>Öntet</option>
                                        <option value='udito'>Üdítő</option>
                                        <option value='extra'>Extra</option>
                                        ";
                                        break;
                                      }
                                      case 'udito':{
                                        echo "
                                          <option value='pizza'>Pizza</option>
                                          <option value='hamburger'>Hamburger</option>
                                          <option value='frissensult'>Frissensült</option>
                                          <option value='salata'>Saláta</option>
                                          <option value='tal'>Tál</option>
                                          <option value='teszta'>Tészta</option>
                                          <option value='gyrostal'>Gyrostál</option>
                                          <option value='koret'>Körét</option>
                                          <option value='ontet'>Öntet</option>
                                          <option value='udito' selected>Üdítő</option>
                                          <option value='extra'>Extra</option>
                                          ";
                                        break;
                                      }
                                      case 'extra':{
                                        echo "
                                          <option value='pizza'>Pizza</option>
                                          <option value='hamburger'>Hamburger</option>
                                          <option value='frissensult'>Frissensült</option>
                                          <option value='salata'>Saláta</option>
                                          <option value='tal'>Tál</option>
                                          <option value='teszta'>Tészta</option>
                                          <option value='gyrostal'>Gyrostál</option>
                                          <option value='koret'>Körét</option>
                                          <option value='ontet'>Öntet</option>
                                          <option value='udito'>Üdítő</option>
                                          <option value='extra' selected>Extra</option>
                                          ";
                                        break;
                                      }
                                      default:{
                                        echo "Probléma adódott a kategória megjelenítésével: ismeretlen kategória";
                                      }
                                    }
                                  echo "
                                  </select>
                                  <button type='submit' class='btn btn-info btn-sm mx-1'><i class='fa-solid fa-check'></i></button>
                                </div>
                              </form>
                            </td>
                            <td>".$item['termek_leiras']."</td>
                            <td class='thumbnail'><img src=./img/uploaded_img/".str_replace(' ', '_',$item['termek_kepurl'])." alt='".$item['termek_nev']."'></td>
                            <td>
                              <div class='input-group'>
                                <button type='button' class='btn btn-info btn-sm text-white mx-1 form-control'>
                                  <a href='admin.php?p_edit=".$item['id']."'><i class='fas fa-pencil modosit'></i></a>
                                </button>
                                <button type='button' class='btn btn-danger btn-sm text-white mx-1 form-control'>
                                  <a href='admin.php?p_delete=".$item['id']."'".$confirm_uzenet. "><i class='fas fa-trash-alt torol'></i></a>
                                </button>
                              </div>
                            </td>";
                        }
                    }
                    else{
                      echo "<tr class='table-warning'><td colspan=6><h6 class='text-center py-2'>Nincsen még termék feltöltve az adatbázisba!</h6></td></tr>";
                    }
                    
                  

                  
                ?>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script defer src="./js/osszecsuk.js"></script>
<script src="./js/indexkepek.js"></script>
</html>

