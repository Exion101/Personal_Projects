<?php
require(__DIR__ . "/../lib/connect.php");
if (!$conn) {
    echo "Connection to Server Failed" . mysqli_connect_error();
    exit();
}
if ($_REQUEST['q']) {
    $check_email = $_REQUEST['q'];

    $sql = "SELECT 1 from users where email='$check_email'";
    $retEmail = mysqli_query($conn, $sql);
    $retEmail = mysqli_fetch_assoc($retEmail);

    if ($retEmail) {
        echo '<span style="color: red"> Email already exists.</span>';
    }
}
