<?php 
// inclusione del file di connessione
require_once ("connessione.php");
//creazione della prima parte della pagina
date_default_timezone_set("Europe/Rome"); // setta il fusorario giusto
//-------------------------------- calcolo e formattazione data inizio e fine per la Query sql ---------------
$giorni_del_mese = date("t");
$mese = date("M");
$anno= date("Y");
$primoDelMese = strtotime("1 $mese $anno");
$ultimoDelMese = strtotime("$giorniDelMese $mese $anno");
$giornoSettimanaUltimoDelMese = date("N",$ultimoDelMese);
if($giornoSettimanaUltimoDelMese != 7){
    $ultimoTab = strtotime( 7-$giornoSettimanaUltimoDelMese $mese+1 $anno);
    $primoTab = strtotime("-34 day" $ultimoTab); 
}else{
    $ultimoTab = strtotime( $giornoSettimanaUltimoDelMese $mese $anno);
    $primoTab = strtotime("-34 day" $ultimoTab); 
}
$SQLultimoTab = date("Y-M-d", $ultimoTab)." 00:00:00";
$SQLprimoTab = date("Y-M-d", $primoTab)." 00:00:00";
//-----------------------------------------------------Query con output slot disponibili da visualizzare nel calendario -------------------------------------------
if (!$result = $connessione->query("SELECT Data_Ora_Inizio FROM Disponibilità WHERE Data_Ora_Inizio>= $SQLprimoTab AND Data_Ora_Inizio<= $SQLULTIMOTab"))
{
    echo "Errore della query: " . $connessione->error . ".";
    exit();
}
else{
    $dataOraSlotTab = array();
    if($result->num_rows > 0){ // TABELLA NON ACCESSIBILE!! (basta il campo data sotto?)
        echo"<table><thead><th>Lun</th><th>Mar</th><th>Mer</th><th>Gio</th><th>Ven</th><th>Sab</th><th>Dom</th></thead><tbody>";
    //------------ popolamento array con tutte le date e ora di inizio per tutti gli slot esistenti in un mese -----------------
        $orarioSlot = array(" 08:30:00"," 10:00:00"," 11:30:00"," 13:00:00"," 14:30:00"," 16:00:00"," 17:30:00","19:00:00"," 20:30:00");
        $giorno = $primoTab;
        for($i=0;$i<35;$i++){
            $giorno = strtotime("+$i day" $giorno); 
            for($j=0,$j<9,$j++){
                $data = date("Y-M-d",$giorno);
                $dataOraSlotTab[i][j][0] = $data.$orarioSlot[$j];
            }
        }
        //-------------------- assegnamento true/false in base alla disponibilità a tutti gli slot e a tutti i giorni visualizzati (senza considerare i trattamenti a domicilio)-------------
        $disponibile = $result->fetch_array(MYSQLI_ASSOC);
        $giornoDisponibile=array();
        for($i=0;$i<35;$i++){
            for($j=0,$j<9,$j++){
                if($dataOraSlotTab[$i][$j][0] == $disponibile["Data_Ora_Inizio"]){
                    $dataOraSlotTab[$i][$j][1] = true;
                    $giornoDisponibile[$i] = true;
                    $disponibile["Data_Ora_Inizio"] = $result->fetch_array(MYSQLI_ASSOC);
                }
                else{
                    $dataOraSlotTab[$i][$j][1] = false;
                    if($j==8){
                        $giornoDisponibile[$i] = false;
                    }
                }
            }
        }
        // ------------------ creazione tabella del mese con info sui singoli slot negli attributi data- (in modo da ridurre le query e trasferire il carico lato client) ----------------------------------------------
        $giorno = $primoTab;
        for($i=0;$i<5;$i++){ // colonne
            echo"<tr>";
            for($j=0;$j<7;$j++){// righe (giorni della settimana)
                $giorno = strtotime("+$i day" $giorno);
                $tmp = date("d", $giorno);
                echo"<td data-slot0= '$dataOraSlotTab[($i+1)*7+($j)][0][1]' 
                data-slot1= '$dataOraSlotTab[($i+1)*7+($j)][1][1]'
                data-slot2= '$dataOraSlotTab[($i+1)*7+($j)][2][1]'
                data-slot3= '$dataOraSlotTab[($i+1)*7+($j)][3][1]'
                data-slot4= '$dataOraSlotTab[($i+1)*7+($j)][4][1]'
                data-slot5= '$dataOraSlotTab[($i+1)*7+($j)][5][1]'
                data-slot6= '$dataOraSlotTab[($i+1)*7+($j)][6][1]'
                data-slot7= '$dataOraSlotTab[($i+1)*7+($j)][7][1]'
                data-slot8= '$dataOraSlotTab[($i+1)*7+($j)][8][1]'
                >";
                if($giornoDisponibile[($i+1)*7+($j)]){ //equivale a for x = 0--> 35
                    echo"<button type='button' onclick"">$tmp</button>"
                }else{
                    echo$tmp;
                }
                echo"</td>";
            }
            echo"</tr>";
        }

    $result->free(); // liberaz. risorse occupate dalla query
    echo "</tbody></table>"
    } else{
        echo"non ci sono slot disponibili questo mese";
    }
}
$connessione->close();

?>





















