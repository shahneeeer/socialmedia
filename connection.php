<?php
    define("HOST","localhost");
    define("UNAME","root");
    define("PASSWORD","");
    define("DATABASE","social_media");

    $conn = mysqli_connect(HOST,UNAME,PASSWORD,DATABASE) or die ("Connection Error")
?>