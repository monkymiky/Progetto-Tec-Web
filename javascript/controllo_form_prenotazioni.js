/*
    Questo codice si occupa del controllo della correttezza del form delle prenotazioni. In poche parole controlla che gli input inseriti dall'utente siano corretti e nel caso
    non lo siano blocca il submit di tale form e segnala un messaggio di errore a fianco dell'input non corretto. 


    */

//variaibili di controllo / espressioni regolari 
var controllo_email_regex = /^([a-zA-Z0-9_.-])+@(([a-zA-Z0-9-]{2,})+.)+([a-zA-Z0-9]{2,})+$/;
var controllo_nome_e_cognome_regex = /^[a-zA-Z]+ [a-zA-Z]+$/;
var controllo_numero_carta = /^(\d{4} ){3}\d{4}$/;
var controllo_cvv_regex = /^\d{3}$/;
var controllo_telefono = /^\d{1,11}$/;

//funzioni utili per fare controlli, ritornano rispettivamente l'anno, il mese e il giorno corrente al momento dell'esecuzione della funzione 

function anno_corrente() {
    var data = new Date();
    var anno = data.getFullYear();
    return anno;
}
function mese_corrente() {
    var data = new Date(); 
    var mese = data.getMonth();
    return mese+1
}
function giorno_corrente() {
    var data = new Date();
    var giorno = data.getDay();
    return giorno;
}



//controllo email
function controllo_email() { 
    console.log("controllo_email");
    var email       = document.getElementById("email");
    var valoreEmail = email.value;
    //verifica la presenza di errori
    var existing_err_elem = email.parentNode.querySelector(".err_elem");

    if(valoreEmail==="" || valoreEmail===undefined || !controllo_email_regex.test(valoreEmail)) {
        var err_elem = document.createElement("span");
        err_elem.classList.add("err_elem");
        err_elem.textContent="Inserisci un indirizzo email valido";
        err_elem.style.color="red";
        err_elem.style.fontSize="0.7em";
        email.insertAdjacentElement('beforebegin', err_elem);
        return false;
    }
    else {
        // Rimuovi l'errore se esiste
        if(existing_err_elem) {
            existing_err_elem.remove();
            return true;
        }
    }
};

//controllo numero di telefono
function controllo_numero_telefono() {

    console.log("controllo_telefono");
    var numero_di_telefono      = document.getElementById("cell");
    var valoreNumeroDiTelefono = numero_di_telefono.value;

    var existing_err_elem = numero_di_telefono.parentNode.querySelector(".err_elem");

    if(valoreNumeroDiTelefono==="" || valoreNumeroDiTelefono===undefined || !controllo_telefono.test(valoreNumeroDiTelefono)) {
        var err_elem = document.createElement("span");
        err_elem.classList.add("err_elem"); 
        err_elem.textContent = "Inserire un numero valido";
        err_elem.style.color = "red";
        err_elem.style.fontSize = "0.7em";
        numero_di_telefono.insertAdjacentElement('beforebegin', err_elem);
        return false;
    }
    else {
        if(existing_err_elem){
            existing_err_elem.remove();
            return true;
        }
    }
    
};

//controllo indirizzo
function controllo_indirizzo() {
    console.log("controllo indirizzo");
    var indirizzo       = document.getElementById("indirizzo");
    var valoreIndirizzo = indirizzo.value;

    var existing_err_elem=indirizzo.parentNode.querySelector(".err_elem");

    if(valoreIndirizzo==="" || valoreIndirizzo===undefined) {
        var err_elem = document.createElement("span");
        err_elem.classList.add("err_elem");
        err_elem.textContent="Inserisci un indirizzo";
        err_elem.style.color="red";
        err_elem.style.fontSize="0.7em";
        indirizzo.insertAdjacentElement('beforebegin', err_elem);
        return false;
    }
    else {
        if(existing_err_elem) {
            existing_err_elem.remove();
            return true;
        }
    }

};

//controllo note non necessario (non per i nostri scopi)

