<?php
    $server = "localhost";
    $user = "root";
    $pass = "";
    $db   = "weather_db";

    $conn = mysqli_connect($server,$user,$pass, $db);
    if(!$conn){
        die("failed to connect: " . mysqli_connect_error());
    }
?>