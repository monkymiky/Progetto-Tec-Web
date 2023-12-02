<?php // selezione di dati da una tabella con MySQLi
// inclusione del file di connessione
require_once ("connessione.php");


$user = ; // 
$pass =;

if (!$result= $connessione->query("SELECT Data_Ora_Inizio FROM Prenotazioni WHERE Username ='$user' AND Pass = '$pass'")){
    echo "Errore della query: " . $connessione->error . ".";
    exit();
}else if($result->num_rows != 0){ // utente esistente
    // creazione pagina ADMIN.HTML
} else{
    echo"username o password errati";
}
$result->free();
// chiusura della connessione
$connessione->close();
//fine pagina
…
?>


