<?php
// la lunghezza dei trattini ------------- indica che quel commento si riferisce alla sezione di codice seguente, 
// che è chiusa da una lunghezza di trattini equivalente
require_once ("connessione.php");
USE DB\DBAccess;

ini_set('display_errors',1);
ini_set("display_startup_errors",1);
setlocale(LC_ALL, 'it_IT');
date_default_timezone_set("Europe/Rome");// setta il fusorario giusto

class Giorno {
    public $stringData;
    public $numero;
    public $data;
    public $disponibilitàSlot = [true,true,true,true,true,true,true,true,true];
    public $dati_prenotazioni;
    public $disponibile;
    public $disponibile3h;
    public $ORARIO_SLOT = [" 08:30:00"," 10:00:00"," 11:30:00"," 13:00:00"," 14:30:00"," 16:00:00"," 17:30:00"," 19:00:00"," 20:30:00"];

    function __construct($data){
        $this->data = $data;
        $this->stringData = date("Y-m-d", $data);
        $this->numero = date("d", $data);
    }
}

class Calendario{
    
    private $admin; // sto creando il calendario per l'admin? true - false
    private $giorno;
    private $mesi = ["Januar", "Februar", "Marz", "April", "Mai", "Juni", "Juli", "August", "September", "Oktober", "November", "Dezember"];
    private $stringaCalendario;
    private $stringaSlot;
    private $nrMese;
    private $anno;
    private $mesiInPiu;