//controllo dati carta 
function controllo_nome_e_cognome() {
    console.log("controllo nome e cognome");
    var nome_e_cognome     = document.getElementById("name_surname");
    var valoreNomeECognome = nome_e_cognome.value;
    
    var existing_err_elem = nome_e_cognome.parentNode.querySelector(".err_elem");

    if(valoreNomeECognome==="" || valoreNomeECognome===undefined || !controllo_nome_e_cognome_regex.test(valoreNomeECognome)){
        var err_elem = document.createElement("span");
        err_elem.classList.add("err_elem");
        err_elem.textContent="Inserisci il nome e il cognome";
        err_elem.style.color="red";
        err_elem.style.fontSize="0.7em";
        nome_e_cognome.insertAdjacentElement('beforebegin', err_elem);
        return false;
    }
    else {
        if(existing_err_elem) {
            existing_err_elem.remove();
            return true;
        }
    }

};

//controllo numero della carta  
function controllo_numero_carta() {
    console.log("controllo numero carta");

    var numero_della_carta      = document.getElementById("card_number");
    var valoreNumeroDellaCarta = numero_della_carta.value;
    
    var existing_err_elem = numero_della_carta.parentNode.querySelector(".err_elem");

    if (valoreNumeroDellaCarta==="" || valoreNumeroDellaCarta===undefined || !controllo_numero_carta.test(valoreNumeroDellaCarta)) {
        var err_elem = document.createElement("span");
        err_elem.classList.add("err_elem");
        err_elem.textContent="Inserisci il numero della carta in questo formato: xxxx xxxx xxxx xxxx";
        err_elem.style.color="red";
        err_elem.style.fontSize="0.7em";
        numero_della_carta.insertAdjacentElement('beforebegin', err_elem);
        return false;
    }
    else {
        if(existing_err_elem) {
            existing_err_elem.remove();
            return true;
        }
    }

};

//controllo cvv
function controllo_cvv() {
    console.log("controllo cvv");
    var cvv       = document.getElementById("id_card_cvv");
    var valoreCVV = cvv.value;
    
    var existing_err_elem = cvv.parentNode.querySelector(".err_elem");

    if(valoreCVV === "" || valoreCVV===undefined || !controllo_cvv_regex.test(valoreCVV)) {
        var err_elem = document.createElement("span");
        err_elem.classList.add("err_elem");
        err_elem.textContent="Inserisci le 3 cifre del cvv";
        err_elem.style.color="red";
        err_elem.style.fontSize="0.7em";
        cvv.insertAdjacentElement('beforebegin', err_elem);
        return false;
    }
    else {
        if(existing_err_elem){
            existing_err_elem.remove();
            return true;
        }
    }
};

function controllo_scadenza_carta() {
    console.log("controllo scadenza carta");
    var mese_scadenza_carta     = document.getElementById("month");
    var anno_scadenza_carta     = document.getElementById("year");

    var valoreMeseScadenzaCarta = mese_scadenza_carta.value;
    var valoreAnnoScadenzaCarta = anno_scadenza_carta.value;

    var existing_err_elem = mese_scadenza_carta.parentNode.querySelector(".err_elem");

    if((anno_corrente() > valoreAnnoScadenzaCarta) || (anno_corrente() === valoreAnnoScadenzaCarta && mese_corrente()>valoreMeseScadenzaCarta)) {
        //nope
        var err_elem = document.createElement("span");
        err_elem.classList.add("err_elem");
        err_elem.textContent="Inserisci una data corretta";
        err_elem.style.color="red";
        err_elem.style.fontSize="0.7em";
        mese_scadenza_carta.insertAdjacentElement('beforebegin', err_elem);
        return false;
    }
    else {
        //ok
        if(existing_err_elem){
            existing_err_elem.remove();
        }
        return true;

    }

};

function controllo_metodo_di_pagamento() {

    console.log("controllo metodo di pagamento");
    var metodo_paypal      = document.getElementById("paypal");
    var metodo_carta       = document.getElementById("credit_debit");

    //var valoreMetodoPaypal = metodo_paypal.checked;
    //var valoreMetodoCarta  = metodo_carta.checked;

    var existing_err_elem  = metodo_paypal.parentNode.querySelector(".err_elem");

    if(!metodo_carta.checked && !metodo_paypal.checked) {
        var err_elem = document.createElement("span");
        err_elem.classList.add("err_elem");
        err_elem.textContent="Scegli un metodo di pagamento";
        err_elem.style.color="red";
        err_elem.style.fontSize="0.7em";
        metodo_paypal.insertAdjacentElement('beforebegin', err_elem);
        return  false;
    }
    else {
        if(existing_err_elem) {
            existing_err_elem.remove();
            return true;
        }
    }
}

