<?php
session_set_cookie_params([
    'lifetime' => 60 * 60,
    'path' => '/SimpleArcade',
    'domain' => $_SERVER['HTTP_HOST'],
    'secure' => true,
    'httponly' => true,
    'samesite' => 'lax'
]);
session_start();
$session_id = session_id();

require(__DIR__ . "/../SimpleArcade/lib/myFunctions.php");
?>

<html>

<head>
    <title>Simple Arcade</title>
    <link rel="stylesheet" href="./styles/default-nav.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
</head>

<body>
    <div class="nav-header">
        <h1><span class="blinking">Simple Arcade</span></h1>
    </div>
    <div class="nav-wrapper">
        <ul>
            <li><a href="#">Login</a></li>
            <li><a href="#">Logout</a></li>
            <li><a href="#">Register</a></li>
            <li><a href="#">Logout</a></li>
        </ul>
    </div>
</body>

</html>