<?php // selezione di dati da una tabella con MySQLi
// inclusione del file di connessione
require_once ("connessione.php");
//creazione della prima parte della pagina

$giorno = array(); // array di giorni
$slot = array(); // $slot[giorno][Data_Ora_inizio]
$azione =;

if($azione = 0){// cancella prenotazione
    if (count($giorno)==1 && count($slot) == 1){
        if (!$result = $connessione->query("DELETE FROM Prenotazioni WHERE Data_Ora_Inizio = '".$giorno[0].$slot[0][0]."'")){
            echo "Errore della query  (".$giorno[0].$slot[0][0]."): " . $connessione->error . ".";
            exit();
        }
    }else {
        echo"non è possibile cancellare le prenotazioni di più slot insieme, selezionane solo 1."
    }
}

if($azione = 1){//imposta non disponibile
    $prenotata = false;
    for ($i=0;$i<count($giorno);$i++){ // vengono fatte molte query ma è un evento relativamente raro siccome può farlo solo l'admin
        for($j=0;$j<9;$j++){
            if (!$result= $connessione->query("SELECT Data_Ora_Inizio FROM Prenotazioni WHERE Data_Ora_Inizio ='".$giorno[0].$slot[0][0]."'")){
                echo "Errore della query: " . $connessione->error . ".";
                exit();
            }else if($result->num_rows != 0){
                $prenotata=true;
            }
        }
    }
    if(!$prenotata){
        for ($i=0;$i<count($giorno);$i++){
            for($j=0;$j<9;$j++){
                if (!$result = $connessione->query("DELETE FROM Disponibilità WHERE Data_Ora_Inizio = '".$giorno[0].$slot[0][0]."';")){
                    echo "Errore della query per il runback delle modifiche fatte prima del primo errore (".$giorno[0].$slot[0][0]."): " . $connessione->error . ".";
                    exit();
                }
            }
        }
    }else{echo"operazione annullata : non è possibile impostare come non disponibile uno slot gia prenotato.";}
}
if($azione = 2){// imposta disponibile
    for ($i=0;$i<count($giorno);$i++){
        for($j=0;$j<9;$j++){
            if (!$result= $connessione->query("SELECT Data_Ora_Inizio FROM Prenotazioni WHERE Data_Ora_Inizio ='".$giorno[$i].$slot[$i][$j]."')"){
                echo "Errore della query:" . $connessione->error . ".";
                exit();
            }else if($result->num_rows == 0){ // se non è gia prenotato inserisce lo slot im Disponibilità
                if (!$result = $connessione->query("INSERT INTO Disponibilità (Data_Ora_Inizio) VALUES (".$giorno[$i].$slot[$i][$j].")")){
                    echo "Errore della query :". $connessione->error .";
                    exit();
                }
            }
        }
    }
}



































// esecuzione della query per la selezione dei record
$DataOraInizio=;
$tipo=;
$Infoaggiuntive=;

$email=;
$cel=;
$indirizzo=;
$nome=;
// se l'utente è gia presente nel db aggiunge solo la prenotazione, altrimenti entrambi. gestisce gli errori.
// se l'email non è presente e fallisce la seconda query di inserimento (prenotazione) cancella i dati inseriti

if (!$result1= $connessione->query("SELECT Email FROM Dati_cliente WHERE Email='$email'"))
{
    echo "Errore della query: " . $connessione->error . ".";
        exit();
}else if ($result1->num_rows == 0) //email non presente nel DB
    {
        if (!$result1 = $connessione->query("INSERT INTO Dati_cliente (Email,Cellulare,Indirizzo,Nome) VALUES ($email,$cel,$indirizzo,$nome);") 
        || !$result2 = $connessione->query("INSERT INTO Prenotazioni (Data_Ora_Inizio,Tipo,InfoAggiuntive,cliente) VALUES ($DataOraInizio,$tipo,$Infoaggiuntive, $email);"))
        {
            
            echo "Errore della query: " . $connessione->error . ".";
            exit();
        }else{
            if($result1){
                if (!$result3 = $connessione->query("DELETE FROM Dati_cliente WHERE email = '$email';"))
                {echo "Errore della query per il runback delle modifiche fatte prima del primo errore ($email): " . $connessione->error . ".";
                exit();
                }
            }//else l'errore è sulla prima query --> non serve fare nulla.
        }
         // elimino la tupla nella tabella Disponibilità con quell'orario
        if (!$result3 = $connessione->query("DELETE FROM Disponibilità WHERE Data_Ora_Inizio = $DataOraInizio;"))
        {
            echo "Errore della query per il runback delle modifiche fatte prima del primo errore ($DataOraInizio): " . $connessione->error . ".";
            exit();
        }
        if($tipo == true){ // elimino anche la tupla che identifica lo slot sucessivo 
            $timestampslot2 = strtotime("+90 min" ,$DataOraInizio);
            $slot2= date("Y/M/d h:i:s", $timestampslot2);
            if (!$result3 = $connessione->query("DELETE FROM Disponibilità WHERE Data_Ora_Inizio = $slot2 ;")){
                echo "Errore della query per il runback delle modifiche fatte prima del primo errore ($slot2): " . $connessione->error . ".";
                exit();
            }
        }
    }else{// email presente nel DB
        if (!$result2 = $connessione->query("INSERT INTO Prenotazioni (Data_Ora_Inizio,Tipo,InfoAggiuntive,cliente) VALUES ();"))
        {
            echo "Errore della query: " . $connessione->error . ".";
            exit();
        }
    }
    $result1->free();
    $result2->free();
    $result3->free();
// chiusura della connessione
$connessione->close();
//fine pagina
…
?>