    function __construct(bool $admin,int $mese){
        $this->mesiInPiu = $mese; // l' utente può andare avanti o indietro rispetto al mese corrente nella visualizzazione dei mesi nel calendario
        $connessione = new DBAccess();
        $this->admin = $admin; 
        // calcolo date -------------------------------------------------------------------------------------
        $oggi = date("Y-m-d", time());
        // aggiunge $mesiInPiu mesi alla data odierna ------------------
        $piuMese = explode("-", $oggi);
        $piuMese[1] = $piuMese[1]+$this->mesiInPiu;
        if($piuMese[1] > 12){
            $piuMese[1] = $piuMese[1]-12; $piuMese[0] = $piuMese[0]+1;
        }else{
            if($piuMese[1] < 0){
                $piuMese[1] = 12+$piuMese[1];$piuMese[0] = $piuMese[0]-1;
            }
        }
        if(gettype($piuMese[1]) == "integer"){
            if($piuMese[1] <10){$piuMese[1] = "0".(string)$piuMese[1];}
            else{$piuMese[1] = (string)$piuMese[1];}
        }
        $oggiPiuMesiAggiunti = ((string)$piuMese[0])."-". $piuMese[1]."-01";
        $timestampOggiPiuMA = strtotime($oggiPiuMesiAggiunti);
        // ------------------------------------------------------------
        $giorniDelMese = date("t",$timestampOggiPiuMA);
        $this->nrMese = date("m",$timestampOggiPiuMA);
        $this->anno= date("Y",$timestampOggiPiuMA);
        $ultimoDelMese = strtotime($this->anno."-".$this->nrMese."-".$giorniDelMese);
        $giornoSettimanaUltimoDelMese = date("N",$ultimoDelMese);
        if($giornoSettimanaUltimoDelMese != "7"){
            if($this->nrMese != 12){$meseprox = $this->nrMese+1;$annoultimoTab= $this->anno;}
            else{$meseprox = 1;$annoultimoTab = $this->anno+1;}
            $ultimoTab = strtotime($annoultimoTab."-".$meseprox."-".(7-$giornoSettimanaUltimoDelMese));
        }else{
            $ultimoTab = $ultimoDelMese;
        }
        $primoTab = strtotime("-41 day", $ultimoTab); 
        $SQLultimoTab = date("Y-m-d", $ultimoTab)." 00:00:00";
        $SQLprimoTab = date("Y-m-d", $primoTab)." 00:00:00";
        // ---------------------------------------------------------------------------------------------------
        $nonDisponibili = array();
        $this->giorno = array();
        $k = 0;

        if($admin){
            $connessione->openDBConnection();
            $prenotazioni = $connessione->getPrenotazioni($SQLprimoTab,$SQLultimoTab); // Query prenotazioni con dati clienti per visualizzare nel calendario 
            $nonDisponibili = $connessione->getNonDisponibili($SQLprimoTab,$SQLultimoTab);//Query slot non disponibili per visualizzare nel calendario ------------
            $connessione->closeConnection();

            if(count($nonDisponibili) == 0){$nonDisponibili[0][0] = "2000-00-00 00:00:00";} //il caso in cui sono tutti disponibili è gestito 
            for($i=0;$i<42;$i++){ // per ogni giorno visualizzato sul calendario
                $this->giorno[$i] = new Giorno(strtotime("+$i day",$primoTab));
                $this->giorno[$i]->prenotato = true;
                $tuttiSlotLiberi = false; 
                for($j=0;$j<9;$j++){ // per ogni slot del giorno
                    $loSlotValutatoESucessivoAlProssimoSlotPrenotato = strtotime($this->giorno[$i]->stringData ." ". $this->giorno[$i]->ORARIO_SLOT[$j]) > strtotime($nonDisponibili[$k][0]) ;
                    while($k < count($nonDisponibili)-1 && $loSlotValutatoESucessivoAlProssimoSlotPrenotato){ //scorro tutti gli slot non disponibili precedenti a quello che sto testando senza uscire dall'array
                        $k++; // questa penotazione riguarda i giorni/slot precedenti, forse la prossima prenotazione riguarda questo slot o i sucessivi
                        $loSlotValutatoESucessivoAlProssimoSlotPrenotato = strtotime($this->giorno[$i]->stringData ." ". $this->giorno[$i]->ORARIO_SLOT[$j]) > strtotime($nonDisponibili[$k][0]) ;
                    }
                    $loSlotValutatoESucessivoAlProssimoSlotPrenotato = strtotime($this->giorno[$i]->stringData ." ". $this->giorno[$i]->ORARIO_SLOT[$j]) > strtotime($nonDisponibili[$k][0]) ;

                    $slotValutatoEPrenotato = strtotime($this->giorno[$i]->stringData ." ". $this->giorno[$i]->ORARIO_SLOT[$j]) == strtotime($nonDisponibili[$k][0]);
                    if($slotValutatoEPrenotato){ 

                        
                        $this->giorno[$i]->disponibilitàSlot[$j] = false;
                        $z=0; 
                        $prenotazioneEDiQuestoSlot = strtotime($this->giorno[$i]->stringData ." ". $this->giorno[$i]->ORARIO_SLOT[$j]) == strtotime($prenotazioni[$z]["Data_Ora_Inizio"]);
                        while ( $z<count($prenotazioni) -1 && !$prenotazioneEDiQuestoSlot ){
                            $z++;// scorro tutte le prenotazioni fino a trovare quella che si riferisce allo slot non disponibile
                            $prenotazioneEDiQuestoSlot = strtotime($this->giorno[$i]->stringData ." ". $this->giorno[$i]->ORARIO_SLOT[$j]) == strtotime($prenotazioni[$z]["Data_Ora_Inizio"]);
                        }

                        $this->giorno[$i]->dati_prenotazioni[$j] = ["nome" => $prenotazioni[$z]["nome"],"indirizzo" => $prenotazioni[$z]["indirizzo"],"email" => $prenotazioni[$z]["email"],"cell" => $prenotazioni[$z]["cellulare"],"note" => $prenotazioni[$z]["InfoAggiuntive"],"tipo" => $prenotazioni[$z]["tipo"]];
                        $this->giorno[$i]->disponibile = false;
                    }
                    else{
                        $tuttiSlotOccupati = false;
                        $this->giorno[$i]->disponibilitàSlot[$j] = true;
                        $this->giorno[$i]->dati_prenotazioni[$j] = ["nome" => "","indirizzo" =>"","email" =>"","cell" =>"","note" =>"","tipo" =>""];
                        if($j==8 && !$tuttiSlotOccupati){$this->giorno[$i]->disponibile = true;}
                    }
                }
            }
        }else{ // utente non admin
            $connessione->openDBConnection();
            $nonDisponibili = $connessione->getNonDisponibili($SQLprimoTab,$SQLultimoTab);//Query slot non disponibili per visualizzare nel calendario ------------
            $connessione->closeConnection();

            if(count($nonDisponibili) == 0){$nonDisponibili[0] = "2000-00-00 00:00:00";} //il caso in cui sono tutti disponibili è gestito 

            for($i=0;$i<42;$i++){ // per ogni giorno visualizzato sul calendario
               $this->giorno[$i] = new Giorno(strtotime("+$i day",$primoTab));
                if($this->giorno[$i]->data >= strtotime("+1 day")){ // se il giorno testato è dopo domani (si può prenotare al minimo 2 giorni prima.) -------------------> da testare
                   $this->giorno[$i]->disponibile = true; //parto assumendo che almeno uno slot sia disponibile
                   $this->giorno[$i]->disponibile3h = false; //non so però se ci sono 2 slot consecutivi disponibili
                    $tuttiSlotOccupati = false; 
                    for($j=0;$j<9;$j++){ // per ogni slot del giorno
                        $sting_time = date("Y-m-d", $this->giorno[$i]->data)." ".$this->giorno[$i]->ORARIO_SLOT[$j];
                        while(
                            strtotime($sting_time) >  
                            strtotime($nonDisponibili[$k][0]) 
                            && 
                            $k < count($nonDisponibili)-1){ //scorro tutti gli slot non disponibili precedenti a quello che sto testando senza uscire dall'array
                            $k++;
                        }
                        if(strtotime($this->giorno[$i]->stringData . $this->giorno[$i]->ORARIO_SLOT[$j]) == strtotime($nonDisponibili[$k][0])){ // se lo slot non è disponibile
                            $this->giorno[$i]->disponibilitàSlot[$j] = false; 
                            if($j==8 && $tuttiSlotOccupati){ // se è l'ultimo slot e tutti gli altri sono non disponibili
                                $this->giorno[$i]->disponibile = false; //imposto l'intero giorno come non disponibile
                            }
                        }
                        else{ // lo slot è disponibile
                            $tuttiSlotOccupati = false;
                            $this->giorno[$i]->disponibilitàSlot[$j] = true;
                            if($j!=0 && $this->giorno[$i]->disponibilitàSlot[$j-1] == true){ // se non è il primo slot e quello precedente è disponibile
                                $this->giorno[$i]->disponibile3h = true; // segno che durante il giorno è disponibile almeno uno slot da 3h 
                            }
                        }
                    }
                }
                else{ // giorno intero non disponibile
                    $this->giorno[$i]->disponibile = false;
                    $this->giorno[$i]->disponibile3h = false;
                    for($j=0;$j<9;$j++){ // per ogni slot del giorno
                       $this->giorno[$i]->disponibilitàSlot[$j] = false;
                    }
                }
            }
        }
        $this->setStringaCalendario();
        $this->setStringaSlot();
    }

