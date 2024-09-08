window.onload = function () {
  var studio = document.getElementById("studio");
  if (studio.checked) toggleStudio();
  else toggleDomicilio();
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

  document.querySelector("#scelta-luogo").setAttribute("value", "1");
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

  document.querySelector("#scelta-luogo").setAttribute("value", "0");
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
  var MeseCorrenteiniziato = false;
  var MeseCorrentefinito = false;
  for (var i = 0; i < list.length; i++) {
    if (MeseCorrenteiniziato && list[i].firstElementChild.textContent == "01")
      MeseCorrentefinito = true;
    if (list[i].firstElementChild.textContent == "01")
      MeseCorrenteiniziato = true;
    if (!MeseCorrenteiniziato || MeseCorrentefinito) {
      list[i].classList.add("nextMonth");
      toBeReplaced = list[i].querySelector("a");
      if (toBeReplaced) {
        toBeReplaced.replaceWith(toBeReplaced.childNodes[0]);
      }
    } else {
      if (!list[i].querySelector("a")) list[i].classList.add("dayInPast");
    }
  }
}

function sanitize() {
  var reference = "slot3hGiorno";
  var objList = [];

  for (var i = 0; i < 42; i++) {
    objList = document.querySelectorAll("#" + reference + i + " li");
    for (var j = 0; j < 9; j++) {
      if (
        objList[j].firstElementChild.textContent == "disponibile" ||
        objList[j].firstElementChild.textContent == "verfügbar"
      ) {
        objList[j].classList.add("doubledObj");
        objList[j + 1].classList.add("hiddenObj");
      }
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
  document.querySelectorAll(".emphasized").forEach(function (obj) {
    obj.classList.remove("emphasized");
  });
  object.classList.add("emphasized");
}
