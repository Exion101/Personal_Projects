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