    private function setStringaCalendario(){
        //per essere compliant alla sintassi prevista per il tag <time>
        $stringaMese = $this->nrMese-1; 
        if (strlen($stringaMese)==1) {$stringaMese="0".$stringaMese;}

        $this->stringaCalendario = "     <ol id='calendario'>
                                            <li id='anno'> 
                                            <time datetime='".$this->anno."'>".$this->anno."</time>
                                            </li>
                                            
                                            <li><button type='button' id='buttonIndietro' name='cambioMese' aria-label='Gehen Sie zum vorherigen Monat' onclick='changeMounth(".($this->mesiInPiu-1).")'> &lt; </button></li>
                                            <li id='mese'><time datetime='".($this->anno)."-".$stringaMese."'>".($this->mesi[(int)$this->nrMese-1])."</time></li>
                                            <li><button type='button' id='buttonAvanti' name='cambioMese' aria-label='Gehen Sie zum nächsten Monat' onclick='changeMounth(".($this->mesiInPiu+1).")'> &gt; </button></li>
                                            <li class='labelgiorno'><abbr title='Montag'>Mon</abbr></li>
                                            <li class='labelgiorno'><abbr title='Dienstag'>Die</abbr></li>
                                            <li class='labelgiorno'><abbr title='Mittwoch'>Mit</abbr></li>
                                            <li class='labelgiorno'><abbr title='Donnerstag'>Don</abbr></li>
                                            <li class='labelgiorno'><abbr title='Freitag'>Fre</abbr></li>
                                            <li class='labelgiorno'><abbr title='Samstag'>Sam</abbr></li>
                                            <li class='labelgiorno'><abbr title='Sonntag'>Son</abbr></li> ";

        if($this->admin){
            for($i=0;$i<42;$i++){ // per ogni giorno visualizzato sul calendario
                $tuttodisponibile = true;
                foreach ($this->giorno[$i]->disponibilitàSlot as $disp){
                    if(!$disp) {
                        $tuttodisponibile = false;
                    }
                }
                if(!$tuttodisponibile){  // Linea 216
                    $this->stringaCalendario .= "<li class='giorno1h'><a href=#slot1hGiorno$i onclick='emphasize(this)'><time datetime=".$this->giorno[$i]->stringData.">".$this->giorno[$i]->numero."</time></a></li>";
                } else {
                    $this->stringaCalendario .= "<li class='giorno1h'><time datetime=".$this->giorno[$i]->stringData.">".$this->giorno[$i]->numero."</time></li>";
                }    
            }
        }

        else{ // utente non amministratore
            for($i=0;$i<42;$i++){ // per ogni giorno visualizzato sul calendario
                if($this->giorno[$i]->disponibile){
                    $this->stringaCalendario .= "<li class='giorno1h'><a href=#slot1hGiorno$i onclick='emphasize(this)'><time datetime=".$this->giorno[$i]->stringData.">".$this->giorno[$i]->numero."</time></a></li>";
                }else{
                    $this->stringaCalendario .= "<li class='giorno1h'><time datetime=".$this->giorno[$i]->stringData.">".$this->giorno[$i]->numero."</time></li>";
                }
                if($this->giorno[$i]->disponibile3h){
                    $this->stringaCalendario .= "<li class='giorno3h'><a href=#slot3hGiorno$i onclick='emphasize(this)'><time datetime=".$this->giorno[$i]->stringData.">".$this->giorno[$i]->numero."</time></a></li>";
                }else{
                    $this->stringaCalendario .= "<li class='giorno3h'><time datetime=".$this->giorno[$i]->stringData.">".$this->giorno[$i]->numero."</time></li>";
                }
            }
        }
        $this->stringaCalendario .="</ol>";
    }

