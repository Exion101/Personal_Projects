<?php
require("header.php");
require(__DIR__ . "/lib/connect.php");

if (isset($_REQUEST["email"])) {
    // $email can recieve either username or email
    $email = $_REQUEST["email"];
    $password = $_REQUEST["password"];
    if (is_empty_or_null($email) || is_empty_or_null("password")) {
        echo "Something is missing here...";
        exit();
    }

    $sql = "SELECT id, email, username, password from users where email='$email' OR username='$email' LIMIT 1";
    $retVal = mysqli_query($conn, $sql);


    if ($retVal) {
        $result = mysqli_fetch_array($retVal, MYSQLI_ASSOC);
        if ($result) {
            if (password_verify($password, $result["password"])) {
                unset($result["password"]);
                $_SESSION["user"] = $result;
                echo '<span class="form-container" style="color:white"><span class="form-wrapper"><h1 style="padding-top:120px;">Welcome to the Club!</h1></span></span>';
                die(header("Refresh:2; url=profile.php"));
            } else {
                header("Refresh:2; url=login.php");
                echo '<span class="form-container" style="color:white"><span class="form-wrapper"><h1 style="padding-top:120px;">Incorrect Password.</h1></span></span>';
                exit();
            }
        } else {
            header("Refresh:2; url=login.php");
            echo '<span class="form-container" style="color:white"><span class="form-wrapper"><h1 style="padding-top:120px;">Account Does Not Exist.</h1></span></span>';
            exit();
        }
    } else {
        header("Refresh:2; url=login.php");
        echo '<span class="form-container" style="color:white"><span class="form-wrapper"><h1 style="padding-top:120px;">Something didn\'t work out' . mysqli_error($conn) . ',/h1></span></span>';
        exit();
    }
    mysqli_close($conn);
}
?>

<html>

<head>
    <title>Simple Arcade - Login</title>
</head>

<body>
    <div class="form-container">
        <div class="form-wrapper">
            <form method="POST">
                <h1>Login</h1>
                <input type="text" name="email" placeholder="Username or Email" required />
                <input type="password" name="password" placeholder="Password" required />
                <input type="submit" value="Submit" />
                <span id="error_message"></span>
            </form>
        </div>
    </div>

</body>

</html>