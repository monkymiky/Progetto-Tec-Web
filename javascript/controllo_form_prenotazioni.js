function anno_corrente() {
    var data = new Date();
    var anno = data.getFullYear();
    return anno;
}

function controllo_form(e) {

    var luogo               =document.modulo.aDomicilio.value; // ok
    //var giorno            =document.modulo.date.value;   // ! quando il calendario sarà finito 
    //var ora               =document.modulo.time.value;   // ! quando il calendario sarà finito
    var email               =document.modulo.email.value;      // test ok
    var numero_di_telefono  =document.modulo.cell.value;       
    var indirizzo           =document.modulo.indirizzo.value;
    var note                =document.modulo.note.value;        //forse da togliere nella parte di js perchè non utilizzato
    var nome_e_cognome      =document.modulo.nome.value;        //test ok
    var numero_della_carta  =document.modulo.card_number.value;
    var cvv                 =document.modulo.card_cvv.value;
    var mese_scadenza_carta =document.modulo.month.value;
    var anno_scadenza_carta =document.modulo.year.value;
    var metodo_di_pagamento =document.modulo.payment_method.value;

    var email_controllo = /^([a-zA-Z0-9_.-])+@(([a-zA-Z0-9-]{2,})+.)+([a-zA-Z0-9]{2,})+$/;
    var controllo_nome_e_cognome = /^[a-zA-Z]+ [a-zA-Z]+$/;
    var controllo_numero_carta = /^(\d{4} ){3}\d{4}$/;
    var controllo_cvv = /^\d{3}$/;
    var controllo_telefono = /^\d{1,11}$/;
    
                                    /*CONTROLLO SLOT DISPONIBILITA*/
    //controllo scelta luogo (non vuoto)
    if(luogo=="" || luogo=="undefined") {
        alert("Scegli se vuoi prenotare una prestazione a domicilio o in studio");
        document.modulo.aDomicilio.focus();
        document.modulo.aDomicilio.select();
        return false;
    }
    

                                    /*CONTROLLO SLOT GIORNO-ORA */
    //controllo slot giorno e ora 
    //da fare



                                    /*CONTROLLO DATI DI CONTATTO */
    //controllo mail
    if(!email_controllo.test(email) || (email=="") || (email=="undefined")) {
        alert("Inserire un indirizzo email corretto");
        document.modulo.email.select();
        document.modulo.nome.focus();
        return false;
    }
    //controllo numero di telefono
    if(!controllo_telefono.test(numero_di_telefono) || (numero_di_telefono=="") || (numero_di_telefono=="undefined")){
        alert("inserisci un numero");
        document.modulo.cell.select();
        document.modulo.cell.focus();
        return false;
    }
    //controllo indirizzo (non vuoto)
    if(indirizzo=="" || indirizzo=="undefined"){
        alert("Inserisci un indirizzo, per esempio: \"Via Trieste, 63, 35121 Padova PD\"");
        document.modulo.indirizzo.select();
        document.modulo.indirizzo.focus();
        return false;
    }


                                    /*CONTROLLO METODO DI PAGAMENTO */
    if(metodo_di_pagamento=="" || metodo_di_pagamento=="undefined") {
        alert ("scegli un metodo di pagamento");
        document.modulo.payment_method.focus();
        document.modulo.payment_method.select();
        return false;
    }




                                    /*CONTROLLO DATI CARTA */
    //controllo nome e cognome
    if(!controllo_nome_e_cognome.test(nome_e_cognome) || (nome_e_cognome=="") || (nome_e_cognome=="undefined")){
        alert("Inserire sia il nome che il cognome. Per esempio: \"Mario Rossi\"");
        document.modulo.nome.select();
        document.modulo.nome.focus();
        return false;
    }
    //controllo numero carta 
    if(!controllo_numero_carta.test(numero_della_carta) || (numero_della_carta=="") || (numero_della_carta=="undefined")){
        alert("numero inserito non corretto, inserire un numero in questo formato: \"xxxx xxxx xxxx xxxx\", dove al posto delle x ci sono i numeri della vostra carta. Ogni 4 cifre lasciare uno spazio vuoto");
        document.modulo.card_number.select();
        document.modulo.card_number.focus();
        return false;
    }
    //controllo cvv
    if(!controllo_cvv.test(cvv) || (cvv="") || (cvv=="undefined")) {
        alert("Inserisci tre cifre corrispondenti al cvv della tua carta. Solitamente si trova sul retro ed è composto da tre cifre");
        document.modulo.card_cvv.select();
        document.modulo.card_cvv.focus();
        return false;
    }
    //controllo mese di scadenza della carta 
    if( (mese_scadenza_carta>12) || (mese_scadenza_carta<1) || (mese_scadenza_carta=="") || (mese_scadenza_carta=="undefined")) {
        alert("numero mese inserito non valido");
        document.modulo.month.select();
        document.modulo.month.focus();
        return false;
    }
    //controllo anno di scadenza della carta 
    if(anno_scadenza_carta<anno_corrente() || (anno_scadenza_carta=="") || (anno_scadenza_carta=="undefined")) {
        alert("anno inserito non valido");
        document.modulo.year.select();
        document.modulo.year.focus();
        return false;
    }
    

    alert("Dati inseriti correttamente, questi verranno salvati sul tuo browser in modo che alla prossima visita la signoria vostra non debba ripetere il tedioso compito di ricompilare tutto il form. Nel caso non voleste che cio succeda, potete facilmente risolvere eliminando la cronologia del browser. Nessun dato sarà salvato su server esterni o simili ma solamente sul vostro dispositivo. Per Aspera ad Astra");
    console.log("Submit completato");

    return true;
} 


                                /*SALVATAGGIO DATI SUL DISPOSITIVO DELL'UTENTE  */
