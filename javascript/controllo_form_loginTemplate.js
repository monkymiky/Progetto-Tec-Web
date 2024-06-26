
//controllo solo che sia stato inserito un testo sia per l'username
//che per la password

//per la relazione, gli script sono aggiunti, a meno di impedimenti, alla fine del body 
//in modo che la pagina si possa caricare e solo poi il codice javascript caricato,
//aumentando le prestazioni in teoria 


var elUsername = document.getElementById('user');
var elPassword = document.getElementById('password');
var loginForm = document.getElementById('login_form');

var errUsername = document.getElementById('errLoginUsername');
var errPassword = document.getElementById('errLoginPassword');

function checkUsername() {
    if(elUsername.value=="" || elUsername.value==undefined) {
        errUsername.style.display='inline';
        return false;
    }
    else {
        errUsername.style.display='none';
        return true;
    }
};

function checkPassword() {
    if(elPassword.value=="" || elPassword.value==undefined) {
        errPassword.style.display='inline';
        return false;
    }
    else {
        errPassword.style.display = 'none';
        return true;
    }
}

function checkGenerale() {
    var A = checkUsername();
    var B = checkPassword();
    if(A && B) {
        return true;
    }
    else {
        return false;
    }
}


elUsername.addEventListener('blur', checkUsername, false);
elPassword.addEventListener('blur', checkPassword, false);
/*
loginForm.addEventListener('submit', function(event) {
    
    event.preventDefault();
    if (checkGenerale()) {
        HTMLFormElement.prototype.submit.call(loginForm);
    }
    else {
        alert("Controlla i campi");
        elUsername.focus();
    }
    
}, false);
*/


