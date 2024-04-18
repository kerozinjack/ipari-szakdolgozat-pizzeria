<?php
    // require 'config.php';
    require "./classes/adatbazis.class.php";
    require "./classes/muvelet.class.php";
    $_SESSION=[];
    session_unset();
    session_destroy();
    echo 
    "<script>
        window.location.href = 'index.php'; 
    </script>";


?>