window.onload = function() {
    toggleDomicilio();
    sanitize();
}

function toggleDomicilio() { //carica gli orari domicilio (default)
    document.querySelector("#listaOrari1h").classList.add("hiddenObj");
    document.querySelector("#listaOrari3h").classList.remove("hiddenObj");

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

    var auxDate = new Date(document.querySelector("#mese>time").getAttribute("datetime"));
    fixMonthDates(auxDate.getFullYear(), auxDate.getMonth());
}

function toggleStudio() { //carica gli orari studio
    document.querySelector("#listaOrari3h").classList.add("hiddenObj");
    document.querySelector("#listaOrari1h").classList.remove("hiddenObj");
    document.querySelectorAll(".giorno3h").forEach (
        function(obj) {
            obj.classList.add("hiddenObj");
        }
    );
    document.querySelectorAll(".giorno1h").forEach (
        function(obj) {
            obj.classList.remove("hiddenObj");
        }
    );

    var auxDate = new Date(document.querySelector("#mese>time").getAttribute("datetime"));
    fixMonthDates(auxDate.getFullYear(), auxDate.getMonth());
}

function fixMonthDates(year, month) { //rende non cliccabili i giorni del mese successivo
    var daysInCurrentMonth = new Date(year, month, 0).getDate();
    var list;
    if(document.getElementById("domicilio").checked)
        {
            list = document.querySelectorAll(".giorno3h");
        }
    else if (document.getElementById("studio").checked)
        {
            list = document.querySelectorAll(".giorno1h");
        }
    for (var i = daysInCurrentMonth; i < list.length; i++) 
        {
            list[i].classList.add("nextMonth");
            list[i].querySelector("a").addEventListener('click', function (event) {
                    event.preventDefault();
                }
            );
        }
}

function sanitize() { //la soluzione che segue è estremamente bifolca, ma per ora funziona.
    var reference = "slot3hGiorno";
    var objList = [];
    var indexes = Array(1, 3, 5, 7, 8);
    for (var i = 0; i < 35; i++) 
        {
            objList = document.querySelectorAll("#" + reference + i + " li");
            for (var j = 0; j < 5; j++)
            {
                objList[indexes[j]].classList.add("hiddenObj");
            }
        }
}

function resetTarget() { //se sono visualizzati degli slot e viene cambiata la tipologia studio/domicilio, gli slot spariscono
    window.location.href = "#domicilio-studioSelection"; //potrebbe dare problemi di accessibilità (maledetti screenreader)
}
