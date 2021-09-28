<?php
ini_set('display_errors', 1);
ini_set('display_atartup_errors', 1);
error_reporting(E_ALL);

function getConn()
{
    global $conn;

    if (!isset($conn)) {
        require(__DIR__ . "/account.php");

        $conn = mysqli_connect($hostname, $username, $password, $database);
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        echo "Successful Connection";
    }
    return $conn;
}

$conn = getConn();
