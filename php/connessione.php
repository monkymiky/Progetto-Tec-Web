<?php
    namespace DB;
    const MESSAGGIO_SHOW_ERR = "Scusa, il sito ha avuto un problema. Riprova tra qualche minuto oppure 
    contattami tramite il <a href=\"/html/contatti.html\">form di contatto</a> riportando il seguente 
    errore. Potrebbe essere d'aiuto ai tecnici!";
    const MESSAGGIO_DBERR = "Scusa, il sito ha avuto un problema nel contattare il Database. Riprova tra qualche minuto, se il problema persiste 
    contattami tramite il <a href=\"/html/contatti.html\">form di contatto</a>";
    
    class DBAccess {
        
        //accesso server/phpMyAdmin uni
        private const HOST_DB = "localhost:3306";
        private const DATABASE_NAME = "mnesler";
        private const USERNAME = "mnesler";
        private const PASSWORD = "Feif1eeng2Ea7nei";

        private $connessione;
        private $state = false;
        
        public function openErrorPage(String $s = MESSAGGIO_DBERR, Exception $e = NULL){ 
            // se gli passo un messaggio mostra quello, se gli passo un eccezzione mostra l'errore con messaggio standard, se passo entrambi mostra entrambi
            $paginaHTML = file_get_contents("../html/DBerrorTemplate.html");
            if($e == NULL){ 
                $messaggioErrore ="<p class=\"errorMessage\">".$s."</p>";
            }else{
                $messaggioErrore ="<p class=\"errorMessage\">".$s." Se mi contatterai riporta il seguente 
                errore. Grazie in anticipo, potrebbe essere d'aiuto ai tecnici per risolvere il problema! </p><p>messaggio d'errore:".$e->getMessage()."</p>";
            }
            $paginaHTML = str_replace("{messaggioErrore}", $messaggioErrore, $paginaHTML);
            echo $paginaHTML;
            exit;
        }

        public function openDBConnection(){
            try{ 
                $this -> connessione = mysqli_connect(self::HOST_DB, self::USERNAME, self::PASSWORD, self::DATABASE_NAME);
                $this -> connessione ->set_charset('utf8');
            }
            catch(Exception $ex){
                $this->openErrorPage("1");
                return false;
            }
            $this -> state = true;
            return true;
        }

        public function closeConnection(){
            mysqli_close($this -> connessione);
            $this -> state = false;
        }

        public function getState(){return $this->state;}
        
        public function getNonDisponibili($inizio,$fine){
            try{
                $result = $this->connessione->query(
                    "SELECT Data_Ora_Inizio FROM NonDisponibili WHERE Data_Ora_Inizio BETWEEN '$inizio' AND '$fine';");
            }
            catch(Exception $ex){
                $this->openErrorPage("2");
            }
            return $result -> fetch_all(MYSQLI_NUM); // ritorna un array numerico (non associativo) con tutti gli slot non disponibili
        }

        public function prenota($nome, $email, $cel, $indirizzo, $dataora , $tipo, $note){
            if($tipo == "0")$tipo = 0;
            else $tipo = 1;
        // se l'utente è gia presente nel db aggiunge solo la prenotazione, altrimenti entrambi. gestisce gli errori.
        // se l'email non è presente e fallisce la seconda query di inserimento (prenotazione) cancella i dati inseriti
            try{
                $result= $this->connessione->query("SELECT Email FROM Dati_cliente WHERE Email='$email'");
                if ($result->num_rows == 0){ // nuovo cliente
                    $result->free();
                    $this->connessione->query("INSERT INTO Dati_cliente (Email,Cellulare,Indirizzo,Nome) VALUES ('$email','$cel','$indirizzo','$nome');");
                }
                $this->connessione->query("INSERT INTO Prenotazioni (Data_Ora_Inizio,Tipo,InfoAggiuntive,cliente) VALUES ('$dataora', '$tipo', '$note', '$email');");
                $this->connessione->query("INSERT INTO NonDisponibili (Data_Ora_Inizio) VALUES ('$dataora');");
                
                if($tipo == 1){ // elimino anche la tupla che identifica lo slot sucessivo 
                    $timestampslot2 = strtotime("+90 min" ,strtotime($dataora));
                    $slot2= date("Y-m-d H:i:s", $timestampslot2);
                    $this->connessione->query("INSERT INTO NonDisponibili (Data_Ora_Inizio) VALUES ('$slot2');");
                }
            }catch(Exception $e){
                $this->openErrorPage("C'èstato un problema nella prenotazione. 
                Porebbe essere che qualcuno ti abbia soffiato il posto mentre lo sceglievi, quindi per prima cosa prova nuovamente. 
                Se il problema persiste contattami tramite il <a href='/html/contatti.html'>form di contatto</a> spiegandomi il problema.");
                return false;
            }
            return true;
        }

        public function getPrenotazioni($inizio,$fine){
            try{
                $result = $this->connessione->query(
                    "SELECT Data_Ora_Inizio, nome, indirizzo, email, cellulare, InfoAggiuntive, tipo 
                    FROM Prenotazioni 
                    JOIN Dati_cliente 
                    ON Prenotazioni.cliente = Dati_cliente.Email
                    WHERE Data_Ora_Inizio 
                    BETWEEN '$inizio' AND '$fine';");
            }
            catch(Exception $ex){
                $this->openErrorPage("3");
            }
            $matrice = array();
            $i = 0;
            foreach ($result as $row) {
                $matrice[$i] = $row;  $i++;
            }
            return $matrice; // ritorna un array numerico di array associativi con tutte le prenotazioni
        }

        public function cancellaPrenotazione($inizio, $tipo){
            try{
                $this->connessione->query("DELETE FROM Prenotazioni WHERE Data_Ora_Inizio = '$inizio'");
                $this->connessione->query("DELETE FROM NonDisponibili WHERE Data_Ora_Inizio = '$inizio'");
                if($tipo){
                    $inizio = date("Y-m-d H:i:s",strtotime("+90 min" ,strtotime($inizio))); // aggiunge ad inixio 1,5h
                    $this->connessione->query("DELETE FROM NonDisponibili WHERE Data_Ora_Inizio = '$inizio'");
                }
            }catch(Exception $ex){
                $this->openErrorPage($ex->getMessage());
            }
        }

        public function modificaPrenotazione($oldEmail,$nome,$email,$cel,$indirizzo,$dataora, $tipo, $note){
            $tipo = (int)$tipo;
            try{
                $this->connessione->begin_transaction();
                $this->connessione->query("UPDATE Dati_cliente
                                            SET `Email` = '$email'
                                            WHERE `Email` = '$oldEmail';");
                $this->connessione->query(
                    "UPDATE `Dati_cliente` 
                    SET  `Cellulare` = '$cel', `Indirizzo` = '$indirizzo', `Nome` = '$nome' 
                    WHERE `Dati_cliente`.`Email` = '$email'");
                $this->connessione->query(
                    "UPDATE `Prenotazioni` 
                    SET  `Tipo` = '$tipo', `InfoAggiuntive` = '$note',`Cliente` = '$email'
                    WHERE `Prenotazioni`.`Data_Ora_Inizio` = '$dataora'
                    AND EXISTS (SELECT 1 FROM `Dati_cliente` WHERE `Email` = '$email');");
                $this->connessione->commit();
                if($tipo == 1){ // elimino anche la tupla che identifica lo slot sucessivo 
                    $slot2= date("Y-m-d H:i:s", strtotime("+90 min" ,strtotime($dataora))); // aggiungo 1,5h
                }
            }catch(Exception $e){
                $this->openErrorPage("4");
                return false;
            }
            return true;
        }

        public function login($user, $password){
            try{
                $result = $this->connessione->query("SELECT * FROM Login WHERE Username ='$user' AND Pass = '$password'");
                if ($result->num_rows == 1){
                    return true;
                }else{
                    return false;
                }
            }
            catch(Exception $ex){
                $this->openErrorPage("5");
            }
        }

    }
?>