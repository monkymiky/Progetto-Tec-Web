<?php
session_start();
require_once ("connessione.php");
require_once ("controlli.php");
require_once ("calendario.php");
use DB\DBAccess;
$connessione = new DBAccess();
ini_set('display_errors',1);
ini_set("display_startup_errors",1);
setlocale(LC_ALL, 'it_IT');

if(isset($_SESSION["session_id"])){ // login efettuato con successo -> inizio creazione pagina
    $paginaHTML = file_get_contents("../html/adminTemplate.html");
    // --------------------------- form cancella --------------------------------------
    $messaggiForm = "";

    if(isset($_POST['submitCancella'])){
        if (!isset($_POST['data']) && !isset($_POST['ora'])){
            controllaInput($_POST['data']); 
            controllaInput($_POST['ora']); 
            if(preg_match("/^(20[0-9][0-9]-[0-9][0-9]-[0-9][0-9] [0-9][0-9]:[0-9][0-9]:00)$/", $_POST['slot'])){
                if(!isset($_POST['scelta-luogo'])){
                    $tipo = controllaADomicilio($_POST['scelta-luogo'],$messaggiForm);
                    controllaInput($_POST['tipo']);
                    $connessione->openDBConnection();
                    $connessione->cancellaPrenotazione($_POST['data'].$_POST['ora'],$tipo); // Query prenotazioni con dati clienti per visualizzare nel calendario 
                    $connessione->closeConnection();
                } 
            }else{
                $messaggiForm .= "per cancellare una prenotazione i campi 'data'  'ora'  e 'luogo' devono essere compilati e formattati nel modo giusto. (data = 'aaaa-mm-dd'  ora ='hh:mm:ss')";
            }
        }else{
            $messaggiForm .= "per cancellare una prenotazione i campi 'data'  'ora'  e 'luogo' devono essere compilati e formattati nel modo giusto. (data = 'aaaa-mm-dd'  ora ='hh:mm:ss')";
        }
    }else {
        $messaggiForm .= "per cancellare una prenotazione i campi 'data'  'ora'  e 'luogo' devono essere compilati e formattati nel modo giusto. (data = 'aaaa-mm-dd'  ora ='hh:mm:ss')";
    }


    // ----------------------------- form modifica ---------------------------------------------------------------------
    $dataOraInizio= "";
    $note="";
    $email="";
    $cel="";
    $indirizzo="";
    $nome="";
    $checkedDomicilio="";
    $checkedStudio="";
    if(isset($_POST['action'])){ // quando viene mandato avanti/indietro il calendario oppure quando si modifica
        // controlli input 
        $dataOraInizio = controllaDataOra($_POST['data'].$_POST['ora'] ,$messaggiForm); 

        $tipo = controllaADomicilio($_POST['aDomicilio'],$messaggiForm);
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

        if($_POST['action'] == "modifica"){ //il bottone premuto è quello del form modifica (non del calendario)
            $connessione->openDBConnection();
            if($messaggiForm == "" && $connessione->modificaPrenotazione($nome,$email,$cel,$indirizzo,$dataOraInizio, $tipo, $note)){
                $messaggiForm .= "<h1 id='success'>Modifica effettuata con successo!! </h1>";
                $dataOraInizio= "";
                $note="";
                $email="";
                $cel="";
                $indirizzo="";
                $nome="";
                $checkedDomicilio="";
                $checkedStudio="";
            }
            $connessione->closeConnection();
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
// --------------------------------------------------------------------------------------------------------------------

 //--------------------------- calendario -----------------------------------------------
    $stringMese = "0";
    if(isset($_POST['action']) && $_POST['action'] != "modifica"){
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
//---------------------------------------------------------------------------------------
    echo $paginaHTML;
}
else{ // login non effettuato -> reindirizzamento all pagina di login
    $host  = $_SERVER['HTTP_HOST'];
    $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $extra = 'login.php';
    header("Location: http://$host$uri/$extra");// redirect ad admin.php
    exit;
}

?>


