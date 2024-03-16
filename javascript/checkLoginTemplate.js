

var elUserName = document.getElementById('user');
var elPassword = document.getElementById('password');
var elSubmit = document.getElementById('submit');
var elLoginForm = document.getElementById('login_form');
var elLoginError = document.getElementById('login_error');

function checkUserName() {
    if (elUserName.value.trim() === '') {
        elLoginError.style.display = 'inline';
    }
};
function checkPassWord() {
    if (elPassword.value.trim() === '') {
        elLoginError.style.display = 'inline';
    }
};


elLoginForm.addEventListener('submit', function(event) {
    console.log("inizio controllo");
    // Impedisce il comportamento predefinito del modulo di invio o almeno dovrebbe
    event.preventDefault();
    
    // Effettua i controlli sugli input
    checkUserName();
    checkPassWord();

    console.log("/nfine controllo");
}, false);

