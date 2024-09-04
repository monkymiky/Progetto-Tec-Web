var email_regex =
  /^([a-zA-Z0-9_.-])+@(([a-zA-Z0-9-]{2,})+.)+([a-zA-Z0-9]{2,})+$/;
var numero_regex = /^(?:[0-9] ?){6,14}[0-9]$/;

var elNomeCognome = document.getElementById("nome");
var elEmail = document.getElementById("email");
var elTelefono = document.getElementById("cell");
var elIndirizzo = document.getElementById("indirizzo");

var errNomeCognome = document.getElementById("errNomeCognome");
var errEmail = document.getElementById("errEmail");
var errTelefono = document.getElementById("errTelefono");
var errIndirizzo = document.getElementById("errIndirizzo");

var errMessage = document.getElementById("errContattiAdmin");

var elForm = document.getElementById("formPrenota");

function checkNomeCognome() {
  if (elNomeCognome.value == undefined || elNomeCognome.value == "") {
    errMessage.style.display = "inline";
    errNomeCognome.style.display = "inline";
    return false;
  } else {
    errMessage.style.display = "none";
    errNomeCognome.style.display = "none";
    return true;
  }
}
function checkEmail() {
  if (
    elEmail.value == undefined ||
    elEmail.value == "" ||
    !email_regex.test(elEmail.value)
  ) {
    errMessage.style.display = "inline";
    errEmail.style.display = "inline";
    return false;
  } else {
    errMessage.style.display = "none";
    errEmail.style.display = "none";
    return true;
  }
}
function checkNumeroTelefono() {
  if (
    !numero_regex.test(elTelefono.value) ||
    elTelefono.value == undefined ||
    elTelefono.value == ""
  ) {
    errMessage.style.display = "inline";
    errTelefono.style.display = "inline";
    return false;
  } else {
    errMessage.style.display = "none";
    errTelefono.style.display = "none";
    return true;
  }
}
function checkIndirizzo() {
  if (elIndirizzo.value == undefined || elIndirizzo.value == "") {
    errMessage.style.display = "inline";
    errIndirizzo.style.display = "inline";
    return false;
  } else {
    errMessage.style.display = "none";
    errIndirizzo.style.display = "none";
    return true;
  }
}
/*
function checkGenerale() {
    if(checkNomeCognome() && checkEmail() && checkIndirizzo() && checkNumeroTelefono()) {
        return true;
    }
    else {
        return false;
    }
}
*/
elNomeCognome.addEventListener("blur", checkNomeCognome, false);
elEmail.addEventListener("blur", checkEmail, false);
elTelefono.addEventListener("blur", checkNumeroTelefono, false);
elIndirizzo.addEventListener("blur", checkIndirizzo, false);
/*
elForm.addEventListener('submit', function(e) {
    e.preventDefault();
    
    if(checkGenerale()) {
        elForm.submit();
    }
    else {
        alert("controlla i campi");
        elNomeCognome.focus();
        
    }
},false)
*/
