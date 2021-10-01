<?php
require("./header.php");
require(__DIR__ . "/../SimpleArcade/lib/connect.php");
if (isset($_REQUEST['email'])) {
    $email = $_REQUEST['email'];
    $username = $_REQUEST['username'];
    $password = $_REQUEST['password'];
    $confirm = $_REQUEST['confirm'];

    if (is_empty_or_null($email) || is_empty_or_null($username) || is_empty_or_null($password) || is_empty_or_null($confirm)) {
        echo "Something is missing....";
        exit();
    }

    $email = trim($email);
    $username = trim($username);
    $password = trim($password);
    $confirm = trim($confirm);

    if ($password !== $confirm) {
        echo "Passwords don't match....";
        exit();
    }
    //TODO: add regex for emails to match school emails
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email....";
        exit();
    }
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    if (strlen($username) < 4) {
        echo "Username name must be 4 or more characters";
        exit();
    }

    $count = preg_match('/^[a-z]{4,20}$/i', $username, $matches);
    if ($count === 0) {
        echo "Username must be between 4 and 20 characters and only contain alphabetical characters.";
        exit();
    }
    $username = filter_var($username, FILTER_SANITIZE_STRING);
    if (strlen($password) < 6) {
        echo "Password must be 6 or more characters";
        exit();
    }

    $email = mysqli_real_escape_string($conn, $email);
    $hash = password_hash($password, PASSWORD_BCRYPT);
    $password = mysqli_real_escape_string($conn, $password);

    $sql = "INSERT INTO users (email, username, password, rawPassword) VALUES ('$email', '$username', '$hash','$password')";
    $retVal = mysqli_query($conn, $sql);
    if ($retVal) {
        echo '<span style="color:green;">Welcome to The Club</span>';
    } else {
        echo '<span style="color:red;">Something did not work out:  ' . mysqli_error($conn);
    }
    mysqli_close($conn);
}
?>
<html>

<head>
    <title>Register Account</title>
    <script type="text/javascript" src="./js/functions.js"></script>
</head>

<body>
    <div>
        <form method="POST" onsubmit="return validate(this);">
            <table>
                <tr>
                    <th>Register Account</th>
                </tr>
                <tr>
                    <td>
                        <label>Email</label>
                    </td>
                    <td>
                        <input type="text" name="email" onkeyup="checkEmail(this.value)" required />
                        <span id="vEmail"></span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Username</label>
                    </td>
                    <td>
                        <input type="text" name="username" onkeyup="checkUsername(this.value)" required />
                        <span id="vUsername"></span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Password</label>
                    </td>
                    <td>
                        <input type="password" name="password" required />
                        <span id="vPassword"></span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Confirm Password</label>
                    </td>
                    <td>
                        <input type="password" name="confirm" required />
                        <span id="vConfirm"></span>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" value="Register" /></td>
                </tr>
            </table>
        </form>
    </div>
</body>

</html>