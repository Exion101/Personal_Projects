<?php
    require(__DIR__ . "/../lib/myFunctions.php"); // TODO: create nav.php that will contain myFunction.php call
    require(__DIR__ . "/../lib/db.php");

    if(isset($_REQUEST["email"])){
        // registration data
        $email = $_REQUEST["email"];
        $username = $_REQUEST["username"];
        $password = $_REQUEST["password"];
        $confirm = $_REQUEST["confirm"];
        
        // check if values are set
        if(is_empty_or_null($email) || is_empty_or_null($username) || is_empty_or_null($password) || is_empty_or_null($confirm)){
            echo "Something is missing...";
            exit();
        }

        $email = trim($email);
        $username = trim($username);
        $password = trim($password);
        $confirm = trim($confirm);

        if($password !== $confirm){
            echo "Passwords don't match";
            exit();
        }

        // validate/sanitize email
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            echo "Invalid email!";
            exit();
        }
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);

        // Check input requirements
        if(strlen($username) < 4 || strlen($username) > 20){
            echo "Username must be beteween 4 and 20 characters.";
            exit();
        }

        $username_pattern = '/^[a-z]{4,20}$/i';
        $count = preg_match($username_pattern, $username, $matches);
        if($count === 0){
            echo "$username \n";
            echo "Username must be between 4 and 20 characters and only contain alphabetical characters.";
            exit();
        }
        $username = filter_var($username, FILTER_SANITIZE_STRING);

        if(strlen($password) < 6){
            echo "Password must be 6 or more characters";
            exit();
        }

        // Prepare input for DB insertion
        $username = mysqli_real_escape_string($db, $username);
        $email = mysqli_real_escape_string($db, $email);
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $password = mysqli_real_escape_string($db, $password);

        $register_user = "INSERT INTO users (email, username, password, rawPassword) VALUES ('$email', '$username', '$hash', '$password')";
        $return = mysqli_query($db, $register_user);
        if($return){
            echo "Account Created. Welcome to the club";
        }
        else{
            echo "Something didn't work out " . mysqli_error($db);
        }

        mysqli_close($db);
    }
?>
<!-- JS for realtime input validation -->
<!-- Form submits if input is valid -->
<script>
    function validate(form){
        let isValid = true;

        let emailPattern = /^[a-z]{2,4}[0-9]{0,3}@[a-z]+\.[a-z]{2,4}$/i;
        let emailRegex = new RegExp(emailPattern);
        let emailInput = form.email.value.trim();

        console.log(emailInput, "is valid ", emailRegex.test(emailInput));
        if(usernameRegex.test(usernameInput)){
            document.getElementById("vUsername").innerText = "Invalid Username: must only contain letters and be between 4-20 characters.";
            isValid = false;
        }

        let password = form.password.value.trim();
        let confirm = form.confirm.value.trim();

        if(password !== confirm){
            console.log("Passwords don't match!");
            document.getElementById("vConfirm").innerText = "Passwords don't match";
            isValid = false;
        }
        else{
            document.getElementById("vConfirm").innerText = "";
        }
        if(password.length < 6){
            console.log("Password is too short, must be 6+");
            document.getElementById("vPassword").innerText = "Password is too short, must be 6+";
            isValid = false;
        }
        else{
            document.getElementById("vPassword").innerText = "";
        }
        return isValid;
    }
</script>

<!-- HTML for Web Page -->
<!-- Takes submission from form and passes through JS function-->
<!DOCTYPE html>
<html lang="en-us">
<html>
    <form method="POST" onsubmit="return validate(this);"> 
        <label>Email</label>
        <input type="text" name="email" required/>
        <span id="vEmail"></span>
        <label>Username</label>
        <input type="text" name="username" required/>
        <span id="vUsername"></span>
        <label>Password</label>
        <input type="password" name="password" required/>
        <span id="vPassword"></span>
        <label>Confirm Password</label>
        <input type="password" name="confirm" required/>
        <input type="submit" value="Register"/>
    </form>
</html>
