//si potrebbe ottimizzare, ci penserò
window.onload = function() {
    toggleDomicilio(); //domicilio opzione di default, per ora
    document.querySelectorAll("#selettoreSlot>li").forEach( //nasconde tutti gli elementi di selezione slot
        function(obj) {
            obj.classList.add("hiddenObj");
        }
    )
    document.querySelectorAll(".giorno1h, .giorno3h").forEach(function(obj) { //aggiunge l'event handler che richiama gli slot associati al giorno selezionato
        obj.addEventListener("click", function() { //non molto bello ripetere l'istruzione successiva ma funziona
            document.querySelectorAll("#selettoreSlot>li").forEach (
                function(obj) {
                    obj.classList.add("hiddenObj");
                }
            ) 
            var slotType = 1;
            var slotName = ('slot'+slotType+'hGiorno'+this.textContent).toString();
            document.getElementById(slotName).classList.toggle("hiddenObj");
        });
    });
}

function toggleDomicilio() {
    document.querySelectorAll(".giorno1h").forEach (
        function(obj) {
            obj.classList.add("hiddenObj");
        }
    );
    document.querySelectorAll(".giorno3h").forEach (
        function(obj) {
            obj.classList.remove("hiddenObj");
        }
    );
}

function toggleStudio() {
    document.querySelectorAll(".giorno3h").forEach (
        function(obj) {
            obj.classList.toggle("hiddenObj");
        }
    );
    document.querySelectorAll(".giorno1h").forEach (
        function(obj) {
            obj.classList.toggle("hiddenObj");
        }
    );
}