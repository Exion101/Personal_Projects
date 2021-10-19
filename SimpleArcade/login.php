<?php
require("header.php");
require(__DIR__ . "/lib/connect.php");

$verify_msg = NULL;

if (isset($_REQUEST["email"])) {
    // $email can recieve either username or email
    $email = $_REQUEST["email"];
    $password = $_REQUEST["password"];
    if (is_empty_or_null($email) || is_empty_or_null("password")) {
        echo "Something is missing here...";
        exit();
    }

    $sql = "SELECT id, email, username, role, password from users where email='$email' OR username='$email' LIMIT 1";
    $retVal = mysqli_query($conn, $sql);


    if ($retVal) {
        $result = mysqli_fetch_array($retVal, MYSQLI_ASSOC);
        if ($result) {
            if (password_verify($password, $result["password"])) {
                unset($result["password"]);
                $_SESSION["user"] = $result;

                $verify_msg = "Welcome to the Club";

                echo '<div class="msg-container"><div class="msg-content">' . $verify_msg . '</div></div>';
                die(header("Refresh:2; url=profile.php"));
            } else {
                $verify_msg = "Incorrect Password";

                echo '<div class="msg-container"><div class="msg-content">' . $verify_msg . '</div></div>';
                header("Refresh:2; url=login.php");
                exit();
            }
        } else {
            $verify_msg = "Account does not Exist";

            echo '<div class="msg-container"><div class="msg-content">' . $verify_msg . '</div></div>';
            header("Refresh:2; url=login.php");
            exit();
        }
    } else {
        $verify_msg = "Something is wrong here";

        echo '<div class="msg-container"><div class="msg-content">' . $verify_msg . '</div></div>';
        header("Refresh:2; url=login.php");
        exit();
    }
    mysqli_close($conn);
}
?>
<!-- TODO: add error message variable for friendly error messages -->
<html>

<body>
    <div class="form-container">
        <form method="POST">
            <h1>Login</h1>
            <input type="text" name="email" placeholder="Username or Email" required /><br>
            <input type="password" name="password" placeholder="Password" required /><br>
            <input type="submit" value="Submit" />
        </form>
    </div>
</body>

</html>