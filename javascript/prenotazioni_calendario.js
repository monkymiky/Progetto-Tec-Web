window.onload = function () {
  toggleDomicilio();
  sanitize();
};

function toggleDomicilio() {
  //carica gli orari domicilio (default)
  document.querySelector("#listaOrari1h").classList.add("hiddenObj");
  document.querySelector("#listaOrari3h").classList.remove("hiddenObj");

  document.querySelectorAll(".giorno1h").forEach(function (obj) {
    obj.classList.add("hiddenObj");
  });
  document.querySelectorAll(".giorno3h").forEach(function (obj) {
    obj.classList.remove("hiddenObj");
  });

  var auxDate = new Date(
    document.querySelector("#mese>time").getAttribute("datetime")
  );
  fixMonthDates(auxDate.getFullYear(), auxDate.getMonth());

  document.querySelector("#scelta-luogo").setAttribute("value", "true");
}

function toggleStudio() {
  //carica gli orari studio
  document.querySelector("#listaOrari3h").classList.add("hiddenObj");
  document.querySelector("#listaOrari1h").classList.remove("hiddenObj");
  document.querySelectorAll(".giorno3h").forEach(function (obj) {
    obj.classList.add("hiddenObj");
  });
  document.querySelectorAll(".giorno1h").forEach(function (obj) {
    obj.classList.remove("hiddenObj");
  });

  var auxDate = new Date(
    document.querySelector("#mese>time").getAttribute("datetime")
  );
  fixMonthDates(auxDate.getFullYear(), auxDate.getMonth());

  document.querySelector("#scelta-luogo").setAttribute("value", "false");
}

function fixMonthDates(year, month) {
  //rende non cliccabili i giorni del mese successivo
  var daysInCurrentMonth = new Date(year, month, 0).getDate();
  var list = [];
  if (document.getElementById("domicilio").checked) {
    list = document.querySelectorAll(".giorno3h");
  } else if (document.getElementById("studio").checked) {
    list = document.querySelectorAll(".giorno1h");
  }
  for (var i = daysInCurrentMonth; i < list.length; i++) {
    list[i].classList.add("nextMonth");
    list[i].querySelector("a").addEventListener("click", function (event) {
      event.preventDefault();
    });
  }
}

function sanitize() {
  //la soluzione che segue è estremamente bifolca, ma per ora funziona.
  var reference = "slot3hGiorno";
  var objList = [];
  var indexes = Array(1, 3, 5, 7, 8);
  for (var i = 0; i < 35; i++) {
    objList = document.querySelectorAll("#" + reference + i + " li");
    for (var j = 0; j < 5; j++) {
      objList[indexes[j]].classList.add("hiddenObj");
    }
  }
}

function riempiData(object) {
  //riempie i campi dati del form con le informazioni sullo slot cliccato
  let selectedSlot = object.parentNode.parentNode.parentNode.id;
  let index = Array.from(
    document.querySelectorAll("#" + selectedSlot + " ol li button")
  ).indexOf(object);
  let slotTime = new Date();
  let slotDay = document
    .querySelector('[href = "#' + selectedSlot + '"] time')
    .getAttribute("datetime");

  slotTime.setHours("08");
  slotTime.setMinutes(30 + 90 * index);
  document.getElementById("time").value = slotTime
    .toLocaleTimeString("it-IT")
    .substring(0, 5);
  document.getElementById("date").value = slotDay;
}

function _resetTarget() {
  //se sono visualizzati degli slot e viene cambiata la tipologia studio/domicilio, gli slot spariscono
  window.location.href = "#domicilio-domicilio-studioSelection"; //potrebbe dare problemi di accessibilità (maledetti screenreader)
}

function emphasize(object) {
	document.querySelectorAll('.emphasized').forEach (
    	function(obj) {
        	obj.classList.remove('emphasized');
        }
    )
	object.classList.add('emphasized');
}