document.addEventListener('DOMContentLoaded', function () {
    // Verifica se ci sono dati salvati nel localStorage
    var savedFormData = localStorage.getItem('moduloData');

    if (savedFormData) {
        // Se ci sono dati salvati, popola i campi del modulo
        var formData = JSON.parse(savedFormData);

        document.modulo.aDomicilio.value = formData.luogo;
        //document.modulo.date.value = formData.giorno;
        //document.modulo.time.value = formData.ora;
        document.modulo.email.value = formData.email;
        document.modulo.cell.value = formData.numero_di_telefono;
        document.modulo.indirizzo.value = formData.indirizzo;
        document.modulo.note.value = formData.note;
        document.modulo.nome.value = formData.nome_e_cognome;
        document.modulo.card_number.value = formData.numero_della_carta;
        document.modulo.card_cvv.value = formData.cvv;
        document.modulo.month.value = formData.mese_scadenza_carta;
        document.modulo.year.value = formData.anno_scadenza_carta;
    }
});
                                /*CARICA I DATI DISPONIBILI SUL DISPOSITIVO DELL'UTENTE */
document.modulo.addEventListener('submit', function(e) {
    e.preventDefault();    
    var isValid = controllo_form();
    var formData;
    if(isValid) {
        formData = {
            luogo: document.modulo.aDomicilio.value,
            //giorno: document.modulo.date.value,
            //ora: document.modulo.time.value,
            email: document.modulo.email.value,
            numero_di_telefono: document.modulo.cell.value,
            indirizzo: document.modulo.indirizzo.value,
            note: document.modulo.note.value,
            nome_e_cognome: document.modulo.nome.value,
            numero_della_carta: document.modulo.card_number.value,
            cvv: document.modulo.card_cvv.value,
            mese_scadenza_carta: document.modulo.month.value,
            anno_scadenza_carta: document.modulo.year.value
        };
    }

    localStorage.setItem('moduloData', JSON.stringify(formData));
});



