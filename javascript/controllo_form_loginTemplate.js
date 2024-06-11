
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



/*
problema con il submit

Il problema risiede nell'elemento <input> del tipo "submit" nel tuo modulo di 
accesso, che ha sia un id che un name entrambi impostati su "submit". 
Questo causa un conflitto con il metodo submit() dell'oggetto del modulo.

Puoi risolvere questo problema semplicemente rinominando l'id o 
il nome dell'elemento <input> in modo che non entrino in conflitto con 
la funzione submit() del modulo. Ad esempio:

<input type="submit" id="submitBtn" name="submitBtn" value="Login"/>

Con questa modifica, l'elemento <input> non interferirà più con il metodo submit() 
del modulo, consentendoti di utilizzare loginForm.submit() senza generare un errore.
Assicurati di aggiornare anche le referenze nell'HTML e nel JavaScript se rinomini 
l'ID o il nome dell'elemento. */