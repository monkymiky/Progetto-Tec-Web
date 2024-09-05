var email_regex = /^([a-zA-Z0-9_.-])+@(([a-zA-Z0-9-]{2,})+.)+([a-zA-Z0-9]{2,})+$/;
var nome_regex = /^[a-zA-Z0-9\s]+$/;
var regex = /^[a-zA-Z0-9\s.,?!@#&$%*()+-]+$/;

// Riferimenti ai campi del form
var elNome = document.getElementById('name');
var elEmail = document.getElementById('email');
var elOggetto = document.getElementById('subject');
var elScriviQui = document.getElementById('emailContent');
var form = document.getElementById('contactForm');

// Funzioni di validazione dei campi
function checkNome() {
    var tmp1 = document.getElementById('errContattiNome');
    var tmp2 = document.getElementById('noErrContattiNome');
    if (elNome.value === undefined || elNome.value === "" || !nome_regex.test(elNome.value)) {
        tmp1.style.display = 'inline';
        tmp2.style.display = 'none';
        return false;
    } else {
        tmp1.style.display = 'none';
        tmp2.style.display = 'inline';
        return true;
    }
}

function checkEmail() {
    var tmp1 = document.getElementById('errContattiEmail');
    var tmp2 = document.getElementById('noErrContattiEmail');
    if (elEmail.value === "" || elEmail === undefined || !email_regex.test(elEmail.value)) {
        tmp1.style.display = 'inline';
        tmp2.style.display = 'none';
        return false;
    } else {
        tmp1.style.display = 'none';
        tmp2.style.display = 'inline';
        return true;
    }
}

function checkOggetto() {
    var tmp1 = document.getElementById('errContattiOggetto');
    var tmp2 = document.getElementById('noErrContattiOggetto');
    if (elOggetto.value === "" || elOggetto.value === undefined || !nome_regex.test(elOggetto.value)) {
        tmp1.style.display = 'inline';
        tmp2.style.display = 'none';
        return false;
    } else {
        tmp1.style.display = 'none';
        tmp2.style.display = 'inline';
        return true;
    }
}

function checkScriviQui() {
    var tmp1 = document.getElementById('errContattiScriviQui');
    var tmp2 = document.getElementById('noErrContattiScriviQui');
    if (elScriviQui.value === "" || elScriviQui.value === undefined || !regex.test(elScriviQui.value)) {
        tmp1.style.display = 'inline';
        tmp2.style.display = 'none';
        return false;
    } else {
        tmp1.style.display = 'none';
        tmp2.style.display = 'inline';
        return true;
    }
}

// Funzione che controlla tutti i campi
function checkGenerale() {
    var A = checkNome();
    var B = checkEmail();
    var C = checkOggetto();
    var D = checkScriviQui();
    return A && B && C && D;
}

// Aggiunta degli eventi sui campi
elNome.addEventListener('blur', checkNome, false);
elEmail.addEventListener('blur', checkEmail, false);
elOggetto.addEventListener('blur', checkOggetto, false);
elScriviQui.addEventListener('blur', checkScriviQui, false);

// Gestione dell'invio del form
form.addEventListener('submit', function(e) {
    e.preventDefault();  // Prevenire l'invio del form

    if (checkGenerale()) {
        // Se tutti i controlli sono corretti, mostra il popup di successo
        alert("Invio avvenuto correttamente. Risponderemo il prima possibile.");
    } else {
        // Se ci sono errori nei campi, mostra il popup di errore
        alert("Errore: dati insufficienti. Controlla i campi e riprova.");
    }
});
