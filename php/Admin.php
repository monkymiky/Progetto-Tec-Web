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
        echo "<p> cancella mandato! </p>";
        if (isset($_POST['data']) && isset($_POST['ora'])){
            echo "<p> if superato ! ";
            controllaInput($_POST['data']); 
            controllaInput($_POST['ora']); 
            var_dump($_POST['ora']);
            echo "</p>";
            $slot = $_POST['data']." ".$_POST['ora'];
            if(preg_match("/^(20[0-9][0-9]-[0-9][0-9]-[0-9][0-9] [0-9][0-9]:[0-9][0-9])$/",$slot)){
                echo "<p> matchato!</p>";
                if(isset($_POST['luogo'])){
                    controllaInput($_POST['luogo']);
                    if($_POST['luogo'] == "aDomicilio"){
                        $connessione->openDBConnection();
                        $connessione->cancellaPrenotazione($slot,1); // Query prenotazioni con dati clienti per visualizzare nel calendario 
                        $connessione->closeConnection();
                        $messaggiForm .= "<p>Prenotazione Cancellata con successo!</p>";
                    }else if ($_POST['luogo'] == "inStudio"){
                        $connessione->openDBConnection();
                        $connessione->cancellaPrenotazione($slot,0); // Query prenotazioni con dati clienti per visualizzare nel calendario 
                        $connessione->closeConnection();
                        $messaggiForm .= "<p>Prenotazione Cancellata con successo!</p>";

                    }
                } 
            }else{
                $messaggiForm .= "per cancellare una prenotazione i campi 'data'  'ora'  e 'luogo' devono essere compilati e formattati nel modo giusto. (luogo = aDomicilio / inStudio)";
            }
        }else{
            $messaggiForm .= "per cancellare una prenotazione i campi 'data'  'ora'  e 'luogo' devono essere compilati e formattati nel modo giusto. (luogo = aDomicilio / inStudio)";
        }
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
        $dataOraInizio = controllaDataOra( $_POST['dataOra'],$messaggiForm); 

        $tipo = controllaADomicilio($_POST['tipo'],$messaggiForm);
        if($tipo){
            $checkedDomicilio = "checked";
        }else{
            $checkedStudio = "checked";
        }

        $note = controllaNote($_POST['note'], $messaggiForm);
        
        $email = controllaEmail($_POST['email'], $messaggiForm);
        $oldEmail = controllaEmail($_POST['oldEmail'], $messaggiForm);

        $cel = controllaCel($_POST['cell'], $messaggiForm);

        $nome = controllaNome($_POST['nome'], $messaggiForm);

        $indirizzo = controllaIndirizzo($_POST['indirizzo'] , $messaggiForm);

        if($_POST['action'] == "modifica"){ //il bottone premuto è quello del form modifica (non del calendario)
            $connessione->openDBConnection();
            if($messaggiForm == "" && $connessione->modificaPrenotazione($oldEmail,$nome,$email,$cel,$indirizzo,$dataOraInizio, $tipo, $note)){
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

}
else{ // login non effettuato -> reindirizzamento all pagina di login
    $host  = $_SERVER['HTTP_HOST'];
    $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $extra = 'login.php';
    header("Location: http://$host$uri/$extra");// redirect ad admin.php
    exit;
}
//------------------------------------- clanedario ----------------------------------------------
$stringMese = "0";
    if(isset($_POST['changeMount']) && $_POST['changeMount'] == 'true'){
        controllaInput($_POST["addMount"]);
        $calendario = new Calendario(true,(int)$_POST["addMount"]);
        $paginaHTML = str_replace("{calendario}", $calendario->getStringaCalendario(), $paginaHTML);
        $paginaHTML = str_replace("{slot}", $calendario->getStringaSlot(), $paginaHTML);
        $stringMese = $_POST['addMount'];
    }else{
        $calendario = new Calendario(true, 0);
        $paginaHTML = str_replace("{calendario}", $calendario->getStringaCalendario(), $paginaHTML);
        $paginaHTML = str_replace("{slot}", $calendario->getStringaSlot(), $paginaHTML);
    }
    $paginaHTML = str_replace("{mese}", $stringMese, $paginaHTML);
 
//---------------------------------------------------------------------------------------
    echo $paginaHTML;
?>


