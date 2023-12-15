<?php // selezione di dati da una tabella con MySQLi
// inclusione del file di connessione
require_once ("connessione.php");
//creazione della prima parte della pagina
// esecuzione della query per la selezione dei record
$DataOraInizio= "2023-12-1 08:30:00";
$tipo= true;
$Infoaggiuntive="";

$email="";
$cel="";
$indirizzo="";
$nome="";
// se l'utente è gia presente nel db aggiunge solo la prenotazione, altrimenti entrambi. gestisce gli errori.
// se l'email non è presente e fallisce la seconda query di inserimento (prenotazione) cancella i dati inseriti

try{
    $result= $connessione->query("SELECT Email FROM Dati_cliente WHERE Email='$email'");
    if ($result->num_rows == 0){ // nuovo cliente
        $result->free();
        $connessione->query("INSERT INTO Dati_cliente (Email,Cellulare,Indirizzo,Nome) VALUES ($email,$cel,$indirizzo,$nome);");
    }
    $connessione->query("INSERT INTO Prenotazioni (Data_Ora_Inizio,Tipo,InfoAggiuntive,cliente) VALUES ();");
    $connessione->query("DELETE FROM Disponibilità WHERE Data_Ora_Inizio = $DataOraInizio;");
    
    if($tipo == true){ // elimino anche la tupla che identifica lo slot sucessivo 
        $timestampslot2 = strtotime("+90 min" ,$DataOraInizio);
        $slot2= date("Y/M/d h:i:s", $timestampslot2);
        $connessione->query("DELETE FROM Disponibilità WHERE Data_Ora_Inizio = $slot2 ;");
    }
}catch(Exception $e){
    //reindirizzamento  a pag errore
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}
// chiusura della connessione
$connessione->close();
//fine pagina
…
?>