function controllo_luogo_selezionato() {
    console.log("controllo luogo selezionato");
    var domicilio               = document.getElementById("domicilio");
    var studio                  = document.getElementById("studio");

    //var valoreDomicilio = domicilio.value;
    //var valoreStudio = studio.value;

    var existing_err_elem = domicilio.parentNode.querySelector(".err_elem");

    if(!domicilio.checked && !studio.checked) {
        var err_elem = document.createElement("span");
        err_elem.classList.add("err_elem");
        err_elem.textContent="Scegli un luogo per la prestazione";
        err_elem.style.color="red";
        err_elem.style.fontSize="0.7em";
        domicilio.insertAdjacentElement('beforebegin', err_elem);
        return false;
    }
    else {
        if(existing_err_elem) {
            existing_err_elem.remove();
            return true;
        }
    }
}

function controllo_giorno() {
    console.log("controllo giorno");
    var date=document.getElementById("date"); 
    //var time=document.getElementById("time");

    var valoreDate = date.value;
    var dataInserita = new Date(valoreDate);
    var giornoInserito = dataInserita.getDay();
    var meseInserito = dataInserita.getMonth();
    var annoInserito = dataInserita.getFullYear(); 
        
    var existing_err_elem = date.parentNode.querySelector(".err_elem");
    //ora, grazie alle funzioni sopra posso confrontare i valori dei tre campi sopra e assicurarmi che non siano nel passato. Per esempio annoInserito > (annoCorrente-1). La logica in questo if è invertita rispetto agli altri 
    if( annoInserito>=anno_corrente()   &&  meseInserito>=mese_corrente()   &&  giornoInserito>=giorno_corrente()) {
        if(existing_err_elem){
            existing_err_elem.remove();
        }
        return true;
    }    
    else {
        var err_elem = document.createElement("span");
        err_elem.classList.add("err_elem");
        err_elem.textContent="Inserisci una data che non sia già passata";
        err_elem.style.color="red";
        err_elem.style.fontSize="0.7em";
        date.insertAdjacentElement('beforebegin', err_elem);
    }
}

function controllo_campi() {
    console.log("controllo campi");

    var risultato = true;

    risultato = risultato && controllo_giorno();
    risultato = risultato && controllo_email();
    risultato = risultato && controllo_numero_telefono();
    risultato = risultato && controllo_indirizzo();
    risultato = risultato && controllo_metodo_di_pagamento();
    risultato = risultato && controllo_nome_e_cognome();
    risultato = risultato && controllo_numero_carta();
    risultato = risultato && controllo_cvv();
    risultato = risultato && controllo_scadenza_carta();
    risultato = risultato && controllo_luogo_selezionato();

    return risultato;
}


var form_pointer = document.getElementById("formPrenota"); 
form_pointer.addEventListener('submit', function(event){
   console.log("si è verificato un submit");
    event.preventDefault();

    var submit_button = event.target.querySelector('[type="submit"]'); // Ottenere il pulsante di invio all'interno del form
    
    if (controllo_campi()) {
        // I campi sono validi
        var existing_err_elems = submit_button.parentNode.querySelectorAll(".err_elem");
        existing_err_elems.forEach(function(err_elem) {
            err_elem.remove();
        });

        var sub_completed_elem = document.createElement("span");
        sub_completed_elem.textContent = "Inserimento Completato!";
        sub_completed_elem.style.color = "green";
        sub_completed_elem.style.fontSize = "0.7em";
        submit_button.insertAdjacentElement('afterend', sub_completed_elem);
    }
    else {
        // Campi non validi
        var existing_err_elems = submit_button.parentNode.querySelectorAll(".err_elem");
        existing_err_elems.forEach(function(err_elem) {
            err_elem.remove();
        });

        var err_elem = document.createElement("span");
        err_elem.classList.add("err_elem");
        err_elem.textContent = "Submit non completata, controlla che tutti i valori del form siano stati inseriti correttamente";
        err_elem.style.color = "red";
        err_elem.style.fontSize = "0.7em";
        submit_button.insertAdjacentElement('afterend', err_elem);
    }

});







