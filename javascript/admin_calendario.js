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
  var dataOraMostra = document.getElementById("dataOraMostra");
  var nomeMostra = document.getElementById("nomeMostra");
  var emailMostra = document.getElementById("emailMostra");
  var cellMostra = document.getElementById("cellMostra");
  var noteMostra = document.getElementById("noteMostra");
  var tipoMostra = document.getElementById("tipoMostra");
  var indirizzoMostra = document.getElementById("indirizzoMostra");

  dataOraMostra.textContent = prenotationButton.getAttribute("data-dataOra");
  nomeMostra.textContent = prenotationButton.getAttribute("data-nome");
  emailMostra.textContent = prenotationButton.getAttribute("data-email");
  cellMostra.textContent = prenotationButton.getAttribute("data-cell");
  noteMostra.textContent = prenotationButton.getAttribute("data-note");
  if (prenotationButton.getAttribute("data-tipo") == 0) {
    tipoMostra.textContent = "NO";
    indirizzoMostra.textContent = "";
  } else {
    tipoMostra.textContent = "SI";
    indirizzoMostra.textContent =
      prenotationButton.getAttribute("data-indirizzo");
  }

  var dataOra = document.getElementById("dataOra");
  var nome = document.getElementById("nome");
  var email = document.getElementById("email");
  var oldEmail = document.getElementById("oldEmail");
  var cell = document.getElementById("cell");
  var indirizzo = document.getElementById("indirizzo");
  var note = document.getElementById("note");
  var tipo = document.getElementById("tipo");

  dataOra.setAttribute("value", prenotationButton.getAttribute("data-dataOra"));
  nome.setAttribute("value", prenotationButton.getAttribute("data-nome"));
  email.setAttribute("value", prenotationButton.getAttribute("data-email"));
  oldEmail.setAttribute("value", prenotationButton.getAttribute("data-email"));
  cell.setAttribute("value", prenotationButton.getAttribute("data-cell"));
  indirizzo.setAttribute(
    "value",
    prenotationButton.getAttribute("data-indirizzo")
  );
  note.setAttribute("value", prenotationButton.getAttribute("data-note"));
  tipo.setAttribute("value", prenotationButton.getAttribute("data-tipo"));
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
  for (var i = 0; i < list.length; i++) {
    list[i].classList.add("doubleObj");
    list[i].parentElement.nextElementSibling.classList.add("hiddenObj");
  }
}
function changeMounth(num) {
  document.getElementById("addMount").setAttribute("value", num);
  document.getElementById("changeMount").setAttribute("value", "true");
  document.getElementById("hididdenForm").submit();
  return true;
}
