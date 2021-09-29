<?php
// when nav is created -> remove myfunctions
require(__DIR__ . "/../SimpleArcade/lib/myFunctions.php");

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

    // TODO: Prepare input variables for database queries
}
?>
<html>

<head>
    <title>Register Account</title>
    <script type="text/javascript" src="./js/functions.js"></script>
</head>

<body>
    <div>
        <form method="POST" onsubmit="validate(this);">
            <table>
                <tr>
                    <th>Register Account</th>
                </tr>
                <tr>
                    <td>
                        <label>Email</label>
                    </td>
                    <td>
                        <input type="text" name="email" required />
                        <span id="vEmail"></span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Username</label>
                    </td>
                    <td>
                        <input type="text" name="username" required />
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