<?php
    namespace DB;

    define(MESSAGGIO_RIPROVA, "Scusa, il sito ha avuto un problema. Riprova tra qualche minuto oppure 
    contattami tramite il <a href=\"../html/contatti.html\">form di contatto</a> riportando il seguente 
    errore. Potrebbe essere d'aiuto ai tecnici!");

    define(MESSAGGIO_SCUSA, "Scusa, il sito ha avuto un problema.
    Contattami tramite il <a href=\"../html/contatti.html\">form di contatto</a> riportando il seguente 
    errore, in modo che i tecnici possano risolvere l'errore. Ti contatterò appena il sito ritorna a funzionare.");
    
    class DBAccess {
        private const HOST_DB = "localhost";
        private const DATABASE_NAME = "mnesler";
        private const USERNAME = "mnesler";
        private const PASSWORD = "Feif1eeng2Ea7nei";

        private $connessione;
        private $state = false;

        public function openErrorPage(String $s, Exception $e){
            $paginaHTML = file_get_contents("../html/DBerrorTemplate.html");
            $messaggioErrore ="<p class=\"errorMessage\">".$s."messaggio d'errore:".$e->getMessage()."</p>";
            $paginaHTML = str_replace("{messaggioErrore}", $messaggioErrore, $paginaHTML);
            echo $paginaHTML;
        }

        public function openDBConnection(){
            try{
                $this -> connessione = mysqli_connect(self::HOST_DB, self::USERNAME, self::PASSWORD, self::DATABASE_NAME);
                $this -> connessione ->set_charset('utf8');
            }
            catch(Exception $ex){
                openErrorPage(MESSAGGIO_RIPROVA, $ex->getMessage());
                return false;
            }
            $this -> state = true;
            return true;
        }

        public function closeConnection(){
            mysqli_close($this -> connessione);
            $this -> state = false;
        }

        public function getState(){return this->state;}
        
        public function getNonDisponibili($inizio,$fine){
            try{
                $result = $this->connessione->query(
                    "SELECT Data_Ora_Inizio FROM NonDisponibili WHERE Data_Ora_Inizio>= $inizio AND Data_Ora_Inizio<= $fine");
            }
            catch(Exception $ex){
                openErrorPage(MESSAGGIO_RIPROVA, $ex->getMessage());
            }
            return $result -> fetch_all(MYSQLI_NUM); // ritorna un array numerico (non associativo) con tutti gli slot non disponibili
        }

        public function prenota($nome, $email, $cel, $indirizzo, $dataora , $tipo, $note){
        // se l'utente è gia presente nel db aggiunge solo la prenotazione, altrimenti entrambi. gestisce gli errori.
        // se l'email non è presente e fallisce la seconda query di inserimento (prenotazione) cancella i dati inseriti
            try{
                $result= $this->connessione->query("SELECT Email FROM Dati_cliente WHERE Email='$email'");
                if ($result->num_rows == 0){ // nuovo cliente
                    $result->free();
                    $this->connessione->query("INSERT INTO Dati_cliente (Email,Cellulare,Indirizzo,Nome) VALUES ($email,$cel,$indirizzo,$nome);");
                }
                $this->connessione->query("INSERT INTO Prenotazioni (Data_Ora_Inizio,Tipo,InfoAggiuntive,cliente) VALUES ($DataOraInizio, $tipo, $note, $email);");
                $this->connessione->query("INSERT INTO NonDisponibili (Data_Ora_Inizio) VALUES ($DataOraInizio);");
                
                if($tipo == true){ // elimino anche la tupla che identifica lo slot sucessivo 
                    $timestampslot2 = strtotime("+90 min" ,$DataOraInizio);
                    $slot2= date("Y/M/d h:i:s", $timestampslot2);
                    $this->connessione->query("INSERT INTO NonDisponibili (Data_Ora_Inizio) VALUES ($slot2);");
                }
            }catch(Exception $e){
                $this->connessione->openErrorPage(MESSAGGIO_RIPROVA,$e->getMessage());
                return false;
            }
            return true;
        }

        public function getPrenotazioni($inizio,$fine){
            try{
                $result = $this->connessione->query(
                    "SELECT Data_Ora_Inizio, nome, indirizzo, email, cel, note, tipo FROM NonDisponibili JOIN Dati_cliente WHERE Data_Ora_Inizio>= $inizio AND Data_Ora_Inizio<= $fine");
            }
            catch(Exception $ex){
                openErrorPage(MESSAGGIO_RIPROVA, $ex->getMessage());
            }
            $matrice = array();
            $i = 0;
            while($row = $result->fetch_assoc()){
                $matrice[$i] = $row;  
            }
            return $matrice; // ritorna un array numerico (non associativo) con tutti gli slot non disponibili
        }

        public function cancellaPrenotazione($inizio, $tipo){
            try{
                
            }catch(Exception $ex){
                openErrorPage(MESSAGGIO_RIPROVA, $ex->getMessage());
            }
        }

    }
?>