//variabili di controllo 
var email_regex = /^([a-zA-Z0-9_.-])+@(([a-zA-Z0-9-]{2,})+.)+([a-zA-Z0-9]{2,})+$/;
var nome_regex = /^[a-zA-Z0-9\s]+$/;
var regex = /^[a-zA-Z0-9\s.,?!@#&$%*()+-]+$/;
let cell_regex = /^\d{0,15}$/;
var numero_carta_regex = /^(\d{15}|\d{16})$/;
var numero_CVV_regex = /^(\d{3})$/;


//variabili per il controllo 
var form = document.getElementById('formPrenota');

var elEmail = document.getElementById('email');
var elCell = document.getElementById('cell');
var elIndirizzo = document.getElementById('indirizzo');


var elPaypal = document.getElementById("paypal");
var elCarta = document.getElementById("creditDebit");

var elNomeCarta = document.getElementById("name_surname");
var elNumeroCarta = document.getElementById("card_number");
var elCVVCarta = document.getElementById("id_card_cvv"); 

var err;
var noerr;


function checkEmail() {
    err = document.getElementById('errPrenotazioniEmail');
    noerr = document.getElementById('noErrPrenotazioniEmail');
    if(elEmail.value=="" || elEmail.value==undefined || !email_regex.test(elEmail.value)) {
        err.style.display = 'inline';
        noerr.style.display = 'none';
        return false;
    }
    else {
        err.style.display = 'none';
        noerr.style.display = 'inline';
    }
} 
function checkCell() {
    err = document.getElementById('errPrenotazioniTelefono');
    noerr = document.getElementById('noErrPrenotazioniTelefono');
    if(elCell.value == "" || elCell.value==undefined || !cell_regex.test(elCell.value)) {
        err.style.display='inline';
        noerr.style.display='none';
        return false;
    }
    else {
        err.style.display = 'none';
        noerr.style.display = 'inline';
        return true;
    }
};
function checkIndirizzo() {
    err = document.getElementById('errPrenotazioniIndirizzo');
    noerr = document.getElementById('noErrPrenotazioniIndirizzo');
    if(elIndirizzo.value=="" || elIndirizzo.value == undefined || !regex.test(elIndirizzo.value)) {
        err.style.display = 'inline';
        noerr.style.display = 'none';
        return false;
    }
    else {
        err.style.display = 'none';
        noerr.style.display = 'inline';
        return true;
    }
};
function checkNomeCarta() {
    err = document.getElementById('errPrenotazioniNomeCarta');
    noerr = document.getElementById('noErrPrenotazioniNomeCarta');
    if(elNomeCarta=="" || elNomeCarta == undefined || !nome_regex.test(elNomeCarta.value)) {
        err.style.display = 'inline';
        noerr.style.display = 'none';
        return false;
    }
    else {
        err.style.display = 'none';
        noerr.style.display = 'inline';
        return true;
    }
}
function checkNumeroCarta() {
    err = document.getElementById("errPrenotazioniNumeroCarta");
    noerr = document.getElementById("noErrPrenotazioniNumeroCarta");
    if(elNumeroCarta.value=="" || elNumeroCarta==undefined || !numero_carta_regex.test(elNumeroCarta.value)) {
        err.style.display = 'inline';
        noerr.style.display = 'none';
        return false;
    }
    else {
        err.style.display = 'none';
        noerr.style.display = 'inline';
        return true;
    }
}
function checkCVV() {
    err = document.getElementById('errPrenotazioniCVV');
    noerr = document.getElementById('noErrPrenotazioniCVV');
    if(elCVVCarta.value=="" || elCVVCarta.value==undefined || !numero_CVV_regex.test(elCVVCarta.value)) {
        err.style.display = 'inline';
        noerr.style.display = 'none';
        return false;
    }
    else {
        err.style.display = 'none';
        noerr.style.display = 'inline';
        return true;
    }
}

function checkGenerale() {
    var A = checkEmail();
    var B = checkCell();
    var C = checkIndirizzo();
    var D = checkNomeCarta();
    var E = checkNumeroCarta();
    var F = checkCVV;
    if(A && B && C && D && E && F) {
        return true;
    }
    else {
        return false;
    }
}


function showCardData() {
    document.getElementById("cardDataFieldset").classList.toggle("hiddenObj");
    document.getElementById("submit-button").classList.toggle("hiddenObj");
}

elEmail.addEventListener('blur', checkEmail, false);
elCell.addEventListener('blur', checkCell, false);
elIndirizzo.addEventListener('blur', checkIndirizzo, false);
elNomeCarta.addEventListener('blur', checkNomeCarta, false);
elNumeroCarta.addEventListener('blur', checkNumeroCarta, false);
elCVVCarta.addEventListener('blur', checkCVV, false);

form.addEventListener('submit',function(e) {
    e.preventDefault();
    if(checkGenerale()) {
        form.submit();
    }
    else {
        alert("Controlla i campi");
        elEmail.focus();
    }
})
