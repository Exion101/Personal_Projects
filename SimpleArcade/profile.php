<?php
require("header.php");
require(__DIR__ . "/lib/connect.php");

if (!is_logged_in()) {
    echo '<span class="form-container" style="color:white"><span class="form-wrapper"><h1 style="padding-top:120px;">Something is Wrong Here.</h1></span></span>';
    die(header("Refresh:3; url=login.php"));
}
// globals of account details
$global_email = get_email();
$global_user = get_username();
$global_role = get_role();
$global_privacy = 'public';

/*
    Most errors will be caught by JS validation
    if ends up being caught by server-side, then user friendly alerts
*/
// change username
if (isset($_REQUEST["username"])) {
    $user_id = get_user_id();
    $username = $_REQUEST["username"];

    if (is_empty_or_null($username)) {
        echo '<div class="msg-container"><div class="msg-content">Username is Missing!</div></div>';
        die(header("Refresh:1; url=profile.php"));
    }
    $username = trim($username);
    if (strlen($username) < 4) {
        echo '<div class="msg-container"><div class="msg-content">Username must be 4 or more characters</div></div>';
        die(header("Refresh:1; url=profile.php"));
    }
    $count = preg_match('/^[a-z]{4,20}$/i', $username, $matches);
    if ($count === 0) {
        echo '<div class="msg-container"><div class="msg-content">Username must be between 4 and 20 characters and only contain alphabetical characters.</div></div>';
        die(header("Refresh:1; url=profile.php"));
    }
    $username = filter_var($username, FILTER_SANITIZE_STRING);

    // check if entered username is same as old
    if ($global_user === $username) {
        echo '<div class="msg-container"><div class="msg-content">New username cannot be old one.</div></div>';
        die(header("Refresh:1; url=profile.php"));
    }
    $sql = "UPDATE users SET username = '$username' WHERE id = '$user_id'";
    $retVal = mysqli_query($conn, $sql);
    if ($retVal) {
        // username update
        $global_user = $username;
    } else {
        echo '<div class="msg-container"><div class="msg-content">Unable to update username!</div></div>';
        die(header("Refresh:1; url=profile.php"));
    }
}
// change email
if (isset($_REQUEST["email"])) {
    $email = $_REQUEST["email"];
    $user_id = get_user_id();

    if (is_empty_or_null($email)) {
        echo '<div class="msg-container"><div class="msg-content">Email is missing!</div></div>';
        die(header("Refresh:1; url=profile.php"));
    }
    $email = trim($email);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo '<div class="msg-container"><div class="msg-content">Invalid email!</div></div>';
        die(header("Refresh:1; url=profile.php"));
    }
    if ($global_email === $email) {
        echo '<div class="msg-container"><div class="msg-content">New email cannot be old one!</div></div>';
        die(header("Refresh:1; url=profile.php"));
    }
    $sql = "UPDATE users SET email = '$email' WHERE id = '$user_id'";
    $retVal = mysqli_query($conn, $sql);
    if ($retVal) {
        // email update
        $global_email = $email;
    } else {
        echo '<div class="msg-container"><div class="msg-content">Unable to update email!</div></div>';
        die(header("Refresh:1; url=profile.php"));
    }
}

// change password
if (isset($_REQUEST["password"]) && isset($_REQUEST["confirm"])) {
    $user_id = get_user_id();
    $old_password = $_REQUEST["confirm"];
    $password = $_REQUEST["password"];

    // verify current password
    $sql = "SELECT password FROM users WHERE id = '$user_id'";
    $retVal = mysqli_query($conn, $sql);
    if ($retVal) {
        $retVal = mysqli_fetch_array($retVal, MYSQLI_ASSOC);
        if ($retVal) {
            if (password_verify($old_password, $retVal["password"])) {

                $hash = password_hash($password, PASSWORD_BCRYPT);
                $password = mysqli_real_escape_string($conn, $password);

                $sql = "UPDATE users SET password = '$hash', rawPassword = '$password' WHERE id = '$user_id'";
                $retVal = mysqli_query($conn, $sql);
                if ($retVal) {
                    echo "Password change Successful";
                } else {
                    echo '<div class="msg-container"><div class="msg-content">Password Change Unsuccessful!</div></div>';
                    die(header("Refresh:1; url=profile.php"));
                }
            } else {
                echo '<div class="msg-container"><div class="msg-content">Wrong Current Password!</div></div>';
                die(header("Refresh:1; url=profile.php"));
            }
        }
    }
}
?>

<html>

<body>
    <div class="profile-container">
        <div class="account-container">
            <table style="color:white">
                <th>My Profile</th>
                <tr>
                    <td>Role:</td>
                    <td><?php echo $global_role; ?></td>
                </tr>
                <tr>
                    <td>Username:</td>
                    <td><?php echo $global_user; ?></td>
                </tr>
                <tr>
                    <td>Email:</td>
                    <td><?php echo $global_email; ?></td>
                </tr>
                <tr>
                    <td>Privacy:</td>
                    <td><?php echo $global_privacy; ?></td>
                </tr>
            </table>
        </div>
        <div class="edit-container">
            <div class="edit-radio">
                <input type="radio" id="change_user" name="edit-choice" onclick="radio_hide('user')" checked>
                <label for="change_user">Change Username</label>
                <input type="radio" id="change_email" name="edit-choice" onclick="radio_hide('email')">
                <label for="change_email">Change Email</label>
                <input type="radio" id="change_pass" name="edit-choice" onclick="radio_hide('password')">
                <label for="change_pass">Change Password</label>
                <input type="radio" id="change_priv" name="edit-choice" onclick="radio_hide('privacy')">
                <label for="change_priv">Change Privacy</label>
            </div>
            <div id="user" class="radio-choice">
                <form method="POST" onsubmit="return validate_user(this);">
                    <input type="text" name="username" placeholder="New Username" onkeyup="checkUsername(this.value);" />
                    <span id="vUsername"></span>
                    <input type="submit" value="submit" />
                </form>
            </div>
            <div id="email" class="radio-choice" style="display:none">
                <form method="POST" onsubmit="return validate_email(this);">
                    <input type="text" name="email" placeholder="New Email" onkeyup="checkEmail(this.value);" />
                    <span id="vEmail"></span>
                    <input type="submit" value="submit" />
                </form>
            </div>
            <div id="password" class="radio-choice" style="display:none">
                <form method="POST" onsubmit="return validate_pass(this);">
                    <input type="password" name="confirm" placeholder="Current Password" />
                    <span id="vConfirm"></span>
                    <input type="text" name="password" placeholder="New Password" />
                    <span id="vPassword"></span>
                    <input type="submit" value="submit" />
                </form>
            </div>
            <div id="privacy" class="radio-choice" style="display:none">
                hello
            </div>
        </div>
    </div>

</body>

</html>