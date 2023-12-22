<?php
require_once ("connessione.php");
require_once ("controlli.php");
USE DB\DBAccess;
$connection = new DBAcces();
// ------------------------------------------------------------------------- form ---------------------------------------------------------------------------------------------
$messaggiForm = "";
if(isset($_POST['submit'])){
    $DataOraInizio= "";
    $tipo= false;
    $note="";
    
    $email="";
    $cel="";
    $indirizzo="";
    $nome="";
    // controlli input 
    if(!empty($_POST['slot'])){
        if(preg_match("/^(20[0-9][0-9]-[0-9][0-9]-[0-9][0-9] [0-9][0-9]:[0-9][0-9]:00)$/", $_POST['slot'])){
            $DataOraInizio = $_POST['slot'];
        }else{
            $messaggiForm .= "<p>il formato del campo slot deve essere aaaa-mm-gg hh-mm-ss</p>";
        }
    }
    else{
        $messaggiForm .= "<p>selezionare uno slot</p>";
    }

    if(empty($_POST['aDomicilio']) || filter_input(INPUT_POST,$_POST['aDomicilio'], FILTER_VALIDATE_BOOLEAN )){
		$messaggiForm .= "<p> il campo \"a domicilio\" deve essere specificato </p>";
	}else{
		if($_POST['aDomicilio'] == "1"){
			$checkedYes = "checked";
		}else{
			$checkedNo = "checked";
		}
	}

    if(!empty($_POST['note'])){
		controllaInput($_POST['note']);
		$note = $_POST['note'];
	}

    if(!empty($_POST['email'])){
		if(!filter_input(INPUT_POST,$_POST['email'], FILTER_VALIDATE_EMAIL)){
			$messaggiForm .= "<p>L'email inserito non è in un formato valido </p>";
		}else{
			$email = $_POST['email'];
		}
	}else{
		$messaggiForm .= "<p> il campo \"email\" deve essere specificato </p>";
	}

    if(!empty($_POST['cel'])){
        controllaInput($_POST['cel']);
        if(preg_match("/^([0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9])$ | ^(+[0-9][0-9] [0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9])$/", $_POST['cel'])){
            $cel = $_POST['cel'];
        }else{
            $messaggiForm .= "<p>il formato del campo cellulare deve essere 1112223333 oppure +11 2223334444</p>";
        }
    }
    else{
        $messaggiForm .= "<p>inserire il numero di cellulare</p>";
    }

    if(!empty($_POST['nome'])){
        controllaInput($_POST['nome']);
        if (preg_match("/^[a-zA-Z' ]*$/",$_POST['nome'])){
            $nome = $_POST['nome'];
        }else{
            $messaggiForm .= "<p>Il nome deve essere composto solo da lettere</p>";
        }
    }else{
        $messaggiForm .= "<p>Il nome deve essere specificato </p>";
    }

    if(!empty($_POST['indirizzo'])){
        controllaInput($_POST['indirizzo']);
        if (preg_match("/^[a-zA-Z0-9' ]*$/",$_POST['indirizzo'])){
            $indirizzo = $_POST['indirizzo'];
        }else{
            $messaggiForm .= "<p>L' indirizzo deve essere composto solo da lettere e numeri</p>";
        }
    }else{
        if($tipo){
            $messaggiForm .= "<p>L' indirizzo deve essere specificato in tutte le prenotazioni a domicilio</p>";
        }
    }

    $connessione->openDBConnection();
    if($connessione->prenota($nome,$email,$cel,$indirizzo,$dataOraInizio, $tipo, $note)){
        $messaggiForm .= "<h1 id='success'>Prenotazione effettuata con successo!! A presto :) </h1>";
    }
}

$paginaHTML = str_replace("{messaggiForm}", $messaggiForm, $paginaHTML);


