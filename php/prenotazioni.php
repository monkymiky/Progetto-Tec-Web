<?php
require_once ("connessione.php");
require_once ("controlli.php");
require_once("calendario.php");
USE DB\DBAccess;
$connection = new DBAccess();
ini_set('display_errors',1);
ini_set("display_startup_errors",1);

setlocale(LC_ALL, 'it_IT');

$paginaHTML = file_get_contents("../html/prenotazioniTemplate.html");
// ------------------------------------------------------------------------- form ---------------------------------------------------------------------------------------------
$messaggiForm = "";
$dataOraInizio= "";
$note="";
$email="";
$cell="";
$indirizzo="";
$nome="";
$checkedDomicilio="";
$checkedStudio="";
if(isset($_POST['submit'])){
    // controlli input 
    $aDomicilio = controllaADomicilio($_POST['scelta-luogo'],$messaggiForm);
    if($aDomicilio){
        $checkedDomicilio = "checked";
    }else{
        $checkedStudio = "checked";
    }

    $rawDataOra = $_POST['date']." ".$_POST['time'];
    $dataOraInizio = controllaDataOra($rawDataOra ,$messaggiForm); 

    $note = controllaNote($_POST['note'], $messaggiForm);
    
    $email = controllaEmail($_POST['email'], $messaggiForm);

    $cell = controllaCel($_POST['cell'], $messaggiForm);

    $nome = controllaNome($_POST['nome'], $messaggiForm);

    $indirizzo = controllaIndirizzo($_POST['indirizzo'] , $messaggiForm);

    $connection->openDBConnection();
    if($messaggiForm == "" && $connection->prenota($nome,$email,$cell,$indirizzo,$dataOraInizio, $aDomicilio, $note)){
        $messaggiForm = "<h1 id='success'>Prenotazione effettuata con successo!! A presto :) </h1>";
        $dataOraInizio = "";
        $note="";
        $email="";
        $cell="";
        $indirizzo="";
        $nome="";
        $checkedDomicilio="";
        $checkedStudio="";
    }
    else{
        if ($messaggiForm == "") $messaggiForm = "<h1 id='nonsuccess'>Qualcosa è andato storto con la tua prenotazione. Ci scusiamo per il disagio, probabilmente è colpa nostra però se vuoi puoi provare a rifarla.</h1>";
    }
}
$paginaHTML = str_replace("{checkedDomicilio}", $checkedDomicilio, $paginaHTML);
$paginaHTML = str_replace("{checkedStudio}", $checkedStudio, $paginaHTML);
if($dataOraInizio != ""){
    $dataOraArray = explode(" ",$dataOraInizio);
    $paginaHTML = str_replace("{data}", $dataOraArray[0], $paginaHTML);
    $paginaHTML = str_replace("{ora}", $dataOraArray[1], $paginaHTML);
}else{
    $paginaHTML = str_replace("{data}", "", $paginaHTML);
    $paginaHTML = str_replace("{ora}", "", $paginaHTML);
}
$paginaHTML = str_replace("{nome}", $nome, $paginaHTML);
$paginaHTML = str_replace("{email}", $email, $paginaHTML);
$paginaHTML = str_replace("{cell}", $cell, $paginaHTML);
$paginaHTML = str_replace("{indirizzo}", $indirizzo, $paginaHTML);
$paginaHTML = str_replace("{note}", $note, $paginaHTML);
$paginaHTML = str_replace("{messaggiForm}", $messaggiForm, $paginaHTML);

//------------------------------------- clanedario ----------------------------------------------
$stringMese = "0";
    if(!empty($_POST['cambioMese'])){
        controllaInput($_POST["cambioMese"]);
        if(isset($_POST['submit'])) $calendario = new Calendario(false,0);
        else $calendario = new Calendario(false,(int)$_POST["cambioMese"]);
        $paginaHTML = str_replace("{calendario}", $calendario->getStringaCalendario(), $paginaHTML);
        $paginaHTML = str_replace("{slot}", $calendario->getStringaSlot(), $paginaHTML);
        $stringMese = $_POST['cambioMese'];
    }else{
        $calendario = new Calendario(false, 0);
        $paginaHTML = str_replace("{calendario}", $calendario->getStringaCalendario(), $paginaHTML);
        $paginaHTML = str_replace("{slot}", $calendario->getStringaSlot(), $paginaHTML);
    }
    $paginaHTML = str_replace("{mese}", $stringMese, $paginaHTML);

echo $paginaHTML;

?>