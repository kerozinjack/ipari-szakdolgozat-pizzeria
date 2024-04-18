<?php
    // error_reporting(E_ERROR | E_PARSE);
    

    require "./classes/adatbazis.class.php";
    require "./classes/muvelet.class.php";
    
    if(empty($_SESSION["id"])){
        echo 
            "<script>
                window.location.href = 'index.php'; 
            </script>";
        exit();
    }

    $felhasznalo=new Felhasznalo();


    
    if(!empty($_SESSION["id"])){
        $id=$_SESSION["id"];
        $bejelentkezett_felhasznalo=$felhasznalo->felhasznalo_kivalasztasa($id);
        // var_dump($bejelentkezett_felhasznalo);
    }

    $adatmodositas=new Felhasznalo();
    if(isset($_POST['submit'])){
        $modosit_id=$id;
        $mnev=$_POST['name'];
        $mfelhasznalonev=$_POST['username'];
        $memail=$_POST['email'];
 
        $muvelet=$adatmodositas->felhasznalo_adatmodositas($mnev,$mfelhasznalonev,$memail,$modosit_id);
        switch ($muvelet) {
            case 0:
                echo 
                    "<script>
                        alert('A megadott felhasználónév már használatban van!')
                    </script>";
                    break;
            case 1:
                echo 
                    "<script>
                        alert('A megadott email cím már használatban van!')
                    </script>";
                    break;
            
            default:
                if($muvelet['valasz']=="Sikeres művelet!"){
                    echo 
                    "<script>
                        alert('Az adatok módosítása sikeres volt!')        
                    </script>";
                    echo //!
                    "<script>
                        window.location.href = 'index.php'; 
                    </script>";
                    }
                    else{
                    echo 
                        "<script>
                        alert('Az adatok módosítása sikertelen volt!')
                        </script>";
                    }
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
    <title>Adatmódosítás</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="./css/main.css">
</head>
<body class="regisztralo">
    <div class="container">
            <div class="row mx-0 my-5">
                <div class="col-md-5 pr-0">
                    <div class="p-4 bg-light h-100 bejelentkezo-form position-relative">
                        <h3 class="korvonal align-self-center">Adataim</h3>
                        <form id="regisztralo" action="" method="post" autocomplete="off">
                            <label  class="display-5 korvonal" for="name">Név: </label>
                            <input type="text" name="name" id="name" required class="form-control mb-2" value='<?php echo $bejelentkezett_felhasznalo[0]['name'];?>'><br>   
                            <label  class="display-5 korvonal" for="username">Felhasználónév: </label>
                            <input type="text" name="username" id="username" required class="form-control mb-2" value='<?php echo $bejelentkezett_felhasznalo[0]['username'];?>'><br>
                            <label  class="display-5 korvonal" for="email">Email: </label>
                            <input type="email" name="email" id="email" required class="form-control mb-2" value='<?php echo $bejelentkezett_felhasznalo[0]['email'];?>'><br>   
                            <input type="submit" value="Adataim módosítása" name="submit" required class="btn btn-warning btn-block mb-2">
                        </form>
                        <br>
                        <hr class="elvalaszto">
                        <input type="button" value="Jelszó módosítása" class="btn btn-secondary btn-block mb-2" onclick=window.location.href='jelszomodositas.php'>
                        
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
    <!-- <script defer src="./js/jelszo.js"></script> -->
    

</body>
</html>



