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
echo "Connessione fallita (". mysqli_connect_errno()
. "): " . mysqli_connect_error();
exit();
} 