<?php
require_once ("connessione.php");
USE DB\DBAccess;
$connessione = new DBAccess();
ini_set('display_errors',1);
ini_set("display_startup_errors",1);
setlocale(LC_ALL, 'it_IT');
date_default_timezone_set("Europe/Rome");// setta il fusorario giusto

Class Giorno {
    public $stringData;
    public $data;
    public $disponibilitàSlot = [true,true,true,true,true,true,true,true,true];
    public $datiPrenotazioni;
    public $disponibile;
    public $disponibile3h;
    public $ORARIO_SLOT = [" 08:30:00"," 10:00:00"," 11:30:00"," 13:00:00"," 14:30:00"," 16:00:00"," 17:30:00"," 19:00:00"," 20:30:00"];

    function __construct($data){
        $this->data = $data;
        $this->stringData = date("Y-M-d", $data);
    }
}

Class Calendario{
    
    private $admin;
    private $giorno;
    private $mesi = array("Gennaio", "Febbraio", "Marzo", "Aprile", "Maggio", "Giugno", "Luglio", "Agosto", "Settembre", "Ottobre", "Novembre", "Dicembre");
    private $stringaCalendario;
    private $stringaSlot;

    function __construct(bool $admin,int $mese){
        $this->admin = $admin;
        $adesso =  strtotime("+$mese mounth", date("Y-m")."-01"); // aggiunge $mese mesi alla data odierna
        $giorniDelMese = date("t");
        $nrMese = date("m");
        $anno= date("Y");
        $ultimoDelMese = strtotime($anno."-".$nrMese."-".$giorniDelMese);
        $giornoSettimanaUltimoDelMese = date("N",$ultimoDelMese);
        if($giornoSettimanaUltimoDelMese != "7"){
            $ultimoTab = strtotime(7-(int)$giornoSettimanaUltimoDelMese . $nrMese+1 . $anno);
            $primoTab = strtotime("-34 day" ,$ultimoTab); 
        }else{
            $ultimoTab = strtotime($giornoSettimanaUltimoDelMese."-". $nrMese ."-". $anno);
            $primoTab = strtotime("-34 day", $ultimoTab); 
        }
        $SQLultimoTab = date("Y-m-d", $ultimoTab)." 00:00:00";
        $SQLprimoTab = date("Y-m-d", $primoTab)." 00:00:00";

        $nonDisponibili = array();
        $this->giorno = array();
        $k = 0;
        $slotPrecedenteDisponibile = false;

        if($admin){
            $connessione->openDBConnection();
            $prenotazioni = $connessione->getPrenotazioni($SQLprimoTab,$SQLultimoTab); // Query prenotazioni con dati clienti per visualizzare nel calendario 
            $connessione->closeConnection();

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
            if(count($nonDisponibili) == 0){$nonDisponibili[0] = "2000-00-00 00:00:00";} //il caso in cui sono tutti disponibili è gestito 
            for($i=0;$i<35;$i++){ // per ogni giorno visualizzato sul calendario
                $this->$giorno[$i] = new Giorno(strtotime("+$i day",$primoTab));
                $this->$giorno[$i]->disponibile = false;
                $tuttiSlotOccupati = false; 
                for($j=0;$j<9;$j++){ // per ogni slot del giorno
                    while($k < count($nonDisponibili)-1 && strtotime($this->$giorno[$i]->stringData.$this->$giorno[$i]->ORARIO_SLOT[$j]) > strtotime($nonDisponibili[$k]) ){ //scorro tutti gli slot non disponibili precedenti a quello che sto testando senza uscire dall'array
                        $k++;
                    }
                    if(strtotime($this->$giorno[$i]->data.$this->$giorno[$i]->ORARIO_SLOT[$j]) == strtotime($nonDisponibili[$k])){ // imposto la disponibilità o meno dello slot
                        $this->$giorno[$i]->disponibilitàSlot[$j] = true;
                        $this->$giorno[$i]->dati_prenotazioni[$j] = ["nome" => $prenotazioni["nome"],"indirizzo" => $prenotazioni["indirizzo"],"email" => $prenotazioni["email"],"cel" => $prenotazioni["cel"],"note" => $prenotazioni["note"],"tipo" => $prenotazioni["tipo"]];
                        if($j==8 && $tuttiSlotOccupati){$this->$giorno[$i]->disponibile = true;}
                    }
                    else{
                        $tuttiSlotOccupati = true;
                        $this->$giorno[$i]->disponibilitàSlot[$j] = false;
                        $this->$giorno[$i]->dati_prenotazioni[$j] = ["nome" => "","indirizzo" =>"","email" =>"","cel" =>"","note" =>"","tipo" =>""];
                    }
                }
            }
        }else{
            $connection->openDBConnection();
            $nonDisponibili = $connection->getNonDisponibili($SQLprimoTab,$SQLultimoTab);//Query slot non disponibili per visualizzare nel calendario ------------
            $connection->closeConnection();

            for($i=0;$i<35;$i++){ // per ogni giorno visualizzato sul calendario
                $giorno[$i] = new Giorno(strtotime("+$i day",$primoTab));
                if($giorno[$i]->data >= strtotime("+2 day")){ // se il giorno testato è dopo domani (si può prenotare al minimo 2 giorni prima.) -------------------> da testare
                    $giorno[$i]->disponibile = false;
                    $giorno[$i]->disponibile3h = true;
                    $tuttiSlotOccupati = false; 
                    for($j=0;$j<9;$j++){ // per ogni slot del giorno
                        while($dataora > startotime($nonDisponibili[$k]) && $k < count($nonDisponibili)-1){ //scorro tutti gli slot non disponibili precedenti a quello che sto testando senza uscire dall'array
                            $k++;
                        }
                        if($dataora == startotime($nonDisponibili[$k])){ // imposto la disponibilità o meno dello slot
                            $giorno[$i]->disponibilitàSlot[$j] = true;
                            if($j==8 && $tuttiSlotOccupati){$giorno[$i]->disponibile = true;}
                        }
                        else{
                            $tuttiSlotOccupati = true;
                            $giorno[$i]->disponibilitàSlot[$j] = false;
                            if($slotPrecedenteDisponibile == false){$giorno[$i]->disponibile3h = false;}
                            $slotPrecedenteDisponibile = false;
                        }
                    }
                }
                else{ // giorno intero non disponibile
                    $giorno[$i]->disponibile = true;
                    $giorno[$i]->disponibile3h = true;
                    for($j=0;$j<9;$j++){ // per ogni slot del giorno
                        $giorno[$i]->disponibilitàSlot[$j] = true;
                    }
                }
            }
        }
        $this->setStringaCalendario();
        $this->setStringaSlot();
    }

    private function setStringaCalendario(){
        
        $this->stringaCalendario = "    
                                        <p id='mese'>
                                            <input type='submit' name='action' value ='".$mese-1."' form='formPrenota'>
                                            <time datetime='".$anno."-".($nrMese-1)."'>".$anno."-".($this->$mesi[$nrMese-1])."</time>
                                            <input type='submit' name='action' value ='".$mese+1."' form='formPrenota'>
                                        </p>
                                        <ol id='calendario'>
                                            <li class='labelgiorno'><abbr title='Lunedì'>Lun</abbr></li>
                                            <li class='labelgiorno'><abbr title='Martedì'>Mar</abbr></li>
                                            <li class='labelgiorno'><abbr title='Mercoledì'>Mer</abbr></li>
                                            <li class='labelgiorno'><abbr title='Giovedì'>Gio</abbr></li>
                                            <li class='labelgiorno'><abbr title='Venerdì'>Ven</abbr></li>
                                            <li class='labelgiorno'><abbr title='Sabato'>Sab</abbr></li>
                                            <li class='labelgiorno'><abbr title='Domenica'>Dom</abbr></li>";
        if($this->admin){
            for($i=0;$i<35;$i++){ // per ogni giorno visualizzato sul calendario
                $tuttodisponibile = true;
                foreach ($giorno[$i]->disponibilitàSlot as $disp){
                    if(!$disp) {$tuttodisponibile = false;}
                }
                if(!$tuttodisponibile){
                    $this->stringaCalendario .= "<li class='giorno1h'><a href=#slot1hGiorno$i><time datetime=".$giorno[$i]->stringData.">$i</time></a></li>";
                }else{
                    $this->stringaCalendario .= "<li class='giorno1h'><time datetime=".$giorno[$i]->stringData.">$i</time></li>";
                }    
            }
        }
        else{ // utente non amministratore
            for($i=0;$i<35;$i++){ // per ogni giorno visualizzato sul calendario
                if($giorno[$i]->disponibile){
                    $this->stringaCalendario .= "<li class='giorno1h'><a href=#slot1hGiorno$i><time datetime=".$giorno[$i]->stringData.">$i</time></a></li>";
                }else{
                    $this->stringaCalendario .= "<li class='giorno1h'><time datetime=".$giorno[$i]->stringData.">$i</time></li>";
                }
                if($giorno[$i]->disponibile3h){
                    $this->stringaCalendario .= "<li class='giorno3h'><a href=#slot3hGiorno$i><time datetime=".$giorno[$i]->stringData.">$i</time></a></li>";
                }else{
                    $this->stringaCalendario .= "<li class='giorno3h'><time datetime=".$giorno[$i]->stringData.">$i</time></li>";
                }
            }
        }
        $this->stringaCalendario .="</ol>";
    }

    private function setStringaSlot(){
        $this->stringaSlot = "<ol>";

        if($this->admin){
            for($i=0;$i<35;$i++){ // per ogni giorno visualizzato sul calendario
                $this->stringaSlot .= "<li id='slot1hGiorno$i'><ol>"; // calendario slot 1,5 h
                for($j=0;$j<9;$j++){ // per ogni slot
                    if($giorno[$i]->disponibilitàSlot[$j]){
                        $this->stringaSlot .= "<li class='slotDisponibile'><button type='button' disabled>disponibile</button></li>";
                    }else{
                        if($giorno[$i]->datiPrenotazioni != NULL){ 
                            $this->stringaSlot .= " <li class='slotNonDisponibile'><button type='button'
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
                        else{ // caso in cui il giorno è precedente ad oggi ma non era prenotato
                            $this->stringaSlot .= "<li class='slotDisponibile'><button type='button' disabled>disponibile</button></li>";
                        }
                    }
                }
                $this->stringaSlot .= "</ol></li>";
            }
        }

        else{ // utente non amministratore
            for($i=0;$i<35;$i++){ // per ogni giorno visualizzato sul calendario
                $this->stringaSlot .= "<li id='slot1hGiorno$i'><ol>"; // calendario slot 1,5 h
                for($j=0;$j<9;$j++){ // per ogni slot
                    if($giorno[$i]->disponibilitàSlot[$j]){
                        $this->stringaSlot .= "<li class='slotDisponibile'><button type='button' onclick='javascript:riempiData()' ontouchend='javascript:riempiData()'>disponibile</button> </li>";
                    }else{
                        $this->stringaSlot .= "<li class='slotNonDisponibile'><button type='button' disabled> occupato </button> </li>";
                    }
                }
                $this->stringaSlot .= "</ol></li>";

                $this->stringaSlot .= "<li id='slot3hGiorno$i'><ol>"; // calendario slot 3 h
                $libero = true; // per ogni slot guarda se il sucessivo è libero, se si è disponibile uno slot da 3 ore e il sucessivo viene disabilitato.
                for($j=0;$j<9;$j++){ // per ogni slot
                    if($j!=8){
                        if($libero && $giorno[$i]->disponibilitàSlot[$j] && $giorno[$i]->disponibilitàSlot[$j+1]){
                            $this->stringaSlot .= "<li class='slotDisponibile3h'><button type='button' onclick='javascript:riempiData()' ontouchend='javascript:riempiData()'>disponibile</button> </li>";
                            $libero = false;
                        }else{
                            $this->stringaSlot .= "<li class='slotNonDisponibile'><button type='button' disabled> occupato </button> </li>";
                            $libero = true;
                        }
                    }else{
                        $this->stringaSlot .= "<li class='slotNonDisponibile'><button type='button' disabled> occupato </button> </li>";
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