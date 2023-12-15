<?php //Connessione al DBMS e selezione del database.
// definizione parametri di connessione
$host="localhost";
$user="admin";
$password="admin";// a caso
$db="";
// stringa di connessione al DBMS e
//creazione istanza della classe MySQLi
$connessione = new mysqli($host, $user, $password, $db);
// verifica su eventuali errori di connessione
if (mysqli_connect_errno()) {
echo "Connessione fallita (". mysqli_connect_errno() // ritorna 0 se è andato tutto bene
. "): " . mysqli_connect_error();
exit();
} 

if(!$connessione->set_charset('utf8')){
    printf("non è possibile usare UTF8: %s\n", $connessione->error);
}else{
    printf("set di caratteri: %s\n",$connessione->character_set_name() );
}