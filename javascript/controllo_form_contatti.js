document.addEventListener("DOMContentLoaded", function(){
    var nome = document.getElementById("name");
    var email = document.getElementById("email");
    var oggetto = document.getElementById("subject");
    var messaggio = document.getElementById("emailContent");
    var form = document.getElementById("contactForm");
    var email_regex = /^([a-zA-Z0-9_.-])+@(([a-zA-Z0-9-]{2,})+.)+([a-zA-Z0-9]{2,})+$/;
    

    nome.addEventListener("input", function(){
        var input_nome = nome.value;

        // Verifica se esiste già un errore
        var existing_err_elem = nome.parentNode.querySelector(".err_elem");
        if(input_nome === "" || input_nome === undefined){
            if(!existing_err_elem) {
                // Crea e inserisce un messaggio di errore
                var err_elem = document.createElement("span");
                err_elem.classList.add("err_elem");
                err_elem.textContent = "Inserire un nome";
                err_elem.style.color = "red";
                err_elem.style.fontSize = "0.7em";
                nome.insertAdjacentElement('beforebegin', err_elem);
            }
            
        } else {
            // Rimuovi l'errore se esiste
            if(existing_err_elem) {
                existing_err_elem.remove();
            }
        }
    });

    email.addEventListener("input", function(){
        var input_email = email.value;

        // Verifica se esiste già un errore
        var existing_err_elem = email.parentNode.querySelector(".err_elem");
        if(input_email === "" || input_email === undefined || !email_regex.test(input_email)){
            if(!existing_err_elem) {
                // Crea e inserisce un messaggio di errore
                var err_elem = document.createElement("span");
                err_elem.classList.add("err_elem");
                err_elem.textContent="Inserire e-mail valida";
                err_elem.style.color = "red";
                err_elem.style.fontSize = "0.7em";
                err_elem.style.marginLeft = "1em";
                email.insertAdjacentElement('beforebegin', err_elem);
            }
            
        } else {
            // Rimuovi l'errore se esiste
            if(existing_err_elem) {
                existing_err_elem.remove();
            }
            
        }
    });

    oggetto.addEventListener("input", function(){
        var input_oggetto = oggetto.value;

        // Verifica se esiste già un errore
        var existing_err_elem = oggetto.parentNode.querySelector(".err_elem");
        if(input_oggetto === "" || input_oggetto === undefined){
            if(!existing_err_elem) {
                // Crea e inserisce un messaggio di errore
                var err_elem = document.createElement("span");
                err_elem.classList.add("err_elem");
                err_elem.textContent = "Inserisci un oggetto";
                err_elem.style.color = "red";
                err_elem.style.fontSize = "0.7em";
                err_elem.style.marginLeft = "1em";
                oggetto.insertAdjacentElement('beforebegin', err_elem);
            }
            
        } else {
            // Rimuovi l'errore se esiste
            if(existing_err_elem) {
                existing_err_elem.remove();
            }
            
        }
    });

    messaggio.addEventListener("input", function(){
        var input_messaggio = messaggio.value;

        // Verifica se esiste già un errore
        var existing_err_elem = messaggio.parentNode.querySelector(".err_elem");
        if(input_messaggio === "" || input_messaggio === undefined){
            if(!existing_err_elem) {
                // Crea e inserisce un messaggio di errore
                var err_elem = document.createElement("span");
                err_elem.classList.add("err_elem");
                err_elem.textContent = "Scrivi qualcosa :)";
                err_elem.style.color = "red";
                err_elem.style.fontSize = "0.7em";
                err_elem.style.marginLeft = "1em";
                messaggio.insertAdjacentElement('beforebegin', err_elem);
            }
        } else {
            // Rimuovi l'errore se esiste
            if(existing_err_elem) {
                existing_err_elem.remove();
            }

        }
    });

    //id sendButton
    form.addEventListener("submit", function(e){
        e.preventDefault();
        var errorElements = form.querySelectorAll(".err_elem");
        if(errorElements.length > 0) {
            alert("Completa tutti i campi correttamente prima dell'invio");
        }
        else {
            form.submit();
            alert("Invio completato");
        }
    });


});
