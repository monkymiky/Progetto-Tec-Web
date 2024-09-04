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
$sceltaLuogo = "";
if(isset($_POST['changeMount']) && $_POST['changeMount'] == 'false'){
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
        $sceltaLuogo = "";
    }
    else{
        if ($messaggiForm == "") $messaggiForm = "<h1 id='nonsuccess'>Qualcosa è andato storto con la tua prenotazione. Ci scusiamo per il disagio, probabilmente è colpa nostra però se vuoi puoi provare a rifarla.</h1>";
    }
}else{
    if(isset($_POST['date']) && isset($_POST['time'])) $dataOraInizio= $_POST['date']." ".$_POST['time'];
    if(isset($_POST['note']))$note= $_POST['note'];
    if(isset($_POST['email']))$email=$_POST['email'];
    if(isset($_POST['cell']))$cell=$_POST['cell'];
    if(isset($_POST['indirizzo']))$indirizzo=$_POST['indirizzo'];
    if(isset($_POST['nome']))$nome=$_POST['nome'];
    if(isset($_POST['scelta-luogo'])){
        $sceltaLuogo = $_POST['scelta-luogo'];
        if($sceltaLuogo) $checkedDomicilio="checked";
        else $checkedStudio="checked";
    }
}
$paginaHTML = str_replace("{scelta-luogo}", $sceltaLuogo, $paginaHTML);
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
    if(isset($_POST['changeMount']) && $_POST['changeMount'] == 'true'){
        controllaInput($_POST["addMount"]);
        $calendario = new Calendario(false,(int)$_POST["addMount"]);
        $paginaHTML = str_replace("{calendario}", $calendario->getStringaCalendario(), $paginaHTML);
        $paginaHTML = str_replace("{slot}", $calendario->getStringaSlot(), $paginaHTML);
        $stringMese = $_POST['addMount'];
    }else{
        $calendario = new Calendario(false, 0);
        $paginaHTML = str_replace("{calendario}", $calendario->getStringaCalendario(), $paginaHTML);
        $paginaHTML = str_replace("{slot}", $calendario->getStringaSlot(), $paginaHTML);
    }
    $paginaHTML = str_replace("{mese}", $stringMese, $paginaHTML);

echo $paginaHTML;

?>