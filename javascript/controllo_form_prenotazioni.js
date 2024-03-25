//variabili di controllo 
var email_regex = /^([a-zA-Z0-9_.-])+@(([a-zA-Z0-9-]{2,})+.)+([a-zA-Z0-9]{2,})+$/;
var nome_regex = /^[a-zA-Z0-9\s]+$/;
var regex = /^[a-zA-Z0-9\s.,?!@#&$%*()+-]+$/;

//variabili per il controllo 
var form = document.getElementById('formPrenota');

var elEmail = document.getElementById('email');
var elCell = document.getElementById('cell');
var elIndirizzo = document.getElementById('indirizzo');




function checkEmail() {
    if(elEmail.value=="" || elEmail.value==undefined) {
        //show error message
    }
    else {
        //show confirmation message (check mark)
    }
} 
function checkCell() {};
function checkIndirizzo() {};



