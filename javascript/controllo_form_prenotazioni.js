//variabili di controllo 
var email_regex = /^([a-zA-Z0-9_.-])+@(([a-zA-Z0-9-]{2,})+.)+([a-zA-Z0-9]{2,})+$/;
var nome_regex = /^[a-zA-Z0-9\s]+$/;
var regex = /^[a-zA-Z0-9\s.,?!@#&$%*()+-]+$/;
let cell_regex = /^\d{0,15}$/;

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

 console.log("elNomeCarta = " + elNomeCarta.value);

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
    console.log("nome della carta inserito = " + elNomeCarta.value);
    err = document.getElementById('errPrenotazioniNomeCognome');
    noerr = document.getElementById('noErrPrenotazioniNomeCognome');
    if(elNomeCarta.value=="" || elNomeCarta==undefined || !nome_regex.test(elNomeCarta.value)) {
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


elEmail.addEventListener('blur', checkEmail, false);
elCell.addEventListener('blur', checkCell, false);
elIndirizzo.addEventListener('blur', checkIndirizzo, false);
elNomeCarta.addEventListener('blur', checkNomeCarta, false);
