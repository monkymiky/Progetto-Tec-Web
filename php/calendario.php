<?php 
// inclusione del file di connessione
require_once ("connessione.php");
//creazione della prima parte della pagina
date_default_timezone_set("Europe/Rome"); // setta il fusorario giusto
//-------------------------------- calcolo e formattazione data inizio e fine per la Query sql ---------------
$giorni_del_mese = date("t");
$nrmese = date("M");
$anno= date("Y");
$primoDelMese = strtotime("1 $nrmese $anno");
$ultimoDelMese = strtotime("$giorniDelMese $nrmese $anno");
$giornoSettimanaUltimoDelMese = date("N",$ultimoDelMese);
if($giornoSettimanaUltimoDelMese != 7){
    $tmp = (string)(7-$giornoSettimanaUltimoDelMese) . $nrmese+1 . $anno;
    $ultimoTab = strtotime($tmp);
    $primoTab = strtotime("-34 day" ,$ultimoTab); 
}else{
    $tmp =  $giornoSettimanaUltimoDelMese . $nrmese . $anno;
    $ultimoTab = strtotime($tmp);
    $primoTab = strtotime("-34 day", $ultimoTab); 
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
    if($result->num_rows > 0){
        $mesi = array("Gennaio", "Febbraio", "Marzo", "Aprile", "Maggio", "Giugno", "Luglio", "Agosto", "Settembre", "Ottobre", "Novembre", "Dicembre");
        echo"<ol id='calendario'>
                <li id='mese'><time datetime='$anno-$nrmese'>$anno-$mesi[$nrmese]</time></li>
                <li><abbr title='Lunedì'>Lun</abbr></li>
                <li><abbr title='Martedì'>Mar</abbr></li>
                <li><abbr title='Mercoledì'>Mer</abbr></li>
                <li><abbr title='Giovedì'>Gio</abbr></li>
                <li><abbr title='Venerdì'>Ven</abbr></li>
                <li><abbr title='Sabato'>Sab</abbr></li>
                <li><abbr title='Domenica'>Dom</abbr></li>";
    //------------ popolamento array con tutte le date e ora di inizio per tutti gli slot esistenti in un mese -----------------
        $orarioSlot = array(" 08:30:00"," 10:00:00"," 11:30:00"," 13:00:00"," 14:30:00"," 16:00:00"," 17:30:00","19:00:00"," 20:30:00");
        $giorno = $primoTab;
        for($i=0;$i<35;$i++){
            $giorno = strtotime("+$i day",$giorno); 
            for($j=0;$j<9;$j++){
                $data = date("Y-M-d",$giorno);
                $dataOraSlotTab[i][j][0] = $data.$orarioSlot[$j];
            }
        }
        //-------------------- assegnamento true/false in base alla disponibilità a tutti gli slot e a tutti i giorni visualizzati (senza considerare i trattamenti a domicilio)-------------
        $disponibile = $result->fetch_array(MYSQLI_ASSOC);
        $giornoDisponibile=array();
        for($i=0;$i<35;$i++){
            for($j=0;$j<9;$j++){
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
        // ------------------ creazione tabella del mese (grid) con info sui singoli slot negli attributi data- (in modo da ridurre le query e trasferire il carico lato client) ----------------------------------------------
        $giorno = $primoTab;
        for($i=0;$i<35;$i++){ // colonne
                $giorno = strtotime("+$i day", $giorno);
                $tmp = date("d", $giorno);
                echo"<li 
                data-slot0= '$dataOraSlotTab[$i][0][1]' 
                data-slot1= '$dataOraSlotTab[$i][1][1]'
                data-slot2= '$dataOraSlotTab[$i][2][1]'
                data-slot3= '$dataOraSlotTab[$i][3][1]'
                data-slot4= '$dataOraSlotTab[$i][4][1]'
                data-slot5= '$dataOraSlotTab[$i][5][1]'
                data-slot6= '$dataOraSlotTab[$i][6][1]'
                data-slot7= '$dataOraSlotTab[$i][7][1]'
                data-slot8= '$dataOraSlotTab[$i][8][1]'
                >";
                $data = date("Y-M-d",$giorno);
                if($giornoDisponibile[$i]){
                    echo"<button type='button' onclick''><time datetime='$data'>$tmp</time></button>";
                }else{
                    echo"<button type='button' disabled><time datetime='$data'>$tmp</time></button>";
                }
                echo"</li>";
        }
    $result->free(); // liberaz. risorse occupate dalla query
    echo "</ol>";
    } else{
        echo"non ci sono slot disponibili questo mese"; // brutto...
    }
}
$connessione->close();

?>