    private function setStringaSlot(){
        if($this->admin){
            $this->stringaSlot = "<ol id='slotList'>";
            for($i=0;$i<42;$i++){ // per ogni giorno visualizzato sul calendario
                $this->stringaSlot .= "<li id='slot1hGiorno$i'><ol>"; // calendario slot 1,5 h
                for($j=0;$j<9;$j++){ // per ogni slot
                    if($this->giorno[$i]->disponibilitàSlot[$j]){
                        $this->stringaSlot .= "<li class='slotDisponibile'><button type='button' disabled>verfügbar</button></li>";
                    }else{
                        if($this->giorno[$i]->dati_prenotazioni[$j] != NULL){ 
                            $class = '';
                            if($this->giorno[$i]->dati_prenotazioni[$j] ['tipo'] == '1') $class = "class ='aDomicilio' ";
                            $this->stringaSlot .= " <li class='slotNonDisponibile'>
                                                        <button type='button'
                                                        data-dataOra='".$this->giorno[$i]->stringData . $this->giorno[$i]->ORARIO_SLOT[$j]."'
                                                        data-nome='".$this->giorno[$i]->dati_prenotazioni[$j] ["nome"]."'  
                                                        data-email='".$this->giorno[$i]->dati_prenotazioni[$j] ["email"]."'  
                                                        data-cell='".$this->giorno[$i]->dati_prenotazioni[$j] ["cell"]."'
                                                        data-note='".$this->giorno[$i]->dati_prenotazioni[$j] ["note"]."'
                                                        data-indirizzo='".$this->giorno[$i]->dati_prenotazioni[$j] ["indirizzo"]."'
                                                        data-tipo='".$this->giorno[$i]->dati_prenotazioni[$j] ["tipo"]."'
                                                        onclick='mostraDati_cliente(this);'".$class.">
                                                        ".$this->giorno[$i]->dati_prenotazioni[$j] ["nome"].
                                                        "</button> 
                                                    </li>";
                        }
                        else{ // caso in cui il giorno è precedente ad oggi ma non era prenotato
                            $this->stringaSlot .= "<li class='slotDisponibile'><button type='button' disabled>verfügbar</button></li>";
                        }
                    }
                }
                $this->stringaSlot .= "</ol></li>";
            }
        }

        else{ // utente non amministratore
            $this->stringaSlot = "<ol id='slotList'>";
            for($i=0;$i<42;$i++){ // per ogni giorno visualizzato sul calendario
                $this->stringaSlot .= "<li id='slot1hGiorno$i'><ol>"; // calendario slot 1,5 h
                for($j=0;$j<9;$j++){ // per ogni slot
                    if($this->giorno[$i]->disponibilitàSlot[$j]){
                        $this->stringaSlot .= "<li class='slotDisponibile'><button type='button' onclick='javascript:riempiData(this)' >verfügbar</button> </li>";
                    }else{
                        $this->stringaSlot .= "<li class='slotNonDisponibile'><button type='button' disabled> beschäftigt </button> </li>";
                    }
                }
                $this->stringaSlot .= "</ol></li>";

                $this->stringaSlot .= "<li id='slot3hGiorno$i'><ol>"; // calendario slot 3 h
                $libero = true; // per ogni slot guarda se il sucessivo è libero, se si è disponibile uno slot da 3 ore e il sucessivo viene disabilitato.
                for($j=0;$j<9;$j++){ // per ogni slot
                    if($j!=8){
                        if($libero && $this->giorno[$i]->disponibilitàSlot[$j] && $this->giorno[$i]->disponibilitàSlot[$j+1]){
                            $this->stringaSlot .= "<li class='slotDisponibile3h'><button type='button' onclick='javascript:riempiData(this)'>verfügbar</button> </li>";
                            $libero = false;
                        }else{
                            $this->stringaSlot .= "<li class='slotNonDisponibile'><button type='button' disabled> beschäftigt </button> </li>";
                            $libero = true;
                        }
                    }else{
                        $this->stringaSlot .= "<li class='slotNonDisponibile'><button type='button' disabled> beschäftigt </button> </li>";
                            $libero = true;
                    }
                }
                $this->stringaSlot .= "</ol></li>";
            }
        }

        $this->stringaSlot .= "</ol>";
    }

    public function getStringaSlot(){return $this->stringaSlot;}

    public function getStringaCalendario(){return $this->stringaCalendario;}

    }
