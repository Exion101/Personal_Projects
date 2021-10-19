function validate(form){
    let isValid = true;
    let emailPattern = /^[a-z]{2,4}[0-9]{0,3}@[a-z]+\.[a-z]{2,4}$/i;
    let emailRegex = new RegExp(emailPattern);
    let emailInput =    form.email.value.trim();
    console.log(emailInput, "is valid ", emailRegex.test(emailInput));
    if(emailRegex.test(emailInput)){
        document.getElementById("vEmail").innerText = "";
    }
    else{
        document.getElementById("vEmail").innerText = "Invalid email address";
        isValid = false;
    }
    let usernamePattern = /^[a-z]{4,20}$/i;
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
        document.getElementById("vPassword").innerText = "Password is too short, must be 6+ characters";
        isValid = false;
    }
    else{
        document.getElementById("vPassword").innerText = "";
    }
    return isValid;//<--false prevents the form from submitting
}

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
        xmlhttp.open("GET", "./ajax/checkEmail.php?q=" + str, true);
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
        xmlhttp.open("GET", "./ajax/checkUsername.php?q=" + str, true);
        xmlhttp.send();
    }
}

function radio_hide(val){
    var choiceArray = Array.from(document.getElementsByClassName('radio-choice'));

    choiceArray.forEach(ele =>{
        if(ele.id === val){
            ele.style.display="block";
        }else{
            ele.style.display="none";
        }
    })
}

function validate_email(form){
    let isValid = true;
    //document.forms[0];var patt = new RegExp("e");
    let emailPattern = /^[a-z]{2,4}[0-9]{0,3}@[a-z]+\.[a-z]{2,4}$/i;
    let emailRegex = new RegExp(emailPattern);
    let emailInput =    form.email.value.trim();
    console.log(emailInput, "is valid ", emailRegex.test(emailInput));
    if(emailRegex.test(emailInput)){
        document.getElementById("vEmail").innerText = "";
    }
    else{
        document.getElementById("vEmail").innerText = "Invalid email address";
        isValid = false;
    }
    return isValid;
}

function validate_user(form){
    let usernamePattern = /^[a-z]{4,20}$/i;
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
    return isValid;
}

function validate_pass(form){
    let password = form.password.value.trim();
    let confirm = form.confirm.value.trim();
    if(password == confirm){
        console.log("New Pass cannot be old Password");
        document.getElementById("vConfirm").innerText = "Passwords entered are the same";
        isValid = false;
    }
    else{
        document.getElementById("vConfirm").innerText = "";
    }
    if(password.length < 6){
        console.log("Password is too short, must be 6+");
        document.getElementById("vPassword").innerText = "Password is too short, must be 6+ characters";
        isValid = false;
    }
    else{
        document.getElementById("vPassword").innerText = "";
    }
    return isValid;
}