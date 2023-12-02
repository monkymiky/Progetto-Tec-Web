<?php // selezione di dati da una tabella con MySQLi
// inclusione del file di connessione
require_once ("connessione.php");
//creazione della prima parte della pagina
…
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

if (!$result1= $connessione->query("SELECT Email FROM Dati_cliente WHERE Email='$email'")){
    echo "Errore della query: " . $connessione->error . ".";
    exit();
}else if ($result1->num_rows == 0){ //email non presente nel DB
        if (!$result1 = $connessione->query("INSERT INTO Dati_cliente (Email,Cellulare,Indirizzo,Nome) VALUES ($email,$cel,$indirizzo,$nome);") 
        || !$result2 = $connessione->query("INSERT INTO Prenotazioni (Data_Ora_Inizio,Tipo,InfoAggiuntive,cliente) VALUES ($DataOraInizio,$tipo,$Infoaggiuntive, $email);")){
            
            echo "Errore della query: " . $connessione->error . ".";
            exit();
        }else if($result1){
                if (!$result3 = $connessione->query("DELETE FROM Dati_cliente WHERE email = '$email';")){
                    echo "Errore della query per il runback delle modifiche fatte prima del primo errore ($email): " . $connessione->error . ".";
                    exit();
                }
            }//else l'errore è sulla prima query --> non serve fare nulla.
         // elimino la tupla nella tabella Disponibilità con quell'orario
        if (!$result3 = $connessione->query("DELETE FROM Disponibilità WHERE Data_Ora_Inizio = $DataOraInizio;")){
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
        if (!$result2 = $connessione->query("INSERT INTO Prenotazioni (Data_Ora_Inizio,Tipo,InfoAggiuntive,cliente) VALUES ();")){
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


