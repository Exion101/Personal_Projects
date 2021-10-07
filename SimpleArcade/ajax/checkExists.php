<?php
require(__DIR__ . "/../lib/connect.php");
if (!$conn) {
    echo "Connection to Server Failed" . mysqli_connect_error();
    exit();
}
if ($_REQUEST['q']) {
    $value = $_REQUEST['q'];

    $sql = "SELECT 1 from users where email='$value' or username='$value'";
    $retVal = mysqli_query($conn, $sql);
    $retVal = mysqli_fetch_assoc($retVal);

    if (!$retVal) {
        echo 'Email/Username does not exist.';
    }
}
