<?php
session_set_cookie_params([
    'lifetime' => 60 * 60,
    'path' => 'Projects/SimpleArcade',
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
            <?php if (!is_logged_in()) : ?>
                <li><a href="login.php">Login</a></li>
                <li><a href="register.php">Register</a></li>
            <?php endif; ?>
            <?php if (is_logged_in()) : ?>
                <li><a href="#">Profile</a></li>
                <li><a href="logout.php">Logout</a></li>
            <?php endif; ?>
        </ul>
    </div>
</body>

</html>