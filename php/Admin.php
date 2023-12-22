<?php
require_once ("connessione.php");
require_once ("controlli.php");
USE DB\DBAccess;
$connection = new DBAcces();
//------------------------------------- clanedario admin ----------------------------------------------------------------------------------------------------------
date_default_timezone_set("Europe/Rome"); // setta il fusorario giusto
//---- calcolo e formattazione data inizio e fine per la Query sql -----
$giorni_del_mese = date("t");
$nrmese = date("M");
$anno= date("Y");
$giornoSettimanaUltimoDelMese = date("N",$ultimoDelMese);
if($giornoSettimanaUltimoDelMese != 7){
    $tmp = (string)(7-$giornoSettimanaUltimoDelMese) . $nrmese+1 . $anno;
    $ultimoTab = strtotime($tmp);
    $primoTab = strtotime("-34 day" ,$ultimoTab); 
}else{
    $tmp =  $giornoSettimanaUltimoDelMese . $nrmese . $anno;
    $ultimoTab = strtotime($tmp);
    $primoTab = strtotime("-34 day", $ultimoTab); 
}
$SQLultimoTab = date("Y-M-d", $ultimoTab)." 00:00:00";
$SQLprimoTab = date("Y-M-d", $primoTab)." 00:00:00";

$connessione->openDBConnection();
$prenotazioni = $connessione->getPrenotazioni($SQLprimoTab,$SQLULTIMOTab); // Query prenotazioni con dati clienti per visualizzare nel calendario 
$connessione->closeDBConnection();
$nonDisponibili = array();
$i = 0;
$considera = true;
foreach( $prenotazioni as $prenotaz ){ // per non dover cambiare tutto il codice ricostruisco le non disponibilità dalle prenotazioni
    if($considera){
        $nonDisponibili[$i] = $prenotaz["Data_Ora_Inizio"];
        if($prenotaz[6] == false){
            $nonDisponibili[$i+1] = false;
            $considera = false;
        }
    }else{$considera = true;}
    
}
//-------- creazione calendario ----------------------------------------------------------------------
Class Giorno {
    public $stringData;
    public $data;
    public $disponibilitàSlot = [true,true,true,true,true,true,true,true,true];
    public $datiPrenotazioni;
    public $disponibile;
    public $disponibile3h;
    public const ORARIO_SLOT = [" 08:30:00"," 10:00:00"," 11:30:00"," 13:00:00"," 14:30:00"," 16:00:00"," 17:30:00"," 19:00:00"," 20:30:00"];

    function __construct($data){
        $this->data = $data;
        $this->stringData = date("Y-M-d", $data);
    }
}

// popolamento array giorni e slot con le disponibilità o non disponibilità
$giorno = array();
$k = 0;
for($i=0;$i<35;$i++){ // per ogni giorno visualizzato sul calendario
    $giorno[$i] = new Giorno(strtotime("+$i day",$primoTab));
    $giorno[$i]->disponibile = true;
    $tuttiSlotOccupati = true; 
    for($j=0;$j<9;$j++){ // per ogni slot del giorno
        while($dataora > startotime($nonDisponibili[$k]) && $k < count($nonDisponibili)-1){ //scorro tutti gli slot non disponibili precedenti a quello che sto testando senza uscire dall'array
            $k++;
        }
        if($dataora == startotime($nonDisponibili[$k])){ // imposto la disponibilità o meno dello slot
            $giorno[$i]->disponibilitàSlot[$j] = false;
            $giorno[$i]->dati_prenotazioni[$j] = ["nome" => $prenotazioni["nome"],"indirizzo" => $prenotazioni["indirizzo"],"email" => $prenotazioni["email"],"cel" => $prenotazioni["cel"],"note" => $prenotazioni["note"],"tipo" => $prenotazioni["tipo"]];
            if($j==8 && $tuttiSlotOccupati){$giorno[$i]->disponibile = false;}
        }
        else{
            $tuttiSlotOccupati = false;
            $giorno[$i]->disponibilitàSlot[$j] = true;
            $giorno[$i]->dati_prenotazioni[$j] = ["nome" => "","indirizzo" =>"","email" =>"","cel" =>"","note" =>"","tipo" =>""];
        }
    }
}
// ---------- creazione stringhe HTML per i 2 calendari -----------------
$mesi = array("Gennaio", "Febbraio", "Marzo", "Aprile", "Maggio", "Giugno", "Luglio", "Agosto", "Settembre", "Ottobre", "Novembre", "Dicembre");

$stringaCalendario = "<ol id='calendario'>
                        <li id='mese'><time datetime='$anno-$nrmese'>$anno-$mesi[$nrmese]</time></li>
                        <li class='labelgiorno'><abbr title='Lunedì'>Lun</abbr></li>
                        <li class='labelgiorno'><abbr title='Martedì'>Mar</abbr></li>
                        <li class='labelgiorno'><abbr title='Mercoledì'>Mer</abbr></li>
                        <li class='labelgiorno'><abbr title='Giovedì'>Gio</abbr></li>
                        <li class='labelgiorno'><abbr title='Venerdì'>Ven</abbr></li>
                        <li class='labelgiorno'><abbr title='Sabato'>Sab</abbr></li>
                        <li class='labelgiorno'><abbr title='Domenica'>Dom</abbr></li>";