//------------------------------------- clanedario ----------------------------------------------------------------------------------------------------------
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
if(!$connection->getState()){
    $connessione->openDBConnection();
}
$nonDisponibili = $connessione->getNonDisponibili($SQLprimoTab,$SQLULTIMOTab);//Query slot non disponibili per visualizzare nel calendario ------------
$connessione->closeDBConnection();
//-------- creazione calendario ----------------------------------------------------------------------
Class Giorno {
    public $stringData;
    public $data;
    public $disponibilitàSlot = [true,true,true,true,true,true,true,true,true];
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
$slotPrecedenteDisponibile = false;
for($i=0;$i<35;$i++){ // per ogni giorno visualizzato sul calendario
    $giorno[$i] = new Giorno(strtotime("+$i day",$primoTab));
    if($giorno[$i]->data >= strtotime("+2 day",date("Y-M-d"))){ // se il giorno testato è dopo domani (si può prenotare al minimo 2 giorni prima.) -------------------> da testare
        $giorno[$i]->disponibile = true;
        $giorno[$i]->disponibile3h = false;
        $tuttiSlotOccupati = true; 
        for($j=0;$j<9;$j++){ // per ogni slot del giorno
            while($dataora > startotime($nonDisponibili[$k]) && $k < count($nonDisponibili)-1){ //scorro tutti gli slot non disponibili precedenti a quello che sto testando senza uscire dall'array
                $k++;
            }
            if($dataora == startotime($nonDisponibili[$k])){ // imposto la disponibilità o meno dello slot
                $giorno[$i]->disponibilitàSlot[$j] = false;
                if($j==8 && $tuttiSlotOccupati){$giorno[$i]->disponibile = false;}
            }
            else{
                $tuttiSlotOccupati = false;
                $giorno[$i]->disponibilitàSlot[$j] = true;
                if($slotPrecedenteDisponibile == true){$giorno[$i]->disponibile3h = true;}
                $slotPrecedenteDisponibile = true;
            }
        }
    }
    else{ // giorno intero non disponibile
        $giorno[$i]->disponibile = false;
        $giorno[$i]->disponibile3h = false;
        for($j=0;$j<9;$j++){ // per ogni slot del giorno
            $giorno[$i]->disponibilitàSlot[$j] = false;
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
    if($giorno[$i]->disponibile3h){
        $stringaCalendario .= "<li class='giorno3h'><a href=#slot3hGiorno$i><time datetime=".$giorno[$i]->stringData.">$i</time></a></li>";
    }else{
        $stringaCalendario .= "<li class='giorno3h'><time datetime=".$giorno[$i]->stringData.">$i</time></li>";
    }
    $stringaSlot .= "<li id='slot1hGiorno$i'><ol>"; // calendario slot 1,5 h
    for($j=0;$j<9;$j++){ // per ogni slot
        if($giorno[$i]->disponibilitàSlot[$j]){
            $stringaSlot .= "<li class='slotDisponibile'><button type='button' onclick='javascript:riempiData()' ontouchend='javascript:riempiData()'>disponibile</button> </li>";
        }else{
            $stringaSlot .= "<li class='slotNonDisponibile'><button type='button' disabled> occupato </button> </li>";
        }
    }
    $stringaSlot .= "</ol></li>";

    $stringaSlot .= "<li id='slot3hGiorno$i'><ol>"; // calendario slot 3 h
    $libero = true; // per ogni slot guarda se il sucessivo è libero, se si è disponibile uno slot da 3 ore e il sucessivo viene disabilitato.
    for($j=0;$j<9;$j++){ // per ogni slot
        if($libero && $giorno[$i]->disponibilitàSlot[$j] && $giorno[$i]->disponibilitàSlot[$j+1]){
            $stringaSlot .= "<li class='slotDisponibile3h'><button type='button' onclick='javascript:riempiData()' ontouchend='javascript:riempiData()'>disponibile</button> </li>";
            $libero = false;
        }else{
            $stringaSlot .= "<li class='slotNonDisponibile'><button type='button' disabled> occupato </button> </li>";
            $libero = true;
        }
    }
    $stringaSlot .= "</ol></li>";

}
$stringaCalendario .="</ol>";
$stringaSlot .= "</ol>";

$paginaHTML = str_replace("{calendario}", $stringaCalendario, $paginaHTML);
$paginaHTML = str_replace("{slot}", $stringaSlot, $paginaHTML);

echo $paginaHTML;

?>