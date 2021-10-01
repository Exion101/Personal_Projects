<?php
require(__DIR__ . "/../lib/connect.php");

if (!$conn) {
    echo "error somethings wrong " . mysqli_connect_error();
    exit();
}
// echo "successfully connected <br><br><hr>";
if ($_REQUEST['q']) {
    $check_user = $_REQUEST['q'];

    $sql = "SELECT 1 from users where username='$check_user'";
    $retUser = mysqli_query($conn, $sql);
    $retUser = mysqli_fetch_assoc($retUser);

    if ($retUser) {
        echo '<span style="color: red"> Username already exists.</span>';
    }
}
