<?php
    // cookies will follow where nav.php is called
    session_set_cookie_params([
        'lifetime' => 60*60,
        'path' => '/',
        'domain' => $_SERVER['HTTP_HOST'],
        'secure' => true,   // recieve cookies only through https
        'httponly' => true, // prevents javascript access to cookie
        'samesite' => 'lax'
    ]);
    session_start();

    $sidvalue = session_id();
    // echo var_export(session_get_cookie_params(), true);
    // echo "Your session id: " . $sidvalue . "<br>";
    require(__DIR__ . "/../lib/myFunctions.php");
?>

<!-- TO DO: add css style here -->

<!DOCTYPE html>
<html lang="en-us">
<html>
    <ul class="nav">
    <?php if(!is_logged_in()):?>
    <li><a href="authenticate.php">Login</a></li>
    <li><a href="register.php">Register</a></li>
    <?php endif;?>
    <?php if(is_logged_in()):?>
    <li><a href="home.php">Home</a></li>
    <li><a href="logout.php">Logout</a></li>
    <?php endif;?>
    </ul>
</html>
