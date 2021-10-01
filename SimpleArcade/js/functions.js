function validate(form){
    let isValid = true;

    /**
     * Email Validation
     */
    let emailPattern = /^[a-z]{2,4}[0-9]{0,3}@[a-z]+\.[a-z]{2,4}$/i;
    let emailRegex = new RegExp(emailPattern);
    let emailInput = form.email.value.trim();

    console.log(emailInput, " is valid ", emailRegex.test(emailInput));

    if(emailRegex.test(emailInput)){
        document.getElementById("vEmail").innerText = "";
    }
    else{
        document.getElementById("vEmail").innerText = "Invalid Email Address";
        isValid = false;
    }
    /**
     * Username Validation
     */
    let usernamePattern =  /^[a-z]{4,20}$/i;
    let usernameRegex = new RegExp(usernamePattern);
    let usernameInput = form.username.value.trim();

    console.log(usernameInput, " is valid ", usernameRegex.test(usernameInput));

    if(usernameRegex.test(usernameInput)){
        document.getElementById("vUsername").innerText = "";
    }
    else{
        document.getElementById("vUsername").innerText = "Invalid Username: must only contain letters and be between 4-20 characters.";
        isValid = false;
    }

    /**
     * Password Validation
     */
    let password = form.password.value.trim();
    let confirm_password = form.confirm.value.trim();
    
    if(password.length <  6){
        console.log("Password is too short, must be 6+ characters");
        document.getElementsById("vPassword").innerText = "Password is too short, must be 6+ characters";
        isValid = false;
    }
    else{
        document.getElementsById("vPassword").innerText = "";
    }
    if(password !== confirm_password){
        console.log("Passwords don't match!");
        document.getElementById("vConfirm").innerText="Passwords don't match!";
        isValid = false;
    }
    else{
        document.getElementsById("vConfirm").innerText="Passwords don't match!";
    }
    // FIXME: find out how to keep innertext messages onscreen and prevent submission from happening
    return isValid;
}

//TODO: fix file paths 
function checkEmail(str) {
    if (str.length == 0) {
        document.getElementById("vEmail").innerHTML = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("vEmail").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET", "/ajax/checkEmail.php?q=" + str, true);
        xmlhttp.send();
    }
}

function checkUsername(str) {
    if (str.length == 0) {
        document.getElementById("vUsername").innerHTML = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("vUsername").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET", "/ajax/checkUsername.php?q=" + str, true);
        xmlhttp.send();
    }
}

