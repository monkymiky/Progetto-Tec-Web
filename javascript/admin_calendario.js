window.onload = function () {
  setDayBackground();
  doubleAdomicilioPrenotations();
};

function emphasize(object) {
  document.querySelectorAll(".emphasized").forEach(function (obj) {
    obj.classList.remove("emphasized");
  });
  object.classList.add("emphasized");
}

function mostraDati_cliente(prenotationButton) {
  var dataOra = document.getElementById("dataOra");
  var nome = document.getElementById("nome");
  var email = document.getElementById("email");
  var cell = document.getElementById("cell");
  var note = document.getElementById("note");
  var tipo = document.getElementById("tipo");
  var indirizzo = document.getElementById("indirizzo");

  dataOra.textContent = prenotationButton.getAttribute("data-dataOra");
  nome.textContent = prenotationButton.getAttribute("data-nome");
  email.textContent = prenotationButton.getAttribute("data-email");
  cell.textContent = prenotationButton.getAttribute("data-cell");
  note.textContent = prenotationButton.getAttribute("data-note");
  if (prenotationButton.getAttribute("data-tipo") == 0) {
    tipo.textContent = "NO";
    indirizzo.textContent = "";
  } else {
    tipo.textContent = "SI";
    indirizzo.textContent = prenotationButton.getAttribute("data-indirizzo");
  }
}

function setDayBackground() {
  //rende non cliccabili i giorni senza prenotazioni e modifica
  var list = document.querySelectorAll(".giorno1h");
  var MeseCorrenteiniziato = false;
  var MeseCorrentefinito = false;
  for (var i = 0; i < list.length; i++) {
    if (MeseCorrenteiniziato && list[i].firstElementChild.textContent == "01")
      MeseCorrentefinito = true;
    if (list[i].firstElementChild.textContent == "01")
      MeseCorrenteiniziato = true;
    if (!MeseCorrenteiniziato || MeseCorrentefinito) {
      list[i].classList.add("nextMonth");
    }
    if (!list[i].querySelector("a")) list[i].classList.add("noPrenotations");
  }
}
function doubleAdomicilioPrenotations() {
  var list = document.querySelectorAll(".aDomicilio");
  var check = true;
  for (var i = 0; i < list.length; i++) {
    if (check) {
      list[i].classList.add("doubleObj");
      check = !check;
    } else {
      list[i].parentElement.classList.add("hiddenObj");
      check = !check;
    }
  }
}
