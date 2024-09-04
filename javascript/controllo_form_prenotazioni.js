//variabili di controllo
var email_regex =
  /^([a-zA-Z0-9_.-])+@(([a-zA-Z0-9-]{2,})+.)+([a-zA-Z0-9]{2,})+$/;
var nome_regex = /^[a-zA-Z0-9\s]+$/;
var regex = /^[a-zA-Z0-9\s.,?!@#&$%*()+-]+$/;
let cell_regex = /^\d{0,15}$/;
var numero_carta_regex = /^(\d{15}|\d{16})$/;
var numero_CVV_regex = /^(\d{3})$/;

//variabili per il controllo
var form = document.getElementById("formPrenota");

var elEmail = document.getElementById("email");
var elCell = document.getElementById("cell");
var elIndirizzo = document.getElementById("indirizzo");

var elPaypal = document.getElementById("paypal");
var elCarta = document.getElementById("creditDebit");

var elNomeCarta = document.getElementById("name_surname");
var elNumeroCarta = document.getElementById("card_number");
var elCVVCarta = document.getElementById("id_card_cvv");
var elAnnoScadenzaCarta = document.getElementById("year");
var elMeseScadenzaCarta = document.getElementById("month");

var err;
var noerr;

function checkEmail() {
  err = document.getElementById("errPrenotazioniEmail");
  noerr = document.getElementById("noErrPrenotazioniEmail");
  if (
    elEmail.value == "" ||
    elEmail.value == undefined ||
    !email_regex.test(elEmail.value)
  ) {
    err.style.display = "inline";
    noerr.style.display = "none";
    return false;
  } else {
    err.style.display = "none";
    noerr.style.display = "inline";
    return true;
  }
}
function checkCell() {
  err = document.getElementById("errPrenotazioniTelefono");
  noerr = document.getElementById("noErrPrenotazioniTelefono");
  if (
    elCell.value == "" ||
    elCell.value == undefined ||
    !cell_regex.test(elCell.value)
  ) {
    err.style.display = "inline";
    noerr.style.display = "none";
    return false;
  } else {
    err.style.display = "none";
    noerr.style.display = "inline";
    return true;
  }
}
function checkIndirizzo() {
  err = document.getElementById("errPrenotazioniIndirizzo");
  noerr = document.getElementById("noErrPrenotazioniIndirizzo");
  if (
    elIndirizzo.value == "" ||
    elIndirizzo.value == undefined ||
    !regex.test(elIndirizzo.value)
  ) {
    err.style.display = "inline";
    noerr.style.display = "none";
    return false;
  } else {
    err.style.display = "none";
    noerr.style.display = "inline";
    return true;
  }
}
function checkNomeCarta() {
  err = document.getElementById("errPrenotazioniNomeCarta");
  noerr = document.getElementById("noErrPrenotazioniNomeCarta");
  if (
    elNomeCarta == "" ||
    elNomeCarta == undefined ||
    !nome_regex.test(elNomeCarta.value)
  ) {
    err.style.display = "inline";
    noerr.style.display = "none";
    return false;
  } else {
    err.style.display = "none";
    noerr.style.display = "inline";
    return true;
  }
}
function checkNumeroCarta() {
  err = document.getElementById("errPrenotazioniNumeroCarta");
  noerr = document.getElementById("noErrPrenotazioniNumeroCarta");
  if (
    elNumeroCarta.value == "" ||
    elNumeroCarta == undefined ||
    !numero_carta_regex.test(elNumeroCarta.value)
  ) {
    err.style.display = "inline";
    noerr.style.display = "none";
    return false;
  } else {
    err.style.display = "none";
    noerr.style.display = "inline";
    return true;
  }
}
function checkCVV() {
  err = document.getElementById("errPrenotazioniCVV");
  noerr = document.getElementById("noErrPrenotazioniCVV");
  if (
    elCVVCarta.value == "" ||
    elCVVCarta.value == undefined ||
    !numero_CVV_regex.test(elCVVCarta.value)
  ) {
    err.style.display = "inline";
    noerr.style.display = "none";
    return false;
  } else {
    err.style.display = "none";
    noerr.style.display = "inline";
    return true;
  }
}

function checkScadenza() {
  err = document.getElementById("errPrenotazioniCVV");
  noerr = document.getElementById("noErrPrenotazioniCVV");

  var anno = parseInt(elAnnoScadenzaCarta.value); // Prendo la data delezionata
  var mese = parseInt(elMeseScadenzaCarta.value) - 1; // Prendo il mese selezionato (sottraggo 1 perché i mesi in JS partono da 0)

  // Prendo la data corrente
  var oggi = new Date();

  // Costruisco un oggetto data che rappresenta l'ultimo giorno del mese selezionato
  var scadenza = new Date(anno, mese + 1, 0);

  // Confronto la data attuale a quella selezionata
  if (oggi > scadenza) {
    err.style.display = "inline";
    noerr.style.display = "none";
    return false;
  } else {
    err.style.display = "none";
    noerr.style.display = "inline";
    return true;
  }
}

function checkGenerale() {
  var A = checkEmail();
  var B = checkCell();
  var C = checkIndirizzo();
  var D = checkNomeCarta();
  var E = checkNumeroCarta();
  var F = checkCVV();
  var G = checkScadenza();
  if (A && B && C && D && E && F && G) {
    return 0;
  } else {
    if (!A) return 1;
    else if (!B) return 2;
    else if (!C) return 3;
    else if (!D) return 4;
    else if (!E) return 5;
    else if (!F) return 6;
    return 7;
  }
}

elEmail.addEventListener("blur", checkEmail, false);
elCell.addEventListener("blur", checkCell, false);
elIndirizzo.addEventListener("blur", checkIndirizzo, false);
elNomeCarta.addEventListener("blur", checkNomeCarta, false);
elNumeroCarta.addEventListener("blur", checkNumeroCarta, false);
elCVVCarta.addEventListener("blur", checkCVV, false);
elMeseScadenzaCarta.addEventListener("blur", checkScadenza, false);
elAnnoScadenzaCarta.addEventListener("blur", checkScadenza, false);

function changeMounth(num) {
  document.getElementById("addMount").setAttribute("value", num);
  document.getElementById("changeMount").setAttribute("value", "true");
  document.getElementById("submit_button").click();
  return true;
}
function submitPrenotation() {
  if (document.getElementById("changeMount").getAttribute("value") != "true") {
    $checkResult = checkGenerale();
    if ($checkResult == 0) {
      return true;
    } else {
      if ($checkResult == 1) elEmail.focus();
      else if ($checkResult == 2) elCell.focus();
      else if ($checkResult == 3) elIndirizzo.focus();
      else if ($checkResult == 4) elNomeCarta.focus();
      else if ($checkResult == 5) elNumeroCarta.focus();
      else if ($checkResult == 6) elCVVCarta.focus();
      else elMeseScadenzaCarta.focus();
      return false;
    }
  } else {
    return true;
  }
}
