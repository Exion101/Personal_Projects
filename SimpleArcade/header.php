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
</head>

<body>
    <div>
        <ul>
            <li><a href="#">Login</a></li>
            <li><a href="#">Logout</a></li>
            <li><a href="#">Register</a></li>
            <li><a href="#">Logout</a></li>
        </ul>
    </div>
</body>

</html>