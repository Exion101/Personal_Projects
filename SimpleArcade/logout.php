<?php
session_start();
$session_id = session_id();
$_SESSION = array();
session_destroy();

require("header.php");
setcookie("PHPSESSID", "", time() - 3600);
echo '<div class="msg-container"><div class="msg-content">See you soon!</div></div>';
die(header("Refresh:3; url=login.php"));
