<?php
session_start();
$session_id = session_id();
$_SESSION = array();
session_destroy();

require("header.php");
setcookie("PHPSESSID", "", time() - 3600);
echo '<span class="form-container" style="color:white"><span class="form-wrapper"><h1 style="padding-top:120px;">See you soon!</h1></span></span>';
die(header("Refresh:3; url=login.php"));
