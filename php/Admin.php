<?php // selezione di dati da una tabella con MySQLi
// inclusione del file di connessione
require_once ("connessione.php");
//creazione della prima parte della pagina


$slot = array(); // $slot[Data_Ora_inizio] 
$azione = 0;

if($azione = 0){// cancella prenotazione
    if ( count($slot) == 1){
        if (!$result = $connessione->query("DELETE FROM Prenotazioni WHERE Data_Ora_Inizio = '$slot[0]'")){
            echo "Errore della query : " . $connessione->error . ".";
            exit();
        }
    }else {
        echo"non è possibile cancellare le prenotazioni di più slot insieme, selezionane solo 1.";
    }
}


if($azione = 1){//imposta non disponibile
    $prenotata = false;
    foreach($slot as $s) {// vengono fatte molte query ma è un evento relativamente raro siccome può farlo solo l'admin
            $tmp = startotime("-90 min",$s);
            $slotprecedente = date("Y:M:d h:i:s");
            if (!$result= $connessione->query("SELECT Data_Ora_Inizio FROM Prenotazioni WHERE Data_Ora_Inizio ='".$s."' 
            OR Data_Ora_Inizio ='".$slotprecedente."' AND Tipo ='false'")){
                echo "Errore della query: " . $connessione->error . ".";
                exit();
            }else if($result->num_rows != 0){
                $prenotata=true;
            }
        }
    if(!$prenotata){
        foreach($slot as $s) {
                if (!$result = $connessione->query("DELETE FROM Disponibilità WHERE Data_Ora_Inizio = '".$s."';")){
                    echo "Errore della query : " . $connessione->error . ".";
                    exit();
                }
            }
        }
    }else{echo"operazione annullata : non è possibile impostare come non disponibile uno slot gia prenotato.";}


if($azione = 2){// imposta disponibile
    foreach($slot as $s) {
        $tmp = startotime("-90 min",$s);
        $slotprecedente = date("Y:M:d h:i:s");
        if (!$result= $connessione->query("SELECT Data_Ora_Inizio FROM Prenotazioni WHERE Data_Ora_Inizio ='".$s."') OR Data_Ora_Inizio ='".$slotprecedente."' AND Tipo ='false'")){
            echo "Errore della query:" . $connessione->error . ".";
            exit();
        }else if($result->num_rows == 0){ // se non è gia prenotato inserisce lo slot im Disponibilità
            if (!$result = $connessione->query("INSERT INTO Disponibilità (Data_Ora_Inizio) VALUES (".$s.")")){
                echo "Errore della query :". $connessione->error ;
                exit();
            }
        }
        }
    }
    $result->free();
// chiusura della connessione
$connessione->close();
//fine pagina
…
?>