$stringaSlot = "<ol>";
for($i=0;$i<35;$i++){ // per ogni giorno visualizzato sul calendario
    if($giorno[$i]->disponibile){
        $stringaCalendario .= "<li class='giorno1h'><a href=#slot1hGiorno$i><time datetime=".$giorno[$i]->stringData.">$i</time></a></li>";
    }else{
        $stringaCalendario .= "<li class='giorno1h'><time datetime=".$giorno[$i]->stringData.">$i</time></li>";
    }
    $stringaSlot .= "<li id='slot1hGiorno$i'><ol>"; // calendario slot 1,5 h
    for($j=0;$j<9;$j++){ // per ogni slot
        if($giorno[$i]->disponibilitàSlot[$j]){
            $stringaSlot .= "<li class='slotDisponibile'><button type='button' disabled>disponibile</button></li>";
        }else{
            $stringaSlot .= "<li class='slotNonDisponibile'><button type='button'
                                data-dataOra=\"".$giorno[$i]->stringData.$giorno[$i]->ORARIO_SLOT[$j]."\"
                                data-nome=\"".$giorno[$i]->datiPrenotazioni["nome"]."\"  
                                data-email=\"".$giorno[$i]->datiPrenotazioni["email"]."\"   
                                data-cel=\"".$giorno[$i]->datiPrenotazioni["cel"]."\"
                                data-note=\"".$giorno[$i]->datiPrenotazioni["note"]."\"
                                data-indirizzo=\"".$giorno[$i]->datiPrenotazioni["indirizzo"]."\"
                                data-tipo=\"".$giorno[$i]->datiPrenotazioni["tipo"]."\"
                                onclick='javascript:mostraDati_cliente()' ontouchend='javascript:mostraDati_cliente()'>
                                <p>nome : ".$giorno[$i]->datiPrenotazioni["nome"]."</p><p>indirizzo : ".$giorno[$i]->datiPrenotazioni["indirizzo"]."</p>
                                </button> </li>";
        }
    }
    $stringaSlot .= "</ol></li>";

}
$stringaCalendario .="</ol>";
$stringaSlot .= "</ol>";

$paginaHTML = str_replace("{calendario}", $stringaCalendario, $paginaHTML);
$paginaHTML = str_replace("{slot}", $stringaSlot, $paginaHTML);

// --------------------------- cancella prenotazione --------------------------------------
$messaggiForm = "";

if(isset($_POST['submit']) && empty($_POST['modifica'])){
    if (!empty($_POST['data']) && !empty($_POST['ora'])){
        controllaInput($_POST['data']); 
        controllaInput($_POST['ora']); 
        if(preg_match("/^(20[0-9][0-9]-[0-9][0-9]-[0-9][0-9] [0-9][0-9]:[0-9][0-9]:00)$/", $_POST['slot'])){
            if(!empty($_POST['scelta-luogo'])){
                $tipo = controllaADomicilio($_POST['scelta-luogo'],$messaggiForm);
                controllaInput($_POST['tipo']);
                $connessione->openDBConnection();
                $connessione->cancellaPrenotazione($_POST['data'].$_POST['ora'],$tipo); // Query prenotazioni con dati clienti per visualizzare nel calendario 
                $connessione->closeDBConnection();
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


// ----------------------------- modifica prenotazione -------------------------------
$dataOraInizio= "";
$note="";
$email="";
$cel="";
$indirizzo="";
$nome="";
$checkedDomicilio="";
$checkedStudio="";
if(isset($_POST['submit']) && !empty($_POST['modifica'])){ //campo nascosto che viene riempito tramite javascript priMA DI INVIARE IL FORM se l' intento è modificare uno slot
    
    // controlli input 
    $dataOraInizio = controllaDataOra($_POST['data'].$_POST['ora'] ,$messaggiForm); // problabilmente sarà da formattare bene

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
    $connessione->closeDBConnection();
}
$paginaHTML = str_replace("{checkedDomicilio}", $checkedDomicilio, $paginaHTML);
$paginaHTML = str_replace("{checkedStudio}", $checkedStudio, $paginaHTML);
$dataOraArray = explode(" ",$dataOraInizio);
$paginaHTML = str_replace("{data}", $dataOraArray[0], $paginaHTML);
$paginaHTML = str_replace("{ora}", $dataOraArray[1], $paginaHTML);
$paginaHTML = str_replace("{nome}", $nome, $paginaHTML);
$paginaHTML = str_replace("{email}", $email, $paginaHTML);
$paginaHTML = str_replace("{cel}", $cel, $paginaHTML);
$paginaHTML = str_replace("{indirizzo}", $indirizzo, $paginaHTML);
$paginaHTML = str_replace("{note}", $note, $paginaHTML);
$paginaHTML = str_replace("{messaggiForm}", $messaggiForm, $paginaHTML);

$paginaHTML = str_replace("{messaggiForm}", $messaggiForm, $paginaHTML);

echo $paginaHTML;
?>


