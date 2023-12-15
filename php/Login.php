<?php // selezione di dati da una tabella con MySQLi
// inclusione del file di connessione
require_once ("connessione.php");
require_once ("controlli.php");
// html : <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);? >"> (togli lo spazio dopo il ?) IMPORTANTE ANTI ATTACCHI

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST["user"])&&isset($_POST["admin"])){
      $user = controlla($_POST["user"]) ; // 
    $pass = controlla($_POST["admin"]);
    if (!$result= $connessione->query("SELECT Data_Ora_Inizio FROM Prenotazioni WHERE Username ='$user' AND Pass = '$pass'")){
        echo "Errore della query: " . $connessione->error . ".";
        exit();
    }else if($result->num_rows != 0){ // utente esistente
      header('Location: localhost/admin.php') ; // ATTENZIONE DA MODIFICARE PRIMA DELLA CONSEGNA !!??
    } else{
        echo"username o password errati";
    }
    $result->free(); 
    }else{
      // pagina login + <p>login o password non inserita</p>
    }
  }// altrimenti pagina con form vuoto

// chiusura della connessione
$connessione->close();
//fine pagina
?>


