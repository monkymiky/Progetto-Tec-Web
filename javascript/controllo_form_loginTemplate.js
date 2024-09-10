var elUsername = document.getElementById("user");
var elPassword = document.getElementById("password");
var loginForm = document.getElementById("login_form");

var errUsername = document.getElementById("errLoginUsername");
var errPassword = document.getElementById("errLoginPassword");

function checkUsername() {
  if (elUsername.value == "" || elUsername.value == undefined) {
    errUsername.style.display = "inline";
    return false;
  } else {
    errUsername.style.display = "none";
    return true;
  }
}

function checkPassword() {
  if (elPassword.value == "" || elPassword.value == undefined) {
    errPassword.style.display = "inline";
    return false;
  } else {
    errPassword.style.display = "none";
    return true;
  }
}

function checkGenerale() {
  var A = checkUsername();
  var B = checkPassword();
  if (A && B) {
    return true;
  } else {
    return false;
  }
}

elUsername.addEventListener("blur", checkUsername, false);
elPassword.addEventListener("blur", checkPassword, false);
