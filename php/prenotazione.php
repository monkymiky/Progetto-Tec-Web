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
if (!$result1= $connessione->query("SELECT Email FROM Dati_cliente WHERE Email='$email'"))
{
    echo "Errore della query: " . $connessione->error . ".";
        exit();
}else if ($result1->num_rows = 0)
    {
        if (!$result1 = $connessione->query("INSERT INTO Dati_cliente (Email,Cellulare,Indirizzo,Nome) VALUES ($email,$cel,$indirizzo,$nome);") 
        || !$result2 = $connessione->query("INSERT INTO Prenotazioni (Data_Ora_Inizio,Tipo,InfoAggiuntive,cliente) VALUES ();"))
        {
            if($result1){
                if (!$result3 = $connessione->query("DELETE FROM table_name WHERE condition;"))
                {echo "Errore della query per il runback delle modifiche fatte prima del primo errore ($email): " . $connessione->error . ".";
                exit();
                }
            }//else l'errore è sulla prima query --> non devo eliminare nulla.
            echo "Errore della query: " . $connessione->error . ".";
            exit();
        }
    }else{// email gia presente
        if (!$result2 = $connessione->query("INSERT INTO Prenotazioni (Data_Ora_Inizio,Tipo,InfoAggiuntive,cliente) VALUES ();"))
        {
            echo "Errore della query: " . $connessione->error . ".";
            exit();
        }
    }

// chiusura della connessione
$connessione->close();
//fine pagina
…
?>


