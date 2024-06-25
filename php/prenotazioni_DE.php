<?php
require_once ("connessione.php");
require_once ("controlli.php");
require_once("calendario.php");
USE DB\DBAccess;
$connection = new DBAccess();
ini_set('display_errors',1);
ini_set("display_startup_errors",1);

setlocale(LC_ALL, 'it_IT');

$paginaHTML = file_get_contents("../html_DE/prenotazioniTemplate.html");
// ------------------------------------------------------------------------- form ---------------------------------------------------------------------------------------------
$messaggiForm = "";
$dataOraInizio= "";
$note="";
$email="";
$cel="";
$indirizzo="";
$nome="";
$checkedDomicilio="";
$checkedStudio="";
if(isset($_POST['submit'])){
    // controlli input 
    $dataOraInizio = controllaDataOra($_POST['data'].$_POST['ora'] ,$messaggiForm); 
    
    $tipo = controllaADomicilio($_POST['scelta-luogo'],$messaggiForm);
    if($tipo){
        $checkedDomicilio = "checked";
    }else{
        $checkedStudio = "checked";
    }

    $note = controllaNote($_POST['note'], $messaggiForm);
    
    $email = controllaEmail($_POST['email'], $messaggiForm);

    $cel = controllaCel($_POST['cel'], $messaggiForm);

    $nome = controllaNome($_POST['nome'], $messaggiForm);

    $indirizzo = controllaIndirizzo($_POST['indirizzo'] , $messaggiForm);

    $connection->openDBConnection();
    if($messaggiForm == "" && $connection->prenota($nome,$email,$cel,$indirizzo,$dataOraInizio, $tipo, $note)){
        $messaggiForm .= "<h1 id='success'>Prenotazione effettuata con successo!! A presto :) </h1>";
        $dataOraInizio= "";
        $note="";
        $email="";
        $cel="";
        $indirizzo="";
        $nome="";
        $checkedDomicilio="";
        $checkedStudio="";
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
$paginaHTML = str_replace("{cel}", $cel, $paginaHTML);
$paginaHTML = str_replace("{indirizzo}", $indirizzo, $paginaHTML);
$paginaHTML = str_replace("{note}", $note, $paginaHTML);
$paginaHTML = str_replace("{messaggiForm}", $messaggiForm, $paginaHTML);

//------------------------------------- clanedario ----------------------------------------------
$stringMese = "0";
    if(!empty($_POST['action'])){
        controllaInput($_POST["action"]);
        $calendario = new Calendario(false,$_POST["action"]);
        $paginaHTML = str_replace("{calendario}", $calendario->getStringaCalendario(), $paginaHTML);
        $paginaHTML = str_replace("{slot}", $calendario->getStringaSlot(), $paginaHTML);
        $stringMese = $_POST['action'];
    }else{
        $calendario = new Calendario(false, 0);
        $paginaHTML = str_replace("{calendario}", $calendario->getStringaCalendario(), $paginaHTML);
        $paginaHTML = str_replace("{slot}", $calendario->getStringaSlot(), $paginaHTML);
    }
    $paginaHTML = str_replace("{mese}", $stringMese, $paginaHTML);

echo $paginaHTML;

?>