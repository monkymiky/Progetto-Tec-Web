<?php // selezione di dati da una tabella con MySQLi
// inclusione del file di connessione
require_once ("connessione.php"); // SBAGLIATO? 
//creazione della prima parte della pagina
// esecuzione della query per la selezione dei record
class Ordine{ // dati sensibili, non devono poter essere inseriti arbitrariamente !!!!
    public $quantità;
    public $tipo;
}
$gift_card = array();

foreach( $gift_card as $ordine){
    for($i=0;$i<$ordine.$quantità;$i++){
        $sha256 = hash('sha256', rand(0, 1000000000000).'nasdviljsabdvl%/&)(sa dvsj vsjib&R%((%£$%dvsihdvbs234593459723894jjbxacòlmla<poojiwef kvds l'.rand(0, 1000000000000));
        if (!$result1= $connessione->query("INSERT INTO Gift_card (SHA_256,Utilizzi,Tipo) VALUES ($sha256,'0',$ordine.$tipo)"))
        {
    echo "Errore della query: " . $connessione->error . ".";
        exit();
        }else{
            echo"l'acquisto è andato a buon fine!";
        }
    }
}

// chiusura della connessione
$connessione->close();
//fine pagina
…
?>


