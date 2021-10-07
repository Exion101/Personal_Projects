<?php
require("header.php");
require(__DIR__ . "/lib/connect.php");

if (!is_logged_in()) {
    echo '<span class="form-container" style="color:white"><span class="form-wrapper"><h1 style="padding-top:120px;">Something is Wrong Here.</h1></span></span>';
    die(header("Refresh:3; url=login.php"));
}
?>

<html>

<body>
    <?php
    var_dump($_SESSION);
    echo $session_id;
    ?>

</body>

</html>