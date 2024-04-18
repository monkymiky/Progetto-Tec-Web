


var email_regex = /^([a-zA-Z0-9_.-])+@(([a-zA-Z0-9-]{2,})+.)+([a-zA-Z0-9]{2,})+$/;
var nome_regex = /^[a-zA-Z0-9\s]+$/;
var regex = /^[a-zA-Z0-9\s.,?!@#&$%*()+-]+$/;
//form________________________________________________________
var elNome = document.getElementById('name');
var elEmail = document.getElementById('email');
var elOggetto = document.getElementById('subject');
var elScriviQui = document.getElementById('emailContent');
var submit = document.getElementById('sendButton');
var form = document.getElementById('contactForm');
//____________________________________________________________

//disabilito la possibilità di inviare cosi posso fare i controlli


/*
    Come fare a fare i controlli ? 
    creo prima di tutto delle funzioni che controllino i valori contenuti in ogni campo
    in particolare la email dovrà rispettare un certo tipo di espressione regolare 

*/
var tmp1;
var tmp2;

function checkNome(){
    tmp1 = document.getElementById('errContattiNome');
    tmp2 = document.getElementById('noErrContattiNome');
    if(elNome.value===undefined || elNome.value==="" || !nome_regex.test(elNome.value)){
        tmp1.style.display='inline';
        tmp2.style.display='none';
        return false;
    }
    else {
        tmp1.style.display='none';
        tmp2.style.display='inline';
        return true;
    }
};

function checkEmail() {
    tmp1 = document.getElementById('errContattiEmail');
    tmp2 = document.getElementById('noErrContattiEmail');
    if(elEmail.value=="" || elEmail==undefined || !email_regex.test(elEmail.value)) {
        tmp1.style.display='inline';
        tmp2.style.display='none';
        return false;
    }
    else {
        tmp1.style.display='none';
        tmp2.style.display='inline';
        return true;
    }
}

function checkOggetto() {
    tmp1 = document.getElementById('errContattiOggetto');
    tmp2 = document.getElementById('noErrContattiOggetto');
    if(elOggetto.value=="" || elOggetto.value==undefined || !nome_regex.test(elOggetto.value)) {
        tmp1.style.display = 'inline';
        tmp2.style.display = 'none';
        return false;
    }
    else {
        tmp1.style.display = 'none';
        tmp2.style.display = 'inline';
        return true;
    }
}

function checkScriviQui() {
    tmp1 = document.getElementById('errContattiScriviQui');
    tmp2 = document.getElementById('noErrContattiScriviQui');
    if(elScriviQui.value=="" || elScriviQui.value==undefined || !regex.test(elScriviQui.value)) {
        tmp1.style.display='inline';
        tmp2.style.display='none';
        return false;
    }
    else {
        tmp1.style.display = 'none';
        tmp2.style.display = 'inline';
        return true;
    }
}

function checkGenerale() {
    var A = checkNome();
    var B = checkEmail();
    var C = checkOggetto(); 
    var D = checkScriviQui();
    if(A && B && C && D) {
        return true;
    }
    else {
        return false;
    }
}



elNome.addEventListener('blur', checkNome, false);
elEmail.addEventListener('blur', checkEmail, false);
elOggetto.addEventListener('blur', checkOggetto, false);
elScriviQui.addEventListener('blur', checkScriviQui, false);


elForm.addEventListener('submit',function(e) {
    e.preventDefault();
    if(checkGenerale()) {
        elForm.submit();
    }
    else {
        alert("Controlla i campi");
        elNome.focus();
    }
})
